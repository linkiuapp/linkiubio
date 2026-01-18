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
        Schema::table('ui_images', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->string('url')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ui_images', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->text('description')->nullable()->after('name');
        });
    }
};
