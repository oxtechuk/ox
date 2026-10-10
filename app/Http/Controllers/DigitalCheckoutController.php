<?php

namespace App\Http\Controllers;

use App\Http\Requests\InitiateCheckoutRequest;
use App\Models\DigitalProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentLog;
use App\Models\PromoCode;
use App\Services\OrderFulfillmentService;
use App\Services\PaySkyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DigitalCheckoutController extends Controller
{
    public function __construct(
        protected PaySkyService $paySkyService,
        protected OrderFulfillmentService $fulfillmentService
    ) {}

    /**
     * Validate a promo code against product and currency
     */
    public function validatePromo(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|max:50',
            'product_id' => 'required|exists:digital_products,id',
            'currency' => 'nullable|string|in:USD,EGP,SAR',
        ]);

        $product = DigitalProduct::findOrFail($request->product_id);
        $code = strtoupper(trim((string) $request->code));
        $promo = PromoCode::where('code', $code)->first();

        if (! $promo) {
            return response()->json([
                'valid' => false,
                'message' => 'كود الخصم غير موجود أو غير صحيح.',
            ], 422);
        }

        $check = $promo->checkValidity($product);
        if (! $check['valid']) {
            return response()->json([
                'valid' => false,
                'message' => $check['message'],
            ], 422);
        }

        $currency = strtoupper($request->currency ?: ($product->currency ?: 'USD'));

        // Calculate base price in selected currency (1 USD = 50 EGP)
        if ($product->currency === 'USD' && $currency === 'EGP') {
            $basePrice = round((float) $product->effective_price * 50.0, 0);
        } elseif ($product->currency === 'EGP' && $currency === 'USD') {
            $basePrice = round((float) $product->effective_price / 50.0, 2);
        } else {
            $basePrice = (float) $product->effective_price;
        }

        $discountAmount = $promo->calculateDiscount($basePrice);
        $finalPrice = max(1.0, round($basePrice - $discountAmount, 2));

        return response()->json([
            'valid' => true,
            'code' => $promo->code,
            'discount_type' => $promo->discount_type,
            'discount_value' => (float) $promo->discount_value,
            'discount_amount' => $discountAmount,
            'original_price' => $basePrice,
            'final_price' => $finalPrice,
            'currency' => $currency,
            'valid_until' => $promo->valid_until ? $promo->valid_until->format('Y-m-d') : null,
            'remaining_time' => $promo->remaining_time,
            'message' => 'تم تطبيق كود الخصم ' . $promo->code . ' بنجاح! (' . ($promo->discount_type === 'percentage' ? round((float) $promo->discount_value) . '%' : $discountAmount . ' ' . $currency) . ' خصم)',
        ]);
    }

    /**
     * Initiate instant order and get PaySky Lightbox payload
     */
    public function initiate(InitiateCheckoutRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $product = DigitalProduct::findOrFail($validated['product_id']);

        if ($product->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'عذراً، هذا المنتج غير متاح للشراء حالياً.',
            ], 422);
        }

        // Determine requested currency (Default: USD or product currency)
        $currency = strtoupper($validated['currency'] ?? ($product->currency ?: 'USD'));

        // Calculate base price in selected currency
        if ($product->currency === 'USD' && $currency === 'EGP') {
            $basePrice = round((float) $product->effective_price * 50.0, 0);
        } elseif ($product->currency === 'EGP' && $currency === 'USD') {
            $basePrice = round((float) $product->effective_price / 50.0, 2);
        } else {
            $basePrice = (float) $product->effective_price;
        }

        // Apply promo code if provided and valid
        $promoCode = null;
        $discountAmount = 0.0;
        $finalPrice = $basePrice;

        if (! empty($validated['promo_code'])) {
            $promo = PromoCode::where('code', strtoupper(trim((string) $validated['promo_code'])))->first();
            if ($promo) {
                $check = $promo->checkValidity($product);
                if ($check['valid']) {
                    $promoCode = $promo->code;
                    $discountAmount = $promo->calculateDiscount($basePrice);
                    $finalPrice = max(1.0, round($basePrice - $discountAmount, 2));
                    $promo->increment('used_count');
                }
            }
        }

        $orderNumber = 'ORD-'.strtoupper(Str::random(3)).'-'.date('YmdHis');
        $merchantReference = 'REF-'.time().'-'.rand(1000, 9999);

        // Create pending order
        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => Auth::id(), // if already logged in
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'total_amount' => $finalPrice,
            'currency' => $currency,
            'payment_gateway' => 'paysky',
            'payment_status' => 'pending',
            'merchant_reference' => $merchantReference,
            'promo_code' => $promoCode,
            'discount_amount' => $discountAmount,
            'utm_source' => $validated['utm_source'] ?? session('utm_source'),
            'utm_medium' => $validated['utm_medium'] ?? session('utm_medium'),
            'utm_campaign' => $validated['utm_campaign'] ?? session('utm_campaign'),
            'ip_address' => $request->ip(),
        ]);

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $finalPrice,
            'max_activations' => 1,
        ]);

        PaymentLog::record(
            event: 'order_created',
            status: 'pending',
            message: 'تم إنشاء الطلب المبدئي وتجهيز السداد للمنتج: '.$product->name.($promoCode ? " [كود: {$promoCode}]" : ''),
            order: $order,
            requestPayload: $validated
        );

        // Generate PaySky configuration payload
        $payskyPayload = $this->paySkyService->prepareLightboxPayload($order);

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'merchant_reference' => $order->merchant_reference,
            'paysky' => $payskyPayload,
            'callback_url' => route('checkout.paysky.callback'),
        ]);
    }

    /**
     * Handle PaySky callback after payment
     */
    public function callback(Request $request): RedirectResponse
    {
        Log::info('PaySky Callback Received', $request->all());

        $merchantReference = $request->input('MerchantReference') ?? $request->input('merchant_reference');
        $success = $request->input('Success') ?? $request->input('success');
        $txnId = $request->input('TransactionId') ?? $request->input('transaction_id') ?? $request->input('SystemReference');

        PaymentLog::record(
            event: 'callback_received',
            status: in_array($success, ['true', 'True', '1', '00', '0'], true) ? 'success' : 'failed',
            message: 'استلام استجابة العودة من بوابة PaySky',
            merchantReference: $merchantReference,
            requestPayload: $request->all()
        );

        if (! $merchantReference) {
            return redirect()->route('store.index')->with('error', 'بيانات العملية غير مكتملة.');
        }

        $order = Order::where('merchant_reference', $merchantReference)->first();

        if (! $order) {
            return redirect()->route('store.index')->with('error', 'الطلب المطلوب غير موجود.');
        }

        // Validate HMAC-SHA256 signature when present or in non-local environments
        if ($request->hasAny(['SecureHash', 'secure_hash'])) {
            $isSignatureValid = $this->paySkyService->verifyCallback($request->all());
            if (! $isSignatureValid) {
                Log::warning('PaySky signature verification failed for MerchantReference: '.$merchantReference);

                return redirect()->route('store.index')->with('error', 'فشل التحقق من التوقيع الرقمي لعملية الدفع.');
            }
        }

        // Check if PaySky indicated success (true / "true" / "1" / "00")
        $isSuccessful = filter_var($success, FILTER_VALIDATE_BOOLEAN) || in_array($success, ['true', 'True', '1', '00', '0'], true);

        if ($isSuccessful) {
            $fulfillment = $this->fulfillmentService->fulfill($order, (string) $txnId, $request->all());

            PaymentLog::record(
                event: 'order_paid_and_fulfilled',
                status: 'success',
                message: 'تم تأكيد السداد بنجاح وإصدار الترخيص وتفعيل الحساب',
                order: $order,
                requestPayload: $request->all()
            );

            // Automatically authenticate user if not logged in
            if (! Auth::check() && isset($fulfillment['user'])) {
                Auth::login($fulfillment['user']);
            }

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'تهانينا! تم تأكيد عملية الدفع بنجاح وأصبح برنامجك متاحاً للتحميل فوراً.');
        }

        // Payment failed or cancelled
        $order->update([
            'payment_status' => 'failed',
            'gateway_response' => $request->all(),
        ]);

        PaymentLog::record(
            event: 'payment_failed',
            status: 'failed',
            message: 'فشلت عملية الدفع أو قام العميل بالإلغاء',
            order: $order,
            requestPayload: $request->all()
        );

        return redirect()->route('store.index')->with('error', 'عذراً، لم تكتمل عملية الدفع أو تم إلغاؤها. يمكنك المحاولة مرة أخرى.');
    }

    /**
     * Webhook / Notification service from PaySky backend
     */
    public function webhook(Request $request): JsonResponse
    {
        if ($request->isMethod('get')) {
            return response()->json([
                'status' => 'active',
                'gateway' => 'paysky',
                'message' => 'PaySky Webhook endpoint is active and listening for POST notifications.',
            ]);
        }

        Log::info('PaySky Webhook Received', $request->all());

        $merchantReference = $request->input('MerchantReference') ?? $request->input('merchant_reference');
        $order = Order::where('merchant_reference', $merchantReference)->first();

        PaymentLog::record(
            event: 'webhook_received',
            status: 'info',
            message: 'استلام إشعار الخادم الآلي (Server-to-Server Webhook)',
            order: $order,
            merchantReference: $merchantReference,
            requestPayload: $request->all()
        );

        if (! $order) {
            return response()->json(['status' => 'order_not_found'], 404);
        }

        if ($request->hasAny(['SecureHash', 'secure_hash'])) {
            $isSignatureValid = $this->paySkyService->verifyCallback($request->all());
            if (! $isSignatureValid) {
                Log::warning('PaySky webhook signature mismatch for MerchantReference: '.$merchantReference);

                return response()->json(['status' => 'invalid_signature'], 403);
            }
        }

        $success = $request->input('Success') ?? $request->input('success');
        $isSuccessful = filter_var($success, FILTER_VALIDATE_BOOLEAN) || in_array($success, ['true', 'True', '1', '00'], true);

        if ($isSuccessful) {
            $this->fulfillmentService->fulfill($order, (string) $request->input('TransactionId'), $request->all());
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Order success page
     */
    public function success(string $orderNumber): View
    {
        $order = Order::with(['items.product', 'downloadTokens'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    /**
     * Log client-side or gateway error to payment logs
     */
    public function logClientError(Request $request): JsonResponse
    {
        $merchantReference = $request->input('merchant_reference') ?? $request->input('MerchantReference');
        $error = $request->input('error') ?? $request->all();
        $message = (string) ($request->input('message') ?? 'خطأ أثناء محاولة الدفع في بوابة PaySky');
        $source = (string) ($request->input('source') ?? 'lightbox_client');
        $status = (string) ($request->input('status') ?? 'failed');

        $order = $merchantReference ? Order::where('merchant_reference', $merchantReference)->first() : null;

        $event = match ($source) {
            'lightbox_cancelled' => 'lightbox_cancelled',
            'paysky_error_callback' => 'gateway_error',
            'paysky_post_message' => 'gateway_error',
            default => 'gateway_error',
        };

        PaymentLog::record(
            event: $event,
            status: $status === 'cancelled' || $event === 'lightbox_cancelled' ? 'info' : 'failed',
            message: $message,
            order: $order,
            merchantReference: $merchantReference,
            requestPayload: [
                'source' => $source,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'received_data' => $request->all(),
            ],
            responsePayload: is_array($error) ? $error : ['error' => $error]
        );

        return response()->json(['success' => true]);
    }
}
