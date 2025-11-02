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
        Schema::create('dine_in_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')
                  ->unique()
                  ->constrained('stores')
                  ->onDelete('cascade');
            
            // Activación del feature
            $table->boolean('is_enabled')->default(false);
            
            // Cargo de servicio
            $table->boolean('charge_service_fee')->default(false);
            $table->enum('service_fee_type', ['percentage', 'fixed'])
                  ->default('percentage');
            $table->integer('service_fee_percentage')->default(10)->comment('Porcentaje si es tipo percentage');
            $table->decimal('service_fee_fixed', 10, 2)->default(0)->comment('Monto fijo si es tipo fixed');
            
            // Propina sugerida
            $table->boolean('suggest_tip')->default(true);
            $table->json('tip_options')->nullable()->comment('Opciones de propina: [0, 10, 15, 20]');
            
            // Configuración adicional
            $table->boolean('allow_custom_tip')->default(true);
            $table->boolean('require_table_number')->default(true);
            
            $table->timestamps();
            
            // Índice
            $table->index('store_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dine_in_settings');
    }
};
