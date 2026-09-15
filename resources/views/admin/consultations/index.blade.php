@extends('layouts.admin')

@section('title', 'طلبات الاستشارة والعملاء | OX Tech')
@section('header_title', 'طلبات الاستشارة ومصدر الزيارة')

@push('admin-styles')
<style>
    .consult-toolbar {
        background: #ffffff;
        border: 1px solid var(--border-card);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }
    .filter-tabs {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .filter-tab {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .filter-tab:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .filter-tab.active {
        background: #eaf3ef;
        color: var(--brand-green);
        border-color: #c2e2d6;
        font-weight: 700;
    }
    .tab-badge {
        font-size: 10.5px;
        font-family: var(--font-code);
        background: #e2e8f0;
        color: #334155;
        padding: 1px 6px;
        border-radius: 99px;
        font-weight: 700;
    }
    .filter-tab.active .tab-badge {
        background: var(--brand-green);
        color: #ffffff;
    }

    .client-avatar-badge {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #eaf3ef;
        color: var(--brand-forest);
        font-weight: 800;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #d2e7de;
    }

    /* Refined Status Pills */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }
    .status-pill::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .status-pill.new { background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }
    .status-pill.new::before { background: #3b82f6; }
    .status-pill.contacted { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .status-pill.contacted::before { background: #f59e0b; }
    .status-pill.scheduled { background: #eaf3ef; color: #006848; border: 1px solid #c2e2d6; }
    .status-pill.scheduled::before { background: #006848; }
    .status-pill.completed { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .status-pill.completed::before { background: #10b981; }
    .status-pill.archived { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .status-pill.archived::before { background: #94a3b8; }

    /* Quick status select inside table */
    .status-quick-select {
        padding: 4px 8px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
        border: 1px solid transparent;
        outline: none;
        cursor: pointer;
        font-family: var(--font);
        transition: 0.2s;
    }
    .status-quick-select.new { background: #eff6ff; color: #1d4ed8; border-color: #dbeafe; }
    .status-quick-select.contacted { background: #fffbeb; color: #b45309; border-color: #fde68a; }
    .status-quick-select.scheduled { background: #eaf3ef; color: #006848; border-color: #c2e2d6; }
    .status-quick-select.completed { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
    .status-quick-select.archived { background: #f1f5f9; color: #64748b; border-color: #e2e8f0; }
</style>
@endpush

@section('content')
<div>

    <!-- Status & Search Toolbar -->
    <div class="consult-toolbar">
        <div class="filter-tabs">
            <a href="{{ route('admin.consultations.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">
                <span>الكل</span>
                <span class="tab-badge">{{ $statusCounts['all'] }}</span>
            </a>
            <a href="{{ route('admin.consultations.index', ['status' => 'new']) }}" class="filter-tab {{ request('status') === 'new' ? 'active' : '' }}">
                <span>جديد</span>
                <span class="tab-badge" style="{{ $statusCounts['new'] > 0 ? 'background:#ef4444; color:#fff;' : '' }}">{{ $statusCounts['new'] }}</span>
            </a>
            <a href="{{ route('admin.consultations.index', ['status' => 'contacted']) }}" class="filter-tab {{ request('status') === 'contacted' ? 'active' : '' }}">
                <span>تم التواصل</span>
                <span class="tab-badge">{{ $statusCounts['contacted'] }}</span>
            </a>
            <a href="{{ route('admin.consultations.index', ['status' => 'scheduled']) }}" class="filter-tab {{ request('status') === 'scheduled' ? 'active' : '' }}">
                <span>تم حجز موعد</span>
                <span class="tab-badge">{{ $statusCounts['scheduled'] }}</span>
            </a>
            <a href="{{ route('admin.consultations.index', ['status' => 'completed']) }}" class="filter-tab {{ request('status') === 'completed' ? 'active' : '' }}">
                <span>مكتمل</span>
                <span class="tab-badge">{{ $statusCounts['completed'] }}</span>
            </a>
            <a href="{{ route('admin.consultations.index', ['status' => 'archived']) }}" class="filter-tab {{ request('status') === 'archived' ? 'active' : '' }}">
                <span>مؤرشف</span>
                <span class="tab-badge">{{ $statusCounts['archived'] }}</span>
            </a>
        </div>

        <div>
            <form method="GET" action="{{ route('admin.consultations.index') }}" style="display: flex; gap: 8px;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="search" class="form-control" style="width: 220px; padding: 7px 12px; font-size: 12px;" placeholder="بحث بالاسم، الإيميل، الهاتف..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline btn-sm">بحث</button>
            </form>
        </div>
    </div>

    <!-- Consultations Table -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div class="table-responsive">
            <table class="admin-table" style="margin: 0;">
                <thead>
                    <tr>
                        <th style="padding-right: 22px;">العميل والمنشأة</th>
                        <th>التواصل والمصدر</th>
                        <th>نوع المشروع</th>
                        <th>الميزانية المتوقعة</th>
                        <th>تفاصيل الرسالة / الفكرة</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th style="padding-left: 22px; text-align: left;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultations as $c)
                        <tr>
                            <td style="padding-right: 22px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div class="client-avatar-badge">
                                        {{ mb_substr($c->name, 0, 1, 'utf-8') }}
                                    </div>
                                    <div>
                                        <strong class="truncate-text sm" title="{{ $c->name }}" style="color: var(--text-heading); font-size: 13px;">{{ $c->name }}</strong>
                                        @if($c->company_name)
                                            <div class="truncate-text sm" title="{{ $c->company_name }}" style="font-size: 11px; color: var(--brand-green); font-weight: 600;">{{ $c->company_name }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><a href="mailto:{{ $c->email }}" class="truncate-text sm" title="{{ $c->email }}" style="color: var(--brand-blue); text-decoration: none; font-size: 12px;">{{ $c->email }}</a></div>
                                <div style="font-size: 11px; color: var(--text-muted); font-family: var(--font-code); margin-top: 1px;">
                                    {{ $c->phone ?? '—' }}
                                    @if($c->platform_detected && $c->platform_detected !== 'Direct')
                                        <span style="font-size: 10px; background: #eaf3ef; color: var(--brand-forest); padding: 1px 6px; border-radius: 4px; font-weight: 600; margin-right: 4px;">{{ $c->platform_detected }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="truncate-text sm" title="{{ $c->project_type ?? 'عام' }}" style="color: var(--text-body); font-weight: 600;">
                                    {{ $c->project_type ?? 'عام' }}
                                </span>
                            </td>
                            <td style="font-family: var(--font-code); color: var(--brand-forest); font-weight: 700; font-size: 12.5px;">
                                {{ $c->budget ?? '—' }}
                            </td>
                            <td>
                                <span class="truncate-text md" title="{{ $c->message }}" style="font-size: 11.5px; color: var(--text-body);">
                                    {{ $c->message }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.consultations.status', $c->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="status-quick-select {{ $c->status }}" onchange="this.form.submit()" title="اضغط لتغيير الحالة فوراً">
                                        <option value="new" {{ $c->status === 'new' ? 'selected' : '' }}>طلب جديد</option>
                                        <option value="contacted" {{ $c->status === 'contacted' ? 'selected' : '' }}>تم التواصل</option>
                                        <option value="scheduled" {{ $c->status === 'scheduled' ? 'selected' : '' }}>تم حجز موعد</option>
                                        <option value="completed" {{ $c->status === 'completed' ? 'selected' : '' }}>مكتمل</option>
                                        <option value="archived" {{ $c->status === 'archived' ? 'selected' : '' }}>مؤرشف</option>
                                    </select>
                                </form>
                            </td>
                            <td style="font-size: 11.5px; font-family: var(--font-code); color: var(--text-muted);">
                                <div>{{ $c->created_at->format('Y-m-d') }}</div>
                                <small style="font-size: 10px; color: var(--brand-green);">{{ $c->created_at->diffForHumans() }}</small>
                            </td>
                            <td style="padding-left: 22px; text-align: left;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ route('admin.consultations.show', $c->id) }}" class="btn btn-outline btn-sm" title="معاينة التفاصيل">
                                        معاينة
                                    </a>
                                    <form action="{{ route('admin.consultations.destroy', $c->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="حذف">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 50px 20px; color: var(--text-muted);">
                                <div style="font-size: 14px; font-weight: 600; margin-bottom: 6px;">لا توجد طلبات استشارة في هذا القسم</div>
                                <div style="font-size: 12px;">سيتم إدراج أي طلب جديد فور إرساله من الموقع مباشرة.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($consultations->hasPages())
            <div style="padding: 16px 22px; border-top: 1px solid var(--border-subtle); background: #fafcfb;">
                {{ $consultations->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
