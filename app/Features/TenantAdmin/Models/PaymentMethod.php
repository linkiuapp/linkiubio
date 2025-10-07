<?php

namespace App\Features\TenantAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Shared\Models\Store;

class PaymentMethod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'is_active',
        'sort_order',
        'instructions',
        'store_id',
        'available_for_pickup',
        'available_for_delivery',
        'require_proof',
        'accepted_cards',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'available_for_pickup' => 'boolean',
        'available_for_delivery' => 'boolean',
        'require_proof' => 'boolean',
    ];

    /**
     * Get the store that owns the payment method.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the bank accounts for the payment method.
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    /**
     * Scope a query to only include active payment methods.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Check if the payment method is available for the given delivery type.
     *
     * @param string $deliveryType 'pickup' or 'delivery'
     * @return bool
     */
    public function isAvailableFor(string $deliveryType): bool
    {
        if ($deliveryType === 'pickup') {
            return $this->available_for_pickup;
        }
        
        if ($deliveryType === 'delivery') {
            return $this->available_for_delivery;
        }
        
        return false;
    }

    /**
     * Check if the payment method is of type 'cash'.
     */
    public function isCash(): bool
    {
        return $this->type === 'cash';
    }

    /**
     * Check if the payment method is of type 'bank_transfer'.
     */
    public function isBankTransfer(): bool
    {
        return $this->type === 'bank_transfer';
    }

    /**
     * Check if the payment method is of type 'card_terminal'.
     */
    public function isCardTerminal(): bool
    {
        return $this->type === 'card_terminal';
    }

    /**
     * Check if the payment method is of type 'digital_wallet'.
     */
    public function isDigitalWallet(): bool
    {
        return $this->type === 'digital_wallet';
    }

    /**
     * Check if the payment method is of type 'cash_on_delivery'.
     */
    public function isCashOnDelivery(): bool
    {
        return $this->type === 'cash_on_delivery';
    }

    /**
     * Get the display name for the payment method type.
     */
    public function getTypeDisplayName(): string
    {
        return match($this->type) {
            'cash' => 'Efectivo',
            'bank_transfer' => 'Transferencia Bancaria',
            'card_terminal' => 'Datáfono',
            'digital_wallet' => 'Billetera Digital',
            'cash_on_delivery' => 'Contraentrega',
            default => ucfirst($this->type)
        };
    }

    /**
     * Get the icon for the payment method type.
     */
    public function getTypeIcon(): string
    {
        return match($this->type) {
            'cash' => '💵',
            'bank_transfer' => '🏦',
            'card_terminal' => '💳',
            'digital_wallet' => '📱',
            'cash_on_delivery' => '🚚',
            default => '💰'
        };
    }
}