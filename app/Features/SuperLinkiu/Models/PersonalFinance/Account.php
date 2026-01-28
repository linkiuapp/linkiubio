<?php

namespace App\Features\SuperLinkiu\Models\PersonalFinance;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $table = 'personal_finance_accounts';

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'bank_name',
        'account_number',
        'current_balance',
        'credit_limit',
        'currency',
        'color',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'current_balance' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class, 'account_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'account_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helpers
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'checking' => 'Cuenta Corriente',
            'savings' => 'Cuenta de Ahorros',
            'credit_card' => 'Tarjeta de Crédito',
            'loan' => 'Préstamo',
            'other' => 'Otro',
            default => 'Otro',
        };
    }
}
