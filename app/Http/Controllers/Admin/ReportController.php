<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Consultation;
use App\Models\Invoice;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Marketing Attribution Stats (Where do consultations come from?)
        $platformAttribution = Consultation::select('platform_detected', DB::raw('count(*) as count'))
            ->groupBy('platform_detected')
            ->orderByDesc('count')
            ->get();

        $totalConsultations = Consultation::count();

        // 2. Financial Metrics
        $totalInvoiced = Invoice::sum('total_amount');
        $totalCollected = Invoice::sum('paid_amount');
        $totalOutstanding = Invoice::sum('due_amount');

        $overdueInvoices = Invoice::with('client')
            ->where(function ($q) {
                $q->where('status', 'overdue')
                    ->orWhere(function ($sub) {
                        $sub->where('due_amount', '>', 0)
                            ->where('due_date', '<', now());
                    });
            })
            ->latest('due_date')
            ->take(10)
            ->get();

        // 3. CRM Metrics
        $clientStatusCounts = Client::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // 4. Top Demanded Project Types
        $projectTypes = Consultation::select('project_type', DB::raw('count(*) as count'))
            ->whereNotNull('project_type')
            ->groupBy('project_type')
            ->orderByDesc('count')
            ->take(6)
            ->get();

        // 5. Quotation Success / Conversion
        $quotationStats = Quotation::select('status', DB::raw('count(*) as count'), DB::raw('sum(total_amount) as total_val'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        // 6. Recent Consultations with Lead Attribution
        $recentLeads = Consultation::latest()->take(10)->get();

        return view('admin.reports.index', compact(
            'platformAttribution',
            'totalConsultations',
            'totalInvoiced',
            'totalCollected',
            'totalOutstanding',
            'overdueInvoices',
            'clientStatusCounts',
            'projectTypes',
            'quotationStats',
            'recentLeads'
        ));
    }
}
