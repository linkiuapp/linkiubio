<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Agregar índice compuesto para optimizar queries del dashboard
     * Mejora performance en ~20ms para queries con:
     * - WHERE store_id = ?
     * - AND status IN (...)
     * - ORDER BY created_at DESC
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Índice compuesto optimizado para dashboard
            // Orden: store_id, status, created_at (de más selectivo a menos selectivo)
            $table->index(['store_id', 'status', 'created_at'], 'idx_orders_dashboard');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_dashboard');
        });
    }
};
