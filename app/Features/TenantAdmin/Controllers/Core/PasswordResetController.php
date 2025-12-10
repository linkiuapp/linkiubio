<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetCode;
use App\Services\OTPSmsService;
use App\Shared\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class PasswordResetController extends Controller
{
    protected $smsService;

    public function __construct(OTPSmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Mostrar formulario para solicitar recuperación
     */
    public function showForgotPassword(Request $request, $store)
    {
        return view('tenant-admin::Core.auth.forgot-password', compact('store'));
    }

    /**
     * Enviar código de verificación por SMS
     */
    public function sendCode(Request $request, $store)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico no es válido',
        ]);

        // Buscar usuario por email y store
        $user = User::where('email', $request->email)
            ->where('role', 'store_admin')
            ->whereHas('store', function($query) use ($store) {
                $query->where('slug', $store->slug);
            })
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No encontramos una cuenta asociada a este correo electrónico para esta tienda.'
            ])->withInput();
        }

        // Verificar que la tienda tenga owner_phone o phone configurado
        $phone = $user->store->owner_phone ?? $user->store->phone ?? null;
        
        if (!$user->store || !$phone) {
            return back()->withErrors([
                'email' => 'La tienda no tiene configurado un número de teléfono. Contacta al administrador del sistema.'
            ])->withInput();
        }

        // Verificar límite de códigos (máximo 3 por hora)
        // Solo contar códigos que NO fueron usados (used_at es null)
        $recentCodes = PasswordResetCode::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subHour())
            ->whereNull('used_at')
            ->count();

        if ($recentCodes >= 3) {
            // Calcular cuánto tiempo falta para poder solicitar otro código
            $oldestCode = PasswordResetCode::where('user_id', $user->id)
                ->where('created_at', '>=', now()->subHour())
                ->whereNull('used_at')
                ->orderBy('created_at', 'asc')
                ->first();
            
            if ($oldestCode) {
                $waitTime = max(1, (int) ceil(now()->diffInSeconds($oldestCode->created_at->addHour()) / 60));
                
                // Formatear el mensaje de manera más amigable
                if ($waitTime >= 60) {
                    $hours = floor($waitTime / 60);
                    $minutes = $waitTime % 60;
                    $timeMessage = $hours > 0 
                        ? ($minutes > 0 ? "{$hours} hora" . ($hours > 1 ? 's' : '') . " y {$minutes} minuto" . ($minutes > 1 ? 's' : '') : "{$hours} hora" . ($hours > 1 ? 's' : ''))
                        : "{$minutes} minuto" . ($minutes > 1 ? 's' : '');
                } else {
                    $timeMessage = "{$waitTime} minuto" . ($waitTime > 1 ? 's' : '');
                }
            } else {
                $timeMessage = "1 hora";
            }
            
            return back()->withErrors([
                'email' => "Has solicitado demasiados códigos. Intenta nuevamente en {$timeMessage}."
            ])->withInput();
        }

        // Verificar que el servicio de SMS esté habilitado ANTES de generar el código
        if (!$this->smsService->isEnabled()) {
            \Log::error('SMS service no está habilitado', [
                'user_id' => $user->id,
                'store_slug' => $store->slug
            ]);
            
            return back()->withErrors([
                'email' => 'El servicio de SMS no está configurado. Contacta al administrador del sistema.'
            ])->withInput();
        }

        // Generar código de 6 dígitos
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Obtener número de teléfono (usar owner_phone o phone como fallback)
        $phone = $user->store->owner_phone ?? $user->store->phone;
        $sent = false;
        
        // Enviar código por SMS
        if ($this->smsService->isEnabled()) {
            try {
                $sent = $this->smsService->sendPasswordResetCode($phone, $code);
            } catch (\Exception $e) {
                \Log::error('Error enviando código de recuperación por SMS', [
                    'user_id' => $user->id,
                    'phone' => $phone ?? 'N/A',
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'store_slug' => $store->slug
                ]);
                
                // Manejar error de plantilla no encontrada
                if ($e->getMessage() === 'TEMPLATE_NOT_FOUND') {
                    return back()->withErrors([
                        'email' => 'La plantilla de WhatsApp no está configurada correctamente. Por favor, contacta al administrador del sistema.'
                    ])->withInput();
                }
                
                // Manejar error de parámetros de plantilla
                if ($e->getMessage() === 'TEMPLATE_PARAMETERS_MISMATCH') {
                    return back()->withErrors([
                        'email' => 'Error en el formato de la plantilla de WhatsApp. Por favor, contacta al administrador del sistema.'
                    ])->withInput();
                }
                
                // Manejar rate limiting
                if (strpos($e->getMessage(), 'RATE_LIMIT_EXCEEDED') === 0) {
                    $errorDetail = str_replace('RATE_LIMIT_EXCEEDED: ', '', $e->getMessage());
                    return back()->withErrors([
                        'email' => $errorDetail
                    ])->withInput();
                }
                
                // Otros errores de rechazo de WhatsApp
                if (strpos($e->getMessage(), 'WHATSAPP_REJECTED') === 0) {
                    $errorDetail = str_replace('WHATSAPP_REJECTED: ', '', $e->getMessage());
                    return back()->withErrors([
                        'email' => "No se pudo enviar el código por WhatsApp: {$errorDetail}. Por favor, contacta al administrador del sistema."
                    ])->withInput();
                }
            }
        }
        
        // Solo crear el registro del código si se envió exitosamente
        if (!$sent) {
            \Log::error('Error: No se pudo enviar el código por WhatsApp', [
                'user_id' => $user->id,
                'phone' => $phone,
                'store_slug' => $store->slug,
                'service_enabled' => $this->smsService->isEnabled()
            ]);
            
            return back()->withErrors([
                'email' => 'No se pudo enviar el código de verificación por WhatsApp. Verifica que tu número de teléfono esté correcto. Si el problema persiste, contacta al administrador.'
            ])->withInput();
        }

        // Crear registro del código solo si se envió exitosamente
        $resetCode = PasswordResetCode::create([
            'user_id' => $user->id,
            'code' => Hash::make($code), // Hashear el código
            'expires_at' => now()->addMinutes(5),
            'ip_address' => $request->ip(),
        ]);

        // Guardar user_id en sesión para el siguiente paso
        session(['password_reset_user_id' => $user->id]);

        return redirect()->route('tenant.admin.password.verify-code', ['store' => $store->slug])
            ->with('success', 'Hemos enviado un código de verificación por WhatsApp a tu teléfono. El código expira en 5 minutos.');
    }

    /**
     * Mostrar formulario para verificar código
     */
    public function showVerifyCode(Request $request, $store)
    {
        if (!session('password_reset_user_id')) {
            return redirect()->route('tenant.admin.password.forgot', ['store' => $store->slug])
                ->withErrors(['error' => 'Sesión expirada. Por favor solicita un nuevo código.']);
        }

        return view('tenant-admin::Core.auth.verify-code', compact('store'));
    }

    /**
     * Verificar código y generar token
     */
    public function verifyCode(Request $request, $store)
    {
        $request->validate([
            'code' => 'required|string|size:6|regex:/^[0-9]{6}$/',
        ], [
            'code.required' => 'El código es obligatorio',
            'code.size' => 'El código debe tener 6 dígitos',
            'code.regex' => 'El código solo puede contener números',
        ]);

        $userId = session('password_reset_user_id');

        if (!$userId) {
            return redirect()->route('tenant.admin.password.forgot', ['store' => $store->slug])
                ->withErrors(['error' => 'Sesión expirada. Por favor solicita un nuevo código.']);
        }

        // Buscar código válido
        $resetCodes = PasswordResetCode::where('user_id', $userId)
            ->valid()
            ->latest()
            ->get();

        $validCode = null;
        foreach ($resetCodes as $resetCode) {
            if (Hash::check($request->code, $resetCode->code)) {
                $validCode = $resetCode;
                break;
            }
        }

        if (!$validCode) {
            return back()->withErrors([
                'code' => 'El código es incorrecto o ha expirado. Verifica e intenta nuevamente.'
            ])->withInput();
        }

        // Generar token único para el siguiente paso
        $token = Str::random(64);
        $validCode->update(['token' => Hash::make($token)]);

        // Guardar token en sesión
        session([
            'password_reset_token' => $token,
            'password_reset_code_id' => $validCode->id,
        ]);

        return redirect()->route('tenant.admin.password.reset', ['store' => $store->slug]);
    }

    /**
     * Mostrar formulario para nueva contraseña
     */
    public function showResetPassword(Request $request, $store)
    {
        if (!session('password_reset_token') || !session('password_reset_code_id')) {
            return redirect()->route('tenant.admin.password.forgot', ['store' => $store->slug])
                ->withErrors(['error' => 'Sesión expirada. Por favor solicita un nuevo código.']);
        }

        return view('tenant-admin::Core.auth.reset-password', compact('store'));
    }

    /**
     * Actualizar contraseña
     */
    public function resetPassword(Request $request, $store)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'password.required' => 'La contraseña es obligatoria',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ]);

        $token = session('password_reset_token');
        $codeId = session('password_reset_code_id');

        if (!$token || !$codeId) {
            return redirect()->route('tenant.admin.password.forgot', ['store' => $store->slug])
                ->withErrors(['error' => 'Sesión expirada. Por favor solicita un nuevo código.']);
        }

        // Verificar token
        $resetCode = PasswordResetCode::find($codeId);

        if (!$resetCode || !Hash::check($token, $resetCode->token)) {
            return redirect()->route('tenant.admin.password.forgot', ['store' => $store->slug])
                ->withErrors(['error' => 'Token inválido. Por favor solicita un nuevo código.']);
        }

        // Verificar que el código no haya sido usado
        if ($resetCode->isUsed()) {
            return redirect()->route('tenant.admin.password.forgot', ['store' => $store->slug])
                ->withErrors(['error' => 'Este código ya fue utilizado. Por favor solicita un nuevo código.']);
        }

        // Verificar que no sea la misma contraseña
        $user = $resetCode->user;
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'La nueva contraseña debe ser diferente a la actual.'
            ])->withInput();
        }

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Marcar código como usado
        $resetCode->markAsUsed();

        // Limpiar sesión
        session()->forget(['password_reset_user_id', 'password_reset_token', 'password_reset_code_id']);

        // Log de auditoría
        \Log::info('Contraseña recuperada exitosamente', [
            'user_id' => $user->id,
            'email' => $user->email,
            'store_id' => $user->store_id,
        ]);

        return redirect()->route('tenant.admin.login', ['store' => $store->slug])
            ->with('success', 'Contraseña actualizada exitosamente. Inicia sesión con tu nueva contraseña.');
    }

    /**
     * Reenviar código
     */
    public function resendCode(Request $request, $store)
    {
        $userId = session('password_reset_user_id');

        if (!$userId) {
            return redirect()->route('tenant.admin.password.forgot', ['store' => $store->slug])
                ->withErrors(['error' => 'Sesión expirada. Por favor solicita un nuevo código.']);
        }

        $user = User::findOrFail($userId);

        // Verificar límite de reenvíos (máximo 3 por hora)
        $recentCodes = PasswordResetCode::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentCodes >= 3) {
            return back()->withErrors([
                'error' => 'Has solicitado demasiados códigos. Intenta nuevamente en una hora.'
            ]);
        }

        // Generar nuevo código
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Obtener número de teléfono
        $phone = $user->store->owner_phone ?? $user->store->phone;
        $sent = false;
        
        // Enviar código por SMS
        if ($this->smsService->isEnabled()) {
            try {
                $sent = $this->smsService->sendPasswordResetCode($phone, $code);
            } catch (\Exception $e) {
                \Log::error('Error reenviando código por SMS', [
                    'user_id' => $user->id,
                    'phone' => $phone,
                    'error' => $e->getMessage(),
                ]);
                
                // Manejar error de plantilla no encontrada
                if ($e->getMessage() === 'TEMPLATE_NOT_FOUND') {
                    return back()->withErrors([
                        'error' => 'La plantilla de WhatsApp no está configurada correctamente. Por favor, contacta al administrador del sistema.'
                    ]);
                }
                
                // Manejar error de parámetros de plantilla
                if ($e->getMessage() === 'TEMPLATE_PARAMETERS_MISMATCH') {
                    return back()->withErrors([
                        'error' => 'Error en el formato de la plantilla de WhatsApp. Por favor, contacta al administrador del sistema.'
                    ]);
                }
                
                // Manejar rate limiting
                if (strpos($e->getMessage(), 'RATE_LIMIT_EXCEEDED') === 0) {
                    $errorDetail = str_replace('RATE_LIMIT_EXCEEDED: ', '', $e->getMessage());
                    return back()->withErrors([
                        'error' => $errorDetail
                    ]);
                }
                
                // Otros errores de rechazo de WhatsApp
                if (strpos($e->getMessage(), 'WHATSAPP_REJECTED') === 0) {
                    $errorDetail = str_replace('WHATSAPP_REJECTED: ', '', $e->getMessage());
                    return back()->withErrors([
                        'error' => "No se pudo enviar el código por WhatsApp: {$errorDetail}. Por favor, contacta al administrador del sistema."
                    ]);
                }
            }
        }

        if (!$sent) {
            return back()->withErrors([
                'error' => 'Error al enviar el código. Por favor intenta nuevamente más tarde.'
            ]);
        }

        // Crear registro del código solo si se envió exitosamente
        PasswordResetCode::create([
            'user_id' => $user->id,
            'code' => Hash::make($code),
            'expires_at' => now()->addMinutes(5),
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Código reenviado exitosamente. Revisa tu WhatsApp.');
    }
}
