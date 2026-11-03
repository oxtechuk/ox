@extends('layouts.app')

@section('title', 'استرجاع الحساب والدخول السريع | ' . config('app.name', 'Ox Tech'))
@section('meta_description', 'استرجع كلمة المرور أو اطلب رابط دخول مباشر لحساب عميل Ox Tech وتراخيص البرمجيات.')

@section('content')
<style>
/* ═══════════════════════════════════════════════════════════════════
   OX TECH LUXURY CYBER-EMERALD FORGOT PASSWORD
   ═══════════════════════════════════════════════════════════════════ */

.ox-auth-page {
    background-color: #030d0c;
    background-image: 
        radial-gradient(circle at 50% 0%, rgba(29, 138, 104, 0.22) 0%, transparent 60%),
        radial-gradient(circle at 10% 35%, rgba(200, 169, 107, 0.08) 0%, transparent 45%),
        radial-gradient(circle at 90% 70%, rgba(0, 229, 155, 0.07) 0%, transparent 50%);
    min-height: calc(100vh - 80px);
    padding: 130px 16px 90px;
    font-family: var(--font-ar, 'Cairo', system-ui, -apple-system, sans-serif);
    direction: rtl;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.ox-auth-page::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1.5px, transparent 1.5px);
    background-size: 24px 24px;
    opacity: 0.55;
    pointer-events: none;
    z-index: 0;
}

.ox-auth-card {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 440px;
    background: rgba(7, 27, 25, 0.82);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(29, 138, 104, 0.45);
    border-radius: 26px;
    padding: 40px 32px 34px;
    box-shadow: 0 25px 65px rgba(0, 0, 0, 0.65), 0 0 35px rgba(0, 229, 155, 0.09), inset 0 1px 0 rgba(255, 255, 255, 0.12);
}

.ox-auth-header {
    text-align: center;
    margin-bottom: 26px;
}

.ox-auth-badge {
    width: 54px;
    height: 54px;
    margin: 0 auto 14px;
    border-radius: 16px;
    background: rgba(29, 138, 104, 0.22);
    border: 1px solid rgba(0, 229, 155, 0.45);
    color: #00e59b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 0 25px rgba(0, 229, 155, 0.25);
}

.ox-auth-title {
    font-size: 22px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
}

.ox-auth-subtitle {
    font-size: 13px;
    color: #94a8a2;
    margin: 0;
    line-height: 1.6;
}

.ox-auth-alert-success {
    background: rgba(22, 101, 52, 0.22);
    border: 1px solid rgba(74, 222, 128, 0.4);
    color: #bbf7d0;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 10px;
    line-height: 1.5;
}

.ox-auth-alert-error {
    background: rgba(153, 27, 27, 0.22);
    border: 1px solid rgba(248, 113, 113, 0.4);
    color: #fecaca;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.ox-form-group {
    margin-bottom: 22px;
}

.ox-form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #e2e8f0;
    margin-bottom: 8px;
}

.ox-form-input {
    width: 100%;
    height: 46px;
    background: rgba(3, 13, 12, 0.72);
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 12px;
    padding: 0 16px;
    font-size: 14px;
    font-family: inherit;
    color: #ffffff;
    outline: none;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.ox-form-input::placeholder {
    color: #64748b;
    font-size: 13px;
}

.ox-form-input:focus {
    background: rgba(3, 13, 12, 0.95);
    border-color: #00e59b;
    box-shadow: 0 0 18px rgba(0, 229, 155, 0.28);
}

.ox-btn-auth-submit {
    width: 100%;
    height: 48px;
    background: linear-gradient(135deg, #1D8A68 0%, #15664d 100%);
    border: 1px solid rgba(0, 229, 155, 0.55);
    border-radius: 12px;
    color: #ffffff;
    font-size: 14.5px;
    font-weight: 800;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 6px 22px rgba(0, 229, 155, 0.25);
}

.ox-btn-auth-submit:hover {
    background: linear-gradient(135deg, #00e59b 0%, #1D8A68 100%);
    color: #030d0c;
    box-shadow: 0 8px 32px rgba(0, 229, 155, 0.45);
    transform: translateY(-1px);
}

.ox-btn-auth-submit:active {
    transform: translateY(1px);
}

.ox-auth-footer {
    margin-top: 24px;
    text-align: center;
    font-size: 13px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding-top: 18px;
}

.ox-auth-footer-link {
    color: #00e59b;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.ox-auth-footer-link:hover {
    color: #ffffff;
    text-shadow: 0 0 10px rgba(0, 229, 155, 0.6);
}

@media (max-width: 480px) {
    .ox-auth-page {
        padding: 105px 14px 60px;
    }
    .ox-auth-card {
        padding: 30px 20px 26px;
        border-radius: 20px;
    }
}
</style>

<div class="ox-auth-page">
    <div class="ox-auth-card">
        
        <div class="ox-auth-header">
            <div class="ox-auth-badge">
                <i class="fa-solid fa-key"></i>
            </div>
            <h1 class="ox-auth-title">استرجاع الحساب</h1>
            <p class="ox-auth-subtitle">أدخل بريدك الإلكتروني لاستلام رابط الدخول الفوري إلى لوحة تحكم حسابك وتراخيصك.</p>
        </div>

        @if(session('success'))
            <div class="ox-auth-alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="ox-auth-alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('customer.forgot-password.submit') }}" method="POST">
            @csrf

            <div class="ox-form-group">
                <label for="customerEmail" class="ox-form-label">البريد الإلكتروني المسجل</label>
                <input 
                    type="email" 
                    id="customerEmail"
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="name@example.com" 
                    class="ox-form-input"
                >
            </div>

            <button type="submit" class="ox-btn-auth-submit">
                <span>إرسال رابط الدخول الفوري</span>
                <span>←</span>
            </button>
        </form>

        <div class="ox-auth-footer">
            <a href="{{ route('customer.login') }}" class="ox-auth-footer-link">
                <span>←</span>
                <span>العودة إلى تسجيل الدخول</span>
            </a>
        </div>

    </div>
</div>
@endsection