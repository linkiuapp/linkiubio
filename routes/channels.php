<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Canal para SuperLinkiu (solo super admins)
Broadcast::channel('superlinkiu-notifications', function ($user) {
    return $user && $user->isSuperAdmin();
});

// Canal para cada tienda por slug (solo store admins de esa tienda)
Broadcast::channel('store.{storeSlug}.notifications', function ($user, $storeSlug) {
    if (!$user || !$user->isStoreAdmin()) {
        return false;
    }
    
    // Verificar que el usuario pertenece a esta tienda
    $store = \App\Shared\Models\Store::where('slug', $storeSlug)->first();
    return $store && $user->tenant_id === $store->tenant_id;
});

// Canal para cada tienda por ID (para notificaciones de error reports, etc)
Broadcast::channel('store.{storeId}', function ($user, $storeId) {
    if (!$user || !$user->isStoreAdmin()) {
        return false;
    }
    
    // Verificar que el usuario pertenece a esta tienda
    $store = \App\Shared\Models\Store::find($storeId);
    return $store && $user->tenant_id === $store->tenant_id;
}); 