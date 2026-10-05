@extends('errors.layout')

@section('title', __('الصفحة غير موجودة | 404 Not Found'))

@section('content')
    <div class="ox-error-badge">404 ERROR</div>
    <h1 class="ox-error-code">404</h1>
    <h2 class="ox-error-title">{{ app()->getLocale() === 'ar' ? 'عذراً، الصفحة التي تبحث عنها غير موجودة' : 'Page Not Found' }}</h2>
    <p class="ox-error-desc">
        {{ app()->getLocale() === 'ar' 
            ? 'قد يكون الرابط الذي اتبعته قديماً أو تم نقل الصفحة إلى مسار جديد. يمكنك العودة للصفحة الرئيسية أو استكشاف مشاريعنا.' 
            : 'The link you followed may be broken, or the page may have been removed or moved.' }}
    </p>
    <div class="ox-error-actions">
        <a href="{{ route('home') }}" class="btn-action-primary">
            {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Homepage' }}
        </a>
        <a href="{{ route('projects.index') }}" class="btn-action-secondary">
            {{ app()->getLocale() === 'ar' ? 'سابقة الأعمال' : 'Our Portfolio' }}
        </a>
        <a href="{{ route('store.index') }}" class="btn-action-secondary">
            {{ app()->getLocale() === 'ar' ? 'متجر البرمجيات' : 'Digital Store' }}
        </a>
    </div>
@endsection
