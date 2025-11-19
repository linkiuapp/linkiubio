{{--
Input Number Mini - Input numérico compacto
Uso: Input numérico en versión compacta inline
Cuándo usar: Cuando necesites un selector numérico en espacios reducidos
Cuándo NO usar: Cuando necesites mostrar etiquetas o información adicional
Ejemplo: <x-input-number-mini name="quantity" value="0" />
--}}

@props([
    'name' => null,
    'inputId' => null,
    'value' => 0,
    'min' => null,
    'max' => null,
    'step' => 1,
    'disabled' => false,
])

@php
    $uniqueId = $inputId ?? 'input-number-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
@endphp

<div class="py-2 px-3 inline-block bg-white border border-gray-400 rounded-lg" 
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
    <div class="flex items-center gap-x-1.5">
        <button 
            type="button" 
            @click="decrement()"
            :disabled="disabled || (min !== null && value <= min)"
                class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-400 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
            tabindex="-1"
            aria-label="Decrease"
        >
            <i data-lucide="minus" class="shrink-0 size-3.5"></i>
        </button>
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
            class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
            style="-moz-appearance: textfield;"
            {{ $attributes }}
        >
        <button 
            type="button" 
            @click="increment()"
            :disabled="disabled || (max !== null && value >= max)"
                class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-400 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
            tabindex="-1"
            aria-label="Increase"
        >
            <i data-lucide="plus" class="shrink-0 size-3.5"></i>
        </button>
    </div>
</div>

