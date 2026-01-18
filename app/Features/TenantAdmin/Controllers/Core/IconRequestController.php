<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\IconRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IconRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'reference_image' => 'required|image|max:5120', // 5MB
        ]);

        $store = $request->user()->store;

        // Subir imagen de referencia
        $imagePath = $request->file('reference_image')->store(
            "icon-requests/{$store->id}",
            'public'
        );

        $iconRequest = IconRequest::create([
            'store_id' => $store->id,
            'business_category_id' => $store->business_category_id,
            'category_name' => $request->category_name,
            'description' => $request->description,
            'reference_image_path' => $imagePath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Solicitud enviada! Revisaremos tu petición pronto.',
            'request' => $iconRequest,
        ]);
    }

    public function index(Request $request)
    {
        $store = $request->user()->store;

        $requests = IconRequest::where('store_id', $store->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'requests' => $requests,
        ]);
    }
}
