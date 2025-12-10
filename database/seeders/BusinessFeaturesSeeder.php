<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Shared\Models\BusinessFeature;
use App\Shared\Models\BusinessCategory;
use Illuminate\Support\Facades\DB;

class BusinessFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar tablas
        DB::table('business_category_feature')->delete();
        BusinessFeature::query()->delete();

        // Features BASE (todas las categorías)
        $baseFeatures = [
            ['key' => 'dashboard', 'name' => 'Dashboard', 'area' => 'admin', 'is_default' => true, 'sort_order' => 1],
            ['key' => 'productos', 'name' => 'Productos', 'area' => 'admin', 'is_default' => true, 'sort_order' => 2],
            ['key' => 'categorias', 'name' => 'Categorías', 'area' => 'admin', 'is_default' => true, 'sort_order' => 3],
            ['key' => 'pedidos', 'name' => 'Pedidos', 'area' => 'admin', 'is_default' => true, 'sort_order' => 4],
            ['key' => 'clientes', 'name' => 'Clientes', 'area' => 'admin', 'is_default' => true, 'sort_order' => 5],
            ['key' => 'cupones', 'name' => 'Cupones', 'area' => 'admin', 'is_default' => true, 'sort_order' => 6],
            ['key' => 'sliders', 'name' => 'Sliders', 'area' => 'admin', 'is_default' => true, 'sort_order' => 7],
            ['key' => 'metodos_pago', 'name' => 'Métodos de Pago', 'area' => 'admin', 'is_default' => true, 'sort_order' => 8],
            ['key' => 'cuentas_bancarias', 'name' => 'Cuentas Bancarias', 'area' => 'admin', 'is_default' => true, 'sort_order' => 9],
            ['key' => 'zonas_entrega', 'name' => 'Zonas de Entrega', 'area' => 'admin', 'is_default' => true, 'sort_order' => 10],
            ['key' => 'configuracion', 'name' => 'Configuración', 'area' => 'admin', 'is_default' => true, 'sort_order' => 11],
            ['key' => 'variables', 'name' => 'Variables de Producto', 'area' => 'admin', 'is_default' => true, 'sort_order' => 12],
        ];

        // Features de RESTAURANT
        $restaurantFeatures = [
            ['key' => 'reservas_mesas', 'name' => 'Reservas de Mesas', 'area' => 'admin', 'is_default' => false, 'sort_order' => 20],
            ['key' => 'mesas', 'name' => 'Mesas', 'area' => 'admin', 'is_default' => false, 'sort_order' => 21],
            ['key' => 'consumo_local', 'name' => 'Consumo en el Local', 'area' => 'admin', 'is_default' => false, 'sort_order' => 22],
        ];

        // Features de HOTEL
        $hotelFeatures = [
            ['key' => 'reservas_hotel', 'name' => 'Reservas de Hotel', 'area' => 'admin', 'is_default' => false, 'sort_order' => 30],
            ['key' => 'habitaciones', 'name' => 'Habitaciones', 'area' => 'admin', 'is_default' => false, 'sort_order' => 31],
            ['key' => 'tipos_habitacion', 'name' => 'Tipos de Habitación', 'area' => 'admin', 'is_default' => false, 'sort_order' => 32],
        ];

        // Insertar todas las features
        $allFeatures = array_merge($baseFeatures, $restaurantFeatures, $hotelFeatures);
        
        foreach ($allFeatures as $featureData) {
            BusinessFeature::create($featureData);
        }

        $this->command->info('✅ Features creadas: ' . count($allFeatures));

        // Asociar features a categorías por vertical
        $categories = BusinessCategory::all();

        foreach ($categories as $category) {
            $featureKeys = [];

            // Todas tienen features base
            $featureKeys = array_merge($featureKeys, array_column($baseFeatures, 'key'));

            // Agregar features específicas por vertical
            switch ($category->vertical) {
                case 'restaurant':
                    $featureKeys = array_merge($featureKeys, array_column($restaurantFeatures, 'key'));
                    break;
                
                case 'hotel':
                    $featureKeys = array_merge($featureKeys, array_column($hotelFeatures, 'key'));
                    break;
                
                case 'ecommerce':
                    // Solo features base
                    break;
            }

            // Obtener IDs de features
            $featureIds = BusinessFeature::whereIn('key', $featureKeys)->pluck('id');

            // Asociar features a la categoría
            $category->features()->sync($featureIds);

            $this->command->info("✅ Categoría '{$category->name}' ({$category->vertical}): " . count($featureIds) . " features");
        }

        $this->command->info('🎉 Seeder completado correctamente');
    }
}

