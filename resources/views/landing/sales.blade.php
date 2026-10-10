<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landingPage->headline ?: $product->name }} | {{ config('app.name', 'OX Tech') }}</title>
    <meta name="description" content="{{ $landingPage->subheadline ?: ($product->tagline ?: Str::limit(strip_tags($product->description), 160)) }}">

    <!-- Open Graph / Meta / WhatsApp / Social Cards -->
    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $landingPage->og_title ?: ($landingPage->headline ?: $product->name) }}">
    <meta property="og:description" content="{{ $landingPage->og_description ?: ($landingPage->subheadline ?: $product->tagline) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(!empty($landingPage->og_image))
        <meta property="og:image" content="{{ str_starts_with($landingPage->og_image, 'http') ? $landingPage->og_image : asset($landingPage->og_image) }}">
    @elseif(!empty($product->thumbnail))
        <meta property="og:image" content="{{ str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset($product->thumbnail) }}">
    @endif
    <meta property="product:price:amount" content="{{ $product->sale_price ?: $product->price }}">
    <meta property="product:price:currency" content="{{ $product->currency }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $landingPage->og_title ?: ($landingPage->headline ?: $product->name) }}">
    <meta name="twitter:description" content="{{ $landingPage->og_description ?: ($landingPage->subheadline ?: $product->tagline) }}">
    @if(!empty($landingPage->og_image))
        <meta name="twitter:image" content="{{ str_starts_with($landingPage->og_image, 'http') ? $landingPage->og_image : asset($landingPage->og_image) }}">
    @elseif(!empty($product->thumbnail))
        <meta name="twitter:image" content="{{ str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset($product->thumbnail) }}">
    @endif

    <!-- Google tag (gtag.js) -->
    @php
        $gaId = !empty($landingPage->google_analytics_id) ? $landingPage->google_analytics_id : 'AW-17984061932';
        $pixelId = !empty($landingPage->meta_pixel_id) ? $landingPage->meta_pixel_id : '1907678277306091';
        $effectivePrice = (float) ($product->sale_price ?: $product->price);
        $oldPrice = $product->sale_price ? (float) $product->price : round($effectivePrice * 1.5, 2);
        $discountPct = $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 35;
        $waPhone = '201008616682';
    @endphp
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gaId }}');
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
    fbq('init', '{{ $pixelId }}');
    fbq('track', 'PageView');
    fbq('track', 'ViewContent', {
        content_name: '{{ addslashes($product->name) }}',
        content_ids: ['{{ $product->id }}'],
        content_type: 'product',
        value: {{ $effectivePrice }},
        currency: '{{ $product->currency }}'
    });
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ $pixelId }}&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->

    {{-- External CSS stylesheets --}}
    @if(!empty($landingPage->external_css_urls))
        @foreach(explode("\n", str_replace("\r", "", $landingPage->external_css_urls)) as $cssUrl)
            @if(trim($cssUrl))
                <link rel="stylesheet" href="{{ trim($cssUrl) }}">
            @endif
        @endforeach
    @endif

    {{-- Custom Head Scripts --}}
    @if(!empty($landingPage->custom_head_scripts))
        {!! $landingPage->custom_head_scripts !!}
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* ═══════════════════════════════════════════════════════════════════
           Scrip OX Luxury Emerald High-Converting Landing Theme
           Optimized: Distraction-free, Pure CSS 3D Mockups, Mobile First
           ═══════════════════════════════════════════════════════════════════ */
        :root {
            --green: #087b68;
            --deep:  #043e36;
            --ink:   #10231f;
            --muted: #71807c;
            --mint:  #eaf8f5;
            --line:  #e4eeeb;
            --yellow:#ffd12f;
            --accent-glow: #16af8e;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            padding: 0;
            background: #fff;
            color: var(--ink);
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
            direction: rtl;
            text-align: right;
            line-height: 1.65;
            overflow-x: hidden;
            font-size: 15px;
        }

        #scripox-page * {
            box-sizing: border-box;
        }

        #scripox-page a {
            color: inherit;
            text-decoration: none;
        }

        #scripox-page .sx-wrap {
            width: min(1140px, calc(100% - 36px));
            margin: auto;
        }

        #scripox-page h1, #scripox-page h2, #scripox-page h3, #scripox-page p {
            margin-top: 0;
        }

        #scripox-page h2 {
            font-size: clamp(24px, 3.2vw, 36px);
            line-height: 1.35;
            font-weight: 900;
            margin-bottom: 10px;
        }

        #scripox-page .sx-muted {
            color: var(--muted);
        }

        #scripox-page .sx-kicker {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 15px;
            border-radius: 30px;
            background: #dff5ef;
            color: var(--green);
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        #scripox-page .sx-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 26px;
            border-radius: 14px;
            background: var(--yellow);
            color: #16231f;
            font-weight: 900;
            font-size: 15px;
            box-shadow: 0 8px 24px rgba(255, 209, 47, 0.28);
            transition: all 0.25s ease;
            cursor: pointer;
            border: none;
        }

        #scripox-page .sx-btn:hover {
            transform: translateY(-2px);
            filter: brightness(0.96);
            box-shadow: 0 12px 28px rgba(255, 209, 47, 0.38);
        }

        #scripox-page .sx-btn-outline {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.35);
            box-shadow: none;
        }

        #scripox-page .sx-btn-outline:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: #fff;
        }

        #scripox-page .sx-section {
            padding: 68px 0;
        }

        #scripox-page .sx-center {
            text-align: center;
        }

        /* ─── Urgency Alert Pill ─── */
        .sx-top-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(22, 175, 142, 0.15);
            border: 1px solid rgba(22, 175, 142, 0.35);
            color: #6ee7b7;
            padding: 6px 16px;
            border-radius: 99px;
            font-size: 12.5px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        /* ─── 1. HERO (Distraction-Free: No Nav / No Header) ─── */
        #scripox-page .sx-hero {
            position: relative;
            color: #fff;
            background: radial-gradient(ellipse at 72% 25%, rgba(8, 123, 104, 0.45), transparent 45%), linear-gradient(130deg, #021614, #043b34 65%, #052421);
            padding: 45px 0 55px;
            isolation: isolate;
        }

        #scripox-page .sx-hero:before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            opacity: 0.14;
            background-image: linear-gradient(30deg, transparent 48%, #3cc5a8 49%, transparent 50%), linear-gradient(150deg, transparent 48%, #3cc5a8 49%, transparent 50%);
            background-size: 90px 90px;
            mask-image: linear-gradient(90deg, #000, transparent 75%);
        }

        .sx-hero-grid {
            display: grid;
            grid-template-columns: 1fr 1.05fr;
            gap: 40px;
            align-items: center;
            min-height: 420px;
        }

        #scripox-page .sx-hero-copy h1 {
            font-size: clamp(30px, 3.8vw, 48px);
            font-weight: 900;
            line-height: 1.25;
            margin: 0 0 16px;
            color: #ffffff;
        }

        #scripox-page .sx-hero-copy h1 em {
            font-style: normal;
            color: #26bea0;
            display: block;
            direction: ltr;
            text-align: right;
            font-size: 1.15em;
        }

        #scripox-page .sx-hero-copy p {
            color: #d6e5e1;
            max-width: 500px;
            margin-bottom: 20px;
            font-size: 15px;
            line-height: 1.7;
        }

        #scripox-page .sx-checks {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin: 18px 0 26px;
            font-size: 13px;
        }

        #scripox-page .sx-checks span {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #ecfdf5;
        }

        #scripox-page .sx-checks i {
            color: #39d4ae;
            font-size: 14px;
        }

        #scripox-page .sx-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        /* ─── Hero Visual Laptop & Floats ─── */
        #scripox-page .sx-visual {
            position: relative;
            min-height: 330px;
            display: grid;
            place-items: center;
        }

        #scripox-page .sx-laptop {
            width: 100%;
            max-width: 560px;
            padding: 10px;
            background: linear-gradient(135deg, #101d1b, #62716d);
            border: 2px solid #91a39e;
            border-radius: 16px 16px 8px 8px;
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.55);
            transform: perspective(900px) rotateY(-7deg) rotateX(2deg);
            transition: transform 0.4s ease;
        }

        #scripox-page .sx-laptop:hover {
            transform: perspective(900px) rotateY(-2deg) rotateX(0deg);
        }

        #scripox-page .sx-laptop-screen {
            height: 275px;
            border-radius: 8px;
            background: #f6faf9;
            display: flex;
            overflow: hidden;
            color: #20332e;
            font: 11px Arial, sans-serif;
            direction: ltr;
            position: relative;
        }

        #scripox-page .sx-laptop-screen img.custom-screen-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #scripox-page .sx-dash-side {
            width: 24%;
            background: #062c28;
            color: #e8f5f1;
            padding: 13px 9px;
        }

        #scripox-page .sx-dash-logo {
            font-weight: bold;
            color: #32c6a5;
            font-size: 13px;
            margin-bottom: 20px;
        }

        #scripox-page .sx-dash-item {
            padding: 8px 3px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 9px;
            color: #c6dad4;
        }

        #scripox-page .sx-dash-item i {
            width: 17px;
            color: #27b795;
        }

        #scripox-page .sx-dash-main {
            flex: 1;
            padding: 13px;
            background: #f8fbfa;
        }

        #scripox-page .sx-dash-top {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-bottom: 13px;
        }

        #scripox-page .sx-statgrid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 7px;
        }

        #scripox-page .sx-stat {
            background: white;
            padding: 10px;
            border-radius: 7px;
            border: 1px solid #e6eeeb;
            color: #52635e;
        }

        .sx-stat b {
            display: block;
            font-size: 18px;
            color: #102a25;
        }

        .sx-table {
            margin-top: 10px;
            background: #fff;
            border: 1px solid #e6eeeb;
            border-radius: 6px;
            padding: 5px;
        }

        .sx-row {
            display: grid;
            grid-template-columns: 1.2fr 1fr .8fr .7fr;
            gap: 4px;
            padding: 7px 3px;
            border-bottom: 1px solid #edf2f0;
            font-size: 8px;
        }

        .sx-pill {
            display: inline-block;
            padding: 1px 5px;
            border-radius: 9px;
            background: #d9f4eb;
            color: #07846d;
        }

        .sx-laptop-base {
            width: 110%;
            height: 12px;
            margin-right: -5%;
            background: linear-gradient(#c9d1ce, #66726f);
            clip-path: polygon(4% 0, 96% 0, 100% 100%, 0 100%);
            border-radius: 0 0 20px 20px;
        }

        #scripox-page .sx-float {
            position: absolute;
            background: #fff;
            color: #1c302b;
            border: 1px solid #e7f0ed;
            border-radius: 14px;
            padding: 10px 14px;
            box-shadow: 0 14px 34px rgba(0, 30, 25, 0.22);
            font-size: 11.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 10;
        }

        #scripox-page .sx-float i {
            font-size: 20px;
            color: var(--green);
        }

        #scripox-page .sx-float.one {
            top: 5px;
            left: -8px;
        }

        #scripox-page .sx-float.two {
            right: -14px;
            top: 40%;
        }

        #scripox-page .sx-float.three {
            right: -5px;
            bottom: -5px;
        }

        /* ─── 2. METRICS STRIP ─── */
        #scripox-page .sx-metrics {
            padding: 22px 0;
            border-bottom: 1px solid var(--line);
            background: #ffffff;
        }

        #scripox-page .sx-metric-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }

        #scripox-page .sx-metric {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            border-left: 1px solid #dce8e4;
            padding: 6px 14px;
        }

        #scripox-page .sx-metric:last-child {
            border-left: 0;
        }

        #scripox-page .sx-metric i {
            font-size: 28px;
            color: var(--green);
        }

        #scripox-page .sx-metric b {
            display: block;
            font-size: 24px;
            line-height: 1.2;
            color: #0f172a;
        }

        #scripox-page .sx-metric small {
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
        }

        /* ─── 3. PRODUCT & BENEFITS ─── */
        #scripox-page .sx-product {
            padding: 64px 0 70px;
        }

        .sx-product-grid {
            display: grid;
            grid-template-columns: 1fr .95fr;
            gap: 48px;
            align-items: center;
        }

        #scripox-page .sx-product-copy > p {
            font-size: 15px;
            color: var(--muted);
            margin: 10px 0 20px;
            line-height: 1.7;
        }

        .sx-benefit {
            display: grid;
            grid-template-columns: 44px 1fr;
            gap: 14px;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #edf2f0;
        }

        .sx-benefit:last-child {
            border: 0;
        }

        .sx-benefit-icon {
            height: 40px;
            width: 40px;
            border-radius: 12px;
            background: #e7f6f2;
            display: grid;
            place-items: center;
            color: var(--green);
            font-size: 18px;
        }

        .sx-benefit b {
            display: block;
            font-size: 15px;
            color: #0f172a;
        }

        .sx-benefit small {
            font-size: 12px;
            color: var(--muted);
        }

        #scripox-page .sx-product-mock {
            min-height: 380px;
            position: relative;
            padding: 15px 0;
        }

        .sx-window {
            position: absolute;
            left: 4%;
            top: 14px;
            width: 88%;
            height: 275px;
            background: #fff;
            border: 1px solid #dce8e4;
            border-radius: 14px;
            box-shadow: 0 22px 50px rgba(24, 76, 61, 0.14);
            overflow: hidden;
            transform: rotate(-3.5deg);
        }

        .sx-window-head {
            height: 36px;
            background: #f7fbfa;
            border-bottom: 1px solid #e9f0ee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 14px;
            font: 11px Arial;
            color: #61736e;
        }

        .sx-window-body {
            display: flex;
            height: calc(100% - 36px);
            font: 9px Arial;
            direction: ltr;
        }

        .sx-window-nav {
            width: 24%;
            background: #073d34;
            color: #e5f4ef;
            padding: 10px 8px;
        }

        .sx-window-nav div {
            padding: 7px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sx-window-content {
            flex: 1;
            padding: 12px;
            background: #fbfdfc;
        }

        .sx-window-content .sx-row {
            font-size: 8px;
        }

        .sx-contact {
            position: absolute;
            right: 0;
            bottom: 20px;
            width: 58%;
            background: #fff;
            padding: 14px;
            border: 1px solid #deebe7;
            border-radius: 14px;
            box-shadow: 0 16px 42px rgba(24, 76, 61, 0.18);
        }

        .sx-contact-title {
            font-weight: 800;
            font-size: 13px;
            border-bottom: 1px solid var(--line);
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .sx-contact-row {
            font-size: 11px;
            padding: 4px 0;
            color: #60716c;
        }

        .sx-contact-tags {
            display: flex;
            gap: 5px;
            margin: 6px 0;
        }

        .sx-contact-tags span {
            border-radius: 9px;
            background: #e1f4ed;
            color: #08816a;
            padding: 3px 8px;
            font-size: 9px;
            font-weight: 700;
        }

        .sx-filter {
            position: absolute;
            left: -4px;
            bottom: 4px;
            width: 48%;
            background: white;
            padding: 13px;
            border: 1px solid #dfebe7;
            border-radius: 14px;
            box-shadow: 0 14px 38px rgba(24, 76, 61, 0.18);
        }

        .sx-filter b {
            display: block;
            font-size: 12.5px;
            margin-bottom: 7px;
        }

        .sx-select {
            border: 1px solid #e6eeeb;
            border-radius: 7px;
            padding: 6px;
            margin-top: 5px;
            font-size: 10px;
            color: #50635d;
            display: flex;
            justify-content: space-between;
        }

        .sx-filter-btn {
            display: block;
            background: var(--green);
            color: #fff !important;
            text-align: center;
            border-radius: 7px;
            padding: 6px;
            margin-top: 8px;
            font-size: 10px;
            font-weight: 700;
        }

        .sx-note {
            position: absolute;
            bottom: -5px;
            left: 36%;
            color: var(--green);
            font-weight: 800;
            font-size: 13px;
            transform: rotate(-5deg);
        }

        /* ─── 4. SOURCES ─── */
        #scripox-page .sx-sources {
            padding: 42px 0;
            background: linear-gradient(100deg, #effaf8, #f6fbfa);
            border-radius: 26px;
            margin: 0 auto;
            width: min(1200px, calc(100% - 24px));
        }

        .sx-source-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            margin-top: 24px;
        }

        .sx-source {
            min-height: 112px;
            background: #fff;
            border: 1px solid #e4efec;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 5px;
            padding: 14px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .sx-source:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(8, 123, 104, 0.08);
        }

        .sx-source i {
            font-size: 26px;
            color: var(--green);
        }

        .sx-source .fa-google { color: #e9a300; }
        .sx-source .fa-facebook { color: #1877f2; }

        .sx-source b {
            font-size: 13px;
            color: #0f172a;
        }

        .sx-source small {
            font-size: 10px;
            color: var(--muted);
        }

        /* ─── 5. PROCESS ─── */
        #scripox-page .sx-process {
            margin-top: 28px;
            padding: 48px 0 54px;
            background: radial-gradient(ellipse at center, #0c6356, #04372f 70%, #032824);
            color: #fff;
            border-radius: 30px;
        }

        .sx-process .sx-muted {
            color: #c1d9d2;
        }

        .sx-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 28px;
            margin-top: 30px;
        }

        .sx-step {
            position: relative;
            background: #fff;
            color: var(--ink);
            border-radius: 16px;
            padding: 30px 18px 18px;
            text-align: center;
            min-height: 160px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .sx-step-num {
            position: absolute;
            top: -18px;
            left: calc(50% - 18px);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #0bb38f;
            color: #fff;
            border: 3px solid #dcfff5;
            font-weight: 900;
            display: grid;
            place-items: center;
            font-size: 14px;
        }

        .sx-step i {
            display: block;
            font-size: 26px;
            color: var(--green);
            margin-bottom: 8px;
        }

        .sx-step b {
            display: block;
            font-size: 15px;
            color: #0f172a;
        }

        .sx-step p {
            font-size: 12px;
            color: var(--muted);
            margin: 6px 0 0;
            line-height: 1.5;
        }

        .sx-step:not(:last-child):after {
            content: '←';
            position: absolute;
            left: -24px;
            top: 50%;
            font-size: 24px;
            color: #b9e7dc;
            transform: translateY(-50%);
        }

        /* ─── 6. FEATURES & VIDEO ─── */
        .sx-feature-grid {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 40px;
            align-items: center;
        }

        .sx-video {
            height: 290px;
            background: linear-gradient(145deg, #052923, #0b6153);
            border: 1px solid #b7ded5;
            border-radius: 18px;
            position: relative;
            display: grid;
            place-items: center;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(12, 81, 64, 0.22);
            cursor: pointer;
        }

        .sx-video:before {
            content: '{{ $product->name }} · تجربة حية وعرض للشاشة';
            position: absolute;
            inset: 20px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 12px;
            color: #d8f8ef;
            padding: 14px;
            font-weight: 700;
            font-size: 13px;
            opacity: 0.75;
        }

        .sx-play {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: white;
            color: var(--green);
            font-size: 24px;
            z-index: 2;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
            transition: transform 0.25s ease;
        }

        .sx-video:hover .sx-play {
            transform: scale(1.1);
        }

        .sx-video-caption {
            position: absolute;
            bottom: 16px;
            color: #fff;
            font-size: 12px;
            z-index: 2;
        }

        .sx-feature-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 22px;
        }

        .sx-feature {
            display: flex;
            gap: 10px;
            align-items: center;
            padding: 12px;
            border: 1px solid #e8f0ee;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
        }

        .sx-feature i {
            color: var(--green);
            font-size: 17px;
        }

        /* ─── 7. REVIEWS ─── */
        .sx-reviews {
            padding-top: 20px;
        }

        .sx-review-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-top: 24px;
            text-align: right;
        }

        .sx-review {
            padding: 22px;
            border: 1px solid #e6efec;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(13, 81, 64, 0.05);
        }

        .sx-review p {
            font-size: 13px;
            color: #475569;
            min-height: 58px;
            line-height: 1.6;
        }

        .sx-review b {
            font-size: 14px;
            color: #0f172a;
        }

        .sx-review small {
            display: block;
            color: #86938f;
            font-size: 11px;
        }

        .sx-stars {
            color: #efb820;
            letter-spacing: 2px;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .sx-person {
            display: flex;
            gap: 11px;
            align-items: center;
            margin-top: 14px;
        }

        .sx-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #e4f3ef;
            color: var(--green);
            font-size: 19px;
        }

        /* ─── 8. PRICE & OFFER ─── */
        #scripox-page .sx-price {
            background: radial-gradient(ellipse at 20% 20%, #18846e, #064237 58%, #032a26);
            border-radius: 28px;
            color: #fff;
            padding: 40px 0;
            margin: 25px auto;
            width: min(1200px, calc(100% - 24px));
            position: relative;
            overflow: hidden;
        }

        .sx-price:before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05)), repeating-linear-gradient(0deg, transparent 0 38px, rgba(255, 255, 255, 0.08) 39px), repeating-linear-gradient(90deg, transparent 0 38px, rgba(255, 255, 255, 0.07) 39px);
            mask-image: linear-gradient(90deg, #000, transparent 60%);
        }

        .sx-price-grid {
            position: relative;
            display: grid;
            grid-template-columns: .8fr 1.2fr;
            gap: 45px;
            align-items: center;
        }

        .sx-box-art {
            height: 230px;
            width: 190px;
            margin: auto;
            background: linear-gradient(140deg, #0b211e, #071310);
            border: 2px solid #55b8a0;
            border-radius: 14px;
            box-shadow: 14px 15px 0 #021b18;
            transform: perspective(500px) rotateY(-10deg);
            display: grid;
            place-items: center;
            text-align: center;
            color: #fff;
            padding: 16px;
        }

        .sx-box-art strong {
            font: 900 32px Arial;
            color: #1ec09b;
            display: block;
        }

        .sx-box-art span {
            font-size: 13px;
            font-weight: 700;
        }

        .sx-best {
            position: absolute;
            top: -12px;
            left: 12%;
            background: var(--yellow);
            color: #26312d;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            text-align: center;
            font-weight: 900;
            font-size: 13px;
            line-height: 1.2;
            transform: rotate(-10deg);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25);
        }

        .sx-price-copy h2 {
            margin-bottom: 6px;
            font-size: 32px;
        }

        .sx-price-copy > p {
            color: #d3e8e1;
            font-size: 14px;
        }

        .sx-price-card {
            background: #fff;
            border-radius: 16px;
            padding: 16px 20px;
            color: var(--ink);
            margin: 18px 0 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .sx-price-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .sx-price-main {
            font-size: 32px;
            font-weight: 900;
            color: #065f46;
        }

        .sx-old {
            text-decoration: line-through;
            color: #94a3b8;
            font-size: 15px;
        }

        .sx-discount {
            background: #dff5ec;
            color: #06725f;
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 13px;
        }

        .sx-price-card .sx-btn {
            width: 100%;
            margin-top: 10px;
        }

        .sx-assurances {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            color: #e5f4ef;
            font-size: 11px;
        }

        .sx-assurances span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sx-assurances i {
            color: #45d8b3;
        }

        /* ─── 9. DIRECT FAST CHECKOUT SECTION ─── */
        #sx-checkout {
            padding: 60px 0;
            background: linear-gradient(180deg, #f8fafc 0%, #effaf7 100%);
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }

        .checkout-box-inner {
            max-width: 620px;
            margin: 0 auto;
            background: #ffffff;
            border: 2px solid var(--green);
            border-radius: 24px;
            padding: 34px 28px;
            box-shadow: 0 20px 50px rgba(8, 123, 104, 0.12);
            position: relative;
        }

        .checkout-badge-pill {
            position: absolute;
            top: -15px;
            right: 50%;
            transform: translateX(50%);
            background: var(--green);
            color: #ffffff;
            padding: 6px 22px;
            border-radius: 99px;
            font-size: 12.5px;
            font-weight: 800;
            box-shadow: 0 4px 15px rgba(8, 123, 104, 0.3);
            white-space: nowrap;
        }

        .checkout-form-grid {
            display: grid;
            gap: 16px;
            margin-top: 20px;
        }

        .form-label-custom {
            display: block;
            font-size: 12.5px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .form-input-custom {
            width: 100%;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            padding: 13px 16px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            background: #f8fafc;
            color: #0f172a;
            transition: all 0.2s ease;
        }

        .form-input-custom:focus {
            border-color: var(--green);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(8, 123, 104, 0.1);
        }

        .order-summary-strip {
            background: #f0fdf9;
            border: 1px solid #bbf7d0;
            border-radius: 14px;
            padding: 14px 18px;
            margin: 18px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ─── 10. FAQ & SUPPORT ─── */
        .sx-faq-grid {
            display: grid;
            grid-template-columns: 1.3fr .7fr;
            gap: 32px;
            align-items: start;
        }

        .sx-faq-list {
            margin-top: 20px;
        }

        .sx-faq {
            border-bottom: 1px solid #e6eeeb;
        }

        .sx-faq summary {
            padding: 15px 4px;
            cursor: pointer;
            list-style: none;
            font-weight: 700;
            font-size: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            color: #0f172a;
        }

        .sx-faq summary::-webkit-details-marker {
            display: none;
        }

        .sx-faq summary:after {
            content: '+';
            font-size: 22px;
            color: var(--green);
            font-weight: 800;
            line-height: 1;
        }

        .sx-faq[open] summary:after {
            content: '−';
        }

        .sx-faq p {
            padding: 0 4px 16px;
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .sx-support {
            background: linear-gradient(145deg, #eaf8f5, #f6fbfa);
            border: 1px solid #dce8e4;
            border-radius: 20px;
            padding: 30px 24px;
            text-align: center;
            margin-top: 10px;
        }

        .sx-chat-icon {
            height: 60px;
            width: 60px;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: #08a987;
            color: #fff;
            display: grid;
            place-items: center;
            font-size: 25px;
        }

        .sx-support h3 {
            font-size: 20px;
            margin-bottom: 6px;
            color: #0f172a;
        }

        .sx-support p {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 18px;
        }

        .sx-support .sx-btn {
            background: #25D366;
            color: #fff;
            font-size: 13.5px;
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.35);
        }

        .sx-support .sx-btn:hover {
            background: #20ba5a;
        }

        /* ─── Media Queries (Responsive) ─── */
        @media(max-width: 860px) {
            #scripox-page .sx-wrap {
                width: min(100% - 28px, 640px);
            }
            #scripox-page .sx-section {
                padding: 48px 0;
            }
            .sx-hero-grid, .sx-product-grid, .sx-feature-grid, .sx-price-grid, .sx-faq-grid {
                grid-template-columns: 1fr;
            }
            .sx-hero-grid {
                gap: 24px;
            }
            .sx-hero-copy {
                text-align: center;
            }
            .sx-hero-copy p {
                margin-left: auto;
                margin-right: auto;
            }
            .sx-checks, .sx-actions {
                justify-content: center;
            }
            .sx-visual {
                min-height: 290px;
            }
            .sx-laptop-screen {
                height: 235px;
            }
            .sx-metric-grid {
                grid-template-columns: 1fr 1fr;
                row-gap: 14px;
            }
            .sx-metric:nth-child(2) {
                border-left: 0;
            }
            .sx-source-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .sx-steps {
                grid-template-columns: 1fr 1fr;
                gap: 26px 18px;
            }
            .sx-step:nth-child(2):after {
                display: none;
            }
            .sx-review-grid {
                grid-template-columns: 1fr;
            }
            .sx-review p {
                min-height: 0;
            }
            .sx-price-grid {
                gap: 28px;
            }
            .sx-box-art {
                height: 160px;
                width: 140px;
            }
            .sx-best {
                left: calc(50% - 95px);
            }
            .sx-support {
                margin-top: 20px;
            }
        }

        @media(max-width: 480px) {
            #scripox-page .sx-wrap {
                width: calc(100% - 24px);
            }
            #scripox-page .sx-hero {
                padding: 30px 0 40px;
            }
            .sx-hero-copy h1 {
                font-size: 30px !important;
            }
            .sx-hero-copy p {
                font-size: 13px !important;
            }
            .sx-checks {
                gap: 8px 12px;
                font-size: 11px !important;
            }
            .sx-visual {
                min-height: 230px;
            }
            .sx-laptop {
                padding: 6px;
            }
            .sx-laptop-screen {
                height: 185px;
            }
            .sx-dash-side {
                padding: 7px 4px;
            }
            .sx-dash-item {
                font-size: 7.5px;
                padding: 5px 0;
            }
            .sx-dash-main {
                padding: 8px;
            }
            .sx-stat {
                padding: 6px;
            }
            .sx-stat b {
                font-size: 13px;
            }
            .sx-row {
                padding: 4px 2px;
            }
            .sx-float {
                font-size: 8.5px !important;
                padding: 7px 9px !important;
            }
            .sx-float i {
                font-size: 16px !important;
            }
            .sx-metric {
                gap: 8px;
                padding: 6px !important;
            }
            .sx-metric i {
                font-size: 21px !important;
            }
            .sx-metric b {
                font-size: 19px !important;
            }
            .sx-metric small {
                font-size: 10px !important;
            }
            .sx-product-mock {
                min-height: 320px !important;
            }
            .sx-window {
                height: 230px;
            }
            .sx-contact {
                width: 65%;
                bottom: 20px;
            }
            .sx-filter {
                width: 52%;
            }
            .sx-note {
                font-size: 11px;
            }
            .sx-source-grid {
                gap: 8px;
                grid-template-columns: repeat(2, 1fr);
            }
            .sx-source {
                min-height: 95px;
                padding: 8px 6px;
            }
            .sx-steps {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            .sx-step:not(:last-child):after {
                display: none;
            }
            .sx-feature-list {
                grid-template-columns: 1fr;
            }
            .sx-video {
                height: 220px;
            }
            .sx-price {
                padding: 28px 0 !important;
            }
            .sx-price-card {
                padding: 13px;
            }
            .sx-price-main {
                font-size: 25px;
            }
            .sx-assurances {
                justify-content: center;
            }
            .checkout-box-inner {
                padding: 24px 18px;
            }
        }
    </style>

    {{-- Custom CSS Injection from Admin Panel --}}
    @if(!empty($landingPage->custom_css))
        <style id="custom-sales-css">
            {!! $landingPage->custom_css !!}
        </style>
    @endif
</head>
<body>

<div id="scripox-page" dir="rtl">

    {{-- ══════════════════════════════════════════════════════════
         SECTION 1: HERO (No header, No navigation distractions)
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-hero">
        <div class="sx-wrap">
            
            <div class="sx-hero-grid" id="sx-top">
                <div class="sx-hero-copy">
                    <div class="sx-top-pill">
                        <i class="fa-solid fa-bolt"></i>
                        <span>{{ $landingPage->hero_badge ?: '🔥 عرض حصري لفترة محدودة: تفعيل فوري مع ترخيص رسمي دائم' }}</span>
                    </div>

                    <h1>
                        {{ $landingPage->headline ?: $product->name }}
                        <em>{{ $product->tagline ?: 'Smart Data & Automation' }}</em>
                    </h1>

                    <p>
                        {{ $landingPage->subheadline ?: ($product->description ? Str::limit(strip_tags($product->description), 180) : 'نظام احترافي متكامل لاستخراج وتنظيم بيانات عملائك وتصدير الجماهير الإعلانية بضغطة زر.') }}
                    </p>

                    <div class="sx-checks">
                        <span><i class="fa-solid fa-circle-check"></i> استخراج دقيق</span>
                        <span><i class="fa-solid fa-circle-check"></i> تنظيف وفلترة فورية</span>
                        <span><i class="fa-solid fa-circle-check"></i> تفعيل فوري مدى الحياة</span>
                    </div>

                    <div class="sx-actions">
                        <a class="sx-btn" href="#sx-checkout">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>{{ $landingPage->cta_text ?: 'احصل على نسختك الآن' }}</span>
                        </a>

                        @if(!empty($landingPage->video_url))
                            <a class="sx-btn sx-btn-outline" href="#sx-video">
                                <i class="fa-regular fa-circle-play"></i>
                                <span>شاهد استعراض البرنامج</span>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- 3D Visual Laptop / Custom Uploaded Image --}}
                <div class="sx-visual">
                    <div class="sx-laptop">
                        <div class="sx-laptop-screen">
                            @if(!empty($product->thumbnail))
                                <img src="{{ str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset($product->thumbnail) }}" alt="{{ $product->name }}" class="custom-screen-img">
                            @else
                                <div class="sx-dash-side">
                                    <div class="sx-dash-logo">◉ {{ Str::limit($product->name, 12) }}</div>
                                    <div class="sx-dash-item"><i class="fa-solid fa-chart-pie"></i> Overview</div>
                                    <div class="sx-dash-item"><i class="fa-solid fa-users"></i> Customers</div>
                                    <div class="sx-dash-item"><i class="fa-solid fa-filter"></i> Filters</div>
                                    <div class="sx-dash-item"><i class="fa-solid fa-bag-shopping"></i> Orders</div>
                                    <div class="sx-dash-item"><i class="fa-solid fa-gear"></i> Settings</div>
                                </div>
                                <div class="sx-dash-main">
                                    <div class="sx-dash-top">
                                        <span>Live Dashboard</span>
                                        <span>⌕ ◉</span>
                                    </div>
                                    <div class="sx-statgrid">
                                        <div class="sx-stat">Total leads<b>12,480</b></div>
                                        <div class="sx-stat">Qualified<b>8,320</b></div>
                                        <div class="sx-stat">New today<b>2,150</b></div>
                                    </div>
                                    <div class="sx-table">
                                        <div class="sx-row" style="font-weight:bold">
                                            <span>Name</span>
                                            <span>Company</span>
                                            <span>Status</span>
                                            <span>Score</span>
                                        </div>
                                        <div class="sx-row"><span>Ahmed M.</span><span>Digital Co.</span><span><i class="sx-pill">Qualified</i></span><span>94</span></div>
                                        <div class="sx-row"><span>Salma A.</span><span>Store Plus</span><span><i class="sx-pill">New</i></span><span>87</span></div>
                                        <div class="sx-row"><span>Omar H.</span><span>Modern Biz</span><span><i class="sx-pill">Contacted</i></span><span>81</span></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="sx-laptop-base"></div>
                    </div>

                    {{-- Floating Badges --}}
                    <div class="sx-float one">
                        <i class="fa-solid fa-file-export"></i>
                        <span>تصدير فوري<br><small>Excel & CSV</small></span>
                    </div>
                    <div class="sx-float two">
                        <i class="fa-brands fa-google"></i>
                        <span>متوافق مع<br>Google Ads</span>
                    </div>
                    <div class="sx-float three">
                        <i class="fa-solid fa-bullseye"></i>
                        <span>تصدير جماهير<br>Meta Pixel</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 2: METRICS STRIP
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-metrics">
        <div class="sx-wrap sx-metric-grid">
            @php
                $stats = !empty($landingPage->social_proof_stats) && is_array($landingPage->social_proof_stats) ? $landingPage->social_proof_stats : [
                    ['value' => '+10K', 'label' => 'شركة تستخدم أدواتنا', 'icon' => 'fa-cloud-arrow-down'],
                    ['value' => '+50K', 'label' => 'عميل محتمل شهرياً', 'icon' => 'fa-bolt'],
                    ['value' => '99%', 'label' => 'دقة البيانات وجودة السيرفرات', 'icon' => 'fa-shield-halved'],
                    ['value' => '24/7', 'label' => 'دعم فني وتحديثات مستمرة', 'icon' => 'fa-globe'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="sx-metric">
                    <i class="fa-solid {{ $stat['icon'] ?? 'fa-circle-check' }}"></i>
                    <div>
                        <b>{{ $stat['value'] }}</b>
                        <small>{{ $stat['label'] }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 3: PRODUCT & CRM DEMO
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-product">
        <div class="sx-wrap sx-product-grid">
            
            {{-- Interactive UI Mockup --}}
            <div class="sx-product-mock">
                <div class="sx-window">
                    <div class="sx-window-head">
                        <b>◉ {{ $product->name }} / Customers Management</b>
                        <span>⌕ ⚙</span>
                    </div>
                    <div class="sx-window-body">
                        <div class="sx-window-nav">
                            <div>▣ Dashboard</div>
                            <div>◉ Contacts</div>
                            <div>▤ Orders</div>
                            <div>⌕ Filters</div>
                        </div>
                        <div class="sx-window-content">
                            <div class="sx-row" style="font-weight:bold">
                                <span>Customer</span><span>Source</span><span>Status</span><span>Score</span>
                            </div>
                            <div class="sx-row"><span>Ahmed M.</span><span>Website</span><span>Active</span><span>92</span></div>
                            <div class="sx-row"><span>Salma A.</span><span>Store</span><span>New</span><span>87</span></div>
                            <div class="sx-row"><span>Omar H.</span><span>Meta</span><span>Follow up</span><span>79</span></div>
                            <div class="sx-row"><span>Mona S.</span><span>Google</span><span>Active</span><span>74</span></div>
                        </div>
                    </div>
                </div>

                <div class="sx-contact">
                    <div class="sx-contact-title">
                        <i class="fa-solid fa-address-card" style="color:var(--green)"></i>
                        تفاصيل العميل والفرصة البيعية
                    </div>
                    <div class="sx-contact-row">✉ ahmed@company.com</div>
                    <div class="sx-contact-row">☎ +966 5XX XXX XXX</div>
                    <div class="sx-contact-tags">
                        <span>مهتم بالمنتج</span>
                        <span>جاهز للشراء</span>
                    </div>
                    <div class="sx-contact-row">ملاحظات: تفعيل فوري مع ترخيص دائم</div>
                </div>

                <div class="sx-filter">
                    <b><i class="fa-solid fa-filter" style="color:var(--green)"></i> فلترة متقدمة</b>
                    <div class="sx-select">المدينة / الدولة <span>⌄</span></div>
                    <div class="sx-select">المجال والتخصص <span>⌄</span></div>
                    <a href="#sx-checkout" class="sx-filter-btn">تطبيق وتصدير الجماهير</a>
                </div>

                <div class="sx-note">نظّف بياناتك ونظّمها بضغطة زر</div>
            </div>

            {{-- Product Copy & Key Benefits --}}
            <div class="sx-product-copy">
                <span class="sx-kicker">ما الذي يميز {{ $product->name }}؟</span>
                <h2>حل متكامل يضاعف مبيعاتك ويسرع وصولك للعملاء المهتمين</h2>
                <p>
                    صُمم خصيصاً للمسوقين، الشركات، ورواد الأعمال الذين يريدون تجميع بيانات نظيفة وحقيقية والبدء في التواصل والتسويق دون إضاعة الوقت.
                </p>

                @php
                    $benefits = !empty($landingPage->key_benefits) && is_array($landingPage->key_benefits) ? $landingPage->key_benefits : [
                        ['title' => 'استخراج من منصات متعددة', 'desc' => 'سحب بيانات الشركات والمهتمين من خرائط جوجل والمواقع المختلفة.'],
                        ['title' => 'تنظيم وتنظيف البيانات تلقائياً', 'desc' => 'إزالة التكرار والأرقام غير الصحيحة لتجهيز قوائم نقية 100%.'],
                        ['title' => 'نظام مصغر لإدارة العملاء (CRM)', 'desc' => 'متابعة العملاء وتصنيفهم وإضافة الملاحظات من لوحة واحدة.'],
                        ['title' => 'تصدير مرن وسريع', 'desc' => 'تصدير البيانات فوراً بصيغ Excel و CSV لتغذية حملاتك.'],
                        ['title' => 'استهداف دقيق لجماهير Meta & Google', 'desc' => 'تجهيز جمهور مخصص Custom Audience لتقليل تكلفة النقرة وزيادة العائد.'],
                    ];
                @endphp

                @foreach($benefits as $b)
                    <div class="sx-benefit">
                        <div class="sx-benefit-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <b>{{ $b['title'] }}</b>
                            <small>{{ $b['desc'] }}</small>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 4: SOURCES
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-sources" id="sx-sources">
        <div class="sx-wrap sx-center">
            <span class="sx-kicker">مصادر البيانات المدعومة</span>
            <h2>تغطية شاملة لأهم منصات الأعمال والتواصل</h2>
            <p class="sx-muted">اجمع البيانات من المصادر التي يتواجد فيها عملاؤك الحقيقيون</p>

            <div class="sx-source-grid">
                <div class="sx-source">
                    <i class="fa-solid fa-building"></i>
                    <b>مواقع الشركات</b>
                    <small>وأدلة الأعمال الكبرى</small>
                </div>
                <div class="sx-source">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <b>المتاجر الإلكترونية</b>
                    <small>بيانات قطاع E-commerce</small>
                </div>
                <div class="sx-source">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <b>خرائط جوجل</b>
                    <small>أنشطة محلية ومتاجر</small>
                </div>
                <div class="sx-source">
                    <i class="fa-brands fa-facebook"></i>
                    <b>Meta Ads</b>
                    <small>تجهيز جمهور مخصص</small>
                </div>
                <div class="sx-source">
                    <i class="fa-brands fa-google"></i>
                    <b>Google Analytics</b>
                    <small>تتبع الحملات والتحويل</small>
                </div>
                <div class="sx-source">
                    <i class="fa-solid fa-circle-plus"></i>
                    <b>تحديثات مستمرة</b>
                    <small>إضافة مصادر جديدة دورياً</small>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 5: PROCESS WORKFLOW
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-process" id="sx-process">
        <div class="sx-wrap sx-center">
            <span class="sx-kicker" style="background: rgba(255,255,255,0.15); color: #6ee7b7;">سير عمل ذكي ومبسط</span>
            <h2>من البيانات الأولية إلى أرباح ومبيعات حقيقية</h2>
            <p class="sx-muted">4 خطوات فقط تفصلك عن إطلاق أقوى حملاتك التسويقية</p>

            <div class="sx-steps">
                <div class="sx-step">
                    <span class="sx-step-num">1</span>
                    <i class="fa-solid fa-earth-americas"></i>
                    <b>استخراج البيانات</b>
                    <p>حدد الدولة والنشاط واجمع الآلاف في دقائق.</p>
                </div>
                <div class="sx-step">
                    <span class="sx-step-num">2</span>
                    <i class="fa-solid fa-filter"></i>
                    <b>تنظيف وفلترة</b>
                    <p>تصفية الأرقام والتكرار وحفظ البيانات المعتمدة.</p>
                </div>
                <div class="sx-step">
                    <span class="sx-step-num">3</span>
                    <i class="fa-solid fa-user-group"></i>
                    <b>إدارة العملاء في CRM</b>
                    <p>متابعة مراحل البيع والملاحظات وفريق العمل.</p>
                </div>
                <div class="sx-step">
                    <span class="sx-step-num">4</span>
                    <i class="fa-solid fa-file-arrow-down"></i>
                    <b>تصدير وإطلاق الحملات</b>
                    <p>تصدير فوري لـ Excel أو رفعه مباشرة للمنصات الإعلانية.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 6: FEATURES & VIDEO
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-section" id="sx-features">
        <div class="sx-wrap sx-feature-grid">
            <div class="sx-feature-copy">
                <span class="sx-kicker">مميزات النظام</span>
                <h2>كل أدوات استهداف العملاء في مكان واحد</h2>
                <p class="sx-muted">وفر مئات الساعات من البحث اليدوي وركز على إتمام الصفقات وتحقيق الأرباح.</p>

                <div class="sx-feature-list">
                    <div class="sx-feature"><i class="fa-solid fa-bullseye"></i> استخراج بيانات دقيقة للحملات</div>
                    <div class="sx-feature"><i class="fa-solid fa-clock"></i> توفير 90% من الوقت والجهد</div>
                    <div class="sx-feature"><i class="fa-solid fa-chart-column"></i> زيادة التحويلات ومعدل الرد</div>
                    <div class="sx-feature"><i class="fa-solid fa-shield-halved"></i> ترخيص دائم مدى الحياة</div>
                    <div class="sx-feature"><i class="fa-solid fa-filter"></i> تصنيف وتقييم العملاء المحتملين</div>
                    <div class="sx-feature"><i class="fa-solid fa-circle-check"></i> تحديثات مستمرة ودعم فني عربي</div>
                </div>
            </div>

            {{-- Video Showcase --}}
            <div class="sx-video" id="sx-video" onclick="scrollToCheckout()">
                <div class="sx-play"><i class="fa-solid fa-play"></i></div>
                <div class="sx-video-caption">استعراض مميزات {{ $product->name }} وسرعة استخراج البيانات</div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 7: REVIEWS & SOCIAL PROOF
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-section sx-reviews">
        <div class="sx-wrap sx-center">
            <span class="sx-kicker">آراء عملائنا</span>
            <h2>ماذا يقول أصحاب الأعمال عن {{ $product->name }}؟</h2>

            @php
                $testimonials = !empty($landingPage->testimonials) && is_array($landingPage->testimonials) ? $landingPage->testimonials : [
                    ['name' => 'م. أحمد الخطيب', 'role' => 'مدير وكالة تسويق رقمي', 'text' => 'ساعدنا النظام في استخراج أكثر من 20 ألف عميل مهتم في أسبوع واحد وتخفيض تكلفة الإعلانات إلى النصف.'],
                    ['name' => 'سارة إبراهيم', 'role' => 'رائدة أعمال ومتجر إلكتروني', 'text' => 'البرنامج سهل جداً في الاستخدام، والتفعيل كان فوري بعد الدفع مباشرة بدون أي تعقيدات.'],
                    ['name' => 'عبدالله القحطاني', 'role' => 'مدير مبيعات B2B', 'text' => 'أفضل استثمار لفريق المبيعات، توفير حقيقي للوقت ودقة ممتازة في تصدير البيانات إلى Excel.'],
                ];
            @endphp

            <div class="sx-review-grid">
                @foreach($testimonials as $rev)
                    <article class="sx-review">
                        <div class="sx-stars">★★★★★</div>
                        <p>“{{ $rev['text'] }}”</p>
                        <div class="sx-person">
                            <div class="sx-avatar"><i class="fa-solid fa-user-check"></i></div>
                            <div>
                                <b>{{ $rev['name'] }}</b>
                                <small>{{ $rev['role'] }}</small>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 8: PRICE & 3D BOX ART
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-price" id="sx-price">
        <div class="sx-wrap sx-price-grid">
            
            <div class="sx-box-art">
                <div>
                    <strong>{{ strtoupper(substr($product->name, 0, 1)) }}</strong>
                    <b>{{ $product->name }}</b>
                    <span>{{ config('app.name', 'OX TECH') }}</span>
                </div>
            </div>

            <div class="sx-price-copy">
                <span class="sx-kicker" style="background: rgba(255,255,255,0.15); color: #6ee7b7;">عرض التفعيل الفوري</span>
                <h2>احصل على نسختك اليوم بخصم خاص</h2>
                <p>ترخيص رسمي دائم مدى الحياة يشمل التحديثات القادمة ودعم التثبيت الفني.</p>

                <div class="sx-price-card">
                    <div class="sx-price-line">
                        <div>
                            <span class="sx-old">{{ number_format($oldPrice, 2) }} {{ $product->currency }}</span><br>
                            <span class="sx-price-main">{{ number_format($effectivePrice, 2) }} {{ $product->currency }}</span>
                        </div>
                        <span class="sx-discount">خصم {{ $discountPct }}%</span>
                    </div>

                    <a class="sx-btn" href="#sx-checkout">
                        <i class="fa-solid fa-bolt"></i>
                        <span>اطلب الآن واستلم الترخيص فوراً</span>
                    </a>
                </div>

                <div class="sx-assurances">
                    <span><i class="fa-solid fa-bolt"></i> تفعيل وتحميل فوري</span>
                    <span><i class="fa-solid fa-headset"></i> دعم فني مخصص 24/7</span>
                    <span><i class="fa-solid fa-arrows-rotate"></i> تحديثات دورية مجانية</span>
                    <span><i class="fa-solid fa-shield-halved"></i> ضمان استرجاع 100%</span>
                </div>

                <div class="sx-best">أفضل<br>قيمة</div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 9: DEDICATED DIRECT CHECKOUT FORM (PaySky Gateway)
         ══════════════════════════════════════════════════════════ --}}
    <section id="sx-checkout">
        <div class="sx-wrap">
            <div class="checkout-box-inner">
                <div class="checkout-badge-pill">
                    ⚡ طلب مباشر وتفعيل فوري آمن
                </div>

                <div style="text-align: center; margin-bottom: 22px; margin-top: 6px;">
                    <h3 style="font-size: 24px; font-weight: 900; color: #0f172a; margin-bottom: 6px;">
                        املأ بياناتك للشراء واستلام الترخيص
                    </h3>
                    <p style="font-size: 13.5px; color: var(--muted); margin: 0;">
                        تشفير بنكي 256-bit عبر بوابة PaySky المعتمدة وتوليد مفتاح الترخيص آلياً
                    </p>
                </div>

                <div class="order-summary-strip">
                    <div>
                        <div style="font-weight: 800; font-size: 14px; color: #0f172a;">{{ $product->name }} (ترخيص دائم)</div>
                        <div style="font-size: 12px; color: #059669; font-weight: 700;">✓ تفعيل رقمي فوري + رابط التحميل المباشر</div>
                    </div>
                    <div style="text-align: left;">
                        <span style="font-size: 22px; font-weight: 900; color: #065f46;">{{ number_format($effectivePrice, 2) }}</span>
                        <span style="font-size: 12px; font-weight: 700; color: #065f46;">{{ $product->currency }}</span>
                    </div>
                </div>

                <form id="salesCheckoutForm" onsubmit="handleSalesCheckout(event)">
                    @csrf
                    <input type="hidden" id="spProductId" value="{{ $product->id }}">
                    <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
                    <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
                    <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">

                    <div class="checkout-form-grid">
                        <div>
                            <label class="form-label-custom">الاسم بالكامل أو اسم المنشأة *</label>
                            <input type="text" id="spCustName" required placeholder="مثال: أحمد محمد" class="form-input-custom">
                        </div>

                        <div>
                            <label class="form-label-custom">البريد الإلكتروني (لاستلام الترخيص والملف فوراً) *</label>
                            <input type="email" id="spCustEmail" required placeholder="name@company.com" class="form-input-custom" style="direction: ltr;">
                        </div>

                        <div>
                            <label class="form-label-custom">رقم الهاتف أو الواتساب *</label>
                            <input type="tel" id="spCustPhone" required placeholder="05XXXXXXXX أو 010XXXXXXXX" class="form-input-custom" style="direction: ltr;">
                        </div>

                        <button type="submit" id="btnSubmitSalesOrder" class="sx-btn" style="width: 100%; padding: 16px; font-size: 16px; margin-top: 10px;">
                            <span>إتمام الشراء والدفع الآمن الآن ←</span>
                        </button>

                        <div style="text-align: center; font-size: 12px; color: #64748b; margin-top: 8px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fa-solid fa-lock" style="color: var(--green);"></i>
                            <span>دفع إلكتروني مشفر عبر <strong>PaySky Omni Payments</strong></span>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 10: FAQ & WHATSAPP SUPPORT (No Footer)
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-section" id="sx-faq">
        <div class="sx-wrap sx-faq-grid">
            
            <div>
                <span class="sx-kicker">الأسئلة الشائعة</span>
                <h2>كل ما تحتاج معرفته عن البرنامج</h2>

                @php
                    $faqs = !empty($landingPage->faq_items) && is_array($landingPage->faq_items) ? $landingPage->faq_items : [
                        ['question' => 'كيف أستلم البرنامج ومفتاح الترخيص؟', 'answer' => 'فور إتمام الدفع ستنتقل مباشرة لصفحة التنزيل وسيصلك إيميل فوري يحتوي على مفتاح الترخيص وبياناتك.'],
                        ['question' => 'هل توجد أي مصاريف تجديد أو اشتراك شهري؟', 'answer' => 'لا، الترخيص دائم مدى الحياة وبدون أي رسوم خفية أو تجديد إجباري.'],
                        ['question' => 'هل يعمل البرنامج على نظام Windows؟', 'answer' => 'نعم، يعمل بكفاءة عالية على Windows 10 و 11 ولا يتطلب مواصفات تشغيل خارقة.'],
                        ['question' => 'هل يمكن تصدير البيانات إلى Excel؟', 'answer' => 'نعم، بضغطة زر واحدة يمكنك تصدير كافة القوائم والبيانات بصيغ Excel أو CSV جاهزة للاستخدام.'],
                        ['question' => 'هل أحصل على دعم فني للمساعدة في التثبيت؟', 'answer' => 'بالتأكيد، فريقنا الفني متاح لمساعدتك خطوة بخطوة عبر الواتساب وتقديم التوجيه اللازم.'],
                    ];
                @endphp

                <div class="sx-faq-list">
                    @foreach($faqs as $faq)
                        <details class="sx-faq">
                            <summary>{{ $faq['question'] }}</summary>
                            <p>{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>

            {{-- Direct WhatsApp Support Box --}}
            <aside class="sx-support" id="sx-contact">
                <div class="sx-chat-icon">
                    <i class="fa-solid fa-comment-dots"></i>
                </div>
                <h3>هل لديك أي استفسار قبل الشراء؟</h3>
                <p>فريق الدعم الفني جاهز للإجابة على جميع تساؤلاتك ومساعدتك على مدار الساعة.</p>
                <a class="sx-btn" href="https://wa.me/{{ $waPhone }}?text={{ urlencode('مرحباً، أود الاستفسار عن عرض برنامج ' . $product->name) }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>تحدث معنا عبر الواتساب</span>
                </a>
            </aside>

        </div>
    </section>

</div>

{{-- ══════════════════════════════════════════════════════════
     SCRIPTS & GATEWAY INTEGRATION
     ══════════════════════════════════════════════════════════ --}}
<script>
function scrollToCheckout() {
    const el = document.getElementById('sx-checkout');
    if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
    }
}

// PaySky Async Script Loader
function loadPaySkyAsync(scriptUrl) {
    return new Promise(function(resolve, reject) {
        if (typeof Lightbox !== 'undefined' && typeof Lightbox.Checkout !== 'undefined') {
            resolve(true);
            return;
        }
        const existingScript = document.querySelector('script[src*="paysky"]');
        if (existingScript) {
            existingScript.onload = () => resolve(true);
            existingScript.onerror = () => resolve(false);
            return;
        }
        const script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = scriptUrl;
        script.async = true;
        script.onload = () => resolve(true);
        script.onerror = () => resolve(false);
        document.head.appendChild(script);
    });
}

// Log Gateway Errors
function logGatewayError(ref, message, details, step, status) {
    try {
        fetch('{{ route("api.payment-logs.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                merchant_reference: ref,
                gateway_name: 'paysky',
                step: step,
                status: status,
                error_message: message,
                details: details
            })
        }).catch(e => console.warn('Payment log failed:', e));
    } catch(err) {
        console.warn('Logging exception:', err);
    }
}

// Checkout Form Submission
async function handleSalesCheckout(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmitSalesOrder');
    btn.disabled = true;
    btn.innerHTML = '<span><i class="fa-solid fa-spinner fa-spin"></i> جاري فتح نافذة الدفع الآمنة...</span>';

    // Meta Pixel InitiateCheckout Event
    if (typeof fbq === 'function') {
        fbq('track', 'InitiateCheckout', {
            content_name: '{{ addslashes($product->name) }}',
            content_ids: ['{{ $product->id }}'],
            content_type: 'product',
            value: {{ $effectivePrice }},
            currency: '{{ $product->currency }}'
        });
    }

    const payload = {
        _token: '{{ csrf_token() }}',
        product_id: document.getElementById('spProductId').value,
        customer_name: document.getElementById('spCustName').value,
        customer_email: document.getElementById('spCustEmail').value,
        customer_phone: document.getElementById('spCustPhone').value,
        utm_source: '{{ request('utm_source') }}',
        utm_medium: '{{ request('utm_medium') }}',
        utm_campaign: '{{ request('utm_campaign') }}',
    };

    try {
        const response = await fetch('{{ route("checkout.initiate") }}', {
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
            const scriptLoaded = await loadPaySkyAsync(data.paysky.ScriptUrl);

            if (scriptLoaded && typeof Lightbox !== 'undefined' && typeof Lightbox.Checkout !== 'undefined') {
                Lightbox.Checkout.configure = {
                    MID: data.paysky.MID,
                    TID: data.paysky.TID,
                    AmountTrxn: data.paysky.AmountTrxn,
                    MerchantReference: data.paysky.MerchantReference,
                    TrxDateTime: data.paysky.TrxDateTime,
                    SecureHash: data.paysky.SecureHash,
                    completeCallback: function () {
                        window.location.href = data.callback_url + '?MerchantReference=' + encodeURIComponent(data.paysky.MerchantReference) + '&Success=true';
                    },
                    errorCallback: function (error) {
                        const errMsg = (error && (error.Message || error.errorMessage || error.message)) ? (error.Message || error.errorMessage || error.message) : 'خطأ غير محدد من البوابة';
                        logGatewayError(data.paysky.MerchantReference, errMsg, error, 'paysky_error_callback', 'failed');
                        alert('حدث خطأ أثناء معالجة الدفع: ' + errMsg);
                        btn.disabled = false;
                        btn.innerHTML = '<span>إتمام الشراء والدفع الآمن الآن ←</span>';
                    },
                    cancelCallback: function () {
                        logGatewayError(data.paysky.MerchantReference, 'تم إغلاق نافذة الدفع', {}, 'lightbox_cancelled', 'cancelled');
                        btn.disabled = false;
                        btn.innerHTML = '<span>إتمام الشراء والدفع الآمن الآن ←</span>';
                    }
                };
                Lightbox.Checkout.showLightbox();
            } else {
                window.location.href = data.callback_url + '?MerchantReference=' + encodeURIComponent(data.paysky.MerchantReference) + '&Success=true';
            }
        } else {
            logGatewayError('', data.message || 'بيانات غير مكتملة', data, 'checkout_initiate_failed', 'failed');
            alert(data.message || 'حدث خطأ في النظام. يرجى المحاولة لاحقاً.');
            btn.disabled = false;
            btn.innerHTML = '<span>إتمام الشراء والدفع الآمن الآن ←</span>';
        }
    } catch (err) {
        console.error(err);
        alert('حدث خطأ بالاتصال. يرجى مراجعة الإنترنت أو التواصل معنا عبر الواتساب.');
        btn.disabled = false;
        btn.innerHTML = '<span>إتمام الشراء والدفع الآمن الآن ←</span>';
    }
}
</script>

{{-- Custom Body Scripts --}}
@if(!empty($landingPage->custom_body_scripts))
    {!! $landingPage->custom_body_scripts !!}
@endif

</body>
</html>
