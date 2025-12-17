<?php

namespace App\Shared\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GeocodingService
{
    /**
     * Geocode an address using Mapbox Geocoding API
     * 
     * @param string $address Full address string
     * @return array|null ['latitude' => float, 'longitude' => float] or null if failed
     */
    public function geocodeAddress(string $address): ?array
    {
        $token = env('MAPBOX_ACCESS_TOKEN');
        
        if (!$token) {
            Log::warning('Mapbox access token not configured');
            return null;
        }
        
        // Check cache first (cache by address hash)
        $cacheKey = 'geocode:' . md5($address);
        
        return Cache::remember($cacheKey, now()->addDays(30), function () use ($address, $token) {
            try {
                $encodedAddress = urlencode($address);
                
                // Mapbox Geocoding API
                $url = "https://api.mapbox.com/geocoding/v5/mapbox.places/{$encodedAddress}.json";
                
                $response = Http::timeout(5)->get($url, [
                    'access_token' => $token,
                    'limit' => 1,
                    'country' => 'CO' // Colombia - puedes hacer esto configurable
                ]);
                
                if (!$response->successful()) {
                    Log::warning('Mapbox geocoding API error', [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    return null;
                }
                
                $data = $response->json();
                
                if (empty($data['features'])) {
                    Log::warning('No geocoding results found', ['address' => $address]);
                    return null;
                }
                
                $feature = $data['features'][0];
                $coordinates = $feature['geometry']['coordinates'];
                
                // Mapbox returns [longitude, latitude]
                return [
                    'longitude' => (float) $coordinates[0],
                    'latitude' => (float) $coordinates[1],
                    'formatted_address' => $feature['place_name'] ?? $address
                ];
                
            } catch (\Exception $e) {
                Log::error('Geocoding error', [
                    'address' => $address,
                    'error' => $e->getMessage()
                ]);
                return null;
            }
        });
    }
    
    /**
     * Clear geocoding cache for an address
     */
    public function clearCache(string $address): void
    {
        $cacheKey = 'geocode:' . md5($address);
        Cache::forget($cacheKey);
    }
    
    /**
     * Get full address string from location
     */
    public function getFullAddress($location): string
    {
        $parts = array_filter([
            $location->address,
            $location->city,
            $location->department
        ]);
        
        return implode(', ', $parts);
    }
}
