<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentProofTemplate extends Model
{
    protected $fillable = [
        'bank',
        'filename',
        'labels',
        'file_hash',
    ];

    protected $casts = [
        'labels' => 'array',
    ];

    /**
     * Obtener plantillas cacheadas por banco
     */
    public static function getByBank(string $bank): array
    {
        return self::where('bank', $bank)->get()->map(function ($template) {
            return [
                'filename' => $template->filename,
                'labels' => $template->labels,
            ];
        })->toArray();
    }

    /**
     * Verificar si una plantilla necesita actualización
     */
    public static function needsUpdate(string $filename, string $fileHash): bool
    {
        $existing = self::where('filename', $filename)->first();
        
        if (!$existing) {
            return true; // No existe, necesita ser creada
        }
        
        return $existing->file_hash !== $fileHash; // Hash cambió, necesita actualización
    }
}
