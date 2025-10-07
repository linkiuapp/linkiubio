<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use App\Shared\Models\BillingSetting;

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
            $settings = BillingSetting::getInstance();
            
            // Manejar logo
            if ($request->hasFile('app_logo')) {
                $logoFile = $request->file('app_logo');
                $extension = $logoFile->getClientOriginalExtension();
                $logoFilename = 'logo_' . time() . '.' . $extension;
                $logoPath = 'system/' . $logoFilename;
                
                // Guardar en almacenamiento (S3 en Laravel Cloud, local en desarrollo)
                $saved = Storage::disk('public')->putFileAs('system', $logoFile, $logoFilename);
                
                if ($saved) {
                    // ✅ GUARDAR EN BASE DE DATOS (persistente)
                    $settings->app_logo = $logoPath;
                    $settings->save();
                    
                    // Log para debugging
                    \Log::info("✅ Logo guardado exitosamente", [
                        'filename' => $logoFilename,
                        'path' => $logoPath,
                        'size' => $logoFile->getSize(),
                        'mime' => $logoFile->getMimeType()
                    ]);
                } else {
                    \Log::error("❌ Error al guardar logo: Storage::putFileAs retornó false");
                }
            }

            // Manejar favicon
            if ($request->hasFile('app_favicon')) {
                $faviconFile = $request->file('app_favicon');
                $extension = $faviconFile->getClientOriginalExtension();
                $faviconFilename = 'favicon_' . time() . '.' . $extension;
                $faviconPath = 'system/' . $faviconFilename;
                
                // Guardar en almacenamiento (S3 en Laravel Cloud, local en desarrollo)
                $saved = Storage::disk('public')->putFileAs('system', $faviconFile, $faviconFilename);
                
                if ($saved) {
                    // ✅ GUARDAR EN BASE DE DATOS (persistente)
                    $settings->app_favicon = $faviconPath;
                    $settings->save();
                    
                    // Log para debugging
                    \Log::info("✅ Favicon guardado exitosamente", [
                        'filename' => $faviconFilename,
                        'path' => $faviconPath,
                        'size' => $faviconFile->getSize(),
                        'mime' => $faviconFile->getMimeType()
                    ]);
                } else {
                    \Log::error("❌ Error al guardar favicon: Storage::putFileAs retornó false");
                }
            }

            // Guardar nombre de app si cambió
            if ($request->filled('app_name')) {
                $settings->app_name = $request->app_name;
                $settings->save();
            }

            return back()->with('status', 'app-settings-updated');
        } catch (\Exception $e) {
            // Log detallado del error para debugging
            \Log::error('❌ Error en updateAppSettings', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('status', 'app-settings-error')->withErrors(['error' => $e->getMessage()]);
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