<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SubPayment extends Model
{
    protected $table = 'sub_payments';

    protected $fillable = [
        'subscription_id',
        'amount',
        'currency',
        'period_start',
        'period_end',
        'status',
        'paid_at',
        'payment_method',
        'payment_reference',
        'epayco_ref',
        'payment_token',
        'notes',
        'epayco_data',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'period_start' => 'date',
        'period_end' => 'date',
        'paid_at' => 'datetime',
        'epayco_data' => 'array',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($payment) {
            if (empty($payment->payment_token)) {
                $payment->payment_token = Str::random(32);
            }
        });
    }

    // ==================== RELACIONES ====================

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(SubSubscription::class, 'subscription_id');
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(SubReminder::class, 'payment_id');
    }

    // ==================== ACCESSORS ====================

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_PAID => 'Pagado',
            self::STATUS_FAILED => 'Fallido',
            self::STATUS_CANCELLED => 'Cancelado',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_PAID => 'green',
            self::STATUS_FAILED => 'red',
            self::STATUS_CANCELLED => 'gray',
            default => 'gray',
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'pse' => 'PSE',
            'cash' => 'Efectivo',
            'nequi' => 'Nequi',
            'daviplata' => 'Daviplata',
            'card' => 'Tarjeta',
            default => $this->payment_method ?? 'N/A',
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount, 0, ',', '.') . ' ' . $this->currency;
    }

    public function getPeriodRangeAttribute(): string
    {
        return $this->period_start->format('d/m/Y') . ' - ' . $this->period_end->format('d/m/Y');
    }

    public function getPublicUrlAttribute(): string
    {
        return url("/pago/factura/{$this->payment_token}");
    }

    // ==================== SCOPES ====================

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // ==================== MÉTODOS ====================

    public function markAsPaid(?string $paymentMethod = null, ?string $reference = null, ?string $epaycoRef = null): void
    {
        $this->update([
            'status' => self::STATUS_PAID,
            'paid_at' => now(),
            'payment_method' => $paymentMethod ?? $this->payment_method,
            'payment_reference' => $reference ?? $this->payment_reference,
            'epayco_ref' => $epaycoRef ?? $this->epayco_ref,
        ]);

        // Renovar la suscripción
        $this->subscription->renewSubscription();
    }

    public function markAsFailed(?string $reason = null): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'notes' => $reason,
        ]);
    }

    public function generateReference(): string
    {
        return 'SUB-' . strtoupper(Str::random(8)) . '-' . $this->id;
    }
}
