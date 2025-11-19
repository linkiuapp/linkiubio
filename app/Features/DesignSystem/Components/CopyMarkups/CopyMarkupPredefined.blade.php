{{--
Copy Markup Predefined - Componente para duplicar markup predefinido
Uso: Permite copiar un markup predefinido que está oculto por defecto
Cuándo usar: Cuando necesites un template específico que se copia al hacer clic
Cuándo NO usar: Cuando quieras copiar el input actual
Ejemplo: <x-copy-markup-predefined template-id="template-copy" wrapper-id="wrapper-copy" limit="3" button-text="Agregar Nombre" />
--}}

@props([
    'templateId' => null,
    'wrapperId' => null,
    'limit' => 3,
    'buttonText' => 'Agregar',
])

@php
    $uniqueTemplateId = $templateId ?? 'template-copy-' . uniqid();
    $uniqueWrapperId = $wrapperId ?? 'wrapper-copy-' . uniqid();
@endphp

<div x-data="{
    count: 0,
    limit: {{ $limit }},
    templateId: '{{ $uniqueTemplateId }}',
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
        const template = document.getElementById(this.templateId);
        
        if (!wrapper || !template) return;
        
        const newInput = template.cloneNode(true);
        newInput.id = this.templateId + '-' + this.count;
        newInput.classList.remove('hidden');
        
        // Actualizar IDs únicos dentro del template clonado
        const inputs = newInput.querySelectorAll('input, select, textarea');
        inputs.forEach((input, index) => {
            if (input.id) {
                input.id = input.id + '-' + this.count + '-' + index;
            }
            if (input.name) {
                input.name = input.name + '[' + this.count + ']';
            }
        });
        
        wrapper.appendChild(newInput);
        
        this.count++;
        
        this.$nextTick(() => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    }
}">
    <div id="{{ $uniqueWrapperId }}" class="space-y-3"></div>

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

    <div id="{{ $uniqueTemplateId }}" class="hidden">
        {{ $slot }}
    </div>
</div>

