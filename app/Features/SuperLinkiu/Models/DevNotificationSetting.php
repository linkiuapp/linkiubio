<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;

class DevNotificationSetting extends Model
{
    protected $table = 'dev_notification_settings';

    protected $fillable = [
        'whatsapp_number',
        'country_code',
        'daily_summary_enabled',
        'daily_summary_time',
        'task_reminders_enabled',
        'default_reminder_minutes',
        'client_notifications_enabled',
    ];

    protected $casts = [
        'daily_summary_enabled' => 'boolean',
        'task_reminders_enabled' => 'boolean',
        'client_notifications_enabled' => 'boolean',
        'default_reminder_minutes' => 'integer',
    ];

    /**
     * Obtener la instancia de configuración (singleton pattern)
     */
    public static function getInstance(): self
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([
                'whatsapp_number' => env('LINKIUDEV_ADMIN_WHATSAPP', ''),
                'country_code' => '+57',
                'daily_summary_enabled' => true,
                'daily_summary_time' => '07:00:00',
                'task_reminders_enabled' => true,
                'default_reminder_minutes' => 30,
                'client_notifications_enabled' => true,
            ]);
        }
        
        return $settings;
    }

    /**
     * Obtener número completo con código de país
     */
    public function getFullWhatsappNumberAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->whatsapp_number);
        $countryCode = preg_replace('/[^0-9]/', '', $this->country_code);
        
        if (str_starts_with($phone, $countryCode)) {
            return $phone;
        }
        
        return $countryCode . $phone;
    }

    /**
     * Verificar si el resumen diario está configurado
     */
    public function isDailySummaryConfigured(): bool
    {
        return $this->daily_summary_enabled && !empty($this->whatsapp_number);
    }

    /**
     * Verificar si los recordatorios están configurados
     */
    public function areRemindersConfigured(): bool
    {
        return $this->task_reminders_enabled && !empty($this->whatsapp_number);
    }

    /**
     * Verificar si las notificaciones a clientes están habilitadas
     */
    public function areClientNotificationsEnabled(): bool
    {
        return $this->client_notifications_enabled;
    }
}
