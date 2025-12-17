<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Features\TenantAdmin\Models\Ticker;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class TickerController extends Controller
{
    /**
     * Mostrar lista de tickers
     */
    public function index(Request $request): View
    {
        $store = view()->shared('currentStore');
        
        $tickers = Ticker::forStore($store->id)->ordered()->get();
        
        // Obtener configuración global (del primer ticker o valores por defecto)
        $firstTicker = $tickers->first();
        $globalConfig = [
            'background_color' => $firstTicker->background_color ?? '#1e293b',
            'text_color' => $firstTicker->text_color ?? '#ffffff',
            'scroll_speed' => $firstTicker->scroll_speed ?? 'medium',
        ];

        // Preparar tickers para JavaScript
        $tickersJson = $tickers->map(function($ticker) {
            return [
                'id' => $ticker->id,
                'text' => $ticker->text,
                'is_active' => $ticker->is_active,
                'sort_order' => $ticker->sort_order,
            ];
        })->values();

        return view('tenant-admin::Core/ticker.index', compact(
            'tickers',
            'tickersJson',
            'store',
            'globalConfig'
        ));
    }

    /**
     * Guardar o actualizar ticker
     */
    public function store(Request $request): JsonResponse
    {
        $store = view()->shared('currentStore');
        
        // Validar límite de 8 tickers
        $currentCount = Ticker::forStore($store->id)->count();
        if ($currentCount >= 8 && !$request->has('id')) {
            return response()->json([
                'error' => 'Has alcanzado el límite máximo de 8 textos para el ticker.'
            ], 422);
        }

        $validated = $request->validate([
            'id' => 'nullable|exists:tickers,id',
            'text' => 'required|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'background_color' => 'nullable|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'text_color' => 'nullable|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'scroll_speed' => 'nullable|in:slow,medium,fast',
        ]);

        try {
            DB::beginTransaction();

            if ($request->has('id') && $request->id) {
                // Actualizar ticker existente
                $ticker = Ticker::where('id', $request->id)
                    ->where('store_id', $store->id)
                    ->firstOrFail();
                
                $ticker->update([
                    'text' => $validated['text'],
                    'emoji' => null, // Los emojis ahora van dentro del texto
                    'is_active' => $validated['is_active'] ?? true,
                    'sort_order' => $validated['sort_order'] ?? $ticker->sort_order,
                ]);
            } else {
                // Crear nuevo ticker
                $maxSortOrder = Ticker::forStore($store->id)->max('sort_order') ?? 0;
                
                $ticker = Ticker::create([
                    'store_id' => $store->id,
                    'text' => $validated['text'],
                    'emoji' => null, // Los emojis ahora van dentro del texto
                    'is_active' => $validated['is_active'] ?? true,
                    'sort_order' => $maxSortOrder + 1,
                    'background_color' => $validated['background_color'] ?? '#1e293b',
                    'text_color' => $validated['text_color'] ?? '#ffffff',
                    'scroll_speed' => $validated['scroll_speed'] ?? 'medium',
                ]);
            }

            // Si se actualiza configuración global, actualizar todos los tickers
            if ($request->has('background_color') || $request->has('text_color') || $request->has('scroll_speed')) {
                $updateData = [];
                if ($request->has('background_color')) {
                    $updateData['background_color'] = $validated['background_color'];
                }
                if ($request->has('text_color')) {
                    $updateData['text_color'] = $validated['text_color'];
                }
                if ($request->has('scroll_speed')) {
                    $updateData['scroll_speed'] = $validated['scroll_speed'];
                }
                
                if (!empty($updateData)) {
                    Ticker::forStore($store->id)->update($updateData);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'ticker' => $ticker->fresh(),
                'message' => $request->has('id') ? 'Ticker actualizado correctamente.' : 'Ticker creado correctamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al guardar el ticker: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar orden de tickers
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $store = view()->shared('currentStore');
        
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:tickers,id',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->order as $index => $tickerId) {
                Ticker::where('id', $tickerId)
                    ->where('store_id', $store->id)
                    ->update(['sort_order' => $index + 1]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Orden actualizado correctamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al actualizar el orden: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle estado activo/inactivo
     */
    public function toggleStatus(Request $request, Ticker $ticker): JsonResponse
    {
        $store = view()->shared('currentStore');
        
        if ($ticker->store_id !== $store->id) {
            return response()->json([
                'error' => 'No autorizado'
            ], 403);
        }

        $ticker->update([
            'is_active' => !$ticker->is_active
        ]);

        return response()->json([
            'success' => true,
            'ticker' => $ticker->fresh(),
            'message' => $ticker->is_active ? 'Ticker activado correctamente.' : 'Ticker desactivado correctamente.'
        ]);
    }

    /**
     * Eliminar ticker
     */
    public function destroy(Request $request, $tickerId = null): JsonResponse
    {
        // Obtener el ID del ticker directamente del request si no viene como parámetro
        if ($tickerId === null || is_object($tickerId)) {
            $tickerId = $request->route('tickerId') ?? $request->input('tickerId');
            
            // Si aún es un objeto, intentar obtenerlo de la URL
            if (is_object($tickerId)) {
                $pathSegments = explode('/', trim($request->getPathInfo(), '/'));
                // Buscar el último segmento numérico
                foreach (array_reverse($pathSegments) as $segment) {
                    if (is_numeric($segment)) {
                        $tickerId = $segment;
                        break;
                    }
                }
            }
        }
        
        // Validar que tickerId sea válido
        if (!is_numeric($tickerId)) {
            \Log::error('TickerId inválido en destroy', [
                'tickerId_type' => gettype($tickerId),
                'tickerId_value' => $tickerId,
                'path' => $request->getPathInfo(),
            ]);
            
            return response()->json([
                'error' => 'ID de ticker inválido'
            ], 400);
        }
        
        $tickerId = (int) $tickerId;
        
        $store = view()->shared('currentStore');
        
        // Verificar que $store sea un objeto Store válido
        if (!$store || !is_object($store)) {
            \Log::error('Store inválido en destroy - no es objeto', [
                'store_type' => gettype($store),
            ]);
            
            return response()->json([
                'error' => 'Error de configuración del sistema'
            ], 500);
        }
        
        // Verificar que tenga la propiedad id y que sea numérica
        if (!isset($store->id) || !is_numeric($store->id)) {
            \Log::error('Store inválido en destroy - ID no válido', [
                'store_type' => gettype($store),
                'has_id' => isset($store->id),
                'id_value' => $store->id ?? 'null',
                'id_type' => isset($store->id) ? gettype($store->id) : 'N/A',
            ]);
            
            return response()->json([
                'error' => 'Error de configuración del sistema'
            ], 500);
        }
        
        // Obtener el ID de la tienda de forma segura
        $storeId = is_numeric($store->id) ? (int) $store->id : null;
        
        if ($storeId === null) {
            \Log::error('No se pudo obtener store_id válido', [
                'store_id_value' => $store->id,
            ]);
            
            return response()->json([
                'error' => 'Error de configuración del sistema'
            ], 500);
        }
        
        // Log para debugging
        \Log::info('Intentando eliminar ticker', [
            'ticker_id' => $tickerId,
            'store_id' => $storeId,
            'store_slug' => $store->slug ?? 'N/A',
        ]);
        
        // Buscar el ticker por ID directamente
        $ticker = Ticker::where('id', $tickerId)->first();
        
        if (!$ticker) {
            \Log::warning('Ticker no encontrado', [
                'ticker_id' => $tickerId,
                'store_id' => $storeId,
            ]);
            
            return response()->json([
                'error' => 'Ticker no encontrado'
            ], 404);
        }
        
        // Verificar que pertenezca a la tienda
        if ((int) $ticker->store_id !== $storeId) {
            \Log::warning('Ticker no pertenece a la tienda', [
                'ticker_id' => $tickerId,
                'ticker_store_id' => $ticker->store_id,
                'current_store_id' => $storeId,
            ]);
            
            return response()->json([
                'error' => 'No autorizado'
            ], 403);
        }

        try {
            $ticker->delete();

            \Log::info('Ticker eliminado exitosamente', [
                'ticker_id' => $tickerId,
                'store_id' => $storeId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ticker eliminado correctamente.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar ticker', [
                'ticker_id' => $tickerId,
                'store_id' => $storeId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Error al eliminar el ticker: ' . $e->getMessage()
            ], 500);
        }
    }
}
