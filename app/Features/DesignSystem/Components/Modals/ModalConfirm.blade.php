{{--
Modal Confirm - Modal de confirmación con acciones
Uso: Modal para confirmar acciones destructivas o importantes
Cuándo usar: Cuando necesites confirmar una acción antes de ejecutarla
Cuándo NO usar: Cuando la acción no requiera confirmación
Ejemplo: 
<x-modal-confirm modalId="confirm-delete">
    <x-slot:trigger>
        <button>Eliminar</button>
    </x-slot:trigger>
    <x-slot:title>¿Eliminar elemento?</x-slot:title>
    <x-slot:content>Esta acción no se puede deshacer</x-slot:content>
    <x-slot:confirmAction>
        <button @click="deleteItem()">Eliminar</button>
    </x-slot:confirmAction>
</x-modal-confirm>
--}}

@props([
    'modalId' => null,
    'type' => 'danger', // danger, warning, info
])

@php
    $uniqueId = $modalId ?? 'modal-confirm-' . uniqid();
    
    $typeClasses = [
        'danger' => [
            'iconBg' => 'bg-red-100',
            'iconColor' => 'text-red-600',
            'confirmBg' => 'bg-red-600 hover:bg-red-700',
        ],
        'warning' => [
            'iconBg' => 'bg-yellow-100',
            'iconColor' => 'text-yellow-600',
            'confirmBg' => 'bg-yellow-600 hover:bg-yellow-700',
        ],
        'info' => [
            'iconBg' => 'bg-blue-100',
            'iconColor' => 'text-blue-600',
            'confirmBg' => 'bg-blue-600 hover:bg-blue-700',
        ],
    ];
    
    $colors = $typeClasses[$type] ?? $typeClasses['danger'];
@endphp

<div x-data="{ open: false }" x-on:keydown.escape.window="open = false">
    {{-- Trigger --}}
    <div @click="open = true">
        {{ $trigger }}
    </div>
    
    {{-- Modal Overlay --}}
    <div 
        x-show="open"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] bg-black/50 backdrop-blur-sm"
        style="display: none;"
    ></div>

    {{-- Modal Content --}}
    <div 
        x-show="open"
        class="fixed inset-0 z-[9999] overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog"
        tabindex="-1"
        aria-labelledby="{{ $uniqueId }}-label"
        style="display: none;"
    >
        <div 
            class="sm:max-w-lg sm:w-full m-3 sm:mx-auto pointer-events-none min-h-[calc(100%-56px)] flex items-center"
            x-transition:enter="transition-all ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition-all ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <div 
                @click.stop
                class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-lg pointer-events-auto"
            >
                {{-- Header --}}
                <div class="flex items-start gap-4 p-6 border-b border-gray-200">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full {{ $colors['iconBg'] }} flex items-center justify-center">
                            @if($type === 'danger')
                                <i data-lucide="alert-triangle" class="w-6 h-6 {{ $colors['iconColor'] }}"></i>
                            @elseif($type === 'warning')
                                <i data-lucide="alert-circle" class="w-6 h-6 {{ $colors['iconColor'] }}"></i>
                            @else
                                <i data-lucide="info" class="w-6 h-6 {{ $colors['iconColor'] }}"></i>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 id="{{ $uniqueId }}-label" class="text-lg font-semibold text-gray-900 mb-2">
                            {{ $title }}
                        </h3>
                        <div class="text-sm text-gray-600">
                            {{ $content }}
                        </div>
                        {{ $slot }}
                    </div>
                    <button 
                        type="button" 
                        class="flex-shrink-0 p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors" 
                        aria-label="Cerrar"
                        @click="open = false"
                    >
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end items-center gap-3 p-6 border-t border-gray-200">
                    <button 
                        type="button" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors" 
                        @click="open = false"
                    >
                        Cancelar
                    </button>
                    <div @click="open = false">
                        {{ $confirmAction ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush

