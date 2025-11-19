{{--
Toast Basic - Toast básico con icono
Uso: Notificaciones, mensajes de estado, alertas
Cuándo usar: Cuando necesites mostrar mensajes informativos al usuario
Cuándo NO usar: Cuando necesites modales o alertas persistentes
Ejemplo: <x-toast-basic type="success" message="Operación exitosa" />
--}}

@props([
    'type' => 'info', // info, success, error, warning
    'message' => '',
    'id' => null, // ID único para el toast
    'showClose' => false, // Mostrar botón de cerrar
    'onClose' => null, // Callback al cerrar
])

@php
    $uniqueId = $id ?? uniqid('toast-');
    
    $iconConfig = match($type) {
        'success' => ['icon' => 'check-circle', 'color' => 'text-teal-500'],
        'error' => ['icon' => 'x-circle', 'color' => 'text-red-500'],
        'warning' => ['icon' => 'alert-triangle', 'color' => 'text-yellow-500'],
        default => ['icon' => 'info', 'color' => 'text-blue-500'],
    };
    
    $labelId = $uniqueId . '-label';
@endphp

<div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg" 
     role="alert" 
     tabindex="-1" 
     aria-labelledby="{{ $labelId }}"
     id="{{ $uniqueId }}"
     {{ $attributes }}>
    <div class="flex p-4">
        <div class="shrink-0">
            <i data-lucide="{{ $iconConfig['icon'] }}" class="shrink-0 size-4 {{ $iconConfig['color'] }} mt-0.5"></i>
        </div>
        <div class="ms-3 flex-1">
            <p id="{{ $labelId }}" class="body-small text-gray-700">
                {{ $message ?: $slot }}
            </p>
        </div>
        @if($showClose)
            <div class="ms-3">
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
        @endif
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















