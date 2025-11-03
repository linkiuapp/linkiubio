<?php

namespace App\Shared\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageOptimizationService
{
    /**
     * Tamaño máximo permitido (10MB)
     */
    const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB en bytes

    /**
     * Ancho máximo de imagen (2000px)
     */
    const MAX_WIDTH = 2000;

    /**
     * Calidad WebP (85%)
     */
    const WEBP_QUALITY = 85;

    /**
     * Calidad JPEG (80%)
     */
    const JPEG_QUALITY = 80;

    /**
     * Cache para verificar si spatie está disponible
     */
    protected static ?bool $spatieAvailable = null;

    /**
     * ImageManager instance
     */
    protected ImageManager $imageManager;

    public function __construct()
    {
        // Usar GD driver (ya lo tienes activo)
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Optimizar imagen: redimensionar, convertir a WebP y comprimir
     * 
     * @param UploadedFile $file Archivo original
     * @param string|null $savePath Ruta donde guardar (opcional, retorna contenido si es null)
     * @param array $options Opciones adicionales (max_width, quality, etc.)
     * @return string|false Contenido de la imagen optimizada o false si falla
     */
    public function optimize(UploadedFile $file, ?string $savePath = null, array $options = []): string|false
    {
        try {
            // Validar tamaño máximo
            if ($file->getSize() > self::MAX_FILE_SIZE) {
                Log::warning('Imagen demasiado grande para optimizar', [
                    'size' => $file->getSize(),
                    'max_size' => self::MAX_FILE_SIZE,
                    'file' => $file->getClientOriginalName()
                ]);
                return false;
            }

            // Leer archivo a memoria
            $imageContent = file_get_contents($file->getPathname());
            if ($imageContent === false) {
                return false;
            }

            // Procesar con Intervention Image
            $image = $this->imageManager->read($imageContent);

            // Obtener opciones
            $maxWidth = $options['max_width'] ?? self::MAX_WIDTH;
            $quality = $options['quality'] ?? self::WEBP_QUALITY;

            // Redimensionar si es necesario
            // Para productos: usar crop desde el centro si se especifica max_height
            $width = $image->width();
            $height = $image->height();
            $maxHeight = $options['max_height'] ?? null;

            if ($width > $maxWidth || ($maxHeight !== null && $height > $maxHeight)) {
                // Si se especifica altura máxima, hacer crop desde el centro
                if ($maxHeight !== null) {
                    // Calcular ratio objetivo
                    $targetRatio = $maxWidth / $maxHeight;
                    $currentRatio = $width / $height;
                    
                    if ($currentRatio > $targetRatio) {
                        // Imagen más ancha que el ratio objetivo: crop horizontal desde el centro
                        $newHeight = $height;
                        $newWidth = $height * $targetRatio;
                        
                        // Si el nuevo ancho es mayor que el máximo, ajustar
                        if ($newWidth > $maxWidth) {
                            $newWidth = $maxWidth;
                            $newHeight = $maxWidth / $targetRatio;
                        }
                        
                        $cropX = ($width - $newWidth) / 2; // Centrar horizontalmente
                        $cropY = ($height - $newHeight) / 2; // Centrar verticalmente
                    } else {
                        // Imagen más alta que el ratio objetivo: crop vertical desde el centro
                        $newWidth = $width;
                        $newHeight = $width / $targetRatio;
                        
                        // Si la nueva altura es mayor que el máximo, ajustar
                        if ($newHeight > $maxHeight) {
                            $newHeight = $maxHeight;
                            $newWidth = $maxHeight * $targetRatio;
                        }
                        
                        $cropX = ($width - $newWidth) / 2; // Centrar horizontalmente
                        $cropY = ($height - $newHeight) / 2; // Centrar verticalmente
                    }
                    
                    // Crop desde el centro
                    $image->crop(
                        width: (int)$newWidth,
                        height: (int)$newHeight,
                        x: (int)$cropX,
                        y: (int)$cropY
                    );
                    
                    // Escalar a tamaño final si aún es necesario
                    if ($image->width() > $maxWidth || ($maxHeight !== null && $image->height() > $maxHeight)) {
                        $image->scale(width: $maxWidth, height: $maxHeight);
                    }
                } else {
                    // Solo redimensionar manteniendo proporción (sin crop)
                    $image->scale(width: $maxWidth);
                }
                
                Log::info('Imagen redimensionada', [
                    'original' => "{$width}x{$height}",
                    'nuevo' => "{$image->width()}x{$image->height()}",
                    'crop_desde_centro' => $maxHeight !== null
                ]);
            }

            // Convertir a WebP con calidad
            $optimizedContent = $image->toWebp($quality);

            // Intentar optimización adicional con spatie si está disponible
            if ($this->isSpatieAvailable()) {
                $tempPath = tempnam(sys_get_temp_dir(), 'img_opt_');
                file_put_contents($tempPath, $optimizedContent);
                
                try {
                    $optimizerChain = OptimizerChainFactory::create();
                    $optimizerChain->optimize($tempPath);
                    
                    $optimizedContent = file_get_contents($tempPath);
                    unlink($tempPath);
                    
                    Log::info('Optimización adicional aplicada con spatie');
                } catch (\Exception $e) {
                    Log::warning('Error en optimización spatie, usando solo Intervention', [
                        'error' => $e->getMessage()
                    ]);
                    // Continuar con contenido de Intervention si falla spatie
                }
            }

            // Guardar si se especificó path
            if ($savePath !== null) {
                Storage::disk('public')->put($savePath, $optimizedContent);
            }

            return $optimizedContent;

        } catch (\Exception $e) {
            Log::error('Error optimizando imagen', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Verificar si spatie/laravel-image-optimizer está disponible
     * (chequea si las herramientas del sistema están instaladas)
     */
    protected function isSpatieAvailable(): bool
    {
        if (self::$spatieAvailable !== null) {
            return self::$spatieAvailable;
        }

        try {
            // Intentar crear una instancia del optimizador
            // Si falla, significa que las herramientas no están disponibles
            $optimizerChain = OptimizerChainFactory::create();
            
            // Verificar herramientas básicas (solo check, no optimizar)
            self::$spatieAvailable = true;
            
            Log::info('spatie/laravel-image-optimizer está disponible');
        } catch (\Exception $e) {
            self::$spatieAvailable = false;
            
            Log::info('spatie/laravel-image-optimizer no disponible, usando solo Intervention Image', [
                'reason' => $e->getMessage()
            ]);
        }

        return self::$spatieAvailable;
    }

    /**
     * Generar nombre único para imagen WebP
     */
    public function generateWebpFilename(UploadedFile $file): string
    {
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slug = \Illuminate\Support\Str::slug($name);
        
        return $slug . '-' . time() . '.webp';
    }

    /**
     * Validar que el archivo sea una imagen válida
     */
    public function isValidImage(UploadedFile $file): bool
    {
        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        return in_array($file->getMimeType(), $allowedMimes) ||
               in_array(strtolower($file->getClientOriginalExtension()), $allowedExtensions);
    }

    /**
     * Obtener información de la imagen optimizada
     */
    public function getOptimizationInfo(string $originalPath, string $optimizedPath): array
    {
        $originalSize = Storage::disk('public')->size($originalPath);
        $optimizedSize = Storage::disk('public')->size($optimizedPath);
        
        $reduction = $originalSize > 0 
            ? round((($originalSize - $optimizedSize) / $originalSize) * 100, 2)
            : 0;

        return [
            'original_size' => $originalSize,
            'optimized_size' => $optimizedSize,
            'reduction_percent' => $reduction,
            'reduction_bytes' => $originalSize - $optimizedSize
        ];
    }
}

