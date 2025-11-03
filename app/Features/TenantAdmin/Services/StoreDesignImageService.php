<?php

namespace App\Features\TenantAdmin\Services;

use App\Shared\Services\ImageOptimizationService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreDesignImageService
{


    /**
     * Procesa y guarda el logo de la tienda con optimización
     *
     * @param UploadedFile $file
     * @param int $storeId
     * @return array{logo_url: string, logo_webp_url: string}
     */
    public function handleLogo(UploadedFile $file, int $storeId): array
    {
        $optimizationService = app(ImageOptimizationService::class);
        
        // Validar imagen
        if (!$optimizationService->isValidImage($file)) {
            throw new \Exception('Archivo no es una imagen válida');
        }

        // Generar nombre WebP
        $filename = 'logo_' . time() . '.webp';
        $relativePath = 'store-design/' . $storeId . '/' . $filename;
        
        // Optimizar imagen
        $optimizedContent = $optimizationService->optimize($file, null, [
            'max_width' => 500, // Logos no necesitan ser muy grandes
            'quality' => 85
        ]);

        // Si falla optimización, guardar original como fallback
        if ($optimizedContent === false) {
            \Log::warning('Optimización de logo falló, guardando original');
            $originalFilename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $relativePath = 'store-design/' . $storeId;
            $savedPath = Storage::disk('public')->putFileAs($relativePath, $file, $originalFilename);
            
            return [
                'logo_url' => $savedPath,
                'logo_webp_url' => null
            ];
        }

        // Guardar imagen optimizada (WebP)
        Storage::disk('public')->put($relativePath, $optimizedContent);
        
        return [
            'logo_url' => $relativePath,
            'logo_webp_url' => $relativePath // WebP es el formato final
        ];
    }

    /**
     * Procesa y guarda el favicon de la tienda con optimización
     *
     * @param UploadedFile $file
     * @param int $storeId
     * @return array{favicon_url: string}
     */
    public function handleFavicon(UploadedFile $file, int $storeId): array
    {
        $optimizationService = app(ImageOptimizationService::class);
        
        // Validar imagen
        if (!$optimizationService->isValidImage($file)) {
            throw new \Exception('Archivo no es una imagen válida');
        }

        // Favicons pequeños, mantener tamaño original pero optimizar
        $filename = 'favicon_' . time() . '.webp';
        $relativePath = 'store-design/' . $storeId . '/' . $filename;
        
        // Optimizar (favicons son pequeños, no necesitan redimensionar mucho)
        $optimizedContent = $optimizationService->optimize($file, null, [
            'max_width' => 512, // Favicon máximo típico
            'quality' => 90 // Mayor calidad para favicons pequeños
        ]);

        // Si falla, guardar original
        if ($optimizedContent === false) {
            \Log::warning('Optimización de favicon falló, guardando original');
            $originalFilename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $relativePath = 'store-design/' . $storeId;
            $savedPath = Storage::disk('public')->putFileAs($relativePath, $file, $originalFilename);
            
            return [
                'favicon_url' => $savedPath
            ];
        }

        // Guardar optimizado
        Storage::disk('public')->put($relativePath, $optimizedContent);
        
        return [
            'favicon_url' => $relativePath
        ];
    }

    /**
     * Elimina imágenes antiguas de una tienda
     *
     * @param int $storeId
     * @param string $prefix Logo o favicon
     * @return void
     */
    public function cleanOldImages(int $storeId, string $prefix): void
    {
        try {
            $directory = 'store-design/' . $storeId;

            // ✅ Obtener archivos usando método estándar
            $directoryPath = public_path('storage/' . $directory);
            if (is_dir($directoryPath)) {
                $files = glob($directoryPath . '/' . $prefix . '_*');
                
                foreach ($files as $filePath) {
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Error cleaning old images from S3:', [
                'store_id' => $storeId,
                'prefix' => $prefix,
                'error' => $e->getMessage()
            ]);
        }
    }
} 