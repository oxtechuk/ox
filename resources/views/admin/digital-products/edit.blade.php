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

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('admin.digital-products.index') }}" class="btn btn-outline" style="padding: 12px 24px;">إلغاء</a>
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 13px;">
                حفظ التعديلات
            </button>
        </div>

    </form>

</div>
@endsection
