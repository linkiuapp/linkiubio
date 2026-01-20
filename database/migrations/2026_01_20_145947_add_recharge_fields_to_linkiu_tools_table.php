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
        Schema::table('linkiu_tools', function (Blueprint $table) {
            $table->decimal('minimum_recharge', 10, 2)->nullable()->after('yearly_cost'); // Monto mínimo de recarga recomendado
            $table->decimal('current_balance', 10, 2)->nullable()->after('minimum_recharge'); // Saldo actual (opcional)
            $table->string('balance_currency', 3)->nullable()->after('current_balance'); // Moneda del saldo (por defecto igual a currency)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('linkiu_tools', function (Blueprint $table) {
            $table->dropColumn(['minimum_recharge', 'current_balance', 'balance_currency']);
        });
    }
};
