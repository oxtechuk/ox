@extends('layouts.admin')

@section('title', 'عرض سعر: ' . $quotation->quotation_number . ' | OX Tech CRM')
@section('header_title', 'عرض السعر الفني والمالي: ' . $quotation->quotation_number)

@section('content')
<div style="max-width: 950px; margin: 0 auto;">

    <!-- Action Toolbar (hidden on print) -->
    <div class="card" style="margin-bottom: 20px;" id="actionToolbar">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 10px;">
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.crm.quotations.index') }}" class="btn btn-outline btn-sm">قائمة العروض</a>
                <a href="{{ route('admin.crm.clients.show', $quotation->client) }}" class="btn btn-outline btn-sm">ملف العميل</a>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <button type="button" class="btn btn-outline btn-sm" onclick="window.print()">طباعة / PDF</button>

                <button type="button" class="btn btn-outline btn-sm" style="color: var(--brand-blue); border-color: #cbd5e1;" onclick="document.getElementById('emailModal').style.display='flex'">
                    إرسال للعميل بالبريد
                </button>

                @if($quotation->status === 'accepted')
                    <form action="{{ route('admin.crm.quotations.convert_to_invoice', $quotation) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل تريد تحويل هذا العرض المعتمد إلى فاتورة رسمية؟');">
                        @csrf
                        <button type="submit" class="btn btn-lime btn-sm">تحويل إلى فاتورة رسمية</button>
                    </form>
                @endif

                <a href="{{ route('admin.crm.quotations.edit', $quotation) }}" class="btn btn-outline btn-sm">تعديل</a>

                <form action="{{ route('admin.crm.quotations.destroy', $quotation) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا العرض؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Luxury Tech Printable Quotation Sheet -->
    <div class="card" style="background: #ffffff; border: 1px solid var(--border-card); padding: 40px; border-radius: 14px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);" id="printableQuotation">

        <!-- Quotation Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid var(--border-card); padding-bottom: 25px; margin-bottom: 30px;">
            <div>
                <h1 style="font-size: 28px; font-weight: 800; color: var(--brand-forest); margin: 0; font-family: var(--font-code);">
                    OX<span style="color: var(--brand-green);">.</span>TECH
                </h1>
                <p style="margin: 4px 0 0; font-size: 13px; color: var(--text-muted); font-weight: 500;">حلول هندسة البرمجيات والأنظمة السحابية الذكية</p>
                <p style="margin: 2px 0 0; font-size: 11px; color: #94a3b8;">الرياض (السعودية) • دبي (الإمارات) • القاهرة (مصر)</p>
            </div>

            <div style="text-align: left;">
                <span style="background: #eaf3ef; color: var(--brand-green); padding: 4px 14px; border-radius: 99px; font-size: 11.5px; font-weight: 700; border: 1px solid #c8e4d8;">
                    عرض سعر فني ومالي
                </span>
                <div style="font-size: 18px; font-weight: 800; color: var(--text-heading); font-family: var(--font-code); margin-top: 8px;">
                    {{ $quotation->quotation_number }}
                </div>
                <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">
                    التاريخ: {{ $quotation->quotation_date ? $quotation->quotation_date->format('Y-m-d') : ($quotation->created_at ? $quotation->created_at->format('Y-m-d') : '—') }}
                </div>
                @if($quotation->valid_until)
                    <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 2px;">
                        صالح حتى: {{ $quotation->valid_until->format('Y-m-d') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Client & Subject Details -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f8fafc; border: 1px solid var(--border-card); border-radius: 10px; padding: 20px; margin-bottom: 30px;">
            <div>
                <div style="font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">مقدم إلى السادة /</div>
                <div style="font-size: 16px; font-weight: 800; color: var(--text-heading);">{{ $quotation->client->name }}</div>
                @if($quotation->client->company_name)
                    <div style="font-size: 13px; color: var(--brand-green); font-weight: 600; margin-top: 2px;">{{ $quotation->client->company_name }}</div>
                @endif
                <div style="font-size: 12px; color: var(--text-body); margin-top: 4px;">{{ $quotation->client->email }} | {{ $quotation->client->phone ?? '—' }}</div>
                <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">{{ $quotation->client->country ?? 'السعودية' }}</div>
            </div>

            <div>
                <div style="font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">المشروع / المقترح /</div>
                <div style="font-size: 16px; font-weight: 800; color: var(--text-heading);">{{ $quotation->title }}</div>
                <div style="font-size: 12px; color: var(--text-muted); margin-top: 6px;">
                    حالة العرض: 
                    @if($quotation->status === 'accepted')
                        <strong style="color: #047857;">معتمد</strong>
                    @elseif($quotation->status === 'sent')
                        <strong style="color: #1d4ed8;">مرسل للعميل</strong>
                    @else
                        <strong style="color: var(--text-muted);">مسودة</strong>
                    @endif
                </div>
            </div>
        </div>

        <!-- Line Items Table -->
        <div style="margin-bottom: 30px;">
            <table class="admin-table" style="background: #ffffff; border: 1px solid var(--border-card); border-radius: 8px; overflow: hidden;">
                <thead>
                    <tr>
                        <th width="5%" style="text-align: center;">#</th>
                        <th width="45%">الخدمة / البند البرمجي</th>
                        <th width="15%" style="text-align: center;">الكمية</th>
                        <th width="15%" style="text-align: center;">سعر الوحدة</th>
                        <th width="20%" style="text-align: left;">الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotation->items as $idx => $item)
                        <tr>
                            <td style="text-align: center; color: var(--text-muted); font-family: var(--font-code);">{{ $idx + 1 }}</td>
                            <td>
                                <strong style="color: var(--text-heading); font-size: 13px;">{{ $item->service_name }}</strong>
                                @if($item->description)
                                    <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 2px;">{{ $item->description }}</div>
                                @endif
                            </td>
                            <td style="text-align: center; font-family: var(--font-code); color: var(--text-body);">{{ $item->quantity }}</td>
                            <td style="text-align: center; font-family: var(--font-code); color: var(--text-body);">{{ number_format($item->unit_price, 2) }} {{ $quotation->currency }}</td>
                            <td style="text-align: left; font-family: var(--font-code); font-weight: 700; color: var(--text-heading);">{{ number_format($item->total_price, 2) }} {{ $quotation->currency }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Financial Breakdown Block -->
        <div style="display: flex; justify-content: flex-end; margin-bottom: 30px;">
            <div style="width: 380px; background: #f8fafc; border: 1px solid var(--border-card); border-radius: 10px; padding: 20px;">
                <div style="display: flex; justify-content: space-between; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">
                    <span>المجموع الفرعي:</span>
                    <strong style="color: var(--text-heading); font-family: var(--font-code);">{{ number_format($quotation->subtotal, 2) }} {{ $quotation->currency }}</strong>
                </div>

                @if($quotation->discount_amount > 0)
                    <div style="display: flex; justify-content: space-between; font-size: 13px; color: #047857; margin-bottom: 8px;">
                        <span>الخصم الممنوح ({{ $quotation->discount_type === 'percentage' ? $quotation->discount_value.'%' : 'مبلغ ثابت' }}):</span>
                        <strong style="font-family: var(--font-code);">- {{ number_format($quotation->discount_amount, 2) }} {{ $quotation->currency }}</strong>
                    </div>
                @endif

                <div style="display: flex; justify-content: space-between; font-size: 13px; color: var(--text-muted); margin-bottom: 12px;">
                    <span>ضريبة القيمة المضافة ({{ $quotation->vat_rate }}%):</span>
                    <strong style="color: var(--text-heading); font-family: var(--font-code);">{{ number_format($quotation->vat_amount, 2) }} {{ $quotation->currency }}</strong>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 800; color: var(--brand-forest); border-top: 2px solid var(--border-card); padding-top: 10px;">
                    <span>الإجمالي الكلي:</span>
                    <span style="font-family: var(--font-code);">{{ number_format($quotation->total_amount, 2) }} {{ $quotation->currency }}</span>
                </div>
            </div>
        </div>

        <!-- Notes & Terms Block -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; font-size: 12px; color: var(--text-muted); border-top: 1px solid var(--border-subtle); padding-top: 20px;">
            <div>
                <strong style="color: var(--brand-forest); display: block; margin-bottom: 6px;">ملاحظات العرض الفني:</strong>
                <p style="margin: 0; line-height: 1.6; color: var(--text-body);">{{ $quotation->notes ?? 'لا توجد ملاحظات إضافية.' }}</p>
            </div>
            <div>
                <strong style="color: var(--brand-forest); display: block; margin-bottom: 6px;">الشروط والأحكام والتعاقد:</strong>
                <p style="margin: 0; line-height: 1.6; color: var(--text-body);">{{ $quotation->terms_conditions ?? 'العرض ساري لمدة 30 يوماً من تاريخ صدوره.' }}</p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 35px; padding-top: 20px; border-top: 1px solid #f1f5f9; font-size: 11px; color: #94a3b8;">
            OX Tech Software House • المملكة العربية السعودية • مصر • الإمارات
        </div>
    </div>

</div>

<!-- Email Modal -->
<div id="emailModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; border: 1px solid var(--border-card); border-radius: 12px; max-width: 500px; width: 100%; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <h3 style="color: var(--text-heading); margin-bottom: 15px; font-size: 16px; font-weight: 800;">إرسال عرض السعر إلى العميل</h3>
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 15px;">
            سيتم إرسال هذا العرض بصيغة HTML أنيقة إلى البريد: <strong style="color: var(--brand-forest);">{{ $quotation->client->email }}</strong>
        </p>

        <form action="{{ route('admin.crm.quotations.send_email', $quotation) }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label class="form-label">رسالة مخصصة تظهر في مقدمة البريد (اختياري)</label>
                <textarea name="custom_message" class="form-control" rows="3" placeholder="مرحباً، يسعدنا تقديم عرض السعر المالي والفني لتنفيذ مشروعكم..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('emailModal').style.display='none'">إلغاء</button>
                <button type="submit" class="btn btn-lime btn-sm">إرسال البريد الآن</button>
            </div>
        </form>
    </div>
</div>

<style>
@media print {
    body {
        background: #fff !important;
        color: #000 !important;
    }
    .admin-sidebar, .admin-topbar, #actionToolbar, .alert-box {
        display: none !important;
    }
    .admin-main {
        margin: 0 !important;
        padding: 0 !important;
    }
    #printableQuotation {
        background: #fff !important;
        color: #000 !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
    #printableQuotation * {
        color: #000 !important;
    }
}
</style>
@endsection
