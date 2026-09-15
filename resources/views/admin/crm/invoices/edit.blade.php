@extends('layouts.admin')

@section('title', 'تعديل الفاتورة | OX Tech CRM')
@section('header_title', 'تعديل بيانات الفاتورة: ' . $invoice->invoice_number)

@section('content')
<div style="max-width: 950px;">

    <form action="{{ route('admin.crm.invoices.update', $invoice) }}" method="POST" id="invoiceForm">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">بيانات الفاتورة الأساسية</h3>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.crm.invoices.show', $invoice) }}" class="btn btn-outline btn-sm">عرض الفاتورة</a>
                    <a href="{{ route('admin.crm.invoices.index') }}" class="btn btn-outline btn-sm">العودة للقائمة</a>
                </div>
            </div>

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">العميل المستفيد *</label>
                    <select name="client_id" class="form-control" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} {{ $client->company_name ? '('.$client->company_name.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">عنوان الفاتورة / اسم المشروع *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $invoice->title) }}" required>
                </div>
            </div>

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">تاريخ الإصدار *</label>
                    <input type="date" name="invoice_date" class="form-control" value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label class="form-label">تاريخ الاستحقاق (Due Date)</label>
                    <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '') }}">
                </div>
                <div>
                    <label class="form-label">العملة *</label>
                    <select name="currency" class="form-control" id="invCurrency" onchange="calculateInvoiceTotals()">
                        <option value="SAR" {{ old('currency', $invoice->currency) === 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                        <option value="AED" {{ old('currency', $invoice->currency) === 'AED' ? 'selected' : '' }}>درهم إماراتي (AED)</option>
                        <option value="EGP" {{ old('currency', $invoice->currency) === 'EGP' ? 'selected' : '' }}>جنيه مصري (EGP)</option>
                        <option value="USD" {{ old('currency', $invoice->currency) === 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">حالة الفاتورة *</label>
                    <select name="status" class="form-control">
                        <option value="draft" {{ old('status', $invoice->status) === 'draft' ? 'selected' : '' }}>مسودة</option>
                        <option value="sent" {{ old('status', $invoice->status) === 'sent' ? 'selected' : '' }}>مرسلة وبانتظار السداد</option>
                        <option value="partially_paid" {{ old('status', $invoice->status) === 'partially_paid' ? 'selected' : '' }}>مدفوعة جزئياً</option>
                        <option value="paid" {{ old('status', $invoice->status) === 'paid' ? 'selected' : '' }}>مدفوعة بالكامل</option>
                        <option value="overdue" {{ old('status', $invoice->status) === 'overdue' ? 'selected' : '' }}>متأخرة السداد</option>
                        <option value="cancelled" {{ old('status', $invoice->status) === 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Financial Calculations Card -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <h3 class="card-title">المبالغ والضرائب والخصم</h3>
                </div>

                <div style="margin-bottom: 15px;">
                    <label class="form-label">المبلغ قبل الضريبة والخصم (Subtotal) *</label>
                    <input type="number" name="subtotal" id="invSubtotal" class="form-control" value="{{ old('subtotal', $invoice->subtotal) }}" min="0" step="0.01" oninput="calculateInvoiceTotals()" required>
                </div>

                <div class="form-grid" style="margin-bottom: 15px;">
                    <div>
                        <label class="form-label">نوع الخصم</label>
                        <select name="discount_type" class="form-control" id="invDiscountType" onchange="calculateInvoiceTotals()">
                            <option value="percentage" {{ $invoice->discount_type === 'percentage' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                            <option value="fixed" {{ $invoice->discount_type === 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">قيمة الخصم</label>
                        <input type="number" name="discount_value" id="invDiscountValue" class="form-control" value="{{ $invoice->discount_value }}" min="0" step="0.01" oninput="calculateInvoiceTotals()">
                    </div>
                </div>

                <div>
                    <label class="form-label">ضريبة القيمة المضافة (VAT %)</label>
                    <input type="number" name="vat_rate" id="invVatRate" class="form-control" value="{{ $invoice->vat_rate }}" min="0" max="100" step="0.01" oninput="calculateInvoiceTotals()">
                </div>
            </div>

            <!-- Live Output -->
            <div class="card" style="margin-bottom: 0; background: #f8fafc; border-color: var(--border-card);">
                <div class="card-header">
                    <h3 class="card-title" style="color: var(--brand-forest);">ملخص إجمالي الفاتورة</h3>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px;">
                    <div style="display: flex; justify-content: space-between; color: var(--text-muted);">
                        <span>المبلغ الخاضع للضريبة:</span>
                        <strong style="color: var(--text-heading); font-family: var(--font-code);" id="invDisplaySubtotal">0.00 SAR</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: #047857;">
                        <span>قيمة الخصم:</span>
                        <strong style="font-family: var(--font-code);" id="invDisplayDiscount">- 0.00 SAR</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: var(--text-muted);">
                        <span>مبلغ الضريبة:</span>
                        <strong style="color: var(--text-heading); font-family: var(--font-code);" id="invDisplayVat">0.00 SAR</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-top: 2px solid var(--border-card); padding-top: 12px; margin-top: 5px;">
                        <span style="font-size: 15px; font-weight: 800; color: var(--brand-forest);">الإجمالي المطلوب:</span>
                        <span style="font-size: 20px; font-weight: 800; color: var(--brand-forest); font-family: var(--font-code);" id="invDisplayTotal">0.00 SAR</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="form-grid">
                <div>
                    <label class="form-label">ملاحظات الفاتورة</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $invoice->notes) }}</textarea>
                </div>
                <div>
                    <label class="form-label">شروط الدفع والتحويل البنكي</label>
                    <textarea name="terms_conditions" class="form-control" rows="3">{{ old('terms_conditions', $invoice->terms_conditions) }}</textarea>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-bottom: 30px;">
            <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
                <span>حفظ التعديلات</span>
            </button>
            <a href="{{ route('admin.crm.invoices.show', $invoice) }}" class="btn btn-outline">إلغاء</a>
        </div>
    </form>

</div>

@push('admin-scripts')
<script>
    function calculateInvoiceTotals() {
        const currency = document.getElementById('invCurrency').value;
        const subtotal = parseFloat(document.getElementById('invSubtotal').value) || 0;
        const discountType = document.getElementById('invDiscountType').value;
        const discountVal = parseFloat(document.getElementById('invDiscountValue').value) || 0;

        let discountAmount = 0;
        if (discountType === 'percentage') {
            discountAmount = subtotal * (discountVal / 100);
        } else {
            discountAmount = discountVal;
        }

        const discountedSubtotal = Math.max(0, subtotal - discountAmount);
        const vatRate = parseFloat(document.getElementById('invVatRate').value) || 0;
        const vatAmount = discountedSubtotal * (vatRate / 100);
        const total = discountedSubtotal + vatAmount;

        document.getElementById('invDisplaySubtotal').innerText = subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency;
        document.getElementById('invDisplayDiscount').innerText = '- ' + discountAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency;
        document.getElementById('invDisplayVat').innerText = vatAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency;
        document.getElementById('invDisplayTotal').innerText = total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency;
    }

    document.addEventListener('DOMContentLoaded', calculateInvoiceTotals);
</script>
@endpush
@endsection
