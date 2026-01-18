<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\UiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UiImageController extends Controller
{
    /**
     * Display a listing of UI images
     */
    public function index(Request $request)
    {
        $context = $request->get('context', 'store');
        $category = $request->get('category');
        
        $query = UiImage::byContext($context)->ordered();
        
        if ($category) {
            $query->byCategory($category);
        }
        
        $images = $query->with('creator')->paginate(20);
        
        // Estadísticas por contexto
        $stats = [
            'store' => UiImage::byContext('store')->active()->count(),
            'tenant_admin' => UiImage::byContext('tenant_admin')->active()->count(),
            'website' => UiImage::byContext('website')->active()->count(),
            'super_admin' => UiImage::byContext('super_admin')->active()->count(),
        ];
        
        // Categorías disponibles por contexto
        $categories = UiImage::where('context', $context)
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->toArray();
        
        // Si es petición AJAX, devolver solo el contenido de la tabla
        if ($request->ajax()) {
            $tableHtml = view('superlinkiu::ui-images.partials.table-content', compact('images'))->render();
            $categoriesHtml = view('superlinkiu::ui-images.partials.categories-select', compact('categories', 'category'))->render();
            
            return response()->json([
                'table' => $tableHtml,
                'categories' => $categoriesHtml,
            ]);
        }
        
        return view('superlinkiu::ui-images.index', compact('images', 'context', 'category', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new UI image
     */
    public function create()
    {
        $categories = UiImage::getAvailableCategories();
        return view('superlinkiu::ui-images.create', compact('categories'));
    }

    /**
     * Store a newly created UI image
     */
    public function store(Request $request)
    {
        // Validar primero si hay archivo
        if (!$request->hasFile('image')) {
            return back()
                ->withErrors(['image' => 'Debes seleccionar un archivo para subir'])
                ->withInput();
        }

        $file = $request->file('image');
        
        // Verificar que el archivo sea válido ANTES de la validación
        if (!$file || !$file->isValid()) {
            $errorMessage = 'El archivo no se pudo subir correctamente.';
            
            // Verificar errores específicos de PHP
            if ($file) {
                $errorCode = $file->getError();
                switch ($errorCode) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $errorMessage = 'El archivo es demasiado grande. El tamaño máximo permitido es 5MB.';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $errorMessage = 'El archivo se subió parcialmente. Intenta nuevamente.';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $errorMessage = 'No se seleccionó ningún archivo.';
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $errorMessage = 'Error del servidor: falta el directorio temporal.';
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $errorMessage = 'Error del servidor: no se pudo escribir el archivo.';
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $errorMessage = 'Error del servidor: una extensión de PHP detuvo la subida.';
                        break;
                }
            }
            
            return back()
                ->withErrors(['image' => $errorMessage])
                ->withInput();
        }

        $validated = $request->validate([
            'context' => 'required|in:store,tenant_admin,website,super_admin',
            'category' => 'nullable|string|max:100',
            'category_custom' => 'nullable|string|max:100',
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:500',
            'image' => 'required|file|mimes:svg,webp|max:5120', // 5MB max
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'image.required' => 'Debes seleccionar un archivo para subir.',
            'image.file' => 'El archivo seleccionado no es válido.',
            'image.uploaded' => 'El archivo no se pudo subir. Verifica que el tamaño no exceda 5MB y que el formato sea SVG o WebP.',
            'image.mimes' => 'El archivo debe ser SVG o WebP. Formatos permitidos: .svg, .webp',
            'image.max' => 'El archivo es demasiado grande. El tamaño máximo permitido es 5MB.',
        ]);
        
        // Usar categoría personalizada si existe
        if ($request->has('category_custom') && !empty($request->input('category_custom'))) {
            $validated['category'] = $request->input('category_custom');
        }

        // El archivo ya está validado, obtenerlo nuevamente
        $file = $request->file('image');
        
        try {
            $mimeType = $file->getMimeType();
        } catch (\Exception $e) {
            return back()
                ->withErrors(['image' => 'No se pudo leer el tipo de archivo. Verifica que el archivo sea válido.'])
                ->withInput();
        }
        
        // Validar que sea SVG o WebP
        if (!UiImage::isValidMimeType($mimeType)) {
            return back()
                ->withErrors(['image' => 'El archivo debe ser SVG o WebP. Tipo detectado: ' . $mimeType])
                ->withInput();
        }

        try {
            // Generar nombre único para el archivo
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug($validated['name']) . '_' . time() . '.' . $extension;
            $directory = 'images-ui/' . $validated['context'] . '/' . $validated['category'];
            
            // Asegurar que el directorio existe
            Storage::disk('public')->makeDirectory($directory);
            
            // Guardar archivo
            $filePath = Storage::disk('public')->putFileAs($directory, $file, $fileName);

            if (!$filePath) {
                throw new \Exception('No se pudo guardar el archivo en el servidor.');
            }

            // Obtener metadata de la imagen (solo para WebP)
            $metadata = [];
            if ($mimeType === 'image/webp') {
                // Usar Storage para obtener la ruta correcta
                $fullPath = Storage::disk('public')->path($filePath);
                if (file_exists($fullPath)) {
                    $imageInfo = @getimagesize($fullPath);
                    if ($imageInfo && $imageInfo !== false) {
                        $metadata = [
                            'width' => $imageInfo[0],
                            'height' => $imageInfo[1],
                        ];
                    }
                }
            }

            // Si no se especifica sort_order, usar el máximo + 1
            if (!isset($validated['sort_order'])) {
                $maxOrder = UiImage::where('context', $validated['context'])
                    ->where('category', $validated['category'])
                    ->max('sort_order') ?? 0;
                $validated['sort_order'] = $maxOrder + 1;
            }

            $uiImage = UiImage::create([
                'context' => $validated['context'],
                'category' => $validated['category'],
                'name' => $validated['name'],
                'url' => $validated['url'] ?? null,
                'file_path' => $filePath, // Solo la ruta relativa, sin 'storage/'
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $mimeType,
                'is_active' => $validated['is_active'] ?? true,
                'sort_order' => $validated['sort_order'],
                'metadata' => $metadata,
                'created_by' => auth()->id(),
            ]);

            return redirect()
                ->route('superlinkiu.ui-images.index', ['context' => $validated['context'], 'category' => $validated['category']])
                ->with('success', 'Imagen creada exitosamente.');
                
        } catch (\Exception $e) {
            \Log::error('Error al guardar imagen UI', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withErrors(['image' => 'Error al guardar el archivo: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified UI image
     */
    public function edit(UiImage $uiImage)
    {
        $categories = UiImage::getAvailableCategories($uiImage->context);
        $categoriesInfo = UiImage::getCategoriesByContext($uiImage->context);
        return view('superlinkiu::ui-images.edit', compact('uiImage', 'categories', 'categoriesInfo'));
    }

    /**
     * Update the specified UI image
     */
    public function update(Request $request, UiImage $uiImage)
    {
        $validated = $request->validate([
            'context' => 'required|in:store,tenant_admin,website,super_admin',
            'category' => 'nullable|string|max:100',
            'category_custom' => 'nullable|string|max:100',
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:500',
            'image' => 'nullable|file|mimes:svg,webp|max:5120',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Manejar categoría: si viene category_custom, usarla; si no, usar category
        if ($request->has('category_custom') && !empty($request->input('category_custom'))) {
            $validated['category'] = $request->input('category_custom');
        } elseif (empty($validated['category'])) {
            return back()
                ->withErrors(['category' => 'Debes seleccionar o ingresar una categoría.'])
                ->withInput();
        }

        // Si se sube una nueva imagen
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mimeType = $file->getMimeType();
            
            if (!UiImage::isValidMimeType($mimeType)) {
                return back()
                    ->withErrors(['image' => 'El archivo debe ser SVG o WebP'])
                    ->withInput();
            }

            // Eliminar imagen anterior
            $oldPath = str_replace('storage/', '', $uiImage->file_path);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Guardar nueva imagen
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug($validated['name']) . '_' . time() . '.' . $extension;
            $directory = 'images-ui/' . $validated['context'] . '/' . $validated['category'];
            
            // Asegurar que el directorio existe
            Storage::disk('public')->makeDirectory($directory);
            
            // Guardar archivo
            $filePath = Storage::disk('public')->putFileAs($directory, $file, $fileName);

            // Actualizar metadata (solo para WebP)
            $metadata = [];
            if ($mimeType === 'image/webp') {
                // Usar Storage para obtener la ruta correcta
                $fullPath = Storage::disk('public')->path($filePath);
                if (file_exists($fullPath)) {
                    $imageInfo = @getimagesize($fullPath);
                    if ($imageInfo && $imageInfo !== false) {
                        $metadata = [
                            'width' => $imageInfo[0],
                            'height' => $imageInfo[1],
                        ];
                    }
                }
            }

            $uiImage->update([
                'file_path' => $filePath, // Solo la ruta relativa, sin 'storage/'
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $mimeType,
                'metadata' => $metadata,
            ]);
        }

        // Actualizar otros campos (incluyendo categoría si cambió)
        $oldCategory = $uiImage->category;
        $uiImage->update([
            'context' => $validated['context'],
            'category' => $validated['category'],
            'name' => $validated['name'],
            'url' => $validated['url'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $validated['sort_order'] ?? $uiImage->sort_order,
        ]);

        // Si cambió la categoría y hay un archivo, mover el archivo
        if ($oldCategory !== $validated['category'] && $request->hasFile('image')) {
            // El archivo ya fue guardado en la nueva ubicación arriba
            // Eliminar archivo antiguo si no hay más imágenes en esa categoría
            $oldPath = str_replace('storage/', '', $uiImage->getOriginal('file_path'));
            $hasOtherImages = UiImage::where('file_path', $uiImage->getOriginal('file_path'))
                ->where('id', '!=', $uiImage->id)
                ->exists();
            
            if (!$hasOtherImages && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        return redirect()
            ->route('superlinkiu.ui-images.index', ['context' => $validated['context'], 'category' => $validated['category']])
            ->with('success', 'Imagen actualizada exitosamente.');
    }

    /**
     * Remove the specified UI image
     */
    public function destroy(UiImage $uiImage)
    {
        // Eliminar archivo físico
        $filePath = $uiImage->file_path;
        // Limpiar 'storage/' si existe por compatibilidad con registros antiguos
        $filePath = str_replace('storage/', '', $filePath);
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $context = $uiImage->context;
        $category = $uiImage->category;

        $uiImage->delete();

        return redirect()
            ->route('superlinkiu.ui-images.index', ['context' => $context, 'category' => $category])
            ->with('success', 'Imagen eliminada exitosamente.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(UiImage $uiImage)
    {
        $uiImage->update(['is_active' => !$uiImage->is_active]);

        return back()->with('success', 'Estado actualizado exitosamente.');
    }
}
