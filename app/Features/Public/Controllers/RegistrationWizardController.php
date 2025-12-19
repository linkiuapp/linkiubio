<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Plan;
use App\Shared\Models\BusinessCategory;
use App\Shared\Models\Subscription;
use App\Models\PendingRegistration;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class RegistrationWizardController extends Controller
{
    /**
     * Step 1: Selecci?n de Plan
     */
    public function step1()
    {
        // Obtener planes p?blicos y activos ordenados
        $plans = Plan::where('is_public', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('price')
            ->get();

        return view('public::registration.step1-plans', compact('plans'));
    }

    /**
     * Guardar Step 1 y continuar a Step 2
     */
    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'billing_period' => 'required|in:monthly,quarterly,semester,annual',
        ]);

        // Guardar en sesi?n
        Session::put('wizard.plan_id', $validated['plan_id']);
        Session::put('wizard.billing_period', $validated['billing_period']);

        return redirect()->route('register.step2');
    }

    /**
     * Guardar Step 2 y continuar a Step 3
     */
    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'business_category_id' => 'required|exists:business_categories,id',
            'business_name' => 'required|string|max:255',
            'document_type' => 'required|in:nit,cc,ce',
            'document_number' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Validar email de contacto del negocio
        $email = $validated['email'];
        // Verificar si ya existe en stores
        $existingStoreEmail = \App\Shared\Models\Store::where('email', $email)->first();
        if ($existingStoreEmail) {
            return back()->withInput()->withErrors(['email' => 'Este correo electrónico ya está registrado por otra tienda.']);
        }

        // Verificar si ya existe en pending_registrations con status approved o pending
        $existingPendingEmail = PendingRegistration::where('email', $email)
            ->whereIn('status', ['approved', 'pending'])
            ->first();
        if ($existingPendingEmail) {
            if ($existingPendingEmail->status === 'approved') {
                return back()->withInput()->withErrors(['email' => 'Este correo electrónico ya tiene un registro aprobado.']);
            } else {
                return back()->withInput()->withErrors(['email' => 'Ya existe un registro pendiente con este correo. Por favor espera a que sea procesado o contacta soporte.']);
            }
        }

        // Validar nombre del negocio (business_name) contra pending_registrations
        // Nota: La tabla stores no tiene columna business_name, solo name (nombre de tienda)
        $businessName = $validated['business_name'];
        
        // Verificar en pending_registrations
        $existingPendingBusinessName = PendingRegistration::whereRaw('LOWER(business_name) = LOWER(?)', [$businessName])
            ->whereIn('status', ['approved', 'pending'])
            ->first();
        if ($existingPendingBusinessName) {
            return back()->withInput()->withErrors(['business_name' => 'Ya existe un registro pendiente o aprobado con este nombre de negocio. Por favor verifica o elige otro nombre.']);
        }

        // Guardar todos los datos en sesi?n
        foreach($validated as $key => $value) {
            Session::put("wizard.{$key}", $value);
        }

        return redirect()->route('register.step3');
    }

    /**
     * Step 2: Informaci?n del Negocio
     */
    public function step2()
    {
        if (!Session::has('wizard.plan_id')) {
            return redirect()->route('register.step1');
        }

        $categories = BusinessCategory::where('is_active', true)
            ->with('features')
            ->orderBy('name')
            ->get();

        return view('public::registration.step2-business', compact('categories'));
    }

    /**
     * Guardar Step 3 y continuar a Step 4
     */
    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'slug' => 'required|string|max:100|regex:/^[a-z0-9-]+$/',
            'store_description' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Validar slug contra stores
        $slug = $validated['slug'];
        $existingStore = \App\Shared\Models\Store::where('slug', $slug)->first();
        if ($existingStore) {
            return back()->withInput()->withErrors(['slug' => 'Esta URL ya está en uso por otra tienda. Por favor elige otra.']);
        }

        // Validar slug contra pending_registrations con status approved o pending
        $existingPendingSlug = PendingRegistration::where('slug', $slug)
            ->whereIn('status', ['approved', 'pending'])
            ->first();
        if ($existingPendingSlug) {
            return back()->withInput()->withErrors(['slug' => 'Esta URL ya está en uso en un registro pendiente o aprobado. Por favor elige otra.']);
        }

        // Validar nombre de tienda contra stores (case-insensitive)
        $storeName = $validated['store_name'];
        $existingStoreName = \App\Shared\Models\Store::whereRaw('LOWER(name) = LOWER(?)', [$storeName])->first();
        if ($existingStoreName) {
            return back()->withInput()->withErrors(['store_name' => 'Ya existe una tienda con este nombre. Por favor elige otro nombre.']);
        }

        // Validar nombre contra pending_registrations
        $existingPendingName = PendingRegistration::whereRaw('LOWER(store_name) = LOWER(?)', [$storeName])
            ->whereIn('status', ['approved', 'pending'])
            ->first();
        if ($existingPendingName) {
            return back()->withInput()->withErrors(['store_name' => 'Ya existe un registro pendiente o aprobado con este nombre. Por favor elige otro nombre.']);
        }

        // Guardar todos los datos en sesi?n
        foreach($validated as $key => $value) {
            Session::put("wizard.{$key}", $value);
        }

        return redirect()->route('register.step4');
    }

    /**
     * Step 3: Configuraci?n de la Tienda
     */
    public function step3()
    {
        if (!Session::has('wizard.plan_id') || !Session::has('wizard.business_category_id')) {
            return redirect()->route('register.step1');
        }

        return view('public::registration.step3-store');
    }

    /**
     * Step 4 redirige directamente a complete (no hay storeStep4)
     */

    /**
     * Step 4: Informaci?n del Propietario
     */
    public function step4()
    {
        if (!Session::has('wizard.plan_id') || !Session::has('wizard.business_category_id')) {
            return redirect()->route('register.step1');
        }

        // Obtener configuraci?n de pago
        $paymentSetting = \App\Models\RegistrationPaymentSetting::getActive();
        
        // Verificar si Epayco est? activo
        $epaycoGateway = \App\Models\PaymentGateway::where('name', 'epayco')
            ->where('is_active', true)
            ->first();
        
        // Calcular monto a pagar
        $plan = \App\Shared\Models\Plan::findOrFail(Session::get('wizard.plan_id'));
        $billingPeriod = Session::get('wizard.billing_period', 'monthly');
        $prices = $plan->prices ?? [];
        
        $amount = match($billingPeriod) {
            'monthly' => $plan->price,
            'quarterly' => $prices['quarterly'] ?? ($plan->price * 3),
            'semester' => $prices['semester'] ?? ($plan->price * 6),
            'annual' => $prices['annual'] ?? ($plan->price * 12),
            default => $plan->price
        };

        // Obtener lista de bancos PSE si Epayco est? activo
        $pseBanks = [];
        if ($epaycoGateway) {
            try {
                $epaycoService = new \App\Services\PaymentGateways\EpaycoService($epaycoGateway);
                $banksResult = $epaycoService->getPseBanks();
                
                if ($banksResult['success'] && isset($banksResult['banks'])) {
                    $banks = $banksResult['banks'];
                    
                    // Convertir a array si es objeto
                    if (is_object($banks)) {
                        $banks = json_decode(json_encode($banks), true);
                    }
                    
                    // Procesar bancos
                    if (is_array($banks) && !empty($banks)) {
                        $pseBanks = $banks;
                    }
                    
                    // Log para debugging
                    \Log::info('Bancos PSE cargados', [
                        'total' => count($pseBanks),
                        'sample' => !empty($pseBanks) ? ($pseBanks[0] ?? null) : null
                    ]);
                }
            } catch (\Exception $e) {
                \Log::warning('Error obteniendo bancos PSE', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return view('public::registration.step4-owner', compact('paymentSetting', 'amount', 'epaycoGateway', 'pseBanks'));
    }

    /**
     * Procesar registro completo
     */
    public function complete(Request $request)
    {
        // Validar Step 4
        $validated = $request->validate([
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255|unique:users,email|unique:pending_registrations,owner_email',
            'owner_document_type' => 'required|in:cc,ce,passport',
            'owner_document_number' => 'required|string|max:50',
            'password' => 'required|string|min:8|confirmed',
            'accept_terms' => 'required|accepted',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,pdf|max:5120', // 5MB max
        ]);

        // Crear registro pendiente con TODOS los datos del wizard
        $registration = PendingRegistration::create([
            // Step 1
            'plan_id' => Session::get('wizard.plan_id'),
            'billing_period' => Session::get('wizard.billing_period'),
            
            // Step 2
            'business_category_id' => Session::get('wizard.business_category_id'),
            'business_name' => Session::get('wizard.business_name'),
            'document_type' => Session::get('wizard.document_type'),
            'document_number' => Session::get('wizard.document_number'),
            'phone' => Session::get('wizard.phone'),
            'email' => Session::get('wizard.email'),
            'city' => Session::get('wizard.city'),
            'department' => Session::get('wizard.department'),
            'address' => Session::get('wizard.address'),
            'description' => Session::get('wizard.description'),
            
            // Step 3
            'store_name' => Session::get('wizard.store_name'),
            'slug' => Session::get('wizard.slug'),
            'store_description' => Session::get('wizard.store_description'),
            'meta_title' => Session::get('wizard.meta_title'),
            'meta_description' => Session::get('wizard.meta_description'),
            'meta_keywords' => Session::get('wizard.meta_keywords'),
            
            // Step 4
            'owner_name' => $validated['owner_name'],
            'owner_email' => $validated['owner_email'],
            'owner_document_type' => $validated['owner_document_type'],
            'owner_document_number' => $validated['owner_document_number'],
            'hashed_password' => Hash::make($validated['password']),
            'temp_password_encrypted' => encrypt($validated['password']), // Guardar encriptada para mostrarla despu?s
            
            // Estado
            'status' => 'pending',
        ]);

        // Guardar comprobante de pago
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = 'proof_' . $registration->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment-proofs/registrations', $filename, 'public');
            $registration->update(['payment_proof' => $path]);
        }

        // Enviar WhatsApp INMEDIATAMENTE
        $this->sendWhatsAppNotification($registration);

        // Limpiar sesi?n del wizard
        Session::forget('wizard.plan_id');
        Session::forget('wizard.selected_period');
        Session::forget('wizard.business_category_id');

        // Redirigir a Step 5 (pantalla de espera)
        return redirect()->route('register.step5', $registration->id);
    }

    /**
     * Step 5: Pantalla de espera
     */
    public function step5($registrationId)
    {
        $registration = PendingRegistration::with(['plan', 'category'])->findOrFail($registrationId);
        
        // Si ya fue aprobado, redirigir a success
        if ($registration->status === 'approved') {
            return redirect()->route('register.success', $registrationId);
        }
        
        // Si fue rechazado, redirigir a rejected
        if ($registration->status === 'rejected') {
            return redirect()->route('register.rejected', $registrationId);
        }
        
        return view('public::registration.step5-payment', compact('registration'));
    }

    /**
     * Vista de ?xito (aprobado)
     */
    public function success($registrationId)
    {
        $registration = PendingRegistration::with(['plan', 'category', 'createdStore'])->findOrFail($registrationId);
        
        if ($registration->status !== 'approved' || !$registration->created_store_id) {
            return redirect()->route('register.step5', $registrationId);
        }
        
        $store = $registration->createdStore;
        $subscription = Subscription::where('store_id', $store->id)->first();
        
        // Obtener contrase?a temporal desencriptada del registro
        $temporaryPassword = null;
        if ($registration->temp_password_encrypted) {
            try {
                $temporaryPassword = decrypt($registration->temp_password_encrypted);
                
                // Limpiar la contrase?a encriptada despu?s de mostrarla (seguridad)
                $registration->update(['temp_password_encrypted' => null]);
            } catch (\Exception $e) {
                \Log::error('Error desencriptando contrase?a temporal:', ['error' => $e->getMessage()]);
            }
        }
        
        // Si no hay contrase?a disponible (registros antiguos), usar placeholder
        if (!$temporaryPassword) {
            $temporaryPassword = '(Contrase?a enviada por email)';
        }
        
        return view('public::registration.success', compact('registration', 'store', 'subscription', 'temporaryPassword'));
    }

    /**
     * Vista de rechazo
     */
    public function rejected($registrationId)
    {
        $registration = PendingRegistration::with(['plan', 'category'])->findOrFail($registrationId);
        
        if ($registration->status !== 'rejected') {
            return redirect()->route('register.step5', $registrationId);
        }
        
        return view('public::registration.rejected', compact('registration'));
    }

    /**
     * API: Verificar estado del registro
     */
    public function checkStatus($registrationId)
    {
        $registration = PendingRegistration::find($registrationId);
        
        if (!$registration) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $response = [
            'status' => $registration->status,
            'reason' => $registration->rejected_reason,
        ];

        if ($registration->isApproved() && $registration->created_store_id) {
            $store = $registration->createdStore;
            $response['redirect_url'] = route('tenant.admin.dashboard', ['store' => $store->slug]);
        }

        return response()->json($response);
    }

    /**
     * Enviar notificaci?n WhatsApp
     */
    private function sendWhatsAppNotification(PendingRegistration $registration)
    {
        try {
            $whatsapp = app(WhatsAppNotificationService::class);
            
            if (!$whatsapp->isEnabled()) {
                \Log::warning('WhatsApp no habilitado - No se envi? notificaci?n de registro');
                return;
            }

            // Enviar notificaci?n de nueva registraci?n pendiente
            $result = $whatsapp->notifyNewRegistrationPending(
                $registration,
                '573233332112' // N?mero del super admin
            );

            if ($result) {
                $registration->update(['whatsapp_sent_at' => now()]);
                \Log::info('WhatsApp enviado para registro pendiente', [
                    'registration_id' => $registration->id
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error enviando WhatsApp de registro', [
                'registration_id' => $registration->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
