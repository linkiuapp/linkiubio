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
        Schema::table('personal_finance_debts', function (Blueprint $table) {
            $table->boolean('interest_included')->default(false)->after('interest_rate')->comment('Si el interés ya está incluido en el monto total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_finance_debts', function (Blueprint $table) {
            $table->dropColumn('interest_included');
        });
    }
};
