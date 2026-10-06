<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'country_code',
        'country_name',
        'sector_slug',
        'sector_name',
        'gradient_class',
        'custom_gradient',
        'is_big',
        'is_featured',
        'order',
        'number_badge',
        'short_description',
        'impact_stat',
        'hero_image',
        'client_name',
        'duration',
        'delivery_date',
        'live_url',
        'summary',
        'challenge',
        'solution',
        'key_features',
        'technologies',
        'gallery',
    ];

    protected $casts = [
        'is_big' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
        'key_features' => 'array',
        'technologies' => 'array',
        'gallery' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title) ?: 'project-'.time();
            }
        });
    }

    public function getVisualClassAttribute(): string
    {
        return $this->gradient_class ?: 'store';
    }

    public function getCountryFlagAttribute(): string
    {
        $flags = [
            'sa' => '🇸🇦',
            'ae' => '🇦🇪',
            'eg' => '🇪🇬',
            'kw' => '🇰🇼',
            'qa' => '🇶🇦',
            'om' => '🇴🇲',
            'bh' => '🇧🇭',
            'jo' => '🇯🇴',
            'de' => '🇩🇪',
            'se' => '🇸🇪',
            'gb' => '🇬🇧',
            'uk' => '🇬🇧',
            'us' => '🇺🇸',
            'ru' => '🇷🇺',
            'iq' => '🇮🇶',
            'fr' => '🇫🇷',
        ];

        return $flags[strtolower($this->country_code ?? '')] ?? '🌐';
    }

    public function getCountryFlagUrlAttribute(): ?string
    {
        $code = strtolower($this->country_code ?? '');
        if ($code === 'uk') {
            $code = 'gb';
        }
        if (! $code) {
            return null;
        }

        $relativePath = "assets/flags/{$code}.webp";
        if (file_exists(public_path($relativePath))) {
            return asset($relativePath);
        }

        return null;
    }

    public function getDisplayImageAttribute(): string
    {
        if ($this->hero_image) {
            $parsed = parse_url($this->hero_image);
            $path = isset($parsed['path']) ? ltrim($parsed['path'], '/') : $this->hero_image;

            if (str_starts_with($path, 'assets/')) {
                $webpAsset = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);
                if (file_exists(public_path($webpAsset))) {
                    return asset($webpAsset);
                }

                return asset($path);
            }

            if (str_starts_with($path, 'storage/')) {
                $storageSub = substr($path, 8);
                $webpStorage = preg_replace('/\.(jpe?g|png)$/i', '.webp', $storageSub);
                if (Storage::disk('public')->exists($webpStorage)) {
                    return asset('storage/'.$webpStorage);
                }

                return asset('storage/'.$storageSub);
            }

            // Check if storage has a .webp version
            $webpStorage = preg_replace('/\.(jpe?g|png)$/i', '.webp', $this->hero_image);
            if (Storage::disk('public')->exists($webpStorage)) {
                return asset('storage/'.$webpStorage);
            }

            if (str_starts_with($this->hero_image, 'http')) {
                return $this->hero_image;
            }

            return asset('storage/'.$this->hero_image);
        }

        if (file_exists(public_path('assets/ox-saudi-story.webp'))) {
            return asset('assets/ox-saudi-story.webp');
        }

        return asset('assets/ox-saudi-story.png');
    }
}
