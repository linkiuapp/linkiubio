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
        Schema::table('personal_finance_access_tokens', function (Blueprint $table) {
            $table->string('short_code', 8)->nullable()->after('token');
        });

        // Generar códigos cortos para tokens existentes
        $tokens = AccessToken::whereNull('short_code')->get();
        foreach ($tokens as $token) {
            do {
                $shortCode = strtoupper(Str::random(6));
            } while (AccessToken::where('short_code', $shortCode)->exists());
            
            $token->update(['short_code' => $shortCode]);
        }

        // Hacer el campo único y requerido
        Schema::table('personal_finance_access_tokens', function (Blueprint $table) {
            $table->string('short_code', 8)->unique()->change();
            $table->index(['short_code', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::table('personal_finance_access_tokens', function (Blueprint $table) {
            $table->dropIndex(['short_code', 'is_active']);
            $table->dropColumn('short_code');
        });
    }
};
