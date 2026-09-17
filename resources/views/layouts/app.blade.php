@php
    use App\Models\SiteSetting;
    use App\Models\TrackingPixel;

    $siteSettings = SiteSetting::all()->pluck('value', 'key');
    $activePixels = TrackingPixel::getActivePixels();
    $currentUrl = url()->current();
    
    $seoTitle = $siteSettings['seo_meta_title'] ?? 'OX Tech | أفضل شركة برمجة وتطوير تطبيقات وسوفت وير في السعودية ومصر والإمارات';
    $seoDesc = $siteSettings['seo_meta_description'] ?? 'أوكس تك (OX Tech) بيت خبرة تقني وتطوير برمجيات متكامل يقدم حلول البرمجة السحابية، تطوير تطبيقات الجوال، المتاجر الإلكترونية، وحلول الذكاء الاصطناعي في الرياض، القاهرة، ودبي.';
    $seoKeywords = $siteSettings['seo_meta_keywords'] ?? 'شركة برمجة في الرياض, افضل سوفت وير هاوس في السعودية, شركة تطوير تطبيقات دبي, برمجة مواقع القاهرة, شركة تقنية معلومات الرياض';
    $ogImage = !empty($siteSettings['seo_og_image']) ? url($siteSettings['seo_og_image']) : asset('assets/hero-bg.jpg');
    $favicon = $siteSettings['site_favicon'] ?? asset('favicon.ico');

    $schemaData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => url('/') . '#organization',
                'name' => $siteSettings['site_name'] ?? 'OX Tech Software House',
                'url' => url('/'),
                'logo' => !empty($siteSettings['site_logo_main']) ? url($siteSettings['site_logo_main']) : url('/assets/logo.png'),
                'description' => $seoDesc,
                'email' => $siteSettings['contact_email_primary'] ?? 'info@ox-tech.sa',
                'telephone' => $siteSettings['contact_phone_primary'] ?? '+966500000000',
                'address' => [
                    [
                        '@type' => 'PostalAddress',
                        'streetAddress' => $siteSettings['office_riyadh_address'] ?? 'طريق الملك فهد',
                        'addressLocality' => 'الرياض',
                        'addressCountry' => 'SA',
                    ],
                    [
                        '@type' => 'PostalAddress',
                        'streetAddress' => $siteSettings['office_cairo_address'] ?? 'القاهرة الجديدة',
                        'addressLocality' => 'القاهرة',
                        'addressCountry' => 'EG',
                    ],
                    [
                        '@type' => 'PostalAddress',
                        'streetAddress' => $siteSettings['office_dubai_address'] ?? 'دبي',
                        'addressLocality' => 'دبي',
                        'addressCountry' => 'AE',
                    ]
                ]
            ],
            [
                '@type' => 'SoftwareApplication',
                'name' => 'OX Tech Enterprise Cloud Solutions & Software Engineering',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem' => 'All',
                'offers' => [
                    '@type' => 'Offer',
                    'price' => '0',
                    'priceCurrency' => 'SAR',
                ]
            ]
        ]
    ];

    $currentLocale = request('lang', session('locale', request()->cookie('locale', app()->getLocale() ?: 'ar')));
    if (!in_array($currentLocale, ['ar', 'en', 'fr'])) {
        $currentLocale = 'ar';
    }
    app()->setLocale($currentLocale);
@endphp
<!doctype html>
<html lang="{{ $currentLocale }}" dir="{{ $currentLocale === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <!-- Primary Regional Tech SEO Meta Tags (KSA, Egypt, UAE) -->
    <title>@yield('title', $seoTitle)</title>
    <meta name="description" content="@yield('meta_description', $seoDesc)">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="author" content="OX Tech Software House">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $currentUrl }}"/>
    <link rel="icon" type="image/x-icon" href="{{ $favicon }}">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:title" content="@yield('title', $seoTitle)">
    <meta property="og:description" content="@yield('meta_description', $seoDesc)">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:locale" content="ar_SA">
    <meta property="og:locale:alternate" content="ar_EG">
    <meta property="og:locale:alternate" content="ar_AE">
    <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? 'OX Tech' }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $currentUrl }}">
    <meta name="twitter:title" content="@yield('title', $seoTitle)">
    <meta name="twitter:description" content="@yield('meta_description', $seoDesc)">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <!-- Geo Meta Tags for Regional Authority (Saudi Arabia, UAE, Egypt) -->
    <meta name="geo.region" content="SA-01; AE-DU; EG-C">
    <meta name="geo.placename" content="Riyadh, Dubai, Cairo">

    <!-- Schema.org JSON-LD Structured Data -->
    <script type="application/ld+json">
        {!! json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @if(!empty($siteSettings['seo_schema_custom']))
        {!! $siteSettings['seo_schema_custom'] !!}
    @endif

    <!-- Marketing Tracking Pixels Injection (GA4, GTM, Meta, Snapchat, TikTok) -->
    @if(!empty($activePixels) && is_iterable($activePixels))
        @foreach($activePixels as $pixel)
            @if(is_object($pixel) && method_exists($pixel, 'renderHeadScript'))
                {!! $pixel->renderHeadScript() !!}
            @elseif(is_string($pixel))
                {!! $pixel !!}
            @endif
        @endforeach
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Main Styles -->
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}"/>

    <style>
        :root {
            --lime-glow: rgba(201, 250, 75, 0.35);
            --blue-glow: rgba(31, 99, 255, 0.4);
            --navy-card: #0d2235;
        }

        /* Luxury Global Pagination */
        .ox-pagination-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            width: 100%;
            margin-top: 20px;
        }
        .ox-pagination-info {
            font-size: 13px;
            color: #94a3b8;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .ox-pagination-info strong {
            color: #ffffff;
            font-weight: 700;
        }
        .ox-pagination-list {
            display: inline-flex;
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 6px;
        }
        .ox-page-item {
            display: inline-block;
        }
        .ox-page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .ox-page-link:hover {
            background: rgba(201, 250, 75, 0.15);
            color: #c9fa4b;
            border-color: #c9fa4b;
        }
        .ox-page-item.active .ox-page-link {
            background: #c9fa4b;
            color: #071827;
            border-color: #c9fa4b;
            font-weight: 800;
        }
        .ox-page-item.disabled .ox-page-link {
            background: rgba(255, 255, 255, 0.02);
            color: #475569;
            border-color: rgba(255, 255, 255, 0.05);
            cursor: not-allowed;
            pointer-events: none;
        }
        nav[role="navigation"] svg {
            width: 14px !important;
            height: 14px !important;
            max-width: 14px !important;
            max-height: 14px !important;
            display: inline-block !important;
        }
        
        .consult-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(7, 24, 39, 0.85);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s ease;
        }
        .consult-modal-backdrop.active {
            opacity: 1;
            visibility: visible;
        }
        .consult-modal-box {
            background: linear-gradient(135deg, #112a3a, #071827);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            max-width: 540px;
            width: 100%;
            padding: 35px 30px;
            position: relative;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
            transform: scale(0.95);
            transition: 0.3s ease;
        }
        .consult-modal-backdrop.active .consult-modal-box {
            transform: scale(1);
        }
        .modal-close {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            display: grid;
            place-items: center;
            transition: 0.2s;
        }
        .modal-close:hover {
            background: rgba(201, 250, 75, 0.2);
            color: var(--lime);
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #c4d3cf;
            margin-bottom: 6px;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            padding: 12px 14px;
            color: #fff;
            font-family: var(--font);
            font-size: 12px;
            transition: 0.2s;
            outline: none;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--lime);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 3px var(--lime-glow);
        }
        .form-input::placeholder, .form-textarea::placeholder {
            color: #7e958f;
        }
        .form-select option {
            background: #071827;
            color: #fff;
        }
        .form-submit-btn {
            width: 100%;
            background: var(--lime);
            color: #09221e;
            border: none;
            border-radius: 99px;
            padding: 14px;
            font-weight: 700;
            font-family: var(--font);
            font-size: 13px;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        .form-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(201, 250, 75, 0.3);
        }
        .flash-alert {
            position: fixed;
            top: 90px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 99999;
            background: var(--lime);
            color: #09221e;
            padding: 14px 28px;
            border-radius: 99px;
            font-weight: 700;
            font-size: 13px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            animation: slideDown 0.4s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translate(-50%, -20px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
        .project-link-card {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .project-link-card:hover .project-visual {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }
        .project-visual {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        /* Video Modal */
        .video-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(10px);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s ease;
        }
        .video-modal-backdrop.active {
            opacity: 1;
            visibility: visible;
        }
        .video-modal-container {
            max-width: 800px;
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            background: #000;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        /* Language Switcher Dropdown */
        .lang-switcher-dropdown {
            position: relative;
            display: inline-block;
        }
        .lang-menu-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            inset-inline-start: 0;
            background: rgba(5, 18, 30, 0.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 6px;
            min-width: 140px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
            display: none;
            flex-direction: column;
            gap: 4px;
            z-index: 10001;
        }
        .lang-menu-dropdown.active {
            display: flex;
        }
        .lang-menu-dropdown a {
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .lang-menu-dropdown a:hover {
            background: rgba(201, 250, 75, 0.15);
            color: var(--lime);
        }
        .lang-menu-dropdown a.active {
            background: var(--lime);
            color: #071827;
            font-weight: 800;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Tracking Pixels Body Injection -->
    @if(!empty($activePixels) && is_iterable($activePixels))
        @foreach($activePixels as $pixel)
            @if(is_object($pixel) && method_exists($pixel, 'renderBodyScript'))
                {!! $pixel->renderBodyScript() !!}
            @endif
        @endforeach
    @endif

    @if(session('success'))
        <div class="flash-alert" id="flash-msg">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-msg');
                if (el) el.style.display = 'none';
            }, 5000);
        </script>
    @endif

    <header id="mainHeader" class="site-header">
        <!-- Left Controls: Menu Hamburger & Language EN -->
        <div class="header-left-actions">
            <button class="nav-menu-btn" id="mobileNavToggle" onclick="toggleMobileNav()" aria-label="القائمة">
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
            <div class="lang-switcher-dropdown">
                <a href="javascript:void(0)" class="lang-pill-badge" id="langBadgeBtn" onclick="toggleLangMenu(event)" title="Language">
                    {{ strtoupper($currentLocale) }}
                    <span style="font-size:8px;margin-inline-start:4px;opacity:0.75;">▼</span>
                </a>
                <div class="lang-menu-dropdown" id="langMenuDropdown">
                    <a href="{{ route('lang.switch', 'ar') }}" class="{{ $currentLocale === 'ar' ? 'active' : '' }}"><span>العربية</span> <small>AR</small></a>
                    <a href="{{ route('lang.switch', 'en') }}" class="{{ $currentLocale === 'en' ? 'active' : '' }}"><span>English</span> <small>EN</small></a>
                    <a href="{{ route('lang.switch', 'fr') }}" class="{{ $currentLocale === 'fr' ? 'active' : '' }}"><span>Français</span> <small>FR</small></a>
                </div>
            </div>
        </div>

        <!-- Center Nav Links -->
        <nav class="desktop-nav">
            <a href="{{ route('home') }}#consult">الهوية</a>
            <a href="{{ route('home') }}#stories">قصصنا</a>
            <a href="{{ route('home') }}#services">الخدمات</a>
            <a href="{{ route('home') }}#work">أعمالنا</a>
            <a href="{{ route('home') }}#home">الحكاية</a>
        </nav>

        <!-- Right Logo -->
        <a class="logo" href="{{ route('home') }}">
            @if(!empty($siteSettings['site_logo_main']))
                <img src="{{ $siteSettings['site_logo_main'] }}" alt="{{ $siteSettings['site_name'] ?? 'OX Tech' }}" style="max-height: 38px;">
            @else
                OX<span>.</span><small>{{ $siteSettings['site_name'] ?? 'TECH STUDIO' }}</small>
            @endif
        </a>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div class="mobile-nav-drawer" id="mobileNavDrawer">
        <div class="mobile-drawer-top">
            <a class="logo" href="{{ route('home') }}">
                @if(!empty($siteSettings['site_logo_main']))
                    <img src="{{ $siteSettings['site_logo_main'] }}" alt="OX Tech" style="max-height: 32px;">
                @else
                    OX<span>.</span><small>TECH STUDIO</small>
                @endif
            </a>
            <button class="mobile-drawer-close" onclick="closeMobileNav()">✕</button>
        </div>
        <div class="mobile-drawer-links">
            <a href="{{ route('home') }}#home" onclick="closeMobileNav()">✦ الرئيسية</a>
            <a href="{{ route('home') }}#work" onclick="closeMobileNav()">✦ أعمالنا ومشاريعنا</a>
            <a href="{{ route('home') }}#services" onclick="closeMobileNav()">✦ الخدمات والحلول</a>
            <a href="{{ route('home') }}#stories" onclick="closeMobileNav()">✦ قصص وآراء الشركاء</a>
            <a href="{{ route('home') }}#about" onclick="closeMobileNav()">✦ عن OX Tech</a>
            <a href="{{ route('home') }}#consult" onclick="closeMobileNav()">✦ احجز استشارتك</a>
        </div>
        <div class="mobile-drawer-footer">
            <button class="primary" onclick="closeMobileNav(); openConsultModal();" style="width: 100%; justify-content: center;">
                ابدأ مشروعك الآن <b>←</b>
            </button>
            <p style="text-align: center; font-size: 11px; color: #8fa59f; margin: 5px 0 0;">
                الرياض • القاهرة • دبي · {{ $siteSettings['contact_email_primary'] ?? 'info@ox-tech.sa' }}
            </p>
        </div>
    </div>

    @yield('content')

    <!-- Upgraded Rich Regional Footer -->
    <footer style="background: #06131f; border-top: 1px solid rgba(255,255,255,0.08); padding: 50px 30px 30px;">
        <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 35px; margin-bottom: 40px; text-align: right;">
            <!-- Brand Column -->
            <div>
                <a class="logo" href="{{ route('home') }}" style="margin-bottom: 12px; display: inline-block;">
                    @if(!empty($siteSettings['site_logo_footer']))
                        <img src="{{ $siteSettings['site_logo_footer'] }}" alt="OX Tech" style="max-height: 36px;">
                    @else
                        OX<span>.</span><small>{{ $siteSettings['site_name'] ?? 'TECH STUDIO' }}</small>
                    @endif
                </a>
                <p style="font-size: 13px; color: #94a3b8; line-height: 1.8; margin-bottom: 15px;">
                    {{ $siteSettings['footer_about_text'] ?? 'بيت برمجيات وتقنية رائد متخصص في بناء وتطوير المنصات السحابية والأنظمة المؤسسية وتطبيقات الذكاء الاصطناعي في السعودية ومصر والإمارات.' }}
                </p>
                <div style="display: flex; gap: 10px;">
                    @if(!empty($siteSettings['social_x'])) <a href="{{ $siteSettings['social_x'] }}" target="_blank" style="color: #cbd5e1; text-decoration: none; font-size: 14px;">𝕏</a> @endif
                    @if(!empty($siteSettings['social_linkedin'])) <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" style="color: #60a5fa; text-decoration: none; font-size: 14px;">in</a> @endif
                    @if(!empty($siteSettings['social_instagram'])) <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" style="color: #f472b6; text-decoration: none; font-size: 14px;">IG</a> @endif
                    @if(!empty($siteSettings['social_tiktok'])) <a href="{{ $siteSettings['social_tiktok'] }}" target="_blank" style="color: #00f2fe; text-decoration: none; font-size: 14px;">TT</a> @endif
                    @if(!empty($siteSettings['social_snapchat'])) <a href="{{ $siteSettings['social_snapchat'] }}" target="_blank" style="color: #facc15; text-decoration: none; font-size: 14px;">Snap</a> @endif
                </div>
            </div>

            <!-- Regional Offices -->
            <div>
                <h4 style="color: #fff; font-size: 15px; margin-bottom: 15px; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 6px;">📍 مكاتبنا الإقليمية</h4>
                <p style="font-size: 12px; color: #cbd5e1; margin: 0 0 8px;"><strong>🇸🇦 الرياض:</strong> {{ $siteSettings['office_riyadh_address'] ?? 'طريق الملك فهد، حي الصحافة' }}</p>
                <p style="font-size: 12px; color: #cbd5e1; margin: 0 0 8px;"><strong>🇪🇬 القاهرة:</strong> {{ $siteSettings['office_cairo_address'] ?? 'التجمع الخامس، شارع التسعين الشمالي' }}</p>
                <p style="font-size: 12px; color: #cbd5e1; margin: 0 0 8px;"><strong>🇦🇪 دبي:</strong> {{ $siteSettings['office_dubai_address'] ?? 'أبراج بحيرات جميرا (JLT)، دبي' }}</p>
            </div>

            <!-- Fast Links -->
            <div>
                <h4 style="color: #fff; font-size: 15px; margin-bottom: 15px; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 6px;">⚡ روابط هامة</h4>
                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 13px;">
                    <a href="{{ route('home') }}#work" style="color: #94a3b8; text-decoration: none;">مشاريعنا وأعمالنا</a>
                    <a href="{{ route('home') }}#services" style="color: #94a3b8; text-decoration: none;">الخدمات التقنية والسحابية</a>
                    <a href="{{ route('home') }}#stories" style="color: #94a3b8; text-decoration: none;">قصص نجاح العملاء</a>
                    <a href="{{ route('seo.sitemap') }}" target="_blank" style="color: #94a3b8; text-decoration: none;">خريطة الموقع (Sitemap.xml)</a>
                    <a href="{{ route('admin.login') }}" style="color: var(--lime); text-decoration: none; font-weight: bold;">دخول لوحة التحكم 🔒</a>
                </div>
            </div>

            <!-- Direct Contact -->
            <div>
                <h4 style="color: #fff; font-size: 15px; margin-bottom: 15px; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 6px;">📞 تواصل مباشر</h4>
                <p style="font-size: 13px; color: #cbd5e1; margin: 0 0 6px;">
                    📧 <a href="mailto:{{ $siteSettings['contact_email_primary'] ?? 'info@ox-tech.sa' }}" style="color: #60a5fa; text-decoration: none;">{{ $siteSettings['contact_email_primary'] ?? 'info@ox-tech.sa' }}</a>
                </p>
                <p style="font-size: 13px; color: #cbd5e1; margin: 0 0 6px;">
                    💬 <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_phone_primary'] ?? '966500000000') }}" style="color: var(--lime); text-decoration: none;">{{ $siteSettings['contact_phone_primary'] ?? '+966 50 000 0000' }}</a>
                </p>
                <button onclick="openConsultModal()" style="margin-top: 10px; background: var(--lime); color: #071827; border: none; padding: 8px 18px; border-radius: 99px; font-weight: bold; font-family: var(--font); cursor: pointer; font-size: 12px;">
                    حجز استشارة فورية 🚀
                </button>
            </div>
        </div>

        <div style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px; text-align: center; font-size: 12px; color: #64748b;">
            {{ $siteSettings['footer_copyright'] ?? ('جميع الحقوق محفوظة © ' . date('Y') . ' لشركة OX Tech Software House.') }}
        </div>
    </footer>

    <!-- Consultation Modal with UTM Marketing Attribution Inputs -->
    <div class="consult-modal-backdrop" id="consultModal">
        <div class="consult-modal-box">
            <button class="modal-close" onclick="closeConsultModal()">✕</button>
            <p class="kicker" style="color:var(--lime); margin-bottom: 8px;">LET'S TALK</p>
            <h3 style="font-size: 24px; margin: 0 0 10px; font-weight: 800;">احجز جلسة استشارة مجانية</h3>
            <p style="font-size: 12px; color: #a4b7b1; margin-bottom: 20px; line-height: 1.8;">
                استشارة أولية مركزة لمدة 30 دقيقة لنناقش متطلبات مشروعك البرمجي ونقترح خطة التنفيذ الأنسب.
            </p>

            <form action="{{ route('consultation.store') }}" method="POST" id="consultationForm">
                @csrf
                <!-- Anti-Spam Bot Trap (Honeypot & Time-Trap) -->
                <input type="text" name="hp_check" value="" style="display:none !important; position:absolute; left:-9999px;" tabindex="-1" autocomplete="off">
                <input type="hidden" name="_form_load_time" value="{{ time() }}">

                <!-- Marketing Attribution Hidden Inputs -->
                <input type="hidden" name="utm_source" value="{{ session('attribution.utm_source', request('utm_source')) }}">
                <input type="hidden" name="utm_medium" value="{{ session('attribution.utm_medium', request('utm_medium')) }}">
                <input type="hidden" name="utm_campaign" value="{{ session('attribution.utm_campaign', request('utm_campaign')) }}">
                <input type="hidden" name="utm_term" value="{{ session('attribution.utm_term', request('utm_term')) }}">
                <input type="hidden" name="utm_content" value="{{ session('attribution.utm_content', request('utm_content')) }}">
                <input type="hidden" name="platform_detected" value="{{ session('attribution.platform_detected') }}">

                <div class="form-group">
                    <label class="form-label">الاسم الكريم *</label>
                    <input type="text" name="name" class="form-input" placeholder="مثال: عبدالله الراجحي" maxlength="70" required>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">البريد الإلكتروني *</label>
                        <input type="email" name="email" class="form-input" placeholder="name@company.com" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">رقم الجوال / واتساب</label>
                        <input type="text" name="phone" class="form-input" placeholder="+966 50 000 0000" maxlength="30">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">نوع المشروع</label>
                        <select name="project_type" class="form-select">
                            <option value="منصات ومواقع ويب">منصات ومواقع ويب</option>
                            <option value="متاجر إلكترونية">متجر إلكتروني متكامل</option>
                            <option value="تطبيقات ومنتجات">تطبيق جوال iOS / Android</option>
                            <option value="أنظمة مخصصة وSaaS">نظام سحابي / SaaS مخصص</option>
                            <option value="تكاملات وتطوير">تكاملات وأتمتة</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">الميزانية التقديرية</label>
                        <select name="budget" class="form-select">
                            <option value="أقل من $10,000">أقل من $10,000</option>
                            <option value="$10,000 - $25,000">$10,000 - $25,000</option>
                            <option value="$25,000 - $50,000">$25,000 - $50,000</option>
                            <option value="أكثر من $50,000">أكثر من $50,000</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">تفاصيل الفكرة أو التحدي *</label>
                    <textarea name="message" class="form-textarea" rows="3" placeholder="أخبرنا باختصار عن فكرتك وما ترغب في تحقيقه..." minlength="10" maxlength="1000" required></textarea>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #8fa099; margin-top: 4px;">
                        <span>الحد الأدنى 10 أحرف</span>
                        <span id="modalMsgCounter">0 / 1000 حرف</span>
                    </div>
                </div>
                <button type="submit" class="form-submit-btn">
                    <span>إرسال وتأكيد الحجز</span>
                    <b>←</b>
                </button>
            </form>
        </div>
    </div>

    <!-- Video Review Player Modal -->
    <div class="video-modal-backdrop" id="videoModal">
        <div class="video-modal-container">
            <button class="modal-close" onclick="closeVideoModal()" style="top: 12px; left: 12px; z-index: 10;">✕</button>
            <div id="videoPlayerBox">
                <!-- Video Element Injected by JS -->
            </div>
        </div>
    </div>

    <script>
        function openConsultModal() {
            document.getElementById('consultModal').classList.add('active');
        }
        function closeConsultModal() {
            document.getElementById('consultModal').classList.remove('active');
        }
        document.getElementById('consultModal').addEventListener('click', function(e) {
            if (e.target === this) closeConsultModal();
        });

        // Live Character Counter for Modal
        const modalMsg = document.querySelector('#consultationForm textarea[name="message"]');
        const modalMsgCounter = document.getElementById('modalMsgCounter');
        if (modalMsg && modalMsgCounter) {
            modalMsg.addEventListener('input', function() {
                modalMsgCounter.innerText = `${this.value.length} / 1000 حرف`;
                if (this.value.length > 900) {
                    modalMsgCounter.style.color = '#f59e0b';
                } else {
                    modalMsgCounter.style.color = '#8fa099';
                }
            });
        }

        function openVideoModal(videoSrc, isDirect) {
            const box = document.getElementById('videoPlayerBox');
            if (isDirect) {
                box.innerHTML = `<video src="${videoSrc}" controls autoplay style="width:100%; height:450px; object-fit:cover;"></video>`;
            } else {
                box.innerHTML = `<iframe src="${videoSrc}" allow="autoplay; fullscreen" style="width:100%; height:450px;"></iframe>`;
            }
            document.getElementById('videoModal').classList.add('active');
        }
        function closeVideoModal() {
            document.getElementById('videoModal').classList.remove('active');
            document.getElementById('videoPlayerBox').innerHTML = '';
        }

        // Language Switcher Dropdown Handler
        function toggleLangMenu(e) {
            if (e) e.stopPropagation();
            const m = document.getElementById('langMenuDropdown');
            if (m) m.classList.toggle('active');
        }
        document.addEventListener('click', () => {
            const m = document.getElementById('langMenuDropdown');
            if (m) m.classList.remove('active');
        });

        // Mobile Drawer Handlers
        function toggleMobileNav() {
            const drawer = document.getElementById('mobileNavDrawer');
            if (drawer) drawer.classList.toggle('active');
        }
        function closeMobileNav() {
            const drawer = document.getElementById('mobileNavDrawer');
            if (drawer) drawer.classList.remove('active');
        }

        // Sticky Header on Scroll
        window.addEventListener('scroll', () => {
            const header = document.getElementById('mainHeader');
            if (header) {
                if (window.scrollY > 40) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
