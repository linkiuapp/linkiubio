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
        Schema::table('platform_announcements', function (Blueprint $table) {
            $table->text('banner_html')->nullable()->after('banner_image');
            $table->string('banner_background_color', 7)->default('#667eea')->after('banner_html');
            $table->string('banner_text_color', 7)->default('#ffffff')->after('banner_background_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('platform_announcements', function (Blueprint $table) {
            $table->dropColumn(['banner_html', 'banner_background_color', 'banner_text_color']);
        });
    }
};
