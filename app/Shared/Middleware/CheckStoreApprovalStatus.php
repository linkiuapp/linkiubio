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
        // Intentar obtener el store del contexto del tenant
        $store = $request->attributes->get('current_store') 
                 ?? $request->route('store') 
                 ?? auth()->user()?->store;
        
        // Si no hay store, continuar
        if (!$store || !is_object($store)) {
            return $next($request);
        }
        
        // Verificar approval_status
        $approvalStatus = $store->approval_status ?? 'approved';
        
        // Si está pendiente de aprobación
        if ($approvalStatus === 'pending_approval') {
            return response()->view('tenant::stores.pending-approval', [
                'store' => $store
            ]);
        }
        
        // Si fue rechazada
        if ($approvalStatus === 'rejected') {
            return response()->view('tenant::stores.rejected', [
                'store' => $store
            ]);
        }
        
        // Si está aprobada, continuar normalmente
        return $next($request);
    }
}

