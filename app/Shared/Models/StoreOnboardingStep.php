<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreOnboardingStep extends Model
{
    protected $fillable = [
        'store_id',
        'step_key',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    /**
     * Relación con Store
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Marcar un paso como completado para una tienda
     */
    public static function markAsCompleted(int $storeId, string $stepKey): void
    {
        static::updateOrCreate(
            [
                'store_id' => $storeId,
                'step_key' => $stepKey,
            ],
            [
                'completed_at' => now(),
            ]
        );
    }

    /**
     * Verificar si un paso está completado para una tienda
     */
    public static function isCompleted(int $storeId, string $stepKey): bool
    {
        return static::where('store_id', $storeId)
            ->where('step_key', $stepKey)
            ->whereNotNull('completed_at')
            ->exists();
    }

    /**
     * Obtener todos los pasos completados de una tienda
     */
    public static function getCompletedSteps(int $storeId): array
    {
        return static::where('store_id', $storeId)
            ->whereNotNull('completed_at')
            ->pluck('step_key')
            ->toArray();
    }

    /**
     * Verificar si todos los pasos están completados
     */
    public static function allCompleted(int $storeId): bool
    {
        $requiredSteps = ['design', 'slider', 'locations', 'payments', 'shipping', 'categories', 'variables', 'products'];
        $completedSteps = static::getCompletedSteps($storeId);
        
        return count(array_intersect($requiredSteps, $completedSteps)) === count($requiredSteps);
    }
}

