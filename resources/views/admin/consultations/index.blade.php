@extends('layouts.admin')

@section('title', 'طلبات الاستشارة والعملاء | OX Tech')
@section('header_title', 'طلبات الاستشارة الواردة')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">إدارة طلبات الاستشارة ({{ $consultations->total() }})</div>
    </div>

    <!-- Status Filter Badges -->
    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px;">
        <a href="{{ route('admin.consultations.index') }}" class="btn {{ !request('status') ? 'btn-lime' : 'btn-outline' }} btn-sm">
            الكل ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.consultations.index', ['status' => 'new']) }}" class="btn {{ request('status') == 'new' ? 'btn-lime' : 'btn-outline' }} btn-sm">
            جديد ({{ $statusCounts['new'] }})
        </a>
        <a href="{{ route('admin.consultations.index', ['status' => 'contacted']) }}" class="btn {{ request('status') == 'contacted' ? 'btn-lime' : 'btn-outline' }} btn-sm">
            تم التواصل ({{ $statusCounts['contacted'] }})
        </a>
        <a href="{{ route('admin.consultations.index', ['status' => 'scheduled']) }}" class="btn {{ request('status') == 'scheduled' ? 'btn-lime' : 'btn-outline' }} btn-sm">
            تم حجز موعد ({{ $statusCounts['scheduled'] }})
        </a>
        <a href="{{ route('admin.consultations.index', ['status' => 'completed']) }}" class="btn {{ request('status') == 'completed' ? 'btn-lime' : 'btn-outline' }} btn-sm">
            مكتمل ({{ $statusCounts['completed'] }})
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>العميل</th>
                    <th>البريد والهاتف</th>
                    <th>نوع المشروع</th>
                    <th>الميزانية</th>
                    <th>الرسالة / الفكرة</th>
                    <th>الحالة</th>
                    <th>تاريخ الإرسال</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultations as $c)
                    <tr>
                        <td>
                            <strong class="truncate-text sm" title="{{ $c->name }}" style="color: var(--text-heading);">{{ $c->name }}</strong>
                            @if($c->company_name)
                                <div class="truncate-text sm" title="{{ $c->company_name }}" style="font-size: 11px; color: var(--brand-green); font-weight: 600;">{{ $c->company_name }}</div>
                            @endif
                        </td>
                        <td>
                            <div><a href="mailto:{{ $c->email }}" class="truncate-text sm" title="{{ $c->email }}" style="color: var(--brand-blue); text-decoration: none;">{{ $c->email }}</a></div>
                            <small style="color: var(--text-muted); font-family: var(--font-code);">{{ $c->phone ?? '-' }}</small>
                        </td>
                        <td style="color: var(--text-body);">{{ $c->project_type ?? 'عام' }}</td>
                        <td style="font-family: var(--font-code); color: var(--brand-forest); font-weight: 700;">{{ $c->budget ?? '-' }}</td>
                        <td>
                            <span class="truncate-text md" title="{{ $c->message }}" style="font-size: 11.5px; color: var(--text-body);">
                                {{ $c->message }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $c->status }}">{{ $c->status_label }}</span>
                        </td>
                        <td style="font-size: 11.5px; font-family: var(--font-code); color: var(--text-muted);">
                            {{ $c->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('admin.consultations.show', $c->id) }}" class="btn btn-outline btn-sm">
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
                        <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            لا توجد طلبات استشارة في هذا القسم.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $consultations->links() }}
    </div>
</div>
@endsection
