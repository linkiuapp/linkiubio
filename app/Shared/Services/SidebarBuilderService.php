<?php

namespace App\Shared\Services;

use App\Shared\Models\Store;
use Illuminate\Support\Facades\Route;

/**
 * Servicio para construir items del sidebar según el vertical de la tienda
 */
class SidebarBuilderService
{
    protected ?Store $store;
    protected ?string $vertical;

    public function __construct(?Store $store = null)
    {
        $this->store = $store;
        
        if ($store) {
            // Asegurar que la relación businessCategory esté cargada
            if (!$store->relationLoaded('businessCategory')) {
                $store->load('businessCategory');
            }
            
            $this->vertical = $store->businessCategory?->vertical;
        } else {
            $this->vertical = null;
        }
    }

    /**
     * Construir todos los items del sidebar para TenantAdmin
     */
    public function buildTenantAdminSidebar(): array
    {
        $items = [];

        // Onboarding (si aplica)
        $items = array_merge($items, $this->buildOnboardingSection());

        // Favoritos
        $items[] = ['type' => 'section', 'title' => 'Favoritos'];
        $items = array_merge($items, $this->buildFavoritesSection());

        // Tienda y productos (Core)
        $items[] = ['type' => 'section', 'title' => 'Tienda y productos'];
        $items = array_merge($items, $this->buildStoreAndProductsSection());

        // Reservas y Servicios (según vertical)
        $reservationsItems = $this->buildReservationsAndServicesSection();
        if (!empty($reservationsItems)) {
            $items[] = ['type' => 'section', 'title' => 'Reservas y Servicios'];
            $items = array_merge($items, $reservationsItems);
        }

        // Marketing (Core)
        $items[] = ['type' => 'section', 'title' => 'Marketing'];
        $items = array_merge($items, $this->buildMarketingSection());

        // Anuncios y soporte (Core)
        $items[] = ['type' => 'section', 'title' => 'Anuncios y soporte'];
        $items = array_merge($items, $this->buildSupportSection());

        return $items;
    }

    /**
     * Construir sección de onboarding
     */
    protected function buildOnboardingSection(): array
    {
        $items = [];
        
        // Solo mostrar si no está todo completo
        $onboardingSteps = [
            'design'     => \App\Shared\Models\StoreOnboardingStep::isCompleted($this->store->id, 'design'),
            'slider'     => \App\Shared\Models\StoreOnboardingStep::isCompleted($this->store->id, 'slider'),
            'locations'  => \App\Shared\Models\StoreOnboardingStep::isCompleted($this->store->id, 'locations'),
            'payments'   => \App\Shared\Models\StoreOnboardingStep::isCompleted($this->store->id, 'payments'),
            'shipping'   => \App\Shared\Models\StoreOnboardingStep::isCompleted($this->store->id, 'shipping'),
            'categories' => \App\Shared\Models\StoreOnboardingStep::isCompleted($this->store->id, 'categories'),
            'variables'  => \App\Shared\Models\StoreOnboardingStep::isCompleted($this->store->id, 'variables'),
            'products'   => \App\Shared\Models\StoreOnboardingStep::isCompleted($this->store->id, 'products'),
            'coupons'    => \App\Shared\Models\StoreOnboardingStep::isCompleted($this->store->id, 'coupons'),
        ];

        $allCompleted = count(array_filter($onboardingSteps)) === count($onboardingSteps);

        if (!$allCompleted) {
            $onboardingContent = view('shared::admin.tenant-sidebar-onboarding', [
                'store'           => $this->store,
                'onboardingSteps' => $onboardingSteps
            ])->render();

            $items[] = ['type' => 'custom', 'content' => $onboardingContent];
            $items[] = ['type' => 'section', 'title' => ''];
        }

        return $items;
    }

    /**
     * Construir todos los items del sidebar para SuperAdmin
     */
    public function buildSuperAdminSidebar(): array
    {
        $items = [];

        // Favoritos
        $items = array_merge($items, $this->buildSuperAdminFavoritesSection());

        // Administración
        $items = array_merge($items, $this->buildSuperAdminAdministrationSection());

        // Planes y Facturación
        $items = array_merge($items, $this->buildSuperAdminBillingSection());

        // Gestión de tickets
        $items = array_merge($items, $this->buildSuperAdminTicketsSection());

        // Anuncios y Configuración
        $items = array_merge($items, $this->buildSuperAdminAnnouncementsSection());

        // Configuración de Tiendas
        $items = array_merge($items, $this->buildSuperAdminConfigurationSection());

        return $items;
    }

    /**
     * Construir sección de favoritos para SuperAdmin
     */
    protected function buildSuperAdminFavoritesSection(): array
    {
        $items = [];

        // Dashboard
        $items[] = [
            'label'  => 'Dashboard',
            'url'    => route('superlinkiu.dashboard'),
            'icon'   => 'layout-dashboard',
            'active' => request()->routeIs('superlinkiu.dashboard')
        ];

        // Componentes (Solo Local) - Movido desde TenantAdmin
        if (app()->environment('local')) {
            $items[] = [
                'label'      => 'Componentes',
                'url'        => route('design-system.index'),
                'icon'       => 'palette',
                'active'     => request()->routeIs('design-system.*'),
                'badge'      => 'LOCAL',
                'badgeColor' => 'bg-yellow-500 text-white'
            ];
        }

        return $items;
    }

    /**
     * Construir sección de administración para SuperAdmin
     */
    protected function buildSuperAdminAdministrationSection(): array
    {
        $items = [];

        // Gestión de tiendas
        $items[] = [
            'label'  => 'Gestión de tiendas',
            'url'    => route('superlinkiu.stores.index'),
            'icon'   => 'store',
            'active' => request()->routeIs('superlinkiu.stores.*') && !request()->routeIs('superlinkiu.store-requests.*')
        ];

        // Solicitudes de Tiendas
        $pendingCount = \App\Shared\Models\Store::where('approval_status', 'pending_approval')->count();
        $items[] = [
            'label'      => 'Solicitudes de Tiendas',
            'url'        => route('superlinkiu.store-requests.index'),
            'icon'       => 'file-text',
            'active'     => request()->routeIs('superlinkiu.store-requests.*'),
            'badge'      => $pendingCount > 0 ? (string)$pendingCount : null,
            'badgeColor' => $pendingCount > 0 ? 'bg-warning-300 text-white' : null
        ];

        // Gestión de Usuarios
        $items[] = [
            'label'  => 'Gestión de Usuarios',
            'url'    => route('superlinkiu.user-management.index'),
            'icon'   => 'users',
            'active' => request()->routeIs('superlinkiu.user-management.*')
        ];

        // Recuperación Clave Maestra
        $pendingRecoveryCount = \App\Shared\Models\MasterKeyRecoveryRequest::where('status', 'pending')->count();
        $items[] = [
            'label'      => 'Recuperación Clave Maestra',
            'url'        => route('superlinkiu.master-key-recovery.index'),
            'icon'       => 'lock-keyhole',
            'active'     => request()->routeIs('superlinkiu.master-key-recovery.*'),
            'badge'      => $pendingRecoveryCount > 0 ? (string)$pendingRecoveryCount : null,
            'badgeColor' => $pendingRecoveryCount > 0 ? 'bg-warning-300 text-white' : null
        ];

        // Reportes de Tiendas
        $pendingReportsCount = \App\Shared\Models\StoreReport::where('status', 'pending')->count();
        $items[] = [
            'label'      => 'Reportes de Tiendas',
            'url'        => route('superlinkiu.store-reports.index'),
            'icon'       => 'alert-triangle',
            'active'     => request()->routeIs('superlinkiu.store-reports.*'),
            'badge'      => $pendingReportsCount > 0 ? (string)$pendingReportsCount : null,
            'badgeColor' => $pendingReportsCount > 0 ? 'bg-error-300 text-white' : null
        ];

        return $items;
    }

    /**
     * Construir sección de planes y facturación para SuperAdmin
     */
    protected function buildSuperAdminBillingSection(): array
    {
        $items = [];

        // Planes disponibles
        $items[] = [
            'label'  => 'Planes disponibles',
            'url'    => route('superlinkiu.plans.index'),
            'icon'   => 'award',
            'active' => request()->routeIs('superlinkiu.plans.*')
        ];

        // Facturación
        $items[] = [
            'label'  => 'Facturación',
            'url'    => route('superlinkiu.invoices.index'),
            'icon'   => 'receipt',
            'active' => request()->routeIs('superlinkiu.invoices.*')
        ];

        // Configurar Facturas
        $items[] = [
            'label'  => 'Configurar Facturas',
            'url'    => route('superlinkiu.billing-settings.index'),
            'icon'   => 'settings',
            'active' => request()->routeIs('superlinkiu.billing-settings.*')
        ];

        return $items;
    }

    /**
     * Construir sección de tickets para SuperAdmin
     */
    protected function buildSuperAdminTicketsSection(): array
    {
        $items = [];

        // Lista de tickets (desde aquí se pueden crear y filtrar)
        $openTicketsCount = \App\Shared\Models\Ticket::whereIn('status', ['open', 'in_progress'])->count();
        $items[] = [
            'label'      => 'Lista de tickets',
            'url'        => route('superlinkiu.tickets.index'),
            'icon'       => 'ticket',
            'active'     => request()->routeIs('superlinkiu.tickets.*') && !request()->routeIs('superlinkiu.email.*'),
            'badge'      => $openTicketsCount > 0 ? (string)$openTicketsCount : null,
            'badgeColor' => $openTicketsCount > 0 ? 'bg-error-200 text-accent-50' : null
        ];

        return $items;
    }

    /**
     * Construir sección de anuncios y configuración para SuperAdmin
     */
    protected function buildSuperAdminAnnouncementsSection(): array
    {
        $items = [];

        // Anuncios de Linkiu
        $totalAnnouncements = \App\Shared\Models\PlatformAnnouncement::where('is_active', true)->count();
        $items[] = [
            'label'      => 'Anuncios de Linkiu',
            'url'        => route('superlinkiu.announcements.index'),
            'icon'       => 'megaphone',
            'active'     => request()->routeIs('superlinkiu.announcements.*'),
            'badge'      => $totalAnnouncements > 0 ? (string)$totalAnnouncements : null,
            'badgeColor' => $totalAnnouncements > 0 ? 'bg-primary-200 text-accent-50' : null
        ];

        // Configuración de Email
        $items[] = [
            'label'  => 'Configuración de Email',
            'url'    => route('superlinkiu.email.configuration'),
            'icon'   => 'mail',
            'active' => request()->routeIs('superlinkiu.email.*')
        ];

        return $items;
    }

    /**
     * Construir sección de configuración para SuperAdmin
     */
    protected function buildSuperAdminConfigurationSection(): array
    {
        $items = [];

        // Categorías de Negocio
        $totalCategories = \App\Shared\Models\BusinessCategory::count();
        $autoApproveCategories = \App\Shared\Models\BusinessCategory::where('requires_manual_approval', false)->where('is_active', true)->count();
        $items[] = [
            'label'      => 'Categorías de Negocio',
            'url'        => route('superlinkiu.business-categories.index'),
            'icon'       => 'tag',
            'active'     => request()->routeIs('superlinkiu.business-categories.*'),
            'badge'      => $totalCategories > 0 ? "{$autoApproveCategories}/{$totalCategories}" : null,
            'badgeColor' => $totalCategories > 0 ? 'bg-success-300 text-white' : null
        ];

        // Iconos de Categorías
        $totalIcons = \App\Shared\Models\CategoryIcon::count();
        $activeIcons = \App\Shared\Models\CategoryIcon::where('is_active', true)->count();
        $items[] = [
            'label'      => 'Iconos de Categorías',
            'url'        => route('superlinkiu.category-icons.index'),
            'icon'       => 'image',
            'active'     => request()->routeIs('superlinkiu.category-icons.*'),
            'badge'      => $totalIcons > 0 ? "{$activeIcons}/{$totalIcons}" : null,
            'badgeColor' => $totalIcons > 0 ? 'bg-info-300 text-accent-50' : null
        ];

        return $items;
    }

    /**
     * Construir footer del sidebar para SuperAdmin
     */
    public function buildSuperAdminFooter(): array
    {
        $user = auth()->user();
        
        $footer = [
            'avatar'   => $user->avatar_url ?? null,
            'name'     => $user->name ?? 'Super Admin',
            'dropdown' => [
                [
                    'label' => 'Perfil',
                    'url'   => route('superlinkiu.profile.show'),
                    'icon'  => 'user-circle'
                ],
                [
                    'label'  => 'Cerrar sesión',
                    'url'    => route('superlinkiu.logout'),
                    'method' => 'POST',
                    'icon'   => 'log-out'
                ]
            ]
        ];

        // Si no hay avatar, usar inicial del usuario
        if (!$footer['avatar'] && $user) {
            $footer['initials'] = strtoupper(substr($user->name, 0, 1));
        }

        return $footer;
    }

    /**
     * Construir sección de favoritos
     */
    protected function buildFavoritesSection(): array
    {
        $items = [];

        // Dashboard
        $items[] = [
            'label'  => 'Dashboard',
            'url'    => route('tenant.admin.dashboard', ['store' => $this->store->slug]),
            'icon'   => 'layout-dashboard',
            'active' => request()->routeIs('tenant.admin.dashboard')
        ];

        // Pedidos
        $pendingOrders = $this->store->pending_orders_count ?? 0;
        $items[] = [
            'label'      => 'Pedidos',
            'url'        => route('tenant.admin.orders.index', ['store' => $this->store->slug]),
            'icon'       => 'party-popper',
            'active'     => request()->routeIs('tenant.admin.orders.*'),
            'badge'      => $pendingOrders > 0 ? (string)$pendingOrders : '0',
            'badgeColor' => $pendingOrders > 0 ? 'bg-red-500 text-white' : 'bg-gray-500 text-white'
        ];

        return $items;
    }

    /**
     * Construir sección de tienda y productos (Core)
     */
    protected function buildStoreAndProductsSection(): array
    {
        $items = [];

        // Categorías
        $categoriesUsed = $this->store->categories_count ?? 0;
        $categoriesLimit = $this->store->plan->max_categories;
        $categoriesPercent = $categoriesLimit > 0 ? ($categoriesUsed / $categoriesLimit) * 100 : 0;
        $categoriesBadgeColor = $categoriesPercent >= 90
            ? 'bg-red-500 text-white'
            : ($categoriesPercent >= 70 ? 'bg-yellow-500 text-white' : 'bg-gray-500 text-white');
        
        $items[] = [
            'label'      => 'Categorías',
            'url'        => route('tenant.admin.categories.index', ['store' => $this->store->slug]),
            'icon'       => 'layout-list',
            'active'     => request()->routeIs('tenant.admin.categories.*'),
            'badge'      => "{$categoriesUsed}/{$categoriesLimit}",
            'badgeColor' => $categoriesBadgeColor
        ];

        // Variables
        $variablesUsed = $this->store->variables_count ?? 0;
        $variablesLimit = $this->store->plan->max_variables ?? 50;
        $variablesPercent = $variablesLimit > 0 ? ($variablesUsed / $variablesLimit) * 100 : 0;
        $variablesBadgeColor = $variablesPercent >= 90
            ? 'bg-red-500 text-white'
            : ($variablesPercent >= 70 ? 'bg-yellow-500 text-white' : 'bg-gray-500 text-white');
        
        $items[] = [
            'label'      => 'Variables',
            'url'        => route('tenant.admin.variables.index', ['store' => $this->store->slug]),
            'icon'       => 'tag',
            'active'     => request()->routeIs('tenant.admin.variables.*'),
            'badge'      => "{$variablesUsed}/{$variablesLimit}",
            'badgeColor' => $variablesBadgeColor
        ];

        // Productos
        $productsUsed = $this->store->products_count ?? 0;
        $productsLimit = $this->store->plan->max_products;
        $productsPercent = $productsLimit > 0 ? ($productsUsed / $productsLimit) * 100 : 0;
        $productsBadgeColor = $productsPercent >= 90
            ? 'bg-red-500 text-white'
            : ($productsPercent >= 70 ? 'bg-yellow-500 text-white' : 'bg-gray-500 text-white');
        
        $items[] = [
            'label'      => 'Productos',
            'url'        => route('tenant.admin.products.index', ['store' => $this->store->slug]),
            'icon'       => 'package',
            'active'     => request()->routeIs('tenant.admin.products.*'),
            'badge'      => "{$productsUsed}/{$productsLimit}",
            'badgeColor' => $productsBadgeColor
        ];

        // Gestión de Envíos (si está habilitado)
        if (featureEnabled($this->store, 'shipping')) {
            $simpleShipping = \App\Features\TenantAdmin\Models\SimpleShipping::where('store_id', $this->store->id)->first();
            $currentZones = $simpleShipping ? $simpleShipping->zones()->count() : 0;

            $zoneLimits = ['explorer' => 2, 'master' => 3, 'legend' => 4];
            $planSlug = strtolower($this->store->plan->slug ?? 'explorer');
            $maxZones = $zoneLimits[$planSlug] ?? 2;
            $zonesPercent = $maxZones > 0 ? ($currentZones / $maxZones) * 100 : 0;
            $zonesBadgeColor = $zonesPercent >= 90
                ? 'bg-red-500 text-white'
                : ($zonesPercent >= 70 ? 'bg-yellow-500 text-white' : 'bg-gray-500 text-white');
            
            $items[] = [
                'label'      => 'Gestión de Envíos',
                'url'        => route('tenant.admin.simple-shipping.index', ['store' => $this->store->slug]),
                'icon'       => 'truck',
                'active'     => request()->routeIs('tenant.admin.simple-shipping.*'),
                'badge'      => "{$currentZones}/{$maxZones}",
                'badgeColor' => $zonesBadgeColor
            ];
        }

        // Métodos de Pago
        $items[] = [
            'label'  => 'Métodos de Pago',
            'url'    => route('tenant.admin.payment-methods.index', ['store' => $this->store->slug]),
            'icon'   => 'dock',
            'active' => request()->routeIs('tenant.admin.payment-methods.*')
        ];

        // Sedes
        $locationsUsed = $this->store->locations_count ?? 0;
        $locationsLimit = $this->store->plan->max_locations ?? $this->store->plan->max_sedes ?? 1;
        $locationsPercent = $locationsLimit > 0 ? ($locationsUsed / $locationsLimit) * 100 : 0;
        $locationsBadgeColor = $locationsPercent >= 90
            ? 'bg-red-500 text-white'
            : ($locationsPercent >= 70 ? 'bg-yellow-500 text-white' : 'bg-gray-500 text-white');
        
        $items[] = [
            'label'      => 'Sedes',
            'url'        => route('tenant.admin.locations.index', ['store' => $this->store->slug]),
            'icon'       => 'store',
            'active'     => request()->routeIs('tenant.admin.locations.*'),
            'badge'      => "{$locationsUsed}/{$locationsLimit}",
            'badgeColor' => $locationsBadgeColor
        ];

        return $items;
    }

    /**
     * Construir sección de reservas y servicios (según vertical)
     */
    protected function buildReservationsAndServicesSection(): array
    {
        $items = [];

        // Notificaciones WhatsApp (si está habilitado)
        if (featureEnabled($this->store, 'notificaciones_whatsapp')) {
            $items[] = [
                'label'  => 'Notificaciones WhatsApp',
                'url'    => route('tenant.admin.whatsapp-notifications.index', ['store' => $this->store->slug]),
                'icon'   => 'message-circle',
                'active' => request()->routeIs('tenant.admin.whatsapp-notifications.*')
            ];
        }

        // Según el vertical, mostrar diferentes opciones
        switch ($this->vertical) {
            case 'restaurant':
                // Reservas de Mesas
                if (featureEnabled($this->store, 'reservas_mesas')) {
                    $items[] = [
                        'label'  => 'Reservas de Mesas',
                        'url'    => route('tenant.admin.reservations.index', ['store' => $this->store->slug]),
                        'icon'   => 'utensils',
                        'active' => request()->routeIs('tenant.admin.reservations.*')
                    ];
                }

                // Consumo en Local
                if (featureEnabled($this->store, 'consumo_local')) {
                    $items[] = [
                        'label'  => 'Consumo en Local',
                        'url'    => route('tenant.admin.dine-in.tables.index', ['store' => $this->store->slug, 'type' => 'mesa']),
                        'icon'   => 'scan-barcode',
                        'active' => request()->routeIs('tenant.admin.dine-in.*') && request()->get('type') === 'mesa'
                    ];
                }
                break;

            case 'hotel':
                // Reservas de Hotel
                if (featureEnabled($this->store, 'reservas_hotel')) {
                    $items[] = [
                        'label'  => 'Reservas de Hotel',
                        'url'    => route('tenant.admin.hotel.reservations.index', ['store' => $this->store->slug]),
                        'icon'   => 'bed',
                        'active' => request()->routeIs('tenant.admin.hotel.reservations.*')
                    ];
                }

                // Servicio a Habitación
                if (featureEnabled($this->store, 'consumo_hotel') && featureEnabled($this->store, 'reservas_hotel')) {
                    $items[] = [
                        'label'  => 'Servicio a Habitación',
                        'url'    => route('tenant.admin.dine-in.tables.index', ['store' => $this->store->slug, 'type' => 'habitacion']),
                        'icon'   => 'concierge-bell',
                        'active' => request()->routeIs('tenant.admin.dine-in.*') && request()->get('type') === 'habitacion'
                    ];
                }
                break;

            case 'dropshipping':
                // Dropshipping no tiene reservas ni consumo local
                break;

            case 'ecommerce':
            default:
                // Ecommerce no tiene reservas ni consumo local
                break;
        }

        return $items;
    }

    /**
     * Construir sección de marketing (Core)
     */
    protected function buildMarketingSection(): array
    {
        $items = [];

        // Diseño de la Tienda
        $items[] = [
            'label'  => 'Diseño de la Tienda',
            'url'    => route('tenant.admin.store-design.index', ['store' => $this->store->slug]),
            'icon'   => 'palette',
            'active' => request()->routeIs('tenant.admin.store-design.*')
        ];

        // Cupones
        $couponsUsed = $this->store->active_coupons_count ?? 0;
        $couponsLimit = $this->store->plan->max_active_coupons;
        $couponsPercent = $couponsLimit > 0 ? ($couponsUsed / $couponsLimit) * 100 : 0;
        $couponsBadgeColor = $couponsPercent >= 90
            ? 'bg-red-500 text-white'
            : ($couponsPercent >= 70 ? 'bg-yellow-500 text-white' : 'bg-gray-500 text-white');
        
        $items[] = [
            'label'      => 'Cupones',
            'url'        => route('tenant.admin.coupons.index', ['store' => $this->store->slug]),
            'icon'       => 'ticket-percent',
            'active'     => request()->routeIs('tenant.admin.coupons.*'),
            'badge'      => "{$couponsUsed}/{$couponsLimit}",
            'badgeColor' => $couponsBadgeColor
        ];

        // Slider
        $slidersUsed = $this->store->sliders_count ?? 0;
        $slidersLimit = $this->store->plan->max_sliders ?? $this->store->plan->max_slider ?? 1;
        $slidersPercent = $slidersLimit > 0 ? ($slidersUsed / $slidersLimit) * 100 : 0;
        $slidersBadgeColor = $slidersPercent >= 90
            ? 'bg-red-500 text-white'
            : ($slidersPercent >= 70 ? 'bg-yellow-500 text-white' : 'bg-gray-500 text-white');
        
        $items[] = [
            'label'      => 'Slider',
            'url'        => route('tenant.admin.sliders.index', ['store' => $this->store->slug]),
            'icon'       => 'images',
            'active'     => request()->routeIs('tenant.admin.sliders.*'),
            'badge'      => "{$slidersUsed}/{$slidersLimit}",
            'badgeColor' => $slidersBadgeColor
        ];

        return $items;
    }

    /**
     * Construir sección de soporte (Core)
     */
    protected function buildSupportSection(): array
    {
        $items = [];

        // Soporte y Tickets
        $openTicketsCount = $this->store->tickets()->whereIn('status', ['open', 'in_progress'])->count();
        $items[] = [
            'label'      => 'Soporte y Tickets',
            'url'        => route('tenant.admin.tickets.index', ['store' => $this->store->slug]),
            'icon'       => 'server-crash',
            'active'     => request()->routeIs('tenant.admin.tickets.*'),
            'badge'      => $openTicketsCount > 0 ? (string)$openTicketsCount : null,
            'badgeColor' => $openTicketsCount > 0 ? 'bg-red-500 text-white' : null
        ];

        // Anuncios de Linkiu
        $unreadAnnouncements = $this->store->unread_announcements_count ?? 0;
        $items[] = [
            'label'      => 'Anuncios de Linkiu',
            'url'        => route('tenant.admin.announcements.index', ['store' => $this->store->slug]),
            'icon'       => 'megaphone',
            'active'     => request()->routeIs('tenant.admin.announcements.*'),
            'badge'      => $unreadAnnouncements > 0 ? (string)$unreadAnnouncements : null,
            'badgeColor' => $unreadAnnouncements > 0 ? 'bg-yellow-500 text-white' : null
        ];

        return $items;
    }

    /**
     * Construir footer del sidebar
     */
    public function buildFooter(): array
    {
        $profileImage = $this->store->design?->logo_url ?? $this->store->logo_url;
        
        $footer = [
            'avatar'   => $profileImage ?: null,
            'name'     => auth()->user()->name ?? 'Usuario',
            'dropdown' => [
                [
                    'label' => 'Mi Cuenta',
                    'url'   => route('tenant.admin.profile.index', ['store' => $this->store->slug]),
                    'icon'  => 'user-circle'
                ],
                [
                    'label' => 'Clave Maestra',
                    'url'   => route('tenant.admin.master-key.index', ['store' => $this->store->slug]),
                    'icon'  => 'lock-keyhole'
                ],
                [
                    'label' => 'Perfil del Negocio',
                    'url'   => route('tenant.admin.business-profile.index', ['store' => $this->store->slug]),
                    'icon'  => 'store'
                ],
                [
                    'label' => 'Plan y Facturación',
                    'url'   => route('tenant.admin.billing.index', ['store' => $this->store->slug]),
                    'icon'  => 'credit-card'
                ],
                [
                    'label'  => 'Cerrar sesión',
                    'url'    => route('tenant.admin.logout', $this->store->slug),
                    'method' => 'POST',
                    'icon'   => 'log-out'
                ]
            ]
        ];

        // Si no hay avatar, usar inicial del usuario
        if (!$footer['avatar'] && auth()->user()) {
            $footer['initials'] = strtoupper(substr(auth()->user()->name, 0, 1));
        }

        return $footer;
    }
}

