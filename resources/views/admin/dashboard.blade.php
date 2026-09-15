@extends('layouts.admin')

@section('title', 'لوحة الإحصائيات | OX Tech')
@section('header_title', 'نظرة عامة على الإحصائيات والأداء')

@push('admin-styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-card {
        background: #ffffff;
        border: 1px solid var(--border-card);
        border-radius: 12px;
        padding: 22px;
        position: relative;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }
    .stat-label {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
        margin-bottom: 8px;
    }
    .stat-number {
        font: 800 32px/1 'Space Grotesk', var(--font);
        color: var(--text-heading);
    }
    .stat-number.green {
        color: var(--brand-green);
    }
    .stat-number.blue {
        color: var(--brand-blue);
    }
    .quick-actions-bar {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }
    .dashboard-two-cols {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 24px;
    }
    @media (max-width: 900px) {
        .dashboard-two-cols {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div>
    <!-- Quick Actions Bar -->
    <div class="quick-actions-bar">
        <a href="{{ route('admin.projects.create') }}" class="btn btn-lime">
            <span>إضافة مشروع جديد</span>
        </a>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-outline">
            <span>إضافة فيديو ريفيو</span>
        </a>
        <a href="{{ route('admin.site-content.index') }}" class="btn btn-outline">
            <span>تعديل نصوص وعناصر الموقع</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card" style="border-top: 3px solid var(--brand-green);">
            <div class="stat-label">إجمالي المشاريع والأعمال</div>
            <div class="stat-number green">{{ $stats['total_projects'] }}</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #f59e0b;">
            <div class="stat-label">طلبات الاستشارة الجديدة</div>
            <div class="stat-number {{ $stats['new_consultations'] > 0 ? 'green' : '' }}">{{ $stats['new_consultations'] }}</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid var(--brand-blue);">
            <div class="stat-label">فيديوهات وقصص الشركاء</div>
            <div class="stat-number blue">{{ $stats['active_testimonials'] }}</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #64748b;">
            <div class="stat-label">إجمالي الاستشارات المستلمة</div>
            <div class="stat-number">{{ $stats['total_consultations'] }}</div>
        </div>
    </div>

    <!-- Two Columns Layout -->
    <div class="dashboard-two-cols">
        <!-- Recent Consultations -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">أحدث طلبات الاستشارة الواردة</div>
                <a href="{{ route('admin.consultations.index') }}" class="btn btn-outline btn-sm">عرض الكل</a>
            </div>

            @if($recentConsultations->count() > 0)
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>العميل</th>
                                <th>نوع المشروع</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentConsultations as $c)
                                <tr>
                                    <td>
                                        <strong class="truncate-text sm" title="{{ $c->name }}">{{ $c->name }}</strong>
                                        <div class="truncate-text sm" title="{{ $c->email }}" style="font-size: 11px; color: var(--text-muted);">{{ $c->email }}</div>
                                    </td>
                                    <td>
                                        <span class="truncate-text sm" title="{{ $c->project_type ?? 'عام' }}">{{ $c->project_type ?? 'عام' }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $c->status }}">{{ $c->status_label }}</span>
                                    </td>
                                    <td style="font-size: 12px; font-family: 'Space Grotesk'; color: var(--text-muted);">
                                        {{ $c->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.consultations.show', $c->id) }}" class="btn btn-outline btn-sm">
                                            معاينة
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: var(--text-muted); padding: 25px 0;">لا توجد طلبات استشارة واردة حالياً.</p>
            @endif
        </div>

        <!-- Recent Projects -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">المشاريع الحديثة</div>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline btn-sm">إدارة المشاريع</a>
            </div>

            @if($recentProjects->count() > 0)
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>المشروع</th>
                                <th>السوق / القطاع</th>
                                <th>المدة</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentProjects as $p)
                                <tr>
                                    <td>
                                        <strong class="truncate-text sm" title="{{ $p->title }}">{{ $p->title }}</strong>
                                        <div class="truncate-text sm" title="{{ $p->subtitle }}" style="font-size: 11px; color: var(--brand-green);">{{ $p->subtitle }}</div>
                                    </td>
                                    <td>
                                        <span class="truncate-text sm" title="{{ $p->country_name }} · {{ $p->sector_name }}">{{ $p->country_name }} · {{ $p->sector_name }}</span>
                                    </td>
                                    <td>{{ $p->duration ?? '-' }}</td>
                                    <td>
                                        <div style="display: flex; gap: 6px;">
                                            <a href="{{ route('admin.projects.edit', $p->id) }}" class="btn btn-outline btn-sm">تعديل</a>
                                            <a href="{{ route('projects.show', $p->slug) }}" target="_blank" class="btn btn-outline btn-sm">معاينة</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: var(--text-muted); padding: 25px 0;">لم يتم إضافة مشاريع بعد.</p>
            @endif
        </div>
    </div>
</div>
@endsection
