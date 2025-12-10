<?php

namespace App\Features\TenantAdmin\Controllers\Verticals\Restaurant;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\Table;
use App\Shared\Models\DineInSetting;
use App\Shared\Models\Order;
use App\Features\TenantAdmin\Requests\Verticals\Restaurant\StoreTableRequest;
use App\Features\TenantAdmin\Requests\Verticals\Restaurant\UpdateTableRequest;
use App\Features\TenantAdmin\Requests\Verticals\Restaurant\UpdateDineInSettingsRequest;
use App\Features\TenantAdmin\Services\Verticals\Restaurant\TableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
{
    protected TableService $tableService;
    
    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }
    /**
     * Listado de mesas/habitaciones
     * 
     * ✅ OPTIMIZACIÓN: Usa TableService para lógica de negocio
     * ✅ OPTIMIZACIÓN: Paginación con 50 items por página
     */
    public function index(Request $request)
    {
        $store = view()->shared('currentStore');
        $type = $request->get('type', 'mesa');
        
        $result = $this->tableService->getTablesForStore($store, $type);
        $tables = $result['tables'];
        $canCreateNew = $result['canCreateNew'];
        
        // ✅ OPTIMIZACIÓN: Paginación para mejor performance con muchas mesas
        $perPage = 50;
        $currentPage = $request->get('page', 1);
        $total = $tables->count();
        $offset = ($currentPage - 1) * $perPage;
        $paginatedTables = $tables->slice($offset, $perPage);
        $totalPages = ceil($total / $perPage);
        
        $dineInSettings = DineInSetting::getOrCreateForStore($store->id);
        $stats = $this->tableService->calculateStats($tables); // Stats de TODAS las mesas, no solo las paginadas
        $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
        
        return view('tenant-admin::verticals.restaurant.dine-in.tables.index', compact(
            'store', 
            'tables', // Pasar todas para stats
            'paginatedTables', // Pasar solo las paginadas para mostrar
            'type', 
            'dineInSettings', 
            'stats', 
            'canCreateNew', 
            'reservasHotelEnabled',
            'currentPage',
            'totalPages',
            'perPage'
        ));
    }

    /**
     * Dashboard en tiempo real
     * 
     * ✅ OPTIMIZACIÓN: Usa TableService para lógica de negocio
     */
    public function dashboard(Request $request)
    {
        $store = view()->shared('currentStore');
        $type = $request->get('type', 'mesa');
        
        $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
        
        // Si es habitación y reservas_hotel está activo, usar habitaciones de Room
        if ($type === 'habitacion' && $reservasHotelEnabled) {
            $tables = $this->tableService->getRoomsAsTables($store);
        } else {
            // Lógica normal para mesas
            $tables = Table::where('store_id', $store->id)
                ->where('type', $type)
                ->where('is_active', true)
                ->with(['currentOrder' => function($q) {
                    $q->with('items');
                }])
                ->orderBy('table_number')
                ->get();
        }
        
        // Filtrar solo las ocupadas/reservadas
        $activeTables = $tables->filter(function($table) {
            return in_array($table->status, ['occupied', 'reserved']) && $table->currentOrder;
        });
        
        // Estadísticas
        $stats = $this->tableService->calculateStats($tables);
        $stats['total_revenue'] = $activeTables->sum(function($table) {
            return $table->currentOrder->total ?? 0;
        });
        
        return view('tenant-admin::verticals.restaurant.dine-in.dashboard', compact('store', 'tables', 'activeTables', 'type', 'stats'));
    }

    /**
     * API: Obtener estado actualizado de mesas/habitaciones (para polling)
     * 
     * ✅ OPTIMIZACIÓN: Cache con TTL 30s para reducir carga en polling frecuente
     */
    public function getStatus(Request $request)
    {
        $store = view()->shared('currentStore');
        $type = $request->get('type', 'mesa');
        
        $cacheKey = "dine_in_status_{$store->id}_{$type}";
        
        return \Cache::remember($cacheKey, 30, function () use ($store, $type) {
            $tables = Table::where('store_id', $store->id)
                ->where('type', $type)
                ->where('is_active', true)
                ->with(['currentOrder' => function($q) {
                    $q->with('items');
                }])
                ->orderBy('table_number')
                ->get();
            
            $activeTables = $tables->filter(function($table) {
                return in_array($table->status, ['occupied', 'reserved']) && $table->currentOrder;
            });
            
            $stats = $this->tableService->calculateStats($tables);
            $stats['total_revenue'] = $activeTables->sum(function($table) {
                return $table->currentOrder->total ?? 0;
            });
            
            return response()->json([
                'success' => true,
                'tables' => $tables->map(function($table) {
                    return [
                        'id' => $table->id,
                        'table_number' => $table->table_number,
                        'status' => $table->status,
                        'current_order' => $table->currentOrder ? [
                            'id' => $table->currentOrder->id,
                            'order_number' => $table->currentOrder->order_number,
                            'status' => $table->currentOrder->status,
                            'total' => $table->currentOrder->total,
                            'created_at' => $table->currentOrder->created_at->diffForHumans(),
                            'items_count' => $table->currentOrder->items->count(),
                        ] : null,
                    ];
                }),
                'active_tables' => $activeTables->map(function($table) {
                    $order = $table->currentOrder;
                    $timeElapsed = $order->created_at->diffInMinutes(now());
                    
                    return [
                        'id' => $table->id,
                        'table_number' => $table->table_number,
                        'status' => $table->status,
                        'order' => [
                            'id' => $order->id,
                            'order_number' => $order->order_number,
                            'status' => $order->status,
                            'total' => $order->total,
                            'time_elapsed' => $timeElapsed,
                            'time_elapsed_formatted' => $timeElapsed . 'min',
                            'items' => $order->items->map(function($item) {
                                return [
                                    'name' => $item->product_name,
                                    'quantity' => $item->quantity,
                                ];
                            }),
                            'tip_amount' => $order->tip_amount ?? 0,
                            'service_charge' => $order->service_charge ?? 0,
                        ],
                    ];
                }),
                'stats' => $stats,
            ]);
        });
    }

    /**
     * Crear mesa/habitación
     * 
     * ✅ OPTIMIZACIÓN: Usa FormRequest para validación (cumple .cursorrules)
     */
    public function store(StoreTableRequest $request)
    {
        $store = view()->shared('currentStore');
        
        // Validar límites del plan para mesas (solo para type = 'mesa')
        if ($request->type === 'mesa') {
            $maxTables = $store->plan->max_tables ?? 0;
            
            if ($maxTables > 0) { // 0 = ilimitado
                $currentTables = Table::where('store_id', $store->id)
                    ->where('type', 'mesa')
                    ->count();
                
                if ($currentTables >= $maxTables) {
                    return response()->json([
                        'success' => false,
                        'message' => "Has alcanzado el límite de {$maxTables} mesas para tu plan {$store->plan->name}. Actualiza tu plan para agregar más mesas."
                    ], 422);
                }
            }
        }
        
        $table = Table::create([
            'store_id' => $store->id,
            'tenant_id' => $store->id, // Sincronizar con store_id
            'table_number' => $request->table_number,
            'type' => $request->type,
            'capacity' => $request->capacity ?? 4,
            'is_active' => true,
            'status' => 'available',
        ]);
        
        // ✅ OPTIMIZACIÓN: Invalidar cache de status
        \Cache::forget("dine_in_status_{$store->id}_{$request->type}");
        
        return response()->json([
            'success' => true,
            'message' => ucfirst($table->type) . ' creada exitosamente',
            'table' => $table->load('currentOrder')
        ]);
    }

    /**
     * Actualizar mesa/habitación
     * 
     * ✅ OPTIMIZACIÓN: Usa FormRequest para validación (cumple .cursorrules)
     */
    public function update(UpdateTableRequest $request, $id)
    {
        $store = view()->shared('currentStore');
        
        $table = Table::where('store_id', $store->id)
            ->findOrFail($id);
        
        $table->update([
            'table_number' => $request->table_number,
            'capacity' => $request->capacity ?? $table->capacity,
            'is_active' => $request->has('is_active') ? $request->is_active : $table->is_active,
        ]);
        
        // ✅ OPTIMIZACIÓN: Invalidar cache de status
        \Cache::forget("dine_in_status_{$store->id}_{$table->type}");
        
        return response()->json([
            'success' => true,
            'message' => ucfirst($table->type) . ' actualizada exitosamente',
            'table' => $table->fresh(['currentOrder'])
        ]);
    }

    /**
     * Eliminar mesa/habitación
     */
    public function destroy($id)
    {
        try {
            $store = view()->shared('currentStore');
            
            $table = Table::where('store_id', $store->id)
                ->find($id);
            
            if (!$table) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mesa no encontrada'
                ], 404);
            }
            
            // Si es habitación y reservas_hotel está activo, verificar que NO venga del sistema
            $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
            if ($table->type === 'habitacion' && $reservasHotelEnabled) {
                // Verificar si esta habitación corresponde a una Room del sistema de reservas
                $room = \App\Shared\Models\Room::where('store_id', $store->id)
                    ->where('room_number', $table->table_number)
                    ->first();
                
                if ($room) {
                    // Esta habitación viene del sistema de reservas, no permitir eliminación
                    return response()->json([
                        'success' => false,
                        'message' => 'No se puede eliminar una habitación que pertenece al sistema de reservas de hotel. Elimínala desde Reservas de Hotel.'
                    ], 422);
                }
            }
            
            // Verificar que no tenga pedidos activos
            if ($table->current_order_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar una ' . ($table->type === 'habitacion' ? 'habitación' : 'mesa') . ' con pedidos activos'
                ], 422);
            }
            
            // Verificar que no tenga reservaciones activas
            $activeReservations = $table->reservations()
                ->whereIn('status', ['pending', 'confirmed'])
                ->count();
            
            if ($activeReservations > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar una ' . ($table->type === 'habitacion' ? 'habitación' : 'mesa') . ' con reservaciones activas'
                ], 422);
            }
            
            // Eliminar QR si existe
            if ($table->qr_code) {
                // TODO: Eliminar archivo QR si se guarda como archivo
            }
            
            $type = $table->type;
            $table->delete();
            
            // ✅ OPTIMIZACIÓN: Invalidar cache de status
            \Cache::forget("dine_in_status_{$store->id}_{$type}");
            
            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar mesa/habitación', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar QR para mesa/habitación
     * 
     * ✅ OPTIMIZACIÓN: Usa TableService para lógica de negocio
     */
    public function generateQR(Request $request, $id)
    {
        $store = view()->shared('currentStore');
        
        // Obtener id desde la ruta si no viene como parámetro
        if ($id === null) {
            $id = $request->route('id', 0);
        }
        
        $type = $request->get('type', 'mesa');
        $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
        
        // Convertir $id a int si es necesario
        if ($id instanceof Store) {
            $id = $request->route('id', 0);
        }
        $id = is_numeric($id) ? (int) $id : 0;
        
        // Si es habitación y viene del sistema de reservas, puede ser una habitación virtual
        if ($type === 'habitacion' && $reservasHotelEnabled && $id == 0) {
            $tableNumber = $request->input('table_number');
            $roomId = $request->input('room_id');
            
            if (!$tableNumber) {
                return response()->json([
                    'success' => false,
                    'message' => 'Número de habitación no proporcionado'
                ], 422);
            }
            
            // Buscar si ya existe una Table para esta habitación
            $table = Table::where('store_id', $store->id)
                ->where('type', 'habitacion')
                ->where('table_number', $tableNumber)
                ->first();
            
            // Si no existe, crear una nueva Table para esta habitación
            if (!$table) {
                try {
                    $table = $this->tableService->createTableForRoom($store, $tableNumber, $roomId);
                } catch (\Exception $e) {
                    Log::error('Error al crear Table para habitación virtual', [
                        'store_id' => $store->id,
                        'table_number' => $tableNumber,
                        'room_id' => $roomId,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al crear la mesa para la habitación: ' . $e->getMessage()
                    ], 500);
                }
            }
        } else {
            // Búsqueda normal
            $table = Table::where('store_id', $store->id)
                ->findOrFail($id);
        }
        
        // Generar QR usando el service
        $result = $this->tableService->generateQRCode($table, $store, $request);
        
        if (!$result['success']) {
            return response()->json($result, 500);
        }
        
        // ✅ OPTIMIZACIÓN: Invalidar cache de status
        \Cache::forget("dine_in_status_{$store->id}_{$type}");
        
        return response()->json($result);
    }

    /**
     * Liberar mesa/habitación
     */
    public function liberate($id)
    {
        $store = view()->shared('currentStore');
        
        $table = Table::where('store_id', $store->id)
            ->findOrFail($id);
        
        $type = $table->type;
        $table->liberate();
        
        // ✅ OPTIMIZACIÓN: Invalidar cache de status
        \Cache::forget("dine_in_status_{$store->id}_{$type}");
        
        return response()->json([
            'success' => true,
            'message' => ucfirst($type) . ' liberada exitosamente',
            'table' => $table->fresh()
        ]);
    }

    /**
     * Actualizar configuración de dine-in
     * 
     * ✅ OPTIMIZACIÓN: Usa FormRequest para validación (cumple .cursorrules)
     */
    public function updateSettings(UpdateDineInSettingsRequest $request)
    {
        $store = view()->shared('currentStore');
        
        $dineInSettings = DineInSetting::getOrCreateForStore($store->id);
        
        $dineInSettings->update($request->only([
            'is_enabled',
            'charge_service_fee',
            'service_fee_type',
            'service_fee_percentage',
            'service_fee_fixed',
            'suggest_tip',
            'tip_options',
            'allow_custom_tip',
            'require_table_number',
        ]));
        
        return response()->json([
            'success' => true,
            'message' => 'Configuración actualizada exitosamente',
            'settings' => $dineInSettings
        ]);
    }
}
