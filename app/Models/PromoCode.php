<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'valid_from',
        'valid_until',
        'max_uses',
        'used_count',
        'is_active',
        'description',
        'product_id',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'valid_from' => 'datetime',
            'valid_until' => 'datetime',
            'max_uses' => 'integer',
            'used_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<DigitalProduct, PromoCode>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class, 'product_id');
    }

    /**
     * Scope for active promo codes
     *
     * @param Builder<PromoCode> $query
     * @return Builder<PromoCode>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            });
    }

    /**
     * Validate if the promo code is currently valid
     *
     * @return array{valid: bool, message: string}
     */
    public function checkValidity(?DigitalProduct $product = null): array
    {
        if (! $this->is_active) {
            return [
                'valid' => false,
                'message' => 'عذراً، كود الخصم غير مفعّل حالياً.',
            ];
        }

        if ($this->valid_from && now()->lt($this->valid_from)) {
            return [
                'valid' => false,
                'message' => 'عذراً، يبدأ سريان كود الخصم في تاريخ ' . $this->valid_from->format('Y-m-d') . '.',
            ];
        }

        if ($this->valid_until && now()->gt($this->valid_until)) {
            return [
                'valid' => false,
                'message' => 'عذراً، انتهت صلاحية كود الخصم في تاريخ ' . $this->valid_until->format('Y-m-d') . '.',
            ];
        }

        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return [
                'valid' => false,
                'message' => 'عذراً، تم الوصول للحد الأقصى لاستخدام كود الخصم هذا.',
            ];
        }

        if ($this->product_id !== null && $product !== null && $this->product_id !== $product->id) {
            return [
                'valid' => false,
                'message' => 'عذراً، كود الخصم غير مخصص لهذا المنتج.',
            ];
        }

        return [
            'valid' => true,
            'message' => 'كود الخصم سارٍ بنجاح!',
        ];
    }

    /**
     * Calculate discount amount for a given price
     */
    public function calculateDiscount(float $amount): float
    {
        if ($this->discount_type === 'percentage') {
            return round($amount * ((float) $this->discount_value / 100), 2);
        }

        return min($amount, (float) $this->discount_value);
    }

    /**
     * Get human readable remaining time / duration
     */
    public function getRemainingTimeAttribute(): ?string
    {
        if (! $this->valid_until) {
            return null;
        }

        if (now()->gt($this->valid_until)) {
            return 'منتهي الصلاحية';
        }

        $diffDays = now()->diffInDays($this->valid_until);
        $diffHours = now()->diffInHours($this->valid_until) % 24;

        if ($diffDays > 0) {
            return "متبقي {$diffDays} يوم و {$diffHours} ساعة";
        }

        $diffMinutes = now()->diffInMinutes($this->valid_until) % 60;
        return "متبقي {$diffHours} ساعة و {$diffMinutes} دقيقة";
    }
}
