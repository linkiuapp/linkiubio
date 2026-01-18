<?php

namespace App\Events;

use App\Shared\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, InteractsWithBroadcasting, SerializesModels;

    public $order;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        
        // Siempre usar Ably para notificaciones de estado de pedidos
        $this->broadcastVia('ably-realtime');
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        // Canal específico por pedido (para que solo lo reciba el cliente de ese pedido)
        return new Channel('order.' . $this->order->id);
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'status.changed';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        $statusMessages = [
            'pending' => 'Tu pedido está pendiente de confirmación',
            'confirmed' => '¡Tu pedido ha sido confirmado! 🎉',
            'preparing' => 'Estamos preparando tu pedido 👨‍🍳',
            'ready' => '¡Tu pedido está listo! 📦',
            'in_transit' => 'Tu pedido está en camino 🚚',
            'delivered' => '¡Pedido entregado! Gracias por tu compra 💚',
            'cancelled' => 'Tu pedido ha sido cancelado'
        ];

        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'status_label' => ucfirst(str_replace('_', ' ', $this->newStatus)),
            'message' => $statusMessages[$this->newStatus] ?? 'Estado del pedido actualizado',
            'customer_name' => $this->order->customer_name,
            'updated_at' => now()->format('H:i')
        ];
    }
}

