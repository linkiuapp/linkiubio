<?php

namespace App\Core\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Features\TenantAdmin\Events\StorePlanChanged;
use App\Features\TenantAdmin\Listeners\HandleBankAccountsOnPlanChange;
use App\Shared\Models\Store;
use App\Shared\Observers\StoreObserver;
use App\Shared\Models\User;
use App\Observers\UserObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        StorePlanChanged::class => [
            HandleBankAccountsOnPlanChange::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Store::observe(StoreObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}