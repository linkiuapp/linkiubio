<?php

namespace App\Features\TenantAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\Reservation;
use App\Shared\Models\Table;
use App\Shared\Models\ReservationSetting;
use App\Shared\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TableReservationController extends Controller
{
    protected ReservationService $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Listado de reservaciones con filtros
     */
    public function index(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $filter = $request->get('filter', 'all'); // all, pending, confirmed, today, tomorrow
        $date = $request->get('date');
        
        $query = Reservation::where('store_id', $store->id)
            ->with(['table', 'createdBy'])
            ->select('reservations.*') // Asegurar que seleccionamos todos los campos
            ->orderBy('reservation_date', 'asc')
            ->orderBy('reservation_time', 'asc');
        
        // Aplicar filtros
        switch ($filter) {
            case 'pending':
                $query->pending();
                break;
            case 'confirmed':
                $query->confirmed();
                break;
            case 'today':
                $query->today();
                break;
            case 'tomorrow':
                $query->tomorrow();
                break;
            case 'completed':
                $query->completed();
                break;
            case 'cancelled':
                $query->cancelled();
                break;
        }
        
        if ($date) {
            $query->forDate($date);
        }
        
        $reservations = $query->paginate(20);
        
        // Estadísticas
        $stats = $this->reservationService->getStatistics($store);
        
        return view('tenant-admin::reservations.index', compact('store', 'reservations', 'stats', 'filter', 'date'));
    }

    /**
     * Mostrar formulario de creación manual
     */
    public function create()
    {
        $store = view()->shared('currentStore');
        
        $tables = Table::where('store_id', $store->id)
            ->where('is_active', true)
            ->ordered()
            ->get();
        
        return view('tenant-admin::reservations.create', compact('store', 'tables'));
    }

    /**
     * Guardar reservación manual
     */
    public function store(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'party_size' => 'required|integer|min:1|max:50',
            'reservation_date' => ['required', 'date', 'after_or_equal:today'],
            'reservation_time' => ['required', 'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/'], // Formato HH:mm válido
            'table_id' => 'nullable|exists:tables,id',
            'notes' => 'nullable|string|max:1000',
            'status' => 'nullable|in:pending,confirmed',
            'send_confirmation' => 'nullable|boolean'
        ], [
            'reservation_date.required' => 'La fecha de reserva es obligatoria.',
            'reservation_date.date' => 'La fecha de reserva no es válida.',
            'reservation_date.after_or_equal' => 'La fecha debe ser hoy o posterior.',
            'reservation_time.required' => 'La hora de reserva es obligatoria.',
            'reservation_time.regex' => 'La hora debe estar en formato HH:mm (ej: 14:30).',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        try {
            $data = $validator->validated();
            
            // Validar que los campos no estén vacíos
            if (empty($data['reservation_date']) || empty($data['reservation_time'])) {
                return back()
                    ->withErrors(['error' => 'La fecha y hora de reserva son obligatorias.'])
                    ->withInput();
            }
            
            // Normalizar formato de fecha y hora (solo si tienen valor)
            // Intentar parsear la fecha con múltiples formatos posibles
            $dateInput = trim($data['reservation_date']);
            $reservationDate = null;
            
            // Intentar diferentes formatos de fecha
            $dateFormats = ['Y-m-d', 'd/m/Y', 'Y/m/d', 'd-m-Y'];
            foreach ($dateFormats as $format) {
                try {
                    $parsedDate = \Carbon\Carbon::createFromFormat($format, $dateInput);
                    $reservationDate = $parsedDate->format('Y-m-d');
                    break;
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            // Si no se pudo parsear con formatos específicos, usar parse genérico
            if (!$reservationDate) {
                try {
                    $reservationDate = \Carbon\Carbon::parse($dateInput)->format('Y-m-d');
                } catch (\Exception $e) {
                    return back()
                        ->withErrors(['reservation_date' => 'La fecha no es válida. Use formato DD/MM/YYYY o YYYY-MM-DD.'])
                        ->withInput();
                }
            }
            
            $reservationTime = trim($data['reservation_time']);
            
            // Validar formato de hora manualmente
            if (!preg_match('/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/', $reservationTime)) {
                return back()
                    ->withErrors(['reservation_time' => 'El formato de hora no es válido. Use HH:mm (ej: 14:30).'])
                    ->withInput();
            }
            
            $data['reservation_date'] = $reservationDate;
            $data['reservation_time'] = $reservationTime;
            $data['created_by'] = auth()->id();
            $data['status'] = $data['status'] ?? 'confirmed';
            
            $reservation = $this->reservationService->createReservation($store, $data);
            
            // Enviar confirmación por WhatsApp si se solicita
            if ($request->boolean('send_confirmation')) {
                try {
                    $whatsapp = app(\App\Services\WhatsAppNotificationService::class);
                    if ($whatsapp->isEnabled()) {
                        if ($reservation->status === 'confirmed') {
                            $whatsapp->notifyReservationConfirmed($reservation);
                        } else {
                            $whatsapp->notifyReservationRequested($reservation);
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('Error enviando WhatsApp de reserva', [
                        'reservation_id' => $reservation->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Notificar al admin sobre nueva reserva
            try {
                $whatsapp = app(\App\Services\WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    $whatsapp->notifyAdminNewReservation($reservation, $store);
                }
            } catch (\Exception $e) {
                \Log::error('Error enviando WhatsApp de nueva reserva al admin', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage()
                ]);
            }
            
            return redirect()
                ->route('tenant.admin.reservations.index', ['store' => $store->slug])
                ->with('swal_success', '✅ Reservación creada correctamente.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Mostrar detalles de reservación
     */
    public function show($store, Reservation $reservation)
    {
        $store = view()->shared('currentStore');
        
        // Verificar que la reservación pertenece a la tienda
        if ($reservation->store_id !== $store->id) {
            abort(404);
        }
        
        $reservation->load(['table', 'createdBy']);
        
        return view('tenant-admin::reservations.show', compact('store', 'reservation'));
    }

    /**
     * Confirmar reservación
     */
    public function confirm(Request $request, $store, Reservation $reservation)
    {
        $store = view()->shared('currentStore');
        
        if ($reservation->store_id !== $store->id) {
            abort(404);
        }
        
        try {
            $tableId = $request->input('table_id');
            $this->reservationService->confirmReservation($reservation, $tableId);
            
            // Enviar WhatsApp de confirmación al cliente
            try {
                $whatsapp = app(\App\Services\WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    $settings = $this->reservationService->getSettings($store);
                    if ($settings->send_confirmation) {
                        $whatsapp->notifyReservationConfirmed($reservation);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error enviando WhatsApp de confirmación', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage()
                ]);
            }
            
            return back()->with('swal_success', '✅ Reservación confirmada correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Cancelar reservación
     */
    public function cancel(Request $request, $store, Reservation $reservation)
    {
        $store = view()->shared('currentStore');
        
        if ($reservation->store_id !== $store->id) {
            abort(404);
        }
        
        try {
            $reason = $request->input('reason');
            $this->reservationService->cancelReservation($reservation, $reason);
            
            // Enviar WhatsApp de cancelación al cliente
            try {
                $whatsapp = app(\App\Services\WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    $whatsapp->notifyReservationCancelled($reservation);
                }
            } catch (\Exception $e) {
                \Log::error('Error enviando WhatsApp de cancelación', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage()
                ]);
            }
            
            return back()->with('swal_success', '✅ Reservación cancelada correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Marcar como completada
     */
    public function complete(Request $request, $store, Reservation $reservation)
    {
        $store = view()->shared('currentStore');
        
        if ($reservation->store_id !== $store->id) {
            abort(404);
        }
        
        try {
            $this->reservationService->updateReservation($reservation, ['status' => 'completed']);
            
            return back()->with('swal_success', '✅ Reservación marcada como completada.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Configuración de reservaciones
     */
    public function settings()
    {
        $store = view()->shared('currentStore');
        
        $settings = $this->reservationService->getSettings($store);
        $tables = Table::where('store_id', $store->id)
            ->ordered()
            ->get();
        
        // Extraer time_slots desde settings
        $timeSlots = $settings->time_slots ?? [];
        
        return view('tenant-admin::reservations.settings', compact('store', 'settings', 'tables', 'timeSlots'));
    }

    /**
     * Guardar configuración
     */
    public function updateSettings(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Procesar time_slots desde el formulario
        $timeSlots = [];
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        
        foreach ($days as $day) {
            $dayEnabled = $request->boolean("daysEnabled.{$day}", false);
            if ($dayEnabled) {
                $slots = [];
                $slotCount = $request->input("slots_count.{$day}", 1);
                
                for ($i = 0; $i < $slotCount; $i++) {
                    $start = $request->input("time_slots.{$day}.{$i}.start");
                    $end = $request->input("time_slots.{$day}.{$i}.end");
                    
                    if ($start && $end && $start < $end) {
                        $slots[] = ['start' => $start, 'end' => $end];
                    }
                }
                
                if (!empty($slots)) {
                    $timeSlots[$day] = $slots;
                }
            }
        }
        
        $validator = Validator::make(array_merge($request->all(), ['time_slots' => $timeSlots]), [
            'time_slots' => 'nullable|array',
            'slot_duration' => 'required|integer|min:15|max:240',
            'require_deposit' => 'boolean',
            'deposit_per_person' => 'required_if:require_deposit,true|numeric|min:0',
            'send_confirmation' => 'boolean',
            'send_reminder' => 'boolean',
            'reminder_hours' => 'required|integer|min:1|max:168',
            'min_advance_hours' => 'required|integer|min:1|max:720'
        ]);
        
        if ($validator->fails()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }
        
        $settings = $this->reservationService->getSettings($store);
        $settings->update(array_merge($validator->validated(), ['time_slots' => $timeSlots]));
        
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '✅ Configuración actualizada correctamente.',
                'settings' => $settings->fresh()
            ]);
        }
        
        return back()->with('swal_success', '✅ Configuración actualizada correctamente.');
    }

    /**
     * Crear mesa (AJAX)
     */
    public function storeTable(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $validator = Validator::make($request->all(), [
            'table_number' => 'required|string|max:10',
            'capacity' => 'required|integer|min:1|max:50'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Verificar que no exista otra mesa con el mismo número en esta tienda
        $existingTable = Table::where('store_id', $store->id)
            ->where('table_number', $request->input('table_number'))
            ->first();
            
        if ($existingTable) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una mesa con ese número en esta tienda'
            ], 422);
        }
        
        $table = Table::create([
            'store_id' => $store->id,
            'table_number' => $request->input('table_number'),
            'capacity' => $request->input('capacity'),
            'is_active' => true
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Mesa creada correctamente',
            'table' => $table
        ]);
    }

    /**
     * Actualizar mesa (AJAX)
     */
    public function updateTable(Request $request, Table $table)
    {
        $store = view()->shared('currentStore');
        
        if ($table->store_id !== $store->id) {
            abort(404);
        }
        
        $validator = Validator::make($request->all(), [
            'table_number' => 'required|string|max:10',
            'capacity' => 'required|integer|min:1|max:50'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Verificar que no exista otra mesa con el mismo número en esta tienda (excepto la actual)
        $existingTable = Table::where('store_id', $store->id)
            ->where('table_number', $request->input('table_number'))
            ->where('id', '!=', $table->id)
            ->first();
            
        if ($existingTable) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una mesa con ese número en esta tienda'
            ], 422);
        }
        
        $table->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Mesa actualizada correctamente',
            'table' => $table->fresh()
        ]);
    }

    /**
     * Eliminar mesa
     */
    public function destroyTable(Table $table)
    {
        $store = view()->shared('currentStore');
        
        if ($table->store_id !== $store->id) {
            abort(404);
        }
        
        // Verificar si tiene reservaciones futuras
        $futureReservations = Reservation::where('table_id', $table->id)
            ->where('status', '!=', 'cancelled')
            ->whereDate('reservation_date', '>=', today())
            ->count();
        
        if ($futureReservations > 0) {
            return back()->withErrors(['error' => "No se puede eliminar la mesa porque tiene {$futureReservations} reservaciones futuras."]);
        }
        
        $table->delete();
        
        return back()->with('swal_success', '✅ Mesa eliminada correctamente.');
    }

    /**
     * Toggle estado de mesa
     */
    public function toggleTable(Table $table)
    {
        $store = view()->shared('currentStore');
        
        if ($table->store_id !== $store->id) {
            abort(404);
        }
        
        $table->update(['is_active' => !$table->is_active]);
        
        return back()->with('swal_success', '✅ Estado de mesa actualizado.');
    }
}

