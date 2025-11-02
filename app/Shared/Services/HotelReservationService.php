<?php

namespace App\Shared\Services;

use App\Shared\Models\Store;
use App\Shared\Models\RoomType;
use App\Shared\Models\Room;
use App\Shared\Models\HotelReservation;
use App\Shared\Models\HotelSetting;
use App\Shared\Enums\RoomStatus;
use App\Shared\Enums\HotelReservationStatus;
use App\Services\WhatsAppNotificationService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HotelReservationService
{
    /**
     * TTL del caché para disponibilidad (5 minutos)
     */
    const CACHE_TTL = 300;

    /**
     * Obtener configuración de hotel para una tienda
     */
    public function getSettings(Store $store): HotelSetting
    {
        return HotelSetting::firstOrCreate(
            ['store_id' => $store->id],
            [
                'check_in_time' => '15:00:00',
                'check_out_time' => '12:00:00',
                'deposit_type' => 'percentage',
                'deposit_percentage' => 50,
                'require_security_deposit' => false,
                'cancellation_hours' => 48,
                'min_guest_age' => 18,
                'min_advance_hours' => 2,
                'children_free_max_age' => 2,
                'children_discounted_max_age' => 11,
                'children_discount_percentage' => 50,
                'charge_children_by_occupancy' => true,
                'send_confirmation' => true,
                'send_checkin_reminder' => true,
                'reminder_hours' => 24
            ]
        );
    }

    /**
     * Verificar disponibilidad de tipos de habitación para un rango de fechas
     * 
     * Retorna array de tipos disponibles con cantidad disponible
     */
    public function getAvailableRoomTypes(Store $store, string $checkIn, string $checkOut): array
    {
        $cacheKey = "hotel.availability.{$store->id}.{$checkIn}.{$checkOut}";
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($store, $checkIn, $checkOut) {
            $checkInDate = Carbon::parse($checkIn);
            $checkOutDate = Carbon::parse($checkOut);
            
            // Validar que check-out sea después de check-in
            if ($checkOutDate->lte($checkInDate)) {
                return [];
            }
            
            // Obtener todos los tipos de habitación activos
            $roomTypes = RoomType::where('store_id', $store->id)
                ->where('is_active', true)
                ->ordered()
                ->get();
            
            $availableTypes = [];
            
            foreach ($roomTypes as $roomType) {
                $availability = $this->checkRoomTypeAvailability($store, $roomType, $checkIn, $checkOut);
                
                if ($availability['available_count'] > 0) {
                    $availableTypes[] = [
                        'room_type_id' => $roomType->id,
                        'name' => $roomType->name,
                        'description' => $roomType->description,
                        'max_occupancy' => $roomType->max_occupancy,
                        'base_occupancy' => $roomType->base_occupancy,
                        'base_price_per_night' => (float) $roomType->base_price_per_night,
                        'extra_person_price' => (float) $roomType->extra_person_price,
                        'amenities' => $roomType->amenities ?? [],
                        'additional_services' => $roomType->additional_services ?? [],
                        'images' => $roomType->images ?? [],
                        'available_count' => $availability['available_count'],
                        'total_count' => $availability['total_count']
                    ];
                }
            }
            
            return $availableTypes;
        });
    }

    /**
     * Verificar disponibilidad de un tipo de habitación específico
     * 
     * Retorna: ['available_count' => int, 'total_count' => int]
     */
    public function checkRoomTypeAvailability(
        Store $store,
        RoomType $roomType,
        string $checkIn,
        string $checkOut,
        ?int $excludeReservationId = null
    ): array {
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);
        
        // Obtener total de habitaciones del tipo (disponibles y no en mantenimiento/bloqueadas)
        $totalRooms = Room::where('store_id', $store->id)
            ->where('room_type_id', $roomType->id)
            ->whereIn('status', [RoomStatus::AVAILABLE->value, RoomStatus::OCCUPIED->value])
            ->count();
        
        if ($totalRooms === 0) {
            return [
                'available_count' => 0,
                'total_count' => 0
            ];
        }
        
        // Obtener reservas que se traslapan con el rango solicitado
        // Se traslapan si:
        // - check_in está dentro del rango [checkIn, checkOut)
        // - check_out está dentro del rango (checkIn, checkOut]
        // - El rango de reserva abarca completamente el rango solicitado
        $overlappingReservations = HotelReservation::where('store_id', $store->id)
            ->where('room_type_id', $roomType->id)
            ->whereIn('status', [
                HotelReservationStatus::PENDING->value,
                HotelReservationStatus::CONFIRMED->value,
                HotelReservationStatus::CHECKED_IN->value
            ])
            ->when($excludeReservationId, function ($query) use ($excludeReservationId) {
                return $query->where('id', '!=', $excludeReservationId);
            })
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                // Reservas que empiezan antes de check-out y terminan después de check-in
                // (permite que check-out = check-in, no hay traslape)
                $query->where('check_in_date', '<', $checkOutDate->format('Y-m-d'))
                      ->where('check_out_date', '>', $checkInDate->format('Y-m-d'));
            })
            ->get();
        
        // Contar habitaciones ocupadas (cada reserva ocupa una habitación)
        $occupiedCount = $overlappingReservations->count();
        
        // Disponibles = total - ocupadas
        $availableCount = max(0, $totalRooms - $occupiedCount);
        
        return [
            'available_count' => $availableCount,
            'total_count' => $totalRooms
        ];
    }

    /**
     * Calcular precio total de una reserva
     * 
     * Retorna: [
     *   'base_price' => float,
     *   'extra_person_charge' => float,
     *   'services_total' => float,
     *   'subtotal' => float,
     *   'security_deposit' => float,
     *   'total' => float,
     *   'num_nights' => int
     * ]
     */
    public function calculatePricing(
        Store $store,
        RoomType $roomType,
        string $checkIn,
        string $checkOut,
        int $numAdults,
        int $numChildren = 0,
        array $selectedServices = [],
        array $childrenAges = []
    ): array {
        $settings = $this->getSettings($store);
        
        // Calcular número de noches
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);
        $numNights = max(1, $checkInDate->diffInDays($checkOutDate));
        
        // Precio base por noche
        $basePricePerNight = (float) $roomType->base_price_per_night;
        $basePriceTotal = $basePricePerNight * $numNights;
        
        // Calcular cargos por niños según políticas
        $childrenCharge = 0;
        $childrenFreeCount = 0;
        $childrenDiscountedCount = 0;
        $childrenAdultCount = 0;
        
        // Si hay edades de niños, calcular según políticas
        if (!empty($childrenAges) && count($childrenAges) === $numChildren) {
            foreach ($childrenAges as $age) {
                $age = (int) $age;
                if ($age <= $settings->children_free_max_age) {
                    // Niño gratis (no cuenta en ocupación extra)
                    $childrenFreeCount++;
                } elseif ($age <= $settings->children_discounted_max_age) {
                    // Niño con descuento
                    $childrenDiscountedCount++;
                    $discountPercent = $settings->children_discount_percentage / 100;
                    $childrenCharge += ($basePricePerNight * (1 - $discountPercent)) * $numNights;
                } else {
                    // Niño paga como adulto
                    $childrenAdultCount++;
                    $childrenCharge += $basePricePerNight * $numNights;
                }
            }
        } else {
            // Si no hay edades, tratar todos como adultos para cálculo de ocupación
            $childrenAdultCount = $numChildren;
        }
        
        // Calcular ocupación total para cargo extra
        // Adultos + niños que cuentan como adultos (si charge_children_by_occupancy está activo)
        $countableGuests = $numAdults;
        if ($settings->charge_children_by_occupancy) {
            $countableGuests += $childrenDiscountedCount + $childrenAdultCount;
        } else {
            // Solo contar adultos para ocupación
            $countableGuests += $childrenAdultCount;
        }
        
        // Cargo por personas extra (base_occupancy está incluido en el precio base)
        $extraGuests = max(0, $countableGuests - $roomType->base_occupancy);
        $extraPersonPricePerNight = (float) $roomType->extra_person_price;
        $extraPersonCharge = $extraPersonPricePerNight * $extraGuests * $numNights;
        
        // Si no había edades pero hay niños, aplicar cargo básico
        if (empty($childrenAges) && $numChildren > 0) {
            $extraPersonCharge += ($extraPersonPricePerNight * $numChildren * $numNights);
        }
        
        // Servicios adicionales
        $servicesTotal = 0;
        $additionalServices = $roomType->additional_services ?? [];
        
        foreach ($selectedServices as $selectedService) {
            $serviceName = $selectedService['name'] ?? '';
            $serviceQuantity = $selectedService['quantity'] ?? 1;
            
            // Buscar el servicio en la lista de servicios adicionales del tipo
            foreach ($additionalServices as $service) {
                if (($service['name'] ?? '') === $serviceName) {
                    $servicePrice = (float) ($service['price'] ?? 0);
                    $servicesTotal += $servicePrice * $serviceQuantity;
                }
            }
        }
        
        // Subtotal = base + cargo por niños + extra personas + servicios
        $subtotal = $basePriceTotal + $childrenCharge + $extraPersonCharge + $servicesTotal;
        
        // Depósito de seguridad
        $securityDeposit = 0;
        if ($settings->require_security_deposit) {
            $securityDeposit = (float) $settings->security_deposit_amount;
        }
        
        // Total = subtotal + depósito de seguridad
        $total = $subtotal + $securityDeposit;
        
        return [
            'base_price' => $basePriceTotal,
            'base_price_per_night' => $basePricePerNight,
            'children_charge' => $childrenCharge,
            'children_free_count' => $childrenFreeCount,
            'children_discounted_count' => $childrenDiscountedCount,
            'children_adult_count' => $childrenAdultCount,
            'extra_person_charge' => $extraPersonCharge,
            'services_total' => $servicesTotal,
            'subtotal' => $subtotal,
            'security_deposit' => $securityDeposit,
            'total' => $total,
            'num_nights' => $numNights
        ];
    }

    /**
     * Asignar habitación automáticamente de un tipo específico
     * Busca la primera habitación disponible que no esté reservada en el rango de fechas
     */
    public function assignRoom(
        Store $store,
        RoomType $roomType,
        string $checkIn,
        string $checkOut,
        ?int $excludeReservationId = null
    ): ?Room {
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);
        
        // Obtener todas las habitaciones del tipo disponibles o ocupadas
        $allRooms = Room::where('store_id', $store->id)
            ->where('room_type_id', $roomType->id)
            ->whereIn('status', [RoomStatus::AVAILABLE->value, RoomStatus::OCCUPIED->value])
            ->orderBy('room_number')
            ->get();
        
        // Obtener IDs de habitaciones ocupadas en ese rango
        $overlappingReservations = HotelReservation::where('store_id', $store->id)
            ->where('room_type_id', $roomType->id)
            ->whereIn('status', [
                HotelReservationStatus::PENDING->value,
                HotelReservationStatus::CONFIRMED->value,
                HotelReservationStatus::CHECKED_IN->value
            ])
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->where('check_in_date', '<', $checkOutDate->format('Y-m-d'))
                      ->where('check_out_date', '>', $checkInDate->format('Y-m-d'));
            })
            ->when($excludeReservationId, function ($query) use ($excludeReservationId) {
                return $query->where('id', '!=', $excludeReservationId);
            })
            ->whereNotNull('room_id')
            ->pluck('room_id')
            ->toArray();
        
        // Buscar primera habitación no ocupada
        foreach ($allRooms as $room) {
            if (!in_array($room->id, $overlappingReservations)) {
                return $room;
            }
        }
        
        // Si no hay habitación disponible, retornar null (el admin asignará manualmente)
        return null;
    }

    /**
     * Validar que las fechas cumplan con las políticas del hotel
     */
    public function validateDates(Store $store, string $checkIn, string $checkOut): array
    {
        $settings = $this->getSettings($store);
        $errors = [];
        
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);
        $now = Carbon::now();
        
        // Validar que check-out sea después de check-in
        if ($checkOutDate->lte($checkInDate)) {
            $errors[] = 'La fecha de check-out debe ser posterior a la fecha de check-in.';
        }
        
        // Validar anticipación mínima
        $hoursUntilCheckIn = $now->diffInHours($checkInDate, false);
        if ($hoursUntilCheckIn < $settings->min_advance_hours && !$checkInDate->isToday()) {
            $errors[] = "Se requiere una anticipación mínima de {$settings->min_advance_hours} horas.";
        }
        
        // No permitir fechas pasadas
        if ($checkInDate->isPast() && !$checkInDate->isToday()) {
            $errors[] = 'No se pueden hacer reservas para fechas pasadas.';
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Crear reserva de hotel
     */
    public function createReservation(Store $store, array $data): HotelReservation
    {
        $settings = $this->getSettings($store);
        
        DB::beginTransaction();
        try {
            // Validar fechas
            $validation = $this->validateDates($store, $data['check_in_date'], $data['check_out_date']);
            if (!$validation['valid']) {
                throw new \Exception(implode(' ', $validation['errors']));
            }
            
            // Obtener tipo de habitación
            $roomType = RoomType::where('store_id', $store->id)
                ->where('id', $data['room_type_id'])
                ->where('is_active', true)
                ->firstOrFail();
            
            // Verificar disponibilidad
            $availability = $this->checkRoomTypeAvailability(
                $store,
                $roomType,
                $data['check_in_date'],
                $data['check_out_date']
            );
            
            if ($availability['available_count'] === 0) {
                throw new \Exception('No hay habitaciones disponibles de este tipo para las fechas seleccionadas.');
            }
            
            // Calcular pricing
            // Extraer edades de niños si están disponibles
            $childrenAges = [];
            if (isset($data['additional_guests']) && is_array($data['additional_guests'])) {
                foreach ($data['additional_guests'] as $guest) {
                    if (isset($guest['type']) && $guest['type'] === 'child' && isset($guest['age'])) {
                        $childrenAges[] = (int) $guest['age'];
                    }
                }
            }
            
            $pricing = $this->calculatePricing(
                $store,
                $roomType,
                $data['check_in_date'],
                $data['check_out_date'],
                $data['num_adults'] ?? 1,
                $data['num_children'] ?? 0,
                $data['selected_services'] ?? [],
                $childrenAges
            );
            
            // Calcular anticipo
            $depositAmount = $settings->calculateDepositAmount($pricing['total']);
            
            // Preparar admin_notes con información de huéspedes adicionales
            $adminNotesData = [];
            if (isset($data['additional_guests']) && !empty($data['additional_guests'])) {
                $adminNotesData['additional_guests'] = $data['additional_guests'];
            }
            
            // Crear reserva (sin asignar habitación aún - se asigna al confirmar)
            $reservation = HotelReservation::create([
                'store_id' => $store->id,
                'room_type_id' => $roomType->id,
                'room_id' => null, // Se asignará al confirmar
                'check_in_date' => $data['check_in_date'],
                'check_out_date' => $data['check_out_date'],
                'num_nights' => $pricing['num_nights'],
                'estimated_arrival_time' => $data['estimated_arrival_time'] ?? null,
                'num_adults' => $data['num_adults'] ?? 1,
                'num_children' => $data['num_children'] ?? 0,
                'guest_name' => $data['guest_name'],
                'guest_phone' => $data['guest_phone'],
                'guest_email' => $data['guest_email'] ?? null,
                'guest_document_type' => $data['guest_document_type'] ?? null,
                'guest_document' => $data['guest_document'] ?? null,
                'guest_city' => $data['guest_city'] ?? null,
                'base_price_per_night' => $pricing['base_price_per_night'],
                'extra_person_charge' => $pricing['extra_person_charge'],
                'services_total' => $pricing['services_total'],
                'subtotal' => $pricing['subtotal'],
                'security_deposit' => $pricing['security_deposit'],
                'deposit_amount' => $depositAmount,
                'deposit_paid' => $data['deposit_paid'] ?? false,
                'payment_proof' => $data['payment_proof'] ?? null,
                'total' => $pricing['total'],
                'selected_services' => $data['selected_services'] ?? null,
                'status' => $data['status'] ?? HotelReservationStatus::PENDING->value,
                'special_requests' => $data['special_requests'] ?? null,
                'admin_notes' => !empty($adminNotesData) ? json_encode($adminNotesData) : null,
                'created_by' => $data['created_by'] ?? null,
                'confirmed_at' => ($data['status'] ?? HotelReservationStatus::PENDING->value) === HotelReservationStatus::CONFIRMED->value ? now() : null
            ]);
            
            // Invalidar caché
            $this->invalidateAvailabilityCache($store, $data['check_in_date'], $data['check_out_date']);
            
            DB::commit();
            
            return $reservation;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Confirmar reserva y asignar habitación
     */
    public function confirmReservation(HotelReservation $reservation, ?int $roomId = null): HotelReservation
    {
        if ($reservation->status === HotelReservationStatus::CONFIRMED->value) {
            return $reservation;
        }
        
        DB::beginTransaction();
        try {
            // Asignar habitación si no tiene
            if (!$reservation->room_id && !$roomId) {
                $room = $this->assignRoom(
                    $reservation->store,
                    $reservation->roomType,
                    $reservation->check_in_date->format('Y-m-d'),
                    $reservation->check_out_date->format('Y-m-d'),
                    $reservation->id
                );
                
                if (!$room) {
                    throw new \Exception('No hay habitaciones disponibles para asignar. Por favor, asigne una habitación manualmente.');
                }
                
                $roomId = $room->id;
            }
            
            // Actualizar reserva
            $reservation->update([
                'status' => HotelReservationStatus::CONFIRMED->value,
                'room_id' => $roomId ?? $reservation->room_id,
                'confirmed_at' => now()
            ]);
            
            // Actualizar estado de la habitación a ocupada
            if ($reservation->room_id) {
                $reservation->room->update(['status' => RoomStatus::OCCUPIED->value]);
            }
            
            // Invalidar caché
            $this->invalidateAvailabilityCache(
                $reservation->store,
                $reservation->check_in_date->format('Y-m-d'),
                $reservation->check_out_date->format('Y-m-d')
            );
            
            DB::commit();
            
            return $reservation->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Realizar check-in
     */
    public function checkIn(HotelReservation $reservation): HotelReservation
    {
        if ($reservation->status !== HotelReservationStatus::CONFIRMED->value) {
            throw new \Exception('Solo se puede hacer check-in de reservas confirmadas.');
        }
        
        DB::beginTransaction();
        try {
            $reservation->update([
                'status' => HotelReservationStatus::CHECKED_IN->value,
                'checked_in_at' => now()
            ]);
            
            // Asegurar que la habitación esté marcada como ocupada
            if ($reservation->room_id) {
                $reservation->room->update(['status' => RoomStatus::OCCUPIED->value]);
            }
            
            DB::commit();
            
            // Enviar notificación de WhatsApp
            try {
                $whatsapp = app(WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    $whatsapp->notifyHotelCheckInCompleted($reservation->fresh(['room', 'roomType', 'store']));
                }
            } catch (\Exception $e) {
                Log::error('Error enviando notificación WhatsApp de check-in', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage()
                ]);
                // No lanzar excepción para no fallar el check-in
            }
            
            return $reservation->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Realizar check-out
     */
    public function checkOut(HotelReservation $reservation): HotelReservation
    {
        if ($reservation->status !== HotelReservationStatus::CHECKED_IN->value) {
            throw new \Exception('Solo se puede hacer check-out de reservas con check-in realizado.');
        }
        
        DB::beginTransaction();
        try {
            $reservation->update([
                'status' => HotelReservationStatus::CHECKED_OUT->value,
                'checked_out_at' => now()
            ]);
            
            // Liberar habitación
            if ($reservation->room_id) {
                $reservation->room->update(['status' => RoomStatus::AVAILABLE->value]);
            }
            
            // Invalidar caché para que quede disponible
            $this->invalidateAvailabilityCache(
                $reservation->store,
                $reservation->check_in_date->format('Y-m-d'),
                $reservation->check_out_date->format('Y-m-d')
            );
            
            DB::commit();
            
            // Enviar notificación de WhatsApp
            try {
                $whatsapp = app(WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    $whatsapp->notifyHotelCheckOutCompleted($reservation->fresh(['room', 'roomType', 'store']));
                }
            } catch (\Exception $e) {
                Log::error('Error enviando notificación WhatsApp de check-out', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage()
                ]);
                // No lanzar excepción para no fallar el check-out
            }
            
            return $reservation->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Cancelar reserva
     */
    public function cancelReservation(HotelReservation $reservation, ?string $reason = null): HotelReservation
    {
        DB::beginTransaction();
        try {
            $reservation->update([
                'status' => HotelReservationStatus::CANCELLED->value,
                'cancelled_at' => now(),
                'cancellation_reason' => $reason
            ]);
            
            // Liberar habitación si estaba asignada
            if ($reservation->room_id) {
                $reservation->room->update(['status' => RoomStatus::AVAILABLE->value]);
            }
            
            // Invalidar caché
            $this->invalidateAvailabilityCache(
                $reservation->store,
                $reservation->check_in_date->format('Y-m-d'),
                $reservation->check_out_date->format('Y-m-d')
            );
            
            DB::commit();
            
            return $reservation->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Invalidar caché de disponibilidad
     */
    public function invalidateAvailabilityCache(Store $store, string $checkIn, string $checkOut): void
    {
        $cacheKey = "hotel.availability.{$store->id}.{$checkIn}.{$checkOut}";
        Cache::forget($cacheKey);
    }

    /**
     * Obtener ocupación de habitaciones para un rango de fechas
     * Útil para dashboard/calendario
     */
    public function getOccupancy(Store $store, string $startDate, string $endDate): array
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        // Obtener todas las habitaciones del hotel
        $rooms = Room::where('store_id', $store->id)
            ->with('roomType')
            ->orderBy('room_type_id')
            ->orderBy('room_number')
            ->get();
        
        // Obtener reservas en el rango
        $reservations = HotelReservation::where('store_id', $store->id)
            ->where(function ($query) use ($start, $end) {
                $query->where('check_in_date', '<=', $end->format('Y-m-d'))
                      ->where('check_out_date', '>=', $start->format('Y-m-d'));
            })
            ->whereIn('status', [
                HotelReservationStatus::CONFIRMED->value,
                HotelReservationStatus::CHECKED_IN->value
            ])
            ->with(['room', 'roomType'])
            ->get();
        
        // Construir matriz de ocupación [habitación][fecha] = estado
        $occupancy = [];
        
        foreach ($rooms as $room) {
            $occupancy[$room->id] = [
                'room' => $room,
                'dates' => []
            ];
            
            $currentDate = $start->copy();
            while ($currentDate->lte($end)) {
                $dateStr = $currentDate->format('Y-m-d');
                
                // Buscar si hay reserva que ocupa esta habitación en esta fecha
                $hasReservation = $reservations->first(function ($reservation) use ($room, $currentDate) {
                    return $reservation->room_id === $room->id
                        && $currentDate->gte(Carbon::parse($reservation->check_in_date))
                        && $currentDate->lt(Carbon::parse($reservation->check_out_date));
                });
                
                $occupancy[$room->id]['dates'][$dateStr] = [
                    'date' => $dateStr,
                    'occupied' => $hasReservation !== null,
                    'reservation' => $hasReservation
                ];
                
                $currentDate->addDay();
            }
        }
        
        return $occupancy;
    }
}

