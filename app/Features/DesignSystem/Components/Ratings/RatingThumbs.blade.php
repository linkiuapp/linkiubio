{{--
Rating Thumbs - Sistema de calificación con pulgares arriba/abajo
Uso: Feedback binario, páginas de ayuda, documentación
Cuándo usar: Cuando necesites una respuesta simple sí/no o útil/no útil
Cuándo NO usar: Cuando necesites calificaciones con más opciones
Ejemplo: <x-rating-thumbs question="¿Fue útil esta página?" />
--}}

@props([
    'question' => '¿Fue útil esta página?',
    'showQuestion' => true,
    'selected' => null, // 'yes' o 'no' o null
    'onSelect' => null, // Callback cuando se selecciona (opcional)
])

@php
    $initialSelected = $selected === 'yes' ? 'yes' : ($selected === 'no' ? 'no' : null);
@endphp

<div x-data="{ 
    selected: @js($initialSelected),
    handleSelect(value) {
        this.selected = value;
        @if($onSelect)
            {{ $onSelect }}(value);
        @endif
    }
}" class="flex justify-center items-center gap-x-2" {{ $attributes }}>
    @if($showQuestion)
        <h3 class="body-small text-gray-800">
            {{ $question }}
        </h3>
    @endif
    <button 
        type="button" 
        @click="handleSelect('yes')"
        :class="selected === 'yes' ? 'bg-blue-50 border-blue-200 text-blue-600 hover:bg-blue-100 focus:bg-blue-100' : 'border-gray-200 bg-white text-gray-800 hover:bg-gray-50 focus:bg-gray-50'"
        class="py-2 px-3 inline-flex items-center gap-x-2 body-small font-medium rounded-lg border shadow-2xs transition-colors focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none"
    >
        <i data-lucide="thumbs-up" class="shrink-0 size-4" :class="selected === 'yes' ? 'text-blue-600' : ''"></i>
        Sí
    </button>
    <button 
        type="button" 
        @click="handleSelect('no')"
        :class="selected === 'no' ? 'bg-red-50 border-red-200 text-red-600 hover:bg-red-100 focus:bg-red-100' : 'border-gray-200 bg-white text-gray-800 hover:bg-gray-50 focus:bg-gray-50'"
        class="py-2 px-3 inline-flex items-center gap-x-2 body-small font-medium rounded-lg border shadow-2xs transition-colors focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none"
    >
        <i data-lucide="thumbs-down" class="shrink-0 size-4" :class="selected === 'no' ? 'text-red-600' : ''"></i>
        No
    </button>
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
