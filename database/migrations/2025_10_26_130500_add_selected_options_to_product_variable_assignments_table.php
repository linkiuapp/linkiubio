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
        Schema::table('product_variable_assignments', function (Blueprint $table) {
            // Agregar campo JSON para almacenar las opciones seleccionadas
            $table->json('selected_options')->nullable()->after('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variable_assignments', function (Blueprint $table) {
            $table->dropColumn('selected_options');
        });
    }
};
