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
        Schema::table('orders', function (Blueprint $table) {
            // Tipo de orden (delivery, pickup, dine_in, room_service)
            $table->enum('order_type', ['delivery', 'pickup', 'dine_in', 'room_service'])
                  ->default('delivery')
                  ->after('delivery_type');
            
            // Número de mesa (para restaurantes)
            $table->string('table_number', 50)
                  ->nullable()
                  ->after('order_type');
            
            // Número de habitación (para hoteles)
            $table->string('room_number', 50)
                  ->nullable()
                  ->after('table_number');
            
            // Cargo de servicio
            $table->decimal('service_charge', 10, 2)
                  ->default(0)
                  ->after('coupon_discount');
            
            // Propina
            $table->decimal('tip_amount', 10, 2)
                  ->default(0)
                  ->after('service_charge');
            
            // Porcentaje de propina seleccionado
            $table->integer('tip_percentage')
                  ->nullable()
                  ->after('tip_amount')
                  ->comment('Porcentaje de propina: 0, 10, 15, 20, o NULL si personalizada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_type',
                'table_number',
                'room_number',
                'service_charge',
                'tip_amount',
                'tip_percentage'
            ]);
        });
    }
};
