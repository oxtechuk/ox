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

    <!-- 3D Product Scroll Showcase (AR / EN / FR) -->
    <div class="showcase-root {{ $locale === 'ar' ? 'is-rtl' : 'is-ltr' }}" id="showcaseRoot" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

        <!-- Intro -->
        <section class="intro">
            <h1>{{ $txt['intro'] }}</h1>
        </section>

        <!-- Pinned Product Overview -->
        <section class="product-overview" id="productOverview">
            <div class="header-1">
                <h1>{{ $txt['header_1'] }}</h1>
            </div>
            <div class="header-2">
                <h1>{{ $txt['header_2'] }}</h1>
            </div>
            <div class="circular-mask"></div>
            <div class="tooltips">
                <div class="tooltip">
                    <div class="icon"><ion-icon name="{{ $txt['t1_icon'] }}"></ion-icon></div>
                    <div class="divider"></div>
                    <div class="title"><h2>{{ $txt['t1_title'] }}</h2></div>
                    <div class="description"><p>{{ $txt['t1_desc'] }}</p></div>
                </div>
                <div class="tooltip">
                    <div class="icon"><ion-icon name="{{ $txt['t2_icon'] }}"></ion-icon></div>
                    <div class="divider"></div>
                    <div class="title"><h2>{{ $txt['t2_title'] }}</h2></div>
                    <div class="description"><p>{{ $txt['t2_desc'] }}</p></div>
                </div>
            </div>
            <div class="model-container" data-model-url="{{ asset('assets/3d/model.glb') }}"></div>
        </section>
    </div>

    <!-- Brands & Partners Marquee Section (Matching Reference Card Design with Monochrome-to-Color Hover) -->
    <section class="brands-marquee-section">
        <div class="brands-header reveal">
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
        </div>

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

    <!-- ─── Sadu Scalloped Fringe Divider into Festive Green Services ─── -->
    <div class="sadu-divider" style="color: #129e38;">
        <svg viewBox="0 0 1200 24" preserveAspectRatio="none">
            <path d="M0,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 q20,24 40,0 V24 H0 Z" fill="currentColor"/>
        </svg>
    </div>

    <!-- Services & Sectors Showcase Section (Split Layout with Vibrant 3D Isometric Cards) -->
    <section class="services section" id="services">
        <div class="services-wrapper">
            <!-- Text & Info Column (Right side in RTL) -->
            <div class="services-info-col reveal">
                <p class="kicker">{{ $locale === 'ar' ? 'القطاعات والحلول الموجهة' : ($locale === 'fr' ? 'SECTEURS & IMPACT' : 'TARGET SECTORS & SOLUTIONS') }}</p>
                @if($locale === 'ar')
                    <h2 class="services-main-title">من يستفيد من<br/><span class="services-highlight">حلول أوكس؟</span></h2>
                    <p class="services-lead">أوكس يخدم مختلف القطاعات التشغيلية الحيوية، ويمنح كل دور الأدوات البرمجية الذكية التي يحتاجها للنجاح والريادة.</p>
                    <p class="services-desc">من الأبراج والشركات الكبرى إلى المجمعات التجارية والمرافق والمنشآت الذكية، كل العمليات تجري في منصة موحّدة ذكية، فائقة الأمان وسهلة الاستخدام.</p>
                @elseif($locale === 'fr')
                    <h2 class="services-main-title">Qui bénéficie des<br/><span class="services-highlight">solutions OX ?</span></h2>
                    <p class="services-lead">OX dessert les secteurs opérationnels stratégiques en fournissant les outils logiciels nécessaires pour accélérer la croissance.</p>
                    <p class="services-desc">Des tours d'affaires aux hôpitaux, hôtels et entités publiques—toutes vos opérations réunies dans une plateforme intelligente et hautement sécurisée.</p>
                @else
                    <h2 class="services-main-title">Who Benefits from<br/><span class="services-highlight">OX Solutions?</span></h2>
                    <p class="services-lead">OX empowers high-impact operational sectors with cutting-edge digital infrastructure and enterprise software tailored for scalable growth.</p>
                    <p class="services-desc">From commercial towers to hotels, government facilities and smart complexes—all operations united in a secure, intelligent, and seamless platform.</p>
                @endif

                <div class="services-cta-wrap">
                    <a href="javascript:void(0)" onclick="openConsultModal()" class="services-cta-btn">
                        <span>{{ $locale === 'ar' ? 'اطلب استشارة تقنية لقطاعك' : ($locale === 'fr' ? 'Demander une consultation' : 'Request Sector Consultation') }}</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                    </a>
                </div>
            </div>

            <!-- Dark Device Panel with Colorful Cards (Left side in RTL) -->
            <div class="services-panel-col reveal">
                <div class="services-showcase-panel">
                    <!-- Top Bar inside Panel -->
                    <div class="panel-top-bar">
                        <div class="panel-tag">
                            <span class="panel-tag-bar"></span>
                            <span class="panel-tag-text">{{ $locale === 'ar' ? 'القطاعات التي نحدث فيها الأثر' : ($locale === 'fr' ? 'Secteurs à Fort Impact' : 'Sectors Where We Drive Real Impact') }}</span>
                        </div>
                        <div class="panel-slider-arrows">
                            <button type="button" class="slider-arrow-btn" id="sectorSlidePrev" aria-label="Previous" title="السابق">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </button>
                            <button type="button" class="slider-arrow-btn" id="sectorSlideNext" aria-label="Next" title="التالي">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Cards Slider Track -->
                    <div class="services-cards-viewport" id="servicesViewport">
                        <div class="services-cards-track" id="servicesCardsTrack">
                            <!-- Card 1: Facility & Ops Management (Royal Blue) -->
                            <div class="service-sector-card card-blue" data-index="0">
                                <div class="sector-card-header">
                                    <h4 class="sector-card-title">{{ $locale === 'ar' ? 'شركات إدارة المرافق والخدمات التشغيلية' : ($locale === 'fr' ? 'Gestion des Installations & Opérations' : 'Facility Management & Operations') }}</h4>
                                </div>
                                <div class="sector-card-graphic">
                                    <svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="isometric-svg">
                                        <!-- Isometric Grid Floor -->
                                        <path d="M10 110L100 150L190 110L100 70Z" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.15)" stroke-dasharray="3 3"/>
                                        <!-- Isometric 3D Clipboard Base -->
                                        <path d="M60 48L140 18L170 82L90 112Z" fill="#1e40af" stroke="#60a5fa" stroke-width="1.5"/>
                                        <path d="M60 48L90 112L85 116L55 52Z" fill="#172554"/>
                                        <path d="M90 112L170 82L165 86L85 116Z" fill="#1e3a8a"/>
                                        <!-- White Sheet on Clipboard -->
                                        <path d="M72 50L135 26L158 78L95 102Z" fill="#f8fafc"/>
                                        <path d="M85 54L125 38" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round"/>
                                        <path d="M88 64L135 46" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round"/>
                                        <path d="M92 74L142 55" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round"/>
                                        <!-- 3D Isometric Blue Gear -->
                                        <g transform="translate(100, 58)">
                                            <ellipse cx="20" cy="20" rx="26" ry="16" fill="#0284c7" stroke="#38bdf8" stroke-width="2"/>
                                            <ellipse cx="20" cy="20" rx="12" ry="7.5" fill="#1e40af"/>
                                            <circle cx="20" cy="20" r="4" fill="#ffffff"/>
                                        </g>
                                        <!-- 3D Glowing Cursor Pointer -->
                                        <path d="M130 92L142 118L132 122L126 108L116 114Z" fill="#ffffff" stroke="#2563eb" stroke-width="2" filter="drop-shadow(0 4px 10px rgba(0,0,0,0.4))"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Card 2: Hospitality & Hotels (Sky / Cyan Blue) -->
                            <div class="service-sector-card card-cyan" data-index="1">
                                <div class="sector-card-header">
                                    <h4 class="sector-card-title">{{ $locale === 'ar' ? 'الضيافة والفنادق والمنشآت الذكية' : ($locale === 'fr' ? 'Hôtellerie & Établissements Intelligents' : 'Hospitality & Smart Hotels') }}</h4>
                                </div>
                                <div class="sector-card-graphic">
                                    <svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="isometric-svg">
                                        <!-- Isometric Grid Floor -->
                                        <path d="M10 115L100 155L190 115L100 75Z" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.15)" stroke-dasharray="3 3"/>
                                        <!-- Isometric Hotel Building Left Facade -->
                                        <path d="M70 42L105 60V126L70 108Z" fill="#0284c7" stroke="#38bdf8" stroke-width="1.5"/>
                                        <!-- Isometric Hotel Building Right Facade -->
                                        <path d="M105 60L145 38V104L105 126Z" fill="#0369a1" stroke="#38bdf8" stroke-width="1.5"/>
                                        <!-- Hotel Roof -->
                                        <path d="M70 42L110 20L145 38L105 60Z" fill="#38bdf8"/>
                                        <!-- Neon HOTEL Sign on Roof -->
                                        <rect x="92" y="14" width="36" height="12" rx="3" fill="#ffffff" stroke="#0284c7" stroke-width="1.5"/>
                                        <text x="110" y="23" text-anchor="middle" font-family="var(--font-latin)" font-weight="900" font-size="8" fill="#0284c7">HOTEL</text>
                                        <!-- Windows Left -->
                                        <rect x="76" y="54" width="10" height="12" rx="2" fill="#e0f2fe" opacity="0.9"/>
                                        <rect x="76" y="74" width="10" height="12" rx="2" fill="#e0f2fe" opacity="0.9"/>
                                        <rect x="76" y="94" width="10" height="12" rx="2" fill="#e0f2fe" opacity="0.9"/>
                                        <!-- Windows Right -->
                                        <rect x="120" y="50" width="12" height="12" rx="2" fill="#bae6fd" opacity="0.9"/>
                                        <rect x="120" y="70" width="12" height="12" rx="2" fill="#bae6fd" opacity="0.9"/>
                                        <!-- Room 302 Keycard badge -->
                                        <g transform="translate(130, 88)">
                                            <rect x="0" y="0" width="46" height="26" rx="5" fill="#ffffff" stroke="#0284c7" stroke-width="1.5" filter="drop-shadow(0 4px 8px rgba(0,0,0,0.3))"/>
                                            <text x="23" y="16" text-anchor="middle" font-family="var(--font-latin)" font-weight="800" font-size="7" fill="#0369a1">ROOM 302</text>
                                            <circle cx="9" cy="13" r="2" fill="#22c55e"/>
                                        </g>
                                    </svg>
                                </div>
                            </div>

                            <!-- Card 3: Government & Public Entities (Deep Indigo) -->
                            <div class="service-sector-card card-indigo" data-index="2">
                                <div class="sector-card-header">
                                    <h4 class="sector-card-title">{{ $locale === 'ar' ? 'الجهات الحكومية والخدمية' : ($locale === 'fr' ? 'Secteur Public & Gouvernement' : 'Government & Public Entities') }}</h4>
                                </div>
                                <div class="sector-card-graphic">
                                    <svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="isometric-svg">
                                        <!-- Isometric Grid Floor -->
                                        <path d="M10 115L100 155L190 115L100 75Z" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.15)" stroke-dasharray="3 3"/>
                                        <!-- Stepped Isometric Plinth -->
                                        <path d="M45 110L100 135L155 110L100 85Z" fill="#312e81" stroke="#818cf8" stroke-width="1.5"/>
                                        <path d="M45 110L100 135V142L45 117Z" fill="#1e1b4b"/>
                                        <path d="M100 135L155 110V117L100 142Z" fill="#1e1b4b"/>
                                        <!-- Neoclassical Columns -->
                                        <rect x="62" y="70" width="8" height="34" rx="2" fill="#e0e7ff" stroke="#6366f1" stroke-width="1"/>
                                        <rect x="80" y="76" width="8" height="34" rx="2" fill="#e0e7ff" stroke="#6366f1" stroke-width="1"/>
                                        <rect x="112" y="76" width="8" height="34" rx="2" fill="#c7d2fe" stroke="#6366f1" stroke-width="1"/>
                                        <rect x="130" y="70" width="8" height="34" rx="2" fill="#c7d2fe" stroke="#6366f1" stroke-width="1"/>
                                        <!-- Classical Pediment / Roof -->
                                        <path d="M50 72L100 50L150 72Z" fill="#4338ca" stroke="#818cf8" stroke-width="1.5"/>
                                        <!-- Central Dome with Spire -->
                                        <path d="M78 50C78 32 122 32 122 50Z" fill="#38bdf8" stroke="#ffffff" stroke-width="1.5"/>
                                        <line x1="100" y1="32" x2="100" y2="20" stroke="#BDFF45" stroke-width="3" stroke-linecap="round"/>
                                        <circle cx="100" cy="18" r="3" fill="#BDFF45"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Card 4: Omnichannel & eCommerce (Royal Violet) -->
                            <div class="service-sector-card card-violet" data-index="3">
                                <div class="sector-card-header">
                                    <h4 class="sector-card-title">{{ $locale === 'ar' ? 'التجارة والمنصات متعددة القنوات' : ($locale === 'fr' ? 'Commerce Omnicanal & Plateformes' : 'Omnichannel Retail & eCommerce') }}</h4>
                                </div>
                                <div class="sector-card-graphic">
                                    <svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="isometric-svg">
                                        <!-- Isometric Grid Floor -->
                                        <path d="M10 115L100 155L190 115L100 75Z" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.15)" stroke-dasharray="3 3"/>
                                        <!-- Storefront Base -->
                                        <path d="M55 70L100 92L145 70L100 48Z" fill="#6d28d9" stroke="#a78bfa" stroke-width="1.5"/>
                                        <path d="M55 70L100 92V124L55 102Z" fill="#4c1d95"/>
                                        <path d="M100 92L145 70V102L100 124Z" fill="#5b21b6"/>
                                        <!-- Glass Window with Product Glow -->
                                        <path d="M63 76L95 91V115L63 100Z" fill="#ddd6fe" opacity="0.85"/>
                                        <!-- Awning / Canopy Stripes -->
                                        <path d="M48 66L100 40L152 66L100 92Z" fill="#c084fc"/>
                                        <path d="M55 70L100 48L112 54L67 76Z" fill="#ffffff" opacity="0.8"/>
                                        <path d="M85 84L130 62L142 68L97 90Z" fill="#ffffff" opacity="0.8"/>
                                        <!-- 3D Floating Shopping Parcel & Credit Card -->
                                        <g transform="translate(115, 84)">
                                            <!-- Parcel Box -->
                                            <path d="M15 10L35 0L50 12L30 22Z" fill="#fbbf24" stroke="#d97706" stroke-width="1.5"/>
                                            <path d="M15 10L30 22V36L15 24Z" fill="#d97706"/>
                                            <path d="M30 22L50 12V24L30 36Z" fill="#b45309"/>
                                        </g>
                                    </svg>
                                </div>
                            </div>

                            <!-- Card 5: Smart Healthcare & MedTech (Emerald Teal) -->
                            <div class="service-sector-card card-teal" data-index="4">
                                <div class="sector-card-header">
                                    <h4 class="sector-card-title">{{ $locale === 'ar' ? 'الرعاية الصحية والمستشفيات الذكية' : ($locale === 'fr' ? 'Santé Connectée & Hôpitaux' : 'Smart Healthcare & MedTech') }}</h4>
                                </div>
                                <div class="sector-card-graphic">
                                    <svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="isometric-svg">
                                        <!-- Isometric Grid Floor -->
                                        <path d="M10 115L100 155L190 115L100 75Z" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.15)" stroke-dasharray="3 3"/>
                                        <!-- Medical Facility Block -->
                                        <path d="M60 52L105 72L145 52L100 32Z" fill="#059669" stroke="#34d399" stroke-width="1.5"/>
                                        <path d="M60 52L105 72V120L60 100Z" fill="#047857"/>
                                        <path d="M105 72L145 52V100L105 120Z" fill="#065f46"/>
                                        <!-- Glowing Medical Cross on Facade -->
                                        <rect x="78" y="74" width="8" height="24" rx="2" fill="#ffffff"/>
                                        <rect x="70" y="82" width="24" height="8" rx="2" fill="#ffffff"/>
                                        <!-- Floating 3D ECG / Heartbeat Monitor -->
                                        <g transform="translate(112, 70)">
                                            <rect x="0" y="0" width="54" height="36" rx="6" fill="#0f172a" stroke="#10b981" stroke-width="2" filter="drop-shadow(0 6px 12px rgba(0,0,0,0.4))"/>
                                            <path d="M6 18H16L21 8L27 28L33 14L38 22H48" stroke="#34d399" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                    </svg>
                                </div>
                            </div>

                            <!-- Card 6: Education & EdTech (Warm Amber) -->
                            <div class="service-sector-card card-amber" data-index="5">
                                <div class="sector-card-header">
                                    <h4 class="sector-card-title">{{ $locale === 'ar' ? 'التعليم والجامعات والأكاديميات' : ($locale === 'fr' ? 'Éducation & Académies Numériques' : 'Higher Education & EdTech') }}</h4>
                                </div>
                                <div class="sector-card-graphic">
                                    <svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="isometric-svg">
                                        <!-- Isometric Grid Floor -->
                                        <path d="M10 115L100 155L190 115L100 75Z" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.15)" stroke-dasharray="3 3"/>
                                        <!-- Stack of 3D Books Base -->
                                        <path d="M60 90L100 110L145 88L105 68Z" fill="#b45309" stroke="#f59e0b" stroke-width="1.5"/>
                                        <path d="M60 90L100 110V118L60 98Z" fill="#78350f"/>
                                        <path d="M100 110L145 88V96L100 118Z" fill="#fef3c7"/>
                                        <!-- Book 2 -->
                                        <path d="M65 76L105 96L142 76L102 56Z" fill="#d97706" stroke="#fbbf24" stroke-width="1.5"/>
                                        <!-- Graduation Cap (Mortarboard) -->
                                        <path d="M50 48L100 24L150 48L100 72Z" fill="#1e293b" stroke="#fbbf24" stroke-width="2"/>
                                        <path d="M78 62V78C78 88 122 88 122 78V62Z" fill="#0f172a"/>
                                        <!-- Gold Tassel -->
                                        <path d="M100 48L138 60V76" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round"/>
                                        <circle cx="138" cy="78" r="3" fill="#f59e0b"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Bar inside Panel -->
                    <div class="panel-bottom-bar">
                        <!-- Navigation Dots Indicator -->
                        <div class="panel-slider-dots" id="sectorDots">
                            <span class="dot active" data-index="0"></span>
                            <span class="dot" data-index="1"></span>
                            <span class="dot" data-index="2"></span>
                            <span class="dot" data-index="3"></span>
                            <span class="dot" data-index="4"></span>
                            <span class="dot" data-index="5"></span>
                        </div>

                        <!-- Trust Guarantee Badge -->
                        <div class="panel-trust-badge">
                            <div class="trust-badge-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    <path d="M9 12l2 2 4-4"></path>
                                </svg>
                            </div>
                            <p class="trust-badge-text">
                                @if($locale === 'ar')
                                    مهما كان نوع منشأتك .. أوكس هو شريكك الذكي لإدارة كل التفاصيل بثقة من <strong>منصة واحدة آمنة ومبنية بأعلى المعايير العالمية</strong>
                                @elseif($locale === 'fr')
                                    Quelle que soit votre organisation .. OX orchestre tous vos flux en toute confiance sur <strong>une plateforme unifiée et sécurisée</strong>
                                @else
                                    Whatever your enterprise scale .. OX is your intelligent partner to orchestrate operations from <strong>a unified, world-class secure platform</strong>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── Sadu Chevron Zigzag Divider into Work & Projects (Light Style) ─── -->
    <div class="sadu-divider" style="color: #f7f9f6;">
        <svg viewBox="0 0 1200 24" preserveAspectRatio="none">
            <path d="M0,0 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 l15,22 15,-22 V24 H0 Z" fill="currentColor"/>
        </svg>
    </div>

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

    // Hero Slider - removed (section replaced by 3D showcase)
</script>

<!-- Ionicons v7 Web Components (self-hosted) -->
<script type="module" src="{{ asset('vendor/ionicons/ionicons.esm.js') }}"></script>
<script nomodule src="{{ asset('vendor/ionicons/ionicons.js') }}"></script>

<!-- 3D Product Scroll Showcase -->
<script type="module" src="{{ asset('assets/product-scroll.js') }}"></script>
@endpush
