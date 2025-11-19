<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PreviewController extends Controller
{
    /**
     * Handle admin preview via temporary token
     * Allows SuperAdmin to access TenantAdmin dashboard without password
     */
    public function preview($token)
    {
        try {
            // Validar token en caché
            $data = Cache::get("admin_preview_token:{$token}");
            
            if (!$data) {
                abort(403, 'Token inválido o expirado. El enlace solo es válido por 5 minutos.');
            }

            // Obtener la tienda para el slug
            $store = \App\Shared\Models\Store::findOrFail($data['store_id']);

            // Guardar el usuario actual de SuperAdmin ANTES de hacer login
            $previousUserId = Auth::id();
            $previousUserRole = Auth::user()?->role;

            // Login temporal como admin de la tienda
            Auth::loginUsingId($data['store_admin_id']);
            
            // Marcar en sesión que es modo preview (SIN límite de tiempo)
            session()->put('preview_mode', [
                'super_admin_id' => $data['super_admin_id'],
                'previous_user_id' => $previousUserId,
                'previous_user_role' => $previousUserRole,
                'store_id' => $data['store_id'],
                'store_name' => $data['store_name'],
                'store_slug' => $store->slug,
                'started_at' => now(),
                // No hay expires_at = tiempo ilimitado
            ]);

            // Eliminar token (un solo uso)
            Cache::forget("admin_preview_token:{$token}");

            Log::info('SuperAdmin entered preview mode', [
                'super_admin_id' => $data['super_admin_id'],
                'store_id' => $data['store_id'],
                'store_admin_id' => $data['store_admin_id'],
                'store_slug' => $store->slug
            ]);

            // Redirigir al dashboard del tenant usando la URL construida manualmente
            return redirect()
                ->to("/{$store->slug}/admin/dashboard")
                ->with('success', 'Modo Vista Previa activado. Puedes hacer cambios como administrador de la tienda.');

        } catch (\Exception $e) {
            Log::error('Error in admin preview', [
                'token' => $token,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Mostrar error directamente
            abort(403, 'Error al acceder al modo preview: ' . $e->getMessage());
        }
    }

    /**
     * Exit preview mode and return to SuperAdmin
     */
    public function exitPreview()
    {
        if (!session()->has('preview_mode')) {
            // Si no hay preview mode, redirigir a dashboard del tenant actual
            if (auth()->check() && auth()->user()->store) {
                return redirect()->to("/" . auth()->user()->store->slug . "/admin/dashboard");
            }
            return redirect()->to('/superlinkiu/login');
        }

        $previewData = session('preview_mode');

        Log::info('SuperAdmin exited preview mode', [
            'super_admin_id' => $previewData['super_admin_id'],
            'store_id' => $previewData['store_id'],
            'duration_minutes' => now()->diffInMinutes($previewData['started_at'])
        ]);

        // Limpiar sesión de preview
        session()->forget('preview_mode');

        // Logout del store admin
        Auth::logout();

        // Invalidar sesión actual
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Redirigir al login de SuperAdmin con mensaje
        return redirect()
            ->to('/superlinkiu/login')
            ->with('success', 'Has salido del modo preview. Inicia sesión como SuperAdmin.');
    }
}

