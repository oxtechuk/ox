<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'لوحة التحكم | OX Tech')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-page: #f7f9f8;
            --bg-card: #ffffff;
            --border-card: #e5e9e7;
            --border-subtle: #edf2f0;
            --text-heading: #091e19;
            --text-body: #334155;
            --text-muted: #64748b;
            --brand-green: #006848;
            --brand-forest: #092c22;
            --brand-blue: #1f63ff;
            --font: 'Alexandria', sans-serif;
            --font-code: 'Space Grotesk', sans-serif;
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

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background: #ffffff;
            border-left: 1px solid var(--border-card);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            min-height: 100vh;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.02);
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            padding: 20px 22px;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .sidebar-logo {
            font: 800 22px/1 'Space Grotesk', sans-serif;
            letter-spacing: -1px;
            color: var(--brand-forest);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
            overflow: hidden;
            white-space: nowrap;
        }
        .sidebar-logo span { color: var(--brand-green); }
        .sidebar-logo small {
            display: block;
            font: 700 9px/1 'Space Grotesk', sans-serif;
            color: var(--brand-green);
            letter-spacing: 1.5px;
            margin-top: 4px;
        }

        .collapse-toggle-btn {
            background: #f1f5f3;
            border: 1px solid #e2e8e5;
            color: var(--brand-forest);
            width: 30px;
            height: 30px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .collapse-toggle-btn:hover {
            background: #e2ede8;
            color: var(--brand-green);
        }

        .sidebar-menu {
            list-style: none;
            padding: 16px 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 3px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .menu-heading {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 12px 12px 4px;
            white-space: nowrap;
            transition: opacity 0.2s ease;
        }

        .menu-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 12px;
            border-radius: 10px;
            color: #475569;
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            position: relative;
        }

        .menu-link-content {
            display: flex;
            align-items: center;
            gap: 10px;
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
            width: 18px;
            height: 18px;
            color: #64748b;
            transition: color 0.2s ease;
            flex-shrink: 0;
        }

        .menu-link:hover .menu-icon,
        .menu-link.active .menu-icon {
            color: var(--brand-green);
        }

        /* Collapsed Sidebar Styles */
        body.sidebar-collapsed .admin-sidebar {
            width: 70px;
        }
        body.sidebar-collapsed .sidebar-logo small,
        body.sidebar-collapsed .menu-text,
        body.sidebar-collapsed .menu-heading,
        body.sidebar-collapsed .menu-badge,
        body.sidebar-collapsed .user-info {
            display: none !important;
        }
        body.sidebar-collapsed .sidebar-brand {
            padding: 18px 10px;
            justify-content: center;
        }
        body.sidebar-collapsed .sidebar-logo {
            display: none;
        }
        body.sidebar-collapsed .sidebar-menu {
            padding: 16px 8px;
            gap: 6px;
        }
        body.sidebar-collapsed .menu-link {
            padding: 10px 0;
            justify-content: center;
        }
        body.sidebar-collapsed .menu-link-content {
            justify-content: center;
            gap: 0;
        }
        body.sidebar-collapsed .menu-icon {
            width: 20px;
            height: 20px;
        }
        body.sidebar-collapsed .sidebar-user {
            padding: 14px 6px;
            justify-content: center;
        }
        body.sidebar-collapsed .logout-btn {
            padding: 6px 8px;
            font-size: 10.5px;
        }

        /* Tooltip on hover when collapsed */
        body.sidebar-collapsed .menu-link:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            right: 68px;
            top: 50%;
            transform: translateY(-50%);
            background: #092c22;
            color: #ffffff;
            font-size: 11.5px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 6px;
            white-space: nowrap;
            z-index: 999;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            pointer-events: none;
        }

        /* Truncate Utilities for Tables */
        .truncate-text {
            display: inline-block;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: middle;
            cursor: help;
        }
        .truncate-text.sm { max-width: 130px; }
        .truncate-text.md { max-width: 220px; }
        .truncate-text.lg { max-width: 320px; }

        /* Luxury Global Pagination */
        .ox-pagination-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            width: 100%;
        }
        .ox-pagination-info {
            font-size: 12px;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .ox-pagination-info strong {
            color: var(--text-heading);
            font-weight: 700;
            font-family: var(--font-code);
        }
        .ox-pagination-list {
            display: inline-flex;
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 5px;
        }
        .ox-page-item {
            display: inline-block;
        }
        .ox-page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            text-decoration: none;
            transition: all 0.2s ease;
            font-family: var(--font-code);
            cursor: pointer;
        }
        .ox-page-link:hover {
            background: #f8fafc;
            color: var(--brand-green);
            border-color: #cbd5e1;
        }
        .ox-page-item.active .ox-page-link {
            background: var(--brand-green);
            color: #ffffff;
            border-color: var(--brand-green);
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(0, 104, 72, 0.2);
        }
        .ox-page-item.disabled .ox-page-link {
            background: #f8fafc;
            color: #cbd5e1;
            border-color: #f1f5f9;
            cursor: not-allowed;
            pointer-events: none;
        }
        .ox-page-link.dots {
            border-color: transparent;
            background: transparent;
            cursor: default;
        }

        /* Generic Fallback to ensure no Tailwind or Laravel SVG explodes */
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }
        nav[role="navigation"] > div {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
        }

        .menu-link:hover {
            background: #f1f5f3;
            color: var(--brand-forest);
        }

        .menu-link.active {
            background: #eaf3ef;
            color: var(--brand-green);
            border-color: #d2e7de;
            font-weight: 700;
        }

        .menu-badge {
            background: #ef4444;
            color: #fff;
            font-family: var(--font-code);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 99px;
            flex-shrink: 0;
        }

        .sidebar-user {
            padding: 16px 20px;
            border-top: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fbfcfb;
            transition: padding 0.25s ease;
        }

        .user-info strong {
            display: block;
            font-size: 12.5px;
            color: var(--text-heading);
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-info small {
            font-size: 10.5px;
            color: var(--brand-green);
            font-weight: 600;
        }

        .logout-btn {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            cursor: pointer;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 6px;
            font-family: var(--font);
            transition: 0.2s;
            flex-shrink: 0;
        }
        .logout-btn:hover {
            background: #fca5a5;
            color: #7f1d1d;
        }

        /* Main Content Wrapper */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: all 0.25s ease;
        }

        .admin-topbar {
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid var(--border-card);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            gap: 16px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-heading);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .view-site-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 16px;
            border-radius: 99px;
            transition: 0.2s;
        }
        .view-site-link:hover {
            background: var(--brand-forest);
            color: #ffffff;
            border-color: var(--brand-forest);
        }

        .admin-content {
            padding: 35px;
            flex: 1;
        }

        /* Common Elements */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-subtle);
        }

        .card-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-heading);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            font-family: var(--font);
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .btn-lime, .btn-primary {
            background: var(--brand-forest);
            color: #ffffff !important;
            font-weight: 700;
        }
        .btn-lime:hover, .btn-primary:hover {
            background: #041813;
            box-shadow: 0 4px 12px rgba(9, 44, 34, 0.15);
            transform: translateY(-1px);
        }

        .btn-blue {
            background: var(--brand-blue);
            color: #ffffff !important;
            font-weight: 700;
        }
        .btn-blue:hover {
            background: #1550d6;
        }

        .btn-outline {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #334155;
        }
        .btn-outline:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a;
        }

        .btn-danger {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }
        .btn-danger:hover {
            background: #fca5a5;
        }

        .btn-sm {
            padding: 5px 12px;
            font-size: 11.5px;
            border-radius: 6px;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }
        table.admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
            font-size: 12.5px;
        }
        table.admin-table th {
            padding: 12px 14px;
            color: #475569;
            font-weight: 700;
            border-bottom: 1px solid var(--border-card);
            background: #f8fafc;
        }
        table.admin-table td {
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            vertical-align: middle;
        }
        table.admin-table tr:hover td {
            background: #fbfcfb;
        }

        /* Forms */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 18px;
        }
        .form-control {
            width: 100%;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 14px;
            color: #0f172a;
            font-family: var(--font);
            font-size: 12.5px;
            outline: none;
            transition: 0.2s;
        }
        .form-control:focus {
            border-color: var(--brand-green);
            box-shadow: 0 0 0 3px rgba(0, 104, 72, 0.12);
        }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-heading);
            margin-bottom: 6px;
        }
        .form-hint {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 600;
        }
        .status-badge.new, .status-badge.info { background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }
        .status-badge.contacted, .status-badge.warning { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .status-badge.scheduled, .status-badge.primary { background: #eaf3ef; color: #006848; border: 1px solid #c2e2d6; }
        .status-badge.completed, .status-badge.success { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .status-badge.archived, .status-badge.secondary { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
        .status-badge.danger, .status-badge.overdue { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        /* Alerts */
        .alert-box {
            padding: 14px 20px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
    </style>
    @stack('admin-styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                OX<span>.</span>
                <small>ADMIN STUDIO</small>
            </a>
            <button type="button" class="collapse-toggle-btn" id="sidebarCollapseBtn" title="طي / توسيع القائمة">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
        </div>

        <ul class="sidebar-menu">
            <!-- Group 1: Dashboard (Most Used) -->
            <li class="menu-heading">الرئيسية والإحصائيات</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="الإحصائيات">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                                <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                                <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                                <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                            </svg>
                        </span>
                        <span class="menu-text">الإحصائيات</span>
                    </div>
                </a>
            </li>

            <!-- Group 2: CRM & Sales (High Frequency) -->
            <li class="menu-heading">إدارة المبيعات (CRM)</li>
            <li>
                <a href="{{ route('admin.crm.invoices.index') }}" class="menu-link {{ request()->routeIs('admin.crm.invoices.*') ? 'active' : '' }}" data-tooltip="الفواتير والمستحقات">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <line x1="10" y1="9" x2="8" y2="9"></line>
                            </svg>
                        </span>
                        <span class="menu-text">عروض الأسعار</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.crm.clients.index') }}" class="menu-link {{ request()->routeIs('admin.crm.clients.*') ? 'active' : '' }}" data-tooltip="سجل العملاء">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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

            <!-- Group 3: Consultations & Marketing Leads -->
            <li class="menu-heading">التسويق والاستشارات</li>
            <li>
                <a href="{{ route('admin.consultations.index') }}" class="menu-link {{ request()->routeIs('admin.consultations.*') ? 'active' : '' }}" data-tooltip="طلبات الاستشارة">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </span>
                        <span class="menu-text">طلبات الاستشارة</span>
                    </div>
                    @php
                        $pendingCount = \App\Models\Consultation::where('status', 'new')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="menu-badge">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.index') }}" class="menu-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" data-tooltip="تقارير الأداء">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </span>
                        <span class="menu-text">تقارير الأداء</span>
                    </div>
                </a>
            </li>

            <!-- Group 4: Content & Portfolio -->
            <li class="menu-heading">المحتوى والأعمال</li>
            <li>
                <a href="{{ route('admin.projects.index') }}" class="menu-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" data-tooltip="المشاريع والأعمال">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </span>
                        <span class="menu-text">نصوص الموقع</span>
                    </div>
                </a>
            </li>

            <!-- Group 5: Settings & System -->
            <li class="menu-heading">الإعدادات والتتبع</li>
            <li>
                <a href="{{ route('admin.settings.index') }}" class="menu-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" data-tooltip="إعدادات الموقع">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                        </span>
                        <span class="menu-text">إعدادات الموقع</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tracking.index') }}" class="menu-link {{ request()->routeIs('admin.tracking.*') ? 'active' : '' }}" data-tooltip="بكسلات التتبع">
                    <div class="menu-link-content">
                        <span class="menu-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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
                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ auth()->user()->role === 'super_admin' ? 'مدير عام' : (auth()->user()->role === 'admin' ? 'مدير' : 'محرر') }}</small>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn" title="تسجيل الخروج">خروج</button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <header class="admin-topbar">
            <div class="topbar-left">
                <button type="button" class="collapse-toggle-btn" id="topbarCollapseBtn" title="طي / توسيع القائمة الجانبية">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div class="topbar-title">
                    @yield('header_title', 'لوحة التحكم')
                </div>
            </div>
            <div class="topbar-actions">
                <a href="{{ route('home') }}" target="_blank" class="view-site-link">
                    <span>عرض الموقع الحي</span>
                    <span>&larr;</span>
                </a>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert-box alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-box alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
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
        });
    </script>

    @stack('admin-scripts')
</body>
</html>
