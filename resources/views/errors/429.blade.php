@extends('errors.layout')

@section('title', __('تجاوزت الحد المسموح | 429 Too Many Requests'))

@section('content')
    <div class="ox-error-badge">429 RATE LIMIT</div>
    <h1 class="ox-error-code">429</h1>
    <h2 class="ox-error-title">{{ app()->getLocale() === 'ar' ? 'تم تجاوز عدد المحاولات المسموح بها' : 'Too Many Requests' }}</h2>
    <p class="ox-error-desc">
        {{ app()->getLocale() === 'ar' 
            ? 'لحماية أمان المنصة، تم إيقاف الطلبات مؤقتاً بسبب تكرار المحاولات في وقت قصير. يرجى الانتظار لمدة دقيقة ثم المحاولة مجدداً.' 
            : 'You have made too many requests in a short period. Please wait a minute and try again.' }}
    </p>
    <div class="ox-error-actions">
        <a href="{{ route('home') }}" class="btn-action-primary">
            {{ app()->getLocale() === 'ar' ? 'العودة للرئيسية' : 'Return Home' }}
        </a>
    </div>
@endsection
