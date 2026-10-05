@extends('errors.layout')

@section('title', __('انتهت الجلسة | 419 Page Expired'))

@section('content')
    <div class="ox-error-badge">419 EXPIRED</div>
    <h1 class="ox-error-code">419</h1>
    <h2 class="ox-error-title">{{ app()->getLocale() === 'ar' ? 'انتهت صلاحية الجلسة أو النموذج' : 'Page Expired' }}</h2>
    <p class="ox-error-desc">
        {{ app()->getLocale() === 'ar' 
            ? 'انتهت صلاحية رمز الأمان (CSRF Token) بسبب عدم النشاط لفترة. يرجى تحديث الصفحة وإعادة المحاولة.' 
            : 'Your security session has expired. Please refresh the page and try submitting again.' }}
    </p>
    <div class="ox-error-actions">
        <button type="button" onclick="window.location.reload();" class="btn-action-primary">
            {{ app()->getLocale() === 'ar' ? 'تحديث الصفحة' : 'Refresh Page' }}
        </button>
        <a href="{{ route('home') }}" class="btn-action-secondary">
            {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
        </a>
    </div>
@endsection
