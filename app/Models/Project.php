<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function getDisplayImageAttribute(): string
    {
        if ($this->hero_image) {
            return str_starts_with($this->hero_image, 'http')
                ? $this->hero_image
                : asset('storage/'.$this->hero_image);
        }

        return asset('assets/ox-saudi-story.png');
    }
}
