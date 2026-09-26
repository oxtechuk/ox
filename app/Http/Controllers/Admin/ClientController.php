<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::with(['quotations', 'invoices']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('company_name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $clients = $query->latest()->paginate(15)->withQueryString();

        // High level CRM stats
        $totalClients = Client::count();
        $totalBilled = Invoice::sum('total_amount');
        $totalCollected = Invoice::sum('paid_amount');
        $totalOutstanding = Invoice::sum('due_amount');

        return view('admin.crm.clients.index', compact(
            'clients',
            'totalClients',
            'totalBilled',
            'totalCollected',
            'totalOutstanding'
        ));
    }

    public function create()
    {
        return view('admin.crm.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:clients,email',
            'phone' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:191',
            'tax_number' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:lead,prospect,active,inactive',
            'lead_source' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:2000',
        ]);

        $client = Client::create($validated);

        return redirect()->route('admin.crm.clients.show', $client)->with('success', 'تم إنشاء ملف العميل بنجاح!');
    }

    public function show(Client $client)
    {
        $client->load([
            'quotations' => fn ($q) => $q->latest(),
            'invoices' => fn ($q) => $q->with('payments')->latest(),
        ]);

        return view('admin.crm.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('admin.crm.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:clients,email,'.$client->id,
            'phone' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:191',
            'tax_number' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:lead,prospect,active,inactive',
            'lead_source' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:2000',
        ]);

        $client->update($validated);

        return redirect()->route('admin.crm.clients.show', $client)->with('success', 'تم تحديث بيانات العميل بنجاح!');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('admin.crm.clients.index')->with('success', 'تم حذف العميل بنجاح.');
    }
}
