@extends('layouts.admin')

@section('title', 'إضافة مشروع جديد | OX Tech')
@section('header_title', 'إضافة مشروع جديد')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">بيانات المشروع وتفاصيل العرض</div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline btn-sm">رجوع للمشاريع</a>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
            <!-- Basic Details -->
            <div>
                <label class="form-label">اسم المشروع * (العنوان الرئيسي)</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="مثال: مِرسال" required>
            </div>

            <div>
                <label class="form-label">الوصف الفرعي بالكارت (Subtitle)</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}" placeholder="مثال: واجهة تجارة مرنة">
            </div>

            <div>
                <label class="form-label">الرابط المخصص (Slug / URL)</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="mersal-ecommerce (يترك فارغاً للتوليد التلقائي)">
            </div>

            <div>
                <label class="form-label">رقم الترتيب أو الشارة (Badge)</label>
                <input type="text" name="number_badge" class="form-control" value="{{ old('number_badge', '01') }}" placeholder="مثال: 01 أو 02">
            </div>

            <!-- Country & Sector -->
            <div>
                <label class="form-label">رمز الدولة (Country Code) *</label>
                <select name="country_code" class="form-control" id="country_code" required onchange="updateCountryName(this)">
                    <option value="sa" data-name="السعودية" {{ old('country_code') == 'sa' ? 'selected' : '' }}>السعودية (sa)</option>
                    <option value="ae" data-name="الإمارات" {{ old('country_code') == 'ae' ? 'selected' : '' }}>الإمارات (ae)</option>
                    <option value="eg" data-name="مصر" {{ old('country_code') == 'eg' ? 'selected' : '' }}>مصر (eg)</option>
                    <option value="jo" data-name="الأردن" {{ old('country_code') == 'jo' ? 'selected' : '' }}>الأردن (jo)</option>
                    <option value="de" data-name="ألمانيا" {{ old('country_code') == 'de' ? 'selected' : '' }}>ألمانيا (de)</option>
                    <option value="se" data-name="السويد" {{ old('country_code') == 'se' ? 'selected' : '' }}>السويد (se)</option>
                    <option value="ru" data-name="روسيا" {{ old('country_code') == 'ru' ? 'selected' : '' }}>روسيا (ru)</option>
                    <option value="iq" data-name="العراق" {{ old('country_code') == 'iq' ? 'selected' : '' }}>العراق (iq)</option>
                </select>
                <input type="hidden" name="country_name" id="country_name" value="{{ old('country_name', 'السعودية') }}">
            </div>

            <div>
                <label class="form-label">رمز التخصص (Sector Slug) *</label>
                <select name="sector_slug" class="form-control" id="sector_slug" required onchange="updateSectorName(this)">
                    <option value="commerce" data-name="تجارة إلكترونية" {{ old('sector_slug') == 'commerce' ? 'selected' : '' }}>تجارة إلكترونية (commerce)</option>
                    <option value="auto" data-name="سيارات" {{ old('sector_slug') == 'auto' ? 'selected' : '' }}>سيارات (auto)</option>
                    <option value="health" data-name="طبي" {{ old('sector_slug') == 'health' ? 'selected' : '' }}>طبي (health)</option>
                    <option value="marine" data-name="نقل بحري" {{ old('sector_slug') == 'marine' ? 'selected' : '' }}>نقل بحري (marine)</option>
                </select>
                <input type="hidden" name="sector_name" id="sector_name" value="{{ old('sector_name', 'تجارة إلكترونية') }}">
            </div>

            <!-- Gradient Theme -->
            <div>
                <label class="form-label">تدرج وألوان الكارت البصري (Gradient Theme) *</label>
                <select name="gradient_class" class="form-control" required>
                    <option value="store">Store (أخضر زيتي وكحلي)</option>
                    <option value="auto-v">Auto-V (برتقالي ناري وبنفسجي داكن)</option>
                    <option value="health-v">Health-V (بنفسجي وأزرق غامق)</option>
                    <option value="marine-v">Marine-V (أزرق بحري عميق)</option>
                    <option value="jordan-v">Jordan-V (نحاسي وعنابي)</option>
                    <option value="sweden-v">Sweden-V (سماوي وكحلي بارد)</option>
                    <option value="russia-v">Russia-V (أرجواني غامق)</option>
                    <option value="iraq-v">Iraq-V (برونزي وبترولي)</option>
                </select>
            </div>

            <!-- Project Details Specifics -->
            <div>
                <label class="form-label">مدة التنفيذ (Duration)</label>
                <input type="text" name="duration" class="form-control" value="{{ old('duration') }}" placeholder="مثال: 3 أشهر / 8 أسابيع">
            </div>

            <div>
                <label class="form-label">تاريخ العمل / الإنجاز (تاريخ التسليم)</label>
                <input type="text" name="delivery_date" class="form-control" value="{{ old('delivery_date') }}" placeholder="مثال: مارس 2024 / الربع الأول 2024">
            </div>

            <div>
                <label class="form-label">رابط المشروع الحي للمعاينة (Live URL)</label>
                <input type="url" name="live_url" class="form-control" value="{{ old('live_url') }}" placeholder="https://example.com">
            </div>

            <div>
                <label class="form-label">اسم العميل / الشريك (Client Name)</label>
                <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" placeholder="مثال: شركة مِرسال للتجارة">
            </div>

            <div>
                <label class="form-label">رقم الأثر المحقق (Impact Metric)</label>
                <input type="text" name="impact_stat" class="form-control" value="{{ old('impact_stat') }}" placeholder="مثال: +38% في معدل إتمام الطلب">
            </div>

            <div>
                <label class="form-label">صورة المشروع الرئيسية (Hero Image)</label>
                <input type="file" name="hero_image" class="form-control" accept="image/*">
            </div>

            <div>
                <label class="form-label">ترتيب العرض</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', 1) }}">
            </div>
        </div>

        <!-- Text Areas -->
        <div style="margin-top: 20px;">
            <div style="margin-bottom: 16px;">
                <label class="form-label">الوصف المختصر (يظهر في كارت الصفحة الرئيسية)</label>
                <input type="text" name="short_description" class="form-control" value="{{ old('short_description') }}" placeholder="مثال: منصة بيع محلية، أسرع من قرار الشراء.">
            </div>

            <div style="margin-bottom: 16px;">
                <label class="form-label">تفاصيل وملخص المشروع (Summary)</label>
                <textarea name="summary" rows="3" class="form-control" placeholder="اكتب نبذة كاملة عن فكرة المشروع والهدف منه...">{{ old('summary') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label class="form-label">التحدي التشغيلي أو التقني (Challenge)</label>
                    <textarea name="challenge" rows="3" class="form-control" placeholder="ما هي التحديات التي واجهها العميل قبل المشروع؟">{{ old('challenge') }}</textarea>
                </div>
                <div>
                    <label class="form-label">الحل المنفذ من قِبل الفريق (Solution)</label>
                    <textarea name="solution" rows="3" class="form-control" placeholder="كيف حلت حلول OX Tech هذه المشاكل؟">{{ old('solution') }}</textarea>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label class="form-label">أبرز الميزات والوظائف (ميزة واحدة في كل سطر)</label>
                    <textarea name="key_features_raw" rows="4" class="form-control" placeholder="نظام شراء فوري بنقرة واحدة
ربط مباشر مع شركات الشحن
لوحة تحكم متعددة الفروع">{{ old('key_features_raw') }}</textarea>
                    <div class="form-hint">افصل بين كل ميزة بسطر جديد.</div>
                </div>

                <div>
                    <label class="form-label">التقنيات المستخدمة (Tech Stack)</label>
                    <textarea name="technologies_raw" rows="4" class="form-control" placeholder="Laravel, Vue.js, Tailwind CSS, Redis, MySQL">{{ old('technologies_raw') }}</textarea>
                    <div class="form-hint">افصل بين التقنيات بفاصلة (,) أو سطر جديد.</div>
                </div>
            </div>

            <!-- Flags -->
            <div style="display: flex; gap: 24px; align-items: center; margin: 25px 0;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_big" value="1" {{ old('is_big') ? 'checked' : '' }}>
                    <span style="font-size: 12.5px; font-weight: 600; color: var(--text-heading);">عرض ككارت مزدوج عريض (Big Card)</span>
                </label>

                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', 1) ? 'checked' : '' }}>
                    <span style="font-size: 12.5px; font-weight: 600; color: var(--text-heading);">تفعيل وظهور في الصفحة الرئيسية</span>
                </label>
            </div>

            <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
                <span>حفظ ونشر المشروع</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('admin-scripts')
<script>
    function updateCountryName(select) {
        const selected = select.options[select.selectedIndex];
        document.getElementById('country_name').value = selected.getAttribute('data-name');
    }
    function updateSectorName(select) {
        const selected = select.options[select.selectedIndex];
        document.getElementById('sector_name').value = selected.getAttribute('data-name');
    }
</script>
@endpush
