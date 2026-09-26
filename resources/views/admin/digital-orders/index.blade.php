@extends('layouts.admin')

@section('title', 'مبيعات وتراخيص PaySky')

@section('content')
<div class="admin-content-inner">
    
    <div class="topbar-actions" style="margin-bottom: 24px; justify-content: space-between;">
        <div>
            <h1 class="topbar-title">💳 مبيعات وتراخيص البرمجيات (PaySky)</h1>
            <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 4px;">
                متابعة عمليات الشراء الفورية، التراخيص المصدرة، ومردود الحملات الإعلانية
            </p>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">إجمالي المبيعات المحصلة</div>
            <div style="font-size: 24px; font-weight: 800; color: #059669; font-family: var(--font-code);">
                {{ number_format($stats['total_sales'], 2) }} <span style="font-size: 12px;">EGP</span>
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">الطلبات المدفوعة والمكتملة</div>
            <div style="font-size: 24px; font-weight: 800; color: #1e293b; font-family: var(--font-code);">
                {{ $stats['paid_orders'] }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">الطلبات المعلقة (قيد الدفع)</div>
            <div style="font-size: 24px; font-weight: 800; color: #d97706; font-family: var(--font-code);">
                {{ $stats['pending_orders'] }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">العمليات الملغاة / غير المكتملة</div>
            <div style="font-size: 24px; font-weight: 800; color: #dc2626; font-family: var(--font-code);">
                {{ $stats['failed_orders'] }}
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 18px 20px; margin-bottom: 24px;">
        <form action="{{ route('admin.digital-orders.index') }}" method="GET" style="display: flex; gap: 14px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">بحث بالاسم أو الإيميل أو رقم الطلب</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث..." class="form-control">
            </div>

            <div style="min-width: 150px;">
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">حالة السداد</label>
                <select name="status" class="form-control">
                    <option value="">جميع الحالات</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>مدفوع بنجاح (Paid)</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>معلق (Pending)</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>ملغي / فشل (Failed)</option>
                </select>
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 18px;">تطبيق</button>
                <a href="{{ route('admin.digital-orders.index') }}" class="btn btn-outline" style="padding: 10px 18px;">إعادة ضبط</a>
            </div>
        </form>
    </div>

    {{-- Orders Table --}}
    <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>العميل</th>
                        <th>البرنامج المطلوب</th>
                        <th>المبلغ</th>
                        <th>الحالة</th>
                        <th>مصدر الإعلان (UTM)</th>
                        <th>التاريخ</th>
                        <th style="text-align: left;">تفاصيل</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong style="font-family: var(--font-code); color: var(--text-heading);">{{ $order->order_number }}</strong>
                                <div style="font-size: 10.5px; color: var(--text-muted); font-family: var(--font-code);">{{ $order->merchant_reference }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--text-heading); font-size: 12.5px;">{{ $order->customer_name }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $order->customer_email }}</div>
                                @if($order->customer_phone)
                                    <div style="font-size: 10.5px; color: var(--brand-green);">{{ $order->customer_phone }}</div>
                                @endif
                            </td>
                            <td>
                                @foreach($order->items as $item)
                                    <div style="font-size: 12px; font-weight: 600; color: var(--brand-forest);">
                                        • {{ $item->product->name ?? 'برنامج' }}
                                    </div>
                                    @if($item->license_key)
                                        <div style="font-size: 10px; font-family: var(--font-code); color: #0284c7;">{{ $item->license_key }}</div>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <span style="font-weight: 800; font-size: 13px; color: #059669; font-family: var(--font-code);">
                                    {{ number_format($order->total_amount, 2) }} {{ $order->currency }}
                                </span>
                            </td>
                            <td>
                                @if($order->payment_status === 'paid')
                                    <span style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 99px; font-size: 11px; font-weight: 700;">مدفوع بنجاح</span>
                                @elseif($order->payment_status === 'pending')
                                    <span style="background: #fef3c7; color: #b45309; padding: 3px 8px; border-radius: 99px; font-size: 11px; font-weight: 700;">معلق</span>
                                @else
                                    <span style="background: #fee2e2; color: #b91c1c; padding: 3px 8px; border-radius: 99px; font-size: 11px; font-weight: 700;">فشل / ملغي</span>
                                @endif
                            </td>
                            <td>
                                @if($order->utm_source)
                                    <span style="background: #f1f5f9; color: #475569; padding: 2px 6px; border-radius: 4px; font-size: 11px; font-family: var(--font-code);">
                                        {{ $order->utm_source }} {{ $order->utm_campaign ? '('.$order->utm_campaign.')' : '' }}
                                    </span>
                                @else
                                    <span style="color: #94a3b8; font-size: 11px;">مباشر (Direct)</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 11.5px; color: var(--text-body);">{{ $order->created_at->format('Y-m-d') }}</div>
                                <div style="font-size: 10.5px; color: var(--text-muted);">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td style="text-align: left;">
                                <a href="{{ route('admin.digital-orders.show', $order->id) }}" class="btn btn-outline btn-sm">
                                    معاينة الفاتورة
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                لا توجد طلبات مسجلة حتى الآن.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid var(--border-subtle);">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
