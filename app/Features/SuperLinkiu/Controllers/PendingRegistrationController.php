<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PendingRegistration;
use App\Shared\Models\Store;
use App\Shared\Models\User;
use App\Services\BillingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PendingRegistrationController extends Controller
{
    /**
     * Mostrar registros pendientes
     */
    public function index(Request $request)
    {
        $query = PendingRegistration::with(['plan', 'category']);

        // Filtrar por estado
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        } else {
            // Por defecto solo mostrar pendientes
            $query->pending();
        }

        // Ordenar por más recientes
        $registrations = $query->latest()->paginate(15);

        // Stats
        $stats = [
            'pending' => PendingRegistration::pending()->count(),
            'approved' => PendingRegistration::approved()->count(),
            'rejected' => PendingRegistration::rejected()->count(),
        ];

        return view('superlinkiu::pending-registrations.index', compact('registrations', 'stats'));
    }

    /**
     * Ver detalle de un registro
     */
    public function show(PendingRegistration $pendingRegistration)
    {
        $pendingRegistration->load(['plan', 'category', 'processedBy', 'createdStore']);
        
        return view('superlinkiu::pending-registrations.show', compact('pendingRegistration'));
    }

    /**
     * Aprobar registro y crear tienda
     */
    public function approve(PendingRegistration $pendingRegistration)
    {
        if (!$pendingRegistration->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Este registro ya fue procesado'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Verificar si el slug ya existe y generar uno único
            $slug = $pendingRegistration->slug;
            $counter = 1;
            while (Store::where('slug', $slug)->exists()) {
                $slug = $pendingRegistration->slug . '-' . $counter;
                $counter++;
            }

            // Verificar si la categoría requiere aprobación manual
            $category = \App\Shared\Models\BusinessCategory::find($pendingRegistration->business_category_id);
            
            // 1. Crear tienda primero
            $store = Store::create([
                'name' => $pendingRegistration->store_name,
                'slug' => $slug,
                'plan_id' => $pendingRegistration->plan_id,
                'business_category_id' => $pendingRegistration->business_category_id,
                'email' => $pendingRegistration->email,
                'phone' => $pendingRegistration->phone,
                'city' => $pendingRegistration->city,
                'department' => $pendingRegistration->department,
                'country' => 'Colombia',
                'address' => $pendingRegistration->address,
                'description' => $pendingRegistration->store_description,
                'document_type' => $pendingRegistration->document_type,
                'document_number' => $pendingRegistration->document_number,
                'meta_title' => $pendingRegistration->meta_title,
                'meta_description' => $pendingRegistration->meta_description,
                'meta_keywords' => $pendingRegistration->meta_keywords,
                'status' => 'active',
                'approval_status' => $category && !$category->requires_manual_approval ? 'approved' : 'pending_approval',
                'approved_at' => $category && !$category->requires_manual_approval ? now() : null,
                'approved_by' => $category && !$category->requires_manual_approval ? auth()->id() : null,
                'created_by' => auth()->id(),
            ]);

            // 2. Verificar si el email del usuario ya existe
            if (User::where('email', $pendingRegistration->owner_email)->exists()) {
                throw new \Exception('El correo electrónico ya está registrado en el sistema.');
            }

            // 3. Crear usuario administrador asociado a la tienda
            $user = User::create([
                'name' => $pendingRegistration->owner_name,
                'email' => $pendingRegistration->owner_email,
                'password' => $pendingRegistration->hashed_password,
                'role' => 'store_admin',
                'store_id' => $store->id,
            ]);

            // 4. Crear suscripción y factura usando BillingService (centralizado)
            $billingService = app(BillingService::class);
            $billing = $billingService->createInitialBilling(
                store: $store,
                billingCycle: $pendingRegistration->billing_period,
                hasTrialPeriod: null, // null = usar trial_days del plan automáticamente
                trialDays: null,      // null = usar trial_days del plan automáticamente
                paymentStatus: 'paid', // Ya pagaron con el comprobante
                createdBy: auth()->id(),
                metadata: [
                    'registration_id' => $pendingRegistration->id,
                    'payment_proof' => $pendingRegistration->payment_proof,
                    'approved_by' => auth()->user()->name,
                    'source' => 'public_registration_wizard'
                ]
            );

            // 5. Actualizar registro como aprobado
            $pendingRegistration->update([
                'status' => 'approved',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
                'created_store_id' => $store->id,
            ]);

            DB::commit();

            // 6. TODO: Enviar email de bienvenida al usuario

            return response()->json([
                'success' => true,
                'message' => 'Registro aprobado. Tienda creada exitosamente.',
                'store_url' => route('superlinkiu.stores.show', $store)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Error aprobando registro', [
                'registration_id' => $pendingRegistration->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al crear la tienda: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rechazar registro
     */
    public function reject(Request $request, PendingRegistration $pendingRegistration)
    {
        if (!$pendingRegistration->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Este registro ya fue procesado'
            ], 400);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
            'details' => 'nullable|array'
        ]);

        $pendingRegistration->update([
            'status' => 'rejected',
            'rejected_reason' => $validated['reason'],
            'rejection_details' => isset($validated['details']) ? json_encode($validated['details']) : null,
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        // TODO: Enviar email al usuario explicando el rechazo

        return response()->json([
            'success' => true,
            'message' => 'Registro rechazado'
        ]);
    }

    /**
     * Verificar estado de un registro (para polling desde Step5)
     */
    public function checkStatus($registrationId)
    {
        $registration = PendingRegistration::find($registrationId);

        if (!$registration) {
            return response()->json([
                'status' => 'not_found'
            ], 404);
        }

        return response()->json([
            'status' => $registration->status,
            'approved' => $registration->status === 'approved',
            'rejected' => $registration->status === 'rejected',
            'pending' => $registration->status === 'pending',
        ]);
    }
}

