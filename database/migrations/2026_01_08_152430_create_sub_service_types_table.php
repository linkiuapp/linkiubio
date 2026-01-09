<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_service_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Dominio .com, Hosting Básico, etc.
            $table->string('category')->nullable(); // domain, hosting, email, ssl, other
            $table->text('description')->nullable();
            $table->decimal('default_price', 12, 2)->default(0);
            $table->string('currency', 3)->default('COP');
            $table->json('period_prices')->nullable(); // {"monthly": 50000, "quarterly": 140000, "annual": 500000}
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('category');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_service_types');
    }
};
