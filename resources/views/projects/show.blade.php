@extends('layouts.app')

@section('title', $project->title . ' | ' . __('OX Tech | تفاصيل المشروع'))
@section('meta_description', $project->short_description ?? $project->summary)

@push('styles')
<style>
    .project-detail-hero {
        min-height: 520px;
        position: relative;
        display: flex;
        align-items: center;
        padding: 130px 8vw 60px;
        background: radial-gradient(circle at 80% 20%, rgba(31, 99, 255, 0.25), transparent 45%), linear-gradient(180deg, #06131f 0%, #060F1A 100%);
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .hero-glow-bg {
        position: absolute;
        width: 450px;
        height: 450px;
        border-radius: 50%;
        filter: blur(90px);
        opacity: 0.18;
        background: var(--lime);
        top: -100px;
        left: -100px;
        pointer-events: none;
    }
    .project-hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
    }
    .back-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #9cb2ab;
        font-size: 12px;
        text-decoration: none;
        margin-bottom: 24px;
        transition: 0.2s;
    }
    .back-nav-link:hover {
        color: var(--lime);
        transform: translateX(4px);
    }
    .project-badges {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .badge-tag {
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 6px 14px;
        border-radius: 99px;
        font-size: 11px;
        color: #dbe5e2;
    }
    .badge-tag.lime {
        background: rgba(201, 250, 75, 0.15);
        border-color: rgba(201, 250, 75, 0.4);
        color: var(--lime);
        font-weight: 700;
        font-family: var(--font-latin), sans-serif;
    }
    .project-title-large {
        font: 800 clamp(42px, 6vw, 76px)/1.1 var(--font);
        letter-spacing: -2px;
        margin: 0 0 16px;
        color: #fff;
    }
    .project-subtitle-text {
        font-size: clamp(16px, 2vw, 22px);
        color: #b5c7c2;
        line-height: 1.6;
        margin: 0 0 30px;
        max-width: 650px;
    }
    .hero-cta-group {
        display: flex;
        gap: 18px;
        align-items: center;
        flex-wrap: wrap;
    }
    .btn-live-link {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: var(--lime);
        color: #09221e;
        padding: 14px 26px;
        border-radius: 99px;
        font-weight: 800;
        font-size: 13px;
        text-decoration: none;
        transition: 0.25s ease;
        box-shadow: 0 10px 25px rgba(201, 250, 75, 0.25);
    }
    .btn-live-link:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(201, 250, 75, 0.4);
    }

    /* Key Meta Strip */
    .meta-strip {
        background: #0b1f2e;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 30px 8vw;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 25px;
    }
    .meta-item {
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        padding-right: 20px;
    }
    .meta-item:last-child {
        border-right: none;
    }
    .meta-item label {
        display: block;
        font-size: 10px;
        color: #8da39c;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }
    .meta-item span {
        font: 700 16px var(--font);
        color: #fff;
    }
    .meta-item span.accent {
        color: var(--lime);
        font-family: var(--font-latin), sans-serif;
    }

    /* Main Details Grid */
    .project-content-section {
        padding: 90px 8vw;
        display: grid;
        grid-template-columns: 1.3fr 0.8fr;
        gap: 7vw;
        background: #060F1A;
    }
    .detail-card-box {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        padding: 35px;
        margin-bottom: 30px;
    }
    .detail-card-box h3 {
        font-size: 22px;
        font-weight: 800;
        margin: 0 0 18px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .detail-card-box h3 i {
        font-style: normal;
        color: var(--lime);
        font-family: var(--font-latin), sans-serif;
    }
    .detail-card-box p {
        font-size: 14px;
        line-height: 2.1;
        color: #c7d5d1;
        margin: 0;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: 14px;
    }
    .feature-list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 13px;
        line-height: 1.8;
        color: #d8e5e1;
    }
    .feature-list li b {
        color: var(--lime);
        font-size: 16px;
        line-height: 1.2;
    }

    .tech-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 15px;
    }
    .tech-pill {
        background: #112d42;
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #e5f1ee;
        padding: 8px 16px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 600;
        font-family: var(--font-latin), sans-serif;
    }

    /* Visual Showcase */
    .project-visual-banner {
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 40px;
        position: relative;
        min-height: 380px;
        display: flex;
        align-items: flex-end;
        padding: 40px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
    }
    .project-visual-banner img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .project-visual-banner-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, rgba(7, 24, 39, 0.92) 10%, rgba(7, 24, 39, 0.3) 60%, transparent 100%);
    }
    .banner-overlay-info {
        position: relative;
        z-index: 2;
    }
    .banner-overlay-info b {
        font: 800 36px/1.2 var(--font-latin), var(--font);
        color: #fff;
        display: block;
    }

    /* Next / Prev Navigation */
    .project-pagination-strip {
        padding: 40px 8vw;
        background: #06131f;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .nav-project-btn {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #fff;
        text-decoration: none;
        transition: 0.2s;
    }
    .nav-project-btn:hover {
        color: var(--lime);
    }
    .nav-project-btn span {
        font-size: 11px;
        color: #7b948d;
        display: block;
    }
    .nav-project-btn strong {
        font-size: 16px;
        font-weight: 700;
    }

    @media (max-width: 900px) {
        .project-content-section {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        .meta-strip {
            grid-template-columns: 1fr 1fr;
        }
        .meta-item {
            border-right: none;
        }
    }
</style>
@endpush

@section('content')
<main>
    @php
        $isRtl = app()->getLocale() === 'ar';
    @endphp
    <!-- Project Hero Header -->
    <section class="project-detail-hero">
        <div class="hero-glow-bg"></div>
        <div class="project-hero-content">
            <a href="{{ route('home') }}#work" class="back-nav-link">
                <b>{{ $isRtl ? '→' : '←' }}</b> {{ __('العودة إلى جميع الأعمال') }}
            </a>
            
            <div class="project-badges">
                <span class="badge-tag lime">{{ $project->number_badge ?? '01' }}</span>
                <span class="badge-tag">{{ __($project->country_name) }}</span>
                <span class="badge-tag">{{ __($project->sector_name) }}</span>
                @if($project->duration)
                    <span class="badge-tag">⏱ {{ __('مدة العمل:') }} {{ $project->duration }}</span>
                @endif
                @if($project->delivery_date)
                    <span class="badge-tag">🚀 {{ __('أُنجز في:') }} {{ $project->delivery_date }}</span>
                @endif
            </div>

            <h1 class="project-title-large">{{ $project->title }}</h1>
            <p class="project-subtitle-text">
                {{ $project->subtitle ? $project->subtitle . ' — ' : '' }}
                {{ $project->short_description ?? $project->summary }}
            </p>

            <div class="hero-cta-group">
                @if($project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="btn-live-link">
                        <span>{{ __('زيارة ومعاينة المشروع الحي') }}</span>
                        <b>↗</b>
                    </a>
                @endif
                <button onclick="openConsultModal()" class="outline" style="background:transparent; cursor:pointer; padding: 14px 22px;">
                    {{ __('طلب مشروع مشابه ↗') }}
                </button>
            </div>
        </div>
    </section>

    <!-- Key Facts Strip -->
    <section class="meta-strip">
        <div class="meta-item">
            <label>{{ __('العميل والجهة') }}</label>
            <span>{{ $project->client_name ?? $project->title }}</span>
        </div>
        <div class="meta-item">
            <label>{{ __('مدة التنفيذ') }}</label>
            <span class="accent">{{ $project->duration ?? '-' }}</span>
        </div>
        <div class="meta-item">
            <label>{{ __('تاريخ الإطلاق والعمل') }}</label>
            <span>{{ $project->delivery_date ?? '-' }}</span>
        </div>
        <div class="meta-item">
            <label>{{ __('السوق والقطاع') }}</label>
            <span>{{ __($project->country_name) }} · {{ __($project->sector_name) }}</span>
        </div>
        @if($project->impact_stat)
            <div class="meta-item">
                <label>{{ __('الأثر المحقق') }}</label>
                <span class="accent">{{ $project->impact_stat }}</span>
            </div>
        @endif
    </section>

    <!-- Project Details Body -->
    <section class="project-content-section">
        <!-- Left Column: Story, Challenge, Solution & Gallery -->
        <div>
            <!-- Visual Hero Banner -->
            <div class="project-visual-banner {{ $project->gradient_class }}">
                @if($project->hero_image)
                    <img src="{{ $project->display_image }}" alt="{{ $project->title }}"/>
                    <div class="project-visual-banner-overlay"></div>
                @endif
                <div class="banner-overlay-info">
                    <b>{{ $project->title }}</b>
                    <span style="font-size: 13px; color: var(--lime);">{{ $project->subtitle }}</span>
                </div>
            </div>

            <!-- Summary / Overview -->
            <div class="detail-card-box">
                <h3><i>01</i> {{ __('نبذة عامة عن المشروع') }}</h3>
                <p>{{ $project->summary ?? $project->short_description ?? __('مشروع تقني متكامل تم بناؤه وتطويره بواسطة فريق OX Tech لتوفير تجربة مستخدم فائقة وسرعة تشغيل عالية.') }}</p>
            </div>

            <!-- Challenge & Solution -->
            @if($project->challenge || $project->solution)
                <div class="detail-card-box">
                    <h3><i>02</i> {{ __('التحدي وحل OX Tech') }}</h3>
                    @if($project->challenge)
                        <div style="margin-bottom: 20px;">
                            <strong style="color: #ff8585; display: block; font-size: 13px; margin-bottom: 6px;">⚠️ {{ __('التحدي التشغيلي والتقني:') }}</strong>
                            <p>{{ $project->challenge }}</p>
                        </div>
                    @endif
                    @if($project->solution)
                        <div>
                            <strong style="color: var(--lime); display: block; font-size: 13px; margin-bottom: 6px;">💡 {{ __('الحل المنفذ:') }}</strong>
                            <p>{{ $project->solution }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Live Link CTA Box -->
            @if($project->live_url)
                <div class="detail-card-box" style="background: linear-gradient(135deg, rgba(31, 99, 255, 0.15), rgba(201, 250, 75, 0.05)); border-color: rgba(31, 99, 255, 0.3);">
                    <h3 style="margin-bottom: 10px;">🔗 {{ __('رابط المعاينة الحية') }}</h3>
                    <p style="margin-bottom: 18px;">{{ __('يمكنك تفقد وتجربة النسخة الحية من المشروع مباشرة:') }}</p>
                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="btn-live-link" style="display: inline-flex;">
                        <span>{{ $project->live_url }}</span>
                        <b>↗</b>
                    </a>
                </div>
            @endif
        </div>

        <!-- Right Column: Features, Tech Stack, Metadata & CTA -->
        <div>
            <!-- Key Features -->
            @if(!empty($project->key_features) && count($project->key_features) > 0)
                <div class="detail-card-box">
                    <h3><i>03</i> {{ __('أبرز الميزات والوظائف') }}</h3>
                    <ul class="feature-list">
                        @foreach($project->key_features as $feature)
                            <li>
                                <b>✓</b>
                                <span>{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Technologies -->
            @if(!empty($project->technologies) && count($project->technologies) > 0)
                <div class="detail-card-box">
                    <h3><i>04</i> {{ __('التقنيات والمكتبات') }}</h3>
                    <div class="tech-tags">
                        @foreach($project->technologies as $tech)
                            <span class="tech-pill">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quick Project Consultation Card -->
            <div class="detail-card-box" style="background: linear-gradient(145deg, #112a3a, #060F1A); border-color: rgba(201, 250, 75, 0.3);">
                <p class="kicker" style="color: var(--lime); margin-bottom: 8px;">GET STARTED</p>
                <h3 style="font-size: 20px; margin-bottom: 10px;">{{ __('معجب بهذا المشروع؟') }}</h3>
                <p style="font-size: 12px; line-height: 1.9; margin-bottom: 20px;">
                    {{ __('يمكننا بناء منتجك الرقمي بنفس المستوى من الدقة والسرعة والجودة.') }}
                </p>
                <button onclick="openConsultModal()" class="form-submit-btn" style="cursor: pointer;">
                    <span>{{ __('احجز استشارة لمشروعك') }}</span>
                    <b style="margin-inline-start: 6px;">{{ $isRtl ? '←' : '→' }}</b>
                </button>
            </div>
        </div>
    </section>

    <!-- Pagination & Next Project Navigation -->
    <section class="project-pagination-strip">
        @if($prevProject)
            <a href="{{ route('projects.show', $prevProject->slug) }}" class="nav-project-btn">
                <b style="font-size: 20px;">{{ $isRtl ? '→' : '←' }}</b>
                <div>
                    <span>{{ __('المشروع السابق') }}</span>
                    <strong>{{ $prevProject->title }}</strong>
                </div>
            </a>
        @else
            <div></div>
        @endif

        <a href="{{ route('home') }}#work" class="outline" style="font-size: 11px;">{{ __('كل المشاريع') }}</a>

        @if($nextProject)
            <a href="{{ route('projects.show', $nextProject->slug) }}" class="nav-project-btn" style="text-align: {{ $isRtl ? 'left' : 'right' }};">
                <div>
                    <span>{{ __('المشروع التالي') }}</span>
                    <strong>{{ $nextProject->title }}</strong>
                </div>
                <b style="font-size: 20px;">{{ $isRtl ? '←' : '→' }}</b>
            </a>
        @else
            <div></div>
        @endif
    </section>
</main>
@endsection
