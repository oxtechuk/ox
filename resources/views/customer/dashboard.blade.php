@extends('layouts.app')

@section('title', 'لوحة تحكم المشتريات والتراخيص | ' . config('app.name', 'Ox Tech'))

@section('content')
<style>
/* ─── Clean White Theme Customer Dashboard ─── */
body {
    background-color: #f8fafc !important;
}

.white-dashboard-wrapper {
    background-color: #f8fafc;
    min-height: 90vh;
    padding: 40px 16px 80px;
    font-family: 'Alexandria', system-ui, sans-serif;
    direction: rtl;
    color: #1e293b;
}

.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Header User Banner */
.dash-user-banner {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 24px 32px;
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
}

.dash-user-info {
    display: flex;
    align-items: center;
    gap: 16px;
}

.dash-avatar {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    color: #ffffff;
    font-size: 22px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
}

.dash-user-text h1 {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px;
}

.dash-user-text p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

.dash-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-browse-more {
    background: #2563eb;
    color: #ffffff;
    padding: 10px 18px;
    border-radius: 12px;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

.btn-browse-more:hover {
    background: #1d4ed8;
}

.btn-dash-logout {
    background: #ffffff;
    color: #ef4444;
    border: 1px solid #fecaca;
    padding: 9px 16px;
    border-radius: 12px;
    font-size: 12.5px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-dash-logout:hover {
    background: #fef2f2;
}

/* Alert Banners */
.dash-alert-success {
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
    padding: 12px 18px;
    border-radius: 14px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 24px;
}

.dash-alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    padding: 12px 18px;
    border-radius: 14px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 24px;
}

/* Section Titles */
.dash-section-title {
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
}

/* Software License Cards Grid */
.dash-products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.dash-license-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s, box-shadow 0.2s;
}

.dash-license-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    border-color: #cbd5e1;
}

.card-status-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}

.version-pill {
    background: #f1f5f9;
    color: #475569;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-family: monospace;
    font-weight: 600;
}

.license-active-tag {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
    padding: 3px 8px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 700;
}

.dash-product-name {
    font-size: 16.5px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 6px;
}

.dash-product-desc {
    font-size: 12px;
    color: #64748b;
    line-height: 1.5;
    margin: 0 0 16px;
}

/* License Key Box */
.dash-key-box {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 12px;
    padding: 10px 14px;
    margin-bottom: 16px;
}

.dash-key-label {
    font-size: 10.5px;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 4px;
}

.dash-key-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

.dash-key-code {
    font-family: monospace;
    font-weight: 800;
    color: #1e293b;
    font-size: 12.5px;
    letter-spacing: 0.5px;
    user-select: all;
}

.btn-mini-copy {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #334155;
    font-size: 10.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.2s;
}

.btn-mini-copy:hover {
    background: #f1f5f9;
    color: #0f172a;
}

/* Download Action */
.dash-card-bottom {
    border-top: 1px solid #f1f5f9;
    padding-top: 16px;
}

.btn-dash-download {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 10px;
    border-radius: 12px;
    background: #2563eb;
    color: #ffffff;
    font-size: 12.5px;
    font-weight: 800;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    transition: background 0.2s;
}

.btn-dash-download:hover {
    background: #1d4ed8;
}

.dash-download-hint {
    text-align: center;
    font-size: 11px;
    color: #64748b;
    margin-top: 8px;
}

.dash-empty-box {
    background: #ffffff;
    border: 1.5px dashed #cbd5e1;
    border-radius: 20px;
    padding: 40px 20px;
    text-align: center;
}

/* Orders Table Card */
.dash-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
}

.dash-table-wrapper {
    overflow-x: auto;
}

.dash-table {
    width: 100%;
    border-collapse: collapse;
    text-align: right;
    font-size: 12.5px;
}

.dash-table th {
    padding: 12px 16px;
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    border-bottom: 1.5px solid #e2e8f0;
}

.dash-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
}

.dash-table tr:hover td {
    background: #f8fafc;
}

.order-num-tag {
    font-family: monospace;
    font-weight: 800;
    color: #0f172a;
}

.order-price-tag {
    font-weight: 800;
    color: #059669;
}

.badge-paysky {
    display: inline-flex;
    padding: 3px 8px;
    border-radius: 6px;
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    font-size: 11px;
    font-weight: 700;
}

.badge-paid {
    display: inline-flex;
    padding: 3px 8px;
    border-radius: 99px;
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
    font-size: 11px;
    font-weight: 700;
}

@media (max-width: 768px) {
    .dash-user-banner {
        flex-direction: column;
        align-items: flex-start;
    }
    .dash-header-actions {
        width: 100%;
        justify-content: space-between;
    }
}
</style>

<div class="white-dashboard-wrapper">
    <div class="dashboard-container">
        
        {{-- User Header Banner --}}
        <div class="dash-user-banner">
            <div class="dash-user-info">
                <div class="dash-avatar">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
                <div class="dash-user-text">
                    <h1>أهلاً بك، {{ $user->name }}</h1>
                    <p>{{ $user->email }} • حساب عميل مرخّص</p>
                </div>
            </div>

            <div class="dash-header-actions">
                <a href="{{ route('store.index') }}" class="btn-browse-more">
                    + تصفح متجر البرمجيات
                </a>

                <form action="{{ route('customer.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-dash-logout">
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="dash-alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="dash-alert-error">
                ✕ {{ session('error') }}
            </div>
        @endif

        {{-- My Digital Products / Downloads --}}
        <div>
            <h2 class="dash-section-title">
                <span>💻</span>
                <span>تراخيص برامجي وملفات التنزيل</span>
            </h2>

            @php
                $hasProducts = false;
            @endphp

            <div class="dash-products-grid">
                @foreach($orders as $order)
                    @foreach($order->items as $item)
                        @php
                            $hasProducts = true;
                            $product = $item->product;
                            $tokenRecord = $order->downloadTokens->where('product_id', $product->id)->first();
                        @endphp

                        <div class="dash-license-card">
                            <div>
                                <div class="card-status-row">
                                    <span class="version-pill">v{{ $product->version ?? '1.0' }}</span>
                                    <span class="license-active-tag">● ترخيص صالح</span>
                                </div>

                                <h3 class="dash-product-name">{{ $product->name }}</h3>
                                <p class="dash-product-desc">{{ $product->tagline }}</p>

                                {{-- License Key --}}
                                @if($item->license_key)
                                    <div class="dash-key-box">
                                        <div class="dash-key-label">مفتاح الترخيص الخاص بك:</div>
                                        <div class="dash-key-row">
                                            <span class="dash-key-code" id="dash_key_{{ $item->id }}">{{ $item->license_key }}</span>
                                            <button type="button" onclick="navigator.clipboard.writeText('{{ $item->license_key }}'); alert('تم نسخ المفتاح بنجاح!');" class="btn-mini-copy">
                                                نسخ
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="dash-card-bottom">
                                @if($tokenRecord && $tokenRecord->isValid())
                                    <a href="{{ route('digital.download', $tokenRecord->token) }}" class="btn-dash-download">
                                        <span>⬇️ تنزيل ملف البرنامج</span>
                                    </a>
                                    <div class="dash-download-hint">
                                        متبقي <strong>{{ max(0, $tokenRecord->max_downloads - $tokenRecord->download_count) }}</strong> تحميلات
                                        (صالح حتى {{ $tokenRecord->expires_at ? $tokenRecord->expires_at->format('Y-m-d') : 'دائم' }})
                                    </div>
                                @else
                                    <div style="background: #f1f5f9; color: #64748b; padding: 10px; border-radius: 10px; text-align: center; font-size: 11.5px; font-weight: 700;">
                                        الرابط منتهي الصلاحية أو استُنفدت المحاولات
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>

            @if(!$hasProducts)
                <div class="dash-empty-box" style="margin-bottom: 40px;">
                    <div style="font-size: 38px; margin-bottom: 12px;">📦</div>
                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">ليس لديك أي برمجيات أو تراخيص حالية</h3>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 18px;">تصفح متجرنا الرقمي واختر الأنظمة المناسبة لعملك مع تفعيل مباشر.</p>
                    <a href="{{ route('store.index') }}" class="btn-browse-more">
                        تصفح برمجيات المتجر الآن
                    </a>
                </div>
            @endif
        </div>

        {{-- Order History Table --}}
        <div class="dash-table-card">
            <h2 class="dash-section-title" style="margin-bottom: 18px;">
                <span>🧾</span>
                <span>سجل المشتريات والمدفوعات (PaySky)</span>
            </h2>

            <div class="dash-table-wrapper">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>تاريخ الشراء</th>
                            <th>المبلغ</th>
                            <th>بوابة السداد</th>
                            <th>حالة الطلب</th>
                            <th>المرجع الإلكتروني</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="order-num-tag">#{{ $order->order_number }}</td>
                                <td>{{ $order->paid_at ? $order->paid_at->format('Y-m-d H:i') : $order->created_at->format('Y-m-d') }}</td>
                                <td class="order-price-tag">{{ number_format($order->total_amount, 2) }} {{ $order->currency }}</td>
                                <td><span class="badge-paysky">PaySky Omni</span></td>
                                <td><span class="badge-paid">✓ مكتمل ومدفوع</span></td>
                                <td style="font-family: monospace; font-size: 11.5px; color: #64748b;">{{ $order->merchant_reference }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">لا توجد أي فواتير مسجلة بعد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
