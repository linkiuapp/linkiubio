<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\BusinessCategory;
use App\Features\SuperLinkiu\Requests\ApproveStoreRequest;
use App\Features\SuperLinkiu\Requests\RejectStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreApprovalController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'pending');
        
        $query = Store::with(['plan', 'businessCategory', 'admins']);
        
        // ✅ Filtro por tab (pending/approved/rejected)
        switch ($tab) {
            case 'pending':
                $query->where('approval_status', 'pending_approval')
                    ->orderBy('created_at', 'asc');
                break;
            case 'approved':
                $query->where('approval_status', 'approved')
                    ->orderBy('approved_at', 'desc');
                break;
            case 'rejected':
                $query->where('approval_status', 'rejected')
                    ->orderBy('rejected_at', 'desc');
                break;
        }
        
        // ✅ Búsqueda por nombre, documento o email
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('business_document_number', 'like', "%{$search}%")
                  ->orWhere('business_type', 'like', "%{$search}%")
                  ->orWhereHas('admins', function($adminQuery) use ($search) {
                      $adminQuery->where('email', 'like', "%{$search}%")
                                 ->orWhere('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // ✅ Filtro por categoría
        if ($categoryId = $request->get('category')) {
            $query->where('business_category_id', $categoryId);
        }
        
        // ✅ Filtro por tiempo de espera (solo para pending)
        if ($tab === 'pending' && $urgency = $request->get('urgency')) {
            $now = now();
            switch ($urgency) {
                case 'critical': // >24h
                    $query->where('created_at', '<', $now->copy()->subHours(24));
                    break;
                case 'urgent': // 6-24h
                    $query->whereBetween('created_at', [
                        $now->copy()->subHours(24),
                        $now->copy()->subHours(6)
                    ]);
                    break;
                case 'normal': // <6h
                    $query->where('created_at', '>', $now->copy()->subHours(6));
                    break;
            }
        }
        
        // ✅ Filtro por rango de fechas
        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        
        $stores = $query->paginate(20)->appends($request->except('page'));
        
        // Estadísticas
        $pendingCount = Store::where('approval_status', 'pending_approval')->count();
        $approvedCount = Store::where('approval_status', 'approved')->count();
        $rejectedCount = Store::where('approval_status', 'rejected')->count();
        
        // Categorías para filtros
        $categories = BusinessCategory::active()->ordered()->get();
        
        return view('superlinkiu::store-requests.index', compact(
            'stores', 
            'tab', 
            'pendingCount', 
            'approvedCount', 
            'rejectedCount',
            'categories'
        ));
    }

    public function show($storeId)
    {
        $store = Store::with(['plan', 'businessCategory', 'admins', 'approvedBy'])->findOrFail($storeId);
        $categories = BusinessCategory::active()->ordered()->get();
        
        return view('superlinkiu::store-requests.show', compact('store', 'categories'));
    }

    public function approve(ApproveStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $store = Store::findOrFail($request->store_id);
            
            // ✅ LOG: Aprobación de tienda
            \Log::info('✅ STORE APPROVAL: Aprobando tienda manualmente', [
                'store_id' => $store->id,
                'store_name' => $store->name,
                'business_type' => $store->business_type,
                'business_document_type' => $store->business_document_type,
                'business_document_number' => $store->business_document_number,
                'business_category_id' => $request->business_category_id,
                'approved_by' => auth()->user()->email,
                'admin_notes' => $request->admin_notes,
                'time_pending_hours' => $store->created_at->diffInHours(now())
            ]);
            
            $store->update([
                'approval_status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
                'business_category_id' => $request->business_category_id,
                'admin_notes' => $request->admin_notes,
                'verified' => $request->boolean('mark_as_verified', false)
            ]);
            
            if ($request->filled('plan_id')) {
                $store->update(['plan_id' => $request->plan_id]);
                
                \Log::info('📋 STORE APPROVAL: Plan actualizado', [
                    'store_id' => $store->id,
                    'new_plan_id' => $request->plan_id
                ]);
            }
            
            // Generar factura si no existe ya
            $this->generateInvoiceForApprovedStore($store);
            
            DB::commit();
            
            // Enviar email si se solicitó
            if ($request->boolean('send_welcome_email', true)) {
                $admin = $store->admins()->first();
                if ($admin) {
                    \App\Jobs\SendEmailJob::dispatch('template', $admin->email, [
                        'template_key' => 'store_approved',
                        'variables' => [
                            'first_name' => $admin->name,
                            'admin_name' => $admin->name,
                            'store_name' => $store->name,
                            'admin_email' => $admin->email,
                            'password' => '(contraseña ya establecida)',
                            'login_url' => route('tenant.admin.login', $store->slug),
                            'store_url' => url($store->slug),
                            'plan_name' => $store->plan->name ?? 'Explorer',
                            'support_email' => 'soporte@linkiu.bio'
                        ]
                    ]);
                }
            }
            
            return redirect()
                ->route('superlinkiu.store-requests.index', ['tab' => 'pending'])
                ->with('success', "Tienda '{$store->name}' aprobada exitosamente.");
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al aprobar tienda: ' . $e->getMessage());
        }
    }

    public function reject(RejectStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $store = Store::findOrFail($request->store_id);
            
            $reapplyDays = $request->boolean('allow_reapply', true) ? 15 : null;
            
            // ❌ LOG: Rechazo de tienda
            \Log::warning('❌ STORE REJECTION: Rechazando tienda', [
                'store_id' => $store->id,
                'store_name' => $store->name,
                'business_type' => $store->business_type,
                'business_document_type' => $store->business_document_type,
                'business_document_number' => $store->business_document_number,
                'rejection_reason' => $request->rejection_reason,
                'rejection_message' => $request->rejection_message,
                'allow_reapply' => $request->boolean('allow_reapply', true),
                'can_reapply_at' => $reapplyDays ? now()->addDays($reapplyDays)->format('Y-m-d') : null,
                'rejected_by' => auth()->user()->email,
                'time_pending_hours' => $store->created_at->diffInHours(now())
            ]);
            
            $store->update([
                'approval_status' => 'rejected',
                'rejected_at' => now(),
                'rejection_reason' => $request->rejection_reason,
                'rejection_message' => $request->rejection_message,
                'can_reapply_at' => $reapplyDays ? now()->addDays($reapplyDays) : null
            ]);
            
            DB::commit();
            
            // Enviar email de rechazo
            $admin = $store->admins()->first();
            if ($admin) {
                \App\Jobs\SendEmailJob::dispatch('template', $admin->email, [
                    'template_key' => 'store_rejected',
                    'variables' => [
                        'first_name' => $admin->name,
                        'admin_name' => $admin->name,
                        'store_name' => $store->name,
                        'rejection_reason' => $this->getRejectionReasonLabel($request->rejection_reason),
                        'rejection_message' => $request->rejection_message ?? '',
                        'can_reapply_date' => $store->can_reapply_at?->format('d/m/Y') ?? 'No disponible',
                        'appeal_email' => 'soporte@linkiu.bio'
                    ]
                ]);
            }
            
            return redirect()
                ->route('superlinkiu.store-requests.index', ['tab' => 'pending'])
                ->with('success', "Tienda '{$store->name}' rechazada.");
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al rechazar tienda: ' . $e->getMessage());
        }
    }

    private function getRejectionReasonLabel(string $reason): string
    {
        return match($reason) {
            'rut_invalido' => 'Documento inválido o no verificable',
            'tipo_no_permitido' => 'Tipo de negocio no permitido en la plataforma',
            'informacion_incompleta' => 'Información incompleta o inconsistente',
            'duplicado' => 'Ya existe una tienda registrada con estos datos',
            'otro' => 'Otro motivo (ver mensaje)',
            default => ucfirst(str_replace('_', ' ', $reason))
        };
    }

    /**
     * Generar factura para tienda aprobada manualmente
     */
    private function generateInvoiceForApprovedStore(Store $store): void
    {
        try {
            // Verificar si ya tiene factura
            if ($store->invoices()->exists()) {
                \Log::info('📋 STORE APPROVAL: Tienda ya tiene factura, no se genera nueva', [
                    'store_id' => $store->id
                ]);
                return;
            }

            // Verificar que tenga plan
            if (!$store->plan_id || !$store->plan) {
                \Log::warning('📋 STORE APPROVAL: Tienda sin plan, no se puede generar factura', [
                    'store_id' => $store->id
                ]);
                return;
            }

            // Crear suscripción si no existe
            if (!$store->subscription) {
                $billingCycle = request('billing_period', 'monthly');
                $periodStart = now();
                $periodDays = match($billingCycle) {
                    'monthly' => 30,
                    'quarterly' => 90,
                    'biannual' => 180,
                    default => 30
                };
                $periodEnd = $periodStart->copy()->addDays($periodDays);

                $subscription = \App\Shared\Models\Subscription::create([
                    'store_id' => $store->id,
                    'plan_id' => $store->plan_id,
                    'status' => \App\Shared\Models\Subscription::STATUS_ACTIVE,
                    'billing_cycle' => $billingCycle,
                    'current_period_start' => $periodStart->toDateString(),
                    'current_period_end' => $periodEnd->toDateString(),
                    'next_billing_date' => $periodEnd->toDateString(),
                    'next_billing_amount' => $store->plan->getPriceForPeriod($billingCycle),
                    'metadata' => [
                        'created_from' => 'manual_approval',
                        'approved_by' => auth()->id()
                    ]
                ]);
            } else {
                $subscription = $store->subscription;
                $billingCycle = $subscription->billing_cycle;
            }

            // Generar factura
            $issueDate = now();
            $dueDate = $issueDate->copy()->addDays(15);
            $amount = $store->plan->getPriceForPeriod($billingCycle);

            $invoice = \App\Shared\Models\Invoice::create([
                'store_id' => $store->id,
                'subscription_id' => $subscription->id,
                'plan_id' => $store->plan_id,
                'amount' => $amount,
                'period' => $billingCycle,
                'status' => 'pending',
                'issue_date' => $issueDate->toDateString(),
                'due_date' => $dueDate->toDateString(),
                'notes' => 'Factura generada tras aprobación manual de tienda',
                'metadata' => [
                    'generated_from' => 'manual_approval',
                    'approved_by' => auth()->id()
                ]
            ]);

            // Enviar email de factura generada
            $storeAdmin = $store->admins()->first();
            if ($storeAdmin) {
                \App\Jobs\SendEmailJob::dispatch('template', $storeAdmin->email, [
                    'template_key' => 'invoice_generated',
                    'variables' => [
                        'first_name' => explode(' ', $storeAdmin->name)[0],
                        'invoice_number' => $invoice->invoice_number,
                        'amount' => '$' . number_format($invoice->amount, 0, ',', '.'),
                        'due_date' => $invoice->due_date->format('d/m/Y'),
                        'store_name' => $store->name,
                        'invoice_url' => route('tenant.admin.invoices.show', [
                            'store' => $store->slug,
                            'invoice' => $invoice->id
                        ])
                    ]
                ]);
            }

            \Log::info('✅ STORE APPROVAL: Factura generada y email enviado', [
                'store_id' => $store->id,
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'amount' => $amount
            ]);

        } catch (\Exception $e) {
            \Log::error('❌ STORE APPROVAL: Error generando factura', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}

