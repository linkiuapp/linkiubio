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
        Schema::table('plans', function (Blueprint $table) {
            // ✅ Agregar columnas solo si NO existen
            if (!Schema::hasColumn('plans', 'max_variables')) {
                $table->integer('max_variables')->default(15)->after('max_categories')
                    ->comment('Máximo de variables por producto (tallas, colores, etc.)');
            }
            
            if (!Schema::hasColumn('plans', 'max_bank_accounts')) {
                $table->integer('max_bank_accounts')->default(2)->after('max_delivery_zones')
                    ->comment('Máximo de cuentas bancarias para recibir pagos');
            }
            
            if (!Schema::hasColumn('plans', 'analytics_retention_days')) {
                $table->integer('analytics_retention_days')->default(90)->after('support_response_time')
                    ->comment('Días de retención de datos de analíticas');
            }
        });

        // ❌ ELIMINAR columna solo si existe
        if (Schema::hasColumn('plans', 'max_active_promotions')) {
            Schema::table('plans', function (Blueprint $table) {
                $table->dropColumn('max_active_promotions');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn([
                'max_variables',
                'max_bank_accounts',
                'analytics_retention_days'
            ]);
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->integer('max_active_promotions')->default(1)->after('max_slider');
        });
    }
};

