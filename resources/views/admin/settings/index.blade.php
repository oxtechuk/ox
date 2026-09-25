@extends('layouts.admin')

@section('title', 'إعدادات الهوية والفوتر و SEO | OX Tech')
@section('header_title', 'إعدادات النظام والموقع والظهور الإقليمي')

@section('content')
<div style="max-width: 1100px;">

    <!-- Navigation Tabs -->
    <div style="display: flex; gap: 8px; margin-bottom: 24px; border-bottom: 1px solid var(--border-card); padding-bottom: 12px; overflow-x: auto;">
        <a href="{{ route('admin.settings.index', ['tab' => 'branding']) }}" class="btn {{ $activeTab === 'branding' ? 'btn-lime' : 'btn-outline' }}">
            الهوية والشعارات
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'footer']) }}" class="btn {{ $activeTab === 'footer' ? 'btn-lime' : 'btn-outline' }}">
            الفوتر والمكاتب الإقليمية
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'seo']) }}" class="btn {{ $activeTab === 'seo' ? 'btn-lime' : 'btn-outline' }}">
            تحسين محركات البحث (SEO KSA/EG/UAE)
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'social']) }}" class="btn {{ $activeTab === 'social' ? 'btn-lime' : 'btn-outline' }}">
            روابط التواصل الاجتماعي
        </a>
        <a href="{{ route('admin.settings.index', ['tab' => 'mail']) }}" class="btn {{ $activeTab === 'mail' ? 'btn-lime' : 'btn-outline' }}">
            خادم البريد (SMTP)
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

        <div style="display: flex; gap: 12px; margin-top: 20px;">
            <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
                <span>حفظ التغييرات وتحديث الإعدادات</span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">إلغاء</a>
        </div>
    </form>

</div>
@endsection
