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
        Schema::table('billing_settings', function (Blueprint $table) {
            $table->string('app_logo')->nullable()->after('logo_url')->comment('Logo de la aplicación (sidebar)');
            $table->string('app_favicon')->nullable()->after('app_logo')->comment('Favicon de la aplicación');
            $table->string('app_name')->nullable()->after('app_favicon')->comment('Nombre de la aplicación');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billing_settings', function (Blueprint $table) {
            $table->dropColumn(['app_logo', 'app_favicon', 'app_name']);
        });
    }
};
