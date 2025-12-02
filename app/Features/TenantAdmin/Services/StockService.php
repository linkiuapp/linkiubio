<?php

namespace App\Features\TenantAdmin\Services;

use App\Features\TenantAdmin\Models\Product;
use App\Features\TenantAdmin\Models\StockVarianteProducto;
use App\Features\TenantAdmin\Models\MovimientoStock;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Verificar disponibilidad de producto
     * 
     * @param Product $producto
     * @param array $opcionesSeleccionadas ['variable_id' => 'option_id']
     * @param int $cantidad
     * @return array ['disponible' => bool, 'cantidad' => int, 'error' => string|null]
     */
    public function verificarDisponibilidad(Product $producto, array $opcionesSeleccionadas = [], int $cantidad = 1): array
    {
        // Sin control de stock
        if (!$producto->controlaStock()) {
            return ['disponible' => true, 'cantidad' => PHP_INT_MAX];
        }

        // Stock ilimitado
        if ($producto->tieneStockIlimitado()) {
            return ['disponible' => true, 'cantidad' => PHP_INT_MAX];
        }

        // Producto simple
        if ($producto->isSimple()) {
            $disponible = $producto->cantidad_stock ?? 0;
            return [
                'disponible' => $disponible >= $cantidad,
                'cantidad' => $disponible,
            ];
        }

        // Producto variable
        $stockVariante = $this->buscarStockVariante($producto->id, $opcionesSeleccionadas);
        
        if (!$stockVariante) {
            return [
                'disponible' => false, 
                'cantidad' => 0, 
                'error' => 'Esta combinación no está disponible'
            ];
        }

        if (!$stockVariante->is_active) {
            return [
                'disponible' => false, 
                'cantidad' => 0, 
                'error' => 'Esta variante no está activa'
            ];
        }

        return [
            'disponible' => $stockVariante->cantidad_disponible >= $cantidad,
            'cantidad' => $stockVariante->cantidad_disponible,
        ];
    }

    /**
     * Reservar stock (al agregar al carrito)
     * 
     * @param Product $producto
     * @param array $opcionesSeleccionadas
     * @param int $cantidad
     * @return bool
     */
    public function reservar(Product $producto, array $opcionesSeleccionadas, int $cantidad): bool
    {
        if (!$producto->controlaStock() || $producto->tieneStockIlimitado()) {
            return true;
        }

        return DB::transaction(function () use ($producto, $opcionesSeleccionadas, $cantidad) {
            if ($producto->isSimple()) {
                // Para productos simples, solo validamos disponibilidad
                // (no tenemos campo reserved_quantity en products)
                return $producto->cantidad_stock >= $cantidad;
            }

            // Producto variable
            $stockVariante = $this->buscarStockVariante($producto->id, $opcionesSeleccionadas);
            
            if (!$stockVariante || $stockVariante->cantidad_disponible < $cantidad) {
                return false;
            }

            // Incrementar cantidad reservada
            $cantidadAntes = $stockVariante->cantidad_stock - $stockVariante->cantidad_reservada;
            $stockVariante->reservar($cantidad);

            // Registrar movimiento
            $this->crearMovimiento(
                $producto->id,
                $stockVariante->id,
                MovimientoStock::TIPO_RESERVA,
                -$cantidad,
                $cantidadAntes,
                $stockVariante->cantidad_stock - $stockVariante->cantidad_reservada
            );

            return true;
        });
    }

    /**
     * Liberar reserva (al eliminar del carrito)
     * 
     * @param Product $producto
     * @param array $opcionesSeleccionadas
     * @param int $cantidad
     * @return void
     */
    public function liberarReserva(Product $producto, array $opcionesSeleccionadas, int $cantidad): void
    {
        if (!$producto->controlaStock() || $producto->tieneStockIlimitado()) {
            return;
        }

        DB::transaction(function () use ($producto, $opcionesSeleccionadas, $cantidad) {
            if ($producto->isSimple()) {
                return;
            }

            $stockVariante = $this->buscarStockVariante($producto->id, $opcionesSeleccionadas);
            if (!$stockVariante) {
                return;
            }

            $cantidadAntes = $stockVariante->cantidad_stock - $stockVariante->cantidad_reservada;
            $stockVariante->liberarReserva($cantidad);

            // Registrar movimiento
            $this->crearMovimiento(
                $producto->id,
                $stockVariante->id,
                MovimientoStock::TIPO_LIBERACION,
                $cantidad,
                $cantidadAntes,
                $stockVariante->cantidad_stock - $stockVariante->cantidad_reservada
            );
        });
    }

    /**
     * Decrementar stock (al confirmar venta)
     * 
     * @param Product $producto
     * @param array $opcionesSeleccionadas
     * @param int $cantidad
     * @param int|null $ordenId
     * @return bool
     */
    public function decrementarStock(Product $producto, array $opcionesSeleccionadas, int $cantidad, ?int $ordenId = null): bool
    {
        if (!$producto->controlaStock() || $producto->tieneStockIlimitado()) {
            return true;
        }

        return DB::transaction(function () use ($producto, $opcionesSeleccionadas, $cantidad, $ordenId) {
            if ($producto->isSimple()) {
                $cantidadAntes = $producto->cantidad_stock;
                $producto->decrement('cantidad_stock', $cantidad);

                $this->crearMovimiento(
                    $producto->id,
                    null,
                    MovimientoStock::TIPO_VENTA,
                    -$cantidad,
                    $cantidadAntes,
                    $producto->cantidad_stock,
                    'Order',
                    $ordenId
                );

                return true;
            }

            // Producto variable
            $stockVariante = $this->buscarStockVariante($producto->id, $opcionesSeleccionadas);
            if (!$stockVariante) {
                return false;
            }

            $cantidadAntes = $stockVariante->cantidad_stock;
            $stockVariante->decrementarStock($cantidad, true);

            $this->crearMovimiento(
                $producto->id,
                $stockVariante->id,
                MovimientoStock::TIPO_VENTA,
                -$cantidad,
                $cantidadAntes,
                $stockVariante->cantidad_stock,
                'Order',
                $ordenId
            );

            return true;
        });
    }

    /**
     * Incrementar stock (entrada de inventario)
     * 
     * @param Product $producto
     * @param array $opcionesSeleccionadas
     * @param int $cantidad
     * @param string|null $notas
     * @return void
     */
    public function incrementarStock(Product $producto, array $opcionesSeleccionadas, int $cantidad, ?string $notas = null): void
    {
        DB::transaction(function () use ($producto, $opcionesSeleccionadas, $cantidad, $notas) {
            if ($producto->isSimple()) {
                $cantidadAntes = $producto->cantidad_stock;
                $producto->increment('cantidad_stock', $cantidad);

                $this->crearMovimiento(
                    $producto->id,
                    null,
                    MovimientoStock::TIPO_ENTRADA,
                    $cantidad,
                    $cantidadAntes,
                    $producto->cantidad_stock,
                    null,
                    null,
                    $notas
                );

                return;
            }

            // Producto variable
            $stockVariante = $this->buscarStockVariante($producto->id, $opcionesSeleccionadas);
            if ($stockVariante) {
                $cantidadAntes = $stockVariante->cantidad_stock;
                $stockVariante->incrementarStock($cantidad);

                $this->crearMovimiento(
                    $producto->id,
                    $stockVariante->id,
                    MovimientoStock::TIPO_ENTRADA,
                    $cantidad,
                    $cantidadAntes,
                    $stockVariante->cantidad_stock,
                    null,
                    null,
                    $notas
                );
            }
        });
    }

    /**
     * Ajustar stock (corrección manual)
     * 
     * @param Product $producto
     * @param array $opcionesSeleccionadas
     * @param int $nuevaCantidad
     * @param string|null $notas
     * @return void
     */
    public function ajustarStock(Product $producto, array $opcionesSeleccionadas, int $nuevaCantidad, ?string $notas = null): void
    {
        DB::transaction(function () use ($producto, $opcionesSeleccionadas, $nuevaCantidad, $notas) {
            if ($producto->isSimple()) {
                $cantidadAntes = $producto->cantidad_stock;
                $diferencia = $nuevaCantidad - $cantidadAntes;
                $producto->cantidad_stock = $nuevaCantidad;
                $producto->save();

                $this->crearMovimiento(
                    $producto->id,
                    null,
                    MovimientoStock::TIPO_AJUSTE,
                    $diferencia,
                    $cantidadAntes,
                    $nuevaCantidad,
                    null,
                    null,
                    $notas
                );

                return;
            }

            // Producto variable
            $stockVariante = $this->buscarStockVariante($producto->id, $opcionesSeleccionadas);
            if ($stockVariante) {
                $cantidadAntes = $stockVariante->cantidad_stock;
                $diferencia = $nuevaCantidad - $cantidadAntes;
                $stockVariante->cantidad_stock = $nuevaCantidad;
                $stockVariante->save();

                $this->crearMovimiento(
                    $producto->id,
                    $stockVariante->id,
                    MovimientoStock::TIPO_AJUSTE,
                    $diferencia,
                    $cantidadAntes,
                    $nuevaCantidad,
                    null,
                    null,
                    $notas
                );
            }
        });
    }

    /**
     * Buscar stock de variante específica por combinación de opciones
     * 
     * @param int $productoId
     * @param array $opcionesSeleccionadas
     * @return StockVarianteProducto|null
     */
    protected function buscarStockVariante(int $productoId, array $opcionesSeleccionadas): ?StockVarianteProducto
    {
        return StockVarianteProducto::where('product_id', $productoId)
            ->where('is_active', true)
            ->get()
            ->first(function ($stock) use ($opcionesSeleccionadas) {
                $combinacion = $stock->combinacion_variables;
                
                // Verificar que todas las opciones coincidan
                foreach ($opcionesSeleccionadas as $varId => $optId) {
                    if (!isset($combinacion[$varId]) || $combinacion[$varId] != $optId) {
                        return false;
                    }
                }
                
                return true;
            });
    }

    /**
     * Crear movimiento de stock
     * 
     * @param int $productoId
     * @param int|null $stockVarianteId
     * @param string $tipo
     * @param int $cantidad
     * @param int $cantidadAntes
     * @param int $cantidadDespues
     * @param string|null $tipoReferencia
     * @param int|null $idReferencia
     * @param string|null $notas
     * @return void
     */
    protected function crearMovimiento(
        int $productoId,
        ?int $stockVarianteId,
        string $tipo,
        int $cantidad,
        int $cantidadAntes,
        int $cantidadDespues,
        ?string $tipoReferencia = null,
        ?int $idReferencia = null,
        ?string $notas = null
    ): void {
        MovimientoStock::create([
            'product_id' => $productoId,
            'stock_variante_id' => $stockVarianteId,
            'tipo' => $tipo,
            'cantidad' => $cantidad,
            'cantidad_antes' => $cantidadAntes,
            'cantidad_despues' => $cantidadDespues,
            'tipo_referencia' => $tipoReferencia,
            'id_referencia' => $idReferencia,
            'notas' => $notas,
            'created_by' => auth()->id(),
        ]);
    }

    /**
     * Obtener productos con stock bajo
     * 
     * @param int $tiendaId
     * @param int $limite
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerProductosStockBajo(int $tiendaId, int $limite = 50)
    {
        $productos = Product::where('store_id', $tiendaId)
            ->where('controla_stock', true)
            ->where('tipo_stock', 'limitado')
            ->with(['mainImage', 'stocksVariantes'])
            ->get();

        return $productos->filter(function ($producto) {
            $stockTotal = $this->obtenerStockTotal($producto);
            $umbral = $producto->umbral_alerta_stock ?? 1;
            
            return $stockTotal > 0 && $stockTotal <= $umbral;
        })->take($limite);
    }

    /**
     * Obtener productos agotados
     * 
     * @param int $tiendaId
     * @param int $limite
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerProductosAgotados(int $tiendaId, int $limite = 50)
    {
        $productos = Product::where('store_id', $tiendaId)
            ->where('controla_stock', true)
            ->where('tipo_stock', 'limitado')
            ->with(['mainImage', 'stocksVariantes'])
            ->get();

        return $productos->filter(function ($producto) {
            $stockTotal = $this->obtenerStockTotal($producto);
            return $stockTotal <= 0;
        })->take($limite);
    }

    /**
     * Obtener estadísticas de inventario
     * 
     * @param int $tiendaId
     * @return array
     */
    public function obtenerEstadisticas(int $tiendaId): array
    {
        $productos = Product::where('store_id', $tiendaId)
            ->where('controla_stock', true)
            ->where('tipo_stock', 'limitado')
            ->with('stocksVariantes')
            ->get();

        $total = $productos->count();
        $enStock = 0;
        $stockBajo = 0;
        $agotados = 0;
        $totalUnidades = 0;

        foreach ($productos as $producto) {
            $stock = $this->obtenerStockTotal($producto);
            $umbral = $producto->umbral_alerta_stock ?? 1;
            
            $totalUnidades += $stock;
            
            if ($stock <= 0) {
                $agotados++;
            } elseif ($stock <= $umbral) {
                $stockBajo++;
            } else {
                $enStock++;
            }
        }

        return [
            'total' => $total,
            'en_stock' => $enStock,
            'stock_bajo' => $stockBajo,
            'agotados' => $agotados,
            'total_unidades' => $totalUnidades,
        ];
    }

    /**
     * Obtener stock total de un producto (simples o variables)
     * 
     * @param Product $producto
     * @return int
     */
    protected function obtenerStockTotal(Product $producto): int
    {
        // Producto simple
        if ($producto->type === 'simple') {
            return $producto->cantidad_stock ?? 0;
        }

        // Producto variable: sumar stock de todas las variantes
        return $producto->stocksVariantes->sum('cantidad_stock');
    }
}

