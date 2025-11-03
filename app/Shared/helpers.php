<?php

use App\Shared\Services\FeatureResolver;
use App\Shared\Models\Store;

if (!function_exists('featureEnabled')) {
    /**
     * Verificar si un feature está habilitado para una tienda
     *
     * @param Store $store
     * @param string $featureKey
     * @return bool
     */
    function featureEnabled(Store $store, string $featureKey): bool
    {
        $resolver = app(FeatureResolver::class);
        return $resolver->isEnabled($store, $featureKey);
    }
}


