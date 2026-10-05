@extends('layouts.app')

@section('title', 'OX Tech | نبني ما يحرك عملك')

@section('content')
<main id="home">
    @php
        $locale = request('lang', session('locale', request()->cookie('locale', app()->getLocale() ?: 'ar')));
        if (!in_array($locale, ['ar', 'en', 'fr'])) {
            $locale = 'ar';
        }
        app()->setLocale($locale);

        $showcaseTexts = [
            'ar' => [
                'intro' => 'OX Tech لا تبرمج فقط. نبني ما يُحرّك عملك.',
                'header_1' => 'كل مشروع ريادي يبدأ بـ',
                'header_2' => 'OX Tech',
                't1_icon' => 'rocket-outline',
                't1_title' => 'بنية سحابية فائقة',
                't1_desc' => 'حلول سحابية وتطبيقات قابلة للتوسع غير المحدود، تعمل بأعلى معايير الأمان والاستقرار المستمر.',
                't2_icon' => 'sparkles-outline',
                't2_title' => 'حلول رقمية ذكية',
                't2_desc' => 'ندمج أحدث تقنيات البرمجة والذكاء الاصطناعي في صلب عملك، لنحوّل رؤيتك إلى منتج تقني رائد.',
            ],
            'en' => [
                'intro' => "OX Tech doesn't just code. We build what moves you.",
                'header_1' => "Every Great Product Starts With",
                'header_2' => "OX Tech",
                't1_icon' => 'rocket-outline',
                't1_title' => "Engineered to Scale",
                't1_desc' => "High-performance cloud architecture and mobile apps built to scale limitlessly with zero downtime.",
                't2_icon' => 'sparkles-outline',
                't2_title' => "Intelligent Engineering",
                't2_desc' => "Custom software and AI-driven systems crafted to transform your vision into market-leading products.",
            ],
            'fr' => [
                'intro' => "OX Tech ne code pas seulement. Nous bâtissons votre avenir.",
                'header_1' => "Chaque vision digitale commence par",
                'header_2' => "OX Tech",
                't1_icon' => 'rocket-outline',
                't1_title' => "Ingénierie Haute Performance",
                't1_desc' => "Architecture cloud et applications mobiles conçues pour évoluer sans limites avec une fiabilité maximale.",
                't2_icon' => 'sparkles-outline',
                't2_title' => "Solutions Intelligentes",
                't2_desc' => "Des systèmes sur mesure intégrant l'IA pour transformer vos ambitions en succès numériques durables.",
            ]
        ];

        $txt = $showcaseTexts[$locale] ?? $showcaseTexts['ar'];
    @endphp

    <!-- =========================================
         HERO SECTION (SAUDI × EGYPT MASTER)
         ========================================= -->
    <section class="ox-hero" id="hero">
        <div class="ox-hero-overlay"></div>

        <!-- Islamic Arabesque Corner Tracery Patterns -->
        <div class="arabesque-corner corner-top-right"></div>
        <div class="arabesque-corner corner-top-left"></div>
        <div class="arabesque-corner corner-bottom-right"></div>
        <div class="arabesque-corner corner-bottom-left"></div>

        <div class="container ox-hero-container">
            <div class="ox-hero-content reveal">
                @if($locale === 'ar')
                    <h1 class="ox-hero-heading">
                        كل مشروع<br/>
                        <span class="text-green">رؤية أكبر</span>
                    </h1>
                    <p class="ox-hero-subtitle">
                        في OxTech لا نبني برامج فقط<br/>
                        نحن نبني عملك للمستقبل.
                    </p>
                @elseif($locale === 'fr')
                    <h1 class="ox-hero-heading">
                        Chaque Projet<br/>
                        <span class="text-green">Une Vision Plus Grande</span>
                    </h1>
                    <p class="ox-hero-subtitle">
                        Chez OxTech, nous ne concevons pas seulement des logiciels.<br/>
                        Nous bâtissons votre entreprise pour l'avenir.
                    </p>
                @else
                    <h1 class="ox-hero-heading">
                        Every Project<br/>
                        <span class="text-green">A Bigger Vision</span>
                    </h1>
                    <p class="ox-hero-subtitle">
                        At OxTech, we don't just build software.<br/>
                        We engineer your business for the future.
                    </p>
                @endif

                <div class="ox-hero-actions">
                    <a href="#consult" onclick="openConsultModal(); return false;" class="btn-primary ox-hero-btn-primary">
                        <span>{{ $locale === 'ar' ? 'ابدأ مشروعك' : ($locale === 'fr' ? 'Démarrer Votre Projet' : 'Start Your Project') }}</span>
                        <span class="btn-arrow-icon">{{ $locale === 'ar' ? '←' : '→' }}</span>
                    </a>
                    
                    <button type="button" class="ox-hero-btn-video" onclick="document.querySelector('#stories')?.scrollIntoView({behavior:'smooth'})">
                        <span class="play-circle-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="6,4 20,12 6,20"></polygon>
                            </svg>
                        </span>
                        <span>{{ $locale === 'ar' ? 'شاهد قصتنا' : ($locale === 'fr' ? 'Voir Notre Histoire' : 'Watch Our Story') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Brands & Partners Marquee Section (Matching Reference Card Design with Monochrome-to-Color Hover) -->
    {{--
    <section class="brands-marquee-section">
        <!-- <div class="brands-header reveal">
            <p class="kicker">{{ $locale === 'ar' ? 'تكاملات وشراكات استراتيجية' : ($locale === 'fr' ? 'ÉCOSYSTÈME & INTÉGRATIONS' : 'ECOSYSTEM & INTEGRATIONS') }}</p>
            @if($locale === 'ar')
                <h3>تكامل سلس مع <span class="accent-highlight">+80 شريك</span> عالمي ومحلي، لتلبية جميع احتياجاتك وتوسيع إمكانياتك بسهولة</h3>
                <p class="brands-subtitle">ربط منجز مع أنظمة المبيعات والمحاسبة والمخزون لديك، تكامل مباشر مع منصات التجارة الإلكترونية، أنظمة CRM أخرى، وأدوات الدفع الإلكتروني لأتمتة كاملة من أول تفاعل إلى إتمام البيع.</p>
            @elseif($locale === 'fr')
                <h3>Intégration fluide avec plus de <span class="accent-highlight">+80 partenaires</span> mondiaux et locaux, pour répondre à tous vos besoins.</h3>
                <p class="brands-subtitle">Connexion directe avec les leaders des ERP, plateformes e-commerce, CRM et passerelles de paiement pour une automatisation complète.</p>
            @else
                <h3>Seamless integration with <span class="accent-highlight">+80 global & local partners</span>, to fulfill your needs and scale effortlessly.</h3>
                <p class="brands-subtitle">Direct, unified integration with top enterprise ERPs, eCommerce engines, CRMs, and payment gateways for end-to-end operational automation.</p>
            @endif
        </div> -->

        <div class="marquee-container">
            <!-- Row 1: Leftward Scroll (Moving Left) -->
            <div class="marquee-row" title="حرك الفأرة لإيقاف الحركة وإظهار الألوان الأصلية">
                <div class="marquee-track track-left">
                    @for($repeat = 0; $repeat < 2; $repeat++)
                        <!-- Yellow Order Up -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 140 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <text x="50%" y="24" text-anchor="middle" font-family="var(--font-latin)" font-weight="800" font-size="26" fill="#c49b09">Yellow</text>
                                <text x="50%" y="36" text-anchor="middle" font-family="var(--font-latin)" font-weight="700" font-size="9" letter-spacing="1.5" fill="#a37e06">ORDER UP!</text>
                            </svg>
                        </div>

                        <!-- CleanCloud -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 150 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(4, 8)">
                                    <path d="M14 6C15.8 3.5 18.7 2 22 2C27.5 2 32 6.5 32 12C32 12.3 32 12.7 31.9 13C34.3 14 36 16.3 36 19C36 22.9 32.9 26 29 26H11C6.6 26 3 22.4 3 18C3 14 5.9 10.7 9.8 10.1C10.8 7.6 13.2 6 16 6" fill="#0084ff"/>
                                    <circle cx="15" cy="16" r="3.5" fill="#ffffff"/>
                                </g>
                                <text x="48" y="27" font-family="var(--font-latin)" font-weight="800" font-size="18" fill="#0c2340">Clean<tspan font-weight="500">Cloud</tspan></text>
                            </svg>
                        </div>

                        <!-- Vend -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 130 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="25" y="4" width="80" height="32" rx="7" fill="#2eb85c"/>
                                <text x="65" y="26" text-anchor="middle" font-family="var(--font-latin)" font-weight="800" font-size="20" fill="#ffffff" letter-spacing="-0.5">vend</text>
                            </svg>
                        </div>

                        <!-- FOODICS -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 140 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <text x="50%" y="27" text-anchor="middle" font-family="var(--font-latin)" font-weight="900" font-size="22" letter-spacing="2.5" fill="#121826">FOODICS</text>
                                <circle cx="126" cy="21" r="3.5" fill="#ff2a5f"/>
                            </svg>
                        </div>

                        <!-- Magento -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 140 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(10, 6)">
                                    <path d="M14 2L2 9V23L7 26V12L14 8L21 12V26L26 23V9L14 2Z" fill="#ea580c"/>
                                    <path d="M14 14L10 16.5V25.5L14 28L18 25.5V16.5L14 14Z" fill="#ea580c"/>
                                </g>
                                <text x="46" y="26" font-family="var(--font-latin)" font-weight="700" font-size="19" fill="#1f2937">Magento</text>
                            </svg>
                        </div>

                        <!-- Kentoo -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 130 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(15, 6)">
                                    <circle cx="14" cy="14" r="13" fill="#14b8a6"/>
                                    <path d="M9 7V21M9 14L18 7M11 12L19 21" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                                <text x="52" y="26" font-family="var(--font-latin)" font-weight="800" font-size="18" fill="#1e293b">kentoo</text>
                            </svg>
                        </div>

                        <!-- SAP -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 110 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 3H75L106 39H4V3Z" fill="#008FD3"/>
                                <path d="M22 13C17 13 14 16 14 19C14 26 27 23 27 28C27 32 22 33 19 32C15 31 13 28 13 28L10 32C10 32 14 36 20 36C26 36 31 32 31 27C31 20 18 22 18 17C18 15 21 14 24 15C26 15 28 17 28 17L31 13C31 13 27 13 22 13Z" fill="#ffffff"/>
                                <path d="M39 13L32 35H36L38 29H47L49 35H53L45 13H39ZM42 17L45.5 26H38.5L42 17Z" fill="#ffffff"/>
                                <path d="M55 13V35H59V27H66C71 27 74 24 74 20C74 15 70 13 66 13H55ZM59 17H65C68 17 70 18 70 20C70 23 67 24 65 24H59V17Z" fill="#ffffff"/>
                            </svg>
                        </div>

                        <!-- Odoo -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <text x="50%" y="28" text-anchor="middle" font-family="var(--font-latin)" font-weight="900" font-size="28" letter-spacing="1" fill="#714B67">odoo</text>
                            </svg>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Row 2: Rightward Scroll (Moving Right) -->
            <div class="marquee-row" title="حرك الفأرة لإيقاف الحركة وإظهار الألوان الأصلية">
                <div class="marquee-track track-right">
                    @for($repeat = 0; $repeat < 2; $repeat++)
                        <!-- Qoyod (قيود) -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 140 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(14, 8)">
                                    <circle cx="12" cy="12" r="10" fill="#0284c7"/>
                                    <circle cx="12" cy="12" r="5" fill="#ffffff"/>
                                    <circle cx="21" cy="6" r="3" fill="#38bdf8"/>
                                    <circle cx="3" cy="18" r="3" fill="#38bdf8"/>
                                </g>
                                <g transform="translate(48, 12)">
                                    <text x="0" y="14" font-family="'Alexandria', sans-serif" font-weight="800" font-size="16" fill="#0f172a">قيـود</text>
                                    <text x="0" y="24" font-family="var(--font-latin)" font-weight="700" font-size="8" letter-spacing="1.5" fill="#0284c7">QOYOD</text>
                                </g>
                            </svg>
                        </div>

                        <!-- ZenHR -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 140 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="24" cy="20" r="13" fill="#00b4d8"/>
                                <path d="M18 20L22 24L30 16" stroke="#ffffff" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <text x="46" y="26" font-family="var(--font-latin)" font-weight="800" font-size="18" fill="#0f172a">zen<tspan fill="#00b4d8">HR</tspan></text>
                            </svg>
                        </div>

                        <!-- Lightspeed -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 150 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(14, 8)">
                                    <path d="M12 2C8 6 3 14 3 18C3 23 7 26 12 26C17 26 21 23 21 18C21 14 16 6 12 2Z" fill="#ed1c24"/>
                                    <path d="M12 9C10 12 7 16 7 19C7 21.8 9.2 23 12 23C14.8 23 17 21.8 17 19C17 16 14 12 12 9Z" fill="#ffffff"/>
                                </g>
                                <text x="46" y="26" font-family="var(--font-latin)" font-weight="800" font-size="16" fill="#18181b">lightspeed</text>
                            </svg>
                        </div>

                        <!-- Oracle NetSuite -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 150 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <text x="50%" y="16" text-anchor="middle" font-family="var(--font-latin)" font-weight="900" font-size="12" letter-spacing="3" fill="#e51c24">ORACLE</text>
                                <text x="50%" y="32" text-anchor="middle" font-family="var(--font-latin)" font-weight="800" font-size="15" letter-spacing="1.5" fill="#18181b">NETSUITE</text>
                            </svg>
                        </div>

                        <!-- STC Pay -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 130 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="24" cy="20" r="13" fill="#4f008c"/>
                                <circle cx="24" cy="20" r="6" fill="#ff3366"/>
                                <text x="46" y="26" font-family="var(--font-latin)" font-weight="800" font-size="17" fill="#18181b">stc <tspan fill="#ff3366">pay</tspan></text>
                            </svg>
                        </div>

                        <!-- Tabby -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="14" y="8" width="92" height="24" rx="6" fill="#2ee59d"/>
                                <text x="60" y="25" text-anchor="middle" font-family="var(--font-latin)" font-weight="900" font-size="17" letter-spacing="-0.5" fill="#030B12">tabby</text>
                            </svg>
                        </div>

                        <!-- Tamara -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 130 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="tamaraGrad{{ $repeat }}" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="#ff5e3a"/>
                                        <stop offset="100%" stop-color="#ffa03a"/>
                                    </linearGradient>
                                </defs>
                                <text x="50%" y="27" text-anchor="middle" font-family="var(--font-latin)" font-weight="900" font-size="22" letter-spacing="-0.5" fill="url(#tamaraGrad{{ $repeat }})">tamara</text>
                            </svg>
                        </div>

                        <!-- Jahez (جاهز) -->
                        <div class="brand-card">
                            <svg class="brand-logo-svg" viewBox="0 0 130 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="14" y="6" width="28" height="28" rx="6" fill="#e30613"/>
                                <text x="28" y="25" text-anchor="middle" font-family="'Alexandria', sans-serif" font-weight="900" font-size="14" fill="#ffffff">جـ</text>
                                <text x="52" y="27" font-family="'Alexandria', sans-serif" font-weight="800" font-size="18" fill="#18181b">جاهـز</text>
                            </svg>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>
    --}}


  
    <!-- =========================================
         OUR SERVICES SECTION (MASTER THEME)
         ========================================= -->
        <section class="ox-services-section ox-portfolio-showcase" id="work">
        <span id="services" style="display:block; position:relative; top:-90px; visibility:hidden;"></span>
        <!-- Arabesque Corner Motifs -->
        <div class="services-arabesque corner-top-right"></div>
        <div class="services-arabesque corner-top-left"></div>

        <div class="container services-header-wrap reveal">
            <div class="services-header-text">
                <span class="services-kicker">
                    <span class="ox-kicker-dot"></span>
                    {{ $locale === 'ar' ? 'سابقة أعمالنا · Portfolio' : ($locale === 'fr' ? 'Nos Réalisations · Portfolio' : 'Our Portfolio & Case Studies') }}
                </span>
                <h2 class="services-title">
                    {{ $locale === 'ar' ? 'مشاريع حقيقية تصنع' : ($locale === 'fr' ? 'Des Projets Réels à Fort' : 'Real Projects Engineered for') }}<br/>
                    <span class="text-green">{{ $locale === 'ar' ? 'أثراً ملموساً ونمواً متسارعاً.' : ($locale === 'fr' ? 'Impact et Croissance.' : 'Scalable Impact.') }}</span>
                </h2>
                <p class="services-subtitle">
                    {{ $locale === 'ar' ? 'استكشف نماذج من أعمالنا وحلولنا البرمجية التي قمنا بتطويرها لشركاء النجاح عبر مختلف الدول والقطاعات مع قياس دقيق للأثر والنتائج.' : ($locale === 'fr' ? 'Explorez nos projets et solutions logicielles développés pour nos partenaires à travers différents pays et secteurs.' : 'Explore custom platforms, SaaS, and mobile applications engineered for our partners across various regions and industries.') }}
                </p>
            </div>
        </div>

        <div class="container">
            <!-- ─── Dual-Filter Bar (Category + Country with Flags) ─── -->
            <div class="portfolio-filter-container reveal">
                <!-- Level 1: Category / Sector Tabs -->
                <div class="portfolio-category-tabs">
                    <button type="button" class="portfolio-cat-btn active" data-cat="all" onclick="filterPortfolio('cat', 'all', this)">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <span>{{ $locale === 'ar' ? 'جميع المجالات' : ($locale === 'fr' ? 'Tous les secteurs' : 'All Sectors') }}</span>
                        <span class="filter-count">{{ $projects->count() }}</span>
                    </button>
                    @foreach($sectors as $sec)
                        @php
                            $secCount = $projects->where('sector_slug', $sec->sector_slug)->count();
                        @endphp
                        <button type="button" class="portfolio-cat-btn" data-cat="{{ $sec->sector_slug }}" onclick="filterPortfolio('cat', '{{ $sec->sector_slug }}', this)">
                            <span>{{ $sec->sector_name }}</span>
                            @if($secCount > 0)
                                <span class="filter-count">{{ $secCount }}</span>
                            @endif
                        </button>
                    @endforeach
                </div>

                <!-- Level 2: Country Flag Pills -->
                <div class="portfolio-country-filter">
                    <div class="country-filter-label">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        <span>{{ $locale === 'ar' ? 'الدولة:' : ($locale === 'fr' ? 'Pays:' : 'Country:') }}</span>
                    </div>
                    <div class="country-pills-list">
                        <button type="button" class="country-pill-btn active" data-country="all" onclick="filterPortfolio('country', 'all', this)">
                            <span class="flag-icon">🌐</span>
                            <span>{{ $locale === 'ar' ? 'جميع الدول' : ($locale === 'fr' ? 'Tous pays' : 'All Countries') }}</span>
                        </button>
                        @foreach($countries as $country)
                            <button type="button" class="country-pill-btn" data-country="{{ strtolower($country->country_code) }}" onclick="filterPortfolio('country', '{{ strtolower($country->country_code) }}', this)">
                                <span class="flag-icon">{{ $country->flag ?? '🌐' }}</span>
                                <span>{{ $country->country_name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ─── Portfolio Cards Grid with High-Res Thumbnails ─── -->
            <div class="ox-portfolio-grid" id="portfolioGrid">
                @forelse($projects as $project)
                    @php
                        $countryLower = strtolower($project->country_code ?? '');
                        $projectSector = $project->sector_slug ?? 'general';
                        $projectImg = $project->display_image;
                    @endphp
                    <article class="ox-portfolio-card reveal" 
                             data-category="{{ $projectSector }}" 
                             data-country="{{ $countryLower }}"
                             onclick="window.location.href='{{ route('projects.show', $project->slug) }}'">
                        
                        <!-- Thumbnail Visual Media -->
                        <div class="portfolio-card-media">
                            <img src="{{ $projectImg }}" 
                                 alt="{{ $project->title }}" 
                                 loading="lazy" 
                                 class="portfolio-card-img" />
                            <div class="portfolio-card-overlay"></div>
                            
                            <!-- Top Floating Badges: Country with Flag & Sector -->
                            <div class="portfolio-badges-top">
                                <span class="portfolio-country-badge">
                                    <span class="badge-flag">{{ $project->country_flag }}</span>
                                    <span>{{ $project->country_name }}</span>
                                </span>
                                @if($project->sector_name)
                                    <span class="portfolio-sector-badge">{{ $project->sector_name }}</span>
                                @endif
                            </div>

                            @if($project->impact_stat)
                                <div class="portfolio-impact-chip">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                        <polyline points="17 6 23 6 23 12"></polyline>
                                    </svg>
                                    <span>{{ $project->impact_stat }}</span>
                                </div>
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
                                    {{ $project->short_description ?: Str::limit($project->summary, 95) }}
                                </p>
                            </div>

                            <!-- Technologies Tags -->
                            @if(!empty($project->technologies) && is_array($project->technologies))
                                <div class="portfolio-tech-tags">
                                    @foreach(array_slice($project->technologies, 0, 4) as $tech)
                                        <span class="tech-tag">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Bottom Action / CTA -->
                            <div class="portfolio-card-foot">
                                <span class="portfolio-view-text">
                                    {{ $locale === 'ar' ? 'عرض تفاصيل المشروع' : ($locale === 'fr' ? 'Voir le projet' : 'View Case Study') }}
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
                    <div class="portfolio-empty-state">
                        <p>{{ $locale === 'ar' ? 'لا توجد مشاريع مضافة حالياً.' : 'No projects found.' }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Empty Filter Result Alert -->
            <div id="portfolioNoResults" class="portfolio-no-results" style="display: none;">
                <div class="no-results-icon">🔍</div>
                <h4>{{ $locale === 'ar' ? 'لم نجد مشاريع تطابق هذه الفلترة' : 'No matching projects found' }}</h4>
                <p>{{ $locale === 'ar' ? 'جرّب اختيار تصنيف أو دولة أخرى، أو تصفح كافة مشاريعنا.' : 'Try selecting another category or country' }}</p>
                <button type="button" class="btn-primary" onclick="resetPortfolioFilter()" style="margin-top:15px; font-size:13px; padding:10px 24px;">
                    {{ $locale === 'ar' ? 'عرض جميع المشاريع' : 'Show All Projects' }}
                </button>
            </div>
        </div>
    </section>

    <!-- ─── Services & Software House / 4 Categories Showcase ─── -->
    <section class="ox-beneficiaries-section" id="beneficiaries">
        <div class="ox-beneficiaries-pattern"></div>
        <div class="ox-beneficiaries-skyline"></div>
        <div class="container">
            <!-- Header matching the reference image: Large, modern, focused -->
            <div class="ox-services-cards-header reveal">
                <div class="ox-white-label-pill">
                    <span class="pill-dot"></span>
                    <span>{{ $locale === 'ar' ? 'بيت برمجيات متكامل · شريك White-Label معتمد' : ($locale === 'fr' ? 'Software House Intégrale · Partenaire White-Label' : 'Full Software House · Certified White-Label Partner') }}</span>
                </div>
                <h2 class="ox-services-cards-title">
                    @if($locale === 'ar')
                        نبني الأساس البرمجي الراسخ<br />
                        لنجاح واستدامة أعمالك.
                    @elseif($locale === 'fr')
                        Bâtir les fondations durables<br />
                        de votre succès numérique.
                    @else
                        Creating the foundation<br />
                        for your sustained success.
                    @endif
                </h2>
                <p class="ox-services-cards-desc">
                    @if($locale === 'ar')
                        نقدم حلولاً هندسية متقدمة ونعمل كفريقك التقني الخفي (White-Label) لإنجاز مشاريع عملائك بأعلى معايير السرية والابتكار.
                    @elseif($locale === 'fr')
                        Ingénierie logicielle sur mesure et équipe White-Label dédiée sous accords stricts de confidentialité.
                    @else
                        Engineering high-performance custom digital platforms and operating silently as your dedicated White-Label squad.
                    @endif
                </p>
            </div>

            <!-- 4-Card Luxury Grid matching reference image -->
            <div class="ox-services-cards-grid reveal">
                <!-- Card 1: Web & SaaS Platforms -->
                <article class="ox-service-card-item" onclick="openConsultModal()">
                    <img src="{{ asset('assets/services/service-web.jpg') }}" alt="{{ $locale === 'ar' ? 'تطوير الويب والسحاب' : 'Web & SaaS Platforms' }}" class="ox-service-card-bg" loading="lazy">
                    <div class="ox-service-card-overlay"></div>
                    
                    <div class="ox-service-card-top">
                        <span class="ox-service-card-tag">Web & SaaS</span>
                        <h3 class="ox-service-card-title">{{ $locale === 'ar' ? 'تطوير الويب والسحاب' : ($locale === 'fr' ? 'Web & Plateformes SaaS' : 'Web & SaaS Platforms') }}</h3>
                    </div>

                    <div class="ox-service-card-bottom">
                        <p class="ox-service-card-desc">
                            {{ $locale === 'ar' ? 'بناء منصات سحابية وبوابات SaaS تفاعلية فائقة السرعة والأمان، بمعمارية برمجية قابلة للتوسع اللانهائي.' : ($locale === 'fr' ? 'Plateformes cloud et SaaS hautement sécurisées et scalables.' : 'Scalable cloud architectures, SaaS platforms, and enterprise portals engineered for speed and security.') }}
                        </p>
                        <div class="ox-service-card-circle-btn" aria-label="Explore Service">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </div>
                    </div>
                </article>

                <!-- Card 2: Mobile Applications -->
                <article class="ox-service-card-item" onclick="openConsultModal()">
                    <img src="{{ asset('assets/services/service-mobile.jpg') }}" alt="{{ $locale === 'ar' ? 'تطبيقات الجوال الذكية' : 'Mobile Applications' }}" class="ox-service-card-bg" loading="lazy">
                    <div class="ox-service-card-overlay"></div>
                    
                    <div class="ox-service-card-top">
                        <span class="ox-service-card-tag">iOS & Android</span>
                        <h3 class="ox-service-card-title">{{ $locale === 'ar' ? 'تطبيقات الجوال الذكية' : ($locale === 'fr' ? 'Applications Mobiles' : 'Mobile Applications') }}</h3>
                    </div>

                    <div class="ox-service-card-bottom">
                        <p class="ox-service-card-desc">
                            {{ $locale === 'ar' ? 'تطبيقات جوال سلسة ومتطورة بأحدث التقنيات (Flutter & Native) تضمن تجربة مستخدم استثنائية وأداء فائق السرعة.' : ($locale === 'fr' ? 'Applications fluides et performantes (Flutter & Native).' : 'High-performance iOS & Android mobile apps engineered with Flutter and Native frameworks.') }}
                        </p>
                        <div class="ox-service-card-circle-btn" aria-label="Explore Service">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </div>
                    </div>
                </article>

                <!-- Card 3: Digital E-Commerce -->
                <article class="ox-service-card-item" onclick="openConsultModal()">
                    <img src="{{ asset('assets/services/service-ecommerce.jpg') }}" alt="{{ $locale === 'ar' ? 'المتاجر والتجارة الرقمية' : 'Digital E-Commerce' }}" class="ox-service-card-bg" loading="lazy">
                    <div class="ox-service-card-overlay"></div>
                    
                    <div class="ox-service-card-top">
                        <span class="ox-service-card-tag">E-Commerce</span>
                        <h3 class="ox-service-card-title">{{ $locale === 'ar' ? 'المتاجر والتجارة الرقمية' : ($locale === 'fr' ? 'E-Commerce & Boutiques' : 'Digital E-Commerce') }}</h3>
                    </div>

                    <div class="ox-service-card-bottom">
                        <p class="ox-service-card-desc">
                            {{ $locale === 'ar' ? 'متاجر مخصصة متكاملة مع بوابات الدفع والشحن والأنظمة المحاسبية، مصممة لتحقيق أعلى معدلات التحويل.' : ($locale === 'fr' ? 'Boutiques en ligne optimisées avec passerelles de paiement et logistique.' : 'Custom digital commerce stores integrated with multi-currency gateways and automated fulfillment.') }}
                        </p>
                        <div class="ox-service-card-circle-btn" aria-label="Explore Service">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </div>
                    </div>
                </article>

                <!-- Card 4: Enterprise, Odoo & Desktop -->
                <article class="ox-service-card-item" onclick="openConsultModal()">
                    <img src="{{ asset('assets/services/service-enterprise.jpg') }}" alt="{{ $locale === 'ar' ? 'أنظمة أودو والمؤسسات' : 'Enterprise & Odoo ERP' }}" class="ox-service-card-bg" loading="lazy">
                    <div class="ox-service-card-overlay"></div>
                    
                    <div class="ox-service-card-top">
                        <span class="ox-service-card-tag">ERP & Desktop</span>
                        <h3 class="ox-service-card-title">{{ $locale === 'ar' ? 'أنظمة أودو والمؤسسات' : ($locale === 'fr' ? 'Systèmes Odoo & ERP' : 'Enterprise & Odoo ERP') }}</h3>
                    </div>

                    <div class="ox-service-card-bottom">
                        <p class="ox-service-card-desc">
                            {{ $locale === 'ar' ? 'تطبيق وتخصيص دورات Odoo ERP الشاملة والربط الضريبي (ZATCA)، مع برمجيات Windows ونقاط البيع POS دون إنترنت.' : ($locale === 'fr' ? 'Intégration Odoo ERP complète et logiciels POS offline.' : 'Full-cycle Odoo ERP customization, e-invoicing compliance, and offline-first desktop POS systems.') }}
                        </p>
                        <div class="ox-service-card-circle-btn" aria-label="Explore Service">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Bottom Trust & Action Banner -->
            <div class="ox-services-bottom-trust reveal">
                <div class="ox-trust-features">
                    <div class="ox-trust-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <span>{{ $locale === 'ar' ? 'اتفاقيات سرية تامة (NDA) وتسليم باسمك 100%' : ($locale === 'fr' ? 'Accords NDA stricts & livraison sous votre marque' : 'Strict NDAs & 100% Branded Deliverables') }}</span>
                    </div>
                    <div class="ox-trust-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>{{ $locale === 'ar' ? 'كود نظيف ومعمارية قابلة للتوسع السحابي' : ($locale === 'fr' ? 'Code propre & architecture cloud scalable' : 'Clean Code & Scalable Cloud Architecture') }}</span>
                    </div>
                    <div class="ox-trust-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>{{ $locale === 'ar' ? 'مرونة العمل: بنظام المشروع أو فريق مخصص' : ($locale === 'fr' ? 'Engagement flexible: au projet ou équipe dédiée' : 'Flexible Engagement: Per-Project or Dedicated Squad') }}</span>
                    </div>
                </div>

                <a href="#consult" class="ox-services-trust-cta" onclick="openConsultModal(); return false;">
                    <span>{{ $locale === 'ar' ? 'ابدأ مشروعك أو شراكتك البرمجية' : ($locale === 'fr' ? 'Démarrer votre projet' : 'Start Your Project or Partnership') }}</span>
                    <span>{{ $locale === 'ar' ? '←' : '→' }}</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ─── B2B & B2C Modern Models Section ─── -->
    <section class="ox-models-section" id="models">
        <div class="container">
            <div class="ox-models-grid">
                <!-- Right Side in RTL: Main Headline -->
                <div class="ox-models-header reveal">
                    <h2 class="ox-models-title">
                        {{ $locale === 'ar' ? 'نشتغل مع' : 'We Build For' }} <span class="tag-b2b">B2B</span><br/>
                        {{ $locale === 'ar' ? 'ونفهم' : 'And Master' }} <span class="tag-b2c">B2C.</span>
                    </h2>
                </div>

                <!-- Left Side in RTL: Two Distinct Feature Cards -->
                <div class="ox-models-cards reveal">
                    <!-- Card 1 (Dark Emerald): حلول للشركات والمؤسسات -->
                    <article class="ox-model-card card-dark" onclick="openConsultModal()">
                        <div>
                            <h3 class="model-card-title">{{ $locale === 'ar' ? 'حلول للشركات والمؤسسات' : 'Enterprise & Corporate' }}</h3>
                            <p class="model-card-desc">{{ $locale === 'ar' ? 'أنظمة مخصصة تلبي احتياجات القطاعات الكبيرة' : 'Tailored enterprise architectures engineered for large-scale operations and complex workflows.' }}</p>
                        </div>
                        <div class="model-card-arrow">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </div>
                    </article>

                    <!-- Card 2 (Light Ivory): حلول جاهزة لقطاعك الخاص -->
                    <article class="ox-model-card card-light" onclick="openConsultModal()">
                        <div>
                            <h3 class="model-card-title">{{ $locale === 'ar' ? 'حلول جاهزة لقطاعك الخاص' : 'Turnkey Sector Solutions' }}</h3>
                            <p class="model-card-desc">{{ $locale === 'ar' ? 'منصات وتطبيقات تساعدك على إدارة وتنمية أعمالك' : 'Ready-to-deploy platforms and apps empowering you to scale and manage your business.' }}</p>
                        </div>
                        <div class="model-card-arrow">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── Partner Stories / Testimonials Section (Saudi Sadu Aesthetic & Inline Video Player) ─── -->
    <section class="testimonials section" id="stories">
        <!-- Sadu Corner Accents -->
        <svg class="sadu-corner top-right" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="16" y="0" width="8" height="8" fill="#00E59B"/>
            <rect x="0" y="16" width="8" height="8" fill="#00E59B"/>
            <rect x="32" y="16" width="8" height="8" fill="#00E59B"/>
            <rect x="16" y="32" width="8" height="8" fill="#00E59B"/>
            <rect x="16" y="16" width="8" height="8" fill="#ffffff"/>
            <rect x="8" y="8" width="8" height="8" fill="#C8A96B"/>
            <rect x="24" y="8" width="8" height="8" fill="#C8A96B"/>
            <rect x="8" y="24" width="8" height="8" fill="#C8A96B"/>
            <rect x="24" y="24" width="8" height="8" fill="#C8A96B"/>
        </svg>
        <svg class="sadu-corner top-left" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="16" y="0" width="8" height="8" fill="#00E59B"/>
            <rect x="0" y="16" width="8" height="8" fill="#00E59B"/>
            <rect x="32" y="16" width="8" height="8" fill="#00E59B"/>
            <rect x="16" y="32" width="8" height="8" fill="#00E59B"/>
            <rect x="16" y="16" width="8" height="8" fill="#ffffff"/>
            <rect x="8" y="8" width="8" height="8" fill="#C8A96B"/>
            <rect x="24" y="8" width="8" height="8" fill="#C8A96B"/>
            <rect x="8" y="24" width="8" height="8" fill="#C8A96B"/>
            <rect x="24" y="24" width="8" height="8" fill="#C8A96B"/>
        </svg>

        <div class="container">
            <div class="test-heading reveal">
                <div class="sadu-badge-wrap">
                    <!-- Sadu Ribbon Pattern Left -->
                    <svg width="60" height="14" viewBox="0 0 60 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0" y="4" width="6" height="6" fill="#00E59B"/>
                        <rect x="6" y="0" width="6" height="6" fill="#00E59B"/>
                        <rect x="6" y="8" width="6" height="6" fill="#00E59B"/>
                        <rect x="12" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="18" y="4" width="6" height="6" fill="#00E59B"/>
                        <rect x="24" y="0" width="6" height="6" fill="#00E59B"/>
                        <rect x="24" y="8" width="6" height="6" fill="#00E59B"/>
                        <rect x="30" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="36" y="4" width="6" height="6" fill="#00E59B"/>
                        <rect x="42" y="0" width="6" height="6" fill="#00E59B"/>
                        <rect x="42" y="8" width="6" height="6" fill="#00E59B"/>
                        <rect x="48" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="54" y="4" width="6" height="6" fill="#00E59B"/>
                    </svg>

                    <p class="kicker">{{ $locale === 'ar' ? 'شركاء النجاح' : ($locale === 'fr' ? 'HISTOIRES DE PARTENAIRES' : 'PARTNER STORIES') }}</p>

                    <!-- Sadu Ribbon Pattern Right -->
                    <svg width="60" height="14" viewBox="0 0 60 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0" y="4" width="6" height="6" fill="#00E59B"/>
                        <rect x="6" y="0" width="6" height="6" fill="#00E59B"/>
                        <rect x="6" y="8" width="6" height="6" fill="#00E59B"/>
                        <rect x="12" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="18" y="4" width="6" height="6" fill="#00E59B"/>
                        <rect x="24" y="0" width="6" height="6" fill="#00E59B"/>
                        <rect x="24" y="8" width="6" height="6" fill="#00E59B"/>
                        <rect x="30" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="36" y="4" width="6" height="6" fill="#00E59B"/>
                        <rect x="42" y="0" width="6" height="6" fill="#00E59B"/>
                        <rect x="42" y="8" width="6" height="6" fill="#00E59B"/>
                        <rect x="48" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="54" y="4" width="6" height="6" fill="#00E59B"/>
                    </svg>
                </div>

                <h2>{{ $locale === 'ar' ? 'شركاؤنا' : 'Our Partners' }}<br/>{{ $locale === 'ar' ? 'هم' : 'Are The' }} <span>{{ $locale === 'ar' ? 'الـدليـل.' : 'Proof.' }}</span></h2>
                <p>{{ $locale === 'ar' ? 'قصص حقيقية من شركاء بنوا معنا منتجات رقمية أحدثت نقلة نوعية في تجربة عملائهم ونمو أعمالهم.' : 'Real stories from visionary partners who built category-defining digital products with us.' }}</p>
            </div>

            @if(isset($testimonials) && $testimonials->count() > 0)
                <div class="video-stage reveal" aria-label="فيديوهات آراء الشركاء">
                    @foreach($testimonials as $tIndex => $t)
                        @php
                            $isCenter = ($tIndex === 0);
                            $class = $isCenter ? 'active-video' : ($tIndex === 1 ? 'side-video next' : 'side-video previous');
                            $hasCustomPoster = !empty($t->poster_url);
                        @endphp
                        <div class="video-card {{ $class }}" id="video-card-{{ $tIndex }}" data-video="{{ $tIndex }}" 
                             onclick="handleCardStageClick({{ $tIndex }})">
                            
                            <!-- Thumbnail / Poster Layer -->
                            <div class="card-thumb-layer" id="card-thumb-{{ $tIndex }}" 
                                 style="@if($hasCustomPoster) background-image: url('{{ $t->poster_url }}'); @endif">
                                
                                <!-- Sadu Geometric Pattern Artwork -->
                                <div class="card-sadu-art">
                                    <svg width="180" height="180" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="70" y="10" width="20" height="20" fill="#C8A96B"/>
                                        <rect x="70" y="130" width="20" height="20" fill="#C8A96B"/>
                                        <rect x="10" y="70" width="20" height="20" fill="#C8A96B"/>
                                        <rect x="130" y="70" width="20" height="20" fill="#C8A96B"/>

                                        <rect x="50" y="30" width="20" height="20" fill="#00E59B"/>
                                        <rect x="90" y="30" width="20" height="20" fill="#00E59B"/>
                                        <rect x="30" y="50" width="20" height="20" fill="#00E59B"/>
                                        <rect x="110" y="50" width="20" height="20" fill="#00E59B"/>
                                        <rect x="30" y="90" width="20" height="20" fill="#00E59B"/>
                                        <rect x="110" y="90" width="20" height="20" fill="#00E59B"/>
                                        <rect x="50" y="110" width="20" height="20" fill="#00E59B"/>
                                        <rect x="90" y="110" width="20" height="20" fill="#00E59B"/>

                                        <rect x="70" y="50" width="20" height="20" fill="#ffffff"/>
                                        <rect x="50" y="70" width="20" height="20" fill="#ffffff"/>
                                        <rect x="90" y="70" width="20" height="20" fill="#ffffff"/>
                                        <rect x="70" y="90" width="20" height="20" fill="#ffffff"/>
                                        <rect x="70" y="70" width="20" height="20" fill="#00E59B"/>
                                    </svg>
                                </div>

                                <!-- Top Bar: Badge & Expand Button -->
                                <div class="card-top-bar">
                                    <span class="video-no">{{ $t->number_badge ?? sprintf('%02d', $tIndex + 1) }}</span>
                                    <button type="button" class="expand-btn" title="توسيع ملء الشاشة" 
                                            onclick="event.stopPropagation(); triggerCardFullscreen({{ $tIndex }})">
                                        ⛶
                                    </button>
                                </div>

                                <!-- Center Glowing Play Button -->
                                <div class="card-center-play">
                                    <div class="play-ring" title="تشغيل الفيديو داخل الكارت"
                                         onclick="event.stopPropagation(); startCardVideo({{ $tIndex }})">
                                        ▶
                                    </div>
                                </div>

                                <!-- Bottom Media Player Controls & Partner Info -->
                                <div class="card-media-footer">
                                    <div class="card-partner-info">
                                        <b>{{ $t->partner_name }}</b>
                                        <small>{{ $t->partner_role }}</small>
                                    </div>
                                    <div class="player-timeline">
                                        <div class="player-timeline-fill" id="timeline-fill-{{ $tIndex }}"></div>
                                    </div>
                                    <div class="player-sub-controls">
                                        <span>◀◀</span>
                                        <span style="color:var(--lime, #00E59B); font-size:13px;">▶</span>
                                        <span>▶▶</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Active Inline Video Frame Layer -->
                            <div class="card-video-frame" id="card-video-frame-{{ $tIndex }}">
                                <div class="frame-overlay-controls">
                                    <button type="button" class="frame-btn" title="إغلاق والعودة" 
                                            onclick="event.stopPropagation(); closeCardVideo({{ $tIndex }})">
                                        ✕
                                    </button>
                                    <button type="button" class="frame-btn" title="تكبير ملء الشاشة" 
                                            onclick="event.stopPropagation(); triggerCardFullscreen({{ $tIndex }})">
                                        ⛶
                                    </button>
                                </div>
                                @if($t->video_src)
                                    <video id="native-video-{{ $tIndex }}" 
                                           playsinline 
                                           controls 
                                           preload="metadata" 
                                           src="{{ $t->video_src }}" 
                                           style="width:100%; height:100%; object-fit:cover;"></video>
                                @else
                                    <div style="display:grid; place-items:center; height:100%; color:#00E59B; padding:20px; text-align:center;">
                                        <span>جاري تجهيز فيديو التجربة...</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

               

                <div class="story-controls reveal">
                    <button id="story-prev" type="button" aria-label="{{ $locale === 'ar' ? 'القصة السابقة' : 'Previous Story' }}">←</button>
                    <span><b id="story-count">01</b> / {{ sprintf('%02d', $testimonials->count()) }}</span>
                    <button id="story-next" type="button" aria-label="{{ $locale === 'ar' ? 'القصة التالية' : 'Next Story' }}">→</button>
                </div>
            @endif
        </div>
    </section>

    <!-- ─── Divider into Saudi Roots & Story Section ─── -->
    <div class="sadu-divider" style="color: #0D2925; background-color: #071B19;">
        <svg viewBox="0 0 1200 24" preserveAspectRatio="none">
            <path d="M0,24 L0,12 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 V24 H0 Z" fill="currentColor"/>
        </svg>
    </div>

    <!-- =========================================
         ABOUT / SAUDI ROOTS (نحن من السعودية، وكبرنا بثقة شركائنا)
         ========================================= -->
    <section class="ox-about-section" id="about">
        <!-- Background Elements: Riyadh Skyline Fade (Right) & Islamic Arabesque Tracery (Left) -->
        <div class="ox-about-skyline" style="background-image: url('{{ asset('assets/ox-riyadh-skyline-fade.jpg') }}');"></div>
        <div class="ox-about-arabesque"></div>

        <div class="container ox-container">
            <div class="ox-about-grid">
                <!-- Video Card Column (Right in RTL) -->
                <div class="ox-about-video-wrap reveal">
                    <div class="ox-video-card" onclick="openStoryVideoModal()" role="button" tabindex="0" aria-label="{{ __('مشاهدة قصة نجاح OX Tech') }}">
                        <img src="{{ asset('assets/ox-saudi-founder-video.jpg') }}" alt="شاهد قصة نجاح OX Tech في السعودية" class="ox-video-img" loading="lazy">
                        <div class="ox-video-overlay"></div>
                        
                        <!-- Glassmorphism Play Button in Center -->
                        <div class="ox-video-play-btn" aria-hidden="true">
                            <span class="play-ripple"></span>
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5.14v14l11-7-11-7z"/>
                            </svg>
                        </div>

                        <!-- Bottom-Right Partner Badge inside Card -->
                        <div class="ox-video-partner-badge">
                            <div class="badge-title">{{ __('شركاؤنا') }}</div>
                            <div class="badge-sub">{{ __('في نجاحنا') }}</div>
                        </div>
                    </div>
                    <div class="ox-video-caption">{{ __('شاهد قصة النجاح') }}</div>
                </div>

                <!-- Content Column (Left in RTL) -->
                <div class="ox-about-content reveal">
                    <h2 class="ox-about-title">
                        {{ __('نحن من السعودية،') }}<br>
                        {{ __('وكبرنا بثقة شركائنا.') }}
                    </h2>

                    <p class="ox-about-desc">
                        {{ __('نفخر بأن نكون جزءًا من رحلة التحول الرقمي في المملكة ونعمل مع شركاء يشاركوننا الطموح.') }}
                    </p>

                    <ul class="ox-about-checklist">
                        <li class="ox-about-check-item">
                            <span class="check-item-icon">
                                <svg viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="check-item-text">{{ __('خبرة في السوق السعودي') }}</span>
                        </li>
                        <li class="ox-about-check-item">
                            <span class="check-item-icon">
                                <svg viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="check-item-text">{{ __('فهم عميق لاحتياجات القطاعات') }}</span>
                        </li>
                        <li class="ox-about-check-item">
                            <span class="check-item-icon">
                                <svg viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="check-item-text">{{ __('التزام بالجودة والابتكار') }}</span>
                        </li>
                    </ul>

                    <button type="button" class="ox-about-cta-btn" onclick="openStoryVideoModal()">
                        <span>{{ __('شاهد قصتنا') }}</span>
                        <span class="cta-play-circle">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5.14v14l11-7-11-7z"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- OxTech Story Video Modal -->
    <div id="oxStoryVideoModal" class="ox-story-modal-overlay" onclick="closeStoryVideoModal(event)">
        <div class="ox-story-modal-dialog" onclick="event.stopPropagation()">
            <button type="button" class="ox-story-modal-close" onclick="closeStoryVideoModal()" aria-label="إغلاق">
                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
            <div class="ox-story-video-container">
                <div class="ox-story-video-frame">
                    <img src="{{ asset('assets/ox-saudi-founder-video.jpg') }}" alt="قصة نجاح OX Tech في السعودية" style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.85);">
                    <div class="ox-story-video-player-ui">
                        <div class="player-header">
                            <span class="player-badge">OX TECH · SAUDI ARABIA</span>
                            <h4>{{ __('رحلتنا في التحول الرقمي بالمملكة') }}</h4>
                        </div>
                        <div class="player-controls">
                            <div class="progress-bar"><div class="progress-fill"></div></div>
                            <div class="controls-row">
                                <span class="status-live">● {{ __('متاح للمشاهدة') }}</span>
                                <a href="#consult" onclick="closeStoryVideoModal(); openConsultModal(); return false;" class="player-cta">{{ __('احجز استشارة مع فريقنا ←') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function openStoryVideoModal() {
        var modal = document.getElementById('oxStoryVideoModal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    function closeStoryVideoModal(e) {
        var modal = document.getElementById('oxStoryVideoModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeStoryVideoModal();
    });
    </script>

    <!-- =========================================
         MODERN CTA BANNER & FAST CONTACT (SAUDI × EGYPT)
         ========================================= -->
    <section class="ox-consult-section" id="consult">
        <div class="ox-consult-banner reveal">
            <!-- Background Artwork Layers -->
            <div class="ox-consult-bg-art" aria-hidden="true"></div>
            <div class="ox-consult-arabesque-art" aria-hidden="true"></div>
            <div class="ox-consult-ambient-glow" aria-hidden="true"></div>

            <div class="ox-consult-grid">
                <!-- Right / Intro Content (RTL Leading) -->
                <div class="ox-consult-info-col">
                    @if($locale === 'ar')
                        <h2 class="ox-consult-headline">
                            عندك فكرة؟ خلّينا<br/>
                            <span class="ox-mint-highlight">نبنيها معاً.</span>
                        </h2>
                        <p class="ox-consult-subtitle">
                            سواء مشروع جديد أو تطوير لفكرة حالية<br/>
                            فريقنا جاهز لمساعدتك.
                        </p>
                    @elseif($locale === 'fr')
                        <h2 class="ox-consult-headline">
                            Une idée en tête ?<br/>
                            <span class="ox-mint-highlight">Bâtissons-la ensemble.</span>
                        </h2>
                        <p class="ox-consult-subtitle">
                            Nouveau projet ou développement d'une idée existante,<br/>
                            notre équipe est prête à vous propulser.
                        </p>
                    @else
                        <h2 class="ox-consult-headline">
                            Have an idea?<br/>
                            <span class="ox-mint-highlight">Let's build it together.</span>
                        </h2>
                        <p class="ox-consult-subtitle">
                            Whether a brand-new project or scaling an existing vision,<br/>
                            our engineering team is ready to help you thrive.
                        </p>
                    @endif

                    <div class="ox-consult-actions">
                        <button type="button" onclick="focusConsultForm()" class="ox-consult-btn-primary">
                            <span>{{ $locale === 'ar' ? 'ابدأ الآن' : ($locale === 'fr' ? 'Démarrer' : 'Start Now') }}</span>
                            <span class="ox-consult-arrow-circle">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="{{ $locale === 'ar' ? 'M19 12H5M12 19l-7-7 7-7' : 'M5 12h14M12 5l7 7-7 7' }}"/>
                                </svg>
                            </span>
                        </button>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_phone_primary'] ?? '966500000000') }}?text={{ urlencode($locale === 'ar' ? 'مرحباً OX Tech، أود الاستفسار عن تطوير مشروع تقني' : 'Hello OX Tech, I would like to inquire about software development') }}" target="_blank" rel="noopener noreferrer" class="ox-consult-btn-secondary">
                            <span>{{ $locale === 'ar' ? 'تواصل معنا' : ($locale === 'fr' ? 'Contactez-nous' : 'Contact Us') }}</span>
                        </a>
                    </div>
                </div>

                <!-- Left / Interactive Form Card (RTL Left) -->
                <div class="ox-consult-form-col">
                    <div class="ox-consult-form-card">
                        <div id="inlineFormContent">
                            <h3 class="ox-consult-card-title">
                                {{ $locale === 'ar' ? 'تواصل معنا الآن' : ($locale === 'fr' ? 'Contactez-nous maintenant' : 'Get In Touch Now') }}
                            </h3>

                            <form action="{{ route('consultation.store') }}" method="POST" id="inlineConsultationForm">
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

                                <!-- 2x2 Grid of Inputs -->
                                <div class="ox-consult-row">
                                    <div class="ox-consult-field-wrap">
                                        <input type="text" name="name" id="consult_name" class="ox-consult-input" placeholder="{{ $locale === 'ar' ? 'الاسم الكامل' : ($locale === 'fr' ? 'Nom Complet' : 'Full Name') }}" maxlength="70" required>
                                    </div>
                                    <div class="ox-consult-field-wrap">
                                        <div class="ox-consult-select-wrap">
                                            <select name="project_type" class="ox-consult-select" required>
                                                <option value="" disabled selected hidden>{{ $locale === 'ar' ? 'نوع المشروع' : ($locale === 'fr' ? 'Type de Projet' : 'Project Type') }}</option>
                                                <option value="تطبيقات جوال (iOS & Android)">{{ $locale === 'ar' ? 'تطبيق جوال iOS / Android' : 'Mobile App (iOS / Android)' }}</option>
                                                <option value="منصات ومواقع ويب">{{ $locale === 'ar' ? 'منصات ومواقع ويب' : 'Web & Platforms' }}</option>
                                                <option value="متجر إلكتروني متكامل">{{ $locale === 'ar' ? 'متجر إلكتروني متكامل' : 'E-Commerce Store' }}</option>
                                                <option value="أنظمة SaaS وسحابية">{{ $locale === 'ar' ? 'أنظمة SaaS وسحابية' : 'Cloud / SaaS Solutions' }}</option>
                                                <option value="حلول الذكاء الاصطناعي والأتمتة">{{ $locale === 'ar' ? 'حلول الذكاء الاصطناعي والأتمتة' : 'AI & Automation Solutions' }}</option>
                                                <option value="استشارة وتخطيط تقني">{{ $locale === 'ar' ? 'استشارة وتخطيط تقني' : 'Technical Consultation' }}</option>
                                            </select>
                                            <span class="ox-consult-select-chevron">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M6 9l6 6 6-6"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="ox-consult-row">
                                    <div class="ox-consult-field-wrap">
                                        <input type="email" name="email" class="ox-consult-input" placeholder="{{ $locale === 'ar' ? 'البريد الإلكتروني' : ($locale === 'fr' ? 'Email Pro' : 'Business Email') }}" maxlength="100" required>
                                    </div>
                                    <div class="ox-consult-field-wrap">
                                        <div class="ox-consult-select-wrap">
                                            <select name="budget" class="ox-consult-select" required>
                                                <option value="" disabled selected hidden>{{ $locale === 'ar' ? 'الميزانية التقديرية' : ($locale === 'fr' ? 'Budget Estimé' : 'Estimated Budget') }}</option>
                                                <option value="أقل من $10,000">{{ $locale === 'ar' ? 'أقل من $10,000' : '< $10,000' }}</option>
                                                <option value="$10,000 - $25,000">$10,000 - $25,000</option>
                                                <option value="$25,000 - $50,000">$25,000 - $50,000</option>
                                                <option value="أكثر من $50,000">{{ $locale === 'ar' ? 'أكثر من $50,000' : '> $50,000' }}</option>
                                            </select>
                                            <span class="ox-consult-select-chevron">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M6 9l6 6 6-6"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message Textarea -->
                                <div class="ox-consult-field-wrap" style="margin-bottom: 12px;">
                                    <textarea name="message" class="ox-consult-textarea" rows="3" placeholder="{{ $locale === 'ar' ? 'رسالتك لنا' : ($locale === 'fr' ? 'Votre message' : 'Your Message') }}" minlength="10" maxlength="1000" required></textarea>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="ox-consult-submit-btn" id="inlineSubmitBtn">
                                    <span>{{ $locale === 'ar' ? 'إرسال الطلب' : ($locale === 'fr' ? 'Envoyer la demande' : 'Send Request') }}</span>
                                </button>
                            </form>
                        </div>

                        <!-- Success Celebration Screen -->
                        <div class="ox-consult-success-box" id="inlineSuccessBox">
                            <div class="ox-consult-success-badge">✓</div>
                            <h3>{{ $locale === 'ar' ? 'تم استلام طلبك بنجاح!' : ($locale === 'fr' ? 'Demande envoyée avec succès !' : 'Request Received Successfully!') }}</h3>
                            <p id="successMsgText">
                                {{ $locale === 'ar' ? 'شكرًا لتواصلك معنا. سنقوم بدراسة فكرتك والتواصل معك خلال 24 ساعة لمناقشة التفاصيل.' : ($locale === 'fr' ? 'Merci de nous avoir contactés. Nous reviendrons vers vous sous 24h.' : 'Thank you for reaching out. Our engineering team will review your scope and follow up within 24 hours.') }}
                            </p>
                            <button type="button" class="ox-consult-btn-secondary" onclick="resetInlineForm()" style="font-size: 13px; padding: 10px 24px; margin-top: 10px;">
                                {{ $locale === 'ar' ? 'إرسال طلب آخر' : ($locale === 'fr' ? 'Envoyer un autre message' : 'Send Another Request') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('styles')
<script type="importmap">
{
    "imports": {
        "gsap": "https://cdn.jsdelivr.net/npm/gsap@3.13.0/index.js",
        "gsap/ScrollTrigger": "https://cdn.jsdelivr.net/npm/gsap@3.13.0/ScrollTrigger.js",
        "gsap/SplitText": "https://cdn.jsdelivr.net/npm/gsap@3.13.0/SplitText.js",
        "lenis": "https://cdn.jsdelivr.net/npm/lenis@1.1.14/dist/lenis.mjs",
        "three": "https://cdn.jsdelivr.net/npm/three@0.169.0/build/three.module.js",
        "three/examples/jsm/loaders/GLTFLoader.js": "https://cdn.jsdelivr.net/npm/three@0.169.0/examples/jsm/loaders/GLTFLoader.js",
        "three/examples/jsm/utils/BufferGeometryUtils.js": "https://cdn.jsdelivr.net/npm/three@0.169.0/examples/jsm/utils/BufferGeometryUtils.js",
        "three/examples/jsm/utils/SkeletonUtils.js": "https://cdn.jsdelivr.net/npm/three@0.169.0/examples/jsm/utils/SkeletonUtils.js"
    }
}
</script>
<link rel="stylesheet" href="{{ asset('assets/product-scroll.css') }}">
<noscript>
    <style>
        .reveal { opacity: 1 !important; transform: none !important; }
    </style>
</noscript>
@endpush

@push('scripts')
<script>
    // 1. Reveal on scroll animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.05, rootMargin: '0px 0px 80px 0px' });
    
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Instant & Scroll Fallback: ensure any elements in or near viewport are always visible
    function ensureRevealed() {
        const threshold = window.innerHeight + 120;
        document.querySelectorAll('.reveal:not(.visible)').forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top <= threshold) {
                el.classList.add('visible');
            }
        });
    }

    ensureRevealed();
    window.addEventListener('scroll', ensureRevealed, { passive: true });
    window.addEventListener('resize', ensureRevealed, { passive: true });
    setTimeout(ensureRevealed, 100);
    setTimeout(ensureRevealed, 400);
    setTimeout(ensureRevealed, 1200);
    // Ultimate fail-safe: reveal everything after 2.5s in case observer is blocked
    setTimeout(() => { document.querySelectorAll('.reveal').forEach(el => el.classList.add('visible')); }, 2500);

    // 2. Dual Portfolio Filter (Category + Country with Flags)
    let currentPortfolioCat = 'all';
    let currentPortfolioCountry = 'all';

    window.filterPortfolio = function(type, value, btn) {
        if (type === 'cat') {
            currentPortfolioCat = value;
            document.querySelectorAll('.portfolio-cat-btn').forEach(b => b.classList.remove('active'));
            if (btn) btn.classList.add('active');
        } else if (type === 'country') {
            currentPortfolioCountry = value;
            document.querySelectorAll('.country-pill-btn').forEach(b => b.classList.remove('active'));
            if (btn) btn.classList.add('active');
        }

        const cards = document.querySelectorAll('.ox-portfolio-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardCat = card.getAttribute('data-category');
            const cardCountry = card.getAttribute('data-country');

            const matchCat = (currentPortfolioCat === 'all' || cardCat === currentPortfolioCat);
            const matchCountry = (currentPortfolioCountry === 'all' || cardCountry === currentPortfolioCountry);

            if (matchCat && matchCountry) {
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

        const noRes = document.getElementById('portfolioNoResults');
        if (noRes) {
            noRes.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    };

    window.resetPortfolioFilter = function() {
        currentPortfolioCat = 'all';
        currentPortfolioCountry = 'all';
        document.querySelectorAll('.portfolio-cat-btn').forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-cat') === 'all');
        });
        document.querySelectorAll('.country-pill-btn').forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-country') === 'all');
        });
        filterPortfolio('cat', 'all', null);
    };

    // 4. Partner Stories Video Stage Controller
    const storiesData = {!! $storiesJson ?? '[]' !!};
    let currentStory = 0;
    const videoCards = [...document.querySelectorAll('.video-card')];

    // Setup Video Listeners for Timeline & Auto-Reset on End
    document.querySelectorAll('.card-video-frame video').forEach((vid, idx) => {
        vid.addEventListener('timeupdate', () => {
            if (vid.duration) {
                const pct = (vid.currentTime / vid.duration) * 100;
                const fill = document.getElementById(`timeline-fill-${idx}`);
                if (fill) fill.style.width = `${pct}%`;
            }
        });
        vid.addEventListener('ended', () => {
            closeCardVideo(idx);
        });
    });

    window.showStory = function(n) {
        if (!storiesData || storiesData.length === 0) return;
        
        pauseAllCardVideos();

        currentStory = (n + storiesData.length) % storiesData.length;
        const qText = document.querySelector('#quote-text');
        const qName = document.querySelector('#quote-name');
        const qRole = document.querySelector('#quote-role');
        const sCount = document.querySelector('#story-count');
        if (qText) qText.textContent = storiesData[currentStory][0];
        if (qName) qName.textContent = storiesData[currentStory][1];
        if (qRole) qRole.textContent = storiesData[currentStory][2];
        if (sCount) sCount.textContent = `0${currentStory + 1}`;

        videoCards.forEach((card, i) => {
            const count = videoCards.length;
            let cls = 'side-video next';
            if (i === currentStory) {
                cls = 'active-video';
            } else if (i === (currentStory + count - 1) % count) {
                cls = 'side-video previous';
            }
            card.className = `video-card ${cls}`;
        });
    };

    window.handleCardStageClick = function(index) {
        if (currentStory === index) {
            startCardVideo(index);
        } else {
            showStory(index);
        }
    };

    window.startCardVideo = function(index) {
        if (currentStory !== index) {
            showStory(index);
        }
        const frame = document.getElementById(`card-video-frame-${index}`);
        const vid = document.getElementById(`native-video-${index}`);
        if (frame && vid) {
            frame.classList.add('playing');
            vid.currentTime = 0;
            const playPromise = vid.play();
            if (playPromise !== undefined) {
                playPromise.catch(e => {
                    console.log('Audio autoplay prevented, retrying muted:', e);
                    vid.muted = true;
                    vid.play().catch(err => console.error('Video error:', err));
                });
            }
        }
    };

    window.closeCardVideo = function(index) {
        const frame = document.getElementById(`card-video-frame-${index}`);
        const vid = document.getElementById(`native-video-${index}`);
        if (vid) {
            vid.pause();
        }
        if (frame) {
            frame.classList.remove('playing');
        }
    };

    window.pauseAllCardVideos = function() {
        document.querySelectorAll('.card-video-frame').forEach((frame, idx) => {
            frame.classList.remove('playing');
            const vid = document.getElementById(`native-video-${idx}`);
            if (vid) vid.pause();
        });
    };

    window.triggerCardFullscreen = function(index) {
        startCardVideo(index);
        const vid = document.getElementById(`native-video-${index}`);
        const frame = document.getElementById(`card-video-frame-${index}`);
        const target = vid || frame;

        if (target) {
            if (target.requestFullscreen) {
                target.requestFullscreen();
            } else if (target.webkitRequestFullscreen) {
                target.webkitRequestFullscreen();
            } else if (target.msRequestFullscreen) {
                target.msRequestFullscreen();
            }
        }
    };

    const prevStoryBtn = document.querySelector('#story-prev');
    const nextStoryBtn = document.querySelector('#story-next');
    if (prevStoryBtn) prevStoryBtn.onclick = () => showStory(currentStory - 1);
    if (nextStoryBtn) nextStoryBtn.onclick = () => showStory(currentStory + 1);

    // 5. Interactive Pills for Consultation Form
    document.querySelectorAll('#projectTypePills .pill-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('#projectTypePills .pill-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const hiddenInput = document.getElementById('selectedProjectType');
            if (hiddenInput) hiddenInput.value = this.dataset.val;
        });
    });

    document.querySelectorAll('#budgetPills .pill-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('#budgetPills .pill-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const hiddenBudget = document.getElementById('selectedBudget');
            if (hiddenBudget) hiddenBudget.value = this.dataset.val;
        });
    });

    // 6. Focus consultation form from CTA button
    function focusConsultForm() {
        const nameInput = document.getElementById('consult_name');
        if (nameInput) {
            nameInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => {
                nameInput.focus();
                nameInput.style.borderColor = '#00e59b';
                nameInput.style.boxShadow = '0 0 0 4px rgba(0, 229, 155, 0.25)';
                setTimeout(() => {
                    nameInput.style.borderColor = '';
                    nameInput.style.boxShadow = '';
                }, 1800);
            }, 350);
        }
    }
    window.focusConsultForm = focusConsultForm;

    // 7. Consultation Form AJAX submission
    const inlineForm = document.getElementById('inlineConsultationForm');
    const inlineSubmitBtn = document.getElementById('inlineSubmitBtn');
    const inlineFormContent = document.getElementById('inlineFormContent');
    const inlineSuccessBox = document.getElementById('inlineSuccessBox');

    if (inlineForm) {
        inlineForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (inlineSubmitBtn) {
                inlineSubmitBtn.disabled = true;
                const span = inlineSubmitBtn.querySelector('span');
                if (span) span.textContent = "{{ $locale === 'ar' ? 'جاري إرسال الطلب...' : ($locale === 'fr' ? 'Envoi en cours...' : 'Sending Request...') }}";
            }

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (inlineFormContent) inlineFormContent.style.display = 'none';
                    if (inlineSuccessBox) inlineSuccessBox.style.display = 'block';
                    if (data.message) {
                        const msgEl = document.getElementById('successMsgText');
                        if (msgEl) msgEl.textContent = data.message;
                    }
                } else {
                    alert("{{ __('حدث خطأ أثناء الإرسال، يرجى التحقق من البيانات والمحاولة مجدداً.') }}");
                    if (inlineSubmitBtn) {
                        inlineSubmitBtn.disabled = false;
                        const span = inlineSubmitBtn.querySelector('span');
                        if (span) span.textContent = "{{ $locale === 'ar' ? 'إرسال الطلب' : ($locale === 'fr' ? 'Envoyer la demande' : 'Send Request') }}";
                    }
                }
            })
            .catch(err => {
                console.error(err);
                inlineForm.submit();
            });
        });
    }

    function resetInlineForm() {
        if (inlineForm) inlineForm.reset();
        if (inlineFormContent) inlineFormContent.style.display = 'block';
        if (inlineSuccessBox) inlineSuccessBox.style.display = 'none';
        if (inlineSubmitBtn) {
            inlineSubmitBtn.disabled = false;
            const span = inlineSubmitBtn.querySelector('span');
            if (span) span.textContent = "{{ $locale === 'ar' ? 'إرسال الطلب' : ($locale === 'fr' ? 'Envoyer la demande' : 'Send Request') }}";
        }
    }
    window.resetInlineForm = resetInlineForm;

    // 8. Live Character Counter for Consultation Form
    const inlineMsg = document.querySelector('#inlineConsultationForm textarea[name="message"]');
    const inlineMsgCounter = document.getElementById('inlineMsgCounter');
    if (inlineMsg && inlineMsgCounter) {
        inlineMsg.addEventListener('input', function() {
            inlineMsgCounter.innerText = `${this.value.length} / 1000 حرف`;
            if (this.value.length > 900) {
                inlineMsgCounter.style.color = '#f59e0b';
            } else {
                inlineMsgCounter.style.color = '#8fa099';
            }
        });
    }
</script>

<!-- Ionicons v7 Web Components (self-hosted) -->
<script type="module" src="{{ asset('vendor/ionicons/ionicons.esm.js') }}"></script>
<script nomodule src="{{ asset('vendor/ionicons/ionicons.js') }}"></script>

<!-- 3D Product Scroll Showcase -->
<script type="module" src="{{ asset('assets/product-scroll.js') }}"></script>
@endpush
