<?php

namespace App\Features\TenantAdmin\Services;

use App\Features\TenantAdmin\Models\Product;
use App\Features\TenantAdmin\Models\ProductImage;
use App\Shared\Services\ImageOptimizationService;
use App\Jobs\OptimizeImageJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{


    /**
     * Procesar y guardar imágenes de producto
     */
    public function processImages(Product $product, array $images, ?int $mainImageIndex = null): array
    {
        $processedImages = [];
        
        foreach ($images as $index => $image) {
            if ($image instanceof UploadedFile) {
                $processedImage = $this->processImage($product, $image, $index, $mainImageIndex);
                if ($processedImage) {
                    $processedImages[] = $processedImage;
                }
            }
        }
        
        return $processedImages;
    }

    /**
     * Procesar una imagen individual con optimización
     */
    private function processImage(Product $product, UploadedFile $image, int $index, ?int $mainImageIndex = null): ?ProductImage
    {
        try {
            // Validar que sea una imagen válida
            $optimizationService = app(ImageOptimizationService::class);
            if (!$image->isValid() || !$optimizationService->isValidImage($image)) {
                return null;
            }

            // Generar nombre único para la imagen WebP
            $filename = $optimizationService->generateWebpFilename($image);
            $directory = 'products/' . $product->id . '/images';
            $relativePath = $directory . '/' . $filename;

            // Optimizar imagen: redimensionar, convertir a WebP
            $optimizedContent = $optimizationService->optimize($image, null, [
                'max_width' => 2000, // Máximo 2000px de ancho
                'quality' => 85
            ]);

            // Si la optimización falla, guardar original como fallback
            if ($optimizedContent === false) {
                \Log::warning('Optimización falló, guardando imagen original', [
                    'product_id' => $product->id,
                    'filename' => $image->getClientOriginalName()
                ]);
                
                // Fallback: guardar original
                $originalFilename = $this->generateUniqueFilename($image);
                $relativePath = Storage::disk('public')->putFileAs($directory, $image, $originalFilename);
                
                if (!$relativePath) {
                    throw new \Exception('Error guardando imagen de producto en storage');
                }
            } else {
                // Guardar imagen optimizada (WebP)
                Storage::disk('public')->put($relativePath, $optimizedContent);
            }

            // Crear registro en base de datos
            $productImage = ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $relativePath,
                'thumbnail_path' => null,
                'medium_path' => null,
                'large_path' => null,
                'alt_text' => $product->name,
                'is_main' => $mainImageIndex === $index,
                'sort_order' => $index
            ]);

            // Si la imagen no es WebP aún, programar optimización adicional en background
            if (pathinfo($relativePath, PATHINFO_EXTENSION) !== 'webp') {
                OptimizeImageJob::dispatch($relativePath, 'product', 2000)
                    ->onQueue('images');
            }

            return $productImage;

        } catch (\Exception $e) {
            \Log::error('Error procesando imagen de producto: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Generar nombre único para archivo
     */
    private function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $timestamp = now()->format('YmdHis');
        $random = Str::random(8);
        
        return "{$name}_{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Eliminar imagen
     */
    public function deleteImage(ProductImage $image): bool
    {
        try {
            // ✅ Eliminar archivo físico usando Storage - Compatible con S3
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }

            // ✅ Eliminar thumbnails si existen
            if ($image->thumbnail_path && Storage::disk('public')->exists($image->thumbnail_path)) {
                Storage::disk('public')->delete($image->thumbnail_path);
            }

            if ($image->medium_path && Storage::disk('public')->exists($image->medium_path)) {
                Storage::disk('public')->delete($image->medium_path);
            }

            if ($image->large_path && Storage::disk('public')->exists($image->large_path)) {
                Storage::disk('public')->delete($image->large_path);
            }

            // Eliminar registro de BD
            return $image->delete();

        } catch (\Exception $e) {
            \Log::error('Error eliminando imagen de producto: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar todas las imágenes de un producto
     */
    public function deleteAllImages(Product $product): bool
    {
        try {
            foreach ($product->images as $image) {
                $this->deleteImage($image);
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Error eliminando imágenes del producto: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Establecer imagen principal
     */
    public function setMainImage(Product $product, ProductImage $image): bool
    {
        try {
            // Quitar la marca de principal de todas las imágenes
            $product->images()->update(['is_main' => false]);
            
            // Establecer como principal la imagen seleccionada
            $image->update(['is_main' => true]);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Error estableciendo imagen principal: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Reordenar imágenes
     */
    public function reorderImages(Product $product, array $imageIds): bool
    {
        try {
            foreach ($imageIds as $index => $imageId) {
                ProductImage::where('id', $imageId)
                    ->where('product_id', $product->id)
                    ->update(['sort_order' => $index]);
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Error reordenando imágenes: ' . $e->getMessage());
            return false;
        }
    }
} 