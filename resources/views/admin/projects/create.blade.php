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
                    <option value="education" data-name="تنمية مهارات الأطفال وتجارة إلكترونية" {{ old('sector_slug') == 'education' ? 'selected' : '' }}>تعليم وتنمية مهارات (education)</option>
                    <option value="creative" data-name="تصميم رقمي وتطوير ويب" {{ old('sector_slug') == 'creative' ? 'selected' : '' }}>تصميم رقمي وتطوير ويب (creative)</option>
                    <option value="legal" data-name="خدمات واستشارات قانونية" {{ old('sector_slug') == 'legal' ? 'selected' : '' }}>خدمات قانونية (legal)</option>
                    <option value="telecom" data-name="اتصالات وخدمات رقمية" {{ old('sector_slug') == 'telecom' ? 'selected' : '' }}>اتصالات وخدمات رقمية (telecom)</option>
                    <option value="marine" data-name="توريدات بحرية وأمن صناعي" {{ old('sector_slug') == 'marine' ? 'selected' : '' }}>توريدات بحرية وأمن صناعي (marine)</option>
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
                <label class="form-label">رابط فيديو المشروع (YouTube / Vimeo / MP4)</label>
                <input type="url" name="video_url" class="form-control" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                <div class="form-hint" style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">يوتيوب أو فيميو لعرض وتشغيل الفيديو في صفحة المشروع.</div>
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
                <label class="form-label">ترتيب العرض (Order) *</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', 1) }}" placeholder="1, 2, 3..." required>
                <div class="form-hint" style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">الترتيب الرقمي (الرقم الأقل يظهر أولاً، مثال: 1 ثم 2 ثم 3).</div>
            </div>

            <!-- Multiple Screenshots Gallery -->
            <div style="grid-column: 1 / -1; background: rgba(255, 255, 255, 0.02); border: 1px dashed var(--border-color, rgba(255, 255, 255, 0.15)); border-radius: 12px; padding: 18px; margin: 10px 0;">
                <label class="form-label" style="font-weight: 700; margin-bottom: 6px; font-size: 13.5px;">📸 معرض لقطات وسكرين شوت المشروع (Project Screenshots Gallery)</label>
                <input type="file" name="gallery[]" class="form-control" multiple accept="image/*">
                <div class="form-hint" style="font-size: 11.5px; color: var(--text-muted); margin-top: 5px;">يمكنك تحديد ورفع أكثر من صورة أو سكرين شوت معاً في نفس الوقت (Multiple Select).</div>
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

            <!-- Display & Feature Settings -->
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-color, rgba(255, 255, 255, 0.08)); border-radius: 12px; padding: 20px; margin: 25px 0;">
                <div style="font-size: 14px; font-weight: 700; color: var(--text-heading); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    <span>⚙️</span>
                    <span>إعدادات التمييز والظهور (Featured & Placement)</span>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                    <!-- Featured Toggle -->
                    <label style="display: flex; align-items: flex-start; gap: 12px; padding: 14px; background: rgba(184, 255, 44, 0.05); border: 1px solid rgba(184, 255, 44, 0.25); border-radius: 10px; cursor: pointer;">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', '1') == '1' ? 'checked' : '' }} style="margin-top: 3px; accent-color: #84cc16; width: 18px; height: 18px;">
                        <div>
                            <div style="font-size: 13.5px; font-weight: 700; color: var(--text-heading); display: flex; align-items: center; gap: 6px;">
                                <span>⭐ مشروع مميز (Featured Project)</span>
                            </div>
                            <div style="font-size: 11.5px; color: var(--text-muted); line-height: 1.5; margin-top: 3px;">
                                يظهر هذا المشروع في <strong>الصفحة الرئيسية</strong> (Home Page)، ويتصدر قائمة المشاريع في <strong>صفحة أعمالنا</strong> وفق ترتيب العرض المحدد.
                            </div>
                        </div>
                    </label>

                    <!-- Big Card Toggle -->
                    <label style="display: flex; align-items: flex-start; gap: 12px; padding: 14px; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 10px; cursor: pointer;">
                        <input type="hidden" name="is_big" value="0">
                        <input type="checkbox" name="is_big" id="is_big" value="1" {{ old('is_big') ? 'checked' : '' }} style="margin-top: 3px; accent-color: #84cc16; width: 18px; height: 18px;">
                        <div>
                            <div style="font-size: 13.5px; font-weight: 700; color: var(--text-heading);">
                                <span>كارت مزدوج عريض (Big Card)</span>
                            </div>
                            <div style="font-size: 11.5px; color: var(--text-muted); line-height: 1.5; margin-top: 3px;">
                                يتم عرض المشروع بحجم كارت عريض يأخذ مساحة أكبر في شبكة المشاريع.
                            </div>
                        </div>
                    </label>
                </div>
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
