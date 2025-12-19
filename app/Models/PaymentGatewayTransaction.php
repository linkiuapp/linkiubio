<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentGatewayTransaction extends Model
{
    protected $fillable = [
        'payment_gateway_id',
        'transaction_id',
        'reference',
        'reference_type',
        'amount',
        'currency',
        'status',
        'request_data',
        'response_data',
        'error_message',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'request_data' => 'array',
        'response_data' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Relación con payment gateway
     */
    public function paymentGateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    /**
     * Verificar si está aprobada
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Verificar si está pendiente
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Marcar como aprobada
     */
    public function markAsApproved(): void
    {
        $this->update([
            'status' => 'approved',
            'processed_at' => now(),
        ]);
    }

    /**
     * Marcar como rechazada
     */
    public function markAsRejected(?string $errorMessage = null): void
    {
        $this->update([
            'status' => 'rejected',
            'error_message' => $errorMessage,
            'processed_at' => now(),
        ]);
    }
}
