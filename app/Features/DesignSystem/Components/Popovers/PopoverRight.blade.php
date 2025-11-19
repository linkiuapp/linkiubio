{{--
Popover Right - Popover con posición derecha
Uso: Popover que se muestra a la derecha del elemento trigger
Cuándo usar: Cuando necesites mostrar información adicional al hacer clic en un elemento
Cuándo NO usar: Cuando la información sea breve (usa tooltip en su lugar)
Ejemplo: <x-popover-right text="Popover derecho"><button>Trigger</button></x-popover-right>
--}}

@props([
    'text' => 'Popover derecho',
])

@php
    $uniqueId = 'popover-' . uniqid();
@endphp

<div class="relative inline-block" x-data="{ open: false }" x-on:click.outside="open = false">
    <div @click="open = !open" class="cursor-pointer">
        {{ $slot }}
    </div>
    
    <div 
        x-show="open"
        x-transition:enter="transition-opacity duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute z-10 py-3 px-4 bg-white border border-gray-200 text-sm text-gray-600 rounded-lg shadow-md whitespace-nowrap left-full top-1/2 -translate-y-1/2 ml-2"
        role="tooltip"
        style="display: none;"
    >
        {{ $text }}
    </div>
</div>















