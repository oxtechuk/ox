@extends('layouts.admin')

@section('title', 'إضافة عميل جديد | OX Tech CRM')
@section('header_title', 'إضافة ملف عميل جديد إلى نظام CRM')

@section('content')
<div style="max-width: 900px;">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">البيانات الأساسية للعميل</h3>
            <a href="{{ route('admin.crm.clients.index') }}" class="btn btn-outline btn-sm">العودة للقائمة</a>
        </div>

        <form action="{{ route('admin.crm.clients.store') }}" method="POST">
            @csrf

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">اسم العميل / المسؤول *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', request('name')) }}" required placeholder="مثال: م. عبد الله الشمري">
                </div>
                <div>
                    <label class="form-label">البريد الإلكتروني *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', request('email')) }}" required placeholder="client@company.com">
                </div>
            </div>

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">رقم الجوال / الواتساب</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', request('phone')) }}" placeholder="+966500000000">
                </div>
                <div>
                    <label class="form-label">اسم الشركة / المؤسسة</label>
                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name', request('company')) }}" placeholder="مؤسسة الابتكار التقني">
                </div>
            </div>

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">الرقم الضريبي (Tax / VAT Number)</label>
                    <input type="text" name="tax_number" class="form-control" value="{{ old('tax_number') }}" placeholder="300000000000003">
                </div>
                <div>
                    <label class="form-label">حالة العميل في الـ CRM *</label>
                    <select name="status" class="form-control" required>
                        <option value="lead" {{ old('status') === 'lead' ? 'selected' : '' }}>عميل محتمل جديد (Lead)</option>
                        <option value="prospect" {{ old('status') === 'prospect' ? 'selected' : '' }}>قيد التفاوض والدراسة (Prospect)</option>
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>عميل حالي نشط (Active)</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>غير نشط (Inactive)</option>
                    </select>
                </div>
            </div>

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">الدولة</label>
                    <select name="country" class="form-control">
                        <option value="السعودية" {{ old('country', 'السعودية') === 'السعودية' ? 'selected' : '' }}>المملكة العربية السعودية</option>
                        <option value="الإمارات" {{ old('country') === 'الإمارات' ? 'selected' : '' }}>الإمارات العربية المتحدة</option>
                        <option value="مصر" {{ old('country') === 'مصر' ? 'selected' : '' }}>جمهورية مصر العربية</option>
                        <option value="الكويت" {{ old('country') === 'الكويت' ? 'selected' : '' }}>الكويت</option>
                        <option value="قطر" {{ old('country') === 'قطر' ? 'selected' : '' }}>قطر</option>
                        <option value="أخرى" {{ old('country') === 'أخرى' ? 'selected' : '' }}>أخرى</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">المدينة</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="الرياض / دبي / القاهرة">
                </div>
                <div>
                    <label class="form-label">مصدر العميل (Lead Source)</label>
                    <input type="text" name="lead_source" class="form-control" value="{{ old('lead_source', 'Direct / Form') }}" placeholder="Snapchat Ads, TikTok, Referral...">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label">العنوان التفصيلي</label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="حي الياسمين، طريق أنس بن مالك...">
            </div>

            <div style="margin-bottom: 25px;">
                <label class="form-label">ملاحظات داخلية حول العميل ومتطلباته</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="أي ملاحظات خاصة بالفريق الهندسي أو المبيعات...">{{ old('notes') }}</textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-lime"><span>حفظ وإنشاء ملف العميل</span></button>
                <a href="{{ route('admin.crm.clients.index') }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
