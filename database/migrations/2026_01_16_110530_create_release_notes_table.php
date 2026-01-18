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
        Schema::create('release_notes', function (Blueprint $table) {
            $table->id();
            $table->string('version', 20)->unique();
            $table->date('release_date');
            $table->boolean('is_current')->default(false);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['is_active', 'order']);
        });
        
        Schema::create('release_note_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('release_note_id')->constrained('release_notes')->onDelete('cascade');
            $table->enum('type', ['new', 'fix', 'improvement', 'deprecated'])->default('fix');
            $table->text('description');
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['release_note_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_note_items');
        Schema::dropIfExists('release_notes');
    }
};
