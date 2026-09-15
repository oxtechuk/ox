@extends('layouts.admin')

@section('title', 'إدارة المستخدمين والصلاحيات | OX Tech')
@section('header_title', 'المستخدمين والصلاحيات')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">المستخدمون المصرح لهم بالدخول</div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-lime">
            <span>إضافة مستخدم جديد</span>
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الدور / الصلاحية</th>
                    <th>الحالة</th>
                    <th>تاريخ الإضافة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <strong style="color: var(--text-heading);">{{ $user->name }}</strong>
                            @if($user->id === auth()->id())
                                <span style="font-size: 11px; color: var(--brand-green); font-weight: 700;">(حسابك الحالي)</span>
                            @endif
                        </td>
                        <td style="font-family: var(--font-code); color: var(--brand-blue);">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'super_admin')
                                <span class="status-badge new">مدير عام (Super Admin)</span>
                            @elseif($user->role === 'admin')
                                <span class="status-badge scheduled">مدير (Admin)</span>
                            @else
                                <span class="status-badge contacted">محرر محتوى (Editor)</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="status-badge scheduled">نشط</span>
                            @else
                                <span class="status-badge archived">معطل</span>
                            @endif
                        </td>
                        <td style="font-size: 11.5px; font-family: var(--font-code); color: var(--text-muted);">
                            {{ $user->created_at->format('Y-m-d') }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline btn-sm">
                                    تعديل
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الحساب؟');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="حذف">
                                            حذف
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
