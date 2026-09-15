@extends('layouts.app')

@section('title', 'OX Tech | نبني ما يحرك عملك')

@section('content')
<main id="home">
    <!-- Hero Cinematic Slider Section -->
    <section class="hero" id="heroSection">
        <div class="hero-slider">
            <!-- Slide 1: Saudi Heritage & Digital Vision (Exact Replica of Reference Design) -->
            <div class="hero-slide active" data-slide="0">
                <div class="hero-slide-photo" style="background-image: url('{{ asset('assets/ox-hero-gathering.jpg') }}');"></div>
                <div class="hero-slide-overlay"></div>
                <div class="hero-copy">
                    <p class="hero-kicker-text">احتفال أصيل · 23 سبتمبر</p>
                    <h1 class="hero-title-main">
                        <span class="white-text">دارنا</span>
                        <span class="lime-text">تجمعنا</span>
                    </h1>
                    <p>حكاية وطن تنسجها التفاصيل، وترويها الأجيال بكل فخر.</p>
                    <div class="hero-actions">
                        <a class="hero-circle-btn" href="javascript:void(0)" onclick="openConsultModal()">
                            <span class="btn-circle-arrow">↓</span>
                            <span class="btn-text">اكتشف الحكاية</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Digital Growth & Innovation -->
            <div class="hero-slide" data-slide="1">
                <div class="hero-slide-photo" style="background-image: url('{{ asset('assets/ox-hero-skyline.jpg') }}');"></div>
                <div class="hero-slide-overlay"></div>
                <div class="hero-copy">
                    <p class="hero-kicker-text">رؤية رقمية · ابتكار مستمر</p>
                    <h1 class="hero-title-main">
                        <span class="white-text">نبني ما</span>
                        <span class="lime-text">يحرّك عملك</span>
                    </h1>
                    <p>شريكك التقني من الفكرة الأولى إلى منتج يخدم ملايين المستخدمين.</p>
                    <div class="hero-actions">
                        <a class="hero-circle-btn" href="#work">
                            <span class="btn-circle-arrow">↓</span>
                            <span class="btn-text">استكشف أعمالنا</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Software Solutions -->
            <div class="hero-slide" data-slide="2">
                <div class="hero-slide-photo" style="background-image: url('{{ asset('assets/ox-hero.png') }}');"></div>
                <div class="hero-slide-overlay"></div>
                <div class="hero-copy">
                    <p class="hero-kicker-text">حلول برمجية متكاملة · 2030</p>
                    <h1 class="hero-title-main">
                        <span class="white-text">حلول تصنع</span>
                        <span class="lime-text">الفارق</span>
                    </h1>
                    <p>أنظمة تشغيل وتجارب رقمية ومنصات تُصمم لتواكب طموحك.</p>
                    <div class="hero-actions">
                        <a class="hero-circle-btn" href="javascript:void(0)" onclick="openConsultModal()">
                            <span class="btn-circle-arrow">↓</span>
                            <span class="btn-text">احجز استشارة</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Vertical Scroll Prompt -->
        <div class="scroll-explore-indicator">
            <div class="scroll-line"><span class="scroll-dot"></span></div>
            <span class="scroll-text">اسحب للاستكشاف</span>
        </div>

        <!-- Slider Navigation & Dots -->
        <div class="hero-slider-nav">
            <button type="button" class="slider-arrow-btn" onclick="prevHeroSlide()" aria-label="الشريحة السابقة">←</button>
            <div class="slider-dots" id="heroSliderDots">
                <span class="slider-dot active" onclick="goToHeroSlide(0)"></span>
                <span class="slider-dot" onclick="goToHeroSlide(1)"></span>
                <span class="slider-dot" onclick="goToHeroSlide(2)"></span>
            </div>
            <button type="button" class="slider-arrow-btn" onclick="nextHeroSlide()" aria-label="الشريحة التالية">→</button>
        </div>

        <!-- Floating Proof Stats -->
        <div class="hero-proof">
            <span><b>+48</b> منتج أُطلق</span>
            <span><b>8</b> أسواق نخدمها</span>
            <span><b>4.9/5</b> رضا الشركاء</span>
        </div>
    </section>

    <!-- Brands & Partners Marquee Section (Two Opposite Moving Rows with Unified Monochrome Filter & Hover Glow) -->
    <section class="brands-marquee-section">
        <div class="brands-header reveal">
            <p class="kicker">TRUSTED BY LEADING BRANDS & VISIONARIES</p>
            <h3>موثوق من رواد الأعمال و<span>أكبر المنظومات الرقمية</span> في المنطقة</h3>
        </div>

        <div class="marquee-container">
            <!-- Row 1: Leftward Scroll (Moving Left) -->
            <div class="marquee-row" title="حرك الفأرة لإيقاف الحركة وإظهار الألوان الأصلية">
                <div class="marquee-track track-left">
                    @for($repeat = 0; $repeat < 2; $repeat++)
                        <!-- STC Pay -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10" stroke="#ff3366" stroke-width="2.5" fill="#4f008c"/>
                                    <circle cx="12" cy="12" r="4.5" fill="#ff3366"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">STC Pay</span>
                                <span class="brand-tag">البنك الرقمي والمدفوعات</span>
                            </div>
                        </div>

                        <!-- Jahez -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="12" fill="#e60028"/>
                                    <path d="M7 13C7 9.5 9.5 7 13 7C16.5 7 17 10 17 12C17 15.5 14.5 17 11 17H7V13Z" fill="#ffd700"/>
                                    <circle cx="12" cy="12" r="2" fill="#e60028"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">جاهز | Jahez</span>
                                <span class="brand-tag">المنصات واللوجستيات</span>
                            </div>
                        </div>

                        <!-- Mersal -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="6" fill="#00d084"/>
                                    <path d="M5 12L19 6L13 19L11 13L5 12Z" fill="#071827"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">مِرسال | Mersal</span>
                                <span class="brand-tag">سلاسل الإمداد الذكية</span>
                            </div>
                        </div>

                        <!-- Lucid Motors -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10" stroke="#e0e0e0" stroke-width="2" fill="#111"/>
                                    <path d="M6 12H18M7 9H17M8 15H16" stroke="#c9fa4b" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">Lucid Motors</span>
                                <span class="brand-tag">السيارات الكهربائية</span>
                            </div>
                        </div>

                        <!-- Aramco Ventures -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="6" fill="#00a3e0"/>
                                    <path d="M12 4L19 18H5L12 4Z" fill="#00843d"/>
                                    <circle cx="12" cy="13" r="3" fill="#ffffff"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">Aramco Ventures</span>
                                <span class="brand-tag">صندوق الابتكار التقني</span>
                            </div>
                        </div>

                        <!-- Tabby -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="6" fill="#3bffb1"/>
                                    <path d="M7 8H17M12 8V17" stroke="#000000" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">تابي | Tabby</span>
                                <span class="brand-tag">التقنية المالية والتسوق</span>
                            </div>
                        </div>

                        <!-- Elm -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10" fill="#005596"/>
                                    <path d="M8 8H16V10H10V11H15V13H10V16H8V8Z" fill="#ffffff"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">عِلـم | Elm</span>
                                <span class="brand-tag">الحلول الرقمية المتكاملة</span>
                            </div>
                        </div>

                        <!-- Nexa Cloud -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="6" fill="#1f63ff"/>
                                    <path d="M7 14C5.9 14 5 13.1 5 12C5 11 5.8 10.1 6.8 10C7.3 7.7 9.4 6 12 6C15 6 17.4 8.2 17.9 11.1C18.6 11.5 19 12.2 19 13C19 14.1 18.1 15 17 15H7" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">Nexa Cloud</span>
                                <span class="brand-tag">البنية السحابية وSaaS</span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Row 2: Rightward Scroll (Moving Opposite Direction) -->
            <div class="marquee-row" title="حرك الفأرة لإيقاف الحركة وإظهار الألوان الأصلية">
                <div class="marquee-track track-right">
                    @for($repeat = 0; $repeat < 2; $repeat++)
                        <!-- Tamara -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="12" fill="#ff6b00"/>
                                    <path d="M6 9H18M12 9V17" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"/>
                                    <circle cx="16" cy="15" r="2" fill="#ffe600"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">تمارا | Tamara</span>
                                <span class="brand-tag">حلول الدفع والتقسيط</span>
                            </div>
                        </div>

                        <!-- Foodics -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="6" fill="#6c2d82"/>
                                    <circle cx="12" cy="12" r="6" stroke="#ff2d55" stroke-width="3" fill="#ffffff"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">فودكس | Foodics</span>
                                <span class="brand-tag">إدارة المطاعم ونقاط البيع</span>
                            </div>
                        </div>

                        <!-- Mozn AI -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="6" fill="#1b1c3a"/>
                                    <circle cx="8" cy="8" r="3" fill="#00e5ff"/>
                                    <circle cx="16" cy="16" r="3" fill="#7b2cbf"/>
                                    <line x1="8" y1="8" x2="16" y2="16" stroke="#ffffff" stroke-width="2"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">مُزن | Mozn AI</span>
                                <span class="brand-tag">الذكاء الاصطناعي وأمن البيانات</span>
                            </div>
                        </div>

                        <!-- Lean Tech -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10" fill="#00473e"/>
                                    <path d="M7 16L12 7L17 16H7Z" fill="#a7f3d0"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">Lean Tech | لين</span>
                                <span class="brand-tag">الربط المالي والـ Open Banking</span>
                            </div>
                        </div>

                        <!-- Rased -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="6" fill="#0f2b3e"/>
                                    <circle cx="12" cy="12" r="7" stroke="#00ffff" stroke-width="2" stroke-dasharray="3 2"/>
                                    <circle cx="12" cy="12" r="2.5" fill="#c9fa4b"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">راصد | Rased</span>
                                <span class="brand-tag">أنظمة الرقابة والذكاء</span>
                            </div>
                        </div>

                        <!-- Bidayah -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="6" fill="#1b365d"/>
                                    <path d="M12 5L5 11V19H19V11L12 5Z" fill="#d9b56c"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">بِداية | Bidayah</span>
                                <span class="brand-tag">التمويل الرقمي العقاري</span>
                            </div>
                        </div>

                        <!-- Gobox Logistics -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="6" fill="#ff7a00"/>
                                    <path d="M6 9L12 5L18 9L12 13L6 9Z" fill="#ffffff"/>
                                    <path d="M6 11L12 15L18 11V15L12 19L6 15V11Z" fill="#2b1800"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">Gobox Logistics</span>
                                <span class="brand-tag">الشحن السريع واللوجستيات</span>
                            </div>
                        </div>

                        <!-- Al Rajhi Capital -->
                        <div class="brand-card">
                            <div class="brand-logo-box">
                                <svg class="brand-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="6" fill="#002b49"/>
                                    <path d="M8 17V7L12 11L16 7V17H14V11L12 13L10 11V17H8Z" fill="#c9fa4b"/>
                                </svg>
                            </div>
                            <div class="brand-info">
                                <span class="brand-name">الراجحي المالية</span>
                                <span class="brand-tag">إدارة الأصول والاستثمار</span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services section" id="services">
        <div class="intro reveal">
            <p class="kicker">WHAT WE DO</p>
            <h2>ليس مجرد كود.<br/><span>بل نظام ينمو معك.</span></h2>
        </div>
        <div class="service-list">
            <article class="reveal">
                <i>01</i>
                <h3>منصات ومواقع</h3>
                <p>مواقع شركات ومنصات حجز وتجارب رقمية سريعة، واضحة ومبنية للتحويل.</p>
                <a href="javascript:void(0)" onclick="openConsultModal()">اكتشف الخدمة ↗</a>
            </article>
            <article class="reveal">
                <i>02</i>
                <h3>متاجر إلكترونية</h3>
                <p>تجارة متعددة القنوات، دفع وشحن وتكاملات تناسب العميل الخليجي وتزيد المبيعات.</p>
                <a href="javascript:void(0)" onclick="openConsultModal()">اكتشف الخدمة ↗</a>
            </article>
            <article class="reveal">
                <i>03</i>
                <h3>تطبيقات ومنتجات</h3>
                <p>تطبيقات iOS وAndroid ولوحات تحكم وSaaS من الاستراتيجية إلى الإطلاق والدعم.</p>
                <a href="javascript:void(0)" onclick="openConsultModal()">اكتشف الخدمة ↗</a>
            </article>
            <article class="reveal">
                <i>04</i>
                <h3>إضافات وتكاملات</h3>
                <p>نربط أدوات عملك، نبني إضافات مخصصة، ونختصر الخطوات اليدوية المرهقة.</p>
                <a href="javascript:void(0)" onclick="openConsultModal()">اكتشف الخدمة ↗</a>
            </article>
        </div>
    </section>

    <!-- Works & Projects Section -->
    <section class="work section" id="work">
        <div class="work-top reveal">
            <div>
                <p class="kicker">SELECTED WORK</p>
                <h2>أعمالنا تتكلم<br/><span>بأثرها.</span></h2>
            </div>
            <p>فلتر المشاريع حسب السوق أو القطاع، واستكشف كيف حوّلنا التحديات التشغيلية إلى تجارب رقمية واضحة ومربحة.</p>
        </div>

        <div class="filters reveal">
            <div class="filter-group" id="countries">
                <button class="active" data-filter="all">كل الدول</button>
                @foreach($countries as $c)
                    <button data-filter="{{ $c->country_code }}">{{ $c->country_name }}</button>
                @endforeach
            </div>
            <div class="filter-group dark" id="sectors">
                <button class="active" data-sector="all">كل التخصصات</button>
                @foreach($sectors as $s)
                    <button data-sector="{{ $s->sector_slug }}">{{ $s->sector_name }}</button>
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
                            <small>{{ $project->country_name }} · {{ $project->sector_name }}</small>
                            <h3>{{ $project->short_description ?? $project->summary }}</h3>
                            @if($project->impact_stat)
                                <p>{{ $project->impact_stat }}</p>
                            @endif
                        </div>
                    </a>
                </article>
            @empty
                <p style="grid-column: 1/-1; text-align: center; color: #587069; padding: 40px;">لا توجد مشاريع مضافة حالياً.</p>
            @endforelse
        </div>
    </section>

    <!-- Models Section -->
    <section class="models section">
        <div class="intro reveal">
            <p class="kicker">BUILT FOR BOTH</p>
            <h2>نشتغل مع <span>B2B</span><br/>ونفهم <span>B2C.</span></h2>
        </div>
        <div class="model-grid">
            <article class="reveal">
                <span>B2B</span>
                <h3>نرتب العمل المعقد.</h3>
                <p>أنظمة داخلية، لوحات تحكم، منصات شركاء وتكاملات تجعل فرقك أسرع وأكثر وضوحًا.</p>
                <ul>
                    <li>تقليل العمل اليدوي</li>
                    <li>بيانات في مكان واحد</li>
                    <li>دعم نمو الفريق</li>
                </ul>
            </article>
            <article class="reveal">
                <span>B2C</span>
                <h3>نصنع تجربة يُحبها العميل.</h3>
                <p>متاجر وتطبيقات ومنتجات خفيفة وسريعة، من لحظة الاكتشاف وحتى عودة العميل.</p>
                <ul>
                    <li>تجربة شراء سلسة</li>
                    <li>هوية تترك أثرًا</li>
                    <li>تحويل ومبيعات أعلى</li>
                </ul>
            </article>
        </div>
    </section>

    <!-- Partner Stories / Testimonials Section (Saudi Sadu Aesthetic & Inline Video Player) -->
    <section class="testimonials section" id="stories">
        <!-- Sadu Corner Accents -->
        <svg class="sadu-corner top-right" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="16" y="0" width="8" height="8" fill="#c9fa4b"/>
            <rect x="0" y="16" width="8" height="8" fill="#c9fa4b"/>
            <rect x="32" y="16" width="8" height="8" fill="#c9fa4b"/>
            <rect x="16" y="32" width="8" height="8" fill="#c9fa4b"/>
            <rect x="16" y="16" width="8" height="8" fill="#ffffff"/>
            <rect x="8" y="8" width="8" height="8" fill="#9f99ec"/>
            <rect x="24" y="8" width="8" height="8" fill="#9f99ec"/>
            <rect x="8" y="24" width="8" height="8" fill="#9f99ec"/>
            <rect x="24" y="24" width="8" height="8" fill="#9f99ec"/>
        </svg>
        <svg class="sadu-corner top-left" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="16" y="0" width="8" height="8" fill="#c9fa4b"/>
            <rect x="0" y="16" width="8" height="8" fill="#c9fa4b"/>
            <rect x="32" y="16" width="8" height="8" fill="#c9fa4b"/>
            <rect x="16" y="32" width="8" height="8" fill="#c9fa4b"/>
            <rect x="16" y="16" width="8" height="8" fill="#ffffff"/>
            <rect x="8" y="8" width="8" height="8" fill="#9f99ec"/>
            <rect x="24" y="8" width="8" height="8" fill="#9f99ec"/>
            <rect x="8" y="24" width="8" height="8" fill="#9f99ec"/>
            <rect x="24" y="24" width="8" height="8" fill="#9f99ec"/>
        </svg>

        <div class="test-heading reveal">
            <div class="sadu-badge-wrap">
                <!-- Sadu Ribbon Pattern Left -->
                <svg width="60" height="14" viewBox="0 0 60 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0" y="4" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="6" y="0" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="6" y="8" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="12" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="18" y="4" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="24" y="0" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="24" y="8" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="30" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="36" y="4" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="42" y="0" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="42" y="8" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="48" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="54" y="4" width="6" height="6" fill="#c9fa4b"/>
                </svg>

                <p class="kicker">PARTNER STORIES</p>

                <!-- Sadu Ribbon Pattern Right -->
                <svg width="60" height="14" viewBox="0 0 60 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0" y="4" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="6" y="0" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="6" y="8" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="12" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="18" y="4" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="24" y="0" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="24" y="8" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="30" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="36" y="4" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="42" y="0" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="42" y="8" width="6" height="6" fill="#c9fa4b"/>
                    <rect x="48" y="4" width="6" height="6" fill="#ffffff"/>
                    <rect x="54" y="4" width="6" height="6" fill="#c9fa4b"/>
                </svg>
            </div>

            <h2>شركاؤنا<br/>هم <span>الـدليـل.</span></h2>
            <p>قصص حقيقية من شركاء بنوا معنا منتجات رقمية أحدثت نقلة نوعية في تجربة عملائهم ونمو أعمالهم.</p>
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
                                    <rect x="70" y="10" width="20" height="20" fill="#9f99ec"/>
                                    <rect x="70" y="130" width="20" height="20" fill="#9f99ec"/>
                                    <rect x="10" y="70" width="20" height="20" fill="#9f99ec"/>
                                    <rect x="130" y="70" width="20" height="20" fill="#9f99ec"/>

                                    <rect x="50" y="30" width="20" height="20" fill="#c9fa4b"/>
                                    <rect x="90" y="30" width="20" height="20" fill="#c9fa4b"/>
                                    <rect x="30" y="50" width="20" height="20" fill="#c9fa4b"/>
                                    <rect x="110" y="50" width="20" height="20" fill="#c9fa4b"/>
                                    <rect x="30" y="90" width="20" height="20" fill="#c9fa4b"/>
                                    <rect x="110" y="90" width="20" height="20" fill="#c9fa4b"/>
                                    <rect x="50" y="110" width="20" height="20" fill="#c9fa4b"/>
                                    <rect x="90" y="110" width="20" height="20" fill="#c9fa4b"/>

                                    <rect x="70" y="50" width="20" height="20" fill="#ffffff"/>
                                    <rect x="50" y="70" width="20" height="20" fill="#ffffff"/>
                                    <rect x="90" y="70" width="20" height="20" fill="#ffffff"/>
                                    <rect x="70" y="90" width="20" height="20" fill="#ffffff"/>
                                    <rect x="70" y="70" width="20" height="20" fill="#c9fa4b"/>
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
                                <div style="display:grid; place-items:center; height:100%; color:#c9fa4b; padding:20px; text-align:center;">
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
                <button id="story-prev" aria-label="القصة السابقة">←</button>
                <span><b id="story-count">01</b> / {{ sprintf('%02d', $testimonials->count()) }}</span>
                <button id="story-next" aria-label="القصة التالية">→</button>
            </div>
        @endif
    </section>

    <!-- About & Roots Section -->
    <section class="about section" id="about">
        <div class="about-visual reveal">
            <img src="{{ asset('assets/ox-saudi-story.png') }}" alt="بداية OX Tech في بيئة سعودية معاصرة"/>
            <div class="heritage-mark">جذور سعودية<br/><span>رؤية رقمية</span></div>
        </div>
        <div class="about-copy reveal">
            <p class="kicker">OUR STORY · ROOTED IN SAUDI</p>
            <h2>{{ $siteContents['about_story_title'] ?? 'بدأنا من السعودية. وكبرنا بثقة شركائنا.' }}</h2>
            <p>{{ $siteContents['about_story_p'] ?? 'في 2021 بدأنا كفريق صغير يؤمن أن التقنية لازم تفهم الناس والسوق قبل أي شيء. أول مشاريعنا كانت لفرق سعودية طموحة تحتاج حلولًا أسرع وأوضح—ومن هناك تعلّمنا أن أفضل المنتجات تبدأ من الاستماع الجيد.' }}</p>
            
            <div class="journey">
                <article>
                    <b>2021</b>
                    <div>
                        <strong>البداية في الرياض</strong>
                        <small>فريق صغير، أول شريك، ووعد واحد: نبني منتجًا يُعتمد عليه.</small>
                    </div>
                </article>
                <article>
                    <b>2023</b>
                    <div>
                        <strong>من فكرة إلى بيت برمجيات</strong>
                        <small>توسعنا في المتاجر والمنصات والتطبيقات لفرق في السعودية والإمارات ومصر.</small>
                    </div>
                </article>
                <article>
                    <b>اليوم</b>
                    <div>
                        <strong>شريك نمو طويل المدى</strong>
                        <small>ندعم الإطلاق، التشغيل، والتحسين المستمر لمنتجات تظل قوية مع نمو الأعمال.</small>
                    </div>
                </article>
            </div>

            <div class="numbers">
                <span><b>5+</b> سنوات خبرة</span>
                <span><b>48+</b> منتج أُطلق</span>
                <span><b>24/7</b> دعم فني</span>
            </div>
        </div>
    </section>

    <!-- Ultra-Luxurious Inline Consultation Section -->
    <section class="consult-section" id="consult">
        <div class="consult-wrap">
            <!-- Left Info Column -->
            <div class="consult-intro reveal">
                <p class="kicker" style="display: inline-flex; align-items: center; gap: 8px;">
                    <span style="width: 7px; height: 7px; border-radius: 50%; background: var(--lime); display: inline-block; box-shadow: 0 0 10px var(--lime);"></span>
                    LET'S BUILD SOMETHING GREAT
                </p>
                <h2>{{ $siteContents['consult_title'] ?? 'عندك فكرة؟' }}<br/><span>خلّينا نرتّبها ونبنيها.</span></h2>
                <div class="consult-direct-box">
                    <div class="direct-info">
                        <small>تفضل التواصل المباشر؟</small>
                        <strong>{{ $siteContents['contact_email'] ?? 'hello@oxtech.studio' }}</strong>
                    </div>
                    <a href="mailto:{{ $siteContents['contact_email'] ?? 'hello@oxtech.studio' }}" class="direct-btn">راسلنا إيميل ↗</a>
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
                            <span>01</span> اختر نوع المشروع أو الخدمة المطلوبة:
                        </div>
                        <div class="pills-grid" id="projectTypePills">
                            <button type="button" class="pill-btn active" data-val="منصات ومواقع">منصات ومواقع ويب</button>
                            <button type="button" class="pill-btn" data-val="متاجر إلكترونية">متجر إلكتروني متكامل</button>
                            <button type="button" class="pill-btn" data-val="تطبيقات ومنتجات">تطبيق جوال iOS / Android</button>
                            <button type="button" class="pill-btn" data-val="أنظمة SaaS مخصصة">نظام سحابي / SaaS</button>
                            <button type="button" class="pill-btn" data-val="تكاملات وأتمتة">تكاملات وأتمتة عمل</button>
                        </div>
                        <input type="hidden" name="project_type" id="selectedProjectType" value="منصات ومواقع">

                        <!-- Personal / Contact Details -->
                        <div class="form-section-title">
                            <span>02</span> بيانات التواصل الأساسية:
                        </div>
                        <div class="input-row">
                            <div class="consult-field">
                                <label>الاسم الكريم *</label>
                                <input type="text" name="name" class="consult-input" placeholder="مثال: عبدالله الراجحي" maxlength="70" required>
                            </div>
                            <div class="consult-field">
                                <label>رقم الجوال / واتساب *</label>
                                <input type="text" name="phone" class="consult-input" placeholder="+966 50 000 0000" dir="ltr" style="text-align: right;" maxlength="30" required>
                            </div>
                        </div>

                        <div class="input-row">
                            <div class="consult-field">
                                <label>البريد الإلكتروني *</label>
                                <input type="email" name="email" class="consult-input" placeholder="name@company.com" maxlength="100" required>
                            </div>
                            <div class="consult-field">
                                <label>اسم الشركة أو الجهة (اختياري)</label>
                                <input type="text" name="company_name" class="consult-input" placeholder="مثال: شركة نمو الرقمية" maxlength="100">
                            </div>
                        </div>

                        <!-- Budget Range Pills -->
                        <div class="form-section-title" style="margin-top: 10px;">
                            <span>03</span> الميزانية التقديرية المتوقعة:
                        </div>
                        <div class="pills-grid" id="budgetPills">
                            <button type="button" class="pill-btn" data-val="أقل من $10,000">أقل من $10k</button>
                            <button type="button" class="pill-btn active" data-val="$10,000 - $25,000">$10,000 - $25,000</button>
                            <button type="button" class="pill-btn" data-val="$25,000 - $50,000">$25,000 - $50,000</button>
                            <button type="button" class="pill-btn" data-val="أكثر من $50,000">أكثر من $50,000</button>
                        </div>
                        <input type="hidden" name="budget" id="selectedBudget" value="$10,000 - $25,000">

                        <!-- Message -->
                        <div class="consult-field">
                            <label>أخبرنا باختصار عن فكرتك أو التحدي التقني *</label>
                            <textarea name="message" class="consult-textarea" rows="3" placeholder="ما هو الهدف الأساسي من المشروع؟ ومن هم عملاؤك المستهدفون؟" minlength="10" maxlength="1000" required></textarea>
                            <div style="display: flex; justify-content: space-between; font-size: 11px; color: #8fa099; margin-top: 4px;">
                                <span>الحد الأدنى 10 أحرف</span>
                                <span id="inlineMsgCounter">0 / 1000 حرف</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="submit-consult-btn" id="inlineSubmitBtn">
                            <span>إرسال وتأكيد طلب الاستشارة</span>
                            <b style="font-size: 18px;">←</b>
                        </button>
                    </form>
                </div>

                <!-- Success Celebration Screen -->
                <div class="consult-success-box" id="inlineSuccessBox">
                    <div class="success-icon-badge">✓</div>
                    <h3>تم استلام طلبك بنجاح!</h3>
                    <p id="successMsgText">
                        شكرًا لاهتمامك بالعمل معنا. تم إرسال تفاصيل فكرتك إلى فريقنا التقني، وسيتواصل معك مهندس المشروع خلال 24 ساعة لترتيب موعد الاستشارة.
                    </p>
                    <button type="button" class="pill-btn active" onclick="resetInlineForm()" style="padding: 12px 28px; font-size: 12px;">
                        إرسال طلب استشارة آخر
                    </button>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

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
            inlineSubmitBtn.querySelector('span').textContent = 'جاري إرسال الطلب...';

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
                    alert('حدث خطأ أثناء الإرسال، يرجى التحقق من البيانات والمحاولة مجدداً.');
                    inlineSubmitBtn.disabled = false;
                    inlineSubmitBtn.querySelector('span').textContent = 'إرسال وتأكيد طلب الاستشارة';
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
            inlineSubmitBtn.querySelector('span').textContent = 'إرسال وتأكيد طلب الاستشارة';
        }
        const inlineCounter = document.getElementById('inlineMsgCounter');
        if (inlineCounter) inlineCounter.innerText = '0 / 1000 حرف';
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

    // Hero Slider Controller
    let currentHeroSlide = 0;
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroDots = document.querySelectorAll('#heroSliderDots .slider-dot');
    let heroSliderTimer = null;

    function showHeroSlide(idx) {
        if (!heroSlides.length) return;
        currentHeroSlide = (idx + heroSlides.length) % heroSlides.length;
        
        heroSlides.forEach((slide, i) => {
            if (i === currentHeroSlide) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        heroDots.forEach((dot, i) => {
            if (i === currentHeroSlide) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function nextHeroSlide() {
        showHeroSlide(currentHeroSlide + 1);
        resetHeroTimer();
    }

    function prevHeroSlide() {
        showHeroSlide(currentHeroSlide - 1);
        resetHeroTimer();
    }

    function goToHeroSlide(idx) {
        showHeroSlide(idx);
        resetHeroTimer();
    }

    function startHeroTimer() {
        if (heroSliderTimer) clearInterval(heroSliderTimer);
        heroSliderTimer = setInterval(() => {
            showHeroSlide(currentHeroSlide + 1);
        }, 6500);
    }

    function resetHeroTimer() {
        startHeroTimer();
    }

    // Pause slider on hover over hero section
    const heroSec = document.getElementById('heroSection');
    if (heroSec) {
        heroSec.addEventListener('mouseenter', () => {
            if (heroSliderTimer) clearInterval(heroSliderTimer);
        });
        heroSec.addEventListener('mouseleave', () => {
            startHeroTimer();
        });
    }

    // Start auto-play
    startHeroTimer();
</script>
@endpush
