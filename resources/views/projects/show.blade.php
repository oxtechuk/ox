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
       OX TECH — REFINED, HUMAN & CALM CASE STUDY STYLES (LIGHT THEME)
       Quiet Luxury • Saudi Emerald #1D8A68 • Desert Camel #C8A96B
       =============================================================== */

    /* ─── Page Container & Base Background ─── */
    .project-page-wrap {
        background-color: #F8FAF9;
        color: #0b1b17;
        min-height: 100vh;
        position: relative;
    }

    /* ─── Hero Section ─── */
    .project-calm-hero {
        padding: 130px 0 55px;
        background: linear-gradient(180deg, #edf7f2 0%, #f8faf9 100%);
        border-bottom: 1px solid #e2ede8;
        position: relative;
        text-align: center;
    }

    .project-calm-hero .container {
        max-width: 900px;
        margin: 0 auto;
    }

    /* Minimalist Breadcrumbs */
    .calm-breadcrumb {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 22px;
        background: #ffffff;
        border: 1px solid #e2ede8;
        padding: 7px 20px;
        border-radius: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .calm-breadcrumb a {
        color: #4b5e57;
        text-decoration: none;
        transition: color 0.2s ease;
        font-weight: 600;
    }
    .calm-breadcrumb a:hover {
        color: #1D8A68;
    }
    .badge-flag-img {
        width: 18px;
        height: 12px;
        object-fit: cover;
        border-radius: 2px;
        display: inline-block;
        vertical-align: middle;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }
    .calm-breadcrumb .sep {
        opacity: 0.4;
        font-size: 11px;
        color: #94a3b8;
    }
    .calm-breadcrumb .current {
        color: #1D8A68;
        font-weight: 700;
    }

    /* Simple, Understated Meta Pills */
    .calm-meta-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }
    .calm-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 30px;
        background: #ffffff;
        border: 1px solid #e2ede8;
        font-size: 12.5px;
        color: #4b5e57;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    }
    .calm-tag.accent {
        color: #1D8A68;
        border-color: #a7f3d0;
        background: #ecfdf5;
        font-weight: 700;
    }

    /* Hero Typography */
    .project-main-title {
        font-weight: 900;
        line-height: 1.25;
        color: #0b1b17;
        margin: 0 0 12px;
        letter-spacing: -0.5px;
        font-family: var(--font-ar);
    }

    .project-subtitle-text {
        font-size: clamp(17px, 2vw, 22px);
        font-weight: 700;
        color: #1D8A68;
        margin: 0 0 18px;
        line-height: 1.5;
        font-family: var(--font-ar);
    }

    .project-lead-summary {
        font-size: clamp(15px, 1.35vw, 17.5px);
        line-height: 1.85;
        color: #4b5e57;
        max-width: 760px;
        margin: 0 auto 32px;
        font-weight: 400;
        font-family: var(--font-ar);
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
        padding: 12px 28px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 18px rgba(29, 138, 104, 0.3);
        transition: all 0.25s ease;
        border: none;
    }
    .btn-quiet-primary:hover {
        background: #167054;
        box-shadow: 0 6px 24px rgba(29, 138, 104, 0.4);
        transform: translateY(-2px);
    }

    .btn-quiet-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        color: #0b1b17 !important;
        border: 1px solid #cbd5e1;
        padding: 12px 26px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        transition: all 0.25s ease;
    }
    .btn-quiet-outline:hover {
        background: #f8fafc;
        border-color: #1D8A68;
        color: #1D8A68 !important;
        transform: translateY(-2px);
    }

    /* ─── Minimal Project Metadata Strip ─── */
    .project-metadata-strip {
        background: #ffffff;
        border-top: 1px solid #e2ede8;
        border-bottom: 1px solid #e2ede8;
        padding: 24px 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
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
        font-size: 11.5px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        font-weight: 700;
    }
    .meta-data-cell span {
        font-size: 14.5px;
        font-weight: 700;
        color: #0b1b17;
    }

    /* ─── Main Content Layout ─── */
    .project-main-section {
        padding: 55px 0 85px;
        background-color: #F8FAF9;
    }
    .project-grid-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 48px;
        align-items: start;
    }

    /* ─── Visual Showcase Frame (Clean & Photographic) ─── */
    .project-showcase-frame {
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #e5eee9;
        background: #ffffff;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(11, 27, 23, 0.05);
    }
    .showcase-media-box {
        position: relative;
        width: 100%;
        max-height: 520px;
        overflow: hidden;
        background: #f1f5f9;
    }
    .showcase-media-box img {
        width: 100%;
        height: auto;
        max-height: 520px;
        object-fit: cover;
        display: block;
    }
    .showcase-media-caption {
        padding: 16px 24px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13.5px;
        color: #64748b;
    }
    .showcase-media-caption strong {
        color: #0b1b17;
        font-weight: 700;
    }

    /* ─── Case Study Narrative Sections ─── */
    .narrative-block {
        margin-bottom: 42px;
    }
    .narrative-heading {
        font-size: 21px;
        font-weight: 800;
        color: #0b1b17;
        margin: 0 0 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2ede8;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: var(--font-ar);
    }
    .narrative-text {
        font-size: 15.5px;
        line-height: 2;
        color: #4b5e57;
        margin: 0;
        font-family: var(--font-ar);
    }

    /* Challenge & Solution Grid */
    .dual-challenge-solution {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 18px;
    }
    .calm-card-box {
        background: #ffffff;
        border: 1px solid #e2ede8;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
    }
    .calm-card-box.challenge-card {
        border-inline-start: 4px solid #ef4444;
        background: #fffdfd;
    }
    .calm-card-box.solution-card {
        border-inline-start: 4px solid #1D8A68;
        background: #fdfffe;
    }
    .calm-card-box h4 {
        font-size: 15.5px;
        font-weight: 800;
        margin: 0 0 8px;
        color: #0b1b17;
        font-family: var(--font-ar);
    }
    .calm-card-box p {
        font-size: 14px;
        line-height: 1.85;
        color: #4b5e57;
        margin: 0;
        font-family: var(--font-ar);
    }

    /* Key Features Clean List */
    .features-clean-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 16px;
    }
    .clean-feature-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        background: #ffffff;
        border: 1px solid #e2ede8;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    .feature-dash {
        color: #1D8A68;
        font-weight: 900;
        line-height: 1;
        margin-top: 2px;
        font-size: 16px;
    }
    .clean-feature-row span {
        font-size: 14px;
        color: #334155;
        line-height: 1.6;
        font-weight: 600;
    }

    /* Live Link In-Content Box */
    .live-url-panel {
        background: linear-gradient(135deg, #edf7f2 0%, #e1efe9 100%);
        border: 1px solid rgba(29, 138, 104, 0.25);
        border-radius: 16px;
        padding: 24px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 32px;
        box-shadow: 0 8px 24px rgba(29, 138, 104, 0.06);
    }
    .live-url-info h4 {
        font-size: 16px;
        font-weight: 800;
        color: #0b1b17;
        margin: 0 0 5px;
        font-family: var(--font-ar);
    }
    .live-url-info p {
        font-size: 13.5px;
        color: #1D8A68;
        font-weight: 600;
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
        background: #ffffff;
        border: 1px solid #e5eee9;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }
    .sidebar-block-title {
        font-size: 15px;
        font-weight: 800;
        color: #0b1b17;
        margin: 0 0 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f3;
        font-family: var(--font-ar);
    }

    /* Tech Stack Pills */
    .sidebar-tech-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    .sidebar-tech-tag {
        background: #f1f7f4;
        border: 1px solid #dceed8;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        color: #1d5244;
        font-family: var(--font-en, sans-serif);
    }

    /* Sidebar Specs Rows */
    .specs-table-rows {
        display: grid;
        gap: 12px;
        font-size: 13.5px;
    }
    .spec-table-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 8px;
        border-bottom: 1px solid #f1f5f3;
    }
    .spec-table-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .spec-table-row span {
        color: #64748b;
        font-size: 13px;
    }
    .spec-table-row strong {
        color: #0b1b17;
        font-weight: 700;
        font-size: 13.5px;
    }

    /* Quiet Consultation Box */
    .sidebar-consult-simple {
        background: linear-gradient(135deg, #edf7f2 0%, #e1efe9 100%);
        border: 1px solid rgba(29, 138, 104, 0.25);
        border-radius: 16px;
        padding: 24px;
        text-align: {{ $isRtl ? 'right' : 'left' }};
        box-shadow: 0 8px 24px rgba(29, 138, 104, 0.06);
    }
    .sidebar-consult-simple h4 {
        font-size: 16px;
        font-weight: 800;
        color: #0b1b17;
        margin: 0 0 8px;
        font-family: var(--font-ar);
    }
    .sidebar-consult-simple p {
        font-size: 13.5px;
        line-height: 1.7;
        color: #4b5e57;
        margin: 0 0 18px;
        font-family: var(--font-ar);
    }
    .sidebar-consult-simple button {
        width: 100%;
        justify-content: center;
    }

    /* ─── Previous / Next Navigation ─── */
    .project-bottom-nav {
        background: #ffffff;
        border-top: 1px solid #e2ede8;
        padding: 28px 0;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.02);
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
        color: #0b1b17;
        font-size: 14px;
        font-weight: 700;
        transition: color 0.2s ease;
    }
    .bottom-nav-link:hover {
        color: #1D8A68;
    }
    .bottom-nav-link span.label {
        font-size: 11.5px;
        color: #64748b;
        display: block;
        font-weight: normal;
        margin-bottom: 2px;
    }
    .all-work-calm-link {
        color: #475569;
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 600;
        padding: 8px 20px;
        border-radius: 30px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.25s ease;
    }
    .all-work-calm-link:hover {
        background: #1D8A68;
        border-color: #1D8A68;
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(29, 138, 104, 0.25);
    }

    /* ─── Related Projects (Understated) ─── */
    .calm-related-section {
        background: #F8FAF9;
        border-top: 1px solid #e2ede8;
        padding: 60px 0 90px;
    }
    .calm-related-section .section-header {
        margin-bottom: 32px;
        text-align: {{ $isRtl ? 'right' : 'left' }};
    }
    .calm-related-section h3 {
        font-size: 24px;
        font-weight: 800;
        color: #0b1b17;
        margin: 0;
        font-family: var(--font-ar);
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
         

            <!-- Clean Project Title & Subtitle -->
            <h1 class="project-main-title">{{ $project->title }}</h1>
            
            @if($project->subtitle)
                <p class="project-subtitle-text">{{ $project->subtitle }}</p>
            @endif

            

        </div>
    </section>

    <!-- =========================================
         2. MINIMAL PROJECT METADATA STRIP
         ========================================= -->
  

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
                                {{ $locale === 'ar' ? 'أبرز مميزات العمل' : 'Key Features' }}
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
