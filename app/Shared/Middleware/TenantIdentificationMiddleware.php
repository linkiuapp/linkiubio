<?php

namespace App\Shared\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Shared\Models\Store;
use App\Shared\Services\TenantService;
use Symfony\Component\HttpFoundation\Response;

class TenantIdentificationMiddleware
{
    public function __construct(
        protected TenantService $tenantService
    ) {}
    
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener el slug de la tienda desde la URL
        $storeSlug = $request->route('store');
        
        if ($storeSlug) {
            // Buscar la tienda por slug sin verificar estado y cargar contadores
            $store = Store::where('slug', $storeSlug)
                ->withCount([
                    'products',
                    'categories',
                    'variables',
                    'sliders'
                ])
                ->with('plan')
                ->first();
            
            if (!$store) {
                abort(404, 'Tienda no encontrada');
            }
            
            // ✅ VALIDACIÓN: Solo para rutas públicas (frontend Tenant)
            // Las rutas /admin/* NO pasan por esta validación
            $isAdminRoute = $request->is('*/admin*') || $request->is('*/admin/*');
            
            if (!$isAdminRoute) {
                // Si la tienda NO está aprobada, mostrar 404 creativo
                if ($store->approval_status !== 'approved') {
                    return response()->view('tenant::errors.404-store', [], 404);
                }
            }
            
            // Establecer el tenant actual
            $this->tenantService->setTenant($store);
            
            // Reemplazar el parámetro string con el modelo Store
            $request->route()->setParameter('store', $store);
            
            // Compartir la tienda con todas las vistas
            view()->share('currentStore', $store);
        }
        
        return $next($request);
    }
} 