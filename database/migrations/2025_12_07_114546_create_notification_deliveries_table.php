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
        Schema::create('notification_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained('platform_announcements')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->enum('channel', ['whatsapp', 'email', 'in_app']);
            $table->enum('status', ['pending', 'sent', 'delivered', 'read', 'failed'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->unique(['announcement_id', 'store_id', 'channel']);
            $table->index(['announcement_id', 'status']);
            $table->index(['store_id', 'status']);
            $table->index('channel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_deliveries');
    }
};
