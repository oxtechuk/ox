<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_amount',
        'currency',
        'payment_gateway',
        'payment_status',
        'transaction_id',
        'merchant_reference',
        'gateway_response',
        'paid_at',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'gateway_response' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, Order>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany<OrderItem>
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * @return HasMany<DownloadToken>
     */
    public function downloadTokens(): HasMany
    {
        return $this->hasMany(DownloadToken::class, 'order_id');
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * @param  Builder<Order>  $query
     * @return Builder<Order>
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * @param  Builder<Order>  $query
     * @return Builder<Order>
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }
}
