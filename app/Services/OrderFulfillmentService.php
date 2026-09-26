<?php

namespace App\Services;

use App\Mail\DigitalProductOrderCompleted;
use App\Models\DownloadToken;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderFulfillmentService
{
    /**
     * Complete and fulfill an order after successful payment
     *
     * @param  array<string, mixed>  $gatewayData
     * @return array<string, mixed>
     */
    public function fulfill(Order $order, ?string $transactionId = null, array $gatewayData = []): array
    {
        if ($order->isPaid()) {
            return [
                'status' => 'already_paid',
                'order' => $order,
            ];
        }

        // 1. Find or create Customer User account
        $tempPassword = null;
        $user = User::where('email', $order->customer_email)->first();

        if (! $user) {
            $tempPassword = Str::password(10, letters: true, numbers: true, symbols: false);
            $user = User::create([
                'name' => $order->customer_name,
                'email' => $order->customer_email,
                'password' => Hash::make($tempPassword),
                'role' => 'client',
                'is_active' => true,
            ]);
        }

        // 2. Mark order as paid
        $order->update([
            'user_id' => $user->id,
            'payment_status' => 'paid',
            'transaction_id' => $transactionId ?? $order->transaction_id ?? 'PAYSKY-'.strtoupper(Str::random(10)),
            'gateway_response' => array_merge((array) $order->gateway_response, $gatewayData),
            'paid_at' => now(),
        ]);

        // 3. Process items: Generate License Keys & Download Tokens
        $order->load(['items.product']);
        $generatedTokens = [];

        foreach ($order->items as $item) {
            $product = $item->product;

            // Generate License Key if required
            if ($product && $product->has_license_key && empty($item->license_key)) {
                $licenseKey = 'OX-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4));
                $item->update([
                    'license_key' => $licenseKey,
                ]);
            }

            // Generate Download Token
            if ($product) {
                $tokenString = Str::random(48).bin2hex(random_bytes(8));
                $downloadToken = DownloadToken::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'token' => $tokenString,
                    'expires_at' => now()->addDays($product->expiry_days > 0 ? $product->expiry_days : 30),
                    'download_count' => 0,
                    'max_downloads' => $product->download_limit > 0 ? $product->download_limit : 5,
                ]);

                $generatedTokens[] = $downloadToken;
            }
        }

        // 4. Send Order Confirmation Email with Download Link & License Key
        try {
            Mail::to($order->customer_email)->send(
                new DigitalProductOrderCompleted(
                    order: $order,
                    user: $user,
                    tempPassword: $tempPassword
                )
            );
        } catch (Exception $e) {
            Log::error('Failed to send digital product order confirmation email', [
                'order_id' => $order->id,
                'email' => $order->customer_email,
                'error' => $e->getMessage(),
            ]);
        }

        return [
            'status' => 'success',
            'order' => $order->fresh(['items.product', 'downloadTokens']),
            'user' => $user,
            'tempPassword' => $tempPassword,
        ];
    }
}
