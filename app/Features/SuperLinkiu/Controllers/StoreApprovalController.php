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

    public function show(Store $store)
    {
        $store->load(['plan', 'businessCategory', 'admins', 'approvedBy']);
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
}

