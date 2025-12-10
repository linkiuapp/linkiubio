<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Invoice;
use App\Shared\Models\Store;
use App\Shared\Models\Plan;
use App\Shared\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\BillingAutomationService;
use App\Services\BillingNotificationService;
use App\Shared\Traits\LogsActivity;

class InvoiceController extends Controller
{
    use LogsActivity;
    protected $billingService;
    protected $notificationService;

    public function __construct(
        BillingAutomationService $billingService,
        BillingNotificationService $notificationService
    ) {
        $this->billingService = $billingService;
        $this->notificationService = $notificationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['store', 'plan']);

        // Búsqueda global
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('store', function($storeQuery) use ($search) {
                      $storeQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por tienda
        if ($storeId = $request->get('store_id')) {
            $query->byStore($storeId);
        }

        // Filtro por plan
        if ($planId = $request->get('plan_id')) {
            $query->byPlan($planId);
        }

        // Filtro por estado
        if ($status = $request->get('status')) {
            switch ($status) {
                case 'pending':
                    $query->pending();
                    break;
                case 'paid':
                    $query->paid();
                    break;
                case 'overdue':
                    $query->overdue();
                    break;
                case 'cancelled':
                    $query->cancelled();
                    break;
            }
        }

        // Filtro por período
        if ($period = $request->get('period')) {
            $query->byPeriod($period);
        }

        // Filtro por rango de fechas
        if ($startDate = $request->get('start_date')) {
            $query->whereDate('issue_date', '>=', $startDate);
        }
        if ($endDate = $request->get('end_date')) {
            $query->whereDate('issue_date', '<=', $endDate);
        }

        // Ordenamiento (validado contra lista blanca para prevenir SQL injection)
        $allowedSortColumns = ['created_at', 'issue_date', 'due_date', 'total', 'status', 'invoice_number'];
        $allowedSortOrders = ['asc', 'desc'];
        
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'created_at';
        }
        if (!in_array(strtolower($sortOrder), $allowedSortOrders)) {
            $sortOrder = 'desc';
        }
        
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 12);
        $invoices = $query->paginate($perPage)->withQueryString();

        // Obtener datos para filtros
        $stores = Store::select('id', 'name')->get();
        $plans = Plan::select('id', 'name')->get();

        // Estadísticas rápidas (optimizado: 1 query en lugar de 5)
        $statsQuery = \DB::table('invoices')
            ->whereNull('deleted_at')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "paid" THEN 1 ELSE 0 END) as paid,
                SUM(CASE WHEN status = "overdue" THEN 1 ELSE 0 END) as overdue,
                SUM(CASE WHEN status = "paid" THEN amount ELSE 0 END) as total_amount
            ')
            ->first();

        $stats = [
            'total' => $statsQuery->total ?? 0,
            'pending' => $statsQuery->pending ?? 0,
            'paid' => $statsQuery->paid ?? 0,
            'overdue' => $statsQuery->overdue ?? 0,
            'total_amount' => $statsQuery->total_amount ?? 0,
        ];

        return view('superlinkiu::invoices.index', compact(
            'invoices',
            'stores',
            'plans',
            'stats'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::select('id', 'name', 'plan_id', 'email')
            ->with('plan:id,name,prices')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $plans = Plan::select('id', 'name', 'prices')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('superlinkiu::invoices.create', compact('stores', 'plans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'plan_id' => 'required|exists:plans,id',
            'amount' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    $plan = Plan::find($request->plan_id);
                    $period = $request->period;
                    
                    if ($plan && $period) {
                        $expectedAmount = $plan->getPriceForPeriod($period);
                        
                        if ($expectedAmount && $value < ($expectedAmount * 0.7)) {
                            $fail('El monto es demasiado bajo. El precio esperado para este plan y período es $' . number_format($expectedAmount, 0, ',', '.'));
                        }
                    }
                },
            ],
            'period' => 'required|in:monthly,quarterly,semester',
            'issue_date' => 'required|date|before_or_equal:today',
            'due_date' => 'required|date|after:issue_date',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Validar que no exista factura duplicada para el mismo período
        $issueMonth = Carbon::parse($validated['issue_date'])->format('Y-m');
        $existingInvoice = Invoice::where('store_id', $validated['store_id'])
            ->where('period', $validated['period'])
            ->whereRaw("DATE_FORMAT(issue_date, '%Y-%m') = ?", [$issueMonth])
            ->whereIn('status', ['pending', 'paid', 'overdue'])
            ->first();

        if ($existingInvoice) {
            return back()
                ->withInput()
                ->with('error', 'Ya existe una factura ' . strtolower($existingInvoice->getStatusLabel()) . ' para esta tienda en el período seleccionado (Factura #' . $existingInvoice->invoice_number . ')');
        }

        // Buscar suscripción activa de la tienda
        $store = Store::find($validated['store_id']);
        $subscription = $store->subscription;
        
        // Añadir subscription_id si existe
        if ($subscription) {
            $validated['subscription_id'] = $subscription->id;
        }

        // Añadir metadata
        $validated['metadata'] = [
            'generated_by' => 'super_admin',
            'admin_id' => auth()->id(),
            'generated_from' => 'manual_creation',
        ];

        $invoice = Invoice::create($validated);

        // Si hay suscripción y esta factura es para el próximo período, actualizar fechas
        if ($subscription && $invoice->issue_date >= now()->subDays(7)) {
            $periodDays = match($validated['period']) {
                'monthly' => 30,
                'quarterly' => 90,
                'semester' => 180,
                default => 30
            };
            
            $subscription->update([
                'billing_cycle' => $validated['period'],
                'next_billing_date' => $invoice->due_date->copy()->addDays($periodDays),
                'next_billing_amount' => $validated['amount'],
            ]);
        }

        // Enviar notificación de factura creada (asíncrono)
        \App\Jobs\SendInvoiceNotificationJob::dispatch($invoice, 'created');

        return redirect()
            ->route('superlinkiu.invoices.index')
            ->with('success', 'Factura creada exitosamente: ' . $invoice->invoice_number);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['store', 'plan']);
        
        return view('superlinkiu::invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $stores = Store::select('id', 'name', 'plan_id', 'email')
            ->with('plan:id,name,prices')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $plans = Plan::select('id', 'name', 'prices')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('superlinkiu::invoices.edit', compact('invoice', 'stores', 'plans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:monthly,quarterly,semester',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $invoice->update($validated);

        return redirect()
            ->route('superlinkiu.invoices.show', $invoice)
            ->with('success', 'Factura actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        // Solo permitir eliminar facturas pendientes o canceladas
        if ($invoice->isPaid()) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar una factura pagada. Las facturas pagadas son inmutables por auditoría contable.'
                ], 422);
            }
            return back()->with('error', 'No se puede eliminar una factura pagada.');
        }

        $invoiceNumber = $invoice->invoice_number;
        $invoice->delete(); // Soft delete

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Factura ' . $invoiceNumber . ' eliminada exitosamente.'
            ]);
        }

        return redirect()
            ->route('superlinkiu.invoices.index')
            ->with('success', 'Factura ' . $invoiceNumber . ' eliminada exitosamente.');
    }

    /**
     * Marcar factura como pagada
     */
    public function markAsPaid(Request $request, Invoice $invoice)
    {
        try {
            // Log para debugging
            \Log::info('[INVOICE] markAsPaid iniciado', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'invoice_status' => $invoice->status,
                'store_name' => $invoice->store->name,
                'admin_user' => auth()->user()->name
            ]);

            // Validaciones iniciales
            if ($invoice->isPaid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta factura ya está marcada como pagada.',
                ], 400);
            }

            if ($invoice->isCancelled()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede marcar como pagada una factura cancelada.',
                ], 400);
            }

            $validated = $request->validate([
                'paid_date' => 'nullable|date',
                'payment_notes' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s\.,\-áéíóúñÁÉÍÓÚÑ]+$/'
            ]);

            $paidDate = isset($validated['paid_date']) && $validated['paid_date'] 
                ? Carbon::parse($validated['paid_date']) 
                : now();
            
            // Usar transacción para asegurar atomicidad
            $automationResults = \DB::transaction(function() use ($invoice, $paidDate, $validated) {
                // 1. Marcar factura como pagada
                $result = $invoice->markAsPaid($paidDate);
                
                if (!$result) {
                    \Log::error('[INVOICE] Error al marcar factura como pagada', ['invoice_id' => $invoice->id]);
                    throw new \Exception('Error al actualizar el estado de la factura.');
                }
                
                // Log de auditoría para pago de factura (acción crítica financiera)
                $this->logActivity('invoice_marked_as_paid', $invoice, [
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->amount,
                    'store_name' => $invoice->store->name,
                    'paid_date' => $paidDate->toDateString(),
                    'payment_notes' => $validated['payment_notes'] ?? null
                ]);

                // 2. Agregar notas de pago si se proporcionaron
                if (!empty($validated['payment_notes'])) {
                    $currentMetadata = $invoice->metadata ?? [];
                    $currentMetadata['payment_notes'] = $validated['payment_notes'];
                    $currentMetadata['processed_by'] = auth()->user()->name;
                    $currentMetadata['processed_at'] = now()->toISOString();
                    $invoice->update(['metadata' => $currentMetadata]);
                }

                \Log::info('[INVOICE] Factura marcada como pagada exitosamente', [
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'new_status' => $invoice->status
                ]);

                // 3. Procesar confirmación de pago automática (usando BillingAutomationService)
                $results = $this->billingService->processPaymentConfirmation($invoice);
                
                \Log::info('[BILLING] Automatización de pago procesada', [
                    'invoice_id' => $invoice->id,
                    'automation_results' => $results
                ]);
                
                return $results;
            });

            // 4. Recargar la factura para obtener los datos actualizados
            $invoice->refresh();

            // 5. Enviar notificación de pago recibido (asíncrono)
            \App\Jobs\SendInvoiceNotificationJob::dispatch($invoice, 'payment_received');

            // 6. Si la tienda fue reactivada, enviar notificación de reactivación (asíncrono)
            if ($automationResults['store_reactivated'] ?? false) {
                // Despachar notificación de reactivación si existe un job para eso
                \Log::info('[STORE] Tienda reactivada automáticamente', [
                    'store_id' => $invoice->store->id,
                    'store_name' => $invoice->store->name
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Factura procesada exitosamente.',
                'details' => $this->getPaymentProcessingDetails($invoice, $automationResults),
                'status' => $invoice->getStatusLabel(),
                'status_color' => $invoice->getStatusColor(),
                'paid_date' => $invoice->paid_date ? $invoice->paid_date->format('d/m/Y H:i') : null,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('[INVOICE] Error de validación en markAsPaid', [
                'invoice_id' => $invoice->id,
                'errors' => $e->errors()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('💥 Error crítico al marcar factura como pagada', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage(),
                'error_details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get payment processing details for response
     */
    private function getPaymentProcessingDetails(Invoice $invoice, array $automationResults): array
    {
        $details = [
            'invoice_number' => $invoice->invoice_number,
            'amount' => $invoice->getFormattedAmount(),
            'store_name' => $invoice->store->name,
            'actions_performed' => []
        ];

        if ($automationResults['subscription_updated'] ?? false) {
            $details['actions_performed'][] = 'Suscripción actualizada';
        }

        if ($automationResults['store_reactivated'] ?? false) {
            $details['actions_performed'][] = 'Tienda reactivada automáticamente';
        }

        if ($automationResults['next_invoice_scheduled'] ?? false) {
            $details['actions_performed'][] = 'Próxima facturación programada';
        }

        $details['actions_performed'][] = 'Notificaciones enviadas';

        return $details;
    }

    /**
     * Cancelar factura
     */
    public function cancel(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $invoice->cancel($validated['reason'] ?? null);

        return response()->json([
            'success' => true,
            'message' => 'Factura cancelada exitosamente.',
            'status' => $invoice->getStatusLabel(),
            'status_color' => $invoice->getStatusColor(),
        ]);
    }

    /**
     * Generar factura automática para una tienda
     */
    public function generateForStore(Request $request, Store $store)
    {
        $validated = $request->validate([
            'period' => 'required|in:monthly,quarterly,semester',
            'issue_date' => 'nullable|date',
        ]);

        $issueDate = $validated['issue_date'] ? Carbon::parse($validated['issue_date']) : now();
        $dueDate = $issueDate->copy()->addDays(15); // 15 días para pagar

        // Calcular el monto según el período
        $amount = $store->plan->getPriceForPeriod($validated['period']);
        
        if (!$amount) {
            return back()->with('error', 'No se pudo determinar el precio para el período seleccionado.');
        }

        // Buscar suscripción activa de la tienda
        $subscription = $store->subscription;
        
        $invoice = Invoice::create([
            'store_id' => $store->id,
            'subscription_id' => $subscription ? $subscription->id : null,
            'plan_id' => $store->plan_id,
            'amount' => $amount,
            'period' => $validated['period'],
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'notes' => 'Factura generada automáticamente desde SuperAdmin',
            'metadata' => [
                'generated_by' => 'super_admin',
                'admin_id' => auth()->id(),
                'generated_from' => 'manual',
            ]
        ]);

        // Si hay suscripción, actualizar su próxima fecha de facturación
        if ($subscription) {
            $periodDays = match($validated['period']) {
                'monthly' => 30,
                'quarterly' => 90,
                'semester' => 180,
                default => 30
            };
            
            $subscription->update([
                'next_billing_date' => $issueDate->copy()->addDays($periodDays)->toDateString(),
                'next_billing_amount' => $amount,
            ]);
        }

        // Enviar notificación de factura creada (asíncrono)
        \App\Jobs\SendInvoiceNotificationJob::dispatch($invoice, 'created');

        return redirect()
            ->route('superlinkiu.invoices.show', $invoice)
            ->with('success', 'Factura generada exitosamente: ' . $invoice->invoice_number);
    }

    /**
     * Actualizar facturas vencidas
     */
    public function updateOverdueInvoices()
    {
        $overdueCount = Invoice::where('status', 'pending')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);

        return response()->json([
            'success' => true,
            'message' => "{$overdueCount} facturas marcadas como vencidas.",
            'count' => $overdueCount,
        ]);
    }

    /**
     * Obtener estadísticas de facturación
     */
    public function getStats()
    {
        $stats = [
            'total_invoices' => Invoice::count(),
            'pending_invoices' => Invoice::pending()->count(),
            'paid_invoices' => Invoice::paid()->count(),
            'overdue_invoices' => Invoice::overdue()->count(),
            'cancelled_invoices' => Invoice::cancelled()->count(),
            'total_revenue' => Invoice::paid()->sum('amount'),
            'pending_revenue' => Invoice::pending()->sum('amount'),
            'overdue_revenue' => Invoice::overdue()->sum('amount'),
            'monthly_revenue' => Invoice::paid()
                ->whereMonth('paid_date', now()->month)
                ->whereYear('paid_date', now()->year)
                ->sum('amount'),
        ];

        return response()->json($stats);
    }

    /**
     * Send invoice created notification email
     */
    private function sendInvoiceCreatedNotification(Invoice $invoice): void
    {
        try {
            // Cargar relaciones necesarias
            $invoice->load(['store.admins', 'plan']);
            
            // Obtener el email del primer admin de la tienda
            $storeAdmin = $invoice->store->admins()->first();
            
            if (!$storeAdmin) {
                \Log::warning('No se pudo enviar email de factura: sin admin', [
                    'invoice_id' => $invoice->id,
                    'store_id' => $invoice->store_id
                ]);
                return;
            }
            
            // Obtener configuración de SendGrid
            $emailConfig = \App\Models\EmailConfiguration::getActive();
            
            if (!$emailConfig || !$emailConfig->template_invoice_generated) {
                \Log::warning('No se pudo enviar email de factura: template no configurado');
                return;
            }
            
            // Preparar datos para el template
            $emailData = [
                'first_name' => explode(' ', $storeAdmin->name)[0], // Primer nombre
                'invoice_number' => $invoice->invoice_number,
                'amount' => '$' . number_format($invoice->amount, 0, ',', '.'),
                'due_date' => $invoice->due_date->format('d/m/Y'),
                'store_name' => $invoice->store->name,
                'invoice_url' => route('tenant.admin.invoices.show', [
                    'store' => $invoice->store->slug,
                    'invoice' => $invoice->id
                ])
            ];
            
            // Enviar email usando SendGrid
            $sendGridService = new \App\Services\SendGridEmailService();
            $result = $sendGridService->sendWithTemplate(
                $emailConfig->template_invoice_generated,
                $storeAdmin->email,
                $emailData,
                $storeAdmin->name,
                'billing' // Categoría para usar facturas@linkiu.email
            );
            
            if ($result['success']) {
                \Log::info('Email de factura enviado exitosamente', [
                    'invoice_number' => $invoice->invoice_number,
                    'to' => $storeAdmin->email
                ]);
            } else {
                \Log::error('Error enviando email de factura', [
                    'invoice_number' => $invoice->invoice_number,
                    'error' => $result['message']
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Error sending invoice created notification', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);
        }
    }

} 