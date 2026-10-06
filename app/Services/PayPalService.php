<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\SiteSetting;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPalService
{
    protected string $clientId;

    protected string $clientSecret;

    protected string $mode;

    protected string $currency;

    protected float $egpToUsdRate;

    protected string $baseUrl;

    protected ?string $lastError = null;

    public function __construct()
    {
        $this->clientId = (string) (SiteSetting::get('paypal_client_id') ?: config('services.paypal.client_id', ''));
        $this->clientSecret = (string) (SiteSetting::get('paypal_client_secret') ?: config('services.paypal.client_secret', ''));
        $this->mode = (string) (SiteSetting::get('paypal_mode') ?: config('services.paypal.mode', 'sandbox'));
        $this->currency = strtoupper((string) (SiteSetting::get('paypal_currency') ?: config('services.paypal.currency', 'USD')));
        $this->egpToUsdRate = (float) (SiteSetting::get('paypal_egp_to_usd_rate') ?: config('services.paypal.egp_to_usd_rate', 0.021));

        $this->baseUrl = $this->mode === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    public function getLastError(): ?string
    {
        return $this->lastError;
    }

    public function isEnabled(): bool
    {
        return (bool) SiteSetting::get('paypal_enabled', config('services.paypal.enabled', true));
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Convert an order's amount to PayPal's configured currency
     *
     * @return array{amount: string, currency: string}
     */
    public function convertAmount(float $totalAmount, string $orderCurrency): array
    {
        $orderCurrency = strtoupper($orderCurrency);

        if ($orderCurrency === $this->currency) {
            return [
                'amount' => number_format($totalAmount, 2, '.', ''),
                'currency' => $this->currency,
            ];
        }

        // Conversion from EGP to USD
        if ($orderCurrency === 'EGP' && $this->currency === 'USD') {
            $converted = round($totalAmount * $this->egpToUsdRate, 2);
            $converted = max(0.99, $converted); // PayPal minimum amount

            return [
                'amount' => number_format($converted, 2, '.', ''),
                'currency' => 'USD',
            ];
        }

        return [
            'amount' => number_format($totalAmount, 2, '.', ''),
            'currency' => $this->currency,
        ];
    }

    /**
     * Get OAuth 2.0 Access Token from PayPal
     */
    public function getAccessToken(): ?string
    {
        if (empty($this->clientId) || empty($this->clientSecret)) {
            $this->lastError = 'بيانات PayPal غير مكتملة (يرجى التأكد من إدخال Client Secret في لوحة التحكم)';
            Log::warning('PayPal credentials missing: clientId or clientSecret is empty.');

            return null;
        }

        $cacheKey = "paypal_token_{$this->mode}_{$this->clientId}";

        if ($cached = Cache::get($cacheKey)) {
            return $cached;
        }

        try {
            $response = Http::asForm()
                ->withBasicAuth($this->clientId, $this->clientSecret)
                ->post("{$this->baseUrl}/v1/oauth2/token", [
                    'grant_type' => 'client_credentials',
                ]);

            if ($response->successful()) {
                $token = $response->json('access_token');
                $expiresIn = (int) ($response->json('expires_in') ?? 3200);
                Cache::put($cacheKey, $token, now()->addSeconds(max(60, $expiresIn - 120)));

                return $token;
            }

            $body = $response->json() ?? [];
            $err = $body['error_description'] ?? $body['error'] ?? $response->body();
            $this->lastError = 'فشل التحقق من حساب PayPal (OAuth): '.$err;
            Log::error('PayPal Auth Error: '.$response->body());

            return null;
        } catch (Exception $e) {
            $this->lastError = 'تعذر الاتصال بخوادم PayPal: '.$e->getMessage();
            Log::error('PayPal Token Request Failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Create PayPal Order (REST API v2)
     *
     * @return array<string, mixed>|null
     */
    public function createOrder(Order $order): ?array
    {
        $token = $this->getAccessToken();
        if (! $token) {
            PaymentLog::record(
                event: 'paypal_order_failed',
                status: 'failed',
                message: 'فشل الحصول على رمز الدخول OAuth من PayPal (تحقق من Client ID & Secret)',
                order: $order,
                merchantReference: $order->merchant_reference
            );

            return null;
        }

        $conversion = $this->convertAmount((float) $order->total_amount, $order->currency);
        $amountValue = $conversion['amount'];
        $currencyCode = $conversion['currency'];

        $productName = $order->items->first()?->product?->name ?? 'منتج رقمي OX Tech';

        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $order->merchant_reference,
                    'custom_id' => $order->order_number,
                    'description' => mb_substr($productName, 0, 120),
                    'amount' => [
                        'currency_code' => $currencyCode,
                        'value' => $amountValue,
                    ],
                ],
            ],
            'application_context' => [
                'brand_name' => config('app.name', 'OX Tech'),
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                'return_url' => route('checkout.success', $order->order_number),
                'cancel_url' => route('store.index'),
            ],
        ];

        try {
            $response = Http::withToken($token)
                ->post("{$this->baseUrl}/v2/checkout/orders", $payload);

            $result = $response->json();

            if ($response->successful() && isset($result['id'])) {
                PaymentLog::record(
                    event: 'paypal_order_created',
                    status: 'info',
                    message: "تم تجهيز طلب الدفع بنجاح في PayPal بالمبلغ {$amountValue} {$currencyCode}",
                    order: $order,
                    merchantReference: $order->merchant_reference,
                    requestPayload: $payload,
                    responsePayload: $result
                );

                return $result;
            }

            $failMsg = $result['message'] ?? $result['error_description'] ?? 'فشل إنشاء طلب الدفع في PayPal';
            $this->lastError = $failMsg;

            PaymentLog::record(
                event: 'paypal_order_failed',
                status: 'failed',
                message: 'فشل إنشاء طلب الدفع في PayPal: '.$failMsg,
                order: $order,
                merchantReference: $order->merchant_reference,
                requestPayload: $payload,
                responsePayload: $result
            );

            return null;
        } catch (Exception $e) {
            $this->lastError = 'استثناء أثناء إنشاء طلب PayPal: '.$e->getMessage();
            Log::error('PayPal Create Order Exception: '.$e->getMessage());

            PaymentLog::record(
                event: 'paypal_order_failed',
                status: 'failed',
                message: 'استثناء أثناء إنشاء طلب PayPal: '.$e->getMessage(),
                order: $order,
                merchantReference: $order->merchant_reference,
                requestPayload: $payload
            );

            return null;
        }
    }

    /**
     * Capture PayPal Order Payment (REST API v2)
     *
     * @return array<string, mixed>|null
     */
    public function capturePayment(string $paypalOrderId, Order $order): ?array
    {
        $token = $this->getAccessToken();
        if (! $token) {
            return null;
        }

        try {
            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/v2/checkout/orders/{$paypalOrderId}/capture");

            $result = $response->json();

            $status = $result['status'] ?? null;
            $isCompleted = ($status === 'COMPLETED');

            $captureId = $result['purchase_units'][0]['payments']['captures'][0]['id'] ?? $paypalOrderId;

            PaymentLog::record(
                event: $isCompleted ? 'paypal_payment_captured' : 'paypal_capture_failed',
                status: $isCompleted ? 'success' : 'failed',
                message: $isCompleted
                    ? "تم سحب وتأكيد مبلغ العملية عبر PayPal بنجاح (معرف المعاملة: {$captureId})"
                    : 'فشل تأكيد سحب المبلغ من PayPal (الحالة: '.($status ?? 'Unknown').')',
                order: $order,
                merchantReference: $order->merchant_reference,
                requestPayload: ['paypal_order_id' => $paypalOrderId],
                responsePayload: $result
            );

            if ($isCompleted) {
                return [
                    'success' => true,
                    'transaction_id' => $captureId,
                    'details' => $result,
                ];
            }

            return null;
        } catch (Exception $e) {
            Log::error('PayPal Capture Exception: '.$e->getMessage());

            PaymentLog::record(
                event: 'paypal_capture_failed',
                status: 'failed',
                message: 'استثناء أثناء سحب مبلغ PayPal: '.$e->getMessage(),
                order: $order,
                merchantReference: $order->merchant_reference,
                requestPayload: ['paypal_order_id' => $paypalOrderId]
            );

            return null;
        }
    }
}
