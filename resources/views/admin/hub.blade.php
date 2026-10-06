@extends('layouts.admin')

@section('title', 'مركز إدارة النظام والمحتوى | OX Tech')
@section('header_title', 'مركز النظام والمحتوى')

@push('admin-styles')
<style>
    .hub-container {
        max-width: 1300px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .hub-hero-banner {
        background: linear-gradient(135deg, #071B19 0%, #0D2C28 100%);
        border-radius: 20px;
        padding: 30px 32px;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: 0 4px 20px rgba(7, 27, 25, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .hub-hero-text h2 {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 6px;
        color: #FFFFFF;
    }
    .hub-hero-text p {
        font-size: 13px;
        color: #94A3B8;
        line-height: 1.6;
        margin: 0;
    }

    .hub-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 800;
        color: var(--text-heading);
        margin-bottom: 16px;
    }
    .hub-section-title span.badge-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--brand-green);
    }

    .hub-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }

    .hub-card {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
    }
    .hub-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        border-color: #CBD5E1;
    }

    .hub-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .hub-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #071B19;
        flex-shrink: 0;
        transition: 0.2s;
    }
    .hub-card:hover .hub-icon-box {
        background: #071B19;
        color: #FFFFFF;
        border-color: #071B19;
    }

    .hub-card-tag {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        background: #F1F5F9;
        color: #475569;
        font-family: var(--font-code);
    }

    .hub-card-content h3 {
        font-size: 15px;
        font-weight: 800;
        color: var(--text-heading);
        margin-bottom: 6px;
    }
    .hub-card-content p {
        font-size: 12px;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 18px;
    }

    .hub-card-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-top: 14px;
        border-top: 1px solid #F1F5F9;
    }

    .hub-enter-btn {
        flex: 1;
        background: #071B19;
        color: #FFFFFF !important;
        text-align: center;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: 0.2s;
    }
    .hub-enter-btn:hover {
        background: #0f2d29;
    }

    .hub-quick-add-btn {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        color: #334155;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: 0.2s;
    }
    .hub-quick-add-btn:hover {
        background: #E2E8F0;
        color: #071B19;
    }
</style>
@endpush

@section('content')
<div class="hub-container">

    <!-- Hero Banner -->
    <div class="hub-hero-banner">
        <div class="hub-hero-text">
            <h2>مركز إدارة النظام والأدوات (System & Operations Hub)</h2>
            <p>
                تم تجميع كافة صفحات المحتوى، سجلات الدفع، الإعدادات، والتقارير في واجهة واحدة موحدة لتسهيل الوصول إليها والحفاظ على بساطة الشريط الجانبي وسرعة التنقل.
            </p>
        </div>
        <div style="font-size: 38px; line-height: 1; opacity: 0.85;">
            🎛️
        </div>
    </div>

    <!-- Group 1: Content & Media -->
    <div>
        <div class="hub-section-title">
            <span class="badge-dot"></span>
            <span>1. المحتوى ومعرض الأعمال (Content & Media)</span>
        </div>
        <div class="hub-cards-grid">
            <!-- Projects -->
            <div class="hub-card">
                <div>
                    <div class="hub-card-header">
                        <div class="hub-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                        </div>
                        <span class="hub-card-tag">{{ $hubStats['projects_count'] }} مشروع</span>
                    </div>
                    <div class="hub-card-content">
                        <h3>المشاريع ومعرض الأعمال</h3>
                        <p>إدارة دراسات الحالة، المشاريع المنفذة، معرض الصور، وتفاصيل الحلول التقنية المنجزة للعملاء.</p>
                    </div>
                </div>
                <div class="hub-card-actions">
                    <a href="{{ route('admin.projects.index') }}" class="hub-enter-btn">
                        <span>إدارة المشاريع</span>
                        <span>&larr;</span>
                    </a>
                    <a href="{{ route('admin.projects.create') }}" class="hub-quick-add-btn" title="إضافة مشروع جديد">
                        <span>+ إضافة</span>
                    </a>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="hub-card">
                <div>
                    <div class="hub-card-header">
                        <div class="hub-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                        </div>
                        <span class="hub-card-tag">{{ $hubStats['testimonials_count'] }} فيديو</span>
                    </div>
                    <div class="hub-card-content">
                        <h3>فيديوهات وقصص الشركاء</h3>
                        <p>إدارة مقاطع الفيديو والريفيوهات الخاصة برؤساء الشركات والشركاء لعرضها في معرض الثقة.</p>
                    </div>
                </div>
                <div class="hub-card-actions">
                    <a href="{{ route('admin.testimonials.index') }}" class="hub-enter-btn">
                        <span>إدارة الفيديوهات</span>
                        <span>&larr;</span>
                    </a>
                    <a href="{{ route('admin.testimonials.create') }}" class="hub-quick-add-btn" title="إضافة فيديو جديد">
                        <span>+ إضافة</span>
                    </a>
                </div>
            </div>

            <!-- Site Content -->
            <div class="hub-card">
                <div>
                    <div class="hub-card-header">
                        <div class="hub-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </div>
                        <span class="hub-card-tag">ديناميكي</span>
                    </div>
                    <div class="hub-card-content">
                        <h3>نصوص وعناصر الموقع</h3>
                        <p>تعديل نصوص الصفحة الرئيسية، البنرات الترويجية، العناوين، ورسائل خدمة العملاء الحية.</p>
                    </div>
                </div>
                <div class="hub-card-actions">
                    <a href="{{ route('admin.site-content.index') }}" class="hub-enter-btn">
                        <span>تعديل نصوص الموقع</span>
                        <span>&larr;</span>
                    </a>
                </div>
            </div>

            <!-- Media Library & Compression -->
            <div class="hub-card">
                <div>
                    <div class="hub-card-header">
                        <div class="hub-icon-box" style="color: #059669; background: #ECFDF5; border-color: #A7F3D0;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </div>
                        <span class="hub-card-tag" style="background: #ECFDF5; color: #065F46; border-color: #A7F3D0;">WebP تلقائي</span>
                    </div>
                    <div class="hub-card-content">
                        <h3>مكتبة الوسائط وضغط الصور</h3>
                        <p>استعراض جميع الصور المرفوعة بالموقع، ضغط تلقائي فوري إلى WebP، نسخ الروابط المباشرة، وحذف الملفات الزائدة.</p>
                    </div>
                </div>
                <div class="hub-card-actions">
                    <a href="{{ route('admin.media.index') }}" class="hub-enter-btn" style="background: #059669;">
                        <span>فتح مكتبة الوسائط</span>
                        <span>&larr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Group 2: Operations & Finance -->
    <div>
        <div class="hub-section-title">
            <span class="badge-dot" style="background: #2563EB;"></span>
            <span>2. العمليات والمالية (Operations & Finance)</span>
        </div>
        <div class="hub-cards-grid">
            <!-- Quotations -->
            <div class="hub-card">
                <div>
                    <div class="hub-card-header">
                        <div class="hub-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line></svg>
                        </div>
                        <span class="hub-card-tag">{{ $hubStats['quotations_count'] }} عرض</span>
                    </div>
                    <div class="hub-card-content">
                        <h3>عروض الأسعار (Quotations)</h3>
                        <p>إنشاء عروض الأسعار الرسمية للشركات، إرسالها للبريد مباشرة وتحويلها بضغطة زر إلى فواتير.</p>
                    </div>
                </div>
                <div class="hub-card-actions">
                    <a href="{{ route('admin.crm.quotations.index') }}" class="hub-enter-btn">
                        <span>إدارة عروض الأسعار</span>
                        <span>&larr;</span>
                    </a>
                    <a href="{{ route('admin.crm.quotations.create') }}" class="hub-quick-add-btn" title="إنشاء عرض سعر">
                        <span>+ إنشاء</span>
                    </a>
                </div>
            </div>

            <!-- Payment Logs -->
            <div class="hub-card">
                <div>
                    <div class="hub-card-header">
                        <div class="hub-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        </div>
                        <span class="hub-card-tag">{{ $hubStats['payment_logs_count'] }} سجل</span>
                    </div>
                    <div class="hub-card-content">
                        <h3>سجل بوابات الدفع (Payment Logs)</h3>
                        <p>متابعة واستعراض تفاصيل طلبات واستجابات PaySky و PayPal والـ Webhooks في الوقت الفعلي.</p>
                    </div>
                </div>
                <div class="hub-card-actions">
                    <a href="{{ route('admin.payment-logs.index') }}" class="hub-enter-btn">
                        <span>استعراض السجلات (Logs)</span>
                        <span>&larr;</span>
                    </a>
                </div>
            </div>

            <!-- Analytics Reports -->
            <div class="hub-card">
                <div>
                    <div class="hub-card-header">
                        <div class="hub-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        </div>
                        <span class="hub-card-tag">تحليلات</span>
                    </div>
                    <div class="hub-card-content">
                        <h3>تقارير الأداء ومصادر الزيارات</h3>
                        <p>تقارير الحملات الإعلانية ومحددات الـ UTM لمعرفة أكثر المصادر والمنصات جذباً للاستشارات.</p>
                    </div>
                </div>
                <div class="hub-card-actions">
                    <a href="{{ route('admin.reports.index') }}" class="hub-enter-btn">
                        <span>استعراض التقارير</span>
                        <span>&larr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Group 3: System & Security -->
    <div>
        <div class="hub-section-title">
            <span class="badge-dot" style="background: #D97706;"></span>
            <span>3. النظام والتهيئة والأمان (System & Settings)</span>
        </div>
        <div class="hub-cards-grid">
            <!-- Settings -->
            <div class="hub-card">
                <div>
                    <div class="hub-card-header">
                        <div class="hub-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        </div>
                        <span class="hub-card-tag">عام</span>
                    </div>
                    <div class="hub-card-content">
                        <h3>إعدادات الموقع وبوابات الدفع</h3>
                        <p>تعديل الشعار، وسائل الاتصال، العملات، وضبط بيانات الربط لبوابات PaySky و PayPal ومعدلات التحويل.</p>
                    </div>
                </div>
                <div class="hub-card-actions">
                    <a href="{{ route('admin.settings.index') }}" class="hub-enter-btn">
                        <span>إعدادات المنصة</span>
                        <span>&larr;</span>
                    </a>
                </div>
            </div>

            <!-- Tracking Pixels -->
            <div class="hub-card">
                <div>
                    <div class="hub-card-header">
                        <div class="hub-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                        </div>
                        <span class="hub-card-tag">{{ $hubStats['tracking_pixels_count'] }} بكسل</span>
                    </div>
                    <div class="hub-card-content">
                        <h3>بكسلات التتبع والحملات</h3>
                        <p>إدارة معرفات التتبع لـ Meta Pixel و Google Analytics و TikTok و Snapchat لضمان دقة التحويلات.</p>
                    </div>
                </div>
                <div class="hub-card-actions">
                    <a href="{{ route('admin.tracking.index') }}" class="hub-enter-btn">
                        <span>إدارة بكسلات التتبع</span>
                        <span>&larr;</span>
                    </a>
                </div>
            </div>

            <!-- Users & Admins -->
            <div class="hub-card">
                <div>
                    <div class="hub-card-header">
                        <div class="hub-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <span class="hub-card-tag">{{ $hubStats['users_count'] }} مستخدم</span>
                    </div>
                    <div class="hub-card-content">
                        <h3>فريق الإدارة والمستخدمين</h3>
                        <p>إدارة حسابات المدراء والمحررين، كلمات المرور، والصلاحيات الأمنية للوحة التحكم.</p>
                    </div>
                </div>
                <div class="hub-card-actions">
                    <a href="{{ route('admin.users.index') }}" class="hub-enter-btn">
                        <span>إدارة المستخدمين</span>
                        <span>&larr;</span>
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="hub-quick-add-btn" title="إضافة مسؤول">
                        <span>+ إضافة</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
