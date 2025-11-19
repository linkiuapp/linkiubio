<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Mostrar formulario de cambio de contraseña
     */
    public function index(Request $request)
    {
        $store = $request->route('store');
        $user = auth()->user();
        
        return view('tenant-admin::Core/profile.index', compact('store', 'user'));
    }
    
    /**
     * Cambiar contraseña
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'current_password.required' => 'La contraseña actual es requerida',
            'password.required' => 'La nueva contraseña es requerida',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ]);
        
        $user = auth()->user();
        
        // Verificar contraseña actual
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'La contraseña actual es incorrecta'
            ]);
        }
        
        // No permitir usar la misma contraseña
        if (Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'La nueva contraseña debe ser diferente a la actual'
            ]);
        }
        
        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);
        
        // Log de auditoría
        \Log::info('Contraseña cambiada por Store Admin', [
            'user_id' => $user->id,
            'email' => $user->email,
            'store_id' => $user->store_id,
            'ip' => $request->ip()
        ]);
        
        return back()->with('success', '✅ Contraseña actualizada exitosamente');
    }
}
