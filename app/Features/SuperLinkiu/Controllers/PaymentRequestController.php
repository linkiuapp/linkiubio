<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Invoice;
use App\Shared\Models\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentRequestController extends Controller
{
    /**
     * Display a listing of payment requests (invoices with payment proof uploaded)
     */
    public function index(Request $request): View
    {
        $query = Invoice::with(['store', 'plan'])
            ->where('status', 'pending')
            ->whereNotNull('metadata->payment_proof')
            ->where('metadata->payment_proof_uploaded', true)
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('store', function($storeQuery) use ($search) {
                      $storeQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('store_id')) {
            $query->where('store_id', $request->get('store_id'));
        }

        // Paginación
        $perPage = $request->get('per_page', 15);
        $paymentRequests = $query->paginate($perPage)->withQueryString();

        // Obtener datos para filtros
        $stores = Store::select('id', 'name')->orderBy('name')->get();

        // Estadísticas
        $totalPending = Invoice::where('status', 'pending')
            ->whereNotNull('metadata->payment_proof')
            ->where('metadata->payment_proof_uploaded', true)
            ->count();

        $stats = [
            'total_pending' => $totalPending,
        ];

        return view('superlinkiu::payment-requests.index', compact(
            'paymentRequests',
            'stores',
            'stats'
        ));
    }

    /**
     * Show payment proof and invoice details
     */
    public function show(Invoice $invoice): View
    {
        $invoice->load(['store', 'plan']);

        // Verificar que tiene comprobante de pago
        if (!$invoice->metadata || !isset($invoice->metadata['payment_proof'])) {
            abort(404, 'Esta factura no tiene comprobante de pago asociado');
        }

        return view('superlinkiu::payment-requests.show', compact('invoice'));
    }

    /**
     * Approve payment request (mark invoice as paid)
     */
    public function approve(Request $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validate([
            'paid_date' => 'nullable|date',
            'payment_notes' => 'nullable|string|max:500',
        ]);

        try {
            // Cargar relaciones necesarias ANTES de la transacción
            $invoice->load(['store', 'store.subscription', 'subscription']);

            // Validaciones iniciales
            if ($invoice->isPaid()) {
                return redirect()
                    ->back()
                    ->with('error', 'Esta factura ya está marcada como pagada.');
            }

            if ($invoice->isCancelled()) {
                return redirect()
                    ->back()
                    ->with('error', 'No se puede marcar como pagada una factura cancelada.');
            }

            // Guardar estado inicial para logs
            $storeInitialStatus = $invoice->store->status ?? 'unknown';
            $storeInitialReason = $invoice->store->suspension_reason ?? null;
            $subscriptionInitialStatus = $invoice->store->subscription->status ?? 'unknown';

            $paidDate = isset($validated['paid_date']) && $validated['paid_date'] 
                ? Carbon::parse($validated['paid_date']) 
                : now();

            // Usar transacción para asegurar atomicidad y capturar resultados
            $automationResults = DB::transaction(function() use ($invoice, $paidDate, $validated) {
                // Marcar factura como pagada
                $result = $invoice->markAsPaid($paidDate);
                
                if (!$result) {
                    throw new \Exception('Error al actualizar el estado de la factura.');
                }
                
                // Recargar la factura para asegurar que el status esté actualizado
                $invoice->refresh();
                
                // Agregar notas de pago si se proporcionaron
                if (!empty($validated['payment_notes'])) {
                    $currentMetadata = $invoice->metadata ?? [];
                    $currentMetadata['payment_notes'] = $validated['payment_notes'];
                    $currentMetadata['processed_by'] = auth()->user()->name;
                    $currentMetadata['processed_at'] = now()->toISOString();
                    $invoice->update(['metadata' => $currentMetadata]);
                }

                // Recargar relaciones antes de procesar automatización
                $invoice->load(['store', 'store.subscription', 'subscription']);

                // Procesar confirmación de pago automática
                $billingService = app(\App\Services\BillingAutomationService::class);
                return $billingService->processPaymentConfirmation($invoice);
            });

            // Recargar todas las relaciones después de la transacción
            $invoice->refresh();
            $invoice->load(['store', 'store.subscription', 'subscription']);
            $store = $invoice->store->fresh();
            $subscription = $store->subscription ?? null;

            // Si la tienda NO fue reactivada automáticamente pero debería, intentar reactivarla manualmente
            if (($automationResults['store_reactivated'] ?? false) === false && $store && $store->status === 'suspended') {
                // Verificar razones relacionadas con facturación
                $billingRelatedReasons = ['billing_overdue', 'subscription_suspended', 'trial_expired_no_payment'];
                $isBillingRelated = empty($store->suspension_reason) || in_array($store->suspension_reason, $billingRelatedReasons);
                
                if ($isBillingRelated) {
                    // Verificar que NO tenga otras facturas pendientes (excluyendo la actual)
                    $hasOtherPendingInvoices = Invoice::where('store_id', $store->id)
                        ->where('id', '!=', $invoice->id)
                        ->whereIn('status', ['overdue', 'pending'])
                        ->where('due_date', '<', now())
                        ->exists();

                    if (!$hasOtherPendingInvoices) {
                        // Reactivar manualmente
                        DB::transaction(function() use ($store, $subscription) {
                            $store->update([
                                'status' => 'active',
                                'suspension_reason' => null,
                                'suspended_at' => null,
                                'suspended_invoice_id' => null,
                                'reactivated_at' => now()
                            ]);

                            // Reactivar suscripción también si está suspendida
                            if ($subscription && $subscription->status === \App\Shared\Models\Subscription::STATUS_SUSPENDED) {
                                $subscription->update([
                                    'status' => \App\Shared\Models\Subscription::STATUS_ACTIVE,
                                    'grace_period_end' => null,
                                    'metadata' => array_merge($subscription->metadata ?? [], [
                                        'reactivated_by_payment' => true,
                                        'reactivated_at' => now()->toISOString(),
                                        'auto_reactivated' => true,
                                        'reactivated_from_payment_request' => true
                                    ])
                                ]);
                            }
                        });

                        Log::info('✅ Tienda reactivada manualmente después de aprobar pago desde Solicitudes de Pago', [
                            'store_id' => $store->id,
                            'store_name' => $store->name,
                            'invoice_id' => $invoice->id,
                            'suspension_reason_was' => $storeInitialReason,
                        ]);

                        // Recargar nuevamente
                        $store->refresh();
                        $automationResults['store_reactivated'] = true;
                    }
                }
            }

            // Log detallado
            Log::info('✅ Pago aprobado desde Solicitudes de Pago', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'store_id' => $invoice->store_id,
                'paid_date' => $paidDate->toDateString(),
                'automation_results' => $automationResults,
                'store_status_before' => $storeInitialStatus,
                'store_status_after' => $store->status ?? 'unknown',
                'store_suspension_reason_before' => $storeInitialReason,
                'store_suspension_reason_after' => $store->suspension_reason ?? null,
                'subscription_status_before' => $subscriptionInitialStatus,
                'subscription_status_after' => $subscription->status ?? 'unknown',
            ]);

            return redirect()
                ->route('superlinkiu.payment-requests.index')
                ->with('success', "Pago de la factura #{$invoice->invoice_number} aprobado exitosamente." . 
                    ($automationResults['store_reactivated'] ?? false ? ' La tienda ha sido reactivada.' : ''));
        } catch (\Exception $e) {
            Log::error('❌ Error al aprobar solicitud de pago', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Error al aprobar el pago: ' . $e->getMessage());
        }
    }

    /**
     * Reject payment request (add note and keep as pending)
     */
    public function reject(Request $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            $metadata = $invoice->metadata ?? [];
            $metadata['rejection_reason'] = $validated['rejection_reason'];
            $metadata['rejected_at'] = now()->toIso8601String();
            $metadata['rejected_by'] = auth()->id();
            $metadata['rejection_count'] = ($metadata['rejection_count'] ?? 0) + 1;

            $invoice->update(['metadata' => $metadata]);

            Log::info('❌ Solicitud de pago rechazada', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'store_id' => $invoice->store_id,
                'reason' => $validated['rejection_reason'],
            ]);

            return redirect()
                ->route('superlinkiu.payment-requests.index')
                ->with('success', "Solicitud de pago de la factura #{$invoice->invoice_number} rechazada.");
        } catch (\Exception $e) {
            Log::error('❌ Error al rechazar solicitud de pago', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Error al rechazar la solicitud: ' . $e->getMessage());
        }
    }

    /**
     * Download payment proof file
     */
    public function downloadProof(Invoice $invoice)
    {
        if (!$invoice->metadata || !isset($invoice->metadata['payment_proof'])) {
            abort(404, 'Comprobante de pago no encontrado');
        }

        $proofPath = $invoice->metadata['payment_proof'];

        if (!Storage::disk('public')->exists($proofPath)) {
            abort(404, 'Archivo de comprobante no encontrado');
        }

        return Storage::disk('public')->download($proofPath);
    }
}
