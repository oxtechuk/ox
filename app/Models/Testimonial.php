<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_name',
        'partner_role',
        'partner_country',
        'quote',
        'video_type',
        'video_url',
        'poster_image',
        'number_badge',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function getPosterUrlAttribute(): string
    {
        if ($this->poster_image) {
            return str_starts_with($this->poster_image, 'http')
                ? $this->poster_image
                : asset('storage/' . $this->poster_image);
        }
        return '';
    }

    public function getVideoSrcAttribute(): string
    {
        if ($this->video_url) {
            return str_starts_with($this->video_url, 'http')
                ? $this->video_url
                : asset('storage/' . $this->video_url);
        }
        return '';
    }
}
