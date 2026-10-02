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

        <div class="ox-hero-container">
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

    <!-- =========================================
         STATS BAR (SAUDI × EGYPT MASTER)
         ========================================= -->
    <section class="stats ox-stats" id="stats">
        <div class="container">
            <div class="stats-grid">
                <!-- Stat 1: Completed Projects (+120 مشروع مكتمل) -->
                <div class="stat">
                    <div class="stat-icon-box">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 17l-5-5a2.5 2.5 0 0 1 0-3.5 2.5 2.5 0 0 1 3.5 0L12 11l2.5-2.5a2.5 2.5 0 0 1 3.5 0 2.5 2.5 0 0 1 0 3.5l-5 5"></path>
                            <path d="M18 11l2.5 2.5a2.5 2.5 0 0 1 0 3.5l-5 5a2.5 2.5 0 0 1-3.5 0L9.5 19.5"></path>
                            <path d="M2 13l4-4"></path>
                            <path d="M22 13l-4-4"></path>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">+120</div>
                        <div class="stat-label">{{ $locale === 'ar' ? 'مشروع مكتمل' : ($locale === 'fr' ? 'Projets Réalisés' : 'Completed Projects') }}</div>
                    </div>
                </div>

                <!-- Stat 2: Clients & Partners (+50 عميل وشريك) -->
                <div class="stat">
                    <div class="stat-icon-box">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">+50</div>
                        <div class="stat-label">{{ $locale === 'ar' ? 'عميل وشريك' : ($locale === 'fr' ? 'Clients & Partenaires' : 'Clients & Partners') }}</div>
                    </div>
                </div>

                <!-- Stat 3: Regional Hub (السعودية × مصر / فريق واحد .. رؤية أكبر) -->
                <div class="stat">
                    <div class="stat-icon-box">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number stat-title">{{ $locale === 'ar' ? 'السعودية × مصر' : ($locale === 'fr' ? 'Arabie × Égypte' : 'Saudi × Egypt') }}</div>
                        <div class="stat-label">{{ $locale === 'ar' ? 'فريق واحد .. رؤية أكبر' : ($locale === 'fr' ? 'Une équipe .. Vision élargie' : 'One Team .. Bigger Vision') }}</div>
                    </div>
                </div>

                <!-- Stat 4: 24/7 Support (24/7 دعم مستمر) -->
                <div class="stat">
                    <div class="stat-icon-box">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                            <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">{{ $locale === 'ar' ? 'دعم مستمر' : ($locale === 'fr' ? 'Support Continu' : 'Ongoing Support') }}</div>
                    </div>
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

     <!-- Works & Projects Section -->
    <section class="work section" id="work">
        <div class="work-top reveal">
            <div>
                <p class="kicker">SELECTED WORK</p>
                <h2>{{ __('أعمالنا تتكلم') }}<br/><span>{{ __('بأثرها.') }}</span></h2>
            </div>
            <p>{{ __('فلتر المشاريع حسب السوق أو القطاع، واستكشف كيف حوّلنا التحديات التشغيلية إلى تجارب رقمية واضحة ومربحة.') }}</p>
        </div>

        <div class="filters reveal">
            <div class="filter-group" id="countries">
                <button class="active" data-filter="all">{{ __('كل الدول') }}</button>
                @foreach($countries as $c)
                    <button data-filter="{{ $c->country_code }}">{{ __($c->country_name) }}</button>
                @endforeach
            </div>
            <div class="filter-group dark" id="sectors">
                <button class="active" data-sector="all">{{ __('كل التخصصات') }}</button>
                @foreach($sectors as $s)
                    <button data-sector="{{ $s->sector_slug }}">{{ __($s->sector_name) }}</button>
                @endforeach
            </div>
        </div>

        <div class="projects" id="projects">
            @forelse($projects as $index => $project)
                <article class="project {{ $project->is_big ? 'big' : '' }} {{ $project->country_code }} {{ $project->sector_slug }} reveal">
                    <a href="{{ route('projects.show', $project->slug) }}" class="project-link-card">
                        <div class="project-visual {{ $project->gradient_class }}">
                            <span>{{ $project->number_badge ?? sprintf('%02d', $index + 1) }}</span>
                            <b>{{ $project->title }}</b>
                            <i>{{ $project->subtitle }}</i>
                        </div>
                        <div>
                            <small>{{ __($project->country_name) }} · {{ __($project->sector_name) }}</small>
                            <h3>{{ $project->short_description ?? $project->summary }}</h3>
                            @if($project->impact_stat)
                                <p>{{ $project->impact_stat }}</p>
                            @endif
                        </div>
                    </a>
                </article>
            @empty
                <p style="grid-column: 1/-1; text-align: center; color: #587069; padding: 40px;">{{ __('لا توجد مشاريع مضافة حالياً.') }}</p>
            @endforelse
        </div>
    </section>
  
    <!-- =========================================
         OUR SERVICES SECTION (MASTER THEME)
         ========================================= -->
    <section class="ox-services-section" id="services">
        <!-- Arabesque Corner Motifs -->
        <div class="services-arabesque corner-top-right"></div>
        <div class="services-arabesque corner-top-left"></div>

        <div class="container services-header-wrap reveal">
            <div class="services-header-text">
                <span class="services-kicker">{{ $locale === 'ar' ? 'خدماتنا' : ($locale === 'fr' ? 'Nos Services' : 'Our Services') }}</span>
                <h2 class="services-title">
                    {{ $locale === 'ar' ? 'أعمالنا تتكلم' : ($locale === 'fr' ? 'Nos Réalisations' : 'Our Work Speaks') }}<br/>
                    <span class="text-green">{{ $locale === 'ar' ? 'بأثرها.' : ($locale === 'fr' ? 'Par leur impact.' : 'With Impact.') }}</span>
                </h2>
                <p class="services-subtitle">
                    {{ $locale === 'ar' ? 'حلول رقمية متكاملة تساعدك على النمو وتحقيق أهدافك.' : ($locale === 'fr' ? 'Des solutions numériques complètes pour propulser votre croissance et atteindre vos objectifs.' : 'End-to-end digital solutions engineered to scale your growth and achieve your strategic vision.') }}
                </p>
            </div>

            <div class="services-slider-nav">
                <button type="button" class="services-nav-btn prev" id="servicesPrev" aria-label="{{ $locale === 'ar' ? 'السابق' : 'Previous' }}" onclick="scrollServices(1)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="{{ $locale === 'ar' ? '9 18 15 12 9 6' : '15 18 9 12 15 6' }}"></polyline>
                    </svg>
                </button>
                <button type="button" class="services-nav-btn next" id="servicesNext" aria-label="{{ $locale === 'ar' ? 'التالي' : 'Next' }}" onclick="scrollServices(-1)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="{{ $locale === 'ar' ? '15 18 9 12 15 6' : '9 18 15 12 9 6' }}"></polyline>
                    </svg>
                </button>
            </div>
        </div>

        <div class="container">
            <div class="ox-services-grid" id="servicesGrid">
                <!-- Card 1: Mobile Apps (تطبيقات الموبايل) -->
                <article class="ox-service-card reveal" onclick="openConsultModal()">
                    <div class="service-card-aura"></div>
                    <div class="service-card-body">
                        <div class="service-card-content">
                            <div class="service-card-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="5" y="2" width="14" height="20" rx="3"></rect>
                                    <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                </svg>
                            </div>
                            <h3 class="service-card-title">{{ $locale === 'ar' ? 'تطبيقات الموبايل' : ($locale === 'fr' ? 'Applications Mobiles' : 'Mobile Apps') }}</h3>
                        </div>
                        <div class="service-card-visual">
                            <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- 3D Perspective Smartphone Body -->
                                <g transform="rotate(-6 80 65)">
                                    <rect x="42" y="10" width="76" height="110" rx="14" fill="#030E0C" stroke="#1D8A68" stroke-width="2.5" filter="drop-shadow(0 10px 18px rgba(0,0,0,0.6))"/>
                                    <!-- Inner Display Glass -->
                                    <rect x="47" y="16" width="66" height="98" rx="10" fill="linear-gradient(180deg, #092823 0%, #051613 100%)"/>
                                    <!-- Notch / Dynamic Island -->
                                    <rect x="68" y="20" width="24" height="4" rx="2" fill="#020807"/>
                                    <!-- App Header Widget -->
                                    <rect x="53" y="30" width="54" height="22" rx="5" fill="rgba(29, 138, 104, 0.25)" stroke="rgba(29, 138, 104, 0.4)" stroke-width="1"/>
                                    <circle cx="62" cy="41" r="5" fill="#1D8A68"/>
                                    <rect x="71" y="37" width="28" height="3" rx="1.5" fill="#ffffff"/>
                                    <rect x="71" y="43" width="18" height="2.5" rx="1" fill="#719489"/>
                                    <!-- Metric Wave Graph -->
                                    <path d="M53 78 Q 66 62, 76 72 T 102 58" fill="none" stroke="#2EE59D" stroke-width="2.5" stroke-linecap="round"/>
                                    <path d="M53 78 Q 66 62, 76 72 T 102 58 L 102 86 L 53 86 Z" fill="rgba(46, 229, 157, 0.12)"/>
                                    <!-- Action Button Row -->
                                    <rect x="53" y="94" width="24" height="12" rx="4" fill="#1D8A68"/>
                                    <rect x="83" y="94" width="24" height="12" rx="4" fill="rgba(255,255,255,0.08)"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="service-card-pill">
                        <span class="service-card-pill-text">{{ $locale === 'ar' ? 'تطبيقات مبتكرة لعملك' : ($locale === 'fr' ? 'Solutions mobiles innovantes' : 'Innovative Mobile Apps') }}</span>
                        <span class="service-card-pill-btn">{{ $locale === 'ar' ? '←' : '→' }}</span>
                    </div>
                </article>

                <!-- Card 2: Odoo System (نظام Odoo) -->
                <article class="ox-service-card reveal" onclick="openConsultModal()">
                    <div class="service-card-aura"></div>
                    <div class="service-card-body">
                        <div class="service-card-content">
                            <div class="service-card-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <h3 class="service-card-title">{{ $locale === 'ar' ? 'نظام Odoo' : 'Odoo ERP' }}</h3>
                        </div>
                        <div class="service-card-visual">
                            <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Monitor Stand & Base -->
                                <path d="M72 104L88 104L84 92L76 92Z" fill="#1E3E37"/>
                                <rect x="64" y="104" width="32" height="4" rx="2" fill="#2E5C52"/>
                                <!-- 3D Workstation Monitor -->
                                <rect x="25" y="16" width="110" height="76" rx="8" fill="#041210" stroke="#1D8A68" stroke-width="2" filter="drop-shadow(0 8px 20px rgba(0,0,0,0.6))"/>
                                <rect x="29" y="20" width="102" height="68" rx="5" fill="#08241F"/>
                                <!-- Odoo Top Nav Bar -->
                                <rect x="29" y="20" width="102" height="12" fill="#0B3029"/>
                                <circle cx="36" cy="26" r="2.5" fill="#714B67"/>
                                <circle cx="43" cy="26" r="2.5" fill="#00A09D"/>
                                <circle cx="50" cy="26" r="2.5" fill="#C8A96B"/>
                                <!-- Odoo App Icons Grid (Accounting, Sales, Inventory, CRM) -->
                                <rect x="35" y="38" width="18" height="14" rx="3" fill="#714B67"/>
                                <rect x="58" y="38" width="18" height="14" rx="3" fill="#00A09D"/>
                                <rect x="81" y="38" width="18" height="14" rx="3" fill="#1D8A68"/>
                                <rect x="104" y="38" width="18" height="14" rx="3" fill="#C8A96B"/>
                                <!-- Analytics / Data Table Rows -->
                                <rect x="35" y="58" width="87" height="6" rx="2" fill="rgba(255,255,255,0.08)"/>
                                <rect x="35" y="68" width="87" height="6" rx="2" fill="rgba(255,255,255,0.05)"/>
                                <rect x="35" y="77" width="55" height="5" rx="2" fill="rgba(46,229,157,0.2)"/>
                            </svg>
                        </div>
                    </div>
                    <div class="service-card-pill">
                        <span class="service-card-pill-text">{{ $locale === 'ar' ? 'حلول متكاملة لإدارة أعمالك' : ($locale === 'fr' ? 'Gestion d\'entreprise unifiée' : 'Integrated Enterprise Management') }}</span>
                        <span class="service-card-pill-btn">{{ $locale === 'ar' ? '←' : '→' }}</span>
                    </div>
                </article>

                <!-- Card 3: Websites (مواقع ويب) -->
                <article class="ox-service-card reveal" onclick="openConsultModal()">
                    <div class="service-card-aura"></div>
                    <div class="service-card-body">
                        <div class="service-card-content">
                            <div class="service-card-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </div>
                            <h3 class="service-card-title">{{ $locale === 'ar' ? 'مواقع ويب' : ($locale === 'fr' ? 'Sites Web' : 'Websites') }}</h3>
                        </div>
                        <div class="service-card-visual">
                            <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Laptop Screen (Isometric) -->
                                <g transform="translate(18, 12)">
                                    <rect x="15" y="6" width="94" height="60" rx="5" fill="#041210" stroke="#1D8A68" stroke-width="2"/>
                                    <rect x="18" y="10" width="88" height="52" rx="3" fill="#092823"/>
                                    <!-- Browser Header -->
                                    <rect x="18" y="10" width="88" height="9" fill="#0E352E"/>
                                    <circle cx="23" cy="14.5" r="1.5" fill="#ff5f56"/>
                                    <circle cx="28" cy="14.5" r="1.5" fill="#ffbd2e"/>
                                    <circle cx="33" cy="14.5" r="1.5" fill="#27c93f"/>
                                    <!-- Web Hero Content -->
                                    <rect x="24" y="24" width="46" height="5" rx="1.5" fill="#ffffff"/>
                                    <rect x="24" y="32" width="68" height="3" rx="1" fill="#719489"/>
                                    <rect x="24" y="38" width="50" height="3" rx="1" fill="#719489"/>
                                    <!-- CTA Button on Screen -->
                                    <rect x="24" y="46" width="22" height="8" rx="2" fill="#1D8A68"/>
                                    <!-- Floating Card on Web -->
                                    <rect x="76" y="24" width="24" height="30" rx="3" fill="#123B33" stroke="#2EE59D" stroke-width="1"/>
                                    <!-- Laptop Base / Keyboard Deck -->
                                    <path d="M4 68L120 68L110 88L14 88Z" fill="#0F332C" stroke="#1D8A68" stroke-width="1.5"/>
                                    <rect x="46" y="74" width="32" height="8" rx="2" fill="#051714"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="service-card-pill">
                        <span class="service-card-pill-text">{{ $locale === 'ar' ? 'مواقع احترافية سريعة وآمنة' : ($locale === 'fr' ? 'Sites rapides et sécurisés' : 'High-Performance Websites') }}</span>
                        <span class="service-card-pill-btn">{{ $locale === 'ar' ? '←' : '→' }}</span>
                    </div>
                </article>

                <!-- Card 4: Digital Marketing (التسويق الرقمي) -->
                <article class="ox-service-card reveal" onclick="openConsultModal()">
                    <div class="service-card-aura"></div>
                    <div class="service-card-body">
                        <div class="service-card-content">
                            <div class="service-card-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                            </div>
                            <h3 class="service-card-title">{{ $locale === 'ar' ? 'التسويق الرقمي' : ($locale === 'fr' ? 'Marketing Digital' : 'Digital Marketing') }}</h3>
                        </div>
                        <div class="service-card-visual">
                            <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Curved Isometric Marketing Screen -->
                                <g transform="translate(18, 14)">
                                    <path d="M10 20 C40 10, 80 10, 115 20 L115 88 C80 80, 40 80, 10 88 Z" fill="#051916" stroke="#1D8A68" stroke-width="2" filter="drop-shadow(0 8px 16px rgba(0,0,0,0.5))"/>
                                    <!-- Inner Display Graph -->
                                    <!-- Bar Chart Columns -->
                                    <rect x="24" y="58" width="8" height="20" rx="2" fill="rgba(29, 138, 104, 0.4)"/>
                                    <rect x="38" y="48" width="8" height="30" rx="2" fill="rgba(29, 138, 104, 0.6)"/>
                                    <rect x="52" y="38" width="8" height="40" rx="2" fill="rgba(29, 138, 104, 0.8)"/>
                                    <rect x="66" y="28" width="8" height="50" rx="2" fill="#1D8A68"/>
                                    <rect x="80" y="22" width="8" height="56" rx="2" fill="#2EE59D"/>
                                    <!-- Skyrocketing Trend Line -->
                                    <path d="M22 66 Q 50 48, 70 34 T 98 18" fill="none" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                                    <circle cx="98" cy="18" r="4" fill="#2EE59D" stroke="#ffffff" stroke-width="1.5"/>
                                    <!-- Floating Target / Growth Badge -->
                                    <g transform="translate(90, 52)">
                                        <circle cx="14" cy="14" r="14" fill="#1D8A68" filter="drop-shadow(0 4px 8px rgba(0,0,0,0.4))"/>
                                        <path d="M9 14L12 17L19 10" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="service-card-pill">
                        <span class="service-card-pill-text">{{ $locale === 'ar' ? 'وصول أكبر لعملائك' : ($locale === 'fr' ? 'Portée & conversion maximales' : 'Maximized Customer Reach') }}</span>
                        <span class="service-card-pill-btn">{{ $locale === 'ar' ? '←' : '→' }}</span>
                    </div>
                </article>

                <!-- Card 5: Custom Systems (أنظمة مخصصة) -->
                <article class="ox-service-card reveal" onclick="openConsultModal()">
                    <div class="service-card-aura"></div>
                    <div class="service-card-body">
                        <div class="service-card-content">
                            <div class="service-card-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="16 18 22 12 16 6"></polyline>
                                    <polyline points="8 6 2 12 8 18"></polyline>
                                </svg>
                            </div>
                            <h3 class="service-card-title">{{ $locale === 'ar' ? 'أنظمة مخصصة' : ($locale === 'fr' ? 'Systèmes Sur-Mesure' : 'Custom Systems') }}</h3>
                        </div>
                        <div class="service-card-visual">
                            <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- 3D Perspective Slate Tablet with IDE -->
                                <g transform="translate(20, 10)">
                                    <rect x="22" y="6" width="82" height="96" rx="10" fill="#04120F" stroke="#1D8A68" stroke-width="2" filter="drop-shadow(0 10px 20px rgba(0,0,0,0.6))"/>
                                    <!-- IDE Top Bar -->
                                    <rect x="26" y="10" width="74" height="12" rx="3" fill="#08221D"/>
                                    <circle cx="32" cy="16" r="2" fill="#2EE59D"/>
                                    <circle cx="38" cy="16" r="2" fill="#C8A96B"/>
                                    <!-- Code Lines with Syntax Coloring -->
                                    <rect x="32" y="28" width="22" height="3" rx="1.5" fill="#2EE59D"/>
                                    <rect x="58" y="28" width="32" height="3" rx="1.5" fill="#ffffff"/>
                                    <rect x="38" y="36" width="46" height="3" rx="1.5" fill="#C8A96B"/>
                                    <rect x="38" y="44" width="34" height="3" rx="1.5" fill="#719489"/>
                                    <rect x="38" y="52" width="48" height="3" rx="1.5" fill="#2EE59D"/>
                                    <rect x="32" y="60" width="18" height="3" rx="1.5" fill="#ffffff"/>
                                    <!-- Microchip / Server Nodes -->
                                    <rect x="32" y="70" width="62" height="24" rx="4" fill="rgba(29, 138, 104, 0.15)" stroke="rgba(29, 138, 104, 0.4)" stroke-width="1"/>
                                    <circle cx="44" cy="82" r="4" fill="#1D8A68"/>
                                    <line x1="48" y1="82" x2="62" y2="82" stroke="#2EE59D" stroke-width="1.5" stroke-dasharray="2 2"/>
                                    <circle cx="66" cy="82" r="4" fill="#2EE59D"/>
                                    <line x1="70" y1="82" x2="80" y2="82" stroke="#2EE59D" stroke-width="1.5" stroke-dasharray="2 2"/>
                                    <circle cx="84" cy="82" r="4" fill="#1D8A68"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="service-card-pill">
                        <span class="service-card-pill-text">{{ $locale === 'ar' ? 'حلول تناسب احتياجاتك' : ($locale === 'fr' ? 'Solutions sur-mesure pour vous' : 'Tailored Software Solutions') }}</span>
                        <span class="service-card-pill-btn">{{ $locale === 'ar' ? '←' : '→' }}</span>
                    </div>
                </article>

                <!-- Card 6: UI/UX Design (تصميم UI/UX) -->
                <article class="ox-service-card reveal" onclick="openConsultModal()">
                    <div class="service-card-aura"></div>
                    <div class="service-card-body">
                        <div class="service-card-content">
                            <div class="service-card-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>
                            </div>
                            <h3 class="service-card-title">{{ $locale === 'ar' ? 'تصميم UI/UX' : 'UI/UX Design' }}</h3>
                        </div>
                        <div class="service-card-visual">
                            <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Dual Overlapping Floating Mobile Mockups -->
                                <!-- Back Phone -->
                                <g transform="rotate(-18 50 65) translate(15, 0)">
                                    <rect x="25" y="15" width="52" height="85" rx="10" fill="#041210" stroke="#1D8A68" stroke-width="1.5" opacity="0.8"/>
                                    <rect x="28" y="20" width="46" height="75" rx="7" fill="#08221D"/>
                                    <circle cx="51" cy="35" r="9" fill="rgba(29, 138, 104, 0.4)"/>
                                    <rect x="36" y="52" width="30" height="4" rx="2" fill="#719489"/>
                                </g>
                                <!-- Front Phone with Glowing Interface -->
                                <g transform="rotate(8 95 65) translate(45, 0)">
                                    <rect x="25" y="15" width="56" height="92" rx="11" fill="#020908" stroke="#2EE59D" stroke-width="2" filter="drop-shadow(0 10px 20px rgba(0,0,0,0.7))"/>
                                    <rect x="28" y="20" width="50" height="82" rx="8" fill="linear-gradient(180deg, #092B24 0%, #041411 100%)"/>
                                    <!-- UI Header Avatar -->
                                    <circle cx="38" cy="32" r="5" fill="#2EE59D"/>
                                    <rect x="47" y="30" width="24" height="4" rx="2" fill="#ffffff"/>
                                    <!-- UI Interactive Slider Card -->
                                    <rect x="33" y="44" width="40" height="24" rx="5" fill="rgba(255,255,255,0.08)" stroke="rgba(46, 229, 157, 0.3)" stroke-width="1"/>
                                    <!-- Toggle Switch -->
                                    <rect x="37" y="76" width="22" height="10" rx="5" fill="#1D8A68"/>
                                    <circle cx="53" cy="81" r="3.5" fill="#ffffff"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="service-card-pill">
                        <span class="service-card-pill-text">{{ $locale === 'ar' ? 'تصميم يجذب ويحول' : ($locale === 'fr' ? 'Expériences fluides et engageantes' : 'Design That Converts') }}</span>
                        <span class="service-card-pill-btn">{{ $locale === 'ar' ? '←' : '→' }}</span>
                    </div>
                </article>

                <!-- Card 7: Maintenance & Support (الصيانة والدعم) -->
                <article class="ox-service-card reveal" onclick="openConsultModal()">
                    <div class="service-card-aura"></div>
                    <div class="service-card-body">
                        <div class="service-card-content">
                            <div class="service-card-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                </svg>
                            </div>
                            <h3 class="service-card-title">{{ $locale === 'ar' ? 'الصيانة والدعم' : ($locale === 'fr' ? 'Maintenance & Support' : 'Support & Maintenance') }}</h3>
                        </div>
                        <div class="service-card-visual">
                            <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- 3D Glowing Mechanical Cyber-Gear System -->
                                <g transform="translate(80, 65)">
                                    <!-- Outer Concentric Pulse Rings -->
                                    <circle cx="0" cy="0" r="48" stroke="rgba(29, 138, 104, 0.25)" stroke-width="1.5" stroke-dasharray="4 4"/>
                                    <circle cx="0" cy="0" r="40" stroke="rgba(46, 229, 157, 0.35)" stroke-width="1.5"/>
                                    <!-- Main 3D Gear Body -->
                                    <path d="M-8 -36 L8 -36 L12 -28 L24 -24 L30 -30 L40 -20 L34 -14 L36 -2 L46 2 L46 14 L36 18 L34 30 L40 36 L30 46 L24 40 L12 44 L8 52 L-8 52 L-12 44 L-24 40 L-30 46 L-40 36 L-34 30 L-36 18 L-46 14 L-46 2 L-36 -2 L-34 -14 L-40 -20 L-30 -30 L-24 -24 L-12 -28 Z" fill="#041411" stroke="#2EE59D" stroke-width="2.5" filter="drop-shadow(0 6px 16px rgba(46,229,157,0.3))"/>
                                    <!-- Inner Cybernetic Core -->
                                    <circle cx="0" cy="0" r="18" fill="#092823" stroke="#1D8A68" stroke-width="2"/>
                                    <circle cx="0" cy="0" r="9" fill="#2EE59D"/>
                                    <!-- Heartbeat Pulse Line through Core -->
                                    <path d="M-28 0 H-12 L-6 -8 L0 10 L6 -6 L12 0 H28" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="service-card-pill">
                        <span class="service-card-pill-text">{{ $locale === 'ar' ? 'دعم مستمر لعملك' : ($locale === 'fr' ? 'Accompagnement continu 24/7' : 'Continuous 24/7 Support') }}</span>
                        <span class="service-card-pill-btn">{{ $locale === 'ar' ? '←' : '→' }}</span>
                    </div>
                </article>
            </div>
        </div>
    </section>

  <!-- ─── Sadu Scalloped Fringe Divider into Festive Green Services ─── -->
    <div class="sadu-divider" style="color: #129e38;">
        <svg viewBox="0 0 1200 24" preserveAspectRatio="none">
            <path d="M0,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 V24 H0 Z" fill="currentColor"/>
        </svg>
    </div>

    <!-- ─── Sadu Chevron Zigzag Divider into Work & Projects (Light Style) ─── -->
    <div class="sadu-divider" style="color: #f7f9f6;">
        <svg viewBox="0 0 1200 24" preserveAspectRatio="none">
            <path d="M0,0 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 V24 H0 Z" fill="currentColor"/>
        </svg>
    </div>

   

    <!-- ─── Sadu Chevron Zigzag Divider into Models ─── -->
    <div class="sadu-divider" style="color: #0a241f;">
        <svg viewBox="0 0 1200 24" preserveAspectRatio="none">
            <path d="M0,0 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 V24 H0 Z" fill="currentColor"/>
        </svg>
    </div>

    <!-- Models Section -->
    <section class="models section">
        <div class="intro reveal">
            <p class="kicker">BUILT FOR BOTH</p>
            <h2>{{ __('نشتغل مع') }} <span>B2B</span><br/>{{ __('ونفهم') }} <span>B2C.</span></h2>
        </div>
        <div class="model-grid">
            <article class="reveal">
                <span>B2B</span>
                <h3>{{ __('نرتب العمل المعقد.') }}</h3>
                <p>{{ __('أنظمة داخلية، لوحات تحكم، منصات شركاء وتكاملات تجعل فرقك أسرع وأكثر وضوحًا.') }}</p>
                <ul>
                    <li>{{ __('تقليل العمل اليدوي') }}</li>
                    <li>{{ __('بيانات في مكان واحد') }}</li>
                    <li>{{ __('دعم نمو الفريق') }}</li>
                </ul>
            </article>
            <article class="reveal">
                <span>B2C</span>
                <h3>{{ __('نصنع تجربة يُحبها العميل.') }}</h3>
                <p>{{ __('متاجر وتطبيقات ومنتجات خفيفة وسريعة، من لحظة الاكتشاف وحتى عودة العميل.') }}</p>
                <ul>
                    <li>{{ __('تجربة شراء سلسة') }}</li>
                    <li>{{ __('هوية تترك أثرًا') }}</li>
                    <li>{{ __('تحويل ومبيعات أعلى') }}</li>
                </ul>
            </article>
        </div>
    </section>

    <!-- ─── Sadu Scalloped Fringe Divider into Electric Purple Stories ─── -->
    <div class="sadu-divider" style="color: #311e9e;">
        <svg viewBox="0 0 1200 24" preserveAspectRatio="none">
            <path d="M0,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 V24 H0 Z" fill="currentColor"/>
        </svg>
    </div>

    <!-- Partner Stories / Testimonials Section (Saudi Sadu Aesthetic & Inline Video Player) -->
    <section class="testimonials section" id="stories">
        <!-- Sadu Corner Accents -->
        <svg class="sadu-corner top-right" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="16" y="0" width="8" height="8" fill="#BDFF45"/>
            <rect x="0" y="16" width="8" height="8" fill="#BDFF45"/>
            <rect x="32" y="16" width="8" height="8" fill="#BDFF45"/>
            <rect x="16" y="32" width="8" height="8" fill="#BDFF45"/>
            <rect x="16" y="16" width="8" height="8" fill="#ffffff"/>
            <rect x="8" y="8" width="8" height="8" fill="#9490E8"/>
            <rect x="24" y="8" width="8" height="8" fill="#9490E8"/>
            <rect x="8" y="24" width="8" height="8" fill="#9490E8"/>
            <rect x="24" y="24" width="8" height="8" fill="#9490E8"/>
        </svg>
        <svg class="sadu-corner top-left" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="16" y="0" width="8" height="8" fill="#BDFF45"/>
            <rect x="0" y="16" width="8" height="8" fill="#BDFF45"/>
            <rect x="32" y="16" width="8" height="8" fill="#BDFF45"/>
            <rect x="16" y="32" width="8" height="8" fill="#BDFF45"/>
            <rect x="16" y="16" width="8" height="8" fill="#ffffff"/>
            <rect x="8" y="8" width="8" height="8" fill="#9490E8"/>
            <rect x="24" y="8" width="8" height="8" fill="#9490E8"/>
            <rect x="8" y="24" width="8" height="8" fill="#9490E8"/>
            <rect x="24" y="24" width="8" height="8" fill="#9490E8"/>
        </svg>

        <div class="test-heading reveal">
            <div class="sadu-badge-wrap">
                <!-- Sadu Ribbon Pattern Left -->
                <svg width="60" height="14" viewBox="0 0 60 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0" y="4" width="6" height="6" fill="#BDFF45"/>
                    <rect x="6" y="0" width="6" height="6" fill="#BDFF45"/>
                    <rect x="6" y="8" width="6" height="6" fill="#BDFF45"/>
                    <rect x="12" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="18" y="4" width="6" height="6" fill="#BDFF45"/>
                    <rect x="24" y="0" width="6" height="6" fill="#BDFF45"/>
                    <rect x="24" y="8" width="6" height="6" fill="#BDFF45"/>
                    <rect x="30" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="36" y="4" width="6" height="6" fill="#BDFF45"/>
                    <rect x="42" y="0" width="6" height="6" fill="#BDFF45"/>
                    <rect x="42" y="8" width="6" height="6" fill="#BDFF45"/>
                    <rect x="48" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="54" y="4" width="6" height="6" fill="#BDFF45"/>
                </svg>

                <p class="kicker">PARTNER STORIES</p>

                <!-- Sadu Ribbon Pattern Right -->
                <svg width="60" height="14" viewBox="0 0 60 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0" y="4" width="6" height="6" fill="#BDFF45"/>
                    <rect x="6" y="0" width="6" height="6" fill="#BDFF45"/>
                    <rect x="6" y="8" width="6" height="6" fill="#BDFF45"/>
                    <rect x="12" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="18" y="4" width="6" height="6" fill="#BDFF45"/>
                    <rect x="24" y="0" width="6" height="6" fill="#BDFF45"/>
                    <rect x="24" y="8" width="6" height="6" fill="#BDFF45"/>
                    <rect x="30" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="36" y="4" width="6" height="6" fill="#BDFF45"/>
                    <rect x="42" y="0" width="6" height="6" fill="#BDFF45"/>
                    <rect x="42" y="8" width="6" height="6" fill="#BDFF45"/>
                    <rect x="48" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="54" y="4" width="6" height="6" fill="#BDFF45"/>
                </svg>
            </div>

            <h2>{{ __('شركاؤنا') }}<br/>{{ __('هم') }} <span>{{ __('الـدليـل.') }}</span></h2>
            <p>{{ __('قصص حقيقية من شركاء بنوا معنا منتجات رقمية أحدثت نقلة نوعية في تجربة عملائهم ونمو أعمالهم.') }}</p>
        </div>

        @if($testimonials->count() > 0)
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
                            
                            <!-- Sadu Geometric Pattern Artwork (Shown if default or subtle overlay) -->
                            <div class="card-sadu-art">
                                <svg width="180" height="180" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Sadu Diamond Star Pattern -->
                                    <rect x="70" y="10" width="20" height="20" fill="#9490E8"/>
                                    <rect x="70" y="130" width="20" height="20" fill="#9490E8"/>
                                    <rect x="10" y="70" width="20" height="20" fill="#9490E8"/>
                                    <rect x="130" y="70" width="20" height="20" fill="#9490E8"/>

                                    <rect x="50" y="30" width="20" height="20" fill="#BDFF45"/>
                                    <rect x="90" y="30" width="20" height="20" fill="#BDFF45"/>
                                    <rect x="30" y="50" width="20" height="20" fill="#BDFF45"/>
                                    <rect x="110" y="50" width="20" height="20" fill="#BDFF45"/>
                                    <rect x="30" y="90" width="20" height="20" fill="#BDFF45"/>
                                    <rect x="110" y="90" width="20" height="20" fill="#BDFF45"/>
                                    <rect x="50" y="110" width="20" height="20" fill="#BDFF45"/>
                                    <rect x="90" y="110" width="20" height="20" fill="#BDFF45"/>

                                    <rect x="70" y="50" width="20" height="20" fill="#ffffff"/>
                                    <rect x="50" y="70" width="20" height="20" fill="#ffffff"/>
                                    <rect x="90" y="70" width="20" height="20" fill="#ffffff"/>
                                    <rect x="70" y="90" width="20" height="20" fill="#ffffff"/>
                                    <rect x="70" y="70" width="20" height="20" fill="#BDFF45"/>
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
                                    <span style="color:var(--lime); font-size:13px;">▶</span>
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
                                <div style="display:grid; place-items:center; height:100%; color:#BDFF45; padding:20px; text-align:center;">
                                    <span>جاري تجهيز فيديو التجربة...</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

         

            <div class="story-controls reveal">
                <button id="story-prev" aria-label="القصة السابقة">←</button>
                <span><b id="story-count">01</b> / {{ sprintf('%02d', $testimonials->count()) }}</span>
                <button id="story-next" aria-label="القصة التالية">→</button>
            </div>
        @endif
    </section>

    <!-- ─── Traditional Mud-Brick Battlement Divider into Desert Gold About ─── -->
    <div class="sadu-divider" style="color: #9c7c3d;">
        <svg viewBox="0 0 1200 24" preserveAspectRatio="none">
            <path d="M0,24 L0,12 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 V24 H0 Z" fill="currentColor"/>
        </svg>
    </div>

    <!-- About & Roots Section -->
    <section class="about section" id="about">
        <div class="about-visual reveal">
            <img src="{{ asset('assets/ox-saudi-story.png') }}" alt="بداية OX Tech في بيئة سعودية معاصرة" loading="lazy" decoding="async" width="600" height="700"/>
            <div class="heritage-mark">{{ __('جذور سعودية') }}<br/><span>{{ __('رؤية رقمية') }}</span></div>
        </div>
        <div class="about-copy reveal">
            <p class="kicker">OUR STORY · ROOTED IN SAUDI</p>
            <h2>{{ $siteContents['about_story_title'] ?? __('بدأنا من السعودية. وكبرنا بثقة شركائنا.') }}</h2>
            <p>{{ $siteContents['about_story_p'] ?? __('في 2021 بدأنا كفريق صغير يؤمن أن التقنية لازم تفهم الناس والسوق قبل أي شيء. أول مشاريعنا كانت لفرق سعودية طموحة تحتاج حلولًا أسرع وأوضح—ومن هناك تعلّمنا أن أفضل المنتجات تبدأ من الاستماع الجيد.') }}</p>
            
            <div class="journey">
                <article>
                    <b>2021</b>
                    <div>
                        <strong>{{ __('البداية في الرياض') }}</strong>
                        <small>{{ __('فريق صغير، أول شريك، ووعد واحد: نبني منتجًا يُعتمد عليه.') }}</small>
                    </div>
                </article>
                <article>
                    <b>2023</b>
                    <div>
                        <strong>{{ __('من فكرة إلى بيت برمجيات') }}</strong>
                        <small>{{ __('توسعنا في المتاجر والمنصات والتطبيقات لفرق في السعودية والإمارات ومصر.') }}</small>
                    </div>
                </article>
                <article>
                    <b>اليوم</b>
                    <div>
                        <strong>{{ __('شريك نمو طويل المدى') }}</strong>
                        <small>{{ __('ندعم الإطلاق، التشغيل، والتحسين المستمر لمنتجات تظل قوية مع نمو الأعمال.') }}</small>
                    </div>
                </article>
            </div>

            <div class="numbers">
                <span><b>5+</b> {{ __('سنوات خبرة') }}</span>
                <span><b>48+</b> {{ __('منتج أُطلق') }}</span>
                <span><b>24/7</b> {{ __('دعم فني') }}</span>
            </div>
        </div>
    </section>

    <!-- ─── Traditional Battlement Divider into Consultation ─── -->
    <div class="sadu-divider" style="color: #06131f;">
        <svg viewBox="0 0 1200 24" preserveAspectRatio="none">
            <path d="M0,24 L0,12 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 l10,0 0,-12 20,0 0,12 10,0 V24 H0 Z" fill="currentColor"/>
        </svg>
    </div>

    <!-- Ultra-Luxurious Inline Consultation Section -->
    <section class="consult-section" id="consult">
        <div class="consult-wrap">
            <!-- Left Info Column -->
            <div class="consult-intro reveal">
                <p class="kicker" style="display: inline-flex; align-items: center; gap: 8px;">
                    <span style="width: 7px; height: 7px; border-radius: 50%; background: var(--lime); display: inline-block; box-shadow: 0 0 10px var(--lime);"></span>
                    LET'S BUILD SOMETHING GREAT
                </p>
                <h2>{{ $siteContents['consult_title'] ?? __('عندك فكرة؟') }}<br/><span>{{ __('خلّينا نرتّبها ونبنيها.') }}</span></h2>
                <div class="consult-direct-box" style="display: flex; flex-direction: column; gap: 14px; margin-top: 25px;">
                    <div class="direct-info">
                        <small style="color: #94b8ac;">{{ __('تفضل التواصل المباشر السريع؟') }}</small>
                        <strong style="color: #fff; font-size: 15px; display: block; margin-top: 2px;">{{ $siteContents['contact_email'] ?? 'hello@oxtech.studio' }}</strong>
                    </div>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <a href="mailto:{{ $siteContents['contact_email'] ?? 'hello@oxtech.studio' }}" class="pill-btn-purple">
                            <span>{{ __('راسلنا إيميل') }}</span>
                            <b>↗</b>
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_phone_primary'] ?? '966500000000') }}" target="_blank" class="pill-btn-lime">
                            <span>{{ __('محادثة واتساب') }}</span>
                            <b>💬</b>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Interactive Form Card -->
            <div class="consult-form-card reveal">
                <div id="inlineFormContent">
                    <form action="{{ route('consultation.store') }}" method="POST" id="inlineConsultationForm">
                        @csrf
                        <!-- Anti-Spam Bot Trap (Honeypot & Time-Trap) -->
                        <input type="text" name="hp_check" value="" style="display:none !important; position:absolute; left:-9999px;" tabindex="-1" autocomplete="off">
                        <input type="hidden" name="_form_load_time" value="{{ time() }}">

                        <!-- Project Type Pills -->
                        <div class="form-section-title">
                            <span>01</span> {{ __('اختر نوع المشروع أو الخدمة المطلوبة:') }}
                        </div>
                        <div class="pills-grid" id="projectTypePills">
                            <button type="button" class="pill-btn active" data-val="منصات ومواقع">{{ __('منصات ومواقع ويب') }}</button>
                            <button type="button" class="pill-btn" data-val="متاجر إلكترونية">{{ __('متجر إلكتروني متكامل') }}</button>
                            <button type="button" class="pill-btn" data-val="تطبيقات ومنتجات">{{ __('تطبيق جوال iOS / Android') }}</button>
                            <button type="button" class="pill-btn" data-val="أنظمة SaaS مخصصة">{{ __('نظام سحابي / SaaS') }}</button>
                            <button type="button" class="pill-btn" data-val="تكاملات وأتمتة">{{ __('تكاملات وأتمتة عمل') }}</button>
                        </div>
                        <input type="hidden" name="project_type" id="selectedProjectType" value="منصات ومواقع">

                        <!-- Personal / Contact Details -->
                        <div class="form-section-title">
                            <span>02</span> {{ __('بيانات التواصل الأساسية:') }}
                        </div>
                        <div class="input-row">
                            <div class="consult-field">
                                <label>{{ __('الاسم الكريم') }} *</label>
                                <input type="text" name="name" class="consult-input" placeholder="{{ $locale === 'ar' ? 'مثال: عبدالله الراجحي' : 'e.g. John Doe' }}" maxlength="70" required>
                            </div>
                            <div class="consult-field">
                                <label>{{ __('رقم الجوال / واتساب *') }}</label>
                                <input type="text" name="phone" class="consult-input" placeholder="+966 50 000 0000" dir="ltr" style="text-align: right;" maxlength="30" required>
                            </div>
                        </div>

                        <div class="input-row">
                            <div class="consult-field">
                                <label>{{ __('البريد الإلكتروني') }} *</label>
                                <input type="email" name="email" class="consult-input" placeholder="name@company.com" maxlength="100" required>
                            </div>
                            <div class="consult-field">
                                <label>{{ __('اسم الشركة أو الجهة (اختياري)') }}</label>
                                <input type="text" name="company_name" class="consult-input" placeholder="{{ $locale === 'ar' ? 'مثال: شركة نمو الرقمية' : 'e.g. Acme Tech' }}" maxlength="100">
                            </div>
                        </div>

                        <!-- Budget Range Pills -->
                        <div class="form-section-title" style="margin-top: 10px;">
                            <span>03</span> {{ __('الميزانية التقديرية المتوقعة:') }}
                        </div>
                        <div class="pills-grid" id="budgetPills">
                            <button type="button" class="pill-btn" data-val="أقل من $10,000">{{ __('أقل من $10k') }}</button>
                            <button type="button" class="pill-btn active" data-val="$10,000 - $25,000">$10,000 - $25,000</button>
                            <button type="button" class="pill-btn" data-val="$25,000 - $50,000">$25,000 - $50,000</button>
                            <button type="button" class="pill-btn" data-val="أكثر من $50,000">{{ $locale === 'ar' ? 'أكثر من $50,000' : '> $50,000' }}</button>
                        </div>
                        <input type="hidden" name="budget" id="selectedBudget" value="$10,000 - $25,000">

                        <!-- Message -->
                        <div class="consult-field">
                            <label>{{ __('أخبرنا باختصار عن فكرتك أو التحدي التقني *') }}</label>
                            <textarea name="message" class="consult-textarea" rows="3" placeholder="{{ __('ما هو الهدف الأساسي من المشروع؟ ومن هم عملاؤك المستهدفون؟') }}" minlength="10" maxlength="1000" required></textarea>
                            <div style="display: flex; justify-content: space-between; font-size: 11px; color: #8fa099; margin-top: 4px;">
                                <span>{{ __('الحد الأدنى 10 أحرف') }}</span>
                                <span id="inlineMsgCounter">0 / 1000 {{ __('حرف') }}</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="submit-consult-btn" id="inlineSubmitBtn">
                            <span>{{ __('إرسال وتأكيد طلب الاستشارة') }}</span>
                            <b style="font-size: 18px;">{{ $locale === 'ar' ? '←' : '→' }}</b>
                        </button>
                    </form>
                </div>

                <!-- Success Celebration Screen -->
                <div class="consult-success-box" id="inlineSuccessBox">
                    <div class="success-icon-badge">✓</div>
                    <h3>{{ __('تم استلام طلبك بنجاح!') }}</h3>
                    <p id="successMsgText">
                        {{ __('شكرًا لاهتمامك بالعمل معنا. تم إرسال تفاصيل فكرتك إلى فريقنا التقني، وسيتواصل معك مهندس المشروع خلال 24 ساعة لترتيب موعد الاستشارة.') }}
                    </p>
                    <button type="button" class="pill-btn active" onclick="resetInlineForm()" style="padding: 12px 28px; font-size: 12px;">
                        {{ __('إرسال طلب استشارة آخر') }}
                    </button>
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
@endpush

@push('scripts')
<script>
    // Reveal animation
    const observer = new IntersectionObserver(e => e.forEach(x => {
        if (x.isIntersecting) x.target.classList.add('visible');
    }), { threshold: .12 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Portfolio filters
    let country = 'all', sector = 'all';
    const cards = [...document.querySelectorAll('.project')];
    function filter() {
        cards.forEach(card => card.classList.toggle('hidden', !(country === 'all' || card.classList.contains(country)) || !(sector === 'all' || card.classList.contains(sector))));
    }
    document.querySelectorAll('#countries button').forEach(b => b.onclick = () => {
        country = b.dataset.filter;
        document.querySelectorAll('#countries button').forEach(x => x.classList.remove('active'));
        b.classList.add('active');
        filter();
    });
    document.querySelectorAll('#sectors button').forEach(b => b.onclick = () => {
        sector = b.dataset.sector;
        document.querySelectorAll('#sectors button').forEach(x => x.classList.remove('active'));
        b.classList.add('active');
        filter();
    });

    // Testimonials Data from Controller
    const storiesData = {!! $storiesJson !!};

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

    function showStory(n) {
        if (!storiesData || storiesData.length === 0) return;
        
        // Pause and reset any playing video
        pauseAllCardVideos();

        currentStory = (n + storiesData.length) % storiesData.length;
        document.querySelector('#quote-text').textContent = storiesData[currentStory][0];
        document.querySelector('#quote-name').textContent = storiesData[currentStory][1];
        document.querySelector('#quote-role').textContent = storiesData[currentStory][2];
        document.querySelector('#story-count').textContent = `0${currentStory + 1}`;

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
    }

    function handleCardStageClick(index) {
        if (currentStory === index) {
            startCardVideo(index);
        } else {
            showStory(index);
        }
    }

    function startCardVideo(index) {
        if (currentStory !== index) {
            showStory(index);
        }
        const frame = document.getElementById(`card-video-frame-${index}`);
        const vid = document.getElementById(`native-video-${index}`);
        if (frame && vid) {
            frame.classList.add('playing');
            vid.play().catch(e => console.log('Autoplay prevented:', e));
        }
    }

    function closeCardVideo(index) {
        const frame = document.getElementById(`card-video-frame-${index}`);
        const vid = document.getElementById(`native-video-${index}`);
        if (vid) {
            vid.pause();
        }
        if (frame) {
            frame.classList.remove('playing');
        }
    }

    function pauseAllCardVideos() {
        document.querySelectorAll('.card-video-frame').forEach((frame, idx) => {
            frame.classList.remove('playing');
            const vid = document.getElementById(`native-video-${idx}`);
            if (vid) vid.pause();
        });
    }

    function triggerCardFullscreen(index) {
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
    }

    const prevBtn = document.querySelector('#story-prev');
    const nextBtn = document.querySelector('#story-next');
    if (prevBtn) prevBtn.onclick = () => showStory(currentStory - 1);
    if (nextBtn) nextBtn.onclick = () => showStory(currentStory + 1);

    // Interactive Pills for Inline Form
    document.querySelectorAll('#projectTypePills .pill-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('#projectTypePills .pill-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('selectedProjectType').value = this.dataset.val;
        });
    });

    document.querySelectorAll('#budgetPills .pill-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('#budgetPills .pill-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('selectedBudget').value = this.dataset.val;
        });
    });

    // Fast AJAX submission for Inline Form
    const inlineForm = document.getElementById('inlineConsultationForm');
    const inlineSubmitBtn = document.getElementById('inlineSubmitBtn');
    const inlineFormContent = document.getElementById('inlineFormContent');
    const inlineSuccessBox = document.getElementById('inlineSuccessBox');

    if (inlineForm) {
        inlineForm.addEventListener('submit', function(e) {
            e.preventDefault();
            inlineSubmitBtn.disabled = true;
            inlineSubmitBtn.querySelector('span').textContent = "{{ __('جاري إرسال الطلب...') }}";

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
                    inlineFormContent.style.display = 'none';
                    inlineSuccessBox.style.display = 'block';
                    if (data.message) {
                        document.getElementById('successMsgText').textContent = data.message;
                    }
                } else {
                    alert("{{ __('حدث خطأ أثناء الإرسال، يرجى التحقق من البيانات والمحاولة مجدداً.') }}");
                    inlineSubmitBtn.disabled = false;
                    inlineSubmitBtn.querySelector('span').textContent = "{{ __('إرسال وتأكيد طلب الاستشارة') }}";
                }
            })
            .catch(err => {
                console.error(err);
                // Fallback to regular form submit if AJAX fails
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
            inlineSubmitBtn.querySelector('span').textContent = "{{ __('إرسال وتأكيد طلب الاستشارة') }}";
        }
        const inlineCounter = document.getElementById('inlineMsgCounter');
        if (inlineCounter) inlineCounter.innerText = "0 / 1000 {{ __('حرف') }}";
    }

    // Live Character Counter for Inline Form
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

    // Services Section Slider Navigation
    window.scrollServices = function(direction) {
        const grid = document.getElementById('servicesGrid');
        if (!grid) return;
        const isRtl = document.documentElement.getAttribute('dir') === 'rtl';
        const card = grid.querySelector('.ox-service-card');
        const scrollAmount = card ? (card.offsetWidth + 24) : 360;
        grid.scrollBy({
            left: isRtl ? (direction * scrollAmount) : (direction * scrollAmount),
            behavior: 'smooth'
        });
    };
</script>

<!-- Ionicons v7 Web Components (self-hosted) -->
<script type="module" src="{{ asset('vendor/ionicons/ionicons.esm.js') }}"></script>
<script nomodule src="{{ asset('vendor/ionicons/ionicons.js') }}"></script>

<!-- 3D Product Scroll Showcase -->
<script type="module" src="{{ asset('assets/product-scroll.js') }}"></script>
@endpush
