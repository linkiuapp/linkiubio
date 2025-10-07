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
        Schema::table('email_configurations', function (Blueprint $table) {
            // Dominio verificado en SendGrid
            $table->string('verified_domain')->nullable()->after('from_name')->comment('Dominio verificado en SendGrid');
            
            // Emails por categoría
            $table->string('sender_store_management')->default('tiendas@linkiu.email')->after('verified_domain')->comment('Email para gestión de tiendas');
            $table->string('sender_tickets')->default('soporte@linkiu.email')->after('sender_store_management')->comment('Email para tickets');
            $table->string('sender_billing')->default('facturas@linkiu.email')->after('sender_tickets')->comment('Email para facturación');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_configurations', function (Blueprint $table) {
            $table->dropColumn([
                'verified_domain',
                'sender_store_management',
                'sender_tickets',
                'sender_billing'
            ]);
        });
    }
};
