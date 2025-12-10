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
        Schema::create('payment_proof_templates', function (Blueprint $table) {
            $table->id();
            $table->string('bank', 50); // nequi, bancolombia, daviplata, etc.
            $table->string('filename', 191); // Nombre del archivo de la plantilla
            $table->json('labels'); // Labels pre-calculados de AWS Rekognition
            $table->string('file_hash', 32)->unique(); // MD5 del archivo para detectar cambios
            $table->timestamps();
            
            $table->index('bank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_proof_templates');
    }
};
