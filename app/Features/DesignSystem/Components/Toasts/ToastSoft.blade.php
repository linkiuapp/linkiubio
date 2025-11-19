{{--
Toast Soft - Toast con fondo suave de color
Uso: Notificaciones sutiles, mensajes con fondo suave
Cuándo usar: Cuando necesites un toast más sutil con fondo de color claro
Cuándo NO usar: Cuando necesites un toast con fondo blanco o sólido
Ejemplo: <x-toast-soft color="blue" message="Hello, world!" />
--}}

@props([
    'color' => 'gray', // gray-dark, gray, teal, blue, red, yellow, green, indigo, purple, pink
    'message' => '',
    'id' => null,
    'onClose' => null,
])

@php
    $uniqueId = $id ?? uniqid('toast-soft-');
    $labelId = $uniqueId . '-label';
    
    $bgClasses = match($color) {
        'gray-dark' => 'bg-gray-100 border-gray-200 text-gray-800',
        'gray' => 'bg-gray-50 border-gray-200 text-gray-600',
        'teal' => 'bg-teal-100 border-teal-200 text-teal-800',
        'blue' => 'bg-blue-100 border-blue-200 text-blue-800',
        'red' => 'bg-red-100 border-red-200 text-red-800',
        'yellow' => 'bg-yellow-100 border-yellow-200 text-yellow-800',
        'green' => 'bg-green-100 border-green-200 text-green-800',
        'indigo' => 'bg-indigo-100 border-indigo-200 text-indigo-800',
        'purple' => 'bg-purple-100 border-purple-200 text-purple-800',
        'pink' => 'bg-pink-100 border-pink-200 text-pink-800',
        'orange' => 'bg-orange-100 border-orange-200 text-orange-800',
        default => 'bg-gray-50 border-gray-200 text-gray-600',
    };
    
    $closeColor = match($color) {
        'gray-dark', 'gray' => 'text-gray-800',
        'teal' => 'text-teal-800',
        'blue' => 'text-blue-800',
        'red' => 'text-red-800',
        'yellow' => 'text-yellow-800',
        'green' => 'text-green-800',
        'indigo' => 'text-indigo-800',
        'purple' => 'text-purple-800',
        'pink' => 'text-pink-800',
        'orange' => 'text-orange-800',
        default => 'text-gray-800',
    };
@endphp

<div class="max-w-xs {{ $bgClasses }} body-small rounded-lg border" 
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
                class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg {{ $closeColor }} opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100"
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

