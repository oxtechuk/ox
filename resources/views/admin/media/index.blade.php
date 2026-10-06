@extends('layouts.admin')

@section('title', 'مكتبة الوسائط وضغط الصور | OX Tech')
@section('header_title', 'مكتبة الوسائط وضغط الصور')

@push('admin-styles')
<style>
    .media-container {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Top Stats Grid */
    .media-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
    }
    .media-stat-card {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }
    .media-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .media-stat-val {
        font-size: 22px;
        font-weight: 800;
        color: var(--text-heading);
        line-height: 1.2;
    }
    .media-stat-lbl {
        font-size: 12.5px;
        color: #64748B;
        margin-top: 3px;
    }

    /* Upload Box */
    .media-upload-card {
        background: #FFFFFF;
        border: 1.5px dashed #CBD5E1;
        border-radius: 20px;
        padding: 32px 24px;
        text-align: center;
        transition: all 0.25s ease;
        position: relative;
        cursor: pointer;
    }
    .media-upload-card:hover, .media-upload-card.drag-over {
        border-color: #10B981;
        background: #F0FDF4;
    }
    .media-upload-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: #ECFDF5;
        color: #059669;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }
    .media-upload-title {
        font-size: 16px;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 6px;
    }
    .media-upload-desc {
        font-size: 13px;
        color: #64748B;
        max-width: 580px;
        margin: 0 auto 16px;
        line-height: 1.6;
    }
    .media-upload-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #071B19;
        color: #10B981;
        font-size: 11.5px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 30px;
    }

    /* Filters Bar */
    .media-toolbar {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }
    .media-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    .media-tab {
        padding: 7px 14px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        color: #475569;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        transition: all 0.2s;
    }
    .media-tab:hover {
        background: #E2E8F0;
        color: #0F172A;
    }
    .media-tab.active {
        background: #071B19;
        color: #FFFFFF;
        border-color: #071B19;
    }
    .media-tab-badge {
        font-size: 11px;
        padding: 1px 6px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.2);
        margin-right: 4px;
    }

    .media-search-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        max-width: 420px;
    }
    .media-search-input {
        flex: 1;
        padding: 8px 14px;
        border: 1px solid #CBD5E1;
        border-radius: 10px;
        font-size: 13px;
        font-family: inherit;
        outline: none;
    }
    .media-search-input:focus {
        border-color: #10B981;
    }

    /* Media Grid */
    .media-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 18px;
    }

    .media-card {
        background: #FFFFFF;
        border: 1px solid var(--border-card);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
    }
    .media-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        border-color: #CBD5E1;
    }

    .media-thumb-wrap {
        width: 100%;
        height: 160px;
        background-color: #F8FAFC;
        background-image: 
            linear-gradient(45deg, #F1F5F9 25%, transparent 25%),
            linear-gradient(-45deg, #F1F5F9 25%, transparent 25%),
            linear-gradient(45deg, transparent 75%, #F1F5F9 75%),
            linear-gradient(-45deg, transparent 75%, #F1F5F9 75%);
        background-size: 16px 16px;
        background-position: 0 0, 0 8px, 8px -8px, -8px 0px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }
    .media-thumb-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .media-card:hover .media-thumb-img {
        transform: scale(1.05);
    }

    .media-format-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        backdrop-filter: blur(4px);
    }
    .badge-webp { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
    .badge-png { background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; }
    .badge-jpg, .badge-jpeg { background: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE; }
    .badge-svg { background: #F3E8FF; color: #6B21A8; border: 1px solid #E9D5FF; }

    .media-card-body {
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        flex: 1;
        justify-content: space-between;
        gap: 10px;
    }
    .media-filename {
        font-size: 12.5px;
        font-weight: 700;
        color: #1E293B;
        word-break: break-all;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }
    .media-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 11px;
        color: #64748B;
        margin-top: 4px;
    }

    .media-card-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        border-top: 1px solid #F1F5F9;
        padding-top: 10px;
    }
    .media-action-btn {
        flex: 1;
        padding: 6px 8px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
        color: #334155;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        transition: all 0.15s;
        text-decoration: none;
    }
    .media-action-btn:hover {
        background: #E2E8F0;
        color: #0F172A;
    }
    .media-action-btn.btn-delete {
        flex: 0 0 32px;
        padding: 6px;
        color: #EF4444;
        border-color: #FEE2E2;
        background: #FEF2F2;
    }
    .media-action-btn.btn-delete:hover {
        background: #EF4444;
        color: #FFFFFF;
        border-color: #EF4444;
    }

    /* Modal Backdrop & Dialog */
    .media-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .media-modal-content {
        background: #FFFFFF;
        border-radius: 20px;
        max-width: 750px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: flex;
        flex-direction: column;
    }
    .media-modal-header {
        padding: 16px 22px;
        border-bottom: 1px solid #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .media-modal-body {
        padding: 22px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .media-modal-preview-box {
        max-height: 380px;
        background: #0B1514;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 12px;
    }
    .media-modal-preview-img {
        max-width: 100%;
        max-height: 350px;
        object-fit: contain;
    }

    /* Toast Notification */
    .clipboard-toast {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: #071B19;
        color: #FFFFFF;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 10000;
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .clipboard-toast.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }

    /* Progress bar */
    .progress-bar-bg {
        width: 100%;
        height: 6px;
        background: #E2E8F0;
        border-radius: 6px;
        overflow: hidden;
        margin-top: 6px;
    }
    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #10B981, #059669);
        border-radius: 6px;
        transition: width 0.5s ease;
    }
</style>
@endpush

@section('content')
<div class="media-container">

    <!-- Top Action Banner -->
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
        <div>
            <h2 style="font-size: 22px; font-weight: 800; color: var(--text-heading); margin: 0 0 4px;">
                مكتبة الوسائط وضغط الصور الذكي
            </h2>
            <p style="font-size: 13px; color: #64748B; margin: 0;">
                إدارة الصور المرفوعة للموقع وضغطها فورياً إلى صيغة WebP فائقة السرعة لتحسين مؤشرات Google PageSpeed.
            </p>
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            <form action="{{ route('admin.media.batch-optimize') }}" method="POST" onsubmit="return confirm('هل تريد ضغط جميع الصور القديمة (PNG/JPG) غير المحولة في التخزين وتوليد نسخ WebP منها؟')">
                @csrf
                <button type="submit" class="btn" style="background: #071B19; color: #FFFFFF; border: 1px solid #1E3A36; font-size: 12.5px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    <span>ضغط الصور القديمة دفعة واحدة (Batch WebP)</span>
                </button>
            </form>

            <a href="{{ route('admin.hub') }}" class="btn btn-secondary" style="font-size: 12.5px;">
                <span>العودة للمركز &larr;</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="media-stats-grid">
        <div class="media-stat-card">
            <div class="media-stat-icon" style="background: #EFF6FF; color: #2563EB;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            </div>
            <div>
                <div class="media-stat-val">{{ number_format($stats['total_files']) }}</div>
                <div class="media-stat-lbl">إجمالي ملفات الصور</div>
            </div>
        </div>

        <div class="media-stat-card">
            <div class="media-stat-icon" style="background: #F8FAFC; color: #0F172A; border: 1px solid #E2E8F0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            </div>
            <div>
                <div class="media-stat-val">{{ $stats['total_size_formatted'] }}</div>
                <div class="media-stat-lbl">الحجم الإجمالي المستهلك</div>
            </div>
        </div>

        <div class="media-stat-card" style="grid-column: span 2;">
            <div class="media-stat-icon" style="background: #ECFDF5; color: #059669;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; align-items: baseline;">
                    <div class="media-stat-val">{{ $stats['webp_percentage'] }}%</div>
                    <span style="font-size: 12px; font-weight: 700; color: #059669;">{{ $stats['webp_count'] }} من أصل {{ $stats['total_files'] }} بصيغة WebP الحديثة</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $stats['webp_percentage'] }}%;"></div>
                </div>
                <div class="media-stat-lbl" style="margin-top: 4px;">نسبة الصور المحسنة للسرعة الفائقة</div>
            </div>
        </div>
    </div>

    <!-- Upload Dropzone Card -->
    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="mediaUploadForm">
        @csrf
        <input type="file" name="files[]" id="mediaFileInput" multiple accept="image/png,image/jpeg,image/webp,image/svg+xml" style="display: none;" onchange="handleFileSelect(this)">
        
        <div class="media-upload-card" id="dropzoneBox" onclick="document.getElementById('mediaFileInput').click()">
            <div class="media-upload-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
            </div>
            <div class="media-upload-title">اسحب وأفلت الصور هنا، أو اضغط للاختيار من جهازك</div>
            <div class="media-upload-desc">
                يتم ضغط كل صورة تلقائياً بنسبة تصل إلى <strong>85%</strong> وتحويلها إلى أحدث صيغ الويب <strong>(WebP)</strong> مع الحفاظ على وضوح التفاصيل والشفافية.
            </div>
            <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; align-items: center;">
                <span class="media-upload-badge">⚡ ضغط WebP فوري</span>
                <span class="media-upload-badge" style="background: #F1F5F9; color: #334155;">📐 ضبط ذكي للأبعاد (Max 1600px)</span>
                <span class="media-upload-badge" style="background: #F1F5F9; color: #334155;">🔒 حفظ تلقائي في التخزين العام</span>
            </div>
            
            <div id="uploadingIndicator" style="display: none; margin-top: 16px; font-weight: 700; color: #059669;">
                <span class="spinner" style="display: inline-block; animation: spin 1s linear infinite; margin-left: 8px;">⏳</span> جاري معالجة وضغط الصور... برجاء الانتظار
            </div>
        </div>
    </form>

    <!-- Toolbar: Categories, Format Filter, Search -->
    <div class="media-toolbar">
        <div class="media-tabs">
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['category' => 'all', 'page' => 1])) }}" class="media-tab {{ $category === 'all' ? 'active' : '' }}">
                الكل
            </a>
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['category' => 'media', 'page' => 1])) }}" class="media-tab {{ $category === 'media' ? 'active' : '' }}">
                مرفوعات الميديا
            </a>
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['category' => 'projects', 'page' => 1])) }}" class="media-tab {{ $category === 'projects' ? 'active' : '' }}">
                المشاريع
            </a>
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['category' => 'branding', 'page' => 1])) }}" class="media-tab {{ $category === 'branding' ? 'active' : '' }}">
                الهوية والشعارات
            </a>
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['category' => 'testimonials', 'page' => 1])) }}" class="media-tab {{ $category === 'testimonials' ? 'active' : '' }}">
                الريفيوز
            </a>
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['category' => 'assets', 'page' => 1])) }}" class="media-tab {{ $category === 'assets' ? 'active' : '' }}">
                أصول الموقع (Assets)
            </a>
        </div>

        <div style="display: flex; gap: 10px; align-items: center; flex: 1; justify-content: flex-end;">
            <!-- Format Filter -->
            <select onchange="window.location.href = this.value;" class="form-control" style="width: auto; padding: 7px 30px 7px 12px; font-size: 12.5px; height: 38px;">
                <option value="{{ route('admin.media.index', array_merge(request()->query(), ['format' => 'all', 'page' => 1])) }}" {{ $extensionFilter === 'all' ? 'selected' : '' }}>جميع الصيغ</option>
                <option value="{{ route('admin.media.index', array_merge(request()->query(), ['format' => 'webp', 'page' => 1])) }}" {{ $extensionFilter === 'webp' ? 'selected' : '' }}>WebP فقط (محسن)</option>
                <option value="{{ route('admin.media.index', array_merge(request()->query(), ['format' => 'png', 'page' => 1])) }}" {{ $extensionFilter === 'png' ? 'selected' : '' }}>PNG</option>
                <option value="{{ route('admin.media.index', array_merge(request()->query(), ['format' => 'jpg', 'page' => 1])) }}" {{ $extensionFilter === 'jpg' ? 'selected' : '' }}>JPG / JPEG</option>
            </select>

            <!-- Search Form -->
            <form action="{{ route('admin.media.index') }}" method="GET" class="media-search-form">
                <input type="hidden" name="category" value="{{ $category }}">
                <input type="hidden" name="format" value="{{ $extensionFilter }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="ابحث باسم الملف..." class="media-search-input">
                <button type="submit" class="btn btn-secondary btn-sm" style="height: 38px;">بحث</button>
                @if($search !== '')
                    <a href="{{ route('admin.media.index', ['category' => $category, 'format' => $extensionFilter]) }}" class="btn btn-secondary btn-sm" title="إلغاء البحث" style="height: 38px;">✕</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Media Gallery Grid -->
    @if($mediaList->isEmpty())
        <div style="background: #FFFFFF; border: 1px solid var(--border-card); border-radius: 16px; padding: 60px 20px; text-align: center;">
            <div style="font-size: 42px; margin-bottom: 12px;">🖼️</div>
            <h3 style="font-size: 16px; font-weight: 800; color: #0F172A; margin-bottom: 6px;">لا توجد صور تطابق البحث أو التصنيف المحدد</h3>
            <p style="font-size: 13px; color: #64748B; margin-bottom: 16px;">يمكنك رفع صورة جديدة بالسحب في المربع أعلاه وسيتم حفظها وضغطها فوراً.</p>
            <button onclick="document.getElementById('mediaFileInput').click()" class="btn btn-primary btn-sm">رفع صورة الآن</button>
        </div>
    @else
        <div class="media-gallery-grid">
            @foreach($mediaList as $item)
                <div class="media-card" id="media-card-{{ md5($item['path']) }}">
                    <div class="media-thumb-wrap" onclick="openPreviewModal('{{ $item['url'] }}', '{{ addslashes($item['name']) }}', '{{ $item['size_formatted'] }}', '{{ $item['dimensions'] ?? 'غير محدد' }}', '{{ $item['date_formatted'] }}', '{{ $item['path'] }}', {{ $item['can_delete'] ? 'true' : 'false' }})">
                        <img src="{{ $item['url'] }}" alt="{{ $item['name'] }}" class="media-thumb-img" loading="lazy">
                        <span class="media-format-badge badge-{{ $item['extension'] }}">
                            .{{ strtoupper($item['extension']) }}
                        </span>
                    </div>

                    <div class="media-card-body">
                        <div>
                            <div class="media-filename" title="{{ $item['name'] }}">
                                {{ $item['name'] }}
                            </div>
                            <div class="media-meta">
                                <span>{{ $item['size_formatted'] }}</span>
                                @if($item['dimensions'])
                                    <span>{{ $item['dimensions'] }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="media-card-actions">
                            <button type="button" class="media-action-btn" onclick="copyMediaUrl('{{ $item['url'] }}')" title="نسخ رابط الصورة المباشر">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                <span>نسخ الرابط</span>
                            </button>

                            <button type="button" class="media-action-btn" onclick="openPreviewModal('{{ $item['url'] }}', '{{ addslashes($item['name']) }}', '{{ $item['size_formatted'] }}', '{{ $item['dimensions'] ?? 'غير محدد' }}', '{{ $item['date_formatted'] }}', '{{ $item['path'] }}', {{ $item['can_delete'] ? 'true' : 'false' }})" title="معاينة وتفاصيل">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </button>

                            @if($item['can_delete'])
                                <button type="button" class="media-action-btn btn-delete" onclick="confirmDeleteMedia('{{ $item['path'] }}', '{{ addslashes($item['name']) }}')" title="حذف الملف">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $mediaList->links() }}
        </div>
    @endif

</div>

<!-- Modal: Image Preview & Details -->
<div class="media-modal-backdrop" id="previewModal" onclick="closePreviewModal(event)">
    <div class="media-modal-content" onclick="event.stopPropagation()">
        <div class="media-modal-header">
            <h4 id="previewModalTitle" style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0; word-break: break-all;">تفاصيل الصورة</h4>
            <button type="button" onclick="closePreviewModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748B;">✕</button>
        </div>
        <div class="media-modal-body">
            <div class="media-modal-preview-box">
                <img id="previewModalImg" src="" alt="" class="media-modal-preview-img">
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; background: #F8FAFC; padding: 14px; border-radius: 12px; border: 1px solid #E2E8F0;">
                <div>
                    <span style="display: block; font-size: 11px; color: #64748B;">الحجم</span>
                    <strong id="previewModalSize" style="font-size: 13px; color: #0F172A;">-</strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11px; color: #64748B;">الأبعاد (العرض × الارتفاع)</span>
                    <strong id="previewModalDimensions" style="font-size: 13px; color: #0F172A;">-</strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11px; color: #64748B;">تاريخ الإضافة / التعديل</span>
                    <strong id="previewModalDate" style="font-size: 13px; color: #0F172A;">-</strong>
                </div>
            </div>

            <div>
                <label class="form-label" style="font-size: 12px;">الرابط المباشر للملف (Direct URL):</label>
                <div style="display: flex; gap: 8px;">
                    <input type="text" id="previewModalUrlInput" readonly class="form-control" style="font-family: monospace; font-size: 12px; background: #F8FAFC;" onclick="this.select()">
                    <button type="button" class="btn btn-lime btn-sm" onclick="copyMediaUrl(document.getElementById('previewModalUrlInput').value)">نسخ</button>
                </div>
            </div>

            <div id="previewModalDeleteContainer" style="display: flex; justify-content: flex-end; padding-top: 10px; border-top: 1px solid #E2E8F0;">
                <button type="button" id="previewModalDeleteBtn" class="btn btn-danger btn-sm">حذف هذه الصورة نهائياً</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Delete Confirmation Form -->
<form id="deleteMediaForm" action="{{ route('admin.media.destroy') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="path" id="deleteMediaPath">
</form>

<!-- Toast Message Container -->
<div class="clipboard-toast" id="clipboardToast">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
    <span id="toastMsgText">تم نسخ الرابط المباشر إلى الحافظة بنجاح!</span>
</div>

@push('admin-scripts')
<script>
    // Copy URL to Clipboard
    function copyMediaUrl(url) {
        if (!navigator.clipboard) {
            const input = document.createElement('textarea');
            input.value = url;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            showToast('تم نسخ الرابط إلى الحافظة!');
            return;
        }

        navigator.clipboard.writeText(url).then(() => {
            showToast('تم نسخ الرابط المباشر للصورة بنجاح!');
        }).catch(() => {
            showToast('تعذر نسخ الرابط تلقائياً.');
        });
    }

    function showToast(text) {
        const toast = document.getElementById('clipboardToast');
        const textElem = document.getElementById('toastMsgText');
        textElem.innerText = text;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2800);
    }

    // Modal Preview Handler
    let activeItemPath = '';
    function openPreviewModal(url, name, size, dimensions, date, path, canDelete) {
        activeItemPath = path;
        document.getElementById('previewModalImg').src = url;
        document.getElementById('previewModalTitle').innerText = name;
        document.getElementById('previewModalSize').innerText = size;
        document.getElementById('previewModalDimensions').innerText = dimensions;
        document.getElementById('previewModalDate').innerText = date;
        document.getElementById('previewModalUrlInput').value = url;

        const delContainer = document.getElementById('previewModalDeleteContainer');
        const delBtn = document.getElementById('previewModalDeleteBtn');
        if (canDelete) {
            delContainer.style.display = 'flex';
            delBtn.onclick = function() {
                confirmDeleteMedia(path, name);
            };
        } else {
            delContainer.style.display = 'none';
        }

        document.getElementById('previewModal').style.display = 'flex';
    }

    function closePreviewModal(e) {
        if (e && e.target !== document.getElementById('previewModal') && !e.target.closest('button')) {
            return;
        }
        document.getElementById('previewModal').style.display = 'none';
    }

    // Delete Media Handler
    function confirmDeleteMedia(path, name) {
        if (confirm(`هل أنت متأكد من رغبتك في حذف ملف الصورة (${name}) نهائياً من التخزين؟`)) {
            document.getElementById('deleteMediaPath').value = path;
            document.getElementById('deleteMediaForm').submit();
        }
    }

    // Drag and Drop Upload Handler
    const dropzone = document.getElementById('dropzoneBox');
    const fileInput = document.getElementById('mediaFileInput');
    const uploadForm = document.getElementById('mediaUploadForm');
    const indicator = document.getElementById('uploadingIndicator');

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('drag-over');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('drag-over');
        }, false);
    });

    dropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files && files.length > 0) {
            fileInput.files = files;
            submitUpload();
        }
    });

    function handleFileSelect(input) {
        if (input.files && input.files.length > 0) {
            submitUpload();
        }
    }

    function submitUpload() {
        indicator.style.display = 'block';
        uploadForm.submit();
    }
</script>
@endpush
@endsection
