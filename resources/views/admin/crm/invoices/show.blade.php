@extends('layouts.admin')

@section('title', 'فاتورة رقم: ' . $invoice->invoice_number . ' | OX Tech CRM')
@section('header_title', 'تفاصيل الفاتورة وسجل السداد: ' . $invoice->invoice_number)

@section('content')
<div style="max-width: 950px; margin: 0 auto;">

    <!-- Action Toolbar -->
    <div class="card" style="margin-bottom: 20px;" id="actionToolbar">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 10px;">
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.crm.invoices.index') }}" class="btn btn-outline btn-sm">قائمة الفواتير</a>
                <a href="{{ route('admin.crm.clients.show', $invoice->client) }}" class="btn btn-outline btn-sm">ملف العميل</a>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <button type="button" class="btn btn-outline btn-sm" onclick="window.print()">طباعة / PDF</button>

                <button type="button" class="btn btn-outline btn-sm" style="color: var(--brand-blue); border-color: #cbd5e1;" onclick="document.getElementById('emailModal').style.display='flex'">
                    إرسال للعميل بالبريد
                </button>

                @if($invoice->due_amount > 0)
                    <button type="button" class="btn btn-lime btn-sm" onclick="document.getElementById('paymentModal').style.display='flex'">
                        تسجيل دفعة جديدة
                    </button>
                @endif

                <a href="{{ route('admin.crm.invoices.edit', $invoice) }}" class="btn btn-outline btn-sm">تعديل</a>

                <form action="{{ route('admin.crm.invoices.destroy', $invoice) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الفاتورة؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Printable Invoice Sheet -->
    <div class="card" style="background: #ffffff; border: 1px solid var(--border-card); padding: 40px; border-radius: 14px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);" id="printableInvoice">

        <!-- Invoice Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid var(--border-card); padding-bottom: 25px; margin-bottom: 30px;">
            <div>
                <h1 style="font-size: 28px; font-weight: 800; color: var(--brand-forest); margin: 0; font-family: var(--font-code);">
                    OX<span style="color: var(--brand-green);">.</span>TECH
                </h1>
                <p style="margin: 4px 0 0; font-size: 13px; color: var(--text-muted); font-weight: 500;">مؤسسة أوكس لتطوير البرمجيات والأنظمة الذكية</p>
                <p style="margin: 2px 0 0; font-size: 11px; color: #94a3b8;">الرقم الضريبي للمنشأة: 310000000000003</p>
            </div>

            <div style="text-align: left;">
                <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; padding: 4px 14px; border-radius: 99px; font-size: 11.5px; font-weight: 700;">
                    فاتورة ضريبية
                </span>
                <div style="font-size: 20px; font-weight: 800; color: var(--text-heading); font-family: var(--font-code); margin-top: 8px;">
                    {{ $invoice->invoice_number }}
                </div>
                <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">
                    تاريخ الإصدار: {{ $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : ($invoice->created_at ? $invoice->created_at->format('Y-m-d') : '—') }}
                </div>
                @if($invoice->due_date)
                    <div style="font-size: 12px; color: {{ ($invoice->due_amount > 0 && $invoice->due_date < now()) ? '#b91c1c' : 'var(--text-muted)' }}; font-weight: 700; margin-top: 2px;">
                        تاريخ الاستحقاق: {{ $invoice->due_date->format('Y-m-d') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Client & Project Details -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f8fafc; border: 1px solid var(--border-card); border-radius: 10px; padding: 20px; margin-bottom: 30px;">
            <div>
                <div style="font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">العميل المفوتر إليه:</div>
                <div style="font-size: 16px; font-weight: 800; color: var(--text-heading);">{{ $invoice->client->name }}</div>
                @if($invoice->client->company_name)
                    <div style="font-size: 13px; color: var(--brand-green); font-weight: 600; margin-top: 2px;">{{ $invoice->client->company_name }}</div>
                @endif
                <div style="font-size: 12px; color: var(--text-body); margin-top: 4px;">{{ $invoice->client->email }} | {{ $invoice->client->phone ?? '—' }}</div>
                @if($invoice->client->tax_number)
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">الرقم الضريبي للعميل: {{ $invoice->client->tax_number }}</div>
                @endif
            </div>

            <div>
                <div style="font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">بيان الفاتورة / المشروع:</div>
                <div style="font-size: 16px; font-weight: 800; color: var(--text-heading);">{{ $invoice->title }}</div>
                
                <div style="margin-top: 8px;">
                    @if($invoice->status === 'paid')
                        <span class="status-badge" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">مدفوعة بالكامل</span>
                    @elseif($invoice->status === 'partially_paid')
                        <span class="status-badge" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">مدفوعة جزئياً</span>
                    @elseif($invoice->status === 'overdue')
                        <span class="status-badge" style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">متأخرة السداد</span>
                    @else
                        <span class="status-badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe;">بانتظار السداد</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Financial Summary Breakdown -->
        <div style="display: flex; justify-content: flex-end; margin-bottom: 30px;">
            <div style="width: 420px; background: #f8fafc; border: 1px solid var(--border-card); border-radius: 10px; padding: 20px;">
                <div style="display: flex; justify-content: space-between; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">
                    <span>المبلغ قبل الضريبة:</span>
                    <strong style="color: var(--text-heading); font-family: var(--font-code);">{{ number_format($invoice->subtotal, 2) }} {{ $invoice->currency }}</strong>
                </div>

                @if($invoice->discount_amount > 0)
                    <div style="display: flex; justify-content: space-between; font-size: 13px; color: #059669; margin-bottom: 8px;">
                        <span>الخصم المطبق:</span>
                        <strong style="font-family: var(--font-code);">- {{ number_format($invoice->discount_amount, 2) }} {{ $invoice->currency }}</strong>
                    </div>
                @endif

                <div style="display: flex; justify-content: space-between; font-size: 13px; color: var(--text-muted); margin-bottom: 10px;">
                    <span>ضريبة القيمة المضافة ({{ $invoice->vat_rate }}%):</span>
                    <strong style="color: var(--text-heading); font-family: var(--font-code);">{{ number_format($invoice->vat_amount, 2) }} {{ $invoice->currency }}</strong>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 800; color: var(--text-heading); border-top: 1px solid #e2e8f0; padding-top: 10px; margin-bottom: 8px;">
                    <span>إجمالي الفاتورة:</span>
                    <span style="font-family: var(--font-code);">{{ number_format($invoice->total_amount, 2) }} {{ $invoice->currency }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 14px; font-weight: 700; color: #047857; margin-bottom: 10px;">
                    <span>المبلغ المسدد:</span>
                    <span style="font-family: var(--font-code);">{{ number_format($invoice->paid_amount, 2) }} {{ $invoice->currency }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 17px; font-weight: 800; color: {{ $invoice->due_amount > 0 ? '#b91c1c' : '#047857' }}; border-top: 2px solid {{ $invoice->due_amount > 0 ? '#fca5a5' : '#a7f3d0' }}; padding-top: 10px;">
                    <span>المتبقي المطلوب سداده:</span>
                    <span style="font-family: var(--font-code);">{{ number_format($invoice->due_amount, 2) }} {{ $invoice->currency }}</span>
                </div>
            </div>
        </div>

        <!-- Payments Log Table -->
        <div style="margin-bottom: 30px;">
            <h4 style="color: var(--text-heading); font-size: 14px; font-weight: 800; margin-bottom: 12px;">سجل الدفعات والتحصيلات المسجلة</h4>
            <table class="admin-table" style="background: #ffffff; border: 1px solid var(--border-card); border-radius: 8px;">
                <thead>
                    <tr>
                        <th>تاريخ السداد</th>
                        <th>طريقة الدفع</th>
                        <th>رقم الحوالة / المرجع</th>
                        <th>ملاحظات</th>
                        <th style="text-align: left;">المبلغ المسدد</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoice->payments as $payment)
                        <tr>
                            <td style="font-size: 12px; color: var(--text-muted);">{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : ($payment->created_at ? $payment->created_at->format('Y-m-d') : '—') }}</td>
                            <td>
                                <span style="background: #f1f5f9; color: var(--text-body); padding: 2px 8px; border-radius: 4px; font-size: 11px;">
                                    {{ $payment->payment_method }}
                                </span>
                            </td>
                            <td style="font-family: var(--font-code); color: var(--text-heading); font-weight: 600;">{{ $payment->transaction_reference ?? '—' }}</td>
                            <td style="font-size: 11.5px; color: var(--text-muted);">{{ $payment->notes ?? '—' }}</td>
                            <td style="text-align: left; font-weight: 700; color: #047857; font-family: var(--font-code);">
                                + {{ number_format($payment->amount, 2) }} {{ $invoice->currency }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">لم يتم تسجيل أي دفعات مالية على هذه الفاتورة حتى الآن.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Terms & Bank Details -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; font-size: 12px; color: var(--text-muted); border-top: 1px solid var(--border-subtle); padding-top: 20px;">
            <div>
                <strong style="color: var(--brand-forest); display: block; margin-bottom: 6px;">شروط السداد والحساب البنكي:</strong>
                <p style="margin: 0; line-height: 1.6; color: var(--text-body);">{{ $invoice->terms_conditions ?? 'يرجى إرسال إشعار التحويل بعد إتمام عملية الدفع.' }}</p>
            </div>
            <div>
                <strong style="color: var(--brand-forest); display: block; margin-bottom: 6px;">ملاحظات إضافية:</strong>
                <p style="margin: 0; line-height: 1.6; color: var(--text-body);">{{ $invoice->notes ?? 'فاتورة رسمية صادرة إلكترونياً.' }}</p>
            </div>
        </div>

    </div>

</div>

<!-- Add Payment Modal -->
<div id="paymentModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; border: 1px solid var(--border-card); border-radius: 12px; max-width: 500px; width: 100%; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <h3 style="color: var(--text-heading); margin-bottom: 15px; font-size: 16px; font-weight: 800;">تسجيل دفعة مالية جديدة</h3>
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 15px;">
            المبلغ المتبقي المطلوب سداده: <strong style="color: #b91c1c; font-family: var(--font-code);">{{ number_format($invoice->due_amount, 2) }} {{ $invoice->currency }}</strong>
        </p>

        <form action="{{ route('admin.crm.invoices.payments.store', $invoice) }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label class="form-label">المبلغ المسدد *</label>
                <input type="number" name="amount" class="form-control" value="{{ $invoice->due_amount }}" max="{{ $invoice->due_amount }}" min="0.01" step="0.01" required>
            </div>

            <div class="form-grid" style="margin-bottom: 15px;">
                <div>
                    <label class="form-label">تاريخ السداد *</label>
                    <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div>
                    <label class="form-label">طريقة الدفع *</label>
                    <select name="payment_method" class="form-control">
                        <option value="bank_transfer">تحويل بنكي</option>
                        <option value="mada">مدى (Mada)</option>
                        <option value="visa_mastercard">فيزا / ماستركارد</option>
                        <option value="cash">نقداً</option>
                        <option value="cheque">شيك مصرفي</option>
                        <option value="other">أخرى</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label class="form-label">رقم الحوالة / المرجع البنكي (Ref No.)</label>
                <input type="text" name="transaction_reference" class="form-control" placeholder="مثال: TR-98765432">
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label">ملاحظات الدفعة</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="أي ملاحظات حول التحويل..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('paymentModal').style.display='none'">إلغاء</button>
                <button type="submit" class="btn btn-lime btn-sm">حفظ وتسجيل الدفعة</button>
            </div>
        </form>
    </div>
</div>

<!-- Email Modal -->
<div id="emailModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; border: 1px solid var(--border-card); border-radius: 12px; max-width: 500px; width: 100%; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <h3 style="color: var(--text-heading); margin-bottom: 15px; font-size: 16px; font-weight: 800;">إرسال الفاتورة إلى العميل</h3>
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 15px;">
            سيتم إرسال الفاتورة وتفاصيل الاستحقاق إلى: <strong style="color: var(--brand-forest);">{{ $invoice->client->email }}</strong>
        </p>

        <form action="{{ route('admin.crm.invoices.send_email', $invoice) }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label class="form-label">رسالة مخصصة (اختياري)</label>
                <textarea name="custom_message" class="form-control" rows="3" placeholder="مرحباً، مرفق إليكم الفاتورة ومطالبة الدفعة الخاصة بمشروع..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('emailModal').style.display='none'">إلغاء</button>
                <button type="submit" class="btn btn-lime btn-sm">إرسال الفاتورة الآن</button>
            </div>
        </form>
    </div>
</div>

<style>
@media print {
    body {
        background: #fff !important;
        color: #000 !important;
    }
    .admin-sidebar, .admin-topbar, #actionToolbar, .alert-box {
        display: none !important;
    }
    .admin-main {
        margin: 0 !important;
        padding: 0 !important;
    }
    #printableInvoice {
        background: #fff !important;
        color: #000 !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
    #printableInvoice * {
        color: #000 !important;
    }
}
</style>
@endsection
