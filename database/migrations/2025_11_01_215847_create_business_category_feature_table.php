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
        Schema::create('business_category_feature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_category_id')->constrained('business_categories')->onDelete('cascade');
            $table->foreignId('business_feature_id')->constrained('business_features')->onDelete('cascade');
            $table->timestamps();
            
            // Índices
            $table->unique(['business_category_id', 'business_feature_id'], 'category_feature_unique');
            $table->index('business_category_id');
            $table->index('business_feature_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_category_feature');
    }
};
