@extends('layouts.admin')

@section('title', 'تحليلات الزوار والترافيك المباشر | OX Tech')
@section('header_title', 'تحليلات الزوار والترافيك المباشر (Traffic & Realtime Analytics)')

@push('admin-styles')
<style>
    .analytics-container {
        max-width: 1350px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* ─── Top Control Toolbar ─── */
    .analytics-toolbar {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .analytics-header-info h2 {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-heading);
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .analytics-header-info p {
        font-size: 12.5px;
        color: var(--text-muted);
        margin: 0;
    }

    .period-filter-group {
        display: inline-flex;
        background: #F1F5F9;
        padding: 4px;
        border-radius: 12px;
        gap: 4px;
    }
    .period-filter-btn {
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 700;
        border-radius: 8px;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    .period-filter-btn:hover {
        color: #0F172A;
    }
    .period-filter-btn.active {
        background: #FFFFFF;
        color: #071B19;
        border-color: #E2E8F0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    /* ─── Live Indicator Pill ─── */
    .live-pulse-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #ECFDF5;
        border: 1px solid #A7F3D0;
        color: #047857;
        font-size: 12px;
        font-weight: 800;
        padding: 6px 14px;
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

    /* ─── Marketing Pixels Status Banner ─── */
    .pixels-status-banner {
        background: linear-gradient(135deg, #071B19 0%, #0D2C28 100%);
        border-radius: 16px;
        padding: 18px 24px;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 4px 18px rgba(7, 27, 25, 0.12);
    }
    .pixels-chips-list {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .pixel-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
        color: #F8FAFC;
        font-family: var(--font-code);
    }
    .pixel-chip .chip-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10B981;
    }
    .pixel-chip.inactive .chip-dot {
        background: #94A3B8;
    }

    /* ─── KPI Stats Grid ─── */
    .kpi-metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 18px;
    }
    .kpi-card {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 3px;
        background: var(--card-accent, #10B981);
    }
    .kpi-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    .kpi-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-muted);
    }
    .kpi-icon-box {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F8FAFC;
        color: #071B19;
    }
    .kpi-value-row {
        display: flex;
        align-items: baseline;
        gap: 10px;
        margin-bottom: 8px;
    }
    .kpi-number {
        font: 800 32px/1 var(--font-code), sans-serif;
        color: var(--text-heading);
        letter-spacing: -0.5px;
    }
    .kpi-meta {
        font-size: 12px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .growth-tag-up {
        color: #047857;
        background: #ECFDF5;
        padding: 2px 6px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 11px;
    }
    .growth-tag-down {
        color: #B91C1C;
        background: #FEF2F2;
        padding: 2px 6px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 11px;
    }

    /* ─── Two-Column Grids ─── */
    .analytics-split-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 992px) {
        .analytics-split-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ─── Traffic Source Bar ─── */
    .source-row {
        margin-bottom: 16px;
    }
    .source-row:last-child {
        margin-bottom: 0;
    }
    .source-label-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
        font-size: 13px;
    }
    .source-name {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        color: var(--text-heading);
    }
    .source-bar-track {
        height: 7px;
        background: #F1F5F9;
        border-radius: 99px;
        overflow: hidden;
    }
    .source-bar-fill {
        height: 100%;
        border-radius: 99px;
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ─── Devices Pill Container ─── */
    .device-pills-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }
    .device-pill {
        background: #F8FAFC;
        border: 1px solid var(--border-card);
        border-radius: 12px;
        padding: 12px;
        text-align: center;
    }
    .device-pill-icon {
        color: #071B19;
        margin-bottom: 6px;
    }
    .device-pill-pct {
        font: 800 18px/1 var(--font-code);
        color: var(--text-heading);
        margin-bottom: 4px;
    }
    .device-pill-title {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 600;
    }

    /* ─── Country List Item ─── */
    .country-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #F1F5F9;
        font-size: 13px;
    }
    .country-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
</style>
@endpush

@section('content')
<div class="analytics-container">

    <!-- 1. Top Control Toolbar -->
    <div class="analytics-toolbar">
        <div class="analytics-header-info">
            <h2>
                <span>تحليلات حركة الزيارات ومصادر الترافيك</span>
                <span class="live-pulse-badge">
                    <span class="live-dot"></span>
                    <span>{{ $liveVisitors }} نشط الآن بالموقع</span>
                </span>
            </h2>
            <p>تتبع مباشر لزوار الموقع، الصفحات والمشاريع الأكثر زيارة، وتفاعل الحملات الإعلانية (Google & Meta)</p>
        </div>

        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div class="period-filter-group">
                <a href="{{ route('admin.analytics.index', ['period' => 'today']) }}" class="period-filter-btn {{ $period === 'today' ? 'active' : '' }}">اليوم</a>
                <a href="{{ route('admin.analytics.index', ['period' => '7days']) }}" class="period-filter-btn {{ $period === '7days' ? 'active' : '' }}">آخر 7 أيام</a>
                <a href="{{ route('admin.analytics.index', ['period' => '30days']) }}" class="period-filter-btn {{ $period === '30days' ? 'active' : '' }}">آخر 30 يوم</a>
                <a href="{{ route('admin.analytics.index', ['period' => 'this_month']) }}" class="period-filter-btn {{ $period === 'this_month' ? 'active' : '' }}">هذا الشهر</a>
            </div>

            <button type="button" onclick="window.location.reload();" class="btn btn-outline btn-sm" title="تحديث البيانات">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                <span>تحديث</span>
            </button>
        </div>
    </div>

    <!-- 2. Marketing Pixels Integration Status Strip -->
    <div class="pixels-status-banner">
        <div>
            <div style="font-size: 13px; font-weight: 800; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                <span>حالة ربط بكسلات التتبع والحملات (Marketing Pixels & Analytics)</span>
            </div>
            <div style="font-size: 11.5px; color: #94A3B8;">
                الموقع متصل تلقائياً مع أدوات التحليل لتسجيل زيارات الإعلانات والتحويلات بدون تباطؤ
            </div>
        </div>

        <div class="pixels-chips-list">
            <!-- Google Analytics 4 -->
            <div class="pixel-chip {{ (!empty($pixels['google_analytics']) && $pixels['google_analytics']->is_active) ? '' : 'inactive' }}" title="Google Analytics 4">
                <span class="chip-dot"></span>
                <span style="font-weight: 700;">Google Analytics 4:</span>
                <span style="color: #6EE7B7;">{{ $pixels['google_analytics']->pixel_id ?? 'G-OXTECH2026' }}</span>
                <span style="font-size: 10px; background: rgba(16, 185, 129, 0.2); color: #A7F3D0; padding: 1px 5px; border-radius: 4px;">متصل</span>
            </div>

            <!-- Meta Pixel (Facebook & Instagram) -->
            <div class="pixel-chip {{ (!empty($pixels['meta']) && $pixels['meta']->is_active) ? '' : 'inactive' }}" title="Meta Pixel">
                <span class="chip-dot"></span>
                <span style="font-weight: 700;">Meta Pixel:</span>
                <span style="color: #6EE7B7;">{{ $pixels['meta']->pixel_id ?? '987654321098765' }}</span>
                <span style="font-size: 10px; background: rgba(16, 185, 129, 0.2); color: #A7F3D0; padding: 1px 5px; border-radius: 4px;">متصل</span>
            </div>

            <!-- Google Tag Manager -->
            @if(!empty($pixels['google_tag_manager']) && $pixels['google_tag_manager']->is_active)
            <div class="pixel-chip" title="Google Tag Manager">
                <span class="chip-dot"></span>
                <span style="font-weight: 700;">GTM:</span>
                <span style="color: #6EE7B7;">{{ $pixels['google_tag_manager']->pixel_id }}</span>
            </div>
            @endif

            <a href="{{ route('admin.tracking.index') }}" class="btn btn-sm" style="background: rgba(255, 255, 255, 0.15); color: #FFFFFF; font-size: 11.5px; border: 1px solid rgba(255, 255, 255, 0.2);">
                <span>إدارة البكسلات &larr;</span>
            </a>
        </div>
    </div>

    <!-- 3. Top 4 KPI Cards -->
    <div class="kpi-metrics-grid">
        <!-- Card 1: Pageviews -->
        <div class="kpi-card" style="--card-accent: #10B981;">
            <div>
                <div class="kpi-header">
                    <span class="kpi-title">إجمالي مشاهدات الصفحات</span>
                    <div class="kpi-icon-box" style="background: #ECFDF5; color: #10B981;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </div>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-number">{{ number_format($totalPageviews) }}</span>
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 600;">مشاهدة</span>
                </div>
            </div>
            <div class="kpi-meta">
                @if($growthPageviews >= 0)
                    <span class="growth-tag-up">&uarr; +{{ $growthPageviews }}%</span>
                @else
                    <span class="growth-tag-down">&darr; {{ $growthPageviews }}%</span>
                @endif
                <span>مقارنة بالفترة السابقة</span>
            </div>
        </div>

        <!-- Card 2: Unique Visitors -->
        <div class="kpi-card" style="--card-accent: #2563EB;">
            <div>
                <div class="kpi-header">
                    <span class="kpi-title">الزوار الفريدين (Unique Visitors)</span>
                    <div class="kpi-icon-box" style="background: #EFF6FF; color: #2563EB;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-number">{{ number_format($uniqueVisitors) }}</span>
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 600;">زائر مستقل</span>
                </div>
            </div>
            <div class="kpi-meta">
                <span style="font-weight: 700; color: #0F172A; font-family: var(--font-code);">{{ $avgPages }}</span>
                <span>متوسط مشاهدات الصفحات لكل زائر</span>
            </div>
        </div>

        <!-- Card 3: Live Active Visitors -->
        <div class="kpi-card" style="--card-accent: #059669;">
            <div>
                <div class="kpi-header">
                    <span class="kpi-title">النشطون الآن بالموقع (Live)</span>
                    <div class="kpi-icon-box" style="background: #ECFDF5; color: #059669;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-number" style="color: #059669;">{{ number_format($liveVisitors) }}</span>
                    <span style="font-size: 12px; color: #059669; font-weight: 700;">متصفح مباشر</span>
                </div>
            </div>
            <div class="kpi-meta">
                <span class="live-dot" style="display: inline-block;"></span>
                <span>زيارات نشطة خلال آخر 10 دقائق</span>
            </div>
        </div>

        <!-- Card 4: Conversions & CTA Actions -->
        <div class="kpi-card" style="--card-accent: #D97706;">
            <div>
                <div class="kpi-header">
                    <span class="kpi-title">تفاعلات التحويل (Conversions & CTAs)</span>
                    <div class="kpi-icon-box" style="background: #FFFBEB; color: #D97706;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    </div>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-number">{{ number_format($whatsappClicks + $consultationsCount) }}</span>
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 600;">تفاعل</span>
                </div>
            </div>
            <div class="kpi-meta" style="flex-wrap: wrap; gap: 8px;">
                <span style="color: #047857; font-weight: 700;">{{ $whatsappClicks }} نقرة واتساب</span>
                <span style="color: #94A3B8;">&bull;</span>
                <span style="color: #2563EB; font-weight: 700;">{{ $consultationsCount }} طلب استشارة</span>
            </div>
        </div>
    </div>

    <!-- 4. Interactive Traffic Trend Chart -->
    <div class="card" style="margin-bottom: 0;">
        <div class="card-header">
            <div>
                <h3 class="card-title">حركة الزيارات والمشاهدات اليومية (Traffic Trend)</h3>
                <span style="font-size: 12px; color: var(--text-muted);">رسم بياني يوضح تدفق المشاهدات والزوار الفريدين على مدار الفترة المحددة</span>
            </div>
            <div style="display: flex; align-items: center; gap: 14px; font-size: 12px; font-weight: 700;">
                <span style="display: inline-flex; align-items: center; gap: 6px; color: #10B981;">
                    <span style="width: 10px; height: 10px; border-radius: 2px; background: #10B981;"></span>
                    مشاهدات الصفحات (Pageviews)
                </span>
                <span style="display: inline-flex; align-items: center; gap: 6px; color: #2563EB;">
                    <span style="width: 10px; height: 10px; border-radius: 2px; background: #2563EB;"></span>
                    الزوار الفريدين (Visitors)
                </span>
            </div>
        </div>

        <div style="position: relative; height: 320px; width: 100%;">
            <canvas id="trafficTrendChart"></canvas>
        </div>
    </div>

    <!-- 5. Split Section: Sources vs Devices & Countries -->
    <div class="analytics-split-grid">
        <!-- Sources Breakdown -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title">مصادر الزيارات والحملات (Acquisition Channels)</h3>
                <span style="font-size: 11px; font-weight: 700; color: #64748B;">تتبع ذكي للمحيل والـ Referer</span>
            </div>

            <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 18px;">
                المنصات ومحركات البحث التي وصل منها زوار الموقع:
            </p>

            <div>
                @forelse($trafficSources as $src)
                    <div class="source-row">
                        <div class="source-label-bar">
                            <span class="source-name">
                                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: {{ $src['color'] }};"></span>
                                <span>{{ $src['label'] }}</span>
                            </span>
                            <span style="font-family: var(--font-code); font-weight: 800; color: var(--text-heading);">
                                {{ number_format($src['count']) }} <small style="font-size: 11px; color: var(--text-muted); font-weight: 600;">({{ $src['percentage'] }}%)</small>
                            </span>
                        </div>
                        <div class="source-bar-track">
                            <div class="source-bar-fill" style="width: {{ $src['percentage'] }}%; background: {{ $src['color'] }};"></div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: var(--text-muted); padding: 30px 10px; font-size: 13px;">
                        لم يتم تسجيل زيارات كافية بعد. تصفح الموقع لتسجيل الترافيك تلقائياً.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Devices & Top Countries -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title">الأجهزة والدول الأكثر تصفحاً</h3>
                <span style="font-size: 11px; font-weight: 700; color: #10B981;">توزيع المستخدمين</span>
            </div>

            <!-- Device Type Badges -->
            <div class="device-pills-row">
                <div class="device-pill">
                    <div class="device-pill-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                    </div>
                    <div class="device-pill-pct">{{ $devicesStats['mobile']['pct'] }}%</div>
                    <div class="device-pill-title">الهواتف الذكية ({{ $devicesStats['mobile']['count'] }})</div>
                </div>

                <div class="device-pill">
                    <div class="device-pill-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                    </div>
                    <div class="device-pill-pct">{{ $devicesStats['desktop']['pct'] }}%</div>
                    <div class="device-pill-title">أجهزة الكمبيوتر ({{ $devicesStats['desktop']['count'] }})</div>
                </div>

                <div class="device-pill">
                    <div class="device-pill-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                    </div>
                    <div class="device-pill-pct">{{ $devicesStats['tablet']['pct'] }}%</div>
                    <div class="device-pill-title">الأجهزة اللوحية ({{ $devicesStats['tablet']['count'] }})</div>
                </div>
            </div>

            <!-- Countries List -->
            <div style="border-top: 1px solid #F1F5F9; padding-top: 14px;">
                <h4 style="font-size: 13px; font-weight: 800; color: var(--text-heading); margin-bottom: 10px;">أكثر الدول زيارة للمنصة:</h4>
                @forelse($topCountries as $c)
                    <div class="country-item">
                        <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: var(--text-heading);">
                            <span style="font-family: var(--font-code); background: #F1F5F9; color: #475569; font-size: 11px; padding: 2px 6px; border-radius: 4px;">{{ strtoupper($c['code']) }}</span>
                            <span>{{ $c['name'] }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-family: var(--font-code); font-weight: 800; color: var(--text-heading);">{{ number_format($c['count']) }}</span>
                            <span style="font-size: 11px; color: var(--text-muted); font-family: var(--font-code);">({{ $c['percentage'] }}%)</span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: var(--text-muted); padding: 15px 0; font-size: 12.5px;">
                        يتم تحديد الدول تلقائياً عبر نطاق العناوين IP.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 6. Top Visited Projects & Pages Table -->
    <div class="card" style="margin-bottom: 0;">
        <div class="card-header">
            <div>
                <h3 class="card-title">أكثر الصفحات والمشاريع زيارة (Top Visited Pages & Projects)</h3>
                <span style="font-size: 12px; color: var(--text-muted);">المحتوى الذي يحظى بأكبر نسبة اهتمام وتفاعل من زوار OX Tech</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">الصفحة / عنوان المشروع</th>
                        <th style="width: 25%;">الرابط (Path)</th>
                        <th>عدد المشاهدات</th>
                        <th>الزوار الفريدين</th>
                        <th>النسبة من الإجمالي</th>
                        <th style="text-align: left;">معاينة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topPages as $page)
                        <tr>
                            <td>
                                <strong style="color: var(--text-heading); font-size: 13.5px;">{{ $page['title'] }}</strong>
                            </td>
                            <td>
                                <code style="font-family: var(--font-code); font-size: 12px; background: #F1F5F9; padding: 3px 8px; border-radius: 6px; color: #334155;">{{ $page['path'] }}</code>
                            </td>
                            <td>
                                <span style="font-family: var(--font-code); font-weight: 800; font-size: 14px; color: var(--text-heading);">{{ number_format($page['views']) }}</span>
                            </td>
                            <td>
                                <span style="font-family: var(--font-code); font-weight: 700; color: #475569;">{{ number_format($page['visitors']) }}</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="flex: 1; height: 6px; background: #E2E8F0; border-radius: 99px; overflow: hidden; max-width: 80px;">
                                        <div style="height: 100%; width: {{ $page['percentage'] }}%; background: #10B981; border-radius: 99px;"></div>
                                    </div>
                                    <span style="font-size: 11.5px; font-family: var(--font-code); font-weight: 700; color: var(--text-muted);">{{ $page['percentage'] }}%</span>
                                </div>
                            </td>
                            <td style="text-align: left;">
                                <a href="{{ url($page['path']) }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm" style="padding: 4px 10px; font-size: 11px;">
                                    <span>عرض</span>
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                لا توجد بيانات مسجلة للصفحات في هذه الفترة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 7. Recent Live Traffic Log -->
    <div class="card" style="margin-bottom: 0;">
        <div class="card-header">
            <div>
                <h3 class="card-title">آخر الزيارات الحية المسجلة (Live Realtime Feed)</h3>
                <span style="font-size: 12px; color: var(--text-muted);">أحدث الحركات الواردة للموقع مباشرة</span>
            </div>
            <span class="status-badge success" style="font-size: 11px;">مباشر LIVE</span>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>الصفحة المطلوبة</th>
                        <th>المصدر (Referer Source)</th>
                        <th>الجهاز / المتصفح</th>
                        <th>الدولة</th>
                        <th>وقت الزيارة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentVisits as $visit)
                        <tr>
                            <td>
                                <strong style="font-size: 13px; color: var(--text-heading);">/{{ ltrim($visit->path, '/') }}</strong>
                            </td>
                            <td>
                                <span class="status-badge" style="background: #F1F5F9; color: #1E293B; font-family: var(--font-code);">
                                    {{ $visit->referer_source ?: 'direct' }}
                                </span>
                            </td>
                            <td>
                                <span style="font-size: 12px; color: #475569;">
                                    {{ ucfirst($visit->device_type) }} &bull; {{ $visit->browser }} ({{ $visit->platform }})
                                </span>
                            </td>
                            <td>
                                <span style="font-family: var(--font-code); font-weight: 700; color: #071B19;">
                                    {{ strtoupper($visit->country_code ?: 'LOCAL') }}
                                </span>
                            </td>
                            <td style="color: var(--text-muted); font-size: 12px; font-family: var(--font-code);">
                                {{ $visit->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">
                                لا توجد زيارات حديثة بعد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('admin-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('trafficTrendChart');
    if (!ctx) return;

    const labels = @json($chartLabels);
    const pageviewsData = @json($chartPageviews);
    const visitorsData = @json($chartVisitors);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'مشاهدات الصفحات',
                    data: pageviewsData,
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.08)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#10B981',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'الزوار الفريدين',
                    data: visitorsData,
                    borderColor: '#2563EB',
                    backgroundColor: 'rgba(37, 99, 235, 0.04)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#2563EB',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    rtl: true,
                    backgroundColor: '#071B19',
                    titleColor: '#FFFFFF',
                    bodyColor: '#E2E8F0',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    titleFont: {
                        family: 'Alexandria, Cairo, sans-serif',
                        size: 13,
                        weight: '700'
                    },
                    bodyFont: {
                        family: 'Space Grotesk, Alexandria, sans-serif',
                        size: 12
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#94A3B8',
                        font: {
                            family: 'Space Grotesk, sans-serif',
                            size: 11
                        }
                    },
                    grid: {
                        color: '#F1F5F9'
                    }
                },
                x: {
                    ticks: {
                        color: '#64748B',
                        font: {
                            family: 'Alexandria, Cairo, sans-serif',
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
