<?php

namespace App\Features\TenantAdmin\Services;

use App\Features\TenantAdmin\Models\Slider;
use App\Shared\Services\ImageOptimizationService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderImageService
{
    /**
     * Procesar y guardar imagen de slider con optimización
     */
    public function processImage(Slider $slider, UploadedFile $image): ?string
    {
        try {
            // Validar imagen
            $optimizationService = app(ImageOptimizationService::class);
            if (!$this->validateImage($image) || !$optimizationService->isValidImage($image)) {
                return null;
            }

            // Sliders tienen dimensiones específicas: 420x200px
            // Usar optimización pero respetar dimensiones exactas
            $filename = $optimizationService->generateWebpFilename($image);
            $directory = 'sliders/' . $slider->store_id;
            $path = $directory . '/' . $filename;

            // Procesar con Intervention para redimensionar y convertir a WebP
            $optimizedContent = $optimizationService->optimize($image, null, [
                'max_width' => 420, // Ancho específico para slider
                'quality' => 85
            ]);

            // Si falla optimización, usar método GD antiguo como fallback
            if ($optimizedContent === false) {
                \Log::warning('Optimización falló, usando GD como fallback', [
                    'slider_id' => $slider->id
                ]);
                
                $processedImage = $this->processImageWithGD($image);
                if (!$processedImage) {
                    return null;
                }
                
                // Guardar como JPG (formato antiguo para compatibilidad)
                $filename = $this->generateUniqueFilename($image);
                $path = $directory . '/' . $filename;
                Storage::disk('public')->put($path, $processedImage);
            } else {
                // Redimensionar a dimensiones exactas del slider (420x200)
                // Usar Intervention para ajustar a dimensiones exactas
                $imageManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                $sliderImage = $imageManager->read($optimizedContent);
                
                // Redimensionar usando cover (crop inteligente) para 420x200
                $sliderImage = $sliderImage->cover(420, 200);
                
                // Guardar como WebP
                $optimizedContent = $sliderImage->toWebp(85);
                Storage::disk('public')->put($path, $optimizedContent);
            }

            return $path;

        } catch (\Exception $e) {
            \Log::error('Error procesando imagen de slider: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            // Fallback final: método GD original
            try {
                $processedImage = $this->processImageWithGD($image);
                if ($processedImage) {
                    $filename = $this->generateUniqueFilename($image);
                    $directory = 'sliders/' . $slider->store_id;
                    $path = $directory . '/' . $filename;
                    Storage::disk('public')->put($path, $processedImage);
                    return $path;
                }
            } catch (\Exception $fallbackError) {
                \Log::error('Error en fallback GD: ' . $fallbackError->getMessage());
            }
            
            return null;
        }
    }

    /**
     * Validar imagen
     */
    private function validateImage(UploadedFile $image): bool
    {
        // Validar que sea una imagen (sin usar finfo)
        if (!$image->isValid()) {
            return false;
        }

        // Validar extensión de archivo en lugar de MIME type
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower($image->getClientOriginalExtension());
        if (!in_array($extension, $allowedExtensions)) {
            return false;
        }

        // Validar tamaño del archivo (máximo 2MB)
        if ($image->getSize() > 2 * 1024 * 1024) {
            return false;
        }

        // Validar dimensiones
        $imageInfo = getimagesize($image->getPathname());
        if (!$imageInfo) {
            return false;
        }

        [$width, $height] = $imageInfo;
        
        // Permitir imágenes con dimensiones mínimas de 420x200px (se redimensionarán automáticamente)
        if ($width < 420 || $height < 200) {
            return false;
        }

        return true;
    }

    /**
     * Procesar imagen con GD nativo
     */
    private function processImageWithGD(UploadedFile $image): ?string
    {
        try {
            // Verificar si GD está disponible
            if (!extension_loaded('gd')) {
                // Si no hay GD, solo mover el archivo sin procesamiento
                return file_get_contents($image->getPathname());
            }

            // Obtener información de la imagen
            $imageInfo = getimagesize($image->getPathname());
            if (!$imageInfo) {
                return null;
            }

            $mimeType = $imageInfo['mime'];
            
            // Crear imagen desde archivo según el tipo
            switch ($mimeType) {
                case 'image/jpeg':
                    $sourceImage = imagecreatefromjpeg($image->getPathname());
                    break;
                case 'image/png':
                    $sourceImage = imagecreatefrompng($image->getPathname());
                    break;
                case 'image/gif':
                    $sourceImage = imagecreatefromgif($image->getPathname());
                    break;
                case 'image/webp':
                    $sourceImage = imagecreatefromwebp($image->getPathname());
                    break;
                default:
                    return null;
            }

            if (!$sourceImage) {
                return null;
            }

            // Obtener dimensiones originales
            $originalWidth = imagesx($sourceImage);
            $originalHeight = imagesy($sourceImage);

            // Dimensiones finales del slider: 420x200px
            $targetWidth = 420;
            $targetHeight = 200;

            // Crear imagen destino
            $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);

            // Mantener transparencia para PNG/GIF
            if ($mimeType === 'image/png' || $mimeType === 'image/gif') {
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);
                $transparent = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
                imagefilledrectangle($resizedImage, 0, 0, $targetWidth, $targetHeight, $transparent);
            }

            // Redimensionar imagen
            imagecopyresampled(
                $resizedImage,
                $sourceImage,
                0, 0, 0, 0,
                $targetWidth, $targetHeight,
                $originalWidth, $originalHeight
            );
            
            // Crear buffer de salida
            ob_start();
            imagejpeg($resizedImage, null, 85); // 85% de calidad
            $imageData = ob_get_contents();
            ob_end_clean();

            // Liberar memoria
            imagedestroy($sourceImage);
            imagedestroy($resizedImage);

            return $imageData;

        } catch (\Exception $e) {
            \Log::error('Error procesando imagen con GD: ' . $e->getMessage());
            // Fallback: devolver archivo original
            return file_get_contents($image->getPathname());
        }
    }

    /**
     * Generar nombre único para archivo
     */
    private function generateUniqueFilename(UploadedFile $image): string
    {
        $extension = $image->getClientOriginalExtension();
        $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $slug = Str::slug($name);
        
        return $slug . '-' . time() . '.jpg'; // Siempre guardamos como JPG
    }

    /**
     * Eliminar imagen del storage
     */
    public function deleteImage(?string $imagePath): bool
    {
        if (!$imagePath) {
            return true;
        }

        try {
            if (Storage::disk('public')->exists($imagePath)) {
                return Storage::disk('public')->delete($imagePath);
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Error eliminando imagen de slider: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Duplicar imagen para nuevo slider
     */
    public function duplicateImage(Slider $originalSlider, Slider $newSlider): ?string
    {
        if (!$originalSlider->image_path) {
            return null;
        }

        try {
            $originalPath = $originalSlider->image_path;
            
            // ✅ Verificar que el archivo original existe en storage
            if (!Storage::disk('public')->exists($originalPath)) {
                return null;
            }

            // Crear nuevo nombre de archivo
            $pathInfo = pathinfo($originalPath);
            $newFilename = $pathInfo['filename'] . '-copy-' . time() . '.' . $pathInfo['extension'];
            
            $directory = 'sliders/' . $newSlider->store_id;
            $newPath = $directory . '/' . $newFilename;
            
            // ✅ Copiar archivo usando Storage - Compatible con S3
            $imageContent = Storage::disk('public')->get($originalPath);
            if (!Storage::disk('public')->put($newPath, $imageContent)) {
                throw new \Exception('Error copiando imagen de slider en storage');
            }

            return $newPath;

        } catch (\Exception $e) {
            \Log::error('Error duplicando imagen de slider: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener URL completa de la imagen
     */
    public function getImageUrl(?string $imagePath): ?string
    {
        if (!$imagePath) {
            return null;
        }

        return Storage::disk('public')->url($imagePath);
    }

    /**
     * Obtener información de la imagen
     */
    public function getImageInfo(?string $imagePath): ?array
    {
        if (!$imagePath || !Storage::disk('public')->exists($imagePath)) {
            return null;
        }

        try {
            // ✅ Para S3, obtenemos el contenido y usamos getimagesizefromstring
            $imageContent = Storage::disk('public')->get($imagePath);
            $imageInfo = getimagesizefromstring($imageContent);
            
            if (!$imageInfo) {
                return null;
            }

            return [
                'width' => $imageInfo[0],
                'height' => $imageInfo[1],
                'mime' => $imageInfo['mime'],
                'size' => Storage::disk('public')->size($imagePath),
                'url' => $this->getImageUrl($imagePath)
            ];

        } catch (\Exception $e) {
            \Log::error('Error obteniendo información de imagen: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Validar si una imagen existe
     */
    public function imageExists(?string $imagePath): bool
    {
        if (!$imagePath) {
            return false;
        }

        return Storage::disk('public')->exists($imagePath);
    }
} 