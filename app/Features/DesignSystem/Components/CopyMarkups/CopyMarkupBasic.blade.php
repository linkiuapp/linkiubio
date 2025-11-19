{{--
Copy Markup Basic - Componente para duplicar inputs dinámicamente
Uso: Permite duplicar un input existente dentro de un contenedor
Cuándo usar: Cuando necesites que el usuario pueda agregar múltiples campos del mismo tipo
Cuándo NO usar: Cuando solo necesites un campo único
Ejemplo: <x-copy-markup-basic input-id="content-copy" wrapper-id="wrapper-copy" limit="3" button-text="Agregar Nombre" />
--}}

@props([
    'inputId' => null,
    'wrapperId' => null,
    'limit' => 3,
    'buttonText' => 'Agregar',
    'placeholder' => 'Ingresa nombre',
])

@php
    $uniqueInputId = $inputId ?? 'content-copy-' . uniqid();
    $uniqueWrapperId = $wrapperId ?? 'wrapper-copy-' . uniqid();
@endphp

<div x-data="{
    count: 1,
    limit: {{ $limit }},
    inputId: '{{ $uniqueInputId }}',
    wrapperId: '{{ $uniqueWrapperId }}',
    init() {
        this.$nextTick(() => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    },
    addInput() {
        if (this.count >= this.limit) return;
        
        const wrapper = document.getElementById(this.wrapperId);
        const originalInput = document.getElementById(this.inputId);
        
        if (!wrapper || !originalInput) return;
        
        const newInput = originalInput.cloneNode(true);
        newInput.id = this.inputId + '-' + this.count;
        newInput.value = '';
        
        wrapper.appendChild(newInput);
        
        this.count++;
        
        this.$nextTick(() => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    }
}">
    <div id="{{ $uniqueWrapperId }}" class="space-y-3">
        <input 
            id="{{ $uniqueInputId }}"
            type="text" 
            class="py-2.5 sm:py-3 px-4 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" 
            placeholder="{{ $placeholder }}"
            {{ $attributes }}
        >
    </div>

    <p class="mt-3 text-end">
        <button 
            type="button" 
            @click="addInput()"
            :disabled="count >= limit"
            class="py-1.5 px-2 inline-flex items-center gap-x-1 text-xs font-medium rounded-full border border-dashed border-gray-400 bg-white text-gray-800 hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
        >
            <i data-lucide="plus" class="shrink-0 size-3.5" x-init="if (typeof lucide !== 'undefined') lucide.createIcons()"></i>
            {{ $buttonText }}
        </button>
    </p>
</div>

