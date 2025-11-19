{{--
Input Number Validation - Input numérico con estado de validación
Uso: Input numérico con estado de error/success
Cuándo usar: Cuando necesites indicar validación del formulario
Cuándo NO usar: Cuando el input normal sea suficiente
Ejemplo: <x-input-number-validation type="error" error-message="Fuera de límite" name="quantity" value="10" />
--}}

@props([
    'type' => 'error', // 'error' o 'success'
    'name' => null,
    'inputId' => null,
    'value' => 0,
    'min' => null,
    'max' => null,
    'step' => 1,
    'disabled' => false,
    'errorMessage' => '',
    'successMessage' => '',
])

@php
    $uniqueId = $inputId ?? 'input-number-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
    $isError = $type === 'error';
    $borderColor = $isError ? 'border-red-500' : 'border-teal-500';
    $iconColor = $isError ? 'text-red-500' : 'text-teal-500';
    $messageColor = $isError ? 'text-red-600' : 'text-teal-600';
    $message = $isError ? $errorMessage : $successMessage;
@endphp

<div>
    <div class="py-2 px-3 bg-white border {{ $borderColor }} rounded-lg" 
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
        <div class="w-full flex justify-between items-center gap-x-3">
            <div class="relative w-full">
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
                    aria-describedby="{{ $uniqueId }}-helper"
                    class="w-full p-0 pe-7 bg-transparent border-0 text-gray-800 focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                    style="-moz-appearance: textfield;"
                    {{ $attributes }}
                >
                <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                    @if($isError)
                        <i data-lucide="alert-circle" class="shrink-0 size-4 {{ $iconColor }}"></i>
                    @else
                        <i data-lucide="check" class="shrink-0 size-4 {{ $iconColor }}"></i>
                    @endif
                </div>
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
    @if($message)
        <p class="text-sm {{ $messageColor }} mt-2" id="{{ $uniqueId }}-helper">{{ $message }}</p>
    @endif
</div>

