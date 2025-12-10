<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppNotificationService;

class ListWhatsAppTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:list-templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listar todas las plantillas de WhatsApp disponibles en SendPulse';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Obteniendo plantillas de SendPulse...');
        
        $whatsappService = app(WhatsAppNotificationService::class);
        
        if (!$whatsappService->isEnabled()) {
            $this->error('❌ El servicio de WhatsApp no está habilitado. Verifica las variables de entorno.');
            return 1;
        }
        
        $templates = $whatsappService->listTemplates();
        
        if (empty($templates)) {
            $this->warn('⚠️  No se encontraron plantillas o hubo un error al obtenerlas.');
            $this->info('Revisa los logs para más detalles.');
            return 1;
        }
        
        $this->info("✅ Se encontraron " . count($templates) . " plantillas:");
        $this->newLine();
        
        // Mostrar respuesta completa para debug
        $this->line('📋 Respuesta completa de SendPulse:');
        $this->line(json_encode($templates, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->newLine();
        
        // Intentar mostrar en tabla si tiene la estructura esperada
        if (is_array($templates) && !empty($templates)) {
            $tableData = [];
            foreach ($templates as $template) {
                if (is_array($template)) {
                    $tableData[] = [
                        'Nombre' => $template['name'] ?? ($template['template_name'] ?? 'N/A'),
                        'Idioma' => is_array($template['language'] ?? null) ? ($template['language']['code'] ?? 'N/A') : ($template['language'] ?? 'N/A'),
                        'Estado' => $template['status'] ?? ($template['state'] ?? 'N/A'),
                        'Categoría' => $template['category'] ?? 'N/A',
                    ];
                } else {
                    $tableData[] = [
                        'Nombre' => 'Formato desconocido',
                        'Idioma' => 'N/A',
                        'Estado' => 'N/A',
                        'Categoría' => 'N/A',
                    ];
                }
            }
            
            if (!empty($tableData)) {
                $this->table(
                    ['Nombre', 'Idioma', 'Estado', 'Categoría'],
                    $tableData
                );
            }
        }
        
        $this->newLine();
        $this->info('💡 Busca la plantilla "account_update_es" en la lista. Si no aparece, necesitas crearla en SendPulse.');
        
        return 0;
    }
}
