<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Agrega índices compuestos para optimizar queries frecuentes:
     * - Dashboard: store_id + type + status + is_active
     * - Lookup: store_id + type + table_number
     * - Status queries: store_id + status
     */
    public function up(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            // Índice para queries del dashboard (filtrado por store, type, status, is_active)
            $table->index(['store_id', 'type', 'status', 'is_active'], 'idx_tables_dashboard');
            
            // Índice para búsqueda rápida de mesa por número (store + type + table_number)
            $table->index(['store_id', 'type', 'table_number'], 'idx_tables_lookup');
            
            // Índice para queries por estado (store + status)
            $table->index(['store_id', 'status'], 'idx_tables_status');
            
            // Índice para tenant_id (multi-tenant)
            if (!Schema::hasColumn('tables', 'tenant_id')) {
                // Si tenant_id no existe, no crear índice (se agregó en migración anterior)
            } else {
                $table->index('tenant_id', 'idx_tables_tenant');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropIndex('idx_tables_dashboard');
            $table->dropIndex('idx_tables_lookup');
            $table->dropIndex('idx_tables_status');
            
            if (Schema::hasColumn('tables', 'tenant_id')) {
                $table->dropIndex('idx_tables_tenant');
            }
        });
    }
};
