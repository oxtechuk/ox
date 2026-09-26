<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DownloadToken extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'token',
        'expires_at',
        'download_count',
        'max_downloads',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'download_count' => 'integer',
            'max_downloads' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Order, DownloadToken>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * @return BelongsTo<DigitalProduct, DownloadToken>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class, 'product_id');
    }

    public function isValid(): bool
    {
        if ($this->expires_at !== null && now()->isAfter($this->expires_at)) {
            return false;
        }

        if ($this->download_count >= $this->max_downloads) {
            return false;
        }

        return true;
    }

    public function recordDownload(): void
    {
        $this->increment('download_count');
    }
}
