<?php

namespace App\Features\Tenant\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\HotelReservation;
use App\Shared\Models\HotelSetting;
use App\Shared\Services\HotelReservationService;
use App\Services\WhatsAppNotificationService;
use App\Features\TenantAdmin\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HotelReservationController extends Controller
{
    protected HotelReservationService $hotelReservationService;

    public function __construct(HotelReservationService $hotelReservationService)
    {
        $this->hotelReservationService = $hotelReservationService;
    }

    /**
     * Mostrar formulario de reserva
     */
    public function index(Request $request)
    {
        $store = $request->route('store');
        
        // Verificar que la tienda tenga el feature habilitado
        if (!featureEnabled($store, 'reservas_hotel')) {
            abort(404);
        }
        
        $settings = $this->hotelReservationService->getSettings($store);
        
        // Obtener cuentas bancarias activas para transferencias (si se requiere anticipo)
        $bankAccounts = collect();
        if ($settings->deposit_type && ($settings->deposit_percentage > 0 || $settings->deposit_fixed_amount > 0)) {
            $bankAccounts = BankAccount::whereHas('paymentMethod', function($query) use ($store) {
                $query->where('store_id', $store->id)
                      ->where('type', 'bank_transfer')
                      ->where('is_active', true);
            })
            ->where('is_active', true)
            ->get();
        }
        
        return view('tenant::hotel-reservations.index', compact('store', 'settings', 'bankAccounts'));
    }

    /**
     * API: Obtener tipos de habitación disponibles
     */
    public function getAvailableRoomTypes(Request $request)
    {
        $store = $request->route('store');
        
        $validator = Validator::make($request->all(), [
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $roomTypes = $this->hotelReservationService->getAvailableRoomTypes(
                $store,
                $request->input('check_in_date'),
                $request->input('check_out_date')
            );

            return response()->json([
                'success' => true,
                'room_types' => $roomTypes,
                'check_in' => $request->input('check_in_date'),
                'check_out' => $request->input('check_out_date')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Calcular precio de reserva
     */
    public function calculatePricing(Request $request)
    {
        $store = $request->route('store');
        
        $validator = Validator::make($request->all(), [
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'num_adults' => 'required|integer|min:1',
            'num_children' => 'nullable|integer|min:0',
            'selected_services' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $roomType = \App\Shared\Models\RoomType::where('store_id', $store->id)
                ->where('id', $request->input('room_type_id'))
                ->where('is_active', true)
                ->firstOrFail();

            $pricing = $this->hotelReservationService->calculatePricing(
                $store,
                $roomType,
                $request->input('check_in_date'),
                $request->input('check_out_date'),
                $request->input('num_adults'),
                $request->input('num_children', 0),
                $request->input('selected_services', [])
            );

            $settings = $this->hotelReservationService->getSettings($store);
            $depositAmount = $settings->calculateDepositAmount($pricing['total']);

            return response()->json([
                'success' => true,
                'pricing' => $pricing,
                'deposit_amount' => $depositAmount,
                'deposit_type' => $settings->deposit_type,
                'deposit_percentage' => $settings->deposit_percentage
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar reserva
     */
    public function store(Request $request)
    {
        $store = $request->route('store');
        
        $validator = Validator::make($request->all(), [
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'num_adults' => 'required|integer|min:1',
            'num_children' => 'nullable|integer|min:0',
            'guest_name' => 'required|string|max:255',
            'guest_phone' => 'required|string|max:20',
            'guest_email' => 'nullable|email|max:255',
            'guest_document' => 'nullable|string|max:100',
            'estimated_arrival_time' => 'nullable|string|max:50',
            'special_requests' => 'nullable|string',
            'selected_services' => 'nullable|array',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Guardar comprobante si existe
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $paymentProofPath = $file->store('hotel-reservations/' . $store->id, 'public');
            }

            $data = [
                'room_type_id' => $request->input('room_type_id'),
                'check_in_date' => $request->input('check_in_date'),
                'check_out_date' => $request->input('check_out_date'),
                'num_adults' => $request->input('num_adults'),
                'num_children' => $request->input('num_children', 0),
                'guest_name' => $request->input('guest_name'),
                'guest_phone' => $request->input('guest_phone'),
                'guest_email' => $request->input('guest_email'),
                'guest_document' => $request->input('guest_document'),
                'estimated_arrival_time' => $request->input('estimated_arrival_time'),
                'special_requests' => $request->input('special_requests'),
                'selected_services' => $request->input('selected_services', []),
                'payment_proof' => $paymentProofPath,
                'deposit_paid' => $paymentProofPath ? true : false,
                'status' => 'pending'
            ];

            $reservation = $this->hotelReservationService->createReservation($store, $data);

            // Guardar ID en sesión para la página de éxito
            $request->session()->put('hotel_reservation_id', $reservation->id);

            // 📱 Enviar notificaciones WhatsApp
            try {
                $whatsapp = app(WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    // Notificar al cliente
                    $whatsapp->notifyHotelReservationRequested($reservation->load('roomType'));
                    // Notificar al admin
                    $whatsapp->notifyAdminNewHotelReservation($reservation->load('roomType'), $store);
                }
            } catch (\Exception $e) {
                \Log::error('Error enviando notificaciones WhatsApp (hotel)', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage()
                ]);
                // No fallar la reserva por error en notificaciones
            }

            $successUrl = route('tenant.hotel-reservations.success', ['store' => $store->slug]) . '?reservation=' . $reservation->id;
            return redirect($successUrl)->with('success', '¡Reserva solicitada con éxito!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Página de éxito
     */
    public function success(Request $request)
    {
        try {
            $store = $request->route('store');
            if (!$store || !($store instanceof Store)) {
                abort(404, 'Tienda no encontrada');
            }

            $reservationId = $request->get('reservation') ?? $request->session()->get('hotel_reservation_id');
            
            if (!$reservationId) {
                abort(404, 'Reservación no encontrada');
            }

            $reservation = HotelReservation::where('id', (int)$reservationId)
                ->where('store_id', $store->id)
                ->with(['roomType', 'room'])
                ->first();

            if (!$reservation) {
                abort(404, 'Reservación no encontrada');
            }

            $settings = $this->hotelReservationService->getSettings($store);

            return view('tenant::hotel-reservations.success', compact('store', 'reservation', 'settings'));
        } catch (\Exception $e) {
            \Log::error('HotelReservationController@success Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Error al cargar la página de éxito');
        }
    }
}

