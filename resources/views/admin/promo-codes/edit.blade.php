@extends('layouts.admin')

@section('title', 'تعديل كود الخصم | OX Tech')
@section('header_title', 'تعديل كود الخصم ' . $promoCode->code)

@section('content')
<div class="admin-content-inner" style="max-width: 800px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 class="topbar-title" style="margin: 0;">✏️ تعديل كود الخصم: {{ $promoCode->code }}</h1>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">
                تعديل نسبة الخصم، تاريخ انتهاء الصلاحية، أو الحد الأقصى للاستخدام
            </p>
        </div>
        <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-outline">
            &rarr; العودة للأكواد
        </a>
    </div>

    @if($errors->any())
        <div class="alert-box alert-danger">
            <ul style="margin: 0; padding-right: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="padding: 24px;">
        <form action="{{ route('admin.promo-codes.update', $promoCode->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Code Input --}}
            <div style="margin-bottom: 22px;">
                <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                    رمز الكود الترويجي (Promo Code) <span style="color: #DC2626;">*</span>
                </label>
                <input type="text" 
                       name="code" 
                       value="{{ old('code', $promoCode->code) }}" 
                       class="form-control" 
                       placeholder="مثال: OX50" 
                       style="font-family: var(--font-code); font-weight: 800; letter-spacing: 1px; font-size: 15px; text-transform: uppercase;" 
                       required>
            </div>

            {{-- Discount Type & Value --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 22px;">
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                        نوع الخصم <span style="color: #DC2626;">*</span>
                    </label>
                    <select name="discount_type" id="discount_type_select" class="form-control" required onchange="updateDiscountLabel()">
                        <option value="percentage" {{ old('discount_type', $promoCode->discount_type) === 'percentage' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                        <option value="fixed" {{ old('discount_type', $promoCode->discount_type) === 'fixed' ? 'selected' : '' }}>مبلغ ثابت (Fixed)</option>
                    </select>
                </div>

                <div>
                    <label id="discount_value_label" style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                        {{ $promoCode->discount_type === 'percentage' ? 'نسبة الخصم (%)' : 'قيمة الخصم الثابتة' }} <span style="color: #DC2626;">*</span>
                    </label>
                    <input type="number" 
                           step="0.01" 
                           name="discount_value" 
                           id="discount_value_input" 
                           value="{{ old('discount_value', $promoCode->discount_value) }}" 
                           class="form-control" 
                           required>
                </div>
            </div>

            {{-- Validity Dates --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 22px;">
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                        تاريخ البداية (اختياري)
                    </label>
                    <input type="datetime-local" 
                           name="valid_from" 
                           value="{{ old('valid_from', $promoCode->valid_from ? $promoCode->valid_from->format('Y-m-d\TH:i') : '') }}" 
                           class="form-control">
                </div>

                <div>
                    <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                        تاريخ انتهاء الصلاحية (مدة العرض)
                    </label>
                    <input type="datetime-local" 
                           name="valid_until" 
                           value="{{ old('valid_until', $promoCode->valid_until ? $promoCode->valid_until->format('Y-m-d\TH:i') : '') }}" 
                           class="form-control">
                    <small style="color: var(--text-muted); font-size: 11px; display: block; margin-top: 4px;">اتركه فارغاً ليكون الكود دائم الصلاحية بدون انتهاء.</small>
                </div>
            </div>

            {{-- Max Uses & Product Limit --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 22px;">
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                        الحد الأقصى لمرات الاستخدام
                    </label>
                    <input type="number" 
                           name="max_uses" 
                           value="{{ old('max_uses', $promoCode->max_uses) }}" 
                           class="form-control" 
                           placeholder="مثال: 100">
                    <small style="color: var(--text-muted); font-size: 11px; display: block; margin-top: 4px;">
                        تم استخدامه حتى الآن: <strong>{{ $promoCode->used_count }}</strong> مرة.
                    </small>
                </div>

                <div>
                    <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                        تخصيص لمنتج معين (اختياري)
                    </label>
                    <select name="product_id" class="form-control">
                        <option value="">جميع المنتجات الرقمية (بدون قيود)</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}" {{ old('product_id', $promoCode->product_id) == $prod->id ? 'selected' : '' }}>
                                {{ $prod->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Description --}}
            <div style="margin-bottom: 22px;">
                <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                    وصف أو مناسبة الكود
                </label>
                <input type="text" 
                       name="description" 
                       value="{{ old('description', $promoCode->description) }}" 
                       class="form-control" 
                       placeholder="مثال: خصم 50% لعملاء برنامج ScripOx">
            </div>

            {{-- Active Checkbox --}}
            <div style="margin-bottom: 28px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $promoCode->is_active) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--brand-green);">
                    <span style="font-weight: 700; font-size: 13.5px; color: #1E293B;">الكود نشط ومفعّل لاستقبال الخصومات</span>
                </label>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-outline">إلغاء</a>
                <button type="submit" class="btn btn-lime">
                    ✓ حفظ التعديلات
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function updateDiscountLabel() {
    const type = document.getElementById('discount_type_select').value;
    const label = document.getElementById('discount_value_label');
    if (type === 'percentage') {
        label.innerHTML = 'نسبة الخصم (%) <span style="color: #DC2626;">*</span>';
    } else {
        label.innerHTML = 'قيمة الخصم الثابتة (بالدولار/الجنيه) <span style="color: #DC2626;">*</span>';
    }
}
</script>
@endsection
