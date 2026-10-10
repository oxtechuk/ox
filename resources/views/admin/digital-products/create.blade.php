@extends('layouts.admin')

@section('title', 'إضافة برنامج أو منتج رقمي جديد')

@section('content')
<div class="admin-content-inner" style="max-width: 900px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.digital-products.index') }}" style="font-size: 12px; color: var(--text-muted); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px;">
            &rarr; العودة لقائمة البرمجيات
        </a>
        <h1 class="topbar-title">📦 إضافة برنامج أو منتج رقمي جديد</h1>
        <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 4px;">
            أدخل مواصفات البرنامج، الأسعار، وارفع ملف التثبيت المخصص للتنزيل الآمن
        </p>
    </div>

    @if($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 14px 18px; border-radius: 8px; font-size: 13px; margin-bottom: 24px;">
            <ul style="padding-right: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.digital-products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Basic Info Card --}}
        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 18px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 10px;">
                1. البيانات الأساسية والتخصص
            </h3>

            <div class="form-grid">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">اسم البرنامج *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="مثال: نظام OxPro المحاسبي" class="form-control">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">التخصص والتصنيف *</label>
                    <select name="category_id" required class="form-control">
                        <option value="">اختر التخصص...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">الرابط التعريفي (Slug - اختياري)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" placeholder="oxpro-accounting-system" class="form-control">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">رقم الإصدار (Version) *</label>
                    <input type="text" name="version" value="{{ old('version', '1.0.0') }}" required class="form-control">
                </div>
            </div>

            <div style="margin-top: 18px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">العنوان الترويجي القصير (Tagline)</label>
                <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="أقوى برنامج لإدارة الفواتير والمخازن بكفاءة 100%" class="form-control">
            </div>

            <div style="margin-top: 18px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">الوصف الكامل والشامل للبرنامج *</label>
                <textarea name="description" rows="5" required placeholder="اشرح تفاصيل البرنامج وقدراته..." class="form-control">{{ old('description') }}</textarea>
            </div>
        </div>

        {{-- Pricing & License Card --}}
        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 18px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 10px;">
                2. التسعير والترخيص
            </h3>

            <div class="form-grid">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">السعر الأساسي *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required placeholder="1500.00" class="form-control">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">سعر الخصم / العرض (اختياري)</label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" placeholder="990.00" class="form-control">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">العملة *</label>
                    <select name="currency" required class="form-control">
                        <option value="EGP" {{ old('currency', 'EGP') === 'EGP' ? 'selected' : '' }}>جنيه مصري (EGP)</option>
                        <option value="SAR" {{ old('currency') === 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                        <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">الحالة *</label>
                    <select name="status" required class="form-control">
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>نشط ومتاح للبيع فوراً (Active)</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>مسودة غير معروضة (Draft)</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 18px; display: flex; gap: 24px;">
                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 12.5px; cursor: pointer;">
                    <input type="checkbox" name="has_license_key" value="1" {{ old('has_license_key', true) ? 'checked' : '' }}>
                    <span>توليد مفتاح ترخيص رسمي للعميل آلياً (License Key)</span>
                </label>

                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 12.5px; cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <span>تمييز البرنامج في أول المتجر (Featured)</span>
                </label>
            </div>
        </div>

        {{-- Features & Requirements --}}
        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 18px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 10px;">
                3. المميزات ومتطلبات النظام
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">
                        المميزات الرئيسية (كل ميزة في سطر منفصل)
                    </label>
                    <textarea name="features" rows="6" placeholder="دعم كامل لمنظومة الفاتورة الإلكترونية&#10;نقطة بيع POS سريعة جداً&#10;تقارير أرباح وخسائر فورية" class="form-control">{{ old('features') }}</textarea>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">
                        متطلبات تشغيل النظام (كل متطلب في سطر منفصل)
                    </label>
                    <textarea name="system_requirements" rows="6" placeholder="نظام التشغيل: Windows 10/11 أو macOS&#10;الذاكرة العشوائية: 4GB RAM كحد أدنى&#10;المساحة المتوفرة: 500MB" class="form-control">{{ old('system_requirements') }}</textarea>
                </div>
            </div>
        </div>

        {{-- File Upload --}}
        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 18px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 10px;">
                4. ملف البرنامج للتنزيل الرقمي
            </h3>

            <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 14px;">
                ارفع ملف التثبيت المضغوط (.zip, .rar, .exe). يتم تخزينه بأمان في مسار محمي ويتم توليد روابط مشفرة للمشترين فقط. (إذا لم ترفع ملفاً، يولد النظام تلقائياً حزمة ترحيبية بالترخيص).
            </p>

            <input type="file" name="software_file" class="form-control" style="padding: 12px;">
        </div>

        {{-- Landing Page Setup --}}
        <div style="background: var(--bg-card); border: 1px solid #bfdbfe; border-radius: 14px; padding: 24px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(37, 99, 235, 0.04);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; border-bottom: 1px solid #e0e7ff; padding-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 800; color: #1e40af; display: flex; align-items: center; gap: 8px;">
                        <span>🚀</span> صفحة هبوط بيعية مخصصة (Sales Landing Page)
                    </h3>
                    <p style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">
                        تتيح لك إطلاق صفحة بيع سريعة وعالية التحويل للمسار <code>/p/slug</code> مع حقن استايل خارجي وتتبع دقيق لميتا وجوجل.
                    </p>
                </div>
                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 800; color: #1e3a8a; cursor: pointer; background: #eff6ff; padding: 8px 16px; border-radius: 99px; border: 1.5px solid #93c5fd;">
                    <input type="checkbox" name="has_sales_page" value="1" {{ old('has_sales_page', true) ? 'checked' : '' }} id="toggleSalesPage" onchange="toggleSalesBox(this.checked)">
                    <span>تفعيل صفحة السيلز</span>
                </label>
            </div>

            <div id="salesSettingsBox" style="{{ old('has_sales_page', true) ? '' : 'display: none;' }}">
                
                {{-- Live URL Alert --}}
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                    <div style="font-size: 12.5px; color: #166534;">
                        🔗 <strong>رابط السيلز الإعلاني المباشر:</strong>
                        <span id="salesUrlPreview" style="direction: ltr; display: inline-block; font-family: monospace; font-weight: 700; color: #15803d; margin-right: 6px;">
                            {{ url('/p/') }}/<span id="slugPlaceholder">[الرابط التعريفي]</span>
                        </span>
                    </div>
                    <span style="font-size: 11px; background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 6px; font-weight: 700;">
                        جاهز لحملات ميتا وجوجل
                    </span>
                </div>

                {{-- Settings Tabs Navigation --}}
                <div style="display: flex; gap: 8px; border-bottom: 2px solid #e2e8f0; margin-bottom: 20px; overflow-x: auto; padding-bottom: 2px;">
                    <button type="button" class="sales-tab-btn active" onclick="switchSalesTab(event, 'tab-content')" style="padding: 10px 18px; font-size: 13px; font-weight: 800; border: none; background: transparent; cursor: pointer; color: #2563eb; border-bottom: 3px solid #2563eb; margin-bottom: -4px;">
                        📝 المحتوى والعرض
                    </button>
                    <button type="button" class="sales-tab-btn" onclick="switchSalesTab(event, 'tab-styling')" style="padding: 10px 18px; font-size: 13px; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-muted); border-bottom: 3px solid transparent; margin-bottom: -4px;">
                        🎨 كود الاستايل والـ CSS الخارجي
                    </button>
                    <button type="button" class="sales-tab-btn" onclick="switchSalesTab(event, 'tab-tracking')" style="padding: 10px 18px; font-size: 13px; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-muted); border-bottom: 3px solid transparent; margin-bottom: -4px;">
                        📊 ميتا بيكسل والتحليلات (Tracking)
                    </button>
                    <button type="button" class="sales-tab-btn" onclick="switchSalesTab(event, 'tab-social')" style="padding: 10px 18px; font-size: 13px; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-muted); border-bottom: 3px solid transparent; margin-bottom: -4px;">
                        🌐 وسوم المعاينة (Open Graph)
                    </button>
                    <button type="button" class="sales-tab-btn" onclick="switchSalesTab(event, 'tab-scripts')" style="padding: 10px 18px; font-size: 13px; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-muted); border-bottom: 3px solid transparent; margin-bottom: -4px;">
                        ⚙️ أكواد Head و Body مخصصة
                    </button>
                </div>

                {{-- Tab 1: Content --}}
                <div id="tab-content" class="sales-tab-content">
                    <div style="display: grid; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">عنوان الهبوط الجذاب (Headline)</label>
                            <input type="text" name="landing_headline" value="{{ old('landing_headline') }}" placeholder="أدر شركتك وتخلّص من فوضى الحسابات مع أفضل نظام ذكي" class="form-control">
                            <small style="color: var(--text-muted); font-size: 11px;">اتركه فارغاً لاستخدام اسم المنتج تلقائياً</small>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">الوصف التسويقي المقنع (Subheadline)</label>
                            <textarea name="landing_subheadline" rows="2" placeholder="برنامج معتمد يمنحك سرعة فائقة مع تفعيل رقمي فوري ودعم متواصل" class="form-control">{{ old('landing_subheadline') }}</textarea>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 120px; gap: 14px;">
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">شارة العرض في الهيدر (Hero Badge)</label>
                                <input type="text" name="landing_hero_badge" value="{{ old('landing_hero_badge', '🔥 عرض خاص لفترة محدودة: تفعيل فوري مع ترخيص رسمي') }}" class="form-control">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">نص زر الطلب والشراء (CTA Button Text)</label>
                                <input type="text" name="landing_cta_text" value="{{ old('landing_cta_text', 'اشترِ الآن واحصل على التفعيل الفوري') }}" class="form-control">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">اللون الرئيسي</label>
                                <input type="color" name="landing_primary_color" value="{{ old('landing_primary_color', '#0284c7') }}" style="height: 42px; width: 100%; border-radius: 8px; border: 1px solid var(--border-card); cursor: pointer; padding: 2px;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab 2: Styling & External CSS --}}
                <div id="tab-styling" class="sales-tab-content" style="display: none;">
                    <div style="display: grid; gap: 18px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                🌐 روابط ملفات استايل CSS خارجية (External CSS URLs)
                            </label>
                            <textarea name="external_css_urls" rows="3" placeholder="https://cdn.jsdelivr.net/npm/animate.css/animate.min.css&#10;https://fonts.googleapis.com/css2?family=Tajawal:wght@700&display=swap" class="form-control" style="font-family: monospace; font-size: 12.5px; direction: ltr;">{{ old('external_css_urls') }}</textarea>
                            <small style="color: var(--text-muted); font-size: 11px;">ضع كل رابط CSS خارجي أو مكتبة CDN في سطر منفصل. سيتم حقنها كـ &lt;link rel="stylesheet"&gt; تلقائياً.</small>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                🎨 كود استايل CSS مخصص (Custom CSS Code)
                            </label>
                            <textarea name="custom_css" rows="7" placeholder="/* اكتب أي كود استايل لتعديل وتخصيص صفحة السيلز بالكامل */&#10;.sales-hero { background: linear-gradient(135deg, #1e3a8a, #0f172a); }&#10;.hero-title { font-size: 44px; color: #ffffff; }" class="form-control" style="font-family: Consolas, monospace; font-size: 12.5px; direction: ltr; background: #1e293b; color: #f8fafc; line-height: 1.5;">{{ old('custom_css') }}</textarea>
                            <small style="color: var(--text-muted); font-size: 11px;">يتم حقن هذا الكود مباشرة داخل صفحة السيلز لتخصيص الألوان، الفونتات، والمسافات بسهولة.</small>
                        </div>
                    </div>
                </div>

                {{-- Tab 3: Tracking & Pixels --}}
                <div id="tab-tracking" class="sales-tab-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                🎯 بيكسل ميتا مخصص (Meta Pixel ID)
                            </label>
                            <input type="text" name="meta_pixel_id" value="{{ old('meta_pixel_id') }}" placeholder="1907678277306091" class="form-control" style="direction: ltr;">
                            <small style="color: var(--text-muted); font-size: 11px;">اتركه فارغاً لاعتماد بيكسل ميتا الرئيسي للموقع تلقائياً. يدعم تتبع أحداث: <code>PageView</code>, <code>ViewContent</code>, <code>InitiateCheckout</code>.</small>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                📈 معرّف تحليلات جوجل (Google Analytics / Ads ID)
                            </label>
                            <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id') }}" placeholder="AW-17984061932 أو G-XXXXXXXXXX" class="form-control" style="direction: ltr;">
                            <small style="color: var(--text-muted); font-size: 11px;">اتركه فارغاً لاعتماد معرّف التحليلات الافتراضي للموقع تلقائياً.</small>
                        </div>
                    </div>
                </div>

                {{-- Tab 4: Social Open Graph --}}
                <div id="tab-social" class="sales-tab-content" style="display: none;">
                    <div style="display: grid; gap: 16px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">عنوان المشاركة للميتا وواتساب (OG Title)</label>
                                <input type="text" name="og_title" value="{{ old('og_title') }}" placeholder="احصل على البرنامج الأقوى في إدارة مبيعاتك" class="form-control">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">رابط صورة المعاينة (OG Image URL)</label>
                                <input type="text" name="og_image" value="{{ old('og_image') }}" placeholder="https://oxtech.uk/images/promo-banner.jpg" class="form-control" style="direction: ltr;">
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">أو رفع صورة معاينة مخصصة للحملة الإعلانية</label>
                            <input type="file" name="og_image_file" accept="image/*" class="form-control" style="padding: 10px;">
                            <small style="color: var(--text-muted); font-size: 11px;">المقاس الموصى به لإعلانات ميتا وواتساب: 1200x630 بكسل.</small>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">وصف المشاركة لشبكات التواصل (OG Description)</label>
                            <textarea name="og_description" rows="2" placeholder="اغتنم الفرصة الآن مع تفعيل فوري وضمان ذهبي 100%..." class="form-control">{{ old('og_description') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Tab 5: Custom Scripts --}}
                <div id="tab-scripts" class="sales-tab-content" style="display: none;">
                    <div style="display: grid; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                📜 أكواد Head مخصصة (Custom &lt;head&gt; Scripts)
                            </label>
                            <textarea name="custom_head_scripts" rows="3" placeholder="&lt;!-- كود التحقق من النطاق، بيكسل تيك توك، أو أدوات الخرائط الحرارية --&gt;" class="form-control" style="font-family: monospace; font-size: 12.5px; direction: ltr;">{{ old('custom_head_scripts') }}</textarea>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                📜 أكواد Body مخصصة (Custom &lt;body&gt; Scripts)
                            </label>
                            <textarea name="custom_body_scripts" rows="3" placeholder="&lt;!-- كود الشات المباشر، أو سكربتات التتبع التفاعلية --&gt;" class="form-control" style="font-family: monospace; font-size: 12.5px; direction: ltr;">{{ old('custom_body_scripts') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script>
            function toggleSalesBox(checked) {
                const box = document.getElementById('salesSettingsBox');
                if (box) {
                    box.style.display = checked ? 'block' : 'none';
                }
            }

            function switchSalesTab(event, tabId) {
                event.preventDefault();
                document.querySelectorAll('.sales-tab-content').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.sales-tab-btn').forEach(btn => {
                    btn.style.color = 'var(--text-muted)';
                    btn.style.borderBottomColor = 'transparent';
                    btn.style.fontWeight = '700';
                });
                
                const target = document.getElementById(tabId);
                if (target) target.style.display = 'block';
                
                event.currentTarget.style.color = '#2563eb';
                event.currentTarget.style.borderBottomColor = '#2563eb';
                event.currentTarget.style.fontWeight = '800';
            }

            // Sync slug with preview
            const slugInput = document.querySelector('input[name="slug"]');
            const nameInput = document.querySelector('input[name="name"]');
            const previewHolder = document.getElementById('slugPlaceholder');

            function updatePreviewSlug() {
                const val = (slugInput && slugInput.value.trim()) || (nameInput && nameInput.value.trim()) || '';
                if (previewHolder) {
                    previewHolder.innerText = val ? encodeURIComponent(val.toLowerCase().replace(/[\s_]+/g, '-')) : '[الرابط التعريفي]';
                }
            }

            if (slugInput) slugInput.addEventListener('input', updatePreviewSlug);
            if (nameInput) nameInput.addEventListener('input', updatePreviewSlug);
        </script>

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('admin.digital-products.index') }}" class="btn btn-outline" style="padding: 12px 24px;">إلغاء</a>
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 13px;">
                حفظ وإطلاق البرنامج الرقمي
            </button>
        </div>

    </form>

</div>
@endsection
