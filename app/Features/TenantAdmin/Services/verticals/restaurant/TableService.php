<?php

namespace App\Features\TenantAdmin\Services\Verticals\Restaurant;

use App\Shared\Models\Store;
use App\Shared\Models\Table;
use App\Shared\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TableService
{
    /**
     * Obtener mesas/habitaciones para una tienda según el tipo
     * 
     * @param Store $store
     * @param string $type 'mesa' o 'habitacion'
     * @return array ['tables' => Collection, 'canCreateNew' => bool]
     */
    public function getTablesForStore(Store $store, string $type): array
    {
        $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
        $canCreateNew = true;
        
        if ($type === 'habitacion' && $reservasHotelEnabled) {
            // Obtener habitaciones desde la tabla rooms (reservas de hotel)
            $tables = $this->getRoomsAsTables($store);
            $canCreateNew = false;
        } elseif ($type === 'habitacion') {
            // Si es habitación, DEBE tener reservas_hotel activo
            if (!$reservasHotelEnabled) {
                abort(404, 'Servicio a habitación requiere que las reservas de hotel estén activas. Activa el feature "Reservas de Hotel" primero.');
            }
            $tables = collect([]);
        } else {
            // Lógica para mesas (consumo_local)
            $tables = $this->getTablesByType($store, 'mesa');
        }
        
        return [
            'tables' => $tables,
            'canCreateNew' => $canCreateNew,
        ];
    }
    
    /**
     * Obtener mesas por tipo
     * 
     * @param Store $store
     * @param string $type
     * @return Collection
     */
    public function getTablesByType(Store $store, string $type): Collection
    {
        $query = Table::where('store_id', $store->id)
            ->where('type', '=', $type)
            ->whereNotNull('type')
            ->with('currentOrder');
        
        // Contar pedidos activos por mesa/habitación
        $query->withCount(['currentOrder' => function($q) {
            $q->whereIn('status', ['pending', 'confirmed', 'preparing']);
        }]);
        
        $tables = $query->orderBy('table_number')->get();
        
        // Validación adicional: filtrar cualquier elemento que no sea del tipo correcto
        $tables = $tables->filter(function($table) use ($type) {
            return $table->type === $type;
        });
        
        // Agregar flags por defecto
        foreach ($tables as $table) {
            $table->is_from_room_system = false;
            $table->room_id = null;
            $table->room_type_name = null;
            $table->setAttribute('type', $type);
        }
        
        return $tables;
    }
    
    /**
     * Convertir habitaciones (Room) a formato compatible con Table
     * 
     * @param Store $store
     * @return Collection
     */
    public function getRoomsAsTables(Store $store): Collection
    {
        $rooms = Room::where('store_id', $store->id)
            ->with('roomType')
            ->orderBy('room_number')
            ->get();
        
        // Convertir Room a formato compatible con Table para la vista
        return $rooms->map(function($room) use ($store) {
            // Buscar si existe una Table correspondiente para esta habitación
            $table = Table::where('store_id', $store->id)
                ->where('type', 'habitacion')
                ->where('table_number', $room->room_number)
                ->with('currentOrder')
                ->first();
            
            // Si no existe Table, crear un objeto virtual con datos de Room
            if (!$table) {
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
            
            return $table;
        });
    }
    
    /**
     * Mapear estado de Room a estado de Table
     * 
     * @param string $roomStatus
     * @return string
     */
    public function mapRoomStatusToTableStatus(string $roomStatus): string
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
     * Generar código QR para una mesa/habitación
     * 
     * @param Table $table
     * @param Store $store
     * @param Request $request
     * @return array ['success' => bool, 'qr_code' => string, 'qr_url' => string, 'message' => string]
     */
    public function generateQRCode(Table $table, Store $store, Request $request): array
    {
        // Verificar extensión GD
        if (!extension_loaded('gd')) {
            return [
                'success' => false,
                'message' => 'Extensión PHP GD no está habilitada. Habilitar en php.ini y reiniciar servidor.'
            ];
        }
        
        // Construir URL base
        $baseUrl = $request->root();
        
        if (empty($baseUrl) || $baseUrl === 'localhost') {
            $scheme = $request->getScheme();
            $host = $request->getHost();
            $port = $request->getPort();
            
            $baseUrl = $scheme . '://' . $host;
            
            if ($port && $port != 80 && $port != 443) {
                $baseUrl .= ':' . $port;
            }
        }
        
        $baseUrl = rtrim($baseUrl, '/');
        
        // Construir URL completa del QR
        $url = $baseUrl . '/' . $store->slug . '/' . ($table->type === Table::TYPE_MESA ? 'mesa' : 'habitacion') . '/' . $table->table_number;
        
        Log::info('Generando QR URL', [
            'baseUrl' => $baseUrl,
            'store_slug' => $store->slug,
            'type' => $table->type,
            'table_number' => $table->table_number,
            'final_url' => $url,
        ]);
        
        try {
            // Generar QR usando SimpleSoftwareIO/simple-qrcode
            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(300)
                ->generate($url);
            
            // Actualizar la Table con el QR generado
            $table->qr_code = $qrCode;
            $table->qr_url = $url;
            $table->save();
            
            return [
                'success' => true,
                'qr_code' => $qrCode,
                'qr_url' => $url,
                'table_id' => $table->id,
                'message' => 'QR generado exitosamente'
            ];
        } catch (\Exception $e) {
            Log::error('Error al generar QR para mesa/habitación', [
                'table_id' => $table->id ?? null,
                'table_number' => $table->table_number ?? null,
                'url' => $url,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error al generar QR: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Crear Table para habitación virtual (desde sistema de reservas)
     * 
     * @param Store $store
     * @param string $tableNumber
     * @param int|null $roomId
     * @return Table
     */
    public function createTableForRoom(Store $store, string $tableNumber, ?int $roomId = null): Table
    {
        // Obtener información de la habitación desde rooms si es posible
        $room = null;
        if ($roomId) {
            $room = Room::where('store_id', $store->id)
                ->where('id', $roomId)
                ->with('roomType')
                ->first();
        } else {
            // Buscar por número de habitación
            $room = Room::where('store_id', $store->id)
                ->where('room_number', $tableNumber)
                ->with('roomType')
                ->first();
        }
        
        // Determinar capacidad
        $capacity = 2; // Default
        if ($room && $room->roomType) {
            $capacity = $room->roomType->max_occupancy ?? 2;
        } elseif ($room && isset($room->room_type_id)) {
            $roomType = \App\Shared\Models\RoomType::find($room->room_type_id);
            if ($roomType) {
                $capacity = $roomType->max_occupancy ?? 2;
            }
        }
        
        // Crear la Table para esta habitación
        return Table::create([
            'store_id' => $store->id,
            'tenant_id' => $store->id, // Sincronizar con store_id
            'table_number' => $tableNumber,
            'type' => 'habitacion',
            'capacity' => $capacity,
            'is_active' => true,
            'status' => 'available',
        ]);
    }
    
    /**
     * Calcular estadísticas de mesas/habitaciones
     * 
     * @param Collection $tables
     * @return array
     */
    public function calculateStats(Collection $tables): array
    {
        return [
            'total' => $tables->count(),
            'available' => $tables->where('status', 'available')->count(),
            'occupied' => $tables->where('status', 'occupied')->count(),
            'reserved' => $tables->where('status', 'reserved')->count(),
        ];
    }
}

