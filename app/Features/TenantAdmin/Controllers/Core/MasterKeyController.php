<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Shared\Models\MasterKeyRecoveryRequest;

class MasterKeyController
{
    /**
     * Mostrar la vista de configuración de clave maestra
     */
    public function index(Request $request)
    {
        $store = $request->route('store');
        
        return view('tenant-admin::core.master-key.index', compact('store'));
    }

    /**
     * Crear o actualizar la clave maestra
     */
    public function store(Request $request)
    {
        $store = $request->route('store');

        $request->validate([
            'master_key' => 'required|string|min:4|max:8',
            'master_key_confirmation' => 'required|same:master_key',
            'protected_actions' => 'nullable|array'
        ], [
            'master_key.required' => 'La clave maestra es obligatoria',
            'master_key.min' => 'La clave debe tener al menos 4 caracteres',
            'master_key.max' => 'La clave no puede tener más de 8 caracteres',
            'master_key_confirmation.required' => 'Debes confirmar la clave maestra',
            'master_key_confirmation.same' => 'Las claves no coinciden'
        ]);

        // Establecer la clave maestra
        $store->setMasterKey($request->master_key);

        // Actualizar acciones protegidas
        $protectedActions = $request->input('protected_actions', []);
        $store->updateProtectedActions($protectedActions);

        return redirect()
            ->route('tenant.admin.master-key.index', $store->slug)
            ->with('swal_success', '✅ Clave maestra configurada correctamente');
    }

    /**
     * Actualizar solo las acciones protegidas
     */
    public function updateActions(Request $request)
    {
        $store = $request->route('store');

        $request->validate([
            'protected_actions' => 'nullable|array'
        ]);

        $protectedActions = $request->input('protected_actions', []);
        $store->updateProtectedActions($protectedActions);

        return redirect()
            ->route('tenant.admin.master-key.index', $store->slug)
            ->with('swal_success', '✅ Acciones protegidas actualizadas');
    }

    /**
     * Verificar la clave maestra (AJAX)
     */
    public function verify(Request $request)
    {
        $store = $request->route('store');

        $request->validate([
            'key' => 'required|string',
            'action' => 'required|string'
        ]);

        // Validar que la tienda tenga clave maestra
        if (!$store->hasMasterKey()) {
            return response()->json([
                'success' => false,
                'message' => 'No hay clave maestra configurada'
            ], 400);
        }

        // Verificar la clave
        if (!$store->verifyMasterKey($request->key)) {
            // Registrar intento fallido
            Log::warning('Master key failed attempt', [
                'store_id' => $store->id,
                'user_id' => auth()->id(),
                'action' => $request->action,
                'ip' => $request->ip()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Clave incorrecta'
            ], 403);
        }

        // Verificar que la acción requiera clave
        $actionParts = explode('.', $request->action);
        
        if (count($actionParts) !== 2) {
            return response()->json([
                'success' => false,
                'message' => 'Formato de acción inválido'
            ], 400);
        }

        [$module, $action] = $actionParts;

        if (!$store->isActionProtected($module, $action)) {
            return response()->json([
                'success' => false,
                'message' => 'Esta acción no requiere clave maestra'
            ], 400);
        }

        // Log de acceso exitoso
        Log::info('Master key verified successfully', [
            'store_id' => $store->id,
            'user_id' => auth()->id(),
            'action' => $request->action,
            'ip' => $request->ip()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Clave verificada correctamente'
        ]);
    }

    /**
     * Eliminar la clave maestra
     */
    public function destroy(Request $request)
    {
        $store = $request->route('store');

        $request->validate([
            'current_key' => 'required|string'
        ], [
            'current_key.required' => 'Debes ingresar la clave actual para desactivarla'
        ]);

        // Verificar que la clave actual sea correcta
        if (!$store->verifyMasterKey($request->current_key)) {
            return back()->withErrors([
                'current_key' => 'La clave ingresada es incorrecta'
            ]);
        }

        $store->removeMasterKey();

        return redirect()
            ->route('tenant.admin.master-key.index', $store->slug)
            ->with('swal_success', '🔓 Clave maestra desactivada correctamente');
    }

    /**
     * Solicitar recuperación de clave maestra
     */
    public function requestRecovery(Request $request)
    {
        $store = $request->route('store');

        // Verificar que la tienda tenga clave maestra
        if (!$store->hasMasterKey()) {
            return back()->with('error', 'No hay clave maestra configurada para recuperar');
        }

        // Verificar que no haya una solicitud pendiente
        $pendingRequest = MasterKeyRecoveryRequest::where('store_id', $store->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingRequest) {
            return back()->with('info', 'Ya existe una solicitud de recuperación pendiente');
        }

        // Crear la solicitud
        MasterKeyRecoveryRequest::create([
            'store_id' => $store->id,
            'requested_by' => auth()->id(),
            'status' => 'pending'
        ]);

        Log::info('Master key recovery requested', [
            'store_id' => $store->id,
            'user_id' => auth()->id(),
            'ip' => $request->ip()
        ]);

        return redirect()
            ->route('tenant.admin.master-key.index', $store->slug)
            ->with('swal_success', '✅ Solicitud de recuperación enviada al SuperAdmin');
    }
}

