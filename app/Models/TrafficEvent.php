<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficEvent extends Model
{
    use HasFactory;

    protected $table = 'traffic_events';

    protected $fillable = [
        'session_id',
        'event_name',
        'page_url',
        'event_data',
    ];

    protected $casts = [
        'event_data' => 'array',
    ];

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', now()->today());
    }

    public function scopeLast7Days(Builder $query): Builder
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }

    public function scopeLast30Days(Builder $query): Builder
    {
        return $query->where('created_at', '>=', now()->subDays(30));
    }
}
