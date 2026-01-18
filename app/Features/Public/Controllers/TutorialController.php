<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\Tutorial;
use App\Features\SuperLinkiu\Models\TutorialCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TutorialController extends Controller
{
    /**
     * Display a listing of public tutorials.
     */
    public function index(Request $request): View
    {
        $query = Tutorial::with(['category', 'tags'])
            ->where('is_active', true);

        // Filtro por categoría
        if ($request->filled('category')) {
            $category = TutorialCategory::where('slug', $request->category)
                ->where('is_active', true)
                ->first();
            
            if ($category) {
                $query->byCategory($category->id);
            }
        }

        // Filtro por nivel de dificultad
        if ($request->filled('difficulty')) {
            $query->byDifficulty($request->difficulty);
        }

        // Búsqueda por palabras clave
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Ordenar
        $tutorials = $query->ordered()->paginate(12)->withQueryString();

        // Obtener categorías activas para el filtro
        $categories = TutorialCategory::active()->ordered()->get();

        // Niveles de dificultad
        $difficulties = [
            'beginner' => 'Principiante',
            'intermediate' => 'Intermedio',
            'advanced' => 'Avanzado',
        ];

        return view('public::tutorials.index', compact('tutorials', 'categories', 'difficulties'));
    }

    /**
     * Display the specified tutorial.
     */
    public function show(string $slug): View
    {
        $tutorial = Tutorial::with(['category', 'tags'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Incrementar contador de vistas
        $tutorial->incrementViews();

        // Obtener tutoriales relacionados (misma categoría)
        $relatedTutorials = Tutorial::with(['category'])
            ->where('category_id', $tutorial->category_id)
            ->where('id', '!=', $tutorial->id)
            ->where('is_active', true)
            ->ordered()
            ->limit(4)
            ->get();

        return view('public::tutorials.show', compact('tutorial', 'relatedTutorials'));
    }
}
