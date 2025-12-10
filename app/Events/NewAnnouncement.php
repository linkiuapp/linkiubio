<?php

namespace App\Events;

use App\Shared\Models\PlatformAnnouncement;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewAnnouncement implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;
    
    /**
     * Determine if the event should broadcast.
     * Si Pusher falla, no debe romper la creación del anuncio
     */
    public function shouldBroadcast(): bool
    {
        try {
            // Solo broadcast si Pusher está configurado correctamente
            return config('broadcasting.default') === 'pusher' 
                && !empty(config('broadcasting.connections.pusher.key'));
        } catch (\Exception $e) {
            \Log::warning('Broadcasting check failed: ' . $e->getMessage());
            return false;
        }
    }

    public $announcement;

    /**
     * Create a new event instance.
     */
    public function __construct(PlatformAnnouncement $announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        // Canal público para todos los admins de tiendas
        return new Channel('platform.announcements');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new.announcement';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        $typeIcons = [
            'info' => 'ℹ️',
            'warning' => '⚠️',
            'success' => '✅',
            'error' => '❌',
            'update' => '🔔'
        ];

        $typeLabels = [
            'info' => 'Información',
            'warning' => 'Importante',
            'success' => 'Actualización',
            'error' => 'Urgente',
            'update' => 'Novedad'
        ];

        // Convertir tipo a categoría de prioridad
        $isUrgent = in_array($this->announcement->type, ['critical', 'important']) || $this->announcement->priority >= 8;
        
        return [
            'id' => $this->announcement->id,
            'title' => $this->announcement->title,
            'message' => \Str::limit(strip_tags($this->announcement->content), 100),
            'type' => $this->announcement->type,
            'type_icon' => $typeIcons[$this->announcement->type] ?? '📢',
            'type_label' => $typeLabels[$this->announcement->type] ?? 'Anuncio',
            'priority' => $this->announcement->priority,
            'is_urgent' => $isUrgent,
            'show_popup' => $this->announcement->show_popup, // Agregar campo popup
            'created_at' => $this->announcement->created_at->format('d/m/Y H:i')
        ];
    }
}

