<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationSetting extends Model
{
    protected $fillable = [
        'store_id',
        'time_slots',
        'slot_duration',
        'require_deposit',
        'deposit_per_person',
        'send_confirmation',
        'send_reminder',
        'reminder_hours',
        'min_advance_hours'
    ];

    protected $casts = [
        'time_slots' => 'array',
        'slot_duration' => 'integer',
        'require_deposit' => 'boolean',
        'deposit_per_person' => 'decimal:2',
        'send_confirmation' => 'boolean',
        'send_reminder' => 'boolean',
        'reminder_hours' => 'integer',
        'min_advance_hours' => 'integer'
    ];

    /**
     * Relación con Store
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Obtener o crear configuración para una tienda
     */
    public static function getOrCreateForStore(int $storeId): self
    {
        return self::firstOrCreate(
            ['store_id' => $storeId],
            [
                'slot_duration' => 60,
                'require_deposit' => false,
                'deposit_per_person' => 0,
                'send_confirmation' => true,
                'send_reminder' => true,
                'reminder_hours' => 24,
                'min_advance_hours' => 2
            ]
        );
    }
}

