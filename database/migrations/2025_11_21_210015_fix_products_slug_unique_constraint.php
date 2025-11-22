<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Cambia la restricción de slug único globalmente a único por tienda (store_id)
     * Esto permite que diferentes tiendas puedan tener productos con el mismo slug
     * pero mantiene la unicidad dentro de cada tienda.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Eliminar el índice único global del slug
            $table->dropUnique(['slug']);
            
            // Agregar índice único compuesto por store_id y slug
            // Esto permite que diferentes tiendas tengan el mismo slug
            // pero mantiene la unicidad dentro de cada tienda
            $table->unique(['store_id', 'slug'], 'products_store_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Eliminar el índice único compuesto
            $table->dropUnique('products_store_slug_unique');
            
            // Restaurar el índice único global del slug
            $table->unique('slug');
        });
    }
};
