<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Shared\Models\BusinessFeature;
use App\Shared\Enums\FeatureKey;

class BusinessFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Inicializa todos los features del sistema desde el enum FeatureKey.
     */
    public function run(): void
    {
        $this->command->info('🏗️ Inicializando features del sistema...');
        
        $features = [];
        
        // Recorrer todos los casos del enum FeatureKey
        foreach (FeatureKey::cases() as $featureKey) {
            $features[] = [
                'key' => $featureKey->value,
                'name' => $featureKey->label(),
                'area' => $featureKey->area(),
                'description' => $this->getDescription($featureKey),
                'is_default' => $this->isDefaultFeature($featureKey),
                'sort_order' => $this->getSortOrder($featureKey),
            ];
        }
        
        // Insertar o actualizar features
        foreach ($features as $feature) {
            BusinessFeature::updateOrCreate(
                ['key' => $feature['key']],
                $feature
            );
            
            $this->command->info("  ✓ {$feature['name']} ({$feature['key']})");
        }
        
        $this->command->info('✅ Features inicializados exitosamente');
        $this->command->info("📊 Total: " . count($features) . " features");
    }
    
    /**
     * Obtener descripción del feature
     */
    private function getDescription(FeatureKey $featureKey): ?string
    {
        return match($featureKey) {
            FeatureKey::RESERVAS_MESAS => 'Sistema de reservas de mesas para restaurantes',
            FeatureKey::CONSUMO_LOCAL => 'Gestión de pedidos para consumo en el local',
            FeatureKey::FAVORITOS => 'Sistema de favoritos para clientes',
            FeatureKey::RESERVAS_HOTEL => 'Sistema de reservas de habitaciones para hoteles',
            FeatureKey::CONSUMO_HOTEL => 'Sistema de servicio a habitación para hoteles',
            FeatureKey::NOTIFICACIONES_WHATSAPP => 'Envío de notificaciones por WhatsApp',
            FeatureKey::DASHBOARD => 'Panel de control principal',
            FeatureKey::ORDERS => 'Gestión de pedidos',
            FeatureKey::PRODUCTS => 'Gestión de productos',
            FeatureKey::CATEGORIES => 'Gestión de categorías',
            FeatureKey::VARIABLES => 'Gestión de variables de productos',
            FeatureKey::SHIPPING => 'Gestión de zonas de envío',
            FeatureKey::PAYMENTS => 'Gestión de métodos de pago',
            FeatureKey::BRANCHES => 'Gestión de sedes del negocio',
            FeatureKey::COUPONS => 'Gestión de cupones de descuento',
            FeatureKey::SLIDER => 'Gestión del slider principal',
            FeatureKey::ACCOUNT => 'Configuración de cuenta',
            FeatureKey::MASTER_KEY => 'Clave maestra para acciones protegidas',
            FeatureKey::BUSINESS_PROFILE => 'Perfil y configuración del negocio',
            FeatureKey::STORE_DESIGN => 'Diseño y personalización de la tienda',
            FeatureKey::BILLING => 'Plan y facturación',
            FeatureKey::ADS => 'Gestión de anuncios',
            FeatureKey::TICKETS => 'Sistema de soporte y tickets',
            default => null,
        };
    }
    
    /**
     * Determinar si un feature es por defecto (siempre habilitado)
     */
    private function isDefaultFeature(FeatureKey $featureKey): bool
    {
        // Features que siempre deben estar habilitados
        $defaultFeatures = [
            FeatureKey::DASHBOARD,
            FeatureKey::ORDERS,
            FeatureKey::PRODUCTS,
            FeatureKey::CATEGORIES,
            FeatureKey::ACCOUNT,
            FeatureKey::BUSINESS_PROFILE,
            FeatureKey::STORE_DESIGN,
        ];
        
        return in_array($featureKey, $defaultFeatures);
    }
    
    /**
     * Obtener orden de visualización
     */
    private function getSortOrder(FeatureKey $featureKey): int
    {
        return match($featureKey) {
            FeatureKey::DASHBOARD => 1,
            FeatureKey::ORDERS => 2,
            FeatureKey::PRODUCTS => 3,
            FeatureKey::CATEGORIES => 4,
            FeatureKey::VARIABLES => 5,
            FeatureKey::SHIPPING => 6,
            FeatureKey::PAYMENTS => 7,
            FeatureKey::BRANCHES => 8,
            FeatureKey::COUPONS => 9,
            FeatureKey::SLIDER => 10,
            FeatureKey::RESERVAS_MESAS => 11,
            FeatureKey::RESERVAS_HOTEL => 12,
            FeatureKey::CONSUMO_LOCAL => 13,
            FeatureKey::CONSUMO_HOTEL => 14,
            FeatureKey::NOTIFICACIONES_WHATSAPP => 15,
            FeatureKey::FAVORITOS => 16,
            FeatureKey::ACCOUNT => 20,
            FeatureKey::MASTER_KEY => 21,
            FeatureKey::BUSINESS_PROFILE => 22,
            FeatureKey::STORE_DESIGN => 23,
            FeatureKey::BILLING => 24,
            FeatureKey::ADS => 25,
            FeatureKey::TICKETS => 26,
            default => 99,
        };
    }
}

