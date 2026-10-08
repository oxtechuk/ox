@extends('layouts.app')

@php
    $locale = app()->getLocale();
    if (!in_array($locale, ['ar', 'en', 'fr'])) {
        $locale = 'ar';
    }
    $isRtl = $locale === 'ar';

    $pageTitle = $locale === 'ar' 
        ? 'سابقة الأعمال والمشاريع البرمجية | OX Tech' 
        : ($locale === 'fr' ? 'Portfolio & Réalisations | OX Tech' : 'Our Portfolio & Case Studies | OX Tech');

    $pageDescription = $locale === 'ar'
        ? 'استكشف معرض أعمال ومشاريع OX Tech: منصات سحابية، تطبيقات جوال، ومتاجر رقمية تم تطويرها وفق أعلى المعايير لشركاء النجاح في السعودية ومصر والخليج.'
        : ($locale === 'fr' 
            ? 'Découvrez nos projets logiciels, applications mobiles et solutions cloud développés pour nos partenaires en Arabie Saoudite, Égypte et Émirats.' 
            : 'Explore OX Tech portfolio of custom cloud platforms, mobile applications, and enterprise software delivered across Saudi Arabia, Egypt, and the UAE.');
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDescription)

@push('styles')
<style>
    /* ═══════════════════════════════════════════════════════════════
       OX TECH — PREMIUM LIGHT THEME PORTFOLIO SHOWCASE
       ═══════════════════════════════════════════════════════════════ */
    .portfolio-archive-page {
        background-color: #F8FAF9;
        color: #0b1b17;
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    /* Ambient Subtle Emerald & Warm Camel Glows */
    .portfolio-archive-page::before {
        content: '';
        position: absolute;
        top: -100px;
        right: 5%;
        width: 650px;
        height: 650px;
        background: radial-gradient(circle, rgba(29, 138, 104, 0.06) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }
    .portfolio-archive-page::after {
        content: '';
        position: absolute;
        top: 500px;
        left: 5%;
        width: 550px;
        height: 550px;
        background: radial-gradient(circle, rgba(200, 169, 107, 0.06) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    /* Hero Section (Light & Elegant) */
    .portfolio-hero-section {
        padding: 130px 0 55px;
        position: relative;
        text-align: center;
        background: linear-gradient(180deg, #edf7f2 0%, #f8faf9 100%);
        border-bottom: 1px solid #e2ede8;
    }
    .portfolio-hero-inner {
        max-width: 920px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    /* Breadcrumbs */
    .portfolio-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 22px;
        background: #ffffff;
        border: 1px solid #e2ede8;
        padding: 7px 20px;
        border-radius: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }
    .portfolio-breadcrumb a {
        color: #4b5e57;
        text-decoration: none;
        transition: color 0.2s ease;
        font-weight: 600;
    }
    .portfolio-breadcrumb a:hover {
        color: #1D8A68;
    }
    .portfolio-breadcrumb .sep {
        opacity: 0.4;
        color: #94a3b8;
    }
    .portfolio-breadcrumb .current {
        color: #1D8A68;
        font-weight: 700;
    }

    .portfolio-page-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 800;
        color: #1D8A68;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 14px;
        background: rgba(29, 138, 104, 0.08);
        padding: 5px 14px;
        border-radius: 99px;
        border: 1px solid rgba(29, 138, 104, 0.15);
    }
    .portfolio-page-kicker-dot {
        width: 7px;
        height: 7px;
        background: #1D8A68;
        border-radius: 50%;
        box-shadow: 0 0 8px rgba(29, 138, 104, 0.5);
    }

    .portfolio-page-title {
        font-size: clamp(30px, 4.5vw, 50px);
        font-weight: 900;
        line-height: 1.25;
        color: #0b1b17;
        margin: 0 0 18px;
        font-family: var(--font-ar);
    }

    .portfolio-page-subtitle {
        font-size: clamp(15px, 1.8vw, 17.5px);
        line-height: 1.85;
        color: #4b5e57;
        max-width: 780px;
        margin: 0 auto 34px;
        font-family: var(--font-ar);
    }

    /* Hero Quick Stats */
    .portfolio-hero-stats {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    .portfolio-stat-box {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #ffffff;
        border: 1px solid #e2ede8;
        padding: 12px 24px;
        border-radius: 14px;
        box-shadow: 0 4px 16px rgba(11, 27, 23, 0.03);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .portfolio-stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(29, 138, 104, 0.08);
        border-color: rgba(29, 138, 104, 0.3);
    }
    .portfolio-stat-num {
        font-size: 24px;
        font-weight: 900;
        color: #1D8A68;
        font-family: var(--font-en, sans-serif);
    }
    .portfolio-stat-label {
        font-size: 13px;
        font-weight: 700;
        color: #4b5e57;
    }

    /* Main Showcase Content Area */
    .portfolio-content-section {
        padding: 45px 0 95px;
        position: relative;
        z-index: 2;
        background-color: #F8FAF9;
    }

    /* Search & Filter Top Bar */
    .portfolio-search-clear {
        position: absolute;
        inset-inline-end: 42px;
        top: 50%;
        transform: translateY(-50%);
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: #64748b;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        transition: all 0.2s ease;
    }
    .portfolio-search-clear:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Project Cards Hover & Transitions in Light Theme */
    .ox-portfolio-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px;
        position: relative;
        z-index: 2;
    }
    .ox-portfolio-card {
        background: #ffffff;
        border: 1px solid #e5eee9;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s ease, border-color 0.35s ease, opacity 0.25s ease;
        box-shadow: 0 4px 20px rgba(11, 27, 23, 0.04);
        position: relative;
    }
    .ox-portfolio-card:hover {
        transform: translateY(-8px);
        border-color: #1D8A68;
        box-shadow: 0 20px 45px rgba(29, 138, 104, 0.12);
    }

    /* Card Details */
    .portfolio-card-head {
        margin-bottom: 12px;
    }
    .portfolio-client-name {
        color: #1D8A68;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: block;
    }
    .portfolio-card-title {
        color: #0b1b17;
        font-size: 20px;
        font-weight: 800;
        margin: 0 0 8px;
        line-height: 1.35;
        font-family: var(--font-ar);
    }
    .portfolio-card-desc {
        color: #4b5e57;
        font-size: 14px;
        line-height: 1.65;
        margin: 0;
        font-family: var(--font-ar);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .portfolio-tech-tags {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .tech-tag {
        background: #f0f7f4;
        border: 1px solid #dceed8;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
        color: #1d5244;
        font-family: var(--font-en, sans-serif);
    }

    .portfolio-card-foot {
        border-top: 1px solid #f0f5f3;
        padding-top: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .portfolio-view-text {
        font-size: 13px;
        font-weight: 700;
        color: #1D8A68;
        transition: color 0.2s ease;
    }
    .portfolio-view-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #1D8A68;
        display: grid;
        place-items: center;
        transition: all 0.25s ease;
    }
    .ox-portfolio-card:hover .portfolio-view-btn {
        background: #1D8A68;
        border-color: #1D8A68;
        color: #ffffff;
        transform: scale(1.08);
    }

    /* Empty state */
    .portfolio-no-results {
        background: #ffffff;
        border: 1px solid #e2ede8;
        border-radius: 20px;
        padding: 50px 20px;
        text-align: center;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        margin: 20px 0;
    }
    .portfolio-no-results .no-results-icon {
        font-size: 38px;
        margin-bottom: 14px;
    }
    .portfolio-no-results h4 {
        color: #0b1b17;
        font-size: 20px;
        font-weight: 800;
        margin: 0 0 8px;
    }
    .portfolio-no-results p {
        color: #64748b;
        font-size: 14.5px;
        margin: 0 0 16px;
    }

    /* Bottom CTA Card (Light Elegant) */
    .portfolio-cta-box {
        margin-top: 75px;
        background: linear-gradient(135deg, #edf6f2 0%, #e1efe9 100%);
        border: 1px solid rgba(29, 138, 104, 0.25);
        border-radius: 24px;
        padding: 52px 32px;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(29, 138, 104, 0.08);
    }
    .portfolio-cta-box h3 {
        font-size: clamp(23px, 3.2vw, 34px);
        font-weight: 900;
        color: #0b1b17;
        margin: 0 0 14px;
        font-family: var(--font-ar);
    }
    .portfolio-cta-box p {
        color: #4b5e57;
        font-size: 15.5px;
        max-width: 650px;
        margin: 0 auto 30px;
        line-height: 1.8;
        font-family: var(--font-ar);
    }
    .portfolio-cta-box .btn-primary {
        background: #1D8A68;
        color: #ffffff;
        border: none;
        border-radius: 50px;
        font-weight: 800;
        box-shadow: 0 6px 22px rgba(29, 138, 104, 0.35);
        transition: all 0.25s ease;
    }
    .portfolio-cta-box .btn-primary:hover {
        background: #167054;
        box-shadow: 0 8px 26px rgba(29, 138, 104, 0.45);
        transform: translateY(-2px);
    }

    @media (max-width: 1080px) {
        .ox-portfolio-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }
    @media (max-width: 680px) {
        .ox-portfolio-grid {
            grid-template-columns: 1fr;
            gap: 18px;
        }
        .portfolio-hero-stats {
            gap: 12px;
        }
        .portfolio-stat-box {
            padding: 10px 16px;
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<main class="portfolio-archive-page">

    <!-- ─── 1. Header / Hero Section ─── -->
    <section class="portfolio-hero-section">
        <div class="container portfolio-hero-inner">
            <!-- Breadcrumbs -->
            <nav class="portfolio-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">{{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}</a>
                <span class="sep">/</span>
                <span class="current">{{ $locale === 'ar' ? 'سابقة الأعمال' : ($locale === 'fr' ? 'Portfolio' : 'Portfolio') }}</span>
            </nav>

          

            <h1 class="portfolio-page-title">
                {{ $locale === 'ar' ? 'أعمالنا تتكلم: ابتكار برمجي يصنع فارقاً حقيقياً' : ($locale === 'fr' ? 'Nos Réalisations: Impact & Excellence' : 'Our Proven Track Record: Built for Real Impact') }}
            </h1>

            <p class="portfolio-page-subtitle">
                {{ $locale === 'ar' 
                    ? 'استكشف كافة الحلول والمنصات السحابية وتطبيقات الجوال والأنظمة المؤسسية التي طوّرناها لشركائنا في السعودية ومصر والإمارات مع مؤشرات أداء ونتائج واقعية.' 
                    : ($locale === 'fr' 
                        ? 'Explorez l\'ensemble de nos plateformes cloud, applications mobiles et solutions logicielles d\'entreprise conçues pour nos partenaires régionaux et internationaux.' 
                        : 'Discover the complete showcase of custom cloud architectures, SaaS products, and mobile applications engineered for enterprise partners across Saudi Arabia, Egypt, and the Gulf.') }}
            </p>

        </div>
    </section>

    <!-- ─── 2. Filter & Grid Section ─── -->
    <section class="portfolio-content-section">
        <div class="container">
            <!-- Smart Client-Friendly Filter Bar -->
            <div class="portfolio-filter-container" id="archiveFilterContainer">
                <!-- Row 1: Visual Country Flags Strip (User Reference Replica) -->
                <style>
                    .portfolio-country-flags-strip-wrap {
                        width: 100%;
                        background: #ffffff;
                        border: 1px solid #eef2f6;
                        border-radius: 20px;
                        padding: 16px 20px;
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
                        margin-bottom: 20px;
                        position: relative;
                    }
                    .portfolio-country-flags-strip {
                        display: flex !important;
                        align-items: center !important;
                        justify-content: flex-start !important;
                        gap: 26px !important;
                        width: 100% !important;
                        overflow-x: auto !important;
                        scrollbar-width: none !important;
                        -ms-overflow-style: none !important;
                        -webkit-overflow-scrolling: touch !important;
                        padding: 4px 2px !important;
                    }
                    .portfolio-country-flags-strip::-webkit-scrollbar {
                        display: none !important;
                    }
                    .country-flag-strip-btn {
                        display: flex !important;
                        flex-direction: column !important;
                        align-items: center !important;
                        justify-content: center !important;
                        gap: 6px !important;
                        background: transparent !important;
                        border: none !important;
                        outline: none !important;
                        box-shadow: none !important;
                        cursor: pointer !important;
                        padding: 2px 4px !important;
                        margin: 0 !important;
                        border-radius: 12px !important;
                        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease !important;
                        min-width: 52px !important;
                        flex-shrink: 0 !important;
                        user-select: none !important;
                        -webkit-tap-highlight-color: transparent !important;
                    }
                    .country-flag-strip-btn:hover {
                        transform: translateY(-2px) !important;
                    }
                    .country-flag-strip-btn:active {
                        transform: scale(0.96) !important;
                    }
                    .flag-strip-avatar {
                        width: 44px !important;
                        height: 44px !important;
                        min-width: 44px !important;
                        min-height: 44px !important;
                        max-width: 44px !important;
                        max-height: 44px !important;
                        border-radius: 50% !important;
                        overflow: hidden !important;
                        display: flex !important;
                        align-items: center !important;
                        justify-content: center !important;
                        position: relative !important;
                        background: #ffffff !important;
                        border: 1px solid rgba(0, 0, 0, 0.08) !important;
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
                        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1) !important;
                        box-sizing: border-box !important;
                    }
                    .country-flag-strip-btn:hover .flag-strip-avatar {
                        border-color: #cbd5e1 !important;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
                    }
                    .flag-strip-img {
                        width: 100% !important;
                        height: 100% !important;
                        object-fit: cover !important;
                        border-radius: 50% !important;
                        display: block !important;
                    }
                    .flag-strip-emoji {
                        font-size: 22px !important;
                        line-height: 1 !important;
                    }
                    .flag-strip-label {
                        font-size: 13.5px !important;
                        font-weight: 700 !important;
                        color: #1e293b !important;
                        text-align: center !important;
                        white-space: nowrap !important;
                        line-height: 1.25 !important;
                        font-family: inherit !important;
                        transition: color 0.2s ease !important;
                    }
                    .country-flag-strip-btn:hover .flag-strip-label {
                        color: #1D8A68 !important;
                    }
                    .country-flag-strip-btn.active .flag-strip-avatar {
                        border-color: #1D8A68 !important;
                        box-shadow: 0 0 0 3px rgba(29, 138, 104, 0.22), 0 6px 14px rgba(29, 138, 104, 0.25) !important;
                        transform: scale(1.06) !important;
                    }
                    .country-flag-strip-btn.active .flag-strip-label {
                        color: #1D8A68 !important;
                        font-weight: 800 !important;
                    }
                    .globe-avatar {
                        background: #f8fafc !important;
                        border-color: #e2e8f0 !important;
                        color: #475569 !important;
                    }
                    .country-flag-strip-btn.active .globe-avatar {
                        background: #ecfdf5 !important;
                        color: #1D8A68 !important;
                        border-color: #1D8A68 !important;
                        box-shadow: 0 0 0 3px rgba(29, 138, 104, 0.22), 0 6px 14px rgba(29, 138, 104, 0.25) !important;
                    }
                    .country-flag-strip-dropdown-wrap {
                        position: relative !important;
                        display: inline-flex !important;
                        flex-direction: column !important;
                        align-items: center !important;
                        flex-shrink: 0 !important;
                    }
                    .other-avatar {
                        background: #ffffff !important;
                        border: 1.5px solid #cbd5e1 !important;
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
                    }
                    .other-count-text {
                        font-size: 13.5px !important;
                        font-weight: 800 !important;
                        color: #334155 !important;
                        letter-spacing: -0.3px !important;
                    }
                    .country-flag-strip-btn.other-countries-btn.active .other-avatar {
                        border-color: #1D8A68 !important;
                        background: #ecfdf5 !important;
                        box-shadow: 0 0 0 3px rgba(29, 138, 104, 0.22) !important;
                    }
                    .country-flag-strip-btn.other-countries-btn.active .other-count-text {
                        color: #1D8A68 !important;
                    }
                    .other-countries-menu {
                        position: absolute !important;
                        top: calc(100% + 12px) !important;
                        z-index: 9999 !important;
                        width: 320px !important;
                        background: #ffffff !important;
                        border: 1px solid #e2e8f0 !important;
                        border-radius: 18px !important;
                        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.16), 0 4px 12px rgba(0, 0, 0, 0.06) !important;
                        padding: 14px !important;
                        display: none;
                    }
                    html[dir="rtl"] .other-countries-menu {
                        left: 0 !important;
                        right: auto !important;
                    }
                    html[dir="ltr"] .other-countries-menu {
                        right: 0 !important;
                        left: auto !important;
                    }
                    .other-countries-menu.show {
                        display: block !important;
                        animation: oxDropdownFade 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
                    }
                    .other-countries-header {
                        display: flex !important;
                        align-items: center !important;
                        justify-content: space-between !important;
                        padding: 2px 4px 10px 4px !important;
                        border-bottom: 1px solid #f1f5f9 !important;
                        font-size: 13px !important;
                        font-weight: 800 !important;
                        color: #475569 !important;
                    }
                    .other-header-count {
                        background: #f1f5f9 !important;
                        color: #334155 !important;
                        font-size: 11px !important;
                        font-weight: 800 !important;
                        padding: 2px 8px !important;
                        border-radius: 10px !important;
                    }
                    .other-countries-grid {
                        display: grid !important;
                        grid-template-columns: 1fr 1fr !important;
                        gap: 6px !important;
                        max-height: 280px !important;
                        overflow-y: auto !important;
                        padding-top: 10px !important;
                        scrollbar-width: thin !important;
                    }
                    .other-country-item {
                        display: flex !important;
                        align-items: center !important;
                        gap: 8px !important;
                        padding: 8px 10px !important;
                        border-radius: 10px !important;
                        background: #f8fafc !important;
                        border: 1px solid transparent !important;
                        cursor: pointer !important;
                        transition: all 0.15s ease !important;
                        font-family: inherit !important;
                        text-align: inherit !important;
                        width: 100% !important;
                        box-sizing: border-box !important;
                    }
                    .other-country-item:hover {
                        background: #f0fdf4 !important;
                        border-color: #a7f3d0 !important;
                        transform: translateY(-1px) !important;
                    }
                    .other-country-item.active {
                        background: #ecfdf5 !important;
                        border-color: #1D8A68 !important;
                        font-weight: 800 !important;
                        color: #1D8A68 !important;
                    }
                    .other-item-flag {
                        width: 22px !important;
                        height: 22px !important;
                        border-radius: 50% !important;
                        overflow: hidden !important;
                        flex-shrink: 0 !important;
                        display: flex !important;
                        align-items: center !important;
                        justify-content: center !important;
                    }
                    .other-flag-img {
                        width: 100% !important;
                        height: 100% !important;
                        object-fit: cover !important;
                        border-radius: 50% !important;
                    }
                    .other-item-name {
                        font-size: 12.5px !important;
                        font-weight: 700 !important;
                        color: #1e293b !important;
                        flex: 1 !important;
                        white-space: nowrap !important;
                        overflow: hidden !important;
                        text-overflow: ellipsis !important;
                    }
                    .other-item-count {
                        font-size: 10.5px !important;
                        font-weight: 800 !important;
                        color: #1D8A68 !important;
                        background: #ffffff !important;
                        border: 1px solid #a7f3d0 !important;
                        padding: 1px 6px !important;
                        border-radius: 8px !important;
                    }
                </style>
                <div class="portfolio-country-flags-strip-wrap">
                    <div class="portfolio-country-flags-strip" id="archiveCountryStrip" role="tablist" aria-label="{{ $locale === 'ar' ? 'فلتر المشاريع حسب الدولة' : 'Filter projects by country' }}">
                        <!-- 1. All Countries Option (Default Active) -->
                        <button type="button" 
                                class="country-flag-strip-btn active" 
                                data-country="all" 
                                id="archiveFlagBtnAll" 
                                onclick="selectArchiveCountry('all', '{{ $locale === 'ar' ? 'كل الدول' : ($locale === 'fr' ? 'Tous les pays' : 'All Countries') }}', null)" 
                                title="{{ $locale === 'ar' ? 'كل الدول' : ($locale === 'fr' ? 'Tous les pays' : 'All Countries') }}">
                            <span class="flag-strip-avatar globe-avatar">
                                <svg class="globe-strip-svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </span>
                            <span class="flag-strip-label">{{ $locale === 'ar' ? 'كل الدول' : ($locale === 'fr' ? 'Tous les pays' : 'All Countries') }}</span>
                        </button>

                        <!-- 2. Display Countries (Circular Flags) -->
                        @foreach($displayCountries as $country)
                            @php
                                $cLower = strtolower($country->country_code);
                                $cName = ($locale === 'en' && !empty($country->country_name_en)) ? $country->country_name_en : $country->country_name;
                                $cCount = $projects->filter(fn($p) => strtolower($p->country_code) === $cLower)->count();
                            @endphp
                            <button type="button" 
                                    class="country-flag-strip-btn" 
                                    data-country="{{ $cLower }}" 
                                    id="archiveFlagBtn_{{ $cLower }}" 
                                    onclick="selectArchiveCountry('{{ $cLower }}', '{{ addslashes($cName) }}', '{{ $country->flag_url }}')" 
                                    title="{{ $cName }}">
                                <span class="flag-strip-avatar">
                                    @if(!empty($country->flag_url))
                                        <img src="{{ $country->flag_url }}" class="flag-strip-img" alt="{{ $cName }}" loading="lazy">
                                    @else
                                        <span class="flag-strip-emoji">🌐</span>
                                    @endif
                                </span>
                                <span class="flag-strip-label">{{ $cName }}</span>
                            </button>
                        @endforeach

                        <!-- 3. Other Countries Dropdown (+13 دول أخرى) -->
                        @if(isset($otherCountries) && $otherCountries->isNotEmpty())
                            <div class="country-flag-strip-dropdown-wrap" id="archiveOtherCountriesWrap">
                                <button type="button" 
                                        class="country-flag-strip-btn other-countries-btn" 
                                        id="archiveOtherCountriesBtn" 
                                        onclick="toggleArchiveOtherCountriesDropdown(event)" 
                                        aria-haspopup="true" 
                                        aria-expanded="false" 
                                        title="{{ $locale === 'ar' ? 'دول أخرى' : 'Other Countries' }}">
                                    <span class="flag-strip-avatar other-avatar" id="archiveOtherCountriesAvatar">
                                        <span class="other-count-text">{{ $otherCountries->count() }}+</span>
                                    </span>
                                    <span class="flag-strip-label" id="archiveOtherCountriesLabel">{{ $locale === 'ar' ? 'دول اخرى' : ($locale === 'fr' ? 'Autres pays' : 'Other countries') }}</span>
                                </button>

                                <div class="other-countries-menu" id="archiveOtherCountriesMenu">
                                    <div class="other-countries-header">
                                        <span>{{ $locale === 'ar' ? 'اختر الدولة' : 'Select Country' }}</span>
                                        <span class="other-header-count">+{{ $otherCountries->count() }}</span>
                                    </div>
                                    <div class="other-countries-grid">
                                        @foreach($otherCountries as $oCountry)
                                            @php
                                                $ocLower = strtolower($oCountry->country_code);
                                                $ocName = ($locale === 'en' && !empty($oCountry->country_name_en)) ? $oCountry->country_name_en : $oCountry->country_name;
                                                $ocCount = $projects->filter(fn($p) => strtolower($p->country_code) === $ocLower)->count();
                                            @endphp
                                            <button type="button" 
                                                    class="other-country-item" 
                                                    data-country="{{ $ocLower }}" 
                                                    onclick="selectArchiveCountry('{{ $ocLower }}', '{{ addslashes($ocName) }}', '{{ $oCountry->flag_url }}', true)">
                                                <span class="other-item-flag">
                                                    @if(!empty($oCountry->flag_url))
                                                        <img src="{{ $oCountry->flag_url }}" class="other-flag-img" alt="{{ $ocName }}" loading="lazy">
                                                    @else
                                                        <span>🌐</span>
                                                    @endif
                                                </span>
                                                <span class="other-item-name">{{ $ocName }}</span>
                                                @if($ocCount > 0)
                                                    <span class="other-item-count">{{ $ocCount }}</span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Row 2: Live Search & Reset Action -->
                <div class="portfolio-filter-toolbar">
                    <!-- Live Search Box -->
                    <div class="portfolio-search-wrap">
                        <svg class="portfolio-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" 
                               id="portfolioSearchInput" 
                               class="portfolio-search-input" 
                               placeholder="{{ $locale === 'ar' ? 'ابحث عن فكرة أو مجال (مثال: متجر، سيارات، عيادة)...' : ($locale === 'fr' ? 'Rechercher une idée, secteur (ex: e-commerce, santé)...' : 'Search by idea or sector (e.g. store, booking, medical)...') }}" 
                               autocomplete="off" 
                               oninput="handleSearchPortfolio(this.value)">
                        <button type="button" id="archiveSearchClear" class="portfolio-search-clear" onclick="clearArchiveSearch()" style="display:none;" title="{{ $locale === 'ar' ? 'مسح البحث' : 'Clear search' }}">✕</button>
                    </div>

                    <!-- Reset Filter Button -->
                    <button type="button" class="portfolio-reset-pill-btn" id="archiveResetBtn" style="display:none;" onclick="resetArchiveFilter()" title="{{ $locale === 'ar' ? 'إعادة تعيين الفلاتر' : 'Reset filters' }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <span>{{ $locale === 'ar' ? 'إلغاء الفلتر' : ($locale === 'fr' ? 'Réinitialiser' : 'Reset') }}</span>
                    </button>
                </div>

                <!-- Row 2: Client-Friendly Business Sector Tabs (SVG Vector Icons, No Emojis) -->
                <div class="portfolio-sector-tabs-wrap">
                    <div class="portfolio-sector-tabs" id="archiveSectorTabs">
                        <button type="button" class="portfolio-sector-tab portfolio-cat-btn active" data-cat="all" onclick="selectArchiveSector('all', this)">
                            <span class="tab-icon">
                                <svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                                    <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                                    <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                                    <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                                </svg>
                            </span>
                            <span class="tab-title">{{ $locale === 'ar' ? 'جميع المشاريع' : ($locale === 'fr' ? 'Tous les projets' : 'All Projects') }}</span>
                            <span class="tab-badge">{{ $projects->count() }}</span>
                        </button>

                        @php
                            $sectorSvgIcons = [
                                'commerce' => '<svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>',
                                'auto' => '<svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.7C1.4 11 1 11.9 1 12.8V16c0 .6.4 1 1 1h2"></path><circle cx="7" cy="17" r="2"></circle><path d="M9 17h6"></path><circle cx="17" cy="17" r="2"></circle></svg>',
                                'health' => '<svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',
                                'legal' => '<svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18"></path><path d="M5 21h14"></path><path d="M4 7l4 8h-8z"></path><path d="M20 7l4 8h-8z"></path></svg>',
                                'education' => '<svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
                                'creative' => '<svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>',
                                'telecom' => '<svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg>',
                                'marine' => '<svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="3"></circle><line x1="12" y1="22" x2="12" y2="8"></line><path d="M5 12H2a10 10 0 0 0 20 0h-3"></path></svg>',
                                'logistics' => '<svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>',
                            ];
                            $defaultSectorSvg = '<svg class="tab-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>';
                        @endphp

                        @foreach($sectors as $sec)
                            @php
                                $sCount = $projects->where('sector_slug', $sec->sector_slug)->count();
                                $iconSvg = $sectorSvgIcons[$sec->sector_slug] ?? $defaultSectorSvg;
                            @endphp
                            <button type="button" class="portfolio-sector-tab portfolio-cat-btn" data-cat="{{ $sec->sector_slug }}" onclick="selectArchiveSector('{{ $sec->sector_slug }}', this)">
                                <span class="tab-icon">{!! $iconSvg !!}</span>
                                <span class="tab-title">{{ $sec->sector_name }}</span>
                                @if($sCount > 0)
                                    <span class="tab-badge">{{ $sCount }}</span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ─── Portfolio Grid ─── -->
            <div class="ox-portfolio-grid" id="archivePortfolioGrid">
                @forelse($projects as $project)
                    @php
                        $countryLower = strtolower($project->country_code ?? '');
                        $projectSector = $project->sector_slug ?? 'general';
                        $projectImg = $project->display_image;
                        $techs = is_array($project->technologies) ? $project->technologies : [];
                    @endphp
                    <article class="ox-portfolio-card" 
                             data-category="{{ $projectSector }}" 
                             data-country="{{ $countryLower }}"
                             data-title="{{ strtolower($project->title) }}"
                             data-client="{{ strtolower($project->client_name ?? '') }}"
                             data-tech="{{ strtolower(implode(' ', $techs)) }}"
                             data-search="{{ mb_strtolower($project->title . ' ' . $project->sector_name . ' ' . $project->country_name . ' ' . $project->subtitle . ' ' . ($project->short_description ?? '') . ' ' . ($project->client_name ?? '')) }}"
                             onclick="window.location.href='{{ route('projects.show', $project->slug) }}'">
                        
                        <!-- Thumbnail Media -->
                        <div class="portfolio-card-media">
                            <img src="{{ $projectImg }}" 
                                 alt="{{ $project->title }}" 
                                 loading="lazy" 
                                 class="portfolio-card-img" />
                            <div class="portfolio-card-overlay"></div>
                            
                            <!-- Badges -->
                            <div class="portfolio-badges-top">
                                <span class="portfolio-country-badge">
                                    <span class="badge-flag">
                                        @if($project->country_flag_url)
                                            <img src="{{ $project->country_flag_url }}" class="badge-flag-img" alt="{{ $project->country_name }}" loading="lazy">
                                        @else
                                            {{ $project->country_flag }}
                                        @endif
                                    </span>
                                    <span>{{ $project->country_name }}</span>
                                </span>
                                @if($project->sector_name)
                                    <span class="portfolio-sector-badge">
                                        {{ $project->sector_name }}
                                    </span>
                                @endif
                                @if($project->is_featured)
                                    <span class="portfolio-featured-badge" style="display: inline-flex; align-items: center; gap: 5px; background: rgba(184, 255, 44, 0.18); border: 1px solid rgba(184, 255, 44, 0.4); padding: 5px 11px; border-radius: 99px; color: #b8ff2c; font-size: 11px; font-weight: 700; backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="#b8ff2c" stroke="#b8ff2c" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <span>{{ app()->getLocale() === 'en' ? 'Featured' : (app()->getLocale() === 'fr' ? 'En vedette' : 'مشروع مميز') }}</span>
                                    </span>
                                @endif
                            </div>

                            @if($project->impact_stat)
                                <span class="portfolio-impact-chip">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                    <span>{{ $project->impact_stat }}</span>
                                </span>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="portfolio-card-body">
                            <div class="portfolio-card-head">
                                @if($project->client_name)
                                    <span class="portfolio-client-name">{{ $project->client_name }}</span>
                                @endif
                                <h3 class="portfolio-card-title">{{ $project->title }}</h3>
                                <p class="portfolio-card-desc">
                                    {{ $project->short_description ?: Str::limit($project->summary, 110) }}
                                </p>
                            </div>

                            <!-- Tech Tags -->
                            @if(!empty($project->technologies) && is_array($project->technologies))
                                <div class="portfolio-tech-tags">
                                    @foreach(array_slice($project->technologies, 0, 4) as $tech)
                                        <span class="tech-tag">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Card Footer -->
                            <div class="portfolio-card-foot">
                                <span class="portfolio-view-text">
                                    {{ $locale === 'ar' ? 'عرض دراسة الحالة والتفاصيل' : ($locale === 'fr' ? 'Voir l\'étude de cas' : 'View Full Case Study') }}
                                </span>
                                <span class="portfolio-view-btn" aria-label="{{ $locale === 'ar' ? 'تفاصيل' : 'Details' }}">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="{{ $locale === 'ar' ? '15 18 9 12 15 6' : '9 18 15 12 9 6' }}"></polyline>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="portfolio-empty-state" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                        <p style="font-size: 16px; color: #94a3b8;">{{ $locale === 'ar' ? 'لا توجد مشاريع مضافة حالياً.' : 'No projects available.' }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Empty Filter Result Alert -->
            <div id="archiveNoResults" class="portfolio-no-results" style="display: none;">
                <div class="no-results-icon">🔍</div>
                <h4>{{ $locale === 'ar' ? 'لم نجد مشاريع تطابق بحثك' : 'No matching projects found' }}</h4>
                <p>{{ $locale === 'ar' ? 'جرّب تعديل كلمة البحث، أو تصفح كافة تصنيفات المشاريع.' : 'Try adjusting your search or filters' }}</p>
                <button type="button" class="btn-primary" onclick="resetArchiveFilter()" style="margin-top:15px; font-size:13px; padding:10px 24px;">
                    {{ $locale === 'ar' ? 'إعادة ضبط الفلاتر' : 'Reset Filters' }}
                </button>
            </div>

            <!-- ─── 3. Consultation CTA Section ─── -->
            <div class="portfolio-cta-box reveal">
                <h3>{{ $locale === 'ar' ? 'هل تخطط لإطلاق أو تطوير مشروعك البرمجي القادم؟' : 'Ready to Build Your Next Digital Product?' }}</h3>
                <p>
                    {{ $locale === 'ar' 
                        ? 'فريق OX Tech الهندسي جاهز لتحويل متطلباتك إلى منصة متكاملة عالية الأداء وقابلة للتوسع. احجز جلستك الاستشارية التقنية المجانية الآن.' 
                        : 'Our engineering team is ready to transform your vision into a scalable, high-performance platform. Book your free technical consultation today.' }}
                </p>
                <button type="button" class="btn-primary" onclick="openConsultModal(); return false;" style="display: inline-flex; align-items: center; gap: 10px; font-size: 15px; padding: 14px 34px;">
                    <span>{{ $locale === 'ar' ? 'احجز استشارتك التقنية المجانية' : 'Book Free Consultation' }}</span>
                    <span style="font-weight: 800;">{{ $locale === 'ar' ? '←' : '→' }}</span>
                </button>
            </div>
        </div>
    </section>

</main>
@endsection

@push('scripts')
<script>
    // Smart Filter & Instant Search for Archive Portfolio Page
    let archiveCat = 'all';
    let archiveCountry = 'all';
    let archiveSearch = '';

    window.selectArchiveSector = function(sectorSlug, btn) {
        archiveCat = sectorSlug;
        document.querySelectorAll('#archiveSectorTabs .portfolio-sector-tab').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');
        applyArchiveFilters();
    };

    window.toggleArchiveOtherCountriesDropdown = function(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        const menu = document.getElementById('archiveOtherCountriesMenu');
        const btn = document.getElementById('archiveOtherCountriesBtn');
        if (!menu) return;
        menu.classList.toggle('show');
        if (btn) btn.classList.toggle('open');
    };

    window.closeArchiveOtherCountriesDropdown = function() {
        const menu = document.getElementById('archiveOtherCountriesMenu');
        const btn = document.getElementById('archiveOtherCountriesBtn');
        if (menu) menu.classList.remove('show');
        if (btn) btn.classList.remove('open');
    };

    window.selectArchiveCountry = function(code, name, flagUrl, isFromOtherMenu = false) {
        archiveCountry = code;

        // Toggle active states
        document.querySelectorAll('#archiveCountryStrip .country-flag-strip-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('#archiveOtherCountriesMenu .other-country-item').forEach(b => b.classList.remove('active'));

        const otherBtn = document.getElementById('archiveOtherCountriesBtn');
        const otherLabel = document.getElementById('archiveOtherCountriesLabel');
        const otherAvatar = document.getElementById('archiveOtherCountriesAvatar');

        if (code === 'all') {
            const allBtn = document.getElementById('archiveFlagBtnAll');
            if (allBtn) allBtn.classList.add('active');
            if (otherLabel) otherLabel.textContent = '{{ $locale === 'ar' ? 'دول اخرى' : ($locale === 'fr' ? 'Autres pays' : 'Other countries') }}';
            if (otherAvatar) otherAvatar.innerHTML = '<span class="other-count-text">{{ $otherCountries->count() }}+</span>';
        } else if (isFromOtherMenu) {
            if (otherBtn) otherBtn.classList.add('active');
            if (otherLabel) otherLabel.textContent = name;
            if (otherAvatar) {
                if (flagUrl) {
                    otherAvatar.innerHTML = `<img src="${flagUrl}" class="flag-strip-img" alt="${name}">`;
                } else {
                    otherAvatar.innerHTML = '<span class="other-count-text">🌐</span>';
                }
            }
            const activeItem = document.querySelector(`#archiveOtherCountriesMenu .other-country-item[data-country="${code}"]`);
            if (activeItem) activeItem.classList.add('active');
        } else {
            const stripBtn = document.getElementById(`archiveFlagBtn_${code}`);
            if (stripBtn) stripBtn.classList.add('active');
            if (otherLabel) otherLabel.textContent = '{{ $locale === 'ar' ? 'دول اخرى' : ($locale === 'fr' ? 'Autres pays' : 'Other countries') }}';
            if (otherAvatar) otherAvatar.innerHTML = '<span class="other-count-text">{{ $otherCountries->count() }}+</span>';
        }

        closeArchiveOtherCountriesDropdown();
        applyArchiveFilters();
    };

    window.handleSearchPortfolio = function(term) {
        archiveSearch = (term || '').trim().toLowerCase();
        const clearBtn = document.getElementById('archiveSearchClear');
        if (clearBtn) {
            clearBtn.style.display = archiveSearch.length > 0 ? 'inline-flex' : 'none';
        }
        applyArchiveFilters();
    };

    window.clearArchiveSearch = function() {
        const input = document.getElementById('portfolioSearchInput');
        if (input) input.value = '';
        archiveSearch = '';
        const clearBtn = document.getElementById('archiveSearchClear');
        if (clearBtn) clearBtn.style.display = 'none';
        applyArchiveFilters();
    };

    function applyArchiveFilters() {
        const cards = document.querySelectorAll('#archivePortfolioGrid .ox-portfolio-card');
        let visibleCount = 0;

        const hasActiveFilter = (archiveCat !== 'all' || archiveCountry !== 'all' || archiveSearch.length > 0);
        const resetBtn = document.getElementById('archiveResetBtn');
        if (resetBtn) {
            resetBtn.style.display = hasActiveFilter ? 'inline-flex' : 'none';
        }

        cards.forEach(card => {
            const cardCat = card.getAttribute('data-category') || '';
            const cardCountry = (card.getAttribute('data-country') || '').toLowerCase();
            const cardSearch = (card.getAttribute('data-search') || card.getAttribute('data-title') || '').toLowerCase();

            const matchCat = (archiveCat === 'all' || cardCat === archiveCat);
            const matchCountry = (archiveCountry === 'all' || cardCountry === archiveCountry);
            const matchSearch = (!archiveSearch || cardSearch.includes(archiveSearch));

            if (matchCat && matchCountry && matchSearch) {
                card.style.display = 'flex';
                visibleCount++;
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0) scale(1)';
                }, 20);
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(12px) scale(0.98)';
                setTimeout(() => {
                    if (card.style.opacity === '0') {
                        card.style.display = 'none';
                    }
                }, 200);
            }
        });

        const noRes = document.getElementById('archiveNoResults');
        if (noRes) {
            noRes.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    window.filterArchivePortfolio = function(type, value, btn) {
        if (type === 'cat') {
            selectArchiveSector(value, btn);
        } else if (type === 'country') {
            selectArchiveCountry(value, value, null);
        } else {
            applyArchiveFilters();
        }
    };

    window.resetArchiveFilter = function() {
        archiveCat = 'all';
        archiveCountry = 'all';
        archiveSearch = '';
        const input = document.getElementById('portfolioSearchInput');
        if (input) input.value = '';
        const clearBtn = document.getElementById('archiveSearchClear');
        if (clearBtn) clearBtn.style.display = 'none';

        document.querySelectorAll('#archiveSectorTabs .portfolio-sector-tab').forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-cat') === 'all');
        });

        selectArchiveCountry('all', '{{ $locale === 'ar' ? 'كل الدول' : ($locale === 'fr' ? 'Tous les pays' : 'All Countries') }}', null);
    };

    document.addEventListener('click', function(e) {
        const wrap = document.getElementById('archiveOtherCountriesWrap');
        if (wrap && !wrap.contains(e.target)) {
            closeArchiveOtherCountriesDropdown();
        }
    });

    // Initial filter execution to apply default all countries filter
    applyArchiveFilters();
</script>
@endpush
