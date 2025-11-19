{{--
Input Number With Label - Input numérico con etiqueta
Uso: Input numérico con etiqueta y botones de incremento/decremento
Cuándo usar: Cuando necesites mostrar claramente qué representa el número
Cuándo NO usar: Cuando el contexto ya sea claro
Ejemplo: <x-input-number-with-label label="Selecciona cantidad" name="quantity" value="1" />
--}}

@props([
    'label' => '',
    'name' => null,
    'inputId' => null,
    'value' => 1,
    'min' => null,
    'max' => null,
    'step' => 1,
    'disabled' => false,
])

@php
    $uniqueId = $inputId ?? 'input-number-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
@endphp

<div class="py-2 px-3 bg-white border border-gray-400 rounded-lg" 
     x-data="{
         value: {{ $value }},
         min: @json($min),
         max: @json($max),
         step: {{ $step }},
         disabled: @json($disabled),
         init() {
             this.$nextTick(() => {
                 if (typeof lucide !== 'undefined') {
                     lucide.createIcons();
                 }
             });
         },
         increment() {
             if (this.max !== null && this.value >= this.max) return;
             this.value = parseFloat(this.value) + this.step;
             if (this.max !== null && this.value > this.max) {
                 this.value = this.max;
             }
         },
         decrement() {
             if (this.min !== null && this.value <= this.min) return;
             this.value = parseFloat(this.value) - this.step;
             if (this.min !== null && this.value < this.min) {
                 this.value = this.min;
             }
         }
     }">
    <div class="w-full flex justify-between items-center gap-x-5">
        <div class="grow">
            @if($label)
                <span class="block text-xs text-gray-500 mb-1">
                    {{ $label }}
                </span>
            @endif
            <input 
                type="number" 
                id="{{ $uniqueId }}"
                name="{{ $nameAttr }}"
                x-model="value"
                @if($min !== null) min="{{ $min }}" @endif
                @if($max !== null) max="{{ $max }}" @endif
                step="{{ $step }}"
                @if($disabled) disabled @endif
                aria-roledescription="Number field"
                class="w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                style="-moz-appearance: textfield;"
                {{ $attributes }}
            >
        </div>
        <div class="flex justify-end items-center gap-x-1.5">
            <button 
                type="button" 
                @click="decrement()"
                :disabled="disabled || (min !== null && value <= min)"
                class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-400 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                tabindex="-1"
                aria-label="Decrease"
            >
                <i data-lucide="minus" class="shrink-0 size-3.5"></i>
            </button>
            <button 
                type="button" 
                @click="increment()"
                :disabled="disabled || (max !== null && value >= max)"
                class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-400 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                tabindex="-1"
                aria-label="Increase"
            >
                <i data-lucide="plus" class="shrink-0 size-3.5"></i>
            </button>
        </div>
    </div>
</div>

