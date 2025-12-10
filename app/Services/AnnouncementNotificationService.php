<?php

namespace App\Services;

use App\Shared\Models\PlatformAnnouncement;
use App\Shared\Models\NotificationChannel;
use App\Shared\Models\NotificationDelivery;
use App\Shared\Models\Store;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AnnouncementNotificationService
{
    protected $otpSmsService;
    protected $whatsappService;

    public function __construct()
    {
        // Inyectar servicios si están disponibles
        if (class_exists(\App\Services\OTPSmsService::class)) {
            $this->otpSmsService = app(\App\Services\OTPSmsService::class);
        }
    }

    /**
     * Send announcement to all target stores via enabled channels
     */
    public function sendAnnouncement(PlatformAnnouncement $announcement): array
    {
        $results = [
            'whatsapp' => ['sent' => 0, 'failed' => 0],
            'email' => ['sent' => 0, 'failed' => 0],
            'in_app' => ['sent' => 0, 'failed' => 0],
        ];

        // Get target stores
        $stores = $this->getTargetStores($announcement);

        // Get enabled channels
        $channels = $announcement->channels()->where('enabled', true)->get();

        if ($channels->isEmpty()) {
            // If no channels configured, use default (in_app only)
            $channels = collect([
                NotificationChannel::create([
                    'announcement_id' => $announcement->id,
                    'channel' => 'in_app',
                    'enabled' => true,
                ])
            ]);
        }

        foreach ($stores as $store) {
            foreach ($channels as $channel) {
                try {
                    $delivery = NotificationDelivery::firstOrCreate(
                        [
                            'announcement_id' => $announcement->id,
                            'store_id' => $store->id,
                            'channel' => $channel->channel,
                        ],
                        [
                            'status' => NotificationDelivery::STATUS_PENDING,
                        ]
                    );

                    if ($delivery->status === NotificationDelivery::STATUS_PENDING) {
                        $this->sendViaChannel($announcement, $store, $channel->channel, $delivery);
                        $results[$channel->channel]['sent']++;
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to send announcement notification', [
                        'announcement_id' => $announcement->id,
                        'store_id' => $store->id,
                        'channel' => $channel->channel,
                        'error' => $e->getMessage(),
                    ]);

                    if (isset($delivery)) {
                        $delivery->markAsFailed($e->getMessage());
                    }

                    $results[$channel->channel]['failed']++;
                }
            }
        }

        // Update channel sent_at timestamps
        foreach ($channels as $channel) {
            if (!$channel->sent_at) {
                $channel->update(['sent_at' => now()]);
            }
        }

        return $results;
    }

    /**
     * Send notification via specific channel
     */
    protected function sendViaChannel(
        PlatformAnnouncement $announcement,
        Store $store,
        string $channel,
        NotificationDelivery $delivery
    ): void {
        switch ($channel) {
            case NotificationDelivery::CHANNEL_WHATSAPP:
                $this->sendWhatsApp($announcement, $store, $delivery);
                break;

            case NotificationDelivery::CHANNEL_EMAIL:
                $this->sendEmail($announcement, $store, $delivery);
                break;

            case NotificationDelivery::CHANNEL_IN_APP:
                $this->sendInApp($announcement, $store, $delivery);
                break;
        }
    }

    /**
     * Send via WhatsApp using Infobip template
     */
    protected function sendWhatsApp(
        PlatformAnnouncement $announcement,
        Store $store,
        NotificationDelivery $delivery
    ): void {
        $phone = $store->owner_phone ?? $store->phone;

        if (!$phone) {
            throw new \Exception('Store does not have a phone number');
        }

        if (!$this->otpSmsService || !$this->otpSmsService->isEnabled()) {
            throw new \Exception('WhatsApp service not available');
        }

        try {
            // Get template parameters
            $params = $this->formatWhatsAppMessage($announcement, $store);
            
            // Send via Infobip WhatsApp API
            $this->sendWhatsAppViaInfobip($phone, $params, $delivery);

            Log::info('Announcement sent via WhatsApp', [
                'announcement_id' => $announcement->id,
                'store_id' => $store->id,
                'phone' => $phone,
            ]);
        } catch (\Exception $e) {
            $delivery->markAsFailed($e->getMessage());
            throw $e;
        }
    }

    /**
     * Send WhatsApp message via Infobip API
     */
    protected function sendWhatsAppViaInfobip(string $phone, array $params, NotificationDelivery $delivery): void
    {
        $apiKey = env('INFOBIP_API_KEY');
        $baseUrl = rtrim(env('INFOBIP_BASE_URL', 'https://api.infobip.com'), '/');
        if (!str_starts_with($baseUrl, 'http')) {
            $baseUrl = 'https://' . $baseUrl;
        }
        $sender = env('INFOBIP_WHATSAPP_SENDER');
        $templateName = env('INFOBIP_WHATSAPP_ANNOUNCEMENT_TEMPLATE', 'announcement_notification_es');
        $templateLanguage = env('INFOBIP_WHATSAPP_TEMPLATE_LANGUAGE', 'es');

        // Format phone number
        $formattedPhone = $this->formatPhone($phone);

        // Construir payload base según el JSON de la plantilla
        // Body tiene 3 placeholders: {{1}} = nombre, {{2}} = título, {{3}} = contenido
        $templateData = [
            'body' => [
                'placeholders' => [
                    $params[0], // {{1}} - Nombre de la tienda
                    $params[1], // {{2}} - Título del anuncio (con emoji)
                    $params[2], // {{3}} - Contenido del anuncio
                ]
            ]
        ];

        // Payload for Infobip WhatsApp template
        $payload = [
            'messages' => [
                [
                    'from' => $sender,
                    'to' => $formattedPhone,
                    'content' => [
                        'templateName' => $templateName,
                        'templateData' => $templateData,
                        'language' => $templateLanguage
                    ]
                ]
            ]
        ];

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'App ' . $apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post("{$baseUrl}/whatsapp/1/message/template", $payload);

        if ($response->successful()) {
            $delivery->markAsSent();
            $delivery->markAsDelivered();
        } else {
            $errorMessage = $response->json()['requestError']['serviceException']['text'] ?? 'Unknown error';
            throw new \Exception("Infobip API error: {$errorMessage}");
        }
    }

    /**
     * Format phone number to international format
     */
    protected function formatPhone(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 0, remove it
        if (str_starts_with($phone, '0')) {
            $phone = substr($phone, 1);
        }
        
        // If doesn't start with country code, assume Colombia (57)
        if (!str_starts_with($phone, '57') && strlen($phone) == 10) {
            $phone = '57' . $phone;
        }
        
        return $phone;
    }

    /**
     * Send via Email
     */
    protected function sendEmail(
        PlatformAnnouncement $announcement,
        Store $store,
        NotificationDelivery $delivery
    ): void {
        $email = $store->owner_email ?? $store->user->email ?? null;

        if (!$email) {
            throw new \Exception('Store does not have an email address');
        }

        try {
            Mail::send('emails.announcement', [
                'announcement' => $announcement,
                'store' => $store,
            ], function ($message) use ($announcement, $email) {
                $message->to($email)
                    ->subject($announcement->title)
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            $delivery->markAsSent();
            $delivery->markAsDelivered();

            Log::info('Announcement sent via Email', [
                'announcement_id' => $announcement->id,
                'store_id' => $store->id,
                'email' => $email,
            ]);
        } catch (\Exception $e) {
            $delivery->markAsFailed($e->getMessage());
            throw $e;
        }
    }

    /**
     * Send in-app notification
     */
    protected function sendInApp(
        PlatformAnnouncement $announcement,
        Store $store,
        NotificationDelivery $delivery
    ): void {
        // In-app notifications are automatically available when announcement is active
        // Just mark as sent and delivered
        $delivery->markAsSent();
        $delivery->markAsDelivered();

        Log::info('Announcement available in-app', [
            'announcement_id' => $announcement->id,
            'store_id' => $store->id,
        ]);
    }

    /**
     * Get target stores for announcement
     */
    protected function getTargetStores(PlatformAnnouncement $announcement): \Illuminate\Database\Eloquent\Collection
    {
        $query = Store::where('status', 'active');

        // Filter by plans
        if ($announcement->target_plans && count($announcement->target_plans) > 0) {
            $query->whereHas('plan', function ($q) use ($announcement) {
                $q->whereIn('name', array_map('ucfirst', $announcement->target_plans));
            });
        }

        // Filter by specific stores
        if ($announcement->target_stores && count($announcement->target_stores) > 0) {
            $query->whereIn('id', $announcement->target_stores);
        }

        return $query->get();
    }

    /**
     * Format message for WhatsApp template
     * Returns array with template parameters for Infobip
     * 
     * @return array [nombre_tienda, titulo, contenido, url_para_boton]
     */
    protected function formatWhatsAppMessage(PlatformAnnouncement $announcement, Store $store): array
    {
        // Limitar contenido a 500 caracteres para WhatsApp
        $content = \Illuminate\Support\Str::limit($announcement->content, 500);
        
        // Agregar emoji al título según el tipo de anuncio (para que no parezca marketing)
        $titleWithEmoji = $this->addEmojiToTitle($announcement->type, $announcement->title);
        
        // Parámetros para el template de Infobip
        // Body: "Estimado cliente {{1}},\n\n{{2}}\n\n{{3}}\n\nPara más información, accede a tu panel de administración.\n\nGracias por su comprensión."
        return [
            $store->name, // {{1}} del body - Nombre de la tienda
            $titleWithEmoji, // {{2}} del body - Título del anuncio con emoji
            $content, // {{3}} del body - Contenido del anuncio
        ];
    }

    /**
     * Agregar emoji al título según el tipo de anuncio
     * Esto ayuda a que no parezca una plantilla de marketing
     */
    protected function addEmojiToTitle(string $type, string $title): string
    {
        $emoji = match($type) {
            'critical' => '⚠️', // Advertencia para críticos
            'important' => '🔧', // Herramienta para importantes
            'info' => 'ℹ️', // Información para info
            default => '' // Sin emoji por defecto para evitar que parezca marketing
        };

        // Si el título ya tiene emoji al inicio, no agregar otro
        if (preg_match('/^[\x{1F300}-\x{1F9FF}]/u', $title)) {
            return $title;
        }

        // Solo agregar emoji si no está vacío
        return $emoji ? $emoji . ' ' . $title : $title;
    }

    /**
     * Get delivery statistics for announcement
     */
    public function getDeliveryStats(PlatformAnnouncement $announcement): array
    {
        $deliveries = $announcement->deliveries;

        return [
            'total_stores' => $this->getTargetStores($announcement)->count(),
            'whatsapp' => [
                'sent' => $deliveries->where('channel', 'whatsapp')->where('status', '!=', 'pending')->count(),
                'delivered' => $deliveries->where('channel', 'whatsapp')->where('status', 'delivered')->count(),
                'read' => $deliveries->where('channel', 'whatsapp')->where('status', 'read')->count(),
                'failed' => $deliveries->where('channel', 'whatsapp')->where('status', 'failed')->count(),
            ],
            'email' => [
                'sent' => $deliveries->where('channel', 'email')->where('status', '!=', 'pending')->count(),
                'delivered' => $deliveries->where('channel', 'email')->where('status', 'delivered')->count(),
                'read' => $deliveries->where('channel', 'email')->where('status', 'read')->count(),
                'failed' => $deliveries->where('channel', 'email')->where('status', 'failed')->count(),
            ],
            'in_app' => [
                'sent' => $deliveries->where('channel', 'in_app')->where('status', '!=', 'pending')->count(),
                'read' => $deliveries->where('channel', 'in_app')->where('status', 'read')->count(),
                'failed' => $deliveries->where('channel', 'in_app')->where('status', 'failed')->count(),
            ],
        ];
    }
}

