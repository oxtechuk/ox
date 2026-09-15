<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_number',
        'client_id',
        'title',
        'subtotal',
        'discount_type',
        'discount_value',
        'discount_amount',
        'vat_percentage',
        'vat_rate',
        'vat_amount',
        'total_amount',
        'currency',
        'status',
        'issue_date',
        'quotation_date',
        'valid_until',
        'terms_and_conditions',
        'terms_conditions',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'vat_percentage' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'issue_date' => 'date',
        'valid_until' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class)->orderBy('order');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public static function generateNumber(): string
    {
        $year = date('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;
        return sprintf('QT-%s-%04d', $year, $count);
    }

    public static function generateQuotationNumber(): string
    {
        return static::generateNumber();
    }

    // Accessors & Mutators for compatibility
    public function getQuotationDateAttribute()
    {
        return $this->issue_date;
    }

    public function setQuotationDateAttribute($value)
    {
        $this->attributes['issue_date'] = $value;
    }

    public function getVatRateAttribute()
    {
        return $this->vat_percentage ?? 15;
    }

    public function setVatRateAttribute($value)
    {
        $this->attributes['vat_percentage'] = $value;
    }

    public function getTermsConditionsAttribute()
    {
        return $this->terms_and_conditions;
    }

    public function setTermsConditionsAttribute($value)
    {
        $this->attributes['terms_and_conditions'] = $value;
    }

    public function recalculateTotals(): void
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += (float) $item->total_price;
        }

        $this->subtotal = $subtotal;
        $discountVal = (float) ($this->discount_value ?? 0);

        if ($this->discount_type === 'percentage') {
            $this->discount_amount = $subtotal * ($discountVal / 100);
        } else {
            $this->discount_amount = $discountVal;
        }

        $taxable = max(0, $subtotal - (float) $this->discount_amount);
        $vatRate = (float) ($this->vat_percentage ?? 15);
        $this->vat_amount = $taxable * ($vatRate / 100);
        $this->total_amount = $taxable + (float) $this->vat_amount;

        $this->save();
    }
}
