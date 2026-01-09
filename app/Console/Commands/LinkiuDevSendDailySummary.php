<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Features\SuperLinkiu\Models\DevNotificationSetting;
use App\Features\SuperLinkiu\Services\LinkiuDev\DevWhatsAppService;
use Illuminate\Support\Facades\Log;

class LinkiuDevSendDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linkiudev:send-daily-summary {--force : Forzar envío aunque no sea la hora configurada}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía el resumen diario de agenda por WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = DevNotificationSetting::getInstance();

        if (!$settings->isDailySummaryConfigured()) {
            $this->warn('El resumen diario no está configurado o habilitado.');
            return Command::SUCCESS;
        }

        // Verificar si es la hora correcta (con margen de 5 minutos)
        if (!$this->option('force')) {
            $scheduledTime = \Carbon\Carbon::parse($settings->daily_summary_time);
            $now = now();
            
            $diffMinutes = abs($now->diffInMinutes($scheduledTime->setDateFrom($now)));
            
            if ($diffMinutes > 5) {
                $this->info("No es hora del resumen. Configurado para: {$settings->daily_summary_time}");
                return Command::SUCCESS;
            }
        }

        $this->info('Enviando resumen diario...');

        try {
            $whatsappService = app(DevWhatsAppService::class);
            $result = $whatsappService->sendDailySummary();

            if ($result) {
                $this->info('✅ Resumen diario enviado correctamente.');
                Log::info('LinkiuDev: Resumen diario enviado', [
                    'phone' => $settings->full_whatsapp_number
                ]);
            } else {
                $this->error('❌ Error al enviar el resumen diario.');
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            Log::error('LinkiuDev: Error enviando resumen diario', [
                'error' => $e->getMessage()
            ]);
            return Command::FAILURE;
        }
    }
}
