@extends('layouts.admin')

@section('title', 'تعديل بيانات الترخيص | OX Tech')
@section('header_title', 'تعديل بيانات ترخيص البرنامج')

@section('content')
<div class="admin-content-inner" style="max-width: 800px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="topbar-title" style="margin: 0;">✏️ تعديل الترخيص: {{ $license->license_key }}</h1>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">
                تعديل الصلاحية، أقصى عدد أجهزة، أو حالة الترخيص
            </p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('admin.licenses.show', $license) }}" class="btn btn-outline">
                عرض الأجهزة ({{ $license->devices->count() }})
            </a>
            <a href="{{ route('admin.licenses.index') }}" class="btn btn-outline">
                &rarr; العودة للتراخيص
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert-box alert-danger">
            <ul style="margin: 0; padding-right: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('admin.licenses.update', $license) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- License Key --}}
            <div style="margin-bottom: 22px;">
                <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                    مفتاح الترخيص (License Key) <span style="color: #DC2626;">*</span>
                </label>
                <input type="text" 
                       name="license_key" 
                       value="{{ old('license_key', $license->license_key) }}" 
                       class="form-control" 
                       style="font-family: var(--font-code); font-weight: 800; letter-spacing: 1px; font-size: 15px;" 
                       required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 22px;">
                {{-- Max Devices --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                        أقصى عدد أجهزة مسموح بها (Max Devices) <span style="color: #DC2626;">*</span>
                    </label>
                    <input type="number" 
                           name="max_devices" 
                           value="{{ old('max_devices', $license->max_devices) }}" 
                           min="1" 
                           max="100" 
                           class="form-control" 
                           required>
                    <small class="form-hint">المفعل حالياً: {{ $license->devices->count() }} جهاز.</small>
                </div>

                {{-- Status --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                        حالة المفتاح <span style="color: #DC2626;">*</span>
                    </label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ old('status', $license->status) === 'active' ? 'selected' : '' }}>نشط (Active)</option>
                        <option value="revoked" {{ old('status', $license->status) === 'revoked' ? 'selected' : '' }}>محظور / معلق (Revoked)</option>
                        <option value="expired" {{ old('status', $license->status) === 'expired' ? 'selected' : '' }}>منتهي الصلاحية (Expired)</option>
                    </select>
                </div>
            </div>

            {{-- Expiration Date --}}
            <div style="margin-bottom: 22px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 18px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <label style="font-weight: 800; font-size: 13px; color: #1E293B; margin: 0;">
                        فترة الصلاحية (Expiration Date)
                    </label>
                    <label style="font-size: 12.5px; font-weight: 700; color: #047857; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                        <input type="checkbox" id="lifetime_checkbox" onchange="toggleLifetime(this.checked)" {{ $license->expires_at ? '' : 'checked' }}>
                        <span>ترخيص مدى الحياة (Lifetime License)</span>
                    </label>
                </div>

                <div id="expires_at_wrapper" style="{{ $license->expires_at ? '' : 'display: none;' }}">
                    <input type="datetime-local" 
                           name="expires_at" 
                           id="expires_at_input" 
                           value="{{ old('expires_at', $license->expires_at?->format('Y-m-d\TH:i')) }}" 
                           class="form-control" 
                           style="max-width: 300px;">
                    <small class="form-hint">حدد تاريخ وساعة انتهاء صلاحية الترخيص.</small>
                </div>
            </div>

            {{-- Optional User Attachment --}}
            <div style="margin-bottom: 28px;">
                <label style="display: block; font-weight: 800; font-size: 13px; color: #1E293B; margin-bottom: 8px;">
                    ربط بحساب عميل (اختياري)
                </label>
                <select name="user_id" class="form-control">
                    <option value="">-- بدون ربط بحساب محدد (عام) --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $license->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Submit Buttons --}}
            <div style="display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid var(--border-subtle); padding-top: 20px;">
                <a href="{{ route('admin.licenses.index') }}" class="btn btn-outline">إلغاء</a>
                <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
                    ✓ حفظ التعديلات
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function toggleLifetime(isLifetime) {
    const wrapper = document.getElementById('expires_at_wrapper');
    const input = document.getElementById('expires_at_input');
    if (isLifetime) {
        wrapper.style.display = 'none';
        input.value = '';
    } else {
        wrapper.style.display = 'block';
        if (!input.value) {
            const nextYear = new Date();
            nextYear.setFullYear(nextYear.getFullYear() + 1);
            input.value = nextYear.toISOString().slice(0, 16);
        }
    }
}
</script>
@endsection
