{{--
Spinner Basic - Spinner de carga básico
Uso: Indicadores de carga, estados de loading, procesamiento
Cuándo usar: Cuando necesites mostrar que algo se está cargando o procesando
Cuándo NO usar: Cuando necesites mensajes de error o estados completos
Ejemplo: <x-spinner-basic color="blue" size="md" />
--}}

@props([
    'color' => 'blue', // blue, gray, red, yellow, green, indigo, purple, pink, orange
    'size' => 'md', // sm, md, lg
    'label' => 'Loading...', // Texto para screen readers
])

@php
    $colorClasses = match($color) {
        'gray' => 'text-gray-800',
        'gray-light' => 'text-gray-400',
        'red' => 'text-red-600',
        'yellow' => 'text-yellow-600',
        'green' => 'text-green-600',
        'blue' => 'text-blue-600',
        'indigo' => 'text-indigo-600',
        'purple' => 'text-purple-600',
        'pink' => 'text-pink-600',
        'orange' => 'text-orange-600',
        default => 'text-blue-600',
    };
    
    $sizeClasses = match($size) {
        'sm' => 'size-4',
        'lg' => 'size-8',
        default => 'size-6',
    };
    
    $borderClasses = match($size) {
        'sm' => 'border-2',
        'lg' => 'border-4',
        default => 'border-[3px]',
    };
@endphp

<div class="animate-spin inline-block {{ $sizeClasses }} {{ $borderClasses }} border-current border-t-transparent {{ $colorClasses }} rounded-full" 
     role="status" 
     aria-label="{{ $label }}" 
     {{ $attributes }}>
    <span class="sr-only">{{ $label }}</span>
</div>

