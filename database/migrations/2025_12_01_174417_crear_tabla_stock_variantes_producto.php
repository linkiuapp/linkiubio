<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear tabla para stock por variante de producto
     */
    public function up(): void
    {
        Schema::create('stock_variantes_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Combinación de variable_id => option_id
            // Ejemplo: {"1": 5, "2": 8} (Talla 38 + Negro)
            $table->json('combinacion_variables');
            
            // SKU único para esta variante
            $table->string('sku')->unique();
            
            // Cantidades
            $table->unsignedInteger('cantidad_stock')->default(0);
            $table->unsignedInteger('cantidad_reservada')->default(0);
            
            // Configuración
            $table->unsignedInteger('umbral_alerta_stock')->default(1);
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Índices
            $table->index(['product_id', 'is_active'], 'idx_producto_activo');
            $table->index('sku');
        });
    }

    /**
     * Revertir cambios
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_variantes_producto');
    }
};
