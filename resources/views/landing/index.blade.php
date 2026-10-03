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
            @if(isset($productCategories) && $productCategories->count() > 0)
                <div class="services-category-tabs reveal">
                    <button type="button" class="services-tab-btn active" data-cat="all" onclick="filterServicesGrid('all', this)">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>{{ $locale === 'ar' ? 'كافة الحلول والأنظمة' : ($locale === 'fr' ? 'Toutes les solutions' : 'All Solutions') }}</span>
                    </button>
                    @foreach($productCategories as $cat)
                        <button type="button" class="services-tab-btn" data-cat="{{ $cat->slug }}" onclick="filterServicesGrid('{{ $cat->slug }}', this)">
                            <span>{{ $cat->name }}</span>
                            @if(($cat->digital_products_count ?? 0) > 0)
                                <span class="tab-count">{{ $cat->digital_products_count }}</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="ox-services-grid" id="servicesGrid">
                @forelse($digitalProducts as $product)
                    <article class="ox-service-card reveal" data-category="{{ $product->category?->slug ?? 'general' }}" onclick="window.location.href='{{ route('store.product', $product->slug) }}'">
                        <div class="service-card-aura"></div>
                        <div class="service-card-body">
                            <div class="service-card-content">
                                <div class="service-card-top-meta">
                                    <div class="service-card-icon-badge">
                                        @if($product->category?->icon === 'calculator')
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="4" y="2" width="16" height="20" rx="2"></rect>
                                                <line x1="8" y1="6" x2="16" y2="6"></line>
                                                <line x1="16" y1="14" x2="16" y2="18"></line>
                                                <path d="M16 10h.01"></path><path d="M12 10h.01"></path><path d="M8 10h.01"></path>
                                                <path d="M12 14h.01"></path><path d="M8 14h.01"></path><path d="M12 18h.01"></path><path d="M8 18h.01"></path>
                                            </svg>
                                        @elseif($product->category?->icon === 'bullhorn')
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                            </svg>
                                        @elseif($product->category?->icon === 'users-gear')
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        @else
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                                <line x1="12" y1="17" x2="12" y2="21"></line>
                                            </svg>
                                        @endif
                                    </div>
                                    @if($product->category)
                                        <span class="service-category-tag">{{ $product->category->name }}</span>
                                    @endif
                                </div>
                                <h3 class="service-card-title">{{ $product->name }}</h3>
                                <p class="service-card-tagline">{{ $product->tagline ?: Str::limit($product->description, 110) }}</p>
                            </div>

                            <div class="service-card-visual">
                                @if($product->category?->slug === 'business-accounting' || Str::contains($product->slug, 'erp'))
                                    <!-- 3D ERP Accounting & POS Workstation -->
                                    <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M72 104L88 104L84 92L76 92Z" fill="#1E3E37"/>
                                        <rect x="64" y="104" width="32" height="4" rx="2" fill="#2E5C52"/>
                                        <rect x="25" y="16" width="110" height="76" rx="8" fill="#041210" stroke="#1D8A68" stroke-width="2" filter="drop-shadow(0 8px 20px rgba(0,0,0,0.6))"/>
                                        <rect x="29" y="20" width="102" height="68" rx="5" fill="#08241F"/>
                                        <rect x="29" y="20" width="102" height="12" fill="#0B3029"/>
                                        <circle cx="36" cy="26" r="2.5" fill="#714B67"/>
                                        <circle cx="43" cy="26" r="2.5" fill="#00A09D"/>
                                        <circle cx="50" cy="26" r="2.5" fill="#C8A96B"/>
                                        <rect x="35" y="38" width="18" height="14" rx="3" fill="#714B67"/>
                                        <rect x="58" y="38" width="18" height="14" rx="3" fill="#00A09D"/>
                                        <rect x="81" y="38" width="18" height="14" rx="3" fill="#1D8A68"/>
                                        <rect x="104" y="38" width="18" height="14" rx="3" fill="#C8A96B"/>
                                        <rect x="35" y="58" width="87" height="6" rx="2" fill="rgba(255,255,255,0.08)"/>
                                        <rect x="35" y="68" width="87" height="6" rx="2" fill="rgba(255,255,255,0.05)"/>
                                        <rect x="35" y="77" width="55" height="5" rx="2" fill="rgba(46,229,157,0.2)"/>
                                    </svg>
                                @elseif($product->category?->slug === 'marketing-automation' || Str::contains($product->slug, ['bot', 'marketing']))
                                    <!-- 3D Automation & Smart Marketing Rocket -->
                                    <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g transform="translate(18, 14)">
                                            <path d="M10 20 C40 10, 80 10, 115 20 L115 88 C80 80, 40 80, 10 88 Z" fill="#051916" stroke="#1D8A68" stroke-width="2" filter="drop-shadow(0 8px 16px rgba(0,0,0,0.5))"/>
                                            <rect x="24" y="58" width="8" height="20" rx="2" fill="rgba(29, 138, 104, 0.4)"/>
                                            <rect x="38" y="48" width="8" height="30" rx="2" fill="rgba(29, 138, 104, 0.6)"/>
                                            <rect x="52" y="38" width="8" height="40" rx="2" fill="rgba(29, 138, 104, 0.8)"/>
                                            <rect x="66" y="28" width="8" height="50" rx="2" fill="#1D8A68"/>
                                            <rect x="80" y="22" width="8" height="56" rx="2" fill="#2EE59D"/>
                                            <path d="M22 66 Q 50 48, 70 34 T 98 18" fill="none" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                                            <circle cx="98" cy="18" r="4" fill="#2EE59D" stroke="#ffffff" stroke-width="1.5"/>
                                            <g transform="translate(90, 52)">
                                                <circle cx="14" cy="14" r="14" fill="#1D8A68" filter="drop-shadow(0 4px 8px rgba(0,0,0,0.4))"/>
                                                <path d="M9 14L12 17L19 10" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </g>
                                        </g>
                                    </svg>
                                @elseif($product->category?->slug === 'crm-customer-service' || Str::contains($product->slug, ['crm', 'helpdesk', 'desk']))
                                    <!-- 3D Customer Care & OmniDesk Dashboard -->
                                    <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g transform="translate(18, 12)">
                                            <rect x="15" y="6" width="94" height="60" rx="5" fill="#041210" stroke="#1D8A68" stroke-width="2"/>
                                            <rect x="18" y="10" width="88" height="52" rx="3" fill="#092823"/>
                                            <rect x="18" y="10" width="88" height="9" fill="#0E352E"/>
                                            <circle cx="23" cy="14.5" r="1.5" fill="#ff5f56"/>
                                            <circle cx="28" cy="14.5" r="1.5" fill="#ffbd2e"/>
                                            <circle cx="33" cy="14.5" r="1.5" fill="#27c93f"/>
                                            <rect x="24" y="24" width="46" height="5" rx="1.5" fill="#ffffff"/>
                                            <rect x="24" y="32" width="68" height="3" rx="1" fill="#719489"/>
                                            <rect x="24" y="38" width="50" height="3" rx="1" fill="#719489"/>
                                            <rect x="24" y="46" width="22" height="8" rx="2" fill="#1D8A68"/>
                                            <rect x="76" y="24" width="24" height="30" rx="3" fill="#123B33" stroke="#2EE59D" stroke-width="1"/>
                                            <path d="M4 68L120 68L110 88L14 88Z" fill="#0F332C" stroke="#1D8A68" stroke-width="1.5"/>
                                            <rect x="46" y="74" width="32" height="8" rx="2" fill="#051714"/>
                                        </g>
                                    </svg>
                                @else
                                    <!-- 3D Futuristic Cloud Architecture Slate -->
                                    <svg viewBox="0 0 160 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g transform="translate(20, 10)">
                                            <rect x="22" y="6" width="82" height="96" rx="10" fill="#04120F" stroke="#1D8A68" stroke-width="2" filter="drop-shadow(0 10px 20px rgba(0,0,0,0.6))"/>
                                            <rect x="26" y="10" width="74" height="12" rx="3" fill="#08221D"/>
                                            <circle cx="32" cy="16" r="2" fill="#2EE59D"/>
                                            <circle cx="38" cy="16" r="2" fill="#C8A96B"/>
                                            <rect x="32" y="28" width="22" height="3" rx="1.5" fill="#2EE59D"/>
                                            <rect x="58" y="28" width="32" height="3" rx="1.5" fill="#ffffff"/>
                                            <rect x="38" y="36" width="46" height="3" rx="1.5" fill="#C8A96B"/>
                                            <rect x="38" y="44" width="34" height="3" rx="1.5" fill="#719489"/>
                                            <rect x="38" y="52" width="48" height="3" rx="1.5" fill="#2EE59D"/>
                                            <rect x="32" y="60" width="18" height="3" rx="1.5" fill="#ffffff"/>
                                            <rect x="32" y="70" width="62" height="24" rx="4" fill="rgba(29, 138, 104, 0.15)" stroke="rgba(29, 138, 104, 0.4)" stroke-width="1"/>
                                            <circle cx="44" cy="82" r="4" fill="#1D8A68"/>
                                            <line x1="48" y1="82" x2="62" y2="82" stroke="#2EE59D" stroke-width="1.5" stroke-dasharray="2 2"/>
                                            <circle cx="66" cy="82" r="4" fill="#2EE59D"/>
                                            <line x1="70" y1="82" x2="80" y2="82" stroke="#2EE59D" stroke-width="1.5" stroke-dasharray="2 2"/>
                                            <circle cx="84" cy="82" r="4" fill="#1D8A68"/>
                                        </g>
                                    </svg>
                                @endif
                            </div>
                        </div>

                        @if(!empty($product->features) && is_array($product->features))
                            <div class="service-features-chips">
                                @foreach(array_slice($product->features, 0, 3) as $feat)
                                    <span class="service-chip">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#2EE59D" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        <span>{{ $feat }}</span>
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="service-card-bottom">
                            @if($product->sale_price || $product->price)
                                <div class="service-price-box">
                                    <span class="service-price-amount">{{ number_format($product->sale_price ?? $product->price) }} <small>{{ $product->currency }}</small></span>
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <del class="service-price-old">{{ number_format($product->price) }}</del>
                                    @endif
                                </div>
                            @endif

                            <div class="service-card-pill">
                                <span class="service-card-pill-text">{{ $locale === 'ar' ? 'تفاصيل وحجز النظام' : ($locale === 'fr' ? 'Détails du système' : 'View System') }}</span>
                                <span class="service-card-pill-btn">{{ $locale === 'ar' ? '←' : '→' }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <!-- Fallback if no products seeded -->
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--ox-gray);">
                        <p>{{ $locale === 'ar' ? 'جاري تحديث قائمة الأنظمة والحلول...' : 'Updating systems and solutions...' }}</p>
                    </div>
                @endforelse
            </div>

            <div class="services-footer-cta reveal">
                <a href="{{ route('store.index') }}" class="services-store-link">
                    <span>{{ $locale === 'ar' ? 'استكشف كافة الحلول والأنظمة الرقمية في المتجر' : ($locale === 'fr' ? 'Explorer toutes les solutions dans la boutique' : 'Explore All Digital Systems in Store') }}</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="{{ $locale === 'ar' ? '15 18 9 12 15 6' : '9 18 15 12 9 6' }}"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </section>

  <!-- ─── Beneficiaries Section: من يستفيد من حلول OxTech؟ ─── -->
    <section class="ox-beneficiaries-section" id="beneficiaries">
        <div class="ox-beneficiaries-pattern"></div>
        <div class="ox-beneficiaries-skyline"></div>
        <div class="container">
            <div class="ox-beneficiaries-grid">
                <!-- Right Side in RTL: Content & Checklist -->
                <div class="ox-beneficiaries-content reveal">
                    <span class="ox-beneficiaries-kicker">{{ $locale === 'ar' ? 'خدماتنا' : 'SECTORS & EXPERTISE' }}</span>
                    <h2 class="ox-beneficiaries-heading">
                        {{ $locale === 'ar' ? 'من يستفيد' : 'Who Benefits From' }}<br/>
                        {{ $locale === 'ar' ? 'من حلول' : 'Solutions by' }} <span class="brand-tag">OxTech</span>{{ $locale === 'ar' ? '؟' : '?' }}
                    </h2>
                    <p class="ox-beneficiaries-desc">
                        {{ $locale === 'ar' ? 'نوفر حلول رقمية تناسب مختلف القطاعات والأحجام، من الشركات الناشئة إلى المؤسسات الكبيرة.' : 'We engineer robust digital architectures built for diverse industries and scales, from high-growth startups to enterprise institutions.' }}
                    </p>
                    <ul class="ox-beneficiaries-checklist">
                        <li class="ox-checklist-item">
                            <span class="ox-check-icon">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </span>
                            <span>{{ $locale === 'ar' ? 'القطاع الحكومي' : 'Government Sector' }}</span>
                        </li>
                        <li class="ox-checklist-item">
                            <span class="ox-check-icon">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </span>
                            <span>{{ $locale === 'ar' ? 'القطاع الخاص' : 'Private Sector' }}</span>
                        </li>
                        <li class="ox-checklist-item">
                            <span class="ox-check-icon">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </span>
                            <span>{{ $locale === 'ar' ? 'الشركات والمؤسسات' : 'Enterprises & Corporations' }}</span>
                        </li>
                        <li class="ox-checklist-item">
                            <span class="ox-check-icon">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </span>
                            <span>{{ $locale === 'ar' ? 'القطاع التعليمي' : 'Educational Sector' }}</span>
                        </li>
                        <li class="ox-checklist-item">
                            <span class="ox-check-icon">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </span>
                            <span>{{ $locale === 'ar' ? 'القطاع التجاري' : 'Commercial Sector' }}</span>
                        </li>
                    </ul>
                    <a href="#consult" class="ox-beneficiaries-cta" onclick="openConsultModal(); return false;">
                        <span>{{ $locale === 'ar' ? 'اكتشف الحلول المناسبة لك' : 'Discover Solutions For You' }}</span>
                        <span class="ox-cta-arrow">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </span>
                    </a>
                </div>

                <!-- Left Side in RTL: Tablet Showcase with 4 Sector Cards -->
                <div class="ox-tablet-wrapper reveal">
                    <div class="ox-tablet-frame">
                        <div class="ox-tablet-camera"></div>
                        <div class="ox-tablet-screen">
                            <!-- Card 1: E-Commerce (التجارة الإلكترونية) -->
                            <article class="ox-tablet-card" onclick="openConsultModal()">
                                <div class="tablet-card-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                                    </svg>
                                </div>
                                <h3 class="tablet-card-title">{{ $locale === 'ar' ? 'التجارة الإلكترونية' : 'E-Commerce' }}</h3>
                                <p class="tablet-card-desc">{{ $locale === 'ar' ? 'حلول تجارة متعددة القنوات وبوابات دفع وتكاملات دفع وشحن مرنة' : 'Omnichannel commerce platforms with secure payment gateways and logistics.' }}</p>
                                <div class="tablet-card-btn">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                            </article>

                            <!-- Card 2: Startups (الشركات الناشئة) -->
                            <article class="ox-tablet-card" onclick="openConsultModal()">
                                <div class="tablet-card-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                </div>
                                <h3 class="tablet-card-title">{{ $locale === 'ar' ? 'الشركات الناشئة' : 'Startups' }}</h3>
                                <p class="tablet-card-desc">{{ $locale === 'ar' ? 'إطلاق سريع ونمو متواصل وتطوير منتجات رقمية مرنة قابلة للتوسع' : 'Rapid MVP development, agile scaling, and modern cloud architectures.' }}</p>
                                <div class="tablet-card-btn">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                            </article>

                            <!-- Card 3: Enterprises & Companies (المؤسسات والشركات) -->
                            <article class="ox-tablet-card" onclick="openConsultModal()">
                                <div class="tablet-card-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
                                        <line x1="9" y1="6" x2="9.01" y2="6"></line>
                                        <line x1="15" y1="6" x2="15.01" y2="6"></line>
                                        <line x1="9" y1="10" x2="9.01" y2="10"></line>
                                        <line x1="15" y1="10" x2="15.01" y2="10"></line>
                                        <line x1="9" y1="14" x2="9.01" y2="14"></line>
                                        <line x1="15" y1="14" x2="15.01" y2="14"></line>
                                        <line x1="9" y1="18" x2="15" y2="18"></line>
                                    </svg>
                                </div>
                                <h3 class="tablet-card-title">{{ $locale === 'ar' ? 'المؤسسات والشركات' : 'Enterprises' }}</h3>
                                <p class="tablet-card-desc">{{ $locale === 'ar' ? 'حلول أتمتة وإدارة متقدمة لرفع الكفاءة التشغيلية والربط المؤسسي' : 'Operational workflows, ERP integrations, and enterprise data management.' }}</p>
                                <div class="tablet-card-btn">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                            </article>

                            <!-- Card 4: Government Solutions (حلول حكومية وشبه حكومية) -->
                            <article class="ox-tablet-card" onclick="openConsultModal()">
                                <div class="tablet-card-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 21h18"></path>
                                        <path d="M3 10h18"></path>
                                        <path d="M5 6l7-3 7 3"></path>
                                        <path d="M4 10v11"></path>
                                        <path d="M20 10v11"></path>
                                        <path d="M8 14v4"></path>
                                        <path d="M12 14v4"></path>
                                        <path d="M16 14v4"></path>
                                    </svg>
                                </div>
                                <h3 class="tablet-card-title">{{ $locale === 'ar' ? 'حلول حكومية وشبه حكومية' : 'Gov & Semi-Gov' }}</h3>
                                <p class="tablet-card-desc">{{ $locale === 'ar' ? 'أنظمة رقمية آمنة ومعتمدة متوافقة مع أعلى الضوابط الوطنية' : 'High-security compliant systems meeting the highest national digital standards.' }}</p>
                                <div class="tablet-card-btn">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
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

                <div class="quote reveal">
                    <span class="quote-mark">“</span>
                    <blockquote id="quote-text">{{ $testimonials[0]->quote }}</blockquote>
                    <div>
                        <b id="quote-name">{{ $testimonials[0]->partner_name }}</b>
                        <small id="quote-role">{{ $testimonials[0]->partner_role }} · {{ $testimonials[0]->partner_country }}</small>
                    </div>
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

    // 2. Services Section Slider Navigation
    window.scrollServices = function(direction) {
        const grid = document.getElementById('servicesGrid');
        if (!grid) return;
        const card = grid.querySelector('.ox-service-card');
        const scrollAmount = card ? (card.offsetWidth + 24) : 360;
        grid.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    };

    // 3. Services Category Filtering
    window.filterServicesGrid = function(categorySlug, btn) {
        const grid = document.getElementById('servicesGrid');
        if (!grid) return;
        const buttons = document.querySelectorAll('.services-tab-btn');
        buttons.forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');

        const cards = grid.querySelectorAll('.ox-service-card');
        cards.forEach(card => {
            const cardCat = card.getAttribute('data-category');
            if (categorySlug === 'all' || cardCat === categorySlug) {
                card.style.display = '';
                card.classList.add('visible');
            } else {
                card.style.display = 'none';
            }
        });
        grid.scrollTo({ left: 0, behavior: 'smooth' });
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
