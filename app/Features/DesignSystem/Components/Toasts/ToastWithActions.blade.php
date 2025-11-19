{{--
Toast With Actions - Toast con título, descripción y acciones
Uso: Notificaciones con múltiples opciones, confirmaciones, permisos
Cuándo usar: Cuando necesites mostrar un toast con título, descripción y botones de acción
Cuándo NO usar: Cuando solo necesites un mensaje simple
Ejemplo: <x-toast-with-actions title="Notificaciones de app" description="Las notificaciones pueden incluir alertas..." :actions="[['label' => 'No permitir'], ['label' => 'Permitir']]" />
--}}

@props([
    'title' => '',
    'description' => '',
    'icon' => 'bell', // Icono de Lucide
    'iconColor' => 'text-gray-600',
    'actions' => [], // Array de acciones: [['label' => 'Action', 'url' => '...' o 'onClick' => '...']]
    'id' => null,
])

@php
    $uniqueId = $id ?? uniqid('toast-actions-');
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
            <i data-lucide="{{ $icon }}" class="size-5 {{ $iconColor }} mt-1"></i>
        </div>
        <div class="ms-4">
            @if($title)
                <h3 id="{{ $labelId }}" class="text-gray-800 font-semibold">
                    {{ $title }}
                </h3>
            @endif
            @if($description)
                <div class="mt-1 body-small text-gray-600">
                    {{ $description }}
                </div>
            @endif
            @if(count($actions) > 0)
                <div class="mt-4">
                    <div class="flex gap-x-3">
                        @foreach($actions as $action)
                            @if(isset($action['url']))
                                <a href="{{ $action['url'] }}" class="text-blue-600 decoration-2 hover:underline font-medium body-small focus:outline-hidden focus:underline">
                                    {{ $action['label'] }}
                                </a>
                            @elseif(isset($action['onClick']))
                                <button 
                                    type="button" 
                                    class="text-blue-600 decoration-2 hover:underline font-medium body-small focus:outline-hidden focus:underline"
                                    onclick="{{ $action['onClick'] }}"
                                >
                                    {{ $action['label'] }}
                                </button>
                            @else
                                <button 
                                    type="button" 
                                    class="text-blue-600 decoration-2 hover:underline font-medium body-small focus:outline-hidden focus:underline"
                                >
                                    {{ $action['label'] }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
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















