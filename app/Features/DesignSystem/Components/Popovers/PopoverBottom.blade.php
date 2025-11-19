{{--
Popover Bottom - Popover con posición inferior
Uso: Popover que se muestra debajo del elemento trigger
Cuándo usar: Cuando necesites mostrar información adicional al hacer clic en un elemento
Cuándo NO usar: Cuando la información sea breve (usa tooltip en su lugar)
Ejemplo: <x-popover-bottom text="Popover inferior"><button>Trigger</button></x-popover-bottom>
--}}

@props([
    'text' => 'Popover inferior',
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
        class="absolute z-10 py-3 px-4 bg-white border border-gray-200 text-sm text-gray-600 rounded-lg shadow-md whitespace-nowrap top-full left-1/2 -translate-x-1/2 mt-2"
        role="tooltip"
        style="display: none;"
    >
        {{ $text }}
    </div>
</div>















