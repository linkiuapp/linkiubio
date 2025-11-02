<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelSetting extends Model
{
    protected $fillable = [
        'store_id',
        'check_in_time',
        'check_out_time',
        'deposit_type',
        'deposit_percentage',
        'deposit_fixed_amount',
        'require_security_deposit',
        'security_deposit_amount',
        'cancellation_hours',
        'min_guest_age',
        'min_advance_hours',
        'children_free_max_age',
        'children_discounted_max_age',
        'children_discount_percentage',
        'charge_children_by_occupancy',
        'send_confirmation',
        'send_checkin_reminder',
        'reminder_hours'
    ];

    protected $casts = [
        'check_in_time' => 'string',
        'check_out_time' => 'string',
        'deposit_type' => 'string',
        'deposit_percentage' => 'integer',
        'deposit_fixed_amount' => 'decimal:2',
        'require_security_deposit' => 'boolean',
        'security_deposit_amount' => 'decimal:2',
        'cancellation_hours' => 'integer',
        'min_guest_age' => 'integer',
        'min_advance_hours' => 'integer',
        'children_free_max_age' => 'integer',
        'children_discounted_max_age' => 'integer',
        'children_discount_percentage' => 'integer',
        'charge_children_by_occupancy' => 'boolean',
        'send_confirmation' => 'boolean',
        'send_checkin_reminder' => 'boolean',
        'reminder_hours' => 'integer'
    ];

    /**
     * Relación con Store
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Calcular monto de anticipo basado en el total
     */
    public function calculateDepositAmount($total): float
    {
        if ($this->deposit_type === 'fixed') {
            return (float) $this->deposit_fixed_amount;
        }
        
        return round(($total * $this->deposit_percentage) / 100, 2);
    }
}

