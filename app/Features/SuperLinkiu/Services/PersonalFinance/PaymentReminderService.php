<?php

namespace App\Features\SuperLinkiu\Services\PersonalFinance;

use App\Features\SuperLinkiu\Models\PersonalFinance\Installment;
use App\Features\SuperLinkiu\Models\PersonalFinance\Reminder;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentReminderService
{
    protected $apiKey;
    protected $baseUrl;
    protected $whatsappSender;
    protected $templateName;

    public function __construct()
    {
        $this->apiKey = env('INFOBIP_API_KEY');
        $baseUrl = env('INFOBIP_BASE_URL');
        
        if ($baseUrl) {
            $baseUrl = rtrim($baseUrl, '/');
            if (!str_starts_with($baseUrl, 'http')) {
                $baseUrl = 'https://' . $baseUrl;
            }
        }
        
        $this->baseUrl = $baseUrl ?: 'https://api.infobip.com';
        $this->whatsappSender = env('INFOBIP_WHATSAPP_SENDER');
        $this->templateName = env('INFOBIP_WHATSAPP_PAYMENT_REMINDER_TEMPLATE', 'auto_pay_reminder_es');
    }

    /**
     * Verificar si el servicio está habilitado
     */
    public function isEnabled(): bool
    {
        return !empty($this->apiKey) && !empty($this->whatsappSender);
    }

    /**
     * Enviar recordatorio de pago próximo
     */
    public function sendReminder(Installment $installment, User $user, int $daysBefore, ?array $phoneNumbers = null): bool
    {
        if (!$this->isEnabled()) {
            Log::warning('Payment Reminder: Servicio WhatsApp no habilitado');
            return false;
        }

        // Usar números de teléfono del recordatorio si están configurados, sino usar el del usuario
        $phones = $phoneNumbers ?? [];
        if (empty($phones)) {
            $userPhone = $user->phone ?? null;
            if ($userPhone) {
                $phones = [$userPhone];
            }
        }

        if (empty($phones)) {
            Log::warning('Payment Reminder: No hay números de teléfono configurados', ['user_id' => $user->id]);
            return false;
        }

        $success = false;
        foreach ($phones as $phone) {
            if ($this->sendReminderToPhone($installment, $user, $daysBefore, $phone)) {
                $success = true;
            }
        }

        return $success;
    }

    /**
     * Enviar recordatorio a un número de teléfono específico
     */
    protected function sendReminderToPhone(Installment $installment, User $user, int $daysBefore, string $phone): bool
    {

        try {
            $formattedPhone = $this->formatPhone($phone);
            
            // Preparar datos del mensaje
            $debtName = $installment->debt->name;
            $amount = number_format($installment->amount, 0, ',', '.');
            
            // Formatear fecha en español: "3 de enero del 2026"
            $months = [
                1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
                5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
                9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
            ];
            $dueDate = $installment->due_date->format('d') . ' de ' . $months[$installment->due_date->month] . ' del ' . $installment->due_date->format('Y');
            
            $accountName = $installment->debt->account ? $installment->debt->account->name : 'Cuenta principal';

            // Placeholders para la plantilla auto_pay_reminder_es
            // {{1}} = Tipo/Nombre del pago (ej: "Mensual")
            // {{2}} = Monto (ej: "20.000")
            // {{3}} = Fecha programada (ej: "3 de enero del 2026")
            // {{4}} = Cuenta (ej: "Laravel cloud")
            $placeholders = [
                $debtName, // {{1}} - Nombre de la deuda
                $amount, // {{2}} - Monto sin símbolo de moneda (el template ya lo incluye)
                $dueDate, // {{3}} - Fecha formateada
                $accountName, // {{4}} - Nombre de la cuenta
            ];

            // Estructura estándar para templates de texto
            // Si el template es MEDIA_TEMPLATE y falla, el problema está en la configuración del template en Infobip
            $payload = [
                'messages' => [
                    [
                        'from' => $this->whatsappSender,
                        'to' => $formattedPhone,
                        'content' => [
                            'templateName' => $this->templateName,
                            'templateData' => [
                                'body' => [
                                    'placeholders' => $placeholders
                                ]
                            ],
                            'language' => 'es'
                        ]
                    ]
                ]
            ];

            Log::info('Payment Reminder: Enviando recordatorio', [
                'to' => $formattedPhone,
                'installment_id' => $installment->id,
                'debt_name' => $debtName,
                'days_before' => $daysBefore,
            ]);

            $response = Http::timeout(30)
                ->withOptions([
                    'curl' => [
                        CURLOPT_PROXY => '',
                        CURLOPT_PROXYUSERPWD => '',
                    ],
                ])
                ->withHeaders([
                    'Authorization' => 'App ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->post("{$this->baseUrl}/whatsapp/1/message/template", $payload);

            if ($response->successful()) {
                $responseData = $response->json();
                $messageId = $responseData['messages'][0]['messageId'] ?? null;

                Log::info('Payment Reminder: Recordatorio enviado exitosamente', [
                    'message_id' => $messageId,
                    'installment_id' => $installment->id,
                ]);

                // Actualizar último envío en el recordatorio
                $reminder = Reminder::where('user_id', $user->id)
                    ->where(function($query) use ($installment) {
                        $query->where('debt_id', $installment->debt_id)
                              ->orWhereNull('debt_id'); // Recordatorios globales
                    })
                    ->where('reminder_days_before', $daysBefore)
                    ->where('is_active', true)
                    ->first();

                if ($reminder) {
                    $reminder->update(['last_sent_at' => now()]);
                }

                return true;
            } else {
                $error = $response->json();
                Log::error('Payment Reminder: Error enviando recordatorio', [
                    'status' => $response->status(),
                    'error' => $error,
                    'installment_id' => $installment->id,
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Payment Reminder: Excepción enviando recordatorio', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'installment_id' => $installment->id,
            ]);
            return false;
        }
    }

    /**
     * Procesar recordatorios automáticos
     * Ejecutar este método desde un comando programado (cron)
     */
    public function processReminders(): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        // Obtener todos los recordatorios activos
        $reminders = Reminder::with(['user', 'debt.installments'])
            ->where('is_active', true)
            ->get();

        foreach ($reminders as $reminder) {
            $this->processReminder($reminder);
        }
    }

    /**
     * Procesar un recordatorio específico
     */
    protected function processReminder(Reminder $reminder): void
    {
        $daysBefore = $reminder->reminder_days_before;
        $targetDate = now()->addDays($daysBefore)->format('Y-m-d');

        // Si es recordatorio global (sin deuda específica)
        if (!$reminder->debt_id) {
            $installments = Installment::with('debt')
                ->whereHas('debt', function($query) use ($reminder) {
                    $query->where('user_id', $reminder->user_id)
                          ->where('status', 'active');
                })
                ->where('status', 'pending')
                ->whereDate('due_date', $targetDate)
                ->get();
        } else {
            // Recordatorio para una deuda específica
            $installments = Installment::where('debt_id', $reminder->debt_id)
                ->where('status', 'pending')
                ->whereDate('due_date', $targetDate)
                ->get();
        }

        foreach ($installments as $installment) {
            // Verificar que no se haya enviado recientemente (evitar spam)
            $lastSent = $reminder->last_sent_at;
            if ($lastSent && $lastSent->isToday()) {
                continue;
            }

            // Usar números de teléfono del recordatorio si están configurados
            $phoneNumbers = $reminder->phone_numbers ?? null;
            $this->sendReminder($installment, $reminder->user, $daysBefore, $phoneNumbers);
        }
    }

    /**
     * Formatear número de teléfono para Infobip
     */
    protected function formatPhone(string $phone): string
    {
        // Remover espacios, guiones, paréntesis
        $phone = preg_replace('/[\s\-\(\)]/', '', $phone);
        
        // Si no empieza con +, agregar código de país Colombia (57)
        if (!str_starts_with($phone, '+')) {
            if (str_starts_with($phone, '57')) {
                $phone = '+' . $phone;
            } else {
                $phone = '+57' . $phone;
            }
        }
        
        return $phone;
    }
}
