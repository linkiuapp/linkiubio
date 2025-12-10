<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\PlanChangeRequest;
use Illuminate\Http\Request;

class PlanChangeRequestController extends Controller
{
    /**
     * Mostrar solicitudes de cambio de plan
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $query = PlanChangeRequest::with(['store', 'currentPlan', 'requestedPlan', 'processedBy']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $requests = $query->latest('requested_at')->paginate(15);
        
        // Stats
        $stats = [
            'pending' => PlanChangeRequest::pending()->count(),
            'approved' => PlanChangeRequest::approved()->count(),
            'rejected' => PlanChangeRequest::rejected()->count(),
        ];
        
        return view('superlinkiu::plan-change-requests.index', compact('requests', 'stats', 'status'));
    }

    /**
     * Aprobar solicitud
     */
    public function approve(PlanChangeRequest $planChangeRequest)
    {
        if (!$planChangeRequest->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Esta solicitud ya fue procesada'
            ], 400);
        }

        try {
            $store = $planChangeRequest->store;
            $subscription = $store->subscription;
            
            if (!$subscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'La tienda no tiene suscripción activa'
                ], 400);
            }

            // Cambiar plan
            $subscription->changePlan(
                $planChangeRequest->requestedPlan,
                "Aprobado desde solicitud de cambio - {$planChangeRequest->reason}"
            );
            
            // Cambiar período de facturación si se solicitó
            if ($planChangeRequest->requested_billing_period && $planChangeRequest->requested_billing_period !== $subscription->billing_cycle) {
                $subscription->changeBillingCycle($planChangeRequest->requested_billing_period);
            }

            // Actualizar solicitud
            $planChangeRequest->update([
                'status' => 'approved',
                'processed_at' => now(),
                'processed_by' => auth()->id(),
            ]);

            // Forzar recarga del store con plan
            $store->refresh()->load('plan');

            return response()->json([
                'success' => true,
                'message' => 'Solicitud aprobada exitosamente. Los límites se actualizarán en unos segundos.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error aprobando cambio de plan', [
                'request_id' => $planChangeRequest->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rechazar solicitud
     */
    public function reject(Request $request, PlanChangeRequest $planChangeRequest)
    {
        if (!$planChangeRequest->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Esta solicitud ya fue procesada'
            ], 400);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $planChangeRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['reason'],
            'processed_at' => now(),
            'processed_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Solicitud rechazada'
        ]);
    }
}

