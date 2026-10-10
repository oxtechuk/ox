<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductLandingPage extends Model
{
    protected $fillable = [
        'product_id',
        'slug',
        'headline',
        'subheadline',
        'hero_badge',
        'video_url',
        'timer_ends_at',
        'key_benefits',
        'social_proof_stats',
        'testimonials',
        'faq_items',
        'comparison_table',
        'guarantee_text',
        'cta_text',
        'primary_color',
        'external_css_urls',
        'custom_css',
        'custom_head_scripts',
        'custom_body_scripts',
        'meta_pixel_id',
        'google_analytics_id',
        'og_title',
        'og_description',
        'og_image',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'timer_ends_at' => 'datetime',
            'key_benefits' => 'array',
            'social_proof_stats' => 'array',
            'testimonials' => 'array',
            'faq_items' => 'array',
            'comparison_table' => 'array',
            'is_published' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<DigitalProduct, ProductLandingPage>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class, 'product_id');
    }
}
