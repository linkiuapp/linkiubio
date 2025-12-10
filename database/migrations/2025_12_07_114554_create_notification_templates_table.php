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
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // maintenance, feature, promotion, payment_reminder
            $table->text('subject')->nullable(); // Para email
            $table->text('content'); // Contenido base
            $table->text('whatsapp_template')->nullable(); // Template para WhatsApp
            $table->text('banner_html')->nullable(); // HTML del banner
            $table->string('banner_background_color', 7)->default('#667eea');
            $table->string('banner_text_color', 7)->default('#ffffff');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
