<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد طلبك وتفاصيل التحميل</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0b0f19;
            color: #e2e8f0;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #111827;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid #1f2937;
        }
        .header {
            background: linear-gradient(135deg, #0284c7, #2563eb, #7c3aed);
            padding: 35px 25px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0 0 10px;
            font-size: 24px;
            font-weight: 700;
        }
        .header p {
            margin: 0;
            font-size: 15px;
            opacity: 0.9;
        }
        .content {
            padding: 30px 25px;
        }
        .order-badge {
            display: inline-block;
            background: rgba(2, 132, 199, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.3);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: #f8fafc;
            border-bottom: 1px solid #1f2937;
            padding-bottom: 8px;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        .product-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 18px;
        }
        .product-title {
            font-size: 16px;
            font-weight: 700;
            color: #38bdf8;
            margin: 0 0 8px;
        }
        .license-box {
            background: #0f172a;
            border: 1px dashed #0284c7;
            border-radius: 8px;
            padding: 12px 15px;
            margin: 12px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .license-key {
            font-family: monospace;
            font-size: 16px;
            font-weight: bold;
            color: #a5f3fc;
            letter-spacing: 1px;
        }
        .btn-download {
            display: inline-block;
            background: linear-gradient(135deg, #0284c7, #2563eb);
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
        .credentials-card {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 10px;
            padding: 16px;
            margin-top: 20px;
        }
        .credentials-card h4 {
            margin: 0 0 8px;
            color: #34d399;
            font-size: 15px;
        }
        .footer {
            background: #090d16;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid #1f2937;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 شكراً لثقتك بنا!</h1>
            <p>تم استلام دفعتك بنجاح وأصبح منتجك الرقمي جاهزاً للاستخدام فوراً</p>
        </div>

        <div class="content">
            <div class="order-badge">
                رقم الطلب: {{ $order->order_number }} | الحالة: تم الدفع بنجاح
            </div>

            <p style="font-size: 15px; line-height: 1.6; color: #cbd5e1;">
                مرحباً <strong>{{ $order->customer_name }}</strong>،<br>
                يسعدنا انضمامك لعملاء <strong>{{ config('app.name', 'Ox Tech') }}</strong>. لقد تم إتمام عملية الشراء بنجاح عبر بوابة الدفع الآمنة. إليك تفاصيل ترخيص البرنامج وروابط التنزيل المباشرة:
            </p>

            <div class="section-title">📦 المنتجات والتراخيص المشتراة</div>

            @foreach($order->items as $item)
                @php
                    $product = $item->product;
                    $tokenRecord = $order->downloadTokens->where('product_id', $product->id)->first();
                @endphp
                <div class="product-card">
                    <div class="product-title">{{ $product->name ?? 'برنامج رقمي' }} (v{{ $product->version ?? '1.0' }})</div>
                    @if($product->tagline)
                        <div style="font-size: 13px; color: #94a3b8; margin-bottom: 10px;">{{ $product->tagline }}</div>
                    @endif

                    @if($item->license_key)
                        <div style="font-size: 12px; color: #94a3b8; margin-bottom: 4px;">مفتاح الترخيص الخاص بك (License Key):</div>
                        <div class="license-box">
                            <span class="license-key">{{ $item->license_key }}</span>
                        </div>
                    @endif

                    @if($tokenRecord)
                        <div style="margin-top: 15px;">
                            <a href="{{ route('digital.download', $tokenRecord->token) }}" class="btn-download">
                                ⬇️ تحميل ملف البرنامج الآن
                            </a>
                            <div style="font-size: 12px; color: #64748b; margin-top: 6px;">
                                * رابط التحميل صالح حتى {{ $tokenRecord->expires_at ? $tokenRecord->expires_at->format('Y-m-d') : '30 يوماً' }} (متبقي {{ $tokenRecord->max_downloads - $tokenRecord->download_count }} تحميلات).
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            @if($tempPassword)
                <div class="credentials-card">
                    <h4>🔐 حسابك الشخصي في المنصة:</h4>
                    <p style="font-size: 13px; color: #e2e8f0; margin: 0 0 6px;">
                        تم إنشاء حساب خاص بك تلقائياً لتتمكن من متابعة تراخيصك وتحديثات البرامج في أي وقت:
                    </p>
                    <div style="font-size: 13px; color: #f1f5f9;">
                        <strong>البريد الإلكتروني:</strong> {{ $order->customer_email }}<br>
                        <strong>كلمة المرور المؤقتة:</strong> <code style="background: #0f172a; padding: 2px 6px; border-radius: 4px; color: #38bdf8;">{{ $tempPassword }}</code>
                    </div>
                    <div style="margin-top: 10px;">
                        <a href="{{ route('customer.dashboard') }}" style="color: #38bdf8; font-weight: 600; font-size: 13px; text-decoration: underline;">
                            تسجيل الدخول إلى لوحة التحكم الخاصة بك &larr;
                        </a>
                    </div>
                </div>
            @else
                <div style="margin-top: 20px; text-align: center;">
                    <a href="{{ route('customer.dashboard') }}" style="color: #38bdf8; font-size: 14px; text-decoration: underline;">
                        الدخول إلى حسابك لاستعراض جميع المشتريات &larr;
                    </a>
                </div>
            @endif

            <div style="margin-top: 25px; padding: 15px; background: #0b1120; border-radius: 8px; font-size: 13px; color: #94a3b8; text-align: center;">
                هل تحتاج إلى مساعدة أو لديك استفسار حول التثبيت؟<br>
                فريق الدعم الفني جاهز لمساعدتك عبر مراسلتنا فوراً.
            </div>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'Ox Tech') }}. جميع الحقوق محفوظة.<br>
            عملية الدفع مؤمنة ومشفرة بالكامل بواسطة PaySky Omni Gateway.
        </div>
    </div>
</body>
</html>
