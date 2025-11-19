<?php

namespace App\Features\TenantAdmin\Services\Core;

use App\Shared\Models\Location;
use App\Shared\Models\LocationSchedule;
use App\Shared\Models\LocationSocialLink;
use App\Shared\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LocationService
{
    /**
     * Check if a store can create more locations based on plan limits.
     */
    public function canCreateLocation(Store $store): bool
    {
        $maxLocations = $this->getMaxLocations($store);
        $currentCount = $store->locations()->count();
        
        return $currentCount < $maxLocations;
    }
    
    /**
     * Get the maximum number of locations allowed for a store based on plan.
     */
    public function getMaxLocations(Store $store): int
    {
        // Usar el límite real del plan desde la base de datos
        return $store->plan->max_sedes ?? 1;
    }
    
    /**
     * Get the remaining location slots for a store.
     */
    public function getRemainingLocationSlots(Store $store): int
    {
        $maxLocations = $this->getMaxLocations($store);
        $currentCount = $store->locations()->count();
        
        return max(0, $maxLocations - $currentCount);
    }
    
    /**
     * Create a new location with schedules and social links.
     */
    public function createLocationWithSchedules(array $data): Location
    {
        // Validate plan limits
        $store = Store::findOrFail($data['store_id']);
        
        if (!$this->canCreateLocation($store)) {
            throw ValidationException::withMessages([
                'store_id' => ['Has alcanzado el límite de sedes para tu plan actual.']
            ]);
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Create location
            $location = Location::create([
                'store_id' => $data['store_id'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'manager_name' => $data['manager_name'] ?? null,
                'phone' => $data['phone'],
                'whatsapp' => $data['whatsapp'] ?? null,
                'department' => $data['department'],
                'city' => $data['city'],
                'address' => $data['address'],
                'is_main' => $data['is_main'] ?? false,
                'is_active' => $data['is_active'] ?? true,
                'whatsapp_message' => $data['whatsapp_message'] ?? null
            ]);
            
            // If this is the first location or marked as main, set as main
            if ($data['is_main'] ?? false) {
                $this->setMainLocation($location);
            } else if ($store->locations()->count() === 1) {
                // If this is the first location, set as main automatically
                $this->setMainLocation($location);
            }
            
            // Create schedules
            if (isset($data['schedules']) && is_array($data['schedules'])) {
                $this->createOrUpdateSchedules($location, $data['schedules']);
            } else {
                // Create default schedules (Mon-Fri 9-18, Sat 9-13, Sun closed)
                $this->createDefaultSchedules($location);
            }
            
            // Create social links
            if (isset($data['social_links']) && is_array($data['social_links'])) {
                $this->createOrUpdateSocialLinks($location, $data['social_links']);
            }
            
            DB::commit();
            
            return $location;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * Update an existing location with schedules and social links.
     */
    public function updateLocationWithSchedules(Location $location, array $data): Location
    {
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Update location
            $location->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'manager_name' => $data['manager_name'] ?? null,
                'phone' => $data['phone'],
                'whatsapp' => $data['whatsapp'] ?? null,
                'department' => $data['department'],
                'city' => $data['city'],
                'address' => $data['address'],
                'is_active' => $data['is_active'] ?? true,
                'whatsapp_message' => $data['whatsapp_message'] ?? null
            ]);
            
            // Handle main location status
            if (($data['is_main'] ?? false) && !$location->is_main) {
                $this->setMainLocation($location);
            }
            
            // Update schedules
            if (isset($data['schedules']) && is_array($data['schedules'])) {
                $this->createOrUpdateSchedules($location, $data['schedules']);
            }
            
            // Update social links
            if (isset($data['social_links']) && is_array($data['social_links'])) {
                $this->createOrUpdateSocialLinks($location, $data['social_links']);
            }
            
            DB::commit();
            
            return $location;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * Set a location as the main location for its store.
     */
    public function setMainLocation(Location $location): void
    {
        // Remove main status from all other locations
        Location::where('store_id', $location->store_id)
            ->where('id', '!=', $location->id)
            ->update(['is_main' => false]);
        
        // Set this location as main
        $location->update(['is_main' => true]);
    }
    
    /**
     * Create or update schedules for a location.
     */
    protected function createOrUpdateSchedules(Location $location, array $schedules): void
    {
        // Validate schedules
        $errors = $this->validateSchedules($schedules);
        
        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
        
        // Delete existing schedules
        $location->schedules()->delete();
        
        // Create new schedules
        foreach ($schedules as $dayOfWeek => $schedule) {
            LocationSchedule::create([
                'location_id' => $location->id,
                'day_of_week' => $dayOfWeek,
                'is_closed' => $schedule['is_closed'] ?? false,
                'open_time_1' => $schedule['is_closed'] ? null : $schedule['open_time_1'],
                'close_time_1' => $schedule['is_closed'] ? null : $schedule['close_time_1'],
                'open_time_2' => $schedule['is_closed'] ? null : ($schedule['open_time_2'] ?? null),
                'close_time_2' => $schedule['is_closed'] ? null : ($schedule['close_time_2'] ?? null)
            ]);
        }
    }
    
    /**
     * Create default schedules for a location.
     */
    protected function createDefaultSchedules(Location $location): void
    {
        $defaultSchedules = [
            // Monday to Friday: 9:00 - 18:00
            1 => ['is_closed' => false, 'open_time_1' => '09:00:00', 'close_time_1' => '18:00:00'],
            2 => ['is_closed' => false, 'open_time_1' => '09:00:00', 'close_time_1' => '18:00:00'],
            3 => ['is_closed' => false, 'open_time_1' => '09:00:00', 'close_time_1' => '18:00:00'],
            4 => ['is_closed' => false, 'open_time_1' => '09:00:00', 'close_time_1' => '18:00:00'],
            5 => ['is_closed' => false, 'open_time_1' => '09:00:00', 'close_time_1' => '18:00:00'],
            // Saturday: 9:00 - 13:00
            6 => ['is_closed' => false, 'open_time_1' => '09:00:00', 'close_time_1' => '13:00:00'],
            // Sunday: Closed
            0 => ['is_closed' => true]
        ];
        
        $this->createOrUpdateSchedules($location, $defaultSchedules);
    }
    
    /**
     * Create or update social links for a location.
     */
    protected function createOrUpdateSocialLinks(Location $location, array $socialLinks): void
    {
        // Delete existing social links
        $location->socialLinks()->delete();
        
        // Create new social links
        foreach ($socialLinks as $platform => $url) {
            if (!empty($url)) {
                LocationSocialLink::create([
                    'location_id' => $location->id,
                    'platform' => $platform,
                    'url' => $url
                ]);
            }
        }
    }
    
    /**
     * Validate schedules data.
     * Permite horarios que cruzan medianoche (ej: 17:00 - 02:00)
     */
    public function validateSchedules(array $schedules): array
    {
        $errors = [];
        
        foreach ($schedules as $dayOfWeek => $schedule) {
            if ($schedule['is_closed'] ?? false) {
                continue;
            }
            
            // Validate primary schedule
            if (empty($schedule['open_time_1']) || empty($schedule['close_time_1'])) {
                $errors["schedules.{$dayOfWeek}.primary"] = 'El horario principal es obligatorio.';
                continue;
            }
            
            // ✅ PERMITIR cruce de medianoche - Solo validar que no sean iguales
            if ($schedule['open_time_1'] === $schedule['close_time_1']) {
                $errors["schedules.{$dayOfWeek}.primary"] = 'La hora de apertura no puede ser igual a la de cierre.';
            }
            
            // Validate additional schedule if provided
            if (!empty($schedule['open_time_2']) || !empty($schedule['close_time_2'])) {
                if (empty($schedule['open_time_2']) || empty($schedule['close_time_2'])) {
                    $errors["schedules.{$dayOfWeek}.additional"] = 'Ambos campos del horario adicional son obligatorios.';
                } elseif ($schedule['open_time_2'] === $schedule['close_time_2']) {
                    $errors["schedules.{$dayOfWeek}.additional"] = 'La hora de apertura adicional no puede ser igual a la de cierre adicional.';
                } else {
                    // ✅ Validar que no haya traslape entre turno 1 y turno 2
                    if ($this->schedulesOverlap($schedule)) {
                        $errors["schedules.{$dayOfWeek}.overlap"] = 'Los turnos no pueden traslaparse. El turno 1 debe terminar antes que empiece el turno 2.';
                    }
                }
            }
        }
        
        return $errors;
    }
    
    /**
     * Check if schedule times overlap (considers midnight crossing)
     */
    private function schedulesOverlap(array $schedule): bool
    {
        $open1 = $schedule['open_time_1'];
        $close1 = $schedule['close_time_1'];
        $open2 = $schedule['open_time_2'];
        $close2 = $schedule['close_time_2'];
        
        // Si turno 1 cruza medianoche (ej: 17:00 - 02:00)
        if ($open1 > $close1) {
            // El turno 2 NO puede empezar entre el rango de turno 1
            // open2 debe estar entre close1 y open1 (ventana libre)
            // Traslape si: open2 >= open1 OR open2 <= close1
            if ($open2 >= $open1 || $open2 <= $close1) {
                return true;
            }
        } else {
            // Turno 1 normal (ej: 09:00 - 18:00)
            // Turno 2 debe empezar después de close1
            if ($open2 <= $close1) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Calculate the current status of a location.
     */
    public function calculateCurrentStatus(Location $location): array
    {
        $status = $location->getCurrentStatus();
        $nextChange = $location->getNextStatusChange();
        
        $statusText = match($status) {
            'open' => 'Abierto',
            'closed' => 'Cerrado',
            'temporarily_closed' => 'Cerrado temporalmente',
            'inactive' => 'Inactivo',
            default => 'Desconocido'
        };
        
        $statusColor = match($status) {
            'open' => 'success',
            'closed' => 'error',
            'temporarily_closed' => 'warning',
            'inactive' => 'secondary',
            default => 'secondary'
        };
        
        $nextChangeText = null;
        
        if ($nextChange) {
            $nextChangeText = match($status) {
                'open' => "Cierra a las {$nextChange->format('H:i')}",
                'closed', 'temporarily_closed' => "Abre a las {$nextChange->format('H:i')}",
                default => null
            };
        }
        
        return [
            'status' => $status,
            'statusText' => $statusText,
            'statusColor' => $statusColor,
            'nextChange' => $nextChange,
            'nextChangeText' => $nextChangeText
        ];
    }
}

