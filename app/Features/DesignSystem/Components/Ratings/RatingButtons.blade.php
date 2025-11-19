{{--
Rating Buttons - Sistema de calificación con botones
Uso: Calificaciones interactivas, valoraciones con botones clickeables en lugar de radios
Cuándo usar: Cuando necesites calificaciones con botones clickeables en lugar de radios
Cuándo NO usar: Cuando necesites formularios con radios o calificaciones estáticas
Ejemplo: <x-rating-buttons :value="4" :max="5" />
--}}

@props([
    'value' => 0, // Valor seleccionado (0-max)
    'max' => 5, // Máximo de estrellas
    'icon' => 'star', // Icono de Lucide (star, heart, etc)
    'colorActive' => 'text-yellow-400', // Color cuando está activo
    'colorInactive' => 'text-gray-300', // Color cuando está inactivo
    'disabled' => false,
    'onChange' => null, // Callback cuando cambia el valor (opcional)
])

@php
    $uniqueId = uniqid('rating-btn-');
    $maxStars = max(1, min(10, $max));
    $currentValue = max(0, min($maxStars, $value));
@endphp

<div x-data="{ 
    selectedValue: {{ $currentValue }},
    hoverValue: 0,
    handleClick(value) {
        if ({{ $disabled ? 'true' : 'false' }}) return;
        this.selectedValue = value;
        @if($onChange)
            {{ $onChange }}(value);
        @endif
    }
}" class="flex items-center" {{ $attributes }}>
    @for($i = 1; $i <= $maxStars; $i++)
        <button 
            type="button" 
            @click="handleClick({{ $i }})"
            @mouseenter="hoverValue = {{ $i }}"
            @mouseleave="hoverValue = 0"
            :class="(hoverValue >= {{ $i }} || selectedValue >= {{ $i }}) ? '{{ $colorActive }}' : '{{ $colorInactive }}'"
            class="size-5 inline-flex justify-center items-center text-2xl rounded-full transition-colors disabled:opacity-50 disabled:pointer-events-none"
            {{ $disabled ? 'disabled' : '' }}
            data-value="{{ $i }}"
        >
            <i data-lucide="{{ $icon }}" class="shrink-0 size-5" :class="(hoverValue >= {{ $i }} || selectedValue >= {{ $i }}) ? 'fill-current' : ''"></i>
        </button>
    @endfor
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof createIcons !== 'undefined') {
        createIcons();
    }
});
</script>
@endpush
