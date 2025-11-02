<?php

namespace App\Features\Tenant\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\Reservation;
use App\Shared\Services\ReservationService;
use App\Features\TenantAdmin\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

class ReservationController extends Controller
{
    protected ReservationService $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Prepágina para seleccionar tipo de reserva (si ambos están activos)
     */
    public function selectType(Request $request): View
    {
        // Obtener store del route o de view shared (el middleware tenant.identify lo resuelve)
        $store = $request->route('store');
        
        // Si no está resuelto, intentar desde view shared (como hacen otros controladores)
        if (!$store || is_string($store)) {
            $store = view()->shared('currentStore');
        }
        
        // Si aún no hay store, intentar resolverlo manualmente
        if (!$store || !($store instanceof \App\Shared\Models\Store)) {
            $storeSlug = $request->route('store');
            if (is_string($storeSlug)) {
                $store = \App\Shared\Models\Store::where('slug', $storeSlug)->first();
            }
        }
        
        if (!$store || !($store instanceof \App\Shared\Models\Store)) {
            abort(404, 'Tienda no encontrada');
        }
        
        $hasMesaReservations = featureEnabled($store, 'reservas_mesas');
        $hasHotelReservations = featureEnabled($store, 'reservas_hotel');
        
        // Si solo uno está activo, redirigir directamente
        if ($hasMesaReservations && !$hasHotelReservations) {
            return redirect()->route('tenant.reservations.index', $store->slug);
        }
        
        if ($hasHotelReservations && !$hasMesaReservations) {
            return redirect()->route('tenant.hotel-reservations.index', $store->slug);
        }
        
        // Si ninguno está activo, 404
        if (!$hasMesaReservations && !$hasHotelReservations) {
            abort(404, 'Reservas no disponibles');
        }
        
        // Si ambos están activos, mostrar prepágina
        return view('tenant::reservations.select-type', compact('store'));
    }

    /**
     * Mostrar formulario de reserva de mesa
     */
    public function index(Request $request)
    {
        $store = $request->route('store');
        
        // Verificar que la tienda tenga el feature habilitado
        if (!featureEnabled($store, 'reservas_mesas')) {
            abort(404);
        }
        
        $settings = $this->reservationService->getSettings($store);
        
        // Obtener cuentas bancarias activas para transferencias
        $bankAccounts = BankAccount::whereHas('paymentMethod', function($query) use ($store) {
            $query->where('store_id', $store->id)
                  ->where('type', 'bank_transfer')
                  ->where('is_active', true);
        })
        ->where('is_active', true)
        ->get();
        
        return view('tenant::reservations.index', compact('store', 'settings', 'bankAccounts'));
    }

    /**
     * Obtener slots disponibles para una fecha (AJAX)
     */
    public function getAvailableSlots(Request $request): JsonResponse
    {
        $store = $request->route('store');
        
        if (!$store || !($store instanceof Store)) {
            return response()->json([
                'success' => false,
                'message' => 'Tienda no encontrada'
            ], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after_or_equal:today'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Fecha inválida',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $date = $request->input('date');
        
        // Verificar si la fecha está disponible
        if (!$this->reservationService->isDateAvailable($store, $date)) {
            return response()->json([
                'success' => false,
                'message' => 'Esta fecha no está disponible para reservas. Por favor selecciona otra fecha.'
            ], 422);
        }
        
        $slots = $this->reservationService->getAvailableTimeSlots($store, $date);
        
        return response()->json([
            'success' => true,
            'slots' => $slots
        ]);
    }

    /**
     * Verificar disponibilidad de un slot específico (AJAX)
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $store = $request->route('store');
        
        if (!$store || !($store instanceof Store)) {
            return response()->json([
                'success' => false,
                'message' => 'Tienda no encontrada'
            ], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'party_size' => 'required|integer|min:1|max:50'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $availability = $this->reservationService->checkAvailability(
            $store,
            $request->input('date'),
            $request->input('time')
        );
        
        // Verificar si hay capacidad suficiente para el party_size
        $canAccommodate = $availability['remaining_capacity'] >= $request->input('party_size');
        
        return response()->json([
            'success' => true,
            'available' => $availability['available'] && $canAccommodate,
            'availability' => $availability,
            'can_accommodate' => $canAccommodate,
            'message' => $this->getAvailabilityMessage($availability, $request->input('party_size'))
        ]);
    }

    /**
     * Crear reservación
     */
    public function store(Request $request)
    {
        $store = $request->route('store');
        
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'party_size' => 'required|integer|min:1|max:50',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:1000',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);
        
        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Por favor completa todos los campos correctamente',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }
        
        try {
            // Verificar disponibilidad
            $availability = $this->reservationService->checkAvailability(
                $store,
                $request->input('reservation_date'),
                $request->input('reservation_time')
            );
            
            if (!$availability['available']) {
                throw new \Exception('Lo sentimos, ya no hay disponibilidad en ese horario. Por favor selecciona otro.');
            }
            
            if ($availability['remaining_capacity'] < $request->input('party_size')) {
                throw new \Exception('No hay suficiente capacidad para ese número de personas en ese horario.');
            }
            
            $data = $validator->validated();
            $settings = $this->reservationService->getSettings($store);
            
            // Procesar comprobante de pago si se requiere anticipo
            $paymentProof = null;
            $depositPaid = false;
            
            if ($settings->require_deposit && $request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $filename = 'reservation_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $directory = 'reservations/payment-proofs';
                
                $paymentProof = Storage::disk('public')->putFileAs($directory, $file, $filename);
                $depositPaid = true;
            }
            
            $data['payment_proof'] = $paymentProof;
            $data['deposit_paid'] = $depositPaid;
            $data['status'] = 'pending';
            
            // Crear reservación
            $reservation = $this->reservationService->createReservation($store, $data);
            
            // Enviar notificaciones WhatsApp
            try {
                $whatsapp = app(\App\Services\WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    // Notificar al cliente
                    $whatsapp->notifyReservationRequested($reservation);
                    // Notificar al admin
                    $whatsapp->notifyAdminNewReservation($reservation, $store);
                }
            } catch (\Exception $e) {
                \Log::error('Error enviando notificaciones WhatsApp de reserva', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage()
                ]);
            }
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '¡Reservación solicitada con éxito! Te contactaremos pronto para confirmar.',
                    'reservation' => [
                        'reference_code' => $reservation->reference_code,
                        'id' => $reservation->id
                    ]
                ]);
            }
            
            // Guardar ID de reservación en sesión (igual que checkout)
            $request->session()->put('reservation_id', $reservation->id);
            
            // Generar URL con query parameter (no como route parameter)
            $successUrl = route('tenant.reservations.success', ['store' => $store->slug]) . '?reservation=' . $reservation->id;
            
            return redirect($successUrl)
                ->with('success', '¡Reservación solicitada con éxito!');
                
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
            
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Página de éxito después de crear reservación
     * Similar a checkout success: usa query parameter en lugar de route parameter
     */
    public function success(Request $request)
    {
        try {
            // Obtener store de la ruta (ya resuelto por tenant.identify)
            $store = $request->route('store');
            
            if (!$store || !($store instanceof Store)) {
                \Log::error('ReservationController@success: Store not found in route', [
                    'url' => $request->fullUrl(),
                    'route_params' => $request->route()?->parameters()
                ]);
                abort(404, 'Tienda no encontrada');
            }
            
            \Log::info('ReservationController@success: Starting', [
                'url' => $request->fullUrl(),
                'store_id' => $store->id,
                'query_params' => $request->all(),
                'session_reservation_id' => $request->session()->get('reservation_id')
            ]);
            
            // Obtener ID de reservación de query parameter o sesión (igual que checkout)
            $reservationId = $request->get('reservation') ?? $request->session()->get('reservation_id');
            
            \Log::info('ReservationController@success: Reservation ID check', [
                'reservation_id' => $reservationId,
                'from_query' => $request->get('reservation'),
                'from_session' => $request->session()->get('reservation_id')
            ]);
            
            if (!$reservationId) {
                \Log::error('ReservationController@success: No reservation ID found', [
                    'url' => $request->fullUrl(),
                    'query_params' => $request->all(),
                    'session_keys' => array_keys($request->session()->all())
                ]);
                abort(404, 'Reservación no encontrada');
            }
            
            // Resolver la reservación
            $reservation = Reservation::where('id', (int)$reservationId)
                ->where('store_id', $store->id)
                ->first();
            
            \Log::info('ReservationController@success: Reservation lookup', [
                'reservation_id' => $reservationId,
                'reservation_found' => $reservation !== null,
                'store_id' => $store->id
            ]);
            
            if (!$reservation) {
                \Log::error('ReservationController@success: Reservation not found', [
                    'reservation_id' => $reservationId,
                    'store_id' => $store->id,
                    'url' => $request->fullUrl()
                ]);
                abort(404, 'Reservación no encontrada');
            }
            
            \Log::info('ReservationController@success: Returning view', [
                'reservation_id' => $reservation->id,
                'view' => 'tenant::reservations.success'
            ]);
            
            return view('tenant::reservations.success', compact('store', 'reservation'));
        } catch (\Exception $e) {
            \Log::error('ReservationController@success: Exception caught', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'url' => $request->fullUrl(),
                'store' => $store->id ?? 'N/A',
                'reservation_id' => $request->get('reservation') ?? 'N/A'
            ]);
            abort(404, 'Error al cargar la reservación');
        }
    }

    /**
     * Obtener mensaje de disponibilidad legible
     */
    private function getAvailabilityMessage(array $availability, int $partySize): string
    {
        if (!$availability['available']) {
            return 'No disponible - Agotado';
        }
        
        if ($availability['remaining_capacity'] < $partySize) {
            return "Capacidad insuficiente. Solo quedan {$availability['remaining_capacity']} lugares disponibles.";
        }
        
        switch ($availability['status']) {
            case 'warning':
                return "¡Últimas {$availability['remaining_capacity']} lugares disponibles!";
            case 'limited':
                return "Solo {$availability['remaining_capacity']} lugares disponibles";
            default:
                return "Disponible ({$availability['remaining_capacity']} lugares libres)";
        }
    }
}

