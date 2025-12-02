<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear tabla para historial de movimientos de stock
     */
    public function up(): void
    {
        Schema::create('movimientos_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('stock_variante_id')->nullable()->constrained('stock_variantes_producto')->onDelete('cascade');
            
            // Tipo de movimiento
            $table->enum('tipo', [
                'entrada',      // Entrada de inventario
                'salida',       // Salida manual
                'ajuste',       // Ajuste de inventario
                'venta',        // Venta confirmada
                'devolucion',   // Devolución de cliente
                'reserva',      // Reserva en carrito
                'liberacion'    // Liberar reserva
            ]);
            
            // Cantidades
            $table->integer('cantidad');
            $table->integer('cantidad_antes');
            $table->integer('cantidad_despues');
            
            // Referencias
            $table->string('tipo_referencia', 100)->nullable();
            $table->unsignedBigInteger('id_referencia')->nullable();
            $table->text('notas')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
            
            // Índices
            $table->index(['product_id', 'created_at']);
            $table->index('stock_variante_id');
            $table->index('tipo');
            $table->index(['tipo_referencia', 'id_referencia']);
        });
    }

    /**
     * Revertir cambios
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_stock');
    }
};
