<?php

namespace App\Features\TenantAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\DineInSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DineInSettingController extends Controller
{
    /**
     * Actualizar configuración de Dine-In
     */
    public function update(Request $request, Store $store)
    {
        // Verificar que el usuario sea admin de esta tienda
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'is_enabled' => 'boolean',
            'charge_service_fee' => 'boolean',
            'service_fee_type' => 'in:percentage,fixed',
            'service_fee_percentage' => 'integer|min:0|max:100',
            'service_fee_fixed' => 'numeric|min:0',
            'suggest_tip' => 'boolean',
            'tip_options' => 'array',
            'allow_custom_tip' => 'boolean',
            'require_table_number' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Obtener o crear configuración
            $dineInSettings = DineInSetting::getOrCreateForStore($store->id);
            
            // Actualizar campos
            $dineInSettings->update([
                'is_enabled' => $request->boolean('is_enabled', false),
                'charge_service_fee' => $request->boolean('charge_service_fee', false),
                'service_fee_type' => $request->input('service_fee_type', 'percentage'),
                'service_fee_percentage' => $request->integer('service_fee_percentage', 10),
                'service_fee_fixed' => $request->input('service_fee_fixed', 0),
                'suggest_tip' => $request->boolean('suggest_tip', true),
                'tip_options' => $request->input('tip_options', [0, 10, 15, 20]),
                'allow_custom_tip' => $request->boolean('allow_custom_tip', true),
                'require_table_number' => $request->boolean('require_table_number', true),
            ]);

            \Log::info('DineInSettings actualizado', [
                'store_id' => $store->id,
                'is_enabled' => $dineInSettings->is_enabled,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Configuración actualizada correctamente',
                'settings' => $dineInSettings
            ]);

        } catch (\Exception $e) {
            \Log::error('Error actualizando DineInSettings', [
                'store_id' => $store->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la configuración: ' . $e->getMessage()
            ], 500);
        }
    }
}

