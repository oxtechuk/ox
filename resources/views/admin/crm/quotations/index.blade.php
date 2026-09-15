@extends('layouts.admin')

@section('title', 'عروض الأسعار | OX Tech CRM')
@section('header_title', 'إدارة عروض الأسعار والمقترحات الفنية (Quotations)')

@push('admin-styles')
<style>
    .quotations-toolbar {
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

    .qtn-number-badge {
        font-family: var(--font-code);
        font-weight: 800;
        color: var(--brand-forest);
        font-size: 13px;
        letter-spacing: 0.5px;
    }
    .qtn-title-sub {
        font-size: 11.5px;
        color: var(--text-muted);
        margin-top: 2px;
    }
    .client-name-link {
        font-size: 13px;
        font-weight: 700;
        color: var(--brand-forest);
        text-decoration: none;
        transition: color 0.15s;
    }
    .client-name-link:hover {
        color: var(--brand-green);
    }
    .client-comp-sub {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 1px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
    }
    .status-pill::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .status-pill.accepted { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .status-pill.accepted::before { background: #10b981; }
    .status-pill.sent { background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }
    .status-pill.sent::before { background: #3b82f6; }
    .status-pill.declined { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .status-pill.declined::before { background: #ef4444; }
    .status-pill.expired { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .status-pill.expired::before { background: #f59e0b; }
    .status-pill.draft { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .status-pill.draft::before { background: #94a3b8; }
</style>
@endpush

@section('content')
<div>

    <!-- Header Actions & Search Toolbar -->
    <div class="quotations-toolbar">
        <div class="filter-tabs">
            <a href="{{ route('admin.crm.quotations.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">الكل</a>
            <a href="{{ route('admin.crm.quotations.index', ['status' => 'draft']) }}" class="filter-tab {{ request('status') === 'draft' ? 'active' : '' }}">مسودة</a>
            <a href="{{ route('admin.crm.quotations.index', ['status' => 'sent']) }}" class="filter-tab {{ request('status') === 'sent' ? 'active' : '' }}">مرسل للعميل</a>
            <a href="{{ route('admin.crm.quotations.index', ['status' => 'accepted']) }}" class="filter-tab {{ request('status') === 'accepted' ? 'active' : '' }}">معتمد / متعاقد</a>
            <a href="{{ route('admin.crm.quotations.index', ['status' => 'declined']) }}" class="filter-tab {{ request('status') === 'declined' ? 'active' : '' }}" style="color: #b91c1c;">مرفوض</a>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <form method="GET" action="{{ route('admin.crm.quotations.index') }}" style="display: flex; gap: 8px;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="search" class="form-control" style="width: 220px; padding: 7px 12px; font-size: 12px;" placeholder="بحث بالرقم أو العميل..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline btn-sm">بحث</button>
            </form>

            <a href="{{ route('admin.crm.quotations.create') }}" class="btn btn-lime btn-sm">
                <span>+ إنشاء عرض سعر جديد</span>
            </a>
        </div>
    </div>

    <!-- Quotations Table -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div class="table-responsive">
            <table class="admin-table" style="margin: 0;">
                <thead>
                    <tr>
                        <th style="padding-right: 22px;">رقم العرض والمقترح</th>
                        <th>العميل والجهة</th>
                        <th>تاريخ العرض</th>
                        <th>المجموع قبل الخصم</th>
                        <th>الإجمالي الكلي (VAT)</th>
                        <th>الحالة</th>
                        <th style="padding-left: 22px; text-align: left;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotations as $quotation)
                        <tr>
                            <td style="padding-right: 22px;">
                                <div class="qtn-number-badge">{{ $quotation->quotation_number }}</div>
                                <div class="qtn-title-sub truncate-text md" title="{{ $quotation->title }}">{{ $quotation->title }}</div>
                            </td>
                            <td>
                                <div>
                                    <a href="{{ route('admin.crm.clients.show', $quotation->client) }}" class="client-name-link truncate-text sm" title="{{ $quotation->client->name }}">
                                        {{ $quotation->client->name }}
                                    </a>
                                    @if($quotation->client->company_name)
                                        <div class="client-comp-sub truncate-text sm" title="{{ $quotation->client->company_name }}">{{ $quotation->client->company_name }}</div>
                                    @endif
                                </div>
                            </td>
                            <td style="font-size: 12px; color: var(--text-muted); font-family: var(--font-code);">
                                {{ $quotation->quotation_date ? $quotation->quotation_date->format('Y-m-d') : ($quotation->created_at ? $quotation->created_at->format('Y-m-d') : '—') }}
                            </td>
                            <td>
                                <div style="font-family: var(--font-code); color: var(--text-body); font-size: 12.5px;">
                                    {{ number_format($quotation->subtotal, 2) }} {{ $quotation->currency }}
                                </div>
                                @if($quotation->discount_amount > 0)
                                    <div style="font-size: 11px; color: #047857; font-family: var(--font-code); margin-top: 1px;">
                                        خصم: -{{ number_format($quotation->discount_amount, 2) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 800; color: var(--text-heading); font-family: var(--font-code); font-size: 13.5px;">
                                    {{ number_format($quotation->total_amount, 2) }} <small style="font-size: 10px; font-weight: 600; color: var(--text-muted);">{{ $quotation->currency }}</small>
                                </div>
                            </td>
                            <td>
                                @if($quotation->status === 'accepted')
                                    <span class="status-pill accepted">معتمد / تعاقد</span>
                                @elseif($quotation->status === 'sent')
                                    <span class="status-pill sent">مرسل للعميل</span>
                                @elseif($quotation->status === 'declined')
                                    <span class="status-pill declined">مرفوض</span>
                                @elseif($quotation->status === 'expired')
                                    <span class="status-pill expired">منتهي الصلاحية</span>
                                @else
                                    <span class="status-pill draft">مسودة</span>
                                @endif
                            </td>
                            <td style="padding-left: 22px; text-align: left;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ route('admin.crm.quotations.show', $quotation) }}" class="btn btn-outline btn-sm" title="تفاصيل عرض السعر">
                                        تفاصيل
                                    </a>
                                    <a href="{{ route('admin.crm.quotations.edit', $quotation) }}" class="btn btn-outline btn-sm" title="تعديل">
                                        تعديل
                                    </a>
                                    @if($quotation->status === 'accepted')
                                        <form action="{{ route('admin.crm.quotations.convert_to_invoice', $quotation) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل تريد تحويل هذا العرض المعتمد إلى فاتورة رسمية؟');">
                                            @csrf
                                            <button type="submit" class="btn btn-lime btn-sm" title="تحويل لفاتورة">تحويل لفاتورة</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 50px 20px;">
                                <div style="font-size: 14px; font-weight: 600; margin-bottom: 6px;">لا توجد عروض أسعار مسجلة حالياً</div>
                                <div style="font-size: 12px; color: var(--text-muted);">يمكنك إنشاء عرض سعر جديد بالضغط على الزر أعلاه.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($quotations->hasPages())
            <div style="padding: 16px 22px; border-top: 1px solid var(--border-subtle); background: #fafcfb;">
                {{ $quotations->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
