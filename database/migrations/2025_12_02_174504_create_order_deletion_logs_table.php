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
        Schema::create('order_deletion_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('order_number');
            $table->unsignedBigInteger('store_id');
            $table->string('store_name');
            $table->string('customer_name')->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->string('status')->nullable();
            $table->json('order_data');
            $table->unsignedBigInteger('deleted_by');
            $table->text('reason');
            $table->timestamps();
            
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['store_id', 'order_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_deletion_logs');
    }
};
