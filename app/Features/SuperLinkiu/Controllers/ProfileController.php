<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show()
    {
        return view('superlinkiu::profile.show', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Actualizar información básica
        $user->fill($request->only(['name', 'email']));

        // Manejar avatar si se subió uno nuevo
        if ($request->hasFile('avatar')) {
            $this->handleAvatarUpload($request->file('avatar'), $user);
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Delete the user's avatar.
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar_path) {
            // ✅ Eliminar archivo usando método estándar
            $filePath = public_path('storage/' . $user->avatar_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Limpiar campo en BD
            $user->update(['avatar_path' => null]);
        }

        return back()->with('status', 'avatar-deleted');
    }

    /**
     * Update app settings (logo, favicon, name)
     */
    public function updateAppSettings(Request $request)
    {
        $request->validate([
            'app_name' => ['required', 'string', 'max:255'],
            'app_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'app_favicon' => ['nullable', 'image', 'mimes:ico,png', 'max:1024'],
        ]);

        try {
            // Manejar logo
            if ($request->hasFile('app_logo')) {
                $logoFile = $request->file('app_logo');
                $logoFilename = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
                $logoPath = 'system/' . $logoFilename;
                
                // Guardar en almacenamiento local
                Storage::disk('public')->putFileAs('system', $logoFile, $logoFilename);
                
                // TODO: Implementar actualización de APP_LOGO sin modificar .env directamente  
                // $this->updateEnvVariable('APP_LOGO', $logoPath);
                
                // Por ahora, guardamos en sesión para mostrar el cambio temporalmente
                session(['temp_app_logo' => $logoPath]);
                
                // Log para debugging
                \Log::info("Logo guardado en bucket S3: {$logoPath}");
            }

            // Manejar favicon
            if ($request->hasFile('app_favicon')) {
                $faviconFile = $request->file('app_favicon');
                $faviconFilename = 'favicon_' . time() . '.' . $faviconFile->getClientOriginalExtension();
                $faviconPath = 'system/' . $faviconFilename;
                
                // Guardar en almacenamiento local
                Storage::disk('public')->putFileAs('system', $faviconFile, $faviconFilename);
                
                // TODO: Implementar actualización de APP_FAVICON sin modificar .env directamente
                // $this->updateEnvVariable('APP_FAVICON', $faviconPath);
                
                // Por ahora, guardamos en sesión para mostrar el cambio temporalmente
                session(['temp_app_favicon' => $faviconPath]);
                
                // Log para debugging
                \Log::info("Favicon guardado en bucket S3: {$faviconPath}");
            }

            return back()->with('status', 'app-settings-updated');
        } catch (\Exception $e) {
            // Log del error para debugging
            \Log::error('Error en updateAppSettings: ' . $e->getMessage());
            return back()->with('status', 'app-settings-error');
        }
    }



    /**
     * Handle the avatar upload using STANDARD method.
     * ✅ Follows ESTANDAR_IMAGENES.md - Compatible with Laravel Cloud
     */
    private function handleAvatarUpload($file, $user)
    {
        // Eliminar avatar anterior si existe
        if ($user->avatar_path) {
            $oldFile = public_path('storage/' . $user->avatar_path);
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        // Crear directorio si no existe
        $destinationPath = public_path('storage/avatars');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Generar nombre único para el archivo
        $filename = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // ✅ GUARDAR con move() - Método estándar obligatorio
        $file->move($destinationPath, $filename);
        
        // Actualizar path en el usuario y guardar
        $user->avatar_path = 'avatars/' . $filename;
        $user->save();
    }

    /**
     * Update environment variable
     */
    private function updateEnvVariable($key, $value)
    {
        $path = base_path('.env');
        
        if (!file_exists($path)) {
            return false;
        }

        $content = file_get_contents($path);
        
        // Escapar valor para uso seguro en .env
        $escapedValue = str_replace('"', '\"', $value);
        $newLine = $key . '="' . $escapedValue . '"';
        
        // Escapar la clave para usar en regex
        $escapedKey = preg_quote($key, '/');
        
        // Buscar si la variable ya existe
        $pattern = '/^' . $escapedKey . '=.*$/m';
        
        if (preg_match($pattern, $content)) {
            // Reemplazar la variable existente
            $content = preg_replace($pattern, $newLine, $content);
        } else {
            // Agregar la variable al final del archivo
            $content = rtrim($content) . "\n" . $newLine . "\n";
        }
        
        // Guardar el archivo
        return file_put_contents($path, $content) !== false;
    }
}