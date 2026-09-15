@extends('layouts.admin')

@section('title', 'إضافة مستخدم جديد | OX Tech')
@section('header_title', 'إضافة مستخدم جديد')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <div class="card-title">بيانات المستخدم الجديد والصلاحيات</div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">رجوع للمستخدمين</a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 16px;">
            <label class="form-label">الاسم الكامل *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="مثال: أحمد الغامدي" required>
        </div>

        <div style="margin-bottom: 16px;">
            <label class="form-label">البريد الإلكتروني *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="user@oxtech.studio" required>
        </div>

        <div style="margin-bottom: 16px;">
            <label class="form-label">كلمة المرور * (6 خانات على الأقل)</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label class="form-label">الدور / الصلاحية *</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير (Admin) - وصول كامل للإدارة</option>
                <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>محرر (Editor) - إدارة المحتوى والمشاريع فقط</option>
                <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>مدير عام (Super Admin) - إدارة النظام والصلاحيات</option>
            </select>
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                <span style="font-size: 12.5px; font-weight: 600; color: var(--text-heading);">تفعيل الحساب مباشرة</span>
            </label>
        </div>

        <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
            <span>حفظ المستخدم الجديد</span>
        </button>
    </form>
</div>
@endsection
