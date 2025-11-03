<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class RoomType extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'slug',
        'description',
        'max_occupancy',
        'base_occupancy',
        'max_adults',
        'max_children',
        'base_price_per_night',
        'extra_person_price',
        'amenities',
        'additional_services',
        'images',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'max_occupancy' => 'integer',
        'base_occupancy' => 'integer',
        'max_adults' => 'integer',
        'max_children' => 'integer',
        'base_price_per_night' => 'decimal:2',
        'extra_person_price' => 'decimal:2',
        'amenities' => 'array',
        'additional_services' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Generar slug automáticamente
        static::creating(function ($roomType) {
            if (empty($roomType->slug)) {
                $roomType->slug = Str::slug($roomType->name);
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
     * Relación con Rooms (habitaciones físicas)
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Relación con HotelReservations
     */
    public function hotelReservations(): HasMany
    {
        return $this->hasMany(HotelReservation::class);
    }

    /**
     * Scope: solo tipos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: ordenados por sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}

