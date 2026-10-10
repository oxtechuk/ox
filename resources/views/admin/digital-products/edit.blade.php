@extends('layouts.admin')

@section('title', 'تعديل البرنامج الرقمي: ' . $digitalProduct->name)

@section('content')
<div class="admin-content-inner" style="max-width: 900px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.digital-products.index') }}" style="font-size: 12px; color: var(--text-muted); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px;">
            &rarr; العودة لقائمة البرمجيات
        </a>
        <h1 class="topbar-title">✏️ تعديل بيانات البرنامج: {{ $digitalProduct->name }}</h1>
        <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 4px;">
            تحديث الأسعار، الإصدارات، أو استبدال ملف البرنامج بملف تحديث جديد
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

    <form action="{{ route('admin.digital-products.update', $digitalProduct->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Basic Info Card --}}
        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 18px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 10px;">
                1. البيانات الأساسية والتخصص
            </h3>

            <div class="form-grid">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">اسم البرنامج *</label>
                    <input type="text" name="name" value="{{ old('name', $digitalProduct->name) }}" required class="form-control">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">التخصص والتصنيف *</label>
                    <select name="category_id" required class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $digitalProduct->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">الرابط التعريفي (Slug) *</label>
                    <input type="text" name="slug" value="{{ old('slug', $digitalProduct->slug) }}" required class="form-control">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">رقم الإصدار (Version) *</label>
                    <input type="text" name="version" value="{{ old('version', $digitalProduct->version) }}" required class="form-control">
                </div>
            </div>

            <div style="margin-top: 18px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">العنوان الترويجي القصير (Tagline)</label>
                <input type="text" name="tagline" value="{{ old('tagline', $digitalProduct->tagline) }}" class="form-control">
            </div>

            <div style="margin-top: 18px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">الوصف الكامل والشامل للبرنامج *</label>
                <textarea name="description" rows="5" required class="form-control">{{ old('description', $digitalProduct->description) }}</textarea>
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
                    <input type="number" step="0.01" name="price" value="{{ old('price', $digitalProduct->price) }}" required class="form-control">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">سعر الخصم / العرض</label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $digitalProduct->sale_price) }}" class="form-control">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">العملة *</label>
                    <select name="currency" required class="form-control">
                        <option value="EGP" {{ old('currency', $digitalProduct->currency) === 'EGP' ? 'selected' : '' }}>جنيه مصري (EGP)</option>
                        <option value="SAR" {{ old('currency', $digitalProduct->currency) === 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                        <option value="USD" {{ old('currency', $digitalProduct->currency) === 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">الحالة *</label>
                    <select name="status" required class="form-control">
                        <option value="active" {{ old('status', $digitalProduct->status) === 'active' ? 'selected' : '' }}>نشط (Active)</option>
                        <option value="draft" {{ old('status', $digitalProduct->status) === 'draft' ? 'selected' : '' }}>مسودة (Draft)</option>
                        <option value="archived" {{ old('status', $digitalProduct->status) === 'archived' ? 'selected' : '' }}>مؤرشف (Archived)</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 18px; display: flex; gap: 24px;">
                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 12.5px; cursor: pointer;">
                    <input type="checkbox" name="has_license_key" value="1" {{ old('has_license_key', $digitalProduct->has_license_key) ? 'checked' : '' }}>
                    <span>توليد مفتاح ترخيص رسمي للعميل آلياً (License Key)</span>
                </label>

                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 12.5px; cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $digitalProduct->is_featured) ? 'checked' : '' }}>
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
                    @php
                        $featuresText = is_array($digitalProduct->features) ? implode("\n", $digitalProduct->features) : '';
                    @endphp
                    <textarea name="features" rows="6" class="form-control">{{ old('features', $featuresText) }}</textarea>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">
                        متطلبات تشغيل النظام (كل متطلب في سطر منفصل)
                    </label>
                    @php
                        $reqsText = is_array($digitalProduct->system_requirements) ? implode("\n", $digitalProduct->system_requirements) : '';
                    @endphp
                    <textarea name="system_requirements" rows="6" class="form-control">{{ old('system_requirements', $reqsText) }}</textarea>
                </div>
            </div>
        </div>

        {{-- File Upload --}}
        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 18px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 10px;">
                4. ملف البرنامج الحالي
            </h3>

            @if($digitalProduct->file_path)
                <div style="padding: 12px 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; margin-bottom: 14px; font-size: 12px; color: #166534; display: flex; align-items: center; justify-content: space-between;">
                    <span>📁 الملف المرفوع حالياً: <strong>{{ $digitalProduct->file_name ?: 'برنامج مثبت' }}</strong> ({{ $digitalProduct->file_size ?: 'الحجم غير محدد' }})</span>
                    <span style="font-weight: 700;">جاهز للتنزيل المشفر</span>
                </div>
            @endif

            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">رفع ملف جديد للاستبدال أو التحديث</label>
            <input type="file" name="software_file" class="form-control" style="padding: 12px;">
        </div>

        @php
            $lp = $digitalProduct->landingPage;
            $hasSalesPageActive = $lp && $lp->is_published;
            $salesUrl = url('/p/' . $digitalProduct->slug);
        @endphp

        {{-- Sales Landing Page Management Card --}}
        <div style="background: var(--bg-card); border: 1px solid #bfdbfe; border-radius: 14px; padding: 24px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(37, 99, 235, 0.04);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; border-bottom: 1px solid #e0e7ff; padding-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 800; color: #1e40af; display: flex; align-items: center; gap: 8px;">
                        <span></span> صفحة هبوط بيعية مخصصة (Sales Landing Page)
                    </h3>
                    <p style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">
                        تتيح لك إطلاق صفحة بيع سريعة وعالية التحويل للمسار <code>/p/{{ $digitalProduct->slug }}</code> مع حقن استايل خارجي وتتبع دقيق لميتا وجوجل.
                    </p>
                </div>
                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 800; color: #1e3a8a; cursor: pointer; background: #eff6ff; padding: 8px 16px; border-radius: 99px; border: 1.5px solid #93c5fd;">
                    <input type="checkbox" name="has_sales_page" value="1" {{ old('has_sales_page', $hasSalesPageActive) ? 'checked' : '' }} id="toggleSalesPage" onchange="toggleSalesBox(this.checked)">
                    <span>تفعيل صفحة السيلز</span>
                </label>
            </div>

            <div id="salesSettingsBox" style="{{ old('has_sales_page', $hasSalesPageActive) ? '' : 'display: none;' }}">
                
                {{-- Live URL Alert with Copy & Preview Actions --}}
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <div style="font-size: 11px; font-weight: 700; color: #166534; text-transform: uppercase; margin-bottom: 2px;">
                            رابط السيلز الإعلاني المباشر (جاهز لحملات ميتا وجوجل):
                        </div>
                        <a href="{{ $salesUrl }}" target="_blank" id="liveSalesUrlLink" style="font-family: monospace; font-size: 13.5px; font-weight: 800; color: #15803d; text-decoration: none; direction: ltr; display: inline-block;">
                            {{ $salesUrl }}
                        </a>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $salesUrl }}'); alert('تم نسخ رابط صفحة السيلز بنجاح!');" class="btn btn-outline" style="font-size: 11.5px; padding: 6px 12px; background: #fff;">
                             نسخ الرابط
                        </button>
                        <a href="{{ $salesUrl }}" target="_blank" class="btn btn-primary" style="font-size: 11.5px; padding: 6px 14px; background: #16a34a; border-color: #16a34a;">
                             معاينة الصفحة
                        </a>
                    </div>
                </div>

                {{-- Settings Tabs Navigation --}}
                <div style="display: flex; gap: 8px; border-bottom: 2px solid #e2e8f0; margin-bottom: 20px; overflow-x: auto; padding-bottom: 2px;">
                    <button type="button" class="sales-tab-btn active" onclick="switchSalesTab(event, 'tab-content')" style="padding: 10px 18px; font-size: 13px; font-weight: 800; border: none; background: transparent; cursor: pointer; color: #2563eb; border-bottom: 3px solid #2563eb; margin-bottom: -4px;">
                         المحتوى والعرض
                    </button>
                    <button type="button" class="sales-tab-btn" onclick="switchSalesTab(event, 'tab-styling')" style="padding: 10px 18px; font-size: 13px; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-muted); border-bottom: 3px solid transparent; margin-bottom: -4px;">
                        كود الاستايل والـ CSS الخارجي
                    </button>
                    <button type="button" class="sales-tab-btn" onclick="switchSalesTab(event, 'tab-tracking')" style="padding: 10px 18px; font-size: 13px; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-muted); border-bottom: 3px solid transparent; margin-bottom: -4px;">
                        ميتا بيكسل والتحليلات (Tracking)
                    </button>
                    <button type="button" class="sales-tab-btn" onclick="switchSalesTab(event, 'tab-social')" style="padding: 10px 18px; font-size: 13px; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-muted); border-bottom: 3px solid transparent; margin-bottom: -4px;">
                         وسوم المعاينة (Open Graph)
                    </button>
                    <button type="button" class="sales-tab-btn" onclick="switchSalesTab(event, 'tab-scripts')" style="padding: 10px 18px; font-size: 13px; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-muted); border-bottom: 3px solid transparent; margin-bottom: -4px;">
                         أكواد Head و Body مخصصة
                    </button>
                </div>

                {{-- Tab 1: Content --}}
                <div id="tab-content" class="sales-tab-content">
                    <div style="display: grid; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">عنوان الهبوط الجذاب (Headline)</label>
                            <input type="text" name="landing_headline" value="{{ old('landing_headline', $lp?->headline) }}" placeholder="أدر شركتك وتخلّص من فوضى الحسابات مع أفضل نظام ذكي" class="form-control">
                            <small style="color: var(--text-muted); font-size: 11px;">اتركه فارغاً لاستخدام اسم المنتج تلقائياً</small>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">الوصف التسويقي المقنع (Subheadline)</label>
                            <textarea name="landing_subheadline" rows="2" placeholder="برنامج معتمد يمنحك سرعة فائقة مع تفعيل رقمي فوري ودعم متواصل" class="form-control">{{ old('landing_subheadline', $lp?->subheadline) }}</textarea>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 120px; gap: 14px;">
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">شارة العرض في الهيدر (Hero Badge)</label>
                                <input type="text" name="landing_hero_badge" value="{{ old('landing_hero_badge', $lp?->hero_badge ?? '🔥 عرض خاص لفترة محدودة: تفعيل فوري مع ترخيص رسمي') }}" class="form-control">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">نص زر الطلب والشراء (CTA Button Text)</label>
                                <input type="text" name="landing_cta_text" value="{{ old('landing_cta_text', $lp?->cta_text ?? 'اشترِ الآن واحصل على التفعيل الفوري') }}" class="form-control">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">اللون الرئيسي</label>
                                <input type="color" name="landing_primary_color" value="{{ old('landing_primary_color', $lp?->primary_color ?? '#0284c7') }}" style="height: 42px; width: 100%; border-radius: 8px; border: 1px solid var(--border-card); cursor: pointer; padding: 2px;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab 2: Styling & External CSS --}}
                <div id="tab-styling" class="sales-tab-content" style="display: none;">
                    <div style="display: grid; gap: 18px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                 روابط ملفات استايل CSS خارجية (External CSS URLs)
                            </label>
                            <textarea name="external_css_urls" rows="3" placeholder="https://cdn.jsdelivr.net/npm/animate.css/animate.min.css&#10;https://fonts.googleapis.com/css2?family=Tajawal:wght@700&display=swap" class="form-control" style="font-family: monospace; font-size: 12.5px; direction: ltr;">{{ old('external_css_urls', $lp?->external_css_urls) }}</textarea>
                            <small style="color: var(--text-muted); font-size: 11px;">ضع كل رابط CSS خارجي أو مكتبة CDN في سطر منفصل. سيتم حقنها كـ &lt;link rel="stylesheet"&gt; تلقائياً في صفحة السيلز.</small>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                 كود استايل CSS مخصص (Custom CSS Code)
                            </label>
                            <textarea name="custom_css" rows="8" placeholder="/* اكتب أي كود استايل لتعديل وتخصيص صفحة السيلز بالكامل */&#10;.sales-hero { background: linear-gradient(135deg, #1e3a8a, #0f172a); }&#10;.hero-title { font-size: 44px; color: #ffffff; }" class="form-control" style="font-family: Consolas, monospace; font-size: 12.5px; direction: ltr; background: #1e293b; color: #f8fafc; line-height: 1.5;">{{ old('custom_css', $lp?->custom_css) }}</textarea>
                            <small style="color: var(--text-muted); font-size: 11px;">يتم حقن هذا الكود مباشرة داخل صفحة السيلز لتخصيص الألوان، الفونتات، والمسافات بسهولة.</small>
                        </div>
                    </div>
                </div>

                {{-- Tab 3: Tracking & Pixels --}}
                <div id="tab-tracking" class="sales-tab-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                 بيكسل ميتا مخصص (Meta Pixel ID)
                            </label>
                            <input type="text" name="meta_pixel_id" value="{{ old('meta_pixel_id', $lp?->meta_pixel_id) }}" placeholder="1907678277306091" class="form-control" style="direction: ltr;">
                            <small style="color: var(--text-muted); font-size: 11px;">اتركه فارغاً لاعتماد بيكسل ميتا الرئيسي للموقع (1907678277306091) تلقائياً. يدعم تتبع أحداث: <code>PageView</code>, <code>ViewContent</code>, <code>InitiateCheckout</code>.</small>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                📈 معرّف تحليلات جوجل (Google Analytics / Ads ID)
                            </label>
                            <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id', $lp?->google_analytics_id) }}" placeholder="AW-17984061932 أو G-XXXXXXXXXX" class="form-control" style="direction: ltr;">
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
                                <input type="text" name="og_title" value="{{ old('og_title', $lp?->og_title) }}" placeholder="احصل على البرنامج الأقوى في إدارة مبيعاتك" class="form-control">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">رابط صورة المعاينة (OG Image URL)</label>
                                <input type="text" name="og_image" value="{{ old('og_image', $lp?->og_image) }}" placeholder="https://oxtech.uk/images/promo-banner.jpg" class="form-control" style="direction: ltr;">
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">أو استبدال/رفع صورة معاينة جديدة للحملة الإعلانية</label>
                            @if($lp?->og_image)
                                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                                    <img src="{{ str_starts_with($lp->og_image, 'http') ? $lp->og_image : asset($lp->og_image) }}" alt="OG Preview" style="height: 50px; border-radius: 6px; border: 1px solid var(--border-card);">
                                    <span style="font-size: 11.5px; color: var(--text-muted);">الصورة المعتمدة حالياً لمعاينة فيسبوك وواتساب</span>
                                </div>
                            @endif
                            <input type="file" name="og_image_file" accept="image/*" class="form-control" style="padding: 10px;">
                            <small style="color: var(--text-muted); font-size: 11px;">المقاس الموصى به لإعلانات ميتا وواتساب: 1200x630 بكسل.</small>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">وصف المشاركة لشبكات التواصل (OG Description)</label>
                            <textarea name="og_description" rows="2" placeholder="اغتنم الفرصة الآن مع تفعيل فوري وضمان ذهبي 100%..." class="form-control">{{ old('og_description', $lp?->og_description) }}</textarea>
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
                            <textarea name="custom_head_scripts" rows="3" placeholder="&lt;!-- كود التحقق من النطاق، بيكسل تيك توك، أو أدوات الخرائط الحرارية --&gt;" class="form-control" style="font-family: monospace; font-size: 12.5px; direction: ltr;">{{ old('custom_head_scripts', $lp?->custom_head_scripts) }}</textarea>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">
                                📜 أكواد Body مخصصة (Custom &lt;body&gt; Scripts)
                            </label>
                            <textarea name="custom_body_scripts" rows="3" placeholder="&lt;!-- كود الشات المباشر، أو سكربتات التتبع التفاعلية --&gt;" class="form-control" style="font-family: monospace; font-size: 12.5px; direction: ltr;">{{ old('custom_body_scripts', $lp?->custom_body_scripts) }}</textarea>
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
        </script>

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('admin.digital-products.index') }}" class="btn btn-outline" style="padding: 12px 24px;">إلغاء</a>
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 13px;">
                حفظ التعديلات
            </button>
        </div>

    </form>

</div>
@endsection
