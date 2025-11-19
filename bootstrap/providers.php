<?php

return [
    App\Core\Providers\AuthServiceProvider::class,
    App\Core\Providers\ComponentsServiceProvider::class,
    App\Core\Providers\EventServiceProvider::class,
    App\Core\Providers\RouteServiceProvider::class,
    App\Features\SuperLinkiu\SuperLinkiuServiceProvider::class,
    App\Features\TenantAdmin\TenantAdminServiceProvider::class,
    App\Features\Tenant\TenantServiceProvider::class,
    App\Providers\AppServiceProvider::class,
];
