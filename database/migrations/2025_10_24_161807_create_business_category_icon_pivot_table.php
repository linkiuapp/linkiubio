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
        Schema::create('business_category_icon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_category_id')
                ->constrained('business_categories')
                ->onDelete('cascade');
            $table->foreignId('category_icon_id')
                ->constrained('category_icons')
                ->onDelete('cascade');
            $table->integer('sort_order')->default(0)->comment('Orden dentro de la categoría específica');
            $table->timestamps();
            
            // Evitar duplicados
            $table->unique(['business_category_id', 'category_icon_id'], 'bc_icon_unique');
            
            // Índices para optimizar queries
            $table->index('business_category_id');
            $table->index('category_icon_id');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_category_icon');
    }
};
