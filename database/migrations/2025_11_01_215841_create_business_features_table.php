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
        Schema::create('business_features', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Clave única del feature (ej: 'dashboard', 'reservas_mesas')
            $table->string('name'); // Nombre legible (ej: 'Dashboard', 'Reservas de Mesas')
            $table->string('area')->default('admin'); // admin, tenant, public
            $table->text('description')->nullable(); // Descripción del feature
            $table->boolean('is_default')->default(false); // Si es feature base para todas las categorías
            $table->integer('sort_order')->default(0); // Orden de visualización en menús
            $table->timestamps();
            
            // Índices
            $table->index('key');
            $table->index('is_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_features');
    }
};
