<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PaymentProofTemplate;
use Aws\Rekognition\RekognitionClient;

class CachePaymentProofTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment-proof:cache-templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cachea los labels de las plantillas de comprobantes para optimizar AWS';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando caché de plantillas...');
        
        $templatesPath = storage_path('app/payment-proof-templates');
        
        if (!is_dir($templatesPath)) {
            $this->error('No se encontró el directorio de plantillas: ' . $templatesPath);
            return 1;
        }
        
        $templates = glob($templatesPath . '/*.{jpg,jpeg,png}', GLOB_BRACE);
        
        if (empty($templates)) {
            $this->error('No se encontraron plantillas en el directorio.');
            return 1;
        }
        
        $this->info('Encontradas ' . count($templates) . ' plantillas.');
        
        // Configurar AWS Rekognition
        $rekognition = new RekognitionClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
        
        $cached = 0;
        $skipped = 0;
        $updated = 0;
        
        foreach ($templates as $templatePath) {
            $filename = basename($templatePath);
            $fileContent = file_get_contents($templatePath);
            $fileHash = md5($fileContent);
            
            // Extraer banco del nombre del archivo
            // Ejemplo: plantilla_comprobante_nequi_01.jpg -> nequi
            preg_match('/plantilla_comprobante_([a-z]+)_\d+/', $filename, $matches);
            $bank = $matches[1] ?? 'otro';
            
            // Verificar si necesita actualización
            if (!PaymentProofTemplate::needsUpdate($filename, $fileHash)) {
                $this->line("⏭️  Omitiendo {$filename} (ya está cacheada)");
                $skipped++;
                continue;
            }
            
            $this->info("Procesando {$filename} ({$bank})...");
            
            try {
                // Obtener labels de AWS Rekognition
                $result = $rekognition->detectLabels([
                    'Image' => ['Bytes' => $fileContent],
                    'MaxLabels' => 10,
                    'MinConfidence' => 70,
                ]);
                
                $labels = $result->get('Labels');
                
                // Guardar o actualizar en BD
                PaymentProofTemplate::updateOrCreate(
                    ['filename' => $filename],
                    [
                        'bank' => $bank,
                        'labels' => $labels,
                        'file_hash' => $fileHash,
                    ]
                );
                
                $this->info("Cacheada: {$filename} ({$bank}) - " . count($labels) . " labels");
                
                if (PaymentProofTemplate::where('filename', $filename)->where('file_hash', '!=', $fileHash)->exists()) {
                    $updated++;
                } else {
                    $cached++;
                }
                
            } catch (\Exception $e) {
                $this->error("Error procesando {$filename}: " . $e->getMessage());
            }
        }
        
        $this->newLine();
        $this->info("Completado:");
        $this->line("- Nuevas cacheadas: {$cached}");
        $this->line("- Actualizadas: {$updated}");
        $this->line("- Omitidas: {$skipped}");
        
        return 0;
    }
}
