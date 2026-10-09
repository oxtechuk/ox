@php
    use App\Models\SiteSetting;
    use App\Models\TrackingPixel;

    $siteSettings = SiteSetting::all()->pluck('value', 'key');
    $activePixels = TrackingPixel::getActivePixels();
    $currentUrl = url()->current();
    $isHome = request()->routeIs('home');
    $homeUrl = route('home');
    
    $seoTitle = $siteSettings['seo_meta_title'] ?? 'OX Tech | أفضل شركة برمجة وتطوير تطبيقات وسوفت وير في السعودية ومصر والإمارات';
    $seoDesc = $siteSettings['seo_meta_description'] ?? 'أوكس تك (OX Tech) بيت خبرة تقني وتطوير برمجيات متكامل يقدم حلول البرمجة السحابية، تطوير تطبيقات الجوال، المتاجر الإلكترونية، وحلول الذكاء الاصطناعي في الرياض، القاهرة، ودبي.';
    $seoKeywords = $siteSettings['seo_meta_keywords'] ?? 'شركة برمجة في الرياض, افضل سوفت وير هاوس في السعودية, شركة تطوير تطبيقات دبي, برمجة مواقع القاهرة, شركة تقنية معلومات الرياض';

    $resolveAssetUrl = function (?string $path, ?string $fallback = null): ?string {
        if (empty($path)) {
            return $fallback ? (str_starts_with($fallback, 'http') ? $fallback : asset(ltrim($fallback, '/'))) : null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return asset(ltrim($path, '/'));
    };

    $mainLogoUrl = $resolveAssetUrl($siteSettings['site_logo_main'] ?? null);
    $footerLogoUrl = $resolveAssetUrl($siteSettings['site_logo_footer'] ?? null) ?: $mainLogoUrl;
    $favicon = $resolveAssetUrl($siteSettings['site_favicon'] ?? null, 'favicon.ico');
    $ogImage = $resolveAssetUrl($siteSettings['seo_og_image'] ?? null, 'assets/hero-bg.jpg');

    $socialLinks = array_values(array_filter([
        !empty($siteSettings['social_instagram']) ? $siteSettings['social_instagram'] : 'https://www.instagram.com/oxtech.uk',
        !empty($siteSettings['social_github']) ? $siteSettings['social_github'] : 'https://github.com/oxtechuk',
        !empty($siteSettings['social_tiktok']) ? $siteSettings['social_tiktok'] : 'https://www.tiktok.com/@oxtech.uk',
        !empty($siteSettings['social_youtube']) ? $siteSettings['social_youtube'] : 'https://www.youtube.com/@oxtech-uk',
        !empty($siteSettings['social_linkedin']) ? $siteSettings['social_linkedin'] : 'https://www.linkedin.com/company/ox-tech',
    ]));

    $schemaData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => ['Organization', 'ProfessionalService', 'Corporation'],
                '@id' => url('/') . '#organization',
                'name' => !empty($siteSettings['site_name']) ? $siteSettings['site_name'] : 'OX Tech Software House',
                'alternateName' => ['OxTech', 'OxTech UK', 'أوكس تك'],
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $mainLogoUrl ?: asset('assets/logo.png'),
                ],
                'image' => $ogImage ?: ($mainLogoUrl ?: asset('assets/hero-bg.jpg')),
                'description' => $seoDesc,
                'email' => !empty($siteSettings['contact_email_primary']) ? $siteSettings['contact_email_primary'] : 'contact@oxtech.uk',
                'telephone' => !empty($siteSettings['contact_phone_primary']) ? $siteSettings['contact_phone_primary'] : '+20 10 08616682',
                'hasMap' => !empty($siteSettings['google_maps_url']) ? $siteSettings['google_maps_url'] : 'https://share.google/82M8ufbu784MYpH3y',
                'sameAs' => $socialLinks,
                'knowsAbout' => [
                    'Custom Software Engineering',
                    'Enterprise Cloud Architecture',
                    'Mobile Application Development (iOS & Android)',
                    'Artificial Intelligence (AI) & Automation Solutions',
                    'SaaS Product Engineering',
                    'E-Commerce & Payment Gateway Integrations'
                ],
                'contactPoint' => [
                    [
                        '@type' => 'ContactPoint',
                        'telephone' => $siteSettings['contact_phone_primary'] ?? '+20 10 08616682',
                        'email' => $siteSettings['contact_email_primary'] ?? 'contact@oxtech.uk',
                        'contactType' => 'customer service',
                        'areaServed' => ['EG', 'SA', 'AE', 'GB'],
                        'availableLanguage' => ['Arabic', 'English', 'French'],
                    ]
                ],
                'address' => [
                    [
                        '@type' => 'PostalAddress',
                        'streetAddress' => $siteSettings['office_cairo_address'] ?? 'القاهرة الجديدة',
                        'addressLocality' => 'القاهرة',
                        'addressCountry' => 'EG',
                        'telephone' => '+20 10 08616682',
                    ],
                    [
                        '@type' => 'PostalAddress',
                        'streetAddress' => $siteSettings['office_riyadh_address'] ?? 'طريق الملك فهد',
                        'addressLocality' => 'الرياض',
                        'addressCountry' => 'SA',
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
                '@type' => 'WebSite',
                '@id' => url('/') . '#website',
                'url' => url('/'),
                'name' => $siteSettings['site_name'] ?? 'OX Tech',
                'description' => $seoDesc,
                'publisher' => ['@id' => url('/') . '#organization'],
                'inLanguage' => ['ar', 'en', 'fr'],
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

    <!-- AI & LLM Engine Optimization Context -->
    <link rel="alternate" type="text/markdown" href="{{ url('/llms.txt') }}" title="LLM Context for AI Engines">
    @if(!empty($siteSettings['seo_schema_custom']))
        {!! $siteSettings['seo_schema_custom'] !!}
    @endif
    @if($isHome)
        <!-- Hero Background LCP Preload Hint -->
        <link rel="preload" as="image" href="{{ asset('assets/ox-hero-saudi-egypt.webp') }}" type="image/webp" fetchpriority="high">
    @endif

    <!-- Optimized Non-Blocking Analytics & Pixels -->
    <script>
    function loadMarketingPixels() {
        if (window._pixelsInitialized) return;
        window._pixelsInitialized = true;

        // Google Tag Manager / Ads
        var gtagScript = document.createElement('script');
        gtagScript.async = true;
        gtagScript.src = 'https://www.googletagmanager.com/gtag/js?id=AW-17984061932';
        document.head.appendChild(gtagScript);
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        window.gtag = gtag;
        gtag('js', new Date());
        gtag('config', 'AW-17984061932');

        // Meta Pixel
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
    }

    if (document.readyState === 'complete') {
        loadMarketingPixels();
    } else {
        window.addEventListener('load', function() {
            if ('requestIdleCallback' in window) {
                requestIdleCallback(loadMarketingPixels, { timeout: 2000 });
            } else {
                setTimeout(loadMarketingPixels, 1200);
            }
        });
    }
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1907678277306091&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->

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

    <!-- ─── Font Preconnects & DNS Prefetch ─── -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- ─── Google Fonts (Optimized Non-Blocking + display=swap) ─── -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Poppins:wght@400;600;700;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Poppins:wght@400;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Poppins:wght@400;600;700;800&display=swap">
    </noscript>

    <!-- ─── Main Styles ─── -->
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}?v={{ @filemtime(public_path('assets/style.css')) ?: time() }}" fetchpriority="high"/>
    <link rel="stylesheet" href="{{ asset('assets/ox-theme.css') }}?v={{ @filemtime(public_path('assets/ox-theme.css')) ?: time() }}" fetchpriority="high"/>

    <style>
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 88px;
        }

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

        /* Global: No highlight backgrounds, glowing text, or gradient clipping */
        .highlight, mark {
            background: transparent !important;
            color: inherit !important;
            -webkit-text-fill-color: initial !important;
            text-shadow: none !important;
        }

        .site-nav-logo-img {
            height: 38px;
            max-height: 38px;
            width: auto;
            max-width: 170px;
            object-fit: contain;
            display: block;
            transition: all 0.3s ease;
        }
        header.site-header.scrolled .site-nav-logo-img {
            height: 32px;
            max-height: 32px;
        }
        .site-footer-logo-img {
            height: 42px;
            max-height: 42px;
            width: auto;
            max-width: 180px;
            object-fit: contain;
            display: block;
            transition: opacity 0.2s ease;
        }
        .site-footer-logo-img:hover,
        .site-nav-logo-img:hover {
            opacity: 0.9;
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
            background: rgba(29, 138, 104, 0.15);
            color: var(--ox-emerald);
            border-color: var(--ox-emerald);
        }
        .ox-page-item.active .ox-page-link {
            background: var(--ox-emerald);
            color: #ffffff;
            border-color: var(--ox-emerald);
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            line-height: 1;
        }
        .ox-flag-emoji .ox-flag-img,
        .ox-lang-flag .ox-flag-img {
            width: 20px;
            height: 14px;
            object-fit: cover;
            border-radius: 3px;
            display: inline-block;
            vertical-align: middle;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.45);
        }
        .lang-menu-dropdown .ox-flag-emoji .ox-flag-img {
            width: 18px;
            height: 12px;
            border-radius: 2px;
            margin-inline-end: 6px;
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
                <button type="button" class="ox-menu-toggle" onclick="toggleMobileNav()" aria-label="Toggle Navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <a href="#consult" onclick="openConsultModal(); return false;" class="btn-primary nav-cta-btn">
                    <span>{{ $currentLocale === 'ar' ? 'ابدأ مشروعك' : ($currentLocale === 'fr' ? 'Démarrer Projet' : 'Start Project') }}</span>
                    <span class="btn-arrow-icon">{{ $currentLocale === 'ar' ? '←' : '→' }}</span>
                </a>
            </div>

            <!-- Center Navigation Links -->
            <nav class="navbar-links" id="mainNavbarLinks">
                @if($currentLocale === 'ar')
                    <a href="{{ $isHome ? '#home' : $homeUrl }}" class="nav-item-link {{ $isHome ? 'active' : '' }}" data-target="home">الرئيسية</a>
                    <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" class="nav-item-link" data-target="services">خدماتنا</a>
                    <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" class="nav-item-link" data-target="work">أعمالنا</a>
                    <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" class="nav-item-link" data-target="about">من نحن</a>
                    <a href="{{ $isHome ? '#consult' : $homeUrl . '#consult' }}" class="nav-item-link" data-target="consult">تواصل معنا</a>
                @elseif($currentLocale === 'fr')
                    <a href="{{ $isHome ? '#home' : $homeUrl }}" class="nav-item-link {{ $isHome ? 'active' : '' }}" data-target="home">Accueil</a>
                    <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" class="nav-item-link" data-target="services">Services</a>
                    <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" class="nav-item-link" data-target="work">Réalisations</a>
                    <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" class="nav-item-link" data-target="about">À Propos</a>
                    <a href="{{ $isHome ? '#consult' : $homeUrl . '#consult' }}" class="nav-item-link" data-target="consult">Contact</a>
                @else
                    <a href="{{ $isHome ? '#home' : $homeUrl }}" class="nav-item-link {{ $isHome ? 'active' : '' }}" data-target="home">Home</a>
                    <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" class="nav-item-link" data-target="services">Services</a>
                    <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" class="nav-item-link" data-target="work">Work</a>
                    <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" class="nav-item-link" data-target="about">About</a>
                    <a href="{{ $isHome ? '#consult' : $homeUrl . '#consult' }}" class="nav-item-link" data-target="consult">Contact</a>
                @endif
            </nav>

            <!-- Left Brand Logo & Lang Switcher in RTL -->
            <div class="navbar-brand-wrap">
                <a class="ox-brand-logo" href="{{ $isHome ? '#home' : $homeUrl }}" aria-label="{{ $siteSettings['site_name'] ?? 'OX Tech' }}" data-target="home">
                    @if(!empty($mainLogoUrl))
                        <img src="{{ $mainLogoUrl }}" alt="{{ $siteSettings['site_name'] ?? 'OX Tech' }}" class="site-nav-logo-img" width="170" height="38" fetchpriority="high">
                    @else
                        <span class="ox-logo-title">Ox<span class="dot-accent">Tech</span></span>
                        <span class="ox-logo-subtitle">TECHNOLOGY FOR A BETTER TOMORROW</span>
                    @endif
                </a>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div class="mobile-nav-drawer" id="mobileNavDrawer">
        <div class="mobile-drawer-top">
            <a class="logo" href="{{ $isHome ? '#home' : $homeUrl }}" aria-label="{{ $siteSettings['site_name'] ?? 'OX Tech' }}">
                @if(!empty($mainLogoUrl))
                    <img src="{{ $mainLogoUrl }}" alt="{{ $siteSettings['site_name'] ?? 'OX Tech' }}" class="site-nav-logo-img" width="140" height="32" style="max-height: 32px;">
                @else
                    OX<span>.</span><small>TECH STUDIO</small>
                @endif
            </a>
            <button class="mobile-drawer-close" onclick="closeMobileNav()">✕</button>
        </div>
        <div class="mobile-drawer-links">
            @if($currentLocale === 'ar')
                <a href="{{ $isHome ? '#home' : $homeUrl }}" onclick="closeMobileNav()">✦ الرئيسية</a>
                <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" onclick="closeMobileNav()">✦ أعمالنا ومشاريعنا</a>
                <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" onclick="closeMobileNav()">✦ الخدمات والحلول</a>
                <a href="{{ $isHome ? '#stories' : $homeUrl . '#stories' }}" onclick="closeMobileNav()">✦ قصص وآراء الشركاء</a>
                <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" onclick="closeMobileNav()">✦ عن OX Tech</a>
                <a href="{{ $isHome ? '#consult' : $homeUrl . '#consult' }}" onclick="closeMobileNav()">✦ احجز استشارتك</a>
            @elseif($currentLocale === 'fr')
                <a href="{{ $isHome ? '#home' : $homeUrl }}" onclick="closeMobileNav()">✦ Accueil</a>
                <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" onclick="closeMobileNav()">✦ Nos Projets</a>
                <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" onclick="closeMobileNav()">✦ Services & Solutions</a>
                <a href="{{ $isHome ? '#stories' : $homeUrl . '#stories' }}" onclick="closeMobileNav()">✦ Témoignages Partenaires</a>
                <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" onclick="closeMobileNav()">✦ À Propos de Nous</a>
                <a href="{{ $isHome ? '#consult' : $homeUrl . '#consult' }}" onclick="closeMobileNav()">✦ Réserver Consultation</a>
            @else
                <a href="{{ $isHome ? '#home' : $homeUrl }}" onclick="closeMobileNav()">✦ Home</a>
                <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" onclick="closeMobileNav()">✦ Work & Projects</a>
                <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" onclick="closeMobileNav()">✦ Services & Solutions</a>
                <a href="{{ $isHome ? '#stories' : $homeUrl . '#stories' }}" onclick="closeMobileNav()">✦ Partner Stories</a>
                <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" onclick="closeMobileNav()">✦ About OX Tech</a>
                <a href="{{ $isHome ? '#consult' : $homeUrl . '#consult' }}" onclick="closeMobileNav()">✦ Book Consultation</a>
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

    <!-- ===============================================================
         COMPONENT 1: Four Pillars Strip (Saudi x Egypt Synergy)
         =============================================================== -->
    <section class="ox-pillars-component" id="oxPillarsComponent">
        <!-- Arabesque Watermark Patterns on Far Edges -->
        <div class="ox-footer-arabesque ox-footer-arabesque-right" aria-hidden="true"></div>
        <div class="ox-footer-arabesque ox-footer-arabesque-left" aria-hidden="true"></div>

      
    </section>

    <!-- ===============================================================
         COMPONENT 2: Main Navigation Bar (Under Component 1)
         =============================================================== -->
    <footer class="ox-modern-footer" id="oxModernFooter">
        <!-- Arabesque Watermark Patterns on Far Edges -->
        <div class="ox-footer-arabesque ox-footer-arabesque-right" aria-hidden="true"></div>
        <div class="ox-footer-arabesque ox-footer-arabesque-left" aria-hidden="true"></div>

        <div class="ox-footer-main">
            <div class="container ox-footer-main-inner">
                <!-- Brand / Logo (Left) -->
                <a href="{{ $isHome ? '#home' : $homeUrl }}" class="ox-footer-logo-brand" aria-label="{{ $siteSettings['site_name'] ?? 'OX Tech' }}">
                    @if(!empty($footerLogoUrl))
                        <img src="{{ $footerLogoUrl }}" alt="{{ $siteSettings['site_name'] ?? 'OX Tech' }}" class="site-footer-logo-img" width="180" height="42" loading="lazy">
                    @else
                        <span class="ox-footer-logo-text">O<span class="ox-logo-accent">x</span>Tech</span>
                        <span class="ox-footer-tagline">
                            <span>TECHNOLOGY</span>
                            <span>FOR A BETTER TOMORROW</span>
                        </span>
                    @endif
                </a>

                <!-- Navigation Links (Center) -->
                <nav class="ox-footer-nav" aria-label="Footer Navigation">
                    <a href="{{ $isHome ? '#consult' : $homeUrl . '#consult' }}" class="ox-footer-nav-link" data-target="consult">
                        {{ $currentLocale === 'ar' ? 'تواصل معنا' : ($currentLocale === 'fr' ? 'Contact' : 'Contact Us') }}
                    </a>
                    <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" class="ox-footer-nav-link" data-target="about">
                        {{ $currentLocale === 'ar' ? 'من نحن' : ($currentLocale === 'fr' ? 'À Propos' : 'About Us') }}
                    </a>
                    <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" class="ox-footer-nav-link" data-target="work">
                        {{ $currentLocale === 'ar' ? 'أعمالنا' : ($currentLocale === 'fr' ? 'Réalisations' : 'Portfolio') }}
                    </a>
                    <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" class="ox-footer-nav-link" data-target="services">
                        {{ $currentLocale === 'ar' ? 'خدماتنا' : ($currentLocale === 'fr' ? 'Services' : 'Services') }}
                    </a>
                    <a href="{{ $isHome ? '#home' : $homeUrl }}" class="ox-footer-nav-link {{ $isHome ? 'active' : '' }}" data-target="home">
                        {{ $currentLocale === 'ar' ? 'الرئيسية' : ($currentLocale === 'fr' ? 'Accueil' : 'Home') }}
                    </a>
                </nav>

                <!-- Socials & Domain Group (Right) -->
                <div class="ox-footer-end-group">
                    <div class="ox-footer-socials">
                        <!-- LinkedIn -->
                        <a href="{{ !empty($siteSettings['social_linkedin']) ? $siteSettings['social_linkedin'] : 'https://www.linkedin.com/company/ox-tech' }}" target="_blank" rel="noopener noreferrer" class="ox-footer-social-link" title="LinkedIn" aria-label="LinkedIn">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <!-- Instagram -->
                        <a href="{{ !empty($siteSettings['social_instagram']) ? $siteSettings['social_instagram'] : 'https://www.instagram.com/oxtech.uk' }}" target="_blank" rel="noopener noreferrer" class="ox-footer-social-link" title="Instagram" aria-label="Instagram">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <!-- TikTok -->
                        <a href="{{ !empty($siteSettings['social_tiktok']) ? $siteSettings['social_tiktok'] : 'https://www.tiktok.com/@oxtech.uk' }}" target="_blank" rel="noopener noreferrer" class="ox-footer-social-link" title="TikTok" aria-label="TikTok">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.96-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 2.89 3.5 2.75 1.25-.03 2.4-1.04 2.56-2.28.09-.76.07-1.54.07-2.31V.02h-.03z"/></svg>
                        </a>
                        <!-- YouTube -->
                        <a href="{{ !empty($siteSettings['social_youtube']) ? $siteSettings['social_youtube'] : 'https://www.youtube.com/@oxtech-uk' }}" target="_blank" rel="noopener noreferrer" class="ox-footer-social-link" title="YouTube" aria-label="YouTube">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <!-- GitHub -->
                        <a href="{{ !empty($siteSettings['social_github']) ? $siteSettings['social_github'] : 'https://github.com/oxtechuk' }}" target="_blank" rel="noopener noreferrer" class="ox-footer-social-link" title="GitHub" aria-label="GitHub">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                        </a>
                    </div>

                    <!-- Vertical Separator between Socials and Domain -->
                    <div class="ox-footer-end-divider" aria-hidden="true"></div>

                    <!-- Domain Link -->
                    <a href="https://oxtech.uk" target="_blank" rel="noopener noreferrer" class="ox-footer-domain">
                        oxtech.uk
                    </a>
                </div>
            </div>
        </div>

        <!-- Horizontal Hairline Divider -->
        <div class="ox-footer-divider" aria-hidden="true"></div>

        <!-- ===============================================================
             COMPONENT 3: Bottom Copyright Row (Under Component 2)
             =============================================================== -->
        <div class="container ox-footer-bottom">
            <p class="ox-footer-copy">
                @if($currentLocale === 'ar')
                    <span>جميع الحقوق محفوظة</span>
                    <span dir="ltr">OxTech &copy; 2025</span>
                @elseif($currentLocale === 'fr')
                    <span dir="ltr">&copy; 2025 OxTech. Tous droits réservés.</span>
                @else
                    <span dir="ltr">&copy; 2025 OxTech. All rights reserved.</span>
                @endif
            </p>
        </div>
    </footer>

    <!-- ─── Floating Actions: WhatsApp (Bottom Left) & Language Switcher with Flags (Above) ─── -->
    <div class="ox-floating-actions" id="oxFloatingActions">
        <!-- Language Switcher with Flag (Above WhatsApp) -->
        <div class="ox-floating-item ox-lang-widget" id="floatingLangWidget">
            <button type="button" class="ox-lang-trigger" id="floatingLangBtn" onclick="toggleFloatingLang(event)" aria-label="Language Selector" title="{{ $currentLocale === 'ar' ? 'تغيير اللغة' : ($currentLocale === 'fr' ? 'Changer de langue' : 'Switch Language') }}">
                <span class="ox-lang-flag">
                    @if($currentLocale === 'ar')
                        <img src="{{ asset('assets/flags/sa.webp') }}" class="ox-flag-img" alt="" aria-hidden="true">
                    @elseif($currentLocale === 'fr')
                        <img src="{{ asset('assets/flags/fr.webp') }}" class="ox-flag-img" alt="" aria-hidden="true">
                    @else
                        <img src="{{ asset('assets/flags/gb.webp') }}" class="ox-flag-img" alt="" aria-hidden="true">
                    @endif
                </span>
                <span class="ox-lang-text">{{ strtoupper($currentLocale) }}</span>
                <svg class="ox-lang-arrow" width="9" height="5" viewBox="0 0 10 6" fill="none"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <div class="ox-lang-popover" id="floatingLangPopover">
                <a href="{{ route('lang.switch', 'ar') }}" class="ox-lang-option {{ $currentLocale === 'ar' ? 'active' : '' }}">
                    <span class="ox-flag-emoji"><img src="{{ asset('assets/flags/sa.webp') }}" class="ox-flag-img" alt="" aria-hidden="true"></span>
                    <span class="ox-lang-name">العربية</span>
                    <span class="ox-lang-code">AR</span>
                    @if($currentLocale === 'ar')<span class="ox-active-dot"></span>@endif
                </a>
                <a href="{{ route('lang.switch', 'en') }}" class="ox-lang-option {{ $currentLocale === 'en' ? 'active' : '' }}">
                    <span class="ox-flag-emoji"><img src="{{ asset('assets/flags/gb.webp') }}" class="ox-flag-img" alt="" aria-hidden="true"></span>
                    <span class="ox-lang-name">English</span>
                    <span class="ox-lang-code">EN</span>
                    @if($currentLocale === 'en')<span class="ox-active-dot"></span>@endif
                </a>
                <a href="{{ route('lang.switch', 'fr') }}" class="ox-lang-option {{ $currentLocale === 'fr' ? 'active' : '' }}">
                    <span class="ox-flag-emoji"><img src="{{ asset('assets/flags/fr.webp') }}" class="ox-flag-img" alt="" aria-hidden="true"></span>
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
                    <label class="form-label" for="consult_name">{{ $currentLocale === 'ar' ? 'الاسم الكريم *' : ($currentLocale === 'fr' ? 'Nom Complet *' : 'Full Name *') }}</label>
                    <input type="text" name="name" id="consult_name" class="form-input" placeholder="{{ $currentLocale === 'ar' ? 'مثال: عبدالله الراجحي' : 'e.g. John Doe' }}" maxlength="70" required>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label" for="consult_email">{{ $currentLocale === 'ar' ? 'البريد الإلكتروني *' : ($currentLocale === 'fr' ? 'Email Pro *' : 'Business Email *') }}</label>
                        <input type="email" name="email" id="consult_email" class="form-input" placeholder="name@company.com" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="consult_phone_raw">{{ $currentLocale === 'ar' ? 'رقم الجوال / واتساب' : ($currentLocale === 'fr' ? 'Téléphone / WhatsApp' : 'Phone / WhatsApp') }}</label>
                        <div class="consult-phone-combo" style="display: flex; gap: 6px; align-items: stretch; direction: ltr;">
                            <select id="consult_country_code" class="form-select consult-code-select" style="width: 105px; flex-shrink: 0; padding: 12px 6px; font-size: 11.5px; font-family: var(--font-code), system-ui; direction: ltr; cursor: pointer; background: #0c202d; color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 10px;" aria-label="{{ $currentLocale === 'ar' ? 'كود الدولة' : 'Country Code' }}">
                                <option value="+966" selected>🇸🇦 +966</option>
                                <option value="+971">🇦🇪 +971</option>
                                <option value="+20">🇪🇬 +20</option>
                                <option value="+965">🇰🇼 +965</option>
                                <option value="+974">🇶🇦 +974</option>
                                <option value="+968">🇴🇲 +968</option>
                                <option value="+973">🇧🇭 +973</option>
                                <option value="+962">🇯🇴 +962</option>
                                <option value="+964">🇮🇶 +964</option>
                                <option value="+967">🇾🇪 +967</option>
                                <option value="+212">🇲🇦 +212</option>
                                <option value="+213">🇩🇿 +213</option>
                                <option value="+216">🇹🇳 +216</option>
                                <option value="+961">🇱🇧 +961</option>
                                <option value="+218">🇱🇾 +218</option>
                                <option value="+970">🇵🇸 +970</option>
                                <option value="+249">🇸🇩 +249</option>
                                <option value="+44">🇬🇧 +44</option>
                                <option value="+1">🇺🇸 +1</option>
                                <option value="+49">🇩🇪 +49</option>
                                <option value="+33">🇫🇷 +33</option>
                                <option value="+90">🇹🇷 +90</option>
                            </select>
                            <input type="tel" id="consult_phone_raw" class="form-input" style="flex: 1; min-width: 0; direction: ltr; font-family: var(--font-code), system-ui;" placeholder="50 123 4567" maxlength="20" autocomplete="tel">
                            <input type="hidden" name="phone" id="consult_phone" value="">
                        </div>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label" for="consult_project_type">{{ $currentLocale === 'ar' ? 'نوع المشروع' : ($currentLocale === 'fr' ? 'Type de Projet' : 'Project Type') }}</label>
                        <select name="project_type" id="consult_project_type" class="form-select">
                            <option value="منصات ومواقع ويب">{{ $currentLocale === 'ar' ? 'منصات ومواقع ويب' : ($currentLocale === 'fr' ? 'Plateforme Web' : 'Web & Platforms') }}</option>
                            <option value="متاجر إلكترونية">{{ $currentLocale === 'ar' ? 'متجر إلكتروني متكامل' : ($currentLocale === 'fr' ? 'E-commerce' : 'E-Commerce Store') }}</option>
                            <option value="تطبيقات ومنتجات">{{ $currentLocale === 'ar' ? 'تطبيق جوال iOS / Android' : ($currentLocale === 'fr' ? 'App Mobile iOS / Android' : 'Mobile App (iOS/Android)') }}</option>
                            <option value="أنظمة مخصصة وSaaS">{{ $currentLocale === 'ar' ? 'نظام سحابي / SaaS مخصص' : ($currentLocale === 'fr' ? 'SaaS sur mesure' : 'Custom SaaS / Cloud Platform') }}</option>
                            <option value="تكاملات وتطوير">{{ $currentLocale === 'ar' ? 'تكاملات وأتمتة' : ($currentLocale === 'fr' ? 'Intégrations & Automatisation' : 'Integrations & Automation') }}</option>
                        </select>
                    </div>
                 
                </div>
                <div class="form-group">
                    <label class="form-label" for="consult_message">{{ $currentLocale === 'ar' ? 'تفاصيل الفكرة أو التحدي *' : ($currentLocale === 'fr' ? 'Détails du Projet *' : 'Project Details or Challenge *') }}</label>
                    <textarea name="message" id="consult_message" class="form-textarea" rows="3" placeholder="{{ $currentLocale === 'ar' ? 'أخبرنا باختصار عن فكرتك وما ترغب في تحقيقه...' : 'Tell us briefly about your goals and technical scope...' }}" minlength="10" maxlength="1000" required></textarea>
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

        // Sync Modal Phone with Country Dial Code (Default Saudi Arabia +966)
        const modalCountryCode = document.getElementById('consult_country_code');
        const modalPhoneRaw = document.getElementById('consult_phone_raw');
        const modalFullPhone = document.getElementById('consult_phone');
        const modalConsultForm = document.getElementById('consultationForm');

        function syncModalPhone() {
            if (!modalPhoneRaw || !modalCountryCode || !modalFullPhone) return;
            let val = modalPhoneRaw.value.trim();
            if (!val) {
                modalFullPhone.value = '';
                return;
            }
            if (val.startsWith('0')) {
                val = val.replace(/^0+/, '');
            }
            if (val.startsWith('+')) {
                for (let i = 0; i < modalCountryCode.options.length; i++) {
                    const optVal = modalCountryCode.options[i].value;
                    if (val.startsWith(optVal)) {
                        modalCountryCode.value = optVal;
                        val = val.substring(optVal.length).trim();
                        modalPhoneRaw.value = val;
                        break;
                    }
                }
            }
            modalFullPhone.value = val ? `${modalCountryCode.value} ${val}` : '';
        }

        if (modalPhoneRaw && modalCountryCode) {
            modalPhoneRaw.addEventListener('input', syncModalPhone);
            modalCountryCode.addEventListener('change', syncModalPhone);
        }
        if (modalConsultForm) {
            modalConsultForm.addEventListener('submit', function() {
                syncModalPhone();
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

        // Smooth scroll to target section with header offset
        function smoothScrollToTarget(targetElement) {
            if (!targetElement) return;
            const header = document.getElementById('mainHeader');
            const headerHeight = header ? (header.offsetHeight || 80) : 80;
            const elementPosition = targetElement.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerHeight - 12;
            
            window.scrollTo({
                top: Math.max(0, offsetPosition),
                behavior: 'smooth'
            });
        }

        // Global Link Interceptor for Smooth In-Page Scrolling (Prevents Full Page Reload)
        document.addEventListener('click', function(e) {
            const anchor = e.target.closest('a');
            if (!anchor) return;

            const href = anchor.getAttribute('href');
            if (!href) return;

            // Ignore non-navigation links
            if (href.startsWith('javascript:') || href.startsWith('tel:') || href.startsWith('mailto:')) {
                return;
            }

            const isHomePage = window.location.pathname === '/' || 
                               window.location.pathname.endsWith('/home') || 
                               document.getElementById('hero') !== null ||
                               document.getElementById('home') !== null;

            let targetId = null;

            if (href.startsWith('#')) {
                targetId = href.substring(1);
            } else if (href.includes('#')) {
                try {
                    const parsedUrl = new URL(anchor.href, window.location.origin);
                    if (parsedUrl.pathname === window.location.pathname) {
                        targetId = parsedUrl.hash.replace('#', '');
                    }
                } catch (err) {
                    const parts = href.split('#');
                    if (parts.length > 1) {
                        targetId = parts[1];
                    }
                }
            } else if (isHomePage) {
                // If it's a link to home (no hash) while already on home page
                try {
                    const parsedUrl = new URL(anchor.href, window.location.origin);
                    if (parsedUrl.pathname === window.location.pathname && (anchor.classList.contains('active') || anchor.classList.contains('ox-brand-logo') || anchor.dataset.target === 'home')) {
                        e.preventDefault();
                        if (typeof closeMobileNav === 'function') closeMobileNav();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        if (history.pushState) {
                            history.pushState(null, null, window.location.pathname);
                        }
                        updateActiveNavLink('home');
                        return;
                    }
                } catch (err) {}
            }

            if (targetId) {
                // If target is "home" or "hero", scroll smoothly to the top
                if (targetId === 'home' || targetId === 'hero') {
                    e.preventDefault();
                    if (typeof closeMobileNav === 'function') closeMobileNav();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    if (history.pushState) {
                        history.pushState(null, null, window.location.pathname);
                    }
                    updateActiveNavLink('home');
                    return;
                }

                // Check if target element exists on this page
                const targetEl = document.getElementById(targetId);
                if (targetEl) {
                    e.preventDefault();
                    if (typeof closeMobileNav === 'function') closeMobileNav();
                    smoothScrollToTarget(targetEl);
                    if (history.pushState) {
                        history.pushState(null, null, '#' + targetId);
                    }
                    updateActiveNavLink(targetId);
                }
            }
        });

        // Function to update active class on header links
        function updateActiveNavLink(sectionId) {
            const navLinks = document.querySelectorAll('#mainNavbarLinks a');
            navLinks.forEach(link => {
                const target = link.getAttribute('data-target') || (link.getAttribute('href') || '').replace('#', '');
                if (target === sectionId || (sectionId === 'services' && target === 'services') || (sectionId === 'work' && target === 'work')) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        }

        // Active Link Scrollspy using IntersectionObserver
        document.addEventListener('DOMContentLoaded', function() {
            const sections = ['hero', 'services', 'work', 'about', 'consult'];
            const sectionElements = sections.map(id => document.getElementById(id)).filter(Boolean);

            if (sectionElements.length > 0 && 'IntersectionObserver' in window) {
                const observerOptions = {
                    root: null,
                    rootMargin: '-20% 0px -60% 0px',
                    threshold: 0
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const id = entry.target.id === 'hero' ? 'home' : entry.target.id;
                            updateActiveNavLink(id);
                        }
                    });
                }, observerOptions);

                sectionElements.forEach(el => observer.observe(el));
            }

            // Handle page load with hash (e.g. navigated from an external page via /#services)
            if (window.location.hash) {
                const hashId = window.location.hash.substring(1);
                const el = document.getElementById(hashId);
                if (el) {
                    setTimeout(() => {
                        smoothScrollToTarget(el);
                        updateActiveNavLink(hashId);
                    }, 250);
                }
            }

            // Realtime Marketing & Traffic Analytics: Track WhatsApp clicks
            document.addEventListener('click', function(e) {
                const waLink = e.target.closest('a[href*="wa.me"], a[href*="whatsapp.com"]');
                if (waLink) {
                    try {
                        const payload = JSON.stringify({
                            _token: '{{ csrf_token() }}',
                            event_name: 'whatsapp_click',
                            page_url: window.location.pathname + window.location.search
                        });
                        if (navigator.sendBeacon) {
                            navigator.sendBeacon('{{ route('traffic.event') }}', new Blob([payload], { type: 'application/json' }));
                        } else {
                            fetch('{{ route('traffic.event') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: payload,
                                keepalive: true
                            });
                        }
                    } catch(err) {}
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
