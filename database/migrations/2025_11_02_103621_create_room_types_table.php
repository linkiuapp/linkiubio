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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            
            // Información básica
            $table->string('name', 255); // "Suite Presidencial"
            $table->string('slug', 255)->nullable();
            $table->text('description')->nullable();
            
            // Capacidad
            $table->integer('max_occupancy')->default(2); // personas máximas
            $table->integer('base_occupancy')->default(2); // incluidas en precio base
            $table->integer('max_adults')->nullable(); // límite adultos (opcional)
            $table->integer('max_children')->nullable(); // límite niños (opcional)
            
            // Precio
            $table->decimal('base_price_per_night', 10, 2); // incluye base_occupancy personas
            $table->decimal('extra_person_price', 10, 2)->default(0); // precio por persona adicional
            
            // Servicios incluidos (JSON array)
            $table->json('amenities')->nullable();
            // Ejemplo: ["wifi", "tv", "ac", "minibar", "breakfast", "balcony"]
            
            // Servicios adicionales opcionales (JSON array)
            $table->json('additional_services')->nullable();
            // Ejemplo: [{"name":"Spa","price":50000},{"name":"Tour","price":30000}]
            
            // Imágenes (JSON array de URLs)
            $table->json('images')->nullable();
            
            // Estado
            $table->boolean('is_active')->default(true);
            
            // Orden de visualización
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            
            // Índices
            $table->index(['store_id', 'is_active']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
