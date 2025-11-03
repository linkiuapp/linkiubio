<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'store_id',
        'room_type_id',
        'room_number',
        'floor',
        'location_notes',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    /**
     * Relación con Store
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Relación con RoomType
     */
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Relación con HotelReservations
     */
    public function hotelReservations(): HasMany
    {
        return $this->hasMany(HotelReservation::class);
    }

    /**
     * Scope: solo habitaciones disponibles
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope: solo habitaciones ocupadas
     */
    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    /**
     * Scope: habitaciones en mantenimiento
     */
    public function scopeMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    /**
     * Scope: habitaciones bloqueadas
     */
    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocked');
    }

    /**
     * Scope: por tipo de habitación
     */
    public function scopeForRoomType($query, $roomTypeId)
    {
        return $query->where('room_type_id', $roomTypeId);
    }
}

