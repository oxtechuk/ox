<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'project_type',
        'budget',
        'message',
        'status',
        'admin_notes',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'referrer_url',
        'platform_detected',
        'ip_address',
        'user_agent',
    ];

    public static function statusLabels(): array
    {
        return [
            'new' => 'طلب جديد',
            'contacted' => 'تم التواصل',
            'scheduled' => 'تم حجز موعد',
            'completed' => 'مكتمل',
            'archived' => 'مؤرشف',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = self::statusLabels();
        return $labels[$this->status] ?? $this->status;
    }
}
