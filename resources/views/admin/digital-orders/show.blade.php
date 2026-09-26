@extends('layouts.admin')

@section('title', 'تفاصيل الطلب: ' . $order->order_number)

@section('content')
<div class="admin-content-inner" style="max-width: 900px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <a href="{{ route('admin.digital-orders.index') }}" style="font-size: 12px; color: var(--text-muted); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px;">
                &rarr; العودة لسجل الطلبات
            </a>
            <h1 class="topbar-title">فاتورة الطلب: {{ $order->order_number }}</h1>
        </div>

        <div>
            @if($order->payment_status === 'paid')
                <span style="background: #dcfce7; color: #15803d; padding: 6px 14px; border-radius: 99px; font-size: 12.5px; font-weight: 700;">
                    ✓ تم السداد بنجاح عبر PaySky
                </span>
            @else
                <span style="background: #fef3c7; color: #b45309; padding: 6px 14px; border-radius: 99px; font-size: 12.5px; font-weight: 700;">
                    حالة الطلب: {{ $order->payment_status }}
                </span>
            @endif
        </div>
    </div>

    {{-- Customer & Payment Info Cards --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 20px;">
            <h3 style="font-size: 14px; font-weight: 800; color: var(--text-heading); margin-bottom: 12px;">بيانات العميل</h3>
            <div style="font-size: 12.5px; line-height: 1.8;">
                <div><strong>الاسم:</strong> {{ $order->customer_name }}</div>
                <div><strong>البريد الإلكتروني:</strong> {{ $order->customer_email }}</div>
                <div><strong>الهاتف:</strong> {{ $order->customer_phone ?: 'غير محدد' }}</div>
                <div><strong>عنوان IP:</strong> <code>{{ $order->ip_address }}</code></div>
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 20px;">
            <h3 style="font-size: 14px; font-weight: 800; color: var(--text-heading); margin-bottom: 12px;">بيانات المعاملة المالية</h3>
            <div style="font-size: 12.5px; line-height: 1.8;">
                <div><strong>المبلغ الإجمالي:</strong> <span style="font-weight: 800; color: #059669;">{{ number_format($order->total_amount, 2) }} {{ $order->currency }}</span></div>
                <div><strong>بوابة الدفع:</strong> PaySky Omni Gateway</div>
                <div><strong>مرجع التاجر:</strong> <code>{{ $order->merchant_reference }}</code></div>
                <div><strong>رقم العملية بالبوابة:</strong> <code>{{ $order->transaction_id ?: 'N/A' }}</code></div>
                <div><strong>تاريخ الدفع:</strong> {{ $order->paid_at ? $order->paid_at->format('Y-m-d H:i:s') : 'لم يتم بعد' }}</div>
            </div>
        </div>
    </div>

    {{-- Purchased Products & License Keys --}}
    <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
        <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 16px;">البرمجيات والتراخيص الممنوحة</h3>
        
        @foreach($order->items as $item)
            @php
                $product = $item->product;
                $tokenRecord = $order->downloadTokens->where('product_id', $product->id)->first();
            @endphp
            <div style="padding: 16px; border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 14px; background: #f8fafc;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <strong style="font-size: 14px; color: var(--text-heading);">{{ $product->name }}</strong>
                    <span style="font-weight: 800; color: #059669;">{{ number_format($item->price, 2) }} {{ $order->currency }}</span>
                </div>

                @if($item->license_key)
                    <div style="font-size: 12px; margin-top: 8px;">
                        <span>مفتاح الترخيص (License Key):</span>
                        <code style="font-size: 13px; font-weight: 700; background: #fff; padding: 4px 8px; border: 1px solid #cbd5e1; border-radius: 6px; color: #0284c7; margin-right: 6px;">
                            {{ $item->license_key }}
                        </code>
                    </div>
                @endif

                @if($tokenRecord)
                    <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 10px;">
                        <span>رابط التحميل المشفر:</span>
                        <a href="{{ route('digital.download', $tokenRecord->token) }}" target="_blank" style="color: #2563eb; text-decoration: underline;">
                            تحميل الملف ↗
                        </a>
                        <span>• عدد مرات التحميل: {{ $tokenRecord->download_count }} من أصل {{ $tokenRecord->max_downloads }}</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Attribution & Raw Gateway Response --}}
    <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 24px;">
        <h3 style="font-size: 14px; font-weight: 800; color: var(--text-heading); margin-bottom: 12px;">بيانات الاستجابة من PaySky (Gateway Response)</h3>
        
        <pre style="background: #0f172a; color: #38bdf8; padding: 16px; border-radius: 8px; font-size: 11px; overflow-x: auto; direction: ltr; text-align: left;">{{ json_encode($order->gateway_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </div>

</div>
@endsection
