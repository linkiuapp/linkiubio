<?php

namespace App\Features\SuperLinkiu\Models\PersonalFinance;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'personal_finance_payments';

    protected $fillable = [
        'user_id',
        'installment_id',
        'account_id',
        'amount',
        'payment_date',
        'payment_method',
        'reference_number',
        'receipt_file',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function installment(): BelongsTo
    {
        return $this->belongsTo(Installment::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    // Scopes
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

    // Helpers
    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'transfer' => 'Transferencia',
            'cash' => 'Efectivo',
            'account_bank' => 'Cuenta Bancaria',
            'card' => 'Tarjeta',
            'nequi' => 'Nequi',
            'daviplata' => 'Daviplata',
            'other' => 'Otro',
            default => 'Otro',
        };
    }
}
