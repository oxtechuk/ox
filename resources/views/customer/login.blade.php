@extends('layouts.app')

@section('title', 'تسجيل الدخول | ' . config('app.name', 'Ox Tech'))

@section('content')
<style>
/* ═══════════════════════════════════════════════════════════════════
   OX TECH MINIMALIST ENTERPRISE LIGHT LOGIN
   Aesthetic: Clean corporate B2B, Slate neutral, Deep Forest Emerald (#0b6153)
   ═══════════════════════════════════════════════════════════════════ */

body {
    background-color: #f8fafc !important;
}

.auth-page-wrapper {
    background-color: #f8fafc;
    min-height: calc(100vh - 80px);
    padding: 130px 16px 80px;
    font-family: 'Cairo', system-ui, -apple-system, sans-serif;
    direction: rtl;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-card-box {
    width: 100%;
    max-width: 410px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 36px 32px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -2px rgba(0, 0, 0, 0.03), 0 20px 25px -5px rgba(0, 0, 0, 0.03);
}

.auth-header {
    text-align: center;
    margin-bottom: 26px;
}

.auth-header-badge {
    width: 44px;
    height: 44px;
    margin: 0 auto 14px;
    border-radius: 12px;
    background: #f0fdf9;
    border: 1px solid #ccfbf1;
    color: #0b6153;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.auth-title {
    font-size: 21px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
}

.auth-subtitle {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

/* Alerts */
.auth-alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.auth-alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Form */
.auth-form-group {
    margin-bottom: 18px;
}

.auth-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}

.auth-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.auth-input {
    width: 100%;
    height: 44px;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 0 14px;
    font-size: 14px;
    font-family: inherit;
    color: #0f172a;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    box-sizing: border-box;
}

.auth-input::placeholder {
    color: #94a3b8;
    font-size: 13px;
}

.auth-input:focus {
    border-color: #0b6153;
    box-shadow: 0 0 0 3px rgba(11, 97, 83, 0.12);
}

.auth-password-toggle {
    position: absolute;
    left: 10px;
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    padding: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: color 0.15s;
}

.auth-password-toggle:hover {
    color: #0b6153;
}

.auth-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 22px;
}

.auth-remember-label {
    display: flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
    user-select: none;
}

.auth-remember-label input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #0b6153;
    cursor: pointer;
}

.auth-submit-btn {
    width: 100%;
    height: 44px;
    background: #0b6153;
    color: #ffffff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    transition: background-color 0.15s, transform 0.15s;
}

.auth-submit-btn:hover {
    background: #084c41;
}

.auth-submit-btn:active {
    transform: translateY(1px);
}

.auth-note-box {
    margin-top: 20px;
    padding: 12px 14px;
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 10px;
    font-size: 12px;
    line-height: 1.6;
    color: #64748b;
    text-align: right;
}

.auth-footer {
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12.5px;
    border-top: 1px solid #f1f5f9;
    padding-top: 16px;
}

.auth-link {
    color: #0b6153;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.15s;
}

.auth-link:hover {
    text-decoration: underline;
}

.auth-support-link {
    color: #64748b;
    text-decoration: none;
    transition: color 0.15s;
}

.auth-support-link:hover {
    color: #0b6153;
}

@media (max-width: 480px) {
    .auth-page-wrapper {
        padding: 110px 14px 60px;
    }

    .auth-card-box {
        padding: 28px 20px;
    }
}
</style>

<div class="auth-page-wrapper">
    <div class="auth-card-box">
        
        <div class="auth-header">
            <div class="auth-header-badge">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h1 class="auth-title">تسجيل الدخول</h1>
            <p class="auth-subtitle">بوابة عملاء Ox Tech</p>
        </div>

        @if(session('success'))
            <div class="auth-alert-success">
                <i class="fa-solid fa-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="auth-alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('customer.login.submit') }}" method="POST">
            @csrf

            <div class="auth-form-group">
                <label for="customerEmail" class="auth-label">البريد الإلكتروني</label>
                <div class="auth-input-wrapper">
                    <input 
                        type="email" 
                        id="customerEmail"
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="name@example.com" 
                        class="auth-input"
                    >
                </div>
            </div>

            <div class="auth-form-group">
                <label for="customerPassword" class="auth-label">كلمة المرور</label>
                <div class="auth-input-wrapper">
                    <input 
                        type="password" 
                        id="customerPassword"
                        name="password" 
                        required 
                        placeholder="••••••••" 
                        class="auth-input"
                        style="padding-left: 38px;"
                    >
                    <button 
                        type="button" 
                        onclick="toggleAuthPassword()" 
                        class="auth-password-toggle" 
                        aria-label="إظهار / إخفاء كلمة المرور"
                        title="إظهار / إخفاء كلمة المرور"
                    >
                        <i id="authEyeIcon" class="fa-regular fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="auth-options">
                <label class="auth-remember-label">
                    <input type="checkbox" name="remember" id="rememberMe">
                    <span>تذكرني</span>
                </label>
            </div>

            <button type="submit" class="auth-submit-btn">
                تسجيل الدخول
            </button>
        </form>

        <div class="auth-note-box">
            <strong>ملاحظة:</strong> يتم إرسال بيانات الدخول إلى بريدك الإلكتروني فور إتمام عملية الشراء.
        </div>

        <div class="auth-footer">
            <a href="{{ route('store.index') }}" class="auth-link">
                ← العودة للمتجر
            </a>

            <a href="https://wa.me/201008616682?text={{ urlencode('مرحباً، أحتاج مساعدة في تسجيل الدخول لبوابة عملاء Ox Tech.') }}" target="_blank" rel="noopener" class="auth-support-link">
                المساعدة والدعم
            </a>
        </div>

    </div>
</div>

<script>
function toggleAuthPassword() {
    const input = document.getElementById('customerPassword');
    const icon = document.getElementById('authEyeIcon');
    if (!input || !icon) return;

    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa-regular fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fa-regular fa-eye';
    }
}
</script>
@endsection
