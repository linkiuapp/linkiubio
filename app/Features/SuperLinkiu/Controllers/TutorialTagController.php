<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\TutorialTag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class TutorialTagController extends Controller
{
    /**
     * Display a listing of tags.
     */
    public function index(Request $request): View
    {
        $query = TutorialTag::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $tags = $query->orderBy('name')->paginate(15)->withQueryString();
        return view('superlinkiu::tutorial-tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create(): View
    {
        return view('superlinkiu::tutorial-tags.create');
    }

    /**
     * Store a newly created tag.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tutorial_tags,name',
            'slug' => 'nullable|string|max:255|unique:tutorial_tags,slug',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        TutorialTag::create($validated);

        return redirect()
            ->route('superlinkiu.tutorial-tags.index')
            ->with('success', 'Etiqueta creada exitosamente.');
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit(TutorialTag $tutorialTag): View
    {
        return view('superlinkiu::tutorial-tags.edit', compact('tutorialTag'));
    }

    /**
     * Update the specified tag.
     */
    public function update(Request $request, TutorialTag $tutorialTag): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tutorial_tags,name,' . $tutorialTag->id,
            'slug' => 'nullable|string|max:255|unique:tutorial_tags,slug,' . $tutorialTag->id,
        ]);

        if (empty($validated['slug']) && $tutorialTag->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tutorialTag->update($validated);

        return redirect()
            ->route('superlinkiu.tutorial-tags.index')
            ->with('success', 'Etiqueta actualizada exitosamente.');
    }

    /**
     * Remove the specified tag.
     */
    public function destroy(TutorialTag $tutorialTag): RedirectResponse
    {
        $tutorialTag->delete();

        return redirect()
            ->route('superlinkiu.tutorial-tags.index')
            ->with('success', 'Etiqueta eliminada exitosamente.');
    }
}
