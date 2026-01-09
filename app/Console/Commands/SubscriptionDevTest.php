<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Features\SuperLinkiu\Models\SubSubscription;
use App\Features\SuperLinkiu\Models\SubClient;
use App\Features\SuperLinkiu\Services\SubscriptionDev\SubWhatsAppService;

class SubscriptionDevTest extends Command
{
    protected $signature = 'subscriptiondev:test 
                            {--subscription= : ID de la suscripción a probar}
                            {--list : Listar suscripciones disponibles}
                            {--dry-run : Mostrar qué se enviaría sin enviar}';

    protected $description = 'Probar envío de notificación de pago de suscripción';

    public function handle()
    {
        $this->info('=== SubscriptionDev - Test de Notificación ===');
        $this->newLine();

        // Listar suscripciones
        if ($this->option('list')) {
            $this->listSubscriptions();
            return Command::SUCCESS;
        }

        // Verificar configuración
        $whatsappService = app(SubWhatsAppService::class);
        
        $this->info('📋 Verificando configuración...');
        $this->table(
            ['Parámetro', 'Valor'],
            [
                ['Servicio habilitado', $whatsappService->isEnabled() ? '✅ Sí' : '❌ No'],
                ['API Key', env('INFOBIP_API_KEY') ? '✅ Configurada' : '❌ No configurada'],
                ['WhatsApp Sender', env('INFOBIP_WHATSAPP_SENDER') ?: '❌ No configurado'],
                ['Base URL', env('INFOBIP_BASE_URL') ?: '❌ No configurado'],
            ]
        );
        $this->newLine();

        if (!$whatsappService->isEnabled()) {
            $this->error('❌ El servicio de WhatsApp no está habilitado. Verifica las variables de entorno.');
            return Command::FAILURE;
        }

        // Obtener suscripción
        $subscriptionId = $this->option('subscription');
        
        if (!$subscriptionId) {
            // Buscar la primera suscripción disponible
            $subscription = SubSubscription::with('client')->first();
            
            if (!$subscription) {
                $this->error('❌ No hay suscripciones creadas.');
                return Command::FAILURE;
            }
            
            $this->warn("ℹ️ No se especificó ID. Usando la primera suscripción encontrada.");
        } else {
            $subscription = SubSubscription::with('client')->find($subscriptionId);
            
            if (!$subscription) {
                $this->error("❌ Suscripción #{$subscriptionId} no encontrada.");
                return Command::FAILURE;
            }
        }

        // Mostrar datos de la suscripción
        $this->info('📦 Datos de la suscripción:');
        $this->table(
            ['Campo', 'Valor'],
            [
                ['ID', $subscription->id],
                ['Servicio', $subscription->service_name],
                ['Cliente', $subscription->client->name],
                ['Email', $subscription->client->email ?: 'N/A'],
                ['Teléfono', $subscription->client->phone ?: '❌ SIN TELÉFONO'],
                ['Código país', $subscription->client->country_code],
                ['Teléfono completo', $subscription->client->full_phone],
                ['Monto', $subscription->formatted_amount],
                ['Período', $subscription->period_label],
                ['Vencimiento', $subscription->next_billing_date->format('d/m/Y')],
                ['Días hasta vencer', $subscription->days_until_due],
                ['Estado', $subscription->status_label],
                ['Link de pago', $subscription->public_url],
            ]
        );
        $this->newLine();

        // Verificar teléfono
        if (empty($subscription->client->phone)) {
            $this->error('❌ El cliente no tiene teléfono configurado. No se puede enviar WhatsApp.');
            return Command::FAILURE;
        }

        // Mostrar mensaje que se enviará
        $daysUntilDue = $subscription->days_until_due;
        $urgencyText = match(true) {
            $daysUntilDue <= 0 => '⚠️ VENCIDO',
            $daysUntilDue === 1 => '⏰ Vence MAÑANA',
            $daysUntilDue <= 3 => "⏰ Vence en {$daysUntilDue} días",
            $daysUntilDue <= 7 => "📅 Vence en {$daysUntilDue} días",
            default => "📅 Vence el {$subscription->next_billing_date->format('d/m/Y')}",
        };

        $this->info('📝 Mensaje que se enviará:');
        $this->line("─────────────────────────────────────");
        $this->line("Hola {$subscription->client->name},");
        $this->line("Tu suscripción {$subscription->service_name}");
        $this->line("Estado: {$urgencyText}");
        $this->line("Período: {$subscription->period_label}");
        $this->line("");
        $this->line("💰 {$subscription->formatted_amount}");
        $this->line("🔗 Paga aquí: {$subscription->public_url}");
        $this->line("─────────────────────────────────────");
        $this->newLine();

        // Dry run
        if ($this->option('dry-run')) {
            $this->warn('🔍 [DRY-RUN] No se envió ningún mensaje.');
            return Command::SUCCESS;
        }

        // Confirmar envío
        if (!$this->confirm('¿Enviar este recordatorio de prueba?', true)) {
            $this->warn('Cancelado.');
            return Command::SUCCESS;
        }

        // Enviar
        $this->info('📤 Enviando notificación...');
        
        try {
            $result = $whatsappService->sendPaymentReminder($subscription);

            if ($result) {
                $this->newLine();
                $this->info('✅ ¡Notificación enviada correctamente!');
                $this->line("   Teléfono: {$subscription->client->full_phone}");
                $this->line("   Link enviado: {$subscription->public_url}");
            } else {
                $this->error('❌ Error al enviar la notificación.');
                $this->line('   Revisa los logs para más detalles: storage/logs/laravel.log');
            }
        } catch (\Exception $e) {
            $this->error('❌ Excepción: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }

    protected function listSubscriptions(): void
    {
        $subscriptions = SubSubscription::with('client')->get();

        if ($subscriptions->isEmpty()) {
            $this->warn('No hay suscripciones creadas.');
            return;
        }

        $rows = [];
        foreach ($subscriptions as $sub) {
            $rows[] = [
                $sub->id,
                $sub->service_name,
                $sub->client->name,
                $sub->client->phone ? '✅' : '❌',
                $sub->formatted_amount,
                $sub->next_billing_date->format('d/m/Y'),
                $sub->status_label,
            ];
        }

        $this->table(
            ['ID', 'Servicio', 'Cliente', 'Tel.', 'Monto', 'Vencimiento', 'Estado'],
            $rows
        );

        $this->newLine();
        $this->line('Usa: php artisan subscriptiondev:test --subscription=ID');
    }
}
