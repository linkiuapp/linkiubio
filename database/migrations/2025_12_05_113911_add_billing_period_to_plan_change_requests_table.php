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
        Schema::table('plan_change_requests', function (Blueprint $table) {
            $table->string('requested_billing_period', 20)->nullable()->after('requested_plan_id')
                ->comment('Período de facturación solicitado: monthly, quarterly, semester, annual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_change_requests', function (Blueprint $table) {
            $table->dropColumn('requested_billing_period');
        });
    }
};
