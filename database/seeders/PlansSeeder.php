<?php

namespace Database\Seeders;

use App\Shared\Models\Plan;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Explorer',
                'description' => 'Plan gratuito para comenzar tu tienda online',
                'allow_custom_slug' => false,
                'price' => 0,
                'prices' => json_encode([
                    'monthly' => 0,
                    'quarterly' => 0,
                    'semester' => 0
                ]),
                'currency' => 'COP',
                'duration_in_days' => 30,
                
                // ✅ Límites reales
                'max_products' => 20,
                'max_categories' => 3,
                'max_variables' => 10,
                'max_slider' => 1,
                'max_active_coupons' => 1,
                'max_sedes' => 1,
                'max_delivery_zones' => 1,
                'max_bank_accounts' => 1,
                'max_admins' => 1,
                'analytics_retention_days' => 30,
                
                'support_level' => 'basic',
                'support_response_time' => 120, // 5 días en horas
                'is_active' => true,
                'is_public' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'trial_days' => 0,
                'additional_features' => json_encode([
                    'Soporte básico',
                    'Personalización básica',
                    'Reportes básicos'
                ]),
                'features_list' => json_encode([
                    '20 productos',
                    '3 categorías',
                    '10 variables por producto',
                    '1 slider',
                    '1 cupón activo',
                    '1 sede',
                    '1 zona de reparto',
                    '1 cuenta bancaria',
                    '30 días de analíticas',
                    'Soporte en 5 días',
                    'Slug genérico'
                ]),
                'version' => '1.0'
            ],
            [
                'name' => 'Master',
                'description' => 'Plan ideal para tiendas en crecimiento',
                'allow_custom_slug' => true,
                'price' => 60000,
                'prices' => json_encode([
                    'monthly' => 60000,
                    'quarterly' => 160000,
                    'semester' => 320000
                ]),
                'currency' => 'COP',
                'duration_in_days' => 30,
                
                // ✅ Límites reales
                'max_products' => 150,
                'max_categories' => 15,
                'max_variables' => 30,
                'max_slider' => 10,
                'max_active_coupons' => 10,
                'max_sedes' => 5,
                'max_delivery_zones' => 5,
                'max_bank_accounts' => 3,
                'max_admins' => 3,
                'analytics_retention_days' => 90,
                
                'support_level' => 'priority',
                'support_response_time' => 48,
                'is_active' => true,
                'is_public' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'trial_days' => 7,
                'additional_features' => json_encode([
                    'Soporte prioritario',
                    'Personalización avanzada',
                    'Reportes avanzados',
                    'Integración con redes sociales'
                ]),
                'features_list' => json_encode([
                    '150 productos',
                    '15 categorías',
                    '30 variables por producto',
                    '10 sliders',
                    '10 cupones activos',
                    '5 sedes',
                    '5 zonas de reparto',
                    '3 cuentas bancarias',
                    '3 administradores',
                    '90 días de analíticas',
                    'Soporte en 48 horas',
                    'Slug personalizado'
                ]),
                'version' => '1.0'
            ],
            [
                'name' => 'Legend',
                'description' => 'Plan premium para tiendas profesionales',
                'allow_custom_slug' => true,
                'price' => 100000,
                'prices' => json_encode([
                    'monthly' => 100000,
                    'quarterly' => 280000,
                    'semester' => 550000
                ]),
                'currency' => 'COP',
                'duration_in_days' => 30,
                
                // ✅ Límites reales
                'max_products' => 999999,  // Ilimitado
                'max_categories' => 999999,  // Ilimitado
                'max_variables' => 100,
                'max_slider' => 20,
                'max_active_coupons' => 50,
                'max_sedes' => 20,
                'max_delivery_zones' => 999999,  // Ilimitado
                'max_bank_accounts' => 10,
                'max_admins' => 10,
                'analytics_retention_days' => 365,
                
                'support_level' => 'premium',
                'support_response_time' => 24,
                'is_active' => true,
                'is_public' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'trial_days' => 14,
                'additional_features' => json_encode([
                    'Soporte premium 24/7',
                    'Personalización completa',
                    'Reportes personalizados',
                    'Integración con todas las plataformas',
                    'API access'
                ]),
                'features_list' => json_encode([
                    'Productos ilimitados',
                    'Categorías ilimitadas',
                    '100 variables por producto',
                    '20 sliders',
                    '50 cupones activos',
                    '20 sedes',
                    'Zonas de reparto ilimitadas',
                    '10 cuentas bancarias',
                    '10 administradores',
                    '365 días de analíticas',
                    'Soporte en 24 horas',
                    'Slug personalizado',
                    'API access'
                ]),
                'version' => '1.0'
            ],
        ];

        foreach ($plans as $planData) {
            Plan::updateOrCreate(
                ['name' => $planData['name']],
                $planData
            );
        }
    }
}
