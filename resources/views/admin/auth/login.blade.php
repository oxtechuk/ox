@php
    use App\Models\SiteSetting;
    $siteSettings = SiteSetting::all()->pluck('value', 'key');
    $resolveLogo = function (?string $path): ?string {
        if (empty($path)) return null;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return asset(ltrim($path, '/'));
    };
    $adminLogo = $resolveLogo($siteSettings['site_logo_main'] ?? null)
        ?: $resolveLogo($siteSettings['site_logo_dark'] ?? null)
        ?: $resolveLogo($siteSettings['site_logo_footer'] ?? null);
    $adminFavicon = $resolveLogo($siteSettings['site_favicon'] ?? null);
    $siteName = $siteSettings['site_name'] ?? 'OX Tech';
@endphp
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>تسجيل دخول الإدارة | {{ $siteName }}</title>
    @if(!empty($adminFavicon))
        <link rel="icon" href="{{ $adminFavicon }}">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@400;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy-bg: #06131f;
            --lime: #BDFF45;
            --font: var(--font), sans-serif;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: radial-gradient(circle at 50% 20%, #153c58, #06131f 70%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font);
            color: #fff;
            padding: 20px;
        }
        .login-box {
            background: linear-gradient(135deg, #0c2532, #060F1A);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            padding: 45px 38px;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
            position: relative;
        }
        .login-logo {
            font: 700 32px/1 var(--font-latin);
            letter-spacing: -1.5px;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 25px;
        }
        .login-logo span { color: var(--lime); }
        .login-title {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .login-subtitle {
            font-size: 12px;
            color: #9cb2ab;
            margin-bottom: 28px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #b7c7c3;
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            padding: 13px 16px;
            color: #fff;
            font-family: var(--font);
            font-size: 13px;
            outline: none;
            transition: 0.2s;
        }
        .form-input:focus {
            border-color: var(--lime);
            box-shadow: 0 0 0 3px rgba(201, 250, 75, 0.2);
        }
        .login-btn {
            width: 100%;
            background: var(--lime);
            color: #060F1A;
            font-family: var(--font);
            font-weight: 800;
            font-size: 14px;
            padding: 14px;
            border: none;
            border-radius: 99px;
            cursor: pointer;
            margin-top: 12px;
            transition: 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .login-btn:hover {
            box-shadow: 0 10px 25px rgba(201, 250, 75, 0.3);
            transform: translateY(-2px);
        }
        .alert-error {
            background: rgba(255, 71, 87, 0.15);
            border: 1px solid rgba(255, 71, 87, 0.4);
            color: #ff6b81;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 11px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: rgba(201, 250, 75, 0.15);
            border: 1px solid rgba(201, 250, 75, 0.4);
            color: var(--lime);
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 11px;
            margin-bottom: 20px;
        }
        .quick-hint {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 11px;
            color: #7d9690;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <a href="{{ route('home') }}" class="login-logo">OX<span>.</span></a>
        <h1 class="login-title">تسجيل الدخول للوحة التحكم</h1>
        <p class="login-subtitle">أدخل بيانات الحساب المصرح له بإدارة موقع OX Tech</p>

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-input" value="{{ old('email', 'admin@oxtech.studio') }}" placeholder="admin@oxtech.studio" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 11px; color: #9bb0aa; cursor: pointer;">
                    <input type="checkbox" name="remember" value="1">
                    <span>تذكرني على هذا الجهاز</span>
                </label>
            </div>

            <button type="submit" class="login-btn">
                <span>دخول إلى النظام</span>
                <b>←</b>
            </button>
        </form>

        <div class="quick-hint">
            بيانات الدخول الافتراضية: <code>admin@oxtech.studio</code> / <code>admin123456</code>
        </div>
    </div>
</body>
</html>
