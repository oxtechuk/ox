<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLog extends Model
{
    protected $fillable = [
        'order_id',
        'gateway',
        'merchant_reference',
        'event',
        'status',
        'amount',
        'currency',
        'request_payload',
        'response_payload',
        'ip_address',
        'user_agent',
        'message',
    ];

    protected function casts(): array
    {
        return [
            'request_payload' => 'array',
            'response_payload' => 'array',
            'amount' => 'decimal:2',
        ];
    }

    /**
     * @return BelongsTo<Order, PaymentLog>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Static helper to easily log payment gateway events
     *
     * @param  array<string, mixed>|null  $requestPayload
     * @param  array<string, mixed>|null  $responsePayload
     */
    public static function record(
        string $event,
        string $status = 'info',
        ?string $message = null,
        ?Order $order = null,
        ?string $merchantReference = null,
        ?array $requestPayload = null,
        ?array $responsePayload = null,
        ?float $amount = null,
        ?string $currency = null
    ): self {
        return static::create([
            'order_id' => $order?->id,
            'gateway' => 'paysky',
            'merchant_reference' => $merchantReference ?? $order?->merchant_reference,
            'event' => $event,
            'status' => $status,
            'message' => $message,
            'amount' => $amount ?? ($order ? (float) $order->total_amount : null),
            'currency' => $currency ?? ($order ? $order->currency : 'EGP'),
            'request_payload' => $requestPayload,
            'response_payload' => $responsePayload,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }
}
