<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Shared\Models\User;

class RegistrationPaymentSetting extends Model
{
    protected $fillable = [
        'bank_name',
        'account_type',
        'account_number',
        'account_holder',
        'nit',
        'qr_code_image',
        'is_active',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Obtener configuración activa (singleton)
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first() 
            ?? static::first() 
            ?? static::create([
                'bank_name' => 'Bancolombia',
                'account_type' => 'Ahorros',
                'account_number' => '1234567890',
                'account_holder' => 'Linkiu S.A.S',
                'nit' => '901234567-1',
                'is_active' => true,
            ]);
    }

    /**
     * Obtener URL completa del QR (compatible con S3 y local)
     */
    public function getQrCodeUrlAttribute()
    {
        if (!$this->qr_code_image) {
            return null;
        }

        // ✅ Usar Storage::url() para compatibilidad con S3/Laravel Cloud
        try {
            $url = Storage::disk('public')->url($this->qr_code_image);
            Log::info('QR Code URL generada:', [
                'path' => $this->qr_code_image,
                'url' => $url
            ]);
            return $url;
        } catch (\Exception $e) {
            Log::error('Error obteniendo URL de QR code:', [
                'path' => $this->qr_code_image,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}

