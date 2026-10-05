@extends('errors.layout')

@section('title', __('خطأ في الخادم | 500 Server Error'))

@section('content')
    <div class="ox-error-badge">500 SERVER ERROR</div>
    <h1 class="ox-error-code">500</h1>
    <h2 class="ox-error-title">{{ app()->getLocale() === 'ar' ? 'حدث خطأ غير متوقع في النظام' : 'Internal Server Error' }}</h2>
    <p class="ox-error-desc">
        {{ app()->getLocale() === 'ar' 
            ? 'نعتذر عن هذا الخلل. تم تسجيل المشكلة تلقائياً وسيقوم فريقنا الهندسي بمعالجتها فوراً.' 
            : 'Something went wrong on our servers. Our team has been notified.' }}
    </p>
    <div class="ox-error-actions">
        <a href="{{ route('home') }}" class="btn-action-primary">
            {{ app()->getLocale() === 'ar' ? 'العودة للرئيسية' : 'Return Home' }}
        </a>
    </div>
@endsection
