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
        Schema::table('hotel_reservations', function (Blueprint $table) {
            $table->string('guest_document_type', 10)->nullable()->after('guest_email'); // CC, CE, PA, TI, NIT
            $table->string('guest_city', 255)->nullable()->after('guest_document');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_reservations', function (Blueprint $table) {
            $table->dropColumn(['guest_document_type', 'guest_city']);
        });
    }
};
