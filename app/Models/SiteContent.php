<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function getByKey(string $key, mixed $default = null)
    {
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
}
