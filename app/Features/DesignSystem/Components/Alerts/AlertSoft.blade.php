{{--
Alert Soft - Tonos gentiles y silenciados que crean una forma sutil pero efectiva de llamar la atención
Código exacto de Preline UI sin modificaciones en clases
--}}

@props([
    'type' => 'info', // dark, secondary, info, success, danger, warning, light
    'title' => '',
    'message' => '',
])

@php
    $typeClasses = [
        'dark' => 'bg-gray-100 border border-gray-200 text-gray-800',
        'secondary' => 'bg-gray-50 border border-gray-200 text-gray-600',
        'info' => 'bg-blue-100 border border-blue-200 text-blue-800',
        'success' => 'bg-teal-100 border border-teal-200 text-teal-800',
        'danger' => 'bg-red-100 border border-red-200 text-red-800',
        'warning' => 'bg-yellow-100 border border-yellow-200 text-yellow-800',
        'light' => 'bg-white/10 border border-white/10 text-white',
    ];
    
    $idLabels = [
        'dark' => 'hs-soft-color-dark-label',
        'secondary' => 'hs-soft-color-secondary-label',
        'info' => 'hs-soft-color-info-label',
        'success' => 'hs-soft-color-success-label',
        'danger' => 'hs-soft-color-danger-label',
        'warning' => 'hs-soft-color-warning-label',
        'light' => 'hs-soft-color-light-label',
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
