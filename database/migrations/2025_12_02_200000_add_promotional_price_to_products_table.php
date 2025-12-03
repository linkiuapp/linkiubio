<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('precio_promocional', 10, 2)->nullable()->after('price');
            $table->boolean('promocion_activa')->default(false)->after('precio_promocional');
            $table->date('promocion_fecha_inicio')->nullable()->after('promocion_activa');
            $table->date('promocion_fecha_fin')->nullable()->after('promocion_fecha_inicio');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'precio_promocional',
                'promocion_activa',
                'promocion_fecha_inicio',
                'promocion_fecha_fin'
            ]);
        });
    }
};

