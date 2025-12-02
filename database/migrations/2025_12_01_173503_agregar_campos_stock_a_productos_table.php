<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agregar campos de control de stock a productos
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Control de inventario
            $table->boolean('controla_stock')->default(false)->after('type');
            $table->enum('tipo_stock', ['ilimitado', 'limitado'])->default('ilimitado')->after('controla_stock');
            $table->unsignedInteger('cantidad_stock')->nullable()->after('tipo_stock');
            $table->unsignedInteger('umbral_alerta_stock')->default(1)->after('cantidad_stock');
            
            // Índices para optimización
            $table->index(['store_id', 'controla_stock', 'tipo_stock'], 'idx_productos_control_stock');
        });
    }

    /**
     * Revertir cambios
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_productos_control_stock');
            $table->dropColumn([
                'controla_stock',
                'tipo_stock',
                'cantidad_stock',
                'umbral_alerta_stock'
            ]);
        });
    }
};
