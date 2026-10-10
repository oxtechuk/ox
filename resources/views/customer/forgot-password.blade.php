@extends('layouts.app')

@section('title', 'استرجاع الحساب والدخول السريع | ' . config('app.name', 'Ox Tech'))

@section('content')
<style>
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
    line-height: 1.5;
}

.auth-alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
    padding: 12px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
    line-height: 1.5;
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

.auth-form-group {
    margin-bottom: 20px;
}

.auth-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
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

.auth-input:focus {
    border-color: #0b6153;
    box-shadow: 0 0 0 3px rgba(11, 97, 83, 0.12);
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
    transition: background-color 0.15s;
}

.auth-submit-btn:hover {
    background: #084c41;
}

.auth-footer {
    margin-top: 22px;
    text-align: center;
    font-size: 13px;
    border-top: 1px solid #f1f5f9;
    padding-top: 16px;
}

.auth-link {
    color: #0b6153;
    text-decoration: none;
    font-weight: 600;
}

.auth-link:hover {
    text-decoration: underline;
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
                <i class="fa-solid fa-key"></i>
            </div>
            <h1 class="auth-title">استرجاع الحساب</h1>
            <p class="auth-subtitle">أدخل بريدك الإلكتروني لاستلام رابط الدخول المباشر إلى لوحة حسابك</p>
        </div>

        @if(session('success'))
            <div class="auth-alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="auth-alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('customer.forgot-password.submit') }}" method="POST">
            @csrf

            <div class="auth-form-group">
                <label for="customerEmail" class="auth-label">البريد الإلكتروني</label>
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

            <button type="submit" class="auth-submit-btn">
                إرسال رابط الدخول الفوري
            </button>
        </form>

        <div class="auth-footer">
            <a href="{{ route('customer.login') }}" class="auth-link">
                ← العودة إلى تسجيل الدخول
            </a>
        </div>

    </div>
</div>
@endsection
