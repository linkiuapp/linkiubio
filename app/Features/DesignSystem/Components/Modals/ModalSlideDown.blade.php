{{--
Modal Slide Down - Modal con animación de deslizamiento hacia abajo
Uso: Modal con animación de deslizamiento desde arriba
Cuándo usar: Cuando quieras una animación de deslizamiento suave
Cuándo NO usar: Cuando prefieras otras animaciones
Ejemplo: <x-modal-slide-down modalId="my-modal" title="Título" content="Contenido" />
--}}

@props([
    'modalId' => null,
    'title' => 'Título del Modal',
    'content' => 'Este es un contenido más amplio con texto de apoyo como introducción natural a contenido adicional.',
])

@php
    $uniqueId = $modalId ?? 'modal-slide-' . uniqid();
@endphp

<div x-data="{ open: false }" x-on:keydown.escape.window="open = false">
    <div @click="open = true">
        {{ $slot }}
    </div>
    
    {{-- Modal Overlay --}}
    <div 
        x-show="open"
        x-transition:enter="transition-opacity duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] bg-black/50 backdrop-blur-sm"
        @click="open = false"
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
            class="sm:max-w-lg sm:w-full m-3 sm:mx-auto pointer-events-none"
            x-transition:enter="transition-all ease-out duration-500"
            x-transition:enter-start="opacity-0 mt-0"
            x-transition:enter-end="opacity-100 mt-7"
            x-transition:leave="transition-all ease-out duration-500"
            x-transition:leave-start="opacity-100 mt-7"
            x-transition:leave-end="opacity-0 mt-0"
        >
            <div 
                @click.stop
                class="w-full flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto"
            >
                {{-- Header --}}
                <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                    <h3 id="{{ $uniqueId }}-label" class="font-bold text-gray-800">
                        {{ $title }}
                    </h3>
                    <button 
                        type="button" 
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                        aria-label="Cerrar"
                        @click="open = false"
                    >
                        <span class="sr-only">Cerrar</span>
                        <i data-lucide="x" class="shrink-0 size-4" x-init="lucide.createIcons()"></i>
                    </button>
                </div>

                {{-- Body --}}
                <div class="p-4 overflow-y-auto">
                    <p class="mt-1 text-gray-800">
                        {{ $content }}
                    </p>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                    <button 
                        type="button" 
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
                        @click="open = false"
                    >
                        Cerrar
                    </button>
                    <button 
                        type="button" 
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                        @click="open = false"
                    >
                        Guardar cambios
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

