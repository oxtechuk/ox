<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DigitalProduct extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'tagline',
        'description',
        'features',
        'system_requirements',
        'price',
        'sale_price',
        'currency',
        'version',
        'demo_url',
        'thumbnail',
        'gallery',
        'file_path',
        'file_name',
        'file_size',
        'download_limit',
        'expiry_days',
        'has_license_key',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'system_requirements' => 'array',
            'gallery' => 'array',
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'has_license_key' => 'boolean',
            'is_featured' => 'boolean',
            'download_limit' => 'integer',
            'expiry_days' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<ProductCategory, DigitalProduct>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * @return HasOne<ProductLandingPage>
     */
    public function landingPage(): HasOne
    {
        return $this->hasOne(ProductLandingPage::class, 'product_id');
    }

    /**
     * @return HasMany<OrderItem>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    /**
     * @return HasMany<DownloadToken>
     */
    public function downloadTokens(): HasMany
    {
        return $this->hasMany(DownloadToken::class, 'product_id');
    }

    public function getEffectivePriceAttribute(): float
    {
        if ($this->sale_price !== null && $this->sale_price > 0 && $this->sale_price < $this->price) {
            return (float) $this->sale_price;
        }

        return (float) $this->price;
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->sale_price !== null && $this->sale_price > 0 && $this->sale_price < $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (! $this->has_discount || $this->price <= 0) {
            return 0;
        }

        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    /**
     * @param  Builder<DigitalProduct>  $query
     * @return Builder<DigitalProduct>
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * @param  Builder<DigitalProduct>  $query
     * @return Builder<DigitalProduct>
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
