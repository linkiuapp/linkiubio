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
        Schema::create('tickers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('text', 100);
            $table->string('emoji', 10)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            // Configuración global (se guarda en el primer registro o en una tabla separada)
            // Por simplicidad, guardamos en cada registro pero solo usamos el primero
            $table->string('background_color', 20)->default('#1e293b');
            $table->string('text_color', 20)->default('#ffffff');
            $table->enum('scroll_speed', ['slow', 'medium', 'fast'])->default('medium');
            $table->timestamps();

            // Índices
            $table->index(['store_id', 'is_active']);
            $table->index(['store_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickers');
    }
};
