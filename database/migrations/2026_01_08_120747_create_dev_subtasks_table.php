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
        Schema::create('dev_subtasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('dev_tasks')->onDelete('cascade');
            $table->string('name'); // Nombre
            $table->boolean('is_completed')->default(false);
            $table->integer('order')->default(0); // Orden
            $table->timestamps();
            
            $table->index('task_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dev_subtasks');
    }
};
