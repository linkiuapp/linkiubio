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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('proof_validation_status')->nullable()->after('cash_amount');
            $table->integer('proof_validation_score')->nullable()->after('proof_validation_status');
            $table->json('proof_validation_details')->nullable()->after('proof_validation_score');
            $table->timestamp('proof_validated_at')->nullable()->after('proof_validation_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'proof_validation_status',
                'proof_validation_score',
                'proof_validation_details',
                'proof_validated_at',
            ]);
        });
    }
};
