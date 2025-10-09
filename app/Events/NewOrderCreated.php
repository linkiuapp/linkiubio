<?php

namespace App\Events;

use App\Shared\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $storeId;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->storeId = $order->store_id;
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
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer_name' => $this->order->customer_name,
            'total' => $this->order->total,
            'formatted_total' => '$' . number_format($this->order->total, 0, ',', '.'),
            'payment_method' => $this->order->payment_method,
            'delivery_type' => $this->order->delivery_type,
            'created_at' => $this->order->created_at->format('H:i'),
            'url' => route('tenant.admin.orders.show', [$this->order->store->slug, $this->order->id])
        ];
    }
}

