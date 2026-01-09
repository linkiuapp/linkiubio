<?php

namespace App\Shared\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreSuspensionStatus
{
    /**
     * Rutas que deben ser accesibles incluso cuando la tienda está suspendida
     */
    protected array $allowedRoutes = [
        'tenant.admin.billing.index',
        'tenant.admin.billing.checkout',
        'tenant.admin.billing.process-payment',
        'tenant.admin.billing.initiate-epayco',
        'tenant.admin.billing.payment-success',
        'tenant.admin.billing.payment-pending',
        'tenant.admin.billing.payment-failed',
        'tenant.admin.logout',
        'tenant.admin.profile.index',
        'tenant.admin.suspended',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Intentar obtener el store del contexto del tenant
        $store = $request->attributes->get('current_store') 
                 ?? $request->route('store') 
                 ?? auth()->user()?->store;
        
        // Si no hay store, continuar
        if (!$store || !is_object($store)) {
            return $next($request);
        }
        
        // Verificar si la tienda está suspendida
        if ($store->status === 'suspended') {
            // Obtener el nombre de la ruta actual
            $currentRoute = $request->route()?->getName();
            
            // Permitir acceso a rutas esenciales
            if ($currentRoute && in_array($currentRoute, $this->allowedRoutes)) {
                return $next($request);
            }
            
            // Verificar si es una solicitud AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tu tienda está suspendida. Por favor, regulariza tu situación de pago.',
                    'suspended' => true,
                    'redirect' => route('tenant.admin.suspended', $store->slug)
                ], 403);
            }
            
            // Redirigir a la vista de suspensión
            return redirect()->route('tenant.admin.suspended', $store->slug);
        }
        
        return $next($request);
    }
}
