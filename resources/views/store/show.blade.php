@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name . ' | ' . config('app.name', 'Ox Tech'))
@section('meta_description', $product->meta_description ?: $product->tagline)

@section('content')
<style>
/* ─── OxTech Dark Emerald & Carbon Theme Product Details ─── */
.ox-product-wrapper {
    background: radial-gradient(circle at 50% 0%, rgba(29, 138, 104, 0.18) 0%, transparent 65%), #071B19;
    color: #F3EFE5;
    min-height: 100vh;
    padding: 35px 16px 90px;
    font-family: 'Alexandria', 'Cairo', system-ui, sans-serif;
    direction: rtl;
    position: relative;
    overflow: hidden;
}

.details-container {
    max-width: 1220px;
    margin: 0 auto;
    position: relative;
    z-index: 3;
}

.breadcrumbs {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12.5px;
    color: #A7B3AE;
    margin-bottom: 28px;
}

.breadcrumbs a {
    color: #A7B3AE;
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumbs a:hover {
    color: #34D399;
}

.breadcrumbs span.separator {
    color: #10B981;
    font-size: 11px;
}

.details-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 32px;
}

@media (min-width: 1024px) {
    .details-layout {
        grid-template-columns: 2fr 1fr;
    }
}

.ox-section-card {
    background: rgba(13, 41, 37, 0.75);
    border: 1px solid rgba(29, 138, 104, 0.25);
    border-radius: 24px;
    padding: 32px;
    margin-bottom: 26px;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35);
    backdrop-filter: blur(16px);
}

.product-hero-badge-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.tag-emerald {
    font-size: 11.5px;
    font-weight: 700;
    padding: 5px 14px;
    border-radius: 8px;
    background: rgba(29, 138, 104, 0.2);
    color: #34D399;
    border: 1px solid rgba(29, 138, 104, 0.4);
}

.tag-version {
    font-size: 11.5px;
    font-family: monospace;
    padding: 4px 10px;
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.06);
    color: #A7B3AE;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.tag-gold {
    font-size: 11.5px;
    font-weight: 800;
    padding: 5px 14px;
    border-radius: 8px;
    background: rgba(200, 169, 107, 0.18);
    color: #E5C989;
    border: 1px solid #C8A96B;
}

.main-title {
    font-size: 32px;
    font-weight: 900;
    color: #F3EFE5;
    line-height: 1.35;
    margin-bottom: 12px;
    letter-spacing: -0.5px;
}

.main-tagline {
    font-size: 15.5px;
    color: #A7B3AE;
    line-height: 1.75;
    margin-bottom: 24px;
}

/* Dark Workspace Showcase Box */
.workspace-preview-box {
    background: radial-gradient(circle at 50% 30%, rgba(29, 138, 104, 0.22) 0%, rgba(7, 27, 25, 0.85) 75%);
    border: 1.5px solid rgba(29, 138, 104, 0.35);
    border-radius: 20px;
    padding: 38px 24px;
    text-align: center;
    margin-top: 14px;
    box-shadow: inset 0 0 35px rgba(0, 0, 0, 0.5), 0 10px 30px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
}

.section-h2 {
    font-size: 19px;
    font-weight: 800;
    color: #F3EFE5;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.features-2col {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 14px;
}

.feature-pill-card {
    background: rgba(7, 27, 25, 0.65);
    border: 1px solid rgba(29, 138, 104, 0.25);
    border-radius: 14px;
    padding: 14px 18px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 13.5px;
    color: #F3EFE5;
    line-height: 1.55;
    transition: all 0.2s ease;
}

.feature-pill-card:hover {
    border-color: rgba(16, 185, 129, 0.5);
    background: rgba(18, 53, 47, 0.7);
}

/* Sticky Checkout Sidebar */
.sticky-checkout-card {
    background: #0D2925;
    border: 1.5px solid rgba(29, 138, 104, 0.45);
    border-radius: 26px;
    padding: 30px;
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.5), 0 0 30px rgba(29, 138, 104, 0.15);
    position: sticky;
    top: 24px;
    color: #F3EFE5;
}

.sidebar-price-row {
    margin-bottom: 22px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(29, 138, 104, 0.25);
}

.sidebar-price-val {
    font-size: 34px;
    font-weight: 900;
    color: #F3EFE5;
}

.form-label-custom {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #A7B3AE;
    margin-bottom: 6px;
}

.form-input-custom {
    width: 100%;
    border: 1.5px solid rgba(29, 138, 104, 0.3);
    border-radius: 12px;
    padding: 11px 15px;
    font-size: 13.5px;
    font-family: inherit;
    outline: none;
    box-sizing: border-box;
    margin-bottom: 14px;
    background: #071B19;
    color: #F3EFE5;
    transition: all 0.2s ease;
}

.form-input-custom:focus {
    border-color: #10B981;
    box-shadow: 0 0 15px rgba(16, 185, 129, 0.25);
}

.btn-sidebar-pay {
    width: 100%;
    padding: 15px;
    border-radius: 14px;
    background: linear-gradient(135deg, #1D8A68 0%, #10B981 100%);
    color: #ffffff;
    border: none;
    font-size: 14.5px;
    font-weight: 800;
    font-family: inherit;
    cursor: pointer;
    box-shadow: 0 6px 22px rgba(29, 138, 104, 0.4);
    transition: all 0.25s ease;
}

.btn-sidebar-pay:hover {
    background: linear-gradient(135deg, #187759 0%, #059669 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(29, 138, 104, 0.55);
}
</style>

<div class="ox-product-wrapper">
    <!-- Arabesque Corner Tracery Patterns from Homepage Theme -->
    <div class="arabesque-corner corner-top-right"></div>
    <div class="arabesque-corner corner-top-left"></div>

    <div class="details-container">
        
        {{-- Breadcrumbs --}}
        <nav class="breadcrumbs">
            <a href="{{ route('home') }}">الرئيسية</a>
            <span class="separator">/</span>
            <a href="{{ route('store.index') }}">متجر البرمجيات</a>
            <span class="separator">/</span>
            @if($product->category)
                <a href="{{ route('store.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                <span class="separator">/</span>
            @endif
            <span style="color: #34D399; font-weight: 700;">{{ $product->name }}</span>
        </nav>

        <div class="details-layout">
            
            {{-- Main Content --}}
            <div>
                {{-- Hero Card --}}
                <div class="ox-section-card">
                    <div class="product-hero-badge-row">
                        @if($product->category)
                            <span class="tag-emerald">{{ $product->category->name }}</span>
                        @endif
                        <span class="tag-version">الإصدار v{{ $product->version }}</span>
                        <span class="tag-gold">✓ ترخيص رسمي دائم</span>
                    </div>

                    <h1 class="main-title">{{ $product->name }}</h1>

                    @if($product->tagline)
                        <p class="main-tagline">{{ $product->tagline }}</p>
                    @endif

                    <div class="workspace-preview-box">
                        <div style="font-size: 48px; margin-bottom: 12px;">💻</div>
                        <h3 style="font-size: 19px; font-weight: 800; color: #F3EFE5; margin-bottom: 8px;">حزمة التثبيت والترخيص الرقمي المعتمد</h3>
                        <p style="font-size: 13.5px; color: #A7B3AE; max-width: 520px; margin: 0 auto 18px; line-height: 1.7;">
                            تتضمن الحزمة ملف التثبيت المعتمد، مفتاح الترخيص الفريد الصادر باسمك أو شركتك، ودليل التشغيل السريع مع التحديثات.
                        </p>
                        @if($product->landingPage)
                            <a href="{{ route('store.landing', $product->landingPage->slug) }}" style="display: inline-block; font-size: 13.5px; font-weight: 800; color: #C8A96B; text-decoration: none; padding: 8px 16px; border: 1px solid rgba(200, 169, 107, 0.4); border-radius: 10px; background: rgba(200, 169, 107, 0.1);">
                                🚀 الانتقال لصفحة العرض الترويجي والتفاصيل الحصرية &larr;
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Full Description --}}
                <div class="ox-section-card">
                    <h2 class="section-h2">📌 نبذة تفصيلية عن البرنامج</h2>
                    <div style="font-size: 14.5px; line-height: 1.85; color: #D1DCD6; white-space: pre-line;">
                        {{ $product->description }}
                    </div>
                </div>

                {{-- Key Features --}}
                @if(!empty($product->features) && is_array($product->features))
                    <div class="ox-section-card">
                        <h2 class="section-h2">⚡ أبرز المميزات والوظائف</h2>
                        <div class="features-2col">
                            @foreach($product->features as $feature)
                                <div class="feature-pill-card">
                                    <span style="color: #10B981; font-weight: 900; font-size: 16px;">✓</span>
                                    <span>{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- System Requirements --}}
                @if(!empty($product->system_requirements) && is_array($product->system_requirements))
                    <div class="ox-section-card">
                        <h2 class="section-h2">⚙️ متطلبات تشغيل النظام</h2>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            @foreach($product->system_requirements as $req)
                                <div style="display: flex; align-items: center; gap: 10px; font-size: 13.5px; color: #D1DCD6; background: rgba(7, 27, 25, 0.65); padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(29, 138, 104, 0.25);">
                                    <span style="color: #34D399; font-weight: 900;">▹</span>
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
                        <div style="font-size: 12px; color: #A7B3AE; margin-bottom: 4px;">سعر الترخيص النهائي:</div>
                        <div style="display: flex; align-items: baseline; gap: 8px;">
                            <span class="sidebar-price-val">{{ number_format($product->effective_price, 2) }}</span>
                            <span style="font-size: 14px; font-weight: 800; color: #34D399;">{{ $product->currency }}</span>
                            @if($product->has_discount)
                                <span style="font-size: 14px; color: #6B7F77; text-decoration: line-through;">{{ number_format($product->price, 2) }}</span>
                                <span style="background: rgba(200, 169, 107, 0.18); border: 1px solid #C8A96B; color: #E5C989; font-size: 11.5px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">
                                    وفرت {{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                        <div style="font-size: 12px; color: #34D399; font-weight: 700; margin-top: 6px;">● ترخيص دائم بدون أي رسوم شهرية</div>
                    </div>

                    <h3 style="font-size: 16px; font-weight: 800; color: #F3EFE5; margin-bottom: 16px;">⚡ شراء وتفعيل فوري</h3>

                    <form id="detailsCheckoutForm" onsubmit="handleDetailsCheckout(event)">
                        @csrf
                        <input type="hidden" id="pId" value="{{ $product->id }}">
                        <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
                        <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
                        <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">

                        <div>
                            <label class="form-label-custom">الاسم بالكامل أو اسم المنشأة *</label>
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

                        <div style="margin-bottom: 18px;">
                            <label class="form-label-custom" style="margin-bottom: 8px;">اختر وسيلة الدفع:</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <button type="button" id="tabPaySky" onclick="switchGateway('paysky')" style="padding: 10px 12px; border-radius: 10px; border: 2px solid #10B981; background: rgba(29, 138, 104, 0.22); color: #34D399; font-weight: 800; font-size: 12.5px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s;">
                                    <span>💳 PaySky / ميزة</span>
                                </button>
                                <button type="button" id="tabPayPal" onclick="switchGateway('paypal')" style="padding: 10px 12px; border-radius: 10px; border: 2px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.05); color: #A7B3AE; font-weight: 800; font-size: 12.5px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s;">
                                    <span>🅿️ PayPal ودولي</span>
                                </button>
                            </div>
                        </div>

                        <div id="paysky-section">
                            <button type="submit" id="btnDetailsPay" class="btn-sidebar-pay">
                                الدفع الآن عبر PaySky ({{ number_format($product->effective_price, 2) }} {{ $product->currency }}) &larr;
                            </button>
                        </div>

                        <div id="paypal-section" style="display: none; margin-top: 12px;">
                            <div id="paypal-button-container" style="min-height: 45px;"></div>
                        </div>
                    </form>

                    <div style="margin-top: 22px; padding-top: 18px; border-top: 1px solid rgba(29, 138, 104, 0.25); display: flex; flex-direction: column; gap: 10px; font-size: 12.5px; color: #A7B3AE;">
                        <div><strong style="color: #10B981;">✓</strong> تنزيل فوري للملف بعد الدفع مباشرة</div>
                        <div><strong style="color: #10B981;">✓</strong> توليد مفتاح ترخيص رسمي باسمك</div>
                        <div><strong style="color: #10B981;">✓</strong> إرسال الفاتورة والملفات لبريدك الإلكتروني</div>
                        <div style="color: #34D399; font-weight: 700; margin-top: 4px;">🔒 دفع مؤمن ومشفر عبر PaySky و PayPal</div>
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

let activeGateway = 'paysky';
let paypalButtonsInitialized = false;

function switchGateway(gateway) {
    activeGateway = gateway;
    const tabPaySky = document.getElementById('tabPaySky');
    const tabPayPal = document.getElementById('tabPayPal');
    const payskySection = document.getElementById('paysky-section');
    const paypalSection = document.getElementById('paypal-section');

    if (gateway === 'paysky') {
        tabPaySky.style.borderColor = '#10B981';
        tabPaySky.style.background = 'rgba(29, 138, 104, 0.22)';
        tabPaySky.style.color = '#34D399';

        tabPayPal.style.borderColor = 'rgba(255, 255, 255, 0.1)';
        tabPayPal.style.background = 'rgba(255, 255, 255, 0.05)';
        tabPayPal.style.color = '#A7B3AE';

        payskySection.style.display = 'block';
        paypalSection.style.display = 'none';
    } else {
        tabPayPal.style.borderColor = '#fbbf24';
        tabPayPal.style.background = 'rgba(251, 191, 36, 0.18)';
        tabPayPal.style.color = '#fde68a';

        tabPaySky.style.borderColor = 'rgba(255, 255, 255, 0.1)';
        tabPaySky.style.background = 'rgba(255, 255, 255, 0.05)';
        tabPaySky.style.color = '#A7B3AE';

        payskySection.style.display = 'none';
        paypalSection.style.display = 'block';

        if (!paypalButtonsInitialized) {
            initPayPalButtons();
        }
    }
}

async function initPayPalButtons() {
    const container = document.getElementById('paypal-button-container');
    if (!container) return;

    container.innerHTML = '<div style="text-align:center; padding:10px; color:#A7B3AE; font-size:12px;">جاري إعداد بوابة PayPal...</div>';

    try {
        const cfgRes = await fetch('{{ route('checkout.paypal.config') }}');
        const cfg = await cfgRes.json();

        if (!cfg.enabled || !cfg.client_id) {
            container.innerHTML = '<div style="background:rgba(239, 68, 68, 0.15); border:1px solid rgba(239, 68, 68, 0.35); color:#fca5a5; padding:10px; border-radius:10px; font-size:12px; text-align:center;">بوابة PayPal غير مهيأة بعد من لوحة التحكم.</div>';
            return;
        }

        if (!window.paypal) {
            await new Promise((resolve, reject) => {
                const s = document.createElement('script');
                s.src = `https://www.paypal.com/sdk/js?client-id=${encodeURIComponent(cfg.client_id)}&currency=${encodeURIComponent(cfg.currency || 'USD')}`;
                s.onload = resolve;
                s.onerror = reject;
                document.head.appendChild(s);
            });
        }

        container.innerHTML = '';
        window.paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'gold',
                shape: 'rect',
                label: 'paypal',
                height: 44
            },
            createOrder: async function(data, actions) {
                const name = document.getElementById('pName').value.trim();
                const email = document.getElementById('pEmail').value.trim();
                const phone = document.getElementById('pPhone').value.trim();

                if (!name || !email) {
                    alert('يرجى كتابة الاسم والبريد الإلكتروني أولاً لاستلام الترخيص.');
                    throw new Error('Name and email required');
                }

                const createRes = await fetch('{{ route('checkout.paypal.create') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                        product_id: document.getElementById('pId').value,
                        customer_name: name,
                        customer_email: email,
                        customer_phone: phone,
                        utm_source: '{{ request('utm_source') }}',
                        utm_medium: '{{ request('utm_medium') }}',
                        utm_campaign: '{{ request('utm_campaign') }}',
                    })
                });

                const resData = await createRes.json();
                if (!resData.success || !resData.paypal_order_id) {
                    alert(resData.message || 'حدث خطأ أثناء إنشاء طلب PayPal.');
                    throw new Error(resData.message);
                }

                currentMerchantRef = resData.merchant_reference;
                return resData.paypal_order_id;
            },
            onApprove: async function(data, actions) {
                container.innerHTML = '<div style="text-align:center; padding:12px; font-weight:800; color:#10B981; font-size:13px;">جاري تأكيد الدفع وإصدار ملفاتك...</div>';
                const captureRes = await fetch('{{ route('checkout.paypal.capture') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                        paypal_order_id: data.orderID,
                        merchant_reference: currentMerchantRef
                    })
                });

                const captureData = await captureRes.json();
                if (captureData.success && captureData.redirect_url) {
                    window.location.href = captureData.redirect_url;
                } else {
                    alert(captureData.message || 'حدث خطأ في استلام الدفع.');
                    paypalButtonsInitialized = false;
                    initPayPalButtons();
                }
            },
            onError: function(err) {
                console.error('PayPal Smart Buttons error:', err);
                logGatewayError(
                    currentMerchantRef,
                    'خطأ في نافذة PayPal: ' + (err.message || String(err)),
                    { error: String(err) },
                    'paypal_sdk_error',
                    'failed'
                );
                alert('حدث خطأ أثناء إجراء الدفع عبر PayPal. يرجى المحاولة لاحقاً.');
            }
        }).render('#paypal-button-container');

        paypalButtonsInitialized = true;
    } catch (err) {
        console.error('PayPal init error:', err);
        container.innerHTML = '<div style="color:#fca5a5; font-size:12px; text-align:center;">تعذر تحميل بوابة PayPal حالياً. يرجى استخدام PaySky.</div>';
    }
}

async function handleDetailsCheckout(e) {
    e.preventDefault();
    const btn = document.getElementById('btnDetailsPay');
    btn.disabled = true;
    btn.innerText = 'جاري التحضير لبوابة PaySky...';

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
            btn.innerText = 'فتح نافذة الدفع...';

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
                        alert('حدث خطأ أثناء معالجة الدفع: ' + (error?.Message || error?.errorMessage || 'يرجى مراجعة بيانات البطاقة أو المحاولة مجدداً'));
                        btn.disabled = false;
                        btn.innerText = 'الدفع الآن عبر PaySky ←';
                    },
                    cancelCallback: function () {
                        logGatewayError(
                            data.paysky.MerchantReference,
                            'قام العميل بإلغاء أو إغلاق نافذة الدفع PaySky Lightbox',
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
                'فشل إنشاء أمر الدفع من الخادم: ' + (data.message || 'بيانات غير مكتملة'),
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
        alert('حدث خطأ بالاتصال بالخادم. يرجى إعادة المحاولة.');
        btn.disabled = false;
        btn.innerText = 'الدفع الآن عبر PaySky ←';
    }
}
</script>
@endsection
