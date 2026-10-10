@extends('layouts.app')

@php
    $effectivePrice = (float) ($product->sale_price ?: $product->price);
    $oldPrice = $product->sale_price ? (float) $product->price : round($effectivePrice * 2, 0);
    $discountPct = $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 50;
    $productCurrency = strtoupper($product->currency ?: 'USD');
    $waPhone = '201008616682';
    $pageTitle = 'اجمع بيانات عملائك من كل مكان | ' . ($product->name ?: 'Scrip OX') . ' — OX TECH';
    $pageDesc = $landingPage->subheadline ?: 'إضافة قوية من Ox Tech لاستخراج البيانات من المواقع وتنظيمها في CRM مصغّر جاهز للاستخدام.';
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)

@push('styles')
    <!-- Google Fonts & Font Awesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- External CSS urls if specified in admin -->
    @if(!empty($landingPage->external_css_urls))
        @foreach(explode("\n", str_replace("\r", "", $landingPage->external_css_urls)) as $cssUrl)
            @if(trim($cssUrl))
                <link rel="stylesheet" href="{{ trim($cssUrl) }}">
            @endif
        @endforeach
    @endif

    <!-- Meta Pixel & Tracking Script Tags -->
    @php
        $gaId = !empty($landingPage->google_analytics_id) ? $landingPage->google_analytics_id : 'AW-17984061932';
        $pixelId = !empty($landingPage->meta_pixel_id) ? $landingPage->meta_pixel_id : '1907678277306091';
    @endphp
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $gaId }}');
    </script>
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
            currency: '{{ $productCurrency }}'
        });
    </script>

    @if(!empty($landingPage->custom_head_scripts))
        {!! $landingPage->custom_head_scripts !!}
    @endif

    <style>
        /* ═══════════════════════════════════════════════════════════════════
           Scrip OX Luxury Design System — Matching Image 2 Exactly
           ═══════════════════════════════════════════════════════════════════ */
        #scripox-page {
            --green: #087b68;
            --deep:  #043e36;
            --ink:   #10231f;
            --muted: #71807c;
            --mint:  #eaf8f5;
            --line:  #e4eeeb;
            --yellow:#ffd12f;
            font-family: 'Cairo', sans-serif;
            color: var(--ink);
            direction: rtl;
            text-align: right;
            line-height: 1.65;
            overflow-x: hidden;
            background: #ffffff;
            font-size: 15px;
            padding-top: 80px; /* Offset for fixed site header */
        }

        #scripox-page * {
            box-sizing: border-box;
        }

        #scripox-page a {
            color: inherit;
            text-decoration: none;
        }

        #scripox-page .sx-wrap {
            width: min(1140px, calc(100% - 42px));
            margin: auto;
        }

        #scripox-page h1,
        #scripox-page h2,
        #scripox-page h3,
        #scripox-page p {
            margin-top: 0;
        }

        #scripox-page h2 {
            font-size: clamp(24px, 3vw, 35px);
            line-height: 1.35;
            font-weight: 900;
            margin-bottom: 10px;
        }

        #scripox-page .sx-muted {
            color: var(--muted);
        }

        #scripox-page .sx-kicker {
            display: inline-flex;
            padding: 4px 14px;
            border-radius: 30px;
            background: #dff5ef;
            color: var(--green);
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        #scripox-page .sx-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 12px 22px;
            border-radius: 12px;
            background: var(--yellow);
            color: #16231f;
            font-weight: 900;
            font-size: 14px;
            box-shadow: 0 6px 18px rgba(255, 209, 47, 0.35);
            transition: transform 0.2s ease, filter 0.2s ease;
            cursor: pointer;
            border: none;
        }

        #scripox-page .sx-btn:hover {
            transform: translateY(-2px);
            filter: brightness(0.96);
        }

        #scripox-page .sx-btn-outline {
            background: transparent;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: none;
        }

        #scripox-page .sx-btn-outline:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: #ffffff;
        }

        #scripox-page .sx-section {
            padding: 60px 0;
            background: #ffffff;
        }

        #scripox-page .sx-center {
            text-align: center;
        }

        /* ─── 1. HERO SECTION ─── */
        #scripox-page .sx-hero {
            position: relative;
            color: #ffffff;
            background: radial-gradient(ellipse at 72% 25%, rgba(8, 123, 104, 0.42), transparent 38%),
                        linear-gradient(120deg, #031b19, #043b34 65%, #052421);
            padding: 24px 0 45px;
            isolation: isolate;
        }

        #scripox-page .sx-hero:before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            opacity: 0.16;
            background-image: linear-gradient(30deg, transparent 48%, #3cc5a8 49%, transparent 50%),
                              linear-gradient(150deg, transparent 48%, #3cc5a8 49%, transparent 50%);
            background-size: 90px 90px;
            mask-image: linear-gradient(90deg, #000, transparent 65%);
        }

        #scripox-page .sx-nav {
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            margin-bottom: 28px;
        }

        #scripox-page .sx-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 19px;
            font-weight: 900;
            letter-spacing: 0.5px;
            color: #ffffff;
        }

        #scripox-page .sx-brand i {
            font-size: 24px;
            color: #16af8e;
        }

        #scripox-page .sx-navlinks {
            display: flex;
            gap: 26px;
            font-size: 13px;
            color: #e3eeeb;
        }

        #scripox-page .sx-navlinks a {
            transition: color 0.2s ease;
        }

        #scripox-page .sx-navlinks a:hover {
            color: #39d4ae;
        }

        #scripox-page .sx-nav .sx-btn {
            padding: 8px 16px;
            font-size: 12.5px;
            border-radius: 10px;
        }

        .sx-hero-grid {
            display: grid;
            grid-template-columns: 1fr 1.05fr;
            gap: 38px;
            align-items: center;
            min-height: 340px;
        }

        #scripox-page .sx-hero-copy h1 {
            font-size: clamp(30px, 4vw, 48px);
            font-weight: 900;
            line-height: 1.25;
            margin: 0 0 14px;
            color: #ffffff;
        }

        #scripox-page .sx-hero-copy h1 em {
            font-style: normal;
            color: #26bea0;
            display: block;
            font-family: Arial, sans-serif;
            direction: ltr;
            text-align: right;
            font-size: 1.15em;
        }

        #scripox-page .sx-hero-copy p {
            color: #d6e5e1;
            max-width: 480px;
            margin-bottom: 18px;
            font-size: 14.5px;
            line-height: 1.7;
        }

        #scripox-page .sx-checks {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            margin: 16px 0 24px;
            font-size: 13px;
        }

        #scripox-page .sx-checks span {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #f0fdf9;
        }

        #scripox-page .sx-checks i {
            color: #39d4ae;
            font-size: 14px;
        }

        #scripox-page .sx-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ─── Hero Visual Laptop & Floats ─── */
        #scripox-page .sx-visual {
            position: relative;
            min-height: 310px;
            display: grid;
            place-items: center;
            width: 100%;
        }

        #scripox-page .sx-laptop {
            width: 100%;
            max-width: 555px;
            padding: 10px;
            background: linear-gradient(135deg, #101d1b, #62716d);
            border: 2px solid #91a39e;
            border-radius: 15px 15px 7px 7px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.55);
            transform: perspective(900px) rotateY(-8deg) rotateX(2deg);
            transition: transform 0.4s ease;
        }

        #scripox-page .sx-laptop:hover {
            transform: perspective(900px) rotateY(-2deg) rotateX(0deg);
        }

        #scripox-page .sx-laptop-screen {
            height: 268px;
            border-radius: 7px;
            background: #f6faf9;
            display: flex;
            overflow: hidden;
            color: #20332e;
            font: 11px Arial, sans-serif;
            direction: ltr;
            text-align: left;
        }

        #scripox-page .sx-dash-side {
            width: 24%;
            background: #062c28;
            color: #e8f5f1;
            padding: 13px 9px;
            flex-shrink: 0;
        }

        #scripox-page .sx-dash-logo {
            font-weight: bold;
            color: #32c6a5;
            font-size: 12.5px;
            margin-bottom: 18px;
        }

        #scripox-page .sx-dash-item {
            padding: 7px 3px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 9px;
            color: #c6dad4;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        #scripox-page .sx-dash-item i {
            width: 15px;
            color: #27b795;
            font-size: 10px;
        }

        #scripox-page .sx-dash-main {
            flex: 1;
            padding: 12px 14px;
            background: #f8fbfa;
            overflow: hidden;
        }

        #scripox-page .sx-dash-top {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-bottom: 12px;
            font-size: 11.5px;
            color: #102a25;
        }

        #scripox-page .sx-statgrid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 7px;
        }

        #scripox-page .sx-stat {
            background: #ffffff;
            padding: 9px 8px;
            border-radius: 7px;
            border: 1px solid #e6eeeb;
            color: #52635e;
            font-size: 9.5px;
        }

        .sx-stat b {
            display: block;
            font-size: 17px;
            color: #102a25;
            margin-top: 2px;
            line-height: 1.2;
        }

        .sx-table {
            margin-top: 10px;
            background: #ffffff;
            border: 1px solid #e6eeeb;
            border-radius: 6px;
            padding: 5px;
        }

        .sx-row {
            display: grid;
            grid-template-columns: 1.2fr 1fr .8fr .7fr;
            gap: 4px;
            padding: 6px 4px;
            border-bottom: 1px solid #edf2f0;
            font-size: 8.5px;
            align-items: center;
        }

        .sx-row:last-child {
            border-bottom: none;
        }

        .sx-pill {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 9px;
            background: #d9f4eb;
            color: #07846d;
            font-weight: bold;
            font-style: normal;
            font-size: 7.5px;
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
            background: #ffffff;
            color: #1c302b;
            border: 1px solid #e7f0ed;
            border-radius: 13px;
            padding: 10px 14px;
            box-shadow: 0 12px 32px rgba(0, 30, 25, 0.22);
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 9px;
            z-index: 2;
            transition: transform 0.25s ease;
        }

        #scripox-page .sx-float:hover {
            transform: translateY(-3px);
        }

        #scripox-page .sx-float i {
            font-size: 20px;
            color: var(--green);
        }

        #scripox-page .sx-float.one {
            top: 5px;
            left: -4px;
        }

        #scripox-page .sx-float.two {
            right: -12px;
            top: 42%;
        }

        #scripox-page .sx-float.three {
            right: -5px;
            bottom: -2px;
        }

        /* ─── 2. METRICS SECTION (Clean White Strip) ─── */
        #scripox-page .sx-metrics {
            padding: 18px 0;
            background: #ffffff;
            border-bottom: 1px solid var(--line);
        }

        #scripox-page .sx-metric-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            align-items: center;
        }

        #scripox-page .sx-metric {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border-left: 1px solid #dce8e4;
            padding: 6px 14px;
        }

        #scripox-page .sx-metric:last-child {
            border-left: 0;
        }

        #scripox-page .sx-metric i {
            font-size: 24px;
            color: var(--green);
        }

        #scripox-page .sx-metric b {
            display: block;
            font-size: 22px;
            line-height: 1.2;
            color: #10231f;
        }

        #scripox-page .sx-metric small {
            color: var(--muted);
            font-size: 11.5px;
        }

        /* ─── 3. PRODUCT & CRM MOCK SECTION ─── */
        #scripox-page .sx-product {
            padding: 55px 0 65px;
            background: #ffffff;
        }

        .sx-product-grid {
            display: grid;
            grid-template-columns: 1fr .9fr;
            gap: 45px;
            align-items: center;
        }

        #scripox-page .sx-product-copy > p {
            font-size: 14.5px;
            color: var(--muted);
            margin: 10px 0 20px;
            line-height: 1.7;
        }

        .sx-benefit {
            display: grid;
            grid-template-columns: 40px 1fr;
            gap: 12px;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #edf2f0;
        }

        .sx-benefit:last-child {
            border: 0;
        }

        .sx-benefit-icon {
            height: 38px;
            width: 38px;
            border-radius: 10px;
            background: #e7f6f2;
            display: grid;
            place-items: center;
            color: var(--green);
            font-size: 17px;
        }

        .sx-benefit b {
            display: block;
            font-size: 14px;
            color: #10231f;
        }

        .sx-benefit small {
            font-size: 11.5px;
            color: var(--muted);
        }

        #scripox-page .sx-product-mock {
            min-height: 355px;
            position: relative;
            padding: 15px 0;
            width: 100%;
        }

        .sx-window {
            position: absolute;
            left: 4%;
            top: 14px;
            width: 88%;
            height: 266px;
            background: #ffffff;
            border: 1px solid #dce8e4;
            border-radius: 13px;
            box-shadow: 0 18px 45px rgba(24, 76, 61, 0.12);
            overflow: hidden;
            transform: rotate(-4deg);
        }

        .sx-window-head {
            height: 34px;
            background: #f7fbfa;
            border-bottom: 1px solid #e9f0ee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 12px;
            font: 10px Arial;
            color: #61736e;
        }

        .sx-window-body {
            display: flex;
            height: calc(100% - 34px);
            font: 9px Arial;
            direction: ltr;
            text-align: left;
        }

        .sx-window-nav {
            width: 23%;
            background: #073d34;
            color: #e5f4ef;
            padding: 10px 7px;
            flex-shrink: 0;
        }

        .sx-window-nav div {
            padding: 7px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 8.5px;
        }

        .sx-window-content {
            flex: 1;
            padding: 12px;
            background: #fbfdfc;
        }

        .sx-contact {
            position: absolute;
            right: 0;
            bottom: 22px;
            width: 55%;
            background: #ffffff;
            padding: 13px;
            border: 1px solid #deebe7;
            border-radius: 12px;
            box-shadow: 0 14px 38px rgba(24, 76, 61, 0.14);
            z-index: 2;
        }

        .sx-contact-title {
            font-weight: 800;
            font-size: 11.5px;
            border-bottom: 1px solid var(--line);
            padding-bottom: 7px;
            margin-bottom: 7px;
            color: #10231f;
        }

        .sx-contact-row {
            font-size: 10px;
            padding: 3px 0;
            color: #60716c;
            direction: ltr;
            text-align: right;
        }

        .sx-contact-tags {
            display: flex;
            gap: 4px;
            margin: 6px 0;
        }

        .sx-contact-tags span {
            border-radius: 9px;
            background: #e1f4ed;
            color: #08816a;
            padding: 3px 6px;
            font-size: 8px;
            font-weight: 700;
        }

        .sx-filter {
            position: absolute;
            left: -3px;
            bottom: 6px;
            width: 46%;
            background: #ffffff;
            padding: 12px;
            border: 1px solid #dfebe7;
            border-radius: 12px;
            box-shadow: 0 12px 35px rgba(24, 76, 61, 0.14);
            z-index: 2;
        }

        .sx-filter b {
            display: block;
            font-size: 11.5px;
            margin-bottom: 7px;
            color: #10231f;
        }

        .sx-select {
            border: 1px solid #e6eeeb;
            border-radius: 6px;
            padding: 5px;
            margin-top: 5px;
            font-size: 9px;
            color: #50635d;
            display: flex;
            justify-content: space-between;
        }

        .sx-filter-btn {
            display: block;
            background: var(--green);
            color: #ffffff !important;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            margin-top: 7px;
            font-size: 9px;
            font-weight: 700;
        }

        .sx-note {
            position: absolute;
            bottom: -3px;
            left: 37%;
            color: var(--green);
            font-weight: 800;
            font-size: 12.5px;
            transform: rotate(-5deg);
            z-index: 3;
        }

        /* ─── 4. DATA SOURCES SECTION ─── */
        #scripox-page .sx-sources {
            padding: 34px 0;
            background: linear-gradient(100deg, #effaf8, #f6fbfa);
            border-radius: 22px;
            margin: 0 auto;
            width: min(1200px, calc(100% - 24px));
        }

        .sx-source-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 12px;
            margin-top: 22px;
        }

        .sx-source {
            min-height: 108px;
            background: #ffffff;
            border: 1px solid #e4efec;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 4px;
            padding: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .sx-source:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(8, 123, 104, 0.08);
        }

        .sx-source i {
            font-size: 24px;
            color: var(--green);
        }

        .sx-source .fa-google {
            color: #e9a300;
        }

        .sx-source .fa-facebook {
            color: #1877f2;
        }

        .sx-source b {
            font-size: 12px;
            color: #10231f;
        }

        .sx-source small {
            font-size: 9.5px;
            color: var(--muted);
        }

        /* ─── 5. PROCESS WORKFLOW ─── */
        #scripox-page .sx-process {
            margin-top: 25px;
            padding: 44px 0 50px;
            background: radial-gradient(ellipse at center, #0c6356, #04372f 70%, #032824);
            color: #ffffff;
            border-radius: 28px;
            width: min(1200px, calc(100% - 24px));
            margin-left: auto;
            margin-right: auto;
        }

        .sx-process .sx-muted {
            color: #c1d9d2;
        }

        .sx-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 26px;
            margin-top: 28px;
        }

        .sx-step {
            position: relative;
            background: #ffffff;
            color: var(--ink);
            border-radius: 14px;
            padding: 30px 14px 18px;
            text-align: center;
            min-height: 150px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .sx-step-num {
            position: absolute;
            top: -17px;
            left: calc(50% - 17px);
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #0bb38f;
            color: #ffffff;
            border: 3px solid #dcfff5;
            font-weight: 900;
            font-size: 14px;
            display: grid;
            place-items: center;
        }

        .sx-step i {
            display: block;
            font-size: 24px;
            color: var(--green);
            margin-bottom: 8px;
        }

        .sx-step b {
            display: block;
            font-size: 14px;
            color: #10231f;
        }

        .sx-step p {
            font-size: 11px;
            color: var(--muted);
            margin: 6px 0 0;
            line-height: 1.5;
        }

        .sx-step:not(:last-child):after {
            content: '←';
            position: absolute;
            left: -23px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 22px;
            color: #b9e7dc;
            font-weight: bold;
        }

        /* ─── 6. FEATURES / VIDEO SHOWCASE ─── */
        .sx-feature-grid {
            display: grid;
            grid-template-columns: 0.95fr 1.05fr;
            gap: 38px;
            align-items: center;
        }

        .sx-video {
            height: 270px;
            background: linear-gradient(145deg, #052923, #0b6153);
            border: 1px solid #b7ded5;
            border-radius: 16px;
            position: relative;
            display: grid;
            place-items: center;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(12, 81, 64, 0.15);
        }

        .sx-video:before {
            content: 'Scrip OX · لوحة استخراج وإدارة البيانات';
            position: absolute;
            inset: 18px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 9px;
            color: #d8f8ef;
            padding: 14px;
            font-weight: 700;
            font-size: 12px;
            opacity: 0.7;
        }

        .sx-play {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #ffffff;
            color: var(--green);
            font-size: 22px;
            z-index: 1;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.35);
            transition: transform 0.2s ease;
            cursor: pointer;
        }

        .sx-play:hover {
            transform: scale(1.08);
        }

        .sx-video-caption {
            position: absolute;
            bottom: 14px;
            color: #ffffff;
            font-size: 11.5px;
            font-weight: 700;
        }

        .sx-feature-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 20px;
        }

        .sx-feature {
            display: flex;
            gap: 9px;
            align-items: center;
            padding: 11px;
            border: 1px solid #e8f0ee;
            border-radius: 10px;
            font-size: 12.5px;
            background: #ffffff;
        }

        .sx-feature i {
            color: var(--green);
            font-size: 16px;
        }

        /* ─── 7. REVIEWS & TESTIMONIALS ─── */
        .sx-reviews {
            padding-top: 20px;
            background: #ffffff;
        }

        .sx-reviews-slider-wrap {
            position: relative;
            width: 100%;
        }

        .sx-review-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 22px;
            text-align: right;
        }

        .sx-review {
            padding: 20px;
            border: 1px solid #e6efec;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 7px 20px rgba(13, 81, 64, 0.05);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .sx-review p {
            font-size: 12.5px;
            color: #687873;
            min-height: 52px;
            line-height: 1.6;
        }

        .sx-review b {
            font-size: 13px;
            color: #10231f;
        }

        .sx-review small {
            display: block;
            color: #86938f;
            font-size: 10.5px;
        }

        .sx-stars {
            color: #efb820;
            letter-spacing: 2px;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .sx-person {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 14px;
        }

        .sx-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #e4f3ef;
            color: var(--green);
            font-size: 18px;
            flex-shrink: 0;
        }

        /* Mobile controls for reviews slider */
        .sx-reviews-controls {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-top: 20px;
        }

        .sx-rev-nav-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid #d0e4df;
            background: #ffffff;
            color: #0b6153;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(13, 81, 64, 0.08);
            transition: all 0.2s ease;
            -webkit-tap-highlight-color: transparent;
        }

        .sx-rev-nav-btn:hover,
        .sx-rev-nav-btn:active {
            background: #0b6153;
            color: #ffffff;
            border-color: #0b6153;
            transform: scale(1.05);
        }

        .sx-rev-dots {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .sx-rev-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #cbd5e1;
            border: none;
            padding: 0;
            cursor: pointer;
            transition: all 0.25s ease;
            -webkit-tap-highlight-color: transparent;
        }

        .sx-rev-dot.active {
            background: #0b6153;
            width: 24px;
            border-radius: 10px;
        }

        /* ─── 8. PRICING & 3D BOX ─── */
        #scripox-page .sx-price {
            background: radial-gradient(ellipse at 20% 20%, #18846e, #064237 58%, #032a26);
            border-radius: 25px;
            color: #ffffff;
            padding: 34px 0;
            margin: 25px auto 15px;
            width: min(1200px, calc(100% - 24px));
            position: relative;
            overflow: hidden;
        }

        .sx-price:before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.03)),
                        repeating-linear-gradient(0deg, transparent 0 38px, rgba(255, 255, 255, 0.05) 39px),
                        repeating-linear-gradient(90deg, transparent 0 38px, rgba(255, 255, 255, 0.04) 39px);
            mask-image: linear-gradient(90deg, #000, transparent 55%);
        }

        .sx-price-grid {
            position: relative;
            display: grid;
            grid-template-columns: 0.8fr 1.2fr;
            gap: 40px;
            align-items: center;
        }

        .sx-box-art {
            height: 220px;
            width: 180px;
            margin: auto;
            background: linear-gradient(140deg, #0b211e, #071310);
            border: 2px solid #55b8a0;
            border-radius: 12px;
            box-shadow: 12px 13px 0 #021b18;
            transform: perspective(500px) rotateY(-10deg);
            display: grid;
            place-items: center;
            text-align: center;
            color: #ffffff;
            position: relative;
        }

        .sx-box-art strong {
            font: 900 34px Arial;
            color: #1ec09b;
            display: block;
        }

        .sx-box-art span {
            font-size: 11.5px;
            color: #94a3b8;
        }

        .sx-best {
            position: absolute;
            top: -9px;
            left: 11%;
            background: var(--yellow);
            color: #26312d;
            width: 66px;
            height: 66px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            text-align: center;
            font-weight: 900;
            font-size: 12px;
            line-height: 1.2;
            transform: rotate(-10deg);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
            z-index: 2;
        }

        .sx-price-copy h2 {
            margin-bottom: 6px;
            color: #ffffff;
        }

        .sx-price-copy > p {
            color: #d3e8e1;
            font-size: 13.5px;
            margin-bottom: 12px;
        }

        .sx-price-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 14px 18px;
            color: var(--ink);
            margin: 15px 0 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .sx-price-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .sx-price-main {
            font-size: 28px;
            font-weight: 900;
            color: #043e36;
        }

        .sx-old {
            text-decoration: line-through;
            color: #a2aaa7;
            font-size: 14px;
        }

        .sx-discount {
            background: #dff5ec;
            color: #06725f;
            padding: 4px 10px;
            border-radius: 7px;
            font-weight: 800;
            font-size: 12.5px;
        }

        .sx-price-card .sx-btn {
            width: 100%;
            margin-top: 10px;
            padding: 14px;
            font-size: 15px;
        }

        .sx-assurances {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
            color: #e5f4ef;
            font-size: 10.5px;
        }

        .sx-assurances span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .sx-assurances i {
            color: #45d8b3;
        }

        /* ─── 9. DIRECT CHECKOUT FORM (PaySky Gateway) ─── */
        #sx-checkout {
            padding: 40px 0 20px;
            background: #ffffff;
        }

        .checkout-box-inner {
            max-width: 640px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #dce8e4;
            border-radius: 20px;
            padding: 30px 28px;
            box-shadow: 0 18px 45px rgba(24, 76, 61, 0.09);
        }

        .checkout-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #dff5ef;
            color: var(--green);
            padding: 4px 14px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        /* Currency Toggle Switcher */
        .sp-currency-toggle-wrapper {
            margin-bottom: 16px;
        }

        .sp-currency-label {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sp-currency-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .sp-currency-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 14px;
            border-radius: 12px;
            border: 2px solid #e2edea;
            background: #f8fafc;
            color: #334155;
            font-size: 13.5px;
            font-weight: 700;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sp-currency-btn:hover {
            border-color: #38b2ac;
            background: #ffffff;
        }

        .sp-currency-btn.active {
            border-color: var(--green);
            background: #eaf8f5;
            color: var(--deep);
            box-shadow: 0 4px 14px rgba(8, 123, 104, 0.15);
        }

        .sp-curr-badge {
            background: var(--green);
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 99px;
        }

        /* Order Summary Strip */
        .order-summary-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f6faf9;
            border: 1px solid #e2edea;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 18px;
        }

        /* Promo Code Section */
        .sp-promo-section {
            margin-bottom: 18px;
            background: #fcfdfd;
            border: 1px solid #e2edea;
            border-radius: 12px;
            padding: 14px;
        }

        .sp-promo-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .sp-promo-input-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--green);
            font-size: 14px;
        }

        .sp-promo-input {
            width: 100%;
            padding: 12px 40px 12px 14px;
            border: 1.5px dashed #94a3b8;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            background: #ffffff;
            font-family: 'Cairo', sans-serif;
            letter-spacing: 1px;
            transition: border-color 0.2s;
            box-sizing: border-box;
            text-transform: uppercase;
        }

        .sp-promo-input:focus {
            outline: none;
            border-color: var(--green);
            border-style: solid;
        }

        .sp-promo-submit-btn {
            padding: 12px 22px;
            background: var(--deep);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-weight: 800;
            font-size: 13.5px;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .sp-promo-submit-btn:hover {
            background: #032520;
            transform: translateY(-1px);
        }

        .sp-promo-countdown-pill {
            display: flex;
            align-items: center;
            gap: 7px;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #9f1239;
            padding: 8px 12px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 700;
            margin-top: 10px;
            line-height: 1.4;
        }

        .sp-promo-feedback {
            margin-top: 10px;
            padding: 9px 13px;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 700;
        }

        .sp-promo-feedback.success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .sp-promo-feedback.error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .form-label-custom {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-input-custom {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            font-family: 'Cairo', sans-serif;
            background: #ffffff;
            color: #0f172a;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }

        .form-input-custom:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(8, 123, 104, 0.15);
        }

        .checkout-form-grid {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* ─── 10. FAQ & SUPPORT ─── */
        .sx-faq-grid {
            display: grid;
            grid-template-columns: 1.3fr .7fr;
            gap: 32px;
            align-items: start;
        }

        .sx-faq-list {
            margin-top: 18px;
        }

        .sx-faq {
            border-bottom: 1px solid #e6eeeb;
        }

        .sx-faq summary {
            padding: 14px 4px;
            cursor: pointer;
            list-style: none;
            font-weight: 700;
            font-size: 14.5px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
            color: #10231f;
        }

        .sx-faq summary::-webkit-details-marker {
            display: none;
        }

        .sx-faq summary:after {
            content: '+';
            font-size: 20px;
            color: var(--green);
            line-height: 1;
            font-weight: 900;
        }

        .sx-faq[open] summary:after {
            content: '−';
        }

        .sx-faq p {
            padding: 0 4px 14px;
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.65;
        }

        .sx-support {
            background: linear-gradient(145deg, #eaf8f5, #f6fbfa);
            border-radius: 16px;
            padding: 28px 22px;
            text-align: center;
            margin-top: 24px;
            border: 1px solid #dff2ed;
        }

        .sx-chat-icon {
            height: 55px;
            width: 55px;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: #08a987;
            color: #ffffff;
            display: grid;
            place-items: center;
            font-size: 24px;
            box-shadow: 0 6px 18px rgba(8, 169, 135, 0.25);
        }

        .sx-support h3 {
            font-size: 19px;
            margin-bottom: 6px;
            color: #10231f;
        }

        .sx-support p {
            font-size: 12.5px;
            color: var(--muted);
            margin-bottom: 16px;
            line-height: 1.6;
        }

        .sx-support .sx-btn {
            background: var(--deep);
            color: #ffffff;
            font-size: 13px;
            box-shadow: none;
        }

        .sx-support .sx-btn:hover {
            background: #032a24;
        }

        /* ═══════════════════════════════════════════════════════════════════
           RESPONSIVE DESIGN (Flawless on Mobile, Tablet & Desktop)
           ═══════════════════════════════════════════════════════════════════ */
        @media (max-width: 900px) {
            #scripox-page {
                padding-top: 70px;
            }

            #scripox-page .sx-wrap {
                width: min(100% - 32px, 680px);
            }

            #scripox-page .sx-section {
                padding: 48px 0;
            }

            .sx-hero-grid,
            .sx-product-grid,
            .sx-feature-grid,
            .sx-price-grid,
            .sx-faq-grid {
                grid-template-columns: 1fr;
            }

            .sx-hero-grid {
                gap: 26px;
            }

            #scripox-page .sx-hero-copy {
                text-align: center;
            }

            #scripox-page .sx-hero-copy p {
                margin-left: auto;
                margin-right: auto;
            }

            #scripox-page .sx-hero-copy h1 em {
                text-align: center;
            }

            .sx-checks,
            .sx-actions {
                justify-content: center;
            }

            .sx-navlinks {
                display: none;
            }

            .sx-visual {
                min-height: 290px;
            }

            #scripox-page .sx-laptop {
                transform: none;
                max-width: 520px;
            }

            #scripox-page .sx-laptop:hover {
                transform: none;
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
                gap: 28px 18px;
            }

            .sx-step:nth-child(2):after {
                display: none;
            }

            .sx-reviews-slider-wrap {
                position: relative;
                width: 100%;
                overflow: hidden;
            }

            .sx-review-grid {
                display: flex !important;
                grid-template-columns: none !important;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scroll-behavior: smooth;
                gap: 14px;
                padding: 10px 4px 18px;
                margin-top: 18px;
                scrollbar-width: none; /* Firefox */
                -ms-overflow-style: none; /* IE 10+ */
            }

            .sx-review-grid::-webkit-scrollbar {
                display: none; /* WebKit */
            }

            .sx-review {
                flex: 0 0 86%;
                max-width: 320px;
                min-width: 260px;
                scroll-snap-align: center;
                scroll-snap-stop: always;
                box-sizing: border-box;
            }

            .sx-review p {
                min-height: 60px;
            }

            .sx-reviews-controls {
                display: flex;
            }

            .sx-price-grid {
                gap: 26px;
            }

            .sx-box-art {
                height: 180px;
                width: 150px;
                transform: none;
            }

            .sx-best {
                left: calc(50% - 95px);
            }

            .sx-faq-grid {
                gap: 12px;
            }

            .sx-support {
                margin-top: 14px;
            }
        }

        @media (max-width: 540px) {
            #scripox-page {
                font-size: 14px;
            }

            #scripox-page .sx-wrap {
                width: calc(100% - 24px);
            }

            #scripox-page .sx-hero {
                padding: 16px 0 35px;
            }

            .sx-nav {
                margin-bottom: 20px;
            }

            .sx-nav .sx-btn {
                font-size: 11px !important;
                padding: 7px 11px !important;
            }

            .sx-brand {
                font-size: 16px !important;
            }

            #scripox-page .sx-hero-copy h1 {
                font-size: 28px !important;
                line-height: 1.25;
            }

            #scripox-page .sx-hero-copy p {
                font-size: 13.5px !important;
            }

            .sx-checks {
                gap: 8px 14px;
                font-size: 11.5px !important;
            }

            .sx-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .sx-actions .sx-btn {
                width: 100%;
            }

            .sx-visual {
                min-height: 230px;
            }

            #scripox-page .sx-laptop {
                padding: 6px;
                border-width: 1.5px;
            }

            #scripox-page .sx-laptop-screen {
                height: 185px;
            }

            #scripox-page .sx-dash-side {
                width: 28%;
                padding: 8px 4px;
            }

            #scripox-page .sx-dash-logo {
                font-size: 10px;
                margin-bottom: 10px;
            }

            #scripox-page .sx-dash-item {
                font-size: 7.5px;
                padding: 4px 0;
            }

            #scripox-page .sx-dash-main {
                padding: 8px 6px;
            }

            #scripox-page .sx-stat {
                padding: 5px;
            }

            .sx-stat b {
                font-size: 12px;
            }

            .sx-table {
                margin-top: 6px;
            }

            .sx-row {
                font-size: 7.5px;
                padding: 3px 2px;
            }

            /* Dock floating badges safely inside screen width */
            #scripox-page .sx-float {
                font-size: 9px !important;
                padding: 6px 10px !important;
                border-radius: 10px !important;
            }

            #scripox-page .sx-float i {
                font-size: 15px !important;
            }

            #scripox-page .sx-float.one {
                top: 0;
                left: 0;
            }

            #scripox-page .sx-float.two {
                right: 0;
                top: 42%;
            }

            #scripox-page .sx-float.three {
                right: 0;
                bottom: 0;
            }

            .sx-metric {
                gap: 8px;
                padding: 6px 4px !important;
            }

            .sx-metric i {
                font-size: 18px !important;
            }

            .sx-metric b {
                font-size: 18px !important;
            }

            .sx-metric small {
                font-size: 10px !important;
            }

            .sx-product-mock {
                min-height: 300px !important;
            }

            .sx-window {
                height: 220px;
                width: 95%;
                left: 2.5%;
                transform: none;
            }

            .sx-contact {
                width: 60%;
                bottom: 18px;
                padding: 9px;
            }

            .sx-filter {
                width: 50%;
                bottom: 4px;
                padding: 9px;
            }

            .sx-note {
                font-size: 10px;
                left: 20%;
            }

            .sx-source-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            .sx-source {
                min-height: 90px;
                padding: 8px 4px;
            }

            .sx-source i {
                font-size: 20px;
            }

            .sx-source b {
                font-size: 10.5px;
            }

            .sx-source small {
                font-size: 8px;
            }

            .sx-steps {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .sx-step:not(:last-child):after {
                display: none;
            }

            .sx-feature-list {
                grid-template-columns: 1fr;
            }

            .sx-video {
                height: 210px;
            }

            .sx-price {
                padding: 24px 0 !important;
            }

            .sx-price-main {
                font-size: 24px;
            }

            .sx-assurances {
                justify-content: center;
                gap: 12px;
            }

            .checkout-box-inner {
                padding: 22px 16px;
            }

            .sp-currency-selector {
                grid-template-columns: 1fr;
            }

            .sp-promo-row {
                flex-direction: column;
            }

            .sp-promo-submit-btn {
                width: 100%;
            }

            .form-input-custom {
                font-size: 16px; /* Prevents auto zoom in iOS */
            }
        }
    </style>
@endpush

@section('content')
<main id="scripox-page" dir="rtl">

    {{-- ══════════════════════════════════════════════════════════
         SECTION 1: HERO (High-Converting Luxury Emerald)
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-hero">
        <div class="sx-wrap">
            
           
            <div class="sx-hero-grid" id="sx-top">
                
                {{-- Hero Copy --}}
                <div class="sx-hero-copy">
                    @if(!empty($landingPage->headline) && $landingPage->slug !== 'scripox')
                        <h1>{!! nl2br(e($landingPage->headline)) !!}</h1>
                    @else
                        <h1>اجمع بيانات عملائك<br>من كل مكان <em>Scrip OX</em></h1>
                    @endif

                    <p>{{ $pageDesc }}</p>

                    <div class="sx-checks">
                        <span><i class="fa-solid fa-circle-check"></i> استخراج دقيق</span>
                        <span><i class="fa-solid fa-circle-check"></i> تنظيف البيانات</span>
                        <span><i class="fa-solid fa-circle-check"></i> تصدير بضغطة واحدة</span>
                    </div>

                    <div class="sx-actions">
                        <a class="sx-btn" href="#sx-checkout" onclick="scrollToCheckout(); return false;">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>احصل على Scrip OX الآن</span>
                        </a>
                        <a class="sx-btn sx-btn-outline" href="#sx-video">
                            <i class="fa-regular fa-circle-play"></i>
                            <span>شاهد فيديو تعريفي</span>
                        </a>
                    </div>
                </div>

                {{-- Hero Visual 3D Laptop with High-Tech CRM Dashboard --}}
                <div class="sx-visual">
                    <div class="sx-laptop">
                        <div class="sx-laptop-screen">
                            <div class="sx-dash-side">
                                <div class="sx-dash-logo">◉ Scrip OX</div>
                                <div class="sx-dash-item"><i class="fa-solid fa-chart-pie"></i> Overview</div>
                                <div class="sx-dash-item"><i class="fa-solid fa-users"></i> Customers</div>
                                <div class="sx-dash-item"><i class="fa-solid fa-filter"></i> Filters</div>
                                <div class="sx-dash-item"><i class="fa-solid fa-bag-shopping"></i> Orders</div>
                                <div class="sx-dash-item"><i class="fa-solid fa-gear"></i> Settings</div>
                            </div>
                            <div class="sx-dash-main">
                                <div class="sx-dash-top">
                                    <span>Customer dashboard</span>
                                    <span>⌕　◉</span>
                                </div>
                                <div class="sx-statgrid">
                                    <div class="sx-stat">Total leads<b>12,480</b></div>
                                    <div class="sx-stat">Qualified<b>8,320</b></div>
                                    <div class="sx-stat">New today<b>2,150</b></div>
                                </div>
                                <div class="sx-table">
                                    <div class="sx-row" style="font-weight:bold">
                                        <span>Name</span><span>Company</span><span>Status</span><span>Score</span>
                                    </div>
                                    <div class="sx-row"><span>Ahmed Mohamed</span><span>Digital Co.</span><span><i class="sx-pill">Qualified</i></span><span>94</span></div>
                                    <div class="sx-row"><span>Salma Ali</span><span>Store Plus</span><span><i class="sx-pill">New</i></span><span>87</span></div>
                                    <div class="sx-row"><span>Omar Hassan</span><span>Modern Biz</span><span><i class="sx-pill">Contacted</i></span><span>81</span></div>
                                    <div class="sx-row"><span>Mona Samir</span><span>Smart House</span><span><i class="sx-pill">Qualified</i></span><span>78</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="sx-laptop-base"></div>
                    </div>

                    {{-- Floating Badges Matching Image 2 --}}
                    <div class="sx-float one">
                        <i class="fa-solid fa-file-export"></i>
                        <span>تصدير البيانات<br><small>Excel أو Scrip OX</small></span>
                    </div>
                    <div class="sx-float two">
                        <i class="fa-brands fa-google"></i>
                        <span>بيانات من<br>Google Analytics</span>
                    </div>
                    <div class="sx-float three">
                        <i class="fa-solid fa-bullseye"></i>
                        <span>جمهور من<br>Meta Ads</span>
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
            <div class="sx-metric">
                <i class="fa-solid fa-cloud-arrow-down"></i>
                <div>
                    <b>+10K</b>
                    <small>شركة تستخدم أدواتنا</small>
                </div>
            </div>
            <div class="sx-metric">
                <i class="fa-solid fa-bolt"></i>
                <div>
                    <b>+50K</b>
                    <small>عميل محتمل شهريًا</small>
                </div>
            </div>
            <div class="sx-metric">
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <b>95%</b>
                    <small>دقة البيانات</small>
                </div>
            </div>
            <div class="sx-metric">
                <i class="fa-solid fa-globe"></i>
                <div>
                    <b>+20</b>
                    <small>مصدر بيانات مختلف</small>
                </div>
            </div>
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
                        <b>◉ Scrip OX　 /　 Customers</b>
                        <span>⌕　⚙</span>
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
                        <i class="fa-solid fa-address-card" style="color:#07866e"></i>
                        <span>تفاصيل العميل — أحمد محمد</span>
                    </div>
                    <div class="sx-contact-row">✉　ahmed@company.com</div>
                    <div class="sx-contact-row">☎　+966 5XX XXX XXX</div>
                    <div class="sx-contact-tags">
                        <span>مهتم بالخدمات</span>
                        <span>عميل محتمل</span>
                    </div>
                    <div class="sx-contact-row" style="direction: rtl; text-align: right;">ملاحظات: تواصل بعد أسبوع</div>
                </div>

                <div class="sx-filter">
                    <b><i class="fa-solid fa-filter" style="color:#07866e"></i> فلترة متقدمة</b>
                    <div class="sx-select">المدينة <span>⌄</span></div>
                    <div class="sx-select">المجال <span>⌄</span></div>
                    <div class="sx-select">آخر تفاعل <span>⌄</span></div>
                    <a class="sx-filter-btn" href="#sx-checkout" onclick="scrollToCheckout(); return false;">تطبيق الفلاتر</a>
                </div>

                <div class="sx-note">نظّف بياناتك ونظّمها بسهولة</div>
            </div>

            {{-- Product Copy & Key Benefits --}}
            <div class="sx-product-copy">
                <span class="sx-kicker">ما هو Scrip OX؟</span>
                <h2>إضافة متكاملة لاستخراج البيانات وتحويلها إلى عملاء</h2>
                <p>
                    Scrip OX يساعدك في جمع بيانات الشركات والأفراد من مواقع متعددة، وتنظيمها. أدر بياناتك داخل CRM مصغّر مع إمكانية التصدير والاستخدام في الحملات التسويقية والبيعية.
                </p>

                <div class="sx-benefit">
                    <div class="sx-benefit-icon"><i class="fa-solid fa-earth-americas"></i></div>
                    <div>
                        <b>استخراج من مصادر متعددة</b>
                        <small>اجمع البيانات من مواقع متنوعة بسهولة.</small>
                    </div>
                </div>
                <div class="sx-benefit">
                    <div class="sx-benefit-icon"><i class="fa-solid fa-database"></i></div>
                    <div>
                        <b>تنظيم وتنظيف البيانات تلقائيًا</b>
                        <small>إزالة التكرار وتصحيح البيانات لتصبح جاهزة.</small>
                    </div>
                </div>
                <div class="sx-benefit">
                    <div class="sx-benefit-icon"><i class="fa-solid fa-address-book"></i></div>
                    <div>
                        <b>CRM مصغّر متكامل</b>
                        <small>إدارة ملفات العملاء، إضافة ملاحظات وتقييم.</small>
                    </div>
                </div>
                <div class="sx-benefit">
                    <div class="sx-benefit-icon"><i class="fa-solid fa-file-export"></i></div>
                    <div>
                        <b>تصدير مرن</b>
                        <small>تصدير إلى Excel أو متابعة العمل داخل Scrip OX.</small>
                    </div>
                </div>
                <div class="sx-benefit">
                    <div class="sx-benefit-icon"><i class="fa-solid fa-bullseye"></i></div>
                    <div>
                        <b>تحليلات وجماهير إعلانية</b>
                        <small>تنظيم مصادر البيانات لتجهيز جماهيرك.</small>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 4: DATA SOURCES
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-sources" id="sx-sources">
        <div class="sx-wrap sx-center">
            <span class="sx-kicker">مصادر البيانات المدعومة</span>
            <h2>اجمع البيانات من مصادر متعددة</h2>
            <p class="sx-muted">استخرج البيانات من منصات ومصادر متنوعة بسهولة</p>

            <div class="sx-source-grid">
                <div class="sx-source">
                    <i class="fa-solid fa-building"></i>
                    <b>مواقع الشركات</b>
                    <small>وأدلة الأعمال</small>
                </div>
                <div class="sx-source">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <b>المتاجر الإلكترونية</b>
                    <small>WooCommerce وغيرها</small>
                </div>
                <div class="sx-source">
                    <i class="fa-solid fa-city"></i>
                    <b>المنصات المحلية</b>
                    <small>حسب مصادر البيانات</small>
                </div>
                <div class="sx-source">
                    <i class="fa-brands fa-facebook"></i>
                    <b>Meta Ads</b>
                    <small>جمهور الإعلانات</small>
                </div>
                <div class="sx-source">
                    <i class="fa-brands fa-google"></i>
                    <b>Google Analytics</b>
                    <small>الأداء والاستخدام</small>
                </div>
                <div class="sx-source">
                    <i class="fa-solid fa-circle-plus"></i>
                    <b>والمزيد</b>
                    <small>إمكانية إضافة مصادر</small>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 5: PROCESS WORKFLOW
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-process" id="sx-process">
        <div class="sx-wrap sx-center">
            <span class="sx-kicker" style="background: rgba(255,255,255,0.15); color: #6ee7b7;">سير عمل بسيط</span>
            <h2>من البيانات إلى عملاء حقيقيين</h2>
            <p class="sx-muted">خطوات واضحة لتحويل البيانات إلى فرص ومبيعات</p>

            <div class="sx-steps">
                <div class="sx-step">
                    <span class="sx-step-num">1</span>
                    <i class="fa-solid fa-earth-americas"></i>
                    <b>استخراج البيانات</b>
                    <p>من المواقع والمنصات في خطوات سهلة.</p>
                </div>
                <div class="sx-step">
                    <span class="sx-step-num">2</span>
                    <i class="fa-solid fa-filter"></i>
                    <b>تنظيف وفلترة</b>
                    <p>إزالة التكرار وتصنيف المعلومات.</p>
                </div>
                <div class="sx-step">
                    <span class="sx-step-num">3</span>
                    <i class="fa-solid fa-user-group"></i>
                    <b>إدارة العملاء في CRM</b>
                    <p>إضافة ملاحظات وتقييم ومتابعة.</p>
                </div>
                <div class="sx-step">
                    <span class="sx-step-num">4</span>
                    <i class="fa-solid fa-file-arrow-down"></i>
                    <b>تصدير أو استخدام</b>
                    <p>Excel أو متابعة العمل داخل البرنامج.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 6: FEATURES & VIDEO SHOWCASE
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-section" id="sx-features">
        <div class="sx-wrap sx-feature-grid">
            
            <div class="sx-feature-copy">
                <span class="sx-kicker">ماذا يمكنك أن تفعل مع Scrip OX؟</span>
                <h2>كل أدوات إدارة البيانات في مكان واحد</h2>
                <p class="sx-muted">رتّب عملاءك، تابع الطلبات، واتخذ قراراتك على أساس بيانات منظمة.</p>

                <div class="sx-feature-list">
                    <div class="sx-feature"><i class="fa-solid fa-bullseye"></i> استخراج بيانات الحملات</div>
                    <div class="sx-feature"><i class="fa-solid fa-clock"></i> توفير الوقت والجهد</div>
                    <div class="sx-feature"><i class="fa-solid fa-chart-column"></i> زيادة المبيعات والتحويلات</div>
                    <div class="sx-feature"><i class="fa-solid fa-cart-shopping"></i> تتبع طلبات الشراء والفرص</div>
                    <div class="sx-feature"><i class="fa-solid fa-filter"></i> تقييم وفرز العملاء المحتملين</div>
                    <div class="sx-feature"><i class="fa-solid fa-circle-check"></i> تسجيل حالة العميل وملاحظاته</div>
                </div>
            </div>

            <div class="sx-video" id="sx-video">
                <div class="sx-play" onclick="scrollToCheckout()">
                    <i class="fa-solid fa-play"></i>
                </div>
                <div class="sx-video-caption">جولة سريعة على أهم مميزات Scrip OX</div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 7: REVIEWS & SOCIAL PROOF
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-section sx-reviews">
        <div class="sx-wrap sx-center">
            <span class="sx-kicker">آراء عملائنا</span>
            <h2>ماذا يقول المستخدمون عن {{ $product->name ?: 'Scrip OX' }}؟</h2>

            @php
                $testimonialsList = (!empty($landingPage->testimonials) && is_array($landingPage->testimonials) && count($landingPage->testimonials) > 0)
                    ? $landingPage->testimonials
                    : [
                        [
                            'name' => 'أحمد الخطيب',
                            'role' => 'شركة تسويق رقمي',
                            'rating' => 5,
                            'comment' => 'ساعدنا على تنظيم بيانات العملاء ومتابعة الفرص التسويقية من مكان واحد.'
                        ],
                        [
                            'name' => 'سارة إبراهيم',
                            'role' => 'مديرة متجر إلكتروني',
                            'rating' => 5,
                            'comment' => 'أصبح فرز العملاء وتسجيل الملاحظات أسهل بكثير لفريق المبيعات.'
                        ],
                        [
                            'name' => 'محمد حسن',
                            'role' => 'رائد أعمال',
                            'rating' => 5,
                            'comment' => 'واجهة عملية تجمع البيانات وتساعدنا على ترتيب أولويات التواصل.'
                        ],
                    ];
            @endphp

            <div class="sx-reviews-slider-wrap">
                <div class="sx-review-grid" id="sxReviewsGrid">
                    @foreach($testimonialsList as $rev)
                        @php
                            $comment = $rev['comment'] ?? $rev['text'] ?? $rev['content'] ?? '';
                            $rating = intval($rev['rating'] ?? 5);
                            $name = $rev['name'] ?? 'عميل موثق';
                            $role = $rev['role'] ?? $rev['title'] ?? 'مستخدم معتمد';
                        @endphp
                        <article class="sx-review">
                            <div class="sx-stars">
                                {{ str_repeat('★', max(1, min(5, $rating))) }}{{ str_repeat('☆', 5 - max(1, min(5, $rating))) }}
                            </div>
                            <p>“{{ $comment }}”</p>
                            <div class="sx-person">
                                <div class="sx-avatar"><i class="fa-solid fa-user"></i></div>
                                <div>
                                    <b>{{ $name }}</b>
                                    <small>{{ $role }}</small>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Navigation Controls for Mobile Slider -->
                <div class="sx-reviews-controls">
                    <button type="button" class="sx-rev-nav-btn" id="sxRevRightBtn" aria-label="تحريك لليمين">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                    <div class="sx-rev-dots" id="sxRevDots"></div>
                    <button type="button" class="sx-rev-nav-btn" id="sxRevLeftBtn" aria-label="تحريك لليسار">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                </div>
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
                    <strong>S</strong>
                    <b style="display:block; font-size: 15px; margin: 4px 0;">Scrip OX</b>
                    <span>OX TECH</span>
                </div>
            </div>

            <div class="sx-price-copy">
                <span class="sx-kicker" style="background: rgba(255,255,255,0.15); color: #6ee7b7;">ابدأ العمل اليوم</span>
                <h2>ابدأ مع Script OX اليوم</h2>
                <p>أداة مرنة لإدارة بياناتك والعملاء من مساحة واحدة.</p>

                <div class="sx-price-card">
                    <div class="sx-price-line">
                        <div>
                            <span class="sx-old">{{ number_format($oldPrice, 0) }} {{ $productCurrency }}</span><br>
                            <span class="sx-price-main">{{ number_format($effectivePrice, 0) }} {{ $productCurrency }}</span>
                        </div>
                        <span class="sx-discount">خصم {{ $discountPct }}%</span>
                    </div>

                    <a class="sx-btn" href="#sx-checkout" onclick="scrollToCheckout(); return false;">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>احصل على Scrip OX الآن</span>
                    </a>
                </div>

                <div class="sx-assurances">
                    <span><i class="fa-solid fa-bolt"></i> تفعيل فوري</span>
                    <span><i class="fa-solid fa-headset"></i> دعم فني مباشر</span>
                    <span><i class="fa-solid fa-arrows-rotate"></i> تحديثات مستمرة</span>
                    <span><i class="fa-solid fa-shield-halved"></i> ضمان الاستخدام</span>
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
                <div style="text-align: center;">
                    <div class="checkout-badge-pill">
                        ⚡ طلب مباشر وتفعيل فوري آمن
                    </div>
                    <h3 style="font-size: 23px; font-weight: 900; color: #0f172a; margin-bottom: 6px;">
                        املأ بياناتك للشراء واستلام الترخيص
                    </h3>
                    <p style="font-size: 13.5px; color: var(--muted); margin: 0 0 16px;">
                        تشفير بنكي 256-bit عبر بوابة PaySky Omni Gateway المعتمدة وتوليد مفتاح الترخيص آلياً
                    </p>
                </div>

                {{-- 1. Currency Selector (USD as default, or EGP) --}}
                <div class="sp-currency-toggle-wrapper">
                    <div class="sp-currency-label">
                        <i class="fa-solid fa-coins" style="color: var(--green);"></i>
                        <span>اختر عملة الدفع المناسبة لك:</span>
                    </div>
                    <div class="sp-currency-selector">
                        <button type="button" class="sp-currency-btn active" id="btnCurrUsd" onclick="selectCurrency('USD')">
                            <span>🇺🇸</span>
                            <span>الدفع بالدولار (USD $)</span>
                            <span class="sp-curr-badge">الافتراضي</span>
                        </button>
                        <button type="button" class="sp-currency-btn" id="btnCurrEgp" onclick="selectCurrency('EGP')">
                            <span>🇪🇬</span>
                            <span>الدفع بالجنيه المصري (EGP ج.م)</span>
                        </button>
                    </div>
                </div>

                {{-- 2. Order Summary Strip with Dynamic Price --}}
                <div class="order-summary-strip" id="orderSummaryStrip">
                    <div>
                        <div style="font-weight: 800; font-size: 14px; color: #0f172a;">{{ $product->name }} (ترخيص دائم)</div>
                        <div style="font-size: 12px; color: #059669; font-weight: 700;">✓ تفعيل رقمي فوري + رابط التحميل المباشر</div>
                        <div id="appliedPromoBadge" style="display:none; font-size: 12px; color: #087b68; font-weight: 800; margin-top: 4px;">
                            🏷️ كود الخصم المفعّل: <span id="appliedPromoCodeText">OX50</span> (<span id="appliedPromoDiscountText">-50%</span>)
                        </div>
                    </div>
                    <div style="text-align: left; min-width: 130px;">
                        <div id="originalPriceLine" style="display:none; text-decoration: line-through; color: #94a3b8; font-size: 13px;">
                            <span id="displayOriginalAmount">100</span> <span class="displayCurrencyLabel">USD</span>
                        </div>
                        <div>
                            <span style="font-size: 24px; font-weight: 900; color: #065f46;" id="displayFinalAmount">{{ number_format($effectivePrice, 0) }}</span>
                            <span style="font-size: 13px; font-weight: 700; color: #065f46;" class="displayCurrencyLabel">USD</span>
                        </div>
                    </div>
                </div>

                {{-- 3. Promo Code Box with Duration and Expiry --}}
                <div class="sp-promo-section">
                    <div class="sp-promo-row">
                        <div style="position: relative; flex: 1;">
                            <i class="fa-solid fa-ticket sp-promo-input-icon"></i>
                            <input type="text" id="spPromoInput" placeholder="أدخل كود الخصم (مثال: OX50)" class="sp-promo-input" value="OX50" autocomplete="off" onkeydown="if(event.key==='Enter'){event.preventDefault();applyPromoCode();}">
                        </div>
                        <button type="button" class="sp-promo-submit-btn" id="btnApplyPromo" onclick="applyPromoCode()">
                            <span id="promoBtnText">تطبيق الكود</span>
                        </button>
                    </div>
                    <div id="spPromoFeedback" class="sp-promo-feedback" style="display: none; margin-top: 10px; padding: 8px 12px; border-radius: 8px; font-size: 12.5px; font-weight: 700;"></div>
                </div>

                {{-- 4. Fast Checkout Form --}}
                <form id="salesCheckoutForm" onsubmit="handleSalesCheckout(event)">
                    @csrf
                    <input type="hidden" id="spProductId" value="{{ $product->id }}">
                    <input type="hidden" id="spSelectedCurrency" name="currency" value="USD">
                    <input type="hidden" id="spAppliedPromo" name="promo_code" value="">
                    <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
                    <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
                    <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">

                    <div class="checkout-form-grid">
                        <div>
                            <label class="form-label-custom">الاسم بالكامل أو اسم المنشأة *</label>
                            <input type="text" id="spCustName" required placeholder="مثال: أحمد محمد" class="form-input-custom">
                        </div>

                        <div>
                            <label class="form-label-custom">البريد الإلكتروني (لاستلام الترخيص فوراً) *</label>
                            <input type="email" id="spCustEmail" required placeholder="name@company.com" class="form-input-custom" style="direction: ltr; text-align: left;">
                        </div>

                        <div>
                            <label class="form-label-custom">رقم الهاتف أو الواتساب *</label>
                            <input type="tel" id="spCustPhone" required placeholder="05XXXXXXXX أو 010XXXXXXXX" class="form-input-custom" style="direction: ltr; text-align: left;">
                        </div>

                        <button type="submit" id="btnSubmitSalesOrder" class="sx-btn" style="width: 100%; padding: 16px; font-size: 16px; margin-top: 8px;">
                            <span id="btnSubmitText">إتمام الشراء والدفع الآمن الآن ←</span>
                        </button>

                        
                    </div>
                </form>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 10: FAQ & WHATSAPP SUPPORT
         ══════════════════════════════════════════════════════════ --}}
    <section class="sx-section" id="sx-faq">
        <div class="sx-wrap sx-faq-grid">
            
            <div>
                <span class="sx-kicker">الأسئلة الشائعة</span>
                <h2>كل ما تحتاج معرفته عن Scrip OX</h2>

                <div class="sx-faq-list">
                    <details class="sx-faq" open>
                        <summary>ما هي المواقع التي يمكن استخراج البيانات منها؟</summary>
                        <p>يعتمد ذلك على المصادر التي يدعمها إصدار Scrip OX لديك وإمكانية الوصول إلى البيانات. راجع تفاصيل المنتج أو تواصل مع الفريق لتأكيد مصدر محدد.</p>
                    </details>
                    <details class="sx-faq">
                        <summary>هل يعمل على نظام Windows فقط؟</summary>
                        <p>تحقق من متطلبات التشغيل المرفقة مع نسختك قبل الشراء، إذ قد تختلف حسب إصدار البرنامج، ويعمل بكفاءة عالية على Windows 10 و 11.</p>
                    </details>
                    <details class="sx-faq">
                        <summary>هل يمكن تصدير البيانات إلى Excel؟</summary>
                        <p>يتضمن تصميم المنتج خيار تصدير البيانات إلى Excel و CSV بضغطة زر واحدة لتجهيز ملفاتك وتحميلها لحملاتك الإعلانية.</p>
                    </details>
                    <details class="sx-faq">
                        <summary>هل يمكن إدارة العملاء واستخدام CRM؟</summary>
                        <p>يمكنك تنظيم بيانات العملاء وإضافة تفاصيل وملاحظات وحالات متابعة ضمن مساحة إدارة العملاء في المنتج.</p>
                    </details>
                    <details class="sx-faq">
                        <summary>هل أستطيع إضافة مصادر بيانات جديدة؟</summary>
                        <p>إتاحة المصادر تعتمد على خصائص الإصدار والتحديثات الدورية. تواصل مع فريق Ox Tech لمعرفة المصادر المتاحة حاليًا.</p>
                    </details>
                </div>
            </div>

            {{-- Direct WhatsApp Support Box --}}
            <aside class="sx-support" id="sx-contact">
                <div class="sx-chat-icon">
                    <i class="fa-solid fa-comment-dots"></i>
                </div>
                <h3>ما زلت لديك سؤال؟</h3>
                <p>فريقنا جاهز لمساعدتك في أي وقت عبر الواتساب للإجابة عن استفساراتك.</p>
                <a class="sx-btn" href="https://wa.me/{{ $waPhone }}?text={{ urlencode('مرحباً، أود الاستفسار عن عرض برنامج ' . $product->name) }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>تواصل معنا عبر واتساب</span>
                </a>
            </aside>

        </div>
    </section>

</main>
@endsection

@push('scripts')
<script>
// Base pricing & exchange rate settings (1 USD = 50 EGP)
const PRODUCT_ID = {{ $product->id }};
const PRODUCT_BASE_CURRENCY = '{{ $productCurrency }}';
const PRODUCT_BASE_PRICE = {{ $effectivePrice }};
const USD_TO_EGP_RATE = 50.0;

let currentCurrency = 'USD'; // USD as Default
let appliedPromoData = null;

function getBasePriceInCurrency(curr) {
    if (PRODUCT_BASE_CURRENCY === 'USD') {
        return curr === 'EGP' ? Math.round(PRODUCT_BASE_PRICE * USD_TO_EGP_RATE) : PRODUCT_BASE_PRICE;
    } else {
        return curr === 'USD' ? Math.round((PRODUCT_BASE_PRICE / USD_TO_EGP_RATE) * 100) / 100 : PRODUCT_BASE_PRICE;
    }
}

function updatePriceUI() {
    const basePrice = getBasePriceInCurrency(currentCurrency);
    const currSymbol = currentCurrency === 'USD' ? 'USD' : 'ج.م';

    // Update Currency Labels
    document.querySelectorAll('.displayCurrencyLabel').forEach(el => el.textContent = currSymbol);

    let finalPrice = basePrice;
    if (appliedPromoData) {
        let discount = 0;
        if (appliedPromoData.discount_type === 'percentage') {
            discount = Math.round(basePrice * (appliedPromoData.discount_value / 100));
        } else {
            discount = Math.min(basePrice, appliedPromoData.discount_value);
        }
        finalPrice = Math.max(1, basePrice - discount);

        document.getElementById('originalPriceLine').style.display = 'block';
        document.getElementById('displayOriginalAmount').textContent = basePrice.toLocaleString();
        document.getElementById('appliedPromoBadge').style.display = 'block';
        document.getElementById('appliedPromoCodeText').textContent = appliedPromoData.code;
        document.getElementById('appliedPromoDiscountText').textContent = appliedPromoData.discount_type === 'percentage'
            ? '-' + Math.round(appliedPromoData.discount_value) + '%'
            : '-' + discount + ' ' + currSymbol;
    } else {
        document.getElementById('originalPriceLine').style.display = 'none';
        document.getElementById('appliedPromoBadge').style.display = 'none';
    }

    document.getElementById('displayFinalAmount').textContent = finalPrice.toLocaleString();

    // Update submit button text
    const btnSubmit = document.getElementById('btnSubmitText');
    if (btnSubmit) {
        btnSubmit.textContent = `إتمام الشراء والدفع الآمن (${finalPrice.toLocaleString()} ${currSymbol}) ←`;
    }
}

function selectCurrency(curr) {
    currentCurrency = curr;
    document.getElementById('spSelectedCurrency').value = curr;

    const btnUsd = document.getElementById('btnCurrUsd');
    const btnEgp = document.getElementById('btnCurrEgp');

    if (curr === 'USD') {
        btnUsd.classList.add('active');
        btnEgp.classList.remove('active');
    } else {
        btnEgp.classList.add('active');
        btnUsd.classList.remove('active');
    }

    updatePriceUI();
}

async function applyPromoCode() {
    const input = document.getElementById('spPromoInput');
    const feedback = document.getElementById('spPromoFeedback');
    const btn = document.getElementById('btnApplyPromo');
    const promoBtnText = document.getElementById('promoBtnText');
    const code = input ? input.value.trim().toUpperCase() : '';

    if (!code) {
        if (feedback) {
            feedback.style.display = 'block';
            feedback.style.background = '#FEF2F2';
            feedback.style.color = '#B91C1C';
            feedback.style.border = '1px solid #FECACA';
            feedback.textContent = 'يرجى كتابة كود الخصم أولاً.';
        }
        return;
    }

    if (btn) btn.disabled = true;
    if (promoBtnText) promoBtnText.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> فحص...';

    try {
        const res = await fetch('{{ route("checkout.validate_promo") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                code: code,
                product_id: PRODUCT_ID,
                currency: currentCurrency
            })
        });

        const data = await res.json();

        if (res.ok && data.valid) {
            appliedPromoData = data;
            const appliedPromoInput = document.getElementById('spAppliedPromo');
            if (appliedPromoInput) appliedPromoInput.value = data.code;
            if (feedback) {
                feedback.style.display = 'block';
                feedback.style.background = '#ECFDF5';
                feedback.style.color = '#047857';
                feedback.style.border = '1px solid #A7F3D0';
                feedback.innerHTML = `✓ ${data.message} ${data.remaining_time ? '— (' + data.remaining_time + ')' : ''}`;
            }
            updatePriceUI();
        } else {
            appliedPromoData = null;
            const appliedPromoInput = document.getElementById('spAppliedPromo');
            if (appliedPromoInput) appliedPromoInput.value = '';
            if (feedback) {
                feedback.style.display = 'block';
                feedback.style.background = '#FEF2F2';
                feedback.style.color = '#B91C1C';
                feedback.style.border = '1px solid #FECACA';
                feedback.textContent = data.message || 'كود الخصم غير صحيح أو منتهي الصلاحية.';
            }
            updatePriceUI();
        }
    } catch (e) {
        if (feedback) {
            feedback.style.display = 'block';
            feedback.style.background = '#FEF2F2';
            feedback.style.color = '#B91C1C';
            feedback.style.border = '1px solid #FECACA';
            feedback.textContent = 'تعذر فحص الكود، يرجى مراجعة الاتصال.';
        }
    } finally {
        if (btn) btn.disabled = false;
        if (promoBtnText) promoBtnText.textContent = 'تطبيق الكود';
    }
}

function scrollToCheckout() {
    const el = document.getElementById('sx-checkout');
    if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
        const nameInput = document.getElementById('spCustName');
        if (nameInput) {
            setTimeout(() => nameInput.focus(), 600);
        }
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

function logGatewayError(ref, message, details, step, status) {
    console.warn('Gateway Error [' + step + ']:', message, details);
}

// Handle Order Submission
async function handleSalesCheckout(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmitSalesOrder');
    btn.disabled = true;
    btn.innerHTML = '<span><i class="fa-solid fa-spinner fa-spin"></i> جاري فتح نافذة الدفع الآمنة...</span>';

    const payload = {
        _token: '{{ csrf_token() }}',
        product_id: document.getElementById('spProductId').value,
        customer_name: document.getElementById('spCustName').value,
        customer_email: document.getElementById('spCustEmail').value,
        customer_phone: document.getElementById('spCustPhone').value,
        currency: currentCurrency,
        promo_code: appliedPromoData ? appliedPromoData.code : '',
        utm_source: '{{ request('utm_source') }}',
        utm_medium: '{{ request('utm_medium') }}',
        utm_campaign: '{{ request('utm_campaign') }}',
    };

    // Meta Pixel InitiateCheckout Event
    if (typeof fbq === 'function') {
        fbq('track', 'InitiateCheckout', {
            content_name: '{{ addslashes($product->name) }}',
            content_ids: ['{{ $product->id }}'],
            content_type: 'product',
            value: appliedPromoData ? appliedPromoData.final_price : getBasePriceInCurrency(currentCurrency),
            currency: currentCurrency
        });
    }

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
                    OrderId: data.paysky.OrderNumber || data.paysky.MerchantReference,
                    TrxDateTime: data.paysky.TrxDateTime,
                    CurrencyCode: data.paysky.CurrencyCode || '818',
                    SecureHash: data.paysky.SecureHash,
                    completeCallback: function () {
                        window.location.href = data.callback_url + '?MerchantReference=' + encodeURIComponent(data.paysky.MerchantReference) + '&Success=true';
                    },
                    errorCallback: function (error) {
                        const errMsg = (error && (error.Message || error.errorMessage || error.message)) ? (error.Message || error.errorMessage || error.message) : 'خطأ من البوابة';
                        logGatewayError(data.paysky.MerchantReference, errMsg, error, 'paysky_error_callback', 'failed');
                        alert('حدث خطأ أثناء معالجة الدفع: ' + errMsg);
                        btn.disabled = false;
                        updatePriceUI();
                    },
                    cancelCallback: function () {
                        logGatewayError(data.paysky.MerchantReference, 'تم إغلاق نافذة الدفع', {}, 'lightbox_cancelled', 'cancelled');
                        btn.disabled = false;
                        updatePriceUI();
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
            updatePriceUI();
        }
    } catch (err) {
        console.error(err);
        alert('حدث خطأ بالاتصال. يرجى مراجعة الإنترنت أو التواصل معنا عبر الواتساب.');
        btn.disabled = false;
        updatePriceUI();
    }
}

// Initial price display on load & Reviews Slider
document.addEventListener('DOMContentLoaded', function() {
    selectCurrency('USD'); // Default: Dollar
    // Automatically pre-apply OX50 promo if valid
    const promoInput = document.getElementById('spPromoInput');
    if (promoInput && promoInput.value) {
        applyPromoCode();
    }

    // ─── Mobile Reviews Slider Logic ───
    (function initMobileReviewsSlider() {
        const grid = document.getElementById('sxReviewsGrid');
        if (!grid) return;

        const rightBtn = document.getElementById('sxRevRightBtn');
        const leftBtn = document.getElementById('sxRevLeftBtn');
        const dotsWrap = document.getElementById('sxRevDots');
        const cards = Array.from(grid.querySelectorAll('.sx-review'));
        if (cards.length <= 1) return;

        let currentIndex = 0;
        let autoSlideTimer = null;
        let userPaused = false;
        let pauseResumeTimeout = null;

        // Render indicator dots
        if (dotsWrap) {
            dotsWrap.innerHTML = '';
            cards.forEach((_, idx) => {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'sx-rev-dot' + (idx === 0 ? ' active' : '');
                dot.setAttribute('aria-label', 'الانتقال للرأي ' + (idx + 1));
                dot.addEventListener('click', () => {
                    goToCard(idx);
                    pauseAutoTemporarily();
                });
                dotsWrap.appendChild(dot);
            });
        }

        function updateDots(activeIdx) {
            if (!dotsWrap) return;
            const dots = dotsWrap.querySelectorAll('.sx-rev-dot');
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === activeIdx);
            });
        }

        function goToCard(idx) {
            if (idx < 0) idx = cards.length - 1;
            if (idx >= cards.length) idx = 0;
            currentIndex = idx;
            const card = cards[currentIndex];
            if (card) {
                card.scrollIntoView({
                    behavior: 'smooth',
                    inline: 'center',
                    block: 'nearest'
                });
                updateDots(currentIndex);
            }
        }

        // Right Button: Move right (in RTL, moving right means previous card towards index 0)
        if (rightBtn) {
            rightBtn.addEventListener('click', () => {
                goToCard(currentIndex - 1);
                pauseAutoTemporarily();
            });
        }

        // Left Button: Move left (in RTL, moving left means next card)
        if (leftBtn) {
            leftBtn.addEventListener('click', () => {
                goToCard(currentIndex + 1);
                pauseAutoTemporarily();
            });
        }

        // Automatic rightward / cycle movement for mobile
        function startAutoSlider() {
            stopAutoSlider();
            autoSlideTimer = setInterval(() => {
                if (!userPaused && window.innerWidth <= 900) {
                    goToCard((currentIndex + 1) % cards.length);
                }
            }, 3800);
        }

        function stopAutoSlider() {
            if (autoSlideTimer) {
                clearInterval(autoSlideTimer);
                autoSlideTimer = null;
            }
        }

        function pauseAutoTemporarily() {
            userPaused = true;
            if (pauseResumeTimeout) clearTimeout(pauseResumeTimeout);
            pauseResumeTimeout = setTimeout(() => {
                userPaused = false;
            }, 6000);
        }

        grid.addEventListener('touchstart', () => { userPaused = true; }, { passive: true });
        grid.addEventListener('touchend', () => { pauseAutoTemporarily(); }, { passive: true });
        grid.addEventListener('mouseenter', () => { userPaused = true; });
        grid.addEventListener('mouseleave', () => { userPaused = false; });

        // Sync active dot on manual finger swipe
        let scrollDebounce;
        grid.addEventListener('scroll', () => {
            if (scrollDebounce) clearTimeout(scrollDebounce);
            scrollDebounce = setTimeout(() => {
                const gridRect = grid.getBoundingClientRect();
                const gridCenter = gridRect.left + gridRect.width / 2;
                let closestIdx = 0;
                let minDiff = Infinity;

                cards.forEach((card, i) => {
                    const r = card.getBoundingClientRect();
                    const cardCenter = r.left + r.width / 2;
                    const diff = Math.abs(gridCenter - cardCenter);
                    if (diff < minDiff) {
                        minDiff = diff;
                        closestIdx = i;
                    }
                });

                if (closestIdx !== currentIndex) {
                    currentIndex = closestIdx;
                    updateDots(currentIndex);
                }
            }, 60);
        }, { passive: true });

        startAutoSlider();
    })();
});
</script>

@if(!empty($landingPage->custom_body_scripts))
    {!! $landingPage->custom_body_scripts !!}
@endif
@endpush
