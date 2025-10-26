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
        Schema::create('store_onboarding_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->string('step_key'); // design, slider, locations, payments, shipping, categories, variables, products
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // Índice único para evitar duplicados
            $table->unique(['store_id', 'step_key']);
            
            // Índice para búsquedas rápidas
            $table->index('store_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_onboarding_steps');
    }
};
