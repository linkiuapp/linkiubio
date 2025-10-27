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
        Schema::table('stores', function (Blueprint $table) {
            $table->text('master_key')->nullable()->after('slug')->comment('Clave maestra encriptada para acciones protegidas');
            $table->json('protected_actions')->nullable()->after('master_key')->comment('JSON de acciones que requieren clave maestra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['master_key', 'protected_actions']);
        });
    }
};
