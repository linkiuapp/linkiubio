<?php

namespace App\Features\SuperLinkiu\Models\PersonalFinance;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Debt extends Model
{
    protected $table = 'personal_finance_debts';

    protected $fillable = [
        'user_id',
        'account_id',
        'name',
        'description',
        'total_amount',
        'installment_amount',
        'interest_rate',
        'interest_included',
        'total_installments',
        'paid_installments',
        'start_date',
        'end_date',
        'payment_frequency',
        'status',
        'auto_calculate_installments',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'interest_included' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'auto_calculate_installments' => 'boolean',
    ];

    // Constantes de estado
    const STATUS_ACTIVE = 'active';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_OVERDUE = 'overdue';

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class, 'debt_id')->orderBy('installment_number');
    }

    public function pendingInstallments(): HasMany
    {
        return $this->hasMany(Installment::class, 'debt_id')
            ->where('status', 'pending')
            ->orderBy('due_date');
    }

    public function overdueInstallments(): HasMany
    {
        return $this->hasMany(Installment::class, 'debt_id')
            ->where('status', 'overdue')
            ->orderBy('due_date');
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class, 'debt_id');
    }

    // Scopes
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    // Helpers
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'Activa',
            self::STATUS_PAID => 'Pagada',
            self::STATUS_CANCELLED => 'Cancelada',
            self::STATUS_OVERDUE => 'Vencida',
            default => 'Desconocido',
        };
    }

    public function getProgressPercentageAttribute(): float
    {
        if ($this->total_installments == 0) {
            return 0;
        }
        return ($this->paid_installments / $this->total_installments) * 100;
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->installments()
            ->where('status', 'paid')
            ->sum('amount');
    }

    public function getTotalPendingAttribute(): float
    {
        return (float) $this->installments()
            ->where('status', 'pending')
            ->sum('amount');
    }

    public function getNextDueDateAttribute(): ?string
    {
        $nextInstallment = $this->pendingInstallments()->first();
        return $nextInstallment?->due_date?->format('Y-m-d');
    }
}
