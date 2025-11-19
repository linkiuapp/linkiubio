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
        Schema::table('business_categories', function (Blueprint $table) {
            $table->enum('vertical', ['ecommerce', 'restaurant', 'hotel', 'dropshipping'])
                  ->nullable()
                  ->after('description')
                  ->comment('Vertical principal de la categoría (ecommerce, restaurant, hotel, dropshipping)');
            
            // Índice para búsquedas rápidas por vertical
            $table->index('vertical');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_categories', function (Blueprint $table) {
            $table->dropIndex(['vertical']);
            $table->dropColumn('vertical');
        });
    }
};
