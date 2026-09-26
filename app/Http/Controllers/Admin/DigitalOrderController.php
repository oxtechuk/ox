<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DigitalOrderController extends Controller
{
    /**
     * Display a listing of digital orders.
     */
    public function index(Request $request): View
    {
        $query = Order::with(['items.product', 'user']);

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('merchant_reference', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total_sales' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'pending_orders' => Order::where('payment_status', 'pending')->count(),
            'failed_orders' => Order::where('payment_status', 'failed')->count(),
        ];

        return view('admin.digital-orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order details.
     */
    public function show(Order $order): View
    {
        $order->load(['items.product', 'downloadTokens.product', 'user']);

        return view('admin.digital-orders.show', compact('order'));
    }
}
