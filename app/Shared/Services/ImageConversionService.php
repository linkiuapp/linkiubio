<?php

namespace App\Shared\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageConversionService
{
    /**
     * Convertir WebP a JPG para compatibilidad con PDFs y visores antiguos
     */
    public function convertWebPToJpg(string $webpPath, ?string $outputPath = null): ?string
    {
        try {
            // Verificar que el archivo existe
            if (!Storage::disk('public')->exists($webpPath)) {
                Log::warning('Archivo WebP no encontrado para conversión', ['path' => $webpPath]);
                return null;
            }

            // Verificar que es WebP
            $extension = strtolower(pathinfo($webpPath, PATHINFO_EXTENSION));
            if ($extension !== 'webp') {
                // No es WebP, devolver el original
                return $webpPath;
            }

            // Generar path de salida si no se especifica
            if ($outputPath === null) {
                $pathInfo = pathinfo($webpPath);
                $outputPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.jpg';
            }

            // Leer imagen WebP
            $imageManager = new ImageManager(new Driver());
            $imageContent = Storage::disk('public')->get($webpPath);
            $image = $imageManager->read($imageContent);

            // Convertir a JPG con calidad 90%
            $jpgContent = $image->toJpeg(90);

            // Guardar JPG
            Storage::disk('public')->put($outputPath, $jpgContent);

            Log::info('WebP convertido a JPG para compatibilidad', [
                'webp_path' => $webpPath,
                'jpg_path' => $outputPath
            ]);

            return $outputPath;

        } catch (\Exception $e) {
            Log::error('Error convirtiendo WebP a JPG', [
                'path' => $webpPath,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Obtener URL de imagen compatible (JPG si es WebP, original si no)
     * Para usar en PDFs y comprobantes
     */
    public function getCompatibleImageUrl(string $imagePath): string
    {
        $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        
        // Si es WebP, convertir a JPG temporalmente
        if ($extension === 'webp') {
            $jpgPath = $this->convertWebPToJpg($imagePath);
            if ($jpgPath) {
                return Storage::disk('public')->url($jpgPath);
            }
        }

        // Si no es WebP o falló la conversión, devolver original
        return Storage::disk('public')->url($imagePath);
    }

    /**
     * Obtener path absoluto de imagen compatible para PDFs
     */
    public function getCompatibleImagePath(string $imagePath): ?string
    {
        $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        
        // Si es WebP, convertir a JPG
        if ($extension === 'webp') {
            $jpgPath = $this->convertWebPToJpg($imagePath);
            if ($jpgPath) {
                // Obtener path absoluto para PDF
                $fullPath = storage_path('app/public/' . $jpgPath);
                if (file_exists($fullPath)) {
                    return $fullPath;
                }
            }
        }

        // Si no es WebP o falló, devolver path original
        $fullPath = storage_path('app/public/' . $imagePath);
        if (file_exists($fullPath)) {
            return $fullPath;
        }

        return null;
    }
}

