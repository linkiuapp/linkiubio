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
        // ✅ Evaluar ANTES del closure para que funcione correctamente
        $hasMaxVariables = Schema::hasColumn('plans', 'max_variables');
        $hasMaxBankAccounts = Schema::hasColumn('plans', 'max_bank_accounts');
        $hasAnalyticsRetention = Schema::hasColumn('plans', 'analytics_retention_days');
        $hasMaxActivePromotions = Schema::hasColumn('plans', 'max_active_promotions');

        Schema::table('plans', function (Blueprint $table) use ($hasMaxVariables, $hasMaxBankAccounts, $hasAnalyticsRetention) {
            // Agregar columnas solo si NO existen
            if (!$hasMaxVariables) {
                $table->integer('max_variables')->default(15)->after('max_categories')
                    ->comment('Máximo de variables por producto (tallas, colores, etc.)');
            }
            
            if (!$hasMaxBankAccounts) {
                $table->integer('max_bank_accounts')->default(2)->after('max_delivery_zones')
                    ->comment('Máximo de cuentas bancarias para recibir pagos');
            }
            
            if (!$hasAnalyticsRetention) {
                $table->integer('analytics_retention_days')->default(90)->after('support_response_time')
                    ->comment('Días de retención de datos de analíticas');
            }
        });

        // Eliminar columna solo si existe
        if ($hasMaxActivePromotions) {
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

