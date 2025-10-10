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
        
        $stores = $query->paginate(20)->appends(['tab' => $tab]);
        
        $stats = [
            'pending' => Store::where('approval_status', 'pending_approval')->count(),
            'approved_today' => Store::where('approval_status', 'approved')
                ->whereDate('approved_at', today())->count(),
            'rejected_today' => Store::where('approval_status', 'rejected')
                ->whereDate('rejected_at', today())->count(),
        ];
        
        return view('superlinkiu::store-requests.index', compact('stores', 'tab', 'stats'));
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

