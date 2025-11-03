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
        Schema::table('hotel_settings', function (Blueprint $table) {
            // Políticas de niños
            $table->integer('children_free_max_age')->default(2)->after('min_guest_age'); // Hasta qué edad son gratis (0-2 años)
            $table->integer('children_discounted_max_age')->default(11)->after('children_free_max_age'); // Hasta qué edad tienen descuento (3-11 años)
            $table->integer('children_discount_percentage')->default(50)->after('children_discounted_max_age'); // % de descuento para niños con tarifa reducida
            $table->boolean('charge_children_by_occupancy')->default(true)->after('children_discount_percentage'); // Si los niños cuentan en ocupación base para cargo extra
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_settings', function (Blueprint $table) {
            $table->dropColumn([
                'children_free_max_age',
                'children_discounted_max_age',
                'children_discount_percentage',
                'charge_children_by_occupancy'
            ]);
        });
    }
};
