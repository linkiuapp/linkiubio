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
        Schema::table('products', function (Blueprint $table) {
            // Campos para productos bajo pedido
            $table->boolean('is_made_to_order')->default(false)->after('is_active');
            $table->unsignedSmallInteger('preparation_days')->nullable()->after('is_made_to_order');
            $table->boolean('requires_deposit')->default(false)->after('preparation_days');
            $table->enum('deposit_type', ['percentage', 'fixed'])->nullable()->after('requires_deposit');
            $table->decimal('deposit_value', 10, 2)->nullable()->after('deposit_type');
            
            // Índice para filtrar productos bajo pedido
            $table->index(['store_id', 'is_made_to_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['store_id', 'is_made_to_order']);
            $table->dropColumn([
                'is_made_to_order',
                'preparation_days',
                'requires_deposit',
                'deposit_type',
                'deposit_value',
            ]);
        });
    }
};
