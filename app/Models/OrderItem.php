<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'license_key',
        'max_activations',
        'is_revoked',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'max_activations' => 'integer',
            'is_revoked' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Order, OrderItem>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * @return BelongsTo<DigitalProduct, OrderItem>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class, 'product_id');
    }
}
