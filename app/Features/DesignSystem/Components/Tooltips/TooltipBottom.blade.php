{{--
Tooltip Bottom - Tooltip con posición inferior
Uso: Tooltip que se muestra debajo del elemento trigger al hacer hover
Cuándo usar: Cuando necesites mostrar información breve al pasar el mouse sobre un elemento
Cuándo NO usar: Cuando la información sea extensa (usa popover en su lugar)
Ejemplo: <x-tooltip-bottom text="Tooltip inferior"><button>Hover me</button></x-tooltip-bottom>
--}}

@props([
    'text' => 'Tooltip inferior',
])

@php
    $uniqueId = 'tooltip-' . uniqid();
@endphp

<div class="relative inline-block" x-data="{ open: false }">
    <div @mouseenter="open = true" @mouseleave="open = false">
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
        class="absolute z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs whitespace-nowrap top-full left-1/2 -translate-x-1/2 mt-2"
        role="tooltip"
        style="display: none;"
    >
        {{ $text }}
    </div>
</div>















