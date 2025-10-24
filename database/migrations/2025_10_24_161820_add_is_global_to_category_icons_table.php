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
        Schema::table('category_icons', function (Blueprint $table) {
            $table->boolean('is_global')
                ->default(false)
                ->after('is_active')
                ->comment('Si es true, aparece en todas las categorías de negocio');
            
            // Índice para optimizar queries
            $table->index('is_global');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_icons', function (Blueprint $table) {
            $table->dropIndex(['is_global']);
            $table->dropColumn('is_global');
        });
    }
};
