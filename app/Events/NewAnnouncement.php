<?php

namespace App\Events;

use App\Shared\Models\PlatformAnnouncement;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewAnnouncement implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
            'created_at' => $this->announcement->created_at->format('d/m/Y H:i')
        ];
    }
}

