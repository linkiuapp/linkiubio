<?php

namespace App\Shared\Services;

use App\Shared\Models\Store;
use App\Shared\Models\Reservation;
use App\Shared\Models\Table;
use App\Shared\Models\ReservationSetting;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ReservationService
{
    /**
     * TTL del caché para capacidad (5 minutos)
     */
    const CACHE_TTL = 300;

    /**
     * Obtener configuración de reservaciones para una tienda
     */
    public function getSettings(Store $store): ReservationSetting
    {
        return ReservationSetting::getOrCreateForStore($store->id);
    }

    /**
     * Verificar capacidad disponible para una fecha/hora específica
     * 
     * Retorna: ['available' => bool, 'used_capacity' => int, 'total_capacity' => int, 'status' => string]
     */
    public function checkAvailability(Store $store, string $date, string $time, ?int $excludeReservationId = null): array
    {
        $cacheKey = "reservation.availability.{$store->id}.{$date}.{$time}";
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($store, $date, $time, $excludeReservationId) {
            // Obtener capacidad total de mesas activas
            $totalCapacity = $this->getTotalCapacity($store);
            
            // Obtener reservas en ese slot (confirmadas y pendientes, no canceladas)
            // Incluir pendientes porque también ocupan capacidad
            // Usar comparación directa con TIME_FORMAT para comparar solo HH:mm sin segundos
            $reservations = Reservation::where('store_id', $store->id)
                ->whereDate('reservation_date', $date)
                ->whereRaw("TIME_FORMAT(reservation_time, '%H:%i') = ?", [$time]) // Comparar solo HH:mm
                ->whereIn('status', ['confirmed', 'pending']) // Incluir pendientes también
                ->when($excludeReservationId, function ($query) use ($excludeReservationId) {
                    return $query->where('id', '!=', $excludeReservationId);
                })
                ->get();
            
            // Sumar capacidad usada
            $usedCapacity = $reservations->sum('party_size');
            
            // Calcular porcentaje de uso
            $usagePercent = $totalCapacity > 0 ? ($usedCapacity / $totalCapacity) * 100 : 0;
            
            // Determinar estado basado en capacidad y existencia de reservas
            // Si hay reservas confirmadas o pendientes, marcar como no disponible
            if ($reservations->count() > 0) {
                $status = 'full';
                $available = false;
            } elseif ($usagePercent >= 100) {
                $status = 'full';
                $available = false;
            } else {
                // Solo disponible si no hay reservas y hay capacidad
                $status = 'available';
                $available = true;
            }
            $remainingCapacity = max(0, $totalCapacity - $usedCapacity);
            
            return [
                'available' => $available,
                'used_capacity' => $usedCapacity,
                'total_capacity' => $totalCapacity,
                'remaining_capacity' => $remainingCapacity,
                'usage_percent' => $usagePercent,
                'status' => $status,
                'reservations_count' => $reservations->count()
            ];
        });
    }

    /**
     * Obtener capacidad total de mesas activas
     */
    public function getTotalCapacity(Store $store): int
    {
        return Table::where('store_id', $store->id)
            ->where('is_active', true)
            ->sum('capacity');
    }

    /**
     * Generar slots de tiempo disponibles para una fecha
     * Basado en time_slots de ReservationSetting
     */
    public function getAvailableTimeSlots(Store $store, string $date): array
    {
        $settings = $this->getSettings($store);
        $timeSlots = $settings->time_slots ?? [];
        
        // Obtener día de la semana (0 = domingo, 1 = lunes, ..., 6 = sábado)
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = strtolower($carbonDate->locale('es')->dayName);
        
        // Mapear nombres de días en español a inglés
        $dayMap = [
            'domingo' => 'sunday',
            'lunes' => 'monday',
            'martes' => 'tuesday',
            'miércoles' => 'wednesday',
            'jueves' => 'thursday',
            'viernes' => 'friday',
            'sábado' => 'saturday'
        ];
        
        $dayKey = $dayMap[$dayOfWeek] ?? $dayOfWeek;
        
        // Si no hay configuración para ese día, retornar vacío
        if (empty($timeSlots[$dayKey])) {
            return [];
        }
        
        $slots = [];
        $slotDuration = $settings->slot_duration ?? 60; // minutos
        $seenSlots = []; // Evitar duplicados
        
        foreach ($timeSlots[$dayKey] as $timeRange) {
            $start = Carbon::parse($timeRange['start']);
            $end = Carbon::parse($timeRange['end']);
            
            // Generar slots cada X minutos
            $current = $start->copy();
            
            // Asegurar que no excedemos el rango final
            while ($current->lt($end)) {
                $slotTime = $current->format('H:i');
                
                // Evitar duplicados - usar array asociativo para verificación rápida
                if (array_key_exists($slotTime, $seenSlots)) {
                    $current->addMinutes($slotDuration);
                    continue;
                }
                $seenSlots[$slotTime] = true;
                
                $slotEnd = $current->copy()->addMinutes($slotDuration);
                
                // Si el slot excede el rango final, no incluirlo
                if ($slotEnd->gt($end)) {
                    break;
                }
                
                // Verificar disponibilidad
                $availability = $this->checkAvailability($store, $date, $slotTime);
                
                $slots[] = [
                    'time' => $slotTime,
                    'end_time' => $slotEnd->format('H:i'),
                    'available' => $availability['available'],
                    'status' => $availability['status'],
                    'remaining_capacity' => $availability['remaining_capacity'],
                    'usage_percent' => round($availability['usage_percent'], 1),
                    'reservations_count' => $availability['reservations_count']
                ];
                
                $current->addMinutes($slotDuration);
            }
        }
        
        return $slots;
    }

    /**
     * Verificar si una fecha está disponible para reservas
     * (verifica anticipación mínima)
     */
    public function isDateAvailable(Store $store, string $date): bool
    {
        $settings = $this->getSettings($store);
        $minAdvanceHours = $settings->min_advance_hours ?? 2;
        
        $reservationDate = Carbon::parse($date);
        $now = Carbon::now();
        
        // No permitir fechas pasadas
        if ($reservationDate->isPast() && !$reservationDate->isToday()) {
            return false;
        }
        
        // Verificar anticipación mínima
        $hoursUntilReservation = $now->diffInHours($reservationDate, false);
        
        if ($hoursUntilReservation < $minAdvanceHours && !$reservationDate->isToday()) {
            return false;
        }
        
        // Si es hoy, verificar horas mínimas
        if ($reservationDate->isToday()) {
            // Calcular la hora mínima permitida para hoy
            $minTime = $now->copy()->addHours($minAdvanceHours);
            return true; // Se validará en el slot
        }
        
        return true;
    }

    /**
     * Asignar mesa automáticamente según capacidad
     */
    public function assignTable(Store $store, int $partySize, string $date, string $time, ?int $excludeReservationId = null): ?Table
    {
        // Obtener mesas activas ordenadas por capacidad (ascendente para optimizar)
        $tables = Table::where('store_id', $store->id)
            ->where('is_active', true)
            ->where('capacity', '>=', $partySize)
            ->orderBy('capacity', 'asc')
            ->get();
        
        // Obtener reservas confirmadas en ese slot
        $reservedTableIds = Reservation::where('store_id', $store->id)
            ->whereDate('reservation_date', $date)
            ->whereTime('reservation_time', $time)
            ->where('status', 'confirmed')
            ->whereNotNull('table_id')
            ->when($excludeReservationId, function ($query) use ($excludeReservationId) {
                return $query->where('id', '!=', $excludeReservationId);
            })
            ->pluck('table_id')
            ->toArray();
        
        // Buscar mesa disponible que no esté reservada
        foreach ($tables as $table) {
            if (!in_array($table->id, $reservedTableIds)) {
                return $table;
            }
        }
        
        // Si no hay mesa disponible exacta, retornar null (el admin asignará manualmente)
        return null;
    }

    /**
     * Validar que la hora esté dentro de los horarios configurados para el día
     */
    public function validateTimeSlot(Store $store, string $date, string $time): bool
    {
        $settings = $this->getSettings($store);
        $timeSlots = $settings->time_slots ?? [];
        
        // Obtener día de la semana
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = strtolower($carbonDate->locale('es')->dayName);
        
        // Mapear nombres de días en español a inglés
        $dayMap = [
            'domingo' => 'sunday',
            'lunes' => 'monday',
            'martes' => 'tuesday',
            'miércoles' => 'wednesday',
            'jueves' => 'thursday',
            'viernes' => 'friday',
            'sábado' => 'saturday'
        ];
        
        $dayKey = $dayMap[$dayOfWeek] ?? $dayOfWeek;
        
        // Si no hay configuración para ese día, la fecha está cerrada
        if (empty($timeSlots[$dayKey])) {
            return false;
        }
        
        // Parsear la hora de la reserva
        $reservationTime = Carbon::parse($time);
        
        // Verificar si la hora está dentro de alguno de los rangos configurados
        foreach ($timeSlots[$dayKey] as $timeRange) {
            $rangeStart = Carbon::parse($timeRange['start']);
            $rangeEnd = Carbon::parse($timeRange['end']);
            
            // Si el rango cruza medianoche (ej: 22:00 - 02:00)
            if ($rangeEnd->lt($rangeStart)) {
                // Rango que cruza medianoche
                if ($reservationTime->gte($rangeStart) || $reservationTime->lte($rangeEnd)) {
                    return true;
                }
            } else {
                // Rango normal (no cruza medianoche)
                if ($reservationTime->gte($rangeStart) && $reservationTime->lte($rangeEnd)) {
                    return true;
                }
            }
        }
        
        return false;
    }

    /**
     * Crear reservación
     */
    public function createReservation(Store $store, array $data): Reservation
    {
        $settings = $this->getSettings($store);
        
        DB::beginTransaction();
        try {
            // Validar anticipación mínima
            $reservationDate = Carbon::parse($data['reservation_date']);
            if (!$this->isDateAvailable($store, $data['reservation_date'])) {
                throw new \Exception('La fecha no está disponible. Se requiere anticipación mínima de ' . ($settings->min_advance_hours ?? 2) . ' horas.');
            }
            
            // Validar que la hora esté dentro de los horarios configurados para ese día
            if (!$this->validateTimeSlot($store, $data['reservation_date'], $data['reservation_time'])) {
                throw new \Exception('La hora seleccionada no está dentro de los horarios configurados para ese día.');
            }
            
            // Verificar disponibilidad (capacidad)
            $availability = $this->checkAvailability($store, $data['reservation_date'], $data['reservation_time']);
            if (!$availability['available']) {
                throw new \Exception('No hay disponibilidad en ese horario.');
            }
            
            // Calcular anticipo si aplica
            $depositAmount = null;
            if ($settings->require_deposit && isset($data['party_size'])) {
                $depositAmount = $settings->deposit_per_person * $data['party_size'];
            }
            
            // Asignar mesa si no se especificó
            $tableId = $data['table_id'] ?? null;
            if (!$tableId && isset($data['party_size'])) {
                $table = $this->assignTable($store, $data['party_size'], $data['reservation_date'], $data['reservation_time']);
                $tableId = $table?->id;
            }
            
            // Crear reservación
            $reservation = Reservation::create([
                'store_id' => $store->id,
                'table_id' => $tableId,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'party_size' => $data['party_size'],
                'reservation_date' => $data['reservation_date'], // Ya viene en formato Y-m-d
                'reservation_time' => $data['reservation_time'], // Ya viene en formato H:i
                'status' => $data['status'] ?? 'pending',
                'requires_deposit' => $settings->require_deposit ?? false,
                'deposit_amount' => $depositAmount,
                'deposit_paid' => $data['deposit_paid'] ?? false,
                'payment_proof' => $data['payment_proof'] ?? null,
                'notes' => $data['notes'] ?? null,
                'created_by' => $data['created_by'] ?? null,
                'confirmed_at' => ($data['status'] ?? 'pending') === 'confirmed' ? now() : null
            ]);
            
            // Invalidar caché de disponibilidad
            $this->invalidateAvailabilityCache($store, $data['reservation_date'], $data['reservation_time']);
            
            DB::commit();
            
            return $reservation;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Actualizar reservación
     */
    public function updateReservation(Reservation $reservation, array $data): Reservation
    {
        DB::beginTransaction();
        try {
            $oldDate = $reservation->reservation_date->format('Y-m-d');
            $oldTime = $reservation->reservation_time;
            
            // Si cambia fecha/hora, verificar disponibilidad
            if (isset($data['reservation_date']) || isset($data['reservation_time'])) {
                $newDate = $data['reservation_date'] ?? $oldDate;
                $newTime = $data['reservation_time'] ?? $oldTime;
                
                $availability = $this->checkAvailability(
                    $reservation->store,
                    $newDate,
                    $newTime,
                    $reservation->id
                );
                
                if (!$availability['available']) {
                    throw new \Exception('No hay disponibilidad en ese horario.');
                }
                
                // Reasignar mesa si cambió fecha/hora o tamaño de grupo
                if (isset($data['party_size']) || $newDate !== $oldDate || $newTime !== $oldTime) {
                    $partySize = $data['party_size'] ?? $reservation->party_size;
                    $table = $this->assignTable(
                        $reservation->store,
                        $partySize,
                        $newDate,
                        $newTime,
                        $reservation->id
                    );
                    if ($table) {
                        $data['table_id'] = $table->id;
                    }
                }
            }
            
            // Actualizar confirmación si cambia a confirmed
            if (isset($data['status']) && $data['status'] === 'confirmed' && $reservation->status !== 'confirmed') {
                $data['confirmed_at'] = now();
            }
            
            // Actualizar cancelación si cambia a cancelled
            if (isset($data['status']) && $data['status'] === 'cancelled' && $reservation->status !== 'cancelled') {
                $data['cancelled_at'] = now();
            }
            
            $reservation->update($data);
            
            // Invalidar caché de disponibilidad (tanto fecha antigua como nueva)
            $this->invalidateAvailabilityCache($reservation->store, $oldDate, $oldTime);
            if (isset($newDate) && isset($newTime)) {
                $this->invalidateAvailabilityCache($reservation->store, $newDate, $newTime);
            }
            
            DB::commit();
            
            return $reservation->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Confirmar reservación
     */
    public function confirmReservation(Reservation $reservation, ?int $tableId = null): Reservation
    {
        if ($reservation->status === 'confirmed') {
            return $reservation;
        }
        
        DB::beginTransaction();
        try {
            // Asignar mesa si no tiene
            if (!$reservation->table_id && !$tableId) {
                $table = $this->assignTable(
                    $reservation->store,
                    $reservation->party_size,
                    $reservation->reservation_date->format('Y-m-d'),
                    $reservation->reservation_time,
                    $reservation->id
                );
                if ($table) {
                    $tableId = $table->id;
                }
            }
            
            $reservation->update([
                'status' => 'confirmed',
                'table_id' => $tableId ?? $reservation->table_id,
                'confirmed_at' => now()
            ]);
            
            // Invalidar caché
            $this->invalidateAvailabilityCache(
                $reservation->store,
                $reservation->reservation_date->format('Y-m-d'),
                $reservation->reservation_time
            );
            
            DB::commit();
            
            return $reservation->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Cancelar reservación
     */
    public function cancelReservation(Reservation $reservation, ?string $reason = null): Reservation
    {
        DB::beginTransaction();
        try {
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $reason
            ]);
            
            // Invalidar caché para liberar capacidad
            $this->invalidateAvailabilityCache(
                $reservation->store,
                $reservation->reservation_date->format('Y-m-d'),
                $reservation->reservation_time
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
    public function invalidateAvailabilityCache(Store $store, string $date, string $time): void
    {
        $cacheKey = "reservation.availability.{$store->id}.{$date}.{$time}";
        Cache::forget($cacheKey);
    }

    /**
     * Obtener estadísticas de reservaciones para una tienda
     */
    public function getStatistics(Store $store, ?string $startDate = null, ?string $endDate = null): array
    {
        $query = Reservation::where('store_id', $store->id);
        
        if ($startDate) {
            $query->whereDate('reservation_date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('reservation_date', '<=', $endDate);
        }
        
        $total = $query->count();
        $pending = (clone $query)->where('status', 'pending')->count();
        $confirmed = (clone $query)->where('status', 'confirmed')->count();
        $completed = (clone $query)->where('status', 'completed')->count();
        $cancelled = (clone $query)->where('status', 'cancelled')->count();
        
        return [
            'total' => $total,
            'pending' => $pending,
            'confirmed' => $confirmed,
            'completed' => $completed,
            'cancelled' => $cancelled
        ];
    }
}

