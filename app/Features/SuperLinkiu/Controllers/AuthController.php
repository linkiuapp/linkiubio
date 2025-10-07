<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('superlinkiu::auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Log del intento de login
        \Log::info('Intento de login SuperAdmin', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->isSuperAdmin()) {
                $request->session()->regenerate();
                $user->updateLastLogin();
                
                // Log de login exitoso
                \Log::info('Login SuperAdmin exitoso', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip' => $request->ip()
                ]);
                
                return redirect()->intended('/superlinkiu/dashboard')
                    ->with('success', 'Bienvenido de vuelta, ' . $user->name);
            }
            
            Auth::logout();
            
            // Log de intento sin permisos
            \Log::warning('Intento de login sin permisos de SuperAdmin', [
                'email' => $user->email,
                'user_id' => $user->id,
                'ip' => $request->ip()
            ]);
            
            return back()->withErrors([
                'email' => 'No tienes permisos de super administrador.',
            ]);
        }

        // Log de credenciales incorrectas
        \Log::warning('Login SuperAdmin fallido - credenciales incorrectas', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('superlinkiu.login');
    }
} 