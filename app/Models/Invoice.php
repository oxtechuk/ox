<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'client_id',
        'quotation_id',
        'title',
        'subtotal',
        'discount_type',
        'discount_value',
        'discount_amount',
        'vat_rate',
        'vat_percentage',
        'vat_amount',
        'total_amount',
        'paid_amount',
        'due_amount',
        'currency',
        'status',
        'issue_date',
        'invoice_date',
        'due_date',
        'payment_terms',
        'terms_conditions',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'issue_date' => 'date',
        'due_date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(InvoicePayment::class)->orderBy('payment_date', 'desc');
    }

    public static function generateNumber(): string
    {
        $year = date('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;

        return sprintf('INV-%s-%04d', $year, $count);
    }

    public static function generateInvoiceNumber(): string
    {
        return static::generateNumber();
    }

    // Accessors & Mutators for compatibility
    public function getInvoiceDateAttribute()
    {
        return $this->issue_date;
    }

    public function setInvoiceDateAttribute($value)
    {
        $this->attributes['issue_date'] = $value;
    }

    public function getTermsConditionsAttribute()
    {
        return $this->payment_terms;
    }

    public function setTermsConditionsAttribute($value)
    {
        $this->attributes['payment_terms'] = $value;
    }

    public function recalculateBalances(): void
    {
        $totalPaid = (float) $this->payments()->sum('amount');
        $this->paid_amount = $totalPaid;
        $this->due_amount = max(0, (float) $this->total_amount - $totalPaid);

        if ($this->due_amount <= 0) {
            $this->status = 'paid';
        } elseif ($totalPaid > 0) {
            $this->status = 'partially_paid';
        } else {
            $this->status = ($this->due_date && $this->due_date->isPast()) ? 'overdue' : 'sent';
        }

        $this->save();
    }

    public function recalculatePaymentStatus(): void
    {
        $this->recalculateBalances();
    }
}
