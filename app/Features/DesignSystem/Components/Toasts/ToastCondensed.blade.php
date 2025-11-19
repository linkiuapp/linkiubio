{{--
Toast Condensed - Toast compacto con acciones
Uso: Notificaciones con acciones rápidas, mensajes con opción de deshacer
Cuándo usar: Cuando necesites mostrar un mensaje con acciones (undo, close)
Cuándo NO usar: Cuando solo necesites un mensaje simple sin acciones
Ejemplo: <x-toast-condensed message="Tu email ha sido enviado" actionLabel="Deshacer" />
--}}

@props([
    'message' => '',
    'actionLabel' => 'Deshacer',
    'actionUrl' => null,
    'onAction' => null, // Callback para la acción
    'onClose' => null, // Callback para cerrar
    'id' => null,
])

@php
    $uniqueId = $id ?? uniqid('toast-condensed-');
    $labelId = $uniqueId . '-label';
@endphp

<div class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg" 
     role="alert" 
     tabindex="-1" 
     aria-labelledby="{{ $labelId }}"
     id="{{ $uniqueId }}"
     {{ $attributes }}>
    <div class="flex p-4">
        <p id="{{ $labelId }}" class="body-small text-gray-700 flex-1">
            {{ $message ?: $slot }}
        </p>

        <div class="ms-auto flex items-center space-x-3">
            @if($actionLabel)
                @if($actionUrl)
                    <a href="{{ $actionUrl }}" class="text-blue-600 decoration-2 hover:underline font-medium body-small focus:outline-hidden focus:underline">
                        {{ $actionLabel }}
                    </a>
                @elseif($onAction)
                    <button 
                        type="button" 
                        class="text-blue-600 decoration-2 hover:underline font-medium body-small focus:outline-hidden focus:underline"
                        onclick="{{ $onAction }}"
                    >
                        {{ $actionLabel }}
                    </button>
                @else
                    <button 
                        type="button" 
                        class="text-blue-600 decoration-2 hover:underline font-medium body-small focus:outline-hidden focus:underline"
                    >
                        {{ $actionLabel }}
                    </button>
                @endif
            @endif
            <button 
                type="button" 
                class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100"
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
    
    // Helper para animaciones de salida de toasts (similar a Preline UI)
    // Si el elemento tiene la clase hs-removing, se activará la animación
    document.querySelectorAll('[class*="hs-removing"]').forEach(function(toast) {
        // Observar cuando el elemento se va a remover
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const target = mutation.target;
                    if (target.classList.contains('hs-removing')) {
                        // La animación ya está aplicada por las clases CSS
                        // El elemento se puede remover después de la animación
                    }
                }
            });
        });
        
        observer.observe(toast, {
            attributes: true,
            attributeFilter: ['class']
        });
    });
});
</script>
@endpush

