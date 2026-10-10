@extends('layouts.app')

@php
    $currentLang = in_array($locale ?? app()->getLocale(), ['ar', 'en', 'fr']) ? ($locale ?? app()->getLocale()) : 'ar';
    $isRtl = $currentLang === 'ar';

    // Multilingual Content Dictionary
    $t = [
        'ar' => [
            'meta_title' => 'تواصل معنا | احجز استشارة تقنية وهندسية معتمدة — OX Tech',
            'meta_desc' => 'تواصل مباشرة مع مهندسي ومستشاري أوكس تك في الرياض، القاهرة، ودبي. احجز جلستك لمناقشة مشروعك مع اتفاقية سرية (NDA) ودراسة جدوى مجانية.',
            'badge' => '✦ استشارة تقنية وهندسية معتمدة • الرياض • القاهرة • دبي',
            'title_start' => 'دعنا نحوّل رؤيتك التقنية إلى',
            'title_highlight' => 'واقع رقمي فائق الأداء',
            'subtitle' => 'جلسة مباشرة لمدة 30 دقيقة مع كبار مهندسينا لمناقشة متطلبات مشروعك، الجدوى التقنية، واقتراح أفضل خارطة طريق ومعمارية برمجية سحابية مخصصة.',
            'feat_1' => 'رد مباشر خلال ساعتين عمل',
            'feat_2' => 'سرية تامة (اتفاقية NDA)',
            'feat_3' => 'استشارة مباشرة مع كبار المهندسين',
            'form_title' => 'املأ بيانات مشروعك لحجز الجلسة',
            'form_sub' => 'سيقوم مستشار تقني مختص بمراجعة طلبك وإعداد ملخص هندسي لمشروعك.',
            'name_label' => 'الاسم الكريم *',
            'name_ph' => 'مثال: سلطان القحطاني',
            'email_label' => 'البريد الإلكتروني المهني *',
            'email_ph' => 'ceo@company.sa',
            'phone_label' => 'رقم الجوال / واتساب *',
            'phone_ph' => '50 123 4567',
            'proj_type_label' => 'نوع المشروع التقني',
            'pref_label' => 'طريقة التواصل المفضلة:',
            'pref_wa' => 'واتساب (الأسرع)',
            'pref_call' => 'مكالمة هاتفية',
            'pref_meet' => 'اجتماع Google Meet / Zoom',
            'msg_label' => 'تفاصيل الفكرة أو المتطلبات الرئيسية *',
            'msg_ph' => 'أخبرنا باختصار عن فكرتك، الميزات الرئيسية المطلوبة، أو التحدي التقني الذي ترغب في حله...',
            'char_count' => 'حرف (الحد الأدنى 10)',
            'submit_btn' => 'تأكيد وحجز الاستشارة المجانية',
            'submitting' => 'جاري تأكيد حجزك...',
            'nda_note' => 'نلتزم بالسرية التامة للبيانات وفق أفضل المعايير المهنية (NDA)',
            'success_title' => 'تم استلام طلب استشارتك بنجاح! 🎉',
            'success_desc' => 'شكراً لثقتك بـ OX Tech. سيقوم أحد خبرائنا التقنيين بالتواصل معك خلال أقل من ساعتين عمل لمناقشة متطلبات مشروعك وتقديم دراسة الجدوى ومعمارية النظام.',
            'ref_num' => 'رقم الطلب المرجعي:',
            'wa_followup' => 'محادثة فورية مع المستشار عبر واتساب',
            'direct_channels' => 'قنوات التواصل المباشرة والتنفيذية',
            'direct_sub' => 'تواصل مباشرة مع فريقنا القيادي والهندسي للاستفسارات السريعة.',
            'wa_btn' => 'محادثة فورية عبر واتساب (رد فوري)',
            'call_btn' => 'اتصال هاتفي مباشر',
            'email_btn' => 'مراسلة عبر البريد الإلكتروني',
            'offices_title' => 'مكاتبنا الإقليمية المعتمدة',
            'offices_riyadh' => 'الرياض — المملكة العربية السعودية',
            'offices_dubai' => 'دبي — الإمارات العربية المتحدة',
            'offices_cairo' => 'القاهرة — جمهورية مصر العربية',
            'proj_types' => [
                'منصة وبوابة رقمية / ويب متطورة',
                'تطبيق جوال ذكي (iOS & Android)',
                'متجر إلكتروني بنظام تجارة حديث',
                'نظام ERP / CRM سحابي لإدارة الشركات',
                'حلول الذكاء الاصطناعي والأتمتة الذكية',
                'بنية تحتية سحابية وهندسة DevOps',
                'استشارة تقنية وهندسية عامة',
            ],
        ],
        'en' => [
            'meta_title' => 'Contact Us | Book an Executive Tech Discovery Session — OX Tech',
            'meta_desc' => 'Connect directly with OX Tech software architects in Riyadh, Cairo, and Dubai. Book a 30-min discovery session with strict NDA and tailored technical roadmap.',
            'badge' => '✦ Elite Software Engineering House • Riyadh • Cairo • Dubai',
            'title_start' => 'Let’s Transform Your Tech Vision Into',
            'title_highlight' => 'High-Performance Digital Reality',
            'subtitle' => 'A dedicated 30-minute discovery session with our principal engineers to evaluate your product requirements, technical feasibility, and enterprise cloud architecture roadmap.',
            'feat_1' => 'Direct response within 2 business hours',
            'feat_2' => 'Strict NDA Protection & Confidentiality',
            'feat_3' => 'Direct Advisory with Principal Engineers',
            'form_title' => 'Tell Us About Your Project to Book the Session',
            'form_sub' => 'A senior tech consultant will review your specifications and prepare an architectural brief.',
            'name_label' => 'Full Name *',
            'name_ph' => 'e.g. Alexander Wright',
            'email_label' => 'Business Email *',
            'email_ph' => 'ceo@company.com',
            'phone_label' => 'Mobile / WhatsApp *',
            'phone_ph' => '50 123 4567',
            'proj_type_label' => 'Project Classification',
            'pref_label' => 'Preferred Contact Channel:',
            'pref_wa' => 'WhatsApp (Fastest)',
            'pref_call' => 'Direct Phone Call',
            'pref_meet' => 'Google Meet / Zoom Call',
            'msg_label' => 'Project Specifications & Key Objectives *',
            'msg_ph' => 'Briefly describe your vision, core features required, or the engineering challenge you need solved...',
            'char_count' => 'characters (minimum 10)',
            'submit_btn' => 'Confirm & Book Free Discovery Session',
            'submitting' => 'Securing your session...',
            'nda_note' => 'Strict data confidentiality protected by mutual Non-Disclosure Agreement (NDA)',
            'success_title' => 'Your Consultation Request Has Been Received! 🎉',
            'success_desc' => 'Thank you for choosing OX Tech. One of our lead software architects will connect with you within 2 hours to confirm your meeting and review your technical roadmap.',
            'ref_num' => 'Reference ID:',
            'wa_followup' => 'Direct VIP Chat With Consultant on WhatsApp',
            'direct_channels' => 'Direct Executive Contact Channels',
            'direct_sub' => 'Need immediate answers? Connect directly with our regional leadership team.',
            'wa_btn' => 'Instant WhatsApp Hotline (Fast Reply)',
            'call_btn' => 'Direct Phone Dialing',
            'email_btn' => 'Executive Email Inquiries',
            'offices_title' => 'Regional Headquarters',
            'offices_riyadh' => 'Riyadh — Kingdom of Saudi Arabia',
            'offices_dubai' => 'Dubai — United Arab Emirates',
            'offices_cairo' => 'Cairo — Arab Republic of Egypt',
            'proj_types' => [
                'Custom Web Platform & Digital Portal',
                'Native Mobile Application (iOS & Android)',
                'Next-Gen E-Commerce Ecosystem',
                'Enterprise ERP / CRM Cloud System',
                'AI Engineering & Intelligent Automation',
                'Cloud Architecture & DevOps Migration',
                'General Tech Architecture Consultation',
            ],
        ],
        'fr' => [
            'meta_title' => 'Contactez-nous | Réservez une Session de Cadrage Technique — OX Tech',
            'meta_desc' => 'Échangez directement avec les architectes logiciels d’OX Tech à Riyad, Le Caire et Dubaï. Session de cadrage de 30 min avec accord NDA et feuille de route technique.',
            'badge' => '✦ Maison d’Ingénierie Logicielle de Premier Plan • Riyad • Le Caire • Dubaï',
            'title_start' => 'Transformons Votre Vision Technologique En',
            'title_highlight' => 'Une Réalité Numérique Haute Performance',
            'subtitle' => 'Une session stratégique de 30 minutes avec nos ingénieurs principaux pour évaluer vos spécifications, la faisabilité technique et concevoir votre architecture cloud.',
            'feat_1' => 'Réponse directe en moins de 2 heures ouvrées',
            'feat_2' => 'Confidentialité stricte garantie (Accord NDA)',
            'feat_3' => 'Échange direct avec des ingénieurs seniors',
            'form_title' => 'Décrivez Votre Projet pour Réserver la Session',
            'form_sub' => 'Un consultant technique senior examinera vos besoins et préparera une synthèse d’ingénierie.',
            'name_label' => 'Nom Complet *',
            'name_ph' => 'ex: Alexandre Dubois',
            'email_label' => 'Email Professionnel *',
            'email_ph' => 'direction@entreprise.fr',
            'phone_label' => 'Téléphone / WhatsApp *',
            'phone_ph' => '6 12 34 56 78',
            'proj_type_label' => 'Type de Projet Technologique',
            'pref_label' => 'Canal de Contact Préféré :',
            'pref_wa' => 'WhatsApp (Le plus rapide)',
            'pref_call' => 'Appel Téléphonique',
            'pref_meet' => 'Session Google Meet / Zoom',
            'msg_label' => 'Spécifications et Objectifs Clés *',
            'msg_ph' => 'Décrivez brièvement votre projet, les fonctionnalités requises ou le défi technique à relever...',
            'char_count' => 'caractères (minimum 10)',
            'submit_btn' => 'Confirmer et Réserver la Session Offerte',
            'submitting' => 'Confirmation en cours...',
            'nda_note' => 'Confidentialité absolue garantie par accord de non-divulgation (NDA)',
            'success_title' => 'Votre Demande a été Reçue avec Succès ! 🎉',
            'success_desc' => 'Merci de votre confiance. Un de nos architectes logiciels seniors prendra contact avec vous d’ici 2 heures ouvrées.',
            'ref_num' => 'N° de référence :',
            'wa_followup' => 'Échange Immédiat sur WhatsApp avec un Consultant',
            'direct_channels' => 'Canaux de Contact Directs et Exécutifs',
            'direct_sub' => 'Besoin d’un échange rapide ? Contactez directement nos équipes régionales.',
            'wa_btn' => 'Ligne WhatsApp Directe (Réponse Rapide)',
            'call_btn' => 'Appel Téléphonique Direct',
            'email_btn' => 'Demandes par Email Professionnel',
            'offices_title' => 'Bureaux Régionaux',
            'offices_riyadh' => 'Riyad — Royaume d’Arabie Saoudite',
            'offices_dubai' => 'Dubaï — Émirats Arabes Unis',
            'offices_cairo' => 'Le Caire — République Arabe d’Égypte',
            'proj_types' => [
                'Plateforme Web & Portail Numérique',
                'Application Mobile Native (iOS & Android)',
                'Écosystème E-Commerce Moderne',
                'Solution ERP / CRM Cloud Entreprise',
                'Ingénierie IA & Automatisation Intelligente',
                'Architecture Cloud & DevOps',
                'Conseil & Audit en Architecture Logicielle',
            ],
        ],
    ];

    $txt = $t[$currentLang] ?? $t['ar'];
    $phonePrimary = $siteSettings['contact_phone_primary'] ?? '+966 50 000 0000';
    $emailPrimary = $siteSettings['contact_email_primary'] ?? 'contact@oxtech.uk';
    $waPhone = preg_replace('/[^0-9]/', '', $phonePrimary);

    $contactCountries = [
        ['code' => 'sa', 'dial' => '+966', 'name_ar' => 'المملكة العربية السعودية', 'name_en' => 'Saudi Arabia', 'name_fr' => 'Arabie Saoudite'],
        ['code' => 'ae', 'dial' => '+971', 'name_ar' => 'الإمارات العربية المتحدة', 'name_en' => 'United Arab Emirates', 'name_fr' => 'Émirats Arabes Unis'],
        ['code' => 'eg', 'dial' => '+20',  'name_ar' => 'جمهورية مصر العربية', 'name_en' => 'Egypt', 'name_fr' => 'Égypte'],
        ['code' => 'kw', 'dial' => '+965', 'name_ar' => 'دولة الكويت', 'name_en' => 'Kuwait', 'name_fr' => 'Koweït'],
        ['code' => 'qa', 'dial' => '+974', 'name_ar' => 'دولة قطر', 'name_en' => 'Qatar', 'name_fr' => 'Qatar'],
        ['code' => 'bh', 'dial' => '+973', 'name_ar' => 'مملكة البحرين', 'name_en' => 'Bahrain', 'name_fr' => 'Bahreïn'],
        ['code' => 'om', 'dial' => '+968', 'name_ar' => 'سلطنة عُمان', 'name_en' => 'Oman', 'name_fr' => 'Oman'],
        ['code' => 'jo', 'dial' => '+962', 'name_ar' => 'المملكة الأردنية', 'name_en' => 'Jordan', 'name_fr' => 'Jordanie'],
        ['code' => 'iq', 'dial' => '+964', 'name_ar' => 'جمهورية العراق', 'name_en' => 'Iraq', 'name_fr' => 'Irak'],
        ['code' => 'gb', 'dial' => '+44',  'name_ar' => 'المملكة المتحدة', 'name_en' => 'United Kingdom', 'name_fr' => 'Royaume-Uni'],
        ['code' => 'us', 'dial' => '+1',   'name_ar' => 'الولايات المتحدة', 'name_en' => 'United States', 'name_fr' => 'États-Unis'],
        ['code' => 'fr', 'dial' => '+33',  'name_ar' => 'الجمهورية الفرنسية', 'name_en' => 'France', 'name_fr' => 'France'],
        ['code' => 'de', 'dial' => '+49',  'name_ar' => 'ألمانيا', 'name_en' => 'Germany', 'name_fr' => 'Allemagne'],
        ['code' => 'tr', 'dial' => '+90',  'name_ar' => 'تركيا', 'name_en' => 'Turkey', 'name_fr' => 'Turquie'],
        ['code' => 'ma', 'dial' => '+212', 'name_ar' => 'المملكة المغربية', 'name_en' => 'Morocco', 'name_fr' => 'Maroc'],
        ['code' => 'dz', 'dial' => '+213', 'name_ar' => 'الجمهورية الجزائرية', 'name_en' => 'Algeria', 'name_fr' => 'Algérie'],
        ['code' => 'tn', 'dial' => '+216', 'name_ar' => 'الجمهورية التونسية', 'name_en' => 'Tunisia', 'name_fr' => 'Tunisie'],
        ['code' => 'ly', 'dial' => '+218', 'name_ar' => 'دولة ليبيا', 'name_en' => 'Libya', 'name_fr' => 'Libye'],
        ['code' => 'ps', 'dial' => '+970', 'name_ar' => 'دولة فلسطين', 'name_en' => 'Palestine', 'name_fr' => 'Palestine'],
        ['code' => 'ye', 'dial' => '+967', 'name_ar' => 'الجمهورية اليمنية', 'name_en' => 'Yemen', 'name_fr' => 'Yémen'],
        ['code' => 'lb', 'dial' => '+961', 'name_ar' => 'الجمهورية اللبنانية', 'name_en' => 'Lebanon', 'name_fr' => 'Liban'],
        ['code' => 'ca', 'dial' => '+1',   'name_ar' => 'كندا', 'name_en' => 'Canada', 'name_fr' => 'Canada'],
        ['code' => 'es', 'dial' => '+34',  'name_ar' => 'إسبانيا', 'name_en' => 'Spain', 'name_fr' => 'Espagne'],
        ['code' => 'it', 'dial' => '+39',  'name_ar' => 'إيطاليا', 'name_en' => 'Italy', 'name_fr' => 'Italie'],
        ['code' => 'nl', 'dial' => '+31',  'name_ar' => 'هولندا', 'name_en' => 'Netherlands', 'name_fr' => 'Pays-Bas'],
        ['code' => 'ch', 'dial' => '+41',  'name_ar' => 'سويسرا', 'name_en' => 'Switzerland', 'name_fr' => 'Suisse'],
        ['code' => 'se', 'dial' => '+46',  'name_ar' => 'السويد', 'name_en' => 'Sweden', 'name_fr' => 'Suède'],
        ['code' => 'au', 'dial' => '+61',  'name_ar' => 'أستراليا', 'name_en' => 'Australia', 'name_fr' => 'Australie'],
        ['code' => 'in', 'dial' => '+91',  'name_ar' => 'الهند', 'name_en' => 'India', 'name_fr' => 'Inde'],
        ['code' => 'pk', 'dial' => '+92',  'name_ar' => 'باكستان', 'name_en' => 'Pakistan', 'name_fr' => 'Pakistan'],
        ['code' => 'my', 'dial' => '+60',  'name_ar' => 'ماليزيا', 'name_en' => 'Malaysia', 'name_fr' => 'Malaisie'],
        ['code' => 'sg', 'dial' => '+65',  'name_ar' => 'سنغافورة', 'name_en' => 'Singapore', 'name_fr' => 'Singapour'],
        ['code' => 'cn', 'dial' => '+86',  'name_ar' => 'الصين', 'name_en' => 'China', 'name_fr' => 'Chine'],
    ];

    $defaultCountry = $contactCountries[0]; // Saudi Arabia (+966)
    if ($currentLang === 'fr') {
        $defaultCountry = $contactCountries[11]; // France
    }
@endphp

@section('title', $txt['meta_title'])
@section('meta_description', $txt['meta_desc'])

@section('content')
<style>
/* ═══════════════════════════════════════════════════════════════════
   OX TECH CLEAN WHITE & LUXURY LIGHT CONTACT SUITE
   ═══════════════════════════════════════════════════════════════════ */
:root {
    --ox-white-bg: #F8FAFC;
    --ox-card-bg: #FFFFFF;
    --ox-border: #E2E8F0;
    --ox-border-focus: #006848;
    --ox-primary: #006848;
    --ox-primary-hover: #004D35;
    --ox-accent-light: #ECFDF5;
    --ox-text-heading: #0F172A;
    --ox-text-body: #334155;
    --ox-text-muted: #64748B;
    --ox-shadow-card: 0 10px 30px -5px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.02);
}

.ox-contact-page-wrapper {
    background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
    color: var(--ox-text-body);
    min-height: 100vh;
    padding: 35px 16px 80px;
    font-family: 'Alexandria', 'Cairo', system-ui, -apple-system, sans-serif;
    position: relative;
}

.ox-contact-container {
    max-width: 1140px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

/* ─── 1. TOP BAR WITH LANGUAGE SWITCHER ─── */
.ox-lang-pill-row {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
    margin-bottom: 25px;
}

.ox-lang-chip {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid var(--ox-border);
    background: #FFFFFF;
    color: var(--ox-text-muted);
}

.ox-lang-chip.active {
    background: var(--ox-primary);
    color: #FFFFFF;
    border-color: var(--ox-primary);
    box-shadow: 0 3px 10px rgba(0, 104, 72, 0.25);
}

.ox-lang-chip.inactive:hover {
    background: #F1F5F9;
    color: var(--ox-text-heading);
    border-color: #CBD5E1;
}

/* ─── 2. HERO HEADLINE (CLEAN & REDUCED NOISE) ─── */
.ox-contact-hero {
    text-align: center;
    max-width: 760px;
    margin: 0 auto 38px;
}

.ox-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 18px;
    background: var(--ox-accent-light);
    color: #065F46;
    border: 1px solid #A7F3D0;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 800;
    margin-bottom: 16px;
}

.ox-hero-title {
    font-size: 36px;
    font-weight: 900;
    color: var(--ox-text-heading);
    line-height: 1.35;
    margin-bottom: 14px;
    letter-spacing: -0.5px;
}

.ox-hero-highlight {
    color: var(--ox-primary);
}

.ox-hero-sub {
    font-size: 15.5px;
    color: var(--ox-text-muted);
    line-height: 1.65;
    margin: 0 auto 20px;
    max-width: 650px;
}

.ox-hero-pills {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}

.ox-pill-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: #FFFFFF;
    border: 1px solid var(--ox-border);
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    color: #475569;
}

.ox-pill-badge i {
    color: var(--ox-primary);
    font-size: 11px;
}

/* ─── 3. TWO-COLUMN SPLIT GRID ─── */
.ox-contact-grid {
    display: grid;
    grid-template-columns: 1.45fr 1fr;
    gap: 24px;
    align-items: start;
}

/* ─── 4. MAIN FORM CARD (CLEAN WHITE) ─── */
.ox-contact-card {
    background: var(--ox-card-bg);
    border: 1px solid var(--ox-border);
    border-radius: 20px;
    padding: 34px 32px 30px;
    box-shadow: var(--ox-shadow-card);
    transition: border-color 0.25s ease;
}

.ox-card-header {
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #F1F5F9;
}

.ox-card-header h3 {
    font-size: 20px;
    font-weight: 800;
    color: var(--ox-text-heading);
    margin: 0 0 6px;
}

.ox-card-header p {
    font-size: 13.5px;
    color: var(--ox-text-muted);
    margin: 0;
}

/* ─── Form Inputs System ─── */
.ox-form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 16px;
}

.ox-form-group {
    margin-bottom: 16px;
}

.ox-form-label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #1E293B;
    margin-bottom: 7px;
}

.ox-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.ox-input-icon {
    position: absolute;
    {{ $isRtl ? 'right: 14px;' : 'left: 14px;' }}
    color: #94A3B8;
    font-size: 13px;
    pointer-events: none;
}

.ox-input-field,
.ox-select-field,
.ox-textarea-field {
    width: 100%;
    background: #FFFFFF;
    border: 1px solid #CBD5E1;
    border-radius: 10px;
    color: #0F172A;
    font-family: inherit;
    font-size: 13.5px;
    padding: 10px 14px;
    transition: all 0.2s ease;
    box-sizing: border-box;
    outline: none;
}

.ox-input-wrapper .ox-input-field {
    {{ $isRtl ? 'padding-right: 38px;' : 'padding-left: 38px;' }}
}

.ox-input-field:focus,
.ox-select-field:focus,
.ox-textarea-field:focus {
    border-color: var(--ox-primary);
    box-shadow: 0 0 0 3px rgba(0, 104, 72, 0.12);
}

.ox-select-field {
    cursor: pointer;
    background-color: #FFFFFF;
}

.ox-phone-row {
    display: flex;
    gap: 8px;
    align-items: stretch;
    position: relative;
}

.ox-country-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #FFFFFF;
    border: 1px solid #CBD5E1;
    border-radius: 10px;
    padding: 9px 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
    user-select: none;
    font-family: inherit;
}

.ox-country-btn:hover,
.ox-country-btn.open {
    border-color: var(--ox-primary);
    background: #F8FAFC;
    box-shadow: 0 0 0 3px rgba(0, 104, 72, 0.1);
}

.ox-country-flag-img {
    width: 22px;
    height: 15px;
    object-fit: cover;
    border-radius: 2px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
    display: block;
}

.ox-country-dial-code {
    font-size: 13px;
    font-weight: 700;
    color: #0F172A;
    direction: ltr;
}

.ox-country-chevron {
    color: #94A3B8;
    transition: transform 0.2s ease;
}

.ox-country-btn.open .ox-country-chevron {
    transform: rotate(180deg);
}

/* Popover Country Dropdown */
.ox-country-popover {
    position: absolute;
    top: calc(100% + 6px);
    {{ $isRtl ? 'right: 0;' : 'left: 0;' }}
    width: 280px;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    box-shadow: 0 12px 32px rgba(15, 23, 42, 0.12);
    z-index: 100;
    display: none;
    flex-direction: column;
    overflow: hidden;
    animation: fadeIn 0.18s ease;
}

.ox-country-popover.open {
    display: flex;
}

.ox-country-search-wrap {
    padding: 8px 10px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    align-items: center;
    gap: 8px;
    background: #F8FAFC;
}

.ox-country-search-wrap svg {
    color: #94A3B8;
    flex-shrink: 0;
}

.ox-country-search-input {
    width: 100%;
    border: none;
    background: transparent;
    font-size: 12px;
    color: #0F172A;
    outline: none;
    font-family: inherit;
}

.ox-country-list {
    max-height: 220px;
    overflow-y: auto;
    padding: 4px;
}

.ox-country-item {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 10px;
    border: none;
    background: transparent;
    border-radius: 8px;
    cursor: pointer;
    font-family: inherit;
    transition: background 0.15s ease;
}

.ox-country-item:hover {
    background: #F1F5F9;
}

.ox-country-item.selected {
    background: #ECFDF5;
}

.ox-country-item-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.ox-country-item-flag {
    width: 20px;
    height: 14px;
    object-fit: cover;
    border-radius: 2px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.ox-country-item-name {
    font-size: 12px;
    font-weight: 600;
    color: #1E293B;
}

.ox-country-item-dial {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748B;
    direction: ltr;
}

.ox-country-no-results {
    padding: 16px;
    text-align: center;
    font-size: 12px;
    color: #94A3B8;
}

.ox-channel-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.ox-channel-option {
    cursor: pointer;
    display: block;
    margin: 0;
    user-select: none;
}

.ox-channel-option input[type="radio"] {
    display: none;
}

.ox-channel-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 8px;
    background: #FFFFFF;
    border: 1.5px solid var(--ox-border);
    border-radius: 14px;
    font-size: 12px;
    font-weight: 700;
    color: #1E293B;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    text-align: center;
    box-sizing: border-box;
    min-height: 94px;
    aspect-ratio: 1 / 0.88;
}

.ox-channel-label:hover {
    border-color: #CBD5E1;
    background: #F8FAFC;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
}

.ox-channel-option input[type="radio"]:checked + .ox-channel-label {
    background: #F0FDF4;
    border-color: #059669;
    color: #065F46;
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.16);
}

.ox-channel-icon-circle {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.ox-channel-option input[type="radio"]:checked + .ox-channel-label .ox-channel-icon-circle {
    background: #DCFCE7;
    color: #059669;
    transform: scale(1.05);
}

.ox-channel-name {
    font-size: 12px;
    font-weight: 700;
    color: inherit;
    line-height: 1.3;
}

.ox-textarea-field {
    min-height: 105px;
    resize: vertical;
    line-height: 1.6;
}

.ox-char-counter {
    font-size: 11px;
    color: var(--ox-text-muted);
    text-align: {{ $isRtl ? 'left' : 'right' }};
    margin-top: 4px;
}

.ox-submit-cta-btn {
    width: 100%;
    background: var(--ox-primary);
    color: #FFFFFF;
    border: none;
    border-radius: 10px;
    font-family: inherit;
    font-size: 15px;
    font-weight: 800;
    padding: 14px 20px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(0, 104, 72, 0.25);
    margin-top: 6px;
}

.ox-submit-cta-btn:hover {
    background: var(--ox-primary-hover);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(0, 104, 72, 0.35);
}

.ox-submit-cta-btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
}

.ox-nda-strip {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 14px;
    font-size: 11.5px;
    color: var(--ox-text-muted);
    text-align: center;
}

/* ─── 5. SIDEBAR CARD (UNCLUTTERED & DIRECT) ─── */
.ox-contact-sidebar {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.ox-side-card {
    background: var(--ox-card-bg);
    border: 1px solid var(--ox-border);
    border-radius: 20px;
    padding: 24px;
    box-shadow: var(--ox-shadow-card);
}

.ox-side-card h4 {
    font-size: 15px;
    font-weight: 800;
    color: var(--ox-text-heading);
    margin: 0 0 6px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ox-side-card p {
    font-size: 12.5px;
    color: var(--ox-text-muted);
    margin: 0 0 16px;
    line-height: 1.5;
}

.ox-hotline-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.ox-hotline-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    transition: all 0.2s ease;
    border: 1px solid var(--ox-border);
    background: #F8FAFC;
    color: var(--ox-text-heading);
}

.ox-hotline-btn:hover {
    background: #FFFFFF;
    border-color: #CBD5E1;
    transform: translateX({{ $isRtl ? '-3px' : '3px' }});
}

.ox-hotline-btn.ox-hotline-wa {
    background: #F0FDF4;
    border-color: #BBF7D0;
    color: #15803D;
}

.ox-hotline-btn.ox-hotline-wa:hover {
    background: #DCFCE7;
    border-color: #86EFAC;
}

.ox-offices-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.ox-office-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    background: #F8FAFC;
    border-radius: 8px;
    border: 1px solid #EDF2F7;
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
}

.ox-office-item .flag {
    font-size: 16px;
}

/* ─── 6. SUCCESS BANNER ─── */
.ox-success-banner {
    display: none;
    background: #ECFDF5;
    border: 1px solid #A7F3D0;
    border-radius: 14px;
    padding: 24px;
    text-align: center;
    margin-bottom: 20px;
    animation: fadeIn 0.3s ease;
}

.ox-success-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #059669;
    color: #FFFFFF;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 12px;
}

.ox-success-wa-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #25D366;
    color: #FFFFFF;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 800;
    text-decoration: none;
    margin-top: 14px;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25);
    transition: transform 0.2s ease;
}

.ox-success-wa-link:hover {
    transform: translateY(-1px);
    color: #FFFFFF;
}

/* ─── 7. RESPONSIVE DESIGN ─── */
@media (max-width: 992px) {
    .ox-contact-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .ox-hero-title {
        font-size: 30px;
    }
}

@media (max-width: 600px) {
    .ox-hero-title {
        font-size: 24px;
    }

    .ox-form-grid-2 {
        grid-template-columns: 1fr;
        gap: 0;
    }

    .ox-channel-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }

    .ox-channel-label {
        padding: 10px 4px;
        min-height: 80px;
        border-radius: 12px;
    }

    .ox-channel-icon-circle {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }

    .ox-channel-name {
        font-size: 10.5px;
    }

    .ox-contact-card {
        padding: 24px 18px 20px;
    }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="ox-contact-page-wrapper" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="ox-contact-container">

        {{-- 1. Language Switcher Pills --}}
        <div class="ox-lang-pill-row">
            <a href="{{ route('lang.switch', 'ar') }}" class="ox-lang-chip {{ $currentLang === 'ar' ? 'active' : 'inactive' }}">
                <span>🇸🇦</span>
                <span>العربية</span>
            </a>
            <a href="{{ route('lang.switch', 'en') }}" class="ox-lang-chip {{ $currentLang === 'en' ? 'active' : 'inactive' }}">
                <span>🇬🇧</span>
                <span>English</span>
            </a>
            <a href="{{ route('lang.switch', 'fr') }}" class="ox-lang-chip {{ $currentLang === 'fr' ? 'active' : 'inactive' }}">
                <span>🇫🇷</span>
                <span>Français</span>
            </a>
        </div>

        {{-- 2. Hero Section (Clean & Focused) --}}
        <div class="ox-contact-hero">


            <h1 class="ox-hero-title">
                {{ $txt['title_start'] }} <span class="ox-hero-highlight">{{ $txt['title_highlight'] }}</span>
            </h1>

            <p class="ox-hero-sub">
                {{ $txt['subtitle'] }}
            </p>

        </div>

        {{-- 3. Two-Column Split Architecture --}}
        <div class="ox-contact-grid">

            {{-- 3.A Main Luxury Consultation Form --}}
            <div class="ox-contact-card">
                <div class="ox-card-header">
                    <h3>{{ $txt['form_title'] }}</h3>
                    <p>{{ $txt['form_sub'] }}</p>
                </div>

                {{-- Success State Banner --}}
                <div id="contactSuccessState" class="ox-success-banner">
                    <div class="ox-success-icon">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 800; color: #065F46; margin-bottom: 6px;">
                        {{ $txt['success_title'] }}
                    </h3>
                    <p style="font-size: 13.5px; color: #334155; line-height: 1.6; max-width: 480px; margin: 0 auto 12px;">
                        {{ $txt['success_desc'] }}
                    </p>
                    <div style="font-size: 13px; color: #059669; font-weight: 800;" id="contactRefNumber">
                        {{ $txt['ref_num'] }} <span id="refCodeSpan">OX-2026</span>
                    </div>

                    <a id="waDirectFollowupBtn" href="https://wa.me/{{ $waPhone }}" target="_blank" class="ox-success-wa-link" onclick="trackWaEscalation()">
                        <i class="fa-brands fa-whatsapp" style="font-size: 17px;"></i>
                        <span>{{ $txt['wa_followup'] }}</span>
                    </a>
                </div>

                {{-- Interactive Form --}}
                <form id="oxContactForm" onsubmit="handleContactSubmit(event)">
                    @csrf

                    {{-- Anti-Spam Honeypots & Time Traps --}}
                    <input type="text" name="hp_check" value="" style="display:none !important;" tabindex="-1" autocomplete="off">
                    <input type="text" name="website_hp" value="" style="display:none !important;" tabindex="-1" autocomplete="off">
                    <input type="hidden" name="_form_load_time" value="{{ time() }}">
                    <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
                    <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
                    <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
                    <input type="hidden" name="referrer_url" value="{{ url()->previous() }}">

                    {{-- Row 1: Full Name & Business Email in 2 columns --}}
                    <div class="ox-form-grid-2">
                        <div class="ox-form-group">
                            <label class="ox-form-label">{{ $txt['name_label'] }}</label>
                            <div class="ox-input-wrapper">
                                <i class="fa-solid fa-user ox-input-icon"></i>
                                <input type="text" name="name" id="c_name" required placeholder="{{ $txt['name_ph'] }}" class="ox-input-field">
                            </div>
                        </div>

                        <div class="ox-form-group">
                            <label class="ox-form-label">{{ $txt['email_label'] }}</label>
                            <div class="ox-input-wrapper">
                                <i class="fa-solid fa-envelope ox-input-icon"></i>
                                <input type="email" name="email" id="c_email" required placeholder="{{ $txt['email_ph'] }}" class="ox-input-field">
                            </div>
                        </div>
                    </div>

                    {{-- Row 2: Phone with Country Code & Project Classification in 2 columns --}}
                    <div class="ox-form-grid-2">
                        <div class="ox-form-group">
                            <label class="ox-form-label">{{ $txt['phone_label'] }}</label>
                            <div class="ox-phone-row">
                                <button type="button" class="ox-country-btn" id="oxCountryBtn" onclick="toggleCountryDropdown(event)" aria-haspopup="listbox" aria-expanded="false" title="{{ $currentLang === 'ar' ? 'اختر الدولة' : 'Select Country' }}">
                                    <img id="oxSelectedFlagImg" src="{{ asset('assets/flags/' . $defaultCountry['code'] . '.webp') }}" alt="{{ $defaultCountry['name_en'] }}" class="ox-country-flag-img" width="22" height="15" loading="lazy">
                                    <span id="oxSelectedDialText" class="ox-country-dial-code">{{ $defaultCountry['dial'] }}</span>
                                    <svg class="ox-country-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 9l6 6 6-6"/>
                                    </svg>
                                </button>
                                <input type="hidden" name="country_code" id="c_country_code" value="{{ $defaultCountry['dial'] }}">

                                <div class="ox-input-wrapper" style="flex: 1;">
                                    <input type="tel" name="phone" id="c_phone" required placeholder="{{ $txt['phone_ph'] }}" class="ox-input-field">
                                </div>

                                {{-- Country Dropdown Popover --}}
                                <div class="ox-country-popover" id="oxCountryPopover" role="listbox">
                                    <div class="ox-country-search-wrap">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                        <input type="text" id="oxCountrySearchInput" class="ox-country-search-input" placeholder="{{ $currentLang === 'ar' ? 'ابحث باسم الدولة أو الكود...' : ($currentLang === 'fr' ? 'Rechercher pays ou code...' : 'Search country or code...') }}" autocomplete="off" oninput="filterCountryList(this.value)">
                                    </div>
                                    <div class="ox-country-list" id="oxCountryList">
                                        @foreach($contactCountries as $c)
                                            <button type="button" class="ox-country-item {{ $c['code'] === $defaultCountry['code'] ? 'selected' : '' }}" 
                                                data-code="{{ $c['code'] }}" 
                                                data-dial="{{ $c['dial'] }}" 
                                                data-name="{{ $currentLang === 'ar' ? $c['name_ar'] : ($currentLang === 'fr' ? $c['name_fr'] : $c['name_en']) }}" 
                                                onclick="selectContactCountry('{{ $c['code'] }}', '{{ $c['dial'] }}', '{{ asset('assets/flags/' . $c['code'] . '.webp') }}')">
                                                <span class="ox-country-item-left">
                                                    <img src="{{ asset('assets/flags/' . $c['code'] . '.webp') }}" class="ox-country-item-flag" width="20" height="14" alt="{{ $c['name_en'] }}" loading="lazy">
                                                    <span class="ox-country-item-name">{{ $currentLang === 'ar' ? $c['name_ar'] : ($currentLang === 'fr' ? $c['name_fr'] : $c['name_en']) }}</span>
                                                </span>
                                                <span class="ox-country-item-dial">{{ $c['dial'] }}</span>
                                            </button>
                                        @endforeach
                                        <div class="ox-country-no-results" id="oxCountryNoResults" style="display: none;">
                                            {{ $currentLang === 'ar' ? 'لا توجد نتائج مطابقة' : 'No matching results' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ox-form-group">
                            <label class="ox-form-label">{{ $txt['proj_type_label'] }}</label>
                            <select name="project_type" id="c_proj_type" class="ox-select-field">
                                @foreach($txt['proj_types'] as $ptype)
                                    <option value="{{ $ptype }}">{{ $ptype }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Preferred Contact Channel --}}
                    <div class="ox-form-group">
                        <label class="ox-form-label">{{ $txt['pref_label'] }}</label>
                        <div class="ox-channel-grid">
                            <label class="ox-channel-option">
                                <input type="radio" name="contact_preference" value="واتساب" checked>
                                <span class="ox-channel-label">
                                    <span class="ox-channel-icon-circle">
                                        <i class="fa-brands fa-whatsapp" style="color: #25d366; font-size: 19px;"></i>
                                    </span>
                                    <span class="ox-channel-name">{{ $txt['pref_wa'] }}</span>
                                </span>
                            </label>
                            <label class="ox-channel-option">
                                <input type="radio" name="contact_preference" value="مكالمة هاتفية">
                                <span class="ox-channel-label">
                                    <span class="ox-channel-icon-circle">
                                        <i class="fa-solid fa-phone" style="color: var(--ox-primary); font-size: 15px;"></i>
                                    </span>
                                    <span class="ox-channel-name">{{ $txt['pref_call'] }}</span>
                                </span>
                            </label>
                            <label class="ox-channel-option">
                                <input type="radio" name="contact_preference" value="اجتماع زوم / Google Meet">
                                <span class="ox-channel-label">
                                    <span class="ox-channel-icon-circle">
                                        <i class="fa-solid fa-video" style="color: #0284c7; font-size: 15px;"></i>
                                    </span>
                                    <span class="ox-channel-name">{{ $txt['pref_meet'] }}</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Project Details & Live Counter --}}
                    <div class="ox-form-group">
                        <label class="ox-form-label">{{ $txt['msg_label'] }}</label>
                        <textarea name="message" id="c_message" required minlength="10" maxlength="1000" placeholder="{{ $txt['msg_ph'] }}" class="ox-textarea-field" oninput="updateCharCount(this)"></textarea>
                        <div class="ox-char-counter">
                            <span id="charCountSpan">0</span> / 1000 {{ $txt['char_count'] }}
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" id="btnContactSubmit" class="ox-submit-cta-btn">
                        <span>{{ $txt['submit_btn'] }}</span>
                        <i class="fa-solid {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                    </button>

                    <div class="ox-nda-strip">
                        <i class="fa-solid fa-shield-halved" style="color: var(--ox-primary);"></i>
                        <span>{{ $txt['nda_note'] }}</span>
                    </div>
                </form>
            </div>

            {{-- 3.B Right Column: Executive Hotlines & Global Offices --}}
            <div class="ox-contact-sidebar">

                {{-- Direct Channels Card --}}
                <div class="ox-side-card">
                    <h4>
                        <i class="fa-solid fa-bolt" style="color: var(--ox-primary);"></i>
                        <span>{{ $txt['direct_channels'] }}</span>
                    </h4>
                    <p>{{ $txt['direct_sub'] }}</p>

                    <div class="ox-hotline-list">
                        <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode($currentLang === 'ar' ? 'مرحباً فريق OX Tech، أرغب بالتواصل المباشر مع استشاري بخصوص مشروع جديد.' : 'Hello OX Tech team, I would like to consult with an architect about a new software project.') }}" target="_blank" class="ox-hotline-btn ox-hotline-wa" onclick="trackWaDirectClick()">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fa-brands fa-whatsapp" style="font-size: 18px;"></i>
                                <span>{{ $txt['wa_btn'] }}</span>
                            </div>
                            <i class="fa-solid {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}" style="font-size: 11px;"></i>
                        </a>

                        <a href="tel:{{ preg_replace('/\s+/', '', $phonePrimary) }}" class="ox-hotline-btn">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-phone" style="color: var(--ox-primary); font-size: 14px;"></i>
                                <span>{{ $txt['call_btn'] }}</span>
                            </div>
                            <span style="font-size: 11px; color: var(--ox-text-muted);" dir="ltr">{{ $phonePrimary }}</span>
                        </a>

                        <a href="mailto:{{ $emailPrimary }}" class="ox-hotline-btn">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-envelope" style="color: var(--ox-primary); font-size: 14px;"></i>
                                <span>{{ $txt['email_btn'] }}</span>
                            </div>
                            <span style="font-size: 11px; color: var(--ox-text-muted);" dir="ltr">{{ $emailPrimary }}</span>
                        </a>
                    </div>
                </div>

                

            </div>

        </div>

    </div>
</div>

<script>
// ─── Live Character Counter ───
function updateCharCount(el) {
    const counter = document.getElementById('charCountSpan');
    if (counter) {
        counter.textContent = el.value.length;
    }
}

// ─── Meta Pixel Tracking Integrations ───
document.addEventListener('DOMContentLoaded', function() {
    if (typeof fbq === 'function') {
        fbq('track', 'PageView', {
            page_type: 'contact_page',
            locale: '{{ $currentLang }}'
        });
    }
});

function trackWaDirectClick() {
    if (typeof fbq === 'function') {
        fbq('track', 'Contact', {
            channel: 'whatsapp_direct',
            page: 'contact_page',
            locale: '{{ $currentLang }}'
        });
        fbq('trackCustom', 'WhatsAppDirectContact', {
            placement: 'contact_suite_sidebar'
        });
    }
}

function trackWaEscalation() {
    if (typeof fbq === 'function') {
        fbq('track', 'Contact', {
            channel: 'whatsapp_after_lead',
            page: 'contact_page_success'
        });
    }
}

// ─── AJAX Form Submission ───
async function handleContactSubmit(e) {
    e.preventDefault();
    const form = document.getElementById('oxContactForm');
    const submitBtn = document.getElementById('btnContactSubmit');
    const successBanner = document.getElementById('contactSuccessState');
    const refCodeSpan = document.getElementById('refCodeSpan');
    const waFollowupBtn = document.getElementById('waDirectFollowupBtn');

    if (!form) return;

    // Build Form Data with combined country code & phone
    const formData = new FormData(form);
    const countryCode = document.getElementById('c_country_code')?.value || '';
    const rawPhone = document.getElementById('c_phone')?.value || '';
    const combinedPhone = countryCode ? (countryCode + ' ' + rawPhone.trim()) : rawPhone.trim();
    formData.set('phone', combinedPhone);

    // Disable button & show spinner
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <i class="fa-solid fa-circle-notch fa-spin"></i>
            <span>{{ $txt['submitting'] }}</span>
        `;
    }

    try {
        const response = await fetch("{{ route('contact.store') }}", {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok && (data.success || data.message)) {
            // 1. Fire Meta Pixel Lead & ConsultationBooked Events
            if (typeof fbq === 'function') {
                fbq('track', 'Lead', {
                    content_name: 'consultation_request',
                    currency: 'USD',
                    value: 250.00
                });

                fbq('trackCustom', 'ConsultationBooked', {
                    locale: '{{ $currentLang }}',
                    project_type: formData.get('project_type'),
                    contact_channel: formData.get('contact_preference')
                });
            }

            // 2. Hide Form, Show Success State
            form.style.display = 'none';
            if (successBanner) {
                successBanner.style.display = 'block';
                successBanner.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            // 3. Dynamic Reference Number
            const generatedRef = 'OX-' + Math.floor(100000 + Math.random() * 900000);
            if (refCodeSpan) refCodeSpan.textContent = generatedRef;

            // 4. Update WhatsApp Followup Link
            if (waFollowupBtn) {
                const clientName = formData.get('name') || '';
                const waText = encodeURIComponent(
                    "{{ $currentLang === 'ar' ? 'مرحباً فريق أوكس تك، قمت للتو بتقديم طلب استشارة بالرقم المرجعي: ' : 'Hello OX Tech, I just submitted a consultation request with Reference: ' }}" + generatedRef + " ({{ $currentLang === 'ar' ? 'الاسم: ' : 'Name: ' }}" + clientName + ")"
                );
                waFollowupBtn.href = "https://wa.me/{{ $waPhone }}?text=" + waText;
            }

        } else {
            alert(data.message || 'حدث خطأ أثناء إرسال الطلب، يرجى المحاولة لاحقاً أو التواصل عبر واتساب مباشرة.');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `
                    <span>{{ $txt['submit_btn'] }}</span>
                    <i class="fa-solid {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                `;
            }
        }
    } catch (err) {
        console.error(err);
        alert('تعذر الاتصال بالخادم، يرجى المحاولة مجدداً أو مراسلتنا مباشرة عبر واتساب.');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <span>{{ $txt['submit_btn'] }}</span>
                <i class="fa-solid {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
            `;
        }
    }
}

// ─── Country Flag Picker JS Handlers ───
function toggleCountryDropdown(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    const btn = document.getElementById('oxCountryBtn');
    const pop = document.getElementById('oxCountryPopover');
    if (!pop) return;

    const isOpen = pop.classList.contains('open');
    if (isOpen) {
        pop.classList.remove('open');
        btn?.classList.remove('open');
    } else {
        pop.classList.add('open');
        btn?.classList.add('open');
        setTimeout(() => {
            document.getElementById('oxCountrySearchInput')?.focus();
        }, 50);
    }
}

function selectContactCountry(code, dial, flagUrl) {
    const flagImg = document.getElementById('oxSelectedFlagImg');
    const dialText = document.getElementById('oxSelectedDialText');
    const hiddenCode = document.getElementById('c_country_code');

    if (flagImg) flagImg.src = flagUrl;
    if (dialText) dialText.textContent = dial;
    if (hiddenCode) hiddenCode.value = dial;

    // Update selected class
    document.querySelectorAll('.ox-country-item').forEach(item => {
        item.classList.toggle('selected', item.dataset.code === code);
    });

    // Close popover
    document.getElementById('oxCountryPopover')?.classList.remove('open');
    document.getElementById('oxCountryBtn')?.classList.remove('open');
}

function filterCountryList(term) {
    const query = term.toLowerCase().trim();
    const items = document.querySelectorAll('.ox-country-item');
    let visibleCount = 0;

    items.forEach(item => {
        const name = (item.dataset.name || '').toLowerCase();
        const dial = (item.dataset.dial || '').toLowerCase();
        const matches = name.includes(query) || dial.includes(query);
        item.style.display = matches ? 'flex' : 'none';
        if (matches) visibleCount++;
    });

    const noResults = document.getElementById('oxCountryNoResults');
    if (noResults) {
        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }
}

// Close country popover when clicking anywhere outside
document.addEventListener('click', function(e) {
    const pop = document.getElementById('oxCountryPopover');
    const btn = document.getElementById('oxCountryBtn');
    if (pop && pop.classList.contains('open')) {
        if (!pop.contains(e.target) && !btn?.contains(e.target)) {
            pop.classList.remove('open');
            btn?.classList.remove('open');
        }
    }
});
</script>
@endsection
