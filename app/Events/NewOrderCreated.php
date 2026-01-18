<?php

namespace App\Events;

use App\Shared\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, InteractsWithBroadcasting, SerializesModels;

    public $order;
    public $storeId;
    
    /**
     * Determine if the event should broadcast.
     * Prioriza Ably para notificaciones de pedidos (mayor confiabilidad)
     * Si Ably no está configurado, usa Pusher como fallback
     */
    public function shouldBroadcast(): bool
    {
        try {
            // Prioridad 1: Usar Ably si está configurado (para notificaciones de pedidos)
            if (!empty(config('broadcasting.connections.ably.key')) || 
                !empty(config('broadcasting.connections.ably-realtime.key'))) {
                return true;
            }
            
            // Prioridad 2: Fallback a Pusher si está configurado
            if (config('broadcasting.default') === 'pusher' 
                && !empty(config('broadcasting.connections.pusher.key'))) {
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            \Log::warning('Broadcasting check failed for NewOrderCreated: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->storeId = $order->store_id;
        
        // Siempre usar Ably para notificaciones de pedidos
        $this->broadcastVia('ably-realtime');
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        // Canal específico por tienda
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
        // Generar URL absoluta usando APP_URL para evitar problemas con localhost
        $orderUrl = url(route('tenant.admin.orders.show', [$this->order->store->slug, $this->order->id], false));
        
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer_name' => $this->order->customer_name,
            'total' => $this->order->total,
            'formatted_total' => '$' . number_format($this->order->total, 0, ',', '.'),
            'payment_method' => $this->order->payment_method,
            'delivery_type' => $this->order->delivery_type,
            'created_at' => $this->order->created_at->format('H:i'),
            'url' => $orderUrl
        ];
    }
}

