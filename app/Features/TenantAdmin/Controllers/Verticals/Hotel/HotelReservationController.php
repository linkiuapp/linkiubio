<?php

namespace App\Features\TenantAdmin\Controllers\Verticals\Hotel;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\HotelReservation;
use App\Shared\Models\RoomType;
use App\Shared\Models\Room;
use App\Shared\Services\HotelReservationService;
use App\Shared\Enums\HotelReservationStatus;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class HotelReservationController extends Controller
{
    protected HotelReservationService $hotelReservationService;

    public function __construct(HotelReservationService $hotelReservationService)
    {
        $this->hotelReservationService = $hotelReservationService;
    }

    /**
     * Dashboard de ocupación y listado de reservas
     */
    public function index(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $filter = $request->get('filter', 'all'); // all, pending, confirmed, checked_in, checked_out, cancelled
        $date = $request->get('date');
        $roomTypeId = $request->get('room_type_id');
        
        $query = HotelReservation::where('store_id', $store->id)
            ->with(['roomType', 'room', 'createdBy'])
            ->latest('created_at')
            ->orderBy('id', 'desc');
        
        // Aplicar filtros
        switch ($filter) {
            case 'pending':
                $query->pending();
                break;
            case 'confirmed':
                $query->confirmed();
                break;
            case 'checked_in':
                $query->checkedIn();
                break;
            case 'checked_out':
                $query->checkedOut();
                break;
            case 'cancelled':
                $query->cancelled();
                break;
            case 'today_checkin':
                $query->where('check_in_date', today());
                break;
            case 'today_checkout':
                $query->where('check_out_date', today());
                break;
            case 'upcoming':
                $query->where('check_in_date', '>=', today())
                      ->whereIn('status', ['pending', 'confirmed']);
                break;
        }
        
        if ($date) {
            // Reservas que incluyen esta fecha
            $query->where('check_in_date', '<=', $date)
                  ->where('check_out_date', '>', $date);
        }
        
        if ($roomTypeId) {
            $query->where('room_type_id', $roomTypeId);
        }
        
        $reservations = $query->paginate(20);
        
        // Obtener ocupación para dashboard (próximos 30 días)
        $startDate = today();
        $endDate = today()->addDays(30);
        $occupancy = $this->hotelReservationService->getOccupancy(
            $store,
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d')
        );
        
        // Estadísticas
        $stats = [
            'total' => HotelReservation::where('store_id', $store->id)->count(),
            'pending' => HotelReservation::where('store_id', $store->id)->pending()->count(),
            'confirmed' => HotelReservation::where('store_id', $store->id)->confirmed()->count(),
            'checked_in' => HotelReservation::where('store_id', $store->id)->checkedIn()->count(),
            'checked_out' => HotelReservation::where('store_id', $store->id)->checkedOut()->count(),
            'cancelled' => HotelReservation::where('store_id', $store->id)->cancelled()->count(),
            'today_checkin' => HotelReservation::where('store_id', $store->id)
                ->where('check_in_date', today())
                ->whereIn('status', ['confirmed', 'checked_in'])
                ->count(),
            'today_checkout' => HotelReservation::where('store_id', $store->id)
                ->where('check_out_date', today())
                ->whereIn('status', ['checked_in', 'checked_out'])
                ->count()
        ];
        
        $roomTypes = RoomType::where('store_id', $store->id)
            ->where('is_active', true)
            ->ordered()
            ->get();
        
        return view('tenant-admin::verticals.hotel.reservations.index', compact(
            'store',
            'reservations',
            'stats',
            'occupancy',
            'filter',
            'date',
            'roomTypeId',
            'roomTypes',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Mostrar reserva
     */
    public function show(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener hotelReservation directamente de la ruta
        $hotelReservationId = $request->route('hotelReservation');
        
        // Buscar la reserva manualmente
        $hotelReservation = HotelReservation::where('id', $hotelReservationId)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        $hotelReservation->load(['roomType', 'room', 'createdBy', 'store']);
        
        return view('tenant-admin::verticals.hotel.reservations.show', compact('store', 'hotelReservation'));
    }

    /**
     * Mostrar formulario de creación manual
     */
    public function create()
    {
        $store = view()->shared('currentStore');
        
        $roomTypes = RoomType::where('store_id', $store->id)
            ->where('is_active', true)
            ->ordered()
            ->get();
        
        return view('tenant-admin::verticals.hotel.reservations.create', compact('store', 'roomTypes'));
    }

    /**
     * Guardar reserva manual
     */
    public function store(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $validator = Validator::make($request->all(), [
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'num_adults' => 'required|integer|min:1',
            'num_children' => 'nullable|integer|min:0',
            'guest_name' => 'required|string|max:255',
            'guest_phone' => 'required|string|max:20',
            'guest_email' => 'nullable|email|max:255',
            'guest_document_type' => 'required|in:CC,CE,PA,TI,NIT',
            'guest_document' => 'required|string|max:100',
            'guest_city' => 'required|string|max:255',
            'estimated_arrival_time' => 'nullable|string|max:50',
            'special_requests' => 'nullable|string',
            'status' => 'nullable|in:pending,confirmed',
            'room_id' => 'nullable|exists:rooms,id',
            'additional_guests' => 'nullable|array',
            'additional_guests.*.name' => 'required_with:additional_guests|string|max:255',
            'additional_guests.*.document_type' => 'required_with:additional_guests|in:CC,CE,PA,TI,NIT',
            'additional_guests.*.document' => 'required_with:additional_guests|string|max:100',
            'additional_guests.*.city' => 'required_with:additional_guests|string|max:255',
            'additional_children' => 'nullable|array',
            'additional_children.*.name' => 'required_with:additional_children|string|max:255',
            'additional_children.*.age' => 'required_with:additional_children|integer|min:0|max:17',
            'additional_children.*.document_type' => 'required_with:additional_children|in:CC,CE,PA,TI,RC',
            'additional_children.*.document' => 'required_with:additional_children|string|max:100',
            'additional_children.*.city' => 'required_with:additional_children|string|max:255'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        try {
            // Verificar que el tipo de habitación pertenezca a la tienda
            $roomType = RoomType::where('store_id', $store->id)
                ->where('id', $request->input('room_type_id'))
                ->firstOrFail();
            
            // Si se especifica una habitación, verificar que pertenezca al tipo
            $roomId = $request->input('room_id');
            if ($roomId) {
                $room = Room::where('store_id', $store->id)
                    ->where('room_type_id', $roomType->id)
                    ->where('id', $roomId)
                    ->firstOrFail();
            }
            
            // Procesar servicios adicionales si existen
            $selectedServices = [];
            if ($request->has('additional_services')) {
                $services = $request->input('additional_services', []);
                if (is_array($services)) {
                    $selectedServices = $services;
                }
            }
            
            // Procesar huéspedes adicionales (adultos)
            $additionalGuests = [];
            if ($request->has('additional_guests') && is_array($request->input('additional_guests'))) {
                foreach ($request->input('additional_guests') as $guest) {
                    if (!empty($guest['name']) && !empty($guest['document_type']) && !empty($guest['document'])) {
                        $additionalGuests[] = [
                            'name' => $guest['name'],
                            'document_type' => $guest['document_type'],
                            'document' => $guest['document'],
                            'city' => $guest['city'] ?? '',
                            'type' => 'adult'
                        ];
                    }
                }
            }
            
            // Procesar niños adicionales
            $additionalChildren = [];
            $childrenAges = [];
            if ($request->has('additional_children') && is_array($request->input('additional_children'))) {
                foreach ($request->input('additional_children') as $child) {
                    if (!empty($child['name']) && !empty($child['document_type']) && !empty($child['document']) && isset($child['age'])) {
                        $age = (int) $child['age'];
                        $additionalChildren[] = [
                            'name' => $child['name'],
                            'document_type' => $child['document_type'],
                            'document' => $child['document'],
                            'city' => $child['city'] ?? '',
                            'age' => $age,
                            'type' => 'child'
                        ];
                        $childrenAges[] = $age;
                    }
                }
            }
            
            // Combinar todos los huéspedes adicionales
            $allAdditionalGuests = array_merge($additionalGuests, $additionalChildren);
            
            $data = [
                'room_type_id' => $request->input('room_type_id'),
                'check_in_date' => $request->input('check_in_date'),
                'check_out_date' => $request->input('check_out_date'),
                'num_adults' => $request->input('num_adults'),
                'num_children' => $request->input('num_children', 0),
                'guest_name' => $request->input('guest_name'),
                'guest_phone' => $request->input('guest_phone'),
                'guest_email' => $request->input('guest_email'),
                'guest_document_type' => $request->input('guest_document_type'),
                'guest_document' => $request->input('guest_document'),
                'guest_city' => $request->input('guest_city'),
                'estimated_arrival_time' => $request->input('estimated_arrival_time'),
                'special_requests' => $request->input('special_requests'),
                'selected_services' => $selectedServices,
                'status' => $request->input('status', HotelReservationStatus::PENDING->value),
                'additional_guests' => $allAdditionalGuests, // Pasar todos los huéspedes adicionales (adultos y niños)
                'created_by' => auth()->id()
            ];
            
            // Si viene con habitación asignada y status confirmed, asignar directamente
            if ($roomId && $request->input('status') === HotelReservationStatus::CONFIRMED->value) {
                $data['room_id'] = $roomId;
            }
            
            $reservation = $this->hotelReservationService->createReservation($store, $data);
            
            // Si viene con status confirmed y habitación, confirmar directamente
            if ($roomId && $request->input('status') === HotelReservationStatus::CONFIRMED->value) {
                $reservation = $this->hotelReservationService->confirmReservation($reservation, $roomId);
            }
            
            // 📱 Enviar notificaciones WhatsApp
            try {
                $whatsapp = app(WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    // Notificar al cliente (solo si la reserva está confirmada o pendiente)
                    if ($reservation->status === HotelReservationStatus::PENDING->value) {
                        $whatsapp->notifyHotelReservationRequested($reservation->load('roomType'));
                    } elseif ($reservation->status === HotelReservationStatus::CONFIRMED->value) {
                        $whatsapp->notifyHotelReservationConfirmed($reservation->load(['roomType', 'room']));
                    }
                    // Notificar al admin siempre
                    $whatsapp->notifyAdminNewHotelReservation($reservation->load('roomType'), $store);
                }
            } catch (\Exception $e) {
                \Log::error('Error enviando notificaciones WhatsApp (hotel admin)', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage()
                ]);
                // No fallar la reserva por error en notificaciones
            }
            
            return redirect()->route('tenant.admin.hotel.reservations.show', ['store' => $store->slug, 'hotelReservation' => $reservation->id])
                ->with('swal_success', '✅ Reserva creada correctamente.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Confirmar reserva y asignar habitación
     */
    public function confirm(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener hotelReservation directamente de la ruta
        $hotelReservationId = $request->route('hotelReservation');
        
        // Buscar la reserva manualmente
        $hotelReservation = HotelReservation::where('id', $hotelReservationId)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        try {
            $roomId = $request->input('room_id');
            
            $hotelReservation = $this->hotelReservationService->confirmReservation($hotelReservation, $roomId);
            
            // 📱 Enviar notificación de confirmación
            try {
                $whatsapp = app(WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    $whatsapp->notifyHotelReservationConfirmed($hotelReservation->load(['roomType', 'room']));
                }
            } catch (\Exception $e) {
                \Log::error('Error enviando notificación WhatsApp (confirmación hotel)', [
                    'reservation_id' => $hotelReservation->id,
                    'error' => $e->getMessage()
                ]);
            }
            
            return back()->with('swal_success', '✅ Reserva confirmada y habitación asignada correctamente.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Realizar check-in
     */
    public function checkIn(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener hotelReservation directamente de la ruta
        $hotelReservationId = $request->route('hotelReservation');
        
        // Buscar la reserva manualmente
        $hotelReservation = HotelReservation::where('id', $hotelReservationId)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        try {
            $hotelReservation = $this->hotelReservationService->checkIn($hotelReservation);
            
            return back()->with('swal_success', '✅ Check-in realizado correctamente.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Realizar check-out
     */
    public function checkOut(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener hotelReservation directamente de la ruta
        $hotelReservationId = $request->route('hotelReservation');
        
        // Buscar la reserva manualmente
        $hotelReservation = HotelReservation::where('id', $hotelReservationId)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        try {
            $hotelReservation = $this->hotelReservationService->checkOut($hotelReservation);
            
            return back()->with('swal_success', '✅ Check-out realizado correctamente.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Marcar anticipo como pagado
     */
    public function markDepositAsPaid(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener hotelReservation directamente de la ruta
        $hotelReservationId = $request->route('hotelReservation');
        
        // Buscar la reserva manualmente
        $hotelReservation = HotelReservation::where('id', $hotelReservationId)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        // Validar que tenga anticipo y no esté ya pagado
        if ($hotelReservation->deposit_amount <= 0) {
            return back()->withErrors(['error' => 'Esta reserva no tiene anticipo configurado.']);
        }
        
        if ($hotelReservation->deposit_paid) {
            return back()->with('swal_success', '✅ El anticipo ya está marcado como pagado.');
        }
        
        try {
            $hotelReservation->update([
                'deposit_paid' => true
            ]);
            
            return back()->with('swal_success', '✅ Anticipo marcado como pagado correctamente.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al marcar el anticipo como pagado: ' . $e->getMessage()]);
        }
    }

    /**
     * Descargar comprobante de pago
     */
    public function downloadPaymentProof(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener hotelReservation directamente de la ruta
        $hotelReservationId = $request->route('hotelReservation');
        
        // Buscar la reserva manualmente
        $hotelReservation = HotelReservation::where('id', $hotelReservationId)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        if (!$hotelReservation->payment_proof) {
            abort(404, 'Esta reserva no tiene comprobante de pago');
        }
        
        try {
            // Intentar múltiples ubicaciones para compatibilidad
            $possiblePaths = [
                $hotelReservation->payment_proof,
                'public/' . $hotelReservation->payment_proof,
            ];
            
            $fileContent = null;
            $mimeType = null;
            $foundPath = null;
            
            // Intentar en disco 'public' (S3)
            foreach ($possiblePaths as $path) {
                if (Storage::disk('public')->exists($path)) {
                    $foundPath = $path;
                    $fileContent = Storage::disk('public')->get($path);
                    $mimeType = Storage::disk('public')->mimeType($path);
                    break;
                }
            }
            
            // Si no se encuentra en 'public', intentar en disco 'local' (fallback)
            if (!$fileContent) {
                foreach ($possiblePaths as $path) {
                    if (Storage::disk('local')->exists($path)) {
                        $foundPath = $path;
                        $fileContent = Storage::disk('local')->get($path);
                        $mimeType = Storage::disk('local')->mimeType($path);
                        break;
                    }
                }
            }
            
            if (!$fileContent) {
                abort(404, 'Archivo de comprobante no encontrado');
            }
            
            $filename = 'Comprobante_' . $hotelReservation->reservation_code . '.' . pathinfo($foundPath, PATHINFO_EXTENSION);
            
            return response($fileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            \Log::error('Error descargando comprobante de reserva de hotel:', [
                'reservation_id' => $hotelReservation->id,
                'path' => $hotelReservation->payment_proof,
                'error' => $e->getMessage()
            ]);
            abort(500, 'Error al descargar el comprobante: ' . $e->getMessage());
        }
    }

    /**
     * Cancelar reserva
     */
    public function cancel(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener hotelReservation directamente de la ruta
        $hotelReservationId = $request->route('hotelReservation');
        
        // Buscar la reserva manualmente
        $hotelReservation = HotelReservation::where('id', $hotelReservationId)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        try {
            $reason = $request->input('cancellation_reason');
            
            $hotelReservation = $this->hotelReservationService->cancelReservation($hotelReservation, $reason);
            
            // 📱 Enviar notificación de cancelación
            try {
                $whatsapp = app(WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    $whatsapp->notifyHotelReservationCancelled($hotelReservation->load('roomType'));
                }
            } catch (\Exception $e) {
                \Log::error('Error enviando notificación WhatsApp (cancelación hotel)', [
                    'reservation_id' => $hotelReservation->id,
                    'error' => $e->getMessage()
                ]);
            }
            
            return back()->with('swal_success', '✅ Reserva cancelada correctamente.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * API: Obtener habitaciones disponibles para un tipo en un rango de fechas
     */
    public function getAvailableRooms(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $validator = Validator::make($request->all(), [
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $roomType = RoomType::where('store_id', $store->id)
            ->where('id', $request->input('room_type_id'))
            ->firstOrFail();
        
        $rooms = Room::where('store_id', $store->id)
            ->where('room_type_id', $roomType->id)
            ->with('roomType')
            ->get();
        
        // Filtrar habitaciones disponibles usando el servicio
        $availableRooms = [];
        foreach ($rooms as $room) {
            // Verificar si la habitación está disponible en ese rango
            $overlapping = HotelReservation::where('room_id', $room->id)
                ->whereIn('status', [
                    HotelReservationStatus::PENDING->value,
                    HotelReservationStatus::CONFIRMED->value,
                    HotelReservationStatus::CHECKED_IN->value
                ])
                ->where(function ($query) use ($request) {
                    $checkIn = Carbon::parse($request->input('check_in_date'));
                    $checkOut = Carbon::parse($request->input('check_out_date'));
                    $query->where('check_in_date', '<', $checkOut->format('Y-m-d'))
                          ->where('check_out_date', '>', $checkIn->format('Y-m-d'));
                })
                ->exists();
            
            if (!$overlapping && in_array($room->status, ['available', 'occupied'])) {
                $availableRooms[] = $room;
            }
        }
        
        return response()->json([
            'success' => true,
            'rooms' => $availableRooms
        ]);
    }

    /**
     * API: Calcular precio de reserva
     */
    public function calculatePricing(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $validator = Validator::make($request->all(), [
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'num_adults' => 'required|integer|min:1',
            'num_children' => 'nullable|integer|min:0',
            'children_ages' => 'nullable|array',
            'children_ages.*' => 'nullable|integer|min:0|max:17',
            'selected_services' => 'nullable|array'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $roomType = RoomType::where('store_id', $store->id)
                ->where('id', $request->input('room_type_id'))
                ->where('is_active', true)
                ->firstOrFail();
            
            $childrenAges = $request->input('children_ages', []);
            
            $pricing = $this->hotelReservationService->calculatePricing(
                $store,
                $roomType,
                $request->input('check_in_date'),
                $request->input('check_out_date'),
                $request->input('num_adults'),
                $request->input('num_children', 0),
                $request->input('selected_services', []),
                $childrenAges
            );
            
            $settings = $this->hotelReservationService->getSettings($store);
            $depositAmount = $settings->calculateDepositAmount($pricing['total']);
            
            return response()->json([
                'success' => true,
                'pricing' => $pricing,
                'deposit_amount' => $depositAmount,
                'deposit_type' => $settings->deposit_type,
                'deposit_percentage' => $settings->deposit_percentage,
                'formatted' => [
                    'base_price' => '$' . number_format($pricing['base_price_per_night'], 0, ',', '.'),
                    'base_price_total' => '$' . number_format($pricing['base_price_per_night'] * $pricing['num_nights'], 0, ',', '.'),
                    'children_charge' => '$' . number_format($pricing['children_charge'] ?? 0, 0, ',', '.'),
                    'extra_person_charge' => '$' . number_format($pricing['extra_person_charge'], 0, ',', '.'),
                    'services_total' => '$' . number_format($pricing['services_total'], 0, ',', '.'),
                    'subtotal' => '$' . number_format($pricing['subtotal'], 0, ',', '.'),
                    'security_deposit' => '$' . number_format($pricing['security_deposit'], 0, ',', '.'),
                    'total' => '$' . number_format($pricing['total'], 0, ',', '.'),
                    'deposit_amount' => '$' . number_format($depositAmount, 0, ',', '.')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar configuración de hotel
     */
    public function settings()
    {
        $store = view()->shared('currentStore');
        
        $settings = $this->hotelReservationService->getSettings($store);
        
        return view('tenant-admin::verticals.hotel.settings', compact('store', 'settings'));
    }

    /**
     * Actualizar configuración de hotel
     */
    public function updateSettings(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $validator = Validator::make($request->all(), [
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'deposit_type' => 'required|in:percentage,fixed',
            'deposit_percentage' => 'nullable|integer|min:0|max:100',
            'deposit_fixed_amount' => 'nullable|numeric|min:0',
            'require_security_deposit' => 'nullable|boolean',
            'security_deposit_amount' => 'nullable|numeric|min:0',
            'cancellation_hours' => 'required|integer|min:0',
            'min_guest_age' => 'required|integer|min:1|max:100',
            'min_advance_hours' => 'required|integer|min:0',
            'children_free_max_age' => 'required|integer|min:0|max:10',
            'children_discounted_max_age' => 'required|integer|min:0|max:17',
            'children_discount_percentage' => 'required|integer|min:0|max:100',
            'charge_children_by_occupancy' => 'nullable|boolean',
            'send_confirmation' => 'nullable|boolean',
            'send_checkin_reminder' => 'nullable|boolean',
            'reminder_hours' => 'required|integer|min:0|max:72'
        ]);
        
        // Validación condicional adicional
        if ($request->input('deposit_type') === 'percentage') {
            $validator->sometimes('deposit_percentage', 'required|integer|min:0|max:100', function ($input) {
                return true;
            });
        } elseif ($request->input('deposit_type') === 'fixed') {
            $validator->sometimes('deposit_fixed_amount', 'required|numeric|min:0', function ($input) {
                return true;
            });
        }
        
        if ($request->has('require_security_deposit') && ($request->input('require_security_deposit') == '1' || $request->input('require_security_deposit') === true || $request->boolean('require_security_deposit'))) {
            $validator->sometimes('security_deposit_amount', 'required|numeric|min:0', function ($input) {
                return true;
            });
        }
        
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }
        
        $settings = $this->hotelReservationService->getSettings($store);
        
        // Preparar datos validados con valores por defecto para booleanos
        $validated = $validator->validated();
        
        // Normalizar formato de horas (asegurar formato H:i sin segundos)
        if (isset($validated['check_in_time'])) {
            $time = $validated['check_in_time'];
            // Si viene con segundos, removerlos
            if (strlen($time) > 5) {
                $validated['check_in_time'] = substr($time, 0, 5);
            }
        }
        if (isset($validated['check_out_time'])) {
            $time = $validated['check_out_time'];
            // Si viene con segundos, removerlos
            if (strlen($time) > 5) {
                $validated['check_out_time'] = substr($time, 0, 5);
            }
        }
        
        // Asegurar que los booleanos se conviertan correctamente
        $validated['require_security_deposit'] = $request->boolean('require_security_deposit', false);
        $validated['charge_children_by_occupancy'] = $request->boolean('charge_children_by_occupancy', true);
        $validated['send_confirmation'] = $request->boolean('send_confirmation', true);
        $validated['send_checkin_reminder'] = $request->boolean('send_checkin_reminder', true);
        
        // Asegurar valores por defecto si no vienen
        if (!isset($validated['deposit_percentage']) && $validated['deposit_type'] === 'percentage') {
            $validated['deposit_percentage'] = 50;
        }
        if (!isset($validated['deposit_fixed_amount']) && $validated['deposit_type'] === 'fixed') {
            $validated['deposit_fixed_amount'] = 0;
        }
        if (!isset($validated['security_deposit_amount'])) {
            $validated['security_deposit_amount'] = 0;
        }
        
        $settings->update($validated);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => '✅ Configuración actualizada correctamente.',
                'settings' => $settings->fresh()
            ]);
        }
        
        return back()->with('swal_success', '✅ Configuración actualizada correctamente.');
    }
}

