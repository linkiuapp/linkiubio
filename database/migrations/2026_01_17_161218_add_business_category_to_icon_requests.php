<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('icon_requests', function (Blueprint $table) {
            $table->foreignId('business_category_id')->nullable()
                ->after('store_id')
                ->constrained('business_categories')
                ->nullOnDelete()
                ->comment('Categoría del negocio para saber dónde subir el ícono');
        });
    }

    public function down(): void
    {
        Schema::table('icon_requests', function (Blueprint $table) {
            $table->dropForeign(['business_category_id']);
            $table->dropColumn('business_category_id');
        });
    }
};
