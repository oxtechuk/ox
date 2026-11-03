<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return HasMany<DigitalProduct>
     */
    public function digitalProducts(): HasMany
    {
        return $this->hasMany(DigitalProduct::class, 'category_id');
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('home_product_categories');
            Cache::forget('home_digital_products');
        });

        static::deleted(function () {
            Cache::forget('home_product_categories');
            Cache::forget('home_digital_products');
        });
    }
}
