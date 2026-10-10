@extends('layouts.admin')

@section('title', 'تفاصيل الترخيص والأجهزة | OX Tech')
@section('header_title', 'تفاصيل الترخيص والأجهزة المفعلة')

@section('content')
<div class="admin-content-inner">

    {{-- Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <h1 class="topbar-title" style="margin: 0; font-family: var(--font-code);">🔑 {{ $license->license_key }}</h1>
                @if($license->status === 'active' && ! $license->isExpired())
                    <span class="status-badge success">نشط (Active)</span>
                @elseif($license->status === 'revoked')
                    <span class="status-badge danger">محظور (Revoked)</span>
                @else
                    <span class="status-badge warning">منتهي (Expired)</span>
                @endif
            </div>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">
                عرض بيانات المفتاح، الأجهزة المسجلة، وإمكانية إلغاء ربط أي جهاز للسماح بجهاز بديل
            </p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('admin.licenses.edit', $license) }}" class="btn btn-lime">
                ✏️ تعديل الترخيص
            </a>
            <a href="{{ route('admin.licenses.index') }}" class="btn btn-outline">
                &rarr; العودة للقائمة
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

    {{-- License Overview Card --}}
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <div class="card-title">معلومات الترخيص الأساسية</div>
            <form action="{{ route('admin.licenses.toggle_status', $license) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn {{ $license->status === 'active' ? 'btn-danger' : 'btn-lime' }}" style="padding: 7px 14px; font-size: 12px;">
                    {{ $license->status === 'active' ? '🚫 حظر هذا الترخيص فوراً' : '✓ إعادة تفعيل الترخيص' }}
                </button>
            </form>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px;">
            <div>
                <small style="display: block; color: var(--text-muted); font-size: 11.5px; font-weight: 700; margin-bottom: 4px;">مفتاح الترخيص</small>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-family: var(--font-code); font-weight: 800; font-size: 15px; color: #0F172A;">
                        {{ $license->license_key }}
                    </span>
                    <button type="button" class="btn btn-outline" style="padding: 3px 8px; font-size: 11px;" onclick="navigator.clipboard.writeText('{{ $license->license_key }}'); alert('تم نسخ المفتاح!');">
                        نسخ
                    </button>
                </div>
            </div>

            <div>
                <small style="display: block; color: var(--text-muted); font-size: 11.5px; font-weight: 700; margin-bottom: 4px;">استهلاك الأجهزة</small>
                <div style="font-size: 15px; font-weight: 800; font-family: var(--font-code); color: {{ $license->devices->count() >= $license->max_devices ? '#DC2626' : '#059669' }};">
                    {{ $license->devices->count() }} / {{ $license->max_devices }} جهاز
                </div>
            </div>

            <div>
                <small style="display: block; color: var(--text-muted); font-size: 11.5px; font-weight: 700; margin-bottom: 4px;">تاريخ انتهاء الصلاحية</small>
                <div style="font-size: 14px; font-weight: 700; color: #1E293B;">
                    @if($license->expires_at)
                        {{ $license->expires_at->format('Y-m-d H:i') }}
                        <small style="color: var(--text-muted);">({{ $license->expires_at->diffForHumans() }})</small>
                    @else
                        <span style="color: #047857; font-weight: 800;">مدى الحياة ∞ (Lifetime)</span>
                    @endif
                </div>
            </div>

            <div>
                <small style="display: block; color: var(--text-muted); font-size: 11.5px; font-weight: 700; margin-bottom: 4px;">العميل المرتبط</small>
                <div style="font-size: 14px; font-weight: 700; color: #1E293B;">
                    @if($license->user)
                        {{ $license->user->name }} ({{ $license->user->email }})
                    @else
                        <span style="color: #94A3B8;">غير مرتبط بحساب</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Devices List Card --}}
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--border-card); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 16px; font-weight: 800; color: #1E293B; margin: 0;">💻 الأجهزة المفعلة ({{ $license->devices->count() }})</h3>
                <small style="color: var(--text-muted);">الأجهزة التي قامت بالاتصال وتفعيل هذا المفتاح</small>
            </div>
            @if($license->devices->count() >= $license->max_devices)
                <span class="status-badge danger">تم بلوغ الحد الأقصى للأجهزة</span>
            @else
                <span class="status-badge success">متبقي {{ $license->max_devices - $license->devices->count() }} جهاز متاح</span>
            @endif
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">#</th>
                        <th>المعرف الفريد للجهاز (Hardware ID)</th>
                        <th>تاريخ أول تفعيل</th>
                        <th>آخر فحص دوري (Last Checked)</th>
                        <th style="text-align: left; padding-left: 20px;">إلغاء التفعيل</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($license->devices as $index => $device)
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #94A3B8;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-family: var(--font-code); font-weight: 700; font-size: 13px; color: #1E293B; background: #F8FAFC; border: 1px solid #E2E8F0; padding: 4px 10px; border-radius: 6px;">
                                        {{ $device->hardware_id }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 12.5px; font-weight: 600; color: #334155;">
                                    {{ $device->created_at->format('Y-m-d H:i') }}
                                </div>
                                <small style="color: var(--text-muted); font-size: 11px;">
                                    {{ $device->created_at->diffForHumans() }}
                                </small>
                            </td>
                            <td>
                                @if($device->last_checked_at)
                                    <div style="font-size: 12.5px; font-weight: 600; color: #047857;">
                                        {{ $device->last_checked_at->format('Y-m-d H:i') }}
                                    </div>
                                    <small style="color: var(--text-muted); font-size: 11px;">
                                        {{ $device->last_checked_at->diffForHumans() }}
                                    </small>
                                @else
                                    <span style="color: #94A3B8; font-size: 12px;">لم يتم التحقق بعد</span>
                                @endif
                            </td>
                            <td style="text-align: left; padding-left: 20px;">
                                <form action="{{ route('admin.licenses.devices.destroy', [$license, $device]) }}" method="POST" style="margin: 0; display: inline;" onsubmit="return confirm('هل تريد فك ارتباط هذا الجهاز؟ سيتم إتاحة استخدام الكود على جهاز كمبيوتر جديد.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 11.5px;">
                                        فك ارتباط الجهاز (Unbind)
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 36px 20px;">
                                <div style="font-size: 32px; margin-bottom: 8px;">💻</div>
                                <div style="font-weight: 700; color: #475569;">لم يتم ربط أي جهاز بهذا المفتاح حتى الآن</div>
                                <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                                    عندما يقوم العميل بإدخال الكود في برنامج الـ Desktop، سيظهر جهازه هنا تلقائياً.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
