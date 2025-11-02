<?php

namespace App\Shared\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Shared\Services\FeatureResolver;
use Symfony\Component\HttpFoundation\Response;

class EnsureFeatureEnabled
{
    protected FeatureResolver $featureResolver;

    public function __construct(FeatureResolver $featureResolver)
    {
        $this->featureResolver = $featureResolver;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $featureKey): Response
    {
        try {
            // Log al inicio para verificar que el middleware se ejecuta
            // Usar error_log para asegurar que se escriba inmediatamente
            error_log('EnsureFeatureEnabled: Starting - Feature: ' . $featureKey . ' - URL: ' . $request->fullUrl());
            \Log::info('EnsureFeatureEnabled: Starting', [
                'feature' => $featureKey,
                'url' => $request->fullUrl(),
                'route_name' => $request->route()?->getName(),
                'route_params' => $request->route()?->parameters()
            ]);
            
            // El store debería estar resuelto por tenant.identify, pero si no, intentar obtenerlo del slug
            $store = $request->route('store');
            
            \Log::info('EnsureFeatureEnabled: Store check', [
                'store_exists' => $store !== null,
                'store_type' => $store !== null ? (is_string($store) ? 'string' : get_class($store)) : 'null',
                'store_value' => $store !== null ? (is_string($store) ? $store : ($store->id ?? 'no-id')) : 'null',
                'all_route_params' => $request->route()?->parameters()
            ]);

            // Si el store no está resuelto (es string), intentar resolverlo ahora
            if (!$store) {
                // Intentar obtener el slug de la URL directamente
                $pathSegments = explode('/', trim($request->path(), '/'));
                $storeSlug = $pathSegments[0] ?? null;
                
                if ($storeSlug) {
                    \Log::info('EnsureFeatureEnabled: Attempting to resolve store from slug', ['slug' => $storeSlug]);
                    $store = \App\Shared\Models\Store::where('slug', $storeSlug)->first();
                    if ($store) {
                        \Log::info('EnsureFeatureEnabled: Store resolved from slug', ['store_id' => $store->id]);
                        // Establecer en la ruta para que otros middlewares lo usen
                        if ($request->route()) {
                            $request->route()->setParameter('store', $store);
                        }
                    }
                }
            } elseif (is_string($store)) {
                // Si es string, resolverlo
                \Log::info('EnsureFeatureEnabled: Store is string, resolving', ['slug' => $store]);
                $storeModel = \App\Shared\Models\Store::where('slug', $store)->first();
                if ($storeModel) {
                    $store = $storeModel;
                    \Log::info('EnsureFeatureEnabled: Store resolved from string', ['store_id' => $store->id]);
                    if ($request->route()) {
                        $request->route()->setParameter('store', $store);
                    }
                }
            }

            if (!$store || !($store instanceof \App\Shared\Models\Store)) {
                \Log::error('EnsureFeatureEnabled: Store not found in route', [
                    'url' => $request->fullUrl(),
                    'route_name' => $request->route()?->getName(),
                    'route_params' => $request->route()?->parameters(),
                    'all_params' => $request->route()?->parametersWithoutNulls()
                ]);
                abort(404, 'Tienda no encontrada');
            }
        
        \Log::info('EnsureFeatureEnabled: Store found and ready', [
            'store_type' => get_class($store),
            'store_id' => $store->id,
            'store_slug' => $store->slug
        ]);

        $isEnabled = $this->featureResolver->isEnabled($store, $featureKey);
        
        \Log::info('EnsureFeatureEnabled: Feature check result', [
            'feature' => $featureKey,
            'store_id' => $store->id,
            'store_slug' => $store->slug,
            'is_enabled' => $isEnabled,
            'url' => $request->fullUrl()
        ]);

        if (!$isEnabled) {
            \Log::warning('EnsureFeatureEnabled: Feature disabled - aborting', [
                'feature' => $featureKey,
                'store_id' => $store->id,
                'url' => $request->fullUrl()
            ]);
            abort(404, 'Funcionalidad no disponible para este tipo de negocio');
        }
        
        \Log::info('EnsureFeatureEnabled: Feature enabled - continuing', [
            'feature' => $featureKey,
            'store_id' => $store->id,
            'next_action' => 'calling $next($request)'
        ]);
        
        $response = $next($request);
        
        \Log::info('EnsureFeatureEnabled: Response received', [
            'feature' => $featureKey,
            'status_code' => $response->getStatusCode(),
            'response_class' => get_class($response)
        ]);

        return $response;
        } catch (\Exception $e) {
            \Log::error('EnsureFeatureEnabled: Exception caught', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'feature' => $featureKey,
                'url' => $request->fullUrl()
            ]);
            throw $e;
        }
    }
}


