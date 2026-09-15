@extends('layouts.admin')

@section('title', 'إنشاء عرض سعر جديد | OX Tech CRM')
@section('header_title', 'إنشاء عرض سعر ومقترح فني مخصص')

@section('content')
<div style="max-width: 1100px;">

    <form action="{{ route('admin.crm.quotations.store') }}" method="POST" id="quotationForm">
        @csrf

        <!-- General Info Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">بيانات العرض والمشروع</h3>
                <a href="{{ route('admin.crm.quotations.index') }}" class="btn btn-outline btn-sm">العودة للقائمة</a>
            </div>

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">العميل المستهدف *</label>
                    <select name="client_id" class="form-control" required>
                        <option value="">-- اختر العميل --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ (old('client_id', $selectedClientId) == $client->id) ? 'selected' : '' }}>
                                {{ $client->name }} {{ $client->company_name ? '('.$client->company_name.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">عنوان العرض / اسم المشروع *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="مثال: تطوير منصة لوجستية سحابية وتطبيق جوال" required>
                </div>
            </div>

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">تاريخ الإصدار *</label>
                    <input type="date" name="quotation_date" class="form-control" value="{{ old('quotation_date', date('Y-m-d')) }}" required>
                </div>
                <div>
                    <label class="form-label">صالح حتى تاريخ</label>
                    <input type="date" name="valid_until" class="form-control" value="{{ old('valid_until', date('Y-m-d', strtotime('+30 days'))) }}">
                </div>
                <div>
                    <label class="form-label">العملة *</label>
                    <select name="currency" class="form-control" id="currencySelect">
                        <option value="SAR" {{ old('currency') === 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                        <option value="AED" {{ old('currency') === 'AED' ? 'selected' : '' }}>درهم إماراتي (AED)</option>
                        <option value="EGP" {{ old('currency') === 'EGP' ? 'selected' : '' }}>جنيه مصري (EGP)</option>
                        <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">حالة العرض *</label>
                    <select name="status" class="form-control">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>مسودة</option>
                        <option value="sent" {{ old('status') === 'sent' ? 'selected' : '' }}>مرسل للعميل</option>
                        <option value="accepted" {{ old('status') === 'accepted' ? 'selected' : '' }}>معتمد وموافق عليه</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Line Items Card (Services & Quotation Items) -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">بنود الخدمات والبرمجيات (Line Items)</h3>
                <button type="button" class="btn btn-lime btn-sm" onclick="addItemRow()">إضافة بند خدمة</button>
            </div>

            <div class="table-responsive">
                <table class="admin-table" id="itemsTable">
                    <thead>
                        <tr>
                            <th width="35%">الخدمة / الميزة البرمجية *</th>
                            <th width="30%">تفاصيل ومواصفات البند</th>
                            <th width="12%">الكمية *</th>
                            <th width="15%">سعر الوحدة *</th>
                            <th width="8%">حذف</th>
                        </tr>
                    </thead>
                    <tbody id="itemsContainer">
                        <tr class="item-row">
                            <td>
                                <input type="text" name="items[0][service_name]" class="form-control" placeholder="مثال: لوحة تحكم ذكية للعملاء" required>
                            </td>
                            <td>
                                <input type="text" name="items[0][description]" class="form-control" placeholder="تفاصيل تقنية اختيارية">
                            </td>
                            <td>
                                <input type="number" name="items[0][quantity]" class="form-control item-qty" value="1" min="1" step="1" oninput="calculateQuotationTotals()" required>
                            </td>
                            <td>
                                <input type="number" name="items[0][unit_price]" class="form-control item-price" value="0" min="0" step="0.01" oninput="calculateQuotationTotals()" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeItemRow(this)" title="حذف">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Financial Summary & Discounts Card -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <h3 class="card-title">الخصم وضريبة القيمة المضافة</h3>
                </div>
                <div class="form-grid" style="margin-bottom: 15px;">
                    <div>
                        <label class="form-label">نوع الخصم</label>
                        <select name="discount_type" class="form-control" id="discountType" onchange="calculateQuotationTotals()">
                            <option value="percentage">نسبة مئوية (%)</option>
                            <option value="fixed">مبلغ ثابت (Fixed Amount)</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">قيمة الخصم</label>
                        <input type="number" name="discount_value" id="discountValue" class="form-control" value="0" min="0" step="0.01" oninput="calculateQuotationTotals()">
                    </div>
                </div>

                <div>
                    <label class="form-label">نسبة ضريبة القيمة المضافة (VAT %)</label>
                    <input type="number" name="vat_rate" id="vatRate" class="form-control" value="15" min="0" max="100" step="0.01" oninput="calculateQuotationTotals()">
                </div>
            </div>

            <!-- Live Calculation Display -->
            <div class="card" style="margin-bottom: 0; background: #f8fafc; border-color: var(--border-card);">
                <div class="card-header">
                    <h3 class="card-title" style="color: var(--brand-forest);">ملخص الحساب المالي الإجمالي</h3>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px;">
                    <div style="display: flex; justify-content: space-between; color: var(--text-muted);">
                        <span>المجموع الفرعي (Subtotal):</span>
                        <strong style="color: var(--text-heading); font-family: var(--font-code);" id="displaySubtotal">0.00 SAR</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: #047857;">
                        <span>الخصم المطبق:</span>
                        <strong style="font-family: var(--font-code);" id="displayDiscount">- 0.00 SAR</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: var(--text-muted);">
                        <span>ضريبة القيمة المضافة (15%):</span>
                        <strong style="color: var(--text-heading); font-family: var(--font-code);" id="displayVat">0.00 SAR</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-top: 2px solid var(--border-card); padding-top: 12px; margin-top: 5px;">
                        <span style="font-size: 15px; font-weight: 800; color: var(--brand-forest);">الإجمالي النهائي:</span>
                        <span style="font-size: 20px; font-weight: 800; color: var(--brand-forest); font-family: var(--font-code);" id="displayTotal">0.00 SAR</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes & Terms -->
        <div class="card">
            <div class="form-grid">
                <div>
                    <label class="form-label">ملاحظات العرض الفني</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="ملاحظات توضيحية للعميل...">يشمل العرض الفني دعم فني وصيانة مجانية لمدة 3 أشهر بعد الإطلاق.</textarea>
                </div>
                <div>
                    <label class="form-label">الشروط والأحكام</label>
                    <textarea name="terms_conditions" class="form-control" rows="3" placeholder="الشروط والأحكام المالية...">الدفعات: 50% دفعة مقدمة عند التوقيع، 25% بعد تسليم النسخة التجريبية (Beta)، و 25% عند الإطلاق النهائي.</textarea>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-bottom: 30px;">
            <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
                <span>حفظ وإنشاء عرض السعر</span>
            </button>
            <a href="{{ route('admin.crm.quotations.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
    </form>

</div>

@push('admin-scripts')
<script>
    let rowIndex = 1;

    function addItemRow() {
        const container = document.getElementById('itemsContainer');
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
            <td>
                <input type="text" name="items[${rowIndex}][service_name]" class="form-control" placeholder="اسم الخدمة / البند" required>
            </td>
            <td>
                <input type="text" name="items[${rowIndex}][description]" class="form-control" placeholder="تفاصيل ومواصفات">
            </td>
            <td>
                <input type="number" name="items[${rowIndex}][quantity]" class="form-control item-qty" value="1" min="1" step="1" oninput="calculateQuotationTotals()" required>
            </td>
            <td>
                <input type="number" name="items[${rowIndex}][unit_price]" class="form-control item-price" value="0" min="0" step="0.01" oninput="calculateQuotationTotals()" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeItemRow(this)" title="حذف">حذف</button>
            </td>
        `;
        container.appendChild(tr);
        rowIndex++;
        calculateQuotationTotals();
    }

    function removeItemRow(btn) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            btn.closest('tr').remove();
            calculateQuotationTotals();
        } else {
            alert('يجب أن يحتوي عرض السعر على بند خدمة واحد على الأقل.');
        }
    }

    function calculateQuotationTotals() {
        const currency = document.getElementById('currencySelect').value;
        const rows = document.querySelectorAll('.item-row');
        let subtotal = 0;

        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            subtotal += (qty * price);
        });

        const discountType = document.getElementById('discountType').value;
        const discountVal = parseFloat(document.getElementById('discountValue').value) || 0;
        let discountAmount = 0;

        if (discountType === 'percentage') {
            discountAmount = subtotal * (discountVal / 100);
        } else {
            discountAmount = discountVal;
        }

        const discountedSubtotal = Math.max(0, subtotal - discountAmount);
        const vatRate = parseFloat(document.getElementById('vatRate').value) || 0;
        const vatAmount = discountedSubtotal * (vatRate / 100);
        const total = discountedSubtotal + vatAmount;

        document.getElementById('displaySubtotal').innerText = subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency;
        document.getElementById('displayDiscount').innerText = '- ' + discountAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency;
        document.getElementById('displayVat').innerText = vatAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency;
        document.getElementById('displayTotal').innerText = total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency;
    }

    document.addEventListener('DOMContentLoaded', calculateQuotationTotals);
</script>
@endpush
@endsection
