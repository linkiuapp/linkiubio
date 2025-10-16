<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\BusinessCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessCategoryController extends Controller
{
    /**
     * Display a listing of business categories
     */
    public function index()
    {
        $categories = BusinessCategory::ordered()
            ->withCount('stores')
            ->paginate(20);

        $stats = [
            'total' => BusinessCategory::count(),
            'active' => BusinessCategory::active()->count(),
            'auto_approve' => BusinessCategory::autoApprove()->count(),
            'manual_review' => BusinessCategory::manualReview()->count()
        ];

        return view('superlinkiu::business-categories.index', compact('categories', 'stats'));
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:business_categories,name',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
            'requires_manual_approval' => 'required|boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0'
        ]);

        $validated['created_by'] = auth()->id();
        $validated['slug'] = Str::slug($validated['name']);
        
        if (!isset($validated['order'])) {
            $validated['order'] = BusinessCategory::max('order') + 1;
        }

        BusinessCategory::create($validated);

        return redirect()
            ->route('superlinkiu.business-categories.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, BusinessCategory $businessCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:business_categories,name,' . $businessCategory->id,
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
            'requires_manual_approval' => 'required|boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $businessCategory->update($validated);

        return redirect()
            ->route('superlinkiu.business-categories.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified category
     */
    public function destroy(BusinessCategory $businessCategory)
    {
        // Verificar que no tenga tiendas asociadas
        if ($businessCategory->stores()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una categoría con tiendas asociadas.');
        }

        $businessCategory->delete();

        return redirect()
            ->route('superlinkiu.business-categories.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(BusinessCategory $businessCategory)
    {
        $businessCategory->update([
            'is_active' => !$businessCategory->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $businessCategory->is_active,
            'message' => $businessCategory->is_active ? 'Categoría activada' : 'Categoría desactivada'
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update order of categories
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:business_categories,id',
            'categories.*.order' => 'required|integer|min:0'
        ]);

        foreach ($validated['categories'] as $categoryData) {
            BusinessCategory::where('id', $categoryData['id'])
                ->update(['order' => $categoryData['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden actualizado exitosamente'
        ]);
    }
}

