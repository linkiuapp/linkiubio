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
            // Cambiar campos de URL de string a text para soportar URLs largas
            $table->text('url')->nullable()->change();
            $table->text('dashboard_url')->nullable()->change();
            $table->text('api_docs_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('linkiu_tools', function (Blueprint $table) {
            // Revertir a string (VARCHAR 255)
            $table->string('url')->nullable()->change();
            $table->string('dashboard_url')->nullable()->change();
            $table->string('api_docs_url')->nullable()->change();
        });
    }
};
