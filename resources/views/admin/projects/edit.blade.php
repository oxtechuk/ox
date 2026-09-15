@extends('layouts.admin')

@section('title', 'تعديل مشروع: ' . $project->title . ' | OX Tech')
@section('header_title', 'تعديل المشروع: ' . $project->title)

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">تعديل بيانات المشروع: {{ $project->title }}</div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="btn btn-outline btn-sm">معاينة في الموقع</a>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline btn-sm">رجوع للمشاريع</a>
        </div>
    </div>

    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <!-- Basic Details -->
            <div>
                <label class="form-label">اسم المشروع * (العنوان الرئيسي)</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
            </div>

            <div>
                <label class="form-label">الوصف الفرعي بالكارت (Subtitle)</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $project->subtitle) }}">
            </div>

            <div>
                <label class="form-label">الرابط المخصص (Slug / URL)</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $project->slug) }}">
            </div>

            <div>
                <label class="form-label">رقم الترتيب أو الشارة (Badge)</label>
                <input type="text" name="number_badge" class="form-control" value="{{ old('number_badge', $project->number_badge) }}">
            </div>

            <!-- Country & Sector -->
            <div>
                <label class="form-label">رمز الدولة (Country Code) *</label>
                <select name="country_code" class="form-control" id="country_code" required onchange="updateCountryName(this)">
                    <option value="sa" data-name="السعودية" {{ old('country_code', $project->country_code) == 'sa' ? 'selected' : '' }}>السعودية (sa)</option>
                    <option value="ae" data-name="الإمارات" {{ old('country_code', $project->country_code) == 'ae' ? 'selected' : '' }}>الإمارات (ae)</option>
                    <option value="eg" data-name="مصر" {{ old('country_code', $project->country_code) == 'eg' ? 'selected' : '' }}>مصر (eg)</option>
                    <option value="jo" data-name="الأردن" {{ old('country_code', $project->country_code) == 'jo' ? 'selected' : '' }}>الأردن (jo)</option>
                    <option value="de" data-name="ألمانيا" {{ old('country_code', $project->country_code) == 'de' ? 'selected' : '' }}>ألمانيا (de)</option>
                    <option value="se" data-name="السويد" {{ old('country_code', $project->country_code) == 'se' ? 'selected' : '' }}>السويد (se)</option>
                    <option value="ru" data-name="روسيا" {{ old('country_code', $project->country_code) == 'ru' ? 'selected' : '' }}>روسيا (ru)</option>
                    <option value="iq" data-name="العراق" {{ old('country_code', $project->country_code) == 'iq' ? 'selected' : '' }}>العراق (iq)</option>
                </select>
                <input type="hidden" name="country_name" id="country_name" value="{{ old('country_name', $project->country_name) }}">
            </div>

            <div>
                <label class="form-label">رمز التخصص (Sector Slug) *</label>
                <select name="sector_slug" class="form-control" id="sector_slug" required onchange="updateSectorName(this)">
                    <option value="commerce" data-name="تجارة إلكترونية" {{ old('sector_slug', $project->sector_slug) == 'commerce' ? 'selected' : '' }}>تجارة إلكترونية (commerce)</option>
                    <option value="auto" data-name="سيارات" {{ old('sector_slug', $project->sector_slug) == 'auto' ? 'selected' : '' }}>سيارات (auto)</option>
                    <option value="health" data-name="طبي" {{ old('sector_slug', $project->sector_slug) == 'health' ? 'selected' : '' }}>طبي (health)</option>
                    <option value="marine" data-name="نقل بحري" {{ old('sector_slug', $project->sector_slug) == 'marine' ? 'selected' : '' }}>نقل بحري (marine)</option>
                </select>
                <input type="hidden" name="sector_name" id="sector_name" value="{{ old('sector_name', $project->sector_name) }}">
            </div>

            <!-- Gradient Theme -->
            <div>
                <label class="form-label">تدرج وألوان الكارت البصري (Gradient Theme) *</label>
                <select name="gradient_class" class="form-control" required>
                    <option value="store" {{ old('gradient_class', $project->gradient_class) == 'store' ? 'selected' : '' }}>Store (أخضر زيتي وكحلي)</option>
                    <option value="auto-v" {{ old('gradient_class', $project->gradient_class) == 'auto-v' ? 'selected' : '' }}>Auto-V (برتقالي ناري وبنفسجي داكن)</option>
                    <option value="health-v" {{ old('gradient_class', $project->gradient_class) == 'health-v' ? 'selected' : '' }}>Health-V (بنفسجي وأزرق غامق)</option>
                    <option value="marine-v" {{ old('gradient_class', $project->gradient_class) == 'marine-v' ? 'selected' : '' }}>Marine-V (أزرق بحري عميق)</option>
                    <option value="jordan-v" {{ old('gradient_class', $project->gradient_class) == 'jordan-v' ? 'selected' : '' }}>Jordan-V (نحاسي وعنابي)</option>
                    <option value="sweden-v" {{ old('gradient_class', $project->gradient_class) == 'sweden-v' ? 'selected' : '' }}>Sweden-V (سماوي وكحلي بارد)</option>
                    <option value="russia-v" {{ old('gradient_class', $project->gradient_class) == 'russia-v' ? 'selected' : '' }}>Russia-V (أرجواني غامق)</option>
                    <option value="iraq-v" {{ old('gradient_class', $project->gradient_class) == 'iraq-v' ? 'selected' : '' }}>Iraq-V (برونزي وبترولي)</option>
                </select>
            </div>

            <!-- Project Details Specifics -->
            <div>
                <label class="form-label">مدة التنفيذ (Duration)</label>
                <input type="text" name="duration" class="form-control" value="{{ old('duration', $project->duration) }}">
            </div>

            <div>
                <label class="form-label">تاريخ العمل / الإنجاز (تاريخ التسليم)</label>
                <input type="text" name="delivery_date" class="form-control" value="{{ old('delivery_date', $project->delivery_date) }}">
            </div>

            <div>
                <label class="form-label">رابط المشروع الحي للمعاينة (Live URL)</label>
                <input type="url" name="live_url" class="form-control" value="{{ old('live_url', $project->live_url) }}">
            </div>

            <div>
                <label class="form-label">اسم العميل / الشريك (Client Name)</label>
                <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $project->client_name) }}">
            </div>

            <div>
                <label class="form-label">رقم الأثر المحقق (Impact Metric)</label>
                <input type="text" name="impact_stat" class="form-control" value="{{ old('impact_stat', $project->impact_stat) }}">
            </div>

            <div>
                <label class="form-label">صورة المشروع (تغيير الصورة الحالية)</label>
                <input type="file" name="hero_image" class="form-control" accept="image/*">
                @if($project->hero_image)
                    <div style="margin-top: 8px; font-size: 11px; color: var(--text-muted);">
                        الصورة الحالية: <a href="{{ $project->display_image }}" target="_blank" style="color: var(--brand-forest); font-weight: 600;">عرض الصورة</a>
                    </div>
                @endif
            </div>

            <div>
                <label class="form-label">ترتيب العرض</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $project->order) }}">
            </div>
        </div>

        <!-- Text Areas -->
        <div style="margin-top: 20px;">
            <div style="margin-bottom: 16px;">
                <label class="form-label">الوصف المختصر (يظهر في كارت الصفحة الرئيسية)</label>
                <input type="text" name="short_description" class="form-control" value="{{ old('short_description', $project->short_description) }}">
            </div>

            <div style="margin-bottom: 16px;">
                <label class="form-label">تفاصيل وملخص المشروع (Summary)</label>
                <textarea name="summary" rows="3" class="form-control">{{ old('summary', $project->summary) }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label class="form-label">التحدي التشغيلي أو التقني (Challenge)</label>
                    <textarea name="challenge" rows="3" class="form-control">{{ old('challenge', $project->challenge) }}</textarea>
                </div>
                <div>
                    <label class="form-label">الحل المنفذ من قِبل الفريق (Solution)</label>
                    <textarea name="solution" rows="3" class="form-control">{{ old('solution', $project->solution) }}</textarea>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label class="form-label">أبرز الميزات والوظائف (ميزة واحدة في كل سطر)</label>
                    <textarea name="key_features_raw" rows="4" class="form-control">@if(!empty($project->key_features)){{ implode("\n", $project->key_features) }}@endif</textarea>
                    <div class="form-hint">افصل بين كل ميزة بسطر جديد.</div>
                </div>

                <div>
                    <label class="form-label">التقنيات المستخدمة (Tech Stack)</label>
                    <textarea name="technologies_raw" rows="4" class="form-control">@if(!empty($project->technologies)){{ implode(", ", $project->technologies) }}@endif</textarea>
                    <div class="form-hint">افصل بين التقنيات بفاصلة (,) أو سطر جديد.</div>
                </div>
            </div>

            <!-- Flags -->
            <div style="display: flex; gap: 24px; align-items: center; margin: 25px 0;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_big" value="1" {{ old('is_big', $project->is_big) ? 'checked' : '' }}>
                    <span style="font-size: 12.5px; font-weight: 600; color: var(--text-heading);">عرض ككارت مزدوج عريض (Big Card)</span>
                </label>

                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                    <span style="font-size: 12.5px; font-weight: 600; color: var(--text-heading);">تفعيل وظهور في الصفحة الرئيسية</span>
                </label>
            </div>

            <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
                <span>تحديث وحفظ التعديلات</span>
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
