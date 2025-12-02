<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use App\Shared\Traits\BelongsToTenant;

class Table extends Model
{
    use BelongsToTenant;
    
    protected $fillable = [
        'store_id',
        'tenant_id',
        'table_number',
        'type',
        'capacity',
        'qr_code',
        'qr_url',
        'is_active',
        'status',
        'current_order_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Constantes de tipo
    const TYPE_MESA = 'mesa';
    const TYPE_HABITACION = 'habitacion';

    const TYPES = [
        self::TYPE_MESA => 'Mesa',
        self::TYPE_HABITACION => 'Habitación',
    ];

    // Constantes de estado
    const STATUS_AVAILABLE = 'available';
    const STATUS_OCCUPIED = 'occupied';
    const STATUS_RESERVED = 'reserved';

    const STATUSES = [
        self::STATUS_AVAILABLE => 'Disponible',
        self::STATUS_OCCUPIED => 'Ocupada',
        self::STATUS_RESERVED => 'Reservada',
    ];

    /**
     * Boot del modelo para sincronizar tenant_id con store_id
     */
    protected static function boot()
    {
        parent::boot();
        
        // Sincronizar tenant_id con store_id al crear
        static::creating(function ($table) {
            if ($table->store_id && !$table->tenant_id) {
                $table->tenant_id = $table->store_id;
            }
        });
        
        // Sincronizar tenant_id con store_id al actualizar
        static::updating(function ($table) {
            if ($table->isDirty('store_id')) {
                $table->tenant_id = $table->store_id;
            }
        });
    }

    /**
     * Relación con Store
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Relación con Order actual
     */
    public function currentOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'current_order_id');
    }

    /**
     * Relación con Reservations
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(\App\Shared\Models\Reservation::class, 'table_id');
    }

    /**
     * Scope: solo mesas/habitaciones activas
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: ordenadas por número
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('table_number');
    }

    /**
     * Scope: por tipo (mesa o habitación)
     */
    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: por estado
     */
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: disponibles
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_AVAILABLE)
                     ->where('is_active', true);
    }

    /**
     * Obtener label del tipo
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    /**
     * Obtener label del estado
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /**
     * Verificar si está disponible
     */
    public function isAvailable(): bool
    {
        return $this->is_active && $this->status === self::STATUS_AVAILABLE;
    }

    /**
     * Ocupar mesa/habitación con una orden
     */
    public function occupy(int $orderId): void
    {
        $this->update([
            'status' => self::STATUS_OCCUPIED,
            'current_order_id' => $orderId,
        ]);
    }

    /**
     * Liberar mesa/habitación
     */
    public function liberate(): void
    {
        $this->update([
            'status' => self::STATUS_AVAILABLE,
            'current_order_id' => null,
        ]);
    }
}

