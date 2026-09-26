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
        <div style="background: #fbfcfe; border: 1px solid #bfdbfe; border-radius: 12px; padding: 24px; margin-bottom: 30px;">
            <h3 style="font-size: 15px; font-weight: 800; color: #1e40af; margin-bottom: 12px;">
                🚀 صفحة هبوط إعلانية للبرنامج (Sales Landing Page)
            </h3>

            <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #1e3a8a; margin-bottom: 16px; cursor: pointer;">
                <input type="checkbox" name="create_landing_page" value="1" checked id="toggleLanding">
                <span>توليد صفحة هبوط إعلانية عالية التحويل تلقائياً لهذا البرنامج للمسار (/p/slug)</span>
            </label>

            <div id="landingFields" style="display: grid; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #1e3a8a; margin-bottom: 4px;">عنوان الهبوط الجذاب (Headline)</label>
                    <input type="text" name="landing_headline" placeholder="أدر شركتك وتخلّص من فوضى الحسابات مع أفضل نظام ذكي" class="form-control">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #1e3a8a; margin-bottom: 4px;">الوصف التسويقي المقنع (Subheadline)</label>
                    <textarea name="landing_subheadline" rows="2" placeholder="برنامج معتمد يمنحك سرعة فائقة مع تفعيل رقمي فوري ودعم متواصل" class="form-control"></textarea>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('admin.digital-products.index') }}" class="btn btn-outline" style="padding: 12px 24px;">إلغاء</a>
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 13px;">
                حفظ وإطلاق البرنامج الرقمي
            </button>
        </div>

    </form>

</div>
@endsection
