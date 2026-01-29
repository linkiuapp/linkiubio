<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_finance_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('token', 64)->unique();
            $table->string('short_code', 8)->unique()->comment('Código corto para URL');
            $table->string('name')->nullable()->comment('Nombre descriptivo del token');
            $table->timestamp('expires_at')->nullable();
            $table->integer('usage_count')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['token', 'is_active']);
            $table->index(['short_code', 'is_active']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_finance_access_tokens');
    }
};
