<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title') | {{ config('app.name', 'OX Tech') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600;700;800;900&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', sans-serif" : "'Poppins', sans-serif" }};
            background-color: #F8FAF9;
            color: #0b1b17;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .ox-error-container {
            width: 100%;
            max-width: 580px;
            background: #ffffff;
            border: 1px solid #E2EDE8;
            border-radius: 24px;
            padding: 48px 36px;
            text-align: center;
            box-shadow: 0 10px 30px -5px rgba(11, 27, 23, 0.05);
        }
        .ox-error-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 18px;
            background: #ECFDF5;
            color: #1D8A68;
            border: 1px solid #A7F3D0;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }
        .ox-error-code {
            font-size: clamp(64px, 12vw, 96px);
            font-weight: 900;
            line-height: 1;
            color: #0b1b17;
            margin-bottom: 12px;
            letter-spacing: -2px;
        }
        .ox-error-title {
            font-size: clamp(20px, 3.5vw, 24px);
            font-weight: 800;
            color: #0b1b17;
            margin-bottom: 14px;
        }
        .ox-error-desc {
            font-size: 15.5px;
            line-height: 1.75;
            color: #4b5e57;
            margin-bottom: 32px;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
        }
        .ox-error-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-action-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 13px 28px;
            background-color: #1D8A68;
            color: #ffffff;
            font-weight: 700;
            font-size: 14.5px;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        .btn-action-primary:hover {
            background-color: #156d52;
            transform: translateY(-1px);
        }
        .btn-action-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 13px 24px;
            background-color: #F0FDF4;
            color: #1D8A68;
            border: 1px solid #D1FAE5;
            font-weight: 700;
            font-size: 14.5px;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
        }
        .btn-action-secondary:hover {
            background-color: #E2EDE8;
        }
    </style>
</head>
<body>
    <div class="ox-error-container">
        @yield('content')
    </div>
</body>
</html>
