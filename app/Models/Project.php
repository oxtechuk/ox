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
        'title_en',
        'subtitle',
        'subtitle_en',
        'country_code',
        'country_name',
        'country_name_en',
        'sector_slug',
        'sector_name',
        'sector_name_en',
        'gradient_class',
        'custom_gradient',
        'is_big',
        'is_featured',
        'order',
        'number_badge',
        'short_description',
        'short_description_en',
        'impact_stat',
        'hero_image',
        'client_name',
        'client_name_en',
        'duration',
        'duration_en',
        'delivery_date',
        'delivery_date_en',
        'live_url',
        'video_url',
        'summary',
        'summary_en',
        'challenge',
        'challenge_en',
        'solution',
        'solution_en',
        'key_features',
        'key_features_en',
        'technologies',
        'gallery',
    ];

    protected $casts = [
        'is_big' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
        'key_features' => 'array',
        'key_features_en' => 'array',
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

    public function getTitleAttribute($value): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['title_en'])) {
            return $this->attributes['title_en'];
        }

        return (string) $value;
    }

    public function getSubtitleAttribute($value): ?string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['subtitle_en'])) {
            return $this->attributes['subtitle_en'];
        }

        return $value;
    }

    public function getCountryNameAttribute($value): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['country_name_en'])) {
            return $this->attributes['country_name_en'];
        }

        return (string) $value;
    }

    public function getSectorNameAttribute($value): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['sector_name_en'])) {
            return $this->attributes['sector_name_en'];
        }

        return (string) $value;
    }

    public function getShortDescriptionAttribute($value): ?string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['short_description_en'])) {
            return $this->attributes['short_description_en'];
        }

        return $value;
    }

    public function getClientNameAttribute($value): ?string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['client_name_en'])) {
            return $this->attributes['client_name_en'];
        }

        return $value;
    }

    public function getDurationAttribute($value): ?string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['duration_en'])) {
            return $this->attributes['duration_en'];
        }

        return $value;
    }

    public function getDeliveryDateAttribute($value): ?string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['delivery_date_en'])) {
            return $this->attributes['delivery_date_en'];
        }

        return $value;
    }

    public function getSummaryAttribute($value): ?string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['summary_en'])) {
            return $this->attributes['summary_en'];
        }

        return $value;
    }

    public function getChallengeAttribute($value): ?string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['challenge_en'])) {
            return $this->attributes['challenge_en'];
        }

        return $value;
    }

    public function getSolutionAttribute($value): ?string
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['solution_en'])) {
            return $this->attributes['solution_en'];
        }

        return $value;
    }

    public function getKeyFeaturesAttribute($value): ?array
    {
        if (app()->getLocale() === 'en' && ! empty($this->attributes['key_features_en'])) {
            $kf = $this->attributes['key_features_en'];

            return is_string($kf) ? json_decode($kf, true) : $kf;
        }

        return is_string($value) ? json_decode($value, true) : $value;
    }

    public function getVideoEmbedUrlAttribute(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        $url = trim($this->video_url);

        // YouTube regex for standard, share, or embed links
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match)) {
            return 'https://www.youtube-nocookie.com/embed/'.$match[1].'?autoplay=1&rel=0';
        }

        // Vimeo regex
        if (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)/i', $url, $match)) {
            return 'https://player.vimeo.com/video/'.$match[3].'?autoplay=1';
        }

        return $url;
    }

    public function getGalleryImagesAttribute(): array
    {
        $images = [];

        if (! empty($this->gallery) && is_array($this->gallery)) {
            foreach ($this->gallery as $item) {
                if (empty($item)) {
                    continue;
                }
                if (str_starts_with($item, 'http://') || str_starts_with($item, 'https://')) {
                    $images[] = $item;
                } elseif (str_starts_with($item, 'assets/')) {
                    $images[] = asset($item);
                } else {
                    $clean = ltrim(str_replace('storage/', '', $item), '/');
                    $images[] = asset('storage/'.$clean);
                }
            }
        }

        // Fallback to display_image if gallery is empty
        if (empty($images)) {
            $images[] = $this->display_image;
        }

        return array_values(array_unique($images));
    }
}
