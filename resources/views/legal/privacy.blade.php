@extends('layouts.app')

@php
    $currentLang = in_array($locale ?? app()->getLocale(), ['ar', 'en', 'fr']) ? ($locale ?? app()->getLocale()) : 'ar';
    $isRtl = $currentLang === 'ar';

    $content = [
        'ar' => [
            'meta_title' => 'سياسة الخصوصية الشاملة | OX Tech — برامج الديسكتوب، إضافات المتصفح، والمنصات السحابية',
            'meta_desc' => 'سياسة الخصوصية الرسمية لشركة OX Tech. توضح معايير الأمان وحماية البيانات لبرامج سطح المكتب (Desktop Apps)، إضافات واكستنشن المتصفح (Browser Extensions)، والحلول السحابية وفق لوائح PDPL و GDPR.',
            'badge' => 'وثيقة قانونية معتمدة • التحديث 3.2 • سارية المفعول',
            'hero_title' => 'سياسة الخصوصية وحماية البيانات',
            'hero_sub' => 'في OX Tech، نعتبر خصوصية بياناتك ركيزة هندسية أساسية وليست مجرد خيار إضافي. تغطي هذه الوثيقة برامج سطح المكتب (Desktop Apps)، إضافات واكستنشن المتصفح (Browser Extensions)، وموقعنا ومتجرنا الرقمي.',
            'last_updated' => 'آخر تحديث:',
            'last_updated_date' => '12 أكتوبر 2026',
            'quick_summary_title' => 'الضمانات الجوهرية لخصوصيتك في 4 مبادئ',
            'print_btn' => 'طباعة / حفظ كملف PDF',
            'filter_all' => 'عرض السياسة كاملة',
            'filter_desktop' => 'برامج الديسكتوب (Desktop)',
            'filter_extension' => 'إضافات واكستنشن المتصفح',
            'filter_store' => 'المتجر والويب',
            'filter_rights' => 'الحقوق والامتثال',
            'toc_title' => 'فهرس الأقسام',
            'dpo_title' => 'مسؤول حماية البيانات (DPO)',
            'dpo_desc' => 'فريقنا القانوني والأمني جاهز للرد على استفساراتك وطلبات ممارسة حقوقك.',
            'contact_btn' => 'تواصل مع إدارة الخصوصية',
        ],
        'en' => [
            'meta_title' => 'Comprehensive Privacy Policy | OX Tech — Desktop Apps, Extensions & Cloud Platforms',
            'meta_desc' => 'Official Privacy Policy of OX Tech detailing data protection standards for desktop applications, browser extensions, and cloud platforms compliant with PDPL, GDPR, and Chrome Web Store policies.',
            'badge' => 'Certified Legal Document • Version 3.2 • Effective',
            'hero_title' => 'Privacy & Data Protection Policy',
            'hero_sub' => 'At OX Tech, user privacy is an architectural foundation. This policy comprehensively covers our Desktop Software, Browser Extensions & Add-ons, and Web Store platforms.',
            'last_updated' => 'Last updated:',
            'last_updated_date' => 'October 12, 2026',
            'quick_summary_title' => 'Core Privacy Guarantees at a Glance',
            'print_btn' => 'Print / Save as PDF',
            'filter_all' => 'Complete Policy',
            'filter_desktop' => 'Desktop Software',
            'filter_extension' => 'Browser Extensions',
            'filter_store' => 'Web & Store',
            'filter_rights' => 'Rights & Compliance',
            'toc_title' => 'Table of Contents',
            'dpo_title' => 'Data Protection Officer (DPO)',
            'dpo_desc' => 'Our legal and security engineering team is available for all privacy requests.',
            'contact_btn' => 'Contact Privacy Team',
        ],
        'fr' => [
            'meta_title' => 'Politique de Confidentialité Complète | OX Tech — Logiciels Bureau, Extensions & Cloud',
            'meta_desc' => 'Politique officielle de confidentialité d\'OX Tech couvrant les logiciels de bureau, les extensions de navigateur et les plateformes cloud conformément au RGPD et aux règles du Chrome Web Store.',
            'badge' => 'Document Légal Officiel • Version 3.2 • En vigueur',
            'hero_title' => 'Politique de Confidentialité et Protection des Données',
            'hero_sub' => 'Chez OX Tech, la confidentialité est un pilier d\'ingénierie fondamental. Cette charte régit nos logiciels de bureau, extensions de navigateur et plateformes web.',
            'last_updated' => 'Dernière mise à jour :',
            'last_updated_date' => '12 Octobre 2026',
            'quick_summary_title' => 'Garanties Fondamentales de Confidentialité',
            'print_btn' => 'Imprimer / Enregistrer en PDF',
            'filter_all' => 'Politique Complète',
            'filter_desktop' => 'Logiciels Bureau',
            'filter_extension' => 'Extensions Navigateur',
            'filter_store' => 'Web & Boutique',
            'filter_rights' => 'Droits & Conformité',
            'toc_title' => 'Table des Matières',
            'dpo_title' => 'Délégué à la Protection des Données (DPO)',
            'dpo_desc' => 'Notre équipe juridique et de sécurité répond à toutes vos demandes de confidentialité.',
            'contact_btn' => 'Contacter l\'Équipe DPO',
        ]
    ];

    $t = $content[$currentLang] ?? $content['ar'];
@endphp

@section('title', $t['meta_title'])
@section('meta_description', $t['meta_desc'])

@push('styles')
<style>
/* ═══════════════════════════════════════════════════════════════════
   OX TECH PRIVACY POLICY HIGH-END DARK LUXURY STYLESHEET
   ═══════════════════════════════════════════════════════════════════ */
:root {
    --ox-priv-carbon: #061514;
    --ox-priv-card: #09201D;
    --ox-priv-card-soft: #0E2B27;
    --ox-priv-card-hover: #123732;
    --ox-priv-emerald: #1D8A68;
    --ox-priv-emerald-glow: rgba(29, 138, 104, 0.28);
    --ox-priv-gold: #C8A96B;
    --ox-priv-gold-glow: rgba(200, 169, 107, 0.22);
    --ox-priv-ivory: #F3EFE5;
    --ox-priv-gray: #A0B2AC;
    --ox-priv-border: rgba(29, 138, 104, 0.22);
    --ox-priv-border-subtle: rgba(243, 239, 229, 0.08);
}

.ox-privacy-wrap {
    background-color: var(--ox-priv-carbon);
    background-image: 
        radial-gradient(circle at 50% -5%, rgba(29, 138, 104, 0.16) 0%, transparent 60%),
        radial-gradient(circle at 90% 25%, rgba(200, 169, 107, 0.06) 0%, transparent 50%),
        radial-gradient(circle at 10% 55%, rgba(29, 138, 104, 0.08) 0%, transparent 50%);
    color: var(--ox-priv-ivory);
    min-height: 100vh;
    padding-top: 110px;
    padding-bottom: 90px;
    font-family: var(--font, 'Cairo', sans-serif);
    direction: {{ $isRtl ? 'rtl' : 'ltr' }};
    position: relative;
    overflow-x: hidden;
}

/* Hero Header */
.privacy-hero-section {
    max-width: 1180px;
    margin: 0 auto 40px;
    padding: 0 20px;
    text-align: center;
    position: relative;
}

.privacy-badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 18px;
    background: rgba(29, 138, 104, 0.14);
    border: 1px solid var(--ox-priv-border);
    border-radius: 999px;
    font-size: 13px;
    color: var(--ox-priv-emerald);
    font-weight: 700;
    margin-bottom: 18px;
    box-shadow: 0 0 20px rgba(29, 138, 104, 0.12);
}

.privacy-hero-title {
    font-size: clamp(28px, 4.2vw, 46px);
    font-weight: 800;
    line-height: 1.25;
    margin-bottom: 16px;
    color: var(--ox-priv-ivory);
    letter-spacing: -0.02em;
}

.privacy-hero-title span.accent-emerald {
    color: #27B387;
    text-shadow: 0 0 24px rgba(39, 179, 135, 0.35);
}

.privacy-hero-subtitle {
    max-width: 820px;
    margin: 0 auto 24px;
    font-size: clamp(15px, 1.8vw, 17px);
    line-height: 1.75;
    color: var(--ox-priv-gray);
}

.privacy-meta-row {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 13px;
    color: var(--ox-priv-gray);
    margin-bottom: 30px;
}

.privacy-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255, 255, 255, 0.04);
    padding: 6px 14px;
    border-radius: 8px;
    border: 1px solid var(--ox-priv-border-subtle);
}

.privacy-print-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    background: rgba(200, 169, 107, 0.12);
    border: 1px solid rgba(200, 169, 107, 0.35);
    color: var(--ox-priv-gold);
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    text-decoration: none;
}

.privacy-print-btn:hover {
    background: rgba(200, 169, 107, 0.22);
    box-shadow: 0 0 16px var(--ox-priv-gold-glow);
    transform: translateY(-1px);
    color: #fff;
}

/* Four Core Guarantee Cards */
.guarantees-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
    max-width: 1180px;
    margin: 0 auto 50px;
    padding: 0 20px;
}

.guarantee-card {
    background: var(--ox-priv-card);
    border: 1px solid var(--ox-priv-border);
    border-radius: 16px;
    padding: 24px;
    position: relative;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
}

.guarantee-card:hover {
    transform: translateY(-4px);
    border-color: rgba(39, 179, 135, 0.5);
    box-shadow: 0 16px 36px var(--ox-priv-emerald-glow);
    background: var(--ox-priv-card-hover);
}

.guarantee-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 16px;
    background: rgba(29, 138, 104, 0.18);
    color: #31d39e;
    border: 1px solid rgba(29, 138, 104, 0.3);
}

.guarantee-card.gold .guarantee-icon {
    background: rgba(200, 169, 107, 0.18);
    color: #E2C17D;
    border-color: rgba(200, 169, 107, 0.35);
}

.guarantee-title {
    font-size: 17px;
    font-weight: 700;
    color: var(--ox-priv-ivory);
    margin-bottom: 8px;
}

.guarantee-desc {
    font-size: 13.5px;
    line-height: 1.65;
    color: var(--ox-priv-gray);
    margin: 0;
}

/* Category Filter Tabs */
.privacy-filter-bar {
    max-width: 1180px;
    margin: 0 auto 35px;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
}

.privacy-filter-btn {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid var(--ox-priv-border-subtle);
    color: var(--ox-priv-gray);
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 7px;
}

.privacy-filter-btn:hover {
    background: rgba(29, 138, 104, 0.12);
    color: var(--ox-priv-ivory);
    border-color: var(--ox-priv-border);
}

.privacy-filter-btn.active {
    background: var(--ox-priv-emerald);
    color: #ffffff;
    border-color: var(--ox-priv-emerald);
    box-shadow: 0 0 18px var(--ox-priv-emerald-glow);
}

/* Main Container: Sidebar + Content Body */
.privacy-main-layout {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 310px 1fr;
    gap: 36px;
    align-items: start;
}

@media (max-width: 992px) {
    .privacy-main-layout {
        grid-template-columns: 1fr;
        gap: 25px;
    }
}

/* Sticky Sidebar Table of Contents */
.privacy-sidebar {
    position: sticky;
    top: 100px;
    background: var(--ox-priv-card);
    border: 1px solid var(--ox-priv-border);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
}

.sidebar-heading {
    font-size: 15px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--ox-priv-gold);
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--ox-priv-border-subtle);
}

.toc-nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.toc-nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    border-radius: 8px;
    color: var(--ox-priv-gray);
    text-decoration: none;
    font-size: 13.5px;
    font-weight: 600;
    line-height: 1.4;
    transition: all 0.2s ease;
    border-right: {{ $isRtl ? '3px solid transparent' : 'none' }};
    border-left: {{ $isRtl ? 'none' : '3px solid transparent' }};
}

.toc-nav-link:hover {
    color: var(--ox-priv-ivory);
    background: rgba(29, 138, 104, 0.12);
}

.toc-nav-link.active {
    color: #31d39e;
    background: rgba(29, 138, 104, 0.18);
    border-color: #31d39e;
    font-weight: 700;
}

.sidebar-dpo-box {
    margin-top: 24px;
    padding: 18px;
    background: rgba(200, 169, 107, 0.08);
    border: 1px solid rgba(200, 169, 107, 0.25);
    border-radius: 12px;
    text-align: {{ $isRtl ? 'right' : 'left' }};
}

.sidebar-dpo-box h4 {
    font-size: 14px;
    font-weight: 700;
    color: var(--ox-priv-gold);
    margin: 0 0 6px;
}

.sidebar-dpo-box p {
    font-size: 12.5px;
    color: var(--ox-priv-gray);
    line-height: 1.55;
    margin: 0 0 12px;
}

.sidebar-dpo-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--ox-priv-ivory);
    background: rgba(200, 169, 107, 0.2);
    border: 1px solid rgba(200, 169, 107, 0.4);
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.sidebar-dpo-link:hover {
    background: var(--ox-priv-gold);
    color: #041210;
}

/* Privacy Content Body & Sections */
.privacy-content-body {
    display: flex;
    flex-direction: column;
    gap: 32px;
}

.privacy-section-block {
    background: var(--ox-priv-card);
    border: 1px solid var(--ox-priv-border);
    border-radius: 18px;
    padding: 34px 30px;
    position: relative;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    scroll-margin-top: 105px;
    transition: border-color 0.3s ease;
}

.privacy-section-block:hover {
    border-color: rgba(29, 138, 104, 0.4);
}

.section-tag-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--ox-priv-border-subtle);
}

.section-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.section-pill.desktop {
    background: rgba(26, 86, 245, 0.15);
    color: #60A5FA;
    border: 1px solid rgba(26, 86, 245, 0.35);
}

.section-pill.extension {
    background: rgba(168, 85, 247, 0.15);
    color: #C084FC;
    border: 1px solid rgba(168, 85, 247, 0.35);
}

.section-pill.general {
    background: rgba(29, 138, 104, 0.15);
    color: #34D399;
    border: 1px solid rgba(29, 138, 104, 0.35);
}

.section-pill.legal {
    background: rgba(200, 169, 107, 0.15);
    color: #E2C17D;
    border: 1px solid rgba(200, 169, 107, 0.35);
}

.section-num {
    font-size: 13px;
    color: var(--ox-priv-gray);
    font-family: monospace;
    font-weight: 700;
}

.section-main-title {
    font-size: clamp(20px, 2.4vw, 25px);
    font-weight: 800;
    color: var(--ox-priv-ivory);
    margin: 0 0 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.section-main-title i {
    color: var(--ox-priv-emerald);
}

.privacy-paragraph {
    font-size: 15px;
    line-height: 1.85;
    color: var(--ox-priv-gray);
    margin-bottom: 20px;
}

.privacy-paragraph strong {
    color: var(--ox-priv-ivory);
}

/* Feature & Policy Callout Boxes */
.privacy-callout-box {
    background: var(--ox-priv-card-soft);
    border: 1px solid var(--ox-priv-border);
    border-radius: 12px;
    padding: 20px 22px;
    margin: 22px 0;
    position: relative;
}

.privacy-callout-box.emerald {
    border-left: {{ $isRtl ? '1px solid var(--ox-priv-border)' : '4px solid #27B387' }};
    border-right: {{ $isRtl ? '4px solid #27B387' : '1px solid var(--ox-priv-border)' }};
    background: rgba(29, 138, 104, 0.08);
}

.privacy-callout-box.gold {
    border-left: {{ $isRtl ? '1px solid var(--ox-priv-border)' : '4px solid var(--ox-priv-gold)' }};
    border-right: {{ $isRtl ? '4px solid var(--ox-priv-gold)' : '1px solid var(--ox-priv-border)' }};
    background: rgba(200, 169, 107, 0.08);
}

.callout-heading {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 15px;
    font-weight: 700;
    color: var(--ox-priv-ivory);
    margin: 0 0 8px;
}

.callout-body {
    font-size: 14px;
    line-height: 1.7;
    color: var(--ox-priv-gray);
    margin: 0;
}

/* Sub-features lists & tables */
.privacy-checklist {
    list-style: none;
    padding: 0;
    margin: 16px 0 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.privacy-checklist li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 14.5px;
    line-height: 1.7;
    color: var(--ox-priv-gray);
}

.privacy-checklist li i.check-icon {
    color: #34D399;
    font-size: 15px;
    margin-top: 4px;
    flex-shrink: 0;
}

.privacy-checklist li i.cross-icon {
    color: #F87171;
    font-size: 15px;
    margin-top: 4px;
    flex-shrink: 0;
}

.privacy-checklist li strong {
    color: var(--ox-priv-ivory);
}

/* Data Table for Extensions & Desktop Permissions */
.privacy-table-responsive {
    overflow-x: auto;
    margin: 20px 0;
    border-radius: 12px;
    border: 1px solid var(--ox-priv-border);
}

.privacy-data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13.5px;
    text-align: {{ $isRtl ? 'right' : 'left' }};
}

.privacy-data-table th {
    background: rgba(29, 138, 104, 0.16);
    color: var(--ox-priv-ivory);
    padding: 14px 18px;
    font-weight: 700;
    border-bottom: 1px solid var(--ox-priv-border);
    white-space: nowrap;
}

.privacy-data-table td {
    padding: 14px 18px;
    border-bottom: 1px solid var(--ox-priv-border-subtle);
    color: var(--ox-priv-gray);
    line-height: 1.6;
}

.privacy-data-table tr:last-child td {
    border-bottom: none;
}

.privacy-data-table tr:hover td {
    background: rgba(255, 255, 255, 0.02);
}

.code-pill {
    background: rgba(255, 255, 255, 0.08);
    color: #E2C17D;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    font-size: 12px;
    padding: 3px 8px;
    border-radius: 4px;
    border: 1px solid rgba(255, 255, 255, 0.12);
}

/* Accordion for FAQ / Detailed Legal Questions */
.legal-accordion {
    margin-top: 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.legal-accordion-item {
    background: var(--ox-priv-card-soft);
    border: 1px solid var(--ox-priv-border-subtle);
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.25s ease;
}

.legal-accordion-header {
    padding: 16px 20px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: none;
    border: none;
    color: var(--ox-priv-ivory);
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    text-align: {{ $isRtl ? 'right' : 'left' }};
    font-family: inherit;
    gap: 12px;
}

.legal-accordion-header i.arrow-icon {
    font-size: 12px;
    color: var(--ox-priv-emerald);
    transition: transform 0.25s ease;
}

.legal-accordion-item.open .legal-accordion-header i.arrow-icon {
    transform: rotate(180deg);
}

.legal-accordion-content {
    display: none;
    padding: 0 20px 18px;
    font-size: 14px;
    line-height: 1.7;
    color: var(--ox-priv-gray);
    border-top: 1px solid var(--ox-priv-border-subtle);
}

.legal-accordion-item.open .legal-accordion-content {
    display: block;
}

/* Print Styles */
@media print {
    body {
        background: #fff !important;
        color: #000 !important;
    }
    .ox-privacy-wrap {
        background: #fff !important;
        color: #000 !important;
        padding: 0 !important;
    }
    .privacy-sidebar,
    .privacy-filter-bar,
    .privacy-print-btn,
    .navbar,
    .ox-footer,
    .ox-floating-actions {
        display: none !important;
    }
    .privacy-main-layout {
        grid-template-columns: 1fr !important;
    }
    .privacy-section-block {
        border: 1px solid #ccc !important;
        box-shadow: none !important;
        background: #fff !important;
        page-break-inside: avoid;
        margin-bottom: 20px !important;
        color: #000 !important;
    }
    .privacy-hero-title, .section-main-title, .callout-heading, .guarantee-title {
        color: #000 !important;
    }
    .privacy-paragraph, .callout-body, .guarantee-desc, .privacy-data-table td {
        color: #333 !important;
    }
    .code-pill {
        background: #eee !important;
        color: #000 !important;
        border-color: #ccc !important;
    }
}
</style>
@endpush

@section('content')
<main class="ox-privacy-wrap" id="privacyRoot">
    <!-- ─── HERO HEADER ─── -->
    <section class="privacy-hero-section">
        <div class="privacy-badge-pill">
            <i class="fa-solid fa-shield-halved"></i>
            <span>{{ $t['badge'] }}</span>
        </div>
        <h1 class="privacy-hero-title">
            {{ $t['hero_title'] }}<br/>
            <span class="accent-emerald">OX Tech Software Engineering</span>
        </h1>
        <p class="privacy-hero-subtitle">
            {{ $t['hero_sub'] }}
        </p>

        <div class="privacy-meta-row">
            <div class="privacy-meta-item">
                <i class="fa-regular fa-calendar-check" style="color: var(--ox-priv-emerald);"></i>
                <span>{{ $t['last_updated'] }} <strong>{{ $t['last_updated_date'] }}</strong></span>
            </div>
            <div class="privacy-meta-item">
                <i class="fa-solid fa-gavel" style="color: var(--ox-priv-gold);"></i>
                <span>PDPL • GDPR • Chrome Web Store V3 Compliant</span>
            </div>
            <button type="button" onclick="window.print()" class="privacy-print-btn" title="{{ $t['print_btn'] }}">
                <i class="fa-solid fa-print"></i>
                <span>{{ $t['print_btn'] }}</span>
            </button>
        </div>
    </section>

    <!-- ─── FOUR CORE PILLARS (AESTHETIC CARDS) ─── -->
    <section class="guarantees-grid">
        <div class="guarantee-card">
            <div class="guarantee-icon">
                <i class="fa-solid fa-laptop-code"></i>
            </div>
            <h3 class="guarantee-title">
                {{ $currentLang === 'ar' ? 'معالجة محلية أولاً (Local-First)' : ($currentLang === 'fr' ? 'Traitement Local d\'Abord' : 'Local-First Processing') }}
            </h3>
            <p class="guarantee-desc">
                {{ $currentLang === 'ar' 
                    ? 'برامج سطح المكتب (Windows / Mac) تعمل وتخزن قواعد بياناتها وملفاتها محلياً على جهازك دون رفع أي بيانات إلى خوادم خارجية.' 
                    : ($currentLang === 'fr' 
                        ? 'Nos applications de bureau stockent et exécutent vos données et bases locales directement sur votre machine sans téléversement.' 
                        : 'Our desktop software processes and stores databases entirely on your local machine with zero unauthorized cloud uploads.') }}
            </p>
        </div>

        <div class="guarantee-card gold">
            <div class="guarantee-icon">
                <i class="fa-solid fa-puzzle-piece"></i>
            </div>
            <h3 class="guarantee-title">
                {{ $currentLang === 'ar' ? 'صفر بيع لبيانات الإضافات' : ($currentLang === 'fr' ? 'Zéro Vente de Données d\'Extension' : 'Zero Data Selling Guarantee') }}
            </h3>
            <p class="guarantee-desc">
                {{ $currentLang === 'ar' 
                    ? 'إضافات واكستنشن المتصفح تخضع لسياسة الغرض الواحد؛ لا نبيع أو نشارك أو نتتبع سجل تصفحك ولا نجمع ضربات المفاتيح أو البطاقات إطلاقاً.' 
                    : ($currentLang === 'fr' 
                        ? 'Nos extensions respectent le principe d\'objectif unique. Zéro suivi de navigation, zéro vente de vos informations à des tiers.' 
                        : 'Our browser add-ons adhere to single-purpose rules. We never sell, monetize, or track your web browsing history or inputs.') }}
            </p>
        </div>

        <div class="guarantee-card">
            <div class="guarantee-icon">
                <i class="fa-solid fa-key"></i>
            </div>
            <h3 class="guarantee-title">
                {{ $currentLang === 'ar' ? 'تشفير ومصادقة التراخيص الآمنة' : ($currentLang === 'fr' ? 'Validation Chiffrée des Licences' : 'Secure License Cryptography') }}
            </h3>
            <p class="guarantee-desc">
                {{ $currentLang === 'ar' 
                    ? 'التحقق من الرخص يتم عبر بصمة جهاز مجردة (Machine GUID مشفر بـ SHA-256) لمنع الاحتيال دون المساس بهويتك أو ملفاتك الشخصية.' 
                    : ($currentLang === 'fr' 
                        ? 'L\'activation utilise une empreinte matérielle abstraite hachée SHA-256 pour vérifier les postes sans collecter de fichiers personnels.' 
                        : 'Licensing uses one-way SHA-256 hashed hardware GUIDs to enforce device limits securely without accessing personal directories.') }}
            </p>
        </div>

        <div class="guarantee-card gold">
            <div class="guarantee-icon">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <h3 class="guarantee-title">
                {{ $currentLang === 'ar' ? 'سيادة المستخدم والامتثال الكامل' : ($currentLang === 'fr' ? 'Souveraineté & Conformité Totale' : 'User Data Sovereignty') }}
            </h3>
            <p class="guarantee-desc">
                {{ $currentLang === 'ar' 
                    ? 'متوافقون تماماً مع نظام حماية البيانات الشخصية السعودي (PDPL)، قانون حماية البيانات الإماراتي والمصري، واللائحة الأوروبية (GDPR).' 
                    : ($currentLang === 'fr' 
                        ? 'Conformité stricte avec le RGPD européen ainsi que les lois sur la protection des données personnelles d\'Arabie Saoudite, EAU et Égypte.' 
                        : 'Fully aligned with Saudi PDPL, UAE Data Protection Law, Egyptian Law 151, and European GDPR, honoring your complete rights.') }}
            </p>
        </div>
    </section>

    <!-- ─── FILTER TABS ─── -->
    <div class="privacy-filter-bar">
        <button type="button" class="privacy-filter-btn active" data-filter="all">
            <i class="fa-solid fa-layer-group"></i>
            <span>{{ $t['filter_all'] }}</span>
        </button>
        <button type="button" class="privacy-filter-btn" data-filter="desktop">
            <i class="fa-solid fa-desktop"></i>
            <span>{{ $t['filter_desktop'] }}</span>
        </button>
        <button type="button" class="privacy-filter-btn" data-filter="extensions">
            <i class="fa-solid fa-puzzle-piece"></i>
            <span>{{ $t['filter_extension'] }}</span>
        </button>
        <button type="button" class="privacy-filter-btn" data-filter="store">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>{{ $t['filter_store'] }}</span>
        </button>
        <button type="button" class="privacy-filter-btn" data-filter="rights">
            <i class="fa-solid fa-scale-balanced"></i>
            <span>{{ $t['filter_rights'] }}</span>
        </button>
    </div>

    <!-- ─── MAIN TWO-COLUMN LAYOUT ─── -->
    <div class="privacy-main-layout">
        <!-- ─── SIDEBAR TABLE OF CONTENTS ─── -->
        <aside class="privacy-sidebar">
            <div class="sidebar-heading">
                <i class="fa-solid fa-list-check"></i>
                <span>{{ $t['toc_title'] }}</span>
            </div>
            <nav>
                <ul class="toc-nav-list">
                    <li>
                        <a href="#section-scope" class="toc-nav-link active">
                            <span>1.</span>
                            <span>{{ $currentLang === 'ar' ? 'المقدمة ونطاق التطبيق' : '1. Scope & Introduction' }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#section-desktop" class="toc-nav-link">
                            <span>2.</span>
                            <span>{{ $currentLang === 'ar' ? 'سياسة برامج سطح المكتب (Desktop)' : '2. Desktop Applications' }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#section-extensions" class="toc-nav-link">
                            <span>3.</span>
                            <span>{{ $currentLang === 'ar' ? 'إضافات واكستنشن المتصفح' : '3. Browser Extensions' }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#section-store" class="toc-nav-link">
                            <span>4.</span>
                            <span>{{ $currentLang === 'ar' ? 'متجر البرمجيات والمدفوعات' : '4. Digital Store & Payments' }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#section-security" class="toc-nav-link">
                            <span>5.</span>
                            <span>{{ $currentLang === 'ar' ? 'الأمان وتشفير البيانات' : '5. Cryptography & Security' }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#section-compliance" class="toc-nav-link">
                            <span>6.</span>
                            <span>{{ $currentLang === 'ar' ? 'الامتثال للأنظمة (PDPL / GDPR)' : '6. Legal Compliance' }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#section-rights" class="toc-nav-link">
                            <span>7.</span>
                            <span>{{ $currentLang === 'ar' ? 'حقوق المستخدم والتحكم' : '7. User Rights & Controls' }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#section-contact" class="toc-nav-link">
                            <span>8.</span>
                            <span>{{ $currentLang === 'ar' ? 'التواصل ومسؤول الخصوصية' : '8. Contact & DPO' }}</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-dpo-box">
                <h4><i class="fa-solid fa-headset"></i> {{ $t['dpo_title'] }}</h4>
                <p>{{ $t['dpo_desc'] }}</p>
                <a href="mailto:privacy@oxtech.uk" class="sidebar-dpo-link">
                    <i class="fa-regular fa-envelope"></i>
                    <span>privacy@oxtech.uk</span>
                </a>
            </div>
        </aside>

        <!-- ─── CONTENT BODY ─── -->
        <div class="privacy-content-body">

            <!-- ==============================================================
                 SECTION 1: Scope & Introduction
                 ============================================================== -->
            <article class="privacy-section-block" id="section-scope" data-category="general">
                <div class="section-tag-header">
                    <span class="section-pill general">
                        <i class="fa-solid fa-info-circle"></i> {{ $currentLang === 'ar' ? 'عام ونطاق التطبيق' : 'General & Scope' }}
                    </span>
                    <span class="section-num">#01 / 08</span>
                </div>
                <h2 class="section-main-title">
                    <i class="fa-solid fa-building-shield"></i>
                    {{ $currentLang === 'ar' ? '1. المقدمة ونطاق سريان السياسة' : '1. Introduction & Scope of Policy' }}
                </h2>
                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar' 
                        ? 'مرحباً بك في أوكس تك (OX Tech - المسجلة كبيت خبرة هندسي في تطوير البرمجيات وحلول السحابية والأنظمة التقنية عبر oxtech.uk). توضح هذه السياسة كيف نقوم بجمع واستخدام وحماية البيانات عبر كافة منتجاتنا وخدماتنا الرقمية.'
                        : 'Welcome to OX Tech (registered software engineering and cloud solutions house operating via oxtech.uk). This Privacy Policy explains how we collect, process, and safeguard your data across all digital products and platforms.' }}
                </p>

                <div class="privacy-callout-box emerald">
                    <div class="callout-heading">
                        <i class="fa-solid fa-compass"></i>
                        <span>{{ $currentLang === 'ar' ? 'المنتجات والخدمات المشمولة بهذه السياسة' : 'Products & Services Covered Under This Policy' }}</span>
                    </div>
                    <p class="callout-body">
                        {{ $currentLang === 'ar' 
                            ? 'تسري هذه الوثيقة على: (أ) برامج سطح المكتب (Desktop Software) لأنظمة تشغيل Windows و macOS و Linux. (ب) إضافات وملحقات متصفحات الويب (Browser Extensions & Add-ons) لمتصفحات Google Chrome و Microsoft Edge و Mozilla Firefox و Opera. (ج) موقعنا الإلكتروني ومتجر البرمجيات الرقمية (Digital Store & Licensing Hub) ونظام التراخيص وإدارة الاشتراكات.'
                            : 'This document applies to: (A) Desktop Software for Windows, macOS, and Linux. (B) Browser Extensions and Add-ons for Google Chrome, Microsoft Edge, and Mozilla Firefox. (C) Our website, Digital Software Store, license management, and customer portal.' }}
                    </p>
                </div>

                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'نحن نتبع مبدأ "الحد الأدنى من جمع البيانات" (Data Minimization) ومبدأ "الخصوصية عبر التصميم" (Privacy by Design). لا نجمع بيانات غير ضرورية، ولا نطلب صلاحيات لا تخدم الغرض الوظيفي المباشر للبرنامج.'
                        : 'We strictly adhere to Data Minimization and Privacy-by-Design engineering. We never request permissions or telemetry beyond what is essential to deliver the software\'s declared functionality.' }}
                </p>
            </article>

            <!-- ==============================================================
                 SECTION 2: Desktop Applications Privacy Policy (KEY REQUIREMENT)
                 ============================================================== -->
            <article class="privacy-section-block" id="section-desktop" data-category="desktop">
                <div class="section-tag-header">
                    <span class="section-pill desktop">
                        <i class="fa-solid fa-desktop"></i> {{ $currentLang === 'ar' ? 'برامج سطح المكتب (Windows / Mac / Linux)' : 'Desktop Software Architecture' }}
                    </span>
                    <span class="section-num">#02 / 08</span>
                </div>
                <h2 class="section-main-title">
                    <i class="fa-solid fa-laptop-code"></i>
                    {{ $currentLang === 'ar' ? '2. السياسة المخصصة لبرامج وتطبيقات الديسكتوب (Desktop Apps)' : '2. Desktop Applications & Software Privacy' }}
                </h2>
                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'تُبنى برامج سطح المكتب المطورة بواسطة OX Tech وفق معمارية تعتمد على المعالجة المحلية أولاً (Local-First Processing). هذا يعني أن بياناتك الأساسية تبقى ملكاً لك وتحت سيطرتك المباشرة داخل نظام تشغيلك المحلي.'
                        : 'OX Tech desktop applications are architected around a strict Local-First model. Your business records, documents, and workflows remain under your exclusive local custody.' }}
                </p>

                <h3 style="font-size: 16px; font-weight: 700; color: var(--ox-priv-ivory); margin: 20px 0 10px;">
                    <i class="fa-solid fa-server" style="color: var(--ox-priv-emerald);"></i>
                    {{ $currentLang === 'ar' ? 'أ. المعالجة والتخزين المحلي للبيانات (Local Data Storage)' : 'A. Local Storage & Zero Exfiltration' }}
                </h3>
                <ul class="privacy-checklist">
                    <li>
                        <i class="fa-solid fa-check-circle check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'قواعد البيانات والملفات المحلية:' : 'Local Database Engine:' }}</strong>
                            {{ $currentLang === 'ar' 
                                ? 'يتم حفظ كافة سجلاتك، قواعد بياناتك (مثل SQLite أو ملفات الإعدادات JSON المشفرة)، والوثائق المُدخلة داخل مجلد البرنامج المحلي أو AppData بجهازك. لا نقوم برفع أو مزامنة أيٍ من هذه الملفات إلى خوادم خارجية إطلاقاً دون تفعيل ميزة نسخ احتياطي سحابي بموافقتك الصريحة.'
                                : 'Databases (e.g., SQLite or encrypted JSON configurations) and user files are stored exclusively within local directory structures. Zero automated background uploads occur.' }}
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-check-circle check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'العمل دون اتصال بالإنترنت (Offline Capability):' : 'Offline Mode Operation:' }}</strong>
                            {{ $currentLang === 'ar' 
                                ? 'تعمل برامجنا بكامل وظائفها التشغيلية والإنتاجية دون الحاجة إلى اتصال دائم بالإنترنت، ولا يُشترط الاتصال إلا في لحظات التحقق من صلاحية مفتاح الترخيص أو البحث عن تحديثات برمجية جديدة.'
                                : 'Applications remain 100% operational offline. Connectivity is only required during periodic license key validation and software update checks.' }}
                        </div>
                    </li>
                </ul>

                <h3 style="font-size: 16px; font-weight: 700; color: var(--ox-priv-ivory); margin: 24px 0 10px;">
                    <i class="fa-solid fa-fingerprint" style="color: var(--ox-priv-gold);"></i>
                    {{ $currentLang === 'ar' ? 'ب. تفعيل الرخص ومعرف الجهاز (Machine GUID / Licensing)' : 'B. Software Activation & Hardware Fingerprinting' }}
                </h3>
                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'لضمان احترام حقوق الملكية الفكرية وعدد المقاعد المصرح بها في رخصة الشراء، يقوم البرنامج عند إدخال مفتاح التفعيل (License Key) بإنشاء معرف تشفيري مجرد للجهاز (Hardware Identifier):'
                        : 'To enforce legitimate seat licensing and anti-piracy bounds, our activation module computes an irreversible hardware identifier hash:' }}
                </p>

                <div class="privacy-table-responsive">
                    <table class="privacy-data-table">
                        <thead>
                            <tr>
                                <th>{{ $currentLang === 'ar' ? 'العنصر المجمع' : 'Parameter' }}</th>
                                <th>{{ $currentLang === 'ar' ? 'طريقة المعالجة' : 'Processing Method' }}</th>
                                <th>{{ $currentLang === 'ar' ? 'الغرض والاستخدام' : 'Declared Purpose' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>{{ $currentLang === 'ar' ? 'معرف الجهاز (Machine HWID)' : 'Hardware Signature' }}</strong></td>
                                <td><span class="code-pill">SHA-256 One-Way Hash</span></td>
                                <td>{{ $currentLang === 'ar' ? 'ربط الرخصة بالجهاز المعتمد ومنع استخدام المفتاح الواحد على أكثر من جهاز غير مرخص.' : 'Binding the license to the designated workstation and preventing key abuse.' }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ $currentLang === 'ar' ? 'اسم الجهاز (Computer Name)' : 'Hostname / Device Label' }}</strong></td>
                                <td>{{ $currentLang === 'ar' ? 'تخزين مشفر في السيرفر' : 'Encrypted on Server' }}</td>
                                <td>{{ $currentLang === 'ar' ? 'لمساعدتك على تمييز أجهزتك وإلغاء تنشيط جهاز قديم من لوحة تحكم حسابك.' : 'Displayed in your Customer Portal to allow you to revoke or switch seats easily.' }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ $currentLang === 'ar' ? 'نظام التشغيل والإصدار' : 'OS Version & Architecture' }}</strong></td>
                                <td>{{ $currentLang === 'ar' ? 'نص تقني مجرد (مثل Win 11 x64)' : 'Technical String' }}</td>
                                <td>{{ $currentLang === 'ar' ? 'لتقديم حزم التحديثات المتوافقة مع معمارية معالج جهازك.' : 'Ensuring update packages match your CPU architecture and operating platform.' }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ $currentLang === 'ar' ? 'الملفات الشخصية والمستندات' : 'Personal Documents & Files' }}</strong></td>
                                <td><strong style="color: #F87171;">{{ $currentLang === 'ar' ? 'لا يتم جمعها نهائياً' : 'Never Collected' }}</strong></td>
                                <td>{{ $currentLang === 'ar' ? 'لا يملك خادمنا أي وصول لمحتويات قرصك الصلب أو ملفاتك الخاصة.' : 'Our activation servers have zero visibility into your filesystem contents.' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 style="font-size: 16px; font-weight: 700; color: var(--ox-priv-ivory); margin: 24px 0 10px;">
                    <i class="fa-solid fa-arrows-rotate" style="color: var(--ox-priv-emerald);"></i>
                    {{ $currentLang === 'ar' ? 'ج. التحديثات الآمنة وتقارير الأعطال (Updates & Crash Reports)' : 'C. Secure Updates & Diagnostic Crash Telemetry' }}
                </h3>
                <ul class="privacy-checklist">
                    <li>
                        <i class="fa-solid fa-shield-virus check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'تحديثات موقعة رقمياً (Code Signing):' : 'Digitally Signed Updates:' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'يتم التحقق من توفر التحديثات عبر بروتوكول HTTPS المشفر. كافة ملفات التثبيت والتحديث موقعة بشهادات تشفير معتمدة لضمان عدم التلاعب بها أو اعتراضها من أطراف خبيثة.'
                                : 'Update manifests are fetched over TLS 1.3. Binaries are signed with code-signing certificates to ensure authentic delivery.' }}
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-bug check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'تقارير الأخطاء والانهيار (Crash Dumps):' : 'Crash Diagnostics:' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'في حال حدوث خطأ غير متوقع، قد يُعرض عليك إرسال تقرير تشخيصي. التقارير خالية تماماً من أسماء المستخدمين أو كلمات المرور أو البيانات الحساسة، وتحتوي فقط على رقم سطر الكود البرمجي المسبب للخطأ.'
                                : 'Crash logs, if opted-in by user, contain strictly call-stack execution paths and OS error codes, stripped of any sensitive memory snapshots or credentials.' }}
                        </div>
                    </li>
                </ul>
            </article>

            <!-- ==============================================================
                 SECTION 3: Browser Extensions Policy (KEY REQUIREMENT)
                 ============================================================== -->
            <article class="privacy-section-block" id="section-extensions" data-category="extensions">
                <div class="section-tag-header">
                    <span class="section-pill extension">
                        <i class="fa-solid fa-puzzle-piece"></i> {{ $currentLang === 'ar' ? 'إضافات واكستنشن المتصفح (Chrome / Edge / Firefox)' : 'Browser Extensions Policy' }}
                    </span>
                    <span class="section-num">#03 / 08</span>
                </div>
                <h2 class="section-main-title">
                    <i class="fa-brands fa-chrome"></i>
                    {{ $currentLang === 'ar' ? '3. السياسة الخاصة بإضافات واكستنشن المتصفحات (Browser Add-ons)' : '3. Browser Extensions & Plugins Privacy Policy' }}
                </h2>
                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'تخضع إضافات واكستنشن المتصفح المطورة بواسطة OX Tech (المطروحة على متجر Chrome Web Store، Microsoft Edge Add-ons، و Mozilla AMO) لأعلى معايير الأمان الدولية وسياسات Google Developer Program Policies المتوافقة مع معيار Manifest V3.'
                        : 'Browser extensions engineered by OX Tech (distributed via Chrome Web Store, Microsoft Edge Add-ons, and Mozilla AMO) adhere stringently to Google Developer Program Policies under Manifest V3 specifications.' }}
                </p>

                <div class="privacy-callout-box gold">
                    <div class="callout-heading">
                        <i class="fa-solid fa-ban"></i>
                        <span>{{ $currentLang === 'ar' ? 'تعهد صارم: لا نبيع أو نشارك أو نتاجر ببياناتك إطلاقاً' : 'Ironclad Guarantee: Zero Data Selling or Commercialization' }}</span>
                    </div>
                    <p class="callout-body">
                        {{ $currentLang === 'ar'
                            ? 'نقر ونتعهد بشكل قاطع ونهائي: إضافاتنا لا تبيع، لا تؤجر، ولا تشارك أي بيانات متعلقة بالمستخدمين، عادات التصفح، أو استعلامات البحث مع أي سماسرة بيانات (Data Brokers)، شبكات إعلانية، أو أطراف خارجية. كما لا تتضمن إضافاتنا أي شفرات برمجية لتعدين العملات الرقمية أو حقن الإعلانات (Ad Injection).'
                            : 'We unconditionally pledge: Our browser extensions NEVER sell, license, rent, or transfer your browsing activity to data brokers, ad networks, or third parties. We strictly reject ad injection, tracking scripts, and cryptocurrency miners.' }}
                    </p>
                </div>

                <h3 style="font-size: 16px; font-weight: 700; color: var(--ox-priv-ivory); margin: 20px 0 10px;">
                    <i class="fa-solid fa-key" style="color: var(--ox-priv-emerald);"></i>
                    {{ $currentLang === 'ar' ? 'أ. تفصيل أذونات الإضافات البرمجية (Extension Permissions Explained)' : 'A. Permissions Transparency & Manifest V3' }}
                </h3>
                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'تطلب الإضافة فقط الأذونات الضرورية للغاية لتقديم الميزة التي قمت بتثبيتها من أجلها (Single Purpose Principle):'
                        : 'Our add-ons request the absolute minimum permissions strictly necessary to fulfill their single declared feature:' }}
                </p>

                <div class="privacy-table-responsive">
                    <table class="privacy-data-table">
                        <thead>
                            <tr>
                                <th>{{ $currentLang === 'ar' ? 'الإذن (Permission)' : 'Requested Scope' }}</th>
                                <th>{{ $currentLang === 'ar' ? 'طريقة الاستخدام' : 'Technical Implementation' }}</th>
                                <th>{{ $currentLang === 'ar' ? 'ما لا نقوم به (الضمانة الأكيدة)' : 'Safety Guarantee' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="code-pill">storage</span></td>
                                <td>{{ $currentLang === 'ar' ? 'تخزين تفضيلات وإعدادات ومظهر الإضافة محلياً داخل المتصفح عبر chrome.storage.local.' : 'Storing your custom tool preferences and UI state locally via chrome.storage.local.' }}</td>
                                <td>{{ $currentLang === 'ar' ? 'لا يتم إرسال إعداداتك لأي خادم خارجي.' : 'Never sent to external third-party servers.' }}</td>
                            </tr>
                            <tr>
                                <td><span class="code-pill">activeTab</span></td>
                                <td>{{ $currentLang === 'ar' ? 'التفاعل حصرياً مع الصفحة المفتوحة عند نقر المستخدم المتعمد على زر الإضافة.' : 'Invoked only when the user deliberately clicks the extension icon on the active tab.' }}</td>
                                <td>{{ $currentLang === 'ar' ? 'لا تراقب الإضافة الصفحات في الخلفية، ولا تتتبع التبويبات الأخرى المفتوحة.' : 'Zero background tab sniffing or cross-tab tracking.' }}</td>
                            </tr>
                            <tr>
                                <td><span class="code-pill">scripting / contextMenus</span></td>
                                <td>{{ $currentLang === 'ar' ? 'تنفيذ وظيفة الأداة (مثل نسخ نص، تحويل تنسيق، أو إدراج خيار في قائمة الزر الأيمن).' : 'Executing the dedicated transformation tool or adding right-click shortcuts.' }}</td>
                                <td>{{ $currentLang === 'ar' ? 'لا نقوم بحقن أي سكريبتات إعلانية أو مراقبة حركات الفأرة.' : 'Zero analytics injection or DOM telemetry.' }}</td>
                            </tr>
                            <tr>
                                <td><span class="code-pill">declarativeNetRequest</span></td>
                                <td>{{ $currentLang === 'ar' ? 'تعديل أو معالجة الطلبات محلياً بواسطة قواعد المتصفح الداخلية فقط إن دعت وظيفة الإضافة.' : 'Modifying network rules safely through built-in browser engine rules.' }}</td>
                                <td>{{ $currentLang === 'ar' ? 'المتصفح لا يشارك عناوين URL للطلبات مع مطور الإضافة.' : 'Browser prohibits extension from seeing visited URLs.' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 style="font-size: 16px; font-weight: 700; color: var(--ox-priv-ivory); margin: 24px 0 10px;">
                    <i class="fa-solid fa-lock" style="color: var(--ox-priv-gold);"></i>
                    {{ $currentLang === 'ar' ? 'ب. حماية كلمات المرور والبيانات المالية والحساسة' : 'B. Sensitive Inputs, Financial & Keystroke Protection' }}
                </h3>
                <ul class="privacy-checklist">
                    <li>
                        <i class="fa-solid fa-circle-xmark cross-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'عدم تسجيل ضربات المفاتيح (Zero Keylogging):' : 'Zero Keystroke Logging:' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'لا تسجل إضافاتنا ما تكتبه في لوحة المفاتيح، ولا تقرأ حقول الإدخال، ولا تسترق النظر إلى كلمات المرور أو أسماء المستخدمين.'
                                : 'Our extensions never record keystrokes, form submissions, or input fields. Passwords and credentials remain untouched.' }}
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-xmark cross-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'عدم اعتراض بيانات الدفع أو البطاقات:' : 'Zero Payment Interception:' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'إضافاتنا محظورة ومصممة هندسياً لعدم التفاعل مع بوابات الدفع أو النماذج البنكية الحساسة.'
                                : 'Extensions are hardcoded to isolate completely from banking, checkout, and payment gateways.' }}
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-check-circle check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'الحذف والإزالة الكاملة (Instant Uninstall):' : 'Clean Uninstallation:' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'يمكنك إزالة الإضافة في أي وقت عبر متصفحك بنقرة واحدة (إزالة من Chrome / Edge)، ويؤدي ذلك إلى حذف كافة بياناتها المحلية المخزنة فوراً ودون ترك أي آثار.'
                                : 'Removing the extension from your browser instantly wipes all local storage and cached preferences with zero residue.' }}
                        </div>
                    </li>
                </ul>
            </article>

            <!-- ==============================================================
                 SECTION 4: Store & Payments
                 ============================================================== -->
            <article class="privacy-section-block" id="section-store" data-category="store">
                <div class="section-tag-header">
                    <span class="section-pill general">
                        <i class="fa-solid fa-bag-shopping"></i> {{ $currentLang === 'ar' ? 'المتجر والمدفوعات الإلكترونية' : 'Digital Store & Payments' }}
                    </span>
                    <span class="section-num">#04 / 08</span>
                </div>
                <h2 class="section-main-title">
                    <i class="fa-solid fa-cart-shopping"></i>
                    {{ $currentLang === 'ar' ? '4. بيانات المتجر الرقمي والمدفوعات والحسابات' : '4. Store Purchases, Licensing & Payment Data' }}
                </h2>
                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'عند شراء البرمجيات الرقمية أو التراخيص من متجر OX Tech، نقوم بجمع البيانات الضرورية فقط لإتمام عملية الشراء وتوليد مفاتيح الترخيص وإرسال روابط التنزيل الآمنة:'
                        : 'When purchasing digital software or licenses through OX Tech, we collect only necessary ordering and licensing data:' }}
                </p>

                <ul class="privacy-checklist">
                    <li>
                        <i class="fa-solid fa-check-circle check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'معلومات الطلب:' : 'Order Records:' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'الاسم، عنوان البريد الإلكتروني (لتسليم مفاتيح التفعيل وروابط التنزيل المحمية برمز مميز)، ورقم الجوال في حال اخترت استلام إشعارات التفعيل عبر واتساب.'
                                : 'Customer name, email address (to deliver activation keys and single-use download tokens), and optional phone number.' }}
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-check-circle check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'أمان معالجة المدفوعات (PaySky & PayPal):' : 'Payment Gateways Tokenization:' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'تتم كافة المدفوعات الإلكترونية عبر بوابات دفع بنكية معتمدة ومطابقة لمعيار أمان بيانات صناعة بطاقات الدفع (PCI-DSS Level 1). نحن لا نرى ولا نخزن أرقام بطاقاتك الائتمانية أو رموز CVV على خوادمنا نهائياً.'
                                : 'All payment processing is handled through PCI-DSS Level 1 certified gateways (PaySky & PayPal). We NEVER see or store credit card numbers or security CVV codes.' }}
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-check-circle check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'حساب العميل وإدارة التراخيص (Customer Portal):' : 'Customer Account & License Seats:' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'تتيح لك لوحة تحكم العميل عرض التراخيص المشتراة، تتبع الأجهزة المفعلة، وإلغاء تفعيل أي جهاز قديم بنقرة واحدة لتحرير المقعد لجهاز جديد.'
                                : 'Your dashboard enables full self-service: inspecting active keys, reviewing activated workstations, and revoking seat bindings.' }}
                        </div>
                    </li>
                </ul>
            </article>

            <!-- ==============================================================
                 SECTION 5: Security Architecture
                 ============================================================== -->
            <article class="privacy-section-block" id="section-security" data-category="general">
                <div class="section-tag-header">
                    <span class="section-pill general">
                        <i class="fa-solid fa-lock"></i> {{ $currentLang === 'ar' ? 'الأمان والهندسة التشفيرية' : 'Security Architecture' }}
                    </span>
                    <span class="section-num">#05 / 08</span>
                </div>
                <h2 class="section-main-title">
                    <i class="fa-solid fa-shield-halved"></i>
                    {{ $currentLang === 'ar' ? '5. تدابير الأمان وتشفير البيانات' : '5. Cryptography & Data Protection Measures' }}
                </h2>
                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'نطبق معايير أمنية صارمة تماثل البنى المؤسسية الكبرى لحماية خصوصية عملائنا ومستخدمي برامجنا:'
                        : 'We deploy robust multi-layered defensive engineering to safeguard all infrastructure and communications:' }}
                </p>

                <div class="guarantees-grid" style="padding: 0; margin-bottom: 20px;">
                    <div class="guarantee-card" style="padding: 18px;">
                        <div class="guarantee-icon" style="width: 38px; height: 38px; font-size: 16px;">
                            <i class="fa-solid fa-network-wired"></i>
                        </div>
                        <h4 class="guarantee-title" style="font-size: 15px;">{{ $currentLang === 'ar' ? 'تشفير أثناء النقل (TLS 1.3)' : 'TLS 1.3 Transport' }}</h4>
                        <p class="guarantee-desc" style="font-size: 12.5px;">{{ $currentLang === 'ar' ? 'كافة الاتصالات بين برامج الديسكتوب والموقع ومخدمات التراخيص مشفرة بأحدث بروتوكولات SSL/TLS.' : 'All client-server exchanges use enforced HTTPS/TLS 1.3 ciphers.' }}</p>
                    </div>
                    <div class="guarantee-card gold" style="padding: 18px;">
                        <div class="guarantee-icon" style="width: 38px; height: 38px; font-size: 16px;">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <h4 class="guarantee-title" style="font-size: 15px;">{{ $currentLang === 'ar' ? 'تشفير أثناء التخزين (AES-256)' : 'AES-256 At Rest' }}</h4>
                        <p class="guarantee-desc" style="font-size: 12.5px;">{{ $currentLang === 'ar' ? 'البيانات الحساسة ومفاتيح التراخيص مخزنة بقواعد بيانات مشفرة مع عزل تام للمستأجرين.' : 'Database clusters and customer keys are guarded with AES-256 encryption.' }}</p>
                    </div>
                </div>

                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'تخضع سيرفراتنا لجدران حماية نشطة (WAF) مع حماية ضد هجمات حجب الخدمة الموزعة (DDoS)، وتطبيق سياسات دورية لمراجعة الثغرات الأمنية واختبارات الاختراق.'
                        : 'Infrastructure is guarded by Web Application Firewalls (WAF) and DDoS filtering, alongside automated penetration audits.' }}
                </p>
            </article>

            <!-- ==============================================================
                 SECTION 6: Legal Compliance (PDPL / GDPR)
                 ============================================================== -->
            <article class="privacy-section-block" id="section-compliance" data-category="rights">
                <div class="section-tag-header">
                    <span class="section-pill legal">
                        <i class="fa-solid fa-scale-balanced"></i> {{ $currentLang === 'ar' ? 'الامتثال القانوني والتشريعات' : 'Regulatory Alignment' }}
                    </span>
                    <span class="section-num">#06 / 08</span>
                </div>
                <h2 class="section-main-title">
                    <i class="fa-solid fa-landmark"></i>
                    {{ $currentLang === 'ar' ? '6. الامتثال للأنظمة الإقليمية والدولية' : '6. Regional & Global Regulatory Compliance' }}
                </h2>
                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'تلتزم OX Tech التزاماً كاملاً بكافة القوانين المنظمة لحماية البيانات في الأسواق التي نخدمها:'
                        : 'OX Tech maintains uncompromising compliance with personal data frameworks governing our operational territories:' }}
                </p>

                <ul class="privacy-checklist">
                    <li>
                        <i class="fa-solid fa-scale-balanced check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'المملكة العربية السعودية (نظام حماية البيانات الشخصية - PDPL):' : 'Saudi Arabia (PDPL Framework):' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'امتثال تام للمرسوم الملكي رقم (م/19) ولائحته التنفيذية الصادرة عن الهيئة السعودية للبيانات والذكاء الاصطناعي (سدايا - SDAIA). نضمن معالجة البيانات وفق أساس نظامي معلن، وصيانة حقوق أصحاب البيانات.'
                                : 'Compliant with Royal Decree No. (M/19) and regulations enacted by the Saudi Data & AI Authority (SDAIA).' }}
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-scale-balanced check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'الإمارات العربية المتحدة (مرسوم بقانون اتحادي رقم 45 لسنة 2021):' : 'United Arab Emirates (Federal Decree-Law 45/2021):' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'التزام بكافة مبادئ حماية خصوصية البيانات الشخصية، وحظر المعالجة دون موافقة أو سند قانوني صريح.'
                                : 'Aligned with UAE Federal Decree-Law No. 45 regarding Personal Data Protection.' }}
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-scale-balanced check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'جمهورية مصر العربية (قانون رقم 151 لسنة 2020):' : 'Egypt (Personal Data Protection Law 151/2020):' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'الامتثال لقانون حماية البيانات الشخصية المصري وقواعد النقل الآمن للبيانات عبر الحدود وتأمين قواعد البيانات الإلكترونية.'
                                : 'Full adherence to Egyptian Law No. 151 of 2020 on Data Protection.' }}
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-scale-balanced check-icon"></i>
                        <div>
                            <strong>{{ $currentLang === 'ar' ? 'الاتحاد الأوروبي (اللائحة العامة GDPR):' : 'European Union (GDPR - EU 2016/679):' }}</strong>
                            {{ $currentLang === 'ar'
                                ? 'احترام كامل لكافة معايير اللائحة العامة لحماية البيانات، بما يشمل الحق في النسيان، ونقل البيانات، وتعيين مسؤول لحماية البيانات.'
                                : 'Honoring GDPR articles regarding lawful processing, data portability, and the Right to Erasure.' }}
                        </div>
                    </li>
                </ul>
            </article>

            <!-- ==============================================================
                 SECTION 7: User Rights & Controls
                 ============================================================== -->
            <article class="privacy-section-block" id="section-rights" data-category="rights">
                <div class="section-tag-header">
                    <span class="section-pill legal">
                        <i class="fa-solid fa-user-check"></i> {{ $currentLang === 'ar' ? 'حقوقك وصلاحياتك' : 'Your Legal Entitlements' }}
                    </span>
                    <span class="section-num">#07 / 08</span>
                </div>
                <h2 class="section-main-title">
                    <i class="fa-solid fa-user-gear"></i>
                    {{ $currentLang === 'ar' ? '7. حقوق المستخدم وكيفية ممارستها' : '7. Your Rights & Data Custody' }}
                </h2>
                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'بموجب الأنظمة المذكورة أعلاه، تتمتع بالحقوق الكاملة وغير المشروطة التالية فيما يتعلق ببياناتك:'
                        : 'Under applicable privacy statutes, you possess the following actionable rights regarding your personal information:' }}
                </p>

                <div class="legal-accordion">
                    <div class="legal-accordion-item open">
                        <button type="button" class="legal-accordion-header" onclick="this.parentElement.classList.toggle('open')">
                            <span><i class="fa-solid fa-eye" style="color: var(--ox-priv-emerald); margin-left: 8px;"></i> {{ $currentLang === 'ar' ? 'حق الاطلاع والوصول (Right of Access)' : 'Right of Access & Inspection' }}</span>
                            <i class="fa-solid fa-chevron-down arrow-icon"></i>
                        </button>
                        <div class="legal-accordion-content">
                            {{ $currentLang === 'ar'
                                ? 'يحق لك في أي وقت طلب نسخة من كافة البيانات الشخصية وسجلات التراخيص المسجلة بحسابك لدينا بصيغة رقمية مقروءة.'
                                : 'You are entitled to request an export of all personal data, purchases, and device associations registered under your account.' }}
                        </div>
                    </div>

                    <div class="legal-accordion-item">
                        <button type="button" class="legal-accordion-header" onclick="this.parentElement.classList.toggle('open')">
                            <span><i class="fa-solid fa-pen-to-square" style="color: var(--ox-priv-gold); margin-left: 8px;"></i> {{ $currentLang === 'ar' ? 'حق التصحيح والتحديث (Right to Rectification)' : 'Right to Rectification' }}</span>
                            <i class="fa-solid fa-chevron-down arrow-icon"></i>
                        </button>
                        <div class="legal-accordion-content">
                            {{ $currentLang === 'ar'
                                ? 'يحق لك تحديث اسمك، بريدك الإلكتروني، أو بيانات الاتصال مباشرة من لوحة تحكم حسابك أو عبر مراسلة فريقنا.'
                                : 'You may update your profile, contact details, or registered company names directly via the customer portal or support.' }}
                        </div>
                    </div>

                    <div class="legal-accordion-item">
                        <button type="button" class="legal-accordion-header" onclick="this.parentElement.classList.toggle('open')">
                            <span><i class="fa-solid fa-trash-can" style="color: #F87171; margin-left: 8px;"></i> {{ $currentLang === 'ar' ? 'حق الحذف والإتلاف (Right to Erasure / To be Forgotten)' : 'Right to Erasure (To Be Forgotten)' }}</span>
                            <i class="fa-solid fa-chevron-down arrow-icon"></i>
                        </button>
                        <div class="legal-accordion-content">
                            {{ $currentLang === 'ar'
                                ? 'يحق لك طلب حذف حسابك وبياناتك الشخصية نهائياً من خوادمنا، وسنقوم بتنفيذ طلبك خلال 14 يوماً عمل (باستثناء السجلات المالية التي يفرض القانون الاحتفاظ بها لأغراض الفواتير الضريبية والمحاسبة).'
                                : 'You have the right to request the permanent purge of your account records within 14 business days, barring legally mandated tax/accounting archives.' }}
                        </div>
                    </div>

                    <div class="legal-accordion-item">
                        <button type="button" class="legal-accordion-header" onclick="this.parentElement.classList.toggle('open')">
                            <span><i class="fa-solid fa-link-slash" style="color: #38BDF8; margin-left: 8px;"></i> {{ $currentLang === 'ar' ? 'حق إلغاء ربط الأجهزة والتراخيص ذاتياً' : 'Seat License Revocation' }}</span>
                            <i class="fa-solid fa-chevron-down arrow-icon"></i>
                        </button>
                        <div class="legal-accordion-content">
                            {{ $currentLang === 'ar'
                                ? 'يمكنك في أي وقت إلغاء تفعيل أي جهاز من لوحة تحكم التراخيص الخاصة بك، مما يؤدي فوراً إلى إبطال المعرف المرتبط به وتحرير مقعد التفعيل لجهاز آخر.'
                                : 'You can unilaterally deactivate workstations from your License Dashboard, severing the device identifier immediately.' }}
                        </div>
                    </div>
                </div>
            </article>

            <!-- ==============================================================
                 SECTION 8: Contact & DPO
                 ============================================================== -->
            <article class="privacy-section-block" id="section-contact" data-category="general">
                <div class="section-tag-header">
                    <span class="section-pill general">
                        <i class="fa-solid fa-headset"></i> {{ $currentLang === 'ar' ? 'التواصل ومسؤول الخصوصية' : 'Contact & DPO' }}
                    </span>
                    <span class="section-num">#08 / 08</span>
                </div>
                <h2 class="section-main-title">
                    <i class="fa-solid fa-envelope-open-text"></i>
                    {{ $currentLang === 'ar' ? '8. قنوات التواصل وإدارة الخصوصية' : '8. Inquiries & Data Protection Office' }}
                </h2>
                <p class="privacy-paragraph">
                    {{ $currentLang === 'ar'
                        ? 'إذا كان لديك أي استفسار يتعلق بهذه السياسة، أو كنت ترغب في ممارسة أيٍ من حقوقك، يسعدنا تواصلك مع مكتب حماية البيانات المعتمد لدينا:'
                        : 'If you have any questions regarding this policy or wish to exercise your data rights, contact our Data Protection Office:' }}
                </p>

                <div class="privacy-callout-box emerald">
                    <div class="callout-heading">
                        <i class="fa-solid fa-building"></i>
                        <span>OX Tech Engineering & Legal Affairs</span>
                    </div>
                    <p class="callout-body" style="margin-bottom: 12px;">
                        <strong>{{ $currentLang === 'ar' ? 'البريد الإلكتروني المباشر:' : 'Dedicated Privacy Email:' }}</strong> 
                        <a href="mailto:privacy@oxtech.uk" style="color: #27B387; text-decoration: underline;">privacy@oxtech.uk</a>
                        &bull;
                        <a href="mailto:support@oxtech.uk" style="color: #27B387; text-decoration: underline;">support@oxtech.uk</a>
                    </p>
                    <p class="callout-body" style="font-size: 13px;">
                        <strong>{{ $currentLang === 'ar' ? 'المكاتب الإقليمية:' : 'Regional Offices:' }}</strong>
                        {{ $currentLang === 'ar' 
                            ? 'الرياض (المملكة العربية السعودية) • القاهرة (جمهورية مصر العربية) • دبي (الإمارات العربية المتحدة)' 
                            : 'Riyadh (Saudi Arabia) • Cairo (Egypt) • Dubai (UAE)' }}
                    </p>
                    <p class="callout-body" style="font-size: 12.5px; margin-top: 8px; color: var(--ox-priv-gray);">
                        <i class="fa-regular fa-clock"></i>
                        {{ $currentLang === 'ar' ? 'نلتزم بالرد على كافة الطلبات والاستفسارات القانونية خلال 48 ساعة عمل كحد أقصى.' : 'We are committed to responding to all privacy inquiries within 48 business hours.' }}
                    </p>
                </div>

                <div style="text-align: center; margin-top: 25px;">
                    <a href="{{ route('contact') }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 10px; padding: 12px 28px; text-decoration: none; font-weight: 700; border-radius: 999px;">
                        <span>{{ $t['contact_btn'] }}</span>
                        <i class="fa-solid {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                    </a>
                </div>
            </article>

        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ─── 1. Category Filter Tabs Interactivity ───
    const filterButtons = document.querySelectorAll('.privacy-filter-btn');
    const sections = document.querySelectorAll('.privacy-section-block');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filterVal = this.getAttribute('data-filter');

            sections.forEach(sec => {
                const secCat = sec.getAttribute('data-category');
                if (filterVal === 'all') {
                    sec.style.display = 'block';
                } else if (filterVal === 'desktop' && sec.id === 'section-desktop') {
                    sec.style.display = 'block';
                } else if (filterVal === 'extensions' && sec.id === 'section-extensions') {
                    sec.style.display = 'block';
                } else if (filterVal === 'store' && sec.id === 'section-store') {
                    sec.style.display = 'block';
                } else if (filterVal === 'rights' && (sec.id === 'section-compliance' || sec.id === 'section-rights')) {
                    sec.style.display = 'block';
                } else {
                    sec.style.display = 'none';
                }
            });

            // Smooth scroll to the first matching section if specific filter
            if (filterVal !== 'all') {
                const visibleSec = Array.from(sections).find(s => s.style.display !== 'none');
                if (visibleSec) {
                    visibleSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });

    // ─── 2. Sticky Scrollspy for Sidebar TOC ───
    const tocLinks = document.querySelectorAll('.toc-nav-link');
    const observerOptions = {
        root: null,
        rootMargin: '-100px 0px -60% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                tocLinks.forEach(link => {
                    if (link.getAttribute('href') === '#' + id) {
                        tocLinks.forEach(l => l.classList.remove('active'));
                        link.classList.add('active');
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(sec => observer.observe(sec));
});
</script>
@endpush
