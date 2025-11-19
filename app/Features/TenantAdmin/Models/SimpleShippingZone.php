<?php

namespace App\Features\TenantAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimpleShippingZone extends Model
{
    protected $fillable = [
        'simple_shipping_id',
        'name',
        'cost',
        'delivery_time',
        'cities',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'cities' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Relación con la configuración de envío
     */
    public function simpleShipping(): BelongsTo
    {
        return $this->belongsTo(SimpleShipping::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Verificar si una ciudad está en esta zona
     * Compatible con formato antiguo (string) y nuevo (array con department)
     */
    public function hasCity(string $city): bool
    {
        if (!$this->cities || !is_array($this->cities)) {
            return false;
        }

        $city = $this->normalizeCity($city);
        
        foreach ($this->cities as $zoneCity) {
            // Formato antiguo: string
            if (is_string($zoneCity)) {
                if ($this->normalizeCity($zoneCity) === $city) {
                    return true;
                }
            }
            // Formato nuevo: array con 'name' y 'department'
            elseif (is_array($zoneCity) && isset($zoneCity['name'])) {
                if ($this->normalizeCity($zoneCity['name']) === $city) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Normalizar nombre de ciudad para comparación
     */
    private function normalizeCity(string $city): string
    {
        return trim(strtolower($city));
    }

    /**
     * Obtener ciudades como string separado por comas
     * Compatible con formato antiguo (string) y nuevo (array con department)
     */
    public function getCitiesStringAttribute(): string
    {
        if (!$this->cities || !is_array($this->cities)) {
            return '';
        }

        $cityNames = array_map(function($city) {
            // Formato antiguo: string
            if (is_string($city)) {
                return $city;
            }
            // Formato nuevo: array con 'name' y 'department'
            if (is_array($city) && isset($city['name'])) {
                return $city['name'];
            }
            return '';
        }, $this->cities);

        return implode(', ', array_filter($cityNames));
    }

    /**
     * Formatear precio
     */
    public function getFormattedCostAttribute(): string
    {
        return '$' . number_format($this->cost, 0, ',', '.');
    }

    /**
     * Obtener label del tiempo de entrega
     */
    public function getDeliveryTimeLabelAttribute(): string
    {
        $times = SimpleShipping::DELIVERY_TIMES;
        return $times[$this->delivery_time] ?? $this->delivery_time;
    }

    /**
     * Obtener departamentos únicos de las ciudades configuradas
     */
    public function getDepartmentsAttribute(): array
    {
        if (!$this->cities || !is_array($this->cities)) {
            return [];
        }

        $departments = [];
        foreach ($this->cities as $city) {
            // Solo procesar formato nuevo con department
            if (is_array($city) && isset($city['department'])) {
                $departments[] = $city['department'];
            }
        }
        
        return array_values(array_unique($departments));
    }

    /**
     * Obtener ciudades de un departamento específico
     */
    public function getCitiesByDepartment(string $department): array
    {
        if (!$this->cities || !is_array($this->cities)) {
            return [];
        }

        $result = [];
        foreach ($this->cities as $city) {
            // Solo procesar formato nuevo con department
            if (is_array($city) && isset($city['department']) && $city['department'] === $department && isset($city['name'])) {
                $result[] = $city['name'];
            }
        }
        
        return $result;
    }
}
