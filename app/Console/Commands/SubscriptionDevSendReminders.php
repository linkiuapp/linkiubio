<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Features\SuperLinkiu\Models\SubSubscription;
use App\Features\SuperLinkiu\Services\SubscriptionDev\SubWhatsAppService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SubscriptionDevSendReminders extends Command
{
    protected $signature = 'subscriptiondev:send-reminders 
                            {--force : Forzar envío sin verificar si ya se envió}
                            {--dry-run : Solo mostrar qué se enviaría sin enviar}';

    protected $description = 'Envía recordatorios de pago por WhatsApp para suscripciones próximas a vencer';

    // Recordatorios según período
    protected $remindersByPeriod = [
        'monthly' => [7, 5, 1],
        'quarterly' => [15, 7, 3, 1],
        'semiannual' => [30, 15, 7, 1],
        'annual' => [30, 15, 7, 1],
    ];

    public function handle()
    {
        $this->info('=== SubscriptionDev: Envío de Recordatorios ===');
        $this->newLine();

        $whatsappService = app(SubWhatsAppService::class);
        
        if (!$whatsappService->isEnabled()) {
            $this->error('El servicio de WhatsApp no está habilitado.');
            return Command::FAILURE;
        }

        $sentCount = 0;
        $errorCount = 0;
        $skippedCount = 0;

        // Obtener suscripciones activas con recordatorios automáticos
        $subscriptions = SubSubscription::with('client')
            ->active()
            ->autoRemind()
            ->where('next_billing_date', '>=', today())
            ->where('next_billing_date', '<=', today()->addDays(30))
            ->get();

        $this->info("Encontradas {$subscriptions->count()} suscripciones próximas a vencer.");
        $this->newLine();

        foreach ($subscriptions as $subscription) {
            $daysUntilDue = $subscription->days_until_due;
            $reminderDays = $this->remindersByPeriod[$subscription->billing_period] ?? [7, 1];

            // Verificar si hoy corresponde enviar recordatorio
            if (!in_array($daysUntilDue, $reminderDays)) {
                continue;
            }

            // Verificar si ya se envió este recordatorio
            if (!$this->option('force') && !$subscription->shouldSendReminder($daysUntilDue)) {
                $this->line("  ⏭️ [{$subscription->service_name}] Recordatorio de {$daysUntilDue}d ya enviado");
                $skippedCount++;
                continue;
            }

            $this->line("📬 Procesando: {$subscription->service_name} ({$subscription->client->name})");
            $this->line("   Vence: {$subscription->next_billing_date->format('d/m/Y')} (en {$daysUntilDue} días)");

            if ($this->option('dry-run')) {
                $this->info("   [DRY-RUN] Se enviaría recordatorio de {$daysUntilDue} días");
                continue;
            }

            try {
                $result = $whatsappService->sendPaymentReminder($subscription, $daysUntilDue);

                if ($result) {
                    $sentCount++;
                    $this->info("   ✅ Recordatorio enviado");
                } else {
                    $errorCount++;
                    $this->error("   ❌ Error al enviar");
                }
            } catch (\Exception $e) {
                $errorCount++;
                $this->error("   ❌ Error: " . $e->getMessage());
                Log::error('SubscriptionDev: Error enviando recordatorio', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // También procesar suscripciones vencidas
        $this->newLine();
        $this->info('Procesando suscripciones vencidas...');

        $overdueSubscriptions = SubSubscription::with('client')
            ->whereIn('status', ['active', 'pending_payment'])
            ->autoRemind()
            ->where('next_billing_date', '<', today())
            ->where('next_billing_date', '>=', today()->subDays(7)) // Solo últimos 7 días
            ->get();

        foreach ($overdueSubscriptions as $subscription) {
            // Verificar si ya se envió recordatorio de vencido hoy
            $sentToday = $subscription->reminders()
                ->where('type', 'overdue')
                ->whereDate('created_at', today())
                ->exists();

            if ($sentToday && !$this->option('force')) {
                $skippedCount++;
                continue;
            }

            $this->line("⚠️ Vencida: {$subscription->service_name} ({$subscription->client->name})");

            if ($this->option('dry-run')) {
                $this->info("   [DRY-RUN] Se enviaría recordatorio de vencido");
                continue;
            }

            try {
                $result = $whatsappService->sendPaymentReminder($subscription, 0);

                if ($result) {
                    $sentCount++;
                    $this->info("   ✅ Recordatorio de vencido enviado");
                    
                    // Marcar como pending_payment si estaba active
                    if ($subscription->status === 'active') {
                        $subscription->markAsPendingPayment();
                    }
                } else {
                    $errorCount++;
                    $this->error("   ❌ Error al enviar");
                }
            } catch (\Exception $e) {
                $errorCount++;
                $this->error("   ❌ Error: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info("=== Resumen ===");
        $this->line("✅ Enviados: {$sentCount}");
        $this->line("❌ Errores: {$errorCount}");
        $this->line("⏭️ Omitidos: {$skippedCount}");

        if ($sentCount > 0) {
            Log::info('SubscriptionDev: Recordatorios enviados', [
                'sent' => $sentCount,
                'errors' => $errorCount,
                'skipped' => $skippedCount
            ]);
        }

        return Command::SUCCESS;
    }
}
