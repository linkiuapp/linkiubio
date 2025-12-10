<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('stock_variantes_productos');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recrear la tabla si se hace rollback
        Schema::create('stock_variantes_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->json('combinacion_variables');
            $table->string('sku')->unique();
            $table->integer('cantidad_stock')->default(0);
            $table->integer('cantidad_reservada')->default(0);
            $table->integer('umbral_alerta_stock')->default(1);
            $table->timestamps();
            
            $table->index('product_id');
            $table->index('sku');
        });
    }
};
