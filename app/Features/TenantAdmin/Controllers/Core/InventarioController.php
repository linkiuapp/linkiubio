<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Features\TenantAdmin\Services\StockService;
use App\Features\TenantAdmin\Models\MovimientoStock;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventarioController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * Dashboard de inventario
     */
    public function index(Request $request): View
    {
        $store = $request->route('store');

        // Obtener estadísticas
        $estadisticas = $this->stockService->obtenerEstadisticas($store->id);

        // Productos con stock bajo
        $productosStockBajo = $this->stockService->obtenerProductosStockBajo($store->id, 20);

        // Productos agotados
        $productosAgotados = $this->stockService->obtenerProductosAgotados($store->id, 20);

        // Movimientos recientes
        $productIds = \App\Features\TenantAdmin\Models\Product::where('store_id', $store->id)
            ->pluck('id');
        
        $movimientosRecientes = MovimientoStock::whereIn('product_id', $productIds)
            ->with(['producto.mainImage', 'creador'])
            ->recientes(30)
            ->get();

        return view('tenant-admin::Core.inventario.index', compact(
            'store',
            'estadisticas',
            'productosStockBajo',
            'productosAgotados',
            'movimientosRecientes'
        ));
    }
}

