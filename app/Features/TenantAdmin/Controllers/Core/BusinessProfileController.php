<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\StorePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BusinessProfileController extends Controller
{
    public function index()
    {
        // El middleware ya identificó la tienda
        $store = view()->shared('currentStore');
        
        if (!$store) {
            return response()->json(['error' => 'Store not found'], 404);
        }
        
        // Cargar las políticas si existen, si no crear un registro vacío
        // Usar first() para obtener el primer registro o null, luego el operador null coalescing
        $policies = $store->policies()->first() ?? new StorePolicy();
        
        return view('tenant-admin::core.business-profile.index', compact('store', 'policies'));
    }

    public function whatsappIndex()
    {
        $store = view()->shared('currentStore');
        
        if (!$store) {
            return redirect()->route('tenant.admin.dashboard', ['store' => $store->slug]);
        }
        
        return view('tenant-admin::core.whatsapp-notifications.index', compact('store'));
    }


    public function updateSeo(Request $request, Store $store)
    {
        $validator = Validator::make($request->all(), [
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'google_analytics' => 'nullable|string|max:100',
            'facebook_pixel' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ];

        // Manejar subida de imagen OG
        if ($request->hasFile('og_image')) {
            // ✅ Crear directorio si no existe
            $destinationPath = public_path('storage/og-images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            // Generar nombre único
            $filename = 'og_' . $store->id . '_' . time() . '.' . $request->file('og_image')->getClientOriginalExtension();
            
            // ✅ GUARDAR con move() - Método estándar obligatorio
            $request->file('og_image')->move($destinationPath, $filename);
            
            $updateData['header_short_description'] = 'og-images/' . $filename; // Usar este campo para OG image
        }

        $store->update($updateData);

        return back()->with('swal_success', '✅ Información SEO actualizada correctamente.');
    }

    public function updatePolicies(Request $request, $store)
    {
        // Obtener el store desde el middleware
        $store = view()->shared('currentStore');
        
        if (!$store) {
            return back()->withErrors(['error' => 'Store not found']);
        }

        $validator = Validator::make($request->all(), [
            'privacy_policy' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'shipping_policy' => 'nullable|string',
            'return_policy' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Crear o actualizar políticas
        $store->policies()->updateOrCreate(
            ['store_id' => $store->id],
            [
                'privacy_policy' => $request->privacy_policy,
                'terms_conditions' => $request->terms_conditions,
                'shipping_policy' => $request->shipping_policy,
                'return_policy' => $request->return_policy,
            ]
        );

        return back()->with('swal_success', '✅ Políticas legales actualizadas correctamente.');
    }

    public function updateAbout(Request $request, $store)
    {
        // Obtener el store desde el middleware
        $store = view()->shared('currentStore');
        
        if (!$store) {
            return back()->withErrors(['error' => 'Store not found']);
        }

        $validator = Validator::make($request->all(), [
            'about_us' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Crear o actualizar la sección "Acerca de"
        $store->policies()->updateOrCreate(
            ['store_id' => $store->id],
            ['about_us' => $request->about_us]
        );

        return back()->with('swal_success', '✅ Información de Acerca de Nosotros actualizada correctamente.');
    }

    public function updateWhatsApp(Request $request, $store)
    {
        \Log::info('updateWhatsApp called', ['store_slug' => $store, 'request' => $request->all()]);
        
        // Obtener la tienda por slug
        if (is_string($store)) {
            $store = Store::where('slug', $store)->firstOrFail();
        }
        
        $validator = Validator::make($request->all(), [
            'owner_phone' => 'required|string|regex:/^[0-9]{10}$/|min:10|max:10',
        ], [
            'owner_phone.required' => 'El número de WhatsApp es obligatorio',
            'owner_phone.regex' => 'El número debe tener exactamente 10 dígitos numéricos',
            'owner_phone.min' => 'El número debe tener exactamente 10 dígitos',
            'owner_phone.max' => 'El número debe tener exactamente 10 dígitos',
        ]);

        if ($validator->fails()) {
            \Log::info('Validation failed', ['errors' => $validator->errors()]);
            return back()->withErrors($validator)->withInput();
        }

        // Actualizar el número de WhatsApp
        $store->update([
            'owner_phone' => $request->owner_phone
        ]);

        \Log::info('WhatsApp updated successfully', ['store_id' => $store->id, 'phone' => $request->owner_phone]);

        return back()->with('swal_success', '✅ Número de WhatsApp configurado correctamente. Ya recibirás notificaciones de pedidos y pagos.');
    }
} 