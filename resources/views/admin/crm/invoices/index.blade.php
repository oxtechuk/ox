@extends('layouts.admin')

@section('title', 'الفواتير والمطالبات المالية | OX Tech CRM')
@section('header_title', 'إدارة الفواتير والمستحقات والتحصيلات')

@push('admin-styles')
<style>
    /* Invoice Specific Luxury Styling */
    .invoice-kpis-grid {
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
    .kpi-stat-card.blue::before { background: var(--brand-blue); }
    .kpi-stat-card.green::before { background: #059669; }
    .kpi-stat-card.red::before { background: #dc2626; }
    .kpi-stat-card.amber::before { background: #d97706; }

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
    .kpi-stat-card.blue .kpi-icon { background: #eff6ff; color: var(--brand-blue); }
    .kpi-stat-card.green .kpi-icon { background: #ecfdf5; color: #059669; }
    .kpi-stat-card.red .kpi-icon { background: #fef2f2; color: #dc2626; }
    .kpi-stat-card.amber .kpi-icon { background: #fffbeb; color: #d97706; }

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

    /* Filter & Search Toolbar */
    .invoices-toolbar {
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

    /* Refined Invoices Table */
    .invoice-row-card {
        transition: background 0.15s ease;
    }
    .invoice-row-card:hover {
        background: #fafcfb !important;
    }
    .inv-number-badge {
        font-family: var(--font-code);
        font-weight: 800;
        color: var(--brand-forest);
        font-size: 13px;
        letter-spacing: 0.5px;
    }
    .inv-title-sub {
        font-size: 11.5px;
        color: var(--text-muted);
        margin-top: 2px;
    }
    .client-name-link {
        font-size: 13px;
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
        margin-top: 1px;
    }
    .amount-display {
        font-family: var(--font-code);
        font-weight: 800;
        color: var(--text-heading);
        font-size: 13.5px;
    }
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

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 99px;
        font-size: 11.5px;
        font-weight: 700;
    }
    .status-pill::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .status-pill.paid { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .status-pill.paid::before { background: #10b981; }
    .status-pill.partially_paid { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .status-pill.partially_paid::before { background: #f59e0b; }
    .status-pill.sent { background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }
    .status-pill.sent::before { background: #3b82f6; }
    .status-pill.overdue { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .status-pill.overdue::before { background: #ef4444; }
</style>
@endpush

@section('content')
<div>

    <!-- Financial KPIs Header Cards -->
    <div class="invoice-kpis-grid">
        <div class="kpi-stat-card blue">
            <div class="kpi-header">
                <span class="kpi-label">إجمالي الفواتير الصادرة</span>
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
            <div class="kpi-val">{{ number_format($totalInvoiced, 2) }} <span>SAR</span></div>
        </div>

        <div class="kpi-stat-card green">
            <div class="kpi-header">
                <span class="kpi-label">إجمالي المبالغ المسددة</span>
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
                <span class="kpi-label">المتبقي الآجل المطلوب تحصيله</span>
                <div class="kpi-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
            </div>
            <div class="kpi-val" style="color: #b91c1c;">{{ number_format($totalDue, 2) }} <span>SAR</span></div>
        </div>

        <div class="kpi-stat-card amber">
            <div class="kpi-header">
                <span class="kpi-label">فواتير متأخرة أو بحاجة متابعة</span>
                <div class="kpi-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
            </div>
            <div class="kpi-val" style="color: #b45309;">{{ $overdueCount }} <span>فاتورة</span></div>
        </div>
    </div>

    <!-- Search & Filter Toolbar -->
    <div class="invoices-toolbar">
        <div class="filter-tabs">
            <a href="{{ route('admin.crm.invoices.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">الكل</a>
            <a href="{{ route('admin.crm.invoices.index', ['status' => 'sent']) }}" class="filter-tab {{ request('status') === 'sent' ? 'active' : '' }}">بانتظار السداد</a>
            <a href="{{ route('admin.crm.invoices.index', ['status' => 'partially_paid']) }}" class="filter-tab {{ request('status') === 'partially_paid' ? 'active' : '' }}">مدفوعة جزئياً</a>
            <a href="{{ route('admin.crm.invoices.index', ['status' => 'paid']) }}" class="filter-tab {{ request('status') === 'paid' ? 'active' : '' }}">مدفوعة بالكامل</a>
            <a href="{{ route('admin.crm.invoices.index', ['status' => 'overdue']) }}" class="filter-tab {{ request('status') === 'overdue' ? 'active' : '' }}" style="color: #b91c1c;">متأخرة السداد</a>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <form method="GET" action="{{ route('admin.crm.invoices.index') }}" style="display: flex; gap: 8px;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="search" class="form-control" style="width: 220px; padding: 7px 12px; font-size: 12px;" placeholder="بحث برقم الفاتورة أو العميل..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline btn-sm">بحث</button>
            </form>

            <a href="{{ route('admin.crm.invoices.create') }}" class="btn btn-lime btn-sm">
                <span>+ إصدار فاتورة جديدة</span>
            </a>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div class="table-responsive">
            <table class="admin-table" style="margin: 0;">
                <thead>
                    <tr>
                        <th style="padding-right: 22px;">الفاتورة والمشروع</th>
                        <th>العميل والجهة</th>
                        <th>التواريخ</th>
                        <th>المبلغ الإجمالي</th>
                        <th>التحصيل والآجل</th>
                        <th>الحالة</th>
                        <th style="padding-left: 22px; text-align: left;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr class="invoice-row-card">
                            <td style="padding-right: 22px;">
                                <div class="inv-number-badge">{{ $invoice->invoice_number }}</div>
                                <div class="inv-title-sub truncate-text md" title="{{ $invoice->title }}">{{ $invoice->title }}</div>
                            </td>
                            <td>
                                <div>
                                    <a href="{{ route('admin.crm.clients.show', $invoice->client) }}" class="client-name-link truncate-text sm" title="{{ $invoice->client->name }}">
                                        {{ $invoice->client->name }}
                                    </a>
                                    @if($invoice->client->company_name)
                                        <div class="client-comp-sub truncate-text sm" title="{{ $invoice->client->company_name }}">{{ $invoice->client->company_name }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 12px; font-family: var(--font-code); color: var(--text-body);">
                                    {{ $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : ($invoice->created_at ? $invoice->created_at->format('Y-m-d') : '—') }}
                                </div>
                                <div style="font-size: 11px; font-family: var(--font-code); margin-top: 2px;">
                                    @if($invoice->due_date)
                                        <span style="{{ ($invoice->due_amount > 0 && $invoice->due_date < now()) ? 'color: #dc2626; font-weight: 700;' : 'color: var(--text-muted);' }}">
                                            استحقاق: {{ $invoice->due_date->format('Y-m-d') }}
                                        </span>
                                    @else
                                        <span style="color: var(--text-muted);">سداد فوري</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="amount-display">{{ number_format($invoice->total_amount, 2) }} <small style="font-size: 10.5px; font-weight: 600; color: var(--text-muted);">{{ $invoice->currency }}</small></div>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 3px;">
                                    <div>
                                        <span class="sub-amount-pill paid">المسدد: {{ number_format($invoice->paid_amount, 2) }}</span>
                                    </div>
                                    @if($invoice->due_amount > 0)
                                        <div>
                                            <span class="sub-amount-pill due">الآجل: {{ number_format($invoice->due_amount, 2) }}</span>
                                        </div>
                                    @else
                                        <div>
                                            <span class="sub-amount-pill paid" style="background: transparent; padding: 0;">خالص 0.00</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($invoice->status === 'paid')
                                    <span class="status-pill paid">مدفوعة بالكامل</span>
                                @elseif($invoice->status === 'partially_paid')
                                    <span class="status-pill partially_paid">مدفوعة جزئياً</span>
                                @elseif($invoice->status === 'overdue')
                                    <span class="status-pill overdue">متأخرة السداد</span>
                                @else
                                    <span class="status-pill sent">بانتظار السداد</span>
                                @endif
                            </td>
                            <td style="padding-left: 22px; text-align: left;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ route('admin.crm.invoices.show', $invoice) }}" class="btn btn-outline btn-sm" title="عرض تفاصيل الفاتورة">
                                        معاينة
                                    </a>
                                    <a href="{{ route('admin.crm.invoices.edit', $invoice) }}" class="btn btn-outline btn-sm" title="تعديل بيانات الفاتورة">
                                        تعديل
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 50px 20px;">
                                <div style="font-size: 14px; font-weight: 600; margin-bottom: 6px;">لا توجد فواتير مطابقة للبحث أو التصفية</div>
                                <div style="font-size: 12px; color: var(--text-muted);">يمكنك إصدار فاتورة جديدة بالضغط على الزر أعلاه.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($invoices->hasPages())
            <div style="padding: 16px 22px; border-top: 1px solid var(--border-subtle); background: #fafcfb;">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
