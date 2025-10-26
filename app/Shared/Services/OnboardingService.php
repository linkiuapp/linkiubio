<?php

namespace App\Shared\Services;

use App\Shared\Models\StoreOnboardingStep;

class OnboardingService
{
    /**
     * Marcar pasos como completados basándose en condiciones actuales
     * Útil para migración de datos existentes
     */
    public static function checkAndMarkCompletedSteps(int $storeId): void
    {
        $store = \App\Shared\Models\Store::find($storeId);
        
        if (!$store) {
            return;
        }

        // Design: Si tiene un diseño configurado
        if ($store->design !== null) {
            StoreOnboardingStep::markAsCompleted($storeId, 'design');
        }

        // Slider: Si tiene al menos un slider
        if ($store->sliders()->count() > 0) {
            StoreOnboardingStep::markAsCompleted($storeId, 'slider');
        }

        // Locations: Si tiene al menos una sede
        if ($store->locations()->count() > 0) {
            StoreOnboardingStep::markAsCompleted($storeId, 'locations');
        }

        // Payments: Si tiene al menos un método de pago activo
        if ($store->paymentMethods()->where('is_active', true)->count() > 0) {
            StoreOnboardingStep::markAsCompleted($storeId, 'payments');
        }

        // Shipping: Si tiene zonas de envío configuradas
        $simpleShipping = \App\Features\TenantAdmin\Models\SimpleShipping::where('store_id', $storeId)->first();
        if ($simpleShipping && $simpleShipping->zones()->count() > 0) {
            StoreOnboardingStep::markAsCompleted($storeId, 'shipping');
        }

        // Categories: Si tiene al menos una categoría
        if ($store->categories()->count() > 0) {
            StoreOnboardingStep::markAsCompleted($storeId, 'categories');
        }

        // Variables: Si tiene al menos una variable
        if ($store->variables()->count() > 0) {
            StoreOnboardingStep::markAsCompleted($storeId, 'variables');
        }

        // Products: Si tiene al menos un producto
        if ($store->products()->count() > 0) {
            StoreOnboardingStep::markAsCompleted($storeId, 'products');
        }
    }
}

