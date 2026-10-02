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

    $currentLocale = app()->getLocale();
    if (!in_array($currentLocale, ['ar', 'en', 'fr'])) {
        $currentLocale = 'ar';
    }

    $defaultTitles = [
        'ar' => $siteSettings['seo_meta_title'] ?? 'OX Tech | أفضل شركة برمجة وتطوير تطبيقات وسوفت وير في السعودية ومصر والإمارات',
        'en' => 'OX Tech | Premier Software House & Enterprise Cloud Solutions in Saudi Arabia, UAE & Egypt',
        'fr' => 'OX Tech | Maison d\'Ingénierie Logicielle & Solutions Cloud d\'Entreprise en Arabie Saoudite, EAU & Égypte',
    ];
    $defaultDescs = [
        'ar' => $siteSettings['seo_meta_description'] ?? 'أوكس تك (OX Tech) بيت خبرة تقني وتطوير برمجيات متكامل يقدم حلول البرمجة السحابية، تطوير تطبيقات الجوال، المتاجر الإلكترونية، وحلول الذكاء الاصطناعي في الرياض، القاهرة، ودبي.',
        'en' => 'OX Tech is an elite software engineering powerhouse delivering custom cloud architecture, mobile apps, SaaS, and AI automation across Riyadh, Cairo, and Dubai.',
        'fr' => 'OX Tech est une référence en ingénierie logicielle et développement cloud, applications mobiles, plateformes SaaS et solutions IA à Riyad, Le Caire et Dubaï.',
    ];
    $seoTitle = $defaultTitles[$currentLocale] ?? $defaultTitles['ar'];
    $seoDesc = $defaultDescs[$currentLocale] ?? $defaultDescs['ar'];
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
    <link rel="alternate" hreflang="ar" href="{{ route('lang.switch', 'ar') }}"/>
    <link rel="alternate" hreflang="en" href="{{ route('lang.switch', 'en') }}"/>
    <link rel="alternate" hreflang="fr" href="{{ route('lang.switch', 'fr') }}"/>
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}"/>
    <link rel="icon" type="image/x-icon" href="{{ $favicon }}">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:title" content="@yield('title', $seoTitle)">
    <meta property="og:description" content="@yield('meta_description', $seoDesc)">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:locale" content="{{ $currentLocale === 'ar' ? 'ar_SA' : ($currentLocale === 'fr' ? 'fr_FR' : 'en_US') }}">
    <meta property="og:locale:alternate" content="{{ $currentLocale === 'ar' ? 'en_US' : 'ar_SA' }}">
    <meta property="og:locale:alternate" content="fr_FR">
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

    <!-- ─── Font Preconnects ─── -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- ─── Google Fonts: Arabic (Cairo + Tajawal + Alexandria) & Latin (Poppins + Syne + Plus Jakarta Sans) ─── -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800&family=Poppins:wght@400;500;600;700;800&family=Alexandria:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">

    <!-- ─── Main Styles ─── -->
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}" fetchpriority="high"/>
    <link rel="stylesheet" href="{{ asset('assets/ox-theme.css') }}" fetchpriority="high"/>

    <style>
        :root {
            /* ===== BRAND COLORS ===== */
            --ox-carbon:       #071B19;
            --ox-emerald:      #1D8A68;
            --ox-ivory:        #F3EFE5;
            --ox-gold:         #C8A96B;

            /* ===== EXTENDED COLORS ===== */
            --ox-dark-card:    #0D2925;
            --ox-dark-soft:    #12352F;
            --ox-white:        #FFFFFF;
            --ox-gray:         #A7B3AE;
            --ox-border:       rgba(29, 138, 104, 0.25);

            /* ─── Unified Design Tokens (Mapped to Master Theme) ─── */
            --ink:             var(--ox-ivory);
            --navy:            var(--ox-carbon);
            --navy-deep:       #041210;
            --navy-mid:        var(--ox-dark-card);
            --lime:            var(--ox-emerald);
            --lime-glow:       rgba(29, 138, 104, 0.25);
            --blue:            #1A56F5;
            --blue-glow:       rgba(26, 86, 245, 0.35);
            --indigo:          #3226A0;
            --gold:            var(--ox-gold);
            --muted:           var(--ox-gray);
            --border:          var(--ox-border);
            --navy-card:       var(--ox-dark-card);

            /* ─── Typography Fonts ─── */
            --font-ar:          "Cairo", "Tajawal", 'Alexandria', system-ui, sans-serif;
            --font-en:          "Poppins", 'Plus Jakarta Sans', system-ui, sans-serif;
            --font-display-en:  "Poppins", 'Syne', sans-serif;

            /* Default active typography */
            --font:            var(--font-ar);
            --font-body:       var(--font-ar);
            --font-latin:      var(--font-en);

            /* ─── Radii ─── */
            --radius-sm:  8px;
            --radius-md:  14px;
            --radius-lg:  24px;
            --radius-xl:  28px;
        }

        /* ─── Explicit Typography Rules (Arabic vs English/Latin) ─── */
        html[lang="ar"],
        html[dir="rtl"] {
            --font:      var(--font-ar);
            --font-body: var(--font-ar);
            font-family: var(--font-ar);
        }
        html[lang="ar"] body,
        html[lang="ar"] h1,
        html[lang="ar"] h2,
        html[lang="ar"] h3,
        html[lang="ar"] h4,
        html[lang="ar"] h5,
        html[lang="ar"] h6,
        html[lang="ar"] p,
        html[lang="ar"] a,
        html[lang="ar"] span,
        html[lang="ar"] button,
        html[lang="ar"] input,
        html[lang="ar"] select,
        html[lang="ar"] textarea {
            font-family: var(--font-ar);
        }

        html[lang="en"],
        html[lang="fr"],
        html[dir="ltr"] {
            --font:      var(--font-en);
            --font-body: var(--font-en);
            font-family: var(--font-en);
        }
        html[lang="en"] body,
        html[lang="en"] p,
        html[lang="en"] a,
        html[lang="en"] span,
        html[lang="en"] button,
        html[lang="en"] input,
        html[lang="en"] select,
        html[lang="en"] textarea,
        html[lang="fr"] body,
        html[lang="fr"] p,
        html[lang="fr"] a,
        html[lang="fr"] span,
        html[lang="fr"] button,
        html[lang="fr"] input,
        html[lang="fr"] select,
        html[lang="fr"] textarea {
            font-family: var(--font-en);
        }
        html[lang="en"] h1,
        html[lang="en"] h2,
        html[lang="en"] h3,
        html[lang="en"] h4,
        html[lang="fr"] h1,
        html[lang="fr"] h2,
        html[lang="fr"] h3,
        html[lang="fr"] h4 {
            font-family: var(--font-display-en);
            letter-spacing: -0.02em;
        }

        .brand-logo-svg text,
        .brand-card text,
        .video-no,
        .en-num {
            font-family: var(--font-en) !important;
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
            background: rgba(189,255,69,0.15);
            color: #BDFF45;
            border-color: #BDFF45;
        }
        .ox-page-item.active .ox-page-link {
            background: #BDFF45;
            color: var(--navy);
            border-color: #BDFF45;
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
            background: linear-gradient(135deg, #112a3a, #060F1A);
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
            background: rgba(189,255,69,0.20);
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
            background: var(--navy);
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
            box-shadow: 0 10px 25px rgba(189,255,69,0.30);
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
            background: rgba(189,255,69,0.15);
            color: var(--lime);
        }
        .lang-menu-dropdown a.active {
            background: var(--lime);
            color: var(--navy);
            font-weight: 800;
        }

        /* ─── Floating Actions Stack (Left Side) ─── */
        .ox-floating-actions {
            position: fixed;
            bottom: 26px;
            left: 24px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        /* Language Trigger */
        .ox-lang-widget {
            position: relative;
        }
        .ox-lang-trigger {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(6, 15, 26, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #ffffff;
            padding: 7px 14px;
            border-radius: 99px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.45);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: var(--font);
        }
        .ox-lang-trigger:hover {
            background: rgba(10, 28, 46, 0.98);
            border-color: var(--lime);
            box-shadow: 0 8px 26px rgba(189, 255, 69, 0.25);
            transform: translateY(-2px);
        }
        .ox-lang-flag {
            font-size: 17px;
            line-height: 1;
        }
        .ox-lang-text {
            font-family: var(--font-en);
            letter-spacing: 0.5px;
            font-size: 12px;
        }
        .ox-lang-arrow {
            transition: transform 0.2s ease;
            opacity: 0.8;
        }
        .ox-lang-widget.open .ox-lang-arrow {
            transform: rotate(180deg);
        }

        /* Language Popover */
        .ox-lang-popover {
            position: absolute;
            bottom: calc(100% + 10px);
            left: 0;
            background: rgba(6, 15, 26, 0.96);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 16px;
            padding: 8px;
            min-width: 175px;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.65);
            display: none;
            flex-direction: column;
            gap: 4px;
            animation: oxPopIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 100000;
        }
        .ox-lang-widget.open .ox-lang-popover {
            display: flex;
        }
        @keyframes oxPopIn {
            from { opacity: 0; transform: translateY(8px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .ox-lang-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .ox-lang-option:hover {
            background: rgba(189, 255, 69, 0.12);
            color: var(--lime);
        }
        .ox-lang-option.active {
            background: var(--lime);
            color: var(--navy);
            font-weight: 800;
        }
        .ox-flag-emoji {
            font-size: 16px;
            line-height: 1;
        }
        .ox-lang-name {
            flex: 1;
        }
        .ox-lang-option .ox-lang-code {
            font-size: 10px;
            opacity: 0.7;
            font-family: var(--font-en);
        }
        .ox-lang-option .ox-active-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--navy);
        }

        /* WhatsApp Floating Button */
        .ox-whatsapp-btn {
            position: relative;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.45), 0 4px 12px rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .ox-whatsapp-btn:hover {
            transform: translateY(-3px) scale(1.06);
            box-shadow: 0 12px 30px rgba(37, 211, 102, 0.65), 0 4px 16px rgba(0, 0, 0, 0.4);
        }
        .ox-whatsapp-pulse {
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 2px solid #25D366;
            animation: oxWaPulse 2.4s infinite cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
        }
        @keyframes oxWaPulse {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.35); opacity: 0; }
            100% { transform: scale(1); opacity: 0; }
        }
        .ox-whatsapp-icon-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        /* WhatsApp Tooltip */
        .ox-whatsapp-tooltip {
            position: absolute;
            left: calc(100% + 14px);
            top: 50%;
            transform: translateY(-50%) translateX(-8px);
            background: rgba(6, 15, 26, 0.95);
            backdrop-filter: blur(12px);
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 8px;
            white-space: nowrap;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            pointer-events: none;
            opacity: 0;
            transition: all 0.25s ease;
            font-family: var(--font);
        }
        .ox-whatsapp-btn:hover .ox-whatsapp-tooltip {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }

        @media (max-width: 640px) {
            .ox-floating-actions {
                bottom: 18px;
                left: 16px;
                gap: 10px;
            }
            .ox-whatsapp-btn {
                width: 50px;
                height: 50px;
            }
            .ox-whatsapp-btn svg {
                width: 24px;
                height: 24px;
            }
        }

        /* ═══════════════════════════════════════════════════════════════
           Ultra-Premium Executive Regional Footer
           ═══════════════════════════════════════════════════════════════ */
        .ox-premium-footer {
            background: radial-gradient(circle at 15% 15%, rgba(22, 98, 196, 0.14) 0%, transparent 45%),
                        radial-gradient(circle at 85% 20%, rgba(18, 158, 56, 0.12) 0%, transparent 50%),
                        radial-gradient(circle at 50% 95%, rgba(49, 30, 158, 0.14) 0%, transparent 55%),
                        #030e12;
            position: relative;
            overflow: hidden;
            color: #e2e8f0;
            font-family: var(--font);
            padding: 0 0 32px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05), 0 -20px 50px rgba(0, 0, 0, 0.4);
        }

        .ox-premium-footer::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.06) 1.5px, transparent 1.5px);
            background-size: 22px 22px;
            opacity: 0.55;
            pointer-events: none;
        }

        /* Top Luminous Highlight Bar */
        .footer-glow-bar {
            height: 2px;
            width: 100%;
            background: linear-gradient(90deg, transparent 0%, rgba(22,98,196,0.6) 25%, rgba(189,255,69,0.8) 50%, rgba(18,158,56,0.6) 75%, transparent 100%);
            box-shadow: 0 0 16px rgba(189,255,69,0.4);
            position: relative;
            z-index: 5;
        }

        /* Pre-Footer Action Banner */
        .footer-pre-banner {
            background: linear-gradient(90deg, rgba(22, 98, 196, 0.14) 0%, rgba(18, 158, 56, 0.12) 50%, rgba(49, 30, 158, 0.14) 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 22px 5vw;
            position: relative;
            z-index: 2;
        }
        .footer-pre-banner-inner {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }
        .footer-pre-text {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .footer-pre-title {
            font-size: clamp(16px, 1.8vw, 21px);
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            letter-spacing: -0.3px;
        }
        .footer-pre-sub {
            font-size: 13px;
            color: #94a8a2;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .footer-live-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(18, 158, 56, 0.2);
            border: 1px solid rgba(18, 158, 56, 0.45);
            color: #bbf7d0;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
        }
        .footer-live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--lime);
            box-shadow: 0 0 10px var(--lime);
            animation: livePulse 2s infinite ease-in-out;
        }

        /* Main Grid */
        .footer-main-container {
            max-width: 1240px;
            margin: 40px auto 30px;
            padding: 0 5vw;
            display: grid;
            grid-template-columns: 1.25fr 1.05fr 0.85fr 1fr;
            gap: 24px;
            position: relative;
            z-index: 2;
        }

        /* Glass Card */
        .footer-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.035) 0%, rgba(255, 255, 255, 0.01) 100%);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-top: 1px solid rgba(189, 255, 69, 0.35);
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
        }
        .footer-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.16);
            border-top-color: var(--lime);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.45), 0 0 25px rgba(18, 158, 56, 0.08);
        }

        .footer-card-title {
            color: #ffffff;
            font-size: 15px;
            font-weight: 800;
            margin: 0 0 16px;
            padding-bottom: 10px;
            border-bottom: 1px dashed rgba(189, 255, 69, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.3px;
        }

        /* Social Buttons */
        .footer-social-strip {
            display: flex;
            gap: 9px;
            margin-top: auto;
            padding-top: 16px;
            flex-wrap: wrap;
        }
        .footer-social-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            display: grid;
            place-items: center;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .footer-social-btn:hover {
            background: rgba(189, 255, 69, 0.15);
            border-color: var(--lime);
            color: var(--lime);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(189, 255, 69, 0.25);
        }

        /* Regional Office Subcards */
        .footer-office-item {
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.25s ease;
        }
        .footer-office-item:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(22, 98, 196, 0.35);
        }
        .footer-office-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
        }
        .footer-office-badge {
            font-size: 9px;
            padding: 2px 7px;
            border-radius: 99px;
            background: rgba(18, 158, 56, 0.18);
            color: var(--lime);
            border: 1px solid rgba(18, 158, 56, 0.3);
            font-weight: 600;
        }
        .footer-office-addr {
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.5;
            margin: 0;
        }

        /* Nav Links */
        .footer-links-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .footer-link-item {
            font-size: 13px;
            color: #94a8a2;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
        }
        .footer-link-item:hover {
            color: var(--lime);
            transform: translateX(-4px);
        }
        [dir="ltr"] .footer-link-item:hover {
            transform: translateX(4px);
        }

        /* Direct Contact Info */
        .footer-contact-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            margin-bottom: 10px;
            text-decoration: none;
            color: #cbd5e1;
            font-size: 12px;
            transition: all 0.25s ease;
        }
        .footer-contact-row:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--lime);
            color: #ffffff;
        }
        .footer-contact-icon {
            font-size: 16px;
            color: var(--lime);
        }

        /* Central Heritage Emblem */
        .footer-emblem-wrap {
            display: flex;
            justify-content: center;
            margin: 15px auto 25px;
            padding: 0 5vw;
            position: relative;
            z-index: 2;
        }
        .footer-emblem {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            padding: 10px 26px;
            background: linear-gradient(135deg, rgba(18, 158, 56, 0.14) 0%, rgba(22, 98, 196, 0.14) 100%);
            border: 1.5px solid rgba(18, 158, 56, 0.5);
            border-radius: 99px;
            box-shadow: 0 0 25px rgba(18, 158, 56, 0.2), inset 0 0 15px rgba(189, 255, 69, 0.08);
        }
        .footer-emblem-stars {
            color: var(--lime);
            font-size: 12px;
            letter-spacing: 2px;
        }
        .footer-emblem-text {
            font-weight: 800;
            font-size: 13px;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        /* Bottom Bar */
        .footer-bottom-bar {
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding: 22px 5vw 0;
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            font-size: 12px;
            color: #64748b;
            position: relative;
            z-index: 2;
        }
        .footer-back-to-top {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.25s ease;
            cursor: pointer;
        }
        .footer-back-to-top:hover {
            background: var(--lime);
            color: #061720;
            border-color: var(--lime);
            box-shadow: 0 4px 15px rgba(189, 255, 69, 0.35);
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .footer-main-container {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
        }
        @media (max-width: 640px) {
            .footer-main-container {
                grid-template-columns: 1fr;
                gap: 16px;
                margin: 25px auto 20px;
            }
            .footer-pre-banner-inner {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .footer-bottom-bar {
                flex-direction: column;
                text-align: center;
                gap: 12px;
            }
            .footer-emblem {
                padding: 8px 16px;
                gap: 8px;
            }
            .footer-emblem-text {
                font-size: 11px;
            }
        }
    </style>
    @stack('styles')
</head>
<body style="-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;">

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

    <header id="mainHeader" class="navbar site-header">
        <div class="container navbar-inner">
            <!-- Right CTA Action in RTL -->
            <div class="navbar-cta-group">
                <a href="#consult" onclick="openConsultModal(); return false;" class="btn-primary nav-cta-btn">
                    <span>{{ $currentLocale === 'ar' ? 'ابدأ مشروعك' : ($currentLocale === 'fr' ? 'Démarrer Projet' : 'Start Project') }}</span>
                    <span class="btn-arrow-icon">{{ $currentLocale === 'ar' ? '←' : '→' }}</span>
                </a>
            </div>

            <!-- Center Navigation Links -->
            <nav class="navbar-links">
                @if($currentLocale === 'ar')
                    <a href="{{ route('home') }}" class="active">الرئيسية</a>
                    <a href="{{ route('home') }}#services">خدماتنا</a>
                    <a href="{{ route('home') }}#work">أعمالنا</a>
                    <a href="{{ route('home') }}#about">من نحن</a>
                    <a href="{{ route('home') }}#consult">تواصل معنا</a>
                @elseif($currentLocale === 'fr')
                    <a href="{{ route('home') }}" class="active">Accueil</a>
                    <a href="{{ route('home') }}#services">Services</a>
                    <a href="{{ route('home') }}#work">Réalisations</a>
                    <a href="{{ route('home') }}#about">À Propos</a>
                    <a href="{{ route('home') }}#consult">Contact</a>
                @else
                    <a href="{{ route('home') }}" class="active">Home</a>
                    <a href="{{ route('home') }}#services">Services</a>
                    <a href="{{ route('home') }}#work">Work</a>
                    <a href="{{ route('home') }}#about">About</a>
                    <a href="{{ route('home') }}#consult">Contact</a>
                @endif
            </nav>

            <!-- Left Brand Logo & Lang Switcher in RTL -->
            <div class="navbar-brand-wrap">
                <a class="ox-brand-logo" href="{{ route('home') }}">
                    <span class="ox-logo-title">Ox<span class="dot-accent">Tech</span></span>
                    <span class="ox-logo-subtitle">TECHNOLOGY FOR A BETTER TOMORROW</span>
                </a>

                <div class="navbar-controls">
                    <div class="lang-switcher-dropdown">
                        <a href="javascript:void(0)" class="ox-lang-pill" id="langBadgeBtn" onclick="toggleLangMenu(event)" title="Language">
                            {{ strtoupper($currentLocale) }}
                            <span style="font-size:8px; margin-inline-start:2px; opacity:0.75;">▼</span>
                        </a>
                        <div class="lang-menu-dropdown" id="langMenuDropdown">
                            <a href="{{ route('lang.switch', 'ar') }}" class="{{ $currentLocale === 'ar' ? 'active' : '' }}"><span>🇸🇦 العربية</span> <small>AR</small></a>
                            <a href="{{ route('lang.switch', 'en') }}" class="{{ $currentLocale === 'en' ? 'active' : '' }}"><span>🇬🇧 English</span> <small>EN</small></a>
                            <a href="{{ route('lang.switch', 'fr') }}" class="{{ $currentLocale === 'fr' ? 'active' : '' }}"><span>🇫🇷 Français</span> <small>FR</small></a>
                        </div>
                    </div>

                    <button class="ox-menu-toggle" id="mobileNavToggle" onclick="toggleMobileNav()" aria-label="القائمة">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
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
            @if($currentLocale === 'ar')
                <a href="{{ route('home') }}#home" onclick="closeMobileNav()">✦ الرئيسية</a>
                <a href="{{ route('home') }}#work" onclick="closeMobileNav()">✦ أعمالنا ومشاريعنا</a>
                <a href="{{ route('home') }}#services" onclick="closeMobileNav()">✦ الخدمات والحلول</a>
                <a href="{{ route('home') }}#stories" onclick="closeMobileNav()">✦ قصص وآراء الشركاء</a>
                <a href="{{ route('home') }}#about" onclick="closeMobileNav()">✦ عن OX Tech</a>
                <a href="{{ route('home') }}#consult" onclick="closeMobileNav()">✦ احجز استشارتك</a>
            @elseif($currentLocale === 'fr')
                <a href="{{ route('home') }}#home" onclick="closeMobileNav()">✦ Accueil</a>
                <a href="{{ route('home') }}#work" onclick="closeMobileNav()">✦ Nos Projets</a>
                <a href="{{ route('home') }}#services" onclick="closeMobileNav()">✦ Services & Solutions</a>
                <a href="{{ route('home') }}#stories" onclick="closeMobileNav()">✦ Témoignages Partenaires</a>
                <a href="{{ route('home') }}#about" onclick="closeMobileNav()">✦ À Propos de Nous</a>
                <a href="{{ route('home') }}#consult" onclick="closeMobileNav()">✦ Réserver Consultation</a>
            @else
                <a href="{{ route('home') }}#home" onclick="closeMobileNav()">✦ Home</a>
                <a href="{{ route('home') }}#work" onclick="closeMobileNav()">✦ Work & Projects</a>
                <a href="{{ route('home') }}#services" onclick="closeMobileNav()">✦ Services & Solutions</a>
                <a href="{{ route('home') }}#stories" onclick="closeMobileNav()">✦ Partner Stories</a>
                <a href="{{ route('home') }}#about" onclick="closeMobileNav()">✦ About OX Tech</a>
                <a href="{{ route('home') }}#consult" onclick="closeMobileNav()">✦ Book Consultation</a>
            @endif
        </div>
        <div class="mobile-drawer-footer">
            <button class="primary" onclick="closeMobileNav(); openConsultModal();" style="width: 100%; justify-content: center;">
                {{ $currentLocale === 'ar' ? 'ابدأ مشروعك الآن' : ($currentLocale === 'fr' ? 'Démarrer Votre Projet' : 'Start Your Project Now') }} <b>{{ $currentLocale === 'ar' ? '←' : '→' }}</b>
            </button>
            <p style="text-align: center; font-size: 11px; color: #8fa59f; margin: 5px 0 0;">
                {{ $currentLocale === 'ar' ? 'الرياض • القاهرة • دبي' : 'Riyadh • Cairo • Dubai' }} · {{ $siteSettings['contact_email_primary'] ?? 'info@ox-tech.sa' }}
            </p>
        </div>
    </div>

    @yield('content')

    <!-- ═══════════════════════════════════════════════════════════════
         Ultra-Premium Executive Regional Footer with Saudi Cultural Tapestry
         ═══════════════════════════════════════════════════════════════ -->
    <footer class="ox-premium-footer">
        <!-- Top Luminous Specular Accent Bar -->
        <div class="footer-glow-bar"></div>

        <!-- Pre-Footer Action Ribbon -->
        <div class="footer-pre-banner">
            <div class="footer-pre-banner-inner">
                <div class="footer-pre-text">
                    <h3 class="footer-pre-title">
                        {{ $currentLocale === 'ar' ? 'هل تخطط لإطلاق أو توسيع منصتك الرقمية القادمة؟' : ($currentLocale === 'fr' ? 'Prêt à concevoir votre prochaine plateforme digitale ?' : 'Ready to engineer your next scalable digital product?') }}
                    </h3>
                    <p class="footer-pre-sub">
                        <span class="footer-live-badge"><span class="footer-live-dot"></span> {{ $currentLocale === 'ar' ? 'متاحون لاستقبال مشاريع جديدة' : ($currentLocale === 'fr' ? 'Disponibles pour nouveaux projets' : 'Available for new projects') }}</span>
                        <span>{{ $currentLocale === 'ar' ? 'فرقنا الهندسية في الرياض ودبي والقاهرة جاهزة للتعاون معك.' : ($currentLocale === 'fr' ? 'Nos équipes à Riyad, Dubaï et Le Caire sont à votre écoute.' : 'Our teams in Riyadh, Dubai & Cairo are ready to collaborate.') }}</span>
                    </p>
                </div>
                <div>
                    <button onclick="openConsultModal()" class="pill-btn-lime" style="padding: 10px 24px; font-size: 13px;">
                        {{ $currentLocale === 'ar' ? 'احجز جلسة استشارية أولية ⚡' : ($currentLocale === 'fr' ? 'Réserver une session ⚡' : 'Book a Discovery Call ⚡') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Main 4-Column Luxury Grid -->
        <div class="footer-main-container">
            <!-- Col 1: Brand & Regional Identity -->
            <div class="footer-card">
                <a class="logo" href="{{ route('home') }}" style="margin-bottom: 14px; display: inline-flex;">
                    @if(!empty($siteSettings['site_logo_footer']))
                        <img src="{{ $siteSettings['site_logo_footer'] }}" alt="OX Tech" style="max-height: 38px;">
                    @else
                        OX<span>.</span><small>{{ $siteSettings['site_name'] ?? 'TECH STUDIO' }}</small>
                    @endif
                </a>
                <p style="font-size: 13px; color: #a4b8b2; line-height: 1.8; margin: 0 0 16px;">
                    @if($currentLocale === 'ar')
                        {{ $siteSettings['footer_about_text'] ?? 'بيت برمجيات وتقنية رائد متخصص في بناء وتطوير المنصات السحابية، الأنظمة المؤسسية، والحلول الرقمية الذكية في السعودية ومصر والإمارات.' }}
                    @elseif($currentLocale === 'fr')
                        Maison d'ingénierie logicielle d'élite dédiée au développement de plateformes cloud, d'architectures SaaS et de solutions d'intelligence artificielle en Arabie Saoudite, en Égypte et aux EAU.
                    @else
                        Premier software engineering studio building high-performance enterprise platforms, custom cloud applications, and AI integrations across Saudi Arabia, Egypt, and the UAE.
                    @endif
                </p>
                
                <!-- Regional Trust Badge -->
                <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(18, 158, 56, 0.1); border: 1px solid rgba(18, 158, 56, 0.25); padding: 5px 12px; border-radius: 8px; margin-bottom: 12px; width: fit-content;">
                    <span style="font-size: 13px;">🇸🇦</span>
                    <span style="font-size: 11px; font-weight: 700; color: #d8fae5;">{{ $currentLocale === 'ar' ? 'سجل تجاري معتمد · الرياض' : 'Registered Tech House · Riyadh' }}</span>
                </div>

                <!-- Custom Luxury Social Media Badges -->
                <div class="footer-social-strip">
                    @if(!empty($siteSettings['social_x']))
                        <a href="{{ $siteSettings['social_x'] }}" target="_blank" class="footer-social-btn" title="X / Twitter" aria-label="X">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    @endif
                    @if(!empty($siteSettings['social_linkedin']))
                        <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" class="footer-social-btn" title="LinkedIn" aria-label="LinkedIn">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                    @endif
                    @if(!empty($siteSettings['social_instagram']))
                        <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" class="footer-social-btn" title="Instagram" aria-label="Instagram">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    @endif
                    @if(!empty($siteSettings['social_tiktok']))
                        <a href="{{ $siteSettings['social_tiktok'] }}" target="_blank" class="footer-social-btn" title="TikTok" aria-label="TikTok">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                        </a>
                    @endif
                    @if(!empty($siteSettings['social_snapchat']))
                        <a href="{{ $siteSettings['social_snapchat'] }}" target="_blank" class="footer-social-btn" title="Snapchat" aria-label="Snapchat">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12.01 0c-4.48 0-7.85 3.37-7.85 7.85 0 .76.12 1.5.35 2.19-.8.25-1.61.64-2.13 1.25-.49.57-.6 1.25-.33 1.92.3.74.96 1.18 1.76 1.34.13.43.43.78.85 1.01-.2.43-.51.84-.96 1.19-.85.67-1.99 1.13-2.6 1.96-.34.46-.38.99-.12 1.5.33.64 1.07.96 1.98.96.96 0 1.99-.37 2.87-.79.35.34.78.61 1.28.81-.3.73-.83 1.55-1.71 1.95-.57.26-.95.66-.99 1.18-.04.49.25.96.79 1.27.69.39 1.62.47 2.65.22.86-.21 1.73-.64 2.59-1.08.7.35 1.45.54 2.22.54s1.52-.19 2.22-.54c.86.44 1.73.87 2.59 1.08 1.03.25 1.96.17 2.65-.22.54-.31.83-.78.79-1.27-.04-.52-.42-.92-.99-1.18-.88-.4-1.41-1.22-1.71-1.95.5-.2.93-.47 1.28-.81.88.42 1.91.79 2.87.79.91 0 1.65-.32 1.98-.96.26-.51.22-1.04-.12-1.5-.61-.83-1.75-1.29-2.6-1.96-.45-.35-.76-.76-.96-1.19.42-.23.72-.58.85-1.01.8-.16 1.46-.6 1.76-1.34.27-.67.16-1.35-.33-1.92-.52-.61-1.33-1-2.13-1.25.23-.69.35-1.43.35-2.19 0-4.48-3.37-7.85-7.85-7.85z"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Col 2: Regional Studios -->
            <div class="footer-card">
                <h4 class="footer-card-title">
                    <span style="color: var(--lime);">📍</span>
                    {{ $currentLocale === 'ar' ? 'مكاتبنا واستوديوهاتنا' : ($currentLocale === 'fr' ? 'Bureaux & Studios' : 'Regional Studios') }}
                </h4>
                
                <!-- Riyadh -->
                <div class="footer-office-item">
                    <div class="footer-office-header">
                        <span>🇸🇦 {{ $currentLocale === 'ar' ? 'الرياض' : 'Riyadh' }}</span>
                        <span class="footer-office-badge">{{ $currentLocale === 'ar' ? 'المقر الرئيسي' : 'HQ' }}</span>
                    </div>
                    <p class="footer-office-addr">{{ $siteSettings['office_riyadh_address'] ?? ($currentLocale === 'ar' ? 'طريق الملك فهد، حي الصحافة' : 'King Fahd Road, Al-Sahafah') }}</p>
                </div>

                <!-- Cairo -->
                <div class="footer-office-item">
                    <div class="footer-office-header">
                        <span>🇪🇬 {{ $currentLocale === 'ar' ? 'القاهرة' : 'Cairo' }}</span>
                        <span class="footer-office-badge" style="background: rgba(22,98,196,0.18); border-color: rgba(22,98,196,0.3); color: #93c5fd;">{{ $currentLocale === 'ar' ? 'مركز التطوير' : 'Dev Hub' }}</span>
                    </div>
                    <p class="footer-office-addr">{{ $siteSettings['office_cairo_address'] ?? ($currentLocale === 'ar' ? 'التجمع الخامس، شارع التسعين الشمالي' : 'Fifth Settlement, North 90th St') }}</p>
                </div>

                <!-- Dubai -->
                <div class="footer-office-item">
                    <div class="footer-office-header">
                        <span>🇦🇪 {{ $currentLocale === 'ar' ? 'دبي' : 'Dubai' }}</span>
                        <span class="footer-office-badge" style="background: rgba(156,124,61,0.2); border-color: rgba(156,124,61,0.4); color: #fde047;">{{ $currentLocale === 'ar' ? 'استشارات النمو' : 'Growth' }}</span>
                    </div>
                    <p class="footer-office-addr">{{ $siteSettings['office_dubai_address'] ?? ($currentLocale === 'ar' ? 'أبراج بحيرات جميرا (JLT)، دبي' : 'JLT Towers, Dubai') }}</p>
                </div>
            </div>

            <!-- Col 3: Ecosystem Links -->
            <div class="footer-card">
                <h4 class="footer-card-title">
                    <span style="color: var(--lime);">⚡</span>
                    {{ $currentLocale === 'ar' ? 'روابط المنصة' : ($currentLocale === 'fr' ? 'Navigation' : 'Ecosystem') }}
                </h4>
                <div class="footer-links-list">
                    <a href="{{ route('home') }}#work" class="footer-link-item">
                        <span style="color: var(--lime); font-size: 10px;">✦</span>
                        <span>{{ $currentLocale === 'ar' ? 'مشاريعنا وأعمالنا' : ($currentLocale === 'fr' ? 'Nos Projets' : 'Our Selected Work') }}</span>
                    </a>
                    <a href="{{ route('home') }}#services" class="footer-link-item">
                        <span style="color: var(--lime); font-size: 10px;">✦</span>
                        <span>{{ $currentLocale === 'ar' ? 'الخدمات والحلول' : ($currentLocale === 'fr' ? 'Solutions Cloud' : 'Services & Architecture') }}</span>
                    </a>
                    <a href="{{ route('home') }}#stories" class="footer-link-item">
                        <span style="color: var(--lime); font-size: 10px;">✦</span>
                        <span>{{ $currentLocale === 'ar' ? 'قصص نجاح الشركاء' : ($currentLocale === 'fr' ? 'Témoignages Clients' : 'Client Success Stories') }}</span>
                    </a>
                    <a href="{{ route('home') }}#about" class="footer-link-item">
                        <span style="color: var(--lime); font-size: 10px;">✦</span>
                        <span>{{ $currentLocale === 'ar' ? 'عن OX Tech وتاريخنا' : ($currentLocale === 'fr' ? 'À Propos de Nous' : 'About OX Tech') }}</span>
                    </a>
                    <a href="{{ route('seo.sitemap') }}" target="_blank" class="footer-link-item">
                        <span style="color: var(--lime); font-size: 10px;">✦</span>
                        <span>{{ $currentLocale === 'ar' ? 'خريطة الموقع (Sitemap)' : 'Sitemap.xml' }}</span>
                    </a>
                    <a href="{{ route('admin.login') }}" class="footer-link-item" style="color: var(--lime); font-weight: 700; margin-top: 6px;">
                        <span>🔒</span>
                        <span>{{ $currentLocale === 'ar' ? 'بوابة الإدارة المشفرة' : 'Admin Portal' }}</span>
                    </a>
                </div>
            </div>

            <!-- Col 4: Executive Direct Contact -->
            <div class="footer-card">
                <h4 class="footer-card-title">
                    <span style="color: var(--lime);">📞</span>
                    {{ $currentLocale === 'ar' ? 'تواصل مباشر' : ($currentLocale === 'fr' ? 'Contact Direct' : 'Direct Contact') }}
                </h4>
                
                <a href="mailto:{{ $siteSettings['contact_email_primary'] ?? 'info@ox-tech.sa' }}" class="footer-contact-row">
                    <span class="footer-contact-icon">📧</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-size: 10px; color: #94a8a2;">{{ $currentLocale === 'ar' ? 'البريد الرسمي' : 'Official Email' }}</span>
                        <strong style="color: #60a5fa; font-size: 12px;">{{ $siteSettings['contact_email_primary'] ?? 'info@ox-tech.sa' }}</strong>
                    </div>
                </a>

                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_phone_primary'] ?? '966500000000') }}" target="_blank" rel="noopener noreferrer" class="footer-contact-row">
                    <span class="footer-contact-icon" style="color: #25D366;">💬</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-size: 10px; color: #94a8a2;">{{ $currentLocale === 'ar' ? 'واتساب الإدارة' : 'WhatsApp Desk' }}</span>
                        <strong style="color: var(--lime); font-size: 12px;">{{ $siteSettings['contact_phone_primary'] ?? '+966 50 000 0000' }}</strong>
                    </div>
                </a>

                <div style="margin-top: auto; padding-top: 8px;">
                    <button onclick="openConsultModal()" class="pill-btn-lime" style="width: 100%; justify-content: center; font-size: 12px; padding: 11px 18px;">
                        {{ $currentLocale === 'ar' ? 'احجز استشارتك الآن ⚡' : ($currentLocale === 'fr' ? 'Réserver Consultation ⚡' : 'Book Consultation ⚡') }}
                    </button>
                    <p style="font-size: 10px; color: #8fa099; text-align: center; margin: 8px 0 0;">
                        {{ $currentLocale === 'ar' ? '⚡ استجابة استشارية خلال يوم عمل واحد' : ($currentLocale === 'fr' ? '⚡ Réponse sous 24h ouvrées' : '⚡ Response within 1 business day') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Central Cultural Heritage Emblem ("عزنا بطبعنا") -->
        <div class="footer-emblem-wrap">
            <div class="footer-emblem">
                <span class="footer-emblem-stars">❖ ❖ ❖</span>
                <span class="footer-emblem-text">
                    {{ $currentLocale === 'ar' ? 'OX TECH SOFTWARE HOUSE · عراقة سعودية معاصرة · ابتكار رقمي مستمر' : 'OX TECH SOFTWARE HOUSE · CONTEMPORARY SAUDI HERITAGE · CONTINUOUS DIGITAL INNOVATION' }}
                </span>
                <span class="footer-emblem-stars">❖ ❖ ❖</span>
            </div>
        </div>

        <!-- Bottom Legal & Compliance Strip -->
        <div class="footer-bottom-bar">
            <div>
                @if($currentLocale === 'ar')
                    {{ $siteSettings['footer_copyright'] ?? ('جميع الحقوق محفوظة © ' . date('Y') . ' لشركة OX Tech Software House.') }}
                @elseif($currentLocale === 'fr')
                    Tous droits réservés © {{ date('Y') }} OX Tech Software House.
                @else
                    All rights reserved © {{ date('Y') }} OX Tech Software House.
                @endif
            </div>

            <!-- Regional Payment / Security Indicators -->
            <div style="display: inline-flex; align-items: center; gap: 14px; font-size: 11px; color: #8ca39e;">
                <span>🔒 SSL Encrypted</span>
                <span>⚡ High-Availability Cloud</span>
                <span>🇸🇦 Saudi Cloud Verified</span>
            </div>

            <a href="#home" class="footer-back-to-top" aria-label="Back to Top">
                <span>{{ $currentLocale === 'ar' ? 'العودة للأعلى' : 'Back to top' }}</span>
                <span>↑</span>
            </a>
        </div>
    </footer>

    <!-- ─── Floating Actions: WhatsApp (Bottom Left) & Language Switcher with Flags (Above) ─── -->
    <div class="ox-floating-actions" id="oxFloatingActions">
        <!-- Language Switcher with Flag (Above WhatsApp) -->
        <div class="ox-floating-item ox-lang-widget" id="floatingLangWidget">
            <button type="button" class="ox-lang-trigger" id="floatingLangBtn" onclick="toggleFloatingLang(event)" aria-label="Language Selector" title="{{ $currentLocale === 'ar' ? 'تغيير اللغة' : ($currentLocale === 'fr' ? 'Changer de langue' : 'Switch Language') }}">
                <span class="ox-lang-flag">{{ $currentLocale === 'ar' ? '🇸🇦' : ($currentLocale === 'fr' ? '🇫🇷' : '🇬🇧') }}</span>
                <span class="ox-lang-text">{{ strtoupper($currentLocale) }}</span>
                <svg class="ox-lang-arrow" width="9" height="5" viewBox="0 0 10 6" fill="none"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <div class="ox-lang-popover" id="floatingLangPopover">
                <a href="{{ route('lang.switch', 'ar') }}" class="ox-lang-option {{ $currentLocale === 'ar' ? 'active' : '' }}">
                    <span class="ox-flag-emoji">🇸🇦</span>
                    <span class="ox-lang-name">العربية</span>
                    <span class="ox-lang-code">AR</span>
                    @if($currentLocale === 'ar')<span class="ox-active-dot"></span>@endif
                </a>
                <a href="{{ route('lang.switch', 'en') }}" class="ox-lang-option {{ $currentLocale === 'en' ? 'active' : '' }}">
                    <span class="ox-flag-emoji">🇬🇧</span>
                    <span class="ox-lang-name">English</span>
                    <span class="ox-lang-code">EN</span>
                    @if($currentLocale === 'en')<span class="ox-active-dot"></span>@endif
                </a>
                <a href="{{ route('lang.switch', 'fr') }}" class="ox-lang-option {{ $currentLocale === 'fr' ? 'active' : '' }}">
                    <span class="ox-flag-emoji">🇫🇷</span>
                    <span class="ox-lang-name">Français</span>
                    <span class="ox-lang-code">FR</span>
                    @if($currentLocale === 'fr')<span class="ox-active-dot"></span>@endif
                </a>
            </div>
        </div>

        <!-- WhatsApp Floating Button (Bottom) -->
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_phone_primary'] ?? '966500000000') }}?text={{ urlencode($currentLocale === 'ar' ? 'مرحباً، أود الاستفسار عن خدمات OX Tech لتطوير مشروعي.' : ($currentLocale === 'fr' ? 'Bonjour, je souhaite me renseigner sur les services OX Tech.' : 'Hello, I would like to inquire about OX Tech software development services.')) }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="ox-floating-item ox-whatsapp-btn" 
           id="floatingWhatsappBtn"
           aria-label="WhatsApp" 
           title="{{ $currentLocale === 'ar' ? 'تواصل معنا مباشرة عبر واتساب' : ($currentLocale === 'fr' ? 'Contactez-nous sur WhatsApp' : 'Chat with us on WhatsApp') }}">
            <div class="ox-whatsapp-pulse"></div>
            <div class="ox-whatsapp-icon-wrap">
                <svg viewBox="0 0 32 32" width="28" height="28" fill="#ffffff" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 2C8.28 2 2 8.28 2 16c0 2.72.78 5.28 2.14 7.46L2.05 30.1c-.13.5.34.97.84.84l6.84-2.05C11.84 30.19 13.88 30.8 16 30.8c7.72 0 14-6.28 14-14S23.72 2 16 2zm8.18 19.86c-.34.96-1.7 1.83-2.77 2.06-.73.16-1.68.29-4.88-1.04-4.1-1.7-6.75-5.86-6.95-6.13-.21-.27-1.68-2.24-1.68-4.27s1.06-3.03 1.44-3.45c.38-.42.82-.53 1.1-.53.28 0 .55.01.79.02.26.01.6.09.93.89.34.82 1.16 2.83 1.26 3.04.1.21.17.46.03.74-.14.28-.21.46-.42.71-.21.25-.44.55-.63.74-.21.21-.43.44-.19.86.25.42 1.1 1.81 2.36 2.93 1.62 1.44 2.99 1.89 3.42 2.1.42.21.67.18.92-.1.25-.29 1.08-1.26 1.37-1.69.29-.43.58-.36.98-.21.4.14 2.54 1.2 2.97 1.42.44.21.73.32.84.5.11.18.11 1.04-.23 2z"/>
                </svg>
            </div>
            <span class="ox-whatsapp-tooltip">{{ $currentLocale === 'ar' ? 'تواصل معنا مباشرة عبر واتساب' : ($currentLocale === 'fr' ? 'Discuter sur WhatsApp' : 'Chat on WhatsApp') }}</span>
        </a>
    </div>

    <!-- Consultation Modal with UTM Marketing Attribution Inputs -->
    <div class="consult-modal-backdrop" id="consultModal">
        <div class="consult-modal-box">
            <button class="modal-close" onclick="closeConsultModal()">✕</button>
            <p class="kicker" style="color:var(--lime); margin-bottom: 8px;">LET'S TALK</p>
            <h3 style="font-size: 24px; margin: 0 0 10px; font-weight: 800;">
                {{ $currentLocale === 'ar' ? 'احجز جلسة استشارة مجانية' : ($currentLocale === 'fr' ? 'Réservez Votre Consultation' : 'Book a Discovery Session') }}
            </h3>
            <p style="font-size: 12px; color: #a4b7b1; margin-bottom: 20px; line-height: 1.8;">
                @if($currentLocale === 'ar')
                    استشارة أولية مركزة لمدة 30 دقيقة لنناقش متطلبات مشروعك البرمجي ونقترح خطة التنفيذ الأنسب.
                @elseif($currentLocale === 'fr')
                    Session découverte ciblée de 30 minutes pour définir les objectifs et l'architecture de votre projet.
                @else
                    A focused 30-minute discovery call to evaluate your requirements and suggest optimal architecture.
                @endif
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
                    <label class="form-label">{{ $currentLocale === 'ar' ? 'الاسم الكريم *' : ($currentLocale === 'fr' ? 'Nom Complet *' : 'Full Name *') }}</label>
                    <input type="text" name="name" class="form-input" placeholder="{{ $currentLocale === 'ar' ? 'مثال: عبدالله الراجحي' : 'e.g. John Doe' }}" maxlength="70" required>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">{{ $currentLocale === 'ar' ? 'البريد الإلكتروني *' : ($currentLocale === 'fr' ? 'Email Pro *' : 'Business Email *') }}</label>
                        <input type="email" name="email" class="form-input" placeholder="name@company.com" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ $currentLocale === 'ar' ? 'رقم الجوال / واتساب' : ($currentLocale === 'fr' ? 'Téléphone / WhatsApp' : 'Phone / WhatsApp') }}</label>
                        <input type="text" name="phone" class="form-input" placeholder="+966 50 000 0000" maxlength="30">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">{{ $currentLocale === 'ar' ? 'نوع المشروع' : ($currentLocale === 'fr' ? 'Type de Projet' : 'Project Type') }}</label>
                        <select name="project_type" class="form-select">
                            <option value="منصات ومواقع ويب">{{ $currentLocale === 'ar' ? 'منصات ومواقع ويب' : ($currentLocale === 'fr' ? 'Plateforme Web' : 'Web & Platforms') }}</option>
                            <option value="متاجر إلكترونية">{{ $currentLocale === 'ar' ? 'متجر إلكتروني متكامل' : ($currentLocale === 'fr' ? 'E-commerce' : 'E-Commerce Store') }}</option>
                            <option value="تطبيقات ومنتجات">{{ $currentLocale === 'ar' ? 'تطبيق جوال iOS / Android' : ($currentLocale === 'fr' ? 'App Mobile iOS / Android' : 'Mobile App (iOS/Android)') }}</option>
                            <option value="أنظمة مخصصة وSaaS">{{ $currentLocale === 'ar' ? 'نظام سحابي / SaaS مخصص' : ($currentLocale === 'fr' ? 'SaaS sur mesure' : 'Custom SaaS / Cloud Platform') }}</option>
                            <option value="تكاملات وتطوير">{{ $currentLocale === 'ar' ? 'تكاملات وأتمتة' : ($currentLocale === 'fr' ? 'Intégrations & Automatisation' : 'Integrations & Automation') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ $currentLocale === 'ar' ? 'الميزانية التقديرية' : ($currentLocale === 'fr' ? 'Budget Estimé' : 'Estimated Budget') }}</label>
                        <select name="budget" class="form-select">
                            <option value="أقل من $10,000">{{ $currentLocale === 'ar' ? 'أقل من $10,000' : '< $10,000' }}</option>
                            <option value="$10,000 - $25,000">$10,000 - $25,000</option>
                            <option value="$25,000 - $50,000">$25,000 - $50,000</option>
                            <option value="أكثر من $50,000">{{ $currentLocale === 'ar' ? 'أكثر من $50,000' : '> $50,000' }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ $currentLocale === 'ar' ? 'تفاصيل الفكرة أو التحدي *' : ($currentLocale === 'fr' ? 'Détails du Projet *' : 'Project Details or Challenge *') }}</label>
                    <textarea name="message" class="form-textarea" rows="3" placeholder="{{ $currentLocale === 'ar' ? 'أخبرنا باختصار عن فكرتك وما ترغب في تحقيقه...' : 'Tell us briefly about your goals and technical scope...' }}" minlength="10" maxlength="1000" required></textarea>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #8fa099; margin-top: 4px;">
                        <span>{{ $currentLocale === 'ar' ? 'الحد الأدنى 10 أحرف' : 'Min 10 characters' }}</span>
                        <span id="modalMsgCounter">0 / 1000</span>
                    </div>
                </div>
                <button type="submit" class="form-submit-btn">
                    <span>{{ $currentLocale === 'ar' ? 'إرسال وتأكيد الحجز' : ($currentLocale === 'fr' ? 'Confirmer la Réservation' : 'Confirm & Request Consultation') }}</span>
                    <b>{{ $currentLocale === 'ar' ? '←' : '→' }}</b>
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
        // Floating Language Widget Popover Handler
        function toggleFloatingLang(e) {
            if (e) e.stopPropagation();
            const w = document.getElementById('floatingLangWidget');
            if (w) w.classList.toggle('open');
        }
        document.addEventListener('click', (e) => {
            const w = document.getElementById('floatingLangWidget');
            if (w && !w.contains(e.target)) w.classList.remove('open');
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
