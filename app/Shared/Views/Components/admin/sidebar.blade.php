
@php
use Illuminate\Support\Facades\Storage;
use App\Shared\Models\BillingSetting;
@endphp

<!-- Sidebar -->
<aside class="fixed left-0 top-0 z-40 h-screen sidebar bg-accent-50 shadow-lg dark:bg-gray-800 transition-transform duration-300 ease-in-out flex flex-col" 
       x-data="{ sidebarOpen: true }"
       :class="{ '-translate-x-full': !sidebarOpen }">
    
    <!-- Logo/Header -->
    <div class="flex h-16 items-center justify-center px-6 border-b dark:border-gray-700 flex-shrink-0">
        <div class="flex items-center">
            <a href="{{ route('superlinkiu.dashboard') }}">
                @php
                    // ✅ LEER DESDE BASE DE DATOS (persistente)
                    $settings = BillingSetting::getInstance();
                    $appLogo = $settings->app_logo;
                    
                    $logoSrc = null;
                    if ($appLogo) {
                        try {
                            // ✅ Usar Storage::url() siempre - funciona en local Y en S3/Laravel Cloud
                            $logoSrc = Storage::disk('public')->url($appLogo);
                        } catch (\Exception $e) {
                            \Log::error('Error generando URL de logo en sidebar', [
                                'logo_path' => $appLogo,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                @endphp
                
                @if($logoSrc)
                    <img src="{{ $logoSrc }}" 
                         alt="{{ config('app.name') }}" 
                         class="w-auto h-10 mt-1"
                         onerror="this.src='{{ asset('assets/images/Logo_Linkiu.svg') }}';">
                @else
                    <img src="{{ asset('assets/images/Logo_Linkiu.svg') }}" alt="{{ config('app.name') }}" class="w-auto h-10 mt-1">
                @endif
            </a>
        </div>
        <!-- Toggle button for mobile -->
        <button @click="sidebarOpen = !sidebarOpen" 
                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 lg:hidden">
                <iconify-icon icon="solar:widget-2-outline" class="menu-icon"></iconify-icon>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-6">
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('superlinkiu.dashboard') }}" 
                   class="item-sidebar {{ request()->routeIs('superlinkiu.dashboard') ? 'item-sidebar-active' : '' }}">
                    <x-solar-widget-2-outline class="w-4 h-4 mr-2" />
                    Dashboard
                </a>
            </li>

            <h3 class="title-group-sidebar">
                Administración
            </h3>

            <!-- Tienda -->
            <li>
                <a href="{{ route('superlinkiu.stores.index') }}" 
                   class="item-sidebar {{ request()->routeIs('superlinkiu.stores.*') ? 'item-sidebar-active' : '' }}">
                    <x-solar-shop-outline class="w-4 h-4 mr-2" />
                    Gestión de tiendas
                </a>
            </li>

            <!-- Planes y Facturación -->
            <li x-data="{ planesOpen: false }">
                <button @click="planesOpen = !planesOpen" class="item-sidebar w-full flex justify-between">
                    <div class="flex items-center">
                        <x-solar-cup-first-outline class="w-4 h-4 mr-2" />
                        <span>Planes y Facturación</span>
                    </div>
                    <x-solar-alt-arrow-down-outline 
                        class="w-4 h-4 transition-transform"
                        x-bind:class="{ 'rotate-180': planesOpen }"
                    />
                </button>
                
                <ul x-show="planesOpen" class="pl-4 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('superlinkiu.plans.index') }}" class="item-sidebar {{ request()->routeIs('superlinkiu.plans.*') ? 'item-sidebar-active' : '' }}">
                            <x-solar-cup-first-outline class="w-4 h-4 mr-2" />
                            Planes disponibles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('superlinkiu.invoices.index') }}" class="item-sidebar {{ request()->routeIs('superlinkiu.invoices.*') ? 'item-sidebar-active' : '' }}">
                            <x-solar-bill-list-outline class="w-4 h-4 mr-2" />
                            Facturación
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('superlinkiu.billing-settings.index') }}" class="item-sidebar {{ request()->routeIs('superlinkiu.billing-settings.*') ? 'item-sidebar-active' : '' }}">
                            <x-solar-settings-outline class="w-4 h-4 mr-2" />
                            Configurar Facturas
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Gestión de usuarios -->
            <li x-data="{ usuariosOpen: false }">
                <button @click="usuariosOpen = !usuariosOpen" class="item-sidebar w-full flex justify-between">
                    <div class="flex items-center">
                        <x-solar-users-group-two-rounded-outline class="w-4 h-4 mr-2" />
                        <span>Gestión de usuarios</span>
                    </div>
                    <x-solar-alt-arrow-down-outline 
                        class="w-4 h-4 transition-transform"
                        x-bind:class="{ 'rotate-180': usuariosOpen }"
                    />
                </button>
                
                <ul x-show="usuariosOpen" class="pl-4 mt-1 space-y-1">
                    <li>
                        <a href="#" class="item-sidebar">
                            <x-solar-users-group-two-rounded-outline class="w-4 h-4 mr-2" />
                            Listado de usuarios
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item-sidebar">
                            <x-solar-shield-user-outline class="w-4 h-4 mr-2" />
                            Roles y permisos
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item-sidebar">
                            <x-solar-lock-password-outline class="w-4 h-4 mr-2" />
                            Verificación de usuarios
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item-sidebar">
                            <x-solar-lock-password-outline class="w-4 h-4 mr-2" />
                            Impersonación de usuarios
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Gestión de tickets -->

            <li x-data="{ ticketsOpen: false }">
                <button @click="ticketsOpen = !ticketsOpen" class="item-sidebar w-full flex justify-between">
                    <div class="flex items-center">
                        <x-solar-ticket-outline class="w-4 h-4 mr-2" />
                        <span>Gestión de tickets</span>
                    </div>
                    <x-solar-alt-arrow-down-outline 
                        class="w-4 h-4 transition-transform"
                        x-bind:class="{ 'rotate-180': ticketsOpen }"
                    />
                </button>
                
                <ul x-show="ticketsOpen" class="pl-4 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('superlinkiu.tickets.index') }}" class="item-sidebar {{ request()->routeIs('superlinkiu.tickets.*') && !request()->routeIs('superlinkiu.email.*') ? 'item-sidebar-active' : '' }}">
                            <x-solar-ticket-outline class="w-4 h-4 mr-2" />
                            Lista de tickets
                            @php
                                $openTicketsCount = \App\Shared\Models\Ticket::whereIn('status', ['open', 'in_progress'])->count();
                            @endphp
                            @if($openTicketsCount > 0)
                                <span class="ml-auto text-xs bg-error-200 text-accent-50 px-2 py-1 rounded-full">
                                    {{ $openTicketsCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('superlinkiu.tickets.create') }}" class="item-sidebar {{ request()->routeIs('superlinkiu.tickets.create') ? 'item-sidebar-active' : '' }}">
                            <x-solar-add-circle-outline class="w-4 h-4 mr-2" />
                            Crear ticket
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('superlinkiu.tickets.index', ['status' => 'open']) }}" class="item-sidebar">
                            <x-solar-clock-circle-outline class="w-4 h-4 mr-2" />
                            Tickets abiertos
                            @php
                                $openOnlyTicketsCount = \App\Shared\Models\Ticket::where('status', 'open')->count();
                            @endphp
                            @if($openOnlyTicketsCount > 0)
                                <span class="ml-auto text-xs bg-warning-300 text-black-500 px-2 py-1 rounded-full">
                                    {{ $openOnlyTicketsCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                </ul>
            </li>

            <!-- Anuncios de Linkiu -->
            <li>
                <a href="{{ route('superlinkiu.announcements.index') }}" class="item-sidebar {{ request()->routeIs('superlinkiu.announcements.*') ? 'item-sidebar-active' : '' }}">
                    <x-solar-bell-bing-outline class="w-4 h-4 mr-2" />
                    Anuncios de Linkiu
                    @php
                        $totalAnnouncements = \App\Shared\Models\PlatformAnnouncement::where('is_active', true)->count();
                    @endphp
                    @if($totalAnnouncements > 0)
                        <span class="ml-auto text-xs bg-primary-200 text-accent-50 px-2 py-1 rounded-full">
                            {{ $totalAnnouncements }}
                        </span>
                    @endif
                </a>
            </li>

            <!-- Configuración de Email -->
            <li x-data="{ emailOpen: {{ request()->routeIs('superlinkiu.email.*') ? 'true' : 'false' }} }">
                <button @click="emailOpen = !emailOpen" class="item-sidebar w-full flex items-center justify-between {{ request()->routeIs('superlinkiu.email.*') ? 'item-sidebar-active' : '' }}">
                    <div class="flex items-center">
                        <x-solar-settings-outline class="w-4 h-4 mr-2" />
                        Configuración de Email
                    </div>
                    <x-solar-alt-arrow-down-outline 
                        class="w-4 h-4 transition-transform"
                        x-bind:class="{ 'rotate-180': emailOpen }"
                    />
                </button>
                
                <ul x-show="emailOpen" class="pl-4 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('superlinkiu.email.configuration') }}" class="item-sidebar {{ request()->routeIs('superlinkiu.email.configuration') ? 'item-sidebar-active' : '' }}">
                            <x-solar-letter-outline class="w-4 h-4 mr-2" />
                            Configuración SendGrid
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Configuración de Tiendas -->
            <h3 class="title-group-sidebar mt-6">
                Configuración
            </h3>

            <!-- Iconos de Categorías -->
            <li>
                <a href="{{ route('superlinkiu.category-icons.index') }}" class="item-sidebar {{ request()->routeIs('superlinkiu.category-icons.*') ? 'item-sidebar-active' : '' }}">
                    <x-solar-gallery-outline class="w-4 h-4 mr-2" />
                    Iconos de Categorías
                    @php
                        $totalIcons = \App\Shared\Models\CategoryIcon::count();
                        $activeIcons = \App\Shared\Models\CategoryIcon::where('is_active', true)->count();
                    @endphp
                    @if($totalIcons > 0)
                        <span class="ml-auto text-xs bg-info-300 text-accent-50 px-2 py-1 rounded-full">
                            {{ $activeIcons }}/{{ $totalIcons }}
                        </span>
                    @endif
                </a>
            </li>


            
        </ul>
    </nav>

    <!-- User section -->
    <div class="p-4 border-t dark:border-gray-700 flex-shrink-0">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-primary-300 rounded-full flex items-center justify-center">
                    <span class="text-accent-50 text-sm font-medium">
                        @if (auth()->user()->avatar_url)
                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-8 h-8 rounded-full">
                        @else
                            {{ substr(auth()->user()->name, 0, 1) }}
                        @endif
                    </span>
                </div>
            </div>
            <div class="ml-3 flex-1 min-w-0">
                <a href="{{ route('superlinkiu.profile.show') }}" class="hover:text-primary-200">
                    <p class="text-sm font-medium text-gray-900 dark:text-accent-50 truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        Super Admin
                    </p>
                </a>
            </div>
            <div class="flex-shrink-0 flex space-x-2">
                <a href="{{ route('superlinkiu.profile.show') }}" 
                   class="text-gray-400 hover:text-primary-200 transition-colors duration-200"
                   title="Perfil">
                    <x-solar-user-circle-outline class="w-5 h-5" />
                </a>
                <form method="POST" action="{{ route('superlinkiu.logout') }}">
                    @csrf
                    <button type="submit" 
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors duration-200"
                            title="Cerrar sesión">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile sidebar overlay -->
<div x-show="!sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-30 bg-gray-600 bg-opacity-75 lg:hidden"
     @click="sidebarOpen = true">
</div>