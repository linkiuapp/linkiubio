{{--
Badge Posicionado - Badge posicionado en la esquina de elementos como botones, avatares
Uso: Contadores de notificaciones, indicadores de estado en elementos UI
Cuándo usar: Notificaciones pendientes, conteos, indicadores de actividad
Cuándo NO usar: Información principal, contenido que debe estar en el flujo normal
Ejemplo: <x-badge-positioned count="5" type="notification" position="top-right" />
--}}

@props([
    'count' => '', // Número o texto a mostrar
    'type' => 'notification', // notification, indicator, profile
    'position' => 'top-right', // top-right, top-left, bottom-right, bottom-left
    'color' => 'red', // red, green, blue, yellow, gray
    'animated' => false, // Si incluye animación ping
])

@php
    $positionClasses = [
        'top-right' => 'absolute top-0 end-0 -translate-y-1/2 translate-x-1/2',
        'top-left' => 'absolute top-0 start-0 -translate-y-1/2 -translate-x-1/2',
        'bottom-right' => 'absolute bottom-0 end-0 translate-y-1/2 translate-x-1/2',
        'bottom-left' => 'absolute bottom-0 start-0 translate-y-1/2 -translate-x-1/2'
    ];
    
    $colorClasses = [
        'red' => 'bg-red-500 text-white',
        'green' => 'bg-teal-500 text-white',
        'blue' => 'bg-blue-500 text-white',
        'yellow' => 'bg-yellow-500 text-white',
        'gray' => 'bg-gray-500 text-white'
    ];
    
    $positionClass = $positionClasses[$position] ?? $positionClasses['top-right'];
    $colorClass = $colorClasses[$color] ?? $colorClasses['red'];
    
    if ($type === 'notification' && $count) {
        $badgeClasses = 'inline-flex items-center py-0.5 px-1.5 rounded-full text-xs font-medium transform ' . $positionClass . ' ' . $colorClass;
    } elseif ($type === 'profile') {
        $badgeClasses = 'inline-flex items-center w-3.5 h-3.5 rounded-full border-2 border-white transform ' . $positionClass . ' ' . $colorClass;
    } else {
        $badgeClasses = 'inline-flex items-center w-3 h-3 rounded-full border-2 border-white transform ' . $positionClass . ' ' . $colorClass;
    }
@endphp

@if($animated)
    <span class="flex absolute {{ $positionClass }}">
        @if($count && $type === 'notification')
            <span class="animate-ping absolute inline-flex size-full rounded-full {{ str_replace('bg-' . ($color === 'green' ? 'teal' : $color) . '-500', 'bg-' . ($color === 'green' ? 'teal' : $color) . '-400', str_replace('bg-green-500', 'bg-teal-500', $colorClass)) }} opacity-75"></span>
            <span class="relative inline-flex text-xs {{ str_replace(' transform', '', $colorClass) }} rounded-full py-0.5 px-1.5">
                {{ $count }}
            </span>
        @else
            <span class="animate-ping absolute inline-flex size-full rounded-full {{ str_replace('bg-' . ($color === 'green' ? 'teal' : $color) . '-500', 'bg-' . ($color === 'green' ? 'teal' : $color) . '-400', str_replace('bg-green-500', 'bg-teal-500', $colorClass)) }} opacity-75"></span>
            <span class="relative inline-flex rounded-full size-3 {{ str_replace(' transform', '', $colorClass) }}"></span>
        @endif
    </span>
@else
    <span class="{{ $badgeClasses }}" {{ $attributes }}>
        @if($count && $type === 'notification')
            {{ $count }}
        @elseif($type === 'profile')
            <span class="sr-only">{{ $count ?: 'Badge value' }}</span>
        @endif
    </span>
@endif
