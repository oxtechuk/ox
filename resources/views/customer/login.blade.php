@extends('layouts.app')

@section('title', 'تسجيل دخول العملاء | ' . config('app.name', 'Ox Tech'))

@section('content')
<style>
/* ─── Clean White Theme Customer Login ─── */
body {
    background-color: #f8fafc !important;
}

.white-login-wrapper {
    background-color: #f8fafc;
    min-height: 85vh;
    padding: 60px 16px 100px;
    font-family: 'Alexandria', system-ui, sans-serif;
    direction: rtl;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1e293b;
}

.login-card-container {
    max-width: 440px;
    width: 100%;
}

.login-white-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 26px;
    padding: 38px 32px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.04);
}

.login-header-icon {
    width: 58px;
    height: 58px;
    margin: 0 auto 16px;
    border-radius: 18px;
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
}

.login-title {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    text-align: center;
    margin: 0 0 6px;
}

.login-subtitle {
    font-size: 13px;
    color: #64748b;
    text-align: center;
    margin: 0 0 26px;
}

.login-alert-success {
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 20px;
}

.login-alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 20px;
}

.login-form-group {
    margin-bottom: 18px;
}

.login-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.login-input {
    width: 100%;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 12px;
    padding: 11px 14px;
    font-size: 13px;
    font-family: inherit;
    color: #0f172a;
    outline: none;
    transition: all 0.2s;
    box-sizing: border-box;
}

.login-input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

.login-options-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
    color: #64748b;
    margin-bottom: 22px;
}

.remember-label {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
}

.btn-login-submit {
    width: 100%;
    background: #2563eb;
    color: #ffffff;
    border: none;
    padding: 12px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 800;
    font-family: inherit;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
    transition: all 0.2s;
}

.btn-login-submit:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
}

.login-footer-info {
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #f1f5f9;
    text-align: center;
}

.login-help-note {
    font-size: 11.5px;
    color: #64748b;
    line-height: 1.6;
    margin: 0 0 12px;
}

.login-back-link {
    font-size: 12px;
    font-weight: 700;
    color: #2563eb;
    text-decoration: none;
}

.login-back-link:hover {
    text-decoration: underline;
}
</style>

<div class="white-login-wrapper">
    <div class="login-card-container">
        
        <div class="login-white-card">
            <div class="login-header-icon">
                🔐
            </div>

            <h1 class="login-title">تسجيل دخول العملاء</h1>
            <p class="login-subtitle">ادخل إلى حسابك للوصول إلى تراخيص البرامج وروابط التنزيل</p>

            @if(session('success'))
                <div class="login-alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="login-alert-error">
                    ✕ {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('customer.login.submit') }}" method="POST">
                @csrf

                <div class="login-form-group">
                    <label class="login-label">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@company.com" class="login-input">
                </div>

                <div class="login-form-group">
                    <label class="login-label">كلمة المرور</label>
                    <input type="password" name="password" required placeholder="••••••••" class="login-input">
                </div>

                <div class="login-options-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" style="accent-color: #2563eb;">
                        <span>تذكرني على هذا الجهاز</span>
                    </label>
                </div>

                <button type="submit" class="btn-login-submit">
                    تسجيل الدخول إلى حسابي ←
                </button>
            </form>

            <div class="login-footer-info">
                <p class="login-help-note">
                    💡 <strong>ملاحظة:</strong> إذا قمت بشراء برنامج مؤخراً، فستجد كلمة المرور المؤقتة ورابط الدخول المباشر في الرسالة التي أُرسلت إلى بريدك الإلكتروني.
                </p>
                <a href="{{ route('store.index') }}" class="login-back-link">
                    العودة لمتجر البرمجيات والحلول الرقمية
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
