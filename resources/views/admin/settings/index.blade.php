@extends('layouts.admin')

@section('title', 'إعدادات الهوية والفوتر و SEO | OX Tech')
@section('header_title', 'إعدادات النظام والموقع والظهور الإقليمي')

@push('admin-styles')
<style>
    .settings-nav-bar {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #F1F5F9;
        padding: 6px;
        border-radius: 14px;
        margin-bottom: 24px;
        border: 1px solid #E2E8F0;
        overflow-x: auto;
    }
    .settings-nav-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-decoration: none;
        border-radius: 10px;
        white-space: nowrap;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }
    .settings-nav-item:hover {
        color: #0F172A;
        background: rgba(255, 255, 255, 0.7);
    }
    .settings-nav-item.active {
        background: #FFFFFF;
        color: #0F172A !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        border-color: #E2E8F0;
    }
    .settings-nav-item.paypal.active {
        color: #003087 !important;
        border-color: #BAE6FD;
        background: #F0F9FF;
    }
    .settings-nav-item.paysky.active {
        color: #0284C7 !important;
        border-color: #BAE6FD;
        background: #F0F9FF;
    }

    /* ─── Premium Card Styles ─── */
    .settings-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
        margin-bottom: 22px;
    }
    .settings-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 16px;
        margin-bottom: 20px;
        border-bottom: 1px solid #F1F5F9;
    }
    .settings-card-title {
        font-size: 16px;
        font-weight: 800;
        color: #0F172A;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }
    .settings-card-subtitle {
        font-size: 12.5px;
        color: #64748B;
        margin-top: 4px;
        line-height: 1.5;
    }

    /* ─── Modern Input Addons ─── */
    .input-action-group {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-action-group .form-control {
        padding-left: 44px;
    }
    .input-action-btn {
        position: absolute;
        left: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #64748B;
        cursor: pointer;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: 0.2s;
    }
    .input-action-btn:hover {
        background: #F1F5F9;
        color: #0F172A;
    }

    /* ─── Notice / Callout Box ─── */
    .callout-box {
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 13px;
        line-height: 1.6;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 22px;
    }
    .callout-warning {
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        color: #92400E;
    }
    .callout-info {
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        color: #1E40AF;
    }

    /* ─── Services Cards Media Manager ─── */
    .service-media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
        margin-top: 15px;
    }
    .service-media-card {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .service-media-card:hover {
        border-color: #CBD5E1;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
    }
    .service-media-preview-box {
        position: relative;
        width: 100%;
        height: 220px;
        border-radius: 10px;
        overflow: hidden;
        background: #092C22;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }
    .service-media-preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .service-media-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        backdrop-filter: blur(8px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }
    .badge-custom {
        background: rgba(16, 185, 129, 0.95);
        color: #FFFFFF;
    }
    .badge-default {
        background: rgba(15, 23, 42, 0.75);
        color: #E2E8F0;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>
@endpush

@section('content')
<div style="max-width: 1100px;">

    <!-- Modern Pill Navigation Tabs -->
    <div class="settings-nav-bar">
        <a href="{{ route('admin.settings.index', ['tab' => 'branding']) }}" class="settings-nav-item {{ $activeTab === 'branding' ? 'active' : '' }}">
            <span>🎨</span>
            <span>الهوية والشعارات</span>
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'footer']) }}" class="settings-nav-item {{ $activeTab === 'footer' ? 'active' : '' }}">
            <span>🏢</span>
            <span>الفوتر والمكاتب</span>
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'seo']) }}" class="settings-nav-item {{ $activeTab === 'seo' ? 'active' : '' }}">
            <span>🌐</span>
            <span>تحسين محركات البحث (SEO)</span>
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'social']) }}" class="settings-nav-item {{ $activeTab === 'social' ? 'active' : '' }}">
            <span>📱</span>
            <span>روابط التواصل</span>
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'mail']) }}" class="settings-nav-item {{ $activeTab === 'mail' ? 'active' : '' }}">
            <span>✉️</span>
            <span>خادم البريد (SMTP)</span>
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'paysky']) }}" class="settings-nav-item paysky {{ $activeTab === 'paysky' ? 'active' : '' }}">
            <span>💳</span>
            <span>بوابة PaySky (مصر)</span>
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'paypal']) }}" class="settings-nav-item paypal {{ $activeTab === 'paypal' ? 'active' : '' }}">
            <span>🅿️</span>
            <span>بوابة PayPal (العالمية)</span>
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'recaptcha']) }}" class="settings-nav-item {{ $activeTab === 'recaptcha' ? 'active' : '' }}">
            <span>🛡️</span>
            <span>حماية reCAPTCHA</span>
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'audio']) }}" class="settings-nav-item {{ $activeTab === 'audio' ? 'active' : '' }}">
            <span>🎵</span>
            <span>الموسيقى والوسائط</span>
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'services']) }}" class="settings-nav-item {{ $activeTab === 'services' ? 'active' : '' }}">
            <span>🚀</span>
            <span>صور كروت الخدمات</span>
        </a>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="active_tab" value="{{ $activeTab }}">

        @if($activeTab === 'branding')
            <!-- Branding & Logos -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">هوية الموقع والشعارات الرسمية</h3>
                </div>
                
                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">اسم المنشأة / الشركة (Site Name)</label>
                        <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'OX Tech Software House' }}" required>
                    </div>
                    <div>
                        <label class="form-label">الشعار اللفظي (Slogan / Tagline)</label>
                        <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline'] ?? 'حلول برمجية سحابية وأنظمة متقدمة تلهم المستقبل' }}">
                    </div>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">اللوجو الرئيسي (Header Light Logo)</label>
                        <input type="file" name="site_logo_main" class="form-control" accept="image/*">
                        @if(!empty($settings['site_logo_main']))
                            <div style="margin-top: 10px; background: #f8fafc; border: 1px solid var(--border-card); padding: 10px; border-radius: 8px; display: inline-block;">
                                <img src="{{ $settings['site_logo_main'] }}" alt="Logo" style="max-height: 40px;">
                                <p style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">المسار الحالي: {{ $settings['site_logo_main'] }}</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="form-label">لوجو الفوتر (Footer Logo)</label>
                        <input type="file" name="site_logo_footer" class="form-control" accept="image/*">
                        @if(!empty($settings['site_logo_footer']))
                            <div style="margin-top: 10px; background: #092c22; padding: 10px; border-radius: 8px; display: inline-block;">
                                <img src="{{ $settings['site_logo_footer'] }}" alt="Footer Logo" style="max-height: 40px;">
                                <p style="font-size: 11px; color: #a4b7b1; margin-top: 4px;">المسار الحالي: {{ $settings['site_logo_footer'] }}</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="form-label">أيقونة المتصفح (Favicon .ico / .png)</label>
                        <input type="file" name="site_favicon" class="form-control" accept="image/*">
                        @if(!empty($settings['site_favicon']))
                            <div style="margin-top: 10px; background: #f8fafc; border: 1px solid var(--border-card); padding: 10px; border-radius: 8px; display: inline-block;">
                                <img src="{{ $settings['site_favicon'] }}" alt="Favicon" style="max-height: 32px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="form-label">لون الهوية البارز (Primary Accent Color)</label>
                        <input type="text" name="brand_color_primary" class="form-control" value="{{ $settings['brand_color_primary'] ?? '#006848' }}" placeholder="#006848">
                    </div>
                    <div>
                        <label class="form-label">اللون الثانوي (Secondary Blue)</label>
                        <input type="text" name="brand_color_secondary" class="form-control" value="{{ $settings['brand_color_secondary'] ?? '#1A56F5' }}" placeholder="#1A56F5">
                    </div>
                </div>
            </div>

        @elseif($activeTab === 'footer')
            <!-- Footer & Regional Offices -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">محتوى الفوتر والمكاتب الإقليمية (السعودية - مصر - الإمارات)</h3>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="form-label">نبذة الفوتر المختصرة (About Text in Footer)</label>
                    <textarea name="footer_about_text" class="form-control" rows="3">{{ $settings['footer_about_text'] ?? 'بيت برمجيات وتقنية رائد متخصص في تطوير المنصات السحابية والأنظمة المؤسسية وتطبيقات الذكاء الاصطناعي في المملكة ومصر والإمارات.' }}</textarea>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">مكتب الرياض (المملكة العربية السعودية)</label>
                        <textarea name="office_riyadh_address" class="form-control" rows="2">{{ $settings['office_riyadh_address'] ?? 'طريق الملك فهد، حي الصحافة، الرياض، المملكة العربية السعودية' }}</textarea>
                    </div>
                    <div>
                        <label class="form-label">مكتب القاهرة (جمهورية مصر العربية)</label>
                        <textarea name="office_cairo_address" class="form-control" rows="2">{{ $settings['office_cairo_address'] ?? 'التجمع الخامس، شارع التسعين الشمالي، القاهرة الجديدة، مصر' }}</textarea>
                    </div>
                    <div>
                        <label class="form-label">مكتب دبي (دولة الإمارات العربية المتحدة)</label>
                        <textarea name="office_dubai_address" class="form-control" rows="2">{{ $settings['office_dubai_address'] ?? 'أبراج بحيرات جميرا (JLT)، برج السيلفر، دبي، الإمارات' }}</textarea>
                    </div>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">البريد الإلكتروني الرسمي الرئيسي</label>
                        <input type="email" name="contact_email_primary" class="form-control" value="{{ $settings['contact_email_primary'] ?? 'info@ox-tech.sa' }}">
                    </div>
                    <div>
                        <label class="form-label">بريد قسم المبيعات والاستشارات</label>
                        <input type="email" name="contact_email_sales" class="form-control" value="{{ $settings['contact_email_sales'] ?? 'sales@ox-tech.sa' }}">
                    </div>
                    <div>
                        <label class="form-label">رقم الهاتف / الواتساب الموحد</label>
                        <input type="text" name="contact_phone_primary" class="form-control" value="{{ $settings['contact_phone_primary'] ?? '+966500000000' }}">
                    </div>
                </div>

                <div>
                    <label class="form-label">نص حقوق الملكية (Copyright Text)</label>
                    <input type="text" name="footer_copyright" class="form-control" value="{{ $settings['footer_copyright'] ?? 'جميع الحقوق محفوظة © ' . date('Y') . ' لشركة OX Tech لتطوير البرمجيات والأنظمة.' }}">
                </div>
            </div>

        @elseif($activeTab === 'seo')
            <!-- Regional Tech SEO Suite -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إعدادات تحسين محركات البحث (Regional Tech SEO - KSA, EG, UAE)</h3>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">عنوان الميتا الرئيسي (Meta Title)</label>
                        <input type="text" name="seo_meta_title" class="form-control" value="{{ $settings['seo_meta_title'] ?? 'OX Tech | أفضل شركة برمجة وتطوير تطبيقات وسوفت وير في السعودية ومصر والإمارات' }}">
                    </div>
                    <div>
                        <label class="form-label">الصورة الترويجية للمشاركة (Open Graph OG Image)</label>
                        <input type="file" name="seo_og_image" class="form-control" accept="image/*">
                        @if(!empty($settings['seo_og_image']))
                            <div style="margin-top: 8px;">
                                <img src="{{ $settings['seo_og_image'] }}" style="max-height: 40px; border-radius: 4px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="form-label">وصف الموقع لمحركات البحث (Meta Description)</label>
                    <textarea name="seo_meta_description" class="form-control" rows="3">{{ $settings['seo_meta_description'] ?? 'أوكس تك (OX Tech) بيت خبرة تقني وتطوير برمجيات متكامل يقدم حلول البرمجة السحابية، تطوير تطبيقات الجوال، المتاجر الإلكترونية، وحلول الذكاء الاصطناعي في الرياض، القاهرة، ودبي.' }}</textarea>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="form-label">الكلمات المفتاحية المستهدفة (Keywords KSA, Egypt, UAE)</label>
                    <textarea name="seo_meta_keywords" class="form-control" rows="3">{{ $settings['seo_meta_keywords'] ?? 'شركة برمجة في الرياض, افضل سوفت وير هاوس في السعودية, شركة تطوير تطبيقات دبي, برمجة مواقع القاهرة, شركة تقنية معلومات الرياض, تصميم متاجر سحابية, حلول ذكاء اصطناعي للشركات, Software House Riyadh, Tech Agency Dubai' }}</textarea>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="form-label">بيانات JSON-LD المهيكلة (Schema.org Structured Data)</label>
                    <textarea name="seo_schema_custom" class="form-control" rows="6" style="font-family: var(--font-code); font-size: 11px;">{{ $settings['seo_schema_custom'] ?? '' }}</textarea>
                    <p class="form-hint">يتم توليد مخطط SoftwareApplication و Organization و LocalBusiness تلقائياً، ويمكنك كتابة مخطط إضافي مخصص هنا.</p>
                </div>
            </div>

        @elseif($activeTab === 'social')
            <!-- Social Media Links -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">روابط الحسابات الرسمية على منصات التواصل</h3>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="form-label">منصة إكس (X / Twitter)</label>
                        <input type="url" name="social_x" class="form-control" value="{{ $settings['social_x'] ?? 'https://x.com/oxtech_sa' }}" placeholder="https://x.com/...">
                    </div>
                    <div>
                        <label class="form-label">لينكد إن (LinkedIn)</label>
                        <input type="url" name="social_linkedin" class="form-control" value="{{ $settings['social_linkedin'] ?? 'https://linkedin.com/company/oxtech' }}" placeholder="https://linkedin.com/...">
                    </div>
                    <div>
                        <label class="form-label">إنستغرام (Instagram)</label>
                        <input type="url" name="social_instagram" class="form-control" value="{{ $settings['social_instagram'] ?? 'https://instagram.com/oxtech.sa' }}">
                    </div>
                    <div>
                        <label class="form-label">سناب شات (Snapchat)</label>
                        <input type="url" name="social_snapchat" class="form-control" value="{{ $settings['social_snapchat'] ?? 'https://snapchat.com/add/oxtech' }}">
                    </div>
                    <div>
                        <label class="form-label">تيك توك (TikTok)</label>
                        <input type="url" name="social_tiktok" class="form-control" value="{{ $settings['social_tiktok'] ?? 'https://tiktok.com/@oxtech' }}">
                    </div>
                    <div>
                        <label class="form-label">جيت هب (GitHub)</label>
                        <input type="url" name="social_github" class="form-control" value="{{ $settings['social_github'] ?? 'https://github.com/oxtech' }}">
                    </div>
                </div>
            </div>

        @elseif($activeTab === 'mail')
            <!-- SMTP Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إعدادات خادم البريد الإلكتروني (SMTP Engine)</h3>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">مضيف البريد (Mail Host)</label>
                        <input type="text" name="mail_host" class="form-control" value="{{ $settings['mail_host'] ?? 'smtp.mailtrap.io' }}">
                    </div>
                    <div>
                        <label class="form-label">منفذ البريد (Mail Port)</label>
                        <input type="text" name="mail_port" class="form-control" value="{{ $settings['mail_port'] ?? '587' }}">
                    </div>
                    <div>
                        <label class="form-label">اسم المستخدم (Mail Username)</label>
                        <input type="text" name="mail_username" class="form-control" value="{{ $settings['mail_username'] ?? '' }}">
                    </div>
                    <div>
                        <label class="form-label">كلمة المرور (Mail Password)</label>
                        <input type="password" name="mail_password" class="form-control" value="{{ $settings['mail_password'] ?? '' }}">
                    </div>
                    <div>
                        <label class="form-label">التشفير (Encryption)</label>
                        <select name="mail_encryption" class="form-control">
                            <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">بريد المرسل الافتراضي (From Address)</label>
                        <input type="email" name="mail_from_address" class="form-control" value="{{ $settings['mail_from_address'] ?? 'noreply@ox-tech.sa' }}">
                    </div>
                </div>
            </div>
        @endif

        @if($activeTab === 'paysky')
            <!-- PaySky Omni Gateway Settings -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <div>
                        <h3 class="settings-card-title">
                            <span style="font-size: 20px;">💳</span>
                            <span>إعدادات بوابة الدفع PaySky Omni Gateway (مصر)</span>
                        </h3>
                        <p class="settings-card-subtitle">
                            تحكم ببيانات الربط مع PaySky، التبديل بين البيئة التجريبية والحية، ومفاتيح التشفير SecureHash.
                        </p>
                    </div>

                    <a href="{{ route('admin.payment-logs.index') }}" class="btn btn-outline btn-sm" style="display: flex; align-items: center; gap: 6px;">
                        <span>📋 سجل العمليات (Logs)</span>
                    </a>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">حالة بوابة الدفع *</label>
                        <select name="paysky_enabled" class="form-control" style="font-weight: 700;">
                            <option value="1" {{ ($settings['paysky_enabled'] ?? '1') === '1' ? 'selected' : '' }}>🟢 مفعلة وتستقبل المدفوعات (Enabled)</option>
                            <option value="0" {{ ($settings['paysky_enabled'] ?? '1') === '0' ? 'selected' : '' }}>⚪ معطلة مؤقتاً (Disabled)</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">بيئة العمل والتشغيل (Environment Mode) *</label>
                        <select name="paysky_mode" class="form-control" style="font-weight: 700;">
                            <option value="live" {{ ($settings['paysky_mode'] ?? 'test') === 'live' ? 'selected' : '' }}>🚀 البيئة الحية للإنتاج الحقيقي (Live / Production)</option>
                            <option value="test" {{ ($settings['paysky_mode'] ?? 'test') === 'test' ? 'selected' : '' }}>🧪 بيئة التجربة والاختبار (Staging / Test)</option>
                        </select>
                        <span class="form-hint">في البيئة الحية سيتم خصم مبالغ حقيقية من بطاقات العملاء.</span>
                    </div>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">رقم التاجر (Merchant ID - MID) *</label>
                        <input type="text" name="paysky_mid" class="form-control" value="{{ $settings['paysky_mid'] ?? config('services.paysky.mid', '10000000001') }}" required style="font-family: monospace; font-size: 13px;">
                        <span class="form-hint">مقدم من بنك مصر / البنك الشريك أو PaySky.</span>
                    </div>

                    <div>
                        <label class="form-label">رقم نقطة البيع / المحطة (Terminal ID - TID) *</label>
                        <input type="text" name="paysky_tid" class="form-control" value="{{ $settings['paysky_tid'] ?? config('services.paysky.tid', '10000001') }}" required style="font-family: monospace; font-size: 13px;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="form-label">المفتاح السري للتشفير (Merchant Secret Key / Secure Hash Key) *</label>
                    <input type="password" name="paysky_secret_key" class="form-control" value="{{ $settings['paysky_secret_key'] ?? config('services.paysky.secret_key', '31323334353637383930313233343536') }}" required style="font-family: monospace; font-size: 13px;">
                    <span class="form-hint">المفتاح السري بنظام HEX أو النص لتوليد توقيع HMAC-SHA256 والتحقق من الاستجابة.</span>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">العملة الافتراضية للتحصيل</label>
                        <select name="paysky_currency" class="form-control">
                            <option value="EGP" {{ ($settings['paysky_currency'] ?? 'EGP') === 'EGP' ? 'selected' : '' }}>جنيه مصري (EGP - 818)</option>
                            <option value="SAR" {{ ($settings['paysky_currency'] ?? 'EGP') === 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR - 682)</option>
                            <option value="USD" {{ ($settings['paysky_currency'] ?? 'EGP') === 'USD' ? 'selected' : '' }}>دولار أمريكي (USD - 840)</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">رابط استلام إشعار الخادم (Webhook / IPN URL)</label>
                        <input type="text" readonly class="form-control" value="{{ route('checkout.paysky.webhook') }}" style="background: #F8FAFC; font-family: monospace; font-size: 13px; color: #1E293B;">
                        <span class="form-hint">ضعه في لوحة تحكم PaySky لاستلام تأكيدات الدفع الآلية.</span>
                    </div>
                </div>
            </div>
        @elseif($activeTab === 'paypal')
            <!-- PayPal Gateway Integration -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <div>
                        <h3 class="settings-card-title">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" style="flex-shrink: 0;">
                                <path d="M7 21l3-14h5.5c3 0 5 1.5 4.5 4.5-.4 2.5-2.2 4-4.5 4H12l-1 5.5H7z" fill="#003087"/>
                                <path d="M9.5 21l2.5-11.5h4c2.5 0 4 1.2 3.5 3.8-.4 2.2-1.9 3.5-3.8 3.5H13l-1 4.2H9.5z" fill="#0079C1"/>
                            </svg>
                            <span>إعدادات بوابة الدفع العالمية PayPal (Checkout REST API v2)</span>
                        </h3>
                        <p class="settings-card-subtitle">
                            تمكين المبيعات الدولية واستقبال المدفوعات بحسابات PayPal والبطاقات العالمية بأسلوب Smart Buttons.
                        </p>
                    </div>
                    <div>
                        <span style="background: rgba(2, 132, 199, 0.1); color: #0284C7; padding: 6px 14px; border-radius: 99px; font-size: 12px; font-weight: 800; border: 1px solid rgba(2, 132, 199, 0.2);">
                            REST API v2
                        </span>
                    </div>
                </div>

                <!-- Callout Alert Box -->
                <div class="callout-box callout-warning">
                    <span style="font-size: 20px; line-height: 1;">⚠️</span>
                    <div>
                        <strong style="color: #78350F; display: block; margin-bottom: 2px;">تنبيه هام لتجنب فشل المصادقة (Client Authentication failed):</strong>
                        <span>تأكد من أن <strong>بيئة العمل (Environment Mode)</strong> المختارة أدناه تطابق نوع التطبيق المستخرج منه المفاتيح في <a href="https://developer.paypal.com/dashboard/applications" target="_blank" style="color: #92400E; text-decoration: underline; font-weight: 800;">لوحة PayPal Developer</a> (إذا نسخت المفاتيح من تبويب <strong>Live</strong> اختر <strong>البيئة الحية</strong>، وإذا نسختها من <strong>Sandbox</strong> اختر <strong>بيئة التجربة</strong>).</span>
                    </div>
                </div>

                <!-- 1. Gateway Status & Mode -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px; margin-bottom: 24px;">
                    <div style="font-size: 13.5px; font-weight: 800; color: #0F172A; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #10B981;"></span>
                        <span>1. تفعيل البوابة وبيئة التشغيل (Status & Environment)</span>
                    </div>
                    <div class="form-grid" style="margin-bottom: 0;">
                        <div>
                            <label class="form-label">حالة بوابة PayPal *</label>
                            <select name="paypal_enabled" class="form-control" style="font-weight: 700;">
                                <option value="1" {{ ($settings['paypal_enabled'] ?? '1') === '1' ? 'selected' : '' }}>🟢 مفعلة وتستقبل المدفوعات (Enabled)</option>
                                <option value="0" {{ ($settings['paypal_enabled'] ?? '1') === '0' ? 'selected' : '' }}>⚪ معطلة مؤقتاً (Disabled)</option>
                            </select>
                            <span class="form-hint">عند التفعيل سيظهر زر PayPal في صفحة تفاصيل المنتج وسلة الشراء.</span>
                        </div>

                        <div>
                            <label class="form-label">بيئة العمل والتشغيل (Environment Mode) *</label>
                            <select name="paypal_mode" class="form-control" style="font-weight: 700;">
                                <option value="live" {{ ($settings['paypal_mode'] ?? 'sandbox') === 'live' ? 'selected' : '' }}>🚀 البيئة الحية للإنتاج الحقيقي (Live / Production)</option>
                                <option value="sandbox" {{ ($settings['paypal_mode'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>🧪 بيئة التجربة والاختبار (Sandbox)</option>
                            </select>
                            <span class="form-hint">في البيئة الحية Live يتم خصم مبالغ حقيقية وتحويلها إلى حساب PayPal التجاري.</span>
                        </div>
                    </div>
                </div>

                <!-- 2. API Credentials -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px; margin-bottom: 24px;">
                    <div style="font-size: 13.5px; font-weight: 800; color: #0F172A; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #2563EB;"></span>
                        <span>2. مفاتيح الاعتماد والربط (PayPal API Credentials)</span>
                    </div>
                    <div class="form-grid" style="margin-bottom: 0;">
                        <div>
                            <label class="form-label">معرف العميل (PayPal Client ID) *</label>
                            <input type="text" name="paypal_client_id" class="form-control" value="{{ $settings['paypal_client_id'] ?? config('services.paypal.client_id', '') }}" placeholder="A..." style="font-family: monospace; font-size: 13px;" required>
                            <span class="form-hint">المعرف العام المستخرج من تطبيق REST API داخل PayPal Developer Dashboard.</span>
                        </div>

                        <div>
                            <label class="form-label">المفتاح السري (PayPal Client Secret) *</label>
                            <div class="input-action-group">
                                <input type="password" id="paypalSecretInput" name="paypal_client_secret" class="form-control" value="{{ $settings['paypal_client_secret'] ?? config('services.paypal.client_secret', '') }}" placeholder="E..." style="font-family: monospace; font-size: 13px;" required>
                                <button type="button" class="input-action-btn" id="toggleSecretBtn" title="إظهار / إخفاء المفتاح السري">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            <span class="form-hint">المفتاح السري الضروري للحصول على تصريح OAuth وإنشاء الطلبات على الخادم.</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Currency & Exchange Rate -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px; margin-bottom: 24px;">
                    <div style="font-size: 13.5px; font-weight: 800; color: #0F172A; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #D97706;"></span>
                        <span>3. العملة وسعر التحويل (Currency & Exchange Rate)</span>
                    </div>
                    <div class="form-grid" style="margin-bottom: 0;">
                        <div>
                            <label class="form-label">العملة الافتراضية لحساب PayPal</label>
                            <select name="paypal_currency" class="form-control">
                                <option value="USD" {{ ($settings['paypal_currency'] ?? 'USD') === 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                                <option value="EUR" {{ ($settings['paypal_currency'] ?? 'USD') === 'EUR' ? 'selected' : '' }}>يورو (EUR)</option>
                                <option value="GBP" {{ ($settings['paypal_currency'] ?? 'USD') === 'GBP' ? 'selected' : '' }}>جنيه إسترليني (GBP)</option>
                                <option value="SAR" {{ ($settings['paypal_currency'] ?? 'USD') === 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                            </select>
                            <span class="form-hint">العملة التي سيتم إنشاء وسحب المعاملة بها داخل حساب PayPal.</span>
                        </div>

                        <div>
                            <label class="form-label">سعر صرف تحويل الجنيه المصري للدولار (EGP to USD Rate)</label>
                            <input type="number" step="0.0001" name="paypal_egp_to_usd_rate" class="form-control" value="{{ $settings['paypal_egp_to_usd_rate'] ?? config('services.paypal.egp_to_usd_rate', 0.021) }}" style="font-family: monospace; font-size: 13px;">
                            <span class="form-hint">مثال: القيمة <code>0.021</code> تعني أن كل 1,000 جنيه مصري تعادل 21.00 دولار أمريكي تقريباً.</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Webhook Notification -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px;">
                    <div style="font-size: 13.5px; font-weight: 800; color: #0F172A; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #8B5CF6;"></span>
                        <span>4. إشعار الخادم الآلي (Server-to-Server Webhook)</span>
                    </div>
                    <div>
                        <label class="form-label">رابط استلام إشعار الخادم (PayPal Webhook URL)</label>
                        <div class="input-action-group">
                            <input type="text" id="paypalWebhookInput" readonly class="form-control" value="{{ route('checkout.paypal.webhook') }}" style="background: #F8FAFC; font-family: monospace; font-size: 13px; color: #1E293B;">
                            <button type="button" class="input-action-btn" id="copyWebhookBtn" title="نسخ رابط الويب هوك">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </button>
                        </div>
                        <span class="form-hint" style="margin-top: 8px;">
                            أضف هذا الرابط في خانة <strong>Webhook URL</strong> داخل لوحة PayPal Developer مع تفعيل حدث <code>PAYMENT.CAPTURE.COMPLETED</code>.
                        </span>
                    </div>
                </div>
            </div>
        @elseif($activeTab === 'recaptcha')
            <!-- Google reCAPTCHA Protection -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إعدادات الحماية ومكافحة البوتات (Google reCAPTCHA)</h3>
                </div>

                <div class="callout callout-info" style="margin-bottom: 24px; padding: 14px 18px; border-radius: 8px;">
                    <div style="font-weight: 700; margin-bottom: 4px;">🛡️ حماية نماذج التواصل وحجز الاستشارات ضد البوتات والرسائل المزعجة</div>
                    <div style="font-size: 13px; line-height: 1.6;">
                        تدعم المنصة حماية <strong>Google reCAPTCHA v3</strong> (الذكية غير المرئية) و <strong>v2</strong>. يمكنك إنشاء مفاتيح مجانية من خلال 
                        <a href="https://www.google.com/recaptcha/admin" target="_blank" style="color: #006848; font-weight: 700; text-decoration: underline;">Google reCAPTCHA Console</a> 
                        ثم حفظها هنا أو عبر ملف <code>.env</code>. عند ترك المفاتيح فارغة في بيئة التطوير المحلي، يتم السماح بالإرسال لتسهيل الاختبار.
                    </div>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">مفتاح الموقع العام (Site Key)</label>
                        <input type="text" name="recaptcha_site_key" class="form-control" value="{{ $settings['recaptcha_site_key'] ?? config('services.recaptcha.site_key', '') }}" placeholder="6LeIx0cYAAAAA..." style="font-family: monospace;">
                        <span class="form-hint">المفتاح العام المستخدم في الواجهة والمتصفح لاستدعاء كود التحقق.</span>
                    </div>

                    <div>
                        <label class="form-label">المفتاح السري (Secret Key)</label>
                        <input type="password" name="recaptcha_secret_key" id="recaptchaSecretInput" class="form-control" value="{{ $settings['recaptcha_secret_key'] ?? config('services.recaptcha.secret_key', '') }}" placeholder="6LeIx0cYAAAAA..." style="font-family: monospace;">
                        <span class="form-hint">المفتاح السري المستخدم للتحقق من أمان الرد من خلال سيرفرات Google.</span>
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="form-label">الحد الأدنى لدرجة الأمان الموثوقة (reCAPTCHA v3 Minimum Score)</label>
                        <input type="number" step="0.1" min="0.1" max="1.0" name="recaptcha_min_score" class="form-control" value="{{ $settings['recaptcha_min_score'] ?? (string) config('services.recaptcha.minimum_score', '0.5') }}" placeholder="0.5">
                        <span class="form-hint">مستوى الأمان من 0.0 (بوت مؤكد) إلى 1.0 (إنسان طبيعي). القيمة القياسية هي <strong>0.5</strong>.</span>
                    </div>

                    <div>
                        <label class="form-label">حالة الحماية الحالية</label>
                        <div style="padding: 11px 16px; border-radius: 8px; background: {{ !empty($settings['recaptcha_site_key'] ?? config('services.recaptcha.site_key')) ? '#ECFDF5; border: 1px solid #A7F3D0; color: #065F46;' : '#FFFBEB; border: 1px solid #FDE68A; color: #92400E;' }}; font-weight: 700; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                            <span>{{ !empty($settings['recaptcha_site_key'] ?? config('services.recaptcha.site_key')) ? '✅ مفعلة ومربوطة بـ Google reCAPTCHA' : '⚠️ غير مفعلة حالياً (يرجى إدخال المفاتيح لتفعيل الفحص التلقائي)' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($activeTab === 'audio')
            <!-- Background Music & Media Widget Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إعدادات ودجت الموسيقى والصوت في الموقع</h3>
                </div>

                <div class="callout callout-info" style="margin-bottom: 24px; padding: 14px 18px; border-radius: 8px;">
                    <div style="font-weight: 700; margin-bottom: 4px;">🎵 ودجت الموسيقى التفاعلية وخلفية الصوت</div>
                    <div style="font-size: 13px; line-height: 1.6;">
                        يظهر هذا الودجت في الموقع لتقديم تجربة صوتية فخمة لزوار الموقع مع مؤثرات صوتية ناعمة. يمكنك رفع ملف صوتي خاص بك (MP3 أو WAV أو M4A) أو وضع رابط صوتي خارجي مباشر، مع إمكانية التحكم الكامل في التشغيل التلقائي ودرجة الصوت الافتراضية.
                    </div>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">حالة ودجت الموسيقى في الموقع</label>
                        <select name="bg_audio_enabled" class="form-control">
                            <option value="1" {{ ($settings['bg_audio_enabled'] ?? '1') === '1' ? 'selected' : '' }}>✅ مفعل (يظهر في الموقع للزوار)</option>
                            <option value="0" {{ ($settings['bg_audio_enabled'] ?? '1') === '0' ? 'selected' : '' }}>❌ معطل (مخفي)</option>
                        </select>
                        <span class="form-hint">يمكنك تعطيل ظهور ودجت الموسيقى والصوت تماماً في أي وقت.</span>
                    </div>

                    <div>
                        <label class="form-label">اسم المقطع الصوتي (Track Display Title)</label>
                        <input type="text" name="bg_audio_title" class="form-control" value="{{ $settings['bg_audio_title'] ?? 'OX Tech Ambient Experience' }}" placeholder="مثال: OX Tech Ambient Experience">
                        <span class="form-hint">الاسم الذي يظهر للزائر في شريط مشغل الموسيقى عند التشغيل.</span>
                    </div>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">رفع ملف صوتي جديد (Upload MP3 / Audio File)</label>
                        <input type="file" name="bg_audio_file" class="form-control" accept="audio/*,.mp3,.wav,.ogg,.m4a,.aac,.webm">
                        <span class="form-hint">الملفات المدعومة: MP3, WAV, M4A, OGG, AAC (بحد أقصى 30MB).</span>
                        
                        @if(!empty($settings['bg_audio_file']))
                            <div style="margin-top: 10px; background: #f8fafc; border: 1px solid var(--border-card); padding: 12px; border-radius: 8px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-weight: 700; font-size: 12.5px; color: #071B19;">🎧 الملف المرفوع حالياً:</span>
                                    <label style="font-size: 12px; color: #DC2626; display: flex; align-items: center; gap: 4px; cursor: pointer;">
                                        <input type="checkbox" name="delete_bg_audio_file" value="1">
                                        <span>حذف هذا الملف الصوتي</span>
                                    </label>
                                </div>
                                <audio controls style="width: 100%; height: 36px;" src="{{ asset(ltrim($settings['bg_audio_file'], '/')) }}"></audio>
                                <p style="font-size: 11px; color: var(--text-muted); margin-top: 4px; font-family: monospace;">{{ $settings['bg_audio_file'] }}</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="form-label">أو رابط صوتي مباشر بديل (Direct External Audio URL)</label>
                        <input type="url" name="bg_audio_url" class="form-control" value="{{ $settings['bg_audio_url'] ?? '' }}" placeholder="https://example.com/soundtrack.mp3" style="direction: ltr; font-family: monospace;">
                        <span class="form-hint">إذا تم ترك رفع الملف فارغاً، سيتم استخدام هذا الرابط المباشر. إذا تُرك الاثنان فارغين، سيتم استخدام مقطع تقني افتراضي هادئ.</span>
                        @if(empty($settings['bg_audio_file']) && !empty($settings['bg_audio_url']))
                            <div style="margin-top: 10px; background: #f8fafc; border: 1px solid var(--border-card); padding: 10px; border-radius: 8px;">
                                <audio controls style="width: 100%; height: 36px;" src="{{ $settings['bg_audio_url'] }}"></audio>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-grid" style="margin-bottom: 20px;">
                    <div>
                        <label class="form-label">التشغيل التلقائي عند دخول الموقع (Autoplay on Enter)</label>
                        <select name="bg_audio_autoplay" class="form-control">
                            <option value="1" {{ ($settings['bg_audio_autoplay'] ?? '1') === '1' ? 'selected' : '' }}>✅ تشغيل تلقائي فور الدخول (أو عند أول تفاعل/تمرير حسب سياسة المتصفح)</option>
                            <option value="0" {{ ($settings['bg_audio_autoplay'] ?? '1') === '0' ? 'selected' : '' }}>⏸ انتظار نقر الزائر على زر التشغيل</option>
                        </select>
                        <span class="form-hint">المتصفحات الحديثة تسمح بالتشغيل التلقائي مباشرة أو بمجرد لمس الشاشة/التمرير.</span>
                    </div>

                    <div>
                        <label class="form-label">تكرار المقطع باستمرار (Loop Playback)</label>
                        <select name="bg_audio_loop" class="form-control">
                            <option value="1" {{ ($settings['bg_audio_loop'] ?? '1') === '1' ? 'selected' : '' }}>🔄 تكرار مستمر تلقائياً (Loop)</option>
                            <option value="0" {{ ($settings['bg_audio_loop'] ?? '1') === '0' ? 'selected' : '' }}>⏹ يتوقف بعد انتهاء المقطع</option>
                        </select>
                        <span class="form-hint">استمرار عزف المقطع الهادئ في الخلفية طوال تصفح الزائر.</span>
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="form-label">مستوى الصوت الافتراضي (Default Volume)</label>
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <input type="range" name="bg_audio_volume" min="0.05" max="1.0" step="0.05" value="{{ $settings['bg_audio_volume'] ?? '0.35' }}" class="form-control" style="padding: 0; cursor: pointer;" oninput="document.getElementById('volValueDisplay').textContent = Math.round(this.value * 100) + '%'">
                            <span id="volValueDisplay" style="font-weight: 800; font-family: monospace; font-size: 15px; color: #10B981; min-width: 45px;">{{ round(((float)($settings['bg_audio_volume'] ?? 0.35)) * 100) }}%</span>
                        </div>
                        <span class="form-hint">يُنصح بضبط الصوت بنسبة هادئة (25% - 40%) لضمان تجربة تصفح راقية دون إزعاج.</span>
                    </div>

                    <div>
                        <label class="form-label">معاينة الصوت الحالي</label>
                        @php
                            $previewSrc = !empty($settings['bg_audio_file']) ? asset(ltrim($settings['bg_audio_file'], '/')) : (!empty($settings['bg_audio_url']) ? $settings['bg_audio_url'] : 'https://assets.mixkit.co/music/preview/mixkit-tech-house-vibes-130.mp3');
                        @endphp
                        <div style="padding: 10px 14px; background: #f8fafc; border: 1px solid #E2E8F0; border-radius: 8px;">
                            <audio controls style="width: 100%; height: 32px;" src="{{ $previewSrc }}"></audio>
                            <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">{{ !empty($settings['bg_audio_file']) ? 'ملف مرفوع محلياً' : (!empty($settings['bg_audio_url']) ? 'رابط صوت خارجي' : 'المقطع الافتراضي للمنصة') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($activeTab === 'services')
            <!-- Services Cards Media & GIF Manager -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <div>
                        <h3 class="settings-card-title">
                            <span>🚀</span>
                            <span>إدارة وسائط وصور كروت الخدمات (Images & Animated GIFs)</span>
                        </h3>
                        <div class="settings-card-subtitle">
                            تحكم بالصور والخلفيات أو ملفات الـ GIF المتحركة لكروت الخدمات الأربعة الرئيسية المعروضة في واجهة الموقع.
                        </div>
                    </div>
                </div>

                <div class="callout-box callout-info">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 1px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <div>
                        <strong>ملاحظة هامة للمصممين:</strong>
                        يمكنك رفع صور عادية (WebP, PNG, JPG) أو ملفات متحركة بصيغة <strong>GIF</strong> لإعطاء الكروت حيوية تفاعلية جذابة. المقاس الموصى به <strong>380 × 460 بكسل</strong> (أو أي أبعاد طولية متناسقة)، وتتكيف الصورة تلقائياً لتملأ مساحة الكرت (object-fit: cover).
                    </div>
                </div>

                @php
                    $serviceCardsList = [
                        [
                            'index' => 1,
                            'key' => 'service_card_img_1',
                            'title' => 'الكرت 1: تطوير الويب والسحاب',
                            'subtitle' => 'Web & SaaS Platforms',
                            'default' => asset('assets/services/service-web.webp'),
                        ],
                        [
                            'index' => 2,
                            'key' => 'service_card_img_2',
                            'title' => 'الكرت 2: تطبيقات الجوال الذكية',
                            'subtitle' => 'Mobile Applications',
                            'default' => asset('assets/services/service-mobile.webp'),
                        ],
                        [
                            'index' => 3,
                            'key' => 'service_card_img_3',
                            'title' => 'الكرت 3: المتاجر والتجارة الرقمية',
                            'subtitle' => 'Digital E-Commerce',
                            'default' => asset('assets/services/service-ecommerce.webp'),
                        ],
                        [
                            'index' => 4,
                            'key' => 'service_card_img_4',
                            'title' => 'الكرت 4: أنظمة أودو والمؤسسات',
                            'subtitle' => 'Enterprise & Odoo ERP',
                            'default' => asset('assets/services/service-enterprise.webp'),
                        ],
                    ];
                @endphp

                <div class="service-media-grid">
                    @foreach($serviceCardsList as $card)
                        @php
                            $hasCustom = !empty($settings[$card['key']]);
                            $currentSrc = $hasCustom ? (str_starts_with($settings[$card['key']], 'http') ? $settings[$card['key']] : asset(ltrim($settings[$card['key']], '/'))) : $card['default'];
                        @endphp
                        <div class="service-media-card">
                            <div>
                                <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; margin-bottom: 10px;">
                                    <div>
                                        <div style="font-weight: 800; font-size: 14px; color: #0F172A;">{{ $card['title'] }}</div>
                                        <div style="font-size: 11.5px; color: #64748B; font-weight: 600;">{{ $card['subtitle'] }}</div>
                                    </div>
                                    <span style="background: #E2E8F0; color: #475569; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 6px;">#{{ $card['index'] }}</span>
                                </div>

                                <div class="service-media-preview-box">
                                    <img src="{{ $currentSrc }}" alt="{{ $card['title'] }}" class="service-media-preview-img" id="preview_{{ $card['key'] }}">
                                    <span class="service-media-badge {{ $hasCustom ? 'badge-custom' : 'badge-default' }}" id="badge_{{ $card['key'] }}">
                                        {{ $hasCustom ? '✨ وسائط مخصصة' : 'الافتراضي' }}
                                    </span>
                                </div>

                                <div style="margin-bottom: 10px;">
                                    <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">اختر صورة جديدة أو ملف GIF:</label>
                                    <input type="file" 
                                           name="{{ $card['key'] }}" 
                                           class="form-control" 
                                           accept="image/*,image/gif" 
                                           onchange="previewServiceImage(this, 'preview_{{ $card['key'] }}', 'badge_{{ $card['key'] }}')">
                                    <span class="form-hint" style="font-size: 11px;">صورة ثابتة أو GIF متحرك حتى 15 ميجابايت</span>
                                </div>
                            </div>

                            @if($hasCustom)
                                <div style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #CBD5E1;">
                                    <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 600; color: #DC2626; cursor: pointer; user-select: none;">
                                        <input type="checkbox" name="delete_{{ $card['key'] }}" value="1" style="accent-color: #DC2626; width: 15px; height: 15px;">
                                        <span>حذف الوسائط المخصصة واستعادة الأصل</span>
                                    </label>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div style="display: flex; align-items: center; gap: 14px; margin-top: 24px; padding-top: 18px; border-top: 1px solid #E2E8F0;">
            <button type="submit" class="btn btn-lime" style="padding: 12px 32px; font-size: 14px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                <span>حفظ التغييرات وتحديث الإعدادات</span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline" style="padding: 12px 24px;">إلغاء</a>
        </div>
    </form>

</div>

@push('admin-scripts')
<script>
    function previewServiceImage(input, previewId, badgeId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewEl = document.getElementById(previewId);
                if (previewEl) {
                    previewEl.src = e.target.result;
                }
                const badgeEl = document.getElementById(badgeId);
                if (badgeEl) {
                    badgeEl.textContent = '✨ تم اختيار ملف جديد';
                    badgeEl.className = 'service-media-badge badge-custom';
                }
            };
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Toggle Secret Visibility
        const toggleBtn = document.getElementById('toggleSecretBtn');
        const secretInput = document.getElementById('paypalSecretInput');
        if (toggleBtn && secretInput) {
            toggleBtn.addEventListener('click', () => {
                const isPassword = secretInput.type === 'password';
                secretInput.type = isPassword ? 'text' : 'password';
                toggleBtn.style.color = isPassword ? '#10B981' : '#64748B';
            });
        }

        // Copy Webhook URL
        const copyBtn = document.getElementById('copyWebhookBtn');
        const webhookInput = document.getElementById('paypalWebhookInput');
        if (copyBtn && webhookInput) {
            copyBtn.addEventListener('click', () => {
                navigator.clipboard.writeText(webhookInput.value).then(() => {
                    copyBtn.style.color = '#10B981';
                    setTimeout(() => {
                        copyBtn.style.color = '#64748B';
                    }, 2000);
                });
            });
        }
    });
</script>
@endpush
@endsection
