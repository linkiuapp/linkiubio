<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\TutorialCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class TutorialCategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(): View
    {
        $categories = TutorialCategory::ordered()->paginate(15);
        return view('superlinkiu::tutorial-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('superlinkiu::tutorial-categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tutorial_categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        TutorialCategory::create($validated);

        return redirect()
            ->route('superlinkiu.tutorial-categories.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified category.
     */
    public function show(TutorialCategory $tutorialCategory): View
    {
        $tutorialCategory->load('tutorials');
        return view('superlinkiu::tutorial-categories.show', compact('tutorialCategory'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(TutorialCategory $tutorialCategory): View
    {
        return view('superlinkiu::tutorial-categories.edit', compact('tutorialCategory'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, TutorialCategory $tutorialCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tutorial_categories,slug,' . $tutorialCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug']) && $tutorialCategory->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? $tutorialCategory->order;

        $tutorialCategory->update($validated);

        return redirect()
            ->route('superlinkiu.tutorial-categories.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(TutorialCategory $tutorialCategory): RedirectResponse
    {
        // Verificar si tiene tutoriales asociados
        if ($tutorialCategory->tutorials()->count() > 0) {
            return redirect()
                ->route('superlinkiu.tutorial-categories.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene tutoriales asociados.');
        }

        $tutorialCategory->delete();

        return redirect()
            ->route('superlinkiu.tutorial-categories.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}
