<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGateway extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_active',
        'is_test_mode',
        'credentials',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_test_mode' => 'boolean',
        'credentials' => 'array',
        'settings' => 'array',
    ];

    /**
     * Relación con transacciones
     */
    public function transactions()
    {
        return $this->hasMany(PaymentGatewayTransaction::class);
    }

    /**
     * Obtener credencial desencriptada
     */
    public function getCredential(string $key): ?string
    {
        $credentials = $this->credentials ?? [];
        if (!isset($credentials[$key])) {
            return null;
        }

        $encryptedValue = $credentials[$key];
        
        // Si el valor ya está desencriptado (string simple), retornarlo
        if (!is_string($encryptedValue) || strlen($encryptedValue) < 50) {
            return $encryptedValue;
        }

        try {
            return \Illuminate\Support\Facades\Crypt::decryptString($encryptedValue);
        } catch (\Exception $e) {
            // Si falla la desencriptación, puede ser que no esté encriptado
            return $encryptedValue;
        }
    }

    /**
     * Establecer credencial (encriptada)
     */
    public function setCredential(string $key, string $value): void
    {
        $credentials = $this->credentials ?? [];
        $credentials[$key] = \Illuminate\Support\Facades\Crypt::encryptString($value);
        $this->credentials = $credentials;
    }

    /**
     * Verificar si está activo
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Verificar si está en modo prueba
     */
    public function isTestMode(): bool
    {
        return $this->is_test_mode;
    }
}
