{{--
Alert Solid - Colores sólidos ideales para crear una apariencia cohesiva y pulida
Código exacto de Preline UI sin modificaciones en clases
--}}

@props([
    'type' => 'info', // dark, secondary, info, success, danger, warning, light
    'title' => '',
    'message' => '',
])

@php
    $typeClasses = [
        'dark' => 'bg-gray-800 text-white',
        'secondary' => 'bg-gray-500 text-white',
        'info' => 'bg-blue-600 text-white',
        'success' => 'bg-teal-500 text-white',
        'danger' => 'bg-red-500 text-white',
        'warning' => 'bg-yellow-500 text-white',
        'light' => 'bg-white text-gray-600',
    ];
    
    $idLabels = [
        'dark' => 'hs-solid-color-dark-label',
        'secondary' => 'hs-solid-color-secondary-label',
        'info' => 'hs-solid-color-info-label',
        'success' => 'hs-solid-color-success-label',
        'danger' => 'hs-solid-color-danger-label',
        'warning' => 'hs-solid-color-warning-label',
        'light' => 'hs-solid-color-light-label',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
    $labelId = $idLabels[$type] ?? $idLabels['info'];
@endphp

<div class="mt-2 {{ $classes }} text-sm rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="{{ $labelId }}" {{ $attributes }}>
    @if($title)
        <span id="{{ $labelId }}" class="font-bold">{{ $title }}</span>
    @endif
    @if($message)
        @if($title) {{ $message }} @else <span id="{{ $labelId }}">{{ $message }}</span> @endif
    @endif
</div>
