@extends('layouts.app')

@php
    $locale = app()->getLocale();
    if (!in_array($locale, ['ar', 'en', 'fr'])) {
        $locale = 'ar';
    }
    $isRtl = $locale === 'ar';
@endphp

@section('title', $project->title . ' | ' . ($locale === 'ar' ? 'أعمال OX Tech' : ($locale === 'fr' ? 'Projets OX Tech' : 'OX Tech Case Study')))
@section('meta_description', $project->short_description ?? Str::limit($project->summary, 160))

@push('styles')
<style>
    /* ===============================================================
       OX TECH — REFINED, HUMAN & CALM CASE STUDY STYLES
       No AI clichés • No neon glow • No noisy taglines • Quiet Luxury
       =============================================================== */

    /* ─── Page Container & Base Background ─── */
    .project-page-wrap {
        background-color: #071715;
        color: #e2e8f0;
        min-height: 100vh;
    }

    /* ─── Hero Section ─── */
    .project-calm-hero {
        padding: 140px 0 50px;
        background: linear-gradient(180deg, #051210 0%, #071715 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        position: relative;
        text-align: center;
    }

    .project-calm-hero .container {
        max-width: 900px;
        margin: 0 auto;
    }

    /* Minimalist Breadcrumbs */
    .calm-breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 13px;
        color: #7b928c;
        margin-bottom: 20px;
    }
    .calm-breadcrumb a {
        color: #9cb0aa;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .calm-breadcrumb a:hover {
        color: #ffffff;
    }
    .badge-flag-img {
        width: 18px;
        height: 12px;
        object-fit: cover;
        border-radius: 2px;
        display: inline-block;
        vertical-align: middle;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }
    .calm-breadcrumb .sep {
        opacity: 0.4;
        font-size: 11px;
    }
    .calm-breadcrumb .current {
        color: #d1deda;
        font-weight: 600;
    }

    /* Simple, Understated Meta Pills */
    .calm-meta-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .calm-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 12.5px;
        color: #a4b8b2;
        font-weight: 500;
    }
    .calm-tag.accent {
        color: #c7dcd5;
        border-color: rgba(29, 138, 104, 0.35);
        background: rgba(29, 138, 104, 0.1);
    }

    /* Hero Typography */
    .project-main-title {
        font-size: clamp(32px, 4.5vw, 56px);
        font-weight: 800;
        line-height: 1.25;
        color: #ffffff;
        margin: 0 0 12px;
        letter-spacing: -0.5px;
    }

    .project-subtitle-text {
        font-size: clamp(17px, 2vw, 24px);
        font-weight: 400;
        color: #9eb5ae;
        margin: 0 0 18px;
        line-height: 1.5;
    }

    .project-lead-summary {
        font-size: clamp(15px, 1.35vw, 17.5px);
        line-height: 1.85;
        color: #8da49e;
        max-width: 720px;
        margin: 0 auto 30px;
        font-weight: 400;
    }

    /* Quiet Action Buttons */
    .calm-hero-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
    }
    .btn-quiet-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #1D8A68;
        color: #ffffff !important;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }
    .btn-quiet-primary:hover {
        background: #177356;
        transform: translateY(-1px);
    }

    .btn-quiet-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        color: #cbdad5 !important;
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 12px 22px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-quiet-outline:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.28);
        color: #ffffff !important;
    }

    /* ─── Minimal Project Metadata Strip ─── */
    .project-metadata-strip {
        background: #051412;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        padding: 22px 0;
    }
    .metadata-items-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }
    .meta-data-cell {
        flex: 1;
        min-width: 140px;
        text-align: {{ $isRtl ? 'right' : 'left' }};
    }
    .meta-data-cell label {
        display: block;
        font-size: 11px;
        color: #6d857f;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        font-weight: 500;
    }
    .meta-data-cell span {
        font-size: 14px;
        font-weight: 600;
        color: #e2e8f0;
    }
    .meta-data-cell span.highlight {
        color: #C8A96B;
    }

    /* ─── Main Content Layout ─── */
    .project-main-section {
        padding: 55px 0 80px;
    }
    .project-grid-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 48px;
        align-items: start;
    }

    /* ─── Visual Showcase Frame (Clean & Photographic) ─── */
    .project-showcase-frame {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: #030c0a;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    }
    .showcase-media-box {
        position: relative;
        width: 100%;
        max-height: 520px;
        overflow: hidden;
        background: #030c0a;
    }
    .showcase-media-box img {
        width: 100%;
        height: auto;
        max-height: 520px;
        object-fit: cover;
        display: block;
    }
    .showcase-media-caption {
        padding: 14px 20px;
        background: #081a17;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
        color: #8da49e;
    }
    .showcase-media-caption strong {
        color: #ffffff;
        font-weight: 600;
    }

    /* ─── Case Study Narrative Sections ─── */
    .narrative-block {
        margin-bottom: 40px;
    }
    .narrative-heading {
        font-size: 20px;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .narrative-text {
        font-size: 15px;
        line-height: 2;
        color: #b5c7c2;
        margin: 0;
    }

    /* Challenge & Solution Grid */
    .dual-challenge-solution {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 16px;
    }
    .calm-card-box {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 12px;
        padding: 22px;
    }
    .calm-card-box.challenge-card {
        border-inline-start: 3px solid #e06c75;
    }
    .calm-card-box.solution-card {
        border-inline-start: 3px solid #1D8A68;
    }
    .calm-card-box h4 {
        font-size: 14.5px;
        font-weight: 700;
        margin: 0 0 8px;
        color: #ffffff;
    }
    .calm-card-box p {
        font-size: 13.5px;
        line-height: 1.85;
        color: #9eb2ac;
        margin: 0;
    }

    /* Key Features Clean List */
    .features-clean-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 14px;
    }
    .clean-feature-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 14px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 8px;
    }
    .feature-dash {
        color: #1D8A68;
        font-weight: bold;
        line-height: 1;
        margin-top: 3px;
    }
    .clean-feature-row span {
        font-size: 13.5px;
        color: #cbd8d4;
        line-height: 1.6;
    }

    /* Live Link In-Content Box */
    .live-url-panel {
        background: rgba(29, 138, 104, 0.08);
        border: 1px solid rgba(29, 138, 104, 0.25);
        border-radius: 12px;
        padding: 22px 26px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 30px;
    }
    .live-url-info h4 {
        font-size: 15px;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 4px;
    }
    .live-url-info p {
        font-size: 12.5px;
        color: #8fa9a1;
        margin: 0;
    }

    /* ─── Sidebar (Clean, Sticky & Calm) ─── */
    .project-calm-sidebar {
        display: flex;
        flex-direction: column;
        gap: 24px;
        position: sticky;
        top: 100px;
    }
    .sidebar-block {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 12px;
        padding: 22px;
    }
    .sidebar-block-title {
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 14px;
        padding-bottom: 8px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    /* Tech Stack Pills */
    .sidebar-tech-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    .sidebar-tech-tag {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 5px 11px;
        border-radius: 6px;
        font-size: 12px;
        color: #b8ccc6;
        font-family: var(--font-latin), sans-serif;
    }

    /* Sidebar Specs Rows */
    .specs-table-rows {
        display: grid;
        gap: 10px;
        font-size: 13px;
    }
    .spec-table-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 6px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }
    .spec-table-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .spec-table-row span {
        color: #7b948d;
    }
    .spec-table-row strong {
        color: #dbe7e4;
        font-weight: 600;
    }

    /* Quiet Consultation Box */
    .sidebar-consult-simple {
        background: rgba(29, 138, 104, 0.06);
        border: 1px solid rgba(29, 138, 104, 0.2);
        border-radius: 12px;
        padding: 22px;
        text-align: {{ $isRtl ? 'right' : 'left' }};
    }
    .sidebar-consult-simple h4 {
        font-size: 15px;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 8px;
    }
    .sidebar-consult-simple p {
        font-size: 13px;
        line-height: 1.7;
        color: #9cb2ab;
        margin: 0 0 16px;
    }
    .sidebar-consult-simple button {
        width: 100%;
        justify-content: center;
    }

    /* ─── Previous / Next Navigation ─── */
    .project-bottom-nav {
        background: #051210;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        padding: 28px 0;
    }
    .nav-flex-split {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    .bottom-nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: #cbd8d4;
        font-size: 14px;
        font-weight: 600;
        transition: color 0.2s ease;
    }
    .bottom-nav-link:hover {
        color: #ffffff;
    }
    .bottom-nav-link span.label {
        font-size: 11px;
        color: #6d857f;
        display: block;
        font-weight: normal;
    }
    .all-work-calm-link {
        color: #8da49e;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        padding: 7px 16px;
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.2s ease;
    }
    .all-work-calm-link:hover {
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* ─── Related Projects (Understated) ─── */
    .calm-related-section {
        background: #071715;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        padding: 60px 0 80px;
    }
    .calm-related-section .section-header {
        margin-bottom: 32px;
        text-align: {{ $isRtl ? 'right' : 'left' }};
    }
    .calm-related-section h3 {
        font-size: 22px;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
    }

    /* ─── Responsive Queries ─── */
    @media (max-width: 992px) {
        .project-grid-layout {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        .project-calm-sidebar {
            position: static;
        }
        .dual-challenge-solution {
            grid-template-columns: 1fr;
        }
        .features-clean-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 768px) {
        .project-calm-hero {
            padding: 110px 0 40px;
        }
        .metadata-items-flex {
            gap: 16px;
        }
        .meta-data-cell {
            min-width: 45%;
        }
        .nav-flex-split {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
        }
    }
</style>
@endpush

@section('content')
<main class="project-page-wrap">

    <!-- =========================================
         1. HERO SECTION (Calm, Editorial & Human)
         Note: Using <section> to prevent collision with global header CSS
         ========================================= -->
    <section class="project-calm-hero">
        <div class="container">
            <!-- Breadcrumbs -->
            <nav class="calm-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">{{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}</a>
                <span class="sep">/</span>
                <a href="{{ route('home') }}#work">{{ $locale === 'ar' ? 'أعمالنا' : 'Work' }}</a>
                <span class="sep">/</span>
                <span class="current">{{ $project->title }}</span>
            </nav>

            <!-- Understated Category Tags -->
            <div class="calm-meta-row">
                <span class="calm-tag">
                    @if($project->country_flag_url)
                        <img src="{{ $project->country_flag_url }}" class="badge-flag-img" alt="{{ $project->country_name }}" loading="lazy">
                    @else
                        <span>{{ $project->country_flag }}</span>
                    @endif
                    <span>{{ __($project->country_name) }}</span>
                </span>
                <span class="calm-tag accent">
                    <span>{{ __($project->sector_name) }}</span>
                </span>
                @if($project->duration)
                    <span class="calm-tag">
                        <span>{{ $locale === 'ar' ? 'مدة العمل:' : 'Timeline:' }} {{ $project->duration }}</span>
                    </span>
                @endif
            </div>

            <!-- Clean Project Title & Subtitle -->
            <h1 class="project-main-title">{{ $project->title }}</h1>
            
            @if($project->subtitle)
                <p class="project-subtitle-text">{{ $project->subtitle }}</p>
            @endif

            @if($project->short_description || $project->summary)
                <p class="project-lead-summary">
                    {{ $project->short_description ?: $project->summary }}
                </p>
            @endif

            <!-- Quiet, Purposeful Actions -->
            <div class="calm-hero-actions">
                @if($project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="btn-quiet-primary">
                        <span>{{ $locale === 'ar' ? 'زيارة الموقع الحي' : 'Visit Live Project' }}</span>
                        <span style="font-size: 15px;">↗</span>
                    </a>
                @endif
                
                <button type="button" onclick="openConsultModal()" class="btn-quiet-outline">
                    <span>{{ $locale === 'ar' ? 'طلب استشارة لمشروعك' : 'Discuss a Project' }}</span>
                </button>
            </div>
        </div>
    </section>

    <!-- =========================================
         2. MINIMAL PROJECT METADATA STRIP
         ========================================= -->
    <div class="project-metadata-strip">
        <div class="container">
            <div class="metadata-items-flex">
                <div class="meta-data-cell">
                    <label>{{ $locale === 'ar' ? 'العميل' : 'Client' }}</label>
                    <span>{{ $project->client_name ?: $project->title }}</span>
                </div>

                @if($project->duration)
                    <div class="meta-data-cell">
                        <label>{{ $locale === 'ar' ? 'مدة التنفيذ' : 'Timeline' }}</label>
                        <span>{{ $project->duration }}</span>
                    </div>
                @endif

                <div class="meta-data-cell">
                    <label>{{ $locale === 'ar' ? 'تاريخ التسليم' : 'Delivered' }}</label>
                    <span>{{ $project->delivery_date ?: '-' }}</span>
                </div>

                <div class="meta-data-cell">
                    <label>{{ $locale === 'ar' ? 'السوق والقطاع' : 'Sector' }}</label>
                    <span>{{ __($project->sector_name) }} · {{ __($project->country_name) }}</span>
                </div>

                @if($project->impact_stat)
                    <div class="meta-data-cell">
                        <label>{{ $locale === 'ar' ? 'الأثر والنتائج' : 'Key Result' }}</label>
                        <span class="highlight">{{ $project->impact_stat }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- =========================================
         3. MAIN CASE STUDY CONTENT & SIDEBAR
         ========================================= -->
    <section class="project-main-section">
        <div class="container">
            <div class="project-grid-layout">
                
                <!-- Main Narrative Column -->
                <div class="project-narrative-col">
                    
                    <!-- Clean Photographic Showcase (No fake browser buttons or frames) -->
                    <div class="project-showcase-frame">
                        <div class="showcase-media-box">
                            <img src="{{ $project->display_image }}" 
                                 alt="{{ $project->title }}" 
                                 loading="lazy" />
                        </div>
                        <div class="showcase-media-caption">
                            <strong>{{ $project->title }}</strong>
                            @if($project->live_url)
                                <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" style="color: #1D8A68; text-decoration: none; font-size: 13px;">
                                    {{ $project->live_url }} ↗
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Section: About The Project -->
                    <div class="narrative-block">
                        <h2 class="narrative-heading">
                            {{ $locale === 'ar' ? 'عن المشروع' : 'About the Project' }}
                        </h2>
                        <p class="narrative-text">
                            {{ $project->summary ?: ($project->short_description ?: ($locale === 'ar' ? 'تم بناء وتطوير هذا المشروع لتوفير منصة برمجية متكاملة وسلسة تلبي متطلبات الأعمال وتمنح المستخدم النهائي أداءً سريعاً وموثوقاً.' : 'Engineered to provide a high-performing digital experience tailored to business growth and user engagement.')) }}
                        </p>
                    </div>

                    <!-- Section: Challenge & Solution -->
                    @if($project->challenge || $project->solution)
                        <div class="narrative-block">
                            <h2 class="narrative-heading">
                                {{ $locale === 'ar' ? 'التحدي والحل' : 'Challenge & Solution' }}
                            </h2>
                            <div class="dual-challenge-solution">
                                @if($project->challenge)
                                    <div class="calm-card-box challenge-card">
                                        <h4>{{ $locale === 'ar' ? 'التحدي' : 'The Challenge' }}</h4>
                                        <p>{{ $project->challenge }}</p>
                                    </div>
                                @endif
                                @if($project->solution)
                                    <div class="calm-card-box solution-card">
                                        <h4>{{ $locale === 'ar' ? 'الحل المنفذ' : 'The Solution' }}</h4>
                                        <p>{{ $project->solution }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Section: Key Features -->
                    @if(!empty($project->key_features) && is_array($project->key_features) && count($project->key_features) > 0)
                        <div class="narrative-block">
                            <h2 class="narrative-heading">
                                {{ $locale === 'ar' ? 'أبرز مميزات العمل' : 'Key Highlights' }}
                            </h2>
                            <div class="features-clean-grid">
                                @foreach($project->key_features as $feature)
                                    <div class="clean-feature-row">
                                        <span class="feature-dash">—</span>
                                        <span>{{ $feature }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- In-Content Live URL Panel (if live_url exists) -->
                    @if($project->live_url)
                        <div class="live-url-panel">
                            <div class="live-url-info">
                                <h4>{{ $locale === 'ar' ? 'المشروع متاح للمعاينة المباشرة' : 'Project is live and available online' }}</h4>
                                <p>{{ $project->live_url }}</p>
                            </div>
                            <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="btn-quiet-primary">
                                <span>{{ $locale === 'ar' ? 'زيارة الموقع' : 'Launch Site' }}</span>
                                <span>↗</span>
                            </a>
                        </div>
                    @endif

                </div>

                <!-- Calm Sidebar Column -->
                <aside class="project-calm-sidebar">
                    
                    <!-- Technologies -->
                    @if(!empty($project->technologies) && is_array($project->technologies) && count($project->technologies) > 0)
                        <div class="sidebar-block">
                            <h3 class="sidebar-block-title">
                                {{ $locale === 'ar' ? 'التقنيات المستخدمة' : 'Technologies' }}
                            </h3>
                            <div class="sidebar-tech-list">
                                @foreach($project->technologies as $tech)
                                    <span class="sidebar-tech-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Specifications Table -->
                    <div class="sidebar-block">
                        <h3 class="sidebar-block-title">
                            {{ $locale === 'ar' ? 'معلومات المشروع' : 'Project Details' }}
                        </h3>
                        <div class="specs-table-rows">
                            <div class="spec-table-row">
                                <span>{{ $locale === 'ar' ? 'القطاع' : 'Sector' }}</span>
                                <strong>{{ __($project->sector_name) }}</strong>
                            </div>
                            <div class="spec-table-row">
                                <span>{{ $locale === 'ar' ? 'السوق' : 'Market' }}</span>
                                <strong>
                                    @if($project->country_flag_url)
                                        <img src="{{ $project->country_flag_url }}" class="badge-flag-img" alt="{{ $project->country_name }}" style="margin-inline-end: 4px;" loading="lazy">
                                    @else
                                        {{ $project->country_flag }}
                                    @endif
                                    {{ __($project->country_name) }}
                                </strong>
                            </div>
                            @if($project->duration)
                                <div class="spec-table-row">
                                    <span>{{ $locale === 'ar' ? 'المدة' : 'Duration' }}</span>
                                    <strong>{{ $project->duration }}</strong>
                                </div>
                            @endif
                            <div class="spec-table-row">
                                <span>{{ $locale === 'ar' ? 'السرية' : 'NDA' }}</span>
                                <strong>{{ $locale === 'ar' ? 'اتفاقية سرية معتمدة' : 'Protected' }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Box (Quiet & Human, no noisy slogans) -->
                    <div class="sidebar-consult-simple">
                        <h4>{{ $locale === 'ar' ? 'هل تخطط لمشروع مماثل؟' : 'Planning a similar project?' }}</h4>
                        <p>
                            {{ $locale === 'ar' ? 'فريقنا متاح لمناقشة متطلبات عملك وتقديم استشارة تقنية مجانية.' : 'Our engineering squad is ready to discuss your requirements and project scope.' }}
                        </p>
                        <button type="button" onclick="openConsultModal()" class="btn-quiet-primary">
                            <span>{{ $locale === 'ar' ? 'تواصل معنا للاستشارة' : 'Book a Consultation' }}</span>
                        </button>
                    </div>

                </aside>

            </div>
        </div>
    </section>

    <!-- =========================================
         4. PREVIOUS / NEXT NAVIGATION
         ========================================= -->
    <nav class="project-bottom-nav" aria-label="Project Navigation">
        <div class="container nav-flex-split">
            @if($prevProject)
                <a href="{{ route('projects.show', $prevProject->slug) }}" class="bottom-nav-link">
                    <span style="font-size: 16px;">{{ $isRtl ? '→' : '←' }}</span>
                    <div>
                        <span class="label">{{ $locale === 'ar' ? 'المشروع السابق' : 'Previous' }}</span>
                        <strong>{{ $prevProject->title }}</strong>
                    </div>
                </a>
            @else
                <div></div>
            @endif

            <a href="{{ route('home') }}#work" class="all-work-calm-link">
                {{ $locale === 'ar' ? 'جميع الأعمال' : 'All Works' }}
            </a>

            @if($nextProject)
                <a href="{{ route('projects.show', $nextProject->slug) }}" class="bottom-nav-link" style="text-align: {{ $isRtl ? 'left' : 'right' }};">
                    <div>
                        <span class="label">{{ $locale === 'ar' ? 'المشروع التالي' : 'Next' }}</span>
                        <strong>{{ $nextProject->title }}</strong>
                    </div>
                    <span style="font-size: 16px;">{{ $isRtl ? '←' : '→' }}</span>
                </a>
            @else
                <div></div>
            @endif
        </div>
    </nav>

    <!-- =========================================
         5. RELATED PROJECTS (Subtle & Natural)
         ========================================= -->
    @if(isset($otherProjects) && $otherProjects->count() > 0)
        <section class="calm-related-section">
            <div class="container">
                <div class="section-header">
                    <h3>{{ $locale === 'ar' ? 'مشاريع أخرى' : 'Other Projects' }}</h3>
                </div>

                <div class="ox-portfolio-grid">
                    @foreach($otherProjects as $rel)
                        @php
                            $relImg = $rel->display_image;
                        @endphp
                        <article class="ox-portfolio-card" onclick="window.location.href='{{ route('projects.show', $rel->slug) }}'">
                            <div class="portfolio-card-media">
                                <img src="{{ $relImg }}" 
                                     alt="{{ $rel->title }}" 
                                     loading="lazy" 
                                     class="portfolio-card-img" />
                                <div class="portfolio-card-overlay"></div>
                                
                                <div class="portfolio-badges-top">
                                    <span class="portfolio-country-badge">
                                        <span class="badge-flag">
                                            @if($rel->country_flag_url)
                                                <img src="{{ $rel->country_flag_url }}" class="badge-flag-img" alt="{{ $rel->country_name }}" loading="lazy">
                                            @else
                                                {{ $rel->country_flag }}
                                            @endif
                                        </span>
                                        <span>{{ __($rel->country_name) }}</span>
                                    </span>
                                    @if($rel->sector_name)
                                        <span class="portfolio-sector-badge">{{ __($rel->sector_name) }}</span>
                                    @endif
                                </div>

                              
                            </div>

                            <div class="portfolio-card-body">
                                <div class="portfolio-card-head">
                                    @if($rel->client_name)
                                        <span class="portfolio-client-name">{{ $rel->client_name }}</span>
                                    @endif
                                    <h4 class="portfolio-card-title">{{ $rel->title }}</h4>
                                    <p class="portfolio-card-desc">
                                        {{ $rel->short_description ?: Str::limit($rel->summary, 90) }}
                                    </p>
                                </div>

                                @if(!empty($rel->technologies) && is_array($rel->technologies))
                                    <div class="portfolio-tech-tags">
                                        @foreach(array_slice($rel->technologies, 0, 3) as $tech)
                                            <span class="tech-tag">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="portfolio-card-foot">
                                    <span class="portfolio-view-text">
                                        {{ $locale === 'ar' ? 'عرض المشروع' : 'View Project' }}
                                    </span>
                                    <span class="portfolio-view-btn" aria-label="Details">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="{{ $isRtl ? '15 18 9 12 15 6' : '9 18 15 12 9 6' }}"></polyline>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</main>
@endsection
