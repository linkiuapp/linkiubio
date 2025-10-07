<?php

namespace App\Features\TenantAdmin\Services;

use App\Features\TenantAdmin\Models\Slider;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderImageService
{
    /**
     * Procesar y guardar imagen de slider
     */
    public function processImage(Slider $slider, UploadedFile $image): ?string
    {
        try {
            // Validar imagen
            if (!$this->validateImage($image)) {
                return null;
            }

            // Generar nombre único
            $filename = $this->generateUniqueFilename($image);
            
            // Procesar imagen con funciones nativas de PHP
            $processedImage = $this->processImageWithGD($image);
            if (!$processedImage) {
                return null;
            }
            
            // Guardar imagen en almacenamiento local (método directo sin Storage facade)
            $directory = 'sliders/' . $slider->store_id;
            $publicPath = storage_path('app/public');
            $fullDirectoryPath = $publicPath . '/' . $directory;
            $fullFilePath = $fullDirectoryPath . '/' . $filename;
            
            // Crear directorio si no existe (método directo PHP)
            if (!file_exists($fullDirectoryPath)) {
                mkdir($fullDirectoryPath, 0755, true);
            }
            
            // Guardar imagen procesada directamente
            if (file_put_contents($fullFilePath, $processedImage)) {
                $path = $directory . '/' . $filename; // Path relativo para BD
            } else {
                throw new \Exception('Error guardando imagen de slider');
            }

            return $path;

        } catch (\Exception $e) {
            \Log::error('Error procesando imagen de slider: ' . $e->getMessage());
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
        
        // Exactamente 170x100px
        if ($width !== 170 || $height !== 100) {
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

            // Como ya validamos que es exactamente 170x100, no necesitamos redimensionar
            // Solo optimizar y convertir a JPEG
            
            // Crear buffer de salida
            ob_start();
            imagejpeg($sourceImage, null, 85); // 85% de calidad
            $imageData = ob_get_contents();
            ob_end_clean();

            // Liberar memoria
            imagedestroy($sourceImage);

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
            $publicPath = storage_path('app/public');
            $fullOriginalPath = $publicPath . '/' . $originalPath;
            
            // Verificar que el archivo original existe
            if (!file_exists($fullOriginalPath)) {
                return null;
            }

            // Crear nuevo nombre de archivo
            $pathInfo = pathinfo($originalPath);
            $newFilename = $pathInfo['filename'] . '-copy-' . time() . '.' . $pathInfo['extension'];
            
            // Crear directorio si no existe (método directo PHP)
            $directory = 'sliders/' . $newSlider->store_id;
            $fullDirectoryPath = $publicPath . '/' . $directory;
            if (!file_exists($fullDirectoryPath)) {
                mkdir($fullDirectoryPath, 0755, true);
            }

            $newPath = $directory . '/' . $newFilename;
            $fullNewPath = $publicPath . '/' . $newPath;
            
            // Copiar archivo directamente
            if (!copy($fullOriginalPath, $fullNewPath)) {
                throw new \Exception('Error copiando imagen de slider');
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
            $fullPath = Storage::disk('public')->path($imagePath);
            $imageInfo = getimagesize($fullPath);
            
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