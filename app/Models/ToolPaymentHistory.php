<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolPaymentHistory extends Model
{
    protected $fillable = [
        'tool_id',
        'payment_date',
        'amount',
        'payment_type',
        'currency',
        'receipt_path',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Relación con herramienta
     */
    public function tool()
    {
        return $this->belongsTo(LinkiuTool::class, 'tool_id');
    }

    /**
     * Relación con usuario creador
     */
    public function creator()
    {
        return $this->belongsTo(\App\Shared\Models\User::class, 'created_by');
    }

    /**
     * Obtener monto formateado
     */
    public function getFormattedAmount(): string
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    /**
     * Scope por tipo de pago
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('payment_type', $type);
    }

    /**
     * Scope por rango de fechas
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }
}
