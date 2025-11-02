<?php

namespace App\Features\TenantAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\RoomType;
use App\Shared\Models\Room;
use App\Shared\Models\HotelReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RoomTypeController extends Controller
{
    /**
     * Listado de tipos de habitación
     */
    public function index()
    {
        $store = view()->shared('currentStore');
        
        $roomTypes = RoomType::where('store_id', $store->id)
            ->withCount(['rooms', 'hotelReservations'])
            ->ordered()
            ->get();
        
        return view('tenant-admin::hotel.room-types.index', compact('store', 'roomTypes'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $store = view()->shared('currentStore');
        
        return view('tenant-admin::hotel.room-types.create', compact('store'));
    }

    /**
     * Guardar tipo de habitación
     */
    public function store(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_occupancy' => 'required|integer|min:1|max:50',
            'base_occupancy' => 'required|integer|min:1|max:50',
            'max_adults' => 'nullable|integer|min:1',
            'max_children' => 'nullable|integer|min:0',
            'base_price_per_night' => 'required|numeric|min:0',
            'extra_person_price' => 'nullable|numeric|min:0',
            'amenities' => 'nullable|array',
            'additional_services' => 'nullable|array',
            'images' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ], [
            'name.required' => 'El nombre es obligatorio',
            'max_occupancy.required' => 'La capacidad máxima es obligatoria',
            'base_price_per_night.required' => 'El precio base por noche es obligatorio',
            'base_price_per_night.numeric' => 'El precio debe ser un número válido'
        ]);
        
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }
        
        // Procesar imágenes si existen
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('room-types/' . $store->id, 'public');
                    $images[] = Storage::url($path);
                }
            }
        }
        
        // Procesar amenities (array simple)
        $amenities = $request->input('amenities', []);
        if (is_string($amenities)) {
            $amenities = array_filter(explode(',', $amenities));
        }
        
        // Procesar servicios adicionales (array de objetos)
        $additionalServices = $request->input('additional_services', []);
        if (is_string($additionalServices)) {
            // Intentar parsear como JSON
            $decoded = json_decode($additionalServices, true);
            $additionalServices = is_array($decoded) ? $decoded : [];
        }
        
        $roomType = RoomType::create([
            'store_id' => $store->id,
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
            'max_occupancy' => $request->input('max_occupancy'),
            'base_occupancy' => $request->input('base_occupancy', 2),
            'max_adults' => $request->input('max_adults'),
            'max_children' => $request->input('max_children'),
            'base_price_per_night' => $request->input('base_price_per_night'),
            'extra_person_price' => $request->input('extra_person_price', 0),
            'amenities' => $amenities,
            'additional_services' => $additionalServices,
            'images' => $images,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->input('sort_order', 0)
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tipo de habitación creado correctamente',
                'room_type' => $roomType->loadCount(['rooms', 'hotelReservations'])
            ]);
        }
        
        return redirect()->route('tenant.admin.hotel.room-types.index', ['store' => $store->slug])
            ->with('swal_success', '✅ Tipo de habitación creado correctamente.');
    }

    /**
     * Mostrar tipo de habitación
     */
    public function show(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener roomType de la ruta (puede ser objeto RoomType por route model binding o ID)
        $roomTypeValue = $request->route('roomType');
        
        // Si es un objeto RoomType (de route model binding), validar que pertenezca al store
        if ($roomTypeValue instanceof RoomType) {
            $roomType = $roomTypeValue;
            if ($roomType->store_id !== $store->id) {
                abort(404, 'Tipo de habitación no encontrado');
            }
        } else {
            // Si es un ID, buscar manualmente
            $roomType = RoomType::where('id', $roomTypeValue)
                ->where('store_id', $store->id)
                ->firstOrFail();
        }
        
        $roomType->load(['rooms', 'hotelReservations' => function($query) {
            $query->latest()->limit(10);
        }]);
        
        return view('tenant-admin::hotel.room-types.show', compact('store', 'roomType'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener roomType de la ruta (puede ser objeto RoomType por route model binding o ID)
        $roomTypeValue = $request->route('roomType');
        
        // Si es un objeto RoomType (de route model binding), validar que pertenezca al store
        if ($roomTypeValue instanceof RoomType) {
            $roomType = $roomTypeValue;
            if ($roomType->store_id !== $store->id) {
                abort(404, 'Tipo de habitación no encontrado');
            }
        } else {
            // Si es un ID, buscar manualmente
            $roomType = RoomType::where('id', $roomTypeValue)
                ->where('store_id', $store->id)
                ->firstOrFail();
        }
        
        return view('tenant-admin::hotel.room-types.edit', compact('store', 'roomType'));
    }

    /**
     * Actualizar tipo de habitación
     */
    public function update(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener roomType de la ruta (puede ser objeto RoomType por route model binding o ID)
        $roomTypeValue = $request->route('roomType');
        
        // Si es un objeto RoomType (de route model binding), validar que pertenezca al store
        if ($roomTypeValue instanceof RoomType) {
            $roomType = $roomTypeValue;
            if ($roomType->store_id !== $store->id) {
                abort(404, 'Tipo de habitación no encontrado');
            }
        } else {
            // Si es un ID, buscar manualmente
            $roomType = RoomType::where('id', $roomTypeValue)
                ->where('store_id', $store->id)
                ->firstOrFail();
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_occupancy' => 'required|integer|min:1|max:50',
            'base_occupancy' => 'required|integer|min:1|max:50',
            'max_adults' => 'nullable|integer|min:1',
            'max_children' => 'nullable|integer|min:0',
            'base_price_per_night' => 'required|numeric|min:0',
            'extra_person_price' => 'nullable|numeric|min:0',
            'amenities' => 'nullable|array',
            'additional_services' => 'nullable|array',
            'images' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);
        
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }
        
        // Procesar nuevas imágenes
        $images = $roomType->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('room-types/' . $store->id, 'public');
                    $images[] = Storage::url($path);
                }
            }
        }
        
        // Eliminar imágenes marcadas para eliminar
        if ($request->has('delete_images')) {
            $deleteImages = is_array($request->input('delete_images')) 
                ? $request->input('delete_images') 
                : [$request->input('delete_images')];
            
            foreach ($deleteImages as $imageUrl) {
                if (($key = array_search($imageUrl, $images)) !== false) {
                    // Eliminar del storage
                    $path = str_replace(Storage::url(''), '', $imageUrl);
                    Storage::disk('public')->delete($path);
                    unset($images[$key]);
                }
            }
            $images = array_values($images);
        }
        
        // Procesar amenities
        $amenities = $request->input('amenities', []);
        if (is_string($amenities)) {
            $amenities = array_filter(explode(',', $amenities));
        }
        
        // Procesar servicios adicionales
        $additionalServices = $request->input('additional_services', []);
        if (is_string($additionalServices)) {
            $decoded = json_decode($additionalServices, true);
            $additionalServices = is_array($decoded) ? $decoded : [];
        }
        
        $roomType->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
            'max_occupancy' => $request->input('max_occupancy'),
            'base_occupancy' => $request->input('base_occupancy', 2),
            'max_adults' => $request->input('max_adults'),
            'max_children' => $request->input('max_children'),
            'base_price_per_night' => $request->input('base_price_per_night'),
            'extra_person_price' => $request->input('extra_person_price', 0),
            'amenities' => $amenities,
            'additional_services' => $additionalServices,
            'images' => $images,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->input('sort_order', 0)
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tipo de habitación actualizado correctamente',
                'room_type' => $roomType->fresh()->loadCount(['rooms', 'hotelReservations'])
            ]);
        }
        
        return redirect()->route('tenant.admin.hotel.room-types.index', ['store' => $store->slug])
            ->with('swal_success', '✅ Tipo de habitación actualizado correctamente.');
    }

    /**
     * Eliminar tipo de habitación
     */
    public function destroy(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener roomType de la ruta (puede ser objeto RoomType por route model binding o ID)
        $roomTypeValue = $request->route('roomType');
        
        // Si es un objeto RoomType (de route model binding), validar que pertenezca al store
        if ($roomTypeValue instanceof RoomType) {
            $roomType = $roomTypeValue;
            if ($roomType->store_id !== $store->id) {
                abort(404, 'Tipo de habitación no encontrado');
            }
        } else {
            // Si es un ID, buscar manualmente
            $roomType = RoomType::where('id', $roomTypeValue)
                ->where('store_id', $store->id)
                ->firstOrFail();
        }
        
        // Verificar si tiene habitaciones
        if ($roomType->rooms()->count() > 0) {
            return back()->withErrors([
                'error' => 'No se puede eliminar el tipo de habitación porque tiene habitaciones asociadas. Elimine primero las habitaciones.'
            ]);
        }
        
        // Verificar si tiene reservas futuras
        $futureReservations = $roomType->hotelReservations()
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->where('check_out_date', '>=', today())
            ->count();
        
        if ($futureReservations > 0) {
            return back()->withErrors([
                'error' => "No se puede eliminar el tipo de habitación porque tiene {$futureReservations} reservaciones futuras."
            ]);
        }
        
        // Eliminar imágenes
        if ($roomType->images) {
            foreach ($roomType->images as $imageUrl) {
                $path = str_replace(Storage::url(''), '', $imageUrl);
                Storage::disk('public')->delete($path);
            }
        }
        
        $roomType->delete();
        
        return redirect()->route('tenant.admin.hotel.room-types.index', ['store' => $store->slug])
            ->with('swal_success', '✅ Tipo de habitación eliminado correctamente.');
    }

    /**
     * Toggle estado (activo/inactivo)
     */
    public function toggleStatus(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener roomType de la ruta (puede ser objeto RoomType por route model binding o ID)
        $roomTypeValue = $request->route('roomType');
        
        // Si es un objeto RoomType (de route model binding), validar que pertenezca al store
        if ($roomTypeValue instanceof RoomType) {
            $roomType = $roomTypeValue;
            if ($roomType->store_id !== $store->id) {
                abort(404, 'Tipo de habitación no encontrado');
            }
        } else {
            // Si es un ID, buscar manualmente
            $roomType = RoomType::where('id', $roomTypeValue)
                ->where('store_id', $store->id)
                ->firstOrFail();
        }
        
        $roomType->update(['is_active' => !$roomType->is_active]);
        
        return back()->with('swal_success', 
            $roomType->is_active 
                ? '✅ Tipo de habitación activado.' 
                : '✅ Tipo de habitación desactivado.'
        );
    }
}

