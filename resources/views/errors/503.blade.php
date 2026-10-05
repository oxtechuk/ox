@extends('errors.layout')

@section('title', __('المنصة تحت الصيانة | 503 Maintenance'))

@section('content')
    <div class="ox-error-badge">503 MAINTENANCE</div>
    <h1 class="ox-error-code">503</h1>
    <h2 class="ox-error-title">{{ app()->getLocale() === 'ar' ? 'المنصة قيد التحديث والترقية المجدولة' : 'Under Scheduled Maintenance' }}</h2>
    <p class="ox-error-desc">
        {{ app()->getLocale() === 'ar' 
            ? 'نقوم حالياً بإجراء تحسينات تقنية لتقديم أفضل تجربة برمجية وسحابية ممكنة. سنعود للعمل خلال لحظات.' 
            : 'We are performing scheduled maintenance to upgrade our infrastructure. We will be back shortly.' }}
    </p>
    <div class="ox-error-actions">
        <button type="button" onclick="window.location.reload();" class="btn-action-primary">
            {{ app()->getLocale() === 'ar' ? 'إعادة المحاولة' : 'Check Again' }}
        </button>
    </div>
@endsection
