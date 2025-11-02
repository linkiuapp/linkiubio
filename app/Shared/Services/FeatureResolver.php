<?php

namespace App\Shared\Services;

use App\Shared\Models\Store;
use App\Shared\Models\BusinessFeature;
use App\Shared\Enums\FeatureKey;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class FeatureResolver
{
    /**
     * TTL del caché en segundos (10 minutos)
     */
    const CACHE_TTL = 600;

    /**
     * Obtener features habilitados para una tienda
     */
    public function enabledForStore(Store $store): Collection
    {
        $cacheKey = "store.{$store->id}.features";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($store) {
            // Si la tienda no tiene categoría, retornar solo features base
            if (!$store->businessCategory) {
                return $this->getDefaultFeatures();
            }

            // Obtener features de la categoría
            $features = $store->businessCategory
                ->features()
                ->pluck('key');

            return $features;
        });
    }

    /**
     * Verificar si un feature específico está habilitado para una tienda
     */
    public function isEnabled(Store $store, string $featureKey): bool
    {
        $enabledFeatures = $this->enabledForStore($store);
        
        return $enabledFeatures->contains($featureKey);
    }

    /**
     * Invalidar caché de features para una tienda
     */
    public function invalidateStoreCache(Store $store): void
    {
        $cacheKey = "store.{$store->id}.features";
        Cache::forget($cacheKey);
    }

    /**
     * Invalidar caché de todas las tiendas de una categoría
     */
    public function invalidateCategoryCache(int $categoryId): void
    {
        $stores = Store::where('business_category_id', $categoryId)->get();
        
        foreach ($stores as $store) {
            $this->invalidateStoreCache($store);
        }
    }

    /**
     * Obtener features por defecto (base para todas las categorías)
     */
    private function getDefaultFeatures(): Collection
    {
        return BusinessFeature::where('is_default', true)
            ->pluck('key');
    }
}


