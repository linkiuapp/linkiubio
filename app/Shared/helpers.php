<?php

use App\Shared\Services\FeatureResolver;
use App\Shared\Models\Store;

if (!function_exists('featureEnabled')) {
    /**
     * Verificar si un feature está habilitado para una tienda
     *
     * @param Store $store
     * @param string $featureKey
     * @return bool
     */
    function featureEnabled(Store $store, string $featureKey): bool
    {
        $resolver = app(FeatureResolver::class);
        $isEnabled = $resolver->isEnabled($store, $featureKey);
        
        // Caso especial: favoritos para ecommerce sin reservas
        // Si es el feature "favoritos" y no está habilitado explícitamente,
        // verificar si es ecommerce sin reservas habilitadas
        if ($featureKey === 'favoritos' && !$isEnabled) {
            $vertical = $store->businessCategory?->vertical ?? 'ecommerce';
            $hasReservas = $resolver->isEnabled($store, 'reservas_mesas') || 
                          $resolver->isEnabled($store, 'reservas_hotel');
            
            if ($vertical === 'ecommerce' && !$hasReservas) {
                return true;
            }
        }
        
        return $isEnabled;
    }
}

if (!function_exists('getMapboxStaticMapUrl')) {
    /**
     * Generate Mapbox Static Image API URL for a location
     * 
     * @param string $address Full address string
     * @param int $width Image width in pixels (default: 600)
     * @param int $height Image height in pixels (default: 256)
     * @return string|null Mapbox Static Image URL or null if token not configured
     */
    function getMapboxStaticMapUrl(string $address, int $width = 600, int $height = 256): ?string
    {
        $token = env('MAPBOX_ACCESS_TOKEN');
        
        if (!$token) {
            return null;
        }
        
        // Mapbox Static Images API requires coordinates (lat, lng)
        // We need to geocode the address first
        // For now, we'll use a simpler approach: use the address as overlay text
        // But better approach: store lat/lng in database
        
        // Format: https://api.mapbox.com/styles/v1/{username}/{style_id}/static/{overlay}/{lon},{lat},{zoom}/{width}x{height}?access_token={token}
        
        // Since we don't have coordinates, we'll return null and handle it in the view
        // The view should check if we have coordinates or use a default/fallback
        
        return null;
    }
    
    /**
     * Generate Mapbox Static Image URL from coordinates
     */
    function getMapboxStaticMapUrlFromCoordinates(float $lng, float $lat, int $width = 600, int $height = 256, int $zoom = 14): ?string
    {
        $token = env('MAPBOX_ACCESS_TOKEN');
        
        if (!$token) {
            return null;
        }
        
        $styleId = 'streets-v11';
        $username = 'mapbox';
        
        // Add a marker pin at the location
        $overlay = "pin-s-l+285A98({$lng},{$lat})";
        
        $url = "https://api.mapbox.com/styles/v1/{$username}/{$styleId}/static/{$overlay}/{$lng},{$lat},{$zoom}/{$width}x{$height}@2x";
        $url .= "?access_token={$token}";
        
        return $url;
    }
    
    /**
     * Generate navigation URLs (Google Maps, Waze) from address
     */
    function getNavigationUrls(string $address): array
    {
        $encodedAddress = urlencode($address);
        
        return [
            'google_maps' => "https://www.google.com/maps/search/?api=1&query={$encodedAddress}",
            'waze' => "https://waze.com/ul?q={$encodedAddress}"
        ];
    }
}


