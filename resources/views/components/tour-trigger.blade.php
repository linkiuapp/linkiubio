{{--
    Componente: Tour Trigger
    
    Muestra un botón de ayuda y opcionalmente inicia el tour automáticamente.
    
    Props:
    - tour: nombre del tour (requerido)
    - autoStart: iniciar automáticamente (default: false)
    - showButton: mostrar botón de ayuda (default: true)
    - buttonClass: clases adicionales para el botón
    - buttonText: texto del botón (default: 'Ayuda')
--}}

@props([
    'tour',
    'autoStart' => false,
    'showButton' => true,
    'buttonClass' => '',
    'buttonText' => 'Ayuda',
])

@php
    $tourService = app(\App\Services\TourService::class);
    $store = view()->shared('currentStore');
    $shouldShow = $store ? $tourService->shouldShowTour($store, $tour) : false;
@endphp

@if($shouldShow)
    @if($showButton)
    <button 
        type="button"
        onclick="window.startTour && window.startTour('{{ $tour }}', true)"
        class="inline-flex items-center gap-1.5 text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors {{ $buttonClass }}"
        title="Ver tutorial"
    >
        <i data-lucide="help-circle" class="w-4 h-4"></i>
        <span>{{ $buttonText }}</span>
    </button>
    @endif
    
    @if($autoStart)
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar si el tour ya fue completado
            if (localStorage.getItem('tour_{{ $tour }}_completed') !== 'true') {
                // Esperar un momento para que la página cargue completamente
                setTimeout(function() {
                    if (window.startTour) {
                        window.startTour('{{ $tour }}');
                    }
                }, 800);
            }
        });
    </script>
    @endpush
    @endif
@endif

