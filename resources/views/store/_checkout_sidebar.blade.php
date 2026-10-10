{{-- ═══════════════════════════════════════════════════
     STICKY CHECKOUT SIDEBAR — ScripOx / Product Page
     ═══════════════════════════════════════════════════ --}}
<div class="sp-checkout-card" id="checkoutCard">

    {{-- Countdown if promo active --}}
    @if($promoActive)
        <div class="sp-countdown">
            <div class="sp-countdown-label">⏰ ينتهي العرض خلال</div>
            <div class="sp-countdown-digits">
                <div class="sp-cd-block">
                    <span class="sp-cd-num" id="cd-days">00</span>
                    <div class="sp-cd-unit">يوم</div>
                </div>
                <span class="sp-cd-sep">:</span>
                <div class="sp-cd-block">
                    <span class="sp-cd-num" id="cd-hours">00</span>
                    <div class="sp-cd-unit">ساعة</div>
                </div>
                <span class="sp-cd-sep">:</span>
                <div class="sp-cd-block">
                    <span class="sp-cd-num" id="cd-mins">00</span>
                    <div class="sp-cd-unit">دقيقة</div>
                </div>
                <span class="sp-cd-sep">:</span>
                <div class="sp-cd-block">
                    <span class="sp-cd-num" id="cd-secs">00</span>
                    <div class="sp-cd-unit">ثانية</div>
                </div>
            </div>
        </div>
    @endif

    {{-- Price --}}
    <div class="sp-price-box">
        <div class="sp-price-label">سعر الترخيص الدائم:</div>
        <div class="sp-price-row">
            <span class="sp-price-main" id="displayPrice">{{ number_format($normalPrice, 2) }}</span>
            <span class="sp-price-currency">{{ $product->currency }}</span>
            @if($product->has_discount)
                <span class="sp-price-old">{{ number_format($product->price, 2) }}</span>
            @endif
            <span class="sp-price-save" id="displaySave" style="{{ $product->has_discount ? '' : 'display:none;' }}">
                @if($product->has_discount)
                    وفرت {{ $product->discount_percentage }}%
                @endif
            </span>
        </div>
        <div class="sp-price-note">● ترخيص دائم — ادفع مرة واحدة للأبد</div>
    </div>

    {{-- Promo Code --}}
    @if($promoActive)
        <div class="sp-promo-box">
            <div class="sp-promo-title">
                <span>🎟️</span>
                عندك كود ترقية؟ احصل على السعر الخاص (5$ بدل 100$)
            </div>
            <div class="sp-promo-input-row">
                <input type="text"
                       id="promoInput"
                       class="sp-promo-input"
                       placeholder="أدخل الكود هنا…"
                       maxlength="20"
                       onkeydown="if(event.key==='Enter'){event.preventDefault();applyPromo();}"
                       autocomplete="off">
                <button type="button" class="sp-promo-apply" onclick="applyPromo()">تطبيق</button>
            </div>
            <div id="promoMsg" class="sp-promo-msg"></div>
        </div>
    @endif

    {{-- Checkout Form --}}
    <form id="detailsCheckoutForm" onsubmit="handleDetailsCheckout(event)">
        @csrf
        <input type="hidden" id="pId" value="{{ $product->id }}">
        <input type="hidden" name="utm_source"   value="{{ request('utm_source') }}">
        <input type="hidden" name="utm_medium"   value="{{ request('utm_medium') }}">
        <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">

        <div>
            <label class="sp-form-label">الاسم الكريم / اسم المنشأة *</label>
            <input type="text"  id="pName"  required placeholder="اسمك الكريم"     class="sp-form-input">
        </div>
        <div>
            <label class="sp-form-label">البريد الإلكتروني (لاستلام الترخيص) *</label>
            <input type="email" id="pEmail" required placeholder="example@mail.com" class="sp-form-input">
        </div>
        <div>
            <label class="sp-form-label">رقم الواتساب (اختياري للدعم الفوري)</label>
            <input type="tel"   id="pPhone"          placeholder="010xxxxxxxx"      class="sp-form-input">
        </div>

        {{-- Payment Tabs --}}
        <div class="sp-gw-tabs">
            <button type="button" id="tab-paysky" class="sp-gw-tab active-gw" onclick="switchGateway('paysky')">
                💳 PaySky / ميزة
            </button>
            <button type="button" id="tab-paypal" class="sp-gw-tab" onclick="switchGateway('paypal')">
                🅿️ PayPal ودولي
            </button>
        </div>

        <div id="paysky-section">
            <button type="submit" id="btnDetailsPay" class="sp-pay-btn">
                <span>⚡</span>
                <span>الدفع الآن — {{ number_format($normalPrice, 2) }} {{ $product->currency }} ←</span>
            </button>
        </div>
        <div id="paypal-section" style="display:none; margin-top: 10px;">
            <div id="paypal-button-container" style="min-height: 48px;"></div>
        </div>
    </form>

    {{-- Trust Badges --}}
    <div class="sp-trust-badges">
        <div class="sp-trust-item">
            <span class="sp-trust-icon">✓</span>
            <span>تنزيل فوري للبرنامج بعد الدفع مباشرة</span>
        </div>
        <div class="sp-trust-item">
            <span class="sp-trust-icon">✓</span>
            <span>مفتاح ترخيص رسمي يُرسل لبريدك</span>
        </div>
        <div class="sp-trust-item">
            <span class="sp-trust-icon">✓</span>
            <span>دعم فني مجاني عبر واتساب</span>
        </div>
        <div class="sp-trust-item" style="color: var(--ox-amber); font-weight: 800; margin-top: 2px;">
            <span>🔒</span>
            <span>دفع مؤمن عبر PaySky و PayPal</span>
        </div>
    </div>

    {{-- Guarantee --}}
    <div class="sp-guarantee">
        <div class="sp-guarantee-icon">🛡️</div>
        <div style="font-size: 12px; color: #88A89E; line-height: 1.65;">
            <strong style="color: var(--ox-green);">ضمان استرداد 14 يوم</strong><br>
            غير راضٍ؟ نعيد لك المبلغ كاملاً بدون أسئلة.
        </div>
    </div>

</div>
