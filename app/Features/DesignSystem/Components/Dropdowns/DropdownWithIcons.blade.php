{{--
Dropdown With Icons - Menú desplegable con iconos
Uso: Menú desplegable que muestra iconos junto a cada opción
Cuándo usar: Cuando quieras mejorar la visualización de las opciones con iconos
Cuándo NO usar: Cuando las opciones no necesiten iconos
Ejemplo: <x-dropdown-with-icons :items="[['label' => 'Newsletter', 'url' => '#', 'icon' => 'bell'], ['label' => 'Purchases', 'url' => '#', 'icon' => 'shopping-cart']]" />
--}}

@props([
    'items' => [], // Array de items: [['label' => '...', 'url' => '...', 'icon' => '...']]
    'triggerText' => 'Acciones',
    'triggerId' => null,
])

@php
    $uniqueId = $triggerId ?? 'dropdown-icons-' . uniqid();
@endphp

<div class="relative inline-flex" x-data="{ open: false }" x-on:click.outside="open = false">
    <button 
        id="{{ $uniqueId }}"
        type="button" 
        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
        aria-haspopup="menu" 
        :aria-expanded="open"
        aria-label="Dropdown"
        @click="open = !open"
    >
        {{ $triggerText }}
        <i data-lucide="chevron-down" class="size-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" x-init="lucide.createIcons()"></i>
    </button>

    <div 
        class="absolute z-50 min-w-60 bg-white shadow-md rounded-lg mt-2 divide-y divide-gray-200 transition-[opacity,margin] duration-200"
        :class="open ? 'opacity-100 visible' : 'opacity-0 invisible'"
        role="menu" 
        aria-orientation="vertical" 
        aria-labelledby="{{ $uniqueId }}"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
    >
        <div class="p-1 space-y-0.5">
            @foreach($items as $item)
                @php
                    $label = $item['label'] ?? '';
                    $url = $item['url'] ?? '#';
                    $icon = $item['icon'] ?? null;
                @endphp
                <a 
                    class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" 
                    href="{{ $url }}"
                    @click="open = false"
                >
                    @if($icon)
                        <i data-lucide="{{ $icon }}" class="shrink-0 size-4" x-init="lucide.createIcons()"></i>
                    @endif
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</div>

