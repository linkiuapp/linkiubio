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
        Schema::create('registration_payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->default('Bancolombia');
            $table->string('account_type')->default('Ahorros');
            $table->string('account_number')->default('1234567890');
            $table->string('account_holder')->default('Linkiu S.A.S');
            $table->string('nit')->default('901234567-1');
            $table->string('qr_code_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Insertar configuración por defecto
        DB::table('registration_payment_settings')->insert([
            'bank_name' => 'Bancolombia',
            'account_type' => 'Ahorros',
            'account_number' => '1234567890',
            'account_holder' => 'Linkiu S.A.S',
            'nit' => '901234567-1',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_payment_settings');
    }
};

