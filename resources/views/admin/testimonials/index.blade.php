@extends('layouts.admin')

@section('title', 'إدارة فيديوهات الريفيو وقصص الشركاء | OX Tech')
@section('header_title', 'فيديوهات الريفيو وقصص الشركاء')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">فيديوهات وآراء الشركاء المعروضة</div>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-lime">
            <span>إضافة فيديو ريفيو جديد</span>
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 50px;">ترتيب</th>
                    <th>الشريك</th>
                    <th>المنصب والجهة</th>
                    <th>الدولة</th>
                    <th>الاقتباس (Quote)</th>
                    <th>الفيديو</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $t)
                    <tr>
                        <td style="font-family: var(--font-code); font-weight: 700; color: var(--brand-forest);">
                            {{ $t->order }}
                        </td>
                        <td>
                            <strong style="color: var(--text-heading);">{{ $t->partner_name }}</strong>
                            <div style="font-size: 11px; color: var(--brand-green); font-weight: 600;">شارة: {{ $t->number_badge ?? '01' }}</div>
                        </td>
                        <td style="color: var(--text-body);">{{ $t->partner_role }}</td>
                        <td style="color: var(--text-muted);">{{ $t->partner_country ?? '-' }}</td>
                        <td style="max-width: 250px; font-size: 11.5px; color: var(--text-body);">
                            {{ Str::limit($t->quote, 80) }}
                        </td>
                        <td>
                            @if($t->video_url)
                                <a href="{{ $t->video_src }}" target="_blank" class="btn btn-outline btn-sm">
                                    تشغيل ({{ $t->video_type }})
                                </a>
                            @else
                                <span style="color: var(--text-muted);">بدون فيديو</span>
                            @endif
                        </td>
                        <td>
                            @if($t->is_active)
                                <span class="status-badge scheduled">نشط</span>
                            @else
                                <span class="status-badge archived">معطل</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="btn btn-outline btn-sm">
                                    تعديل
                                </a>
                                <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الريفيو؟');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            لا توجد فيديوهات ريفيو مضافة حالياً.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
