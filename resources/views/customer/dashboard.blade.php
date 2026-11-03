@extends('layouts.app')

@section('title', 'لوحة تحكم المشتريات والتراخيص | ' . config('app.name', 'Ox Tech'))
@section('meta_description', 'لوحة تحكم عملاء Ox Tech لإدارة البرمجيات والأنظمة المشتراة، نسخ مفاتيح الترخيص، وتنزيل أحدث الإصدارات.')

@section('content')
<style>
/* ═══════════════════════════════════════════════════════════════════
   OX TECH LUXURY CYBER-EMERALD CUSTOMER PORTAL
   Aesthetic: Deep Midnight Obsidian (#030d0c), Glowing Emerald (#00e59b),
   Warm Camel Gold (#c8a96b), Glassmorphism, Sadu geometric accents
   ═══════════════════════════════════════════════════════════════════ */

.ox-portal-wrapper {
    background-color: #030d0c;
    background-image: 
        radial-gradient(circle at 50% 0%, rgba(29, 138, 104, 0.18) 0%, transparent 60%),
        radial-gradient(circle at 10% 25%, rgba(200, 169, 107, 0.07) 0%, transparent 40%),
        radial-gradient(circle at 90% 60%, rgba(0, 229, 155, 0.06) 0%, transparent 45%);
    min-height: 90vh;
    padding: 125px 16px 90px;
    font-family: var(--font-ar, 'Cairo', system-ui, -apple-system, sans-serif);
    direction: rtl;
    color: #F3EFE5;
    position: relative;
    overflow-x: hidden;
}

/* Ambient Dot Matrix */
.ox-portal-wrapper::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1.5px, transparent 1.5px);
    background-size: 24px 24px;
    opacity: 0.5;
    pointer-events: none;
    z-index: 0;
}

.ox-portal-container {
    max-width: 1220px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

/* ─── 1. USER PROFILE BANNER ─── */
.ox-user-banner {
    background: rgba(7, 27, 25, 0.82);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(29, 138, 104, 0.45);
    border-radius: 26px;
    padding: 28px 34px;
    margin-bottom: 34px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 30px rgba(0, 229, 155, 0.07), inset 0 1px 0 rgba(255, 255, 255, 0.12);
    position: relative;
    overflow: hidden;
}

.ox-user-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent 0%, rgba(29, 138, 104, 0.8) 25%, #00e59b 50%, rgba(200, 169, 107, 0.8) 75%, transparent 100%);
}

.ox-user-info {
    display: flex;
    align-items: center;
    gap: 18px;
}

.ox-avatar {
    width: 62px;
    height: 62px;
    border-radius: 20px;
    background: linear-gradient(135deg, #1D8A68 0%, #C8A96B 100%);
    color: #ffffff;
    font-size: 24px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 25px rgba(29, 138, 104, 0.45);
    border: 2px solid rgba(255, 255, 255, 0.2);
    flex-shrink: 0;
}

.ox-user-text h1 {
    font-size: 22px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 5px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ox-user-text p {
    font-size: 13.5px;
    color: #94a8a2;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.ox-badge-verified {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(0, 229, 155, 0.15);
    border: 1px solid rgba(0, 229, 155, 0.4);
    color: #00e59b;
    padding: 2px 10px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 700;
}

.ox-header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.ox-btn-browse {
    background: linear-gradient(135deg, #1D8A68 0%, #15664d 100%);
    border: 1px solid rgba(0, 229, 155, 0.55);
    color: #ffffff;
    padding: 11px 20px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 18px rgba(0, 229, 155, 0.25);
}

.ox-btn-browse:hover {
    background: linear-gradient(135deg, #00e59b 0%, #1D8A68 100%);
    color: #030d0c;
    box-shadow: 0 6px 26px rgba(0, 229, 155, 0.45);
    transform: translateY(-1px);
}

.ox-btn-logout {
    background: rgba(239, 68, 68, 0.12);
    border: 1px solid rgba(239, 68, 68, 0.35);
    color: #fca5a5;
    padding: 10px 18px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.ox-btn-logout:hover {
    background: rgba(239, 68, 68, 0.25);
    color: #ffffff;
    border-color: rgba(239, 68, 68, 0.6);
}

/* ─── ALERTS ─── */
.ox-alert-success {
    background: rgba(22, 101, 52, 0.25);
    border: 1px solid rgba(74, 222, 128, 0.45);
    color: #bbf7d0;
    padding: 14px 20px;
    border-radius: 16px;
    font-size: 13.5px;
    font-weight: 700;
    margin-bottom: 26px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.ox-alert-error {
    background: rgba(153, 27, 27, 0.25);
    border: 1px solid rgba(248, 113, 113, 0.45);
    color: #fecaca;
    padding: 14px 20px;
    border-radius: 16px;
    font-size: 13.5px;
    font-weight: 700;
    margin-bottom: 26px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ─── SECTION TITLES ─── */
.ox-section-title {
    font-size: 20px;
    font-weight: 800;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 22px;
    letter-spacing: -0.3px;
}

.ox-title-icon-box {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(29, 138, 104, 0.25);
    border: 1px solid rgba(0, 229, 155, 0.4);
    color: #00e59b;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
}

/* ─── SOFTWARE LICENSE CARDS GRID ─── */
.ox-products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 24px;
    margin-bottom: 46px;
}

.ox-license-card {
    background: rgba(7, 27, 25, 0.82);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(29, 138, 104, 0.4);
    border-radius: 22px;
    padding: 26px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.ox-license-card:hover {
    transform: translateY(-4px);
    border-color: rgba(0, 229, 155, 0.6);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.65), 0 0 30px rgba(0, 229, 155, 0.12);
}

.ox-card-status-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}

.ox-version-pill {
    background: rgba(3, 13, 12, 0.7);
    border: 1px solid rgba(200, 169, 107, 0.4);
    color: #C8A96B;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 11.5px;
    font-family: monospace;
    font-weight: 700;
}

.ox-license-tag {
    background: rgba(0, 229, 155, 0.15);
    border: 1px solid rgba(0, 229, 155, 0.45);
    color: #00e59b;
    padding: 4px 12px;
    border-radius: 99px;
    font-size: 11.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.ox-license-tag::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #00e59b;
    box-shadow: 0 0 8px #00e59b;
}

.ox-product-name {
    font-size: 18px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 8px;
    letter-spacing: -0.2px;
}

.ox-product-desc {
    font-size: 12.5px;
    color: #94a8a2;
    line-height: 1.6;
    margin: 0 0 18px;
}

/* License Key Box (Terminal Look) */
.ox-key-box {
    background: rgba(3, 13, 12, 0.85);
    border: 1px dashed rgba(0, 229, 155, 0.35);
    border-radius: 14px;
    padding: 12px 14px;
    margin-bottom: 18px;
    position: relative;
}

.ox-key-label {
    font-size: 11px;
    font-weight: 700;
    color: #c8a96b;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.ox-key-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.ox-key-code {
    font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
    font-weight: 800;
    color: #00e59b;
    font-size: 13px;
    letter-spacing: 0.8px;
    user-select: all;
    word-break: break-all;
    direction: ltr;
    text-align: left;
}

.ox-btn-copy {
    background: rgba(29, 138, 104, 0.25);
    border: 1px solid rgba(0, 229, 155, 0.45);
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    flex-shrink: 0;
}

.ox-btn-copy:hover {
    background: #00e59b;
    color: #030d0c;
    box-shadow: 0 0 12px rgba(0, 229, 155, 0.5);
}

/* Download Actions */
.ox-card-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding-top: 18px;
}

.ox-btn-download {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    background: linear-gradient(135deg, #1D8A68 0%, #15664d 100%);
    border: 1px solid rgba(0, 229, 155, 0.5);
    color: #ffffff;
    font-size: 13.5px;
    font-weight: 800;
    text-decoration: none;
    box-shadow: 0 4px 18px rgba(0, 229, 155, 0.22);
    transition: all 0.25s ease;
}

.ox-btn-download:hover {
    background: linear-gradient(135deg, #00e59b 0%, #1D8A68 100%);
    color: #030d0c;
    box-shadow: 0 6px 26px rgba(0, 229, 155, 0.45);
    transform: translateY(-1px);
}

.ox-download-hint {
    text-align: center;
    font-size: 11.5px;
    color: #94a8a2;
    margin-top: 9px;
}

.ox-download-hint strong {
    color: #00e59b;
}

.ox-download-expired {
    background: rgba(3, 13, 12, 0.7);
    color: #94a8a2;
    padding: 12px;
    border-radius: 12px;
    text-align: center;
    font-size: 12px;
    font-weight: 700;
    border: 1px solid rgba(255, 255, 255, 0.08);
}

/* Empty State */
.ox-empty-box {
    background: rgba(7, 27, 25, 0.65);
    border: 1.5px dashed rgba(29, 138, 104, 0.4);
    border-radius: 24px;
    padding: 48px 24px;
    text-align: center;
    margin-bottom: 44px;
}

.ox-empty-icon {
    font-size: 44px;
    margin-bottom: 14px;
    display: inline-block;
    filter: drop-shadow(0 0 15px rgba(0, 229, 155, 0.3));
}

.ox-empty-title {
    font-size: 18px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 8px;
}

.ox-empty-desc {
    font-size: 13.5px;
    color: #94a8a2;
    margin: 0 auto 22px;
    max-width: 480px;
    line-height: 1.6;
}

/* ─── ORDERS HISTORY TABLE ─── */
.ox-table-card {
    background: rgba(7, 27, 25, 0.82);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(29, 138, 104, 0.4);
    border-radius: 26px;
    padding: 30px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.08);
}

.ox-table-wrapper {
    overflow-x: auto;
}

.ox-table {
    width: 100%;
    border-collapse: collapse;
    text-align: right;
    font-size: 13px;
}

.ox-table th {
    padding: 14px 18px;
    background: rgba(3, 13, 12, 0.7);
    color: #94a8a2;
    font-weight: 700;
    font-size: 12px;
    border-bottom: 1px solid rgba(29, 138, 104, 0.35);
    white-space: nowrap;
}

.ox-table td {
    padding: 16px 18px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    color: #e2e8f0;
    white-space: nowrap;
}

.ox-table tr:hover td {
    background: rgba(29, 138, 104, 0.1);
}

.ox-order-num {
    font-family: monospace;
    font-weight: 800;
    color: #ffffff;
}

.ox-order-price {
    font-weight: 800;
    color: #00e59b;
}

.ox-badge-paysky {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 8px;
    background: rgba(37, 99, 235, 0.15);
    color: #93c5fd;
    border: 1px solid rgba(59, 130, 246, 0.4);
    font-size: 11.5px;
    font-weight: 700;
}

.ox-badge-paid {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    border-radius: 99px;
    background: rgba(0, 229, 155, 0.15);
    color: #00e59b;
    border: 1px solid rgba(0, 229, 155, 0.4);
    font-size: 11.5px;
    font-weight: 700;
}

/* Floating Copied Toast */
.ox-copied-toast {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%) translateY(100px);
    background: rgba(5, 20, 18, 0.95);
    border: 1px solid #00e59b;
    color: #ffffff;
    padding: 12px 24px;
    border-radius: 99px;
    font-size: 13.5px;
    font-weight: 700;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8), 0 0 20px rgba(0, 229, 155, 0.3);
    z-index: 99999;
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ox-copied-toast.active {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}

@media (max-width: 768px) {
    .ox-portal-wrapper {
        padding: 105px 12px 60px;
    }
    .ox-user-banner {
        flex-direction: column;
        align-items: flex-start;
        padding: 22px 20px;
    }
    .ox-header-actions {
        width: 100%;
        justify-content: space-between;
    }
    .ox-products-grid {
        grid-template-columns: 1fr;
    }
    .ox-table-card {
        padding: 20px 16px;
    }
}
</style>

<div class="ox-portal-wrapper">
    <div class="ox-portal-container">
        
        {{-- User Header Banner --}}
        <div class="ox-user-banner">
            <div class="ox-user-info">
                <div class="ox-avatar">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
                <div class="ox-user-text">
                    <h1>
                        <span>أهلاً بك، {{ $user->name }}</span>
                    </h1>
                    <p>
                        <span>{{ $user->email }}</span>
                        <span class="ox-badge-verified">
                            <i class="fa-solid fa-certificate"></i>
                            <span>حساب عميل مرخّص</span>
                        </span>
                    </p>
                </div>
            </div>

            <div class="ox-header-actions">
                <a href="{{ route('store.index') }}" class="ox-btn-browse">
                    <i class="fa-solid fa-cart-plus"></i>
                    <span>تصفح متجر البرمجيات</span>
                </a>

                <form action="{{ route('customer.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="ox-btn-logout">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="ox-alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="ox-alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- My Digital Products / Downloads --}}
        <div>
            <h2 class="ox-section-title">
                <span class="ox-title-icon-box">
                    <i class="fa-solid fa-laptop-code"></i>
                </span>
                <span>تراخيص برامجي وملفات التنزيل</span>
            </h2>

            @php
                $hasProducts = false;
            @endphp

            <div class="ox-products-grid">
                @foreach($orders as $order)
                    @foreach($order->items as $item)
                        @php
                            $hasProducts = true;
                            $product = $item->product;
                            $tokenRecord = $order->downloadTokens->where('product_id', $product->id)->first();
                        @endphp

                        <div class="ox-license-card">
                            <div>
                                <div class="ox-card-status-row">
                                    <span class="ox-version-pill">v{{ $product->version ?? '1.0' }}</span>
                                    <span class="ox-license-tag">ترخيص صالح</span>
                                </div>

                                <h3 class="ox-product-name">{{ $product->name }}</h3>
                                <p class="ox-product-desc">{{ $product->tagline }}</p>

                                {{-- License Key --}}
                                @if($item->license_key)
                                    <div class="ox-key-box">
                                        <div class="ox-key-label">
                                            <i class="fa-solid fa-key"></i>
                                            <span>مفتاح الترخيص الخاص بك:</span>
                                        </div>
                                        <div class="ox-key-row">
                                            <span class="ox-key-code" id="dash_key_{{ $item->id }}">{{ $item->license_key }}</span>
                                            <button type="button" onclick="copyLicenseKey('{{ $item->license_key }}', this)" class="ox-btn-copy">
                                                <i class="fa-regular fa-copy"></i>
                                                <span>نسخ</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="ox-card-bottom">
                                @if($tokenRecord && $tokenRecord->isValid())
                                    <a href="{{ route('digital.download', $tokenRecord->token) }}" class="ox-btn-download">
                                        <i class="fa-solid fa-cloud-arrow-down"></i>
                                        <span>تنزيل ملف البرنامج</span>
                                    </a>
                                    <div class="ox-download-hint">
                                        متبقي <strong>{{ max(0, $tokenRecord->max_downloads - $tokenRecord->download_count) }}</strong> تحميلات
                                        (صالح حتى {{ $tokenRecord->expires_at ? $tokenRecord->expires_at->format('Y-m-d') : 'دائم' }})
                                    </div>
                                @else
                                    <div class="ox-download-expired">
                                        <i class="fa-solid fa-triangle-exclamation" style="color: #f59e0b; margin-left: 5px;"></i>
                                        <span>الرابط منتهي الصلاحية أو استُنفدت التحميلات المتاحة</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>

            @if(!$hasProducts)
                <div class="ox-empty-box">
                    <div class="ox-empty-icon">📦</div>
                    <h3 class="ox-empty-title">ليس لديك أي برمجيات أو تراخيص حالية</h3>
                    <p class="ox-empty-desc">تصفح متجرنا الرقمي واختر الأنظمة وحلول الأعمال المناسبة لمؤسستك مع تفعيل مباشر وترخيص فوري.</p>
                    <a href="{{ route('store.index') }}" class="ox-btn-browse">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>تصفح برمجيات المتجر الآن</span>
                    </a>
                </div>
            @endif
        </div>

        {{-- Order History Table --}}
        <div class="ox-table-card">
            <h2 class="ox-section-title" style="margin-bottom: 20px;">
                <span class="ox-title-icon-box">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </span>
                <span>سجل المشتريات والمدفوعات الإلكترونية</span>
            </h2>

            <div class="ox-table-wrapper">
                <table class="ox-table">
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
                                <td class="ox-order-num">#{{ $order->order_number }}</td>
                                <td>{{ $order->paid_at ? $order->paid_at->format('Y-m-d H:i') : $order->created_at->format('Y-m-d') }}</td>
                                <td class="ox-order-price">{{ number_format($order->total_amount, 2) }} {{ $order->currency }}</td>
                                <td><span class="ox-badge-paysky"><i class="fa-solid fa-credit-card"></i> PaySky Omni</span></td>
                                <td><span class="ox-badge-paid">✓ مكتمل ومدفوع</span></td>
                                <td style="font-family: monospace; font-size: 12px; color: #94a8a2;">{{ $order->merchant_reference }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #64748b; padding: 32px;">لا توجد أي فواتير مسجلة في حسابك حتى الآن.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- Modern Copied Toast Notification --}}
<div class="ox-copied-toast" id="oxCopiedToast">
    <i class="fa-solid fa-circle-check" style="color: #00e59b;"></i>
    <span>تم نسخ مفتاح الترخيص بنجاح إلى الحافظة!</span>
</div>

<script>
function copyLicenseKey(key, btn) {
    if (!key) return;
    navigator.clipboard.writeText(key).then(() => {
        const toast = document.getElementById('oxCopiedToast');
        if (toast) {
            toast.classList.add('active');
            setTimeout(() => toast.classList.remove('active'), 2800);
        }
        if (btn) {
            const origHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> <span>تم!</span>';
            btn.style.background = '#00e59b';
            btn.style.color = '#030d0c';
            setTimeout(() => {
                btn.innerHTML = origHtml;
                btn.style.background = '';
                btn.style.color = '';
            }, 2000);
        }
    }).catch(err => {
        console.error('Clipboard copy error:', err);
    });
}
</script>
@endsection