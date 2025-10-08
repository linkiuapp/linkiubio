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
        Schema::table('plans', function (Blueprint $table) {
            // ✅ Renombrar max_sliders → max_slider (si existe el antiguo)
            if (Schema::hasColumn('plans', 'max_sliders') && !Schema::hasColumn('plans', 'max_slider')) {
                $table->renameColumn('max_sliders', 'max_slider');
            }
            
            // ✅ Renombrar max_locations → max_sedes (si existe el antiguo)
            if (Schema::hasColumn('plans', 'max_locations') && !Schema::hasColumn('plans', 'max_sedes')) {
                $table->renameColumn('max_locations', 'max_sedes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            // Revertir cambios
            if (Schema::hasColumn('plans', 'max_slider')) {
                $table->renameColumn('max_slider', 'max_sliders');
            }
            
            if (Schema::hasColumn('plans', 'max_sedes')) {
                $table->renameColumn('max_sedes', 'max_locations');
            }
        });
    }
};

