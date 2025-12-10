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
        Schema::create('pending_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->string('billing_period', 20); // monthly, quarterly, semester, annual
            
            // Datos del negocio
            $table->foreignId('business_category_id')->constrained('business_categories')->onDelete('cascade');
            $table->string('business_name');
            $table->string('document_type', 10); // nit, cc, ce
            $table->string('document_number', 50);
            $table->string('phone', 20);
            $table->string('email');
            $table->string('city', 100);
            $table->string('department', 100);
            $table->string('address');
            $table->text('description')->nullable();
            
            // Datos de la tienda
            $table->string('store_name');
            $table->string('slug', 100)->unique();
            $table->text('store_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Datos del propietario
            $table->string('owner_name');
            $table->string('owner_email')->unique();
            $table->string('owner_document_type', 20);
            $table->string('owner_document_number', 50);
            $table->string('hashed_password');
            
            // Comprobante de pago
            $table->string('payment_proof')->nullable();
            
            // Estado y validación
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->json('validation_result')->nullable(); // Resultado del AI
            $table->text('rejected_reason')->nullable();
            
            // Auditoría
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('whatsapp_sent_at')->nullable();
            $table->foreignId('created_store_id')->nullable()->constrained('stores')->onDelete('set null');
            
            $table->timestamps();
            
            // Índices
            $table->index('status');
            $table->index(['status', 'created_at']);
            $table->index('owner_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_registrations');
    }
};

