@extends('errors.layout')

@section('title', __('غير مصرح | 403 Forbidden'))

@section('content')
    <div class="ox-error-badge">403 FORBIDDEN</div>
    <h1 class="ox-error-code">403</h1>
    <h2 class="ox-error-title">{{ app()->getLocale() === 'ar' ? 'عذراً، الوصول غير مصرح به' : 'Access Forbidden' }}</h2>
    <p class="ox-error-desc">
        {{ app()->getLocale() === 'ar' 
            ? 'ليس لديك الصلاحيات الكافية للوصول إلى هذا المورد أو لوحة التحكم المطلوبة.' 
            : 'You do not have permission to access the requested resource.' }}
    </p>
    <div class="ox-error-actions">
        <a href="{{ route('home') }}" class="btn-action-primary">
            {{ app()->getLocale() === 'ar' ? 'العودة للرئيسية' : 'Return Home' }}
        </a>
    </div>
@endsection
