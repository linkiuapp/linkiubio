<?php

namespace App\Features\TenantAdmin\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreDesignImageService
{


    /**
     * Procesa y guarda el logo de la tienda
     *
     * @param UploadedFile $file
     * @param int $storeId
     * @return array{logo_url: string, logo_webp_url: string}
     */
    public function handleLogo(UploadedFile $file, int $storeId): array
    {
        // Generar nombre único para el archivo
        $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        $relativePath = 'store-design/' . $storeId;
        
        // ✅ Guardar con Storage::disk('public')->putFileAs() - Compatible con S3 y local
        $savedPath = Storage::disk('public')->putFileAs($relativePath, $file, $filename);
        
        // ✅ Retornar PATH RELATIVO (el accessor del modelo lo convertirá a URL)
        return [
            'logo_url' => $savedPath,
            'logo_webp_url' => null // Por ahora no generamos WebP
        ];
    }

    /**
     * Procesa y guarda el favicon de la tienda
     *
     * @param UploadedFile $file
     * @param int $storeId
     * @return array{favicon_url: string}
     */
    public function handleFavicon(UploadedFile $file, int $storeId): array
    {
        // Generar nombre único para el archivo
        $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
        $relativePath = 'store-design/' . $storeId;
        
        // ✅ Guardar con Storage::disk('public')->putFileAs() - Compatible con S3 y local
        $savedPath = Storage::disk('public')->putFileAs($relativePath, $file, $filename);
        
        // ✅ Retornar PATH RELATIVO (el accessor del modelo lo convertirá a URL)
        return [
            'favicon_url' => $savedPath
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