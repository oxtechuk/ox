@extends('layouts.admin')

@section('title', 'تفاصيل طلب الاستشارة: ' . $consultation->name . ' | OX Tech')
@section('header_title', 'تفاصيل طلب الاستشارة')

@section('content')
<div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 24px;">
    <!-- Lead Details -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">بيانات العميل وفكرة المشروع</div>
            <a href="{{ route('admin.consultations.index') }}" class="btn btn-outline btn-sm">رجوع لكل الطلبات</a>
        </div>

        <div style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid var(--border-subtle);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                <div>
                    <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-bottom: 4px;">{{ $consultation->name }}</h2>
                    <span style="font-size: 12px; color: var(--brand-green); font-weight: 600;">{{ $consultation->company_name ?? 'عميل فردي / شركة ناشئة' }}</span>
                </div>
                <span class="status-badge {{ $consultation->status }}" style="font-size: 12px; padding: 6px 14px;">
                    {{ $consultation->status_label }}
                </span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 14px; margin-top: 15px;">
                <div>
                    <small style="color: var(--text-muted); display: block; font-size: 11px;">البريد الإلكتروني:</small>
                    <a href="mailto:{{ $consultation->email }}" style="color: var(--brand-blue); font-size: 12.5px; text-decoration: none; font-weight: 600;">{{ $consultation->email }}</a>
                </div>
                <div>
                    <small style="color: var(--text-muted); display: block; font-size: 11px;">رقم الجوال / واتساب:</small>
                    @if($consultation->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $consultation->phone) }}" target="_blank" style="color: var(--brand-forest); font-size: 12.5px; text-decoration: none; font-family: var(--font-code); font-weight: 600;">
                            {{ $consultation->phone }}
                        </a>
                    @else
                        <span style="color: var(--text-muted); font-size: 12px;">غير متوفر</span>
                    @endif
                </div>
                <div>
                    <small style="color: var(--text-muted); display: block; font-size: 11px;">نوع المشروع:</small>
                    <strong style="color: var(--text-heading); font-size: 12.5px;">{{ $consultation->project_type ?? 'غير محدد' }}</strong>
                </div>
                <div>
                    <small style="color: var(--text-muted); display: block; font-size: 11px;">الميزانية التقديرية:</small>
                    <strong style="color: var(--brand-forest); font-size: 12.5px; font-family: var(--font-code);">{{ $consultation->budget ?? 'غير محدد' }}</strong>
                </div>
            </div>
        </div>

        <div>
            <h4 style="font-size: 13px; font-weight: 800; color: var(--text-heading); margin-bottom: 10px;">تفاصيل الفكرة أو التحدي المطروح:</h4>
            <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid var(--border-card); font-size: 13px; line-height: 2; color: var(--text-body); white-space: pre-line;">
                {{ $consultation->message }}
            </div>
        </div>
    </div>

    <!-- Status & Team Notes -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">متابعة الطلب وتحديث الحالة</div>
        </div>

        <form action="{{ route('admin.consultations.status', $consultation->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div style="margin-bottom: 20px;">
                <label class="form-label">حالة الطلب الحالية</label>
                <select name="status" class="form-control">
                    <option value="new" {{ $consultation->status == 'new' ? 'selected' : '' }}>طلب جديد (New)</option>
                    <option value="contacted" {{ $consultation->status == 'contacted' ? 'selected' : '' }}>تم التواصل مع العميل (Contacted)</option>
                    <option value="scheduled" {{ $consultation->status == 'scheduled' ? 'selected' : '' }}>تم تحديد موعد استشارة (Scheduled)</option>
                    <option value="completed" {{ $consultation->status == 'completed' ? 'selected' : '' }}>مكتمل ومغلق بنجاح (Completed)</option>
                    <option value="archived" {{ $consultation->status == 'archived' ? 'selected' : '' }}>مؤرشف (Archived)</option>
                </select>
            </div>

            <div style="margin-bottom: 25px;">
                <label class="form-label">ملاحظات الفريق الداخلي (Admin Notes)</label>
                <textarea name="admin_notes" rows="6" class="form-control" placeholder="اكتب هنا نتائج التواصل مع العميل، موعد الاجتماع، أو تفاصيل العرض الفني...">{{ old('admin_notes', $consultation->admin_notes) }}</textarea>
            </div>

            <button type="submit" class="btn btn-lime" style="width: 100%; justify-content: center; padding: 10px 0;">
                <span>تحديث الحالة وحفظ الملاحظات</span>
            </button>
        </form>
    </div>
</div>
@endsection
