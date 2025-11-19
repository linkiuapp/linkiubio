{{--
Rating Static - Sistema de calificación estático (solo lectura)
Uso: Mostrar calificaciones existentes, valoraciones de productos
Cuándo usar: Cuando necesites mostrar una calificación sin permitir modificación
Cuándo NO usar: Cuando necesites que el usuario pueda calificar
Ejemplo: <x-rating-static :value="4" :max="5" />
--}}

@props([
    'value' => 0, // Valor a mostrar (0-max)
    'max' => 5, // Máximo de estrellas
    'icon' => 'star', // Icono de Lucide
    'colorActive' => 'text-yellow-400', // Color cuando está activo
    'colorInactive' => 'text-gray-300', // Color cuando está inactivo
])

@php
    $maxStars = max(1, min(10, $max));
    $currentValue = max(0, min($maxStars, $value));
@endphp

<div class="flex items-center" {{ $attributes }}>
    @for($i = 1; $i <= $maxStars; $i++)
        @php
            $isActive = $i <= $currentValue;
            $iconClass = $isActive ? $colorActive : $colorInactive;
        @endphp
        <i data-lucide="{{ $icon }}" class="shrink-0 size-5 {{ $iconClass }} {{ $isActive ? 'fill-current' : '' }}"></i>
    @endfor
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof createIcons !== 'undefined') {
        createIcons();
    }
});
</script>
@endpush















