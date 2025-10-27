<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\MasterKeyRecoveryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MasterKeyRecoveryController extends Controller
{
    /**
     * Mostrar todas las solicitudes de recuperación
     */
    public function index()
    {
        $requests = MasterKeyRecoveryRequest::with(['store', 'requestedByUser', 'approvedByUser'])
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('superlinkiu::master-key-recovery.index', compact('requests'));
    }

    /**
     * Aprobar una solicitud de recuperación
     */
    public function approve(Request $request, $id)
    {
        $recoveryRequest = MasterKeyRecoveryRequest::findOrFail($id);
        
        if ($recoveryRequest->status !== 'pending') {
            return back()->with('error', 'Esta solicitud ya fue procesada');
        }

        $recoveryRequest->approve(auth()->id());

        Log::info('Master key recovery approved by SuperAdmin', [
            'recovery_request_id' => $recoveryRequest->id,
            'store_id' => $recoveryRequest->store_id,
            'super_admin_id' => auth()->id()
        ]);

        return back()->with('swal_success', '✅ Clave maestra desactivada correctamente. El administrador de la tienda puede crear una nueva.');
    }

    /**
     * Rechazar una solicitud de recuperación
     */
    public function reject(Request $request, $id)
    {
        $recoveryRequest = MasterKeyRecoveryRequest::findOrFail($id);
        
        if ($recoveryRequest->status !== 'pending') {
            return back()->with('error', 'Esta solicitud ya fue procesada');
        }

        $request->validate([
            'reason' => 'nullable|string|max:500'
        ], [
            'reason.max' => 'La razón no puede tener más de 500 caracteres'
        ]);

        $recoveryRequest->reject(auth()->id(), $request->reason);

        Log::info('Master key recovery rejected by SuperAdmin', [
            'recovery_request_id' => $recoveryRequest->id,
            'store_id' => $recoveryRequest->store_id,
            'super_admin_id' => auth()->id(),
            'reason' => $request->reason
        ]);

        return back()->with('swal_success', '❌ Solicitud rechazada');
    }
}

