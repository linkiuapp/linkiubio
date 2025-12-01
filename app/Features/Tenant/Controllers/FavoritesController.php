<?php

namespace App\Features\Tenant\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Features\TenantAdmin\Models\Product;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * Mostrar la lista de productos favoritos
     */
    public function index(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Cargar la relación design para el frontend
        $store->load('design');

        // Si la tienda está inactiva o suspendida, mostrar mensaje
        if ($store->status !== 'active') {
            return view('tenant::storefront.inactive', compact('store'));
        }

        // Los favoritos se manejan en el frontend con JavaScript y LocalStorage
        // Solo pasamos la información de la tienda
        return view('tenant::favorites.index', compact('store'));
    }

    /**
     * API: Obtener detalles de productos favoritos por IDs
     */
    public function getProductsByIds(Request $request)
    {
        $store = view()->shared('currentStore');
        
        $validated = $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'integer'
        ]);

        $productIds = $validated['product_ids'];

        // Obtener productos activos que estén en la lista de favoritos
        $products = Product::where('store_id', $store->id)
            ->whereIn('id', $productIds)
            ->where('is_active', true)
            ->with(['mainImage', 'categories'])
            ->get();

        // Formatear respuesta
        $formattedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'price' => $product->price,
                'formatted_price' => '$' . number_format($product->price, 0, ',', '.'),
                'type' => $product->type,
                'image_url' => $product->main_image_url,
                'url' => route('tenant.product', [$product->store->slug, $product->slug]),
                'is_active' => $product->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $formattedProducts
        ]);
    }
}

