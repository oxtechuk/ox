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
       OX TECH — FULL PORTFOLIO SHOWCASE PAGE
       ═══════════════════════════════════════════════════════════════ */
    .portfolio-archive-page {
        background-color: #030e15;
        color: #e2e8f0;
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    /* Ambient Background Glows */
    .portfolio-archive-page::before {
        content: '';
        position: absolute;
        top: -100px;
        right: 10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(22, 98, 196, 0.12) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }
    .portfolio-archive-page::after {
        content: '';
        position: absolute;
        top: 400px;
        left: 5%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(189, 255, 69, 0.06) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    /* Hero Section */
    .portfolio-hero-section {
        padding: 150px 0 50px;
        position: relative;
        text-align: center;
        background: radial-gradient(ellipse at 50% 0%, rgba(10, 31, 51, 0.7) 0%, #030e15 80%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
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
        color: #8da49e;
        margin-bottom: 22px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.07);
        padding: 6px 18px;
        border-radius: 30px;
    }
    .portfolio-breadcrumb a {
        color: #b8ccc6;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .portfolio-breadcrumb a:hover {
        color: #bdff45;
    }
    .portfolio-breadcrumb .sep {
        opacity: 0.4;
    }
    .portfolio-breadcrumb .current {
        color: #ffffff;
        font-weight: 600;
    }

    .portfolio-page-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #bdff45;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 14px;
    }
    .portfolio-page-kicker-dot {
        width: 8px;
        height: 8px;
        background: #bdff45;
        border-radius: 50%;
        box-shadow: 0 0 10px #bdff45;
    }

    .portfolio-page-title {
        font-size: clamp(28px, 4.5vw, 48px);
        font-weight: 800;
        line-height: 1.25;
        color: #ffffff;
        margin: 0 0 18px;
    }
    .portfolio-page-title .highlight {
        color: #bdff45;
        background: linear-gradient(135deg, #bdff45 0%, #34d399 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .portfolio-page-subtitle {
        font-size: clamp(14px, 1.8vw, 17px);
        line-height: 1.8;
        color: #94a3b8;
        max-width: 760px;
        margin: 0 auto 32px;
    }

    /* Hero Quick Stats */
    .portfolio-hero-stats {
        display: flex;
        justify-content: center;
        gap: 32px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    .portfolio-stat-box {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(10, 31, 51, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 10px 20px;
        border-radius: 12px;
        backdrop-filter: blur(8px);
    }
    .portfolio-stat-num {
        font-size: 22px;
        font-weight: 800;
        color: #bdff45;
        font-family: var(--font-en, sans-serif);
    }
    .portfolio-stat-label {
        font-size: 12px;
        color: #cbd5e1;
    }

    /* Main Showcase Content Area */
    .portfolio-content-section {
        padding: 50px 0 100px;
        position: relative;
        z-index: 2;
    }

    /* Search & Filter Top Bar */
    .portfolio-search-filter-wrap {
        margin-bottom: 32px;
    }
    .portfolio-search-box {
        position: relative;
        max-width: 460px;
        margin: 0 auto 24px;
    }
    .portfolio-search-input {
        width: 100%;
        background: rgba(10, 31, 51, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #ffffff;
        padding: 12px 44px 12px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        outline: none;
        transition: all 0.25s ease;
    }
    html[dir="rtl"] .portfolio-search-input {
        padding: 12px 18px 12px 44px;
    }
    .portfolio-search-input:focus {
        border-color: #bdff45;
        box-shadow: 0 0 18px rgba(189, 255, 69, 0.2);
        background: rgba(10, 31, 51, 0.95);
    }
    .portfolio-search-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        pointer-events: none;
        inset-inline-end: 16px;
    }

    /* Project Cards Hover & Transitions */
    .ox-portfolio-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px;
        position: relative;
        z-index: 2;
    }
    .ox-portfolio-card {
        background: linear-gradient(180deg, rgba(12, 28, 42, 0.85) 0%, rgba(6, 17, 28, 0.96) 100%);
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s ease, border-color 0.35s ease, opacity 0.25s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        position: relative;
    }
    .ox-portfolio-card:hover {
        transform: translateY(-8px);
        border-color: rgba(189, 255, 69, 0.45);
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.6), 0 0 30px rgba(189, 255, 69, 0.16);
    }

    /* Bottom CTA Card */
    .portfolio-cta-box {
        margin-top: 80px;
        background: radial-gradient(ellipse at 50% 0%, rgba(22, 98, 196, 0.2) 0%, rgba(10, 31, 51, 0.8) 100%);
        border: 1px solid rgba(189, 255, 69, 0.25);
        border-radius: 24px;
        padding: 50px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.4);
    }
    .portfolio-cta-box h3 {
        font-size: clamp(22px, 3vw, 32px);
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 12px;
    }
    .portfolio-cta-box p {
        color: #94a3b8;
        font-size: 15px;
        max-width: 600px;
        margin: 0 auto 28px;
        line-height: 1.7;
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
            padding: 8px 14px;
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

            <div class="portfolio-page-kicker">
                <span class="portfolio-page-kicker-dot"></span>
                <span>{{ $locale === 'ar' ? 'معرض المشاريع والحلول التقنية' : ($locale === 'fr' ? 'Portfolio des Projets OX Tech' : 'Engineered Digital Systems') }}</span>
            </div>

            <h1 class="portfolio-page-title">
                {{ $locale === 'ar' ? 'أعمالنا تتكلم:' : ($locale === 'fr' ? 'Nos Réalisations:' : 'Our Proven Track Record:') }}
                <span class="highlight">{{ $locale === 'ar' ? 'ابتكار برمجي يصنع فارقاً حقيقياً' : ($locale === 'fr' ? 'Impact & Excellence' : 'Built for Real Impact') }}</span>
            </h1>

            <p class="portfolio-page-subtitle">
                {{ $locale === 'ar' 
                    ? 'استكشف كافة الحلول والمنصات السحابية وتطبيقات الجوال والأنظمة المؤسسية التي طوّرناها لشركائنا في السعودية ومصر والإمارات مع مؤشرات أداء ونتائج واقعية.' 
                    : ($locale === 'fr' 
                        ? 'Explorez l\'ensemble de nos plateformes cloud, applications mobiles et solutions logicielles d\'entreprise conçues pour nos partenaires régionaux et internationaux.' 
                        : 'Discover the complete showcase of custom cloud architectures, SaaS products, and mobile applications engineered for enterprise partners across Saudi Arabia, Egypt, and the Gulf.') }}
            </p>

            <div class="portfolio-hero-stats">
                <div class="portfolio-stat-box">
                    <span class="portfolio-stat-num">{{ $allProjectsCount }}+</span>
                    <span class="portfolio-stat-label">{{ $locale === 'ar' ? 'مشروع ومنصة منجزة' : ($locale === 'fr' ? 'Projets Livrés' : 'Delivered Platforms') }}</span>
                </div>
                <div class="portfolio-stat-box">
                    <span class="portfolio-stat-num">{{ count($countries) }}+</span>
                    <span class="portfolio-stat-label">{{ $locale === 'ar' ? 'دول إقليمية وعالمية' : ($locale === 'fr' ? 'Pays Couverts' : 'Active Markets') }}</span>
                </div>
                <div class="portfolio-stat-box">
                    <span class="portfolio-stat-num">99.8%</span>
                    <span class="portfolio-stat-label">{{ $locale === 'ar' ? 'رضا والتزام بالجودة' : ($locale === 'fr' ? 'Satisfaction Client' : 'Client Satisfaction') }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── 2. Filter & Grid Section ─── -->
    <section class="portfolio-content-section">
        <div class="container">
            <!-- Smart Client-Friendly Filter Bar -->
            <div class="portfolio-filter-container" id="archiveFilterContainer">
                <!-- Row 1: Smart Search & Country Dropdown & Actions -->
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

                    <!-- Actions: Country Picker + Reset Button -->
                    <div class="portfolio-toolbar-actions">
                        @php
                            $saCountry = $countries->first(fn($c) => strtolower($c->country_code) === 'sa');
                            $defaultCountryCode = 'sa';
                            $defaultCountryName = $saCountry ? $saCountry->country_name : ($locale === 'ar' ? 'السعودية' : ($locale === 'fr' ? 'Arabie Saoudite' : 'Saudi Arabia'));
                            $defaultFlagUrl = $saCountry?->flag_url ?? asset('assets/flags/sa.webp');
                        @endphp
                        <!-- Country Dropdown Button (Default: Saudi Arabia) -->
                        <div class="portfolio-country-dropdown-wrap" id="archiveCountryWrap">
                            <button type="button" class="portfolio-country-toggle-btn has-filter" id="archiveCountryBtn" onclick="toggleArchiveCountryDropdown(event)" aria-haspopup="true" aria-expanded="false">
                                <span class="country-toggle-flag" id="archiveCurrentFlag">
                                    <img src="{{ $defaultFlagUrl }}" class="country-toggle-flag-img" alt="{{ $defaultCountryName }}">
                                </span>
                                <span class="country-toggle-text" id="archiveCurrentCountryText">{{ $defaultCountryName }}</span>
                                <svg class="country-toggle-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 9l6 6 6-6"/>
                                </svg>
                            </button>

                            <div class="portfolio-country-menu" id="archiveCountryMenu">
                                <button type="button" class="country-menu-item" data-country="all" onclick="selectArchiveCountry('all', '{{ $locale === 'ar' ? 'جميع الدول' : ($locale === 'fr' ? 'Tous les pays' : 'All Countries') }}', null)">
                                    <span class="country-menu-flag">
                                        <svg class="country-menu-globe-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                    </span>
                                    <span class="country-menu-name">{{ $locale === 'ar' ? 'جميع الدول' : ($locale === 'fr' ? 'Tous les pays' : 'All Countries') }}</span>
                                    <span class="country-menu-count">{{ $projects->count() }}</span>
                                </button>
                                @foreach($countries as $country)
                                    @php
                                        $cLower = strtolower($country->country_code);
                                        $cCount = $projects->filter(fn($p) => strtolower($p->country_code) === $cLower)->count();
                                        $isDefaultActive = ($cLower === 'sa');
                                    @endphp
                                    <button type="button" class="country-menu-item {{ $isDefaultActive ? 'active' : '' }}" data-country="{{ $cLower }}" onclick="selectArchiveCountry('{{ $cLower }}', '{{ addslashes($country->country_name) }}', '{{ $country->flag_url }}')">
                                        <span class="country-menu-flag">
                                            @if(!empty($country->flag_url))
                                                <img src="{{ $country->flag_url }}" class="country-menu-flag-img" alt="{{ $country->country_name }}" loading="lazy">
                                            @else
                                                <svg class="country-menu-globe-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                            @endif
                                        </span>
                                        <span class="country-menu-name">{{ $country->country_name }}</span>
                                        @if($cCount > 0)
                                            <span class="country-menu-count">{{ $cCount }}</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
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
                                    <span class="portfolio-sector-badge">{{ $project->sector_name }}</span>
                                @endif
                            </div>

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
    let archiveCountry = 'sa';
    let archiveSearch = '';

    window.selectArchiveSector = function(sectorSlug, btn) {
        archiveCat = sectorSlug;
        document.querySelectorAll('#archiveSectorTabs .portfolio-sector-tab').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');
        applyArchiveFilters();
    };

    window.toggleArchiveCountryDropdown = function(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        const menu = document.getElementById('archiveCountryMenu');
        const btn = document.getElementById('archiveCountryBtn');
        if (!menu) return;
        const isOpen = menu.classList.contains('show');
        if (isOpen) {
            menu.classList.remove('show');
            if (btn) btn.classList.remove('active');
        } else {
            menu.classList.add('show');
            if (btn) btn.classList.add('active');
        }
    };

    window.closeArchiveCountryDropdown = function() {
        const menu = document.getElementById('archiveCountryMenu');
        const btn = document.getElementById('archiveCountryBtn');
        if (menu) menu.classList.remove('show');
        if (btn) btn.classList.remove('active');
    };

    window.selectArchiveCountry = function(code, name, flagUrl) {
        archiveCountry = code;
        
        const textEl = document.getElementById('archiveCurrentCountryText');
        const flagEl = document.getElementById('archiveCurrentFlag');
        const toggleBtn = document.getElementById('archiveCountryBtn');
        
        if (textEl) textEl.textContent = name;
        if (flagEl) {
            if (code === 'all' || !flagUrl) {
                flagEl.innerHTML = '<svg class="country-toggle-flag-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1 4-10z"></path></svg>';
            } else {
                flagEl.innerHTML = `<img src="${flagUrl}" class="country-toggle-flag-img" alt="${name}">`;
            }
        }
        if (toggleBtn) {
            if (code !== 'all') {
                toggleBtn.classList.add('has-filter');
            } else {
                toggleBtn.classList.remove('has-filter');
            }
        }

        document.querySelectorAll('#archiveCountryMenu .country-menu-item').forEach(item => {
            if (item.getAttribute('data-country') === code) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        closeArchiveCountryDropdown();
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

        const hasActiveFilter = (archiveCat !== 'all' || archiveCountry !== 'sa' || archiveSearch.length > 0);
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
        archiveCountry = 'sa';
        archiveSearch = '';
        const input = document.getElementById('portfolioSearchInput');
        if (input) input.value = '';
        const clearBtn = document.getElementById('archiveSearchClear');
        if (clearBtn) clearBtn.style.display = 'none';

        document.querySelectorAll('#archiveSectorTabs .portfolio-sector-tab').forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-cat') === 'all');
        });

        selectArchiveCountry('sa', '{{ addslashes($defaultCountryName) }}', '{{ $defaultFlagUrl }}');
    };

    document.addEventListener('click', function(e) {
        const wrap = document.getElementById('archiveCountryWrap');
        if (wrap && !wrap.contains(e.target)) {
            closeArchiveCountryDropdown();
        }
    });

    // Initial filter execution to apply default Saudi Arabia filter
    applyArchiveFilters();
</script>
@endpush
