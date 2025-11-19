{{--
Toast Solid - Toast con fondo sólido de color
Uso: Notificaciones destacadas, mensajes con mayor visibilidad
Cuándo usar: Cuando necesites un toast más llamativo con fondo de color
Cuándo NO usar: Cuando necesites un toast con fondo blanco estándar
Ejemplo: <x-toast-solid color="blue" message="Hello, world!" />
--}}

@props([
    'color' => 'gray', // gray-dark, gray, teal, blue, red, yellow, green, indigo, purple, pink
    'message' => '',
    'id' => null,
    'onClose' => null,
])

@php
    $uniqueId = $id ?? uniqid('toast-solid-');
    $labelId = $uniqueId . '-label';
    
    $bgClasses = match($color) {
        'gray-dark' => 'bg-gray-800',
        'gray' => 'bg-gray-500',
        'teal' => 'bg-teal-500',
        'blue' => 'bg-blue-500',
        'red' => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'green' => 'bg-green-500',
        'indigo' => 'bg-indigo-500',
        'purple' => 'bg-purple-500',
        'pink' => 'bg-pink-500',
        'orange' => 'bg-orange-500',
        default => 'bg-gray-500',
    };
@endphp

<div class="max-w-xs {{ $bgClasses }} body-small text-white rounded-xl shadow-lg" 
     role="alert" 
     tabindex="-1" 
     aria-labelledby="{{ $labelId }}"
     id="{{ $uniqueId }}"
     {{ $attributes }}>
    <div id="{{ $labelId }}" class="flex p-4">
        <span class="flex-1">
            {{ $message ?: $slot }}
        </span>

        <div class="ms-auto">
            <button 
                type="button" 
                class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-white hover:text-white opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100"
                aria-label="Cerrar"
                @if($onClose)
                    onclick="{{ $onClose }}"
                @endif
            >
                <span class="sr-only">Cerrar</span>
                <i data-lucide="x" class="shrink-0 size-4"></i>
            </button>
        </div>
    </div>
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

