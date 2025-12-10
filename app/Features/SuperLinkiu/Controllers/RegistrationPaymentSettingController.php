<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RegistrationPaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrationPaymentSettingController extends Controller
{
    /**
     * Mostrar configuración
     */
    public function index()
    {
        $setting = RegistrationPaymentSetting::getActive();
        
        return view('superlinkiu::registration-payment-settings.index', compact('setting'));
    }

    /**
     * Actualizar configuración
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_type' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:255',
            'nit' => 'required|string|max:50',
            'qr_code_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $setting = RegistrationPaymentSetting::getActive();

        // Manejar QR code
        if ($request->hasFile('qr_code_image')) {
            // Eliminar QR anterior si existe
            if ($setting->qr_code_image && Storage::disk('public')->exists($setting->qr_code_image)) {
                Storage::disk('public')->delete($setting->qr_code_image);
            }

            // Guardar nuevo QR usando Storage::put() - Compatible con S3 y local
            $file = $request->file('qr_code_image');
            $filename = 'qr_registro_' . time() . '.' . $file->getClientOriginalExtension();
            $relativePath = 'payment-qr/' . $filename;
            
            // ✅ Guardar usando Storage::disk('public')->put() - Compatible con S3 y local
            Storage::disk('public')->put($relativePath, file_get_contents($file->getRealPath()));
            
            $validated['qr_code_image'] = $relativePath;
        }

        $validated['updated_by'] = auth()->id();

        $setting->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Configuración actualizada exitosamente'
            ]);
        }

        return redirect()
            ->route('superlinkiu.registration-payment-settings.index')
            ->with('success', 'Configuración actualizada exitosamente');
    }

    /**
     * Eliminar QR code
     */
    public function deleteQr()
    {
        $setting = RegistrationPaymentSetting::getActive();

        if ($setting->qr_code_image && Storage::disk('public')->exists($setting->qr_code_image)) {
            Storage::disk('public')->delete($setting->qr_code_image);
        }

        $setting->update(['qr_code_image' => null]);

        return response()->json([
            'success' => true,
            'message' => 'QR code eliminado exitosamente'
        ]);
    }
}

