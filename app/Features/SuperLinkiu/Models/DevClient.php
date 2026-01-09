<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DevClient extends Model
{
    protected $table = 'dev_clients';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'country_code',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Proyectos del cliente
     */
    public function projects(): HasMany
    {
        return $this->hasMany(DevProject::class, 'client_id');
    }

    /**
     * Entradas de agenda relacionadas
     */
    public function agendaEntries(): HasMany
    {
        return $this->hasMany(DevAgendaEntry::class, 'client_id');
    }

    /**
     * Logs de notificaciones
     */
    public function notificationLogs(): HasMany
    {
        return $this->hasMany(DevNotificationLog::class, 'client_id');
    }

    /**
     * Obtener número de teléfono completo con código de país
     */
    public function getFullPhoneAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        $countryCode = preg_replace('/[^0-9]/', '', $this->country_code);
        
        // Si el teléfono ya incluye el código de país, devolverlo tal cual
        if (str_starts_with($phone, $countryCode)) {
            return $phone;
        }
        
        return $countryCode . $phone;
    }

    /**
     * Proyectos activos count
     */
    public function getActiveProjectsCountAttribute(): int
    {
        return $this->projects()->whereIn('status', ['pending', 'in_progress', 'on_hold'])->count();
    }

    /**
     * Scope: Clientes activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Buscar por nombre o email
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }
}
