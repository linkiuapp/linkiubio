<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubSubscription extends Model
{
    protected $table = 'sub_subscriptions';

    protected $fillable = [
        'client_id',
        'service_type_id',
        'service_name',
        'description',
        'amount',
        'currency',
        'billing_period',
        'start_date',
        'next_billing_date',
        'status',
        'payment_token',
        'notes',
        'auto_remind',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'next_billing_date' => 'date',
        'auto_remind' => 'boolean',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING_PAYMENT = 'pending_payment';
    const STATUS_EXPIRED = 'expired';
    const STATUS_CANCELLED = 'cancelled';

    const PERIOD_MONTHLY = 'monthly';
    const PERIOD_QUARTERLY = 'quarterly';
    const PERIOD_SEMIANNUAL = 'semiannual';
    const PERIOD_ANNUAL = 'annual';

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($subscription) {
            if (empty($subscription->payment_token)) {
                $subscription->payment_token = Str::random(32);
            }
        });
    }

    // ==================== RELACIONES ====================

    public function client(): BelongsTo
    {
        return $this->belongsTo(SubClient::class, 'client_id');
    }

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(SubServiceType::class, 'service_type_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SubPayment::class, 'subscription_id');
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(SubReminder::class, 'subscription_id');
    }

    // ==================== ACCESSORS ====================

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'Activo',
            self::STATUS_PENDING_PAYMENT => 'Pago Pendiente',
            self::STATUS_EXPIRED => 'Vencido',
            self::STATUS_CANCELLED => 'Cancelado',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'green',
            self::STATUS_PENDING_PAYMENT => 'yellow',
            self::STATUS_EXPIRED => 'red',
            self::STATUS_CANCELLED => 'gray',
            default => 'gray',
        };
    }

    public function getPeriodLabelAttribute(): string
    {
        return match($this->billing_period) {
            self::PERIOD_MONTHLY => 'Mensual',
            self::PERIOD_QUARTERLY => 'Trimestral',
            self::PERIOD_SEMIANNUAL => 'Semestral',
            self::PERIOD_ANNUAL => 'Anual',
            default => $this->billing_period,
        };
    }

    public function getPeriodMonthsAttribute(): int
    {
        return match($this->billing_period) {
            self::PERIOD_MONTHLY => 1,
            self::PERIOD_QUARTERLY => 3,
            self::PERIOD_SEMIANNUAL => 6,
            self::PERIOD_ANNUAL => 12,
            default => 12,
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount, 0, ',', '.') . ' ' . $this->currency;
    }

    public function getDaysUntilDueAttribute(): int
    {
        return max(0, now()->startOfDay()->diffInDays($this->next_billing_date, false));
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->next_billing_date->isPast();
    }

    public function getIsDueSoonAttribute(): bool
    {
        return $this->days_until_due <= 7 && $this->days_until_due > 0;
    }

    public function getPublicUrlAttribute(): string
    {
        return url("/pago/{$this->payment_token}");
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopePendingPayment($query)
    {
        return $query->where('status', self::STATUS_PENDING_PAYMENT);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED);
    }

    public function scopeDueSoon($query, int $days = 30)
    {
        return $query->whereBetween('next_billing_date', [now(), now()->addDays($days)]);
    }

    public function scopeOverdue($query)
    {
        return $query->where('next_billing_date', '<', now())
                     ->whereNotIn('status', [self::STATUS_CANCELLED]);
    }

    public function scopeAutoRemind($query)
    {
        return $query->where('auto_remind', true);
    }

    public function scopeByPeriod($query, ?string $period)
    {
        if (!$period) return $query;
        return $query->where('billing_period', $period);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) return $query;
        
        return $query->where(function ($q) use ($search) {
            $q->where('service_name', 'like', "%{$search}%")
              ->orWhereHas('client', function ($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
              });
        });
    }

    // ==================== MÉTODOS ====================

    public function getReminderDays(): array
    {
        return match($this->billing_period) {
            self::PERIOD_MONTHLY => [7, 5, 1],
            self::PERIOD_QUARTERLY => [15, 7, 3, 1],
            self::PERIOD_SEMIANNUAL => [30, 15, 7, 1],
            self::PERIOD_ANNUAL => [30, 15, 7, 1],
            default => [7, 1],
        };
    }

    public function shouldSendReminder(int $daysBeforeDue): bool
    {
        // Verificar si ya se envió este recordatorio
        $reminderType = "reminder_{$daysBeforeDue}d";
        $currentPeriodStart = $this->next_billing_date->copy()->subMonths($this->period_months);
        
        return !$this->reminders()
            ->where('type', $reminderType)
            ->where('status', 'sent')
            ->where('created_at', '>=', $currentPeriodStart)
            ->exists();
    }

    public function calculateNextBillingDate(): Carbon
    {
        return $this->next_billing_date->copy()->addMonths($this->period_months);
    }

    public function renewSubscription(): void
    {
        $this->update([
            'next_billing_date' => $this->calculateNextBillingDate(),
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function createPayment(): SubPayment
    {
        $periodStart = $this->next_billing_date;
        $periodEnd = $this->calculateNextBillingDate()->subDay();

        return $this->payments()->create([
            'amount' => $this->amount,
            'currency' => $this->currency,
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
            'status' => 'pending',
            'payment_token' => Str::random(32),
        ]);
    }

    public function markAsPendingPayment(): void
    {
        $this->update(['status' => self::STATUS_PENDING_PAYMENT]);
    }

    public function markAsExpired(): void
    {
        $this->update(['status' => self::STATUS_EXPIRED]);
    }

    public static function getPeriods(): array
    {
        return [
            self::PERIOD_MONTHLY => 'Mensual',
            self::PERIOD_QUARTERLY => 'Trimestral',
            self::PERIOD_SEMIANNUAL => 'Semestral',
            self::PERIOD_ANNUAL => 'Anual',
        ];
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_ACTIVE => 'Activo',
            self::STATUS_PENDING_PAYMENT => 'Pago Pendiente',
            self::STATUS_EXPIRED => 'Vencido',
            self::STATUS_CANCELLED => 'Cancelado',
        ];
    }
}
