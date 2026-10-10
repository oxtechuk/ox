@extends('layouts.app')

@section('title', 'تسجيل دخول العملاء وإدارة التراخيص | ' . config('app.name', 'Ox Tech'))

@section('content')
<style>
/* ═══════════════════════════════════════════════════════════════════
   OX TECH LUXURY OBSIDIAN & EMERALD CUSTOMER PORTAL
   Aesthetic: Deep Obsidian (#071B19), Rich Emerald (#087B68), Mint Glow (#00D29F)
   ═══════════════════════════════════════════════════════════════════ */

.ox-login-page-wrapper {
    background-color: #041210;
    background-image: 
        radial-gradient(circle at 18% 20%, rgba(16, 185, 129, 0.12) 0%, transparent 45%),
        radial-gradient(circle at 82% 70%, rgba(8, 123, 104, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 50% 40%, rgba(7, 27, 25, 0.7) 0%, transparent 75%);
    min-height: 100vh;
    padding: 135px 20px 90px;
    font-family: 'Cairo', 'Alexandria', system-ui, -apple-system, sans-serif;
    direction: rtl;
    color: #F3EFE5;
    position: relative;
    overflow-x: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Subtle Ambient Glow Orb */
.ox-login-page-wrapper::before {
    content: '';
    position: absolute;
    top: 5%;
    left: 50%;
    transform: translateX(-50%);
    width: 650px;
    height: 350px;
    background: radial-gradient(ellipse, rgba(0, 210, 159, 0.08) 0%, transparent 70%);
    pointer-events: none;
    z-index: 1;
}

.portal-login-container {
    max-width: 1100px;
    width: 100%;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: 1.1fr 1fr;
    gap: 48px;
    align-items: center;
}

/* ─── 1. LEFT BRAND & VALUE SHOWCASE COLUMN ─── */
.portal-showcase-column {
    padding: 10px 10px 10px 0;
}

.portal-kicker-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(0, 210, 159, 0.08);
    border: 1px solid rgba(0, 210, 159, 0.25);
    color: #00D29F;
    padding: 6px 14px;
    border-radius: 99px;
    font-size: 12.5px;
    font-weight: 700;
    margin-bottom: 22px;
    box-shadow: 0 4px 16px rgba(0, 210, 159, 0.06);
}

.portal-showcase-title {
    font-size: 34px;
    font-weight: 800;
    line-height: 1.35;
    color: #FFFFFF;
    margin: 0 0 16px;
    letter-spacing: -0.5px;
}

.portal-showcase-title .emerald-gradient-text {
    background: linear-gradient(135deg, #00D29F, #10B981, #A7F3D0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.portal-showcase-desc {
    font-size: 15px;
    line-height: 1.75;
    color: #A7B3AE;
    margin-bottom: 34px;
    max-width: 520px;
}

.portal-features-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 34px;
}

.portal-feature-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: rgba(13, 41, 37, 0.45);
    border: 1px solid rgba(29, 138, 104, 0.2);
    border-radius: 16px;
    padding: 14px 18px;
    backdrop-filter: blur(8px);
    transition: all 0.3s ease;
}

.portal-feature-item:hover {
    background: rgba(13, 41, 37, 0.7);
    border-color: rgba(0, 210, 159, 0.35);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
}

.portal-feature-icon-box {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(8, 123, 104, 0.3), rgba(0, 210, 159, 0.15));
    border: 1px solid rgba(0, 210, 159, 0.3);
    color: #00D29F;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.portal-feature-content h4 {
    font-size: 14.5px;
    font-weight: 700;
    color: #FFFFFF;
    margin: 0 0 3px;
}

.portal-feature-content p {
    font-size: 12.5px;
    color: #9CB2AB;
    line-height: 1.5;
    margin: 0;
}

.portal-trust-badge-strip {
    display: flex;
    align-items: center;
    gap: 20px;
    padding-top: 18px;
    border-top: 1px solid rgba(29, 138, 104, 0.18);
    font-size: 12px;
    color: #7E968F;
    flex-wrap: wrap;
}

.portal-trust-badge-strip span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.portal-trust-badge-strip i {
    color: #00D29F;
}

/* ─── 2. RIGHT LOGIN CARD COLUMN ─── */
.portal-card-column {
    display: flex;
    justify-content: center;
}

.portal-glass-card {
    background: rgba(13, 41, 37, 0.88);
    border: 1px solid rgba(16, 185, 129, 0.25);
    border-radius: 28px;
    padding: 38px 34px;
    width: 100%;
    max-width: 460px;
    box-shadow: 
        0 24px 60px rgba(0, 0, 0, 0.45),
        0 0 45px rgba(0, 210, 159, 0.06);
    backdrop-filter: blur(20px);
    position: relative;
    overflow: hidden;
}

.portal-glass-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, #00D29F, #10B981, transparent);
}

.login-card-header {
    text-align: center;
    margin-bottom: 26px;
}

.login-card-icon-pill {
    width: 54px;
    height: 54px;
    margin: 0 auto 14px;
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(8, 123, 104, 0.4), rgba(0, 210, 159, 0.2));
    border: 1px solid rgba(0, 210, 159, 0.35);
    color: #00D29F;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 8px 20px rgba(0, 210, 159, 0.12);
}

.login-card-title {
    font-size: 22px;
    font-weight: 800;
    color: #FFFFFF;
    margin: 0 0 6px;
}

.login-card-subtitle {
    font-size: 13px;
    color: #9CB2AB;
    margin: 0;
}

/* Alerts */
.login-alert-success {
    background: rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(16, 185, 129, 0.35);
    color: #A7F3D0;
    padding: 11px 16px;
    border-radius: 14px;
    font-size: 12.5px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.login-alert-error {
    background: rgba(239, 68, 68, 0.12);
    border: 1px solid rgba(239, 68, 68, 0.35);
    color: #FECACA;
    padding: 11px 16px;
    border-radius: 14px;
    font-size: 12.5px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* Form Styles */
.form-input-group {
    margin-bottom: 20px;
}

.form-field-label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: #E2ECE9;
    margin-bottom: 8px;
}

.input-with-icon-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-leading-icon {
    position: absolute;
    right: 15px;
    color: #64877F;
    font-size: 15px;
    pointer-events: none;
    transition: color 0.2s;
}

.form-lux-input {
    width: 100%;
    background: rgba(4, 18, 16, 0.65);
    border: 1.5px solid rgba(29, 138, 104, 0.35);
    border-radius: 14px;
    padding: 12px 42px 12px 16px;
    font-size: 14px;
    font-family: inherit;
    color: #FFFFFF;
    outline: none;
    transition: all 0.25s ease;
    box-sizing: border-box;
}

.form-lux-input::placeholder {
    color: #5A776F;
    font-size: 13px;
}

.form-lux-input:focus {
    background: rgba(4, 18, 16, 0.85);
    border-color: #00D29F;
    box-shadow: 0 0 0 4px rgba(0, 210, 159, 0.15);
}

.form-lux-input:focus ~ .input-leading-icon {
    color: #00D29F;
}

/* Password Toggle Button */
.password-toggle-btn {
    position: absolute;
    left: 14px;
    background: none;
    border: none;
    color: #64877F;
    cursor: pointer;
    font-size: 15px;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
}

.password-toggle-btn:hover {
    color: #00D29F;
}

/* Remember Options Row */
.form-options-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12.5px;
    color: #9CB2AB;
    margin-bottom: 24px;
}

.custom-remember-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    user-select: none;
}

.custom-remember-label input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    background: rgba(4, 18, 16, 0.6);
    border: 1.5px solid rgba(29, 138, 104, 0.4);
    border-radius: 5px;
    cursor: pointer;
    position: relative;
    transition: all 0.2s ease;
}

.custom-remember-label input[type="checkbox"]:checked {
    background: #00D29F;
    border-color: #00D29F;
}

.custom-remember-label input[type="checkbox"]:checked::after {
    content: '✓';
    position: absolute;
    color: #071B19;
    font-size: 12px;
    font-weight: 800;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Submit Action Button */
.btn-portal-submit {
    width: 100%;
    background: linear-gradient(135deg, #087B68 0%, #00D29F 100%);
    color: #071B19;
    border: none;
    padding: 13.5px 20px;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 800;
    font-family: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 8px 24px rgba(0, 210, 159, 0.25);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.btn-portal-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0, 210, 159, 0.35);
    filter: brightness(1.04);
}

.btn-portal-submit:active {
    transform: translateY(0);
}

/* Helpful Notice Box */
.portal-help-box {
    margin-top: 24px;
    background: rgba(4, 18, 16, 0.5);
    border: 1px dashed rgba(29, 138, 104, 0.3);
    border-radius: 14px;
    padding: 13px 15px;
    font-size: 12px;
    line-height: 1.6;
    color: #9CB2AB;
}

.portal-help-box strong {
    color: #00D29F;
}

/* Footer Nav Links */
.portal-footer-links {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    text-align: center;
    font-size: 12.5px;
}

.portal-store-return-link {
    color: #00D29F;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.portal-store-return-link:hover {
    color: #A7F3D0;
    text-decoration: underline;
}

.portal-whatsapp-support-link {
    color: #A7B3AE;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: color 0.2s;
}

.portal-whatsapp-support-link:hover {
    color: #25D366;
}

/* ─── RESPONSIVE BREAKPOINTS ─── */
@media (max-width: 960px) {
    .ox-login-page-wrapper {
        padding: 110px 16px 70px;
    }

    .portal-login-container {
        grid-template-columns: 1fr;
        gap: 36px;
    }

    .portal-showcase-column {
        text-align: center;
        padding: 0;
    }

    .portal-showcase-desc {
        margin-left: auto;
        margin-right: auto;
    }

    .portal-feature-item {
        text-align: right;
    }

    .portal-trust-badge-strip {
        justify-content: center;
    }

    .portal-glass-card {
        max-width: 100%;
        padding: 30px 22px;
    }

    .portal-showcase-title {
        font-size: 27px;
    }
}
</style>

<div class="ox-login-page-wrapper">
    <div class="portal-login-container">
        
        {{-- ══════════════════════════════════════════════════════════
             1. LEFT BRAND & VALUE SHOWCASE COLUMN
             ══════════════════════════════════════════════════════════ --}}
        <div class="portal-showcase-column">
            
            <div class="portal-kicker-badge">
                <i class="fa-solid fa-gem"></i>
                <span>بوابة عملاء ومشتريات OX TECH المعتمدة</span>
            </div>

            <h1 class="portal-showcase-title">
                الوصول السريع إلى <br>
                <span class="emerald-gradient-text">تراخيصك وبرمجياتك السحابية</span>
            </h1>

            <p class="portal-showcase-desc">
                لوحة موحدة تمكّنك من إدارة تراخيص الأنظمة المشتراة، تحميل التحديثات البرمجية الفورية، استعراض فواتيرك المؤكدة، والتواصل مع مهندسي الدعم الفني دون تعقيد.
            </p>

            {{-- 3 Value Points --}}
            <div class="portal-features-list">
                
                <div class="portal-feature-item">
                    <div class="portal-feature-icon-box">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <div class="portal-feature-content">
                        <h4>تفعيل فوري وربط الأجهزة</h4>
                        <p>استعراض مفاتيح التفعيل الرسمية وربط وتحديث أجهزتك المصرحة بضغطة زر.</p>
                    </div>
                </div>

                <div class="portal-feature-item">
                    <div class="portal-feature-icon-box">
                        <i class="fa-solid fa-cloud-arrow-down"></i>
                    </div>
                    <div class="portal-feature-content">
                        <h4>تحميل أحدث النسخ والتحديثات</h4>
                        <p>روابط تنزيل سريعة وآمنة للملفات التنفيذية والتحديثات الدورية بدون قيود.</p>
                    </div>
                </div>

                <div class="portal-feature-item">
                    <div class="portal-feature-icon-box">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div class="portal-feature-content">
                        <h4>حماية بنكية ودعم هندسي VIP</h4>
                        <p>تشفير عالي المستوى لكافة مشترياتك مع إمكانية التواصل الفوري عبر الواتساب.</p>
                    </div>
                </div>

            </div>

            {{-- Trust Badges Strip --}}
            <div class="portal-trust-badge-strip">
                <span>
                    <i class="fa-solid fa-lock"></i>
                    <span>تشفير 256-bit SSL آمن</span>
                </span>
                <span>
                    <i class="fa-solid fa-circle-check"></i>
                    <span>ضمان تفعيل معتمد 100%</span>
                </span>
                <span>
                    <i class="fa-solid fa-bolt"></i>
                    <span>تسليم فوري للملفات</span>
                </span>
            </div>

        </div>

        {{-- ══════════════════════════════════════════════════════════
             2. RIGHT LOGIN CARD COLUMN
             ══════════════════════════════════════════════════════════ --}}
        <div class="portal-card-column">
            <div class="portal-glass-card">
                
                {{-- Header Icon & Title --}}
                <div class="login-card-header">
                    <div class="login-card-icon-pill">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <h2 class="login-card-title">تسجيل الدخول إلى حسابك</h2>
                    <p class="login-card-subtitle">أدخل بيانات بريدك للوصول إلى لوحة المشتريات والتراخيص</p>
                </div>

                {{-- Session Alerts --}}
                @if(session('success'))
                    <div class="login-alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="login-alert-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- Login Form --}}
                <form action="{{ route('customer.login.submit') }}" method="POST">
                    @csrf

                    {{-- Email Field --}}
                    <div class="form-input-group">
                        <label for="customerEmail" class="form-field-label">البريد الإلكتروني</label>
                        <div class="input-with-icon-wrapper">
                            <input 
                                type="email" 
                                id="customerEmail"
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                                placeholder="name@company.com" 
                                class="form-lux-input"
                            >
                            <i class="fa-regular fa-envelope input-leading-icon"></i>
                        </div>
                    </div>

                    {{-- Password Field with Show/Hide Toggle --}}
                    <div class="form-input-group">
                        <label for="customerPassword" class="form-field-label">كلمة المرور</label>
                        <div class="input-with-icon-wrapper">
                            <input 
                                type="password" 
                                id="customerPassword"
                                name="password" 
                                required 
                                placeholder="••••••••" 
                                class="form-lux-input"
                                style="padding-left: 42px;"
                            >
                            <i class="fa-solid fa-lock input-leading-icon"></i>
                            
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility()" 
                                class="password-toggle-btn" 
                                aria-label="إظهار / إخفاء كلمة المرور"
                                title="إظهار / إخفاء كلمة المرور"
                            >
                                <i id="passEyeIcon" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me Option --}}
                    <div class="form-options-row">
                        <label class="custom-remember-label">
                            <input type="checkbox" name="remember" id="rememberMe">
                            <span>تذكرني على هذا الجهاز</span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn-portal-submit">
                        <span>تسجيل الدخول إلى حسابي</span>
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </form>

                {{-- Help Note Box --}}
                <div class="portal-help-box">
                    💡 <strong>أين تجد كلمة المرور؟</strong> إذا اشتريت برنامجاً مؤخراً، فستجد كلمة المرور المؤقتة ورابط الدخول الفوري في رسالة التأكيد التي وصلتك على بريدك الإلكتروني.
                </div>

                {{-- Navigation Links --}}
                <div class="portal-footer-links">
                    <a href="{{ route('store.index') }}" class="portal-store-return-link">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span>العودة لسوق البرمجيات والحلول الرقمية</span>
                    </a>

                    <a href="https://wa.me/201008616682?text={{ urlencode('مرحباً فريق أوكس تك، أحتاج مساعدة في تسجيل الدخول لبوابة العملاء.') }}" target="_blank" rel="noopener" class="portal-whatsapp-support-link">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span>تواجه مشكلة في الدخول؟ تحدث مع الدعم الفني</span>
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
function togglePasswordVisibility() {
    const input = document.getElementById('customerPassword');
    const icon = document.getElementById('passEyeIcon');
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
