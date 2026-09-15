@extends('layouts.admin')

@section('title', 'بكسلات التتبع والتحليلات | OX Tech')
@section('header_title', 'إدارة بكسلات التتبع وروابط الحملات الإعلانية (Attribution Engine)')

@section('content')
<div style="max-width: 1100px;">

    <!-- Intro Card -->
    <div class="card" style="background: #ffffff; border-right: 4px solid var(--brand-forest);">
        <div>
            <h3 style="color: var(--text-heading); font-size: 16px; font-weight: 800; margin-bottom: 6px;">محرك الربط والتتبع الذكي للزيارات والاستشارات (Lead Attribution)</h3>
            <p style="color: var(--text-muted); font-size: 12.5px; line-height: 1.6; margin: 0;">
                يقوم هذا النظام بربط وتضمين بكسلات تتبع الحملات الإعلانية تلقائياً في كافة صفحات الموقع، مع التقاط مصدر كل عميل (سناب شات، تيك توك، ميتا، جوجل) عند إرسال طلب استشارة أو حجز موعد وربطه بسجل CRM والتقارير.
            </p>
        </div>
    </div>

    <!-- Tracking Form -->
    <form action="{{ route('admin.tracking.update') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 24px;">

            <!-- Meta Pixel -->
            @php $meta = $pixels['meta'] ?? null; @endphp
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <h4 class="card-title">Meta Pixel (Facebook & Instagram)</h4>
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 12px; color: var(--brand-green); font-weight: 700;">
                        <input type="checkbox" name="pixels[meta][is_active]" value="1" {{ ($meta && $meta->is_active) ? 'checked' : '' }}>
                        <span>تفعيل البكسل</span>
                    </label>
                </div>
                <div>
                    <label class="form-label">معرف البكسل (Pixel ID)</label>
                    <input type="text" name="pixels[meta][pixel_id]" class="form-control" value="{{ $meta->pixel_id ?? '' }}" placeholder="e.g. 123456789012345">
                    <p class="form-hint">يتم تضمين كود التتبع القياسي لـ Meta تلقائياً فور إدخال المعرف.</p>
                </div>
            </div>

            <!-- Snapchat Pixel -->
            @php $snap = $pixels['snapchat'] ?? null; @endphp
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <h4 class="card-title">Snapchat Pixel</h4>
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 12px; color: var(--brand-green); font-weight: 700;">
                        <input type="checkbox" name="pixels[snapchat][is_active]" value="1" {{ ($snap && $snap->is_active) ? 'checked' : '' }}>
                        <span>تفعيل البكسل</span>
                    </label>
                </div>
                <div>
                    <label class="form-label">معرف بكسل سناب شات (Snap Pixel ID)</label>
                    <input type="text" name="pixels[snapchat][pixel_id]" class="form-control" value="{{ $snap->pixel_id ?? '' }}" placeholder="e.g. xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                    <p class="form-hint">يتتبع زيارات وتحويلات حملات سناب شات في السعودية والخليج.</p>
                </div>
            </div>

            <!-- TikTok Pixel -->
            @php $tiktok = $pixels['tiktok'] ?? null; @endphp
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <h4 class="card-title">TikTok Pixel</h4>
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 12px; color: var(--brand-green); font-weight: 700;">
                        <input type="checkbox" name="pixels[tiktok][is_active]" value="1" {{ ($tiktok && $tiktok->is_active) ? 'checked' : '' }}>
                        <span>تفعيل البكسل</span>
                    </label>
                </div>
                <div>
                    <label class="form-label">معرف بكسل تيك توك (TikTok Pixel ID)</label>
                    <input type="text" name="pixels[tiktok][pixel_id]" class="form-control" value="{{ $tiktok->pixel_id ?? '' }}" placeholder="e.g. CXXXXXXXXXXXXXXX">
                    <p class="form-hint">يتتبع التحويلات وتفاعل مستخدمي إعلانات TikTok.</p>
                </div>
            </div>

            <!-- Google Analytics 4 (GA4) -->
            @php $ga = $pixels['google_analytics'] ?? null; @endphp
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <h4 class="card-title">Google Analytics 4 (GA4)</h4>
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 12px; color: var(--brand-green); font-weight: 700;">
                        <input type="checkbox" name="pixels[google_analytics][is_active]" value="1" {{ ($ga && $ga->is_active) ? 'checked' : '' }}>
                        <span>تفعيل التحليلات</span>
                    </label>
                </div>
                <div>
                    <label class="form-label">معرف القياس (Measurement ID)</label>
                    <input type="text" name="pixels[google_analytics][pixel_id]" class="form-control" value="{{ $ga->pixel_id ?? '' }}" placeholder="e.g. G-XXXXXXXXXX">
                    <p class="form-hint">يربط الموقع بـ Google Analytics لرصد الزيارات ومصادرها بالكامل.</p>
                </div>
            </div>

            <!-- Google Tag Manager (GTM) -->
            @php $gtm = $pixels['google_tag_manager'] ?? null; @endphp
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <h4 class="card-title">Google Tag Manager (GTM)</h4>
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 12px; color: var(--brand-green); font-weight: 700;">
                        <input type="checkbox" name="pixels[google_tag_manager][is_active]" value="1" {{ ($gtm && $gtm->is_active) ? 'checked' : '' }}>
                        <span>تفعيل GTM</span>
                    </label>
                </div>
                <div>
                    <label class="form-label">معرف الحاوية (Container ID)</label>
                    <input type="text" name="pixels[google_tag_manager][pixel_id]" class="form-control" value="{{ $gtm->pixel_id ?? '' }}" placeholder="e.g. GTM-XXXXXXX">
                    <p class="form-hint">لإدارة كافة الوسوم المتقدمة دون تعديل الكود البرمجي.</p>
                </div>
            </div>

            <!-- Custom Scripts -->
            @php $custom = $pixels['custom'] ?? null; @endphp
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <h4 class="card-title">أكواد وسكربتات مخصصة (Custom Scripts)</h4>
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 12px; color: var(--brand-green); font-weight: 700;">
                        <input type="checkbox" name="pixels[custom][is_active]" value="1" {{ ($custom && $custom->is_active) ? 'checked' : '' }}>
                        <span>تفعيل</span>
                    </label>
                </div>
                <div>
                    <label class="form-label">كود الهيدر (Header Scripts &lt;head&gt;)</label>
                    <textarea name="pixels[custom][head_code]" class="form-control" rows="2" style="font-family: var(--font-code); font-size: 11px;">{{ $custom->head_code ?? '' }}</textarea>
                </div>
            </div>

        </div>

        <div style="display: flex; gap: 12px; margin-bottom: 30px;">
            <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
                <span>حفظ وتحديث إعدادات البكسلات</span>
            </button>
        </div>
    </form>

    <!-- UTM Campaign URL Builder -->
    <div class="card" style="background: #ffffff;">
        <div class="card-header">
            <h3 class="card-title">أداة توليد روابط الحملات الإعلانية الذكية (UTM Builder)</h3>
        </div>
        <p style="font-size: 12.5px; color: var(--text-muted); margin-bottom: 15px;">
            استخدم هذه الأداة لتوليد روابط إعلانات لحساباتكم في (سناب شات، تيك توك، ميتا، جوجل). عند نقر العميل على الرابط وتعبئة طلب الاستشارة، ستسجل اللوحة مباشرة المنصة واسم الحملة.
        </p>

        <div class="form-grid" style="margin-bottom: 15px;">
            <div>
                <label class="form-label">المنصة الإعلانية (Campaign Source)</label>
                <select id="utm_source_select" class="form-control" onchange="generateUtmUrl()">
                    <option value="snapchat">Snapchat Ads (سناب شات)</option>
                    <option value="tiktok">TikTok Ads (تيك توك)</option>
                    <option value="meta">Meta / Instagram Ads (إنستقرام وفيسبوك)</option>
                    <option value="google">Google Ads (إعلانات جوجل)</option>
                    <option value="x">X / Twitter Ads (إكس)</option>
                    <option value="linkedin">LinkedIn Ads (لينكد إن)</option>
                </select>
            </div>
            <div>
                <label class="form-label">نوع الوسيلة (Campaign Medium)</label>
                <input type="text" id="utm_medium_input" class="form-control" value="cpc" oninput="generateUtmUrl()" placeholder="cpc, story_ad, bio_link">
            </div>
            <div>
                <label class="form-label">اسم الحملة (Campaign Name)</label>
                <input type="text" id="utm_campaign_input" class="form-control" value="saudi_launch_2026" oninput="generateUtmUrl()" placeholder="e.g. ksa_promo_2026">
            </div>
        </div>

        <div>
            <label class="form-label">الرابط الإعلاني الجاهز للنسخ (Campaign URL)</label>
            <div style="display: flex; gap: 10px;">
                <input type="text" id="generated_utm_url" class="form-control" readonly style="color: var(--brand-forest); font-family: var(--font-code); font-weight: 600; background: #f8fafc;" value="{{ url('/') }}?utm_source=snapchat&utm_medium=cpc&utm_campaign=saudi_launch_2026">
                <button type="button" class="btn btn-lime" onclick="copyUtmUrl()">نسخ الرابط</button>
            </div>
        </div>
    </div>

</div>

@push('admin-scripts')
<script>
    function generateUtmUrl() {
        const base = "{{ url('/') }}";
        const source = document.getElementById('utm_source_select').value;
        const medium = document.getElementById('utm_medium_input').value.trim();
        const campaign = document.getElementById('utm_campaign_input').value.trim();

        let url = `${base}?utm_source=${encodeURIComponent(source)}`;
        if (medium) url += `&utm_medium=${encodeURIComponent(medium)}`;
        if (campaign) url += `&utm_campaign=${encodeURIComponent(campaign)}`;

        document.getElementById('generated_utm_url').value = url;
    }

    function copyUtmUrl() {
        const copyText = document.getElementById("generated_utm_url");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        alert("تم نسخ الرابط الإعلاني بنجاح! يمكنك استخدامه في حملتك.");
    }
</script>
@endpush
@endsection
