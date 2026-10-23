@extends('layouts.app')

@php
    $effectivePrice = (float) ($product->sale_price ?: 200);
    $oldPrice = (float) ($product->price ?: 1000);
    $discountPct = round((($oldPrice - $effectivePrice) / $oldPrice) * 100);
    $productCurrency = 'ج.م';
    $waPhone = '201008616682';
    $pageTitle = 'Proposal Ox · أداة احترافية للفريلانسرز ومقدمي الخدمات | OX TECH';
    $pageDesc = 'اعمل عروض أسعار ومقترحات شغل بشكل احترافي، وخلّي العميل يشوف قيمة شغلك من أول صفحة. عرض الإطلاق بـ 200 جنيه فقط.';
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --po-charcoal: #0c1214;
            --po-dark-card: #141d20;
            --po-dark-border: #223035;
            --po-emerald: #10b981;
            --po-emerald-light: #34d399;
            --po-emerald-glow: rgba(16, 185, 129, 0.25);
            --po-text-white: #f8fafc;
            --po-text-muted: #94a3b8;
            --po-text-dim: #64748b;
            --po-accent-gold: #fbbf24;
        }

        #proposal-ox-page {
            font-family: 'Cairo', sans-serif;
            background: var(--po-charcoal);
            color: var(--po-text-white);
            direction: rtl;
            text-align: right;
            line-height: 1.7;
            overflow-x: hidden;
            padding-top: 80px;
        }

        #proposal-ox-page * {
            box-sizing: border-box;
        }

        .po-container {
            width: min(1180px, calc(100% - 36px));
            margin: auto;
        }

        /* ── Header Badge & Typography ── */
        .po-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 9999px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: var(--po-emerald-light);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 18px;
            backdrop-filter: blur(8px);
        }

        .po-kicker-fire {
            background: rgba(251, 191, 36, 0.12);
            border-color: rgba(251, 191, 36, 0.35);
            color: var(--po-accent-gold);
        }

        .po-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 12px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-weight: 800;
            font-size: 16px;
            text-decoration: none;
            box-shadow: 0 10px 25px var(--po-emerald-glow);
            transition: all 0.25s ease;
            cursor: pointer;
            border: none;
        }

        .po-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(16, 185, 129, 0.4);
            color: #ffffff;
        }

        .po-btn-outline {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--po-dark-border);
            color: var(--po-text-white);
            box-shadow: none;
        }

        .po-btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--po-emerald);
        }

        .po-btn-wa {
            background: #25d366;
            color: #ffffff;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.25);
        }

        .po-btn-wa:hover {
            background: #20ba59;
            box-shadow: 0 14px 30px rgba(37, 211, 102, 0.35);
        }

        .po-section {
            padding: 85px 0;
            position: relative;
        }

        .po-section-border {
            border-bottom: 1px solid var(--po-dark-border);
        }

        .po-title {
            font-size: clamp(26px, 3.5vw, 42px);
            font-weight: 900;
            line-height: 1.3;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .po-title em {
            font-style: normal;
            background: linear-gradient(120deg, #34d399, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .po-desc {
            color: var(--po-text-muted);
            font-size: 16px;
            max-width: 680px;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .po-center {
            text-align: center;
        }

        .po-center .po-desc {
            margin-left: auto;
            margin-right: auto;
        }

        /* ── Hero Section ── */
        .po-hero {
            padding: 40px 0 80px;
            background: radial-gradient(circle at 75% 20%, rgba(16, 185, 129, 0.12) 0%, transparent 50%),
                        radial-gradient(circle at 20% 80%, rgba(15, 23, 42, 0.6) 0%, transparent 50%);
        }

        .po-hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 45px;
            align-items: center;
        }

        .po-price-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: rgba(20, 29, 32, 0.9);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 12px;
            margin: 15px 0 25px;
        }

        .po-price-now {
            font-size: 26px;
            font-weight: 900;
            color: var(--po-emerald-light);
        }

        .po-price-old {
            text-decoration: line-through;
            color: var(--po-text-dim);
            font-size: 16px;
        }

        .po-price-save {
            background: var(--po-emerald);
            color: #0c1214;
            font-weight: 800;
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 6px;
        }

        /* ── Hero Interactive Mockup ── */
        .po-mockup {
            background: var(--po-dark-card);
            border: 1px solid var(--po-dark-border);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5), 0 0 40px rgba(16, 185, 129, 0.1);
            position: relative;
            transform: perspective(1000px) rotateY(-4deg) rotateX(2deg);
            transition: transform 0.4s ease;
        }

        .po-mockup:hover {
            transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
        }

        .po-mockup-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--po-dark-border);
            margin-bottom: 18px;
        }

        .po-mockup-dots {
            display: flex;
            gap: 6px;
        }

        .po-mockup-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #334155;
        }

        .po-mockup-dot.red { background: #ef4444; }
        .po-mockup-dot.yellow { background: #f59e0b; }
        .po-mockup-dot.green { background: #10b981; }

        .po-proposal-preview {
            background: #ffffff;
            color: #0f172a;
            border-radius: 12px;
            padding: 22px;
            font-size: 13px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .po-preview-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 12px;
            margin-bottom: 14px;
        }

        .po-preview-badge {
            background: #ecfdf5;
            color: #065f46;
            font-weight: 800;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 6px;
            border: 1px solid #a7f3d0;
        }

        .po-preview-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            font-size: 12px;
        }

        .po-preview-table th {
            background: #f8fafc;
            padding: 8px 10px;
            text-align: right;
            border-bottom: 1px solid #cbd5e1;
            color: #475569;
        }

        .po-preview-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
        }

        .po-preview-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            background: #f8fafc;
            border-radius: 8px;
            font-weight: 800;
            font-size: 14px;
            color: #0f172a;
        }

        /* ── Problems Grid ── */
        .po-problems-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 35px;
        }

        .po-problem-card {
            background: var(--po-dark-card);
            border: 1px solid var(--po-dark-border);
            border-radius: 16px;
            padding: 26px 20px;
            transition: transform 0.2s, border-color 0.2s;
            position: relative;
        }

        .po-problem-card:hover {
            transform: translateY(-4px);
            border-color: #ef4444;
        }

        .po-problem-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
            display: grid;
            place-items: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .po-problem-title {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .po-problem-text {
            font-size: 13.5px;
            color: var(--po-text-muted);
            line-height: 1.6;
        }

        /* ── Features Grid ── */
        .po-features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-top: 40px;
        }

        .po-feature-card {
            background: var(--po-dark-card);
            border: 1px solid var(--po-dark-border);
            border-radius: 18px;
            padding: 30px;
            display: flex;
            gap: 20px;
            transition: all 0.25s ease;
        }

        .po-feature-card:hover {
            border-color: var(--po-emerald);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .po-feature-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            border-radius: 14px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--po-emerald-light);
            display: grid;
            place-items: center;
            font-size: 24px;
        }

        .po-feature-content h3 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .po-feature-content p {
            font-size: 14px;
            color: var(--po-text-muted);
            margin: 0;
            line-height: 1.65;
        }

        /* ── Target Audience (Who is it for) ── */
        .po-audience-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 35px;
        }

        .po-audience-card {
            background: linear-gradient(145deg, #162226, #111a1d);
            border: 1px solid var(--po-dark-border);
            border-radius: 16px;
            padding: 26px 20px;
            text-align: center;
            transition: all 0.25s;
        }

        .po-audience-card:hover {
            border-color: var(--po-emerald);
            transform: translateY(-4px);
        }

        .po-audience-avatar {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.15);
            color: var(--po-emerald-light);
            display: grid;
            place-items: center;
            font-size: 22px;
        }

        .po-audience-card h4 {
            font-size: 16px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .po-audience-card p {
            font-size: 13px;
            color: var(--po-text-muted);
            margin: 0;
        }

        /* ── Pricing Section ── */
        .po-pricing-box {
            max-width: 680px;
            margin: 35px auto 0;
            background: linear-gradient(145deg, #182529, #121c1f);
            border: 2px solid var(--po-emerald);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4), 0 0 30px var(--po-emerald-glow);
            text-align: center;
            position: relative;
        }

        .po-pricing-badge {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #10b981, #059669);
            color: #ffffff;
            font-weight: 900;
            font-size: 12px;
            padding: 5px 20px;
            border-radius: 9999px;
            letter-spacing: 0.5px;
        }

        .po-pricing-amount {
            font-size: clamp(38px, 5vw, 56px);
            font-weight: 900;
            color: #ffffff;
            margin: 15px 0 6px;
        }

        .po-pricing-amount small {
            font-size: 20px;
            color: var(--po-emerald-light);
        }

        .po-pricing-check-list {
            list-style: none;
            padding: 0;
            margin: 25px 0 30px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            text-align: right;
        }

        .po-pricing-check-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14.5px;
            color: #e2e8f0;
        }

        .po-pricing-check-list i {
            color: var(--po-emerald-light);
            font-size: 16px;
        }

        /* ── FAQ Accordion ── */
        .po-faq-list {
            max-width: 780px;
            margin: 35px auto 0;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .po-faq-item {
            background: var(--po-dark-card);
            border: 1px solid var(--po-dark-border);
            border-radius: 14px;
            overflow: hidden;
            transition: border-color 0.2s;
        }

        .po-faq-item[open] {
            border-color: var(--po-emerald);
        }

        .po-faq-item summary {
            padding: 18px 22px;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #ffffff;
        }

        .po-faq-item summary::-webkit-details-marker {
            display: none;
        }

        .po-faq-item summary:after {
            content: '+';
            font-size: 22px;
            color: var(--po-emerald);
            transition: transform 0.2s;
        }

        .po-faq-item[open] summary:after {
            content: '−';
        }

        .po-faq-item p {
            padding: 0 22px 20px;
            margin: 0;
            color: var(--po-text-muted);
            font-size: 14px;
            line-height: 1.7;
        }

        /* ── Checkout Modal ── */
        .po-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            z-index: 99999;
            display: none;
            place-items: center;
            padding: 20px;
        }

        .po-modal-overlay.active {
            display: grid;
        }

        .po-modal-card {
            background: var(--po-dark-card);
            border: 1px solid var(--po-dark-border);
            border-radius: 20px;
            padding: 32px;
            width: min(520px, 100%);
            color: #ffffff;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
            position: relative;
        }

        .po-modal-close {
            position: absolute;
            top: 18px;
            left: 18px;
            background: none;
            border: none;
            color: var(--po-text-muted);
            font-size: 22px;
            cursor: pointer;
        }

        .po-input {
            width: 100%;
            padding: 12px 14px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--po-dark-border);
            border-radius: 10px;
            color: #ffffff;
            font-family: inherit;
            margin-bottom: 14px;
            font-size: 14px;
        }

        .po-input:focus {
            outline: none;
            border-color: var(--po-emerald);
        }

        @media (max-width: 900px) {
            .po-hero-grid, .po-features-grid {
                grid-template-columns: 1fr;
            }
            .po-problems-grid, .po-audience-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .po-mockup {
                transform: none;
            }
        }

        @media (max-width: 580px) {
            .po-problems-grid, .po-audience-grid {
                grid-template-columns: 1fr;
            }
            .po-pricing-box {
                padding: 25px 18px;
            }
        }
    </style>
@endpush

@section('content')
<main id="proposal-ox-page">

    <!-- ════════════ 1. الـ HERO SECTION ════════════ -->
    <section class="po-hero">
        <div class="po-container">
            <div class="po-hero-grid">
                
                <div class="po-hero-content">
                    <span class="po-kicker po-kicker-fire">
                        <i class="fa-solid fa-fire"></i> عرض إطلاق خاص لفترة محدودة · وفر 800 جنيه
                    </span>
                    
                    <h1 class="po-title">
                        شغلك يستاهل يتقدّم بشكل أحسن.<br>
                        <em>Proposal Ox</em>
                    </h1>

                    <p class="po-desc">
                        قدّم خدماتك باحتراف، وسيب انطباع يليق بقيمة شغلك. بدل ما تضيّع وقتك كل مرة في تنسيق عرض سعر أو كتابة مقترح من الصفر، استخدم Proposal Ox عشان تنظّم طريقة تقديم خدماتك وتظهر بصورة احترافية قدام عملائك.
                    </p>

                    <div class="po-price-badge">
                        <span class="po-price-now">200 جنيه</span>
                        <span class="po-price-old">1,000 جنيه</span>
                        <span class="po-price-save">خصم 80%</span>
                    </div>

                    <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                        <button type="button" class="po-btn" onclick="openProposalCheckout()">
                            <i class="fa-solid fa-cart-shopping"></i> احصل على Proposal Ox الآن — بـ 200 جنيه
                        </button>
                        <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode('مرحباً، أريد الاستفسار عن إضافة Proposal Ox بسعر الإطلاق 200 جنيه') }}" target="_blank" rel="noopener" class="po-btn po-btn-outline">
                            <i class="fa-brands fa-whatsapp"></i> تواصل عبر واتساب
                        </a>
                    </div>

                    <p style="font-size: 12.5px; color: var(--po-text-dim); margin-top: 14px;">
                        <i class="fa-solid fa-shield-check" style="color: var(--po-emerald);"></i> أداة مصممة لتسهيل تقديم عروضك المهنية، مع توضيح المميزات المتاحة قبل الشراء.
                    </p>
                </div>

                <!-- Visual Interactive Proposal Mockup -->
                <div class="po-mockup">
                    <div class="po-mockup-bar">
                        <div class="po-mockup-dots">
                            <span class="po-mockup-dot red"></span>
                            <span class="po-mockup-dot yellow"></span>
                            <span class="po-mockup-dot green"></span>
                        </div>
                        <span style="font-size: 11px; color: var(--po-text-muted); font-weight: 700;">Proposal Ox · Chrome Extension</span>
                    </div>

                    <div class="po-proposal-preview">
                        <div class="po-preview-header">
                            <div>
                                <h4 style="margin: 0; font-size: 15px; font-weight: 900; color: #0f172a;">عرض سعر وخدمات تطوير</h4>
                                <small style="color: #64748b;">العميل: شركة الأفق للحلول الرقمية</small>
                            </div>
                            <span class="po-preview-badge"><i class="fa-solid fa-check-circle"></i> جاهز للإرسال</span>
                        </div>

                        <p style="font-size: 11.5px; color: #475569; margin: 4px 0 10px;">
                            <strong>نطاق العمل:</strong> تصميم واجهة المستخدم، تطوير لوحة تحكم سحابية، والربط مع بوابات الدفع.
                        </p>

                        <table class="po-preview-table">
                            <thead>
                                <tr>
                                    <th>الخدمة / المخرجات</th>
                                    <th>المدة</th>
                                    <th>التكلفة</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>تصميم هوية وواجهة UI/UX</td>
                                    <td>5 أيام</td>
                                    <td>4,500 ج.م</td>
                                </tr>
                                <tr>
                                    <td>برمجة الواجهة وربط الـ API</td>
                                    <td>10 أيام</td>
                                    <td>9,000 ج.م</td>
                                </tr>
                                <tr>
                                    <td>اختبار وضمان تسليم</td>
                                    <td>مستمر</td>
                                    <td>مشمول</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="po-preview-total">
                            <span>إجمالي تكلفة المشروع:</span>
                            <span style="color: #059669; font-size: 15px;">13,500 ج.م</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════ 2. المشكلة — ليه محتاج Proposal Ox؟ ════════════ -->
    <section class="po-section po-section-border">
        <div class="po-container">
            <div class="po-center">
                <span class="po-kicker">المشكلة التي يواجهها كل مستقل</span>
                <h2 class="po-title">العميل مش بيشوف شغلك بس…<br>بيشوف كمان <em>طريقة تقديمك ليه</em></h2>
                <p class="po-desc">
                    تخيّل إنك خلّصت مكالمة مع عميل مهتم بخدماتك، وطلب منك عرض سعر. هتعمل إيه؟
                </p>
            </div>

            <div class="po-problems-grid">
                <div class="po-problem-card">
                    <div class="po-problem-icon"><i class="fa-solid fa-file-pen"></i></div>
                    <div class="po-problem-title">تفتح ملف قديم وتعدّل؟</div>
                    <div class="po-problem-text">البحث عن ملف وورد أو PDF قديم ومحاولة تعديل الأسماء بدون أخطاء.</div>
                </div>

                <div class="po-problem-card">
                    <div class="po-problem-icon"><i class="fa-solid fa-calculator"></i></div>
                    <div class="po-problem-title">تنسيق يدوي للأسعار؟</div>
                    <div class="po-problem-text">حسابات يدوية وإعادة صياغة بنود الخدمات كل مرة من الصفر.</div>
                </div>

                <div class="po-problem-card">
                    <div class="po-problem-icon"><i class="fa-solid fa-arrows-rotate"></i></div>
                    <div class="po-problem-title">تكرار نفس التفاصيل؟</div>
                    <div class="po-problem-text">إضاعة ساعات ثمينة مع كل عميل في كتابة نفس الشروط والملاحظات.</div>
                </div>

                <div class="po-problem-card">
                    <div class="po-problem-icon"><i class="fa-brands fa-whatsapp"></i></div>
                    <div class="po-problem-title">رسائل واتساب عشوائية؟</div>
                    <div class="po-problem-text">إرسال تفاصيل معقدة في رسالة طويلة تجعل العميل يتراجع أو يفاصل في السعر.</div>
                </div>
            </div>

            <div style="background: rgba(20, 29, 32, 0.6); border: 1px dashed var(--po-dark-border); border-radius: 14px; padding: 18px 24px; margin-top: 30px; text-align: center;">
                <p style="margin: 0; font-size: 15px; color: var(--po-text-white);">
                    💡 <strong>المشكلة مش في إنك مش محترف.</strong> المشكلة إن تجهيز العرض نفسه بياخد من وقتك ومجهودك أكتر مما يستحق. 
                    <span style="color: var(--po-emerald-light);">Proposal Ox تمنحك هذا الوقت للتركيز على شغلك الحقيقي.</span>
                </p>
            </div>
        </div>
    </section>

    <!-- ════════════ 3. الحل — إيه هو Proposal Ox؟ ════════════ -->
    <section class="po-section po-section-border">
        <div class="po-container">
            <div class="po-hero-grid" style="align-items: center;">
                <div>
                    <span class="po-kicker">الحل الذكي والمباشر</span>
                    <h2 class="po-title">كل عرض شغل يستحق<br><em>بداية احترافية</em></h2>
                    <p class="po-desc">
                        Proposal Ox إضافة متصفح عملية من <strong>OxTech</strong>، موجهة للفريلانسرز ومقدمي الخدمات والوكالات الصغيرة اللي عايزين يطوّروا طريقة تجهيز وتقديم عروضهم للعملاء.
                    </p>
                    <p class="po-desc" style="font-size: 14.5px;">
                        بدل العشوائية في تقديم الخدمات والأسعار، بنوفرلك تجربة منظمة تساعدك تعرض:
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px; color: #e2e8f0;">
                            <i class="fa-solid fa-circle-check" style="color: var(--po-emerald);"></i> تفاصيل وبنود الخدمة اللي بتقدمها بوضوح.
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; color: #e2e8f0;">
                            <i class="fa-solid fa-circle-check" style="color: var(--po-emerald);"></i> نطاق العمل والمخرجات المتفق عليها.
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; color: #e2e8f0;">
                            <i class="fa-solid fa-circle-check" style="color: var(--po-emerald);"></i> السعر والجدول الزمني للدفعات.
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; color: #e2e8f0;">
                            <i class="fa-solid fa-circle-check" style="color: var(--po-emerald);"></i> الملاحظات والشروط الخاصة بالمشروع لضمان حقك وحق العميل.
                        </div>
                    </div>
                </div>

                <div style="background: var(--po-dark-card); border: 1px solid var(--po-dark-border); border-radius: 20px; padding: 30px; text-align: center;">
                    <div style="width: 70px; height: 70px; border-radius: 20px; background: rgba(16, 185, 129, 0.15); color: var(--po-emerald); display: grid; place-items: center; font-size: 32px; margin: 0 auto 18px;">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 10px;">عروض تقنع العميل من أول نظرة</h3>
                    <p style="font-size: 14px; color: var(--po-text-muted); margin-bottom: 20px;">
                        العميل لما بيشوف عرض واضح ومنسق، بيفهم إنك شخص منظم بيحترم مواعيده وشغله، وبيبدأ النقاش من نقطة ثقة واضحة.
                    </p>
                    <button type="button" class="po-btn" style="width: 100%;" onclick="openProposalCheckout()">
                        احصل عليها بسعر 200 جنيه فقط
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ 4. المميزات الأساسية ════════════ -->
    <section class="po-section po-section-border">
        <div class="po-container">
            <div class="po-center">
                <span class="po-kicker">ماذا تقدم لك الإضافة؟</span>
                <h2 class="po-title">المميزات الأساسية المصممة <em>لإنتاجيتك</em></h2>
                <p class="po-desc">أدوات عملية تختصر مجهودك وتمنحك حضوراً تجارياً راقياً</p>
            </div>

            <div class="po-features-grid">
                <div class="po-feature-card">
                    <div class="po-feature-icon"><i class="fa-solid fa-list-check"></i></div>
                    <div class="po-feature-content">
                        <h3>عروض أسعار أكثر تنظيمًا</h3>
                        <p>رتّب خدماتك وأسعارك وتفاصيل المشروع في عرض واضح وسهل على العميل مراجعته دون تشتت.</p>
                    </div>
                </div>

                <div class="po-feature-card">
                    <div class="po-feature-icon"><i class="fa-solid fa-stopwatch"></i></div>
                    <div class="po-feature-content">
                        <h3>وقت أقل في التجهيز</h3>
                        <p>قلّل تكرار العمل اليدوي في تجهيز عروض متشابهة بنماذج مرتبة تنجز العرض في دقائق بدلاً من ساعات.</p>
                    </div>
                </div>

                <div class="po-feature-card">
                    <div class="po-feature-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="po-feature-content">
                        <h3>مناسبة لشغلك الحر</h3>
                        <p>سواء بتقدم تصميمات، برمجة، تسويق إلكتروني، كتابة محتوى أو خدمات استشارية متخصصة.</p>
                    </div>
                </div>

                <div class="po-feature-card">
                    <div class="po-feature-icon"><i class="fa-solid fa-tag"></i></div>
                    <div class="po-feature-content">
                        <h3>سعر يناسب السوق المصري</h3>
                        <p>سعر إطلاق 200 جنيه بدلًا من 1,000 جنيه، عشان تبدأ بأداة عملية بتكلفة بسيطة تعود عليك من أول مشروع.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ 5. مين هيستفيد من Proposal Ox؟ ════════════ -->
    <section class="po-section po-section-border">
        <div class="po-container">
            <div class="po-center">
                <span class="po-kicker">الفئات المستهدفة</span>
                <h2 class="po-title">مين هيستفيد من <em>Proposal Ox</em>؟</h2>
                <p class="po-desc">أداة مرنة تناسب تخصصك في العمل الحر والخدمات الرقمية</p>
            </div>

            <div class="po-audience-grid">
                <div class="po-audience-card">
                    <div class="po-audience-avatar"><i class="fa-solid fa-palette"></i></div>
                    <h4>مصممو الجرافيك والهوية</h4>
                    <p>قدّم تفاصيل التصميمات والباقات والمقاسات والتكلفة بطريقة مرتبة ومقنعة.</p>
                </div>

                <div class="po-audience-card">
                    <div class="po-audience-avatar"><i class="fa-solid fa-code"></i></div>
                    <h4>المبرمجون ومطورو المواقع</h4>
                    <p>وضّح نطاق المشروع البرمجي والمراحل والتكلفة المتوقعة بدقة تمنع سوء الفهم.</p>
                </div>

                <div class="po-audience-card">
                    <div class="po-audience-avatar"><i class="fa-solid fa-bullhorn"></i></div>
                    <h4>المسوقون وأصحاب الوكالات</h4>
                    <p>نظّم عروض إدارة السوشيال ميديا والإعلانات والخدمات التسويقية والتقارير الدورية.</p>
                </div>

                <div class="po-audience-card">
                    <div class="po-audience-avatar"><i class="fa-solid fa-handshake"></i></div>
                    <h4>الاستشاريون ومقدمو الخدمات</h4>
                    <p>اعرض نطاق الجلسات الاستشارية والتكلفة والتفاصيل المتفق عليها بأسلوب مهني.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ 6. السعر والعرض ════════════ -->
    <section class="po-section po-section-border" id="pricing-section">
        <div class="po-container">
            <div class="po-pricing-box">
                <span class="po-pricing-badge">PROPOSAL OX · LAUNCH OFFER</span>

                <h3 style="font-size: 24px; font-weight: 900; color: #ffffff; margin-top: 10px;">
                    ابدأ بتقديم عروضك بشكل احترافي
                </h3>

                <div class="po-pricing-amount">
                    200 <small>ج.م</small>
                </div>
                <div style="color: var(--po-text-dim); text-decoration: line-through; font-size: 18px; margin-bottom: 6px;">
                    1,000 ج.م
                </div>
                <div style="color: var(--po-emerald-light); font-weight: 800; font-size: 14px;">
                    خصم 80% · توفير فوري 800 جنيه
                </div>

                <ul class="po-pricing-check-list">
                    <li><i class="fa-solid fa-check-circle"></i> ترخيص النسخة الحالية للأداة لاستخدامك الشخصي.</li>
                    <li><i class="fa-solid fa-check-circle"></i> توثيق ودليل سريع للتثبيت على متصفح Google Chrome.</li>
                    <li><i class="fa-solid fa-check-circle"></i> دعم فني مباشر عبر واتساب عند وجود أي استفسار في التثبيت.</li>
                    <li><i class="fa-solid fa-check-circle"></i> تحديثات التحسينات والإصلاحات الخاصة بالإصدار.</li>
                </ul>

                <button type="button" class="po-btn" style="width: 100%; font-size: 18px;" onclick="openProposalCheckout()">
                    اطلب الإضافة الآن بـ 200 جنيه فقط
                </button>
            </div>
        </div>
    </section>

    <!-- ════════════ 7. ليه تختار منتج من OxTech؟ ════════════ -->
    <section class="po-section po-section-border">
        <div class="po-container">
            <div class="po-hero-grid" style="align-items: center;">
                <div>
                    <span class="po-kicker">عن المطور والشركة</span>
                    <h2 class="po-title">أداة عملية من شركة تقنية<br><em>بتفهم احتياجات الشغل</em></h2>
                    <p class="po-desc">
                        في <strong>OxTech</strong>، بنطوّر حلولاً تقنية تساعد أصحاب الأعمال ومقدمي الخدمات على تنظيم شغلهم وتحسين تجربتهم اليومية.
                    </p>
                    <p class="po-desc">
                        Proposal Ox جاية من نفس الفكرة: بدل ما تكون أدوات تنظيم العروض معقدة أو باشتراكات دولية مكلفة بالدولار للفريلانسر في بداية طريقه، هدفنا تقديم حل بسيط بسعر مناسب للسوق المصري.
                    </p>
                    <p style="font-size: 15px; color: var(--po-emerald-light); font-weight: 700;">
                        مش مطلوب منك تكون شركة كبيرة عشان تبدأ بشكل احترافي. ابدأ بإمكانياتك الحالية، وطوّر طريقة تقديم خدماتك خطوة بخطوة.
                    </p>
                </div>

                <div style="background: var(--po-dark-card); border: 1px solid var(--po-dark-border); border-radius: 20px; padding: 30px;">
                    <h4 style="font-size: 18px; font-weight: 800; margin-bottom: 14px; color: #ffffff;">اختبر العناوين التسويقية</h4>
                    <p style="font-size: 13.5px; color: var(--po-text-muted); margin-bottom: 15px;">
                        نسخ رسائل تسويقية جاهزة يمكنك استخدامها مع عملائك:
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <div style="padding: 10px 14px; background: rgba(0,0,0,0.25); border-radius: 8px; font-size: 13px; color: #cbd5e1;">
                            ✨ "عرضك هو أول انطباع عنك… خلّيه احترافي."
                        </div>
                        <div style="padding: 10px 14px; background: rgba(0,0,0,0.25); border-radius: 8px; font-size: 13px; color: #cbd5e1;">
                            ⚡ "بطل تبدأ كل عرض سعر من الصفر."
                        </div>
                        <div style="padding: 10px 14px; background: rgba(0,0,0,0.25); border-radius: 8px; font-size: 13px; color: #cbd5e1;">
                            🎯 "شغلك يستاهل عرض يليق بيه — دلوقتي بـ 200 جنيه."
                        </div>
                        <div style="padding: 10px 14px; background: rgba(0,0,0,0.25); border-radius: 8px; font-size: 13px; color: #cbd5e1;">
                            🤝 "من أول رسالة لأول اتفاق… نظّم تقديم خدماتك مع Proposal Ox."
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ 8. الأسئلة الشائعة FAQ ════════════ -->
    <section class="po-section po-section-border">
        <div class="po-container">
            <div class="po-center">
                <span class="po-kicker">إجابات واضحة</span>
                <h2 class="po-title">الأسئلة الشائعة <em>FAQ</em></h2>
                <p class="po-desc">كل ما تحتاج معرفته عن الأداة قبل الشراء</p>
            </div>

            <div class="po-faq-list">
                <details class="po-faq-item" open>
                    <summary>ما هي Proposal Ox؟</summary>
                    <p>إضافة متصفح من OxTech تهدف إلى تسهيل تنظيم وتجهيز عروض الأسعار والمقترحات المهنية لمقدمي الخدمات والفريلانسرز بطريقة مرتبة ومختصرة للوقت.</p>
                </details>

                <details class="po-faq-item">
                    <summary>هل تناسب المبتدئين والفريلانسرز؟</summary>
                    <p>نعم، مصممة خصيصاً لتكون بسيطة وسهلة ولا تتطلب أي خبرة تقنية أو تعقيدات برمجية.</p>
                </details>

                <details class="po-faq-item">
                    <summary>هل تعمل على متصفح Google Chrome؟</summary>
                    <p>نعم، تعمل الإضافة بشكل متوافق وسلس على متصفح Chrome والمتصفحات المبنية على Chromium مثل Microsoft Edge وBrave.</p>
                </details>

                <details class="po-faq-item">
                    <summary>هل السعر 200 جنيه نهائي؟</summary>
                    <p>نعم، الـ 200 جنيه هي سعر الإطلاق الخاص لفترة محددة بدلاً من 1,000 جنيه، ولا توجد أي مصاريف خفية إضافية لهذا الإصدار.</p>
                </details>

                <details class="po-faq-item">
                    <summary>كيف أحصل على الإضافة بعد الدفع؟</summary>
                    <p>بمجرد إتمام الدفع، يتم توجيهك لصفحة التحميل الفوري مع إرسال رابط التنزيل ودليل التثبيت السريع إلى بريدك الإلكتروني ورقم واتساب المسجل.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- ════════════ 9. الخاتمة — Final CTA ════════════ -->
    <section class="po-section" style="background: radial-gradient(circle at center, rgba(16, 185, 129, 0.12) 0%, transparent 60%);">
        <div class="po-container po-center">
            <span class="po-kicker">CREATE · SEND · WIN</span>
            <h2 class="po-title">خلّي كل عرض يعبّر عن <em>قيمة شغلك</em></h2>
            <p class="po-desc">
                ابدأ مع Proposal Ox، ونظّم طريقة تقديم خدماتك بسعر إطلاق مناسب ليك.
            </p>

            <div style="margin: 25px 0;">
                <div style="font-size: 32px; font-weight: 900; color: var(--po-emerald-light);">200 جنيه فقط</div>
                <div style="text-decoration: line-through; color: var(--po-text-dim); font-size: 16px;">بدلًا من 1,000 جنيه</div>
            </div>

            <button type="button" class="po-btn" style="font-size: 18px; padding: 16px 36px;" onclick="openProposalCheckout()">
                <i class="fa-solid fa-cart-shopping"></i> احصل على Proposal Ox الآن
            </button>
        </div>
    </section>

</main>

<!-- ════════════ Checkout & Order Modal ════════════ -->
<div class="po-modal-overlay" id="proposalCheckoutModal">
    <div class="po-modal-card">
        <button type="button" class="po-modal-close" onclick="closeProposalCheckout()">&times;</button>
        
        <h3 style="font-size: 20px; font-weight: 900; margin-bottom: 6px; color: #ffffff;">طلب إضافة Proposal Ox</h3>
        <p style="font-size: 13.5px; color: var(--po-text-muted); margin-bottom: 20px;">
            سعر الإطلاق الخاص: <strong style="color: var(--po-emerald-light);">200 ج.م</strong> بدل 1,000 ج.م
        </p>

        <form id="proposalOrderForm" onsubmit="handleProposalSubmit(event)">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id ?? 101 }}">
            <input type="hidden" name="currency" value="EGP">

            <label style="display: block; font-size: 13px; margin-bottom: 6px; color: #cbd5e1;">الاسم بالكامل:</label>
            <input type="text" name="customer_name" class="po-input" placeholder="مثال: أحمد محمد" required>

            <label style="display: block; font-size: 13px; margin-bottom: 6px; color: #cbd5e1;">البريد الإلكتروني (لاستلام الإضافة):</label>
            <input type="email" name="customer_email" class="po-input" placeholder="name@example.com" required>

            <label style="display: block; font-size: 13px; margin-bottom: 6px; color: #cbd5e1;">رقم الهاتف / الواتساب:</label>
            <input type="tel" name="customer_phone" class="po-input" placeholder="010XXXXXXXX" required>

            <button type="submit" class="po-btn" id="proposalSubmitBtn" style="width: 100%; margin-top: 10px;">
                <i class="fa-solid fa-bolt"></i> متابعة الدفع الفوري (200 ج.م)
            </button>

            <div style="text-align: center; margin-top: 16px;">
                <span style="font-size: 12px; color: var(--po-text-dim);">أو تواصل فوراً لتأكيد الدفع عبر إنستاباي / فودافون كاش:</span><br>
                <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode('أريد شراء Proposal Ox بـ 200 جنيه عبر فودافون كاش / إنستاباي') }}" target="_blank" rel="noopener" style="color: #25d366; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-top: 6px;">
                    <i class="fa-brands fa-whatsapp"></i> تحويل عبر إنستاباي أو المحفظة الإلكترونية
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openProposalCheckout() {
        document.getElementById('proposalCheckoutModal').classList.add('active');
    }

    function closeProposalCheckout() {
        document.getElementById('proposalCheckoutModal').classList.remove('active');
    }

    // Close on clicking outside
    document.getElementById('proposalCheckoutModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProposalCheckout();
        }
    });

    async function handleProposalSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const btn = document.getElementById('proposalSubmitBtn');
        const originalText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> جاري تهيئة الطلب...';

        const formData = new FormData(form);

        try {
            const response = await fetch("{{ route('checkout.initiate') }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const data = await response.json();

            if (data.success && data.payment_url) {
                window.location.href = data.payment_url;
            } else if (data.order_number) {
                window.location.href = "{{ url('/checkout/success') }}/" + data.order_number;
            } else {
                // If PaySky / direct payment is configured or fallback to WhatsApp confirmation
                const name = encodeURIComponent(form.customer_name.value);
                const email = encodeURIComponent(form.customer_email.value);
                const phone = encodeURIComponent(form.customer_phone.value);
                const waUrl = `https://wa.me/{{ $waPhone }}?text=${encodeURIComponent('تم تقديم طلب Proposal Ox بقيمة 200 جنيه:\nالاسم: ' + form.customer_name.value + '\nالإيميل: ' + form.customer_email.value + '\nالهاتف: ' + form.customer_phone.value)}`;
                window.location.href = waUrl;
            }
        } catch (err) {
            // Fallback gracefully to instant WhatsApp checkout
            const waUrl = `https://wa.me/{{ $waPhone }}?text=${encodeURIComponent('مرحباً، أريد شراء إضافة Proposal Ox بسعر الإطلاق 200 جنيه:\nالاسم: ' + form.customer_name.value + '\nالإيميل: ' + form.customer_email.value + '\nالهاتف: ' + form.customer_phone.value)}`;
            window.location.href = waUrl;
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }
</script>
@endpush
@endsection
