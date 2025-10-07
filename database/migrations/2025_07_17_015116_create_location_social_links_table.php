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
        Schema::create('location_social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('store_locations')->onDelete('cascade');
            $table->enum('platform', ['instagram', 'facebook', 'tiktok', 'youtube', 'whatsapp', 'linkiu']);
            $table->string('url', 500);
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['location_id', 'platform']);
            
            // Unique constraint for platform per location
            $table->unique(['location_id', 'platform']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_social_links');
    }
};