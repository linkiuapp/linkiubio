<?php

namespace App\Features\SuperLinkiu\Services;

use App\Shared\Models\Store;
use App\Shared\Traits\LogsActivity;
use App\Shared\Models\User;
use App\Shared\Models\Plan;
use App\Shared\Models\BusinessCategory;
use App\Core\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SimpleEmailService;
use App\Services\SendGridEmailService;
use App\Services\RUTValidationService;
use App\Models\EmailConfiguration;
use App\Events\StoreRequestCreated;

class StoreService
{
    use LogsActivity;
    /**
     * Crear una nueva tienda con su administrador
     */
    public function createStore(array $data, Request $request): array
    {
        Log::info('🏪 STORE SERVICE: Iniciando creación de tienda', [
            'store_name' => $data['name'],
            'admin_email' => $data['admin_email'],
            'plan_id' => $data['plan_id']
        ]);

        try {
            DB::beginTransaction();

            // 🔍 Procesar slug según plan
            $plan = Plan::findOrFail($data['plan_id']);
            $processedSlug = $this->processSlugForPlan($data['slug'], $plan);

            // Preparar datos de la tienda (sin los campos del propietario)
            $storeData = collect($data)->except([
                'owner_name', 'admin_email', 'owner_document_type', 'owner_document_number',
                'owner_country', 'owner_department', 'owner_city', 'admin_password'
            ])->filter(function ($value) {
                return $value !== null && $value !== '';
            })->toArray();

            // 🔐 LÓGICA DE AUTO-APROBACIÓN
            $approvalData = $this->determineApprovalStatus($data);

            // Crear la tienda
            $store = Store::create([
                ...$storeData,
                'slug' => $processedSlug,
                'status' => $data['status'] ?? 'active',
                'verified' => false,
                ...$approvalData // Agregar datos de aprobación
            ]);

            // 🔧 Preparar contexto para Observers
            $this->prepareObserverContext($request, $data, $store);

            // Crear el usuario administrador
            $storeAdmin = $this->createStoreAdmin($data, $store);

            // ✅ Verificaciones de integridad
            $this->validateStoreCreation($store, $storeAdmin);

            DB::commit();

            Log::info('🏪 STORE SERVICE: Tienda creada exitosamente', [
                'store_id' => $store->id,
                'store_slug' => $store->slug,
                'admin_id' => $storeAdmin->id,
                'approval_status' => $store->approval_status
            ]);

            // 📧 ENVIAR EMAILS SEGÚN ESTADO DE APROBACIÓN
            $this->sendStoreCreationEmails($store, $storeAdmin, $data['admin_password']);

            // 📡 BROADCAST SI ES SOLICITUD PENDIENTE
            if ($store->approval_status === 'pending_approval') {
                event(new StoreRequestCreated($store));
            }

            return [
                'success' => true,
                'store' => $store,
                'admin' => $storeAdmin,
                'approval_status' => $store->approval_status,
                'admin_credentials' => $store->approval_status === 'approved' ? [
                    'store_name' => $store->name,
                    'store_slug' => $store->slug,
                    'name' => $storeAdmin->name,
                    'email' => $storeAdmin->email,
                    'password' => $data['admin_password'], // Solo para mostrar una vez
                    'frontend_url' => url($store->slug),
                    'admin_url' => route('tenant.admin.login', $store->slug),
                    // Mantener compatibilidad con otros usos
                    'store_url' => url($store->slug),
                    'login_url' => route('tenant.admin.login', $store->slug)
                ] : null
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('🏪 STORE SERVICE: Error en creación', [
                'error' => $e->getMessage(),
                'store_name' => $data['name'] ?? 'N/A',
                'stack_trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Actualizar una tienda existente
     */
    public function updateStore(Store $store, array $data): array
    {
        Log::info('🔧 STORE SERVICE: Iniciando actualización de tienda', [
            'store_id' => $store->id,
            'changes' => array_keys($data)
        ]);

        try {
            DB::beginTransaction();

            // 📧 DETECTAR CAMBIOS IMPORTANTES ANTES DE ACTUALIZAR
            $planChanged = isset($data['plan_id']) && $data['plan_id'] != $store->plan_id;
            $statusChanged = isset($data['status']) && $data['status'] != $store->status;
            $verifiedChanged = isset($data['verified']) && (bool)$data['verified'] != $store->verified;

            $oldPlan = $store->plan;
            $oldStatus = $store->status;
            $oldVerified = $store->verified;

            // Procesar slug si cambió el plan
            if ($planChanged) {
                $newPlan = Plan::findOrFail($data['plan_id']);
                $data['slug'] = $this->handleSlugOnPlanChange($store, $newPlan, $data['slug'] ?? $store->slug);
            }

            // Convertir verified checkbox a boolean
            if (isset($data['verified'])) {
                $data['verified'] = (bool) $data['verified'];
            }

            $store->update($data);

            // 📧 ENVIAR EMAILS SEGÚN LOS CAMBIOS DETECTADOS
            if ($planChanged) {
                $this->sendStorePlanChangeEmail($store, $oldPlan, $store->plan);
            }
            
            if ($statusChanged) {
                $this->sendStoreStatusChangeEmail($store, $oldStatus, $store->status);
            }
            
            if ($verifiedChanged) {
                $this->sendStoreVerificationChangeEmail($store, $oldVerified, $store->verified);
            }

            DB::commit();

            Log::info('🔧 STORE SERVICE: Tienda actualizada exitosamente', [
                'store_id' => $store->id
            ]);

            return [
                'success' => true,
                'store' => $store->fresh()
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('🔧 STORE SERVICE: Error en actualización', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Procesar slug según el plan seleccionado
     */
    private function processSlugForPlan(string $slug, Plan $plan): string
    {
        if (!$plan->allow_custom_slug) {
            // Plan no permite personalización - generar automático
            return $this->generateRandomSlug();
        } else {
            // Plan permite personalización - sanitizar
            return $this->sanitizeSlug($slug);
        }
    }

    /**
     * Manejar cambio de slug al cambiar plan
     */
    private function handleSlugOnPlanChange(Store $store, Plan $newPlan, string $requestedSlug): string
    {
        $currentSlug = $store->slug;
        $isCurrentlyRandom = preg_match('/^tienda-[a-z0-9]{8}$/', $currentSlug);

        if (!$newPlan->allow_custom_slug) {
            // Nuevo plan no permite personalización
            if (!$isCurrentlyRandom) {
                // El slug actual es personalizado, pero el nuevo plan no lo permite
                // Mantener el slug actual como excepción (grandfathering)
                Log::info('🔧 SLUG: Manteniendo slug personalizado por grandfathering', [
                    'store_id' => $store->id,
                    'slug' => $currentSlug
                ]);
                return $currentSlug;
            } else {
                // Generar nuevo slug aleatorio
                return $this->generateRandomSlug();
            }
        } else {
            // Nuevo plan permite personalización
            if ($requestedSlug !== $currentSlug) {
                // Usuario quiere cambiar el slug
                return $this->sanitizeSlug($requestedSlug);
            } else {
                // Mantener slug actual
                return $currentSlug;
            }
        }
    }

    /**
     * Generar un slug aleatorio para planes que no permiten personalización
     */
    private function generateRandomSlug(): string
    {
        do {
            $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $slug = 'tienda-';
            
            for ($i = 0; $i < 8; $i++) {
                $slug .= $characters[rand(0, strlen($characters) - 1)];
            }
            
            // Verificar que no exista en la BD
            $exists = Store::where('slug', $slug)->exists();
            
        } while ($exists || RouteServiceProvider::isReservedSlug($slug));
        
        return $slug;
    }

    /**
     * Sanitizar slug personalizado para asegurar formato correcto
     */
    private function sanitizeSlug(string $slug): string
    {
        // Convertir a minúsculas
        $slug = strtolower($slug);
        
        // Eliminar acentos
        $accents = [
            'á' => 'a', 'à' => 'a', 'ä' => 'a', 'â' => 'a', 'ā' => 'a', 'ã' => 'a',
            'é' => 'e', 'è' => 'e', 'ë' => 'e', 'ê' => 'e', 'ē' => 'e',
            'í' => 'i', 'ì' => 'i', 'ï' => 'i', 'î' => 'i', 'ī' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ö' => 'o', 'ô' => 'o', 'ō' => 'o', 'õ' => 'o',
            'ú' => 'u', 'ù' => 'u', 'ü' => 'u', 'û' => 'u', 'ū' => 'u',
            'ñ' => 'n', 'ç' => 'c'
        ];
        $slug = strtr($slug, $accents);
        
        // Reemplazar espacios y caracteres no permitidos con guiones
        $slug = preg_replace('/[^a-z0-9\-]/', '-', $slug);
        
        // Eliminar múltiples guiones consecutivos
        $slug = preg_replace('/-+/', '-', $slug);
        
        // Eliminar guiones al inicio y final
        $slug = trim($slug, '-');
        
        // Si queda vacío, generar uno básico
        if (empty($slug)) {
            $slug = 'tienda-' . rand(1000, 9999);
        }
        
        return $slug;
    }

    /**
     * Crear usuario administrador de la tienda
     */
    private function createStoreAdmin(array $data, Store $store): User
    {
        return User::create([
            'name' => $data['owner_name'],
            'email' => $data['admin_email'],
            'password' => bcrypt($data['admin_password']),
            'role' => 'store_admin',
            'store_id' => $store->id,
        ]);
    }

    /**
     * Preparar contexto para Observers
     */
    private function prepareObserverContext(Request $request, array $data, Store $store): void
    {
        // 🔧 ASEGURAR QUE billing_period esté disponible para el Observer
        if (!$request->has('billing_period') && isset($data['billing_period'])) {
            $request->merge(['billing_period' => $data['billing_period']]);
        }

        // 🔧 ASEGURAR QUE initial_payment_status esté disponible para el Observer
        if (!$request->has('initial_payment_status') && isset($data['initial_payment_status'])) {
            $request->merge(['initial_payment_status' => $data['initial_payment_status']]);
        }

        // 🔧 PASAR CONTEXTO DE TIENDA CREADA AL UserObserver
        $request->merge(['_created_store' => $store, 'store_id' => $store->id]);
    }

    /**
     * Validar que la tienda se creó correctamente
     */
    private function validateStoreCreation(Store $store, User $storeAdmin): void
    {
        // ✅ VERIFICAR QUE EL ADMIN SE CREÓ CORRECTAMENTE
        if (!$storeAdmin || !$storeAdmin->store_id) {
            throw new \Exception('Failed to create store admin with store_id');
        }

        // ✅ VERIFICAR QUE LA TIENDA TIENE AL MENOS UN ADMIN
        $adminCount = $store->admins()->count();
        if ($adminCount === 0) {
            throw new \Exception('Store created but no admin found');
        }

        Log::info('✅ STORE SERVICE: Validaciones de integridad completadas', [
            'store_id' => $store->id,
            'admin_count' => $adminCount
        ]);
    }

    /**
     * Eliminar tienda de forma segura
     */
    public function deleteStore(Store $store): array
    {
        // Log de auditoría ANTES de la eliminación
        $this->logSecurityAction('store_deletion_initiated', [
            'store_id' => $store->id,
            'store_name' => $store->name,
            'store_slug' => $store->slug,
            'store_email' => $store->email,
            'admin_count' => $store->admins()->count()
        ]);

        Log::info('🗑️ STORE SERVICE: Iniciando eliminación segura', [
            'store_id' => $store->id,
            'store_name' => $store->name
        ]);

        try {
            DB::beginTransaction();

            // La eliminación en cascada es manejada por foreign keys y observers
            $store->delete();

            DB::commit();

            // Log de auditoría DESPUÉS de la eliminación exitosa
            $this->logActivity('store_deleted', null, [
                'deleted_store_id' => $store->id,
                'deleted_store_name' => $store->name
            ]);

            Log::info('🗑️ STORE SERVICE: Tienda eliminada exitosamente', [
                'store_id' => $store->id
            ]);

            return ['success' => true];

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('🗑️ STORE SERVICE: Error en eliminación', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Toggle verificación de tienda
     */
    public function toggleVerified(Store $store): array
    {
        $oldStatus = $store->verified;
        $store->verified = !$store->verified;
        $store->save();

        // Log de auditoría
        $this->logStateChange($store, 'verified', $oldStatus, $store->verified);

        Log::info('🔄 STORE SERVICE: Estado de verificación cambiado', [
            'store_id' => $store->id,
            'old_status' => $oldStatus,
            'new_status' => $store->verified
        ]);

        // 📧 ENVIAR EMAIL DE CAMBIO DE VERIFICACIÓN
        $this->sendStoreVerificationChangeEmail($store, $oldStatus, $store->verified);

        return [
            'success' => true,
            'verified' => $store->verified,
            'message' => $store->verified 
                ? 'Tienda verificada exitosamente'
                : 'Verificación de tienda removida'
        ];
    }

    /**
     * Actualizar estado de tienda
     */
    public function updateStatus(Store $store, string $status): array
    {
        $validStatuses = ['active', 'inactive', 'suspended'];
        
        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException('Estado inválido: ' . $status);
        }
        
        $oldStatus = $store->status;
        
        // Validar transiciones de estado
        $this->validateStatusTransition($store, $oldStatus, $status);
        
        // Si no hay cambio, retornar sin hacer nada
        if ($oldStatus === $status) {
            return [
                'success' => true,
                'status' => $status,
                'message' => 'La tienda ya tiene este estado.'
            ];
        }

        $store->status = $status;
        $store->save();
        
        // Log de auditoría para cambio de estado crítico
        $this->logStateChange($store, 'status', $oldStatus, $status);
        
        // Si se suspende la tienda, log de seguridad adicional
        if ($status === 'suspended') {
            $this->logSecurityAction('store_suspended', [
                'store_id' => $store->id,
                'store_name' => $store->name,
                'reason' => 'Manual suspension by admin'
            ]);
        }

        Log::info('🔄 STORE SERVICE: Estado cambiado', [
            'store_id' => $store->id,
            'old_status' => $oldStatus,
            'new_status' => $status
        ]);

        // 📧 ENVIAR EMAIL DE CAMBIO DE ESTADO
        $this->sendStoreStatusChangeEmail($store, $oldStatus, $status);

        return [
            'success' => true,
            'status' => $status,
            'message' => 'Estado actualizado exitosamente'
        ];
    }

    /**
     * Actualizar plan de tienda
     */
    public function updatePlan(Store $store, int $planId): array
    {
        $oldPlan = $store->plan;
        $newPlan = Plan::findOrFail($planId);

        $store->plan_id = $planId;
        $store->save();

        Log::info('🔄 STORE SERVICE: Plan cambiado', [
            'store_id' => $store->id,
            'old_plan' => $oldPlan->name ?? 'N/A',
            'new_plan' => $newPlan->name
        ]);

        // 📧 ENVIAR EMAIL DE CAMBIO DE PLAN
        $this->sendStorePlanChangeEmail($store, $oldPlan, $newPlan);

        return [
            'success' => true,
            'plan' => $newPlan,
            'message' => 'Plan actualizado exitosamente'
        ];
    }

    // ================================================================
    // 📧 MÉTODOS DE EMAIL
    // ================================================================

    /**
     * Enviar emails de creación de tienda (bienvenida + credenciales)
     */
    private function sendStoreCreationEmails(Store $store, User $storeAdmin, string $password): void
    {
        try {
            if ($store->approval_status === 'approved') {
                // ✅ APROBADA: Enviar credenciales
                \App\Jobs\SendEmailJob::dispatch('template', $storeAdmin->email, [
                    'template_key' => 'store_approved',
                    'variables' => [
                        'admin_name' => $storeAdmin->name,
                        'store_name' => $store->name,
                        'admin_email' => $storeAdmin->email,
                        'password' => $password,
                        'login_url' => route('tenant.admin.login', $store->slug),
                        'store_url' => url($store->slug),
                        'plan_name' => $store->plan->name ?? 'Plan básico',
                        'support_email' => 'soporte@linkiu.email'
                    ]
                ]);

                Log::info('📧 STORE SERVICE: Email de aprobación automática enviado', [
                    'store_id' => $store->id,
                    'admin_email' => $storeAdmin->email
                ]);
            } else {
                // ⏳ PENDIENTE: Enviar notificación de revisión
                \App\Jobs\SendEmailJob::dispatch('template', $storeAdmin->email, [
                    'template_key' => 'store_pending_review',
                    'variables' => [
                        'admin_name' => $storeAdmin->name,
                        'store_name' => $store->name,
                        'business_type' => $store->businessCategory->name ?? $store->business_type ?? 'No especificado',
                        'business_document_type' => $store->business_document_type ?? 'N/A',
                        'business_document_number' => $store->business_document_number ?? 'N/A',
                        'estimated_time' => '6 horas',
                        'support_email' => 'soporte@linkiu.email'
                    ]
                ]);

                // 📧 Notificar al SuperAdmin sobre la nueva solicitud
                $superAdminEmail = config('mail.super_admin_email', 'admin@linkiu.email');
                \App\Jobs\SendEmailJob::dispatch('template', $superAdminEmail, [
                    'template_key' => 'new_store_request',
                    'variables' => [
                        'store_name' => $store->name,
                        'business_type' => $store->businessCategory->name ?? $store->business_type ?? 'No especificado',
                        'business_document_type' => $store->business_document_type ?? 'N/A',
                        'business_document_number' => $store->business_document_number ?? 'N/A',
                        'admin_name' => $storeAdmin->name,
                        'admin_email' => $storeAdmin->email,
                        'created_at' => $store->created_at->format('d/m/Y H:i'),
                        'review_url' => route('superlinkiu.store-requests.index')
                    ]
                ])->delay(now()->addSeconds(5));

                Log::info('📧 STORE SERVICE: Emails de solicitud pendiente enviados', [
                    'store_id' => $store->id,
                    'admin_email' => $storeAdmin->email,
                    'superadmin_notified' => true
                ]);
            }
        } catch (\Exception $e) {
            Log::error('📧 STORE SERVICE: Error enviando emails', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Determinar el estado de aprobación de la tienda según categoría y documento
     */
    private function determineApprovalStatus(array $data): array
    {
        // Si no hay categoría o documento, dejar como pending por defecto
        if (!isset($data['business_category_id']) || !isset($data['business_document_number'])) {
            Log::info('🔐 APPROVAL: Tienda sin categoría o documento → PENDING', [
                'has_category' => isset($data['business_category_id']),
                'has_document' => isset($data['business_document_number'])
            ]);
            
            return [
                'approval_status' => 'pending_approval'
            ];
        }

        // Obtener la categoría
        $category = BusinessCategory::find($data['business_category_id']);
        
        if (!$category || !$category->is_active) {
            Log::warning('🔐 APPROVAL: Categoría no encontrada o inactiva → PENDING', [
                'category_id' => $data['business_category_id']
            ]);
            
            return [
                'approval_status' => 'pending_approval'
            ];
        }

        // Si la categoría requiere aprobación manual, dejar pending
        if ($category->requires_manual_approval) {
            Log::info('🔐 APPROVAL: Categoría requiere aprobación manual → PENDING', [
                'category' => $category->name
            ]);
            
            return [
                'approval_status' => 'pending_approval'
            ];
        }

        // Validar el documento según el tipo
        $documentType = $data['business_document_type'] ?? null;
        $documentNumber = $data['business_document_number'];
        $validationService = new RUTValidationService();
        
        $isDocumentValid = false;
        if ($documentType === 'NIT') {
            $isDocumentValid = $validationService->validateNIT($documentNumber);
        } elseif ($documentType === 'CC') {
            $isDocumentValid = $validationService->validateCC($documentNumber);
        }

        if ($isDocumentValid) {
            // ✅ AUTO-APROBACIÓN: Categoría permite + Documento válido
            Log::info('🔐 APPROVAL: Auto-aprobación → APPROVED', [
                'category' => $category->name,
                'document_type' => $documentType,
                'document_valid' => true
            ]);
            
            return [
                'approval_status' => 'approved',
                'document_verified' => true,
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ];
        } else {
            // ⚠️ Documento no válido → PENDING
            Log::warning('🔐 APPROVAL: Documento no válido → PENDING', [
                'category' => $category->name,
                'document_type' => $documentType,
                'document_valid' => false
            ]);
            
            return [
                'approval_status' => 'pending_approval',
                'document_verified' => false
            ];
        }
    }

    /**
     * Enviar email de cambio de estado
     */
    private function sendStoreStatusChangeEmail(Store $store, string $oldStatus, string $newStatus): void
    {
        try {
            $storeAdmin = $store->admins()->first();
            if (!$storeAdmin) {
                Log::warning('📧 STORE SERVICE: No se encontró admin para notificar cambio de estado', [
                    'store_id' => $store->id
                ]);
                return;
            }

            \App\Jobs\SendEmailJob::dispatch('template', $storeAdmin->email, [
                'template_key' => 'store_status_changed',
                'variables' => [
                    'admin_name' => $storeAdmin->name,
                    'store_name' => $store->name,
                    'old_value' => $this->getStatusLabel($oldStatus),
                    'new_value' => $this->getStatusLabel($newStatus),
                    'change_date' => now()->format('d/m/Y H:i'),
                    'changed_by' => Auth::user()->name ?? 'Sistema',
                    'login_url' => route('tenant.admin.login', $store->slug),
                    'support_email' => 'soporte@linkiu.email'
                ]
            ]);

            Log::info('📧 STORE SERVICE: Email de cambio de estado programado', [
                'store_id' => $store->id,
                'admin_email' => $storeAdmin->email
            ]);

        } catch (\Exception $e) {
            Log::error('📧 STORE SERVICE: Error al programar email de cambio de estado', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Enviar email de cambio de plan
     */
    private function sendStorePlanChangeEmail(Store $store, ?Plan $oldPlan, Plan $newPlan): void
    {
        try {
            $storeAdmin = $store->admins()->first();
            if (!$storeAdmin) {
                Log::warning('📧 STORE SERVICE: No se encontró admin para notificar cambio de plan', [
                    'store_id' => $store->id
                ]);
                return;
            }

            \App\Jobs\SendEmailJob::dispatch('template', $storeAdmin->email, [
                'template_key' => 'store_plan_changed',
                'variables' => [
                    'admin_name' => $storeAdmin->name,
                    'store_name' => $store->name,
                    'old_value' => $oldPlan->name ?? 'Plan anterior',
                    'new_value' => $newPlan->name,
                    'change_date' => now()->format('d/m/Y H:i'),
                    'changed_by' => Auth::user()->name ?? 'Sistema',
                    'login_url' => route('tenant.admin.login', $store->slug),
                    'support_email' => 'soporte@linkiu.email'
                ]
            ]);

            Log::info('📧 STORE SERVICE: Email de cambio de plan programado', [
                'store_id' => $store->id,
                'admin_email' => $storeAdmin->email
            ]);

        } catch (\Exception $e) {
            Log::error('📧 STORE SERVICE: Error al programar email de cambio de plan', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Validar transición de estado
     */
    private function validateStatusTransition(Store $store, string $from, string $to): void
    {
        // Reglas de transición de estados
        $invalidTransitions = [
            // No se puede activar una tienda suspendida sin revisar el motivo
            'suspended->active' => 'No se puede activar directamente una tienda suspendida. Primero debe pasar a inactiva.',
        ];
        
        $transition = "{$from}->{$to}";
        
        if (isset($invalidTransitions[$transition])) {
            throw new \InvalidArgumentException($invalidTransitions[$transition]);
        }
        
        // Validaciones adicionales según el estado destino
        if ($to === 'active') {
            // Verificar que la tienda tenga un plan activo
            if (!$store->plan_id) {
                throw new \InvalidArgumentException('No se puede activar una tienda sin plan asignado.');
            }
            
            // Verificar que tenga al menos un administrador
            if ($store->admins()->count() === 0) {
                throw new \InvalidArgumentException('No se puede activar una tienda sin administrador.');
            }
        }
        
        if ($to === 'suspended') {
            // Verificar que no tenga pedidos activos (si existe la relación)
            if (method_exists($store, 'orders')) {
                $activeOrders = $store->orders()
                    ->whereIn('status', ['pending', 'confirmed', 'preparing', 'shipped', 'out_for_delivery'])
                    ->count();
                    
                if ($activeOrders > 0) {
                    throw new \InvalidArgumentException(
                        "No se puede suspender la tienda porque tiene {$activeOrders} pedido(s) activo(s). " .
                        "Los pedidos deben estar entregados o cancelados antes de suspender."
                    );
                }
            }
        }
    }
    
    /**
     * Enviar email de cambio de verificación
     */
    private function sendStoreVerificationChangeEmail(Store $store, bool $oldVerified, bool $newVerified): void
    {
        try {
            $storeAdmin = $store->admins()->first();
            if (!$storeAdmin) {
                Log::warning('📧 STORE SERVICE: No se encontró admin para notificar cambio de verificación', [
                    'store_id' => $store->id
                ]);
                return;
            }

            $templateKey = $newVerified ? 'store_verified' : 'store_unverified';
            
            \App\Jobs\SendEmailJob::dispatch('template', $storeAdmin->email, [
                'template_key' => $templateKey,
                'variables' => [
                    'admin_name' => $storeAdmin->name,
                    'store_name' => $store->name,
                    'store_url' => url($store->slug),
                    'login_url' => route('tenant.admin.login', $store->slug),
                    'old_value' => $oldVerified ? 'Verificada' : 'No verificada',
                    'new_value' => $newVerified ? 'Verificada' : 'No verificada',
                    'change_date' => now()->format('d/m/Y H:i'),
                    'changed_by' => Auth::user()->name ?? 'Sistema',
                    'support_email' => 'soporte@linkiu.email'
                ]
            ]);

            Log::info('📧 STORE SERVICE: Email de cambio de verificación programado', [
                'store_id' => $store->id,
                'admin_email' => $storeAdmin->email,
                'template' => $templateKey
            ]);

        } catch (\Exception $e) {
            Log::error('📧 STORE SERVICE: Error al programar email de verificación', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Obtener etiqueta legible para status
     */
    private function getStatusLabel(string $status): string
    {
        $labels = [
            'active' => 'Activa',
            'inactive' => 'Inactiva', 
            'suspended' => 'Suspendida'
        ];

        return $labels[$status] ?? ucfirst($status);
    }
}
