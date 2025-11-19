{{--
Alert Dismiss - Alerta que puede ser cerrada por el usuario
Código exacto de Preline UI sin modificaciones en clases
--}}

@props([
    'type' => 'success', // success, info, warning, error
    'title' => '',
    'id' => '',
])

@php
    $typeClasses = [
        'success' => [
            'container' => 'bg-teal-50 border border-teal-200 text-teal-800',
            'button' => 'bg-teal-50 rounded-lg p-1.5 text-teal-500 hover:bg-teal-100 focus:outline-hidden focus:bg-teal-100',
        ],
        'info' => [
            'container' => 'bg-blue-50 border border-blue-200 text-blue-800',
            'button' => 'bg-blue-50 rounded-lg p-1.5 text-blue-500 hover:bg-blue-100 focus:outline-hidden focus:bg-blue-100',
        ],
        'warning' => [
            'container' => 'bg-yellow-50 border border-yellow-200 text-yellow-800',
            'button' => 'bg-yellow-50 rounded-lg p-1.5 text-yellow-500 hover:bg-yellow-100 focus:outline-hidden focus:bg-yellow-100',
        ],
        'error' => [
            'container' => 'bg-red-50 border border-red-200 text-red-800',
            'button' => 'bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-hidden focus:bg-red-100',
        ],
    ];
    
    $config = $typeClasses[$type] ?? $typeClasses['success'];
    $alertId = $id ?: 'dismiss-alert';
    $iconName = $type === 'success' ? 'check-circle' : ($type === 'error' ? 'x-circle' : 'info');
@endphp

<div id="{{ $alertId }}" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 {{ $config['container'] }} text-sm rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-dismiss-button-label" {{ $attributes }}>
    <div class="flex">
        <div class="shrink-0">
            <i data-lucide="{{ $iconName }}" class="shrink-0 size-4 mt-0.5"></i>
        </div>
        <div class="ms-2">
            @if($title)
                <h3 id="hs-dismiss-button-label" class="text-sm font-medium">
                    {{ $title }}
                </h3>
            @endif
        </div>
        <div class="ps-3 ms-auto">
            <div class="-mx-1.5 -my-1.5">
                <button type="button" class="inline-flex {{ $config['button'] }}" data-hs-remove-element="#{{ $alertId }}">
                    <span class="sr-only">Descartar</span>
                    <i data-lucide="x" class="shrink-0 size-4"></i>
                </button>
            </div>
        </div>
    </div>
</div>

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
