<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Agrega tenant_id a las tablas tables y dine_in_settings
     * y sincroniza los valores con store_id para mantener compatibilidad
     */
    public function up(): void
    {
        // Agregar tenant_id a tables
        Schema::table('tables', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('store_id');
            $table->index('tenant_id');
        });
        
        // Sincronizar tenant_id con store_id en tables
        DB::statement('UPDATE tables SET tenant_id = store_id WHERE tenant_id IS NULL');
        
        // Agregar tenant_id a dine_in_settings
        Schema::table('dine_in_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('store_id');
            $table->index('tenant_id');
        });
        
        // Sincronizar tenant_id con store_id en dine_in_settings
        DB::statement('UPDATE dine_in_settings SET tenant_id = store_id WHERE tenant_id IS NULL');
        
        // Hacer tenant_id NOT NULL después de sincronizar
        Schema::table('tables', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable(false)->change();
        });
        
        Schema::table('dine_in_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
        
        Schema::table('dine_in_settings', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};
