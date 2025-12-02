<?php

namespace App\Features\TenantAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class StockVarianteProducto extends Model
{
    protected $table = 'stock_variantes_producto';

    protected $fillable = [
        'product_id',
        'combinacion_variables',
        'sku',
        'cantidad_stock',
        'cantidad_reservada',
        'umbral_alerta_stock',
        'is_active',
    ];

    protected $casts = [
        'combinacion_variables' => 'array',
        'cantidad_stock' => 'integer',
        'cantidad_reservada' => 'integer',
        'umbral_alerta_stock' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'cantidad_disponible',
        'tiene_stock_bajo',
        'esta_agotado',
    ];

    /**
     * Relación con el producto
     */
    public function producto()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relación con movimientos de stock
     */
    public function movimientos()
    {
        return $this->hasMany(MovimientoStock::class, 'stock_variante_id');
    }

    /**
     * Cantidad disponible (stock - reservado)
     */
    public function getCantidadDisponibleAttribute(): int
    {
        return max(0, $this->cantidad_stock - $this->cantidad_reservada);
    }

    /**
     * Tiene stock bajo
     */
    public function getTieneStockBajoAttribute(): bool
    {
        return $this->cantidad_disponible > 0 
            && $this->cantidad_disponible <= $this->umbral_alerta_stock;
    }

    /**
     * Está agotado
     */
    public function getEstaAgotadoAttribute(): bool
    {
        return $this->cantidad_disponible <= 0;
    }

    /**
     * Puede reservar cantidad
     */
    public function puedeReservar(int $cantidad): bool
    {
        return $this->cantidad_disponible >= $cantidad;
    }

    /**
     * Reservar stock
     */
    public function reservar(int $cantidad): bool
    {
        if (!$this->puedeReservar($cantidad)) {
            return false;
        }
        
        $this->increment('cantidad_reservada', $cantidad);
        return true;
    }

    /**
     * Liberar reserva
     */
    public function liberarReserva(int $cantidad): void
    {
        $this->decrement('cantidad_reservada', min($cantidad, $this->cantidad_reservada));
    }

    /**
     * Decrementar stock (al vender)
     */
    public function decrementarStock(int $cantidad, bool $liberarReserva = true): void
    {
        if ($liberarReserva) {
            $this->liberarReserva($cantidad);
        }
        $this->decrement('cantidad_stock', $cantidad);
    }

    /**
     * Incrementar stock (entrada de inventario)
     */
    public function incrementarStock(int $cantidad): void
    {
        $this->increment('cantidad_stock', $cantidad);
    }
}

