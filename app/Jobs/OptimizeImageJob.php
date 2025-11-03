<?php

namespace App\Jobs;

use App\Shared\Services\ImageOptimizationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OptimizeImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Número de intentos máximos
     */
    public $tries = 3;

    /**
     * Timeout del job (60 segundos)
     */
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $imagePath,
        public string $context = 'general', // 'product', 'slider', 'logo', 'category', 'icon'
        public ?int $maxWidth = null,
        public ?int $maxHeight = null, // Altura máxima para crop desde centro
        public ?string $modelType = null, // 'ProductImage', 'Slider', 'CategoryIcon', etc.
        public ?int $modelId = null // ID del modelo a actualizar
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ImageOptimizationService $optimizationService): void
    {
        try {
            // Verificar que el archivo existe
            if (!Storage::disk('public')->exists($this->imagePath)) {
                Log::warning('Imagen no encontrada para optimizar', [
                    'path' => $this->imagePath,
                    'context' => $this->context
                ]);
                return;
            }

            // Crear backup del original (temporal, 24 horas)
            $backupPath = $this->createBackup($this->imagePath);

            // Leer imagen original
            $originalContent = Storage::disk('public')->get($this->imagePath);
            
            // Crear archivo temporal para procesar
            $tempFile = tempnam(sys_get_temp_dir(), 'opt_img_');
            file_put_contents($tempFile, $originalContent);

            // Crear UploadedFile simulada para el servicio
            $uploadedFile = new \Illuminate\Http\UploadedFile(
                $tempFile,
                basename($this->imagePath),
                Storage::disk('public')->mimeType($this->imagePath),
                null,
                true // test mode
            );

            // Opciones de optimización
            $options = [];
            if ($this->maxWidth !== null) {
                $options['max_width'] = $this->maxWidth;
            }
            if ($this->maxHeight !== null) {
                $options['max_height'] = $this->maxHeight;
            }

            // Optimizar imagen
            $optimizedContent = $optimizationService->optimize($uploadedFile, null, $options);

            if ($optimizedContent === false) {
                Log::error('Error al optimizar imagen, manteniendo original', [
                    'path' => $this->imagePath,
                    'context' => $this->context
                ]);
                
                // Limpiar backup si falla
                if ($backupPath && Storage::disk('public')->exists($backupPath)) {
                    Storage::disk('public')->delete($backupPath);
                }
                return;
            }

            // Generar nuevo nombre (WebP)
            $pathInfo = pathinfo($this->imagePath);
            $newPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';

            // Guardar imagen optimizada
            Storage::disk('public')->put($newPath, $optimizedContent);

            // Verificar integridad de la nueva imagen
            if (!$this->validateImage($optimizedContent)) {
                Log::error('Imagen optimizada corrupta, restaurando backup', [
                    'path' => $this->imagePath,
                    'new_path' => $newPath
                ]);
                
                $this->restoreFromBackup($backupPath, $this->imagePath);
                Storage::disk('public')->delete($newPath);
                return;
            }

            // Si el path original es diferente al nuevo, eliminar el original
            if ($this->imagePath !== $newPath && Storage::disk('public')->exists($this->imagePath)) {
                Storage::disk('public')->delete($this->imagePath);
            }

            // Actualizar registro en BD si es necesario (depende del contexto)
            $this->updateDatabaseRecord($this->imagePath, $newPath);

            // Log de éxito
            $info = $optimizationService->getOptimizationInfo(
                $backupPath ?? $this->imagePath,
                $newPath
            );

            Log::info('Imagen optimizada exitosamente', [
                'original_path' => $this->imagePath,
                'optimized_path' => $newPath,
                'context' => $this->context,
                'reduction_percent' => $info['reduction_percent'],
                'reduction_bytes' => $info['reduction_bytes']
            ]);

            // Limpiar archivo temporal
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }

            // Programar eliminación de backup (24 horas después)
            \Illuminate\Support\Facades\Queue::later(
                now()->addHours(24),
                new \App\Jobs\DeleteImageBackupJob($backupPath)
            );

        } catch (\Exception $e) {
            Log::error('Error en OptimizeImageJob', [
                'path' => $this->imagePath,
                'context' => $this->context,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // En caso de error, restaurar backup si existe
            if (isset($backupPath) && Storage::disk('public')->exists($backupPath)) {
                $this->restoreFromBackup($backupPath, $this->imagePath);
            }

            throw $e; // Re-throw para que el job falle y se reintente
        }
    }

    /**
     * Crear backup del archivo original
     */
    protected function createBackup(string $imagePath): string
    {
        $backupPath = 'backups/' . dirname($imagePath) . '/backup_' . time() . '_' . basename($imagePath);
        Storage::disk('public')->copy($imagePath, $backupPath);
        return $backupPath;
    }

    /**
     * Restaurar desde backup
     */
    protected function restoreFromBackup(string $backupPath, string $originalPath): void
    {
        if (Storage::disk('public')->exists($backupPath)) {
            Storage::disk('public')->copy($backupPath, $originalPath);
            Log::info('Imagen restaurada desde backup', [
                'backup' => $backupPath,
                'restored' => $originalPath
            ]);
        }
    }

    /**
     * Validar que la imagen optimizada sea válida
     */
    protected function validateImage(string $imageContent): bool
    {
        // Intentar leer la imagen con GD
        $imageInfo = @getimagesizefromstring($imageContent);
        return $imageInfo !== false && $imageInfo[0] > 0 && $imageInfo[1] > 0;
    }

    /**
     * Actualizar registro en base de datos según el contexto
     */
    protected function updateDatabaseRecord(string $oldPath, string $newPath): void
    {
        if (!$this->modelType || !$this->modelId) {
            return;
        }

        try {
            switch ($this->modelType) {
                case 'ProductImage':
                    $model = \App\Features\TenantAdmin\Models\ProductImage::find($this->modelId);
                    if ($model && $model->image_path === $oldPath) {
                        $model->update(['image_path' => $newPath]);
                        Log::info('ProductImage actualizado con nuevo path', [
                            'id' => $this->modelId,
                            'new_path' => $newPath
                        ]);
                    }
                    break;
                
                case 'Slider':
                    $model = \App\Features\TenantAdmin\Models\Slider::find($this->modelId);
                    if ($model && $model->image_path === $oldPath) {
                        $model->update(['image_path' => $newPath]);
                        Log::info('Slider actualizado con nuevo path', [
                            'id' => $this->modelId,
                            'new_path' => $newPath
                        ]);
                    }
                    break;
                
                case 'CategoryIcon':
                    $model = \App\Shared\Models\CategoryIcon::find($this->modelId);
                    if ($model && $model->image_path === $oldPath) {
                        $model->update(['image_path' => $newPath]);
                        Log::info('CategoryIcon actualizado con nuevo path', [
                            'id' => $this->modelId,
                            'new_path' => $newPath
                        ]);
                    }
                    break;
                
                case 'StoreDesign':
                    // StoreDesign tiene logo_url y favicon_url, necesitamos más contexto
                    // Por ahora solo logueamos
                    Log::info('StoreDesign debe actualizarse manualmente', [
                        'old_path' => $oldPath,
                        'new_path' => $newPath
                    ]);
                    break;
            }
        } catch (\Exception $e) {
            Log::error('Error actualizando registro en BD', [
                'model_type' => $this->modelType,
                'model_id' => $this->modelId,
                'error' => $e->getMessage()
            ]);
        }
    }
}

