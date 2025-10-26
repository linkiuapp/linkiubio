<?php

namespace App\Shared\Observers;

use App\Shared\Models\StoreOnboardingStep;

class OnboardingObserver
{
    /**
     * Verificar y marcar pasos de onboarding según las condiciones
     */
    public static function checkAndMarkStep($model, string $stepKey): void
    {
        $storeId = null;

        // Obtener el store_id según el modelo
        if (property_exists($model, 'store_id')) {
            $storeId = $model->store_id;
        } elseif (method_exists($model, 'store')) {
            $storeId = $model->store->id ?? null;
        }

        if (!$storeId) {
            return;
        }

        // Verificar si ya está marcado
        if (StoreOnboardingStep::isCompleted($storeId, $stepKey)) {
            return;
        }

        // Marcar como completado
        StoreOnboardingStep::markAsCompleted($storeId, $stepKey);
    }
}

