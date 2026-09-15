<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_name',
        'email',
        'phone',
        'country',
        'city',
        'address',
        'vat_number',
        'tax_number',
        'status',
        'source_platform',
        'lead_source',
        'notes',
    ];

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class)->orderBy('id', 'desc');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class)->orderBy('id', 'desc');
    }

    public function getTaxNumberAttribute()
    {
        return $this->vat_number;
    }

    public function setTaxNumberAttribute($value)
    {
        $this->attributes['vat_number'] = $value;
    }

    public function getLeadSourceAttribute()
    {
        return $this->source_platform;
    }

    public function setLeadSourceAttribute($value)
    {
        $this->attributes['source_platform'] = $value;
    }

    public function getTotalBilledAttribute(): float
    {
        return (float) $this->invoices()->sum('total_amount');
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->invoices()->sum('paid_amount');
    }

    public function getTotalDueAttribute(): float
    {
        return (float) $this->invoices()->sum('due_amount');
    }

    public function getOutstandingBalanceAttribute(): float
    {
        return $this->total_due;
    }

    public function recalculateFinancials(): void
    {
        // Dynamic calculated through relationships
    }
}
