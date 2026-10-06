<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landingPage->headline }} | {{ config('app.name', 'Ox Tech') }}</title>
    <meta name="description" content="{{ $landingPage->subheadline }}">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17984061932"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-17984061932');
    </script>
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1907678277306091');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1907678277306091&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* ─── White Theme Sales Landing Page ─── */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Alexandria', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
            direction: rtl;
        }
        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* Top Urgency Bar */
        .urgency-bar {
            background: linear-gradient(90deg, #dc2626, #ea580c, #dc2626);
            color: #ffffff;
            padding: 10px 16px;
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 10px rgba(220, 38, 38, 0.2);
        }
        .timer-box {
            font-family: monospace;
            background: rgba(0, 0, 0, 0.25);
            padding: 3px 8px;
            border-radius: 6px;
            color: #fef08a;
            font-weight: 900;
        }

        /* Header */
        .sales-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 0;
        }
        .header-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo-box {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .logo-square {
            width: 40px;
            height: 40px;
            background: #2563eb;
            color: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 18px;
        }

        /* Hero */
        .sales-hero {
            padding: 50px 0 60px;
            text-align: center;
            background: radial-gradient(circle at 50% 0%, #eff6ff 0%, #f8fafc 70%);
        }
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            padding: 6px 16px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 18px;
        }
        .hero-title {
            font-size: 38px;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.35;
            max-width: 860px;
            margin: 0 auto 16px;
        }
        .hero-desc {
            font-size: 16px;
            color: #475569;
            line-height: 1.7;
            max-width: 720px;
            margin: 0 auto 28px;
        }

        .cta-btn-main {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #2563eb;
            color: #ffffff !important;
            padding: 16px 36px;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 800;
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.35);
            transition: all 0.25s ease;
            cursor: pointer;
            border: none;
        }
        .cta-btn-main:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.45);
        }

        /* Pricing Card */
        .pricing-hero-card {
            background: #ffffff;
            border: 2px solid #2563eb;
            border-radius: 24px;
            padding: 30px;
            max-width: 500px;
            margin: 30px auto 40px;
            box-shadow: 0 10px 40px rgba(37, 99, 235, 0.08);
            position: relative;
        }
        .discount-ribbon {
            position: absolute;
            top: -14px;
            right: 50%;
            transform: translateX(50%);
            background: #dc2626;
            color: #fff;
            padding: 4px 16px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 800;
        }

        /* Stats Section */
        .stats-strip {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            padding: 35px 0;
            margin: 20px 0 50px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            text-align: center;
        }
        .stat-val {
            font-size: 34px;
            font-weight: 900;
            color: #2563eb;
            font-family: monospace;
            margin-bottom: 4px;
        }
        .stat-lbl {
            font-size: 12.5px;
            color: #64748b;
            font-weight: 600;
        }

        /* Benefits */
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin: 40px 0 60px;
        }
        .benefit-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            display: flex;
            gap: 16px;
        }
        .benefit-icon {
            width: 44px;
            height: 44px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .benefit-card h3 {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .benefit-card p {
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
        }

        /* Comparison Table */
        .comp-table-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            margin: 40px 0 60px;
        }
        .comp-table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
            font-size: 13px;
        }
        .comp-table th {
            padding: 16px 20px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 800;
            color: #0f172a;
        }
        .comp-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Fast Order Section */
        .fast-order-section {
            background: #ffffff;
            border: 2px solid #2563eb;
            border-radius: 28px;
            padding: 40px 30px;
            max-width: 620px;
            margin: 50px auto;
            box-shadow: 0 15px 50px rgba(37, 99, 235, 0.1);
        }
        .input-label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
        }
        .input-field {
            width: 100%;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            margin-bottom: 16px;
            background: #ffffff;
            color: #0f172a;
        }
        .input-field:focus {
            border-color: #2563eb;
        }

        /* FAQ */
        .faq-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 14px;
        }
        .faq-item h4 {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .faq-item p {
            font-size: 13px;
            color: #475569;
            line-height: 1.7;
        }
    </style>
</head>
<body>

    {{-- Urgency Announcement Bar --}}
    <div class="urgency-bar">
        <span>⏳ {{ $landingPage->hero_badge ?: 'عرض استثنائي لفترة محدودة: احصل على خصم 40% وتفعيل فوري اليوم' }}</span>
        <span>| ينتهي العرض خلال:</span>
        <span class="timer-box" id="countdownTimer">18:42:15</span>
    </div>

    {{-- Header --}}
    <header class="sales-header">
        <div class="container header-flex">
            <a href="{{ route('home') }}" class="logo-box">
                <div class="logo-square">OX</div>
                <div>
                    <strong style="font-size: 16px; color: #0f172a;">{{ config('app.name', 'Ox Tech') }}</strong>
                    <div style="font-size: 11px; color: #64748b;">البرمجيات وتطبيقات الأعمال الذكية</div>
                </div>
            </a>

            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="#orderSection" class="cta-btn-main" style="padding: 10px 22px; font-size: 13px;">
                    ⚡ شراء الآن
                </a>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="sales-hero">
        <div class="container">
            <div class="badge-pill">
                ✨ النسخة الأحدث والأكثر استقراراً (v{{ $product->version }})
            </div>

            <h1 class="hero-title">
                {{ $landingPage->headline }}
            </h1>

            <p class="hero-desc">
                {{ $landingPage->subheadline }}
            </p>

            {{-- Price Highlight Box --}}
            <div class="pricing-hero-card">
                @if($product->has_discount)
                    <div class="discount-ribbon">
                        خصم حصري {{ $product->discount_percentage }}% لفترة محدودة
                    </div>
                @endif

                <div style="display: flex; align-items: baseline; justify-content: center; gap: 8px; margin: 10px 0 6px;">
                    <span style="font-size: 42px; font-weight: 900; color: #0f172a;">{{ number_format($product->effective_price, 2) }}</span>
                    <span style="font-size: 16px; font-weight: 700; color: #2563eb;">{{ $product->currency }}</span>
                    @if($product->has_discount)
                        <span style="font-size: 16px; color: #94a3b8; text-decoration: line-through;">{{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <div style="font-size: 12px; color: #059669; font-weight: 700; margin-bottom: 20px;">
                    ● ترخيص رسمي دائم مدى الحياة بدون أي اشتراكات دورية
                </div>

                <a href="#orderSection" class="cta-btn-main" style="width: 100%;">
                    <span>{{ $landingPage->cta_text ?: 'اشترِ الآن واحصل على التفعيل الفوري' }}</span>
                    <span>&larr;</span>
                </a>

                <div style="margin-top: 14px; font-size: 11.5px; color: #64748b;">
                    🔒 دفع إلكتروني مشفر عبر <strong style="color: #2563eb;">PaySky Omni Gateway</strong>
                </div>
            </div>

            {{-- Trust Pills --}}
            <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; font-size: 12.5px; color: #475569;">
                <span style="background: #ffffff; padding: 6px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <strong style="color: #059669;">✓</strong> متوافق مع الفاتورة الإلكترونية
                </span>
                <span style="background: #ffffff; padding: 6px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <strong style="color: #059669;">✓</strong> تفعيل رقمي فوري
                </span>
                <span style="background: #ffffff; padding: 6px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <strong style="color: #059669;">✓</strong> ضمان استرجاع 100%
                </span>
            </div>
        </div>
    </section>

    {{-- Stats Numbers --}}
    @if(!empty($landingPage->social_proof_stats) && is_array($landingPage->social_proof_stats))
        <section class="stats-strip">
            <div class="container">
                <div class="stats-grid">
                    @foreach($landingPage->social_proof_stats as $stat)
                        <div>
                            <div class="stat-val">{{ $stat['value'] }}</div>
                            <div class="stat-lbl">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Benefits --}}
    @if(!empty($landingPage->key_benefits) && is_array($landingPage->key_benefits))
        <section class="container">
            <div style="text-align: center; margin-bottom: 24px;">
                <span class="badge-pill">لماذا تختار هذا البرنامج؟</span>
                <h2 style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 6px;">مزايا صُممت لتسريع أرباحك وتوفير وقتك</h2>
            </div>

            <div class="benefits-grid">
                @foreach($landingPage->key_benefits as $benefit)
                    <div class="benefit-card">
                        <div class="benefit-icon">★</div>
                        <div>
                            <h3>{{ $benefit['title'] }}</h3>
                            <p>{{ $benefit['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Comparison Table --}}
    @if(!empty($landingPage->comparison_table) && is_array($landingPage->comparison_table))
        <section class="container">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="font-size: 24px; font-weight: 800; color: #0f172a;">مقارنة بين برنامجنا والبرامج التقليدية الأخرى</h2>
            </div>

            <div class="comp-table-box">
                <table class="comp-table">
                    <thead>
                        <tr>
                            <th>الميزة والمواصفات</th>
                            <th style="color: #059669; background: #f0fdf4;">برنامج {{ $product->name }}</th>
                            <th style="color: #64748b;">الأنظمة الأخرى</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($landingPage->comparison_table as $row)
                            <tr>
                                <td style="font-weight: 700; color: #0f172a;">{{ $row['feature'] }}</td>
                                <td style="color: #059669; font-weight: 800; background: #f0fdf4;">✓ {{ $row['us'] }}</td>
                                <td style="color: #dc2626;">✕ {{ $row['others'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif

    {{-- Order Section --}}
    <section id="orderSection" class="container">
        <div class="fast-order-section">
            <div style="text-align: center; margin-bottom: 24px;">
                <span class="badge-pill">⚡ طلب مباشر مع تفعيل فوري</span>
                <h2 style="font-size: 24px; font-weight: 900; color: #0f172a; margin: 8px 0 4px;">اغتنم العرض واطلب نسختك الآن</h2>
                <p style="font-size: 13px; color: #64748b;">املأ بياناتك وسيتم توجيهك لبوابة PaySky الآمنة واستلام الترخيص والملف فوراً</p>
            </div>

            <form id="salesForm" onsubmit="handleSalesCheckout(event)">
                @csrf
                <input type="hidden" id="spId" value="{{ $product->id }}">
                <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
                <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
                <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">

                <div>
                    <label class="input-label">الاسم بالكامل أو اسم المنشأة *</label>
                    <input type="text" id="spName" required placeholder="أدخل اسمك الكريم" class="input-field">
                </div>

                <div>
                    <label class="input-label">البريد الإلكتروني (هام: لاستلام مفتاح التفعيل ورابط التنزيل) *</label>
                    <input type="email" id="spEmail" required placeholder="example@mail.com" class="input-field">
                </div>

                <div>
                    <label class="input-label">رقم الهاتف / الواتساب للتواصل والدعم</label>
                    <input type="tel" id="spPhone" placeholder="010xxxxxxxx" class="input-field">
                </div>

                <button type="submit" id="btnSalesSubmit" class="cta-btn-main" style="width: 100%;">
                    <span>إتمام الشراء الآن والدفع عبر PaySky ({{ number_format($product->effective_price, 2) }} {{ $product->currency }})</span>
                    <span>&larr;</span>
                </button>
            </form>

            <div style="margin-top: 20px; text-align: center; font-size: 11.5px; color: #64748b; display: flex; justify-content: center; gap: 14px;">
                <span>🛡️ معتمد ومؤمن من PaySky</span>
                <span>•</span>
                <span>⚡ تفعيل رقمي فوري</span>
                <span>•</span>
                <span>📩 نسخة على بريدك الإلكتروني</span>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    @if(!empty($landingPage->faq_items) && is_array($landingPage->faq_items))
        <section class="container" style="max-width: 760px; margin-bottom: 60px;">
            <div style="text-align: center; margin-bottom: 24px;">
                <h2 style="font-size: 22px; font-weight: 800; color: #0f172a;">الأسئلة الشائعة حول البرنامج</h2>
            </div>

            @foreach($landingPage->faq_items as $faq)
                <div class="faq-item">
                    <h4>❓ {{ $faq['question'] }}</h4>
                    <p>{{ $faq['answer'] }}</p>
                </div>
            @endforeach
        </section>
    @endif

    {{-- Footer --}}
    <footer style="background: #ffffff; border-top: 1px solid #e2e8f0; padding: 24px 0; text-align: center; font-size: 12px; color: #64748b;">
        &copy; {{ date('Y') }} {{ config('app.name', 'Ox Tech') }}. جميع الحقوق محفوظة.<br>
        معالجة الدفع مؤمنة ومشفرة بالكامل بواسطة بوابة PaySky Omni Gateway.
    </footer>

    <script>
    // Live Countdown Timer
    function startTimer(durationInSeconds) {
        let timer = durationInSeconds;
        const timerElem = document.getElementById('countdownTimer');
        setInterval(() => {
            const hours = String(Math.floor(timer / 3600)).padStart(2, '0');
            const minutes = String(Math.floor((timer % 3600) / 60)).padStart(2, '0');
            const seconds = String(timer % 60).padStart(2, '0');
            if (timerElem) timerElem.textContent = `${hours}:${minutes}:${seconds}`;
            if (--timer < 0) timer = 24 * 3600;
        }, 1000);
    }
    startTimer(18 * 3600 + 42 * 60);

    function loadPaySkyAsync(scriptUrl) {
        return new Promise((resolve) => {
            if (typeof window.Lightbox !== 'undefined' && typeof window.Lightbox.Checkout !== 'undefined') {
                return resolve(true);
            }
            const script = document.createElement('script');
            script.src = scriptUrl;
            script.async = true;
            script.onload = () => resolve(true);
            script.onerror = () => {
                console.warn('PaySky JS could not be reached via current DNS/network. Proceeding to simulated/fallback checkout.');
                resolve(false);
            };
            document.head.appendChild(script);
        });
    }

    let currentMerchantRef = '';

    function logGatewayError(ref, message, errorData, source, status) {
        try {
            fetch('{{ route('checkout.paysky.log_error') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    merchant_reference: ref || currentMerchantRef,
                    message: message,
                    error: errorData,
                    source: source || 'lightbox_client',
                    status: status || 'failed'
                })
            }).catch(console.error);
        } catch (e) {
            console.error('Failed to log error to server:', e);
        }
    }

    window.addEventListener('message', function (event) {
        if (event.data && typeof event.data === 'object') {
            if (event.data.callback === 'errorCallback' || event.data.status === 'failed') {
                logGatewayError(
                    currentMerchantRef,
                    'خطأ وارد من نافذة PaySky (postMessage): ' + (event.data.Info?.Message || event.data.message || JSON.stringify(event.data)),
                    event.data,
                    'paysky_post_message',
                    'failed'
                );
            }
        }
    });

    async function handleSalesCheckout(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSalesSubmit');
        btn.disabled = true;
        btn.innerText = 'جاري التحضير لبوابة PaySky...';

        const payload = {
            _token: '{{ csrf_token() }}',
            product_id: document.getElementById('spId').value,
            customer_name: document.getElementById('spName').value,
            customer_email: document.getElementById('spEmail').value,
            customer_phone: document.getElementById('spPhone').value,
            utm_source: '{{ request('utm_source') }}',
            utm_medium: '{{ request('utm_medium') }}',
            utm_campaign: '{{ request('utm_campaign') }}',
        };

        try {
            const response = await fetch('{{ route('checkout.initiate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (data.success && data.paysky) {
                currentMerchantRef = data.paysky.MerchantReference || data.merchant_reference || '';
                btn.innerText = 'فتح نافذة الدفع...';

                const scriptLoaded = await loadPaySkyAsync(data.paysky.ScriptUrl);

                if (scriptLoaded && typeof Lightbox !== 'undefined' && typeof Lightbox.Checkout !== 'undefined') {
                    Lightbox.Checkout.configure = {
                        MID: data.paysky.MID,
                        TID: data.paysky.TID,
                        AmountTrxn: data.paysky.AmountTrxn,
                        MerchantReference: data.paysky.MerchantReference,
                        TrxDateTime: data.paysky.TrxDateTime,
                        SecureHash: data.paysky.SecureHash,
                        completeCallback: function (dataResponse) {
                            window.location.href = data.callback_url + '?MerchantReference=' + encodeURIComponent(data.paysky.MerchantReference) + '&Success=true';
                        },
                        errorCallback: function (error) {
                            const errMsg = (error && (error.Message || error.errorMessage || error.message)) ? (error.Message || error.errorMessage || error.message) : JSON.stringify(error || 'خطأ غير محدد من البوابة');
                            logGatewayError(
                                data.paysky.MerchantReference,
                                'فشل الدفع في نافذة PaySky (errorCallback): ' + errMsg,
                                error,
                                'paysky_error_callback',
                                'failed'
                            );
                            alert('حدث خطأ أثناء معالجة الدفع: ' + (error?.Message || error?.errorMessage || 'يرجى مراجعة بيانات البطاقة أو المحاولة مجدداً'));
                            btn.disabled = false;
                            btn.innerText = 'إتمام الشراء الآن والدفع عبر PaySky ←';
                        },
                        cancelCallback: function () {
                            logGatewayError(
                                data.paysky.MerchantReference,
                                'قام العميل بإلغاء أو إغلاق نافذة الدفع PaySky Lightbox',
                                { action: 'lightbox_cancelled' },
                                'lightbox_cancelled',
                                'cancelled'
                            );
                            btn.disabled = false;
                            btn.innerText = 'إتمام الشراء الآن والدفع عبر PaySky ←';
                        }
                    };
                    Lightbox.Checkout.showLightbox();
                } else {
                    window.location.href = data.callback_url + '?MerchantReference=' + encodeURIComponent(data.paysky.MerchantReference) + '&Success=true';
                }
            } else {
                logGatewayError(
                    '',
                    'فشل إنشاء أمر الدفع من الخادم: ' + (data.message || 'بيانات غير مكتملة'),
                    data,
                    'checkout_initiate_failed',
                    'failed'
                );
                alert(data.message || 'حدث خطأ في النظام.');
                btn.disabled = false;
                btn.innerText = 'إتمام الشراء الآن والدفع عبر PaySky ←';
            }
        } catch (err) {
            console.error(err);
            logGatewayError(
                currentMerchantRef,
                'استثناء في متصفح العميل أثناء محاولة الدفع: ' + (err.message || String(err)),
                { error: String(err), stack: err.stack },
                'client_exception',
                'failed'
            );
            alert('حدث خطأ بالاتصال. يرجى المحاولة لاحقاً.');
            btn.disabled = false;
            btn.innerText = 'إتمام الشراء الآن والدفع عبر PaySky ←';
        }
    }
    </script>
</body>
</html>
