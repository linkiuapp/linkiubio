{{--
Select Validation - Select con estados de validación
Uso: Select con estados de validación (error/success)
Cuándo usar: Cuando necesites indicar validación del formulario
Cuándo NO usar: Cuando el select normal sea suficiente
Ejemplo: <x-select-validation type="error" label="País" name="country" error-message="Por favor selecciona un país válido" :options="['Colombia', 'México']" />
--}}

@props([
    'type' => 'error', // 'error' o 'success'
    'label' => '',
    'labelFor' => null,
    'name' => null,
    'selectId' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Selecciona una opción',
    'disabled' => false,
    'errorMessage' => '',
    'successMessage' => '',
])

@php
    $uniqueId = $selectId ?? $labelFor ?? 'select-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
    $isError = $type === 'error';
    $borderColor = $isError ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-teal-500 focus:border-teal-500 focus:ring-teal-500';
    $iconColor = $isError ? 'text-red-500' : 'text-teal-500';
    $messageColor = $isError ? 'text-red-600' : 'text-teal-600';
    $message = $isError ? $errorMessage : $successMessage;
@endphp

<div>
    @if($label)
        <label for="{{ $uniqueId }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
    @endif
    <div class="relative">
        <select 
            id="{{ $uniqueId }}"
            name="{{ $nameAttr }}"
            @if($disabled) disabled @endif
            class="py-3 px-4 pe-16 block w-full border {{ $borderColor }} rounded-lg text-sm disabled:opacity-50 disabled:pointer-events-none {{ $attributes->get('class') }}"
            {{ $attributes->except('class') }}
        >
            @if($placeholder)
                <option value="" @if($selected === null || $selected === '') selected @endif>{{ $placeholder }}</option>
            @endif
            @foreach($options as $value => $labelOption)
                @if(is_array($labelOption))
                    <optgroup label="{{ $value }}">
                        @foreach($labelOption as $optValue => $optLabel)
                            <option value="{{ $optValue }}" @if($selected == $optValue) selected @endif>{{ $optLabel }}</option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ is_numeric($value) ? $labelOption : $value }}" @if($selected == (is_numeric($value) ? $labelOption : $value)) selected @endif>
                        {{ $labelOption }}
                    </option>
                @endif
            @endforeach
        </select>
        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-8">
            @if($isError)
                <i data-lucide="alert-circle" class="shrink-0 size-4 {{ $iconColor }}"></i>
            @else
                <i data-lucide="check" class="shrink-0 size-4 {{ $iconColor }}"></i>
            @endif
        </div>
    </div>
    @if($message)
        <p class="text-sm {{ $messageColor }} mt-2">{{ $message }}</p>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

