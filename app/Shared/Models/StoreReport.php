<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreReport extends Model
{
    protected $fillable = [
        'store_id',
        'reason',
        'description',
        'reporter_email',
        'reporter_ip',
        'user_agent',
        'status',
        'admin_notes',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Relación con Store
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Relación con el admin que revisó
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Obtener el nombre del motivo en español
     */
    public function getReasonNameAttribute(): string
    {
        $reasons = [
            'producto_defectuoso' => 'Producto defectuoso',
            'envio_tardio' => 'Envío tardío',
            'mal_servicio' => 'Mal servicio al cliente',
            'cobro_incorrecto' => 'Cobro incorrecto',
            'fraude' => 'Posible fraude',
            'contenido_inapropiado' => 'Contenido inapropiado',
            'otro' => 'Otro motivo',
        ];

        return $reasons[$this->reason] ?? $this->reason;
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }
}

