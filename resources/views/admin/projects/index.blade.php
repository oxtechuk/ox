@extends('layouts.admin')

@section('title', 'إدارة المشاريع | OX Tech')
@section('header_title', 'إدارة المشاريع والأعمال')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">قائمة المشاريع المضافة ({{ $projects->total() }})</div>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-lime">
            <span>إضافة مشروع جديد</span>
        </a>
    </div>

    <!-- Filters & Search -->
    <form method="GET" action="{{ route('admin.projects.index') }}" style="margin-bottom: 20px;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <input type="text" name="search" class="form-control" style="max-width: 250px;" placeholder="ابحث باسم المشروع أو العميل..." value="{{ request('search') }}">
            
            <select name="country" class="form-control" style="max-width: 160px;">
                <option value="">كل الدول</option>
                <option value="sa" {{ request('country') == 'sa' ? 'selected' : '' }}>السعودية</option>
                <option value="ae" {{ request('country') == 'ae' ? 'selected' : '' }}>الإمارات</option>
                <option value="eg" {{ request('country') == 'eg' ? 'selected' : '' }}>مصر</option>
                <option value="jo" {{ request('country') == 'jo' ? 'selected' : '' }}>الأردن</option>
                <option value="de" {{ request('country') == 'de' ? 'selected' : '' }}>ألمانيا</option>
                <option value="se" {{ request('country') == 'se' ? 'selected' : '' }}>السويد</option>
                <option value="ru" {{ request('country') == 'ru' ? 'selected' : '' }}>روسيا</option>
                <option value="iq" {{ request('country') == 'iq' ? 'selected' : '' }}>العراق</option>
            </select>

            <select name="sector" class="form-control" style="max-width: 160px;">
                <option value="">كل التخصصات</option>
                <option value="commerce" {{ request('sector') == 'commerce' ? 'selected' : '' }}>تجارة إلكترونية</option>
                <option value="auto" {{ request('sector') == 'auto' ? 'selected' : '' }}>سيارات</option>
                <option value="health" {{ request('sector') == 'health' ? 'selected' : '' }}>طبي</option>
                <option value="marine" {{ request('sector') == 'marine' ? 'selected' : '' }}>نقل بحري</option>
            </select>

            <select name="featured" class="form-control" style="max-width: 170px;">
                <option value="">كل المشاريع</option>
                <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>⭐ المميزة (الرئيسية)</option>
                <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>غير مميزة (أعمالنا فقط)</option>
            </select>

            <button type="submit" class="btn btn-outline">تصفية</button>
            @if(request()->hasAny(['search', 'country', 'sector', 'featured']))
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline" style="color: #b91c1c;">إلغاء الفلتر</a>
            @endif
        </div>
    </form>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 70px; text-align: center;">الترتيب</th>
                    <th>المشروع</th>
                    <th>الدولة والقطاع</th>
                    <th>مدة العمل</th>
                    <th>تاريخ الإنجاز</th>
                    <th>كارت كبير</th>
                    <th>الظهور والتمييز</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $p)
                    <tr>
                        <td style="font-family: var(--font-code); font-weight: 700; color: var(--brand-forest); text-align: center;">
                            #{{ $p->order }}
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 44px; height: 32px; border-radius: 6px; display: grid; place-items: center; font-size: 10px; font-weight: 700; color: #fff;" class="{{ $p->gradient_class }}">
                                    OX
                                </div>
                                <div>
                                    <strong class="truncate-text md" title="{{ $p->title }}" style="color: var(--text-heading);">{{ $p->title }}</strong>
                                    <div class="truncate-text md" title="{{ $p->subtitle }}" style="font-size: 11px; color: var(--brand-green); font-weight: 600;">{{ $p->subtitle }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="color: var(--text-heading); font-weight: 600;">{{ $p->country_name }}</div>
                            <small style="color: var(--text-muted);">{{ $p->sector_name }}</small>
                        </td>
                        <td style="color: var(--text-body);">{{ $p->duration ?? '-' }}</td>
                        <td style="color: var(--text-muted); font-size: 11.5px;">{{ $p->delivery_date ?? '-' }}</td>
                        <td>
                            @if($p->is_big)
                                <span class="status-badge new">Big Card</span>
                            @else
                                <span style="color: var(--text-muted);">عادي</span>
                            @endif
                        </td>
                        <td>
                            @if($p->is_featured)
                                <span class="status-badge new" style="background: rgba(184, 255, 44, 0.15); color: #84cc16; border: 1px solid rgba(184, 255, 44, 0.3); font-weight: 700; white-space: nowrap;">
                                    ⭐ مميز (الرئيسية)
                                </span>
                            @else
                                <span class="status-badge archived" style="white-space: nowrap;">
                                    عادي (أعمالنا فقط)
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('projects.show', $p->slug) }}" target="_blank" class="btn btn-outline btn-sm">
                                    معاينة
                                </a>
                                <a href="{{ route('admin.projects.edit', $p->id) }}" class="btn btn-outline btn-sm">
                                    تعديل
                                </a>
                                <form action="{{ route('admin.projects.destroy', $p->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا المشروع؟');" style="margin: 0;">
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
                            لا توجد مشاريع تطابق البحث.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $projects->links() }}
    </div>
</div>
@endsection
