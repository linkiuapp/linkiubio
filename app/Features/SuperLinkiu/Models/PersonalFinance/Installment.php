<?php

namespace App\Features\SuperLinkiu\Models\PersonalFinance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Installment extends Model
{
    protected $table = 'personal_finance_installments';

    protected $fillable = [
        'debt_id',
        'installment_number',
        'amount',
        'due_date',
        'paid_date',
        'status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    // Constantes de estado
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_OVERDUE = 'overdue';
    const STATUS_CANCELLED = 'cancelled';

    // Relaciones
    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'installment_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_OVERDUE)
            ->orWhere(function($q) {
                $q->where('status', self::STATUS_PENDING)
                  ->where('due_date', '<', now());
            });
    }

    public function scopeUpcoming($query, int $days = 7)
    {
        return $query->where('status', self::STATUS_PENDING)
            ->whereBetween('due_date', [now(), now()->addDays($days)]);
    }

    // Helpers
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_PAID => 'Pagada',
            self::STATUS_OVERDUE => 'Vencida',
            self::STATUS_CANCELLED => 'Cancelada',
            default => 'Desconocido',
        };
    }

    public function getDaysUntilDueAttribute(): ?int
    {
        if ($this->status === self::STATUS_PAID) {
            return null;
        }
        return now()->diffInDays($this->due_date, false);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status === self::STATUS_PENDING 
            && $this->due_date < now();
    }

    public function markAsPaid(?string $paymentMethod = null, ?Carbon $paidDate = null): void
    {
        $this->update([
            'status' => self::STATUS_PAID,
            'paid_date' => $paidDate ?? now(),
            'payment_method' => $paymentMethod,
        ]);

        // Actualizar contador de cuotas pagadas en la deuda
        $this->debt->increment('paid_installments');

        // Si todas las cuotas están pagadas, marcar deuda como pagada
        if ($this->debt->paid_installments >= $this->debt->total_installments) {
            $this->debt->update(['status' => Debt::STATUS_PAID]);
        }
    }
}
