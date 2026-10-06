<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
            $parsed = parse_url($this->poster_image);
            $path = isset($parsed['path']) ? ltrim($parsed['path'], '/') : $this->poster_image;

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

            $webpStorage = preg_replace('/\.(jpe?g|png)$/i', '.webp', $this->poster_image);
            if (Storage::disk('public')->exists($webpStorage)) {
                return asset('storage/'.$webpStorage);
            }

            if (str_starts_with($this->poster_image, 'http')) {
                return $this->poster_image;
            }

            return asset('storage/'.$this->poster_image);
        }

        return '';
    }

    public function getVideoSrcAttribute(): string
    {
        if ($this->video_url) {
            if (str_starts_with($this->video_url, 'http')) {
                return $this->video_url;
            }
            if (str_starts_with($this->video_url, 'assets/')) {
                return asset($this->video_url);
            }

            return asset('storage/'.$this->video_url);
        }

        return '';
    }
}
