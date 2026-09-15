@extends('layouts.admin')

@section('title', 'عروض الأسعار | OX Tech CRM')
@section('header_title', 'إدارة عروض الأسعار والمقترحات الفنية (Quotations)')

@section('content')
<div>

    <!-- Header Actions & Search -->
    <div class="card">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 15px;">
            <form method="GET" action="{{ route('admin.crm.quotations.index') }}" style="display: flex; flex-wrap: wrap; gap: 10px; flex: 1;">
                <input type="text" name="search" class="form-control" style="max-width: 250px;" placeholder="بحث بالرقم، المشروع، العميل..." value="{{ request('search') }}">
                
                <select name="status" class="form-control" style="max-width: 160px;">
                    <option value="">جميع الحالات</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>مسودة</option>
                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>مرسل للعميل</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>معتمد / تم التعاقد</option>
                    <option value="declined" {{ request('status') === 'declined' ? 'selected' : '' }}>مرفوض</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>منتهي الصلاحية</option>
                </select>

                <button type="submit" class="btn btn-outline">بحث</button>
            </form>

            <a href="{{ route('admin.crm.quotations.create') }}" class="btn btn-lime">
                <span>إنشاء عرض سعر جديد</span>
            </a>
        </div>
    </div>

    <!-- Quotations Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>رقم العرض</th>
                        <th>العميل المستهدف</th>
                        <th>عنوان المشروع / المقترح</th>
                        <th>التاريخ</th>
                        <th>المجموع قبل الخصم</th>
                        <th>قيمة الخصم</th>
                        <th>الإجمالي الكلي (VAT)</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotations as $quotation)
                        <tr>
                            <td><strong style="color: var(--brand-forest); font-family: var(--font-code);">{{ $quotation->quotation_number }}</strong></td>
                            <td>
                                <div>
                                    <a href="{{ route('admin.crm.clients.show', $quotation->client) }}" class="truncate-text sm" title="{{ $quotation->client->name }}" style="color: var(--brand-forest); font-weight: 700; text-decoration: none;">{{ $quotation->client->name }}</a>
                                    @if($quotation->client->company_name)
                                        <div class="truncate-text sm" title="{{ $quotation->client->company_name }}" style="font-size: 11px; color: var(--text-muted);">{{ $quotation->client->company_name }}</div>
                                    @endif
                                </div>
                            </td>
                            <td><strong class="truncate-text md" title="{{ $quotation->title }}" style="color: var(--text-body);">{{ $quotation->title }}</strong></td>
                            <td style="font-size: 12px; color: var(--text-muted);">{{ $quotation->quotation_date ? $quotation->quotation_date->format('Y-m-d') : ($quotation->created_at ? $quotation->created_at->format('Y-m-d') : '—') }}</td>
                            <td style="font-family: var(--font-code);">{{ number_format($quotation->subtotal, 2) }} {{ $quotation->currency }}</td>
                            <td style="color: #047857; font-family: var(--font-code);">
                                @if($quotation->discount_amount > 0)
                                    -{{ number_format($quotation->discount_amount, 2) }} {{ $quotation->currency }}
                                @else
                                    —
                                @endif
                            </td>
                            <td style="font-weight: 800; color: var(--text-heading); font-family: var(--font-code);">
                                {{ number_format($quotation->total_amount, 2) }} {{ $quotation->currency }}
                            </td>
                            <td>
                                @if($quotation->status === 'accepted')
                                    <span class="status-badge" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">معتمد</span>
                                @elseif($quotation->status === 'sent')
                                    <span class="status-badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe;">مرسل للعميل</span>
                                @elseif($quotation->status === 'declined')
                                    <span class="status-badge" style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">مرفوض</span>
                                @elseif($quotation->status === 'expired')
                                    <span class="status-badge" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">منتهي الصلاحية</span>
                                @else
                                    <span class="status-badge" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;">مسودة</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('admin.crm.quotations.show', $quotation) }}" class="btn btn-outline btn-sm">تفاصيل</a>
                                    <a href="{{ route('admin.crm.quotations.edit', $quotation) }}" class="btn btn-outline btn-sm">تعديل</a>
                                    @if($quotation->status === 'accepted')
                                        <form action="{{ route('admin.crm.quotations.convert_to_invoice', $quotation) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل تريد تحويل هذا العرض المعتمد إلى فاتورة رسمية؟');">
                                            @csrf
                                            <button type="submit" class="btn btn-lime btn-sm">تحويل لفاتورة</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: var(--text-muted); padding: 35px;">لا توجد عروض أسعار مسجلة بعد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $quotations->links() }}
        </div>
    </div>

</div>
@endsection
