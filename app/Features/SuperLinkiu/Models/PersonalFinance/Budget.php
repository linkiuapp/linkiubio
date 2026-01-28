<?php

namespace App\Features\SuperLinkiu\Models\PersonalFinance;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $table = 'personal_finance_budgets';

    protected $fillable = [
        'user_id',
        'category',
        'amount',
        'period',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helpers
    public function getSpentAmountAttribute(): float
    {
        return Transaction::where('user_id', $this->user_id)
            ->where('category', $this->category)
            ->where('type', Transaction::TYPE_EXPENSE)
            ->whereBetween('transaction_date', [
                $this->start_date,
                $this->end_date ?? now()
            ])
            ->sum('amount');
    }

    public function getRemainingAmountAttribute(): float
    {
        return $this->amount - $this->spent_amount;
    }

    public function getPercentageUsedAttribute(): float
    {
        if ($this->amount == 0) {
            return 0;
        }
        return ($this->spent_amount / $this->amount) * 100;
    }
}
