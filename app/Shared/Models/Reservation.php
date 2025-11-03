<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    protected $fillable = [
        'store_id',
        'table_id',
        'customer_name',
        'customer_phone',
        'party_size',
        'reservation_date',
        'reservation_time',
        'status',
        'requires_deposit',
        'deposit_amount',
        'deposit_paid',
        'payment_proof',
        'notes',
        'cancellation_reason',
        'reference_code',
        'created_by',
        'confirmed_at',
        'cancelled_at',
        'reminder_sent_at'
    ];

    protected $casts = [
        'reservation_date' => 'date', // Cast como date para usar como Carbon
        'reservation_time' => 'string', // TIME se guarda como string 'HH:MM'
        'status' => 'string',
        'requires_deposit' => 'boolean',
        'deposit_amount' => 'decimal:2',
        'deposit_paid' => 'boolean',
        'party_size' => 'integer',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'reminder_sent_at' => 'datetime'
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Generar código de referencia único al crear
        static::creating(function ($reservation) {
            if (empty($reservation->reference_code)) {
                do {
                    $code = 'RSV-' . strtoupper(Str::random(8));
                } while (self::where('reference_code', $code)->exists());
                
                $reservation->reference_code = $code;
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
     * Relación con Table
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Relación con User (creado por)
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(\App\Shared\Models\User::class, 'created_by');
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

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope: por fecha
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('reservation_date', $date);
    }

    /**
     * Scope: para hoy
     */
    public function scopeToday($query)
    {
        return $query->whereDate('reservation_date', today());
    }

    /**
     * Scope: para mañana
     */
    public function scopeTomorrow($query)
    {
        return $query->whereDate('reservation_date', today()->addDay());
    }

    /**
     * Scope: por store
     */
    public function scopeForStore($query, $storeId)
    {
        return $query->where('store_id', $storeId);
    }
    
    /**
     * Obtener fecha de reserva como string sin conversiones
     * Consulta directamente la BD para evitar cualquier transformación
     */
    public function getRawReservationDate(): string
    {
        // Siempre consultar directamente la BD para evitar problemas de casts/zonas horarias
        $value = DB::table('reservations')
            ->where('id', $this->id)
            ->value('reservation_date');
        
        return $value ?? '';
    }
    
    /**
     * Obtener hora de reserva como string sin conversiones
     * Consulta directamente la BD para evitar cualquier transformación
     */
    public function getRawReservationTime(): string
    {
        // Siempre consultar directamente la BD para evitar problemas de casts
        $value = DB::table('reservations')
            ->where('id', $this->id)
            ->value('reservation_time');
        
        if (empty($value)) {
            return '';
        }
        
        // MySQL TIME devuelve formato HH:mm:ss, convertir a HH:mm
        return strlen($value) > 5 ? substr($value, 0, 5) : $value;
    }
}

