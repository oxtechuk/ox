@extends('layouts.admin')

@section('title', 'تعديل نصوص وعناصر الموقع | OX Tech')
@section('header_title', 'محرر نصوص ومحتوى الموقع الديناميكي')

@section('content')
<form action="{{ route('admin.site-content.update') }}" method="POST">
    @csrf

    <!-- Hero Section Content -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">قسم الهيرو والواجهة الرئيسية (Hero Section)</div>
        </div>

        <div class="form-grid">
            <div>
                <label class="form-label">العبارة العلوية (Kicker)</label>
                <input type="text" name="hero_kicker" class="form-control" value="{{ $contents['hero']->where('key', 'hero_kicker')->first()->value ?? '' }}">
            </div>

            <div>
                <label class="form-label">العنوان الرئيسي الأول</label>
                <input type="text" name="hero_title_p1" class="form-control" value="{{ $contents['hero']->where('key', 'hero_title_p1')->first()->value ?? '' }}">
            </div>

            <div>
                <label class="form-label">الكلمة المميزة باللون الأخضر (Highlight)</label>
                <input type="text" name="hero_title_highlight" class="form-control" value="{{ $contents['hero']->where('key', 'hero_title_highlight')->first()->value ?? '' }}" style="color: var(--brand-green); font-weight: 700;">
            </div>

            <div style="grid-column: 1 / -1;">
                <label class="form-label">نص وصف الهيرو</label>
                <textarea name="hero_description" rows="2" class="form-control">{{ $contents['hero']->where('key', 'hero_description')->first()->value ?? '' }}</textarea>
            </div>

            <div>
                <label class="form-label">الإحصائية 1 (الرقم والنص)</label>
                <input type="text" name="hero_proof_stat_1" class="form-control" value="{{ $contents['hero']->where('key', 'hero_proof_stat_1')->first()->value ?? '' }}">
            </div>

            <div>
                <label class="form-label">الإحصائية 2 (الرقم والنص)</label>
                <input type="text" name="hero_proof_stat_2" class="form-control" value="{{ $contents['hero']->where('key', 'hero_proof_stat_2')->first()->value ?? '' }}">
            </div>

            <div>
                <label class="form-label">الإحصائية 3 (الرقم والنص)</label>
                <input type="text" name="hero_proof_stat_3" class="form-control" value="{{ $contents['hero']->where('key', 'hero_proof_stat_3')->first()->value ?? '' }}">
            </div>

            <div style="grid-column: 1 / -1;">
                <label class="form-label">شريط العملاء والشركاء الموثوقين (Trust Strip - مفصولة بفاصلة)</label>
                <input type="text" name="trust_clients" class="form-control" value="{{ $contents['hero']->where('key', 'trust_clients')->first()->value ?? '' }}">
                <div class="form-hint">افصل بين أسماء الشركات بفاصلة (مثال: RASED, NEXA, مِرسال, VELA, GOBOX, بِداية)</div>
            </div>
        </div>
    </div>

    <!-- About Section Content -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">قسم قصة البداية وعن الشركة (About & Roots)</div>
        </div>

        <div style="margin-bottom: 16px;">
            <label class="form-label">عنوان قسم القصة</label>
            <input type="text" name="about_story_title" class="form-control" value="{{ $contents['about']->where('key', 'about_story_title')->first()->value ?? '' }}">
        </div>

        <div>
            <label class="form-label">نص قصة البداية والرحلة</label>
            <textarea name="about_story_p" rows="4" class="form-control">{{ $contents['about']->where('key', 'about_story_p')->first()->value ?? '' }}</textarea>
        </div>
    </div>

    <!-- Consult Section Content -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">قسم دعوة حجز الاستشارة (Consultation CTA)</div>
        </div>

        <div class="form-grid">
            <div>
                <label class="form-label">عنوان بطاقة الاستشارة</label>
                <input type="text" name="consult_title" class="form-control" value="{{ $contents['consult']->where('key', 'consult_title')->first()->value ?? '' }}">
            </div>

            <div>
                <label class="form-label">البريد الإلكتروني للتواصل</label>
                <input type="email" name="contact_email" class="form-control" value="{{ $contents['contact']->where('key', 'contact_email')->first()->value ?? 'hello@oxtech.studio' }}">
            </div>

            <div style="grid-column: 1 / -1;">
                <label class="form-label">نص وصف الاستشارة</label>
                <input type="text" name="consult_subtitle" class="form-control" value="{{ $contents['consult']->where('key', 'consult_subtitle')->first()->value ?? '' }}">
            </div>
        </div>
    </div>

    <div style="position: sticky; bottom: 20px; z-index: 100; background: rgba(255, 255, 255, 0.95); padding: 15px 25px; border-radius: 12px; border: 1px solid var(--border-card); box-shadow: 0 4px 20px rgba(0,0,0,0.06); backdrop-filter: blur(10px); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-size: 12.5px; color: var(--text-muted); font-weight: 500;">يتم تطبيق التعديلات فوراً على الموقع الحي.</span>
        <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
            <span>حفظ وتطبيق كافة التعديلات</span>
        </button>
    </div>
</form>
@endsection
