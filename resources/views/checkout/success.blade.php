@extends('layouts.app')

@section('title', 'تم تأكيد طلبك بنجاح | ' . config('app.name', 'Ox Tech'))

@section('content')
<style>
/* ─── Clean White Theme Success Page ─── */
body {
    background-color: #f8fafc !important;
}

.white-success-wrapper {
    background-color: #f8fafc;
    min-height: 90vh;
    padding: 60px 16px 100px;
    font-family: 'Alexandria', system-ui, sans-serif;
    direction: rtl;
    color: #1e293b;
}

.success-container {
    max-width: 820px;
    margin: 0 auto;
}

.success-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 28px;
    padding: 44px 36px;
    text-align: center;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.04);
}

.success-icon-bubble {
    width: 76px;
    height: 76px;
    margin: 0 auto 20px;
    border-radius: 22px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
}

.success-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 14px;
}

.success-title {
    font-size: 28px;
    font-weight: 900;
    color: #0f172a;
    line-height: 1.3;
    margin: 0 0 10px;
}

.success-subtitle {
    font-size: 14.5px;
    color: #64748b;
    line-height: 1.6;
    max-width: 580px;
    margin: 0 auto 26px;
}

.order-meta-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 16px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    padding: 10px 20px;
    border-radius: 14px;
    font-size: 12.5px;
    color: #475569;
    margin-bottom: 34px;
}

.order-meta-pill strong {
    color: #0f172a;
}

.order-meta-pill .amount-highlight {
    color: #059669;
    font-weight: 800;
}

/* Products License Section */
.products-licenses-list {
    display: flex;
    flex-direction: column;
    gap: 18px;
    text-align: right;
    margin-bottom: 30px;
}

.license-item-card {
    background: #fafbfc;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    padding: 24px;
    transition: border-color 0.2s;
}

.license-item-card:hover {
    border-color: #cbd5e1;
}

.license-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 16px;
}

.product-item-title {
    font-size: 17px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 3px;
}

.product-version-badge {
    font-size: 11.5px;
    color: #64748b;
    font-family: monospace;
}

.active-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
    font-size: 11.5px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 99px;
}

/* License Key Input Group */
.license-box-wrapper {
    background: #ffffff;
    border: 1.5px dashed #cbd5e1;
    border-radius: 14px;
    padding: 14px 18px;
    margin-bottom: 18px;
}

.license-box-label {
    display: block;
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 6px;
}

.license-input-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.license-code-input {
    flex: 1;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 10px;
    padding: 8px 14px;
    font-family: monospace;
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: 1px;
    outline: none;
}

.btn-copy-key {
    background: #2563eb;
    color: #ffffff;
    border: none;
    padding: 9px 18px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    transition: background 0.2s;
    white-space: nowrap;
}

.btn-copy-key:hover {
    background: #1d4ed8;
}

/* Download Action Row */
.download-action-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 6px;
}

.btn-download-software {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #059669, #10b981);
    color: #ffffff;
    padding: 12px 24px;
    border-radius: 14px;
    font-size: 13.5px;
    font-weight: 800;
    text-decoration: none;
    box-shadow: 0 6px 18px rgba(16, 185, 129, 0.25);
    transition: all 0.2s ease;
}

.btn-download-software:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(16, 185, 129, 0.35);
}

.download-limits-hint {
    font-size: 12px;
    color: #64748b;
}

.download-limits-hint strong {
    color: #1e293b;
}

/* Email notice box */
.email-alert-notice {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 18px;
    padding: 18px 22px;
    text-align: right;
    margin-bottom: 30px;
}

.email-alert-title {
    font-size: 13.5px;
    font-weight: 800;
    color: #1e40af;
    margin: 0 0 5px;
}

.email-alert-text {
    font-size: 12.5px;
    color: #3b82f6;
    line-height: 1.6;
    margin: 0;
}

/* Bottom Action Buttons */
.success-actions-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    flex-wrap: wrap;
}

.btn-to-dashboard {
    background: #2563eb;
    color: #ffffff;
    padding: 12px 26px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
    transition: all 0.2s ease;
}

.btn-to-dashboard:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
}

.btn-to-store {
    background: #ffffff;
    color: #475569;
    border: 1px solid #cbd5e1;
    padding: 12px 24px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-to-store:hover {
    background: #f1f5f9;
    color: #0f172a;
    border-color: #94a3b8;
}

@media (max-width: 640px) {
    .success-main-card {
        padding: 30px 18px;
    }
    .order-meta-pill {
        flex-direction: column;
        gap: 6px;
    }
    .license-input-row {
        flex-direction: column;
        align-items: stretch;
    }
    .download-action-row {
        flex-direction: column;
        align-items: stretch;
    }
    .btn-download-software {
        justify-content: center;
    }
}
</style>

<div class="white-success-wrapper">
    <div class="success-container">
        
        <div class="success-main-card">
            
            {{-- Checkmark Icon --}}
            <div class="success-icon-bubble">
                ✓
            </div>

            <div class="success-badge">
                <span>🛡️</span>
                <span>تم الدفع والتحقق بنجاح عبر PaySky</span>
            </div>

            <h1 class="success-title">
                تهانينا! اكتمل طلبك بنجاح وجاهز للتنزيل
            </h1>

            <p class="success-subtitle">
                شكراً لك يا <strong>{{ $order->customer_name }}</strong>، تم استلام المبلغ بنجاح وتوليد تراخيصك الخاصة وروابط التنزيل المباشرة.
            </p>

            {{-- Summary Pill --}}
            <div class="order-meta-pill">
                <span>رقم الطلب: <strong>#{{ $order->order_number }}</strong></span>
                <span>•</span>
                <span>المبلغ المدفوع: <strong class="amount-highlight">{{ number_format($order->total_amount, 2) }} {{ $order->currency }}</strong></span>
                <span>•</span>
                <span>المرجع: <strong style="font-family: monospace;">{{ $order->merchant_reference }}</strong></span>
            </div>

            {{-- Product Items & Licenses --}}
            <div class="products-licenses-list">
                @foreach($order->items as $item)
                    @php
                        $product = $item->product;
                        $tokenRecord = $order->downloadTokens->where('product_id', $product->id)->first();
                    @endphp

                    <div class="license-item-card">
                        <div class="license-card-header">
                            <div>
                                <h2 class="product-item-title">{{ $product->name }}</h2>
                                <span class="product-version-badge">الإصدار v{{ $product->version ?? '1.0' }}</span>
                            </div>
                            <span class="active-status-badge">
                                <span>●</span> ترخيص معتمد ومفعل
                            </span>
                        </div>

                        {{-- License Key Box --}}
                        @if($item->license_key)
                            <div class="license-box-wrapper">
                                <label class="license-box-label">مفتاح الترخيص الخاص بك (License Key):</label>
                                <div class="license-input-row">
                                    <input type="text" readonly id="key_{{ $item->id }}" value="{{ $item->license_key }}" class="license-code-input">
                                    <button type="button" onclick="copyToClipboard('key_{{ $item->id }}')" class="btn-copy-key">
                                        📋 نسخ المفتاح
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Download Button --}}
                        @if($tokenRecord)
                            <div class="download-action-row">
                                <a href="{{ route('digital.download', $tokenRecord->token) }}" class="btn-download-software">
                                    <span>⬇️ تحميل البرنامج الآن ({{ $product->file_name ?: 'ملف الإعداد والتثبيت' }})</span>
                                </a>

                                <div class="download-limits-hint">
                                    صالح حتى: <strong>{{ $tokenRecord->expires_at ? $tokenRecord->expires_at->format('Y-m-d') : '30 يوماً' }}</strong>
                                    (متبقي <strong>{{ max(0, $tokenRecord->max_downloads - $tokenRecord->download_count) }}</strong> تحميلات)
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Account & Email Alert --}}
            <div class="email-alert-notice">
                <h3 class="email-alert-title">📩 تم إرسال تفاصيل الطلب والترخيص إلى بريدك</h3>
                <p class="email-alert-text">
                    لقد قمنا بإرسال الفاتورة الرسمية، مفتاح الترخيص، وروابط التنزيل المباشرة إلى: <strong>{{ $order->customer_email }}</strong>.<br>
                    تم إنشاء حساب عميل لك تلقائياً لتتمكن من تنزيل تحديثات البرنامج ومراجعة فواتيرك في أي وقت.
                </p>
            </div>

            {{-- Actions --}}
            <div class="success-actions-row">
                <a href="{{ route('customer.dashboard') }}" class="btn-to-dashboard">
                    الانتقال إلى لوحة حسابي الشخصي ←
                </a>
                <a href="{{ route('store.index') }}" class="btn-to-store">
                    تصفح المزيد من البرامج بالمتجر
                </a>
            </div>

        </div>

    </div>
</div>

<script>
function copyToClipboard(elementId) {
    const input = document.getElementById(elementId);
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value);
    alert('تم نسخ مفتاح الترخيص بنجاح إلى الحافظة!');
}
</script>
@endsection
