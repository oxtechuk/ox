@extends('layouts.admin')

@section('title', 'ملف العميل: ' . $client->name . ' | OX Tech CRM')
@section('header_title', 'ملف العميل وسجل المعاملات والمديونيات')

@section('content')
<div style="max-width: 1200px;">

    <!-- Top Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('admin.crm.clients.index') }}" class="btn btn-outline btn-sm">العودة للعملاء</a>
            <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin: 0;">{{ $client->name }}</h2>
            @if($client->company_name)
                <span style="background: #eaf3ef; color: var(--brand-green); padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; border: 1px solid #c8e4d8;">{{ $client->company_name }}</span>
            @endif
        </div>

        <div style="display: flex; gap: 8px;">
            <a href="{{ route('admin.crm.quotations.create', ['client_id' => $client->id]) }}" class="btn btn-lime btn-sm">
                <span>عرض سعر جديد</span>
            </a>
            <a href="{{ route('admin.crm.invoices.create', ['client_id' => $client->id]) }}" class="btn btn-outline btn-sm">
                <span>إصدار فاتورة</span>
            </a>
            <a href="{{ route('admin.crm.clients.edit', $client) }}" class="btn btn-outline btn-sm">تعديل</a>
        </div>
    </div>

    <!-- Financial Account Statement Banner -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; margin-bottom: 24px;">
        <div class="card" style="margin-bottom: 0;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px; font-weight: 600;">إجمالي المبيعات المفوترة</div>
            <div style="font-size: 22px; font-weight: 800; color: var(--text-heading); font-family: var(--font-code);">{{ number_format($client->total_billed, 2) }} SAR</div>
        </div>

        <div class="card" style="margin-bottom: 0;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px; font-weight: 600;">إجمالي المدفوع والمحصل</div>
            <div style="font-size: 22px; font-weight: 800; color: #047857; font-family: var(--font-code);">{{ number_format($client->total_paid, 2) }} SAR</div>
        </div>

        <div class="card" style="margin-bottom: 0; border: 1px solid {{ $client->outstanding_balance > 0 ? '#fecaca' : 'var(--border-card)' }}; background: {{ $client->outstanding_balance > 0 ? '#fff5f5' : '#ffffff' }};">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px; font-weight: 600;">الرصيد المستحق الآجل (Outstanding Due)</div>
            @if($client->outstanding_balance > 0)
                <div style="font-size: 22px; font-weight: 800; color: #b91c1c; font-family: var(--font-code);">
                    {{ number_format($client->outstanding_balance, 2) }} SAR
                    <span style="font-size: 11px; font-weight: 700; background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 4px; vertical-align: middle;">مستحق الدفع</span>
                </div>
            @else
                <div style="font-size: 22px; font-weight: 800; color: #047857; font-family: var(--font-code);">0.00 SAR (خالص)</div>
            @endif
        </div>

        <div class="card" style="margin-bottom: 0;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px; font-weight: 600;">الحالة ومصدر العميل</div>
            <div style="font-size: 13px; font-weight: 700; color: var(--text-heading); margin-top: 4px;">
                <span class="status-badge" style="background: #eaf3ef; color: var(--brand-green);">{{ strtoupper($client->status) }}</span>
                <span style="font-size: 11px; color: var(--text-muted); margin-right: 6px;">{{ $client->lead_source ?? 'Direct' }}</span>
            </div>
        </div>
    </div>

    <!-- Client Dossier Details Grid -->
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 24px;">
        <!-- Contact & General Info -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title">بيانات الاتصال والمعلومات</h3>
            </div>
            <div style="font-size: 12.5px; display: flex; flex-direction: column; gap: 12px;">
                <div>
                    <span style="color: var(--text-muted); display: block; margin-bottom: 2px; font-size: 11px;">البريد الإلكتروني:</span>
                    <a href="mailto:{{ $client->email }}" style="color: var(--brand-blue); text-decoration: none; font-weight: 600;">{{ $client->email }}</a>
                </div>
                <div>
                    <span style="color: var(--text-muted); display: block; margin-bottom: 2px; font-size: 11px;">رقم الجوال:</span>
                    <a href="tel:{{ $client->phone }}" style="color: var(--brand-forest); text-decoration: none; font-weight: 600;">{{ $client->phone ?? '—' }}</a>
                </div>
                <div>
                    <span style="color: var(--text-muted); display: block; margin-bottom: 2px; font-size: 11px;">الرقم الضريبي:</span>
                    <span style="color: var(--text-heading); font-family: var(--font-code); font-weight: 600;">{{ $client->tax_number ?? 'غير مسجل' }}</span>
                </div>
                <div>
                    <span style="color: var(--text-muted); display: block; margin-bottom: 2px; font-size: 11px;">الموقع الجغرافي:</span>
                    <span style="color: var(--text-body); font-weight: 600;">{{ $client->country ?? 'السعودية' }} - {{ $client->city ?? 'الرياض' }}</span>
                    @if($client->address) <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">{{ $client->address }}</div> @endif
                </div>
                @if($client->notes)
                    <div style="background: #f8fafc; padding: 12px; border-radius: 6px; border-right: 3px solid var(--brand-green);">
                        <span style="color: var(--brand-green); font-size: 11px; font-weight: 700; display: block; margin-bottom: 4px;">ملاحظات خاصة:</span>
                        <p style="color: var(--text-body); font-size: 11.5px; line-height: 1.6; margin: 0;">{{ $client->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Invoices List -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title">سجل الفواتير والمطالبات المالية</h3>
                <a href="{{ route('admin.crm.invoices.create', ['client_id' => $client->id]) }}" class="btn btn-lime btn-sm">إضافة فاتورة</a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>المشروع / العنوان</th>
                            <th>الإجمالي</th>
                            <th>المسدد</th>
                            <th>المتبقي</th>
                            <th>الحالة</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($client->invoices as $invoice)
                            <tr>
                                <td><strong style="color: var(--text-heading); font-family: var(--font-code);">{{ $invoice->invoice_number }}</strong></td>
                                <td>{{ Str::limit($invoice->title, 25) }}</td>
                                <td style="font-family: var(--font-code); font-weight: 700; color: var(--text-heading);">{{ number_format($invoice->total_amount, 2) }}</td>
                                <td style="font-family: var(--font-code); color: #047857; font-weight: 600;">{{ number_format($invoice->paid_amount, 2) }}</td>
                                <td>
                                    @if($invoice->due_amount > 0)
                                        <span style="font-family: var(--font-code); font-weight: 700; color: #b91c1c;">{{ number_format($invoice->due_amount, 2) }}</span>
                                    @else
                                        <span style="color: #047857; font-size: 11px;">خالص</span>
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->status === 'paid')
                                        <span class="status-badge" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">مسددة</span>
                                    @elseif($invoice->status === 'partially_paid')
                                        <span class="status-badge" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">جزئي</span>
                                    @elseif($invoice->status === 'overdue')
                                        <span class="status-badge" style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">متأخرة</span>
                                    @else
                                        <span class="status-badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe;">بانتظار السداد</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.crm.invoices.show', $invoice) }}" class="btn btn-outline btn-sm">عرض</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 20px;">لا توجد فواتير منشأة لهذا العميل بعد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quotations History -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">سجل عروض الأسعار (Quotations History)</h3>
            <a href="{{ route('admin.crm.quotations.create', ['client_id' => $client->id]) }}" class="btn btn-lime btn-sm">عرض سعر جديد</a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>رقم العرض</th>
                        <th>عنوان العرض / المشروع</th>
                        <th>تاريخ العرض</th>
                        <th>صالح حتى</th>
                        <th>المجموع قبل الخصم</th>
                        <th>الخصم</th>
                        <th>الإجمالي الشامل (VAT)</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($client->quotations as $quotation)
                        <tr>
                            <td><strong style="color: var(--brand-forest); font-family: var(--font-code);">{{ $quotation->quotation_number }}</strong></td>
                            <td>{{ $quotation->title }}</td>
                            <td style="font-size: 12px; color: var(--text-muted);">{{ $quotation->quotation_date ? $quotation->quotation_date->format('Y-m-d') : ($quotation->created_at ? $quotation->created_at->format('Y-m-d') : '—') }}</td>
                            <td style="font-size: 12px; color: var(--text-muted);">{{ $quotation->valid_until ? $quotation->valid_until->format('Y-m-d') : '—' }}</td>
                            <td style="font-family: var(--font-code);">{{ number_format($quotation->subtotal, 2) }} {{ $quotation->currency }}</td>
                            <td style="color: #047857; font-family: var(--font-code);">{{ $quotation->discount_amount > 0 ? '-' . number_format($quotation->discount_amount, 2) : '—' }}</td>
                            <td style="font-weight: 800; color: var(--text-heading); font-family: var(--font-code);">{{ number_format($quotation->total_amount, 2) }} {{ $quotation->currency }}</td>
                            <td>
                                @if($quotation->status === 'accepted')
                                    <span class="status-badge" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">معتمد / تم التعاقد</span>
                                @elseif($quotation->status === 'sent')
                                    <span class="status-badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe;">مرسل للعميل</span>
                                @elseif($quotation->status === 'declined')
                                    <span class="status-badge" style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">مرفوض</span>
                                @else
                                    <span class="status-badge" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;">مسودة</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.crm.quotations.show', $quotation) }}" class="btn btn-outline btn-sm">عرض وتفاصيل</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: var(--text-muted); padding: 25px;">لا توجد عروض أسعار سابقة لهذا العميل.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
