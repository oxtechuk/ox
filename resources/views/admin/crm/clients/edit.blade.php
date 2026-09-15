@extends('layouts.admin')

@section('title', 'تعديل بيانات العميل | OX Tech CRM')
@section('header_title', 'تعديل بيانات العميل: ' . $client->name)

@section('content')
<div style="max-width: 900px;">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">تعديل ملف العميل</h3>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.crm.clients.show', $client) }}" class="btn btn-outline btn-sm">عرض الملف</a>
                <a href="{{ route('admin.crm.clients.index') }}" class="btn btn-outline btn-sm">العودة للقائمة</a>
            </div>
        </div>

        <form action="{{ route('admin.crm.clients.update', $client) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">اسم العميل / المسؤول *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>
                </div>
                <div>
                    <label class="form-label">البريد الإلكتروني *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}" required>
                </div>
            </div>

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">رقم الجوال / الواتساب</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
                </div>
                <div>
                    <label class="form-label">اسم الشركة / المؤسسة</label>
                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $client->company_name) }}">
                </div>
            </div>

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">الرقم الضريبي (Tax / VAT Number)</label>
                    <input type="text" name="tax_number" class="form-control" value="{{ old('tax_number', $client->tax_number) }}">
                </div>
                <div>
                    <label class="form-label">حالة العميل في الـ CRM *</label>
                    <select name="status" class="form-control" required>
                        <option value="lead" {{ old('status', $client->status) === 'lead' ? 'selected' : '' }}>عميل محتمل جديد (Lead)</option>
                        <option value="prospect" {{ old('status', $client->status) === 'prospect' ? 'selected' : '' }}>قيد التفاوض والدراسة (Prospect)</option>
                        <option value="active" {{ old('status', $client->status) === 'active' ? 'selected' : '' }}>عميل حالي نشط (Active)</option>
                        <option value="inactive" {{ old('status', $client->status) === 'inactive' ? 'selected' : '' }}>غير نشط (Inactive)</option>
                    </select>
                </div>
            </div>

            <div class="form-grid" style="margin-bottom: 20px;">
                <div>
                    <label class="form-label">الدولة</label>
                    <select name="country" class="form-control">
                        <option value="السعودية" {{ old('country', $client->country) === 'السعودية' ? 'selected' : '' }}>المملكة العربية السعودية</option>
                        <option value="الإمارات" {{ old('country', $client->country) === 'الإمارات' ? 'selected' : '' }}>الإمارات العربية المتحدة</option>
                        <option value="مصر" {{ old('country', $client->country) === 'مصر' ? 'selected' : '' }}>جمهورية مصر العربية</option>
                        <option value="الكويت" {{ old('country', $client->country) === 'الكويت' ? 'selected' : '' }}>الكويت</option>
                        <option value="قطر" {{ old('country', $client->country) === 'قطر' ? 'selected' : '' }}>قطر</option>
                        <option value="أخرى" {{ old('country', $client->country) === 'أخرى' ? 'selected' : '' }}>أخرى</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">المدينة</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $client->city) }}">
                </div>
                <div>
                    <label class="form-label">مصدر العميل (Lead Source)</label>
                    <input type="text" name="lead_source" class="form-control" value="{{ old('lead_source', $client->lead_source) }}">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label">العنوان التفصيلي</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $client->address) }}">
            </div>

            <div style="margin-bottom: 25px;">
                <label class="form-label">ملاحظات داخلية</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $client->notes) }}</textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-lime"><span>حفظ التعديلات</span></button>
                <a href="{{ route('admin.crm.clients.show', $client) }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
