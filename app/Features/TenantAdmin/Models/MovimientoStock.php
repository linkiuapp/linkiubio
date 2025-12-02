<?php

namespace App\Features\TenantAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Models\User;

class MovimientoStock extends Model
{
    protected $table = 'movimientos_stock';

    const UPDATED_AT = null; // Solo created_at

    // Tipos de movimiento
    const TIPO_ENTRADA = 'entrada';
    const TIPO_SALIDA = 'salida';
    const TIPO_AJUSTE = 'ajuste';
    const TIPO_VENTA = 'venta';
    const TIPO_DEVOLUCION = 'devolucion';
    const TIPO_RESERVA = 'reserva';
    const TIPO_LIBERACION = 'liberacion';

    protected $fillable = [
        'product_id',
        'stock_variante_id',
        'tipo',
        'cantidad',
        'cantidad_antes',
        'cantidad_despues',
        'tipo_referencia',
        'id_referencia',
        'notas',
        'created_by',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'cantidad_antes' => 'integer',
        'cantidad_despues' => 'integer',
    ];

    /**
     * Relación con el producto
     */
    public function producto()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relación con stock de variante
     */
    public function stockVariante()
    {
        return $this->belongsTo(StockVarianteProducto::class, 'stock_variante_id');
    }

    /**
     * Relación con usuario que creó el movimiento
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope para movimientos de un producto
     */
    public function scopeDeProducto($query, int $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope para movimientos por tipo
     */
    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para movimientos recientes
     */
    public function scopeRecientes($query, int $limite = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limite);
    }
}

