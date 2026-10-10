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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

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
        
        /* ===== CONSULTATION & BOOKING MODAL (OX TECH CLEAN WHITE SUITE) ===== */
        .consult-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.72);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }
        .consult-modal-backdrop.active {
            opacity: 1;
            visibility: visible;
        }
        .consult-modal-box {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 22px;
            max-width: 960px;
            width: 100%;
            max-height: calc(100vh - 32px);
            overflow-y: auto;
            overscroll-behavior: contain;
            padding: 26px 24px 22px;
            position: relative;
            box-shadow: 0 25px 70px -10px rgba(15, 23, 42, 0.25), 0 0 1px 1px rgba(15, 23, 42, 0.05);
            transform: scale(0.96) translateY(10px);
            transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease;
            scrollbar-width: thin;
            scrollbar-color: #CBD5E1 transparent;
            color: #334155;
            font-family: inherit;
        }
        .consult-modal-box::-webkit-scrollbar {
            width: 6px;
        }
        .consult-modal-box::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 6px;
        }
        .consult-modal-backdrop.active .consult-modal-box {
            transform: scale(1) translateY(0);
        }
        .modal-close {
            position: absolute;
            top: 16px;
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            color: #64748B;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            z-index: 30;
        }
        html[dir="rtl"] .modal-close { left: 18px; right: auto; }
        html[dir="ltr"] .modal-close { right: 18px; left: auto; }
        .modal-close:hover {
            background: #E2E8F0;
            color: #0F172A;
            transform: rotate(90deg) scale(1.05);
        }

        /* Modal Grid Layout */
        .ox-contact-grid {
            display: grid;
            grid-template-columns: 1.55fr 1fr;
            gap: 20px;
            align-items: start;
        }

        /* Main Form Card */
        .ox-contact-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 18px;
            padding: 24px 22px 20px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
        }
        .ox-card-header {
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid #F1F5F9;
        }
        .ox-card-header h3 {
            font-size: 19px;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 5px;
            letter-spacing: -0.2px;
        }
        .ox-card-header p {
            font-size: 13px;
            color: #64748B;
            margin: 0;
            line-height: 1.5;
        }

        /* Form Inputs & Fields */
        .ox-form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 14px;
        }
        .ox-form-group {
            margin-bottom: 14px;
        }
        .ox-form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 6px;
        }
        .ox-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .ox-input-icon {
            position: absolute;
            color: #94A3B8;
            font-size: 13px;
            pointer-events: none;
        }
        html[dir="rtl"] .ox-input-icon { right: 13px; }
        html[dir="ltr"] .ox-input-icon { left: 13px; }

        .ox-input-field,
        .ox-select-field,
        .ox-textarea-field {
            width: 100%;
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-radius: 10px;
            color: #0F172A;
            font-family: inherit;
            font-size: 13px;
            padding: 10px 13px;
            transition: all 0.2s ease;
            box-sizing: border-box;
            outline: none;
        }
        html[dir="rtl"] .ox-input-wrapper .ox-input-field { padding-right: 36px; }
        html[dir="ltr"] .ox-input-wrapper .ox-input-field { padding-left: 36px; }

        .ox-input-field:focus,
        .ox-select-field:focus,
        .ox-textarea-field:focus {
            border-color: #006848;
            box-shadow: 0 0 0 3px rgba(0, 104, 72, 0.12);
        }
        .ox-select-field {
            cursor: pointer;
            background-color: #FFFFFF;
        }

        /* Phone Row & Country Flag Dropdown */
        .ox-phone-row {
            display: flex;
            gap: 8px;
            align-items: stretch;
            position: relative;
        }
        .ox-country-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-radius: 10px;
            padding: 9px 11px;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
            user-select: none;
            font-family: inherit;
        }
        .ox-country-btn:hover,
        .ox-country-btn.open {
            border-color: #006848;
            background: #F8FAFC;
            box-shadow: 0 0 0 3px rgba(0, 104, 72, 0.1);
        }
        .ox-country-flag-img {
            width: 22px;
            height: 15px;
            object-fit: cover;
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            display: block;
        }
        .ox-country-dial-code {
            font-size: 13px;
            font-weight: 700;
            color: #0F172A;
            direction: ltr;
        }
        .ox-country-chevron {
            color: #94A3B8;
            transition: transform 0.2s ease;
        }
        .ox-country-btn.open .ox-country-chevron {
            transform: rotate(180deg);
        }
        .ox-country-popover {
            position: absolute;
            top: calc(100% + 6px);
            width: 280px;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.16);
            z-index: 100;
            display: none;
            flex-direction: column;
            overflow: hidden;
            animation: fadeIn 0.18s ease;
        }
        html[dir="rtl"] .ox-country-popover { right: 0; }
        html[dir="ltr"] .ox-country-popover { left: 0; }
        .ox-country-popover.open {
            display: flex;
        }
        .ox-country-search-wrap {
            padding: 8px 10px;
            border-bottom: 1px solid #F1F5F9;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #F8FAFC;
        }
        .ox-country-search-wrap svg {
            color: #94A3B8;
            flex-shrink: 0;
        }
        .ox-country-search-input {
            width: 100%;
            border: none;
            background: transparent;
            font-size: 12px;
            color: #0F172A;
            outline: none;
            font-family: inherit;
        }
        .ox-country-list {
            max-height: 200px;
            overflow-y: auto;
            padding: 4px;
        }
        .ox-country-item {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px 10px;
            border: none;
            background: transparent;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s ease;
        }
        .ox-country-item:hover {
            background: #F1F5F9;
        }
        .ox-country-item.selected {
            background: #ECFDF5;
        }
        .ox-country-item-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ox-country-item-flag {
            width: 20px;
            height: 14px;
            object-fit: cover;
            border-radius: 2px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        .ox-country-item-name {
            font-size: 12px;
            font-weight: 600;
            color: #1E293B;
        }
        .ox-country-item-dial {
            font-size: 11.5px;
            font-weight: 700;
            color: #64748B;
            direction: ltr;
        }
        .ox-country-no-results {
            padding: 14px;
            text-align: center;
            font-size: 12px;
            color: #94A3B8;
        }

        /* 3 Compact Square Channel Tiles */
        .ox-channel-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        .ox-channel-option {
            cursor: pointer;
            display: block;
            margin: 0;
            user-select: none;
        }
        .ox-channel-option input[type="radio"] {
            display: none;
        }
        .ox-channel-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 12px 6px;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            font-size: 11.5px;
            font-weight: 700;
            color: #1E293B;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            box-sizing: border-box;
            min-height: 84px;
            aspect-ratio: 1 / 0.88;
        }
        .ox-channel-label:hover {
            border-color: #CBD5E1;
            background: #F8FAFC;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }
        .ox-channel-option input[type="radio"]:checked + .ox-channel-label {
            background: #F0FDF4;
            border-color: #059669;
            color: #065F46;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.16);
        }
        .ox-channel-icon-circle {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .ox-channel-option input[type="radio"]:checked + .ox-channel-label .ox-channel-icon-circle {
            background: #DCFCE7;
            color: #059669;
            transform: scale(1.05);
        }
        .ox-channel-name {
            font-size: 11.5px;
            font-weight: 700;
            color: inherit;
            line-height: 1.3;
        }

        .ox-textarea-field {
            min-height: 95px;
            resize: vertical;
            line-height: 1.6;
        }
        .ox-char-counter {
            font-size: 11px;
            color: #64748B;
            text-align: right;
            margin-top: 4px;
        }
        html[dir="ltr"] .ox-char-counter { text-align: left; }

        .ox-submit-cta-btn {
            width: 100%;
            background: #006848;
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            font-family: inherit;
            font-size: 14.5px;
            font-weight: 800;
            padding: 13px 20px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(0, 104, 72, 0.25);
            margin-top: 6px;
        }
        .ox-submit-cta-btn:hover {
            background: #004D35;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(0, 104, 72, 0.35);
        }
        .ox-submit-cta-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        .ox-nda-strip {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 12px;
            font-size: 11px;
            color: #64748B;
            text-align: center;
        }

        /* Sidebar Card & Direct Hotlines */
        .ox-contact-sidebar {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .ox-side-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 18px;
            padding: 22px 20px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
        }
        .ox-side-card h4 {
            font-size: 14.5px;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ox-side-card p {
            font-size: 12px;
            color: #64748B;
            margin: 0 0 14px;
            line-height: 1.5;
        }
        .ox-hotline-list {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }
        .ox-hotline-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 13px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 700;
            transition: all 0.2s ease;
            border: 1px solid #E2E8F0;
            background: #F8FAFC;
            color: #0F172A;
        }
        .ox-hotline-btn:hover {
            background: #FFFFFF;
            border-color: #CBD5E1;
            transform: translateX(-3px);
        }
        html[dir="ltr"] .ox-hotline-btn:hover { transform: translateX(3px); }
        .ox-hotline-btn.ox-hotline-wa {
            background: #F0FDF4;
            border-color: #BBF7D0;
            color: #15803D;
        }
        .ox-hotline-btn.ox-hotline-wa:hover {
            background: #DCFCE7;
            border-color: #86EFAC;
        }

        /* In-Modal Success Banner */
        .ox-success-banner {
            display: none;
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            border-radius: 14px;
            padding: 22px 18px;
            text-align: center;
            margin-bottom: 18px;
            animation: fadeIn 0.3s ease;
        }
        .ox-success-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #059669;
            color: #FFFFFF;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            margin-bottom: 10px;
        }
        .ox-success-wa-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #25D366;
            color: #FFFFFF;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            margin-top: 12px;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25);
            transition: transform 0.2s ease;
        }
        .ox-success-wa-link:hover {
            transform: translateY(-1px);
            color: #FFFFFF;
        }

        /* Modal Alert Box */
        .ox-modal-alert {
            display: none;
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #B91C1C;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            margin-bottom: 12px;
            align-items: center;
            gap: 8px;
        }

        /* Responsive Modal */
        @media (max-width: 860px) {
            .ox-contact-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .consult-modal-box {
                padding: 22px 16px 18px;
                border-radius: 18px;
            }
        }
        @media (max-width: 560px) {
            .ox-form-grid-2 {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .ox-channel-grid {
                gap: 6px;
            }
            .ox-channel-label {
                padding: 8px 4px;
                min-height: 76px;
            }
            .ox-channel-icon-circle {
                width: 30px;
                height: 30px;
                font-size: 13px;
            }
            .ox-channel-name {
                font-size: 10px;
            }
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
                <a href="{{ route('contact') }}" onclick="openConsultModal(); return false;" class="btn-primary nav-cta-btn">
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
                    <a href="{{ route('contact') }}" class="nav-item-link {{ request()->routeIs('contact') ? 'active' : '' }}" data-target="consult">تواصل معنا</a>
                @elseif($currentLocale === 'fr')
                    <a href="{{ $isHome ? '#home' : $homeUrl }}" class="nav-item-link {{ $isHome ? 'active' : '' }}" data-target="home">Accueil</a>
                    <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" class="nav-item-link" data-target="services">Services</a>
                    <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" class="nav-item-link" data-target="work">Réalisations</a>
                    <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" class="nav-item-link" data-target="about">À Propos</a>
                    <a href="{{ route('contact') }}" class="nav-item-link {{ request()->routeIs('contact') ? 'active' : '' }}" data-target="consult">Contact</a>
                @else
                    <a href="{{ $isHome ? '#home' : $homeUrl }}" class="nav-item-link {{ $isHome ? 'active' : '' }}" data-target="home">Home</a>
                    <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" class="nav-item-link" data-target="services">Services</a>
                    <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" class="nav-item-link" data-target="work">Work</a>
                    <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" class="nav-item-link" data-target="about">About</a>
                    <a href="{{ route('contact') }}" class="nav-item-link {{ request()->routeIs('contact') ? 'active' : '' }}" data-target="consult">Contact</a>
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
                <a href="{{ route('contact') }}" onclick="closeMobileNav()">✦ تواصل معنا</a>
            @elseif($currentLocale === 'fr')
                <a href="{{ $isHome ? '#home' : $homeUrl }}" onclick="closeMobileNav()">✦ Accueil</a>
                <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" onclick="closeMobileNav()">✦ Nos Projets</a>
                <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" onclick="closeMobileNav()">✦ Services & Solutions</a>
                <a href="{{ $isHome ? '#stories' : $homeUrl . '#stories' }}" onclick="closeMobileNav()">✦ Témoignages Partenaires</a>
                <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" onclick="closeMobileNav()">✦ À Propos de Nous</a>
                <a href="{{ route('contact') }}" onclick="closeMobileNav()">✦ Contactez-nous</a>
            @else
                <a href="{{ $isHome ? '#home' : $homeUrl }}" onclick="closeMobileNav()">✦ Home</a>
                <a href="{{ $isHome ? '#work' : $homeUrl . '#work' }}" onclick="closeMobileNav()">✦ Work & Projects</a>
                <a href="{{ $isHome ? '#services' : $homeUrl . '#services' }}" onclick="closeMobileNav()">✦ Services & Solutions</a>
                <a href="{{ $isHome ? '#stories' : $homeUrl . '#stories' }}" onclick="closeMobileNav()">✦ Partner Stories</a>
                <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" onclick="closeMobileNav()">✦ About OX Tech</a>
                <a href="{{ route('contact') }}" onclick="closeMobileNav()">✦ Contact Us</a>
            @endif
        </div>
        <div class="mobile-drawer-footer">
            <a href="{{ route('contact') }}" class="primary" onclick="closeMobileNav(); openConsultModal(); return false;" style="width: 100%; justify-content: center; text-decoration: none; display: inline-flex; align-items: center;">
                {{ $currentLocale === 'ar' ? 'ابدأ مشروعك الآن' : ($currentLocale === 'fr' ? 'Démarrer Votre Projet' : 'Start Your Project Now') }} <b>{{ $currentLocale === 'ar' ? '←' : '→' }}</b>
            </a>
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
                    <a href="{{ route('contact') }}" class="ox-footer-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" data-target="consult">
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

    @php
        $modalPhoneCountries = [
            ['code' => 'sa', 'dial' => '+966', 'name_ar' => 'المملكة العربية السعودية', 'name_en' => 'Saudi Arabia'],
            ['code' => 'ae', 'dial' => '+971', 'name_ar' => 'الإمارات العربية المتحدة', 'name_en' => 'United Arab Emirates'],
            ['code' => 'kw', 'dial' => '+965', 'name_ar' => 'الكويت', 'name_en' => 'Kuwait'],
            ['code' => 'qa', 'dial' => '+974', 'name_ar' => 'قطر', 'name_en' => 'Qatar'],
            ['code' => 'bh', 'dial' => '+973', 'name_ar' => 'البحرين', 'name_en' => 'Bahrain'],
            ['code' => 'om', 'dial' => '+968', 'name_ar' => 'سلطنة عُمان', 'name_en' => 'Oman'],
            ['code' => 'eg', 'dial' => '+20',  'name_ar' => 'مصر', 'name_en' => 'Egypt'],
            ['code' => 'jo', 'dial' => '+962', 'name_ar' => 'الأردن', 'name_en' => 'Jordan'],
            ['code' => 'iq', 'dial' => '+964', 'name_ar' => 'العراق', 'name_en' => 'Iraq'],
            ['code' => 'ye', 'dial' => '+967', 'name_ar' => 'اليمن', 'name_en' => 'Yemen'],
            ['code' => 'ma', 'dial' => '+212', 'name_ar' => 'المغرب', 'name_en' => 'Morocco'],
            ['code' => 'dz', 'dial' => '+213', 'name_ar' => 'الجزائر', 'name_en' => 'Algeria'],
            ['code' => 'tn', 'dial' => '+216', 'name_ar' => 'تونس', 'name_en' => 'Tunisia'],
            ['code' => 'lb', 'dial' => '+961', 'name_ar' => 'لبنان', 'name_en' => 'Lebanon'],
            ['code' => 'ly', 'dial' => '+218', 'name_ar' => 'ليبيا', 'name_en' => 'Libya'],
            ['code' => 'ps', 'dial' => '+970', 'name_ar' => 'فلسطين', 'name_en' => 'Palestine'],
            ['code' => 'sd', 'dial' => '+249', 'name_ar' => 'السودان', 'name_en' => 'Sudan'],
            ['code' => 'sy', 'dial' => '+963', 'name_ar' => 'سوريا', 'name_en' => 'Syria'],
            ['code' => 'gb', 'dial' => '+44',  'name_ar' => 'المملكة المتحدة', 'name_en' => 'United Kingdom'],
            ['code' => 'us', 'dial' => '+1',   'name_ar' => 'الولايات المتحدة', 'name_en' => 'United States'],
            ['code' => 'ca', 'dial' => '+1',   'name_ar' => 'كندا', 'name_en' => 'Canada'],
            ['code' => 'de', 'dial' => '+49',  'name_ar' => 'ألمانيا', 'name_en' => 'Germany'],
            ['code' => 'fr', 'dial' => '+33',  'name_ar' => 'فرنسا', 'name_en' => 'France'],
            ['code' => 'tr', 'dial' => '+90',  'name_ar' => 'تركيا', 'name_en' => 'Turkey'],
            ['code' => 'se', 'dial' => '+46',  'name_ar' => 'السويد', 'name_en' => 'Sweden'],
            ['code' => 'ch', 'dial' => '+41',  'name_ar' => 'سويسرا', 'name_en' => 'Switzerland'],
            ['code' => 'nl', 'dial' => '+31',  'name_ar' => 'هولندا', 'name_en' => 'Netherlands'],
            ['code' => 'es', 'dial' => '+34',  'name_ar' => 'إسبانيا', 'name_en' => 'Spain'],
            ['code' => 'it', 'dial' => '+39',  'name_ar' => 'إيطاليا', 'name_en' => 'Italy'],
            ['code' => 'my', 'dial' => '+60',  'name_ar' => 'ماليزيا', 'name_en' => 'Malaysia'],
            ['code' => 'sg', 'dial' => '+65',  'name_ar' => 'سنغافورة', 'name_en' => 'Singapore'],
            ['code' => 'au', 'dial' => '+61',  'name_ar' => 'أستراليا', 'name_en' => 'Australia'],
            ['code' => 'in', 'dial' => '+91',  'name_ar' => 'الهند', 'name_en' => 'India'],
            ['code' => 'pk', 'dial' => '+92',  'name_ar' => 'باكستان', 'name_en' => 'Pakistan'],
            ['code' => 'cn', 'dial' => '+86',  'name_ar' => 'الصين', 'name_en' => 'China'],
        ];
        $defaultModalCountry = $modalPhoneCountries[0]; // Saudi Arabia (+966) by default
    @endphp

    <!-- Consultation Modal with UTM Marketing Attribution Inputs -->
    <div class="consult-modal-backdrop" id="consultModal">
        <div class="consult-modal-box">
            <button type="button" class="modal-close" onclick="closeConsultModal()" aria-label="{{ $currentLocale === 'ar' ? 'إغلاق النافذة' : 'Close modal' }}">
                <i class="fa-solid fa-xmark" style="font-size: 16px;"></i>
            </button>

            <div class="ox-contact-grid">
                <!-- 1. Main Luxury Consultation Form Card -->
                <div class="ox-contact-card">
                    <div class="ox-card-header">
                        <h3>{{ $currentLocale === 'ar' ? 'املأ بيانات مشروعك لحجز الجلسة' : ($currentLocale === 'fr' ? 'Décrivez Votre Projet pour Réserver la Session' : 'Tell Us About Your Project to Book the Session') }}</h3>
                        <p>{{ $currentLocale === 'ar' ? 'سيقوم مستشار تقني مختص بمراجعة طلبك وإعداد ملخص هندسي لمشروعك.' : ($currentLocale === 'fr' ? 'Un consultant technique senior examinera vos besoins et préparera une synthèse d’ingénierie.' : 'A senior tech consultant will review your specifications and prepare an architectural brief.') }}</p>
                    </div>

                    <!-- In-Modal Alert Box -->
                    <div class="ox-modal-alert" id="oxModalAlert" role="alert">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 14px;"></i>
                        <span id="oxModalAlertText"></span>
                    </div>

                    <!-- In-Modal Success State -->
                    <div id="contactSuccessState" class="ox-success-banner">
                        <div class="ox-success-icon">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <h3 style="font-size: 20px; font-weight: 800; color: #065F46; margin-bottom: 6px;">
                            {{ $currentLocale === 'ar' ? 'تم استلام طلب استشارتك بنجاح! 🎉' : ($currentLocale === 'fr' ? 'Votre Demande a été Reçue avec Succès ! 🎉' : 'Your Consultation Request Has Been Received! 🎉') }}
                        </h3>
                        <p style="font-size: 13.5px; color: #334155; line-height: 1.6; max-width: 480px; margin: 0 auto 12px;">
                            {{ $currentLocale === 'ar' 
                                ? 'شكراً لثقتك بـ OX Tech. سيقوم أحد خبرائنا التقنيين بالتواصل معك خلال أقل من ساعتين عمل لمناقشة متطلبات مشروعك وتقديم دراسة الجدوى ومعمارية النظام.' 
                                : ($currentLocale === 'fr' 
                                    ? 'Merci de votre confiance. Un de nos architectes logiciels seniors prendra contact avec vous d’ici 2 heures ouvrées pour examiner votre projet.' 
                                    : 'Thank you for choosing OX Tech. One of our lead software architects will connect with you within 2 hours to confirm your meeting and review your technical roadmap.') 
                            }}
                        </p>
                        <div style="font-size: 13px; color: #059669; font-weight: 800;" id="contactRefNumber">
                            {{ $currentLocale === 'ar' ? 'رقم الطلب المرجعي:' : ($currentLocale === 'fr' ? 'N° de référence :' : 'Reference ID:') }} <span id="refCodeSpan">OX-2026</span>
                        </div>

                        <a id="waDirectFollowupBtn" 
                           href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_phone_primary'] ?? ($siteSettings['social_whatsapp'] ?? '201008616682')) }}?text={{ urlencode($currentLocale === 'ar' ? 'مرحباً فريق OX Tech، قمت بتقديم طلب استشارة تقنية وأرغب بالمتابعة السريعة معكم.' : 'Hello OX Tech, I just booked a tech consultation and would like an instant follow-up.') }}" 
                           target="_blank" 
                           class="ox-success-wa-link" 
                           onclick="trackWaEscalation()">
                            <i class="fa-brands fa-whatsapp" style="font-size: 17px;"></i>
                            <span>{{ $currentLocale === 'ar' ? 'محادثة فورية مع المستشار عبر واتساب' : ($currentLocale === 'fr' ? 'Échange Immédiat sur WhatsApp' : 'Direct VIP Chat on WhatsApp') }}</span>
                        </a>
                    </div>

                    <!-- Interactive Form -->
                    <form id="oxContactForm" onsubmit="handleModalContactSubmit(event)">
                        @csrf
                        <input type="text" name="hp_check" value="" style="display:none !important;" tabindex="-1" autocomplete="off">
                        <input type="text" name="website_hp" value="" style="display:none !important;" tabindex="-1" autocomplete="off">
                        <input type="hidden" name="_form_load_time" value="{{ time() }}">
                        <input type="hidden" name="utm_source" value="{{ session('attribution.utm_source', request('utm_source')) }}">
                        <input type="hidden" name="utm_medium" value="{{ session('attribution.utm_medium', request('utm_medium')) }}">
                        <input type="hidden" name="utm_campaign" value="{{ session('attribution.utm_campaign', request('utm_campaign')) }}">
                        <input type="hidden" name="referrer_url" value="{{ url()->previous() }}">

                        <!-- Row 1: Name & Email -->
                        <div class="ox-form-grid-2">
                            <div class="ox-form-group">
                                <label class="ox-form-label">{{ $currentLocale === 'ar' ? 'الاسم الكريم *' : ($currentLocale === 'fr' ? 'Nom Complet *' : 'Full Name *') }}</label>
                                <div class="ox-input-wrapper">
                                    <i class="fa-solid fa-user ox-input-icon"></i>
                                    <input type="text" name="name" id="c_name" required placeholder="{{ $currentLocale === 'ar' ? 'مثال: سلطان القحطاني' : ($currentLocale === 'fr' ? 'ex: Alexandre Dubois' : 'e.g. Sultan Al-Qahtani') }}" class="ox-input-field">
                                </div>
                            </div>

                            <div class="ox-form-group">
                                <label class="ox-form-label">{{ $currentLocale === 'ar' ? 'البريد الإلكتروني المهني *' : ($currentLocale === 'fr' ? 'Email Professionnel *' : 'Business Email *') }}</label>
                                <div class="ox-input-wrapper">
                                    <i class="fa-solid fa-envelope ox-input-icon"></i>
                                    <input type="email" name="email" id="c_email" required placeholder="ceo@company.sa" class="ox-input-field">
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Phone with Flag Dropdown & Project Type -->
                        <div class="ox-form-grid-2">
                            <div class="ox-form-group">
                                <label class="ox-form-label">{{ $currentLocale === 'ar' ? 'رقم الجوال / واتساب *' : ($currentLocale === 'fr' ? 'Téléphone / WhatsApp *' : 'Mobile / WhatsApp *') }}</label>
                                <div class="ox-phone-row">
                                    <button type="button" class="ox-country-btn" id="modalOxCountryBtn" onclick="toggleModalCountryDropdown(event)" aria-haspopup="listbox" aria-expanded="false" title="{{ $currentLocale === 'ar' ? 'اختر الدولة' : 'Select Country' }}">
                                        <img id="modalOxSelectedFlagImg" src="{{ asset('assets/flags/' . $defaultModalCountry['code'] . '.webp') }}" alt="{{ $defaultModalCountry['name_en'] }}" class="ox-country-flag-img" width="22" height="15" loading="lazy">
                                        <span id="modalOxSelectedDialText" class="ox-country-dial-code">{{ $defaultModalCountry['dial'] }}</span>
                                        <svg class="ox-country-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="country_code" id="modal_c_country_code" value="{{ $defaultModalCountry['dial'] }}">

                                    <div class="ox-input-wrapper" style="flex: 1;">
                                        <input type="tel" name="phone" id="modal_c_phone" required placeholder="50 123 4567" class="ox-input-field">
                                    </div>

                                    <!-- Country Dropdown Popover -->
                                    <div class="ox-country-popover" id="modalOxCountryPopover" role="listbox">
                                        <div class="ox-country-search-wrap">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                            <input type="text" id="modalOxCountrySearchInput" class="ox-country-search-input" placeholder="{{ $currentLocale === 'ar' ? 'ابحث باسم الدولة أو الكود...' : 'Search country or code...' }}" autocomplete="off" oninput="filterModalCountryList(this.value)">
                                        </div>
                                        <div class="ox-country-list" id="modalOxCountryList">
                                            @foreach($modalPhoneCountries as $c)
                                                <button type="button" class="ox-country-item {{ $c['code'] === $defaultModalCountry['code'] ? 'selected' : '' }}" 
                                                    data-code="{{ $c['code'] }}" 
                                                    data-dial="{{ $c['dial'] }}" 
                                                    data-name="{{ $currentLocale === 'ar' ? $c['name_ar'] : $c['name_en'] }}" 
                                                    onclick="selectModalContactCountry('{{ $c['code'] }}', '{{ $c['dial'] }}', '{{ asset('assets/flags/' . $c['code'] . '.webp') }}')">
                                                    <span class="ox-country-item-left">
                                                        <img src="{{ asset('assets/flags/' . $c['code'] . '.webp') }}" class="ox-country-item-flag" width="20" height="14" alt="{{ $c['name_en'] }}" loading="lazy">
                                                        <span class="ox-country-item-name">{{ $currentLocale === 'ar' ? $c['name_ar'] : $c['name_en'] }}</span>
                                                    </span>
                                                    <span class="ox-country-item-dial">{{ $c['dial'] }}</span>
                                                </button>
                                            @endforeach
                                            <div class="ox-country-no-results" id="modalOxCountryNoResults" style="display: none;">
                                                {{ $currentLocale === 'ar' ? 'لا توجد نتائج مطابقة' : 'No matching results' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ox-form-group">
                                <label class="ox-form-label">{{ $currentLocale === 'ar' ? 'نوع المشروع التقني' : ($currentLocale === 'fr' ? 'Type de Projet' : 'Project Classification') }}</label>
                                <select name="project_type" id="modal_c_proj_type" class="ox-select-field">
                                    <option value="منصة وبوابة رقمية / ويب متطورة">{{ $currentLocale === 'ar' ? 'منصة وبوابة رقمية / ويب متطورة' : 'Custom Web Platform & Digital Portal' }}</option>
                                    <option value="تطبيق جوال ذكي (iOS & Android)">{{ $currentLocale === 'ar' ? 'تطبيق جوال ذكي (iOS & Android)' : 'Native Mobile Application (iOS & Android)' }}</option>
                                    <option value="متجر إلكتروني بنظام تجارة حديث">{{ $currentLocale === 'ar' ? 'متجر إلكتروني بنظام تجارة حديث' : 'Next-Gen E-Commerce Ecosystem' }}</option>
                                    <option value="نظام ERP / CRM سحابي لإدارة الشركات">{{ $currentLocale === 'ar' ? 'نظام ERP / CRM سحابي لإدارة الشركات' : 'Enterprise ERP / CRM Cloud System' }}</option>
                                    <option value="حلول الذكاء الاصطناعي والأتمتة الذكية">{{ $currentLocale === 'ar' ? 'حلول الذكاء الاصطناعي والأتمتة الذكية' : 'AI Engineering & Intelligent Automation' }}</option>
                                    <option value="بنية تحتية سحابية وهندسة DevOps">{{ $currentLocale === 'ar' ? 'بنية تحتية سحابية وهندسة DevOps' : 'Cloud Architecture & DevOps Migration' }}</option>
                                    <option value="استشارة تقنية وهندسية عامة">{{ $currentLocale === 'ar' ? 'استشارة تقنية وهندسية عامة' : 'General Tech Architecture Consultation' }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 3: 3 Compact Square Channel Tiles -->
                        <div class="ox-form-group">
                            <label class="ox-form-label">{{ $currentLocale === 'ar' ? 'طريقة التواصل المفضلة:' : ($currentLocale === 'fr' ? 'Canal de Contact Préféré :' : 'Preferred Contact Channel:') }}</label>
                            <div class="ox-channel-grid">
                                <label class="ox-channel-option">
                                    <input type="radio" name="contact_preference" value="واتساب" checked>
                                    <span class="ox-channel-label">
                                        <span class="ox-channel-icon-circle">
                                            <i class="fa-brands fa-whatsapp" style="color: #25d366; font-size: 18px;"></i>
                                        </span>
                                        <span class="ox-channel-name">{{ $currentLocale === 'ar' ? 'واتساب (الأسرع)' : 'WhatsApp (Fastest)' }}</span>
                                    </span>
                                </label>
                                <label class="ox-channel-option">
                                    <input type="radio" name="contact_preference" value="مكالمة هاتفية">
                                    <span class="ox-channel-label">
                                        <span class="ox-channel-icon-circle">
                                            <i class="fa-solid fa-phone" style="color: #006848; font-size: 15px;"></i>
                                        </span>
                                        <span class="ox-channel-name">{{ $currentLocale === 'ar' ? 'مكالمة هاتفية' : 'Phone Call' }}</span>
                                    </span>
                                </label>
                                <label class="ox-channel-option">
                                    <input type="radio" name="contact_preference" value="اجتماع زوم / Google Meet">
                                    <span class="ox-channel-label">
                                        <span class="ox-channel-icon-circle">
                                            <i class="fa-solid fa-video" style="color: #0284c7; font-size: 15px;"></i>
                                        </span>
                                        <span class="ox-channel-name">{{ $currentLocale === 'ar' ? 'اجتماع Meet / Zoom' : 'Google Meet / Zoom' }}</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Row 4: Message Textarea -->
                        <div class="ox-form-group">
                            <label class="ox-form-label">{{ $currentLocale === 'ar' ? 'تفاصيل الفكرة أو المتطلبات الرئيسية *' : ($currentLocale === 'fr' ? 'Spécifications et Objectifs Clés *' : 'Project Scope or Key Objectives *') }}</label>
                            <textarea name="message" id="modal_c_message" required minlength="10" maxlength="1000" placeholder="{{ $currentLocale === 'ar' ? 'أخبرنا باختصار عن فكرتك، الميزات الرئيسية المطلوبة، أو التحدي التقني الذي ترغب في حله...' : 'Briefly describe your vision, core features required, or the engineering challenge you need solved...' }}" class="ox-textarea-field" oninput="updateModalCharCount(this)"></textarea>
                            <div class="ox-char-counter">
                                <span id="modalCharCountSpan">0</span> / 1000 {{ $currentLocale === 'ar' ? 'حرف (الحد الأدنى 10)' : 'characters (min 10)' }}
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="btnModalContactSubmit" class="ox-submit-cta-btn">
                            <span>{{ $currentLocale === 'ar' ? 'تأكيد وحجز الاستشارة المجانية' : ($currentLocale === 'fr' ? 'Confirmer et Réserver la Session' : 'Confirm & Book Free Session') }}</span>
                            <i class="fa-solid {{ $currentLocale === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                        </button>

                        <div class="ox-nda-strip">
                            <i class="fa-solid fa-shield-halved" style="color: #006848;"></i>
                            <span>{{ $currentLocale === 'ar' ? 'نلتزم بالسرية التامة للبيانات وفق أفضل المعايير المهنية (NDA)' : 'Strict data confidentiality protected by mutual Non-Disclosure Agreement (NDA)' }}</span>
                        </div>
                    </form>
                </div>

                <!-- 2. Direct Channels Executive Sidebar -->
                <div class="ox-contact-sidebar">
                    <div class="ox-side-card">
                        <h4>
                            <i class="fa-solid fa-bolt" style="color: #006848;"></i>
                            <span>{{ $currentLocale === 'ar' ? 'قنوات التواصل المباشرة والتنفيذية' : 'Direct Executive Channels' }}</span>
                        </h4>
                        <p>{{ $currentLocale === 'ar' ? 'تواصل مباشرة مع فريقنا القيادي والهندسي للاستفسارات السريعة.' : 'Connect directly with our regional leadership and engineering team.' }}</p>

                        <div class="ox-hotline-list">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_phone_primary'] ?? ($siteSettings['social_whatsapp'] ?? '201008616682')) }}?text={{ urlencode($currentLocale === 'ar' ? 'مرحباً فريق OX Tech، أرغب بالتواصل المباشر مع استشاري بخصوص مشروع جديد.' : 'Hello OX Tech, I would like to connect directly with a consultant.') }}" target="_blank" class="ox-hotline-btn ox-hotline-wa" onclick="trackWaDirectClick()">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-brands fa-whatsapp" style="font-size: 18px;"></i>
                                    <span>{{ $currentLocale === 'ar' ? 'محادثة فورية عبر واتساب (رد فوري)' : 'Instant WhatsApp Hotline' }}</span>
                                </div>
                                <i class="fa-solid {{ $currentLocale === 'ar' ? 'fa-chevron-left' : 'fa-chevron-right' }}" style="font-size: 11px;"></i>
                            </a>

                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['contact_phone_primary'] ?? '+201008616682') }}" class="ox-hotline-btn">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-phone" style="color: #006848; font-size: 14px;"></i>
                                    <span>{{ $currentLocale === 'ar' ? 'اتصال هاتفي مباشر' : 'Direct Phone Call' }}</span>
                                </div>
                                <span style="font-size: 11px; color: #64748B;" dir="ltr">{{ $siteSettings['contact_phone_primary'] ?? '+20 10 08616682' }}</span>
                            </a>

                            <a href="mailto:{{ $siteSettings['contact_email_primary'] ?? 'contact@oxtech.uk' }}" class="ox-hotline-btn">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-envelope" style="color: #006848; font-size: 14px;"></i>
                                    <span>{{ $currentLocale === 'ar' ? 'مراسلة عبر البريد الإلكتروني' : 'Executive Email Inquiries' }}</span>
                                </div>
                                <span style="font-size: 11px; color: #64748B;" dir="ltr">{{ $siteSettings['contact_email_primary'] ?? 'contact@oxtech.uk' }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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
        // ─── Modal Open & Close Logic ───
        function openConsultModal() {
            const modal = document.getElementById('consultModal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeConsultModal() {
            const modal = document.getElementById('consultModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
            closeModalCountryPopover();
        }

        document.getElementById('consultModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeConsultModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const pop = document.getElementById('modalOxCountryPopover');
                if (pop && pop.classList.contains('open')) {
                    closeModalCountryPopover();
                } else {
                    const modal = document.getElementById('consultModal');
                    if (modal && modal.classList.contains('active')) {
                        closeConsultModal();
                    }
                }
            }
        });

        // ─── Country Flag Picker Handlers for Modal ───
        function toggleModalCountryDropdown(e) {
            if (e) e.stopPropagation();
            const pop = document.getElementById('modalOxCountryPopover');
            const btn = document.getElementById('modalOxCountryBtn');
            if (!pop) return;

            const isOpen = pop.classList.contains('open');
            if (isOpen) {
                closeModalCountryPopover();
            } else {
                pop.classList.add('open');
                btn?.classList.add('open');
                setTimeout(() => {
                    document.getElementById('modalOxCountrySearchInput')?.focus();
                }, 50);
            }
        }

        function closeModalCountryPopover() {
            const pop = document.getElementById('modalOxCountryPopover');
            const btn = document.getElementById('modalOxCountryBtn');
            if (pop) pop.classList.remove('open');
            if (btn) btn.classList.remove('open');
        }

        function selectModalContactCountry(code, dial, flagUrl) {
            const flagImg = document.getElementById('modalOxSelectedFlagImg');
            const dialText = document.getElementById('modalOxSelectedDialText');
            const hiddenCode = document.getElementById('modal_c_country_code');

            if (flagImg) flagImg.src = flagUrl;
            if (dialText) dialText.textContent = dial;
            if (hiddenCode) hiddenCode.value = dial;

            document.querySelectorAll('#modalOxCountryList .ox-country-item').forEach(item => {
                item.classList.toggle('selected', item.getAttribute('data-code') === code);
            });

            closeModalCountryPopover();
            document.getElementById('modal_c_phone')?.focus();
        }

        function filterModalCountryList(query) {
            query = (query || '').toLowerCase().trim();
            const items = document.querySelectorAll('#modalOxCountryList .ox-country-item');
            let visibleCount = 0;

            items.forEach(item => {
                const name = (item.getAttribute('data-name') || '').toLowerCase();
                const dial = (item.getAttribute('data-dial') || '').toLowerCase();
                const matches = name.includes(query) || dial.includes(query);
                item.style.display = matches ? 'flex' : 'none';
                if (matches) visibleCount++;
            });

            const noResults = document.getElementById('modalOxCountryNoResults');
            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        document.addEventListener('click', function(e) {
            const pop = document.getElementById('modalOxCountryPopover');
            const btn = document.getElementById('modalOxCountryBtn');
            if (pop && pop.classList.contains('open')) {
                if (!pop.contains(e.target) && !btn?.contains(e.target)) {
                    closeModalCountryPopover();
                }
            }
        });

        // ─── Modal Textarea Live Character Counter ───
        function updateModalCharCount(textarea) {
            const span = document.getElementById('modalCharCountSpan');
            if (span && textarea) {
                span.textContent = textarea.value.length;
            }
        }

        // ─── Direct WhatsApp Event Escalation ───
        function trackWaEscalation() {
            try {
                if (typeof window.fbq === 'function') {
                    window.fbq('trackCustom', 'WhatsAppConsultationClick', { source: 'modal_success_button' });
                }
                if (typeof window.gtag === 'function') {
                    window.gtag('event', 'whatsapp_escalation', { event_category: 'Consultation', event_label: 'Modal Success WhatsApp' });
                }
            } catch (e) {}
        }

        function trackWaDirectClick() {
            try {
                if (typeof window.fbq === 'function') {
                    window.fbq('trackCustom', 'WhatsAppDirectClick', { source: 'modal_sidebar' });
                }
                if (typeof window.gtag === 'function') {
                    window.gtag('event', 'whatsapp_click', { event_category: 'Hotlines', event_label: 'Modal Sidebar WhatsApp' });
                }
            } catch (e) {}
        }

        // ─── Form Submission with Instant AJAX & Live Pixels ───
        function handleModalContactSubmit(e) {
            e.preventDefault();
            const form = document.getElementById('oxContactForm');
            const btn = document.getElementById('btnModalContactSubmit');
            const alertBox = document.getElementById('oxModalAlert');
            const alertText = document.getElementById('oxModalAlertText');
            if (!form || !btn) return;

            if (alertBox) alertBox.style.display = 'none';

            const msgInput = document.getElementById('modal_c_message');
            if (msgInput && msgInput.value.trim().length < 10) {
                if (alertBox && alertText) {
                    alertText.textContent = "{{ $currentLocale === 'ar' ? 'يرجى كتابة 10 أحرف على الأقل لشرح متطلبات مشروعك.' : 'Please enter at least 10 characters explaining your project requirements.' }}";
                    alertBox.style.display = 'flex';
                }
                msgInput.focus();
                return;
            }

            const origBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>{{ $currentLocale === 'ar' ? 'جاري تأكيد حجزك...' : ($currentLocale === 'fr' ? 'Confirmation en cours...' : 'Securing your session...') }}</span>`;

            // Prepare unified international phone number
            const dialCode = document.getElementById('modal_c_country_code')?.value || '+966';
            const phoneRaw = document.getElementById('modal_c_phone')?.value || '';
            let cleanPhone = phoneRaw.trim();
            if (cleanPhone.startsWith('0')) cleanPhone = cleanPhone.replace(/^0+/, '');
            const fullPhone = cleanPhone.startsWith('+') ? cleanPhone : (dialCode + ' ' + cleanPhone);

            const formData = new FormData(form);
            formData.set('phone', fullPhone);

            fetch("{{ route('consultation.store') }}", {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async res => {
                const data = await res.json().catch(() => null);
                if (res.ok && data && data.success) {
                    const leadId = data.consultation_id ? ('OX-' + data.consultation_id) : ('OX-' + Date.now().toString().slice(-6));
                    
                    // Dispatch multi-channel marketing pixels
                    try {
                        if (typeof window.fbq === 'function') {
                            window.fbq('track', 'Lead', {
                                content_name: 'Tech Consultation Discovery',
                                content_category: formData.get('project_type'),
                                currency: 'SAR',
                                value: 0.00
                            });
                            window.fbq('trackCustom', 'ConsultationBooked', {
                                lead_id: leadId,
                                project_type: formData.get('project_type'),
                                contact_preference: formData.get('contact_preference')
                            });
                        }
                    } catch (pixelErr) {}

                    try {
                        if (typeof window.gtag === 'function') {
                            window.gtag('event', 'generate_lead', {
                                event_category: 'Consultation',
                                event_label: formData.get('project_type'),
                                lead_id: leadId
                            });
                            window.gtag('event', 'conversion', { 'send_to': 'AW-17984061932' });
                        }
                    } catch (gtagErr) {}

                    // Update Reference Code in Success Banner
                    const refCodeSpan = document.getElementById('refCodeSpan');
                    if (refCodeSpan) refCodeSpan.textContent = leadId;

                    // Update WhatsApp VIP direct followup link with custom Reference ID
                    const waBtn = document.getElementById('waDirectFollowupBtn');
                    if (waBtn) {
                        const waBase = "https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_phone_primary'] ?? ($siteSettings['social_whatsapp'] ?? '201008616682')) }}";
                        const waText = encodeURIComponent("{{ $currentLocale === 'ar' ? 'مرحباً فريق OX Tech، قمت بحجز استشارة تقنية برقم مرجعي #' : 'Hello OX Tech, I booked a consultation with reference #' }}" + leadId + " {{ $currentLocale === 'ar' ? 'وأود المتابعة المباشرة معك.' : 'and would like to follow up directly.' }}");
                        waBtn.href = `${waBase}?text=${waText}`;
                    }

                    // Smooth transition to Success State
                    form.style.display = 'none';
                    const successState = document.getElementById('contactSuccessState');
                    if (successState) successState.style.display = 'block';
                } else {
                    const errMsg = (data && data.message) ? data.message : "{{ $currentLocale === 'ar' ? 'حدث خطأ أثناء إرسال البيانات، يرجى المحاولة مرة أخرى.' : 'An error occurred while submitting. Please try again.' }}";
                    if (alertBox && alertText) {
                        alertText.textContent = errMsg;
                        alertBox.style.display = 'flex';
                    }
                    btn.disabled = false;
                    btn.innerHTML = origBtnHtml;
                }
            })
            .catch(err => {
                console.warn('Network issue during modal submission, submitting standard form:', err);
                form.submit();
            });
        }

        // Fallback for session flash success (e.g. from server redirects)
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                trackConsultationLead({
                    source: 'session_flash'
                });
            });
        @endif

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
