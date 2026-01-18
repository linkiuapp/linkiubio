<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\Tutorial;
use App\Features\SuperLinkiu\Models\TutorialCategory;
use App\Features\SuperLinkiu\Models\TutorialTag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TutorialController extends Controller
{
    /**
     * Display a listing of tutorials.
     */
    public function index(Request $request): View
    {
        $query = Tutorial::with(['category', 'tags']);

        // Filtros
        if ($request->filled('category_id')) {
            $query->byCategory($request->category_id);
        }

        if ($request->filled('difficulty')) {
            $query->byDifficulty($request->difficulty);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $tutorials = $query->ordered()->paginate(15)->withQueryString();

        $categories = TutorialCategory::ordered()->get();
        $difficulties = [
            'beginner' => 'Principiante',
            'intermediate' => 'Intermedio',
            'advanced' => 'Avanzado',
        ];

        // Estadísticas
        $stats = [
            'total' => Tutorial::count(),
            'active' => Tutorial::where('is_active', true)->count(),
            'inactive' => Tutorial::where('is_active', false)->count(),
        ];

        return view('superlinkiu::tutorials.index', compact('tutorials', 'categories', 'difficulties', 'stats'));
    }

    /**
     * Show the form for creating a new tutorial.
     */
    public function create(): View
    {
        $categories = TutorialCategory::active()->ordered()->get();
        $tags = TutorialTag::orderBy('name')->get();
        $difficulties = [
            'beginner' => 'Principiante',
            'intermediate' => 'Intermedio',
            'advanced' => 'Avanzado',
        ];

        return view('superlinkiu::tutorials.create', compact('categories', 'tags', 'difficulties'));
    }

    /**
     * Store a newly created tutorial.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:tutorial_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tutorials,slug',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_url' => 'nullable|url|max:500',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tutorial_tags,id',
        ]);

        // Generar slug si no se proporciona
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Manejar imagen destacada (cover - vista general)
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('tutorials/featured', 'public');
            $validated['featured_image'] = $path;
        }

        // Manejar imagen portada (vista individual - 830x200)
        if ($request->hasFile('portada_image')) {
            $path = $request->file('portada_image')->store('tutorials/portada', 'public');
            $validated['portada_image'] = $path;
        }

        // Valores por defecto
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        // Crear tutorial
        $tutorial = Tutorial::create($validated);

        // Sincronizar tags
        if ($request->has('tags')) {
            $tutorial->tags()->sync($request->tags);
        }

        return redirect()
            ->route('superlinkiu.tutorials.index')
            ->with('success', 'Tutorial creado exitosamente.');
    }

    /**
     * Display the specified tutorial.
     */
    public function show(Tutorial $tutorial): View
    {
        $tutorial->load(['category', 'tags']);
        return view('superlinkiu::tutorials.show', compact('tutorial'));
    }

    /**
     * Show the form for editing the specified tutorial.
     */
    public function edit(Tutorial $tutorial): View
    {
        $tutorial->load(['category', 'tags']);
        $categories = TutorialCategory::active()->ordered()->get();
        $tags = TutorialTag::orderBy('name')->get();
        $difficulties = [
            'beginner' => 'Principiante',
            'intermediate' => 'Intermedio',
            'advanced' => 'Avanzado',
        ];

        return view('superlinkiu::tutorials.edit', compact('tutorial', 'categories', 'tags', 'difficulties'));
    }

    /**
     * Update the specified tutorial.
     */
    public function update(Request $request, Tutorial $tutorial): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:tutorial_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tutorials,slug,' . $tutorial->id,
            'description' => 'nullable|string',
            'content' => 'required|string',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'portada_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_url' => 'nullable|url|max:500',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tutorial_tags,id',
        ]);

        // Generar slug si no se proporciona y el título cambió
        if (empty($validated['slug']) && $tutorial->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Manejar imagen destacada (cover - vista general)
        if ($request->hasFile('featured_image')) {
            // Eliminar imagen anterior si existe
            if ($tutorial->featured_image) {
                Storage::disk('public')->delete($tutorial->featured_image);
            }
            $path = $request->file('featured_image')->store('tutorials/featured', 'public');
            $validated['featured_image'] = $path;
        }

        // Manejar imagen portada (vista individual - 830x200)
        if ($request->hasFile('portada_image')) {
            // Eliminar imagen anterior si existe
            if ($tutorial->portada_image) {
                Storage::disk('public')->delete($tutorial->portada_image);
            }
            $path = $request->file('portada_image')->store('tutorials/portada', 'public');
            $validated['portada_image'] = $path;
        }

        // Valores por defecto
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? $tutorial->order;

        // Actualizar tutorial
        $tutorial->update($validated);

        // Sincronizar tags
        if ($request->has('tags')) {
            $tutorial->tags()->sync($request->tags);
        } else {
            $tutorial->tags()->detach();
        }

        return redirect()
            ->route('superlinkiu.tutorials.index')
            ->with('success', 'Tutorial actualizado exitosamente.');
    }

    /**
     * Remove the specified tutorial.
     */
    public function destroy(Tutorial $tutorial): RedirectResponse
    {
        // Eliminar imágenes si existen
        if ($tutorial->featured_image) {
            Storage::disk('public')->delete($tutorial->featured_image);
        }
        if ($tutorial->portada_image) {
            Storage::disk('public')->delete($tutorial->portada_image);
        }

        $tutorial->delete();

        return redirect()
            ->route('superlinkiu.tutorials.index')
            ->with('success', 'Tutorial eliminado exitosamente.');
    }

    /**
     * Upload image for content insertion
     */
    public function uploadImage(Request $request)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $path = $request->file('image')->store('tutorials/content', 'public');
            $url = Storage::disk('public')->url($path);

            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $path,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen: ' . $e->getMessage(),
            ], 500);
        }
    }
}
