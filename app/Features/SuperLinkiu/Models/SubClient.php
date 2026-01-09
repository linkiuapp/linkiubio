<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubClient extends Model
{
    protected $table = 'sub_clients';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'country_code',
        'document_type',
        'document',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ==================== RELACIONES ====================

    public function subscriptions(): HasMany
    {
        return $this->hasMany(SubSubscription::class, 'client_id');
    }

    public function activeSubscriptions(): HasMany
    {
        return $this->subscriptions()->where('status', 'active');
    }

    // ==================== ACCESSORS ====================

    public function getFullPhoneAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        $countryCode = preg_replace('/[^0-9]/', '', $this->country_code);
        
        if (str_starts_with($phone, $countryCode)) {
            return $phone;
        }
        
        return $countryCode . $phone;
    }

    public function getPartialNameAttribute(): string
    {
        $parts = explode(' ', $this->name);
        if (count($parts) === 1) {
            return $parts[0];
        }
        
        $first = $parts[0];
        $last = $parts[count($parts) - 1];
        
        return $first . ' ' . substr($last, 0, 1) . '***';
    }

    public function getDocumentTypeLabelAttribute(): string
    {
        return match($this->document_type) {
            'CC' => 'Cédula',
            'CE' => 'Cédula Extranjería',
            'NIT' => 'NIT',
            'PA' => 'Pasaporte',
            default => $this->document_type ?? 'N/A',
        };
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) return $query;
        
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('document', 'like', "%{$search}%");
        });
    }

    // ==================== MÉTODOS ====================

    public function getTotalActiveSubscriptions(): int
    {
        return $this->activeSubscriptions()->count();
    }

    public function getTotalPendingAmount(): float
    {
        return $this->subscriptions()
            ->where('status', 'pending_payment')
            ->sum('amount');
    }
}
