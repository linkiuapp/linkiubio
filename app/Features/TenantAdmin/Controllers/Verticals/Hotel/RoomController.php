<?php

namespace App\Features\TenantAdmin\Controllers\Verticals\Hotel;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\Room;
use App\Shared\Models\RoomType;
use App\Shared\Models\HotelReservation;
use App\Shared\Enums\RoomStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Listado de habitaciones
     */
    public function index(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $roomTypeId = $request->get('room_type_id');
        
        $query = Room::where('store_id', $store->id)
            ->with('roomType')
            ->withCount(['hotelReservations' => function($query) {
                $query->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                      ->where('check_out_date', '>=', today());
            }]);
        
        if ($roomTypeId) {
            $query->where('room_type_id', $roomTypeId);
        }
        
        $rooms = $query->orderBy('room_type_id')
            ->orderBy('room_number')
            ->get();
        
        $roomTypes = RoomType::where('store_id', $store->id)
            ->where('is_active', true)
            ->ordered()
            ->get();
        
        return view('tenant-admin::verticals.hotel.rooms.index', compact('store', 'rooms', 'roomTypes', 'roomTypeId'));
    }

    /**
     * Crear habitación (AJAX)
     */
    public function store(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $validator = Validator::make($request->all(), [
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($store) {
                    $exists = Room::where('store_id', $store->id)
                        ->where('room_number', $value)
                        ->exists();
                    if ($exists) {
                        $fail('Ya existe una habitación con ese número en esta tienda.');
                    }
                }
            ],
            'floor' => 'nullable|string|max:50',
            'location_notes' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance,blocked'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Verificar que el tipo de habitación pertenezca a la tienda
        $roomType = RoomType::where('store_id', $store->id)
            ->where('id', $request->input('room_type_id'))
            ->firstOrFail();
        
        $room = Room::create([
            'store_id' => $store->id,
            'room_type_id' => $request->input('room_type_id'),
            'room_number' => $request->input('room_number'),
            'floor' => $request->input('floor'),
            'location_notes' => $request->input('location_notes'),
            'status' => $request->input('status', RoomStatus::AVAILABLE->value)
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Habitación creada correctamente',
            'room' => $room->load('roomType')
        ]);
    }

    /**
     * Mostrar habitación (para AJAX)
     */
    public function show(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener room de la ruta
        $roomId = $request->route('room');
        
        // Buscar la habitación manualmente
        $room = Room::where('id', $roomId)
            ->where('store_id', $store->id)
            ->with('roomType')
            ->firstOrFail();
        
        return response()->json([
            'success' => true,
            'room' => $room
        ]);
    }

    /**
     * Actualizar habitación (AJAX)
     */
    public function update(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener room de la ruta
        $roomId = $request->route('room');
        
        // Buscar la habitación manualmente
        $room = Room::where('id', $roomId)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($store, $room) {
                    $exists = Room::where('store_id', $store->id)
                        ->where('room_number', $value)
                        ->where('id', '!=', $room->id)
                        ->exists();
                    if ($exists) {
                        $fail('Ya existe otra habitación con ese número en esta tienda.');
                    }
                }
            ],
            'floor' => 'nullable|string|max:50',
            'location_notes' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance,blocked'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Verificar que el tipo de habitación pertenezca a la tienda
        $roomType = RoomType::where('store_id', $store->id)
            ->where('id', $request->input('room_type_id'))
            ->firstOrFail();
        
        // Verificar que si está ocupada, no se pueda cambiar a disponible sin check-out
        if ($room->status === RoomStatus::OCCUPIED->value 
            && $request->input('status') === RoomStatus::AVAILABLE->value) {
            $hasActiveReservation = HotelReservation::where('room_id', $room->id)
                ->whereIn('status', ['confirmed', 'checked_in'])
                ->where('check_out_date', '>=', today())
                ->exists();
            
            if ($hasActiveReservation) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede marcar como disponible una habitación con reservas activas. Realice el check-out primero.'
                ], 422);
            }
        }
        
        $room->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Habitación actualizada correctamente',
            'room' => $room->fresh()->load('roomType')
        ]);
    }

    /**
     * Eliminar habitación
     */
    public function destroy(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener room de la ruta
        $roomId = $request->route('room');
        
        // Buscar la habitación manualmente
        $room = Room::where('id', $roomId)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        // Verificar si tiene reservas futuras
        $futureReservations = HotelReservation::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->where('check_out_date', '>=', today())
            ->count();
        
        if ($futureReservations > 0) {
            return back()->withErrors([
                'error' => "No se puede eliminar la habitación porque tiene {$futureReservations} reservaciones futuras."
            ]);
        }
        
        $room->delete();
        
        return back()->with('swal_success', '✅ Habitación eliminada correctamente.');
    }

    /**
     * Cambiar estado de habitación (AJAX)
     */
    public function updateStatus(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener room de la ruta
        $roomId = $request->route('room');
        
        // Buscar la habitación manualmente
        $room = Room::where('id', $roomId)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:available,occupied,maintenance,blocked'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $newStatus = $request->input('status');
        
        // Validaciones especiales
        if ($room->status === RoomStatus::OCCUPIED->value 
            && $newStatus === RoomStatus::AVAILABLE->value) {
            $hasActiveReservation = HotelReservation::where('room_id', $room->id)
                ->whereIn('status', ['confirmed', 'checked_in'])
                ->where('check_out_date', '>=', today())
                ->exists();
            
            if ($hasActiveReservation) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede marcar como disponible una habitación con reservas activas.'
                ], 422);
            }
        }
        
        $room->update(['status' => $newStatus]);
        
        return response()->json([
            'success' => true,
            'message' => 'Estado de habitación actualizado correctamente',
            'room' => $room->fresh()->load('roomType')
        ]);
    }
}

