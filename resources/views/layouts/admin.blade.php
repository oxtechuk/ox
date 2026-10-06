@php
    use App\Models\SiteSetting;
    use App\Models\Order;
    use App\Models\Consultation;

    $siteSettings = SiteSetting::all()->pluck('value', 'key');
    $resolveLogo = function (?string $path): ?string {
        if (empty($path)) return null;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return asset(ltrim($path, '/'));
    };
    $adminLogo = $resolveLogo($siteSettings['site_logo_main'] ?? null)
        ?: $resolveLogo($siteSettings['site_logo_dark'] ?? null)
        ?: $resolveLogo($siteSettings['site_logo_footer'] ?? null);
    $adminFavicon = $resolveLogo($siteSettings['site_favicon'] ?? null);
    $siteName = $siteSettings['site_name'] ?? 'OX Tech';

    $paidOrdersBadge = Order::where('payment_status', 'paid')->count();
    $newConsultationsBadge = Consultation::where('status', 'new')->count();
    $totalNotificationBadge = $newConsultationsBadge;
@endphp
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'لوحة التحكم | OX Tech')</title>
    @if(!empty($adminFavicon))
        <link rel="icon" href="{{ $adminFavicon }}">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700;800&family=Cairo:wght@600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            /* ─── SpaceRemit & OxTech Luxury Dark Sidebar Tokens ─── */
            --sidebar-bg:         #071B19;    /* كربون داكن ملكي */
            --sidebar-bg-sub:     #051513;    /* أغمق للفوتر والشعار */
            --sidebar-border:     rgba(255, 255, 255, 0.07);
            --sidebar-text:       #94A3B8;    /* رمادي ناعم للقوائم */
            --sidebar-hover:      rgba(255, 255, 255, 0.06);
            --sidebar-active-bg:  #FFFFFF;    /* أبيض ناصع للكبسولة النشطة */
            --sidebar-active-t:   #071B19;    /* نص كربوني غامق */
            
            /* ─── Clean SaaS Canvas Tokens (Matching Reference Image) ─── */
            --bg-page:            #F4F6F8;    /* رمادي ناصع مريح للعين */
            --bg-card:            #FFFFFF;    /* أبيض ناصع للبطاقات */
            --border-card:        #E2E8F0;    /* حدود رمادية ناعمة */
            --border-subtle:      #EDF2F7;
            --text-heading:       #0F172A;    /* أسود عصري فخم */
            --text-body:          #334155;
            --text-muted:         #64748B;
            
            /* ─── Brand Accents ─── */
            --brand-green:        #10B981;    /* زمردي متوهج */
            --brand-forest:       #071B19;
            --brand-blue:         #2563EB;
            --brand-gold:         #D97706;
            --brand-danger:       #EF4444;

            --font:               'Alexandria', 'Cairo', system-ui, sans-serif;
            --font-code:          'Space Grotesk', system-ui, sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg-page);
            color: var(--text-body);
            font-family: var(--font);
            min-height: 100vh;
            display: flex;
        }

        /* ─── Sidebar (Dark Obsidian) ─── */
        .admin-sidebar {
            width: 270px;
            background: var(--sidebar-bg);
            border-left: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            min-height: 100vh;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15);
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            padding: 22px 24px;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: var(--sidebar-bg-sub);
        }

        .sidebar-logo {
            font: 900 22px/1 var(--font-code), sans-serif;
            letter-spacing: -0.5px;
            color: #FFFFFF;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }
        .sidebar-logo span { color: var(--brand-green); }
        .sidebar-logo small {
            display: block;
            font: 800 9px/1 var(--font-code), sans-serif;
            color: var(--brand-green);
            letter-spacing: 2px;
            margin-top: 5px;
        }

        .admin-sidebar-logo-img {
            max-height: 38px;
            max-width: 150px;
            object-fit: contain;
            display: block;
            filter: brightness(0) invert(1);
        }

        .collapse-toggle-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #FFFFFF;
            width: 32px;
            height: 32px;
            border-radius: 9px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .collapse-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.16);
            color: var(--brand-green);
        }

        .sidebar-menu {
            list-style: none;
            padding: 18px 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* ─── Group Headings ─── */
        .menu-heading {
            font-size: 11px;
            color: #64748B;
            font-weight: 800;
            letter-spacing: 0.8px;
            padding: 16px 14px 6px;
            text-transform: uppercase;
            white-space: nowrap;
            transition: opacity 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .menu-heading::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.5);
        }

        /* ─── Menu Links (Capsule Active Pill style from Image 1) ─── */
        .menu-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: 12px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .menu-link-content {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .menu-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: opacity 0.2s ease;
        }

        .menu-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            color: #64748B;
            transition: color 0.2s ease;
            flex-shrink: 0;
        }

        .menu-link:hover {
            background: var(--sidebar-hover);
            color: #FFFFFF;
        }

        .menu-link:hover .menu-icon {
            color: #FFFFFF;
        }

        /* Active Capsule Pill */
        .menu-link.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-active-t) !important;
            font-weight: 800;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25);
        }

        .menu-link.active .menu-icon {
            color: var(--sidebar-active-t) !important;
        }

        .menu-badge {
            background: var(--brand-danger);
            color: #FFFFFF;
            font-family: var(--font-code);
            font-size: 11px;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 99px;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.35);
        }

        .menu-badge.green {
            background: var(--brand-green);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.35);
        }

        /* ─── Sidebar Bottom User ─── */
        .sidebar-user {
            padding: 16px 20px;
            border-top: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--sidebar-bg-sub);
            transition: padding 0.25s ease;
        }

        .user-info strong {
            display: block;
            font-size: 13px;
            color: #FFFFFF;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-info small {
            font-size: 11px;
            color: var(--brand-green);
            font-weight: 600;
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #FCA5A5;
            cursor: pointer;
            font-size: 11.5px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            font-family: var(--font);
            transition: 0.2s;
            flex-shrink: 0;
        }
        .logout-btn:hover {
            background: #EF4444;
            color: #FFFFFF;
            border-color: #EF4444;
        }

        /* ─── Collapsed State ─── */
        body.sidebar-collapsed .admin-sidebar {
            width: 76px;
        }
        body.sidebar-collapsed .sidebar-logo small,
        body.sidebar-collapsed .menu-text,
        body.sidebar-collapsed .menu-heading,
        body.sidebar-collapsed .menu-badge,
        body.sidebar-collapsed .user-info {
            display: none !important;
        }
        body.sidebar-collapsed .sidebar-brand {
            padding: 20px 10px;
            justify-content: center;
        }
        body.sidebar-collapsed .sidebar-logo {
            display: none;
        }
        body.sidebar-collapsed .sidebar-menu {
            padding: 16px 10px;
            gap: 8px;
        }
        body.sidebar-collapsed .menu-link {
            padding: 12px 0;
            justify-content: center;
        }
        body.sidebar-collapsed .menu-link-content {
            justify-content: center;
            gap: 0;
        }
        body.sidebar-collapsed .sidebar-user {
            padding: 16px 10px;
            justify-content: center;
        }

        /* Tooltip on hover when collapsed */
        body.sidebar-collapsed .menu-link:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            right: 74px;
            top: 50%;
            transform: translateY(-50%);
            background: #0A0F0D;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: 700;
            padding: 7px 14px;
            border-radius: 8px;
            white-space: nowrap;
            z-index: 999;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            pointer-events: none;
        }

        /* ─── Main Content Wrapper ─── */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            background: var(--bg-page);
        }

        /* ─── Clean Top Bar (Matching Image 1) ─── */
        .admin-topbar {
            height: 75px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-card);
            padding: 0 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            gap: 20px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-title {
            font-size: 22px;
            font-weight: 900;
            color: var(--text-heading);
            letter-spacing: -0.5px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-date-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 600;
            color: #64748B;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            padding: 4px 10px;
            border-radius: 99px;
            margin-right: 12px;
        }

        .quick-add-dropdown-wrapper {
            position: relative;
        }

        .btn-quick-add {
            background: #071B19 !important;
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-quick-add:hover {
            background: #0f2d29 !important;
            box-shadow: 0 4px 14px rgba(7, 27, 25, 0.2);
            transform: translateY(-1px);
        }

        .quick-add-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            min-width: 210px;
            padding: 6px;
            display: none;
            flex-direction: column;
            gap: 2px;
            z-index: 100;
        }
        .quick-add-menu.show {
            display: flex;
        }

        .quick-add-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            color: #334155;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .quick-add-item:hover {
            background: #F1F5F9;
            color: #071B19;
        }
        .quick-add-item svg {
            color: #006848;
        }

        .topbar-bell-btn {
            position: relative;
            background: #071B19;
            color: #FFFFFF;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .topbar-bell-btn:hover {
            transform: translateY(-1px);
            background: #0d2724;
            box-shadow: 0 4px 12px rgba(7, 27, 25, 0.2);
        }

        .bell-counter-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #EF4444;
            color: #FFFFFF;
            font-size: 10.5px;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 99px;
            border: 2px solid #FFFFFF;
            font-family: var(--font-code);
        }

        .topbar-user-capsule {
            background: #071B19;
            color: #FFFFFF;
            padding: 6px 14px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .user-capsule-avatar-box {
            position: relative;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 12px;
            color: #FFFFFF;
        }

        .verified-dot {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 10px;
            height: 10px;
            background: #10B981;
            border: 2px solid #071B19;
            border-radius: 50%;
        }

        .user-capsule-text {
            font-size: 12px;
            font-weight: 700;
            color: #FFFFFF;
            white-space: nowrap;
        }
        .user-capsule-text small {
            display: block;
            font-size: 9.5px;
            color: #94A3B8;
            font-weight: 500;
        }

        .view-site-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            text-decoration: none;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            padding: 8px 16px;
            border-radius: 10px;
            transition: 0.2s;
        }
        .view-site-link:hover {
            background: #0F172A;
            color: #FFFFFF;
            border-color: #0F172A;
        }

        .admin-content {
            padding: 35px;
            flex: 1;
        }

        /* ─── Common Modern Card & UI Elements ─── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 20px;
            padding: 26px;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-subtle);
        }

        .card-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-heading);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            font-family: var(--font);
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .btn-lime, .btn-primary {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: #FFFFFF !important;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);
        }
        .btn-lime:hover, .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35);
        }

        .btn-dark {
            background: #0F172A;
            color: #FFFFFF !important;
        }
        .btn-dark:hover {
            background: #1E293B;
        }

        .btn-outline {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: #334155;
        }
        .btn-outline:hover {
            background: #F8FAFC;
            border-color: #94A3B8;
            color: #0F172A;
        }

        .btn-danger {
            background: #FEE2E2;
            border: 1px solid #FECACA;
            color: #B91C1C;
        }
        .btn-danger:hover {
            background: #EF4444;
            color: #FFFFFF;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 12px;
            border-radius: 8px;
        }

        /* ─── Tables ─── */
        .table-responsive {
            overflow-x: auto;
        }
        table.admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
            font-size: 13px;
        }
        table.admin-table th {
            padding: 14px 16px;
            color: #64748B;
            font-weight: 800;
            border-bottom: 1px solid var(--border-card);
            background: #F8FAFC;
        }
        table.admin-table td {
            padding: 15px 16px;
            border-bottom: 1px solid #F1F5F9;
            color: #1E293B;
            vertical-align: middle;
        }
        table.admin-table tr:hover td {
            background: #FBFDFB;
        }

        /* ─── Status Badges ─── */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 700;
        }
        .status-badge.new, .status-badge.info { background: #EFF6FF; color: #1D4ED8; border: 1px solid #DBEAFE; }
        .status-badge.contacted, .status-badge.warning { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
        .status-badge.scheduled, .status-badge.primary { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }
        .status-badge.completed, .status-badge.success { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }
        .status-badge.archived, .status-badge.secondary { background: #F1F5F9; color: #64748B; border: 1px solid #E2E8F0; }
        .status-badge.danger, .status-badge.overdue { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }

        /* Alerts */
        .alert-box {
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 22px;
        }
        .alert-success {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
        }
        .alert-danger {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
        }
    </style>
    @stack('admin-styles')
</head>
<body>

    <!-- ─── Sidebar (Dark Obsidian - Grouped Navigation) ─── -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                @if(!empty($adminLogo))
                    <img src="{{ $adminLogo }}" alt="{{ $siteName }}" class="admin-sidebar-logo-img">
                @else
                    OX<span>.</span>
                    <small>ADMIN STUDIO</small>
                @endif
            </a>
            <button type="button" class="collapse-toggle-btn" id="sidebarCollapseBtn" title="طي / توسيع القائمة">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
        </div>

        <ul class="sidebar-menu">
            <!-- GROUP 1: OVERVIEW & FINANCE (نظرة عامة والمالية) -->
            <li class="menu-heading">نظرة عامة والمالية</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="لوحة التحكم">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </span>
                        <span class="menu-text">لوحة التحكم</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.digital-orders.index') }}" class="menu-link {{ request()->routeIs('admin.digital-orders.*') ? 'active' : '' }}" data-tooltip="مبيعات وتراخيص المتجر">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                        </span>
                        <span class="menu-text">مبيعات وتراخيص المتجر</span>
                    </div>
                    @if($paidOrdersBadge > 0)
                        <span class="menu-badge green">{{ $paidOrdersBadge }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.payment-logs.index') }}" class="menu-link {{ request()->routeIs('admin.payment-logs.*') ? 'active' : '' }}" data-tooltip="سجل بوابات الدفع (Logs)">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                        </span>
                        <span class="menu-text">سجل بوابات الدفع (Logs)</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.crm.invoices.index') }}" class="menu-link {{ request()->routeIs('admin.crm.invoices.*') ? 'active' : '' }}" data-tooltip="الفواتير والمستحقات">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1z"></path>
                                <path d="M8 7h8"></path>
                                <path d="M8 11h8"></path>
                                <path d="M8 15h5"></path>
                            </svg>
                        </span>
                        <span class="menu-text">الفواتير والمستحقات</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.crm.quotations.index') }}" class="menu-link {{ request()->routeIs('admin.crm.quotations.*') ? 'active' : '' }}" data-tooltip="عروض الأسعار">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                            </svg>
                        </span>
                        <span class="menu-text">عروض الأسعار</span>
                    </div>
                </a>
            </li>

            <!-- GROUP 2: DIGITAL PRODUCTS (المتجر والمنتجات) -->
            <li class="menu-heading">المتجر والمنتجات الرقمية</li>
            <li>
                <a href="{{ route('admin.digital-products.index') }}" class="menu-link {{ request()->routeIs('admin.digital-products.*') ? 'active' : '' }}" data-tooltip="البرامج والمنتجات">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                        </span>
                        <span class="menu-text">البرامج والمنتجات</span>
                    </div>
                </a>
            </li>

            <!-- GROUP 3: CLIENTS & LEADS (العملاء والتسويق) -->
            <li class="menu-heading">العملاء والتسويق</li>
            <li>
                <a href="{{ route('admin.consultations.index') }}" class="menu-link {{ request()->routeIs('admin.consultations.*') ? 'active' : '' }}" data-tooltip="طلبات الاستشارة">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </span>
                        <span class="menu-text">طلبات الاستشارة</span>
                    </div>
                    @if($newConsultationsBadge > 0)
                        <span class="menu-badge">{{ $newConsultationsBadge }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.crm.clients.index') }}" class="menu-link {{ request()->routeIs('admin.crm.clients.*') ? 'active' : '' }}" data-tooltip="سجل العملاء والشركات">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        <span class="menu-text">سجل العملاء</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.index') }}" class="menu-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" data-tooltip="تقارير الأداء ومصادر الزيارات">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </span>
                        <span class="menu-text">تقارير الأداء</span>
                    </div>
                </a>
            </li>

            <!-- GROUP 4: CONTENT & SYSTEM (المحتوى والنظام) -->
            <li class="menu-heading">المحتوى والنظام</li>
            <li>
                <a href="{{ route('admin.projects.index') }}" class="menu-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" data-tooltip="معرض الأعمال والمشاريع">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </span>
                        <span class="menu-text">المشاريع والأعمال</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.testimonials.index') }}" class="menu-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" data-tooltip="فيديوهات الشركاء">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                            </svg>
                        </span>
                        <span class="menu-text">فيديوهات الشركاء</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.site-content.index') }}" class="menu-link {{ request()->routeIs('admin.site-content.*') ? 'active' : '' }}" data-tooltip="نصوص الموقع">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </span>
                        <span class="menu-text">نصوص الموقع</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings.index') }}" class="menu-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" data-tooltip="إعدادات الموقع وبوابات الدفع">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                        </span>
                        <span class="menu-text">إعدادات الموقع والدفع</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tracking.index') }}" class="menu-link {{ request()->routeIs('admin.tracking.*') ? 'active' : '' }}" data-tooltip="بكسلات التتبع">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="6"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                            </svg>
                        </span>
                        <span class="menu-text">بكسلات التتبع</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-tooltip="المستخدمين">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </span>
                        <span class="menu-text">المستخدمين</span>
                    </div>
                </a>
            </li>
        </ul>

        <div class="sidebar-user">
            <div class="user-info">
                <strong>{{ auth()->user()?->name ?? 'مدير النظام' }}</strong>
                <small>{{ (auth()->user()?->role === 'super_admin') ? 'مدير عام' : ((auth()->user()?->role === 'admin') ? 'مدير' : 'محرر') }}</small>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn" title="تسجيل الخروج">خروج</button>
            </form>
        </div>
    </aside>

    <!-- ─── Main Content Canvas ─── -->
    <div class="admin-main">
        <header class="admin-topbar">
            <div class="topbar-left">
                <button type="button" class="collapse-toggle-btn" id="topbarCollapseBtn" title="طي / توسيع القائمة" style="background: #F1F5F9; color: #0F172A; border-color: #E2E8F0;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <h1 class="topbar-title">
                        @yield('header_title', 'لوحة التحكم')
                    </h1>
                    <span class="topbar-date-badge">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        {{ now()->locale('ar')->isoFormat('dddd، D MMMM YYYY') }}
                    </span>
                </div>
            </div>

            <div class="topbar-actions">
                <!-- Quick Add Dropdown -->
                <div class="quick-add-dropdown-wrapper" id="quickAddDropdownWrapper">
                    <button type="button" class="btn-quick-add" id="quickAddBtn" title="إجراء سريع">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>إضافة سريعة</span>
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <div class="quick-add-menu" id="quickAddMenu">
                        <a href="{{ route('admin.digital-products.create') }}" class="quick-add-item">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line></svg>
                            <span>إضافة برنامج أو منتج</span>
                        </a>
                        <a href="{{ route('admin.projects.create') }}" class="quick-add-item">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                            <span>إضافة مشروع جديد</span>
                        </a>
                        <a href="{{ route('admin.crm.invoices.create') }}" class="quick-add-item">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path></svg>
                            <span>إنشاء فاتورة جديدة</span>
                        </a>
                        <a href="{{ route('admin.crm.quotations.create') }}" class="quick-add-item">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><line x1="16" y1="13" x2="8" y2="13"></line></svg>
                            <span>إنشاء عرض سعر</span>
                        </a>
                    </div>
                </div>

                <!-- View Site Link -->
                <a href="{{ route('home') }}" target="_blank" class="view-site-link">
                    <span>عرض الموقع</span>
                    <span>&larr;</span>
                </a>

                <!-- Notification Bell with Active Counter (Image 1 Style) -->
                <a href="{{ route('admin.consultations.index') }}" class="topbar-bell-btn" title="طلبات الاستشارة الجديدة">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    @if($totalNotificationBadge > 0)
                        <span class="bell-counter-badge">{{ $totalNotificationBadge }}</span>
                    @endif
                </a>

                <!-- User Capsule Pill (Image 1 Style: Welcome! SPACEREMIT / OX TECH) -->
                <div class="topbar-user-capsule">
                    <div class="user-capsule-avatar-box">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span class="verified-dot" title="متصل"></span>
                    </div>
                    <div class="user-capsule-text">
                        <span>مرحباً! {{ auth()->user()?->name ?? 'OX TECH' }}</span>
                        <small>{{ auth()->user()?->role === 'super_admin' ? 'المدير العام' : 'المسؤول' }}</small>
                    </div>
                </div>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert-box alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-box alert-danger">
                    ✕ {{ session('error') }}
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="alert-box alert-danger">
                    <ul style="padding-right: 18px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Sidebar Collapse State Controller -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const isCollapsed = localStorage.getItem('ox_admin_sidebar_collapsed') === '1';
            if (isCollapsed) {
                document.body.classList.add('sidebar-collapsed');
            }

            const toggleSidebar = () => {
                document.body.classList.toggle('sidebar-collapsed');
                const collapsed = document.body.classList.contains('sidebar-collapsed');
                localStorage.setItem('ox_admin_sidebar_collapsed', collapsed ? '1' : '0');
            };

            const sidebarBtn = document.getElementById('sidebarCollapseBtn');
            const topbarBtn = document.getElementById('topbarCollapseBtn');

            if (sidebarBtn) sidebarBtn.addEventListener('click', toggleSidebar);
            if (topbarBtn) topbarBtn.addEventListener('click', toggleSidebar);

            // Quick Add Dropdown Toggle
            const quickAddBtn = document.getElementById('quickAddBtn');
            const quickAddMenu = document.getElementById('quickAddMenu');
            if (quickAddBtn && quickAddMenu) {
                quickAddBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    quickAddMenu.classList.toggle('show');
                });
                document.addEventListener('click', () => {
                    quickAddMenu.classList.remove('show');
                });
            }
        });
    </script>

    @stack('admin-scripts')
</body>
</html>
