@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name . ' | ' . config('app.name', 'Ox Tech'))
@section('meta_description', $product->meta_description ?: $product->tagline)

@section('content')
<style>
/* ─── White Theme Product Details ─── */
body {
    background-color: #f8fafc !important;
}

.white-product-wrapper {
    background: #f8fafc;
    color: #1e293b;
    min-height: 100vh;
    padding: 30px 16px 80px;
    font-family: 'Alexandria', system-ui, sans-serif;
    direction: rtl;
}

.details-container {
    max-width: 1200px;
    margin: 0 auto;
}

.breadcrumbs {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #64748b;
    margin-bottom: 24px;
}
.breadcrumbs a {
    color: #64748b;
    text-decoration: none;
}
.breadcrumbs a:hover {
    color: #2563eb;
}

.details-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 30px;
}
@media (min-width: 1024px) {
    .details-layout {
        grid-template-columns: 2fr 1fr;
    }
}

.white-section-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
}

.product-hero-badge-row {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}

.tag-blue {
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 8px;
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #dbeafe;
}

.tag-version {
    font-size: 11.5px;
    font-family: monospace;
    padding: 4px 10px;
    border-radius: 8px;
    background: #f1f5f9;
    color: #475569;
}

.tag-green {
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 8px;
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}

.main-title {
    font-size: 28px;
    font-weight: 900;
    color: #0f172a;
    line-height: 1.35;
    margin-bottom: 10px;
}

.main-tagline {
    font-size: 15px;
    color: #475569;
    line-height: 1.7;
    margin-bottom: 22px;
}

.preview-box {
    background: linear-gradient(135deg, #f0fdf4 0%, #eff6ff 100%);
    border: 1.5px dashed #bfdbfe;
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    margin-top: 10px;
}

.section-h2 {
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.features-2col {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 12px;
}

.feature-pill-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 16px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 13px;
    color: #334155;
    line-height: 1.5;
}

/* Sticky Checkout Sidebar */
.sticky-checkout-card {
    background: #ffffff;
    border: 2px solid #2563eb;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.08);
    position: sticky;
    top: 24px;
}

.sidebar-price-row {
    margin-bottom: 20px;
    padding-bottom: 18px;
    border-bottom: 1px solid #e2e8f0;
}

.sidebar-price-val {
    font-size: 32px;
    font-weight: 900;
    color: #0f172a;
}

.form-label-custom {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 4px;
}

.form-input-custom {
    width: 100%;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    font-family: inherit;
    outline: none;
    box-sizing: border-box;
    margin-bottom: 14px;
    background: #ffffff;
    color: #0f172a;
}

.form-input-custom:focus {
    border-color: #2563eb;
}

.btn-sidebar-pay {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    background: #2563eb;
    color: #ffffff;
    border: none;
    font-size: 14px;
    font-weight: 800;
    font-family: inherit;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    transition: all 0.2s ease;
}

.btn-sidebar-pay:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
}
</style>

<div class="white-product-wrapper">
    <div class="details-container">
        
        {{-- Breadcrumbs --}}
        <nav class="breadcrumbs">
            <a href="{{ route('home') }}">الرئيسية</a>
            <span>/</span>
            <a href="{{ route('store.index') }}">متجر البرمجيات</a>
            <span>/</span>
            @if($product->category)
                <a href="{{ route('store.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                <span>/</span>
            @endif
            <span style="color: #0f172a; font-weight: 700;">{{ $product->name }}</span>
        </nav>

        <div class="details-layout">
            
            {{-- Main Content --}}
            <div>
                {{-- Hero Card --}}
                <div class="white-section-card">
                    <div class="product-hero-badge-row">
                        @if($product->category)
                            <span class="tag-blue">{{ $product->category->name }}</span>
                        @endif
                        <span class="tag-version">الإصدار v{{ $product->version }}</span>
                        <span class="tag-green">✓ ترخيص رسمي دائم</span>
                    </div>

                    <h1 class="main-title">{{ $product->name }}</h1>

                    @if($product->tagline)
                        <p class="main-tagline">{{ $product->tagline }}</p>
                    @endif

                    <div class="preview-box">
                        <div style="font-size: 44px; margin-bottom: 10px;">💻</div>
                        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">حزمة التثبيت الرقمية المباشرة</h3>
                        <p style="font-size: 13px; color: #64748b; max-width: 500px; margin: 0 auto 16px;">
                            تتضمن الحزمة ملف التثبيت المعتمد، مفتاح الترخيص الفريد الصادر باسمك، ودليل التشغيل السريع.
                        </p>
                        @if($product->landingPage)
                            <a href="{{ route('store.landing', $product->landingPage->slug) }}" style="display: inline-block; font-size: 13px; font-weight: 700; color: #d97706; text-decoration: underline;">
                                🚀 الانتقال لصفحة العرض الترويجي والتفاصيل الحصرية &larr;
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Full Description --}}
                <div class="white-section-card">
                    <h2 class="section-h2">📌 نبذة تفصيلية عن البرنامج</h2>
                    <div style="font-size: 14px; line-height: 1.8; color: #334155; white-space: pre-line;">
                        {{ $product->description }}
                    </div>
                </div>

                {{-- Key Features --}}
                @if(!empty($product->features) && is_array($product->features))
                    <div class="white-section-card">
                        <h2 class="section-h2">⚡ أبرز المميزات والوظائف</h2>
                        <div class="features-2col">
                            @foreach($product->features as $feature)
                                <div class="feature-pill-card">
                                    <span style="color: #059669; font-weight: 800; font-size: 14px;">✓</span>
                                    <span>{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- System Requirements --}}
                @if(!empty($product->system_requirements) && is_array($product->system_requirements))
                    <div class="white-section-card">
                        <h2 class="section-h2">⚙️ متطلبات تشغيل النظام</h2>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach($product->system_requirements as $req)
                                <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #334155; background: #f8fafc; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                    <span style="color: #2563eb;">▹</span>
                                    <span>{{ $req }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            {{-- Sticky Checkout Sidebar --}}
            <div>
                <div class="sticky-checkout-card">
                    <div class="sidebar-price-row">
                        <div style="font-size: 12px; color: #64748b; margin-bottom: 2px;">سعر الترخيص النهائي:</div>
                        <div style="display: flex; align-items: baseline; gap: 8px;">
                            <span class="sidebar-price-val">{{ number_format($product->effective_price, 2) }}</span>
                            <span style="font-size: 14px; font-weight: 700; color: #2563eb;">{{ $product->currency }}</span>
                            @if($product->has_discount)
                                <span style="font-size: 14px; color: #94a3b8; text-decoration: line-through;">{{ number_format($product->price, 2) }}</span>
                                <span style="background: #fee2e2; color: #b91c1c; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 6px;">
                                    وفرت {{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                        <div style="font-size: 11.5px; color: #059669; font-weight: 700; margin-top: 4px;">● ترخيص دائم بدون أي رسوم شهرية</div>
                    </div>

                    <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 14px;">⚡ شراء وتفعيل فوري</h3>

                    <form id="detailsCheckoutForm" onsubmit="handleDetailsCheckout(event)">
                        @csrf
                        <input type="hidden" id="pId" value="{{ $product->id }}">
                        <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
                        <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
                        <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">

                        <div>
                            <label class="form-label-custom">الاسم بالكامل *</label>
                            <input type="text" id="pName" required placeholder="اسمك الكريم" class="form-input-custom">
                        </div>

                        <div>
                            <label class="form-label-custom">البريد الإلكتروني (هام: لاستلام الترخيص) *</label>
                            <input type="email" id="pEmail" required placeholder="example@mail.com" class="form-input-custom">
                        </div>

                        <div>
                            <label class="form-label-custom">رقم الهاتف / الواتساب</label>
                            <input type="tel" id="pPhone" placeholder="010xxxxxxxx" class="form-input-custom">
                        </div>

                        <button type="submit" id="btnDetailsPay" class="btn-sidebar-pay">
                            الدفع الآن عبر PaySky ({{ number_format($product->effective_price, 2) }} {{ $product->currency }}) &larr;
                        </button>
                    </form>

                    <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 8px; font-size: 12px; color: #475569;">
                        <div><strong style="color: #059669;">✓</strong> تنزيل فوري للملف بعد الدفع</div>
                        <div><strong style="color: #059669;">✓</strong> توليد مفتاح ترخيص رسمي باسمك</div>
                        <div><strong style="color: #059669;">✓</strong> إرسال الفاتورة والملفات لبريدك</div>
                        <div style="color: #2563eb; font-weight: 700; margin-top: 4px;">🔒 دفع مؤمن ومشفر عبر PaySky Omni Gateway</div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
function loadPaySkyAsync(scriptUrl) {
    return new Promise((resolve) => {
        if (typeof window.Lightbox !== 'undefined' && typeof window.Lightbox.Checkout !== 'undefined') {
            return resolve(true);
        }
        const script = document.createElement('script');
        script.src = scriptUrl;
        script.async = true;
        script.onload = () => resolve(true);
        script.onerror = () => {
            console.warn('PaySky JS could not be reached via current DNS/network. Proceeding to simulated/fallback checkout.');
            resolve(false);
        };
        document.head.appendChild(script);
    });
}

let currentMerchantRef = '';

function logGatewayError(ref, message, errorData, source, status) {
    try {
        fetch('{{ route('checkout.paysky.log_error') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                merchant_reference: ref || currentMerchantRef,
                message: message,
                error: errorData,
                source: source || 'lightbox_client',
                status: status || 'failed'
            })
        }).catch(console.error);
    } catch (e) {
        console.error('Failed to log error to server:', e);
    }
}

window.addEventListener('message', function (event) {
    if (event.data && typeof event.data === 'object') {
        if (event.data.callback === 'errorCallback' || event.data.status === 'failed') {
            logGatewayError(
                currentMerchantRef,
                'خطأ وارد من نافذة PaySky (postMessage): ' + (event.data.Info?.Message || event.data.message || JSON.stringify(event.data)),
                event.data,
                'paysky_post_message',
                'failed'
            );
        }
    }
});

async function handleDetailsCheckout(e) {
    e.preventDefault();
    const btn = document.getElementById('btnDetailsPay');
    btn.disabled = true;
    btn.innerText = 'جاري التحضير...';

    const payload = {
        _token: '{{ csrf_token() }}',
        product_id: document.getElementById('pId').value,
        customer_name: document.getElementById('pName').value,
        customer_email: document.getElementById('pEmail').value,
        customer_phone: document.getElementById('pPhone').value,
        utm_source: '{{ request('utm_source') }}',
        utm_medium: '{{ request('utm_medium') }}',
        utm_campaign: '{{ request('utm_campaign') }}',
    };

    try {
        const response = await fetch('{{ route('checkout.initiate') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (data.success && data.paysky) {
            currentMerchantRef = data.paysky.MerchantReference || data.merchant_reference || '';
            btn.innerText = 'فتح بوابة PaySky...';

            const scriptLoaded = await loadPaySkyAsync(data.paysky.ScriptUrl);

            if (scriptLoaded && typeof Lightbox !== 'undefined' && typeof Lightbox.Checkout !== 'undefined') {
                Lightbox.Checkout.configure = {
                    MID: data.paysky.MID,
                    TID: data.paysky.TID,
                    AmountTrxn: data.paysky.AmountTrxn,
                    MerchantReference: data.paysky.MerchantReference,
                    TrxDateTime: data.paysky.TrxDateTime,
                    SecureHash: data.paysky.SecureHash,
                    completeCallback: function (dataResponse) {
                        window.location.href = data.callback_url + '?MerchantReference=' + encodeURIComponent(data.paysky.MerchantReference) + '&Success=true';
                    },
                    errorCallback: function (error) {
                        const errMsg = (error && (error.Message || error.errorMessage || error.message)) ? (error.Message || error.errorMessage || error.message) : JSON.stringify(error || 'خطأ غير محدد من البوابة');
                        logGatewayError(
                            data.paysky.MerchantReference,
                            'فشل الدفع في نافذة PaySky (errorCallback): ' + errMsg,
                            error,
                            'paysky_error_callback',
                            'failed'
                        );
                        alert('حدث خطأ أثناء الدفع: ' + (error?.Message || error?.errorMessage || 'يرجى مراجعة بيانات البطاقة أو المحاولة مجدداً'));
                        btn.disabled = false;
                        btn.innerText = 'الدفع الآن عبر PaySky ←';
                    },
                    cancelCallback: function () {
                        logGatewayError(
                            data.paysky.MerchantReference,
                            'قام المستخدم بإلغاء أو إغلاق نافذة الدفع PaySky Lightbox',
                            { action: 'lightbox_cancelled' },
                            'lightbox_cancelled',
                            'cancelled'
                        );
                        btn.disabled = false;
                        btn.innerText = 'الدفع الآن عبر PaySky ←';
                    }
                };
                Lightbox.Checkout.showLightbox();
            } else {
                window.location.href = data.callback_url + '?MerchantReference=' + encodeURIComponent(data.paysky.MerchantReference) + '&Success=true';
            }
        } else {
            logGatewayError(
                '',
                'فشل إنشاء أمر الدفع من السيرفر: ' + (data.message || 'بيانات غير مكتملة'),
                data,
                'checkout_initiate_failed',
                'failed'
            );
            alert(data.message || 'حدث خطأ أثناء معالجة الطلب.');
            btn.disabled = false;
            btn.innerText = 'الدفع الآن عبر PaySky ←';
        }
    } catch (err) {
        console.error(err);
        logGatewayError(
            currentMerchantRef,
            'استثناء في متصفح العميل أثناء محاولة الدفع: ' + (err.message || String(err)),
            { error: String(err), stack: err.stack },
            'client_exception',
            'failed'
        );
        alert('حدث خطأ بالاتصال. يرجى المحاولة مجدداً.');
        btn.disabled = false;
        btn.innerText = 'الدفع الآن عبر PaySky ←';
    }
}
</script>
@endsection
