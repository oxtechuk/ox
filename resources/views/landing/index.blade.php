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
                <h3>تكامل سلس مع +80 شريك عالمي ومحلي، لتلبية جميع احتياجاتك وتوسيع إمكانياتك بسهولة</h3>
                <p class="brands-subtitle">ربط منجز مع أنظمة المبيعات والمحاسبة والمخزون لديك، تكامل مباشر مع منصات التجارة الإلكترونية، أنظمة CRM أخرى، وأدوات الدفع الإلكتروني لأتمتة كاملة من أول تفاعل إلى إتمام البيع.</p>
            @elseif($locale === 'fr')
                <h3>Intégration fluide avec plus de +80 partenaires mondiaux et locaux, pour répondre à tous vos besoins.</h3>
                <p class="brands-subtitle">Connexion directe avec les leaders des ERP, plateformes e-commerce, CRM et passerelles de paiement pour une automatisation complète.</p>
            @else
                <h3>Seamless integration with +80 global & local partners, to fulfill your needs and scale effortlessly.</h3>
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
            <!-- ─── Smart Client-Friendly Filter Bar ─── -->
            <div class="portfolio-filter-container reveal" id="portfolioFilterContainer">
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
                    <div class="portfolio-country-flags-strip" id="portfolioCountryStrip" role="tablist" aria-label="{{ $locale === 'ar' ? 'فلتر المشاريع حسب الدولة' : 'Filter projects by country' }}">
                        <!-- 1. All Countries Option (Default Active) -->
                        <button type="button" 
                                class="country-flag-strip-btn active" 
                                data-country="all" 
                                id="flagBtnAll" 
                                onclick="selectPortfolioCountry('all', '{{ $locale === 'ar' ? 'كل الدول' : ($locale === 'fr' ? 'Tous les pays' : 'All Countries') }}', null)" 
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
                                    id="flagBtn_{{ $cLower }}" 
                                    onclick="selectPortfolioCountry('{{ $cLower }}', '{{ addslashes($cName) }}', '{{ $country->flag_url }}')" 
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
                            <div class="country-flag-strip-dropdown-wrap" id="otherCountriesWrap">
                                <button type="button" 
                                        class="country-flag-strip-btn other-countries-btn" 
                                        id="otherCountriesBtn" 
                                        onclick="toggleOtherCountriesDropdown(event)" 
                                        aria-haspopup="true" 
                                        aria-expanded="false" 
                                        title="{{ $locale === 'ar' ? 'دول أخرى' : 'Other Countries' }}">
                                    <span class="flag-strip-avatar other-avatar" id="otherCountriesAvatar">
                                        <span class="other-count-text">{{ $otherCountries->count() }}+</span>
                                    </span>
                                    <span class="flag-strip-label" id="otherCountriesLabel">{{ $locale === 'ar' ? 'دول اخرى' : ($locale === 'fr' ? 'Autres pays' : 'Other countries') }}</span>
                                </button>

                                <div class="other-countries-menu" id="otherCountriesMenu">
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
                                                    onclick="selectPortfolioCountry('{{ $ocLower }}', '{{ addslashes($ocName) }}', '{{ $oCountry->flag_url }}', true)">
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
                        <input type="text" id="portfolioSmartSearch" class="portfolio-search-input" 
                               placeholder="{{ $locale === 'ar' ? 'ابحث عن فكرة أو مجال (مثال: متجر، سيارات، عيادة)...' : ($locale === 'fr' ? 'Rechercher une idée, secteur (ex: e-commerce, santé)...' : 'Search by idea or sector (e.g. store, booking, medical)...') }}" 
                               autocomplete="off" 
                               oninput="handlePortfolioSearch(this.value)">
                        <button type="button" id="portfolioSearchClear" class="portfolio-search-clear" onclick="clearPortfolioSearch()" style="display:none;" title="{{ $locale === 'ar' ? 'مسح البحث' : 'Clear search' }}">✕</button>
                    </div>

                    <!-- Reset Filter Button (Shown when filters active) -->
                    <button type="button" class="portfolio-reset-pill-btn" id="portfolioResetBtn" style="display:none;" onclick="resetPortfolioFilter()" title="{{ $locale === 'ar' ? 'إعادة تعيين الفلاتر' : 'Reset filters' }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <span>{{ $locale === 'ar' ? 'إلغاء الفلتر' : ($locale === 'fr' ? 'Réinitialiser' : 'Reset') }}</span>
                    </button>
                </div>

                <!-- Row 2: Client-Friendly Business Sector Tabs (SVG Vector Icons, No Emojis) -->
                <div class="portfolio-sector-tabs-wrap">
                    <div class="portfolio-sector-tabs" id="portfolioSectorTabs">
                        <button type="button" class="portfolio-sector-tab portfolio-cat-btn active" data-cat="all" onclick="selectPortfolioSector('all', this)">
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
                            <button type="button" class="portfolio-sector-tab portfolio-cat-btn" data-cat="{{ $sec->sector_slug }}" onclick="selectPortfolioSector('{{ $sec->sector_slug }}', this)">
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

            <!-- ─── Portfolio Cards Grid with High-Res Thumbnails ─── -->
            <div class="ox-portfolio-grid" id="portfolioGrid">
                @forelse($projects as $index => $project)
                    @php
                        $countryLower = strtolower($project->country_code ?? '');
                        $projectSector = $project->sector_slug ?? 'general';
                        $projectImg = $project->display_image;
                        $isOverDesktopLimit = $index >= 9;
                        $isOverMobileLimit = $index >= 6;
                    @endphp
                    <article class="ox-portfolio-card reveal {{ $isOverDesktopLimit ? 'ox-limit-desktop-hide' : '' }} {{ $isOverMobileLimit ? 'ox-limit-mobile-hide' : '' }}" 
                             data-category="{{ $projectSector }}" 
                             data-country="{{ $countryLower }}"
                             data-search="{{ mb_strtolower($project->title . ' ' . $project->sector_name . ' ' . $project->country_name . ' ' . $project->subtitle . ' ' . ($project->short_description ?? '') . ' ' . ($project->client_name ?? '')) }}"
                             onclick="window.location.href='{{ route('projects.show', $project->slug) }}'">
                        
                        <!-- Thumbnail Visual Media -->
                        <div class="portfolio-card-media">
                            <img src="{{ $projectImg }}" 
                                 alt="{{ $project->title }}" 
                                 loading="lazy" 
                                 width="420"
                                 height="280"
                                 class="portfolio-card-img" />
                            <div class="portfolio-card-overlay"></div>
                            
                            <!-- Top Floating Badges: Country with Flag & Sector -->
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
                                <span class="portfolio-view-btn" aria-hidden="true">
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

            <!-- ─── Browse All Projects CTA Button ─── -->
            <div class="ox-portfolio-browse-wrap reveal" id="portfolioBrowseWrap">
                <a href="{{ route('projects.index') }}" class="ox-btn-browse-portfolio">
                    <span class="btn-sparkle-dot">✦</span>
                    <span class="btn-title">{{ $locale === 'ar' ? 'تصفح جميع المشاريع' : ($locale === 'fr' ? 'Consulter toutes nos réalisations' : 'Browse All Projects') }}</span>
                    <span class="btn-arrow-wrap">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            @if($locale === 'ar')
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            @else
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            @endif
                        </svg>
                    </span>
                </a>
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
                    <img src="{{ asset('assets/services/service-web.webp') }}" alt="{{ $locale === 'ar' ? 'تطوير الويب والسحاب' : 'Web & SaaS Platforms' }}" class="ox-service-card-bg" width="380" height="460" loading="lazy">
                    <div class="ox-service-card-overlay"></div>
                    
                    <div class="ox-service-card-top">
                        <span class="ox-service-card-tag">Web & SaaS</span>
                        <h3 class="ox-service-card-title">{{ $locale === 'ar' ? 'تطوير الويب والسحاب' : ($locale === 'fr' ? 'Web & Plateformes SaaS' : 'Web & SaaS Platforms') }}</h3>
                    </div>

                    <div class="ox-service-card-bottom">
                        <p class="ox-service-card-desc">
                            {{ $locale === 'ar' ? 'بناء منصات سحابية وبوابات SaaS تفاعلية فائقة السرعة والأمان، بمعمارية برمجية قابلة للتوسع اللانهائي.' : ($locale === 'fr' ? 'Plateformes cloud et SaaS hautement sécurisées et scalables.' : 'Scalable cloud architectures, SaaS platforms, and enterprise portals engineered for speed and security.') }}
                        </p>
                        <div class="ox-service-card-circle-btn" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </div>
                    </div>
                </article>

                <!-- Card 2: Mobile Applications -->
                <article class="ox-service-card-item" onclick="openConsultModal()">
                    <img src="{{ asset('assets/services/service-mobile.webp') }}" alt="{{ $locale === 'ar' ? 'تطبيقات الجوال الذكية' : 'Mobile Applications' }}" class="ox-service-card-bg" width="380" height="460" loading="lazy">
                    <div class="ox-service-card-overlay"></div>
                    
                    <div class="ox-service-card-top">
                        <span class="ox-service-card-tag">iOS & Android</span>
                        <h3 class="ox-service-card-title">{{ $locale === 'ar' ? 'تطبيقات الجوال الذكية' : ($locale === 'fr' ? 'Applications Mobiles' : 'Mobile Applications') }}</h3>
                    </div>

                    <div class="ox-service-card-bottom">
                        <p class="ox-service-card-desc">
                            {{ $locale === 'ar' ? 'تطبيقات جوال سلسة ومتطورة بأحدث التقنيات (Flutter & Native) تضمن تجربة مستخدم استثنائية وأداء فائق السرعة.' : ($locale === 'fr' ? 'Applications fluides et performantes (Flutter & Native).' : 'High-performance iOS & Android mobile apps engineered with Flutter and Native frameworks.') }}
                        </p>
                        <div class="ox-service-card-circle-btn" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </div>
                    </div>
                </article>

                <!-- Card 3: Digital E-Commerce -->
                <article class="ox-service-card-item" onclick="openConsultModal()">
                    <img src="{{ asset('assets/services/service-ecommerce.webp') }}" alt="{{ $locale === 'ar' ? 'المتاجر والتجارة الرقمية' : 'Digital E-Commerce' }}" class="ox-service-card-bg" width="380" height="460" loading="lazy">
                    <div class="ox-service-card-overlay"></div>
                    
                    <div class="ox-service-card-top">
                        <span class="ox-service-card-tag">E-Commerce</span>
                        <h3 class="ox-service-card-title">{{ $locale === 'ar' ? 'المتاجر والتجارة الرقمية' : ($locale === 'fr' ? 'E-Commerce & Boutiques' : 'Digital E-Commerce') }}</h3>
                    </div>

                    <div class="ox-service-card-bottom">
                        <p class="ox-service-card-desc">
                            {{ $locale === 'ar' ? 'متاجر مخصصة متكاملة مع بوابات الدفع والشحن والأنظمة المحاسبية، مصممة لتحقيق أعلى معدلات التحويل.' : ($locale === 'fr' ? 'Boutiques en ligne optimisées avec passerelles de paiement et logistique.' : 'Custom digital commerce stores integrated with multi-currency gateways and automated fulfillment.') }}
                        </p>
                        <div class="ox-service-card-circle-btn" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </div>
                    </div>
                </article>

                <!-- Card 4: Enterprise, Odoo & Desktop -->
                <article class="ox-service-card-item" onclick="openConsultModal()">
                    <img src="{{ asset('assets/services/service-enterprise.webp') }}" alt="{{ $locale === 'ar' ? 'أنظمة أودو والمؤسسات' : 'Enterprise & Odoo ERP' }}" class="ox-service-card-bg" width="380" height="460" loading="lazy">
                    <div class="ox-service-card-overlay"></div>
                    
                    <div class="ox-service-card-top">
                        <span class="ox-service-card-tag">ERP & Desktop</span>
                        <h3 class="ox-service-card-title">{{ $locale === 'ar' ? 'أنظمة أودو والمؤسسات' : ($locale === 'fr' ? 'Systèmes Odoo & ERP' : 'Enterprise & Odoo ERP') }}</h3>
                    </div>

                    <div class="ox-service-card-bottom">
                        <p class="ox-service-card-desc">
                            {{ $locale === 'ar' ? 'تطبيق وتخصيص دورات Odoo ERP الشاملة والربط الضريبي (ZATCA)، مع برمجيات Windows ونقاط البيع POS دون إنترنت.' : ($locale === 'fr' ? 'Intégration Odoo ERP complète et logiciels POS offline.' : 'Full-cycle Odoo ERP customization, e-invoicing compliance, and offline-first desktop POS systems.') }}
                        </p>
                        <div class="ox-service-card-circle-btn" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </div>
                    </div>
                </article>
            </div>

          
        </div>
    </section>

   
    <!-- ─── Partner Stories / Testimonials Section (Saudi Sadu Aesthetic & Inline Video Player) ─── -->
    <section class="testimonials section" id="stories">
        <!-- Sadu Corner Accents -->
        <svg class="sadu-corner top-right" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="16" y="0" width="8" height="8" fill="#1D8A68"/>
            <rect x="0" y="16" width="8" height="8" fill="#1D8A68"/>
            <rect x="32" y="16" width="8" height="8" fill="#1D8A68"/>
            <rect x="16" y="32" width="8" height="8" fill="#1D8A68"/>
            <rect x="16" y="16" width="8" height="8" fill="#ffffff"/>
            <rect x="8" y="8" width="8" height="8" fill="#C8A96B"/>
            <rect x="24" y="8" width="8" height="8" fill="#C8A96B"/>
            <rect x="8" y="24" width="8" height="8" fill="#C8A96B"/>
            <rect x="24" y="24" width="8" height="8" fill="#C8A96B"/>
        </svg>
        <svg class="sadu-corner top-left" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="16" y="0" width="8" height="8" fill="#1D8A68"/>
            <rect x="0" y="16" width="8" height="8" fill="#1D8A68"/>
            <rect x="32" y="16" width="8" height="8" fill="#1D8A68"/>
            <rect x="16" y="32" width="8" height="8" fill="#1D8A68"/>
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
                        <rect x="0" y="4" width="6" height="6" fill="#1D8A68"/>
                        <rect x="6" y="0" width="6" height="6" fill="#1D8A68"/>
                        <rect x="6" y="8" width="6" height="6" fill="#1D8A68"/>
                        <rect x="12" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="18" y="4" width="6" height="6" fill="#1D8A68"/>
                        <rect x="24" y="0" width="6" height="6" fill="#1D8A68"/>
                        <rect x="24" y="8" width="6" height="6" fill="#1D8A68"/>
                        <rect x="30" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="36" y="4" width="6" height="6" fill="#1D8A68"/>
                        <rect x="42" y="0" width="6" height="6" fill="#1D8A68"/>
                        <rect x="42" y="8" width="6" height="6" fill="#1D8A68"/>
                        <rect x="48" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="54" y="4" width="6" height="6" fill="#1D8A68"/>
                    </svg>

                    <p class="kicker">{{ $locale === 'ar' ? 'شركاء النجاح' : ($locale === 'fr' ? 'HISTOIRES DE PARTENAIRES' : 'PARTNER STORIES') }}</p>

                    <!-- Sadu Ribbon Pattern Right -->
                    <svg width="60" height="14" viewBox="0 0 60 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0" y="4" width="6" height="6" fill="#1D8A68"/>
                        <rect x="6" y="0" width="6" height="6" fill="#1D8A68"/>
                        <rect x="6" y="8" width="6" height="6" fill="#1D8A68"/>
                        <rect x="12" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="18" y="4" width="6" height="6" fill="#1D8A68"/>
                        <rect x="24" y="0" width="6" height="6" fill="#1D8A68"/>
                        <rect x="24" y="8" width="6" height="6" fill="#1D8A68"/>
                        <rect x="30" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="36" y="4" width="6" height="6" fill="#1D8A68"/>
                        <rect x="42" y="0" width="6" height="6" fill="#1D8A68"/>
                        <rect x="42" y="8" width="6" height="6" fill="#1D8A68"/>
                        <rect x="48" y="4" width="6" height="6" fill="#ffffff"/>
                        <rect x="54" y="4" width="6" height="6" fill="#1D8A68"/>
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

                                        <rect x="50" y="30" width="20" height="20" fill="#1D8A68"/>
                                        <rect x="90" y="30" width="20" height="20" fill="#1D8A68"/>
                                        <rect x="30" y="50" width="20" height="20" fill="#1D8A68"/>
                                        <rect x="110" y="50" width="20" height="20" fill="#1D8A68"/>
                                        <rect x="30" y="90" width="20" height="20" fill="#1D8A68"/>
                                        <rect x="110" y="90" width="20" height="20" fill="#1D8A68"/>
                                        <rect x="50" y="110" width="20" height="20" fill="#1D8A68"/>
                                        <rect x="90" y="110" width="20" height="20" fill="#1D8A68"/>

                                        <rect x="70" y="50" width="20" height="20" fill="#ffffff"/>
                                        <rect x="50" y="70" width="20" height="20" fill="#ffffff"/>
                                        <rect x="90" y="70" width="20" height="20" fill="#ffffff"/>
                                        <rect x="70" y="90" width="20" height="20" fill="#ffffff"/>
                                        <rect x="70" y="70" width="20" height="20" fill="#1D8A68"/>
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
                                        <span style="color:var(--lime, #1D8A68); font-size:13px;">▶</span>
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
                                           preload="none" 
                                           data-src="{{ $t->video_src }}" 
                                           style="width:100%; height:100%; object-fit:cover;"></video>
                                @else
                                    <div style="display:grid; place-items:center; height:100%; color:#1D8A68; padding:20px; text-align:center;">
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
                        <img src="{{ asset('assets/ox-saudi-founder-video.webp') }}" alt="شاهد قصة نجاح OX Tech في السعودية" class="ox-video-img" width="560" height="360" loading="lazy">
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
                    <img src="{{ asset('assets/ox-saudi-founder-video.webp') }}" alt="قصة نجاح OX Tech في السعودية" width="760" height="428" style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.85);" loading="lazy">
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
                            نبنيها معاً.
                        </h2>
                        <p class="ox-consult-subtitle">
                            سواء مشروع جديد أو تطوير لفكرة حالية<br/>
                            فريقنا جاهز لمساعدتك.
                        </p>
                    @elseif($locale === 'fr')
                        <h2 class="ox-consult-headline">
                            Une idée en tête ?<br/>
                            Bâtissons-la ensemble.
                        </h2>
                        <p class="ox-consult-subtitle">
                            Nouveau projet ou développement d'une idée existante,<br/>
                            notre équipe est prête à vous propulser.
                        </p>
                    @else
                        <h2 class="ox-consult-headline">
                            Have an idea?<br/>
                            Let's build it together.
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
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_phone_primary'] ?? '966500000000') }}?text={{ urlencode($locale === 'ar' ? 'مرحباً OX Tech، أود الاستفسار عن تطوير مشروع تقني' : 'Hello OX Tech, I would like to inquire about software development') }}" target="_blank" rel="noopener noreferrer" class="ox-consult-btn-secondary" aria-label="{{ $locale === 'ar' ? 'تواصل معنا عبر واتساب' : ($locale === 'fr' ? 'Contactez-nous sur WhatsApp' : 'Contact Us on WhatsApp') }}">
                            <span>{{ $locale === 'ar' ? 'تواصل معنا' : ($locale === 'fr' ? 'Contactez-nous' : 'Contact Us') }}</span>
                        </a>
                    </div>
                </div>

                <!-- Left / Interactive Form Card (RTL Left) -->
                <div class="ox-consult-form-col">
                    <div class="ox-consult-form-card">
                        @php
                            $phoneCountries = [
                                ['code' => 'sa', 'dial' => '+966', 'name_ar' => 'المملكة العربية السعودية', 'name_en' => 'Saudi Arabia'],
                                ['code' => 'ae', 'dial' => '+971', 'name_ar' => 'الإمارات العربية المتحدة', 'name_en' => 'United Arab Emirates'],
                                ['code' => 'eg', 'dial' => '+20',  'name_ar' => 'مصر', 'name_en' => 'Egypt'],
                                ['code' => 'kw', 'dial' => '+965', 'name_ar' => 'الكويت', 'name_en' => 'Kuwait'],
                                ['code' => 'qa', 'dial' => '+974', 'name_ar' => 'قطر', 'name_en' => 'Qatar'],
                                ['code' => 'om', 'dial' => '+968', 'name_ar' => 'سلطنة عُمان', 'name_en' => 'Oman'],
                                ['code' => 'bh', 'dial' => '+973', 'name_ar' => 'البحرين', 'name_en' => 'Bahrain'],
                                ['code' => 'jo', 'dial' => '+962', 'name_ar' => 'الأردن', 'name_en' => 'Jordan'],
                                ['code' => 'iq', 'dial' => '+964', 'name_ar' => 'العراق', 'name_en' => 'Iraq'],
                                ['code' => 'gb', 'dial' => '+44',  'name_ar' => 'المملكة المتحدة', 'name_en' => 'United Kingdom'],
                                ['code' => 'us', 'dial' => '+1',   'name_ar' => 'الولايات المتحدة', 'name_en' => 'United States'],
                                ['code' => 'fr', 'dial' => '+33',  'name_ar' => 'فرنسا', 'name_en' => 'France'],
                                ['code' => 'de', 'dial' => '+49',  'name_ar' => 'ألمانيا', 'name_en' => 'Germany'],
                                ['code' => 'se', 'dial' => '+46',  'name_ar' => 'السويد', 'name_en' => 'Sweden'],
                                ['code' => 'tr', 'dial' => '+90',  'name_ar' => 'تركيا', 'name_en' => 'Turkey'],
                                ['code' => 'ma', 'dial' => '+212', 'name_ar' => 'المغرب', 'name_en' => 'Morocco'],
                                ['code' => 'dz', 'dial' => '+213', 'name_ar' => 'الجزائر', 'name_en' => 'Algeria'],
                                ['code' => 'tn', 'dial' => '+216', 'name_ar' => 'تونس', 'name_en' => 'Tunisia'],
                                ['code' => 'lb', 'dial' => '+961', 'name_ar' => 'لبنان', 'name_en' => 'Lebanon'],
                                ['code' => 'ye', 'dial' => '+967', 'name_ar' => 'اليمن', 'name_en' => 'Yemen'],
                                ['code' => 'ps', 'dial' => '+970', 'name_ar' => 'فلسطين', 'name_en' => 'Palestine'],
                                ['code' => 'sy', 'dial' => '+963', 'name_ar' => 'سوريا', 'name_en' => 'Syria'],
                                ['code' => 'ly', 'dial' => '+218', 'name_ar' => 'ليبيا', 'name_en' => 'Libya'],
                                ['code' => 'sd', 'dial' => '+249', 'name_ar' => 'السودان', 'name_en' => 'Sudan'],
                                ['code' => 'ca', 'dial' => '+1',   'name_ar' => 'كندا', 'name_en' => 'Canada'],
                                ['code' => 'ch', 'dial' => '+41',  'name_ar' => 'سويسرا', 'name_en' => 'Switzerland'],
                                ['code' => 'nl', 'dial' => '+31',  'name_ar' => 'هولندا', 'name_en' => 'Netherlands'],
                                ['code' => 'es', 'dial' => '+34',  'name_ar' => 'إسبانيا', 'name_en' => 'Spain'],
                                ['code' => 'it', 'dial' => '+39',  'name_ar' => 'إيطاليا', 'name_en' => 'Italy'],
                                ['code' => 'my', 'dial' => '+60',  'name_ar' => 'ماليزيا', 'name_en' => 'Malaysia'],
                                ['code' => 'sg', 'dial' => '+65',  'name_ar' => 'سنغافورة', 'name_en' => 'Singapore'],
                                ['code' => 'au', 'dial' => '+61',  'name_ar' => 'أستراليا', 'name_en' => 'Australia'],
                            ];

                            $defaultCountryCode = $locale === 'ar' ? 'sa' : ($locale === 'fr' ? 'fr' : 'gb');
                            $defaultPhoneCountry = collect($phoneCountries)->firstWhere('code', $defaultCountryCode) ?? $phoneCountries[0];
                        @endphp
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

                                <!-- Row 1: Name & Email -->
                                <div class="ox-consult-row">
                                    <div class="ox-consult-field-wrap">
                                        <input type="text" name="name" id="inline_consult_name" class="ox-consult-input" placeholder="{{ $locale === 'ar' ? 'الاسم الكامل *' : ($locale === 'fr' ? 'Nom Complet *' : 'Full Name *') }}" maxlength="70" required>
                                    </div>
                                    <div class="ox-consult-field-wrap">
                                        <input type="email" name="email" class="ox-consult-input" placeholder="{{ $locale === 'ar' ? 'البريد الإلكتروني *' : ($locale === 'fr' ? 'Email Pro *' : 'Business Email *') }}" maxlength="100" required>
                                    </div>
                                </div>

                                <!-- Row 2: Phone with Country Code Picker -->
                                <div class="ox-phone-group" id="consultPhoneGroup">
                                    <input type="hidden" name="phone" id="consultFullPhone" value="">
                                    <input type="hidden" id="selectedDialCode" value="{{ $defaultPhoneCountry['dial'] }}">
                                    
                                    <div class="ox-phone-input-wrap">
                                        <button type="button" class="ox-phone-country-btn" id="countryPickerToggleBtn" onclick="toggleCountryPicker(event)" aria-haspopup="listbox" aria-expanded="false" title="{{ $locale === 'ar' ? 'اختر الدولة' : 'Select Country' }}">
                                            <img id="selectedCountryFlag" src="{{ asset('assets/flags/' . $defaultPhoneCountry['code'] . '.webp') }}" alt="{{ $locale === 'ar' ? $defaultPhoneCountry['name_ar'] : $defaultPhoneCountry['name_en'] }}" class="ox-phone-flag-img" width="22" height="15" loading="lazy">
                                            <span id="selectedCountryDial" class="ox-phone-dial-text">{{ $defaultPhoneCountry['dial'] }}</span>
                                            <svg class="ox-phone-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M6 9l6 6 6-6"/>
                                            </svg>
                                        </button>

                                        <span class="ox-phone-divider" aria-hidden="true"></span>

                                        <input type="tel" id="consult_phone_raw" class="ox-phone-raw-input" placeholder="{{ $locale === 'ar' ? 'رقم الجوال (مثال: 50 123 4567)' : ($locale === 'fr' ? 'Numéro de mobile (ex: 6 12 34 56 78)' : 'Mobile number (e.g. 50 123 4567)') }}" autocomplete="tel" maxlength="20">
                                    </div>

                                    <!-- Country Dropdown Menu -->
                                    <div class="ox-country-picker-dropdown" id="countryPickerDropdown" role="listbox">
                                        <div class="ox-country-search-wrap">
                                            <svg class="ox-country-search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                            <input type="text" id="countrySearchInput" class="ox-country-search-input" placeholder="{{ $locale === 'ar' ? 'ابحث باسم الدولة أو كود الاتصال...' : ($locale === 'fr' ? 'Rechercher pays ou indicatif...' : 'Search country or dial code...') }}" autocomplete="off" oninput="filterCountryOptions(this.value)">
                                        </div>

                                        <div class="ox-country-options-list" id="countryOptionsList">
                                            @foreach($phoneCountries as $country)
                                                <button type="button" class="ox-country-option-item {{ $country['code'] === $defaultPhoneCountry['code'] ? 'selected' : '' }}" data-code="{{ $country['code'] }}" data-dial="{{ $country['dial'] }}" data-name-ar="{{ $country['name_ar'] }}" data-name-en="{{ $country['name_en'] }}" onclick="selectCountryCode('{{ $country['code'] }}', '{{ $country['dial'] }}', '{{ addslashes($locale === 'ar' ? $country['name_ar'] : $country['name_en']) }}', '{{ asset('assets/flags/' . $country['code'] . '.webp') }}')">
                                                    <span class="ox-country-option-left">
                                                        <img src="{{ asset('assets/flags/' . $country['code'] . '.webp') }}" class="ox-country-option-flag" width="20" height="14" alt="{{ $country['name_en'] }}" loading="lazy">
                                                        <span class="ox-country-option-name">{{ $locale === 'ar' ? $country['name_ar'] : $country['name_en'] }}</span>
                                                    </span>
                                                    <span class="ox-country-option-dial">{{ $country['dial'] }}</span>
                                                </button>
                                            @endforeach
                                            <div class="ox-country-no-results" id="countryNoResults" style="display: none;">
                                                {{ $locale === 'ar' ? 'لا توجد نتائج مطابقة' : ($locale === 'fr' ? 'Aucun résultat trouvé' : 'No matching results') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 3: Project Type & Estimated Budget -->
                                <div class="ox-consult-row">
                                    <div class="ox-consult-field-wrap">
                                        <div class="ox-consult-select-wrap">
                                            <select name="project_type" id="inline_project_type" class="ox-consult-select" aria-label="{{ $locale === 'ar' ? 'نوع المشروع' : ($locale === 'fr' ? 'Type de Projet' : 'Project Type') }}" required>
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
                                    <div class="ox-consult-field-wrap">
                                        <div class="ox-consult-select-wrap">
                                            <select name="budget" id="inline_budget" class="ox-consult-select" aria-label="{{ $locale === 'ar' ? 'الميزانية التقديرية' : ($locale === 'fr' ? 'Budget Estimé' : 'Estimated Budget') }}" required>
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
<style>
    /* ─── Portfolio Grid Limits (3x3 = 9 Desktop, 6 Mobile) ─── */
    @media (min-width: 769px) {
        #portfolioGrid .ox-portfolio-card.ox-limit-desktop-hide {
            display: none !important;
        }
    }
    @media (max-width: 768px) {
        #portfolioGrid .ox-portfolio-card.ox-limit-mobile-hide {
            display: none !important;
        }
    }

    /* ─── Browse All Projects CTA Button ─── */
    .ox-portfolio-browse-wrap {
        text-align: center;
        margin-top: 48px;
        position: relative;
        z-index: 5;
    }
    .ox-btn-browse-portfolio {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        background: linear-gradient(135deg, rgba(12, 32, 50, 0.95) 0%, rgba(6, 17, 28, 0.98) 100%);
        border: 1px solid rgba(189, 255, 69, 0.35);
        color: #ffffff;
        padding: 15px 36px;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4), 0 0 24px rgba(189, 255, 69, 0.12);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .ox-btn-browse-portfolio .btn-sparkle-dot {
        color: var(--lime, #bdff45);
        font-size: 14px;
        animation: pulseSparkle 2s infinite ease-in-out;
    }
    .ox-btn-browse-portfolio .btn-arrow-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: rgba(189, 255, 69, 0.15);
        color: var(--lime, #bdff45);
        transition: transform 0.3s ease, background 0.3s ease, color 0.3s ease;
    }
    .ox-btn-browse-portfolio:hover {
        background: linear-gradient(135deg, rgba(189, 255, 69, 0.2) 0%, rgba(10, 31, 51, 0.98) 100%);
        border-color: var(--lime, #bdff45);
        color: #ffffff;
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 32px rgba(189, 255, 69, 0.3);
    }
    .ox-btn-browse-portfolio:hover .btn-arrow-wrap {
        background: var(--lime, #bdff45);
        color: #05121e;
        transform: translateX(4px);
    }
    html[dir="rtl"] .ox-btn-browse-portfolio:hover .btn-arrow-wrap {
        transform: translateX(-4px);
    }
    @keyframes pulseSparkle {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.85); }
    }
    @media (max-width: 680px) {
        .ox-portfolio-browse-wrap {
            margin-top: 32px;
        }
        .ox-btn-browse-portfolio {
            width: 100%;
            justify-content: center;
            padding: 13px 20px;
            font-size: 14px;
        }
    }

    /* ─── Phone & Country Code Picker ─── */
    .ox-phone-group {
        position: relative;
        margin-bottom: 12px;
        width: 100%;
    }
    .ox-phone-input-wrap {
        display: flex;
        align-items: center;
        width: 100%;
        height: 46px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        transition: all 0.25s ease;
        box-sizing: border-box;
    }
    .ox-phone-input-wrap:focus-within {
        border-color: #1D8A68;
        background: rgba(255, 255, 255, 0.07);
        box-shadow: 0 0 0 3px rgba(0, 229, 155, 0.16);
    }
    .ox-phone-country-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 100%;
        padding: 0 12px;
        background: transparent;
        border: none;
        cursor: pointer;
        color: #ffffff;
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 600;
        flex-shrink: 0;
        outline: none;
        transition: background 0.2s ease;
    }
    .ox-phone-country-btn:hover {
        background: rgba(255, 255, 255, 0.05);
    }
    .ox-phone-flag-img {
        width: 22px;
        height: 15px;
        object-fit: cover;
        border-radius: 3px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.4);
        flex-shrink: 0;
    }
    .ox-phone-dial-text {
        font-family: 'SF Mono', Monaco, Consolas, monospace;
        font-size: 13px;
        color: #1D8A68;
        letter-spacing: 0.5px;
    }
    .ox-phone-chevron {
        color: #79988e;
        transition: transform 0.25s ease;
        flex-shrink: 0;
    }
    .ox-phone-country-btn.active .ox-phone-chevron {
        transform: rotate(180deg);
        color: #1D8A68;
    }
    .ox-phone-divider {
        width: 1px;
        height: 22px;
        background: rgba(255, 255, 255, 0.12);
        flex-shrink: 0;
    }
    .ox-phone-raw-input {
        flex: 1;
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        color: #ffffff;
        font-family: inherit;
        font-size: 13.5px;
        padding: 0 14px;
        box-sizing: border-box;
    }
    html[dir="rtl"] .ox-phone-raw-input {
        text-align: right;
        direction: ltr;
    }
    html[dir="ltr"] .ox-phone-raw-input {
        text-align: left;
        direction: ltr;
    }
    .ox-phone-raw-input::placeholder {
        color: #6d8a81;
    }

    /* Country Dropdown */
    .ox-country-picker-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        z-index: 120;
        background: rgba(9, 24, 20, 0.98);
        border: 1px solid rgba(0, 229, 155, 0.35);
        border-radius: 14px;
        box-shadow: 0 18px 50px rgba(0, 0, 0, 0.8), 0 0 30px rgba(0, 229, 155, 0.12);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        display: none;
        overflow: hidden;
        animation: oxPickerFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .ox-country-picker-dropdown.show {
        display: block;
    }
    @keyframes oxPickerFade {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .ox-country-search-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.02);
    }
    .ox-country-search-icon {
        color: #6d8a81;
        flex-shrink: 0;
    }
    .ox-country-search-input {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        color: #ffffff;
        font-family: inherit;
        font-size: 13px;
    }
    .ox-country-search-input::placeholder {
        color: #6d8a81;
        font-size: 12.5px;
    }
    .ox-country-options-list {
        max-height: 220px;
        overflow-y: auto;
        padding: 6px 0;
        scrollbar-width: thin;
        scrollbar-color: rgba(0, 229, 155, 0.3) transparent;
    }
    .ox-country-options-list::-webkit-scrollbar {
        width: 6px;
    }
    .ox-country-options-list::-webkit-scrollbar-thumb {
        background: rgba(0, 229, 155, 0.3);
        border-radius: 4px;
    }
    .ox-country-option-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 9px 14px;
        background: transparent;
        border: none;
        cursor: pointer;
        color: #e2e8f0;
        font-family: inherit;
        font-size: 13px;
        transition: background 0.15s ease, color 0.15s ease;
        text-align: inherit;
    }
    .ox-country-option-item:hover {
        background: rgba(0, 229, 155, 0.12);
        color: #ffffff;
    }
    .ox-country-option-item.selected {
        background: rgba(0, 229, 155, 0.18);
        color: #1D8A68;
        font-weight: 700;
    }
    .ox-country-option-left {
        display: flex;
        align-items: center;
        gap: 10px;
        overflow: hidden;
    }
    .ox-country-option-flag {
        width: 20px;
        height: 14px;
        object-fit: cover;
        border-radius: 2px;
        flex-shrink: 0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    .ox-country-option-name {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .ox-country-option-dial {
        font-family: 'SF Mono', Monaco, Consolas, monospace;
        font-size: 12px;
        color: #1D8A68;
        letter-spacing: 0.5px;
        flex-shrink: 0;
        margin-left: 8px;
    }
    html[dir="rtl"] .ox-country-option-dial {
        margin-left: 0;
        margin-right: 8px;
    }
    .ox-country-no-results {
        padding: 16px 14px;
        text-align: center;
        color: #8fa099;
        font-size: 12.5px;
    }
</style>
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
        const toShow = [];
        document.querySelectorAll('.reveal:not(.visible)').forEach(el => {
            if (el.getBoundingClientRect().top <= threshold) {
                toShow.push(el);
            }
        });
        toShow.forEach(el => el.classList.add('visible'));
    }

    if (window.requestIdleCallback) {
        requestIdleCallback(() => ensureRevealed());
    } else {
        setTimeout(ensureRevealed, 100);
    }
    window.addEventListener('scroll', () => {
        requestAnimationFrame(ensureRevealed);
    }, { passive: true });
    window.addEventListener('resize', () => {
        requestAnimationFrame(ensureRevealed);
    }, { passive: true });
    // Ultimate fail-safe: reveal everything after 2s in case observer is blocked
    setTimeout(() => { document.querySelectorAll('.reveal').forEach(el => el.classList.add('visible')); }, 2000);

    // 2. Smart Client-Friendly Portfolio Filter (Live Search + Sector Tabs + Country Flags Strip)
    let currentPortfolioCat = 'all';
    let currentPortfolioCountry = 'all';
    let currentPortfolioSearch = '';

    window.handlePortfolioSearch = function(query) {
        currentPortfolioSearch = (query || '').trim().toLowerCase();
        const clearBtn = document.getElementById('portfolioSearchClear');
        if (clearBtn) {
            clearBtn.style.display = currentPortfolioSearch.length > 0 ? 'inline-flex' : 'none';
        }
        applyPortfolioFilters();
    };

    window.clearPortfolioSearch = function() {
        const input = document.getElementById('portfolioSmartSearch');
        if (input) input.value = '';
        currentPortfolioSearch = '';
        const clearBtn = document.getElementById('portfolioSearchClear');
        if (clearBtn) clearBtn.style.display = 'none';
        applyPortfolioFilters();
    };

    window.selectPortfolioSector = function(sectorSlug, btn) {
        currentPortfolioCat = sectorSlug;
        document.querySelectorAll('.portfolio-sector-tab, .portfolio-cat-btn').forEach(t => t.classList.remove('active'));
        if (btn) btn.classList.add('active');
        applyPortfolioFilters();
    };

    window.toggleOtherCountriesDropdown = function(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        const menu = document.getElementById('otherCountriesMenu');
        const btn = document.getElementById('otherCountriesBtn');
        if (!menu) return;
        menu.classList.toggle('show');
        if (btn) btn.classList.toggle('open');
    };

    window.closeOtherCountriesDropdown = function() {
        const menu = document.getElementById('otherCountriesMenu');
        const btn = document.getElementById('otherCountriesBtn');
        if (menu) menu.classList.remove('show');
        if (btn) btn.classList.remove('open');
    };

    window.selectPortfolioCountry = function(code, name, flagUrl, isFromOtherMenu = false) {
        currentPortfolioCountry = code;

        // Toggle active states
        document.querySelectorAll('.country-flag-strip-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.other-country-item').forEach(b => b.classList.remove('active'));

        const otherBtn = document.getElementById('otherCountriesBtn');
        const otherLabel = document.getElementById('otherCountriesLabel');
        const otherAvatar = document.getElementById('otherCountriesAvatar');

        if (code === 'all') {
            const allBtn = document.getElementById('flagBtnAll');
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
            const activeItem = document.querySelector(`.other-country-item[data-country="${code}"]`);
            if (activeItem) activeItem.classList.add('active');
        } else {
            const stripBtn = document.getElementById(`flagBtn_${code}`);
            if (stripBtn) stripBtn.classList.add('active');
            if (otherLabel) otherLabel.textContent = '{{ $locale === 'ar' ? 'دول اخرى' : ($locale === 'fr' ? 'Autres pays' : 'Other countries') }}';
            if (otherAvatar) otherAvatar.innerHTML = '<span class="other-count-text">{{ $otherCountries->count() }}+</span>';
        }

        closeOtherCountriesDropdown();
        applyPortfolioFilters();
    };

    window.applyPortfolioFilters = function() {
        const isMobile = window.innerWidth <= 768;
        const maxDisplayLimit = isMobile ? 6 : 9;
        const cards = document.querySelectorAll('#portfolioGrid .ox-portfolio-card');
        let visibleCount = 0;
        let matchedSoFar = 0;

        const hasActiveFilter = (currentPortfolioCat !== 'all' || currentPortfolioCountry !== 'all' || currentPortfolioSearch.length > 0);
        const resetBtn = document.getElementById('portfolioResetBtn');
        if (resetBtn) {
            resetBtn.style.display = hasActiveFilter ? 'inline-flex' : 'none';
        }

        cards.forEach(card => {
            card.classList.remove('ox-limit-desktop-hide', 'ox-limit-mobile-hide');

            const cardCat = card.getAttribute('data-category') || '';
            const cardCountry = (card.getAttribute('data-country') || '').toLowerCase();
            const cardSearch = (card.getAttribute('data-search') || '').toLowerCase();

            const matchCat = (currentPortfolioCat === 'all' || cardCat === currentPortfolioCat);
            const matchCountry = (currentPortfolioCountry === 'all' || cardCountry === currentPortfolioCountry);
            const matchSearch = (!currentPortfolioSearch || cardSearch.includes(currentPortfolioSearch));

            if (matchCat && matchCountry && matchSearch) {
                matchedSoFar++;
                if (matchedSoFar <= maxDisplayLimit) {
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
                        card.style.display = 'none';
                    }, 200);
                }
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

        const browseWrap = document.getElementById('portfolioBrowseWrap');
        if (browseWrap) {
            browseWrap.style.display = visibleCount === 0 ? 'none' : 'block';
        }
    };

    window.filterPortfolio = function(type, value, btn) {
        if (type === 'cat') {
            selectPortfolioSector(value, btn);
        } else if (type === 'country') {
            selectPortfolioCountry(value, value, null);
        } else {
            applyPortfolioFilters();
        }
    };

    window.resetPortfolioFilter = function() {
        currentPortfolioCat = 'all';
        currentPortfolioCountry = 'all';
        currentPortfolioSearch = '';
        
        const searchInput = document.getElementById('portfolioSmartSearch');
        if (searchInput) searchInput.value = '';
        const searchClear = document.getElementById('portfolioSearchClear');
        if (searchClear) searchClear.style.display = 'none';

        document.querySelectorAll('.portfolio-sector-tab, .portfolio-cat-btn').forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-cat') === 'all');
        });

        selectPortfolioCountry('all', '{{ $locale === 'ar' ? 'كل الدول' : ($locale === 'fr' ? 'Tous les pays' : 'All Countries') }}', null);
    };

    document.addEventListener('click', function(e) {
        const wrap = document.getElementById('otherCountriesWrap');
        if (wrap && !wrap.contains(e.target)) {
            closeOtherCountriesDropdown();
        }
    });

    let portfolioResizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(portfolioResizeTimer);
        portfolioResizeTimer = setTimeout(function() {
            applyPortfolioFilters();
        }, 150);
    });

    // Initial filter execution to apply default all countries filter
    applyPortfolioFilters();

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
            if (!vid.src && vid.dataset.src) {
                vid.src = vid.dataset.src;
                vid.load();
            }
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
        const nameInput = document.getElementById('inline_consult_name') || document.getElementById('consult_name');
        if (nameInput) {
            nameInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => {
                nameInput.focus();
                nameInput.style.borderColor = '#1D8A68';
                nameInput.style.boxShadow = '0 0 0 4px rgba(0, 229, 155, 0.25)';
                setTimeout(() => {
                    nameInput.style.borderColor = '';
                    nameInput.style.boxShadow = '';
                }, 1800);
            }, 350);
        }
    }
    window.focusConsultForm = focusConsultForm;

    // 6.5 Country Code Picker & Phone Sync
    const countryPickerToggleBtn = document.getElementById('countryPickerToggleBtn');
    const countryPickerDropdown = document.getElementById('countryPickerDropdown');
    const countrySearchInput = document.getElementById('countrySearchInput');
    const consultPhoneRaw = document.getElementById('consult_phone_raw');
    const consultFullPhone = document.getElementById('consultFullPhone');
    const selectedDialCode = document.getElementById('selectedDialCode');
    const selectedCountryFlag = document.getElementById('selectedCountryFlag');
    const selectedCountryDial = document.getElementById('selectedCountryDial');

    function toggleCountryPicker(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        if (!countryPickerDropdown) return;
        const isOpen = countryPickerDropdown.classList.contains('show');
        if (isOpen) {
            closeCountryPicker();
        } else {
            countryPickerDropdown.classList.add('show');
            if (countryPickerToggleBtn) {
                countryPickerToggleBtn.classList.add('active');
                countryPickerToggleBtn.setAttribute('aria-expanded', 'true');
            }
            if (countrySearchInput) {
                countrySearchInput.value = '';
                filterCountryOptions('');
                setTimeout(() => countrySearchInput.focus(), 60);
            }
        }
    }
    window.toggleCountryPicker = toggleCountryPicker;

    function closeCountryPicker() {
        if (!countryPickerDropdown) return;
        countryPickerDropdown.classList.remove('show');
        if (countryPickerToggleBtn) {
            countryPickerToggleBtn.classList.remove('active');
            countryPickerToggleBtn.setAttribute('aria-expanded', 'false');
        }
    }
    window.closeCountryPicker = closeCountryPicker;

    function selectCountryCode(code, dial, name, flagUrl) {
        if (selectedCountryFlag) {
            selectedCountryFlag.src = flagUrl;
            selectedCountryFlag.alt = name;
        }
        if (selectedCountryDial) {
            selectedCountryDial.textContent = dial;
        }
        if (selectedDialCode) {
            selectedDialCode.value = dial;
        }

        document.querySelectorAll('.ox-country-option-item').forEach(item => {
            if (item.getAttribute('data-code') === code) {
                item.classList.add('selected');
            } else {
                item.classList.remove('selected');
            }
        });

        syncConsultPhone();
        closeCountryPicker();
        if (consultPhoneRaw) {
            consultPhoneRaw.focus();
        }
    }
    window.selectCountryCode = selectCountryCode;

    function filterCountryOptions(query) {
        const q = (query || '').trim().toLowerCase();
        const items = document.querySelectorAll('.ox-country-option-item');
        const noResults = document.getElementById('countryNoResults');
        let visibleCount = 0;

        items.forEach(item => {
            const nameAr = (item.getAttribute('data-name-ar') || '').toLowerCase();
            const nameEn = (item.getAttribute('data-name-en') || '').toLowerCase();
            const dial = (item.getAttribute('data-dial') || '').toLowerCase();
            const code = (item.getAttribute('data-code') || '').toLowerCase();

            if (!q || nameAr.includes(q) || nameEn.includes(q) || dial.includes(q) || code.includes(q)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (noResults) {
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }
    window.filterCountryOptions = filterCountryOptions;

    function syncConsultPhone() {
        if (!consultPhoneRaw || !consultFullPhone || !selectedDialCode) return;
        const raw = consultPhoneRaw.value.trim();
        if (raw.length > 0) {
            consultFullPhone.value = `${selectedDialCode.value} ${raw}`;
        } else {
            consultFullPhone.value = '';
        }
    }
    window.syncConsultPhone = syncConsultPhone;

    if (consultPhoneRaw) {
        consultPhoneRaw.addEventListener('input', syncConsultPhone);
    }

    document.addEventListener('click', function(e) {
        const group = document.getElementById('consultPhoneGroup');
        if (group && !group.contains(e.target)) {
            closeCountryPicker();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCountryPicker();
        }
    });

    // 7. Consultation Form AJAX submission
    const inlineForm = document.getElementById('inlineConsultationForm');
    const inlineSubmitBtn = document.getElementById('inlineSubmitBtn');
    const inlineFormContent = document.getElementById('inlineFormContent');
    const inlineSuccessBox = document.getElementById('inlineSuccessBox');

    if (inlineForm) {
        inlineForm.addEventListener('submit', function(e) {
            e.preventDefault();
            syncConsultPhone();

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
        if (consultPhoneRaw) consultPhoneRaw.value = '';
        if (consultFullPhone) consultFullPhone.value = '';
        closeCountryPicker();
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
@endpush
