<?php

namespace App\Shared\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStoreApprovalStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $store = $request->route('store');
        
        // Si no hay store o no es un objeto Store, continuar
        if (!$store || !is_object($store) || !method_exists($store, 'getAttribute')) {
            return $next($request);
        }
        
        // Verificar approval_status
        $approvalStatus = $store->approval_status ?? 'approved';
        
        // Si está pendiente de aprobación
        if ($approvalStatus === 'pending_approval') {
            return redirect()
                ->route('tenant.store-pending')
                ->with('store', $store);
        }
        
        // Si fue rechazada
        if ($approvalStatus === 'rejected') {
            return redirect()
                ->route('tenant.store-rejected')
                ->with('store', $store);
        }
        
        // Si está aprobada, continuar normalmente
        return $next($request);
    }
}

