{{--
Rating Basic - Sistema de calificación básico con radios
Uso: Calificaciones de productos, reseñas, valoraciones
Cuándo usar: Cuando necesites que el usuario seleccione una calificación de 1 a 5 estrellas
Cuándo NO usar: Cuando necesites calificaciones con botones o símbolos personalizados
Ejemplo: <x-rating-basic name="rating" :value="3" />
--}}

@props([
    'name' => 'rating',
    'value' => 0, // Valor seleccionado (0-5)
    'max' => 5, // Máximo de estrellas
    'disabled' => false,
    'required' => false,
])

@php
    $uniqueId = uniqid('rating-');
    $maxStars = max(1, min(10, $max));
@endphp

<div class="flex flex-row-reverse justify-end items-center" {{ $attributes }}>
    @for($i = $maxStars; $i >= 1; $i--)
        @php
            $inputId = $uniqueId . '-' . $i;
            $isChecked = $value == $i;
        @endphp
        <input 
            type="radio" 
            id="{{ $inputId }}" 
            name="{{ $name }}" 
            value="{{ $i }}" 
            class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0 {{ $disabled ? 'disabled:opacity-50 disabled:pointer-events-none' : '' }}"
            {{ $isChecked ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $required && $i == $maxStars ? 'required' : '' }}
        >
        <label 
            for="{{ $inputId }}" 
            class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none {{ $disabled ? 'opacity-50' : '' }}"
        >
            <i data-lucide="star" class="shrink-0 size-5 fill-current"></i>
        </label>
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















