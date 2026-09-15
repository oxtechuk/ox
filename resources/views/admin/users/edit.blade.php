@extends('layouts.admin')

@section('title', 'تعديل المستخدم: ' . $user->name . ' | OX Tech')
@section('header_title', 'تعديل المستخدم: ' . $user->name)

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <div class="card-title">تعديل بيانات المستخدم: {{ $user->name }}</div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">رجوع للمستخدمين</a>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 16px;">
            <label class="form-label">الاسم الكامل *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div style="margin-bottom: 16px;">
            <label class="form-label">البريد الإلكتروني *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div style="margin-bottom: 16px;">
            <label class="form-label">تغيير كلمة المرور (اتركها فارغة إذا كنت لا ترغب في تغييرها)</label>
            <input type="password" name="password" class="form-control" placeholder="كلمة مرور جديدة (اختياري)">
        </div>

        <div style="margin-bottom: 20px;">
            <label class="form-label">الدور / الصلاحية *</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>مدير (Admin)</option>
                <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>محرر (Editor)</option>
                <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>مدير عام (Super Admin)</option>
            </select>
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                <span style="font-size: 12.5px; font-weight: 600; color: var(--text-heading);">الحساب نشط</span>
            </label>
        </div>

        <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
            <span>حفظ التعديلات</span>
        </button>
    </form>
</div>
@endsection
