<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'allow_custom_slug',
        'price',
        'prices',
        'currency',
        'duration_in_days',
        'image_url',
        
        // PRODUCTOS Y CATÁLOGO
        'max_products',
        'max_categories',
        'max_variables',
        'max_product_images',
        
        // DISEÑO Y MARKETING
        'max_slider',
        'max_active_coupons',
        
        // ENVÍOS Y LOGÍSTICA
        'max_sedes',
        'max_delivery_zones',
        
        // PAGOS
        'max_payment_methods',
        'max_bank_accounts',
        
        // ADMINISTRACIÓN Y SOPORTE
        'max_admins',
        'max_tickets_per_month',
        'order_history_months',
        'analytics_retention_days',
        'support_level',
        'support_response_time',
        
        // INVENTARIO
        'inventory_tracking',
        
        // INTEGRACIONES
        'whatsapp_integration',
        'kiubot_enabled',
        'trial_days',
        
        // LÍMITES VERTICAL RESTAURANT
        'max_tables',
        'max_daily_reservations',
        
        // LÍMITES VERTICAL HOTEL
        'max_rooms',
        'max_room_types',
        'max_daily_hotel_reservations',
        
        // CONFIGURACIÓN
        'is_active',
        'is_public',
        'is_featured',
        'sort_order',
        'trial_days',
        'additional_features',
        'features_list',
        'version'
    ];

    protected $casts = [
        'allow_custom_slug' => 'boolean',
        'price' => 'decimal:2',
        'prices' => 'array',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'inventory_tracking' => 'boolean',
        'whatsapp_integration' => 'boolean',
        'kiubot_enabled' => 'boolean',
        'trial_days' => 'integer',
        'additional_features' => 'array',
        'features_list' => 'array',
    ];

    // Accessor para features_list para asegurar que siempre sea un array
    public function getFeaturesListAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return is_array($value) ? $value : [];
    }

    // Relaciones
    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function planExtensions()
    {
        return $this->hasMany(StorePlanExtension::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // Métodos de ayuda
    public function isCustomSlugAllowed(): bool
    {
        return $this->allow_custom_slug;
    }

    public function getPriceFormatted(): string
    {
        return number_format($this->price, 0, ',', '.') . ' ' . $this->currency;
    }

    public function getPriceForPeriod(string $period): ?float
    {
        if ($this->prices && isset($this->prices[$period])) {
            return $this->prices[$period];
        }
        
        // Si no hay precio específico para el período, calcular basado en el precio mensual
        if ($this->price) {
            switch ($period) {
                case 'monthly':
                    return $this->price;
                case 'quarterly':
                    return $this->price * 3;
                case 'semester':
                    return $this->price * 6;
            }
        }
        
        return null;
    }

    public function getFormattedPriceForPeriod(string $period): string
    {
        $price = $this->getPriceForPeriod($period);
        return $price ? '$' . number_format($price, 0, ',', '.') : 'N/A';
    }

    public function getDiscountForPeriod(string $period): float
    {
        if ($period === 'monthly' || !$this->price) {
            return 0;
        }
        
        $monthlyTotal = $this->price * ($period === 'quarterly' ? 3 : 6);
        $periodPrice = $this->getPriceForPeriod($period);
        
        if ($periodPrice && $monthlyTotal > $periodPrice) {
            return round((($monthlyTotal - $periodPrice) / $monthlyTotal) * 100, 0);
        }
        
        return 0;
    }

    public function hasActiveStores(): bool
    {
        return $this->stores()->where('status', 'active')->exists();
    }
} 