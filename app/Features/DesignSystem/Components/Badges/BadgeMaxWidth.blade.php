{{--
Badge con Ancho Máximo - Badge con truncado para texto largo
Uso: Badges que pueden contener texto largo y necesitan un ancho máximo controlado
Cuándo usar: Nombres de usuario, títulos largos, contenido variable que puede exceder el espacio
Cuándo NO usar: Texto corto que no necesita truncado, información crítica que debe leerse completa
Ejemplo: <x-badge-max-width type="info" text="Este contenido es un poco más largo" maxWidth="40" />
--}}

@props([
    'type' => 'info', // dark, secondary, success, info, error, warning, light
    'text' => 'Badge',
    'maxWidth' => '40', // max-w-{value} - 40, 48, 56, 64, etc.
])

@php
    $typeClasses = [
        'dark' => 'bg-gray-100 text-gray-800',
        'secondary' => 'bg-gray-50 text-gray-500',
        'success' => 'bg-green-100 text-green-800',
        'info' => 'bg-blue-100 text-blue-800',
        'error' => 'bg-red-100 text-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'light' => 'bg-white text-gray-600',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
    $maxWidthClass = 'max-w-' . $maxWidth;
@endphp

<span class="{{ $maxWidthClass }} truncate whitespace-nowrap inline-block py-1.5 px-3 rounded-lg caption font-medium {{ $classes }}" 
      title="{{ $text }}" {{ $attributes }}>
    {{ $text }}
</span>
