<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentLogController extends Controller
{
    /**
     * Display a listing of PaySky payment logs
     */
    public function index(Request $request): View
    {
        $query = PaymentLog::with('order');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('merchant_reference', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->latest()->paginate(25)->withQueryString();

        $stats = [
            'total_logs' => PaymentLog::count(),
            'success_events' => PaymentLog::where('status', 'success')->count(),
            'failed_events' => PaymentLog::where('status', 'failed')->count(),
            'today_events' => PaymentLog::whereDate('created_at', today())->count(),
        ];

        return view('admin.payment-logs.index', compact('logs', 'stats'));
    }

    /**
     * Show detailed payment log
     */
    public function show(PaymentLog $paymentLog): View
    {
        $paymentLog->load('order');

        return view('admin.payment-logs.show', compact('paymentLog'));
    }

    /**
     * Clear logs older than 30 days
     */
    public function clearOld(): RedirectResponse
    {
        $deleted = PaymentLog::where('created_at', '<', now()->subDays(30))->delete();

        return redirect()->route('admin.payment-logs.index')
            ->with('success', "تم تنظيف {$deleted} سجل قديم أقدم من 30 يوماً بنجاح.");
    }
}
