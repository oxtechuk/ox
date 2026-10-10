@extends('layouts.admin')

@section('title', 'إدارة تراخيص البرامج | OX Tech')
@section('header_title', 'تراخيص البرامج والأنظمة (Desktop Licenses)')

@section('content')
<div class="admin-content-inner">

    {{-- Header Action --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
        <div>
            <h1 class="topbar-title" style="margin: 0;">🔑 إدارة وتفعيل تراخيص البرامج</h1>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">
                التحكم بمفاتيح البرامج (C# Desktop)، ربط وتتبع الأجهزة المفعلة، وإدارة الصلاحيات
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.licenses.create') }}" class="btn btn-lime">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>إضافة كود ترخيص جديد</span>
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
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">إجمالي التراخيص</div>
            <div style="font-size: 26px; font-weight: 800; color: #1E293B; font-family: var(--font-code);">
                {{ $stats['total'] }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 14px; padding: 18px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">تراخيص نشطة (Active)</div>
            <div style="font-size: 26px; font-weight: 800; color: #059669; font-family: var(--font-code);">
                {{ $stats['active'] }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 14px; padding: 18px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">الأجهزة المفعلة حالياً</div>
            <div style="font-size: 26px; font-weight: 800; color: #2563EB; font-family: var(--font-code);">
                {{ $stats['devices_count'] }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 14px; padding: 18px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">محظورة / ملغاة (Revoked)</div>
            <div style="font-size: 26px; font-weight: 800; color: #DC2626; font-family: var(--font-code);">
                {{ $stats['revoked'] }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 14px; padding: 18px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">منتهية الصلاحية (Expired)</div>
            <div style="font-size: 26px; font-weight: 800; color: #D97706; font-family: var(--font-code);">
                {{ $stats['expired'] }}
            </div>
        </div>
    </div>

    {{-- Filters & Search --}}
    <div class="card" style="padding: 18px 22px; margin-bottom: 22px;">
        <form method="GET" action="{{ route('admin.licenses.index') }}" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 240px;">
                <input type="text" name="search" class="form-control" placeholder="ابحث بكود الترخيص، العميل، أو Hardware ID..." value="{{ request('search') }}">
            </div>

            <div style="min-width: 160px;">
                <select name="status" class="form-control">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط (Active)</option>
                    <option value="revoked" {{ request('status') === 'revoked' ? 'selected' : '' }}>محظور (Revoked)</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>منتهي (Expired)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 9px 18px;">تصفية</button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.licenses.index') }}" class="btn btn-outline" style="padding: 9px 18px; color: #DC2626;">إلغاء الفلتر</a>
            @endif
        </form>
    </div>

    {{-- Licenses Table --}}
    <div class="card" style="padding: 0; overflow: hidden;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 280px;">مفتاح الترخيص (License Key)</th>
                        <th>العميل المرتبط</th>
                        <th>الأجهزة المستهلكة</th>
                        <th>الصلاحية</th>
                        <th>الحالة</th>
                        <th style="text-align: left; padding-left: 20px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($licenses as $lic)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-family: var(--font-code); font-weight: 800; font-size: 13.5px; letter-spacing: 0.5px; color: #0F172A; background: #F1F5F9; padding: 4px 10px; border-radius: 6px; border: 1px solid #E2E8F0;" id="key-{{ $lic->id }}">
                                        {{ $lic->license_key }}
                                    </span>
                                    <button type="button" class="btn btn-outline" style="padding: 4px 8px; font-size: 11px;" onclick="copyKey('{{ $lic->license_key }}', this)" title="نسخ الكود">
                                        📋
                                    </button>
                                </div>
                            </td>
                            <td>
                                @if($lic->user)
                                    <div style="font-weight: 700; color: #0F172A;">{{ $lic->user->name }}</div>
                                    <small style="color: var(--text-muted); font-size: 11px;">{{ $lic->user->email }}</small>
                                @else
                                    <span style="color: #94A3B8; font-size: 12px;">غير مرتبط بحساب</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.licenses.show', $lic) }}" style="text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                    <span style="font-weight: 800; font-family: var(--font-code); font-size: 13px; color: {{ $lic->devices_count >= $lic->max_devices ? '#DC2626' : '#059669' }};">
                                        {{ $lic->devices_count }} / {{ $lic->max_devices }}
                                    </span>
                                    <span style="font-size: 11px; color: #64748B;">جهاز (عرض)</span>
                                </a>
                            </td>
                            <td>
                                @if($lic->expires_at)
                                    <div style="font-size: 12px; font-weight: 700; color: {{ $lic->isExpired() ? '#DC2626' : '#334155' }};">
                                        {{ $lic->expires_at->format('Y-m-d') }}
                                    </div>
                                    <small style="font-size: 10.5px; color: var(--text-muted);">
                                        {{ $lic->isExpired() ? 'منتهي' : 'متبقي ' . $lic->expires_at->diffForHumans() }}
                                    </small>
                                @else
                                    <span style="display: inline-block; padding: 2px 8px; background: #ECFDF5; color: #047857; border-radius: 6px; font-size: 11px; font-weight: 800;">
                                        مدى الحياة ∞
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($lic->status === 'active' && ! $lic->isExpired())
                                    <span class="status-badge success">نشط (Active)</span>
                                @elseif($lic->status === 'revoked')
                                    <span class="status-badge danger">محظور (Revoked)</span>
                                @else
                                    <span class="status-badge warning">منتهي (Expired)</span>
                                @endif
                            </td>
                            <td style="text-align: left; padding-left: 20px;">
                                <div style="display: inline-flex; gap: 6px; align-items: center;">
                                    {{-- Show Devices --}}
                                    <a href="{{ route('admin.licenses.show', $lic) }}" class="btn btn-outline" style="padding: 6px 10px; font-size: 11.5px;" title="عرض الأجهزة المرتبطة">
                                        الأجهزة ({{ $lic->devices_count }})
                                    </a>

                                    {{-- Quick Toggle Status --}}
                                    <form action="{{ route('admin.licenses.toggle_status', $lic) }}" method="POST" style="margin: 0; display: inline;">
                                        @csrf
                                        <button type="submit" class="btn {{ $lic->status === 'active' ? 'btn-outline' : 'btn-primary' }}" style="padding: 6px 10px; font-size: 11.5px;" title="{{ $lic->status === 'active' ? 'حظر المفتاح' : 'تفعيل المفتاح' }}">
                                            {{ $lic->status === 'active' ? 'حظر' : 'تفعيل' }}
                                        </button>
                                    </form>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.licenses.edit', $lic) }}" class="btn btn-outline" style="padding: 6px 10px; font-size: 11.5px;">
                                        تعديل
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.licenses.destroy', $lic) }}" method="POST" style="margin: 0; display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الترخيص نهائياً؟ ستتوقف أي أجهزة مفعلة به.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 11.5px;">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 48px 20px;">
                                <div style="font-size: 40px; margin-bottom: 10px;">🔑</div>
                                <h3 style="font-size: 16px; font-weight: 800; color: #1E293B; margin-bottom: 6px;">لا توجد تراخيص مضافة حتى الآن</h3>
                                <p style="font-size: 13px; color: var(--text-muted); max-width: 400px; margin: 0 auto 18px;">
                                    يمكنك إنشاء أول كود تفعيل بضغطة زر وإرساله للعميل لتفعيله داخل برنامج الديسكتوب.
                                </p>
                                <a href="{{ route('admin.licenses.create') }}" class="btn btn-lime">
                                    + إضافة أول كود تفعيل الآن
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($licenses->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid var(--border-subtle);">
                {{ $licenses->links() }}
            </div>
        @endif
    </div>

</div>

<script>
function copyKey(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const originalText = btn.innerHTML;
        btn.innerHTML = '✓ تم';
        btn.style.color = '#059669';
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.color = '';
        }, 1500);
    });
}
</script>
@endsection
