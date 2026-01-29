<?php

namespace App\Features\SuperLinkiu\Models\PersonalFinance;

use App\Shared\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AccessToken extends Model
{
    protected $table = 'personal_finance_access_tokens';

    protected $fillable = [
        'user_id',
        'token',
        'short_code',
        'name',
        'expires_at',
        'usage_count',
        'last_used_at',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $hidden = [
        'token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generar un nuevo token
     */
    public static function generate(int $userId, ?string $name = null, ?int $daysValid = null): self
    {
        // Generar código corto único (6-8 caracteres alfanuméricos)
        do {
            $shortCode = strtoupper(Str::random(6));
        } while (self::where('short_code', $shortCode)->exists());

        return self::create([
            'user_id' => $userId,
            'token' => Str::random(64),
            'short_code' => $shortCode,
            'name' => $name ?? 'Acceso rápido móvil',
            'expires_at' => $daysValid ? now()->addDays($daysValid) : null,
            'is_active' => true,
        ]);
    }

    /**
     * Buscar por código corto
     */
    public static function findByShortCode(string $shortCode): ?self
    {
        return self::where('short_code', strtoupper($shortCode))->first();
    }

    /**
     * Verificar si el token es válido
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Registrar uso del token
     */
    public function recordUsage(): void
    {
        $this->increment('usage_count');
        $this->update(['last_used_at' => now()]);
    }

    /**
     * Scope para tokens válidos
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }
}
