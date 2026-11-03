<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
        'description',
    ];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("site_setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value, string $group = 'general', string $type = 'text', ?string $label = null): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
                'label' => $label ?? ucfirst(str_replace('_', ' ', $key)),
            ]
        );

        Cache::forget("site_setting_{$key}");
        Cache::forget('site_settings_all');
        Cache::forget('site_settings_dict');

        return $setting;
    }

    public static function cachedDict(): array
    {
        try {
            $cached = Cache::get('site_settings_dict');
            if (is_array($cached)) {
                return $cached;
            }
            if ($cached instanceof \Illuminate\Support\Collection) {
                return $cached->toArray();
            }
            Cache::forget('site_settings_dict');
        } catch (\Throwable $e) {
        }

        try {
            $data = static::all()->pluck('value', 'key')->toArray();
            try {
                Cache::put('site_settings_dict', $data, 86400);
            } catch (\Throwable $e) {
            }

            return $data;
        } catch (\Throwable $e) {
            return [];
        }
    }

    public static function getAllGrouped(): array
    {
        return Cache::rememberForever('site_settings_all', function () {
            return static::all()->groupBy('group')->toArray();
        });
    }

    protected static function booted()
    {
        static::saved(function ($setting) {
            Cache::forget("site_setting_{$setting->key}");
            Cache::forget('site_settings_all');
            Cache::forget('site_settings_dict');
        });

        static::deleted(function ($setting) {
            Cache::forget("site_setting_{$setting->key}");
            Cache::forget('site_settings_all');
            Cache::forget('site_settings_dict');
        });
    }
}
