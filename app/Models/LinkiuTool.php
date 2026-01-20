<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class LinkiuTool extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'description',
        'usage_in_linkiu',
        'url',
        'dashboard_url',
        'api_docs_url',
        'start_date',
        'billing_type',
        'monthly_cost',
        'yearly_cost',
        'currency',
        'minimum_recharge',
        'current_balance',
        'balance_currency',
        'username',
        'password',
        'api_key',
        'api_secret',
        'account_id',
        'notes',
        'status',
        'is_critical',
        'responsible_team',
        'last_renewal_date',
        'next_renewal_date',
        'notification_phone',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'last_renewal_date' => 'date',
        'next_renewal_date' => 'date',
        'monthly_cost' => 'decimal:2',
        'yearly_cost' => 'decimal:2',
        'minimum_recharge' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'is_critical' => 'boolean',
    ];

    /**
     * Relación con historial de pagos
     */
    public function paymentHistory()
    {
        return $this->hasMany(ToolPaymentHistory::class, 'tool_id');
    }

    /**
     * Relación con usuario creador
     */
    public function creator()
    {
        return $this->belongsTo(\App\Shared\Models\User::class, 'created_by');
    }

    /**
     * Relación con usuario que actualizó
     */
    public function updater()
    {
        return $this->belongsTo(\App\Shared\Models\User::class, 'updated_by');
    }

    /**
     * Obtener contraseña desencriptada
     */
    public function getDecryptedPassword(): ?string
    {
        if (!$this->password) {
            return null;
        }

        try {
            return Crypt::decryptString($this->password);
        } catch (\Exception $e) {
            return $this->password; // Si falla, retornar el valor original
        }
    }

    /**
     * Obtener API key desencriptada
     */
    public function getDecryptedApiKey(): ?string
    {
        if (!$this->api_key) {
            return null;
        }

        try {
            return Crypt::decryptString($this->api_key);
        } catch (\Exception $e) {
            return $this->api_key; // Si falla, retornar el valor original
        }
    }

    /**
     * Obtener API secret desencriptado
     */
    public function getDecryptedApiSecret(): ?string
    {
        if (!$this->api_secret) {
            return null;
        }

        try {
            return Crypt::decryptString($this->api_secret);
        } catch (\Exception $e) {
            return $this->api_secret; // Si falla, retornar el valor original
        }
    }

    /**
     * Establecer contraseña encriptada
     */
    public function setPasswordAttribute($value)
    {
        if ($value && trim($value) !== '') {
            $this->attributes['password'] = Crypt::encryptString($value);
        } else {
            // Si está vacío y no existe el atributo original, establecer null
            // Si existe, no hacer nada (mantener el valor actual)
            if (!array_key_exists('password', $this->attributes)) {
                $this->attributes['password'] = null;
            }
        }
    }

    /**
     * Establecer API key encriptada
     */
    public function setApiKeyAttribute($value)
    {
        if ($value && trim($value) !== '') {
            $this->attributes['api_key'] = Crypt::encryptString($value);
        } else {
            // Si está vacío y no existe el atributo original, establecer null
            // Si existe, no hacer nada (mantener el valor actual)
            if (!array_key_exists('api_key', $this->attributes)) {
                $this->attributes['api_key'] = null;
            }
        }
    }

    /**
     * Establecer API secret encriptado
     */
    public function setApiSecretAttribute($value)
    {
        if ($value && trim($value) !== '') {
            $this->attributes['api_secret'] = Crypt::encryptString($value);
        } else {
            // Si está vacío y no existe el atributo original, establecer null
            // Si existe, no hacer nada (mantener el valor actual)
            if (!array_key_exists('api_secret', $this->attributes)) {
                $this->attributes['api_secret'] = null;
            }
        }
    }

    /**
     * Scope para herramientas activas
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope para herramientas críticas
     */
    public function scopeCritical($query)
    {
        return $query->where('is_critical', true);
    }

    /**
     * Scope por categoría
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope por tipo de facturación
     */
    public function scopeByBillingType($query, string $type)
    {
        return $query->where('billing_type', $type);
    }

    /**
     * Obtener costo formateado
     */
    public function getFormattedCost(): string
    {
        $amount = match($this->billing_type) {
            'monthly' => $this->monthly_cost,
            'yearly' => $this->yearly_cost,
            default => 0
        };

        return $this->currency . ' ' . number_format($amount, 2);
    }

    /**
     * Verificar si tiene renovación próxima (próximos 7 días)
     */
    public function hasUpcomingRenewal(): bool
    {
        if (!$this->next_renewal_date) {
            return false;
        }

        return $this->next_renewal_date->isBefore(now()->addDays(7));
    }

    /**
     * Obtener el estado de pago basado en la fecha de renovación
     * Retorna: 'active', 'upcoming', 'due', 'overdue', o null si no aplica
     */
    public function getPaymentStatus(): ?string
    {
        if (!$this->next_renewal_date || $this->billing_type === 'free') {
            return null;
        }

        $today = now()->startOfDay();
        $dueDate = $this->next_renewal_date->startOfDay();
        
        // Si es exactamente hoy
        if ($today->equalTo($dueDate)) {
            return 'due';
        }
        
        // Calcular diferencia: diffInDays con false siempre devuelve positivo
        // Necesitamos verificar si la fecha es pasada o futura
        if ($dueDate->isPast()) {
            // Ya pasó - calcular días de retraso
            $daysOverdue = $today->diffInDays($dueDate);
            return 'overdue';
        } else {
            // Es futura - calcular días hasta vencimiento
            $daysUntilDue = $today->diffInDays($dueDate);
            
            // Por vencer: entre 1 y 7 días antes
            if ($daysUntilDue >= 1 && $daysUntilDue <= 7) {
                return 'upcoming';
            }
            
            // Vigente: más de 7 días antes
            if ($daysUntilDue > 7) {
                return 'active';
            }
        }

        return null;
    }

    /**
     * Obtener el label del estado de pago
     */
    public function getPaymentStatusLabel(): ?string
    {
        return match($this->getPaymentStatus()) {
            'active' => 'Vigente',
            'upcoming' => 'Por vencer',
            'due' => 'Vencido',
            'overdue' => 'Retrasado',
            default => null
        };
    }

    /**
     * Obtener los días de retraso (si está retrasado)
     */
    public function getDaysOverdue(): ?int
    {
        if ($this->getPaymentStatus() !== 'overdue') {
            return null;
        }

        return abs(now()->startOfDay()->diffInDays($this->next_renewal_date->startOfDay(), false));
    }

    /**
     * Verificar si es una herramienta de pago por uso (requiere recargas)
     */
    public function isPayPerUse(): bool
    {
        return $this->billing_type === 'pay_per_use';
    }

    /**
     * Verificar si el saldo está bajo (menor al mínimo recomendado)
     */
    public function isBalanceLow(): bool
    {
        if (!$this->isPayPerUse() || !$this->current_balance || !$this->minimum_recharge) {
            return false;
        }

        return $this->current_balance < $this->minimum_recharge;
    }

    /**
     * Obtener saldo formateado
     */
    public function getFormattedBalance(): ?string
    {
        if (!$this->current_balance) {
            return null;
        }

        $currency = $this->balance_currency ?? $this->currency ?? 'USD';
        return $currency . ' ' . number_format($this->current_balance, 2);
    }

    /**
     * Obtener moneda del saldo (por defecto usa currency)
     */
    public function getBalanceCurrency(): string
    {
        return $this->balance_currency ?? $this->currency ?? 'USD';
    }
}
