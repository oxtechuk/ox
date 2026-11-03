<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'group',
        'label',
        'value',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public static function cachedDict(): array
    {
        return Cache::rememberForever('site_content_dict', function () {
            return static::all()->pluck('value', 'key')->toArray();
        });
    }

    public static function getByKey(string $key, mixed $default = null)
    {
        $dict = static::cachedDict();
        if (array_key_exists($key, $dict)) {
            return $dict[$key] ?? $default;
        }

        $item = static::where('key', $key)->first();
        if (! $item) {
            return $default;
        }

        return $item->payload ?? $item->value ?? $default;
    }

    public static function getGroup(string $group): array
    {
        return static::where('group', $group)->pluck('value', 'key')->toArray();
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('site_content_dict');
        });

        static::deleted(function () {
            Cache::forget('site_content_dict');
        });
    }
}
