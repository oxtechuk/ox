@extends('layouts.app')

@section('title', 'لوحة تحكم مشترياتي والتراخيص | ' . config('app.name', 'OX Tech'))

@section('content')
<style>
/* ═══════════════════════════════════════════════════════════════════
   OX Tech Customer Dashboard — Luxury Emerald & Obsidian Brand System
   ═══════════════════════════════════════════════════════════════════ */
:root {
    --ox-deep: #071B19;
    --ox-surface: #0B2824;
    --ox-green: #087B68;
    --ox-vivid: #00D29F;
    --ox-mint: #ECFDF5;
    --ox-mint-border: #A7F3D0;
    --ox-line: #E2EDEA;
    --ox-text-main: #0F172A;
    --ox-text-muted: #64748B;
}

body {
    background-color: #F8FAF9 !important;
}

.ox-customer-dashboard-wrapper {
    background-color: #F8FAF9;
    min-height: 92vh;
    padding: 110px 16px 80px; /* Offset for fixed topbar */
    font-family: 'Cairo', sans-serif;
    direction: rtl;
    color: var(--ox-text-main);
}

.ox-dash-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* ─── 1. Luxury Hero User Banner ─── */
.ox-dash-hero-banner {
    background: radial-gradient(ellipse at 85% 20%, #0F3A34 0%, #071B19 65%, #041210 100%);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 24px;
    padding: 30px 34px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    box-shadow: 0 12px 35px rgba(7, 27, 25, 0.18);
    position: relative;
    overflow: hidden;
}

.ox-dash-hero-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 15% 90%, rgba(0, 210, 159, 0.08) 0%, transparent 60%);
    pointer-events: none;
}

.ox-dash-user-info {
    display: flex;
    align-items: center;
    gap: 18px;
    position: relative;
    z-index: 2;
}

.ox-dash-avatar {
    width: 62px;
    height: 62px;
    border-radius: 20px;
    background: linear-gradient(135deg, var(--ox-green) 0%, var(--ox-vivid) 100%);
    color: #FFFFFF;
    font-size: 25px;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(0, 210, 159, 0.3);
    border: 2px solid rgba(255, 255, 255, 0.2);
    flex-shrink: 0;
}

.ox-dash-user-meta h1 {
    font-size: 22px;
    font-weight: 900;
    color: #FFFFFF;
    margin: 0 0 6px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.ox-dash-user-meta .user-badge-verified {
    font-size: 11px;
    font-weight: 800;
    color: #A7F3D0;
    background: rgba(0, 210, 159, 0.12);
    border: 1px solid rgba(0, 210, 159, 0.3);
    padding: 2px 10px;
    border-radius: 99px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.ox-dash-user-meta p {
    font-size: 13.5px;
    color: #94A3B8;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ox-dash-header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    z-index: 2;
    flex-wrap: wrap;
}

.ox-btn-browse-store {
    background: linear-gradient(135deg, var(--ox-green) 0%, #059669 100%);
    color: #FFFFFF !important;
    padding: 12px 22px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(8, 123, 104, 0.35);
    transition: all 0.25s ease;
    border: none;
}

.ox-btn-browse-store:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(8, 123, 104, 0.45);
    filter: brightness(1.08);
}

.ox-btn-dash-logout {
    background: rgba(255, 255, 255, 0.08);
    color: #FCA5A5;
    border: 1px solid rgba(255, 255, 255, 0.15);
    padding: 11px 18px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.ox-btn-dash-logout:hover {
    background: rgba(239, 68, 68, 0.18);
    color: #FFFFFF;
    border-color: rgba(239, 68, 68, 0.4);
}

/* ─── 2. Quick KPI Counters ─── */
.ox-dash-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 16px;
    margin-bottom: 30px;
}

.ox-kpi-card {
    background: #FFFFFF;
    border: 1px solid var(--ox-line);
    border-radius: 18px;
    padding: 20px 22px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 14px rgba(7, 27, 25, 0.03);
    transition: all 0.2s ease;
}

.ox-kpi-card:hover {
    border-color: #CBD5E1;
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(7, 27, 25, 0.06);
}

.ox-kpi-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.ox-kpi-card.green .ox-kpi-icon-wrap {
    background: #ECFDF5;
    color: var(--ox-green);
    border: 1px solid #A7F3D0;
}

.ox-kpi-card.blue .ox-kpi-icon-wrap {
    background: #EFF6FF;
    color: #2563EB;
    border: 1px solid #BFDBFE;
}

.ox-kpi-card.purple .ox-kpi-icon-wrap {
    background: #F5F3FF;
    color: #7C3AED;
    border: 1px solid #DDD6FE;
}

.ox-kpi-data {
    display: flex;
    flex-direction: column;
}

.ox-kpi-data .label {
    font-size: 12px;
    font-weight: 700;
    color: var(--ox-text-muted);
    margin-bottom: 2px;
}

.ox-kpi-data .number {
    font-size: 24px;
    font-weight: 900;
    color: var(--ox-deep);
    font-family: Arial, sans-serif;
    line-height: 1.1;
}

/* ─── 3. Section Titles ─── */
.ox-dash-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 10px;
}

.ox-dash-section-title {
    font-size: 18.5px;
    font-weight: 900;
    color: var(--ox-deep);
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
}

.ox-dash-section-title i {
    color: var(--ox-green);
    font-size: 20px;
}

/* ─── 4. Software License Cards Grid ─── */
.ox-products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 22px;
    margin-bottom: 36px;
}

.ox-license-card {
    background: #FFFFFF;
    border: 1.5px solid var(--ox-line);
    border-radius: 20px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 18px rgba(7, 27, 25, 0.04);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
}

.ox-license-card:hover {
    border-color: var(--ox-green);
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(8, 123, 104, 0.12);
}

.ox-card-top-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}

.ox-version-pill {
    background: #F1F5F9;
    color: #475569;
    padding: 3px 9px;
    border-radius: 6px;
    font-size: 11.5px;
    font-family: monospace;
    font-weight: 700;
}

.ox-active-tag {
    background: #ECFDF5;
    color: #059669;
    border: 1px solid #A7F3D0;
    padding: 3px 10px;
    border-radius: 99px;
    font-size: 11.5px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.ox-active-tag .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #059669;
}

.ox-product-title {
    font-size: 18px;
    font-weight: 900;
    color: var(--ox-deep);
    margin: 0 0 6px;
}

.ox-product-tagline {
    font-size: 12.5px;
    color: var(--ox-text-muted);
    line-height: 1.55;
    margin: 0 0 16px;
}

/* License Key Box */
.ox-license-key-box {
    background: #F8FAF9;
    border: 1.5px dashed #CBD5E1;
    border-radius: 14px;
    padding: 12px 14px;
    margin-bottom: 18px;
    transition: border-color 0.2s;
}

.ox-license-key-box:hover {
    border-color: var(--ox-green);
}

.ox-key-label {
    font-size: 11px;
    font-weight: 800;
    color: var(--ox-text-muted);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.ox-key-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.ox-key-string {
    font-family: monospace;
    font-weight: 900;
    color: var(--ox-deep);
    font-size: 13.5px;
    letter-spacing: 0.8px;
    user-select: all;
    direction: ltr;
}

.ox-btn-copy-key {
    background: #FFFFFF;
    border: 1px solid #CBD5E1;
    color: var(--ox-deep);
    font-size: 11.5px;
    font-weight: 800;
    padding: 5px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-family: inherit;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s;
}

.ox-btn-copy-key:hover {
    background: var(--ox-mint);
    border-color: var(--ox-green);
    color: var(--ox-green);
}

/* Download Action Button */
.ox-card-download-sec {
    border-top: 1px solid #F1F5F9;
    padding-top: 16px;
}

.ox-btn-download-software {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--ox-deep) 0%, #0D2C28 100%);
    color: #FFFFFF !important;
    font-size: 13.5px;
    font-weight: 800;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(7, 27, 25, 0.2);
    transition: all 0.25s ease;
    box-sizing: border-box;
}

.ox-btn-download-software:hover {
    background: linear-gradient(135deg, var(--ox-green) 0%, #059669 100%);
    box-shadow: 0 8px 24px rgba(8, 123, 104, 0.35);
    transform: translateY(-1px);
}

.ox-download-hint-text {
    text-align: center;
    font-size: 11.5px;
    color: var(--ox-text-muted);
    margin-top: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

/* ─── 5. Empty State Box ─── */
.ox-empty-state-box {
    background: #FFFFFF;
    border: 2px dashed #CBD5E1;
    border-radius: 24px;
    padding: 50px 24px;
    text-align: center;
    margin-bottom: 36px;
    box-shadow: 0 4px 18px rgba(7, 27, 25, 0.02);
}

.ox-empty-icon-wrap {
    width: 76px;
    height: 76px;
    border-radius: 24px;
    background: #ECFDF5;
    color: var(--ox-green);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin: 0 auto 18px;
    border: 1px solid #A7F3D0;
}

.ox-empty-state-box h3 {
    font-size: 18px;
    font-weight: 900;
    color: var(--ox-deep);
    margin: 0 0 8px;
}

.ox-empty-state-box p {
    font-size: 13.5px;
    color: var(--ox-text-muted);
    max-width: 440px;
    margin: 0 auto 22px;
    line-height: 1.6;
}

/* ─── 6. Orders History Table ─── */
.ox-table-card {
    background: #FFFFFF;
    border: 1px solid var(--ox-line);
    border-radius: 24px;
    padding: 26px;
    box-shadow: 0 6px 25px rgba(7, 27, 25, 0.03);
    margin-bottom: 30px;
}

.ox-table-responsive {
    overflow-x: auto;
    border-radius: 14px;
    border: 1px solid #F1F5F9;
}

.ox-dash-table {
    width: 100%;
    border-collapse: collapse;
    text-align: right;
    font-size: 13px;
    white-space: nowrap;
}

.ox-dash-table th {
    padding: 14px 18px;
    background: #F8FAF9;
    color: var(--ox-deep);
    font-weight: 800;
    border-bottom: 1.5px solid #E2EDEA;
    font-size: 12.5px;
}

.ox-dash-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #F1F5F9;
    color: #334155;
    vertical-align: middle;
}

.ox-dash-table tr:hover td {
    background: #F8FAF9;
}

.ox-order-number-tag {
    font-family: monospace;
    font-weight: 900;
    color: var(--ox-deep);
    font-size: 13.5px;
}

.ox-order-price-tag {
    font-weight: 900;
    color: #059669;
    font-size: 14px;
}

.ox-badge-gateway {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 7px;
    font-size: 11.5px;
    font-weight: 800;
}

.ox-badge-gateway.paysky {
    background: #ECFDF5;
    color: #065F46;
    border: 1px solid #A7F3D0;
}

.ox-badge-gateway.paypal {
    background: #EFF6FF;
    color: #0284C7;
    border: 1px solid #BAE6FD;
}

.ox-badge-gateway.card {
    background: #F8FAFC;
    color: #334155;
    border: 1px solid #CBD5E1;
}

.ox-badge-paid {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 99px;
    background: #DCFCE7;
    color: #166534;
    border: 1px solid #86EFAC;
    font-size: 11.5px;
    font-weight: 800;
}

/* ─── 7. Support Strip Box ─── */
.ox-support-strip-box {
    background: linear-gradient(135deg, #071B19 0%, #0C2B26 100%);
    border-radius: 20px;
    padding: 24px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 18px;
    color: #FFFFFF;
    border: 1px solid rgba(255, 255, 255, 0.08);
}

.ox-support-text {
    display: flex;
    align-items: center;
    gap: 16px;
}

.ox-support-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: rgba(0, 210, 159, 0.15);
    color: var(--ox-vivid);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    border: 1px solid rgba(0, 210, 159, 0.3);
    flex-shrink: 0;
}

.ox-support-text h4 {
    margin: 0 0 4px;
    font-size: 16px;
    font-weight: 800;
    color: #FFFFFF;
}

.ox-support-text p {
    margin: 0;
    font-size: 13px;
    color: #94A3B8;
}

.ox-btn-wa-support {
    background: #25D366;
    color: #FFFFFF !important;
    padding: 11px 22px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(37, 211, 102, 0.3);
    transition: all 0.2s ease;
}

.ox-btn-wa-support:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.45);
    filter: brightness(1.06);
}

@media (max-width: 768px) {
    .ox-dash-hero-banner {
        padding: 24px 20px;
        flex-direction: column;
        align-items: flex-start;
    }
    .ox-dash-header-actions {
        width: 100%;
        justify-content: space-between;
    }
    .ox-dash-kpi-grid {
        grid-template-columns: 1fr;
    }
    .ox-products-grid {
        grid-template-columns: 1fr;
    }
    .ox-support-strip-box {
        flex-direction: column;
        align-items: flex-start;
    }
    .ox-btn-wa-support {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="ox-customer-dashboard-wrapper">
    <div class="ox-dash-container">
        
        {{-- 1. User Header Banner --}}
        <div class="ox-dash-hero-banner">
            <div class="ox-dash-user-info">
                <div class="ox-dash-avatar">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
                <div class="ox-dash-user-meta">
                    <h1>
                        <span>مرحباً، {{ $user->name }}</span>
                        <span class="user-badge-verified">
                            <i class="fa-solid fa-circle-check"></i> حساب عميل معتمد
                        </span>
                    </h1>
                    <p>
                        <i class="fa-regular fa-envelope" style="color: #64748B;"></i>
                        <span>{{ $user->email }}</span>
                        <span>•</span>
                        <span>انضم في {{ $user->created_at ? $user->created_at->format('Y-m-d') : date('Y-m-d') }}</span>
                    </p>
                </div>
            </div>

            <div class="ox-dash-header-actions">
                <a href="{{ route('store.index') }}" class="ox-btn-browse-store">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>تصفح متجر البرمجيات</span>
                </a>

                <form action="{{ route('customer.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="ox-btn-dash-logout">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Flash Alerts --}}
        @if(session('success'))
            <div style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #047857; padding: 14px 20px; border-radius: 14px; font-size: 13.5px; font-weight: 700; margin-bottom: 22px; display: flex; align-items: center; gap: 9px;">
                <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div style="background: #FEF2F2; border: 1px solid #FECACA; color: #B91C1C; padding: 14px 20px; border-radius: 14px; font-size: 13.5px; font-weight: 700; margin-bottom: 22px; display: flex; align-items: center; gap: 9px;">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 16px;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Calculations for KPI Strip --}}
        @php
            $activeLicensesCount = 0;
            $downloadTokensCount = 0;
            foreach($orders as $ord) {
                foreach($ord->items as $itm) {
                    if(!empty($itm->license_key)) $activeLicensesCount++;
                }
                foreach($ord->downloadTokens as $dt) {
                    if($dt->isValid()) $downloadTokensCount++;
                }
            }
        @endphp

        {{-- 2. Quick KPI Strip --}}
        <div class="ox-dash-kpi-grid">
            <div class="ox-kpi-card green">
                <div class="ox-kpi-icon-wrap">
                    <i class="fa-solid fa-key"></i>
                </div>
                <div class="ox-kpi-data">
                    <span class="label">تراخيص البرامج النشطة</span>
                    <span class="number">{{ $activeLicensesCount }}</span>
                </div>
            </div>

            <div class="ox-kpi-card blue">
                <div class="ox-kpi-icon-wrap">
                    <i class="fa-solid fa-cloud-arrow-down"></i>
                </div>
                <div class="ox-kpi-data">
                    <span class="label">روابط التحميل الصالحة</span>
                    <span class="number">{{ $downloadTokensCount }}</span>
                </div>
            </div>

            <div class="ox-kpi-card purple">
                <div class="ox-kpi-icon-wrap">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div class="ox-kpi-data">
                    <span class="label">الفواتير والطلبات المسجلة</span>
                    <span class="number">{{ $orders->count() }}</span>
                </div>
            </div>
        </div>

        {{-- 3. Software Licenses & Direct Download Files --}}
        <div>
            <div class="ox-dash-section-header">
                <h2 class="ox-dash-section-title">
                    <i class="fa-solid fa-laptop-code"></i>
                    <span>تراخيص برامجي وروابط التنزيل المباشرة</span>
                </h2>
                <span style="font-size: 12.5px; color: var(--ox-text-muted); font-weight: 700;">
                    التفعيل يتم تلقائياً بإدخال مفتاح الترخيص داخل البرنامج
                </span>
            </div>

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
                                <div class="ox-card-top-row">
                                    <span class="ox-version-pill">v{{ $product->version ?? '1.0' }}</span>
                                    <span class="ox-active-tag">
                                        <span class="dot"></span>
                                        <span>ترخيص سارٍ</span>
                                    </span>
                                </div>

                                <h3 class="ox-product-title">{{ $product->name }}</h3>
                                <p class="ox-product-tagline">{{ $product->tagline }}</p>

                                {{-- License Key Box --}}
                                @if($item->license_key)
                                    <div class="ox-license-key-box">
                                        <div class="ox-key-label">
                                            <i class="fa-solid fa-lock" style="color: var(--ox-green);"></i>
                                            <span>مفتاح الترخيص الخاص بك:</span>
                                        </div>
                                        <div class="ox-key-row">
                                            <span class="ox-key-string" id="dash_key_{{ $item->id }}">{{ $item->license_key }}</span>
                                            <button type="button" onclick="copyLicenseKey('{{ $item->license_key }}', this)" class="ox-btn-copy-key">
                                                <i class="fa-regular fa-copy"></i>
                                                <span>نسخ</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="ox-card-download-sec">
                                @if($tokenRecord && $tokenRecord->isValid())
                                    <a href="{{ route('digital.download', $tokenRecord->token) }}" class="ox-btn-download-software">
                                        <i class="fa-solid fa-download"></i>
                                        <span>تنزيل ملف البرنامج الآن</span>
                                    </a>
                                    <div class="ox-download-hint-text">
                                        <i class="fa-solid fa-arrows-rotate" style="font-size: 11px;"></i>
                                        <span>متبقي <strong>{{ max(0, $tokenRecord->max_downloads - $tokenRecord->download_count) }}</strong> مرات تحميل</span>
                                        <span>•</span>
                                        <span>{{ $tokenRecord->expires_at ? 'صالح حتى ' . $tokenRecord->expires_at->format('Y-m-d') : 'صلاحية دائمة' }}</span>
                                    </div>
                                @else
                                    <div style="background: #F8FAFC; color: #64748B; border: 1px dashed #CBD5E1; padding: 11px; border-radius: 12px; text-align: center; font-size: 12px; font-weight: 700;">
                                        <i class="fa-solid fa-circle-exclamation"></i> انتهت صلاحية رابط التحميل أو استُنفدت المرات
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>

            @if(!$hasProducts)
                <div class="ox-empty-state-box">
                    <div class="ox-empty-icon-wrap">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3>ليس لديك أي برمجيات أو تراخيص حالية</h3>
                    <p>
                        تصفح متجر OX Tech الرقمي واختر أفضل الأدوات والبرمجيات لأنشطتك التجارية مع تفعيل آلي فوري.
                    </p>
                    <a href="{{ route('store.index') }}" class="ox-btn-browse-store">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>تصفح برمجيات المتجر الآن</span>
                    </a>
                </div>
            @endif
        </div>

        {{-- 4. Order History Table --}}
        <div class="ox-table-card">
            <div class="ox-dash-section-header" style="margin-bottom: 16px;">
                <h2 class="ox-dash-section-title">
                    <i class="fa-solid fa-receipt"></i>
                    <span>سجل المشتريات والمدفوعات الإلكترونية</span>
                </h2>
                <span style="font-size: 12.5px; color: var(--ox-text-muted); font-weight: 700;">
                    جميع العمليات مشفرة ومؤكدة عبر البوابات الرسمية
                </span>
            </div>

            <div class="ox-table-responsive">
                <table class="ox-dash-table">
                    <thead>
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>تاريخ الشراء</th>
                            <th>المبلغ المدفوع</th>
                            <th>بوابة السداد</th>
                            <th>حالة الطلب</th>
                            <th>المرجع الإلكتروني</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $gwClass = 'paysky';
                                $gwName = 'PaySky مصر';
                                if (str_contains(strtolower($order->merchant_reference ?? ''), 'paypal') || str_contains(strtolower($order->payment_method ?? ''), 'paypal')) {
                                    $gwClass = 'paypal';
                                    $gwName = 'PayPal الدولية';
                                } elseif ($order->currency === 'USD') {
                                    $gwClass = 'card';
                                    $gwName = 'بطاقة بنكية دولية';
                                }
                            @endphp
                            <tr>
                                <td class="ox-order-number-tag">#{{ $order->order_number }}</td>
                                <td style="color: #475569;">
                                    <i class="fa-regular fa-calendar" style="margin-left: 4px; font-size: 11.5px; color: #94A3B8;"></i>
                                    {{ $order->paid_at ? $order->paid_at->format('Y-m-d H:i') : $order->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="ox-order-price-tag">{{ number_format($order->total_amount, 2) }} {{ $order->currency }}</td>
                                <td>
                                    <span class="ox-badge-gateway {{ $gwClass }}">
                                        @if($gwClass === 'paypal')
                                            <i class="fa-brands fa-paypal"></i>
                                        @elseif($gwClass === 'card')
                                            <i class="fa-solid fa-credit-card"></i>
                                        @else
                                            <i class="fa-solid fa-building-columns"></i>
                                        @endif
                                        <span>{{ $gwName }}</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="ox-badge-paid">
                                        <i class="fa-solid fa-check"></i> مكتمل ومدفوع
                                    </span>
                                </td>
                                <td style="font-family: monospace; font-size: 12px; color: #64748B;">
                                    {{ $order->merchant_reference }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94A3B8; padding: 36px 20px;">
                                    <div style="font-size: 24px; margin-bottom: 8px;">🧾</div>
                                    <div>لا توجد أي فواتير مسجلة في حسابك حتى الآن.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 5. WhatsApp VIP Support Banner --}}
        <div class="ox-support-strip-box">
            <div class="ox-support-text">
                <div class="ox-support-icon">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                    <h4>هل تواجه أي مشكلة في تثبيت البرنامج أو تفعيل كود الرخصة؟</h4>
                    <p>فريق الدعم الفني المباشر لـ OX Tech جاهز لمساعدتك خطوة بخطوة في أي وقت.</p>
                </div>
            </div>
            <a href="https://wa.me/201008616682?text={{ urlencode('مرحباً فريق OX Tech، أحتاج مساعدة بخصوص حسابي وبرامجي المسجلة.') }}" target="_blank" rel="noopener" class="ox-btn-wa-support">
                <i class="fa-brands fa-whatsapp" style="font-size: 16px;"></i>
                <span>محادثة الدعم الفني عبر واتساب</span>
            </a>
        </div>

    </div>
</div>

<script>
function copyLicenseKey(key, btn) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(key).then(() => {
            showCopyFeedback(btn);
        }).catch(() => {
            fallbackCopy(key, btn);
        });
    } else {
        fallbackCopy(key, btn);
    }
}

function fallbackCopy(key, btn) {
    const ta = document.createElement('textarea');
    ta.value = key;
    ta.style.position = 'fixed';
    ta.style.opacity = '0';
    document.body.appendChild(ta);
    ta.select();
    try {
        document.execCommand('copy');
        showCopyFeedback(btn);
    } catch (e) {
        alert('كود الترخيص: ' + key);
    }
    document.body.removeChild(ta);
}

function showCopyFeedback(btn) {
    const origHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-check" style="color: #059669;"></i> تم النسخ!';
    btn.style.background = '#ECFDF5';
    btn.style.borderColor = '#A7F3D0';
    setTimeout(() => {
        btn.innerHTML = origHtml;
        btn.style.background = '';
        btn.style.borderColor = '';
    }, 2000);
}
</script>
@endsection
