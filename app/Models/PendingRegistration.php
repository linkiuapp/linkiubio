<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Models\Plan;
use App\Shared\Models\BusinessCategory;
use App\Shared\Models\Store;
use App\Shared\Models\User;

class PendingRegistration extends Model
{
    protected $fillable = [
        'plan_id',
        'billing_period',
        'business_category_id',
        'business_name',
        'document_type',
        'document_number',
        'phone',
        'email',
        'city',
        'department',
        'address',
        'description',
        'store_name',
        'slug',
        'store_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'owner_name',
        'owner_email',
        'owner_document_type',
        'owner_document_number',
        'hashed_password',
        'temp_password_encrypted',
        'payment_proof',
        'status',
        'validation_result',
        'rejected_reason',
        'rejection_details',
        'processed_by',
        'processed_at',
        'whatsapp_sent_at',
        'created_store_id',
    ];

    protected $casts = [
        'validation_result' => 'array',
        'processed_at' => 'datetime',
        'whatsapp_sent_at' => 'datetime',
    ];

    // Relaciones
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function category()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function createdStore()
    {
        return $this->belongsTo(Store::class, 'created_store_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Métodos
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getAmount(): float
    {
        $prices = $this->plan->prices ?? [];
        
        return match($this->billing_period) {
            'monthly' => $this->plan->price,
            'quarterly' => $prices['quarterly'] ?? ($this->plan->price * 3),
            'semester' => $prices['semester'] ?? ($this->plan->price * 6),
            'annual' => $prices['annual'] ?? ($this->plan->price * 12),
            default => $this->plan->price
        };
    }

    public function getFormattedAmount(): string
    {
        return '$' . number_format($this->getAmount(), 0, ',', '.');
    }

    public function getBillingPeriodLabel(): string
    {
        return match($this->billing_period) {
            'monthly' => 'Mensual',
            'quarterly' => 'Trimestral',
            'semester' => 'Semestral',
            'annual' => 'Anual',
            default => 'Mensual'
        };
    }
}

