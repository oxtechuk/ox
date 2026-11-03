@extends('layouts.app')

@section('title', 'تسجيل الدخول لبوابة العملاء | ' . config('app.name', 'Ox Tech'))
@section('meta_description', 'سجّل الدخول إلى حساب عميل Ox Tech لإدارة تراخيص البرمجيات وتنزيل التحديثات والفواتير الرقمية.')

@section('content')
<style>
/* ═══════════════════════════════════════════════════════════════════
   OX TECH LUXURY CYBER-EMERALD CUSTOMER AUTH
   Aesthetic: Deep Midnight (#030d0c), Radiant Emerald (#00e59b / #1D8A68),
   Frosted Glassmorphism, Sadu geometric motifs
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

/* Ambient Dot Matrix Backdrop */
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

/* Auth Card Glass Container */
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
    transition: transform 0.3s ease, border-color 0.3s ease;
}

.ox-auth-card:hover {
    border-color: rgba(0, 229, 155, 0.55);
}

/* Header & Glowing Icon Badge */
.ox-auth-header {
    text-align: center;
    margin-bottom: 24px;
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
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.ox-auth-subtitle .dot-accent {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #00e59b;
    display: inline-block;
    box-shadow: 0 0 8px #00e59b;
}

/* Tabs Switcher */
.ox-auth-tabs {
    display: flex;
    background: rgba(3, 13, 12, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.09);
    border-radius: 14px;
    padding: 4px;
    margin-bottom: 22px;
    gap: 4px;
}

.ox-auth-tab-btn {
    flex: 1;
    border: none;
    background: none;
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 600;
    font-family: inherit;
    color: #94a8a2;
    cursor: pointer;
    transition: all 0.25s ease;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.ox-auth-tab-btn.active {
    background: linear-gradient(135deg, #1D8A68 0%, #146149 100%);
    color: #ffffff;
    font-weight: 700;
    border: 1px solid rgba(0, 229, 155, 0.4);
    box-shadow: 0 4px 16px rgba(0, 229, 155, 0.22);
}

.ox-auth-tab-btn:not(.active):hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.04);
}

/* Alerts */
.ox-auth-alert-success {
    background: rgba(22, 101, 52, 0.22);
    border: 1px solid rgba(74, 222, 128, 0.4);
    color: #bbf7d0;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.ox-auth-alert-error {
    background: rgba(153, 27, 27, 0.22);
    border: 1px solid rgba(248, 113, 113, 0.4);
    color: #fecaca;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Forms */
.ox-form-group {
    margin-bottom: 18px;
}

.ox-label-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 7px;
}

.ox-form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #e2e8f0;
}

.ox-link-forgot {
    font-size: 12px;
    color: #00e59b;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s, text-shadow 0.2s;
}

.ox-link-forgot:hover {
    color: #ffffff;
    text-shadow: 0 0 8px rgba(0, 229, 155, 0.6);
    text-decoration: underline;
}

.ox-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
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

.ox-password-toggle {
    position: absolute;
    left: 12px;
    background: none;
    border: none;
    color: #64748b;
    cursor: pointer;
    padding: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: color 0.2s;
}

.ox-password-toggle:hover {
    color: #00e59b;
}

.ox-form-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    color: #94a8a2;
    margin-bottom: 22px;
}

.ox-remember-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    user-select: none;
}

.ox-remember-label input[type="checkbox"] {
    width: 17px;
    height: 17px;
    accent-color: #00e59b;
    cursor: pointer;
    border-radius: 4px;
}

/* Submit Action Button */
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

/* Info Box */
.ox-auth-note {
    margin-top: 20px;
    padding: 12px 14px;
    background: rgba(3, 13, 12, 0.55);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    font-size: 12px;
    line-height: 1.6;
    color: #94a8a2;
    text-align: right;
    display: flex;
    align-items: flex-start;
    gap: 8px;
}

.ox-auth-note strong {
    color: #c8a96b;
}

/* Footer Links */
.ox-auth-footer {
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding-top: 16px;
}

.ox-auth-footer-link {
    color: #00e59b;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.ox-auth-footer-link:hover {
    color: #ffffff;
    text-shadow: 0 0 10px rgba(0, 229, 155, 0.6);
}

.ox-auth-support-link {
    color: #94a8a2;
    text-decoration: none;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.ox-auth-support-link:hover {
    color: #25d366;
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
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h1 class="ox-auth-title">تسجيل الدخول</h1>
            <p class="ox-auth-subtitle">
                <span class="dot-accent"></span>
                <span>بوابة عملاء Ox Tech والتراخيص</span>
            </p>
        </div>

        {{-- Switch Tabs --}}
        <div class="ox-auth-tabs">
            <button type="button" onclick="switchAuthTab('password')" id="tabBtnPassword" class="ox-auth-tab-btn active">
                <i class="fa-solid fa-key" style="font-size: 11px;"></i>
                <span>بكلمة المرور</span>
            </button>
            <button type="button" onclick="switchAuthTab('order')" id="tabBtnOrder" class="ox-auth-tab-btn">
                <i class="fa-solid fa-receipt" style="font-size: 11px;"></i>
                <span>برقم الطلب (سريع)</span>
            </button>
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

        {{-- 1. PASSWORD FORM --}}
        <form id="formPasswordAuth" action="{{ route('customer.login.submit') }}" method="POST">
            @csrf

            <div class="ox-form-group">
                <div class="ox-label-row">
                    <label for="customerEmail" class="ox-form-label">البريد الإلكتروني</label>
                </div>
                <div class="ox-input-wrapper">
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
            </div>

            <div class="ox-form-group">
                <div class="ox-label-row">
                    <label for="customerPassword" class="ox-form-label">كلمة المرور</label>
                    <a href="{{ route('customer.forgot-password') }}" class="ox-link-forgot">
                        نسيت كلمة المرور؟
                    </a>
                </div>
                <div class="ox-input-wrapper">
                    <input 
                        type="password" 
                        id="customerPassword"
                        name="password" 
                        required 
                        placeholder="••••••••" 
                        class="ox-form-input"
                        style="padding-left: 42px;"
                    >
                    <button 
                        type="button" 
                        onclick="toggleAuthPassword()" 
                        class="ox-password-toggle" 
                        aria-label="إظهار / إخفاء كلمة المرور"
                        title="إظهار / إخفاء كلمة المرور"
                    >
                        <i id="authEyeIcon" class="fa-regular fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="ox-form-options">
                <label class="ox-remember-label">
                    <input type="checkbox" name="remember" id="rememberMe">
                    <span>تذكر هذا الجهاز</span>
                </label>
            </div>

            <button type="submit" class="ox-btn-auth-submit">
                <span>دخول لوحة التحكم</span>
                <span>←</span>
            </button>
        </form>

        {{-- 2. ORDER NUMBER FAST LOGIN FORM --}}
        <form id="formOrderAuth" action="{{ route('customer.login.order') }}" method="POST" style="display: none;">
            @csrf

            <div class="ox-form-group">
                <div class="ox-label-row">
                    <label for="orderEmail" class="ox-form-label">البريد الإلكتروني</label>
                </div>
                <div class="ox-input-wrapper">
                    <input 
                        type="email" 
                        id="orderEmail"
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="البريد المستخدم أثناء الشراء" 
                        class="ox-form-input"
                    >
                </div>
            </div>

            <div class="ox-form-group">
                <div class="ox-label-row">
                    <label for="orderNumber" class="ox-form-label">رقم الطلب (Order #)</label>
                </div>
                <div class="ox-input-wrapper">
                    <input 
                        type="text" 
                        id="orderNumber"
                        name="order_number" 
                        value="{{ old('order_number') }}" 
                        required 
                        placeholder="مثال: OX-2026-XXXX أو رقم إيصال الدفع" 
                        class="ox-form-input"
                    >
                </div>
            </div>

            <div class="ox-form-options">
                <span style="font-size: 11.5px; color: #94a8a2;">
                    * ستجد رقم الطلب في إيصال الدفع أو بريد تأكيد العملية.
                </span>
            </div>

            <button type="submit" class="ox-btn-auth-submit">
                <span>الدخول عبر رقم الطلب</span>
                <span>←</span>
            </button>
        </form>

        <div class="ox-auth-note">
            <i class="fa-solid fa-circle-info" style="color: #c8a96b; margin-top: 2px;"></i>
            <div>
                <strong>تنويه:</strong> يتم إرسال بيانات الدخول وتراخيص البرمجيات إلى بريدك الإلكتروني فور إتمام الدفع بنجاح.
            </div>
        </div>

        <div class="ox-auth-footer">
            <a href="{{ route('store.index') }}" class="ox-auth-footer-link">
                <span>←</span>
                <span>متجر البرمجيات</span>
            </a>

            <a href="https://wa.me/201008616682?text={{ urlencode('مرحباً، أحتاج مساعدة في تسجيل الدخول لبوابة عملاء Ox Tech.') }}" target="_blank" rel="noopener" class="ox-auth-support-link">
                <i class="fa-brands fa-whatsapp"></i>
                <span>المساعدة والدعم</span>
            </a>
        </div>

    </div>
</div>

<script>
function switchAuthTab(type) {
    const formPass = document.getElementById('formPasswordAuth');
    const formOrder = document.getElementById('formOrderAuth');
    const btnPass = document.getElementById('tabBtnPassword');
    const btnOrder = document.getElementById('tabBtnOrder');

    if (type === 'order') {
        formPass.style.display = 'none';
        formOrder.style.display = 'block';
        btnPass.classList.remove('active');
        btnOrder.classList.add('active');
    } else {
        formOrder.style.display = 'none';
        formPass.style.display = 'block';
        btnOrder.classList.remove('active');
        btnPass.classList.add('active');
    }
}

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