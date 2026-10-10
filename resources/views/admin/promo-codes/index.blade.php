@extends('layouts.admin')

@section('title', 'إدارة كوبونات وأكواد الخصم | OX Tech')
@section('header_title', 'إدارة كوبونات وأكواد الخصم (Promo Codes)')

@section('content')
<div class="admin-content-inner">

    {{-- Header Action --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
        <div>
            <h1 class="topbar-title" style="margin: 0;">🏷️ كوبونات وأكواد الخصم</h1>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">
                إنشاء وتعديل أكواد الخصم الترويجية وتحديد نسب الخصم وتواريخ انتهاء الصلاحية
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.promo-codes.create') }}" class="btn btn-lime">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>إنشاء كود خصم جديد</span>
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert-box alert-success" style="display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 14px; padding: 18px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">إجمالي الأكواد</div>
            <div style="font-size: 26px; font-weight: 800; color: #1E293B; font-family: var(--font-code);">
                {{ $stats['total'] }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 14px; padding: 18px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">أكواد سارية ونشطة</div>
            <div style="font-size: 26px; font-weight: 800; color: #059669; font-family: var(--font-code);">
                {{ $stats['active'] }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 14px; padding: 18px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">إجمالي مرات الاستخدام</div>
            <div style="font-size: 26px; font-weight: 800; color: #2563EB; font-family: var(--font-code);">
                {{ $stats['total_uses'] }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 14px; padding: 18px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">أكواد منتهية الصلاحية</div>
            <div style="font-size: 26px; font-weight: 800; color: #DC2626; font-family: var(--font-code);">
                {{ $stats['expired'] }}
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="card" style="margin-bottom: 20px; padding: 16px 20px;">
        <form action="{{ route('admin.promo-codes.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 220px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث باسم الكود أو الوصف..." class="form-control" style="font-size: 13px;">
            </div>

            <div style="min-width: 160px;">
                <select name="status" class="form-control" style="font-size: 13px;">
                    <option value="">جميع الحالات</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط وسارٍ</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>معطّل</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>منتهي الصلاحية</option>
                </select>
            </div>

            <button type="submit" class="btn btn-outline" style="font-size: 13px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span>تصفية</span>
            </button>

            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-outline" style="font-size: 13px; color: #DC2626;">
                    إلغاء الفلتر
                </a>
            @endif
        </form>
    </div>

    {{-- Promo Codes Table --}}
    <div class="card" style="padding: 0; overflow: hidden;">
        <div class="table-responsive">
            <table class="data-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-surface); border-bottom: 1px solid var(--border-card); text-align: right;">
                        <th style="padding: 14px 18px; font-size: 12px; font-weight: 800; color: var(--text-muted);">الكود الترويجي</th>
                        <th style="padding: 14px 18px; font-size: 12px; font-weight: 800; color: var(--text-muted);">قيمة الخصم</th>
                        <th style="padding: 14px 18px; font-size: 12px; font-weight: 800; color: var(--text-muted);">المنتج المخصص</th>
                        <th style="padding: 14px 18px; font-size: 12px; font-weight: 800; color: var(--text-muted);">صلاحية الكود</th>
                        <th style="padding: 14px 18px; font-size: 12px; font-weight: 800; color: var(--text-muted);">مرات الاستخدام</th>
                        <th style="padding: 14px 18px; font-size: 12px; font-weight: 800; color: var(--text-muted);">الحالة</th>
                        <th style="padding: 14px 18px; font-size: 12px; font-weight: 800; color: var(--text-muted); text-align: left;">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promoCodes as $code)
                        @php
                            $isExpired = $code->valid_until && now()->gt($code->valid_until);
                            $isMaxReached = $code->max_uses && $code->used_count >= $code->max_uses;
                        @endphp
                        <tr style="border-bottom: 1px solid var(--border-card);">
                            <td style="padding: 16px 18px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-family: var(--font-code); font-weight: 900; font-size: 15px; color: #047857; background: #ECFDF5; border: 1px dashed #A7F3D0; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.5px;">
                                        {{ $code->code }}
                                    </span>
                                </div>
                                @if($code->description)
                                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">{{ $code->description }}</div>
                                @endif
                            </td>

                            <td style="padding: 16px 18px;">
                                <span style="font-size: 14px; font-weight: 800; color: #1E293B;">
                                    @if($code->discount_type === 'percentage')
                                        {{ rtrim(rtrim(number_format($code->discount_value, 2), '0'), '.') }}% خصم
                                    @else
                                        {{ number_format($code->discount_value, 0) }} خصم ثابت
                                    @endif
                                </span>
                            </td>

                            <td style="padding: 16px 18px;">
                                @if($code->product)
                                    <span style="font-size: 13px; font-weight: 700; color: #1E293B;">{{ $code->product->name }}</span>
                                @else
                                    <span style="font-size: 12px; color: var(--text-muted); background: #F1F5F9; padding: 3px 8px; border-radius: 6px;">جميع المنتجات</span>
                                @endif
                            </td>

                            <td style="padding: 16px 18px;">
                                @if($code->valid_until)
                                    <div style="font-size: 12.5px; font-weight: 700; color: {{ $isExpired ? '#DC2626' : '#1E293B' }};">
                                        {{ $code->valid_until->format('Y-m-d') }}
                                    </div>
                                    <div style="font-size: 11.5px; color: {{ $isExpired ? '#DC2626' : '#059669' }};">
                                        {{ $code->remaining_time }}
                                    </div>
                                @else
                                    <span style="font-size: 12px; color: var(--text-muted);">دائم / غير محدد</span>
                                @endif
                            </td>

                            <td style="padding: 16px 18px;">
                                <div style="font-size: 13px; font-weight: 800; color: #1E293B;">
                                    {{ $code->used_count }}
                                    @if($code->max_uses)
                                        <span style="font-size: 11.5px; color: var(--text-muted); font-weight: 400;">/ {{ $code->max_uses }}</span>
                                    @endif
                                </div>
                                @if($isMaxReached)
                                    <span style="font-size: 11px; color: #DC2626; font-weight: 700;">وصل للحد الأقصى</span>
                                @endif
                            </td>

                            <td style="padding: 16px 18px;">
                                @if(!$code->is_active)
                                    <span class="badge" style="background: #F1F5F9; color: #64748B; border: 1px solid #CBD5E1;">معطّل</span>
                                @elseif($isExpired)
                                    <span class="badge" style="background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA;">منتهي الصلاحية</span>
                                @elseif($isMaxReached)
                                    <span class="badge" style="background: #FFFBEB; color: #D97706; border: 1px solid #FDE68A;">مكتمل الاستخدام</span>
                                @else
                                    <span class="badge" style="background: #ECFDF5; color: #059669; border: 1px solid #A7F3D0;">سارٍ ونشط</span>
                                @endif
                            </td>

                            <td style="padding: 16px 18px; text-align: left;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                    {{-- Toggle Status --}}
                                    <form action="{{ route('admin.promo-codes.toggle_status', $code->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $code->is_active ? 'btn-outline' : 'btn-lime' }}" style="font-size: 11.5px; padding: 4px 10px;" title="{{ $code->is_active ? 'تعطيل الكود' : 'تفعيل الكود' }}">
                                            {{ $code->is_active ? 'تعطيل' : 'تفعيل' }}
                                        </button>
                                    </form>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.promo-codes.edit', $code->id) }}" class="btn btn-sm btn-outline" style="font-size: 11.5px; padding: 4px 10px;">
                                        تعديل
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.promo-codes.destroy', $code->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف كود الخصم {{ $code->code }}؟');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline" style="font-size: 11.5px; padding: 4px 8px; color: #DC2626; border-color: #FECACA;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                لا توجد أكواد خصم مسجلة حالياً.
                                <div style="margin-top: 12px;">
                                    <a href="{{ route('admin.promo-codes.create') }}" class="btn btn-lime btn-sm">
                                        + إنشاء أول كود خصم
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($promoCodes->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid var(--border-card);">
                {{ $promoCodes->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
