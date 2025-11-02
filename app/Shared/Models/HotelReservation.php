<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class HotelReservation extends Model
{
    protected $fillable = [
        'store_id',
        'room_type_id',
        'room_id',
        'reservation_code',
        'check_in_date',
        'check_out_date',
        'num_nights',
        'estimated_arrival_time',
        'num_adults',
        'num_children',
        'guest_name',
        'guest_phone',
        'guest_email',
        'guest_document_type',
        'guest_document',
        'guest_city',
        'base_price_per_night',
        'extra_person_charge',
        'services_total',
        'subtotal',
        'security_deposit',
        'deposit_amount',
        'deposit_paid',
        'payment_proof',
        'total',
        'selected_services',
        'status',
        'special_requests',
        'cancellation_reason',
        'admin_notes',
        'created_by',
        'confirmed_at',
        'checked_in_at',
        'checked_out_at',
        'cancelled_at',
        'reminder_sent_at'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'num_nights' => 'integer',
        'num_adults' => 'integer',
        'num_children' => 'integer',
        'base_price_per_night' => 'decimal:2',
        'extra_person_charge' => 'decimal:2',
        'services_total' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'deposit_paid' => 'boolean',
        'selected_services' => 'array',
        'status' => 'string',
        'confirmed_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'reminder_sent_at' => 'datetime'
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Generar código de reserva único al crear
        static::creating(function ($reservation) {
            if (empty($reservation->reservation_code)) {
                do {
                    $code = 'HTL-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
                } while (self::where('reservation_code', $code)->exists());
                
                $reservation->reservation_code = $code;
            }

            // Calcular número de noches si no está establecido
            if (empty($reservation->num_nights) && $reservation->check_in_date && $reservation->check_out_date) {
                $checkIn = \Carbon\Carbon::parse($reservation->check_in_date);
                $checkOut = \Carbon\Carbon::parse($reservation->check_out_date);
                $reservation->num_nights = max(1, $checkIn->diffInDays($checkOut));
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
     * Relación con RoomType
     */
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Relación con Room
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Relación con User (creado por)
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scopes para estados
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCheckedIn($query)
    {
        return $query->where('status', 'checked_in');
    }

    public function scopeCheckedOut($query)
    {
        return $query->where('status', 'checked_out');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope: por rango de fechas (traslapes)
     */
    public function scopeOverlappingDates($query, $checkIn, $checkOut)
    {
        return $query->where(function ($q) use ($checkIn, $checkOut) {
            $q->where(function ($subQ) use ($checkIn, $checkOut) {
                // Reservas que empiezan dentro del rango
                $subQ->whereBetween('check_in_date', [$checkIn, $checkOut]);
            })
            ->orWhere(function ($subQ) use ($checkIn, $checkOut) {
                // Reservas que terminan dentro del rango
                $subQ->whereBetween('check_out_date', [$checkIn, $checkOut]);
            })
            ->orWhere(function ($subQ) use ($checkIn, $checkOut) {
                // Reservas que abarcan todo el rango
                $subQ->where('check_in_date', '<=', $checkIn)
                     ->where('check_out_date', '>=', $checkOut);
            });
        });
    }

    /**
     * Scope: reservas activas (no canceladas)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed', 'checked_in']);
    }
}

