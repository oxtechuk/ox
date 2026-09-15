@extends('layouts.admin')

@section('title', 'إدارة العملاء والمديونيات | OX Tech CRM')
@section('header_title', 'نظام إدارة العملاء (CRM) وسجل المستحقات')

@section('content')
<div>

    <!-- Financial KPI Summary Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 24px;">
        <div class="card" style="margin-bottom: 0; border-right: 4px solid var(--brand-forest);">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">إجمالي العملاء المسجلين</div>
            <div style="font-size: 24px; font-weight: 800; color: var(--text-heading); font-family: var(--font-code);">{{ $totalClients }} <span style="font-size: 13px; font-weight: 600; color: var(--text-muted);">عميل</span></div>
        </div>

        <div class="card" style="margin-bottom: 0; border-right: 4px solid var(--brand-blue);">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">إجمالي المبيعات المفوترة</div>
            <div style="font-size: 24px; font-weight: 800; color: var(--text-heading); font-family: var(--font-code);">{{ number_format($totalBilled, 2) }} <span style="font-size: 13px; font-weight: 600; color: var(--text-muted);">SAR</span></div>
        </div>

        <div class="card" style="margin-bottom: 0; border-right: 4px solid #10b981;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">إجمالي الإيرادات المحصلة</div>
            <div style="font-size: 24px; font-weight: 800; color: #047857; font-family: var(--font-code);">{{ number_format($totalCollected, 2) }} <span style="font-size: 13px; font-weight: 600; color: var(--text-muted);">SAR</span></div>
        </div>

        <div class="card" style="margin-bottom: 0; border-right: 4px solid #ef4444;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">المستحقات والديون الآجلة (Due)</div>
            <div style="font-size: 24px; font-weight: 800; color: #b91c1c; font-family: var(--font-code);">{{ number_format($totalOutstanding, 2) }} <span style="font-size: 13px; font-weight: 600; color: #b91c1c;">SAR</span></div>
        </div>
    </div>

    <!-- Actions & Filter Bar -->
    <div class="card">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 15px;">
            <form method="GET" action="{{ route('admin.crm.clients.index') }}" style="display: flex; flex-wrap: wrap; gap: 10px; flex: 1; min-width: 300px;">
                <input type="text" name="search" class="form-control" style="max-width: 250px;" placeholder="بحث بالاسم، الشركة، البريد..." value="{{ request('search') }}">
                
                <select name="status" class="form-control" style="max-width: 150px;">
                    <option value="">جميع الحالات</option>
                    <option value="lead" {{ request('status') === 'lead' ? 'selected' : '' }}>محتمل جديد (Lead)</option>
                    <option value="prospect" {{ request('status') === 'prospect' ? 'selected' : '' }}>قيد التفاوض (Prospect)</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>عميل نشط (Active)</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>

                <button type="submit" class="btn btn-outline">تصفية</button>
                @if(request()->hasAny(['search', 'status', 'country']))
                    <a href="{{ route('admin.crm.clients.index') }}" class="btn btn-outline" style="color: #b91c1c;">إلغاء الفلتر</a>
                @endif
            </form>

            <a href="{{ route('admin.crm.clients.create') }}" class="btn btn-lime">
                <span>إضافة عميل جديد</span>
            </a>
        </div>
    </div>

    <!-- Clients Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>العميل / المنشأة</th>
                        <th>بيانات التواصل</th>
                        <th>الدولة / المدينة</th>
                        <th>الحالة</th>
                        <th>مصدر العميل</th>
                        <th>إجمالي المعاملات</th>
                        <th>المستحق الآجل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td>
                                <div>
                                    <strong class="truncate-text sm" title="{{ $client->name }}" style="color: var(--text-heading); font-size: 13.5px;">{{ $client->name }}</strong>
                                    @if($client->company_name)
                                        <div class="truncate-text sm" title="{{ $client->company_name }}" style="font-size: 11px; color: var(--brand-green); font-weight: 600;">{{ $client->company_name }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div><a href="mailto:{{ $client->email }}" class="truncate-text sm" title="{{ $client->email }}" style="color: var(--brand-blue); text-decoration: none;">{{ $client->email }}</a></div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $client->phone ?? '—' }}</div>
                            </td>
                            <td>
                                <span>{{ $client->country ?? 'السعودية' }}</span>
                                @if($client->city) <small style="color: var(--text-muted);">({{ $client->city }})</small> @endif
                            </td>
                            <td>
                                @if($client->status === 'active')
                                    <span class="status-badge" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">عميل نشط</span>
                                @elseif($client->status === 'prospect')
                                    <span class="status-badge" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">قيد التفاوض</span>
                                @elseif($client->status === 'lead')
                                    <span class="status-badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe;">محتمل جديد</span>
                                @else
                                    <span class="status-badge" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <span style="font-size: 11px; background: #f1f5f9; padding: 3px 8px; border-radius: 4px; color: var(--text-body); font-weight: 600;">
                                    {{ $client->lead_source ?? 'Direct' }}
                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--text-heading); font-family: var(--font-code);">
                                    {{ number_format($client->total_billed, 2) }} SAR
                                </div>
                                <div style="font-size: 11px; color: #047857; font-weight: 600;">محصل: {{ number_format($client->total_paid, 2) }} SAR</div>
                            </td>
                            <td>
                                @if($client->outstanding_balance > 0)
                                    <span style="font-weight: 800; color: #b91c1c; font-family: var(--font-code); background: #fef2f2; padding: 3px 8px; border-radius: 6px; border: 1px solid #fee2e2;">
                                        {{ number_format($client->outstanding_balance, 2) }} SAR
                                    </span>
                                @else
                                    <span style="color: #047857; font-size: 11.5px; font-weight: 600;">مسدد بالكامل</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('admin.crm.clients.show', $client) }}" class="btn btn-outline btn-sm">تفاصيل</a>
                                    <a href="{{ route('admin.crm.quotations.create', ['client_id' => $client->id]) }}" class="btn btn-outline btn-sm">عرض سعر</a>
                                    <a href="{{ route('admin.crm.clients.edit', $client) }}" class="btn btn-outline btn-sm">تعديل</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                لا يوجد عملاء مسجلين حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $clients->links() }}
        </div>
    </div>

</div>
@endsection
