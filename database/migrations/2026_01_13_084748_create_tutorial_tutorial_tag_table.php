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
        Schema::create('tutorial_tutorial_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutorial_id')->constrained('tutorials')->onDelete('cascade');
            $table->foreignId('tutorial_tag_id')->constrained('tutorial_tags')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['tutorial_id', 'tutorial_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorial_tutorial_tag');
    }
};
