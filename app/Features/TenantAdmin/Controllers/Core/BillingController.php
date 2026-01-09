<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Shared\Models\Store;
use App\Shared\Models\Subscription;
use App\Shared\Models\SubscriptionHistory;
use App\Shared\Models\Plan;
use App\Shared\Models\Invoice;
use App\Features\TenantAdmin\Models\Product;
use App\Features\TenantAdmin\Models\Category;
use App\Features\TenantAdmin\Models\ProductVariable;
use App\Features\TenantAdmin\Models\Slider;
use App\Shared\Models\Location;
use App\Features\TenantAdmin\Models\PaymentMethod;
use App\Shared\Models\PlanChangeRequest;
use App\Services\PlanUsageService;
use App\Services\BillingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Shared\Traits\LogsActivity;
use App\Shared\Traits\HandlesErrors;

class BillingController extends Controller
{
    use LogsActivity, HandlesErrors;
    /**
     * Display the billing dashboard
     */
    public function index(Request $request): View
    {
        $store = $request->route('store');
        
        // Verificar que el usuario sea admin de esta tienda
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            abort(403);
        }

        // Obtener o crear suscripción
        $subscription = $store->subscription ?? $this->createDefaultSubscription($store);

        // Obtener planes disponibles
        $availablePlans = Plan::active()->orderBy('price')->get();

        // Usar el nuevo PlanUsageService para calcular uso
        $planUsageService = new PlanUsageService();
        $usage = $planUsageService->calculateUsage($store);
        $limits = $planUsageService->getPlanLimits($store);
        $percentages = $planUsageService->getUsagePercentages($store);
        
        // Preparar datos en el formato que espera la vista
        $planUsage = [];
        foreach ($usage as $resource => $current) {
            $planUsage[$resource] = [
                'current' => $current,
                'limit' => $limits[$resource] ?? 0,
                'percentage' => round($percentages[$resource] ?? 0, 1)
            ];
        }
        
        // Calcular porcentaje general
        $planUsage['overall_percentage'] = $planUsageService->getOverallUsagePercentage($store);

        // Obtener facturas recientes
        $invoices = Invoice::where('store_id', $store->id)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Obtener próxima facturación
        $nextInvoice = $this->getNextInvoiceInfo($subscription);

        // Obtener información de trial period
        $billingService = new BillingService();
        $isInTrial = $billingService->isInTrialPeriod($store);
        $trialDaysRemaining = $billingService->getRemainingTrialDays($store);

        // Obtener solicitudes de cambio pendientes
        $pendingRequests = PlanChangeRequest::forStore($store->id)
            ->with(['currentPlan', 'requestedPlan'])
            ->pending()
            ->orderBy('requested_at', 'desc')
            ->get();

        return view('tenant-admin::Core/billing.index', compact(
            'store',
            'subscription',
            'availablePlans',
            'planUsage',
            'invoices',
            'nextInvoice',
            'pendingRequests',
            'isInTrial',
            'trialDaysRemaining'
        ));
    }

    /**
     * Change subscription plan
     */
    public function changePlan(Request $request): JsonResponse
    {
        $store = $request->route('store');
        
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'reason' => 'nullable|string|max:500',
            'password' => 'required|string'
        ]);

        // Verificar contraseña
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Contraseña incorrecta'
            ], 422);
        }

        $subscription = $store->subscription;
        if (!$subscription || !$subscription->canChangePlan()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede cambiar el plan en este momento'
            ], 422);
        }

        $newPlan = Plan::find($validated['plan_id']);
        
        if ($newPlan->id === $subscription->plan_id) {
            return response()->json([
                'success' => false,
                'message' => 'Ya tienes este plan activo'
            ], 422);
        }

        // Realizar cambio de plan
        $success = $subscription->changePlan($newPlan, $validated['reason']);

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Plan cambiado exitosamente',
                'new_plan' => $newPlan->name,
                'redirect' => route('tenant.admin.billing.index', $store->slug)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al cambiar el plan'
        ], 500);
    }

    /**
     * Change billing cycle
     */
    public function changeBillingCycle(Request $request): JsonResponse
    {
        $store = $request->route('store');
        
        $validated = $request->validate([
            'billing_cycle' => 'required|in:monthly,quarterly,biannual',
            'password' => 'required|string'
        ]);

        // Verificar contraseña
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Contraseña incorrecta'
            ], 422);
        }

        $subscription = $store->subscription;
        if (!$subscription || !$subscription->canChangePlan()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede cambiar el ciclo de facturación en este momento'
            ], 422);
        }

        if ($subscription->billing_cycle === $validated['billing_cycle']) {
            return response()->json([
                'success' => false,
                'message' => 'Ya tienes este ciclo de facturación activo'
            ], 422);
        }

        $success = $subscription->changeBillingCycle($validated['billing_cycle']);

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Ciclo de facturación cambiado exitosamente',
                'new_cycle' => $subscription->billing_cycle_label,
                'redirect' => route('tenant.admin.billing.index', $store->slug)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al cambiar el ciclo de facturación'
        ], 500);
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription(Request $request): JsonResponse
    {
        $store = $request->route('store');
        
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
            'password' => 'required|string'
        ]);

        // Verificar contraseña
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Contraseña incorrecta'
            ], 422);
        }

        $subscription = $store->subscription;
        if (!$subscription || !$subscription->canCancel()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede cancelar la suscripción en este momento'
            ], 422);
        }

        // Cancelar con período de gracia hasta el final del período actual
        try {
            $success = $subscription->cancel($validated['reason'], $subscription->current_period_end);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Suscripción cancelada exitosamente. Mantendrás acceso hasta ' . 
                               $subscription->current_period_end->locale('es')->isoFormat('D [de] MMMM [de] YYYY'),
                    'redirect' => route('tenant.admin.billing.index', $store->slug)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar la suscripción'
            ], 500);
        } catch (\Exception $e) {
            // Capturar error de protección anti-abuso
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Reactivate subscription
     */
    public function reactivateSubscription(Request $request): JsonResponse
    {
        $store = $request->route('store');
        
        $validated = $request->validate([
            'password' => 'required|string'
        ]);

        // Verificar contraseña
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Contraseña incorrecta'
            ], 422);
        }

        $subscription = $store->subscription;
        if (!$subscription || !$subscription->canReactivate()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede reactivar la suscripción en este momento'
            ], 422);
        }

        $success = $subscription->reactivate();

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Suscripción reactivada exitosamente',
                'redirect' => route('tenant.admin.billing.index', $store->slug)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al reactivar la suscripción'
        ], 500);
    }

    /**
     * Download invoice PDF
     */
    public function downloadInvoice(Request $request, $storeSlug, Invoice $invoice)
    {
        $store = $request->route('store');
        
        // Verificar que la factura pertenece a la tienda
        if ($invoice->store_id !== $store->id) {
            abort(404);
        }

        $pdf = Pdf::loadView('tenant-admin::Core/billing.invoice-pdf', compact('invoice', 'store'));
        
        return $pdf->download("Factura_{$invoice->invoice_number}.pdf");
    }

    /**
     * Get usage data for the store
     */
    private function calculateUsage(Store $store): array
    {
        return [
            'products' => Product::where('store_id', $store->id)->count(),
            'categories' => Category::where('store_id', $store->id)->count(),
            'variables' => ProductVariable::where('store_id', $store->id)->count(),
            'sliders' => Slider::where('store_id', $store->id)->count(),
            'locations' => Location::where('store_id', $store->id)->count(),
            'bank_accounts' => PaymentMethod::where('store_id', $store->id)
                ->where('type', 'bank_transfer')
                ->whereHas('bankAccounts')
                ->count(),
            'coupons' => 0, // TODO: Implementar cuando tengamos cupones
            'active_promotions' => 0 // TODO: Implementar cuando tengamos promociones
        ];
    }

    /**
     * Get plan limits
     */
    private function getPlanLimits(Plan $plan): array
    {
        return [
            'products' => $plan->max_products,
            'categories' => $plan->max_categories,
            'variables' => $plan->max_variables ?? intval(($plan->max_products ?? 50) / 3),
            'sliders' => $plan->max_slider,
            'locations' => $plan->max_sedes,
            'bank_accounts' => $plan->max_bank_accounts ?? min($plan->max_sedes ?? 1, 3),
            'coupons' => $plan->max_active_coupons
        ];
    }

    /**
     * Calculate usage percentages
     */
    private function calculatePercentages(array $usage, array $limits): array
    {
        $percentages = [];
        
        foreach ($usage as $key => $value) {
            $limit = $limits[$key] ?? 1;
            $percentages[$key] = $limit > 0 ? min(round(($value / $limit) * 100), 100) : 0;
        }
        
        return $percentages;
    }

    /**
     * Get next invoice information
     */
    private function getNextInvoiceInfo(Subscription $subscription): array
    {
        return [
            'date' => $subscription->next_billing_date,
            'amount' => $subscription->next_billing_amount,
            'plan' => $subscription->plan->name,
            'cycle' => $subscription->billing_cycle_label,
            'days_until' => $subscription->days_until_next_billing
        ];
    }

    /**
     * Create default subscription for stores without one
     */
    private function createDefaultSubscription(Store $store): Subscription
    {
        return Subscription::create([
            'store_id' => $store->id,
            'plan_id' => $store->plan_id,
            'status' => $store->status === 'active' ? Subscription::STATUS_ACTIVE : Subscription::STATUS_SUSPENDED,
            'billing_cycle' => Subscription::BILLING_CYCLE_MONTHLY,
            'current_period_start' => $store->created_at ?? now(),
            'current_period_end' => ($store->created_at ?? now())->addDays(30),
            'next_billing_date' => ($store->created_at ?? now())->addDays(30),
            'next_billing_amount' => $store->plan->getPriceForPeriod('monthly'),
            'metadata' => [
                'created_from_legacy_store' => true,
                'auto_created_at' => now()
            ]
        ]);
    }

    /**
     * Request plan change
     */
    public function requestPlanChange(Request $request): JsonResponse
    {
        $store = $request->route('store');
        
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'billing_period' => 'required|in:monthly,quarterly,semester,annual',
            'reason' => 'nullable|string|max:1000',
            'password' => 'required|string'
        ]);

        // Verificar contraseña
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Contraseña incorrecta'
            ], 422);
        }

        $subscription = $store->subscription;
        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró suscripción activa'
            ], 422);
        }

        $newPlan = Plan::find($validated['plan_id']);
        if ($newPlan->id === $subscription->plan_id) {
            return response()->json([
                'success' => false,
                'message' => 'Ya tienes este plan activo'
            ], 422);
        }

        // Verificar si ya hay una solicitud pendiente
        $existingRequest = PlanChangeRequest::forStore($store->id)
            ->pending()
            ->first();

        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Ya tienes una solicitud de cambio pendiente'
            ], 422);
        }

        // Determinar tipo de cambio
        $isUpgrade = $newPlan->price > $subscription->plan->price;
        $type = $isUpgrade ? PlanChangeRequest::TYPE_UPGRADE : PlanChangeRequest::TYPE_DOWNGRADE;

        // Crear solicitud
        $planChangeRequest = PlanChangeRequest::create([
            'store_id' => $store->id,
            'current_plan_id' => $subscription->plan_id,
            'requested_plan_id' => $newPlan->id,
            'requested_billing_period' => $validated['billing_period'],
            'type' => $type,
            'status' => PlanChangeRequest::STATUS_PENDING,
            'reason' => $validated['reason'],
            'requested_at' => now(),
        ]);

        $message = $isUpgrade 
            ? "Solicitud de mejora a Plan {$newPlan->name} enviada exitosamente. Se procesará en las próximas 24-48 horas."
            : "Solicitud de cambio a Plan {$newPlan->name} enviada exitosamente. Se aplicará al finalizar tu período actual.";

        return response()->json([
            'success' => true,
            'message' => $message,
            'request_id' => $request->id,
            'type' => $type,
        ]);
    }

    /**
     * Mostrar checkout de renovación/pago
     */
    public function checkout(Request $request): View
    {
        $store = $request->route('store');
        
        // Verificar que el usuario sea admin de esta tienda
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            abort(403);
        }

        $subscription = $store->subscription;
        if (!$subscription) {
            return redirect()->route('tenant.admin.billing.index', $store->slug)
                ->with('error', 'No tienes una suscripción activa.');
        }

        $plan = $subscription->plan;
        $billingCycle = $subscription->billing_cycle;
        
        // Calcular monto a pagar
        $amount = $plan->getPriceForPeriod($billingCycle);
        
        // Obtener configuración de pagos
        $paymentSetting = \App\Models\RegistrationPaymentSetting::first();
        
        // Verificar si ePayco está configurado
        $epaycoGateway = \App\Models\PaymentGateway::where('name', 'epayco')
            ->where('is_active', true)
            ->first();
        
        // Calcular días restantes
        $now = now();
        $isInTrial = $subscription->trial_end && $now->lte($subscription->trial_end);
        $endDate = $isInTrial ? $subscription->trial_end : $subscription->current_period_end;
        $daysRemaining = $endDate ? (int) $now->diffInDays($endDate, false) : 0;
        
        // Obtener última factura pendiente si existe
        $pendingInvoice = Invoice::where('store_id', $store->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->first();

        return view('tenant-admin::Core.billing.checkout', compact(
            'store',
            'subscription',
            'plan',
            'billingCycle',
            'amount',
            'paymentSetting',
            'epaycoGateway',
            'isInTrial',
            'daysRemaining',
            'endDate',
            'pendingInvoice'
        ));
    }

    /**
     * Procesar pago de renovación
     */
    public function processPayment(Request $request): JsonResponse
    {
        $store = $request->route('store');
        
        // Verificar que el usuario sea admin de esta tienda
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:transfer,epayco',
            'payment_proof' => 'required_if:payment_method,transfer|file|max:5120|mimes:jpg,jpeg,png,pdf',
        ]);

        $subscription = $store->subscription;
        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes una suscripción activa.'
            ], 422);
        }

        try {
            \DB::beginTransaction();

            $plan = $subscription->plan;
            $amount = $plan->getPriceForPeriod($subscription->billing_cycle);

            // Crear o actualizar factura
            $invoice = Invoice::where('store_id', $store->id)
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$invoice) {
                $invoice = Invoice::create([
                    'store_id' => $store->id,
                    'subscription_id' => $subscription->id,
                    'plan_id' => $plan->id,
                    'amount' => $amount,
                    'period' => $subscription->billing_cycle,
                    'status' => 'pending',
                    'issue_date' => now(),
                    'due_date' => now()->addDays(15),
                    'notes' => 'Renovación de suscripción',
                ]);
            }

            // Procesar según método de pago
            if ($validated['payment_method'] === 'transfer') {
                // Guardar comprobante
                $path = $request->file('payment_proof')->store('payment-proofs/' . $store->id, 'public');
                
                $invoice->update([
                    'status' => 'pending_verification',
                    'metadata' => array_merge($invoice->metadata ?? [], [
                        'payment_method' => 'transfer',
                        'payment_proof' => $path,
                        'uploaded_at' => now()->toIso8601String(),
                        'uploaded_by' => auth()->id(),
                    ])
                ]);

                \DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => '¡Comprobante enviado! Tu pago será verificado en las próximas 24-48 horas.',
                    'redirect' => route('tenant.admin.billing.index', $store->slug)
                ]);
            }

            // Para ePayco, retornar datos para iniciar pago
            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Redirigiendo a pasarela de pago...',
                'epayco_data' => [
                    'invoice_id' => $invoice->id,
                    'amount' => $amount,
                    'description' => "Renovación Plan {$plan->name} - {$store->name}",
                ]
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error procesando pago de renovación', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago. Intenta de nuevo.'
            ], 500);
        }
    }

    /**
     * Iniciar pago con ePayco para renovación
     */
    public function initiateEpaycoPayment(Request $request): JsonResponse
    {
        $store = $request->route('store');
        
        // Verificar permisos
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'epayco_method' => 'required|in:pse,cash',
            'pse_bank_code' => 'required_if:epayco_method,pse',
            'cash_type' => 'required_if:epayco_method,cash',
        ]);

        $subscription = $store->subscription;
        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes una suscripción activa.'
            ], 422);
        }

        try {
            $plan = $subscription->plan;
            $amount = $plan->getPriceForPeriod($subscription->billing_cycle);
            $user = auth()->user();

            // Obtener gateway de ePayco
            $epaycoGateway = \App\Models\PaymentGateway::where('name', 'epayco')
                ->where('is_active', true)
                ->first();

            if (!$epaycoGateway) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pasarela de pagos no disponible.'
                ], 422);
            }

            // Generar referencia única
            $reference = 'REN-' . $store->id . '-' . time() . '-' . uniqid();

            // Crear servicio ePayco
            $epaycoService = new \App\Services\PaymentGateways\EpaycoService($epaycoGateway);

            // Preparar datos del pago
            $paymentData = [
                'reference' => $reference,
                'reference_type' => 'renewal',
                'amount' => $amount,
                'currency' => 'COP',
                'description' => "Renovación Plan {$plan->name} - {$store->name}",
                'email' => $user->email,
                'name' => $user->name,
                'last_name' => '',
                'document' => $store->document_number ?? '',
                'document_type' => $store->document_type ?? 'CC',
                'phone' => $store->phone ?? '',
                'city' => $store->city ?? 'Bogota',
                'response_url' => route('tenant.admin.billing.payment-success', $store->slug),
                'confirmation_url' => route('api.epayco.webhook'),
            ];

            // Guardar referencia en sesión
            session()->put('renewal_payment', [
                'reference' => $reference,
                'store_id' => $store->id,
                'subscription_id' => $subscription->id,
                'amount' => $amount,
            ]);

            // Crear pago según método
            $method = $validated['epayco_method'];
            $bankCode = $validated['pse_bank_code'] ?? null;
            $cashType = $validated['cash_type'] ?? null;

            $result = $epaycoService->createPaymentSession($paymentData, $method, $bankCode, $cashType);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['error'] ?? 'Error al iniciar el pago.'
                ], 422);
            }

            return response()->json([
                'success' => true,
                'checkout_url' => $result['checkout_url'],
            ]);

        } catch (\Exception $e) {
            \Log::error('Error iniciando pago ePayco para renovación', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al iniciar el pago: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Página de éxito de pago
     */
    public function paymentSuccess(Request $request): View
    {
        $store = $request->route('store');
        
        // Verificar permisos
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            abort(403);
        }

        $subscription = $store->subscription;
        $plan = $subscription ? $subscription->plan : null;

        // Obtener referencia de los parámetros o sesión
        $refPayco = $request->input('ref_payco') ?? $request->input('x_ref_payco');
        $renewalData = session()->get('renewal_payment');
        
        // Verificar estado del pago si tenemos referencia
        $paymentStatus = 'unknown';
        $transaction = null;
        
        if ($refPayco || ($renewalData && isset($renewalData['reference']))) {
            $reference = $refPayco ?? $renewalData['reference'];
            $transaction = \App\Models\PaymentGatewayTransaction::where('reference', $reference)
                ->orWhere('transaction_id', $reference)
                ->first();
            
            if ($transaction) {
                $paymentStatus = $transaction->status;
                
                // Si está aprobado, actualizar suscripción
                if ($transaction->isApproved() && $subscription) {
                    $this->renewSubscription($store, $subscription);
                }
            }
        }

        // Limpiar sesión
        session()->forget('renewal_payment');

        return view('tenant-admin::Core.billing.payment-success', compact(
            'store',
            'subscription',
            'plan',
            'paymentStatus',
            'transaction'
        ));
    }

    /**
     * Página de pago pendiente
     */
    public function paymentPending(Request $request): View
    {
        $store = $request->route('store');
        
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            abort(403);
        }

        $subscription = $store->subscription;
        
        return view('tenant-admin::Core.billing.payment-pending', compact('store', 'subscription'));
    }

    /**
     * Página de pago fallido
     */
    public function paymentFailed(Request $request): View
    {
        $store = $request->route('store');
        
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            abort(403);
        }

        $subscription = $store->subscription;
        $errorMessage = $request->input('error') ?? 'El pago no pudo ser procesado.';
        
        return view('tenant-admin::Core.billing.payment-failed', compact('store', 'subscription', 'errorMessage'));
    }

    /**
     * Renovar suscripción después de pago aprobado
     */
    protected function renewSubscription(Store $store, Subscription $subscription): void
    {
        try {
            $plan = $subscription->plan;
            $billingCycle = $subscription->billing_cycle;
            
            // Calcular nuevo período
            $periodDays = match($billingCycle) {
                'monthly' => 30,
                'quarterly' => 90,
                'semester' => 180,
                'annual' => 365,
                default => 30
            };

            $newPeriodStart = now();
            $newPeriodEnd = now()->addDays($periodDays);

            // Actualizar suscripción
            $subscription->update([
                'status' => Subscription::STATUS_ACTIVE,
                'current_period_start' => $newPeriodStart,
                'current_period_end' => $newPeriodEnd,
                'next_billing_date' => $newPeriodEnd,
                'trial_end' => null, // Ya no está en trial
            ]);

            // Crear factura pagada
            Invoice::create([
                'store_id' => $store->id,
                'subscription_id' => $subscription->id,
                'plan_id' => $plan->id,
                'amount' => $plan->getPriceForPeriod($billingCycle),
                'period' => $billingCycle,
                'status' => 'paid',
                'issue_date' => now(),
                'due_date' => now(),
                'paid_date' => now(),
                'notes' => 'Renovación de suscripción - Pago con ePayco',
            ]);

            \Log::info('Suscripción renovada exitosamente', [
                'store_id' => $store->id,
                'subscription_id' => $subscription->id,
                'new_period_end' => $newPeriodEnd,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error renovando suscripción', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Mostrar vista de tienda suspendida
     */
    public function suspended(Request $request): View
    {
        $store = $request->route('store');
        
        // Verificar que el usuario sea admin de esta tienda
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            abort(403);
        }

        // Obtener factura pendiente más antigua
        $pendingInvoice = Invoice::where('store_id', $store->id)
            ->whereIn('status', ['pending', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->first();

        return view('tenant-admin::Core.suspended', compact('store', 'pendingInvoice'));
    }
} 
