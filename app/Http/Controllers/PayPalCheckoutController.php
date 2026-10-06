<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentLog;
use App\Services\OrderFulfillmentService;
use App\Services\PayPalService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PayPalCheckoutController extends Controller
{
    public function __construct(
        protected PayPalService $payPalService,
        protected OrderFulfillmentService $fulfillmentService
    ) {}

    /**
     * Get client configuration for PayPal SDK (Client ID & Currency)
     */
    public function config(): JsonResponse
    {
        return response()->json([
            'enabled' => $this->payPalService->isEnabled(),
            'client_id' => $this->payPalService->getClientId(),
            'currency' => $this->payPalService->getCurrency(),
            'mode' => $this->payPalService->getMode(),
        ]);
    }

    /**
     * Initiate and create PayPal Order
     */
    public function create(Request $request): JsonResponse
    {
        if (! $this->payPalService->isEnabled()) {
            return response()->json([
                'success' => false,
                'message' => 'بوابة دفع PayPal غير مفعلة حالياً.',
            ], 403);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:digital_products,id',
            'customer_name' => 'required|string|max:150',
            'customer_email' => 'required|email|max:190',
            'customer_phone' => 'nullable|string|max:30',
            'utm_source' => 'nullable|string|max:100',
            'utm_medium' => 'nullable|string|max:100',
            'utm_campaign' => 'nullable|string|max:100',
        ]);

        $product = DigitalProduct::findOrFail($validated['product_id']);

        if ($product->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'هذا المنتج غير متاح للشراء حالياً.',
            ], 422);
        }

        $price = (float) $product->effective_price;
        $merchantReference = 'PP-'.time().'-'.rand(1000, 9999);
        $orderNumber = 'ORD-'.strtoupper(Str::random(3)).'-'.date('YmdHis');

        // 1. Create local Order
        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => Auth::id(),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'total_amount' => $price,
            'currency' => $product->currency,
            'payment_gateway' => 'paypal',
            'payment_status' => 'pending',
            'merchant_reference' => $merchantReference,
            'utm_source' => $validated['utm_source'] ?? session('utm_source'),
            'utm_medium' => $validated['utm_medium'] ?? session('utm_medium'),
            'utm_campaign' => $validated['utm_campaign'] ?? session('utm_campaign'),
            'ip_address' => $request->ip(),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $price,
            'max_activations' => 1,
        ]);

        PaymentLog::record(
            event: 'order_created',
            status: 'pending',
            message: 'تم إنشاء الطلب المبدئي للدفع عبر PayPal للمنتج: '.$product->name,
            order: $order,
            merchantReference: $merchantReference,
            requestPayload: $validated
        );

        // 2. Call PayPal to create the Order
        $paypalOrder = $this->payPalService->createOrder($order);

        if (! $paypalOrder || ! isset($paypalOrder['id'])) {
            return response()->json([
                'success' => false,
                'message' => 'تعذر بدء عملية الدفع مع خوادم PayPal. يرجى التحقق من إعدادات الحساب.',
            ], 500);
        }

        $converted = $this->payPalService->convertAmount($price, $product->currency);

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'merchant_reference' => $order->merchant_reference,
            'paypal_order_id' => $paypalOrder['id'],
            'amount' => $converted['amount'],
            'currency' => $converted['currency'],
        ]);
    }

    /**
     * Capture PayPal Payment after buyer approves in popup
     */
    public function capture(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'paypal_order_id' => 'required|string',
            'merchant_reference' => 'required|string',
        ]);

        $order = Order::where('merchant_reference', $validated['merchant_reference'])->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب المطلوب غير موجود.',
            ], 404);
        }

        if ($order->isPaid()) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('checkout.success', $order->order_number),
            ]);
        }

        $captureResult = $this->payPalService->capturePayment($validated['paypal_order_id'], $order);

        if ($captureResult && ! empty($captureResult['success'])) {
            $transactionId = (string) $captureResult['transaction_id'];

            try {
                $this->fulfillmentService->fulfill($order, $transactionId, $captureResult['details'] ?? []);

                return response()->json([
                    'success' => true,
                    'redirect_url' => route('checkout.success', $order->order_number),
                ]);
            } catch (Exception $e) {
                Log::error('Fulfillment error for PayPal order: '.$e->getMessage());

                return response()->json([
                    'success' => true,
                    'redirect_url' => route('checkout.success', $order->order_number),
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'لم يتم تأكيد الدفع بنجاح من قبل PayPal.',
        ], 400);
    }

    /**
     * PayPal Server-to-Server Webhook
     */
    public function webhook(Request $request): JsonResponse
    {
        if ($request->isMethod('get')) {
            return response()->json([
                'status' => 'active',
                'gateway' => 'paypal',
                'message' => 'PayPal Webhook endpoint is active and listening for POST notifications.',
            ]);
        }

        Log::info('PayPal Webhook Received', $request->all());

        $eventType = $request->input('event_type');
        $resource = $request->input('resource', []);

        $customId = $resource['custom_id'] ?? null;
        $orderNumber = $customId;

        $order = null;
        if ($orderNumber) {
            $order = Order::where('order_number', $orderNumber)->first();
        }

        PaymentLog::record(
            event: 'paypal_webhook_received',
            status: 'info',
            message: "استلام إشعار Webhook من PayPal بنوع الحدث: {$eventType}",
            order: $order,
            merchantReference: $order?->merchant_reference,
            requestPayload: $request->all()
        );

        if ($eventType === 'PAYMENT.CAPTURE.COMPLETED' && $order && ! $order->isPaid()) {
            $transactionId = $resource['id'] ?? 'PP-CAPTURE-'.time();
            $this->fulfillmentService->fulfill($order, (string) $transactionId, $resource);
        }

        return response()->json(['status' => 'received']);
    }
}
