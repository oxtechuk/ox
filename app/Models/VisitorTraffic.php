<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorTraffic extends Model
{
    use HasFactory;

    protected $table = 'visitor_traffic';

    protected $fillable = [
        'session_id',
        'ip_address',
        'url',
        'path',
        'route_name',
        'project_id',
        'referer',
        'referer_source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'device_type',
        'browser',
        'platform',
        'country_code',
        'country_name',
        'is_bot',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeHumans(Builder $query): Builder
    {
        return $query->where('is_bot', false);
    }

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
