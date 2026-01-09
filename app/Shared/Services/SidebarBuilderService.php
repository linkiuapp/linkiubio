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
     * Sistema unificado de colores para badges del sidebar
     *
     * @param string $type Tipo de badge: 'count', 'important', 'warning', 'success', 'info', 'error', 'new', 'beta'
     * @param int|null $value Valor para badges de tipo count (usado para calcular nivel de alerta)
     * @param int|null $max Valor máximo para badges de tipo count
     * @return string Clases de Tailwind CSS
     */
    protected function getBadgeColor(string $type = 'count', ?int $value = null, ?int $max = null): string
    {
        // Para badges de contador con valores/límites, calcular nivel de alerta automáticamente
        if ($type === 'count' && $value !== null && $max !== null && $max > 0) {
            $percent = ($value / $max) * 100;
            if ($percent >= 90) {
                return 'bg-red-500 text-white dark:bg-red-600';
            } elseif ($percent >= 70) {
                return 'bg-yellow-500 text-white dark:bg-yellow-600';
            } else {
                return 'bg-gray-500 text-white dark:bg-gray-600';
            }
        }

        // Colores predefinidos por tipo
        return match ($type) {
            'new' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
            'beta' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
            'important' => 'bg-red-500 text-white dark:bg-red-600',
            'warning' => 'bg-yellow-500 text-white dark:bg-yellow-600',
            'success' => 'bg-green-500 text-white dark:bg-green-600',
            'info' => 'bg-blue-500 text-white dark:bg-blue-600',
            'error' => 'bg-red-500 text-white dark:bg-red-600',
            'count' => 'bg-gray-500 text-white dark:bg-gray-600',
            default => 'bg-gray-500 text-white dark:bg-gray-600',
        };
    }

    /**
     * Construir todos los items del sidebar para TenantAdmin
     */
    public function buildTenantAdminSidebar(): array
    {
        $items = [];

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

        // Banner de suscripción al final (si aplica)
        $subscriptionBanner = $this->buildSubscriptionBanner();
        if ($subscriptionBanner) {
            $items[] = ['type' => 'separator'];
            $items[] = $subscriptionBanner;
        }

        return $items;
    }

    /**
     * Construir banner de suscripción si está por vencer, en período de prueba, grace_period o suspendida
     */
    protected function buildSubscriptionBanner(): ?array
    {
        if (!$this->store) {
            return null;
        }

        $subscription = $this->store->subscription;
        if (!$subscription) {
            return null;
        }

        $now = now();
        $status = $subscription->status;
        $planName = $subscription->plan->name ?? 'Plan';
        $billingUrl = route('tenant.admin.billing.index', $this->store->slug);
        $checkoutUrl = route('tenant.admin.billing.checkout', $this->store->slug);

        // Caso especial: Tienda suspendida
        if ($this->store->status === 'suspended' || $status === 'suspended') {
            return $this->buildSuspendedBanner($checkoutUrl, $billingUrl);
        }

        // Caso especial: En período de gracia
        if ($status === 'grace_period' && $subscription->grace_period_end) {
            return $this->buildGracePeriodBanner($subscription, $checkoutUrl, $billingUrl);
        }

        // Calcular fechas y días restantes
        $isInTrial = $subscription->trial_end && $now->lte($subscription->trial_end);
        $endDate = $isInTrial ? $subscription->trial_end : $subscription->current_period_end;
        $startDate = $isInTrial ? $subscription->trial_start : $subscription->current_period_start;
        
        if (!$endDate) {
            return null;
        }

        // Calcular días restantes correctamente
        $daysRemaining = (int) $now->diffInDays($endDate, false);
        
        // Calcular progreso para la barra (% consumido del período)
        $totalDays = $startDate ? (int) $startDate->diffInDays($endDate) : 30;
        $daysUsed = $totalDays - max(0, $daysRemaining);
        $progressPercent = $totalDays > 0 ? round(min(100, max(0, ($daysUsed / $totalDays) * 100))) : 0;
        
        // Fecha formateada en español
        $endDateFormatted = $endDate->locale('es')->isoFormat('D MMM YYYY');
        
        // Solo mostrar banner si quedan 15 días o menos, o si está en trial
        if ($daysRemaining > 15 && !$isInTrial) {
            return null;
        }

        // Determinar estilo según urgencia
        if ($daysRemaining <= 0) {
            $bgColor = 'bg-red-50';
            $borderColor = 'border-red-200';
            $progressBg = 'bg-red-100';
            $progressBar = 'bg-red-500';
            $iconBg = 'bg-red-100';
            $iconColor = 'text-red-600';
            $titleColor = 'text-red-800';
            $subtitleColor = 'text-red-600';
            $icon = 'alert-triangle';
            $title = $isInTrial ? '¡Prueba finalizada!' : '¡Suscripción vencida!';
            $subtitle = 'Renueva para continuar';
        } elseif ($daysRemaining <= 3) {
            $bgColor = 'bg-red-50';
            $borderColor = 'border-red-200';
            $progressBg = 'bg-red-100';
            $progressBar = 'bg-red-500';
            $iconBg = 'bg-red-100';
            $iconColor = 'text-red-600';
            $titleColor = 'text-red-800';
            $subtitleColor = 'text-red-600';
            $icon = 'alert-circle';
            $title = $isInTrial ? 'Prueba por terminar' : '¡Atención!';
            $subtitle = "{$daysRemaining} día" . ($daysRemaining > 1 ? 's' : '') . " restante" . ($daysRemaining > 1 ? 's' : '');
        } elseif ($daysRemaining <= 7) {
            $bgColor = 'bg-amber-50';
            $borderColor = 'border-amber-200';
            $progressBg = 'bg-amber-100';
            $progressBar = 'bg-amber-500';
            $iconBg = 'bg-amber-100';
            $iconColor = 'text-amber-600';
            $titleColor = 'text-amber-800';
            $subtitleColor = 'text-amber-600';
            $icon = 'clock';
            $title = $isInTrial ? 'Período de prueba' : 'Tu suscripción';
            $subtitle = "{$daysRemaining} días restantes";
        } else {
            $bgColor = 'bg-blue-50';
            $borderColor = 'border-blue-200';
            $progressBg = 'bg-blue-100';
            $progressBar = 'bg-blue-500';
            $iconBg = 'bg-blue-100';
            $iconColor = 'text-blue-600';
            $titleColor = 'text-blue-800';
            $subtitleColor = 'text-blue-600';
            $icon = 'sparkles';
            $title = $isInTrial ? 'Período de prueba' : $planName;
            $subtitle = "{$daysRemaining} días restantes";
        }

        $html = <<<HTML
<div class="mx-2 mb-3 mt-3">
    <div class="rounded-xl {$bgColor} border {$borderColor} p-4 shadow-sm">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg {$iconBg}">
                <i data-lucide="{$icon}" class="h-5 w-5 {$iconColor}"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold {$titleColor}">{$title}</p>
                <p class="text-xs {$subtitleColor}">{$subtitle}</p>
            </div>
        </div>
        
        <!-- Barra de progreso -->
        <div class="mb-4">
            <div class="flex items-center justify-between text-xs text-gray-500 mb-1.5">
                <span>{$progressPercent}% del período</span>
                <span class="font-medium">{$endDateFormatted}</span>
            </div>
            <div class="h-2.5 w-full overflow-hidden rounded-full {$progressBg}">
                <div class="h-full {$progressBar} rounded-full transition-all duration-500" style="width: {$progressPercent}%"></div>
            </div>
        </div>
        
        <!-- Botones -->
        <div class="flex gap-2">
            <a href="{$checkoutUrl}" class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700 transition-colors">
                <i data-lucide="credit-card" class="h-3.5 w-3.5"></i>
                Pagar ahora
            </a>
            <a href="{$billingUrl}" class="inline-flex items-center justify-center gap-1 rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                Ver plan
            </a>
        </div>
    </div>
</div>
HTML;

        return [
            'type' => 'custom',
            'content' => $html,
        ];
    }

    /**
     * Banner para tienda suspendida
     */
    protected function buildSuspendedBanner(string $checkoutUrl, string $billingUrl): array
    {
        $html = <<<HTML
<div class="mx-2 mb-3 mt-3">
    <div class="rounded-xl bg-red-100 border-2 border-red-300 p-4 shadow-md">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-200">
                <i data-lucide="alert-octagon" class="h-6 w-6 text-red-700"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-red-800">Tienda Suspendida</p>
                <p class="text-xs text-red-600">Regulariza tu pago para reactivar</p>
            </div>
        </div>
        
        <!-- Mensaje -->
        <p class="text-xs text-red-700 mb-4 leading-relaxed">
            Tu tienda no está visible para tus clientes. Paga ahora para reactivarla inmediatamente.
        </p>
        
        <!-- Botón principal -->
        <a href="{$checkoutUrl}" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-red-700 transition-colors shadow-lg">
            <i data-lucide="credit-card" class="h-4 w-4"></i>
            Pagar y Reactivar Ahora
        </a>
    </div>
</div>
HTML;

        return [
            'type' => 'custom',
            'content' => $html,
        ];
    }

    /**
     * Banner para período de gracia
     */
    protected function buildGracePeriodBanner($subscription, string $checkoutUrl, string $billingUrl): array
    {
        $graceEnd = $subscription->grace_period_end;
        $daysLeft = max(0, (int) now()->diffInDays($graceEnd, false));
        $graceEndFormatted = $graceEnd->locale('es')->isoFormat('D MMM YYYY');

        $html = <<<HTML
<div class="mx-2 mb-3 mt-3">
    <div class="rounded-xl bg-orange-50 border-2 border-orange-300 p-4 shadow-sm">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100">
                <i data-lucide="hourglass" class="h-5 w-5 text-orange-600"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-orange-800">Período de Gracia</p>
                <p class="text-xs text-orange-600">{$daysLeft} día(s) para pagar</p>
            </div>
        </div>
        
        <!-- Mensaje -->
        <p class="text-xs text-orange-700 mb-3 leading-relaxed">
            Tu período de prueba terminó. Tienes hasta el <strong>{$graceEndFormatted}</strong> para pagar y evitar la suspensión.
        </p>
        
        <!-- Botones -->
        <div class="flex gap-2">
            <a href="{$checkoutUrl}" class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-lg bg-orange-600 px-3 py-2 text-xs font-semibold text-white hover:bg-orange-700 transition-colors">
                <i data-lucide="credit-card" class="h-3.5 w-3.5"></i>
                Pagar ahora
            </a>
            <a href="{$billingUrl}" class="inline-flex items-center justify-center gap-1 rounded-lg border border-orange-300 bg-white px-3 py-2 text-xs font-medium text-orange-700 hover:bg-orange-50 transition-colors">
                Ver detalles
            </a>
        </div>
    </div>
</div>
HTML;

        return [
            'type' => 'custom',
            'content' => $html,
        ];
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

        // Herramientas
        $items = array_merge($items, $this->buildSuperAdminToolsSection());

        // Anuncios y Configuración
        $items = array_merge($items, $this->buildSuperAdminAnnouncementsSection());

        // Configuración de Tiendas
        $items = array_merge($items, $this->buildSuperAdminConfigurationSection());

        // Integraciones
        $items = array_merge($items, $this->buildSuperAdminIntegrationsSection());

        // LinkiuDev - Gestión de Proyectos y Suscripciones Dev
        $items = array_merge($items, $this->buildLinkiuDevSection());

        return $items;
    }

    /**
     * Construir sección LinkiuDev para SuperAdmin (con Projects y Suscripciones)
     */
    protected function buildLinkiuDevSection(): array
    {
        $items = [];

        // Contar proyectos activos y tareas de hoy
        $activeProjects = 0;
        $totalToday = 0;
        $activeSubs = 0;
        $pendingPayments = 0;
        
        try {
            $activeProjects = \App\Features\SuperLinkiu\Models\DevProject::active()->count();
            $todayTasks = \App\Features\SuperLinkiu\Models\DevTask::scheduledToday()->active()->count();
            $todayEvents = \App\Features\SuperLinkiu\Models\DevAgendaEntry::today()->count();
            $totalToday = $todayTasks + $todayEvents;
            
            $activeSubs = \App\Features\SuperLinkiu\Models\SubSubscription::active()->count();
            $pendingPayments = \App\Features\SuperLinkiu\Models\SubSubscription::pendingPayment()->count();
            $expiredSubs = \App\Features\SuperLinkiu\Models\SubSubscription::expired()->count();
            $pendingPayments += $expiredSubs;
        } catch (\Exception $e) {
            // Si hay error en las consultas, usar valores por defecto
        }

        // Sección principal LinkiuDev
        $items[] = [
            'label'  => 'LinkiuDev',
            'icon'   => 'code-2',
            'active' => request()->routeIs('superlinkiu.linkiudev.*') || request()->routeIs('superlinkiu.subscriptiondev.*'),
            'children' => [
                // === Projects Linkiu ===
                [
                    'label'  => 'Projects Linkiu',
                    'icon'   => 'folder-kanban',
                    'active' => request()->routeIs('superlinkiu.linkiudev.*'),
                    'children' => [
                        [
                            'label'  => 'Dashboard',
                            'url'    => '/superlinkiu/linkiudev',
                            'icon'   => 'layout-dashboard',
                            'active' => request()->routeIs('superlinkiu.linkiudev.dashboard'),
                        ],
                        [
                            'label'  => 'Clientes',
                            'url'    => '/superlinkiu/linkiudev/clients',
                            'icon'   => 'users',
                            'active' => request()->routeIs('superlinkiu.linkiudev.clients.*'),
                        ],
                        [
                            'label'      => 'Proyectos',
                            'url'        => '/superlinkiu/linkiudev/projects',
                            'icon'       => 'folder-git-2',
                            'active'     => request()->routeIs('superlinkiu.linkiudev.projects.*'),
                            'badge'      => $activeProjects > 0 ? (string)$activeProjects : null,
                            'badgeColor' => $activeProjects > 0 ? 'bg-blue-500 text-white' : null,
                        ],
                        [
                            'label'  => 'Tareas',
                            'url'    => '/superlinkiu/linkiudev/tasks',
                            'icon'   => 'list-checks',
                            'active' => request()->routeIs('superlinkiu.linkiudev.tasks.*'),
                        ],
                        [
                            'label'      => 'Mi Agenda',
                            'url'        => '/superlinkiu/linkiudev/agenda',
                            'icon'       => 'calendar-days',
                            'active'     => request()->routeIs('superlinkiu.linkiudev.agenda.*'),
                            'badge'      => $totalToday > 0 ? (string)$totalToday : null,
                            'badgeColor' => $totalToday > 0 ? 'bg-green-500 text-white' : null,
                        ],
                        [
                            'label'  => 'Configuración',
                            'url'    => '/superlinkiu/linkiudev/settings',
                            'icon'   => 'settings',
                            'active' => request()->routeIs('superlinkiu.linkiudev.settings.*'),
                        ],
                    ],
                ],
                // === Suscripciones ===
                [
                    'label'  => 'Suscripciones',
                    'icon'   => 'credit-card',
                    'active' => request()->routeIs('superlinkiu.subscriptiondev.*'),
                    'children' => [
                        [
                            'label'  => 'Dashboard',
                            'url'    => '/superlinkiu/subscriptiondev',
                            'icon'   => 'layout-dashboard',
                            'active' => request()->routeIs('superlinkiu.subscriptiondev.dashboard'),
                        ],
                        [
                            'label'  => 'Clientes',
                            'url'    => '/superlinkiu/subscriptiondev/clients',
                            'icon'   => 'users',
                            'active' => request()->routeIs('superlinkiu.subscriptiondev.clients.*'),
                        ],
                        [
                            'label'  => 'Tipos de Servicio',
                            'url'    => '/superlinkiu/subscriptiondev/service-types',
                            'icon'   => 'tags',
                            'active' => request()->routeIs('superlinkiu.subscriptiondev.service-types.*'),
                        ],
                        [
                            'label'      => 'Suscripciones',
                            'url'        => '/superlinkiu/subscriptiondev/subscriptions',
                            'icon'       => 'file-text',
                            'active'     => request()->routeIs('superlinkiu.subscriptiondev.subscriptions.*'),
                            'badge'      => $activeSubs > 0 ? (string)$activeSubs : null,
                            'badgeColor' => $activeSubs > 0 ? 'bg-green-500 text-white' : null,
                        ],
                        [
                            'label'      => 'Pagos',
                            'url'        => '/superlinkiu/subscriptiondev/payments',
                            'icon'       => 'wallet',
                            'active'     => request()->routeIs('superlinkiu.subscriptiondev.payments.*'),
                            'badge'      => $pendingPayments > 0 ? (string)$pendingPayments : null,
                            'badgeColor' => $pendingPayments > 0 ? 'bg-yellow-500 text-white' : null,
                        ],
                    ],
                ],
            ],
        ];

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

        return $items;
    }

    /**
     * Construir sección de administración para SuperAdmin
     */
    protected function buildSuperAdminAdministrationSection(): array
    {
        $items = [];

        // Administración (expandible)
        $pendingCount = \App\Shared\Models\Store::where('approval_status', 'pending_approval')->count();
        $pendingRecoveryCount = \App\Shared\Models\MasterKeyRecoveryRequest::where('status', 'pending')->count();
        $pendingReportsCount = \App\Shared\Models\StoreReport::where('status', 'pending')->count();

        $items[] = [
            'label'  => 'Administración',
            'icon'   => 'settings',
            'active' => request()->routeIs('superlinkiu.stores.*') || 
                       request()->routeIs('superlinkiu.store-requests.*') ||
                       request()->routeIs('superlinkiu.store-statistics.*') ||
                       request()->routeIs('superlinkiu.user-management.*') ||
                       request()->routeIs('superlinkiu.master-key-recovery.*') ||
                       request()->routeIs('superlinkiu.store-reports.*'),
            'children' => [
                // Tiendas (expandible)
                [
                    'label'  => 'Tiendas',
                    'icon'   => 'store',
                    'active' => request()->routeIs('superlinkiu.stores.*') || request()->routeIs('superlinkiu.store-requests.*') || request()->routeIs('superlinkiu.store-statistics.*'),
                    'children' => [
                        [
                            'label'  => 'Gestión de tiendas',
                            'url'    => route('superlinkiu.stores.index'),
                            'icon'   => 'store',
                            'active' => request()->routeIs('superlinkiu.stores.*') && !request()->routeIs('superlinkiu.store-requests.*') && !request()->routeIs('superlinkiu.store-statistics.*')
                        ],
                        [
                            'label'  => 'Estadísticas de Tiendas',
                            'url'    => route('superlinkiu.store-statistics.index'),
                            'icon'   => 'bar-chart-2',
                            'active' => request()->routeIs('superlinkiu.store-statistics.*')
                        ],
                        [
                            'label'      => 'Solicitudes de Tiendas',
                            'url'        => route('superlinkiu.store-requests.index'),
                            'icon'       => 'file-text',
                            'active'     => request()->routeIs('superlinkiu.store-requests.*'),
                            'badge'      => $pendingCount > 0 ? (string)$pendingCount : null,
                            'badgeColor' => $pendingCount > 0 ? 'bg-warning-300 text-white' : null
                        ],
                    ],
                ],
                // Gestión de Usuarios
                [
                    'label'  => 'Gestión de Usuarios',
                    'url'    => route('superlinkiu.user-management.index'),
                    'icon'   => 'users',
                    'active' => request()->routeIs('superlinkiu.user-management.*')
                ],
                // Reportes y Solicitudes (expandible)
                [
                    'label'  => 'Reportes y Solicitudes',
                    'icon'   => 'alert-triangle',
                    'active' => request()->routeIs('superlinkiu.master-key-recovery.*') || request()->routeIs('superlinkiu.store-reports.*'),
                    'children' => [
                        [
                            'label'      => 'Reportes de Tiendas',
                            'url'        => route('superlinkiu.store-reports.index'),
                            'icon'       => 'alert-triangle',
                            'active'     => request()->routeIs('superlinkiu.store-reports.*'),
                            'badge'      => $pendingReportsCount > 0 ? (string)$pendingReportsCount : null,
                            'badgeColor' => $pendingReportsCount > 0 ? 'bg-error-300 text-white' : null
                        ],
                        [
                            'label'      => 'Recuperación Clave Maestra',
                            'url'        => route('superlinkiu.master-key-recovery.index'),
                            'icon'       => 'lock-keyhole',
                            'active'     => request()->routeIs('superlinkiu.master-key-recovery.*'),
                            'badge'      => $pendingRecoveryCount > 0 ? (string)$pendingRecoveryCount : null,
                            'badgeColor' => $pendingRecoveryCount > 0 ? 'bg-warning-300 text-white' : null
                        ],
                    ],
                ],
            ],
        ];

        return $items;
    }

    /**
     * Construir sección de planes y facturación para SuperAdmin
     */
    protected function buildSuperAdminBillingSection(): array
    {
        $items = [];

        // Planes y Facturación (expandible)
        $items[] = [
            'label'  => 'Planes y Facturación',
            'icon'   => 'credit-card',
            'active' => request()->routeIs('superlinkiu.plans.*') ||
                       request()->routeIs('superlinkiu.invoices.*') ||
                       request()->routeIs('superlinkiu.billing-settings.*'),
            'children' => [
                [
                    'label'  => 'Planes disponibles',
                    'url'    => route('superlinkiu.plans.index'),
                    'icon'   => 'award',
                    'active' => request()->routeIs('superlinkiu.plans.*')
                ],
                [
                    'label'  => 'Facturación',
                    'url'    => route('superlinkiu.invoices.index'),
                    'icon'   => 'receipt',
                    'active' => request()->routeIs('superlinkiu.invoices.*')
                ],
                [
                    'label'  => 'Configurar Facturas',
                    'url'    => route('superlinkiu.billing-settings.index'),
                    'icon'   => 'settings',
                    'active' => request()->routeIs('superlinkiu.billing-settings.*')
                ],
            ],
        ];

        return $items;
    }

    /**
     * Construir sección de tickets para SuperAdmin
     */
    protected function buildSuperAdminTicketsSection(): array
    {
        $items = [];

        // Soporte (expandible)
        $openTicketsCount = \App\Shared\Models\Ticket::whereIn('status', ['open', 'in_progress'])->count();
        $items[] = [
            'label'  => 'Soporte',
            'icon'   => 'headphones',
            'active' => request()->routeIs('superlinkiu.tickets.*') || request()->routeIs('superlinkiu.email.*'),
            'children' => [
                [
                    'label'      => 'Lista de tickets',
                    'url'        => route('superlinkiu.tickets.index'),
                    'icon'       => 'ticket',
                    'active'     => request()->routeIs('superlinkiu.tickets.*') && !request()->routeIs('superlinkiu.email.*'),
                    'badge'      => $openTicketsCount > 0 ? (string)$openTicketsCount : null,
                    'badgeColor' => $openTicketsCount > 0 ? 'bg-error-200 text-accent-50' : null
                ],
                [
                    'label'  => 'Configuración de Email',
                    'url'    => route('superlinkiu.email.configuration'),
                    'icon'   => 'mail',
                    'active' => request()->routeIs('superlinkiu.email.*')
                ],
            ],
        ];

        return $items;
    }

    /**
     * Construir sección de herramientas para SuperAdmin
     */
    protected function buildSuperAdminToolsSection(): array
    {
        $items = [];

        // Herramientas (expandible)
        $pendingCount = \App\Models\PendingRegistration::pending()->count();
        $planChangeCount = \App\Shared\Models\PlanChangeRequest::pending()->count();

        $items[] = [
            'label'  => 'Herramientas',
            'icon'   => 'wrench',
            'active' => request()->routeIs('superlinkiu.monitoring.*') ||
                       request()->routeIs('superlinkiu.pending-registrations.*') ||
                       request()->routeIs('superlinkiu.registration-payment-settings.*') ||
                       request()->routeIs('superlinkiu.plan-change-requests.*') ||
                       request()->routeIs('superlinkiu.tools.*'),
            'children' => [
                [
                    'label'  => 'Monitoreo',
                    'url'    => route('superlinkiu.monitoring.index'),
                    'icon'   => 'activity',
                    'active' => request()->routeIs('superlinkiu.monitoring.*'),
                ],
                [
                    'label'  => 'Registros Pendientes',
                    'url'    => route('superlinkiu.pending-registrations.index'),
                    'icon'   => 'user-check',
                    'active' => request()->routeIs('superlinkiu.pending-registrations.*'),
                    'badge'  => $pendingCount > 0 ? $pendingCount : null,
                    'badge_color' => 'yellow',
                ],
                [
                    'label'  => 'Solicitudes de Plan',
                    'url'    => route('superlinkiu.plan-change-requests.index'),
                    'icon'   => 'repeat',
                    'active' => request()->routeIs('superlinkiu.plan-change-requests.*'),
                    'badge'  => $planChangeCount > 0 ? $planChangeCount : null,
                    'badge_color' => 'yellow',
                ],
                [
                    'label'  => 'Datos de Pago',
                    'url'    => route('superlinkiu.registration-payment-settings.index'),
                    'icon'   => 'qr-code',
                    'active' => request()->routeIs('superlinkiu.registration-payment-settings.*'),
                ],
                [
                    'label'  => 'Eliminar Pedidos',
                    'url'    => route('superlinkiu.tools.delete-order'),
                    'icon'   => 'trash-2',
                    'active' => request()->routeIs('superlinkiu.tools.*')
                ],
            ],
        ];

        return $items;
    }

    /**
     * Construir sección de anuncios y configuración para SuperAdmin
     */
    protected function buildSuperAdminAnnouncementsSection(): array
    {
        // Esta sección se ha movido a buildSuperAdminConfigurationSection
        return [];
    }

    /**
     * Construir sección de configuración para SuperAdmin
     */
    protected function buildSuperAdminConfigurationSection(): array
    {
        $items = [];

        // Configuración (expandible)
        $totalCategories = \App\Shared\Models\BusinessCategory::count();
        $autoApproveCategories = \App\Shared\Models\BusinessCategory::where('requires_manual_approval', false)->where('is_active', true)->count();
        $totalIcons = \App\Shared\Models\CategoryIcon::count();
        $activeIcons = \App\Shared\Models\CategoryIcon::where('is_active', true)->count();
        $totalAnnouncements = \App\Shared\Models\PlatformAnnouncement::where('is_active', true)->count();

        $items[] = [
            'label'  => 'Configuración',
            'icon'   => 'sliders-horizontal',
            'active' => request()->routeIs('superlinkiu.business-categories.*') ||
                       request()->routeIs('superlinkiu.category-icons.*') ||
                       request()->routeIs('superlinkiu.announcements.*'),
            'children' => [
                [
                    'label'      => 'Categorías de Negocio',
                    'url'        => route('superlinkiu.business-categories.index'),
                    'icon'       => 'tag',
                    'active'     => request()->routeIs('superlinkiu.business-categories.*'),
                    'badge'      => $totalCategories > 0 ? "{$autoApproveCategories}/{$totalCategories}" : null,
                    'badgeColor' => $totalCategories > 0 ? 'bg-success-300 text-white' : null
                ],
                [
                    'label'      => 'Iconos de Categorías',
                    'url'        => route('superlinkiu.category-icons.index'),
                    'icon'       => 'image',
                    'active'     => request()->routeIs('superlinkiu.category-icons.*'),
                    'badge'      => $totalIcons > 0 ? "{$activeIcons}/{$totalIcons}" : null,
                    'badgeColor' => $totalIcons > 0 ? 'bg-info-300 text-accent-50' : null
                ],
                [
                    'label'      => 'Anuncios de Linkiu',
                    'url'        => route('superlinkiu.announcements.index'),
                    'icon'       => 'megaphone',
                    'active'     => request()->routeIs('superlinkiu.announcements.*'),
                    'badge'      => $totalAnnouncements > 0 ? (string)$totalAnnouncements : null,
                    'badgeColor' => $totalAnnouncements > 0 ? 'bg-primary-200 text-accent-50' : null
                ],
            ],
        ];

        return $items;
    }

    /**
     * Construir sección de integraciones para SuperAdmin
     */
    protected function buildSuperAdminIntegrationsSection(): array
    {
        $items = [];

        // Integraciones (expandible)
        $items[] = [
            'label'  => 'Integraciones',
            'icon'   => 'plug',
            'active' => request()->routeIs('superlinkiu.integrations.*'),
            'children' => [
                [
                    'label'  => 'Pasarelas de Pagos',
                    'icon'   => 'credit-card',
                    'active' => request()->routeIs('superlinkiu.integrations.payment-gateways.*'),
                    'children' => [
                        [
                            'label'  => 'Epayco',
                            'url'    => route('superlinkiu.integrations.payment-gateways.epayco.index'),
                            'icon'   => 'wallet',
                            'active' => request()->routeIs('superlinkiu.integrations.payment-gateways.epayco.*'),
                        ],
                    ],
                ],
            ],
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
            'badge'      => (string)$pendingOrders,
            'badgeColor' => $pendingOrders > 0 ? $this->getBadgeColor('important') : $this->getBadgeColor('count')
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
        $items[] = [
            'label'      => 'Categorías',
            'url'        => route('tenant.admin.categories.index', ['store' => $this->store->slug]),
            'icon'       => 'layout-list',
            'active'     => request()->routeIs('tenant.admin.categories.*'),
            'badge'      => "{$categoriesUsed}/{$categoriesLimit}",
            'badgeColor' => $this->getBadgeColor('count', $categoriesUsed, $categoriesLimit)
        ];

        // Variables
        $variablesUsed = $this->store->variables_count ?? 0;
        $variablesLimit = $this->store->plan->max_variables ?? 50;
        $items[] = [
            'label'      => 'Variables',
            'url'        => route('tenant.admin.variables.index', ['store' => $this->store->slug]),
            'icon'       => 'tag',
            'active'     => request()->routeIs('tenant.admin.variables.*'),
            'badge'      => "{$variablesUsed}/{$variablesLimit}",
            'badgeColor' => $this->getBadgeColor('count', $variablesUsed, $variablesLimit)
        ];

        // Productos
        $productsUsed = $this->store->products_count ?? 0;
        $productsLimit = $this->store->plan->max_products;
        $items[] = [
            'label'      => 'Productos',
            'url'        => route('tenant.admin.products.index', ['store' => $this->store->slug]),
            'icon'       => 'package',
            'active'     => request()->routeIs('tenant.admin.products.*') && !request()->routeIs('tenant.admin.inventario.*'),
            'badge'      => "{$productsUsed}/{$productsLimit}",
            'badgeColor' => $this->getBadgeColor('count', $productsUsed, $productsLimit)
        ];

        // Inventario (submenú de productos)
        $items[] = [
            'label'      => 'Inventario',
            'url'        => route('tenant.admin.inventario.index', ['store' => $this->store->slug]),
            'icon'       => 'warehouse',
            'active'     => request()->routeIs('tenant.admin.inventario.*'),
            'indent'     => true
        ];

        // Gestión de Envíos (si está habilitado o es ecommerce/dropshipping)
        $shippingEnabled = featureEnabled($this->store, 'shipping') || 
                          featureEnabled($this->store, 'shipping') ||
                          in_array($this->vertical, ['ecommerce', 'dropshipping', 'restaurant']);
        
        if ($shippingEnabled) {
            $simpleShipping = \App\Features\TenantAdmin\Models\SimpleShipping::where('store_id', $this->store->id)->first();
            $currentZones = $simpleShipping ? $simpleShipping->zones()->count() : 0;
            $maxZones = $this->store->plan->max_delivery_zones ?? 3;
            
            $items[] = [
                'label'      => 'Gestión de Envíos',
                'url'        => route('tenant.admin.simple-shipping.index', ['store' => $this->store->slug]),
                'icon'       => 'truck',
                'active'     => request()->routeIs('tenant.admin.simple-shipping.*'),
                'badge'      => "{$currentZones}/{$maxZones}",
                'badgeColor' => $this->getBadgeColor('count', $currentZones, $maxZones)
            ];
        }

        // Métodos de Pago
        $paymentMethodsUsed = $this->store->paymentMethods()->active()->count();
        $paymentMethodsLimit = $this->store->plan->max_payment_methods ?? 4;
        $items[] = [
            'label'      => 'Métodos de Pago',
            'url'        => route('tenant.admin.payment-methods.index', ['store' => $this->store->slug]),
            'icon'       => 'dock',
            'active'     => request()->routeIs('tenant.admin.payment-methods.*'),
            'badge'      => "{$paymentMethodsUsed}/{$paymentMethodsLimit}",
            'badgeColor' => $this->getBadgeColor('count', $paymentMethodsUsed, $paymentMethodsLimit)
        ];

        // Sedes
        $locationsUsed = $this->store->locations_count ?? 0;
        $locationsLimit = $this->store->plan->max_locations ?? $this->store->plan->max_sedes ?? 1;
        $items[] = [
            'label'      => 'Sedes',
            'url'        => route('tenant.admin.locations.index', ['store' => $this->store->slug]),
            'icon'       => 'store',
            'active'     => request()->routeIs('tenant.admin.locations.*'),
            'badge'      => "{$locationsUsed}/{$locationsLimit}",
            'badgeColor' => $this->getBadgeColor('count', $locationsUsed, $locationsLimit)
        ];

        return $items;
    }

    /**
     * Construir sección de reservas y servicios (según vertical)
     */
    protected function buildReservationsAndServicesSection(): array
    {
        $items = [];

        // Notificaciones WhatsApp (si está habilitado en el plan)
        if ($this->store->plan && $this->store->plan->whatsapp_integration) {
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
        $items[] = [
            'label'      => 'Cupones',
            'url'        => route('tenant.admin.coupons.index', ['store' => $this->store->slug]),
            'icon'       => 'ticket-percent',
            'active'     => request()->routeIs('tenant.admin.coupons.*'),
            'badge'      => "{$couponsUsed}/{$couponsLimit}",
            'badgeColor' => $this->getBadgeColor('count', $couponsUsed, $couponsLimit)
        ];

        // Slider
        $slidersUsed = $this->store->sliders_count ?? 0;
        $slidersLimit = $this->store->plan->max_sliders ?? $this->store->plan->max_slider ?? 1;
        $items[] = [
            'label'      => 'Slider',
            'url'        => route('tenant.admin.sliders.index', ['store' => $this->store->slug]),
            'icon'       => 'images',
            'active'     => request()->routeIs('tenant.admin.sliders.*'),
            'badge'      => "{$slidersUsed}/{$slidersLimit}",
            'badgeColor' => $this->getBadgeColor('count', $slidersUsed, $slidersLimit)
        ];

        // Ticker
        $tickersUsed = $this->store->tickers()->count() ?? 0;
        $items[] = [
            'label'      => 'Ticker de Promociones',
            'url'        => route('tenant.admin.ticker.index', ['store' => $this->store->slug]),
            'icon'       => 'scroll-text',
            'active'     => request()->routeIs('tenant.admin.ticker.*'),
            'badge'      => $tickersUsed > 0 ? "{$tickersUsed}/8" : null,
            'badgeColor' => $tickersUsed > 0 ? $this->getBadgeColor('count', $tickersUsed, 8) : null
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
        $ticketsThisMonth = $this->store->tickets()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $ticketsLimit = $this->store->plan->max_tickets_per_month ?? 999;
        $openTicketsCount = $this->store->tickets()->whereIn('status', ['open', 'in_progress'])->count();
        
        $items[] = [
            'label'      => 'Soporte y Tickets',
            'url'        => route('tenant.admin.tickets.index', ['store' => $this->store->slug]),
            'icon'       => 'server-crash',
            'active'     => request()->routeIs('tenant.admin.tickets.*'),
            'badge'      => "{$ticketsThisMonth}/{$ticketsLimit}",
            'badgeColor' => $this->getBadgeColor('count', $ticketsThisMonth, $ticketsLimit),
            'subBadge'   => $openTicketsCount > 0 ? (string)$openTicketsCount : null,
            'subBadgeColor' => $openTicketsCount > 0 ? $this->getBadgeColor('error') : null
        ];

        // Anuncios de Linkiu
        $unreadAnnouncements = $this->store->unread_announcements_count ?? 0;
        $items[] = [
            'label'      => 'Anuncios de Linkiu',
            'url'        => route('tenant.admin.announcements.index', ['store' => $this->store->slug]),
            'icon'       => 'megaphone',
            'active'     => request()->routeIs('tenant.admin.announcements.*'),
            'badge'      => $unreadAnnouncements > 0 ? (string)$unreadAnnouncements : null,
            'badgeColor' => $unreadAnnouncements > 0 ? $this->getBadgeColor('info') : null
        ];

        return $items;
    }

    /**
     * Construir footer del sidebar
     */
    public function buildFooter(): array
    {
        // Usar el logo de StoreDesign (que tiene el accessor correcto para convertir path a URL)
        // Si no existe StoreDesign o no tiene logo, retornar null para usar avatar por defecto
        $profileImage = null;
        
        if ($this->store) {
            // Asegurar que la relación design esté cargada
            if (!$this->store->relationLoaded('design')) {
                $this->store->load('design');
            }
            
            // Obtener el logo de StoreDesign (tiene el accessor correcto)
            $profileImage = $this->store->design?->logo_url;
        }
        
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

