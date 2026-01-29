<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Features\SuperLinkiu\Models\PersonalFinance\AccessToken;

return new class extends Migration
{
    public function up(): void
    {
        // Si la columna ya existe (creada por la primera migración), no hacer nada
        if (Schema::hasColumn('personal_finance_access_tokens', 'short_code')) {
            // Solo generar códigos para tokens existentes que no tengan short_code
            try {
                $tokens = AccessToken::whereNull('short_code')->get();
                foreach ($tokens as $token) {
                    do {
                        $shortCode = strtoupper(Str::random(6));
                    } while (AccessToken::where('short_code', $shortCode)->exists());
                    
                    $token->update(['short_code' => $shortCode]);
                }
            } catch (\Exception $e) {
                // Si hay error, continuar sin problemas
            }
            return;
        }

        // Si la columna no existe, agregarla (para tablas creadas antes de la primera migración)
        Schema::table('personal_finance_access_tokens', function (Blueprint $table) {
            $table->string('short_code', 8)->nullable()->after('token');
        });

        // Generar códigos cortos para tokens existentes
        try {
            $tokens = AccessToken::whereNull('short_code')->get();
            foreach ($tokens as $token) {
                do {
                    $shortCode = strtoupper(Str::random(6));
                } while (AccessToken::where('short_code', $shortCode)->exists());
                
                $token->update(['short_code' => $shortCode]);
            }
        } catch (\Exception $e) {
            // Si hay error, continuar
        }

        // Hacer el campo único y agregar índice
        try {
            Schema::table('personal_finance_access_tokens', function (Blueprint $table) {
                $table->string('short_code', 8)->unique()->change();
                $table->index(['short_code', 'is_active']);
            });
        } catch (\Exception $e) {
            // Si ya es único o el índice ya existe, ignorar
        }
    }

    public function down(): void
    {
        Schema::table('personal_finance_access_tokens', function (Blueprint $table) {
            $table->dropIndex(['short_code', 'is_active']);
            $table->dropColumn('short_code');
        });
    }
};
