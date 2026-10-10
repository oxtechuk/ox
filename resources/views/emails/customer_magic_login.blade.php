<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رابط الدخول السريع إلى حسابك</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
        }
        .container {
            max-width: 580px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: #0b6153;
            padding: 30px 25px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0 0 6px;
            font-size: 22px;
            font-weight: 700;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px 25px;
        }
        .btn-magic {
            display: inline-block;
            background: #0b6153;
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 28px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            margin: 20px 0;
            text-align: center;
        }
        .box-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            font-size: 13px;
            line-height: 1.6;
        }
        .box-info code {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            color: #0b6153;
        }
        .footer {
            background: #f1f5f9;
            padding: 18px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name', 'Ox Tech') }}</h1>
            <p>بوابة العملاء وإدارة التراخيص</p>
        </div>

        <div class="content">
            <p style="font-size: 15px; line-height: 1.6; color: #334155;">
                مرحباً <strong>{{ $user->name ?: 'عميلنا العزيز' }}</strong>،<br>
                لقد تلقينا طلباً للدخول السريع أو استرجاع حسابك. يمكنك تسجيل الدخول إلى لوحة التحكم فوراً وبضغطة زر واحدة عبر الرابط أدناه:
            </p>

            <div style="text-align: center;">
                <a href="{{ $magicUrl }}" class="btn-magic">
                    تسجيل الدخول إلى حسابي مباشرةً &larr;
                </a>
            </div>

            @if(!empty($tempPassword))
                <div class="box-info">
                    <strong>بيانات الدخول البديلة:</strong><br>
                    البريد الإلكتروني: <code>{{ $user->email }}</code><br>
                    كلمة المرور الجديدة: <code>{{ $tempPassword }}</code>
                </div>
            @endif

            <p style="font-size: 12px; color: #64748b; line-height: 1.5; margin-top: 15px;">
                * رابط الدخول صالح للاستخدام خلال 24 ساعة. إذا لم تكن قد طلبت هذا الرابط، يمكنك تجاهل هذه الرسالة بأمان.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'Ox Tech') }}. جميع الحقوق محفوظة.
        </div>
    </div>
</body>
</html>
