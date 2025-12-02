{{--
Modal Generic - Modal genérico con slots para contenido personalizado
Uso: Modal flexible que acepta contenido personalizado mediante slots
Cuándo usar: Cuando necesites un modal con formularios, contenido dinámico o estructura personalizada
Cuándo NO usar: Cuando el contenido sea simple y puedas usar modal-basic
Ejemplo: 
<x-modal-generic modalId="my-modal" openVariable="showModal" closeHandler="resetForm()">
    <x-slot:header>
        <h3>Título</h3>
    </x-slot:header>
    <x-slot:body>
        <form>...</form>
    </x-slot:body>
    <x-slot:footer>
        <button>Guardar</button>
    </x-slot:footer>
</x-modal-generic>
--}}

@props([
    'modalId' => null,
    'maxWidth' => 'lg', // sm, md, lg, xl, 2xl
    'closeOnBackdrop' => true, // Si se cierra al hacer clic fuera
    'openVariable' => null, // Nombre de la variable Alpine.js (ej: 'showCreateModal')
    'closeHandler' => null, // Función a ejecutar al cerrar (ej: 'resetForm()')
])

@php
    $uniqueId = $modalId ?? 'modal-generic-' . uniqid();
    
    $maxWidthClasses = [
        'xs' => 'max-w-xs',
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ];
    
    $maxWidthClass = $maxWidthClasses[$maxWidth] ?? $maxWidthClasses['lg'];
    
    // Construir el código de cierre
    $closeCode = $openVariable ? $openVariable . ' = false' : 'open = false';
    if ($closeHandler) {
        $closeCode .= '; ' . $closeHandler;
    }
@endphp

@if($openVariable)
    {{-- Modal usando variable del padre --}}
    <div 
        x-show="{{ $openVariable }}"
        x-cloak
        x-transition
        class="fixed inset-0 z-[9999] overflow-x-hidden overflow-y-auto pointer-events-none"
        @keydown.escape.window="{{ $closeCode }}"
        role="dialog"
        tabindex="-1"
        aria-labelledby="{{ $uniqueId }}-label"
        style="display: none;"
    >
        {{-- Modal Overlay --}}
        <div 
            x-show="{{ $openVariable }}"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[9999] bg-black/50 backdrop-blur-sm"
            @if($closeOnBackdrop)
                @click="{{ $closeCode }}"
            @endif
            style="display: none;"
        ></div>

        {{-- Modal Content --}}
        <div 
            x-show="{{ $openVariable }}"
            class="fixed inset-0 z-[9999] overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog"
            tabindex="-1"
            aria-labelledby="{{ $uniqueId }}-label"
            style="display: none;"
        >
            <div 
                class="{{ $maxWidthClass }} w-full m-3 sm:mx-auto pointer-events-none min-h-[calc(100%-56px)] flex items-center"
                x-transition:enter="transition-all ease-out duration-300"
                x-transition:enter-start="opacity-0 mt-0"
                x-transition:enter-end="opacity-100 mt-7"
                x-transition:leave="transition-all ease-in duration-200"
                x-transition:leave-start="opacity-100 mt-7"
                x-transition:leave-end="opacity-0 mt-0"
            >
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    {{-- Header --}}
                    @if(isset($header))
                        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                            <div id="{{ $uniqueId }}-label" class="flex-1">
                                {{ $header }}
                            </div>
                            <button 
                                type="button" 
                                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                                aria-label="Cerrar"
                                @click="{{ $closeCode }}"
                            >
                                <span class="sr-only">Cerrar</span>
                                <i data-lucide="x" class="shrink-0 size-4"></i>
                            </button>
                        </div>
                    @endif

                    {{-- Body --}}
                    @if(isset($body) || $slot->isNotEmpty())
                        <div class="p-4 overflow-y-auto">
                            {{ $body ?? $slot }}
                        </div>
                    @endif

                    {{-- Footer --}}
                    @if(isset($footer))
                        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                            {{ $footer }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@else
    {{-- Modal con estado interno (fallback) --}}
    <div 
        x-data="{ open: false }"
        x-on:keydown.escape.window="open = false"
        x-bind:class="{ 'open': open }"
    >
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
            @if($closeOnBackdrop)
                @click="open = false"
            @endif
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
                class="{{ $maxWidthClass }} w-full m-3 sm:mx-auto pointer-events-none min-h-[calc(100%-56px)] flex items-center"
                x-transition:enter="transition-all ease-out duration-300"
                x-transition:enter-start="opacity-0 mt-0"
                x-transition:enter-end="opacity-100 mt-7"
                x-transition:leave="transition-all ease-in duration-200"
                x-transition:leave-start="opacity-100 mt-7"
                x-transition:leave-end="opacity-0 mt-0"
            >
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    {{-- Header --}}
                    @if(isset($header))
                        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                            <div id="{{ $uniqueId }}-label" class="flex-1">
                                {{ $header }}
                            </div>
                            <button 
                                type="button" 
                                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                                aria-label="Cerrar"
                                @click="open = false"
                            >
                                <span class="sr-only">Cerrar</span>
                                <i data-lucide="x" class="shrink-0 size-4"></i>
                            </button>
                        </div>
                    @endif

                    {{-- Body --}}
                    @if(isset($body) || $slot->isNotEmpty())
                        <div class="p-4 overflow-y-auto">
                            {{ $body ?? $slot }}
                        </div>
                    @endif

                    {{-- Footer --}}
                    @if(isset($footer))
                        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                            {{ $footer }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush
