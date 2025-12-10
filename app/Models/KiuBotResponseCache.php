<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KiuBotResponseCache extends Model
{
    protected $table = 'kiubot_response_cache';

    protected $fillable = [
        'question_hash',
        'question',
        'response',
        'category',
        'vertical',
        'hit_count',
        'last_hit_at',
    ];

    protected $casts = [
        'last_hit_at' => 'datetime',
        'hit_count' => 'integer',
    ];

    /**
     * Buscar respuesta cacheada
     */
    public static function findCachedResponse(string $question, ?string $vertical = null): ?self
    {
        $hash = self::hashQuestion($question);
        
        $query = self::where('question_hash', $hash);
        
        // Si hay vertical, buscar específica primero, luego genérica
        if ($vertical) {
            $cached = $query->clone()->where('vertical', $vertical)->first();
            if ($cached) {
                return $cached->recordHit();
            }
        }
        
        // Buscar versión genérica (sin vertical)
        $cached = $query->whereNull('vertical')->first();
        
        return $cached?->recordHit();
    }

    /**
     * Guardar respuesta en cache
     */
    public static function cacheResponse(string $question, string $response, ?string $category = null, ?string $vertical = null): self
    {
        return self::updateOrCreate(
            [
                'question_hash' => self::hashQuestion($question),
                'vertical' => $vertical,
            ],
            [
                'question' => $question,
                'response' => $response,
                'category' => $category,
                'hit_count' => 1,
                'last_hit_at' => now(),
            ]
        );
    }

    /**
     * Generar hash de pregunta normalizada
     */
    public static function hashQuestion(string $question): string
    {
        // Normalizar: minúsculas, sin acentos, sin signos de puntuación extra
        $normalized = mb_strtolower(trim($question));
        $normalized = self::removeAccents($normalized);
        $normalized = preg_replace('/[^\w\s]/', '', $normalized);
        $normalized = preg_replace('/\s+/', ' ', $normalized);
        
        return md5($normalized);
    }

    /**
     * Registrar uso de cache
     */
    public function recordHit(): self
    {
        $this->increment('hit_count');
        $this->update(['last_hit_at' => now()]);
        return $this;
    }

    /**
     * Eliminar respuestas no usadas en X días
     */
    public static function cleanOldCache(int $days = 30): int
    {
        return self::where('last_hit_at', '<', now()->subDays($days))
            ->orWhereNull('last_hit_at')
            ->delete();
    }

    /**
     * Obtener respuestas más frecuentes
     */
    public static function topQuestions(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return self::orderByDesc('hit_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Quitar acentos de string
     */
    protected static function removeAccents(string $string): string
    {
        $accents = ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'Ñ'];
        $noAccents = ['a', 'e', 'i', 'o', 'u', 'u', 'n', 'a', 'e', 'i', 'o', 'u', 'u', 'n'];
        
        return str_replace($accents, $noAccents, $string);
    }
}

