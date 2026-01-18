<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Evento de prueba para verificar conexión con Ably
 * NO usar en producción - solo para testing
 * 
 * NOTA: No implementa ShouldQueue para que se envíe inmediatamente (útil para pruebas)
 */
class TestOrderNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, InteractsWithBroadcasting, SerializesModels;

    public $storeId;
    public $testData;

    /**
     * Create a new event instance.
     */
    public function __construct($storeId)
    {
        $this->storeId = $storeId;
        
        // Usar Ably si está configurado
        if (!empty(config('broadcasting.connections.ably-realtime.key')) || 
            !empty(config('broadcasting.connections.ably.key'))) {
            $this->broadcastVia('ably-realtime');
        }
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('store.' . $this->storeId . '.orders');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new.order';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'order_id' => 999,
            'order_number' => 'TEST-' . time(),
            'customer_name' => 'Cliente de Prueba',
            'total' => 50000,
            'formatted_total' => '$50.000',
            'payment_method' => 'test',
            'delivery_type' => 'test',
            'created_at' => now()->format('H:i'),
            'url' => '#',
            'test' => true,
            'message' => 'Esta es una notificación de prueba desde Ably'
        ];
    }
}
