<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['client', 'quotation']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('invoice_number', 'like', "%{$s}%")
                    ->orWhere('title', 'like', "%{$s}%")
                    ->orWhereHas('client', function ($cq) use ($s) {
                        $cq->where('name', 'like', "%{$s}%")->orWhere('company_name', 'like', "%{$s}%");
                    });
            });
        }

        $invoices = $query->latest()->paginate(15)->withQueryString();

        $totalInvoiced = Invoice::sum('total_amount');
        $totalCollected = Invoice::sum('paid_amount');
        $totalDue = Invoice::sum('due_amount');
        $overdueCount = Invoice::where('status', 'overdue')->orWhere(function ($q) {
            $q->where('due_amount', '>', 0)->where('due_date', '<', now());
        })->count();

        return view('admin.crm.invoices.index', compact(
            'invoices',
            'totalInvoiced',
            'totalCollected',
            'totalDue',
            'overdueCount'
        ));
    }

    public function create(Request $request)
    {
        $clients = Client::orderBy('name')->get();
        $selectedClientId = $request->query('client_id');

        return view('admin.crm.invoices.create', compact('clients', 'selectedClientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'currency' => 'required|string|max:10',
            'subtotal' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'nullable|numeric|min:0',
            'vat_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:2000',
            'terms_conditions' => 'nullable|string|max:2000',
            'status' => 'required|in:draft,sent,paid,partially_paid,overdue,cancelled',
        ]);

        $invoice = DB::transaction(function () use ($validated) {
            $subtotal = (float) $validated['subtotal'];
            $discountVal = (float) ($validated['discount_value'] ?? 0);
            $vatRate = (float) $validated['vat_rate'];

            $discountAmount = $validated['discount_type'] === 'percentage'
                ? ($subtotal * ($discountVal / 100))
                : $discountVal;

            $discountedSubtotal = max(0, $subtotal - $discountAmount);
            $vatAmount = $discountedSubtotal * ($vatRate / 100);
            $totalAmount = $discountedSubtotal + $vatAmount;

            $invoice = Invoice::create([
                'client_id' => $validated['client_id'],
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'title' => $validated['title'],
                'issue_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'] ?? null,
                'currency' => $validated['currency'],
                'total_amount' => $totalAmount,
                'paid_amount' => 0,
                'due_amount' => $totalAmount,
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
                'payment_terms' => $validated['terms_conditions'] ?? null,
            ]);

            return $invoice;
        });

        return redirect()->route('admin.crm.invoices.show', $invoice)->with('success', 'تم إنشاء الفاتورة بنجاح!');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'quotation.items', 'payments' => fn ($q) => $q->latest()]);

        return view('admin.crm.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $clients = Client::orderBy('name')->get();

        return view('admin.crm.invoices.edit', compact('invoice', 'clients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'currency' => 'required|string|max:10',
            'subtotal' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'nullable|numeric|min:0',
            'vat_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:2000',
            'terms_conditions' => 'nullable|string|max:2000',
            'status' => 'required|in:draft,sent,paid,partially_paid,overdue,cancelled',
        ]);

        DB::transaction(function () use ($invoice, $validated) {
            $subtotal = (float) $validated['subtotal'];
            $discountVal = (float) ($validated['discount_value'] ?? 0);
            $vatRate = (float) $validated['vat_rate'];

            $discountAmount = $validated['discount_type'] === 'percentage'
                ? ($subtotal * ($discountVal / 100))
                : $discountVal;

            $discountedSubtotal = max(0, $subtotal - $discountAmount);
            $vatAmount = $discountedSubtotal * ($vatRate / 100);
            $totalAmount = $discountedSubtotal + $vatAmount;

            $invoice->update([
                'client_id' => $validated['client_id'],
                'title' => $validated['title'],
                'issue_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'] ?? null,
                'currency' => $validated['currency'],
                'total_amount' => $totalAmount,
                'notes' => $validated['notes'] ?? null,
                'payment_terms' => $validated['terms_conditions'] ?? null,
            ]);

            $invoice->recalculatePaymentStatus();
        });

        return redirect()->route('admin.crm.invoices.show', $invoice)->with('success', 'تم تعديل بيانات الفاتورة بنجاح!');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.crm.invoices.index')->with('success', 'تم حذف الفاتورة بنجاح.');
    }

    public function addPayment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:'.($invoice->due_amount + 0.01),
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:bank_transfer,mada,visa_mastercard,cash,cheque,other',
            'transaction_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($invoice, $validated) {
            $invoice->payments()->create([
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'transaction_reference' => $validated['transaction_reference'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            $invoice->recalculatePaymentStatus();
        });

        return back()->with('success', 'تم تسجيل دفعة مالية بقيمة ('.number_format($validated['amount'], 2).' '.$invoice->currency.') بنجاح!');
    }

    public function sendEmail(Request $request, Invoice $invoice)
    {
        $invoice->load(['client', 'payments']);
        $customMessage = $request->input('custom_message');

        try {
            Mail::to($invoice->client->email)->send(new InvoiceMail($invoice, $customMessage));
            if ($invoice->status === 'draft') {
                $invoice->update(['status' => 'sent']);
            }

            return back()->with('success', 'تم إرسال الفاتورة إلى بريد العميل ('.$invoice->client->email.') بنجاح!');
        } catch (\Throwable $e) {
            return back()->with('error', 'تعذر إرسال البريد: '.$e->getMessage());
        }
    }
}
