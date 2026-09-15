@extends('layouts.admin')

@section('title', 'الفواتير والمطالبات المالية | OX Tech CRM')
@section('header_title', 'إدارة الفواتير والمستحقات والتحصيلات')

@section('content')
<div>

    <!-- Financial KPIs Header Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 18px; margin-bottom: 24px;">
        <div class="card" style="margin-bottom: 0; border-right: 4px solid var(--brand-blue);">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">إجمالي الفواتير الصادرة</div>
            <div style="font-size: 24px; font-weight: 800; color: var(--text-heading); font-family: var(--font-code);">{{ number_format($totalInvoiced, 2) }} SAR</div>
        </div>

        <div class="card" style="margin-bottom: 0; border-right: 4px solid #10b981;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">إجمالي المبالغ المسددة</div>
            <div style="font-size: 24px; font-weight: 800; color: #047857; font-family: var(--font-code);">{{ number_format($totalCollected, 2) }} SAR</div>
        </div>

        <div class="card" style="margin-bottom: 0; border-right: 4px solid #ef4444;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">المتبقي الآجل المطلوب تحصيله (Due)</div>
            <div style="font-size: 24px; font-weight: 800; color: #b91c1c; font-family: var(--font-code);">{{ number_format($totalDue, 2) }} SAR</div>
        </div>

        <div class="card" style="margin-bottom: 0; border-right: 4px solid #f59e0b;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">فواتير متأخرة أو بحاجة متابعة</div>
            <div style="font-size: 24px; font-weight: 800; color: #b45309; font-family: var(--font-code);">{{ $overdueCount }} <span style="font-size: 13px; font-weight: 600;">فاتورة</span></div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="card">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 15px;">
            <form method="GET" action="{{ route('admin.crm.invoices.index') }}" style="display: flex; flex-wrap: wrap; gap: 10px; flex: 1;">
                <input type="text" name="search" class="form-control" style="max-width: 250px;" placeholder="رقم الفاتورة، العميل، المشروع..." value="{{ request('search') }}">
                
                <select name="status" class="form-control" style="max-width: 160px;">
                    <option value="">جميع الحالات</option>
                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>بانتظار السداد</option>
                    <option value="partially_paid" {{ request('status') === 'partially_paid' ? 'selected' : '' }}>مدفوعة جزئياً</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>مدفوعة بالكامل</option>
                    <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>متأخرة السداد</option>
                </select>

                <button type="submit" class="btn btn-outline">بحث</button>
            </form>

            <a href="{{ route('admin.crm.invoices.create') }}" class="btn btn-lime">
                <span>إصدار فاتورة جديدة</span>
            </a>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>العميل</th>
                        <th>عنوان الفاتورة</th>
                        <th>تاريخ الإصدار</th>
                        <th>تاريخ الاستحقاق</th>
                        <th>إجمالي الفاتورة</th>
                        <th>المسدد</th>
                        <th>المتبقي الآجل (Due)</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td><strong style="color: var(--text-heading); font-family: var(--font-code);">{{ $invoice->invoice_number }}</strong></td>
                            <td>
                                <div>
                                    <a href="{{ route('admin.crm.clients.show', $invoice->client) }}" class="truncate-text sm" title="{{ $invoice->client->name }}" style="color: var(--brand-forest); font-weight: 700; text-decoration: none;">{{ $invoice->client->name }}</a>
                                    @if($invoice->client->company_name)
                                        <div class="truncate-text sm" title="{{ $invoice->client->company_name }}" style="font-size: 11px; color: var(--text-muted);">{{ $invoice->client->company_name }}</div>
                                    @endif
                                </div>
                            </td>
                            <td><strong class="truncate-text md" title="{{ $invoice->title }}" style="color: var(--text-body);">{{ $invoice->title }}</strong></td>
                            <td style="color: var(--text-muted); font-size: 12px;">{{ $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : ($invoice->created_at ? $invoice->created_at->format('Y-m-d') : '—') }}</td>
                            <td>
                                @if($invoice->due_date)
                                    <span style="{{ ($invoice->due_amount > 0 && $invoice->due_date < now()) ? 'color: #b91c1c; font-weight: 700;' : 'color: var(--text-muted);' }}">
                                        {{ $invoice->due_date->format('Y-m-d') }}
                                    </span>
                                @else
                                    <span style="color: var(--text-muted);">فوري</span>
                                @endif
                            </td>
                            <td style="font-weight: 700; color: var(--text-heading); font-family: var(--font-code);">{{ number_format($invoice->total_amount, 2) }} {{ $invoice->currency }}</td>
                            <td style="font-family: var(--font-code); color: #047857; font-weight: 700;">{{ number_format($invoice->paid_amount, 2) }} {{ $invoice->currency }}</td>
                            <td>
                                @if($invoice->due_amount > 0)
                                    <span style="font-weight: 800; color: #b91c1c; font-family: var(--font-code); background: #fef2f2; padding: 4px 8px; border-radius: 6px; border: 1px solid #fee2e2;">
                                        {{ number_format($invoice->due_amount, 2) }} {{ $invoice->currency }}
                                    </span>
                                @else
                                    <span style="color: #047857; font-size: 11.5px; font-weight: 600;">خالص 0.00</span>
                                @endif
                            </td>
                            <td>
                                @if($invoice->status === 'paid')
                                    <span class="status-badge" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">مدفوعة بالكامل</span>
                                @elseif($invoice->status === 'partially_paid')
                                    <span class="status-badge" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">مدفوعة جزئياً</span>
                                @elseif($invoice->status === 'overdue')
                                    <span class="status-badge" style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">متأخرة السداد</span>
                                @else
                                    <span class="status-badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe;">بانتظار السداد</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('admin.crm.invoices.show', $invoice) }}" class="btn btn-outline btn-sm">تفاصيل</a>
                                    <a href="{{ route('admin.crm.invoices.edit', $invoice) }}" class="btn btn-outline btn-sm">تعديل</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; color: var(--text-muted); padding: 35px;">لا توجد فواتير مسجلة حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $invoices->links() }}
        </div>
    </div>

</div>
@endsection
