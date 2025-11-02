<?php

namespace App\Features\TenantAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\Table;
use App\Shared\Models\DineInSetting;
use App\Shared\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
{
    /**
     * Listado de mesas/habitaciones
     */
    public function index(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $type = $request->get('type', 'mesa'); // 'mesa' o 'habitacion'
        
        $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
        $reservasMesasEnabled = featureEnabled($store, 'reservas_mesas');
        $canCreateNew = true; // Por defecto puede crear
        
        // Si es habitación y reservas_hotel está activo, usar habitaciones de Room
        if ($type === 'habitacion' && $reservasHotelEnabled) {
            // Obtener habitaciones desde la tabla rooms (reservas de hotel)
            $rooms = \App\Shared\Models\Room::where('store_id', $store->id)
                ->with('roomType')
                ->orderBy('room_number')
                ->get();
            
            // Convertir Room a formato compatible con Table para la vista
            $tables = $rooms->map(function($room) use ($store) {
                // Buscar si existe una Table correspondiente para esta habitación
                $table = Table::where('store_id', $store->id)
                    ->where('type', 'habitacion')
                    ->where('table_number', $room->room_number)
                    ->with('currentOrder')
                    ->first();
                
                // Si no existe Table, crear un objeto virtual con datos de Room
                if (!$table) {
                    // Usar ID 0 para habitaciones virtuales (el controlador creará la Table al generar QR)
                    return (object) [
                        'id' => 0, // ID temporal para habitaciones virtuales
                        'table_number' => $room->room_number,
                        'type' => 'habitacion',
                        'capacity' => $room->roomType->max_occupancy ?? null,
                        'is_active' => $room->status === 'available',
                        'status' => $this->mapRoomStatusToTableStatus($room->status),
                        'current_order_id' => null,
                        'currentOrder' => null,
                        'qr_code' => null,
                        'qr_url' => null,
                        'is_from_room_system' => true, // Flag para identificar que viene de Room
                        'room_id' => $room->id,
                        'room_type_name' => $room->roomType->name ?? 'N/A',
                    ];
                }
                
                // Si existe Table (ya tiene QR), agregar flag y asegurar que tenga room_id para referencia
                // IMPORTANTE: Cargar la relación currentOrder si no está cargada
                if (!$table->relationLoaded('currentOrder')) {
                    $table->load('currentOrder');
                }
                
                $table->is_from_room_system = false; // Ya no es virtual, tiene Table real
                $table->room_id = $room->id; // Mantener referencia al Room original
                $table->room_type_name = $room->roomType->name ?? 'N/A';
                // Asegurar que el ID sea numérico (no string)
                if (!is_numeric($table->id)) {
                    $table->id = (int) $table->id;
                }
                
                // Asegurar que qr_code y qr_url estén disponibles
                if (!$table->qr_code && !$table->qr_url) {
                    // Si la Table existe pero no tiene QR, puede que se haya creado recientemente
                    // No hacer nada, se mostrará como sin QR
                }
                
                return $table;
            });
            
            // No permitir crear nuevas habitaciones si reservas_hotel está activo
            $canCreateNew = false;
            
            // NO incluir Tables creadas directamente si reservas_hotel está activo
            // Las habitaciones SOLO deben venir del sistema de reservas (tabla rooms)
            // Esto asegura que no haya habitaciones "huérfanas" que no correspondan a rooms reales
            
        } elseif ($type === 'habitacion') {
            // Si es habitación, DEBE tener reservas_hotel activo
            if (!$reservasHotelEnabled) {
                abort(404, 'Servicio a habitación requiere que las reservas de hotel estén activas. Activa el feature "Reservas de Hotel" primero.');
            }
            // Si llegamos aquí pero no entramos en el primer if, significa que reservas_hotel está activo
            // pero no hay habitaciones configuradas aún. Esto es válido, solo mostrar lista vacía.
            $tables = collect([]);
        } else {
            // Lógica para mesas (consumo_local)
            // IMPORTANTE: Asegurar que type sea exactamente 'mesa' para evitar mostrar habitaciones
            // Validación adicional: asegurar que el type del request sea 'mesa'
            if ($type !== 'mesa') {
                // Si por alguna razón type no es 'mesa', forzarlo
                $type = 'mesa';
            }
            
            $query = Table::where('store_id', $store->id)
                ->where('type', '=', 'mesa') // Filtro estricto: SOLO mesas (uso === para evitar NULL o otros valores)
                ->whereNotNull('type') // Asegurar que type no sea NULL
                ->with('currentOrder');
            
            // Si reservas_mesas está activo, mostrar TODAS las mesas de tipo 'mesa'
            // Cuando reservas_mesas está activo, todas las mesas de tipo 'mesa' vienen del sistema de reservas
            // No necesitamos filtrar por whereHas('reservations') porque una mesa puede estar creada pero aún no tener reservas
            // Si reservas_mesas NO está activo, mostrar todas las mesas (las creadas manualmente para consumo_local)
            
            // Contar pedidos activos por mesa/habitación
            $query->withCount(['currentOrder' => function($q) {
                $q->whereIn('status', ['pending', 'confirmed', 'preparing']);
            }]);
            
            $tables = $query->orderBy('table_number')->get();
            
            // Validación adicional: filtrar cualquier elemento que no sea mesa
            $tables = $tables->filter(function($table) {
                return $table->type === 'mesa' || (is_object($table) && isset($table->type) && $table->type === 'mesa');
            });
            
            // Agregar flags por defecto
            foreach ($tables as $table) {
                $table->is_from_room_system = false;
                $table->room_id = null;
                $table->room_type_name = null;
                // Asegurar que type sea 'mesa'
                if (is_object($table) && method_exists($table, 'setAttribute')) {
                    $table->setAttribute('type', 'mesa');
                } elseif (is_object($table)) {
                    $table->type = 'mesa';
                }
            }
        }
        
        // Obtener configuración
        $dineInSettings = DineInSetting::getOrCreateForStore($store->id);
        
        // Estadísticas
        $stats = [
            'total' => $tables->count(),
            'available' => $tables->where('status', 'available')->count(),
            'occupied' => $tables->where('status', 'occupied')->count(),
            'reserved' => $tables->where('status', 'reserved')->count(),
        ];
        
        return view('tenant-admin::dine-in.tables.index', compact('store', 'tables', 'type', 'dineInSettings', 'stats', 'canCreateNew', 'reservasHotelEnabled'));
    }
    
    /**
     * Mapear estado de Room a estado de Table
     */
    private function mapRoomStatusToTableStatus($roomStatus)
    {
        $mapping = [
            'available' => 'available',
            'occupied' => 'occupied',
            'maintenance' => 'reserved',
            'blocked' => 'reserved',
        ];
        
        return $mapping[$roomStatus] ?? 'available';
    }

    /**
     * Dashboard en tiempo real
     */
    public function dashboard(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $type = $request->get('type', 'mesa'); // 'mesa' o 'habitacion'
        
        $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
        
        // Si es habitación y reservas_hotel está activo, usar habitaciones de Room
        if ($type === 'habitacion' && $reservasHotelEnabled) {
            $rooms = \App\Shared\Models\Room::where('store_id', $store->id)
                ->with('roomType')
                ->orderBy('room_number')
                ->get();
            
            // Convertir Room a formato compatible
            $tables = $rooms->map(function($room) use ($store) {
                $table = Table::where('store_id', $store->id)
                    ->where('type', 'habitacion')
                    ->where('table_number', $room->room_number)
                    ->with(['currentOrder' => function($q) {
                        $q->with('items');
                    }])
                    ->first();
                
                if (!$table) {
                    return (object) [
                        'id' => 'room_' . $room->id,
                        'table_number' => $room->room_number,
                        'type' => 'habitacion',
                        'status' => $this->mapRoomStatusToTableStatus($room->status),
                        'currentOrder' => null,
                        'is_from_room_system' => true,
                    ];
                }
                
                $table->is_from_room_system = false;
                return $table;
            });
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
        $stats = [
            'total' => $tables->count(),
            'available' => $tables->where('status', 'available')->count(),
            'occupied' => $tables->where('status', 'occupied')->count(),
            'reserved' => $tables->where('status', 'reserved')->count(),
            'total_revenue' => $activeTables->sum(function($table) {
                return $table->currentOrder->total ?? 0;
            }),
        ];
        
        return view('tenant-admin::dine-in.dashboard', compact('store', 'tables', 'activeTables', 'type', 'stats'));
    }

    /**
     * API: Obtener estado actualizado de mesas/habitaciones (para polling)
     */
    public function getStatus(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $type = $request->get('type', 'mesa');
        
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
        
        $stats = [
            'total' => $tables->count(),
            'available' => $tables->where('status', 'available')->count(),
            'occupied' => $tables->where('status', 'occupied')->count(),
            'reserved' => $tables->where('status', 'reserved')->count(),
            'total_revenue' => $activeTables->sum(function($table) {
                return $table->currentOrder->total ?? 0;
            }),
        ];
        
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
    }

    /**
     * Crear mesa/habitación
     */
    public function store(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Si intentan crear una habitación y reservas_hotel está activo, no permitir
        $type = $request->input('type', 'mesa');
        $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
        
        if ($type === 'habitacion' && $reservasHotelEnabled) {
            return response()->json([
                'success' => false,
                'message' => 'No se pueden crear habitaciones manualmente cuando las reservas de hotel están activas. Las habitaciones se gestionan desde Reservas de Hotel.'
            ], 422);
        }
        
        $validator = Validator::make($request->all(), [
            'table_number' => [
                'required',
                'string',
                'max:10',
                function ($attribute, $value, $fail) use ($store, $request) {
                    $exists = Table::where('store_id', $store->id)
                        ->where('table_number', $value)
                        ->where('type', $request->input('type', 'mesa'))
                        ->exists();
                    if ($exists) {
                        $fail('Ya existe una ' . ($request->input('type') === 'habitacion' ? 'habitación' : 'mesa') . ' con ese número.');
                    }
                }
            ],
            'type' => 'required|in:mesa,habitacion',
            'capacity' => 'nullable|integer|min:1|max:20',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $table = Table::create([
            'store_id' => $store->id,
            'table_number' => $request->table_number,
            'type' => $request->type,
            'capacity' => $request->capacity ?? 4,
            'is_active' => true,
            'status' => 'available',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => ucfirst($table->type) . ' creada exitosamente',
            'table' => $table->load('currentOrder')
        ]);
    }

    /**
     * Actualizar mesa/habitación
     */
    public function update(Request $request, $id)
    {
        $store = view()->shared('currentStore');
        
        $table = Table::where('store_id', $store->id)
            ->findOrFail($id);
        
        // Si es habitación y reservas_hotel está activo, verificar que NO venga del sistema
        $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
        if ($table->type === 'habitacion' && $reservasHotelEnabled) {
            // Verificar si esta habitación corresponde a una Room del sistema de reservas
            $room = \App\Shared\Models\Room::where('store_id', $store->id)
                ->where('room_number', $table->table_number)
                ->first();
            
            if ($room) {
                // Esta habitación viene del sistema de reservas, no permitir edición manual
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede editar una habitación que pertenece al sistema de reservas de hotel. Edítala desde Reservas de Hotel.'
                ], 422);
            }
        }
        
        $validator = Validator::make($request->all(), [
            'table_number' => [
                'required',
                'string',
                'max:10',
                function ($attribute, $value, $fail) use ($store, $table) {
                    $exists = Table::where('store_id', $store->id)
                        ->where('table_number', $value)
                        ->where('type', $table->type)
                        ->where('id', '!=', $table->id)
                        ->exists();
                    if ($exists) {
                        $fail('Ya existe una ' . ($table->type === 'habitacion' ? 'habitación' : 'mesa') . ' con ese número.');
                    }
                }
            ],
            'capacity' => 'nullable|integer|min:1|max:20',
            'is_active' => 'nullable|boolean',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $table->update([
            'table_number' => $request->table_number,
            'capacity' => $request->capacity ?? $table->capacity,
            'is_active' => $request->has('is_active') ? $request->is_active : $table->is_active,
        ]);
        
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
        $store = view()->shared('currentStore');
        
        $table = Table::where('store_id', $store->id)
            ->findOrFail($id);
        
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
        
        // Eliminar QR si existe
        if ($table->qr_code) {
            // TODO: Eliminar archivo QR si se guarda como archivo
        }
        
        $table->delete();
        
        return response()->json([
            'success' => true,
            'message' => ucfirst($table->type) . ' eliminada exitosamente'
        ]);
    }

    /**
     * Generar QR para mesa/habitación
     */
    public function generateQR(Request $request, $id)
    {
        // Obtener store desde view shared (consistente con otros métodos)
        $store = view()->shared('currentStore');
        
        // Obtener id desde la ruta si no viene como parámetro
        if ($id === null) {
            $id = $request->route('id', 0);
        }
        
        $type = $request->get('type', 'mesa'); // Obtener tipo de la request
        
        $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
        
        // Convertir $id a int si es necesario (puede venir como string desde la URL)
        // Si $id es un objeto Store (por error de route binding), intentar obtenerlo de la ruta
        if ($id instanceof Store) {
            // Si Laravel resolvió mal el parámetro, obtener el id desde la ruta
            $id = $request->route('id', 0);
        }
        $id = is_numeric($id) ? (int) $id : 0;
        
        // Si es habitación y viene del sistema de reservas, puede ser una habitación virtual
        if ($type === 'habitacion' && $reservasHotelEnabled && $id == 0) {
            // Intentar obtener la mesa/habitación desde la request o crear una nueva
            $tableNumber = $request->input('table_number');
            $roomId = $request->input('room_id'); // ID de la habitación en la tabla rooms
            
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
                // Obtener información de la habitación desde rooms si es posible
                $room = null;
                if ($roomId) {
                    $room = \App\Shared\Models\Room::where('store_id', $store->id)
                        ->where('id', $roomId)
                        ->with('roomType')
                        ->first();
                } else {
                    // Buscar por número de habitación
                    $room = \App\Shared\Models\Room::where('store_id', $store->id)
                        ->where('room_number', $tableNumber)
                        ->with('roomType')
                        ->first();
                }
                
                // Determinar capacidad
                $capacity = 2; // Default
                if ($room && $room->roomType) {
                    $capacity = $room->roomType->max_occupancy ?? 2;
                } elseif ($room && isset($room->room_type_id)) {
                    // Si roomType no se cargó, intentar cargarlo manualmente
                    $roomType = \App\Shared\Models\RoomType::find($room->room_type_id);
                    if ($roomType) {
                        $capacity = $roomType->max_occupancy ?? 2;
                    }
                }
                
                // Crear la Table para esta habitación
                try {
                    $table = Table::create([
                        'store_id' => $store->id,
                        'table_number' => $tableNumber,
                        'type' => 'habitacion',
                        'capacity' => $capacity,
                        'is_active' => true,
                        'status' => 'available',
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Error al crear Table para habitación virtual', [
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
        
        // URL que apuntará el QR - SIEMPRE usar la URL de la request actual (más confiable)
        // Esto asegura que funcione en cualquier entorno sin depender de config('app.url')
        $baseUrl = $request->root(); // Obtiene la URL base de la request actual
        
        // Si root() devuelve vacío o localhost sin protocolo, construir manualmente
        if (empty($baseUrl) || $baseUrl === 'localhost') {
            $scheme = $request->getScheme(); // http o https
            $host = $request->getHost(); // dominio o localhost
            $port = $request->getPort(); // puerto si existe (8000, 443, etc.)
            
            // Construir URL base
            $baseUrl = $scheme . '://' . $host;
            
            // Agregar puerto solo si no es el puerto estándar (80 para http, 443 para https)
            if ($port && $port != 80 && $port != 443) {
                $baseUrl .= ':' . $port;
            }
        }
        
        // Asegurar que la URL no termine en slash
        $baseUrl = rtrim($baseUrl, '/');
        
        // Construir URL completa del QR - IMPORTANTE: incluir el store slug
        // Formato: {baseUrl}/{store_slug}/{mesa|habitacion}/{number}
        $url = $baseUrl . '/' . $store->slug . '/' . ($table->type === Table::TYPE_MESA ? 'mesa' : 'habitacion') . '/' . $table->table_number;
        
        \Log::info('Generando QR URL', [
            'baseUrl' => $baseUrl,
            'store_slug' => $store->slug,
            'type' => $table->type,
            'table_number' => $table->table_number,
            'final_url' => $url,
            'request_root' => $request->root(),
            'request_host' => $request->getHost(),
            'request_scheme' => $request->getScheme(),
            'request_port' => $request->getPort()
        ]);
        
        // Generar QR usando SimpleSoftwareIO/simple-qrcode
        if (!extension_loaded('gd')) {
            return response()->json([
                'success' => false,
                'message' => 'Extensión PHP GD no está habilitada. Habilitar en php.ini y reiniciar servidor.'
            ], 500);
        }
        
        try {
            // Usar el helper de QrCode (auto-descubierto por Laravel)
            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(300)
                ->generate($url);
            
            // Actualizar la Table con el QR generado
            $table->qr_code = $qrCode;
            $table->qr_url = $url;
            $table->save();
            
            return response()->json([
                'success' => true,
                'qr_code' => $qrCode,
                'qr_url' => $url,
                'table_id' => $table->id, // Retornar el ID real para actualizar el frontend
                'message' => 'QR generado exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al generar QR para mesa/habitación', [
                'table_id' => $table->id ?? null,
                'table_number' => $table->table_number ?? null,
                'url' => $url,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al generar QR: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Liberar mesa/habitación
     */
    public function liberate($id)
    {
        $store = view()->shared('currentStore');
        
        $table = Table::where('store_id', $store->id)
            ->findOrFail($id);
        
        $table->liberate();
        
        return response()->json([
            'success' => true,
            'message' => ucfirst($table->type) . ' liberada exitosamente',
            'table' => $table->fresh()
        ]);
    }

    /**
     * Actualizar configuración de dine-in
     */
    public function updateSettings(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $validator = Validator::make($request->all(), [
            'is_enabled' => 'nullable|boolean',
            'charge_service_fee' => 'nullable|boolean',
            'service_fee_type' => 'nullable|in:percentage,fixed',
            'service_fee_percentage' => 'nullable|integer|min:0|max:100',
            'service_fee_fixed' => 'nullable|numeric|min:0',
            'suggest_tip' => 'nullable|boolean',
            'tip_options' => 'nullable|array',
            'tip_options.*' => 'integer|min:0|max:100',
            'allow_custom_tip' => 'nullable|boolean',
            'require_table_number' => 'nullable|boolean',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
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
