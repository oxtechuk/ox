<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\QuotationMail;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = Quotation::with(['client', 'items']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('quotation_number', 'like', "%{$s}%")
                  ->orWhere('title', 'like', "%{$s}%")
                  ->orWhereHas('client', function ($cq) use ($s) {
                      $cq->where('name', 'like', "%{$s}%")->orWhere('company_name', 'like', "%{$s}%");
                  });
            });
        }

        $quotations = $query->latest()->paginate(15)->withQueryString();

        return view('admin.crm.quotations.index', compact('quotations'));
    }

    public function create(Request $request)
    {
        $clients = Client::orderBy('name')->get();
        $selectedClientId = $request->query('client_id');

        return view('admin.crm.quotations.create', compact('clients', 'selectedClientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date',
            'currency' => 'required|string|max:10',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'nullable|numeric|min:0',
            'vat_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:2000',
            'terms_conditions' => 'nullable|string|max:2000',
            'status' => 'required|in:draft,sent,accepted,declined,expired',
            'items' => 'required|array|min:1',
            'items.*.service_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string|max:500',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $quotation = DB::transaction(function () use ($validated) {
            $quotationNumber = Quotation::generateQuotationNumber();

            $quotation = Quotation::create([
                'client_id' => $validated['client_id'],
                'quotation_number' => $quotationNumber,
                'title' => $validated['title'],
                'issue_date' => $validated['quotation_date'],
                'valid_until' => $validated['valid_until'] ?? null,
                'currency' => $validated['currency'],
                'discount_type' => $validated['discount_type'],
                'discount_value' => $validated['discount_value'] ?? 0,
                'vat_percentage' => $validated['vat_rate'],
                'notes' => $validated['notes'] ?? null,
                'terms_and_conditions' => $validated['terms_conditions'] ?? null,
                'status' => $validated['status'],
                'subtotal' => 0,
                'discount_amount' => 0,
                'vat_amount' => 0,
                'total_amount' => 0,
            ]);

            foreach ($validated['items'] as $item) {
                $quotation->items()->create([
                    'service_name' => $item['service_name'],
                    'description' => $item['description'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            $quotation->unsetRelation('items');
            $quotation->recalculateTotals();

            return $quotation;
        });

        return redirect()->route('admin.crm.quotations.show', $quotation)->with('success', 'تم إنشاء عرض السعر بنجاح!');
    }

    public function show(Quotation $quotation)
    {
        $quotation->load(['client', 'items']);
        return view('admin.crm.quotations.show', compact('quotation'));
    }

    public function edit(Quotation $quotation)
    {
        $quotation->load(['client', 'items']);
        $clients = Client::orderBy('name')->get();

        return view('admin.crm.quotations.edit', compact('quotation', 'clients'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date',
            'currency' => 'required|string|max:10',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'nullable|numeric|min:0',
            'vat_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:2000',
            'terms_conditions' => 'nullable|string|max:2000',
            'status' => 'required|in:draft,sent,accepted,declined,expired',
            'items' => 'required|array|min:1',
            'items.*.service_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string|max:500',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($quotation, $validated) {
            $quotation->update([
                'client_id' => $validated['client_id'],
                'title' => $validated['title'],
                'issue_date' => $validated['quotation_date'],
                'valid_until' => $validated['valid_until'] ?? null,
                'currency' => $validated['currency'],
                'discount_type' => $validated['discount_type'],
                'discount_value' => $validated['discount_value'] ?? 0,
                'vat_percentage' => $validated['vat_rate'],
                'notes' => $validated['notes'] ?? null,
                'terms_and_conditions' => $validated['terms_conditions'] ?? null,
                'status' => $validated['status'],
            ]);

            // Replace items
            $quotation->items()->delete();
            foreach ($validated['items'] as $item) {
                $quotation->items()->create([
                    'service_name' => $item['service_name'],
                    'description' => $item['description'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            $quotation->unsetRelation('items');
            $quotation->recalculateTotals();
        });

        return redirect()->route('admin.crm.quotations.show', $quotation)->with('success', 'تم تعديل عرض السعر بنجاح!');
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect()->route('admin.crm.quotations.index')->with('success', 'تم حذف عرض السعر بنجاح.');
    }

    public function sendEmail(Request $request, Quotation $quotation)
    {
        $quotation->load(['client', 'items']);
        $customMessage = $request->input('custom_message');

        try {
            Mail::to($quotation->client->email)->send(new QuotationMail($quotation, $customMessage));
            $quotation->update(['status' => 'sent']);
            return back()->with('success', 'تم إرسال عرض السعر إلى بريد العميل (' . $quotation->client->email . ') بنجاح!');
        } catch (\Throwable $e) {
            return back()->with('error', 'تعذر إرسال البريد: ' . $e->getMessage());
        }
    }

    public function convertToInvoice(Quotation $quotation)
    {
        $quotation->load(['client', 'items']);

        $invoice = DB::transaction(function () use ($quotation) {
            $invoiceNumber = Invoice::generateInvoiceNumber();

            $invoice = Invoice::create([
                'client_id' => $quotation->client_id,
                'quotation_id' => $quotation->id,
                'invoice_number' => $invoiceNumber,
                'title' => $quotation->title,
                'issue_date' => now()->toDateString(),
                'due_date' => now()->addDays(14)->toDateString(),
                'currency' => $quotation->currency,
                'total_amount' => $quotation->total_amount,
                'paid_amount' => 0,
                'due_amount' => $quotation->total_amount,
                'status' => 'sent',
                'notes' => $quotation->notes,
                'payment_terms' => $quotation->terms_conditions,
            ]);

            $quotation->update(['status' => 'accepted']);

            return $invoice;
        });

        return redirect()->route('admin.crm.invoices.show', $invoice)->with('success', 'تم تحويل عرض السعر إلى فاتورة بنجاح!');
    }
}
