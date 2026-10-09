@extends('layouts.admin')

@section('title', 'لوحة التحكم والإحصائيات الشاملة | OX Tech')
@section('header_title', 'لوحة التحكم')

@push('admin-styles')
<style>
    /* ─── SpaceRemit & SaaS Clean Canvas Styles ─── */
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
        max-width: 1440px;
        margin: 0 auto;
    }

    /* ─── Top Live Visitors Strip ─── */
    .visitors-live-strip {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 16px;
        padding: 16px 22px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        flex-wrap: wrap;
    }

    .visitors-live-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .live-pulse-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #ECFDF5;
        border: 1px solid #A7F3D0;
        color: #047857;
        font-size: 12px;
        font-weight: 800;
        padding: 5px 12px;
        border-radius: 99px;
    }

    .live-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10B981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulseLive 1.8s infinite;
    }

    @keyframes pulseLive {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .visitors-quick-metrics {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .v-metric-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .v-metric-label {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 600;
    }

    .v-metric-val {
        font: 800 16px/1 var(--font-code), sans-serif;
        color: var(--text-heading);
    }

    /* ─── Top Main Hero Grid ─── */
    .hero-metrics-grid {
        display: grid;
        grid-template-columns: 1.15fr 0.95fr 1fr;
        gap: 20px;
        align-items: stretch;
    }

    @media (max-width: 1200px) {
        .hero-metrics-grid {
            grid-template-columns: 1fr 1fr;
        }
        .marketplace-hero-card {
            grid-column: span 2;
        }
    }

    @media (max-width: 768px) {
        .hero-metrics-grid {
            grid-template-columns: 1fr;
        }
        .marketplace-hero-card {
            grid-column: span 1;
        }
    }

    /* ─── 1. Main Available Balance Card ─── */
    .balance-hero-card {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 160px;
        position: relative;
    }

    .balance-amount-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 4px;
    }

    .balance-amount-num {
        font: 800 28px/1 var(--font-code), sans-serif;
        color: var(--text-heading);
        letter-spacing: -0.5px;
    }

    .balance-amount-currency {
        font: 700 13.5px/1 var(--font-code), sans-serif;
        color: #0F172A;
        letter-spacing: 0.5px;
    }

    .balance-label {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
        margin-bottom: 12px;
    }

    .balance-meta-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 12px;
        border-top: 1px solid #F1F5F9;
    }

    .balance-growth-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #ECFDF5;
        color: #047857;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 99px;
        font-family: var(--font-code);
    }
    .balance-growth-badge.down {
        background: #FEF2F2;
        color: #B91C1C;
    }

    /* ─── 2. Income & Orders Cards Stack ─── */
    .metrics-stack {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .metric-sub-card {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 14px;
        padding: 13px 18px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex: 1;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .metric-sub-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
    }

    .metric-sub-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .metric-sub-label {
        font-size: 11.5px;
        color: var(--text-muted);
        font-weight: 600;
    }

    .metric-sub-value {
        font: 800 19px/1 var(--font-code), sans-serif;
        color: var(--text-heading);
    }

    .metric-sub-icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1.5px solid #0F172A;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0F172A;
        background: #FFFFFF;
        flex-shrink: 0;
        transition: 0.2s;
    }

    .metric-sub-card:hover .metric-sub-icon-circle {
        background: #0F172A;
        color: #FFFFFF;
    }

    /* ─── 3. MarketPlace Hero Box ─── */
    .marketplace-hero-card {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 16px;
        padding: 18px 18px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 160px;
    }

    .marketplace-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
    }

    .marketplace-brand-tag {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 700;
        color: #0F172A;
    }
    .marketplace-brand-tag span.brand-dot {
        color: #10B981;
        font-size: 14px;
        line-height: 1;
    }

    .marketplace-actions-row {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .marketplace-pill-btn {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        color: #334155;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 9px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
    }
    .marketplace-pill-btn:hover {
        background: #071B19;
        color: #FFFFFF;
        border-color: #071B19;
    }

    .marketplace-center-content {
        text-align: center;
        padding: 6px 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .marketplace-icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #071B19;
    }

    .marketplace-desc-text {
        font-size: 11.5px;
        color: var(--text-muted);
        line-height: 1.5;
        margin: 0;
        max-width: 340px;
    }

    .marketplace-footer-pills {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        padding-top: 10px;
        border-top: 1px solid #F1F5F9;
    }

    .marketplace-action-pill {
        font-size: 10.5px;
        font-weight: 700;
        color: #475569;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        padding: 4px 10px;
        border-radius: 6px;
        text-decoration: none;
        transition: 0.15s;
    }
    .marketplace-action-pill:hover {
        background: #071B19;
        color: #FFFFFF;
        border-color: #071B19;
    }

    /* ─── 4. Chart & Two-Column Grid ─── */
    .chart-and-gateways-grid {
        display: grid;
        grid-template-columns: 1.25fr 0.95fr;
        gap: 20px;
    }

    @media (max-width: 1024px) {
        .chart-and-gateways-grid {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .chart-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .chart-title-box h3 {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--text-heading);
        margin-bottom: 2px;
    }
    .chart-title-box p {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 500;
        margin: 0;
    }

    .chart-tabs-bar {
        display: flex;
        align-items: center;
        gap: 4px;
        background: #F8FAFC;
        padding: 3px;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        flex-wrap: wrap;
    }

    .chart-tab-btn {
        background: transparent;
        border: none;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        color: #64748B;
        cursor: pointer;
        transition: 0.15s;
        font-family: var(--font);
    }
    .chart-tab-btn.active {
        background: #FFFFFF;
        color: #071B19;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
    }

    .chart-canvas-wrapper {
        position: relative;
        height: 240px;
        width: 100%;
    }

    .chart-bottom-caption {
        text-align: center;
        font-size: 11px;
        font-weight: 600;
        color: #64748B;
        font-family: var(--font-code);
        margin-top: 10px;
    }

    /* ─── Top Countries & Gateway Box ─── */
    .side-metrics-card {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 20px;
        padding: 22px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 16px;
    }

    .country-row-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #F1F5F9;
        font-size: 12.5px;
    }
    .country-row-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .gateway-item {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: 0.2s;
    }
    .gateway-item:hover {
        border-color: #CBD5E1;
        background: #F1F5F9;
    }

    .gateway-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .gateway-title-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .gateway-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #10B981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    .gateway-dot.inactive {
        background: #94A3B8;
        box-shadow: none;
    }

    .gateway-name {
        font-size: 13px;
        font-weight: 800;
        color: #0F172A;
    }

    .gateway-status-tag {
        font-size: 10.5px;
        font-weight: 700;
        color: #047857;
        background: #ECFDF5;
        padding: 2px 7px;
        border-radius: 99px;
    }
    .gateway-status-tag.inactive {
        color: #64748B;
        background: #F1F5F9;
    }

    .gateway-amount-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
    }

    .gateway-revenue-num {
        font: 800 16px/1 var(--font-code), sans-serif;
        color: #0F172A;
    }

    .gateway-link-btn {
        font-size: 11px;
        font-weight: 700;
        color: #006848;
        text-decoration: none;
    }
    .gateway-link-btn:hover {
        text-decoration: underline;
    }

    /* ─── Bottom Section: Recent Tables Grid ─── */
    .recent-activities-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 20px;
    }

    @media (max-width: 1024px) {
        .recent-activities-grid {
            grid-template-columns: 1fr;
        }
    }

    .activity-card {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 20px;
        padding: 24px 22px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .activity-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid #F1F5F9;
    }

    .activity-card-title {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-heading);
    }

    .pill-link-btn {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        color: #334155;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.2s;
    }
    .pill-link-btn:hover {
        background: #071B19;
        color: #FFFFFF;
        border-color: #071B19;
    }

    .gateway-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 10.5px;
        font-weight: 800;
        font-family: var(--font-code);
        text-transform: uppercase;
    }
    .gateway-badge.paysky {
        background: #EEF2FF;
        color: #4338CA;
        border: 1px solid #C7D2FE;
    }
    .gateway-badge.paypal {
        background: #EFF6FF;
        color: #1D4ED8;
        border: 1px solid #BFDBFE;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">

    <!-- ─── 0. REALTIME VISITORS & TRAFFIC DYNAMIC STRIP ─── -->
    <div class="visitors-live-strip">
        <div class="visitors-live-info">
            <span class="live-pulse-badge">
                <span class="live-dot"></span>
                <span>{{ $stats['live_visitors'] }} زائر نشط الآن بالموقع</span>
            </span>
            <span style="font-size: 12px; color: var(--text-muted); font-weight: 600;">
                رصد فوري للزيارات والترافيك (Traffic & Realtime Analytics)
            </span>
        </div>

        <div class="visitors-quick-metrics">
            <div class="v-metric-item">
                <span class="v-metric-label">زوار اليوم (Unique)</span>
                <span class="v-metric-val">{{ number_format($stats['today_visitors']) }}</span>
            </div>
            <div style="width: 1px; height: 26px; background: #E2E8F0;"></div>
            <div class="v-metric-item">
                <span class="v-metric-label">إجمالي الزوار الفريدين</span>
                <span class="v-metric-val">{{ number_format($stats['total_visitors']) }}</span>
            </div>
            <div style="width: 1px; height: 26px; background: #E2E8F0;"></div>
            <div class="v-metric-item">
                <span class="v-metric-label">مشاهدات الصفحات</span>
                <span class="v-metric-val" style="color: #10B981;">{{ number_format($stats['total_pageviews']) }}</span>
            </div>

            <a href="{{ route('admin.analytics.index') }}" class="pill-link-btn" style="background: #071B19; color: #FFFFFF; border-color: #071B19;">
                <span>تقرير التحليلات المفصل &larr;</span>
            </a>
        </div>
    </div>

    <!-- ─── 1. HERO FINANCIAL & MARKETPLACE GRID (100% Dynamic) ─── -->
    <div class="hero-metrics-grid">
        <!-- Card A: Available Balance / Main Revenue -->
        <div class="balance-hero-card">
            <div>
                <div class="balance-amount-row">
                    <span class="balance-amount-num">{{ number_format($stats['total_revenue'], 2) }}</span>
                    <span class="balance-amount-currency">{{ $stats['currency'] }}</span>
                </div>
                <div class="balance-label">الرصيد الفعلي وإجمالي المبيعات المحصلة (Available balance)</div>
            </div>

            <div class="balance-meta-bar">
                <span class="balance-growth-badge {{ $stats['growth_percentage'] < 0 ? 'down' : '' }}">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="{{ $stats['growth_percentage'] < 0 ? '6 9 12 15 18 9' : '18 15 12 9 6 15' }}"></polyline></svg>
                    {{ $stats['growth_percentage'] > 0 ? '+' : '' }}{{ $stats['growth_percentage'] }}% هذا الشهر
                </span>
                <span style="font-size: 11.5px; color: #64748B; font-weight: 700; font-family: var(--font-code);">
                    {{ $stats['paid_orders_count'] }} طلب مسدد من {{ $stats['total_orders_count'] }}
                </span>
                <span style="font-size: 11.5px; color: #94A3B8; margin-right: auto;">
                    {{ $stats['active_products_count'] }} منتج نشط
                </span>
            </div>
        </div>

        <!-- Card B: Income & Orders Stack -->
        <div class="metrics-stack">
            <!-- Sub-card 1: Income -->
            <div class="metric-sub-card">
                <div class="metric-sub-info">
                    <span class="metric-sub-label">الدخل المحصل هذا الشهر (Monthly Income)</span>
                    <span class="metric-sub-value">
                        {{ number_format($stats['monthly_revenue'], 2) }} {{ $stats['currency'] }}
                    </span>
                </div>
                <div class="metric-sub-icon-circle" title="الدخل الوارد">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="17" y1="7" x2="7" y2="17"></line>
                        <polyline points="17 17 7 17 7 7"></polyline>
                    </svg>
                </div>
            </div>

            <!-- Sub-card 2: Orders Completed -->
            <div class="metric-sub-card">
                <div class="metric-sub-info">
                    <span class="metric-sub-label">الطلبات المسددة والتراخيص (Paid Orders)</span>
                    <span class="metric-sub-value">
                        {{ number_format($stats['paid_orders_count']) }} <small style="font-size: 12px; color: var(--text-muted); font-weight: 600;">طلب</small>
                    </span>
                </div>
                <div class="metric-sub-icon-circle" title="العمليات المنفذة">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="7" y1="17" x2="17" y2="7"></line>
                        <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card C: MarketPlace Box -->
        <div class="marketplace-hero-card">
            <div>
                <div class="marketplace-header">
                    <div class="marketplace-brand-tag">
                        <span class="brand-dot">●</span>
                        <span>OX Tech MarketPlace</span>
                    </div>
                    <div class="marketplace-actions-row">
                        <a href="{{ route('admin.digital-products.create') }}" class="marketplace-pill-btn">
                            <span>+ إضافة منتج</span>
                        </a>
                        <a href="{{ route('admin.digital-orders.index') }}" class="marketplace-pill-btn">
                            <span>الطلبات</span>
                        </a>
                    </div>
                </div>

                <div class="marketplace-center-content">
                    <div class="marketplace-icon-wrap">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                            <circle cx="8" cy="10" r="1"></circle>
                            <path d="M12 10h4"></path>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <p class="marketplace-desc-text">
                        متجر البرمجيات والأنظمة يوفر إدارة متكاملة لتراخيص البرامج والملفات الرقمية وتفعيلها الفوري للعملاء بعد إتمام الدفع.
                    </p>
                </div>
            </div>

            <div class="marketplace-footer-pills">
                <a href="{{ route('admin.payment-logs.index') }}" class="marketplace-action-pill">
                    <span>بوابات الدفع: PaySky {{ $stats['paysky_active'] ? '🟢' : '⚪' }} | PayPal {{ $stats['paypal_active'] ? '🟢' : '⚪' }}</span>
                </a>
                <a href="{{ route('admin.digital-products.index') }}" class="marketplace-action-pill">
                    <span>كتالوج البرامج ({{ $stats['total_products_count'] }}) ▶</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ─── 2. DYNAMIC CHART & COUNTRIES / GATEWAYS SECTION ─── -->
    <div class="chart-and-gateways-grid">
        <!-- Interactive Multi-Mode Dynamic Chart -->
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="chart-title-box">
                    <h3 id="chartDynamicTitle">حركة المبيعات والدخل الشهري (Income Trend)</h3>
                    <p id="chartDynamicSubtitle">مخطط بياني يوضح تدفق الإيرادات الفعلية ومبيعات المتجر الرقمي</p>
                </div>
                <div class="chart-tabs-bar">
                    <button type="button" class="chart-tab-btn active" id="tab7M">آخر 7 أشهر</button>
                    <button type="button" class="chart-tab-btn" id="tab30D">آخر 30 يوماً</button>
                    <button type="button" class="chart-tab-btn" id="tabYear">العام الحالي</button>
                    <button type="button" class="chart-tab-btn" id="tabTraffic" style="background: rgba(16, 185, 129, 0.1); color: #047857; font-weight: 800;">
                        حركة الزوار (7 أيام)
                    </button>
                </div>
            </div>

            <div class="chart-canvas-wrapper">
                <canvas id="monthlyIncomeChart"></canvas>
            </div>

            <div class="chart-bottom-caption" id="chartBottomCaption">
                Dynamic Income Data ({{ $stats['currency'] }})
            </div>
        </div>

        <!-- Visitors by Country & Gateways Status -->
        <div class="side-metrics-card">
            <!-- Part 1: Top Countries (البلاد الأكثر زيارة للموقع) -->
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <div style="font-size: 14.5px; font-weight: 800; color: var(--text-heading);">
                        أكثر الدول تصفحاً (Visitors by Country)
                    </div>
                    <a href="{{ route('admin.analytics.index') }}" style="font-size: 11px; font-weight: 700; color: #10B981; text-decoration: none;">
                        تفاصيل الدول &larr;
                    </a>
                </div>
                <div style="font-size: 11.5px; color: var(--text-muted); margin-bottom: 12px;">
                    توزيع الزيارات حسب النطاق الجغرافي والدول:
                </div>

                <div style="display: flex; flex-direction: column; gap: 2px;">
                    @forelse($topCountries as $c)
                        <div class="country-row-item">
                            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: var(--text-heading);">
                                <span style="font-family: var(--font-code); background: #F1F5F9; color: #334155; font-size: 10.5px; padding: 2px 6px; border-radius: 4px; font-weight: 800;">
                                    {{ $c['code'] }}
                                </span>
                                <span style="font-size: 12.5px;">{{ $c['name'] }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 55px; height: 5px; background: #E2E8F0; border-radius: 99px; overflow: hidden;">
                                    <div style="height: 100%; width: {{ $c['percentage'] }}%; background: #10B981; border-radius: 99px;"></div>
                                </div>
                                <span style="font-family: var(--font-code); font-weight: 800; color: var(--text-heading); font-size: 12px;">
                                    {{ number_format($c['views']) }}
                                </span>
                                <small style="font-size: 10.5px; color: var(--text-muted); font-family: var(--font-code);">
                                    ({{ $c['percentage'] }}%)
                                </small>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; color: var(--text-muted); padding: 14px 10px; font-size: 12px; background: #F8FAFC; border-radius: 10px; border: 1px dashed #CBD5E1;">
                            يتم رصد بيانات الدول والزيارات وتحديثها تلقائياً عند تصفح المستخدمين للمنصة.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Part 2: Gateways Realtime Revenue -->
            <div style="border-top: 1px solid #F1F5F9; padding-top: 14px; margin-top: 6px;">
                <div style="font-size: 13.5px; font-weight: 800; color: var(--text-heading); margin-bottom: 10px;">
                    بوابات الدفع والتحصيل الرقمي
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <!-- PaySky -->
                    <div class="gateway-item">
                        <div class="gateway-top-row">
                            <div class="gateway-title-wrap">
                                <span class="gateway-dot {{ $stats['paysky_active'] ? '' : 'inactive' }}"></span>
                                <span class="gateway-name">PaySky (بطاقات ومحافظ مصر)</span>
                            </div>
                            <span class="gateway-status-tag {{ $stats['paysky_active'] ? '' : 'inactive' }}">
                                {{ $stats['paysky_active'] ? '🟢 متصل' : '⚪ غير مهيأ' }}
                            </span>
                        </div>
                        <div class="gateway-amount-row">
                            <span style="font-size: 11.5px; color: #64748B;">الإجمالي المسدد الفعلي:</span>
                            <span class="gateway-revenue-num">{{ number_format($stats['paysky_revenue'], 2) }} {{ $stats['currency'] }}</span>
                        </div>
                    </div>

                    <!-- PayPal -->
                    <div class="gateway-item">
                        <div class="gateway-top-row">
                            <div class="gateway-title-wrap">
                                <span class="gateway-dot {{ $stats['paypal_active'] ? '' : 'inactive' }}"></span>
                                <span class="gateway-name">PayPal (المبيعات الدولية)</span>
                            </div>
                            <span class="gateway-status-tag {{ $stats['paypal_active'] ? '' : 'inactive' }}">
                                {{ $stats['paypal_active'] ? '🟢 متصل' : '⚪ غير مهيأ' }}
                            </span>
                        </div>
                        <div class="gateway-amount-row">
                            <span style="font-size: 11.5px; color: #64748B;">الإجمالي المسدد الفعلي:</span>
                            <span class="gateway-revenue-num">{{ number_format($stats['paypal_revenue'], 2) }} {{ $stats['currency'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── 3. RECENT ACTIVITY: DIGITAL ORDERS & CONSULTATIONS ─── -->
    <div class="recent-activities-grid">
        <!-- Recent Digital Store Orders -->
        <div class="activity-card">
            <div class="activity-card-header">
                <div class="activity-card-title">أحدث مبيعات المتجر الرقمي (Store Orders)</div>
                <a href="{{ route('admin.digital-orders.index') }}" class="pill-link-btn">عرض كافة الطلبات</a>
            </div>

            @if($recentOrders->count() > 0)
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>الطلب والعميل</th>
                                <th>البرنامج</th>
                                <th>بوابة الدفع</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: #0F172A; font-family: var(--font-code);">
                                            #{{ $order->order_number ?? $order->id }}
                                        </div>
                                        <div style="font-size: 11px; color: var(--text-muted);" class="truncate-text sm" title="{{ $order->customer_email }}">
                                            {{ $order->customer_name ?? $order->customer_email }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($order->items->first())
                                            <span class="truncate-text sm" title="{{ $order->items->first()->product->title ?? 'منتج رقمي' }}">
                                                {{ $order->items->first()->product->title ?? 'منتج رقمي' }}
                                            </span>
                                        @else
                                            <span style="color: #94A3B8;">ترخيص برمجي</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="gateway-badge {{ strtolower($order->payment_gateway ?? 'paysky') }}">
                                            {{ $order->payment_gateway ?? 'PaySky' }}
                                        </span>
                                    </td>
                                    <td style="font-weight: 800; font-family: var(--font-code);">
                                        {{ number_format($order->total_amount, 2) }} {{ $order->currency ?? $stats['currency'] }}
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $order->payment_status === 'paid' ? 'completed' : 'warning' }}">
                                            {{ $order->payment_status === 'paid' ? 'مسدد' : 'معلق' }}
                                        </span>
                                    </td>
                                    <td style="font-size: 11.5px; color: var(--text-muted); font-family: var(--font-code);">
                                        {{ $order->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 35px 20px; color: var(--text-muted);">
                    <div style="font-size: 32px; margin-bottom: 8px;">🛒</div>
                    <div style="font-weight: 700; color: #0F172A; margin-bottom: 4px;">لا توجد طلبات شراء مسجلة بعد</div>
                    <div style="font-size: 12px; margin-bottom: 16px;">سيتم إدراج عمليات الشراء والتراخيص المسددة فور إتمام العملاء للدفع عبر PaySky أو PayPal.</div>
                    <a href="{{ route('admin.digital-products.create') }}" class="btn btn-lime btn-sm">
                        <span>+ إضافة برنامج للبيع</span>
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Consultations Leads -->
        <div class="activity-card">
            <div class="activity-card-header">
                <div class="activity-card-title">أحدث طلبات الاستشارة والعملاء (Leads)</div>
                <a href="{{ route('admin.consultations.index') }}" class="pill-link-btn">عرض الكل</a>
            </div>

            @if($recentConsultations->count() > 0)
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>العميل</th>
                                <th>نوع المشروع</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentConsultations as $c)
                                <tr>
                                    <td>
                                        <strong class="truncate-text sm" title="{{ $c->name }}">{{ $c->name }}</strong>
                                        <div class="truncate-text sm" title="{{ $c->email }}" style="font-size: 11px; color: var(--text-muted);">
                                            {{ $c->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="truncate-text sm" title="{{ $c->project_type ?? 'عام' }}">
                                            {{ $c->project_type ?? 'استشارة تقنية' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $c->status }}">
                                            {{ $c->status_label }}
                                        </span>
                                    </td>
                                    <td style="font-size: 11.5px; font-family: var(--font-code); color: var(--text-muted);">
                                        {{ $c->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.consultations.show', $c->id) }}" class="btn btn-outline btn-sm">
                                            معاينة
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 35px 20px; color: var(--text-muted);">
                    <div style="font-size: 32px; margin-bottom: 8px;">📩</div>
                    <div style="font-weight: 700; color: #0F172A; margin-bottom: 4px;">لا توجد طلبات استشارة واردة حالياً</div>
                    <div style="font-size: 12px;">تظهر هنا طلبات العملاء الراغبين في الاستشارات التقنية والبرمجية فور إرسالها من الموقع.</div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('admin-scripts')
<!-- Chart.js CDN for Interactive Multi-Mode Dynamic Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('monthlyIncomeChart');
    if (!ctx) return;

    // 100% Dynamic datasets from database
    const labels7M = @json($chartLabels7M);
    const revenue7M = @json($chartRevenue7M);

    const labels30D = @json($chartLabels30D);
    const revenue30D = @json($chartRevenue30D);

    const labelsYear = @json($chartLabelsYear);
    const revenueYear = @json($chartRevenueYear);

    const labelsTraffic = @json($chartLabelsTraffic);
    const viewsTraffic = @json($chartViewsTraffic);
    const visitorsTraffic = @json($chartVisitorsTraffic);

    const currency = @json($stats['currency']);

    const chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels7M,
            datasets: [{
                label: `الإيرادات الشهرية (${currency})`,
                data: revenue7M,
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.08)',
                borderWidth: 2.6,
                tension: 0.38,
                fill: true,
                pointBackgroundColor: '#10B981',
                pointBorderColor: '#FFFFFF',
                pointBorderWidth: 2,
                pointRadius: 4.5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#047857',
                pointHoverBorderColor: '#FFFFFF',
                pointHoverBorderWidth: 2.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: { top: 15, bottom: 5, left: 10, right: 15 }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    rtl: true,
                    backgroundColor: '#071B19',
                    titleColor: '#FFFFFF',
                    bodyColor: '#F8FAFC',
                    titleFont: {
                        family: "'Alexandria', 'Cairo', sans-serif",
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: "'Space Grotesk', sans-serif",
                        size: 12
                    },
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: {
                        color: '#64748B',
                        font: { family: "'Alexandria', sans-serif", size: 11, weight: '600' },
                        padding: 8
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#F1F5F9', drawBorder: false },
                    ticks: {
                        color: '#64748B',
                        font: { family: "'Space Grotesk', sans-serif", size: 11 },
                        padding: 10,
                        precision: 0,
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Timeframe switcher tabs
    const tab7M = document.getElementById('tab7M');
    const tab30D = document.getElementById('tab30D');
    const tabYear = document.getElementById('tabYear');
    const tabTraffic = document.getElementById('tabTraffic');
    const chartTitle = document.getElementById('chartDynamicTitle');
    const chartSubtitle = document.getElementById('chartDynamicSubtitle');
    const chartCaption = document.getElementById('chartBottomCaption');

    const setTabActive = (activeBtn) => {
        [tab7M, tab30D, tabYear, tabTraffic].forEach(btn => btn?.classList.remove('active'));
        activeBtn?.classList.add('active');
    };

    tab7M?.addEventListener('click', () => {
        setTabActive(tab7M);
        chartTitle.textContent = 'حركة المبيعات والدخل الشهري (Income Trend)';
        chartSubtitle.textContent = 'مخطط بياني يوضح تدفق الإيرادات الفعلية ومبيعات المتجر الرقمي';
        chartCaption.textContent = `Dynamic Income Data (${currency})`;

        chartInstance.data.labels = labels7M;
        chartInstance.data.datasets = [{
            label: `الإيرادات الشهرية (${currency})`,
            data: revenue7M,
            borderColor: '#10B981',
            backgroundColor: 'rgba(16, 185, 129, 0.08)',
            borderWidth: 2.6,
            tension: 0.38,
            fill: true,
            pointBackgroundColor: '#10B981',
            pointBorderColor: '#FFFFFF',
            pointBorderWidth: 2,
            pointRadius: 4.5,
            pointHoverRadius: 7
        }];
        chartInstance.update();
    });

    tab30D?.addEventListener('click', () => {
        setTabActive(tab30D);
        chartTitle.textContent = 'مبيعات آخر 30 يوماً (Last 30 Days)';
        chartSubtitle.textContent = 'تدفق المبيعات المسددة أسبوعياً خلال الشهر الأخير';
        chartCaption.textContent = `Weekly Revenue (${currency})`;

        chartInstance.data.labels = labels30D;
        chartInstance.data.datasets = [{
            label: `مبيعات الأسبوع (${currency})`,
            data: revenue30D,
            borderColor: '#10B981',
            backgroundColor: 'rgba(16, 185, 129, 0.08)',
            borderWidth: 2.6,
            tension: 0.38,
            fill: true,
            pointBackgroundColor: '#10B981',
            pointBorderColor: '#FFFFFF',
            pointBorderWidth: 2,
            pointRadius: 4.5,
            pointHoverRadius: 7
        }];
        chartInstance.update();
    });

    tabYear?.addEventListener('click', () => {
        setTabActive(tabYear);
        chartTitle.textContent = 'إيرادات أرباع العام الحالي (Current Year Quarters)';
        chartSubtitle.textContent = 'التوزيع الربعي للمبيعات والتحصيلات في العام الجاري';
        chartCaption.textContent = `Quarterly Revenue (${currency})`;

        chartInstance.data.labels = labelsYear;
        chartInstance.data.datasets = [{
            label: `إيرادات الربع (${currency})`,
            data: revenueYear,
            borderColor: '#10B981',
            backgroundColor: 'rgba(16, 185, 129, 0.08)',
            borderWidth: 2.6,
            tension: 0.38,
            fill: true,
            pointBackgroundColor: '#10B981',
            pointBorderColor: '#FFFFFF',
            pointBorderWidth: 2,
            pointRadius: 4.5,
            pointHoverRadius: 7
        }];
        chartInstance.update();
    });

    tabTraffic?.addEventListener('click', () => {
        setTabActive(tabTraffic);
        chartTitle.textContent = 'حركة الزوار والمشاهدات اليومية (Daily Visitors & Views)';
        chartSubtitle.textContent = 'رصد مباشر لحركة المشاهدات والزوار الفريدين على مدار آخر 7 أيام';
        chartCaption.textContent = 'Daily Traffic: Views & Unique Visitors';

        chartInstance.data.labels = labelsTraffic;
        chartInstance.data.datasets = [
            {
                label: 'مشاهدات الصفحات (Pageviews)',
                data: viewsTraffic,
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.08)',
                borderWidth: 2.5,
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#10B981',
                pointBorderColor: '#FFFFFF',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            },
            {
                label: 'الزوار الفريدين (Visitors)',
                data: visitorsTraffic,
                borderColor: '#2563EB',
                backgroundColor: 'rgba(37, 99, 235, 0.04)',
                borderWidth: 2.5,
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#2563EB',
                pointBorderColor: '#FFFFFF',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }
        ];
        chartInstance.update();
    });
});
</script>
@endpush
