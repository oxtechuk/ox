@extends('layouts.admin')

@section('title', 'إدارة العملاء والمديونيات | OX Tech CRM')
@section('header_title', 'نظام إدارة العملاء (CRM) وسجل المستحقات')

@push('admin-styles')
<style>
    .clients-kpis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .kpi-stat-card {
        background: #ffffff;
        border: 1px solid var(--border-card);
        border-radius: 12px;
        padding: 20px 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .kpi-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
    }
    .kpi-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 3px;
    }
    .kpi-stat-card.forest::before { background: var(--brand-forest); }
    .kpi-stat-card.blue::before { background: var(--brand-blue); }
    .kpi-stat-card.green::before { background: #059669; }
    .kpi-stat-card.red::before { background: #dc2626; }

    .kpi-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .kpi-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
    }
    .kpi-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .kpi-stat-card.forest .kpi-icon { background: #eaf3ef; color: var(--brand-forest); }
    .kpi-stat-card.blue .kpi-icon { background: #eff6ff; color: var(--brand-blue); }
    .kpi-stat-card.green .kpi-icon { background: #ecfdf5; color: #059669; }
    .kpi-stat-card.red .kpi-icon { background: #fef2f2; color: #dc2626; }

    .kpi-val {
        font-size: 22px;
        font-weight: 800;
        font-family: var(--font-code);
        color: var(--text-heading);
        line-height: 1.2;
    }
    .kpi-val span {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        margin-right: 4px;
    }

    /* Toolbar */
    .clients-toolbar {
        background: #ffffff;
        border: 1px solid var(--border-card);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }
    .filter-tabs {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .filter-tab {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: 0.2s;
    }
    .filter-tab:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .filter-tab.active {
        background: #eaf3ef;
        color: var(--brand-green);
        border-color: #c2e2d6;
        font-weight: 700;
    }

    /* Client Row Elements */
    .client-avatar-badge {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #eaf3ef;
        color: var(--brand-forest);
        font-weight: 800;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #d2e7de;
    }
    .client-name-link {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--brand-forest);
        text-decoration: none;
        transition: color 0.15s;
    }
    .client-name-link:hover {
        color: var(--brand-green);
    }
    .client-comp-sub {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
    }
    .status-pill::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .status-pill.active { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .status-pill.active::before { background: #10b981; }
    .status-pill.prospect { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .status-pill.prospect::before { background: #f59e0b; }
    .status-pill.lead { background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }
    .status-pill.lead::before { background: #3b82f6; }
    .status-pill.inactive { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .status-pill.inactive::before { background: #94a3b8; }

    .sub-amount-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-family: var(--font-code);
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
    }
    .sub-amount-pill.paid { background: #ecfdf5; color: #047857; }
    .sub-amount-pill.due { background: #fef2f2; color: #b91c1c; }
</style>
@endpush

@section('content')
<div>

    <!-- Financial KPI Summary Cards -->
    <div class="clients-kpis-grid">
        <div class="kpi-stat-card forest">
            <div class="kpi-header">
                <span class="kpi-label">إجمالي العملاء المسجلين</span>
                <div class="kpi-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
            </div>
            <div class="kpi-val">{{ $totalClients }} <span>عميل</span></div>
        </div>

        <div class="kpi-stat-card blue">
            <div class="kpi-header">
                <span class="kpi-label">إجمالي المبيعات المفوترة</span>
                <div class="kpi-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <line x1="10" y1="9" x2="8" y2="9"></line>
                    </svg>
                </div>
            </div>
            <div class="kpi-val">{{ number_format($totalBilled, 2) }} <span>SAR</span></div>
        </div>

        <div class="kpi-stat-card green">
            <div class="kpi-header">
                <span class="kpi-label">إجمالي الإيرادات المحصلة</span>
                <div class="kpi-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
            </div>
            <div class="kpi-val" style="color: #047857;">{{ number_format($totalCollected, 2) }} <span>SAR</span></div>
        </div>

        <div class="kpi-stat-card red">
            <div class="kpi-header">
                <span class="kpi-label">المستحقات والديون الآجلة (Due)</span>
                <div class="kpi-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
            </div>
            <div class="kpi-val" style="color: #b91c1c;">{{ number_format($totalOutstanding, 2) }} <span>SAR</span></div>
        </div>
    </div>

    <!-- Actions & Filter Toolbar -->
    <div class="clients-toolbar">
        <div class="filter-tabs">
            <a href="{{ route('admin.crm.clients.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">الكل</a>
            <a href="{{ route('admin.crm.clients.index', ['status' => 'active']) }}" class="filter-tab {{ request('status') === 'active' ? 'active' : '' }}">عميل نشط</a>
            <a href="{{ route('admin.crm.clients.index', ['status' => 'prospect']) }}" class="filter-tab {{ request('status') === 'prospect' ? 'active' : '' }}">قيد التفاوض</a>
            <a href="{{ route('admin.crm.clients.index', ['status' => 'lead']) }}" class="filter-tab {{ request('status') === 'lead' ? 'active' : '' }}">محتمل جديد</a>
            <a href="{{ route('admin.crm.clients.index', ['status' => 'inactive']) }}" class="filter-tab {{ request('status') === 'inactive' ? 'active' : '' }}">غير نشط</a>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <form method="GET" action="{{ route('admin.crm.clients.index') }}" style="display: flex; gap: 8px;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="search" class="form-control" style="width: 220px; padding: 7px 12px; font-size: 12px;" placeholder="بحث بالاسم، الشركة، البريد..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline btn-sm">بحث</button>
            </form>

            <a href="{{ route('admin.crm.clients.create') }}" class="btn btn-lime btn-sm">
                <span>+ إضافة عميل جديد</span>
            </a>
        </div>
    </div>

    <!-- Clients Table -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div class="table-responsive">
            <table class="admin-table" style="margin: 0;">
                <thead>
                    <tr>
                        <th style="padding-right: 22px;">العميل والمنشأة</th>
                        <th>بيانات التواصل والموقع</th>
                        <th>حالة العميل والمصدر</th>
                        <th>المعاملات المالية</th>
                        <th>المستحق الآجل (Due)</th>
                        <th style="padding-left: 22px; text-align: left;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td style="padding-right: 22px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="client-avatar-badge">
                                        {{ mb_substr($client->name, 0, 1, 'utf-8') }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.crm.clients.show', $client) }}" class="client-name-link truncate-text sm" title="{{ $client->name }}">
                                            {{ $client->name }}
                                        </a>
                                        @if($client->company_name)
                                            <div class="client-comp-sub truncate-text sm" title="{{ $client->company_name }}">
                                                {{ $client->company_name }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><a href="mailto:{{ $client->email }}" class="truncate-text sm" title="{{ $client->email }}" style="color: var(--brand-blue); text-decoration: none; font-size: 12px;">{{ $client->email }}</a></div>
                                <div style="font-size: 11px; color: var(--text-muted); font-family: var(--font-code); margin-top: 2px;">
                                    {{ $client->phone ?? '—' }} · {{ $client->country ?? 'السعودية' }} @if($client->city) <small>({{ $client->city }})</small> @endif
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    @if($client->status === 'active')
                                        <span class="status-pill active">عميل نشط</span>
                                    @elseif($client->status === 'prospect')
                                        <span class="status-pill prospect">قيد التفاوض</span>
                                    @elseif($client->status === 'lead')
                                        <span class="status-pill lead">محتمل جديد</span>
                                    @else
                                        <span class="status-pill inactive">غير نشط</span>
                                    @endif

                                    <span style="font-size: 10.5px; background: #f1f5f9; padding: 2px 7px; border-radius: 4px; color: var(--text-muted); font-weight: 600;">
                                        {{ $client->lead_source ?? 'Direct' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--text-heading); font-family: var(--font-code); font-size: 13px;">
                                    {{ number_format($client->total_billed, 2) }} SAR
                                </div>
                                <div style="margin-top: 2px;">
                                    <span class="sub-amount-pill paid">محصل: {{ number_format($client->total_paid, 2) }}</span>
                                </div>
                            </td>
                            <td>
                                @if($client->outstanding_balance > 0)
                                    <span class="sub-amount-pill due" style="font-size: 12px; font-weight: 800; padding: 4px 8px; border-radius: 6px; border: 1px solid #fee2e2;">
                                        {{ number_format($client->outstanding_balance, 2) }} SAR
                                    </span>
                                @else
                                    <span class="sub-amount-pill paid" style="font-size: 11px; font-weight: 700;">خالص 0.00</span>
                                @endif
                            </td>
                            <td style="padding-left: 22px; text-align: left;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ route('admin.crm.clients.show', $client) }}" class="btn btn-outline btn-sm" title="عرض ملف العميل وتاريخه">
                                        ملف العميل
                                    </a>
                                    <a href="{{ route('admin.crm.quotations.create', ['client_id' => $client->id]) }}" class="btn btn-outline btn-sm" title="إنشاء عرض سعر">
                                        عرض سعر
                                    </a>
                                    <a href="{{ route('admin.crm.clients.edit', $client) }}" class="btn btn-outline btn-sm" title="تعديل">
                                        تعديل
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 50px 20px;">
                                <div style="font-size: 14px; font-weight: 600; margin-bottom: 6px;">لا يوجد عملاء مطابقين للبحث أو التصفية</div>
                                <div style="font-size: 12px; color: var(--text-muted);">يمكنك إضافة عميل جديد بالضغط على الزر أعلاه.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clients->hasPages())
            <div style="padding: 16px 22px; border-top: 1px solid var(--border-subtle); background: #fafcfb;">
                {{ $clients->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
