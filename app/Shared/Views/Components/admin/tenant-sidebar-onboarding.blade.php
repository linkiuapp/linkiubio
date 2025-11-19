{{-- SECTION: Primeros pasos --}}
@php
    $profileImage = $store->design?->logo_url ?? $store->logo_url;
    $completedSteps = count(array_filter($onboardingSteps));
    $totalSteps = count($onboardingSteps);
@endphp

<li class="mb-4 bg-gray-100 rounded-lg p-3 border border-dashed border-gray-300">
    {{-- ITEM: Título de primeros pasos --}}
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-2">
            <i data-lucide="rocket" class="w-5 h-5 text-blue-600"></i>
            <span class="text-sm font-bold text-blue-600">Primeros pasos</span>
        </div>
        <x-badge-solid type="info" text="{{ $completedSteps }}/{{ $totalSteps }}" />
    </div>
    
    {{-- LIST: Items de onboarding --}}
    <ul class="space-y-1">
        {{-- ITEM: Diseño de la tienda --}}
        <li>
            <a href="{{ route('tenant.admin.store-design.index', ['store' => $store->slug]) }}" 
               class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 {{ request()->routeIs('tenant.admin.store-design.*') ? 'bg-gray-200' : '' }} {{ $onboardingSteps['design'] ? 'opacity-95' : '' }}">
                @if($onboardingSteps['design'])
                    <i data-lucide="check-circle" class="size-4 shrink-0 text-teal-500"></i>
                @else
                    <i data-lucide="palette" class="size-4 shrink-0"></i>
                @endif
                <span class="{{ $onboardingSteps['design'] ? 'line-through' : '' }}">Personalizar tu tienda</span>
            </a>
        </li>
        
        {{-- ITEM: Slider --}}
        <li>
            <a href="{{ route('tenant.admin.sliders.index', ['store' => $store->slug]) }}" 
               class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 {{ request()->routeIs('tenant.admin.sliders.*') ? 'bg-gray-200' : '' }} {{ $onboardingSteps['slider'] ? 'opacity-95' : '' }}">
                @if($onboardingSteps['slider'])
                    <i data-lucide="check-circle" class="size-4 shrink-0 text-teal-500"></i>
                @else
                    <i data-lucide="images" class="size-4 shrink-0"></i>
                @endif
                <span class="{{ $onboardingSteps['slider'] ? 'line-through' : '' }}">Slider</span>
            </a>
        </li>
        
        {{-- ITEM: Sedes --}}
        <li>
            <a href="{{ route('tenant.admin.locations.index', ['store' => $store->slug]) }}" 
               class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 {{ request()->routeIs('tenant.admin.locations.*') ? 'bg-gray-200' : '' }} {{ $onboardingSteps['locations'] ? 'opacity-95' : '' }}">
                @if($onboardingSteps['locations'])
                    <i data-lucide="check-circle" class="size-4 shrink-0 text-teal-500"></i>
                @else
                    <i data-lucide="store" class="size-4 shrink-0"></i>
                @endif
                <span class="{{ $onboardingSteps['locations'] ? 'line-through' : '' }}">Sedes</span>
            </a>
        </li>
        
        {{-- ITEM: Métodos de pago --}}
        <li>
            <a href="{{ route('tenant.admin.payment-methods.index', ['store' => $store->slug]) }}" 
               class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 {{ request()->routeIs('tenant.admin.payment-methods.*') ? 'bg-gray-200' : '' }} {{ $onboardingSteps['payments'] ? 'opacity-95' : '' }}">
                @if($onboardingSteps['payments'])
                    <i data-lucide="check-circle" class="size-4 shrink-0 text-teal-500"></i>
                @else
                    <i data-lucide="dock" class="size-4 shrink-0"></i>
                @endif
                <span class="{{ $onboardingSteps['payments'] ? 'line-through' : '' }}">Métodos de Pago</span>
            </a>
        </li>
        
        {{-- ITEM: Gestión de envíos (condicional) --}}
        @if(featureEnabled($store, 'shipping'))
        <li>
            <a href="{{ route('tenant.admin.simple-shipping.index', ['store' => $store->slug]) }}" 
               class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 {{ request()->routeIs('tenant.admin.simple-shipping.*') ? 'bg-gray-200' : '' }} {{ $onboardingSteps['shipping'] ? 'opacity-95' : '' }}">
                @if($onboardingSteps['shipping'])
                    <i data-lucide="check-circle" class="size-4 shrink-0 text-teal-500"></i>
                @else
                    <i data-lucide="truck" class="size-4 shrink-0"></i>
                @endif
                <span class="{{ $onboardingSteps['shipping'] ? 'line-through' : '' }}">Gestión de Envíos</span>
            </a>
        </li>
        @endif
        
        {{-- ITEM: Categorías --}}
        <li>
            <a href="{{ route('tenant.admin.categories.index', ['store' => $store->slug]) }}" 
               class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 {{ request()->routeIs('tenant.admin.categories.*') ? 'bg-gray-200' : '' }} {{ $onboardingSteps['categories'] ? 'opacity-95' : '' }}">
                @if($onboardingSteps['categories'])
                    <i data-lucide="check-circle" class="size-4 shrink-0 text-teal-500"></i>
                @else
                    <i data-lucide="layout-list" class="size-4 shrink-0"></i>
                @endif
                <span class="{{ $onboardingSteps['categories'] ? 'line-through' : '' }}">Categorías</span>
            </a>
        </li>
        
        {{-- ITEM: Variables --}}
        <li>
            <a href="{{ route('tenant.admin.variables.index', ['store' => $store->slug]) }}" 
               class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 {{ request()->routeIs('tenant.admin.variables.*') ? 'bg-gray-200' : '' }} {{ $onboardingSteps['variables'] ? 'opacity-95' : '' }}">
                @if($onboardingSteps['variables'])
                    <i data-lucide="check-circle" class="size-4 shrink-0 text-teal-500"></i>
                @else
                    <i data-lucide="tag" class="size-4 shrink-0"></i>
                @endif
                <span class="{{ $onboardingSteps['variables'] ? 'line-through' : '' }}">Variables</span>
            </a>
        </li>
        
        {{-- ITEM: Productos --}}
        <li>
            <a href="{{ route('tenant.admin.products.index', ['store' => $store->slug]) }}" 
               class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 {{ request()->routeIs('tenant.admin.products.*') ? 'bg-gray-200' : '' }} {{ $onboardingSteps['products'] ? 'opacity-95' : '' }}">
                @if($onboardingSteps['products'])
                    <i data-lucide="check-circle" class="size-4 shrink-0 text-teal-500"></i>
                @else
                    <i data-lucide="package" class="size-4 shrink-0"></i>
                @endif
                <span class="{{ $onboardingSteps['products'] ? 'line-through' : '' }}">Productos</span>
            </a>
        </li>
        
        {{-- ITEM: Cupones --}}
        <li>
            <a href="{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}" 
               class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 {{ request()->routeIs('tenant.admin.coupons.*') ? 'bg-gray-200' : '' }} {{ $onboardingSteps['coupons'] ? 'opacity-95' : '' }}">
                @if($onboardingSteps['coupons'])
                    <i data-lucide="check-circle" class="size-4 shrink-0 text-teal-500"></i>
                @else
                    <i data-lucide="ticket-percent" class="size-4 shrink-0"></i>
                @endif
                <span class="{{ $onboardingSteps['coupons'] ? 'line-through' : '' }}">Cupones</span>
            </a>
        </li>
    </ul>
</li>

{{-- ITEM: Separador visual --}}
<li class="my-4 border-t border-gray-200"></li>



