<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DineInSetting extends Model
{
    protected $fillable = [
        'store_id',
        'is_enabled',
        'charge_service_fee',
        'service_fee_type',
        'service_fee_percentage',
        'service_fee_fixed',
        'suggest_tip',
        'tip_options',
        'allow_custom_tip',
        'require_table_number',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'charge_service_fee' => 'boolean',
        'service_fee_percentage' => 'integer',
        'service_fee_fixed' => 'decimal:2',
        'suggest_tip' => 'boolean',
        'tip_options' => 'array',
        'allow_custom_tip' => 'boolean',
        'require_table_number' => 'boolean',
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
        return static::firstOrCreate(
            ['store_id' => $storeId],
            [
                'is_enabled' => false,
                'charge_service_fee' => false,
                'service_fee_type' => 'percentage',
                'service_fee_percentage' => 10,
                'service_fee_fixed' => 0,
                'suggest_tip' => true,
                'tip_options' => [0, 10, 15, 20],
                'allow_custom_tip' => true,
                'require_table_number' => true,
            ]
        );
    }

    /**
     * Obtener opciones de propina por defecto si no están configuradas
     */
    public function getTipOptionsAttribute($value): array
    {
        $options = json_decode($value, true);
        return $options ?? [0, 10, 15, 20];
    }
}

