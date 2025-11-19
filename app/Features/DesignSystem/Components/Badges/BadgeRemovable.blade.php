{{--
Badge Removable - Badge con botón de eliminar/cerrar con animación
Código exacto de Preline UI sin modificaciones en clases
--}}

@props([
    'type' => 'info', // info, success, warning, error, dark, secondary
    'text' => 'Badge',
    'id' => '', // ID del badge para referencia
])

@php
    $typeClasses = [
        'info' => [
            'container' => 'bg-blue-100 text-blue-800',
            'button' => 'hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 focus:text-blue-500'
        ],
        'success' => [
            'container' => 'bg-teal-100 text-teal-800',
            'button' => 'hover:bg-teal-200 focus:outline-hidden focus:bg-teal-200 focus:text-teal-500'
        ],
        'warning' => [
            'container' => 'bg-yellow-100 text-yellow-800',
            'button' => 'hover:bg-yellow-200 focus:outline-hidden focus:bg-yellow-200 focus:text-yellow-500'
        ],
        'error' => [
            'container' => 'bg-red-100 text-red-800',
            'button' => 'hover:bg-red-200 focus:outline-hidden focus:bg-red-200 focus:text-red-500'
        ],
        'dark' => [
            'container' => 'bg-gray-100 text-gray-800',
            'button' => 'hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 focus:text-gray-500'
        ],
        'secondary' => [
            'container' => 'bg-gray-50 text-gray-500',
            'button' => 'hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 focus:text-gray-400'
        ],
    ];
    
    $config = $typeClasses[$type] ?? $typeClasses['info'];
    $badgeId = $id ?: 'badge-' . uniqid();
@endphp

<span id="{{ $badgeId }}" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 inline-flex items-center gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium {{ $config['container'] }}" {{ $attributes }}>
    {{ $text }}
    <button type="button" 
            class="shrink-0 size-4 inline-flex items-center justify-center rounded-full {{ $config['button'] }}"
            data-hs-remove-element="#{{ $badgeId }}">
        <span class="sr-only">Eliminar badge</span>
        <i data-lucide="x" class="shrink-0 size-3"></i>
    </button>
</span>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
