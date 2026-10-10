@extends('layouts.app')

@section('title', $product->meta_title ?: 'ScripOx — البرنامج الشامل لاستخراج واستهداف بيانات العملاء في السعودية والخليج | OX Tech')
@section('meta_description', $product->meta_description ?: 'اجمع بيانات عملائك الحقيقيين من المنصات وصدّر جمهورك الإعلاني لفيسبوك وجوجل بضغطة زر واحدة. ترخيص دائم بدون اشتراكات شهرية مع ضمان ذهبي 14 يوم.')

@section('content')
@php
    $lp = $product->landingPage;
    $promoDeadline = \Carbon\Carbon::create(2026, 10, 19, 23, 59, 59, 'Africa/Cairo');
    $promoActive   = now('Africa/Cairo')->lt($promoDeadline);
    $promoPrice    = 5;   // USD when promo code applied
    $normalPrice   = (float) $product->effective_price;
    $promoPriceSar = 19;  // Approximate SAR conversion
    $normalPriceSar = 375;
@endphp

<style>
/* ═══════════════════════════════════════════════════════════════════
   ScripOx — Apple & Google Inspired Clean Light Theme
   Aesthetic: Minimalist, Airy White, Soft Slate, Refined Indigo/Emerald Accents
   No Emojis — 100% Clean SVG Icons — 100% Mobile Responsive
   ═══════════════════════════════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&display=swap');

:root {
    --ap-bg-main:       #FFFFFF;
    --ap-bg-subtle:     #F8FAFC;
    --ap-bg-elevated:   #FFFFFF;
    --ap-bg-muted:      #F1F5F9;
    --ap-text-primary:  #0F172A;
    --ap-text-secondary:#475569;
    --ap-text-muted:    #64748B;
    --ap-border-subtle: #E2E8F0;
    --ap-border-strong: #CBD5E1;
    --ap-blue-primary:  #2563EB;
    --ap-blue-hover:    #1D4ED8;
    --ap-blue-subtle:   #EFF6FF;
    --ap-emerald:       #059669;
    --ap-emerald-subtle:#ECFDF5;
    --ap-amber:         #D97706;
    --ap-amber-subtle:  #FFFBEB;
    --ap-shadow-xs:     0 1px 2px rgba(15, 23, 42, 0.04);
    --ap-shadow-sm:     0 2px 8px rgba(15, 23, 42, 0.05);
    --ap-shadow-md:     0 8px 24px rgba(15, 23, 42, 0.07);
    --ap-shadow-lg:     0 20px 40px -10px rgba(15, 23, 42, 0.08);
    --ap-shadow-pop:    0 24px 60px -12px rgba(37, 99, 235, 0.14);
    --ap-radius-sm:     10px;
    --ap-radius-md:     16px;
    --ap-radius-lg:     24px;
    --ap-radius-full:   9999px;
}

/* Base resets & typography */
.sp-apple-page {
    background-color: var(--ap-bg-main);
    color: var(--ap-text-primary);
    font-family: 'Cairo', 'Tajawal', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    direction: rtl;
    line-height: 1.65;
    overflow-x: hidden;
    position: relative;
    -webkit-font-smoothing: antialiased;
}

.sp-apple-page * {
    box-sizing: border-box;
}

.sp-container {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 24px;
    position: relative;
    z-index: 2;
}

/* ─── Breadcrumb ─── */
.sp-breadcrumbs-bar {
    padding: 16px 0 10px;
    font-size: 12.5px;
    color: var(--ap-text-muted);
    display: flex;
    align-items: center;
    gap: 8px;
}
.sp-breadcrumbs-bar a {
    color: var(--ap-text-muted);
    text-decoration: none;
    transition: color 0.15s;
}
.sp-breadcrumbs-bar a:hover {
    color: var(--ap-blue-primary);
}
.sp-breadcrumbs-bar .sep {
    color: #CBD5E1;
    font-size: 11px;
}

/* ─── Top Urgency Ribbon ─── */
.sp-top-ribbon {
    background: #0F172A;
    color: #F8FAFC;
    font-size: 13px;
    font-weight: 700;
    padding: 10px 16px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
.sp-ribbon-tag {
    background: #2563EB;
    color: #FFFFFF;
    font-size: 11px;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: var(--ap-radius-full);
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.sp-ribbon-btn {
    background: rgba(255, 255, 255, 0.14);
    color: #FFFFFF !important;
    text-decoration: none;
    font-size: 12px;
    padding: 3px 12px;
    border-radius: var(--ap-radius-full);
    transition: background 0.2s;
    font-weight: 700;
}
.sp-ribbon-btn:hover {
    background: rgba(255, 255, 255, 0.25);
}

/* ─── HERO BANNER (sp-hero-banner) Apple Style ─── */
.sp-hero-banner {
    position: relative;
    background: linear-gradient(180deg, #F8FAFC 0%, #FFFFFF 100%);
    padding: 56px 0 72px;
    border-bottom: 1px solid var(--ap-border-subtle);
    overflow: hidden;
}

.sp-hero-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 1000px;
    height: 480px;
    background: radial-gradient(ellipse at 50% 0%, rgba(37, 99, 235, 0.08) 0%, rgba(248, 250, 252, 0) 70%);
    pointer-events: none;
    z-index: 1;
}

.sp-hero-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 48px;
    align-items: center;
    position: relative;
    z-index: 3;
}

@media (max-width: 992px) {
    .sp-hero-grid {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 36px;
    }
}

/* Regional Badge */
.sp-pill-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--ap-blue-subtle);
    border: 1px solid rgba(37, 99, 235, 0.2);
    color: var(--ap-blue-primary);
    font-size: 13px;
    font-weight: 800;
    padding: 6px 16px;
    border-radius: var(--ap-radius-full);
    margin-bottom: 22px;
}
.sp-pill-dot {
    width: 7px;
    height: 7px;
    background: var(--ap-blue-primary);
    border-radius: 50%;
}

.sp-hero-title {
    font-size: clamp(28px, 4vw, 46px);
    font-weight: 900;
    line-height: 1.3;
    color: var(--ap-text-primary);
    margin-bottom: 20px;
    letter-spacing: -0.6px;
}
.sp-hero-title .sp-hl-blue {
    color: var(--ap-blue-primary);
}

.sp-hero-subtitle {
    font-size: clamp(15.5px, 1.8vw, 18px);
    color: var(--ap-text-secondary);
    line-height: 1.8;
    margin-bottom: 32px;
    max-width: 630px;
}
@media (max-width: 992px) {
    .sp-hero-subtitle { margin-left: auto; margin-right: auto; }
}

/* Hero Action Buttons */
.sp-hero-actions {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}
@media (max-width: 992px) {
    .sp-hero-actions { justify-content: center; }
}

.sp-btn-apple-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: var(--ap-text-primary);
    color: #FFFFFF !important;
    font-size: 16px;
    font-weight: 800;
    padding: 16px 34px;
    border-radius: var(--ap-radius-full);
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.18);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    border: none;
    cursor: pointer;
}
.sp-btn-apple-primary:hover {
    background: #000000;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.26);
}

.sp-btn-apple-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #FFFFFF;
    border: 1.5px solid var(--ap-border-strong);
    color: var(--ap-text-primary) !important;
    padding: 15px 24px;
    border-radius: var(--ap-radius-full);
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    box-shadow: var(--ap-shadow-xs);
    transition: all 0.2s;
}
.sp-btn-apple-secondary:hover {
    background: var(--ap-bg-subtle);
    border-color: var(--ap-blue-primary);
    color: var(--ap-blue-primary) !important;
}

.sp-trust-strip {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
    font-size: 13px;
    color: var(--ap-text-muted);
    font-weight: 600;
}
@media (max-width: 992px) {
    .sp-trust-strip { justify-content: center; }
}
.sp-trust-strip span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.sp-icon-check {
    color: var(--ap-emerald);
}

/* ─── Hero Visual: Croquis / Architecture UI Mockup ─── */
.sp-app-mockup-card {
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-lg);
    padding: 24px;
    box-shadow: var(--ap-shadow-lg);
    position: relative;
    transition: transform 0.3s;
}
.sp-app-mockup-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--ap-shadow-pop);
}

.sp-mockup-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 16px;
    margin-bottom: 18px;
    border-bottom: 1px solid var(--ap-border-subtle);
}
.sp-mockup-dots {
    display: flex;
    gap: 6px;
}
.sp-mockup-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}
.sp-dot-red   { background: #EF4444; }
.sp-dot-yellow{ background: #F59E0B; }
.sp-dot-green { background: #10B981; }

.sp-mockup-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--ap-text-muted);
    letter-spacing: -0.2px;
}

/* Visual Croquis Diagram (Vector Clean) */
.sp-croquis-flow {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 12px;
    align-items: center;
    background: var(--ap-bg-subtle);
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-md);
    padding: 20px 16px;
    margin-bottom: 18px;
}
@media (max-width: 480px) {
    .sp-croquis-flow {
        grid-template-columns: 1fr;
        gap: 10px;
    }
}

.sp-croquis-block {
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-sm);
    padding: 16px 12px;
    text-align: center;
    box-shadow: var(--ap-shadow-xs);
}
.sp-croquis-icon-wrap {
    width: 44px;
    height: 44px;
    background: var(--ap-blue-subtle);
    color: var(--ap-blue-primary);
    border-radius: var(--ap-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
}
.sp-croquis-block-title {
    font-size: 13.5px;
    font-weight: 800;
    color: var(--ap-text-primary);
}
.sp-croquis-block-desc {
    font-size: 11.5px;
    color: var(--ap-text-muted);
    margin-top: 4px;
    line-height: 1.5;
}

.sp-flow-arrow {
    color: var(--ap-blue-primary);
    display: flex;
    align-items: center;
    justify-content: center;
}
@media (max-width: 480px) {
    .sp-flow-arrow { transform: rotate(90deg); margin: 4px 0; }
}

.sp-croquis-output-banner {
    background: var(--ap-emerald-subtle);
    border: 1px solid rgba(5, 150, 105, 0.25);
    border-radius: var(--ap-radius-sm);
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12.5px;
    color: var(--ap-emerald);
    font-weight: 700;
}

.sp-mockup-badges-row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 14px;
}
.sp-mockup-mini-badge {
    background: var(--ap-bg-subtle);
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-full);
    padding: 6px 14px;
    font-size: 11.5px;
    font-weight: 700;
    color: var(--ap-text-secondary);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* ─── STATS SECTION (Minimalist Google/Apple Style) ─── */
.sp-stats-section {
    background: #FFFFFF;
    border-bottom: 1px solid var(--ap-border-subtle);
    padding: 38px 0;
}
.sp-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    text-align: center;
}
@media (max-width: 768px) {
    .sp-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
}
.sp-stat-value {
    font-size: clamp(30px, 3.8vw, 44px);
    font-weight: 900;
    color: var(--ap-text-primary);
    line-height: 1.1;
    margin-bottom: 6px;
    letter-spacing: -0.5px;
    font-feature-settings: "tnum";
}
.sp-stat-caption {
    font-size: 13.5px;
    color: var(--ap-text-muted);
    font-weight: 600;
}

/* ─── SECTION HEADER (Clean Typography) ─── */
.sp-section {
    padding: 72px 0;
    position: relative;
}
.sp-section-heading {
    text-align: center;
    max-width: 720px;
    margin: 0 auto 48px;
}
.sp-section-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--ap-bg-subtle);
    border: 1px solid var(--ap-border-subtle);
    color: var(--ap-text-secondary);
    font-size: 12.5px;
    font-weight: 800;
    padding: 4px 14px;
    border-radius: var(--ap-radius-full);
    margin-bottom: 14px;
}
.sp-section-title {
    font-size: clamp(24px, 3.2vw, 36px);
    font-weight: 900;
    color: var(--ap-text-primary);
    line-height: 1.35;
    margin-bottom: 14px;
    letter-spacing: -0.5px;
}
.sp-section-desc {
    font-size: 15.5px;
    color: var(--ap-text-secondary);
    line-height: 1.8;
}

/* ─── PROBLEM CARDS (Light Theme) ─── */
.sp-problems-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 36px;
}
@media (max-width: 860px) {
    .sp-problems-grid { grid-template-columns: 1fr; }
}
.sp-problem-card {
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-md);
    padding: 32px 24px;
    box-shadow: var(--ap-shadow-xs);
    transition: all 0.25s ease;
}
.sp-problem-card:hover {
    border-color: #CBD5E1;
    box-shadow: var(--ap-shadow-md);
    transform: translateY(-3px);
}
.sp-problem-icon-circle {
    width: 48px;
    height: 48px;
    background: #FEF2F2;
    color: #DC2626;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
}
.sp-problem-card-title {
    font-size: 16.5px;
    font-weight: 800;
    color: var(--ap-text-primary);
    margin-bottom: 10px;
    line-height: 1.4;
}
.sp-problem-card-desc {
    font-size: 14px;
    color: var(--ap-text-secondary);
    line-height: 1.75;
}

.sp-solution-banner {
    background: var(--ap-bg-subtle);
    border: 1px solid var(--ap-border-strong);
    border-radius: var(--ap-radius-lg);
    padding: 32px 30px;
    text-align: center;
    max-width: 860px;
    margin: 0 auto;
}
.sp-solution-banner h3 {
    font-size: 20px;
    font-weight: 900;
    color: var(--ap-blue-primary);
    margin-bottom: 10px;
}
.sp-solution-banner p {
    font-size: 15px;
    color: var(--ap-text-secondary);
    line-height: 1.8;
}

/* ─── DEFINITION SECTION (White / Slate Cards) ─── */
.sp-definition-section {
    background: var(--ap-bg-subtle);
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-lg);
    padding: 48px 36px;
    margin: 36px 0;
}
@media (max-width: 768px) {
    .sp-definition-section { padding: 32px 20px; }
}
.sp-def-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
@media (max-width: 860px) {
    .sp-def-grid { grid-template-columns: 1fr; }
}
.sp-def-card {
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-md);
    padding: 30px 22px;
    text-align: center;
    box-shadow: var(--ap-shadow-xs);
    transition: all 0.25s;
}
.sp-def-card:hover {
    border-color: var(--ap-blue-primary);
    box-shadow: var(--ap-shadow-md);
    transform: translateY(-3px);
}
.sp-def-num-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: var(--ap-blue-subtle);
    color: var(--ap-blue-primary);
    font-weight: 900;
    border-radius: 50%;
    margin-bottom: 16px;
    font-size: 15px;
}
.sp-def-card-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--ap-text-primary);
    margin-bottom: 10px;
}
.sp-def-card-desc {
    font-size: 14px;
    color: var(--ap-text-secondary);
    line-height: 1.75;
}

/* ─── FOUNDER STORY (Apple Executive Card) ─── */
.sp-story-card {
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-lg);
    padding: 40px;
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 40px;
    align-items: center;
    box-shadow: var(--ap-shadow-sm);
    margin: 44px 0;
}
@media (max-width: 860px) {
    .sp-story-card {
        grid-template-columns: 1fr;
        text-align: center;
        padding: 30px 20px;
    }
}
.sp-story-avatar {
    width: 170px;
    height: 170px;
    border-radius: var(--ap-radius-md);
    object-fit: cover;
    border: 1px solid var(--ap-border-subtle);
    box-shadow: var(--ap-shadow-sm);
    margin: 0 auto 12px;
    display: block;
}
.sp-story-author-name {
    font-size: 17px;
    font-weight: 900;
    color: var(--ap-text-primary);
}
.sp-story-author-title {
    font-size: 12.5px;
    color: var(--ap-text-muted);
    font-weight: 600;
}
.sp-story-quote-block {
    background: var(--ap-bg-subtle);
    border-right: 4px solid var(--ap-blue-primary);
    padding: 18px 22px;
    border-radius: 0 var(--ap-radius-sm) var(--ap-radius-sm) 0;
    margin-bottom: 16px;
    font-size: 15.5px;
    font-weight: 600;
    color: var(--ap-text-primary);
    line-height: 1.8;
}
.sp-story-body {
    font-size: 15px;
    color: var(--ap-text-secondary);
    line-height: 1.9;
}

/* ─── STORIES & REELS SHOWCASE (Light Card with Clean Video Play) ─── */
.sp-reels-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
@media (max-width: 992px) {
    .sp-reels-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 520px) {
    .sp-reels-grid { grid-template-columns: 1fr; }
}

.sp-reel-card {
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-md);
    overflow: hidden;
    cursor: pointer;
    box-shadow: var(--ap-shadow-xs);
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
}
.sp-reel-card:hover {
    border-color: var(--ap-blue-primary);
    box-shadow: var(--ap-shadow-md);
    transform: translateY(-4px);
}
.sp-reel-thumb-wrap {
    height: 220px;
    position: relative;
    background: #0F172A;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.sp-reel-thumb-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.88);
    transition: transform 0.35s ease;
}
.sp-reel-card:hover .sp-reel-thumb-wrap img {
    transform: scale(1.05);
    filter: brightness(0.95);
}
.sp-reel-play-icon {
    position: absolute;
    width: 46px;
    height: 46px;
    background: rgba(255, 255, 255, 0.95);
    color: var(--ap-blue-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    transition: transform 0.2s;
}
.sp-reel-card:hover .sp-reel-play-icon {
    transform: scale(1.12);
}
.sp-reel-tag {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(15, 23, 42, 0.85);
    color: #FFFFFF;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: var(--ap-radius-full);
}
.sp-reel-info {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.sp-reel-stars-row {
    display: flex;
    gap: 3px;
    color: #F59E0B;
    margin-bottom: 6px;
}
.sp-reel-author-title {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--ap-text-primary);
    margin-bottom: 2px;
}
.sp-reel-author-sub {
    font-size: 12px;
    color: var(--ap-text-muted);
    margin-bottom: 8px;
}
.sp-reel-quote-text {
    font-size: 13px;
    color: var(--ap-text-secondary);
    line-height: 1.65;
    margin-top: auto;
}

/* ─── BONUSES BUNDLE SECTION (Clean Light Card) ─── */
.sp-bonus-bundle-wrap {
    background: #FFFFFF;
    border: 2px solid var(--ap-blue-primary);
    border-radius: var(--ap-radius-lg);
    padding: 48px 36px;
    box-shadow: var(--ap-shadow-md);
    margin: 48px 0;
}
@media (max-width: 768px) {
    .sp-bonus-bundle-wrap { padding: 32px 20px; }
}

.sp-bonus-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin: 32px 0;
}
@media (max-width: 992px) {
    .sp-bonus-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 540px) {
    .sp-bonus-grid { grid-template-columns: 1fr; }
}

.sp-bonus-item-card {
    background: var(--ap-bg-subtle);
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-md);
    padding: 24px 18px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.sp-bonus-icon-box {
    width: 48px;
    height: 48px;
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ap-blue-primary);
    margin-bottom: 12px;
    box-shadow: var(--ap-shadow-xs);
}
.sp-bonus-tag-label {
    background: var(--ap-blue-primary);
    color: #FFFFFF;
    font-size: 11px;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: var(--ap-radius-full);
    margin-bottom: 8px;
}
.sp-bonus-name {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--ap-text-primary);
    margin-bottom: 6px;
}
.sp-bonus-desc {
    font-size: 12.5px;
    color: var(--ap-text-secondary);
    line-height: 1.6;
}
.sp-bonus-free-badge {
    margin-top: auto;
    padding-top: 10px;
    font-size: 12px;
    color: var(--ap-emerald);
    font-weight: 800;
}

/* ─── 3 STEPS SECTION ─── */
.sp-steps-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin: 36px 0;
}
@media (max-width: 860px) {
    .sp-steps-grid { grid-template-columns: 1fr; }
}
.sp-step-card {
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-md);
    padding: 32px 24px;
    text-align: center;
    box-shadow: var(--ap-shadow-xs);
    position: relative;
}
.sp-step-number-tag {
    position: absolute;
    top: -12px;
    right: 24px;
    background: var(--ap-text-primary);
    color: #FFFFFF;
    font-weight: 800;
    font-size: 11.5px;
    padding: 2px 12px;
    border-radius: var(--ap-radius-full);
}
.sp-step-icon-wrap {
    width: 52px;
    height: 52px;
    background: var(--ap-bg-subtle);
    color: var(--ap-blue-primary);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 8px auto 16px;
}
.sp-step-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--ap-text-primary);
    margin-bottom: 10px;
}
.sp-step-desc {
    font-size: 14px;
    color: var(--ap-text-secondary);
    line-height: 1.75;
}

/* ─── COMPARISON TABLE (Apple Minimalist Table) ─── */
.sp-table-card {
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-lg);
    overflow-x: auto;
    box-shadow: var(--ap-shadow-xs);
    margin: 32px 0;
}
.sp-apple-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 620px;
}
.sp-apple-table th {
    padding: 18px 24px;
    font-size: 14px;
    font-weight: 800;
    text-align: center;
    border-bottom: 1px solid var(--ap-border-subtle);
}
.sp-apple-table th:first-child { text-align: right; }
.sp-apple-table th.col-scripox {
    background: var(--ap-blue-subtle);
    color: var(--ap-blue-primary);
}
.sp-apple-table th.col-others {
    background: #FFFFFF;
    color: var(--ap-text-muted);
}
.sp-apple-table td {
    padding: 16px 24px;
    font-size: 14px;
    border-bottom: 1px solid var(--ap-border-subtle);
    color: var(--ap-text-secondary);
}
.sp-apple-table td.td-scripox {
    background: rgba(37, 99, 235, 0.03);
    color: var(--ap-emerald);
    font-weight: 800;
    text-align: center;
}
.sp-apple-table td.td-others {
    color: var(--ap-text-muted);
    text-align: center;
}

/* ─── CHECKOUT SECTION (Clean Light Card) ─── */
.sp-checkout-section {
    padding: 64px 0;
    position: relative;
    background: var(--ap-bg-subtle);
    border-top: 1px solid var(--ap-border-subtle);
    border-bottom: 1px solid var(--ap-border-subtle);
}
.sp-checkout-box {
    max-width: 760px;
    margin: 0 auto;
    background: #FFFFFF;
    border: 1.5px solid var(--ap-border-strong);
    border-radius: var(--ap-radius-lg);
    padding: 44px;
    box-shadow: var(--ap-shadow-lg);
}
@media (max-width: 768px) {
    .sp-checkout-box { padding: 26px 18px; }
}

/* Big Price Card */
.sp-price-display-banner {
    background: var(--ap-bg-subtle);
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-md);
    padding: 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}
.sp-price-row {
    display: flex;
    align-items: baseline;
    gap: 12px;
    flex-wrap: wrap;
}
.sp-price-large-amount {
    font-size: 48px;
    font-weight: 900;
    color: var(--ap-text-primary);
    line-height: 1;
    letter-spacing: -1px;
}
.sp-price-currency {
    font-size: 18px;
    font-weight: 800;
    color: var(--ap-blue-primary);
}
.sp-price-sar-equiv {
    font-size: 14.5px;
    color: var(--ap-text-secondary);
    font-weight: 700;
}
.sp-price-crossed {
    font-size: 18px;
    color: var(--ap-text-muted);
    text-decoration: line-through;
}
.sp-save-pill {
    background: var(--ap-emerald-subtle);
    border: 1px solid rgba(5, 150, 105, 0.25);
    color: var(--ap-emerald);
    font-size: 12.5px;
    font-weight: 800;
    padding: 5px 14px;
    border-radius: var(--ap-radius-full);
}

/* Countdown bar (Light style) */
.sp-timer-bar {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    border-radius: var(--ap-radius-sm);
    padding: 10px 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 24px;
    flex-wrap: wrap;
    font-size: 13px;
    font-weight: 700;
    color: #991B1B;
}
.sp-timer-digits-wrap {
    display: flex;
    gap: 6px;
}
.sp-timer-digit-box {
    background: #FFFFFF;
    border: 1px solid #FCA5A5;
    color: #991B1B;
    padding: 3px 8px;
    border-radius: 6px;
    font-family: monospace;
    font-weight: 800;
    font-size: 14px;
}

/* Promo Code Box */
.sp-promo-card {
    background: var(--ap-bg-subtle);
    border: 1px dashed var(--ap-border-strong);
    border-radius: var(--ap-radius-sm);
    padding: 14px 18px;
    margin-bottom: 24px;
}
.sp-promo-card-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--ap-text-primary);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.sp-promo-inputs {
    display: flex;
    gap: 10px;
}
.sp-promo-input {
    flex: 1;
    background: #FFFFFF;
    border: 1px solid var(--ap-border-strong);
    border-radius: var(--ap-radius-sm);
    padding: 10px 14px;
    font-size: 14px;
    color: var(--ap-text-primary);
    outline: none;
    font-family: monospace;
}
.sp-promo-input:focus { border-color: var(--ap-blue-primary); }
.sp-promo-btn {
    background: var(--ap-text-primary);
    color: #FFFFFF;
    font-weight: 700;
    border: none;
    border-radius: var(--ap-radius-sm);
    padding: 0 20px;
    cursor: pointer;
    font-family: inherit;
    transition: background 0.15s;
}
.sp-promo-btn:hover { background: #000000; }
.sp-promo-alert {
    font-size: 12.5px;
    margin-top: 8px;
    display: none;
}
.sp-promo-alert.success { color: var(--ap-emerald); display: block; font-weight: 700; }
.sp-promo-alert.error   { color: #DC2626; display: block; }

/* Checkout Form inputs */
.sp-field-label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--ap-text-primary);
    margin-bottom: 6px;
}
.sp-field-input {
    width: 100%;
    background: #FFFFFF;
    border: 1px solid var(--ap-border-strong);
    border-radius: var(--ap-radius-sm);
    padding: 12px 16px;
    font-size: 14.5px;
    color: var(--ap-text-primary);
    outline: none;
    margin-bottom: 16px;
    font-family: inherit;
    transition: all 0.2s;
}
.sp-field-input:focus {
    border-color: var(--ap-blue-primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

/* Gateway selection */
.sp-gateway-selector {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 20px;
}
.sp-gateway-tab {
    padding: 12px;
    border-radius: var(--ap-radius-sm);
    border: 1.5px solid var(--ap-border-subtle);
    background: var(--ap-bg-subtle);
    color: var(--ap-text-secondary);
    font-size: 13px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
}
.sp-gateway-tab.active {
    border-color: var(--ap-blue-primary);
    background: var(--ap-blue-subtle);
    color: var(--ap-blue-primary);
    font-weight: 800;
}

.sp-pay-submit-btn {
    width: 100%;
    padding: 18px;
    border-radius: var(--ap-radius-full);
    background: var(--ap-blue-primary);
    color: #FFFFFF;
    border: none;
    font-size: 17px;
    font-weight: 800;
    font-family: inherit;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.sp-pay-submit-btn:hover {
    background: var(--ap-blue-hover);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
}
.sp-pay-submit-btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
}

.sp-wa-help-row {
    margin-top: 18px;
    text-align: center;
    font-size: 13px;
    color: var(--ap-text-muted);
}
.sp-wa-help-row a {
    color: var(--ap-emerald);
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.sp-wa-help-row a:hover {
    text-decoration: underline;
}

/* ─── GUARANTEE CARD ─── */
.sp-guarantee-card {
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-lg);
    padding: 32px;
    margin: 32px 0 0;
    display: flex;
    align-items: center;
    gap: 24px;
    box-shadow: var(--ap-shadow-xs);
}
@media (max-width: 680px) {
    .sp-guarantee-card { flex-direction: column; text-align: center; }
}
.sp-guarantee-shield-wrap {
    width: 64px;
    height: 64px;
    background: var(--ap-emerald-subtle);
    border: 1px solid rgba(5, 150, 105, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ap-emerald);
    flex-shrink: 0;
}
.sp-guarantee-heading {
    font-size: 19px;
    font-weight: 800;
    color: var(--ap-emerald);
    margin-bottom: 6px;
}
.sp-guarantee-text {
    font-size: 14px;
    color: var(--ap-text-secondary);
    line-height: 1.75;
}

/* ─── FAQ ACCORDION (Light Clean Style) ─── */
.sp-faq-container {
    max-width: 820px;
    margin: 0 auto;
}
.sp-faq-row {
    background: #FFFFFF;
    border: 1px solid var(--ap-border-subtle);
    border-radius: var(--ap-radius-md);
    margin-bottom: 12px;
    overflow: hidden;
    transition: border-color 0.2s;
}
.sp-faq-row.open {
    border-color: var(--ap-blue-primary);
}
.sp-faq-question-btn {
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    font-size: 15.5px;
    font-weight: 800;
    color: var(--ap-text-primary);
    user-select: none;
    transition: background 0.15s;
}
.sp-faq-question-btn:hover {
    background: var(--ap-bg-subtle);
}
.sp-faq-chevron {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--ap-bg-subtle);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ap-text-secondary);
    transition: transform 0.25s;
}
.sp-faq-row.open .sp-faq-chevron {
    transform: rotate(180deg);
    background: var(--ap-blue-subtle);
    color: var(--ap-blue-primary);
}
.sp-faq-answer-body {
    padding: 0 24px;
    max-height: 0;
    overflow: hidden;
    font-size: 14px;
    color: var(--ap-text-secondary);
    line-height: 1.8;
    transition: max-height 0.3s ease, padding 0.3s ease;
}
.sp-faq-row.open .sp-faq-answer-body {
    max-height: 280px;
    padding: 0 24px 20px;
}

/* ─── STICKY MOBILE BOTTOM BAR (Light Apple Style) ─── */
.sp-mobile-sticky-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-top: 1px solid var(--ap-border-subtle);
    padding: 10px 16px;
    z-index: 9999;
    display: none;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
}
@media (max-width: 768px) {
    .sp-mobile-sticky-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
}
.sp-mobile-price-group {
    display: flex;
    flex-direction: column;
}
.sp-mobile-price-val {
    font-size: 22px;
    font-weight: 900;
    color: var(--ap-text-primary);
    line-height: 1;
}
.sp-mobile-price-note {
    font-size: 11px;
    color: var(--ap-text-muted);
}
.sp-mobile-actions-group {
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
    justify-content: flex-end;
}
.sp-mobile-cta-btn {
    background: var(--ap-blue-primary);
    color: #FFFFFF !important;
    font-size: 14px;
    font-weight: 800;
    padding: 12px 18px;
    border-radius: var(--ap-radius-full);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 10px rgba(37, 99, 235, 0.25);
    white-space: nowrap;
}
.sp-mobile-wa-btn {
    background: #25D366;
    color: #FFFFFF !important;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    flex-shrink: 0;
}
</style>

<div class="sp-apple-page">

    {{-- Top Urgency Ribbon --}}
    @if($promoActive)
        <div class="sp-top-ribbon">
            <span class="sp-ribbon-tag">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                السوق السعودي والخليجي
            </span>
            <span>عرض إطلاق ScripOx الحصري: احصل على ترخيصك الدائم بـ <strong>5$ فقط</strong> (~19 ريال) بدلاً من 100$ بكود: <strong>LAUNCH5</strong></span>
            <a href="#checkoutSection" class="sp-ribbon-btn">اطلب نسختك الآن ←</a>
        </div>
    @endif

    <div class="sp-container">
        {{-- Breadcrumbs --}}
        <nav class="sp-breadcrumbs-bar" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">الرئيسية</a>
            <span class="sep">›</span>
            <a href="{{ route('store.index') }}">متجر البرمجيات</a>
            @if($product->category)
                <span class="sep">›</span>
                <a href="{{ route('store.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
            @endif
            <span class="sep">›</span>
            <span style="color: var(--ap-blue-primary); font-weight: 700;">{{ $product->name }}</span>
        </nav>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         1. HERO BANNER (class="sp-hero-banner") Apple & Google Style
         ═══════════════════════════════════════════════════════════════════ --}}
    <section class="sp-hero-banner">
        <div class="sp-container">
            <div class="sp-hero-grid">

                {{-- Left Column: Copy & Actions --}}
                <div>
                    <div class="sp-pill-badge">
                        <span class="sp-pill-dot"></span>
                        <span>البرنامج الرائد لأصحاب المتاجر ورواد الأعمال في السعودية</span>
                    </div>

                    <h1 class="sp-hero-title">
                        توقّف عن إهدار ميزانيتك على <span class="sp-hl-blue">إعلانات غير مستهدفة</span>.
                        <br>
                        استخرج بيانات عملائك الحقيقيين واستهدف من يشتري فقط.
                    </h1>

                    <p class="sp-hero-subtitle">
                        بدون اشتراكات شهرية متكررة وبدون أي تعقيد برمجي.. <strong>ScripOx</strong> يجمع لك أرقام وايميلات المهتمين بنشاطك من كبرى المنصات ويجهز لك جمهورك الإعلاني لـ Meta وGoogle في دقائق معدودة.
                    </p>

                    <div class="sp-hero-actions">
                        <a href="#checkoutSection" class="sp-btn-apple-primary">
                            <span>احصل على نسختك الآن (5$ فقط)</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        </a>
                        <button type="button" class="sp-btn-apple-secondary" onclick="openVideoModal('{{ asset('assets/videos/story-1.mp4') }}', true)">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            <span>شاهد العرض التوضيحي</span>
                        </button>
                    </div>

                    <div class="sp-trust-strip">
                        <span>
                            <svg class="sp-icon-check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            ترخيص دائم مدى الحياة
                        </span>
                        <span>
                            <svg class="sp-icon-check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            بدون اشتراكات شهرية
                        </span>
                        <span>
                            <svg class="sp-icon-check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            ضمان استرجاع 14 يوماً
                        </span>
                    </div>
                </div>

                {{-- Right Column: Croquis Mockup (Apple Minimalist UI) --}}
                <div>
                    <div class="sp-app-mockup-card">
                        <div class="sp-mockup-header">
                            <div class="sp-mockup-dots">
                                <span class="sp-mockup-dot sp-dot-red"></span>
                                <span class="sp-mockup-dot sp-dot-yellow"></span>
                                <span class="sp-mockup-dot sp-dot-green"></span>
                            </div>
                            <span class="sp-mockup-label">ScripOx Architecture v1.0</span>
                        </div>

                        {{-- Flow Diagram (Croquis Clean Vector) --}}
                        <div class="sp-croquis-flow">
                            <div class="sp-croquis-block">
                                <div class="sp-croquis-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><line x1="21.17" y1="8" x2="12" y2="8"/><line x1="3.95" y1="6.06" x2="8.54" y2="14"/><line x1="10.88" y1="21.94" x2="15.46" y2="14"/></svg>
                                </div>
                                <div class="sp-croquis-block-title">Chrome Extension</div>
                                <div class="sp-croquis-block-desc">استخراج فوري للبيانات من المنصات والخرائط</div>
                            </div>

                            <div class="sp-flow-arrow">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                            </div>

                            <div class="sp-croquis-block">
                                <div class="sp-croquis-icon-wrap" style="background:#ECFDF5; color:#059669;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                </div>
                                <div class="sp-croquis-block-title">Studio Desktop</div>
                                <div class="sp-croquis-block-desc">فلترة جغرافية وخرائط وتجهيز الجمهور</div>
                            </div>
                        </div>

                        <div class="sp-croquis-output-banner">
                            <span style="display:flex; align-items:center; gap:8px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                ملف جمهور مخصص جاهز لـ Meta Ads & Google Ads
                            </span>
                            <span>100% معتمد</span>
                        </div>

                        <div class="sp-mockup-badges-row">
                            <span class="sp-mockup-mini-badge">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                الرياض • جدة • مكة • دبي
                            </span>
                            <span class="sp-mockup-mini-badge" style="color:var(--ap-emerald);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                توفير 78% من التكلفة
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════
         2. STATS SECTION (Minimalist Social Proof)
         ═══════════════════════════════════════════════════════════════════ --}}
    <section class="sp-stats-section">
        <div class="sp-container">
            <div class="sp-stats-grid">
                <div>
                    <div class="sp-stat-value">+2,000</div>
                    <div class="sp-stat-caption">متجر ومسوق في السعودية والخليج</div>
                </div>
                <div>
                    <div class="sp-stat-value">+850K</div>
                    <div class="sp-stat-caption">عميل تم استخراج بياناتهم بنجاح</div>
                </div>
                <div>
                    <div class="sp-stat-value">78%</div>
                    <div class="sp-stat-caption">متوسط توفير ميزانية الإعلانات</div>
                </div>
                <div>
                    <div class="sp-stat-value">4.9 / 5</div>
                    <div class="sp-stat-caption">تقييم رضا العملاء وأصحاب المتاجر</div>
                </div>
            </div>
        </div>
    </section>

    <div class="sp-container">

        {{-- ═══════════════════════════════════════════════════════════════════
             3. SECTION: THE PAIN / التحديات بلغة مبسطة
             ═══════════════════════════════════════════════════════════════════ --}}
        <section class="sp-section">
            <div class="sp-section-heading">
                <span class="sp-section-pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    التحدي الحقيقي
                </span>
                <h2 class="sp-section-title">لماذا تخسر معظم الحملات الإعلانية ميزانياتها؟</h2>
                <p class="sp-section-desc">المشكلة ليست في منتجك ولا في متجرك، بل في الاعتماد على الطرق التقليدية في الاستهداف:</p>
            </div>

            <div class="sp-problems-grid">
                <div class="sp-problem-card">
                    <div class="sp-problem-icon-circle">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M16 8l-8 8"/><path d="M8 8l8 8"/></svg>
                    </div>
                    <h3 class="sp-problem-card-title">1. الإنفاق على جمهور عشوائي</h3>
                    <p class="sp-problem-card-desc">
                        الاستهداف الواسع (Broad) يجعل منصات الإعلانات تعرض إعلانك لأشخاص غير مهتمين بالمرة، مما يستهلك ميزانيتك دون تحقيق مبيعات فعلية.
                    </p>
                </div>

                <div class="sp-problem-card">
                    <div class="sp-problem-icon-circle">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    </div>
                    <h3 class="sp-problem-card-title">2. غياب قاعدة بيانات خاصة بنشاطك</h3>
                    <p class="sp-problem-card-desc">
                        بدون امتلاك أرقام وايميلات العملاء المهتمين بنشاطك، تضطر لإعادة الدفع للمنصات الإعلانية في كل مرة تريد فيها الوصول إليهم مجدداً.
                    </p>
                </div>

                <div class="sp-problem-card">
                    <div class="sp-problem-icon-circle">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <h3 class="sp-problem-card-title">3. اشتراكات شهرية باهظة وتعقيد تقني</h3>
                    <p class="sp-problem-card-desc">
                        الأدوات العالمية تفرض رسوماً شهرية مستمرة تتراوح بين 500 إلى 2,000 ريال شهرياً، مع واجهات معقدة تتطلب خبرة برمجية واسعة.
                    </p>
                </div>
            </div>

            <div class="sp-solution-banner">
                <h3>الحل الهندسي المباشر مع ScripOx</h3>
                <p>
                    بدل التخمين ودفع الأموال عشوائياً، استخرج بيانات الجمهور المهتم فعلياً بمجالك، واجعل إعلاناتك تظهر أمامهم تحديداً. وفر حتى 80% من الميزانية وحقق عائد استثمار حقيقي.
                </p>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════════
             4. SECTION: تعريف البرنامج (Clean Architecture Cards)
             ═══════════════════════════════════════════════════════════════════ --}}
        <section class="sp-definition-section">
            <div class="sp-section-heading" style="margin-bottom:32px;">
                <span class="sp-section-pill">بساطة الاستخدام</span>
                <h2 class="sp-section-title">كيف يعمل البرنامج؟</h2>
                <p class="sp-section-desc">صُمم ScripOx ليمنحك قوة هندسية كاملة عبر واجهة سلسة وبديهية:</p>
            </div>

            <div class="sp-def-grid">
                <div class="sp-def-card">
                    <div class="sp-def-num-pill">1</div>
                    <h3 class="sp-def-card-title">إضافة المتصفح (Chrome Extension)</h3>
                    <p class="sp-def-card-desc">
                        تثبيت فوري بنقرة واحدة. تعمل مباشرة على منصاتك المفضلة (انستقرام، لينكد إن، مجموعات، خرائط جوجل) لاستخراج بيانات المهتمين بضغطة زر.
                    </p>
                </div>

                <div class="sp-def-card">
                    <div class="sp-def-num-pill">2</div>
                    <h3 class="sp-def-card-title">استوديو سطح المكتب (ScripOx Studio)</h3>
                    <p class="sp-def-card-desc">
                        ينظم بيانات العملاء في بطاقات واضحة، مع خريطة تفاعلية لتحديد مواقعهم في مدن المملكة والخليج والفلترة الجغرافية المتقدمة.
                    </p>
                </div>

                <div class="sp-def-card">
                    <div class="sp-def-num-pill">3</div>
                    <h3 class="sp-def-card-title">تصدير الجمهور المخصص المعتمد</h3>
                    <p class="sp-def-card-desc">
                        تصدير مباشر لملفات Custom Audience الرسمية لـ Meta وGoogle، مشفرة وجاهزة للرفع الفوري داخل مدير الإعلانات.
                    </p>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════════
             5. SECTION: FOUNDER STORY (Apple Style Story Card)
             ═══════════════════════════════════════════════════════════════════ --}}
        <div class="sp-story-card">
            <div style="text-align:center;">
                <img src="{{ asset('assets/ox-saudi-founder-video.webp') }}" 
                     alt="مؤسس البرنامج" 
                     class="sp-story-avatar"
                     onerror="this.src='{{ asset('assets/ahmedga.jpg') }}'">
                <div class="sp-story-author-name">م. أحمد عبد الفتاح</div>
                <div class="sp-story-author-title">خبير البرمجيات ومؤسس OX Tech</div>
            </div>

            <div>
                <div class="sp-story-quote-block">
                    "المشروع انطلق من تجربة حقيقية في إدارة الحملات التسويقية.. السؤال كان بسيطاً: لماذا نتحمل تكاليف إعلانات باهظة بينما يمكننا الوصول للجمهور المهتم مباشرة؟"
                </div>
                <p class="sp-story-body">
                    قمنا ببناء <strong>ScripOx</strong> ليكون الأداة التي يحتاجها كل تاجر ومسوق رقمي في السعودية والخليج. هدفنا ليس مجرد بيع برنامج، بل تمكين أصحاب الأعمال من بناء أصول بيانات خاصة بهم، وخفض تكاليف الإعلانات دون الحاجة لاشتراكات شهرية متكررة أو تعقيدات تقنية.
                </p>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════════
             6. SECTION: تجارب العملاء (Clean Video Stories & Reels)
             ═══════════════════════════════════════════════════════════════════ --}}
        <section class="sp-section">
            <div class="sp-section-heading">
                <span class="sp-section-pill">آراء وتجارب</span>
                <h2 class="sp-section-title">تجارب حقيقية لنتائج الاستهداف الدقيق</h2>
                <p class="sp-section-desc">اضغط على أي تجربة لمشاهدة فيديو الاستعراض والنتائج المحققة:</p>
            </div>

            <div class="sp-reels-grid">
                {{-- Reel 1 --}}
                <div class="sp-reel-card" onclick="openVideoModal('{{ asset('assets/videos/story-1.mp4') }}', true)">
                    <div class="sp-reel-thumb-wrap">
                        <img src="{{ asset('assets/ox-saudi-story.webp') }}" alt="تجربة أبو فهد" onerror="this.src='{{ asset('assets/ox-hero-saudi-egypt.webp') }}'">
                        <div class="sp-reel-tag">متجر عطور • الرياض</div>
                        <div class="sp-reel-play-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        </div>
                    </div>
                    <div class="sp-reel-info">
                        <div class="sp-reel-stars-row">
                            @for($i=0;$i<5;$i++)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endfor
                        </div>
                        <div class="sp-reel-author-title">أبو فهد العتيبي</div>
                        <div class="sp-reel-author-sub">متجر عطور فاخرة — الرياض</div>
                        <p class="sp-reel-quote-text">
                            "استخرجت بيانات المهتمين بالعطور، وتكلفة الطلب انخفضت من 42 ريال إلى 8.5 ريال فقط بفضل الاستهداف المباشر."
                        </p>
                    </div>
                </div>

                {{-- Reel 2 --}}
                <div class="sp-reel-card" onclick="openVideoModal('{{ asset('assets/videos/story-2.mp4') }}', true)">
                    <div class="sp-reel-thumb-wrap">
                        <img src="{{ asset('assets/ox-saudi-founder-video.webp') }}" alt="تجربة م. سلطان" onerror="this.src='{{ asset('assets/ox-hero-skyline.webp') }}'">
                        <div class="sp-reel-tag">تسويق عقاري • جدة</div>
                        <div class="sp-reel-play-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        </div>
                    </div>
                    <div class="sp-reel-info">
                        <div class="sp-reel-stars-row">
                            @for($i=0;$i<5;$i++)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endfor
                        </div>
                        <div class="sp-reel-author-title">م. سلطان الشمري</div>
                        <div class="sp-reel-author-sub">مسوق ومطور عقاري — جدة</div>
                        <p class="sp-reel-quote-text">
                            "الخريطة التفاعلية بالبرنامج ساعدتني في تحديد المهتمين بالعقار في شمال جدة بدقة، وأغلقت 3 صفقات في أول أسبوعين."
                        </p>
                    </div>
                </div>

                {{-- Reel 3 --}}
                <div class="sp-reel-card" onclick="openVideoModal('{{ asset('assets/videos/story-3.mp4') }}', true)">
                    <div class="sp-reel-thumb-wrap">
                        <img src="{{ asset('assets/ox-hero-gathering.webp') }}" alt="تجربة أميرة" onerror="this.src='{{ asset('assets/ox-hero.webp') }}'">
                        <div class="sp-reel-tag">أزياء وعبايات • الدمام</div>
                        <div class="sp-reel-play-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        </div>
                    </div>
                    <div class="sp-reel-info">
                        <div class="sp-reel-stars-row">
                            @for($i=0;$i<5;$i++)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endfor
                        </div>
                        <div class="sp-reel-author-title">أميرة الدوسري</div>
                        <div class="sp-reel-author-sub">متجر عبايات وأزياء — الدمام</div>
                        <p class="sp-reel-quote-text">
                            "الشرح التدريبي بالفيديو كان واضحاً للغاية، بنيت جمهوري الإعلاني في 10 دقائق دون الحاجة لشركة خارجية."
                        </p>
                    </div>
                </div>

                {{-- Reel 4 --}}
                <div class="sp-reel-card" onclick="openVideoModal('{{ asset('assets/videos/story-1.mp4') }}', true)">
                    <div class="sp-reel-thumb-wrap">
                        <img src="{{ asset('assets/ox-hero-saudi-egypt.webp') }}" alt="تجربة فيصل" onerror="this.src='{{ asset('assets/ox-saudi-story.webp') }}'">
                        <div class="sp-reel-tag">خدمات وصيانة • الخبر</div>
                        <div class="sp-reel-play-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        </div>
                    </div>
                    <div class="sp-reel-info">
                        <div class="sp-reel-stars-row">
                            @for($i=0;$i<5;$i++)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endfor
                        </div>
                        <div class="sp-reel-author-title">فيصل بن ناصر</div>
                        <div class="sp-reel-author-sub">مركز خدمات وصيانة — الخبر</div>
                        <p class="sp-reel-quote-text">
                            "الترخيص الدائم بدون اشتراك شهري يجعله أفضل استثمار قمت به لمتجري هذا العام."
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════════
             7. SECTION: الحزمة والبونص (Minimalist Bonus Box)
             ═══════════════════════════════════════════════════════════════════ --}}
        <section class="sp-bonus-bundle-wrap">
            <div class="sp-section-heading" style="margin-bottom:24px;">
                <span class="sp-section-pill" style="background:var(--ap-blue-subtle); color:var(--ap-blue-primary);">حزمة متكاملة</span>
                <h2 class="sp-section-title">ما ستحصل عليه فور الاشتراك في ScripOx</h2>
                <p class="sp-section-desc">تحصل على المنظومة البرمجية الكاملة مع حزمة تدريبية ودعم مباشر بقيمة تتجاوز 1,500 ريال:</p>
            </div>

            <div class="sp-bonus-grid">
                <div class="sp-bonus-item-card">
                    <div class="sp-bonus-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <span class="sp-bonus-tag-label">البرنامج الأساسي</span>
                    <h3 class="sp-bonus-name">ترخيص دائم لـ ScripOx</h3>
                    <p class="sp-bonus-desc">إضافة المتصفح + برنامج Studio المكتبي مدى الحياة مع كافة التحديثات المستقبلية.</p>
                    <div class="sp-bonus-free-badge">القيمة: 375 ريال</div>
                </div>

                <div class="sp-bonus-item-card">
                    <div class="sp-bonus-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                    </div>
                    <span class="sp-bonus-tag-label">هدية مجانية 1</span>
                    <h3 class="sp-bonus-name">كورس فيديو تدريبي تطبيقي</h3>
                    <p class="sp-bonus-desc">دليل تدريبي مرئي يشرح كيفية بناء ورفع أول جمهور إعلاني مخصص خطوة بخطوة.</p>
                    <div class="sp-bonus-free-badge">القيمة: 450 ريال (مجاناً اليوم)</div>
                </div>

                <div class="sp-bonus-item-card">
                    <div class="sp-bonus-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <span class="sp-bonus-tag-label">هدية مجانية 2</span>
                    <h3 class="sp-bonus-name">قاعدة 10,000 مهتم تجريبية</h3>
                    <p class="sp-bonus-desc">ملف جاهز لـ 10,000 مستهلك مهتم بالتسوق الإلكتروني في السعودية لاختبار النتائج فوراً.</p>
                    <div class="sp-bonus-free-badge">القيمة: 500 ريال (مجاناً اليوم)</div>
                </div>

                <div class="sp-bonus-item-card">
                    <div class="sp-bonus-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    </div>
                    <span class="sp-bonus-tag-label">هدية مجانية 3</span>
                    <h3 class="sp-bonus-name">دعم فني واستشاري بالواتساب</h3>
                    <p class="sp-bonus-desc">قناة دعم مباشر لمساعدتك في إعداد البرنامج والإجابة عن أي استفسار.</p>
                    <div class="sp-bonus-free-badge">القيمة: 300 ريال (مجاناً اليوم)</div>
                </div>
            </div>

            <div style="text-align:center;">
                <a href="#checkoutSection" class="sp-btn-apple-primary">
                    <span>احصل على الحزمة كاملة بـ 5$ فقط ←</span>
                </a>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════════
             8. SECTION: طريقة العمل في 3 خطوات
             ═══════════════════════════════════════════════════════════════════ --}}
        <section class="sp-section">
            <div class="sp-section-heading">
                <span class="sp-section-pill">خطوات التنفيذ</span>
                <h2 class="sp-section-title">كيف تبدأ في 3 خطوات بسيطة؟</h2>
                <p class="sp-section-desc">سير عمل هندسي مصمم لتوفير الوقت والجهد:</p>
            </div>

            <div class="sp-steps-grid">
                <div class="sp-step-card">
                    <span class="sp-step-number-tag">الخطوة 1</span>
                    <div class="sp-step-icon-wrap">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    </div>
                    <h3 class="sp-step-title">1. التثبيت في دقيقتين</h3>
                    <p class="sp-step-desc">
                        بعد تأكيد الطلب، يصلك رابط التنزيل المباشر ومفتاح الترخيص الخاص بك لبريدك ولواتسابك.
                    </p>
                </div>

                <div class="sp-step-card">
                    <span class="sp-step-number-tag">الخطوة 2</span>
                    <div class="sp-step-icon-wrap">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                    </div>
                    <h3 class="sp-step-title">2. تحديد الجمهور والاستخراج</h3>
                    <p class="sp-step-desc">
                        افتح المنصة المستهدفة وانقر زر الاستخراج التلقائي ليقوم البرنامج بجمع وتنسيق البيانات فوراً.
                    </p>
                </div>

                <div class="sp-step-card">
                    <span class="sp-step-number-tag">الخطوة 3</span>
                    <div class="sp-step-icon-wrap">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </div>
                    <h3 class="sp-step-title">3. رفع الجمهور وبدء الإعلان</h3>
                    <p class="sp-step-desc">
                        ارفع الملف المعتمد داخل مدير إعلانات فيسبوك أو جوجل، واطلق حملتك مباشرة لمن يهتم بنشاطك فقط.
                    </p>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════════
             9. SECTION: جدول المقارنة (Apple Minimalist Table)
             ═══════════════════════════════════════════════════════════════════ --}}
        <section class="sp-section">
            <div class="sp-section-heading">
                <span class="sp-section-pill">المقارنة التقنية</span>
                <h2 class="sp-section-title">الفارق بين ScripOx والبدائل التقليدية</h2>
            </div>

            <div class="sp-table-card">
                <table class="sp-apple-table">
                    <thead>
                        <tr>
                            <th>المعيار</th>
                            <th class="col-scripox">ScripOx</th>
                            <th class="col-others">الأدوات والطرق التقليدية</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>نموذج التسعير</strong></td>
                            <td class="td-scripox">دفع مرة واحدة فقط لمدى الحياة</td>
                            <td class="td-others">اشتراكات شهرية متكررة (500–2,000 ريال/شهر)</td>
                        </tr>
                        <tr>
                            <td><strong>سهولة الاستخدام</strong></td>
                            <td class="td-scripox">واجهة بديهية وخطوات واضحة باللغة العربية</td>
                            <td class="td-others">واجهات إنجليزية معقدة تتطلب تدريباً طويلاً</td>
                        </tr>
                        <tr>
                            <td><strong>التحليل الجغرافي والخرائط</strong></td>
                            <td class="td-scripox">مدمج بالكامل للمدن السعودية والخليجية</td>
                            <td class="td-others">غير متوفر أو يتطلب إضافات مدفوعة</td>
                        </tr>
                        <tr>
                            <td><strong>تنسيق ملفات Custom Audience</strong></td>
                            <td class="td-scripox">جاهز ومعتمد مباشرة لـ Meta & Google</td>
                            <td class="td-others">تنسيق وتشفير يدوي يستهلك ساعات</td>
                        </tr>
                        <tr>
                            <td><strong>الدعم الفني</strong></td>
                            <td class="td-scripox">دعم فني مباشر بالواتساب باللغة العربية</td>
                            <td class="td-others">تذاكر إلكترونية وردود متأخرة بالإنجليزية</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </div>{{-- /.sp-container --}}

    {{-- ═══════════════════════════════════════════════════════════════════
         10. SECTION: CHECKOUT & PRICING (باقة الاشتراك والشيك أوت)
         ═══════════════════════════════════════════════════════════════════ --}}
    <section class="sp-checkout-section" id="checkoutSection">
        <div class="sp-container">
            <div class="sp-checkout-box">

                <div class="sp-section-heading" style="margin-bottom:28px;">
                    <span class="sp-section-pill">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        دفع آمن وتفعيل فوري
                    </span>
                    <h2 class="sp-section-title" style="margin-bottom:8px;">امتلك ترخيص ScripOx الآن</h2>
                    <p class="sp-section-desc">ترخيص دائم للأبد + كافة الهدايا التدريبية + ضمان ذهبي 14 يوماً</p>
                </div>

                {{-- Price Display Banner --}}
                <div class="sp-price-display-banner">
                    <div>
                        <div style="font-size:13px; color:var(--ap-text-muted); margin-bottom:4px;">سعر الترخيص الدائم مع العرض:</div>
                        <div class="sp-price-row">
                            <span class="sp-price-large-amount" id="displayPrice">{{ number_format($promoActive ? $promoPrice : $normalPrice, 2) }}</span>
                            <span class="sp-price-currency">{{ $product->currency }}</span>
                            <span class="sp-price-sar-equiv">(~{{ $promoActive ? $promoPriceSar : $normalPriceSar }} ريال سعودي)</span>
                            <span class="sp-price-crossed">{{ number_format($normalPrice, 2) }} {{ $product->currency }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="sp-save-pill" id="displaySave">
                            {{ $promoActive ? 'وفرت 95% اليوم' : 'عرض خاص' }}
                        </span>
                    </div>
                </div>

                {{-- Countdown Bar --}}
                @if($promoActive)
                    <div class="sp-timer-bar">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>ينتهي هذا العرض الحصري خلال:</span>
                        <div class="sp-timer-digits-wrap">
                            <span class="sp-timer-digit-box" id="cd-days">00</span><span>يوم</span>
                            <span class="sp-timer-digit-box" id="cd-hours">00</span><span>ساعة</span>
                            <span class="sp-timer-digit-box" id="cd-mins">00</span><span>دقيقة</span>
                            <span class="sp-timer-digit-box" id="cd-secs">00</span><span>ثانية</span>
                        </div>
                    </div>

                    {{-- Promo Input Strip --}}
                    <div class="sp-promo-card">
                        <div class="sp-promo-card-title">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            <span>كود الخصم الحصري (LAUNCH5) للحصول على السعر الخاص (5$ بدل 100$):</span>
                        </div>
                        <div class="sp-promo-inputs">
                            <input type="text" 
                                   id="promoInput" 
                                   class="sp-promo-input" 
                                   value="LAUNCH5" 
                                   placeholder="أدخل الكود هنا…"
                                   onkeydown="if(event.key==='Enter'){event.preventDefault();applyPromo();}">
                            <button type="button" class="sp-promo-btn" onclick="applyPromo()">تطبيق الكود</button>
                        </div>
                        <div id="promoMsg" class="sp-promo-alert success">تم تطبيق كود LAUNCH5 بنجاح! السعر مخفض لـ 5$ فقط.</div>
                    </div>
                @endif

                {{-- Checkout Form --}}
                <form id="detailsCheckoutForm" onsubmit="handleDetailsCheckout(event)">
                    @csrf
                    <input type="hidden" id="pId" value="{{ $product->id }}">
                    <input type="hidden" name="utm_source"   value="{{ request('utm_source') }}">
                    <input type="hidden" name="utm_medium"   value="{{ request('utm_medium') }}">
                    <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">

                    <div>
                        <label class="sp-field-label">الاسم الكريم / اسم المنشأة *</label>
                        <input type="text" id="pName" required placeholder="مثال: عبد العزيز الشمري" class="sp-field-input">
                    </div>

                    <div>
                        <label class="sp-field-label">البريد الإلكتروني (لاستلام ملفات البرنامج والترخيص) *</label>
                        <input type="email" id="pEmail" required placeholder="name@example.com" class="sp-field-input">
                    </div>

                    <div>
                        <label class="sp-field-label">رقم الجوال / الواتساب (للتفعيل والدعم السريع) *</label>
                        <input type="tel" id="pPhone" required placeholder="05xxxxxxxx أو +966..." class="sp-field-input">
                    </div>

                    {{-- Payment Tabs --}}
                    <div>
                        <label class="sp-field-label">طريقة الدفع:</label>
                        <div class="sp-gateway-selector">
                            <button type="button" id="tab-paysky" class="sp-gateway-tab active" onclick="switchGateway('paysky')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                بطاقة بنكية / مدى / فيزا
                            </button>
                            <button type="button" id="tab-paypal" class="sp-gateway-tab" onclick="switchGateway('paypal')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M10 8h4a2 2 0 0 1 2 2v0a2 2 0 0 1-2 2h-4v-4z"/><line x1="10" y1="12" x2="10" y2="16"/></svg>
                                PayPal وحسابات دولية
                            </button>
                        </div>
                    </div>

                    <div id="paysky-section">
                        <button type="submit" id="btnDetailsPay" class="sp-pay-submit-btn">
                            <span>إتمام الطلب الآن — {{ number_format($promoActive ? $promoPrice : $normalPrice, 2) }} {{ $product->currency }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        </button>
                    </div>

                    <div id="paypal-section" style="display:none; margin-top: 14px;">
                        <div id="paypal-button-container" style="min-height: 48px;"></div>
                    </div>
                </form>

                {{-- Direct WhatsApp Assistance --}}
                <div class="sp-wa-help-row">
                    <span>تحتاج مساعدة أو تفضل الدفع عبر تحويل مباشر؟ </span>
                    <a href="https://wa.me/201008616682?text={{ urlencode('مرحباً، أود الحصول على ترخيص برنامج ScripOx بسعر العرض (5$) عبر التحويل المباشر.') }}" target="_blank">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                        تواصل معنا عبر واتساب للمساعدة الفورية
                    </a>
                </div>

                {{-- Guarantee Card --}}
                <div class="sp-guarantee-card">
                    <div class="sp-guarantee-shield-wrap">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <h3 class="sp-guarantee-heading">ضمان استرجاع 100% لمدة 14 يوماً</h3>
                        <p class="sp-guarantee-text">
                            جرّب ScripOx في عملك، استخرج جمهورك وأطلق حملاتك. إن لم يحقق لك البرنامج النتائج المرجوة، راسلنا عبر الواتساب وسنقوم برد كامل المبلغ فوراً دون أي تعقيد.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="sp-container">

        {{-- ═══════════════════════════════════════════════════════════════════
             11. SECTION: الأسئلة الشائعة (FAQ Accordion)
             ═══════════════════════════════════════════════════════════════════ --}}
        <section class="sp-section">
            <div class="sp-section-heading">
                <span class="sp-section-pill">مركز المساعدة</span>
                <h2 class="sp-section-title">الأسئلة الأكثر شيوعاً</h2>
            </div>

            <div class="sp-faq-container">
                <div class="sp-faq-row open" id="faq-0">
                    <div class="sp-faq-question-btn" onclick="toggleFaq(0)">
                        <span>1. لا أملك خلفية برمجية، هل يمكنني تشغيل البرنامج بسهولة؟</span>
                        <div class="sp-faq-chevron">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="sp-faq-answer-body">
                        نعم بكل تأكيد. صُمم البرنامج للمستخدم العادي وأصحاب المتاجر ليعمل بنقرة زر واحدة. كما نرفق معه دليلاً تدريبياً مرئياً يشرح كافة الخطوات دقيقة بدقيقة.
                    </div>
                </div>

                <div class="sp-faq-row" id="faq-1">
                    <div class="sp-faq-question-btn" onclick="toggleFaq(1)">
                        <span>2. ما هي أنظمة التشغيل التي يدعمها البرنامج؟</span>
                        <div class="sp-faq-chevron">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="sp-faq-answer-body">
                        إضافة المتصفح (Chrome Extension) تعمل على أي نظام ومتصفح (ويندوز أو ماك). وبرنامج الاستوديو المكتبي يعمل بكفاءة وسرعة على أنظمة Windows 10 و 11.
                    </div>
                </div>

                <div class="sp-faq-row" id="faq-2">
                    <div class="sp-faq-question-btn" onclick="toggleFaq(2)">
                        <span>3. هل الدفع يتم مرة واحدة أم يتطلب اشتراكاً شهرياً؟</span>
                        <div class="sp-faq-chevron">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="sp-faq-answer-body">
                        الدفع يتم لمرة واحدة فقط لمدى الحياة. لا توجد أي اشتراكات دورية أو رسوم تجديد، مع ضمان الحصول على كافة التحديثات القادمة مجاناً.
                    </div>
                </div>

                <div class="sp-faq-row" id="faq-3">
                    <div class="sp-faq-question-btn" onclick="toggleFaq(3)">
                        <span>4. كيف يتم استلام البرنامج والترخيص بعد إتمام الدفع؟</span>
                        <div class="sp-faq-chevron">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="sp-faq-answer-body">
                        فور إتمام العملية ستظهر شاشة التحميل الفورية، كما ستصلك رسالة بريد إلكتروني تحتوي على رابط التحميل ومفتاح الترخيص الخاص بك مع رسالة ترحيبية على الواتساب.
                    </div>
                </div>

                <div class="sp-faq-row" id="faq-4">
                    <div class="sp-faq-question-btn" onclick="toggleFaq(4)">
                        <span>5. هل البرنامج آمن ومتوافق مع سياسات المنصات الإعلانية؟</span>
                        <div class="sp-faq-chevron">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="sp-faq-answer-body">
                        البرنامج متوافق 100% مع معايير الجماهير المخصصة لـ Meta وGoogle، ويقوم بتشفير البيانات محلياً على جهازك قبل تصديرها دون مشاركتها مع أي طرف خارجي.
                    </div>
                </div>

                <div class="sp-faq-row" id="faq-5">
                    <div class="sp-faq-question-btn" onclick="toggleFaq(5)">
                        <span>6. في حال واجهت أي استفسار أثناء التثبيت، كيف أحصل على المساعدة؟</span>
                        <div class="sp-faq-chevron">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="sp-faq-answer-body">
                        فريق الدعم الفني لدى OX Tech متاح عبر الواتساب للإجابة عن أسئلتك ومساعدتك في التثبيت وإعداد جمهورك الأول بكل سلاسة.
                    </div>
                </div>
            </div>
        </section>

    </div>{{-- /.sp-container --}}

    {{-- ═══════════════════════════════════════════════════════════════════
         12. STICKY MOBILE BOTTOM BAR (Clean Light Apple Style)
         ═══════════════════════════════════════════════════════════════════ --}}
    <div class="sp-mobile-sticky-bar" id="mobileStickyBar">
        <div class="sp-mobile-price-group">
            <span class="sp-mobile-price-val">{{ $promoActive ? '$5' : '$' . number_format($normalPrice, 0) }}</span>
            <span class="sp-mobile-price-note">ترخيص دائم للأبد</span>
        </div>
        <div class="sp-mobile-actions-group">
            <a href="#checkoutSection" class="sp-mobile-cta-btn">
                <span>طلب العرض الحصري</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            <a href="https://wa.me/201008616682?text={{ urlencode('مرحباً، أود الاستفسار عن عرض برنامج ScripOx.') }}" target="_blank" class="sp-mobile-wa-btn" aria-label="واتساب">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
            </a>
        </div>
    </div>

</div>{{-- /.sp-apple-page --}}

@push('scripts')
<script>
/* ─── FAQ Accordion Toggle ─── */
function toggleFaq(idx) {
    const item = document.getElementById('faq-' + idx);
    if (!item) return;
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.sp-faq-row').forEach(el => el.classList.remove('open'));
    if (!isOpen) {
        item.classList.add('open');
    }
}

/* ─── Countdown Timer ─── */
(function () {
    const deadline = new Date('{{ $promoDeadline->toIso8601String() }}');
    const dEl = document.getElementById('cd-days');
    const hEl = document.getElementById('cd-hours');
    const mEl = document.getElementById('cd-mins');
    const sEl = document.getElementById('cd-secs');
    if (!dEl) return;

    function update() {
        const diff = deadline - Date.now();
        if (diff <= 0) {
            dEl.innerText = hEl.innerText = mEl.innerText = sEl.innerText = '00';
            return;
        }
        const d = Math.floor(diff / 86400000);
        const h = Math.floor((diff % 86400000) / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        dEl.innerText = String(d).padStart(2, '0');
        hEl.innerText = String(h).padStart(2, '0');
        mEl.innerText = String(m).padStart(2, '0');
        sEl.innerText = String(s).padStart(2, '0');
    }
    update();
    setInterval(update, 1000);
})();

/* ─── Promo Code Logic ─── */
const PROMO_CODE   = 'LAUNCH5';
const PROMO_PRICE  = {{ $promoPrice }};
const NORMAL_PRICE = {{ $normalPrice }};
const PROMO_ACTIVE = {{ $promoActive ? 'true' : 'false' }};
const CURRENCY     = '{{ $product->currency }}';
let   promoApplied = PROMO_ACTIVE;

function applyPromo() {
    const val = (document.getElementById('promoInput')?.value || '').trim().toUpperCase();
    const msg = document.getElementById('promoMsg');
    const priceEl = document.getElementById('displayPrice');
    const saveEl  = document.getElementById('displaySave');

    if (!PROMO_ACTIVE) {
        if (msg) {
            msg.textContent = 'انتهت مدة العرض الترويجي.';
            msg.className = 'sp-promo-alert error';
        }
        return;
    }

    if (val === PROMO_CODE) {
        promoApplied = true;
        if (priceEl) priceEl.innerText = PROMO_PRICE.toFixed(2);
        if (saveEl)  saveEl.innerText  = 'وفرت ' + (NORMAL_PRICE - PROMO_PRICE).toFixed(0) + ' ' + CURRENCY + ' اليوم';
        if (msg) {
            msg.textContent = 'تم تطبيق الكود بنجاح! السعر مخفض لـ ' + PROMO_PRICE + ' ' + CURRENCY + ' فقط.';
            msg.className = 'sp-promo-alert success';
        }
        updatePayButton();
    } else {
        promoApplied = false;
        if (priceEl) priceEl.innerText = NORMAL_PRICE.toFixed(2);
        if (saveEl)  saveEl.innerText  = '';
        if (msg) {
            msg.textContent = 'كود غير صحيح. يرجى التحقق وإعادة المحاولة.';
            msg.className = 'sp-promo-alert error';
        }
        updatePayButton();
    }
}

function updatePayButton() {
    const btn = document.getElementById('btnDetailsPay');
    if (!btn) return;
    const price = promoApplied ? PROMO_PRICE : NORMAL_PRICE;
    btn.innerHTML = `<span>إتمام الطلب الآن — ${price.toFixed(2)} ${CURRENCY}</span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>`;
}

/* ─── Payment Gateway Switcher ─── */
let activeGateway = 'paysky';
let paypalButtonsInitialized = false;

function switchGateway(gw) {
    activeGateway = gw;
    document.querySelectorAll('.sp-gateway-tab').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + gw)?.classList.add('active');
    
    const payskySec = document.getElementById('paysky-section');
    const paypalSec = document.getElementById('paypal-section');
    if (payskySec) payskySec.style.display = gw === 'paysky' ? 'block' : 'none';
    if (paypalSec) paypalSec.style.display = gw === 'paypal' ? 'block' : 'none';

    if (gw === 'paypal' && !paypalButtonsInitialized) {
        initPayPalButtons();
    }
}

/* ─── PaySky Lightbox Loader ─── */
function loadPaySkyAsync(src) {
    return new Promise((resolve) => {
        if (typeof window.Lightbox !== 'undefined') return resolve(true);
        const s = document.createElement('script');
        s.src = src; 
        s.async = true;
        s.onload  = () => resolve(true);
        s.onerror = () => resolve(false);
        document.head.appendChild(s);
    });
}

let currentMerchantRef = '';

function logGatewayError(ref, message, errorData, source, status) {
    fetch('{{ route('checkout.paysky.log_error') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            merchant_reference: ref || currentMerchantRef, 
            message, 
            error: errorData, 
            source: source || 'client', 
            status: status || 'failed' 
        })
    }).catch(() => {});
}

window.addEventListener('message', function (e) {
    if (e.data && e.data.callback === 'errorCallback') {
        logGatewayError(currentMerchantRef, 'PaySky postMessage error: ' + JSON.stringify(e.data), e.data, 'paysky_post_message', 'failed');
    }
});

/* ─── PayPal SDK Integration ─── */
async function initPayPalButtons() {
    const container = document.getElementById('paypal-button-container');
    if (!container) return;
    container.innerHTML = '<div style="text-align:center;padding:12px;color:var(--ap-text-muted);font-size:13px;">جاري تجهيز بوابة PayPal…</div>';
    
    try {
        const cfg = await (await fetch('{{ route('checkout.paypal.config') }}')).json();
        if (!cfg.enabled || !cfg.client_id) {
            container.innerHTML = '<div style="background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;padding:10px;border-radius:8px;font-size:12.5px;text-align:center;">بوابة PayPal غير مهيأة بعد، يمكنك الدفع بالبطاقة عبر الخيار الأول.</div>';
            return;
        }
        if (!window.paypal) {
            await new Promise((res, rej) => {
                const s = document.createElement('script');
                s.src = `https://www.paypal.com/sdk/js?client-id=${encodeURIComponent(cfg.client_id)}&currency=${encodeURIComponent(cfg.currency || 'USD')}`;
                s.onload = res; 
                s.onerror = rej;
                document.head.appendChild(s);
            });
        }
        container.innerHTML = '';
        window.paypal.Buttons({
            style: { layout: 'vertical', color: 'blue', shape: 'pill', label: 'paypal', height: 48 },
            createOrder: async function () {
                const name  = (document.getElementById('pName')?.value || '').trim();
                const email = (document.getElementById('pEmail')?.value || '').trim();
                const phone = (document.getElementById('pPhone')?.value || '').trim();
                if (!name || !email) { 
                    alert('يرجى إدخال الاسم والبريد الإلكتروني أولاً.'); 
                    throw new Error('Missing fields'); 
                }
                const r = await fetch('{{ route('checkout.paypal.create') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ 
                        product_id: '{{ $product->id }}', 
                        customer_name: name, 
                        customer_email: email, 
                        customer_phone: phone, 
                        promo_applied: promoApplied 
                    })
                });
                const d = await r.json();
                if (!d.success) { 
                    alert(d.message || 'خطأ في إنشاء طلب الدفع.'); 
                    throw new Error(d.message); 
                }
                currentMerchantRef = d.merchant_reference;
                return d.paypal_order_id;
            },
            onApprove: async function (data) {
                container.innerHTML = '<div style="text-align:center;padding:12px;color:var(--ap-emerald);font-weight:700;">جاري تأكيد استلام الدفع وإصدار الترخيص…</div>';
                const r = await fetch('{{ route('checkout.paypal.capture') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ paypal_order_id: data.orderID, merchant_reference: currentMerchantRef })
                });
                const d = await r.json();
                if (d.success && d.redirect_url) { 
                    window.location.href = d.redirect_url; 
                } else { 
                    alert(d.message || 'خطأ في استلام الدفع.'); 
                    paypalButtonsInitialized = false; 
                    initPayPalButtons(); 
                }
            },
            onError: function (err) {
                logGatewayError(currentMerchantRef, 'PayPal error: ' + String(err), { error: String(err) }, 'paypal_sdk', 'failed');
                alert('حدث خطأ في بوابة PayPal. يرجى استخدام الدفع بالبطاقة أو المحاولة لاحقاً.');
            }
        }).render('#paypal-button-container');
        paypalButtonsInitialized = true;
    } catch (e) {
        console.error(e);
        container.innerHTML = '<div style="color:#DC2626;font-size:12px;text-align:center;">تعذر تحميل PayPal حالياً، يرجى الدفع بالبطاقة.</div>';
    }
}

/* ─── Main Details Checkout (PaySky / Cards) ─── */
async function handleDetailsCheckout(e) {
    e.preventDefault();
    const btn = document.getElementById('btnDetailsPay');
    if (!btn) return;
    
    btn.disabled = true;
    btn.innerHTML = '<span>جاري تجهيز بوابة الدفع الآمنة…</span>';

    const payload = {
        _token: '{{ csrf_token() }}',
        product_id: '{{ $product->id }}',
        customer_name:  document.getElementById('pName')?.value || '',
        customer_email: document.getElementById('pEmail')?.value || '',
        customer_phone: document.getElementById('pPhone')?.value || '',
        promo_applied:  promoApplied,
        utm_source:   '{{ request('utm_source') }}',
        utm_medium:   '{{ request('utm_medium') }}',
        utm_campaign: '{{ request('utm_campaign') }}',
    };

    try {
        const res  = await fetch('{{ route('checkout.initiate') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(payload)
        });
        const data = await res.json();

        if (data.success && data.paysky) {
            currentMerchantRef = data.paysky.MerchantReference || data.merchant_reference || '';
            btn.innerHTML = '<span>جاري فتح نافذة الدفع…</span>';
            
            const loaded = await loadPaySkyAsync(data.paysky.ScriptUrl);
            if (loaded && typeof Lightbox !== 'undefined') {
                Lightbox.Checkout.configure = {
                    MID: data.paysky.MID, 
                    TID: data.paysky.TID,
                    AmountTrxn: data.paysky.AmountTrxn,
                    MerchantReference: data.paysky.MerchantReference,
                    OrderId: data.paysky.OrderNumber || data.paysky.MerchantReference,
                    TrxDateTime: data.paysky.TrxDateTime,
                    CurrencyCode: data.paysky.CurrencyCode || '818',
                    SecureHash: data.paysky.SecureHash,
                    completeCallback: () => { 
                        window.location.href = data.callback_url + '?MerchantReference=' + encodeURIComponent(data.paysky.MerchantReference) + '&Success=true'; 
                    },
                    errorCallback: (err) => {
                        logGatewayError(data.paysky.MerchantReference, 'PaySky error: ' + JSON.stringify(err), err, 'paysky_callback', 'failed');
                        alert('تعذر إتمام الدفع: ' + (err?.Message || err?.errorMessage || 'يرجى مراجعة بيانات البطاقة والمحاولة'));
                        btn.disabled = false; 
                        updatePayButton();
                    },
                    cancelCallback: () => {
                        logGatewayError(data.paysky.MerchantReference, 'PaySky cancelled', {}, 'paysky_cancel', 'cancelled');
                        btn.disabled = false; 
                        updatePayButton();
                    }
                };
                Lightbox.Checkout.showLightbox();
            } else {
                window.location.href = data.callback_url + '?MerchantReference=' + encodeURIComponent(data.paysky.MerchantReference) + '&Success=true';
            }
        } else {
            logGatewayError('', data.message || 'checkout failed', data, 'checkout_initiate', 'failed');
            alert(data.message || 'حدث خطأ في النظام. يرجى المحاولة أو التواصل معنا عبر الواتساب.');
            btn.disabled = false;
            updatePayButton();
        }
    } catch (err) {
        logGatewayError(currentMerchantRef, 'Client exception: ' + err.message, { error: String(err) }, 'client_exception', 'failed');
        alert('حدث خطأ في الاتصال. يرجى المحاولة مجدداً.');
        btn.disabled = false;
        updatePayButton();
    }
}
</script>
@endpush

@endsection
