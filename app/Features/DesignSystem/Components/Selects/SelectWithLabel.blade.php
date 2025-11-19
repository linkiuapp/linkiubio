{{--
Select With Label - Select con etiqueta
Uso: Select con etiqueta visible
Cuándo usar: Cuando necesites mostrar claramente qué representa el select
Cuándo NO usar: Cuando el contexto ya sea claro
Ejemplo: <x-select-with-label label="País" name="country" :options="['Colombia', 'México']" />
--}}

@props([
    'label' => '',
    'labelFor' => null,
    'name' => null,
    'selectId' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Selecciona una opción',
    'disabled' => false,
])

@php
    $uniqueId = $selectId ?? $labelFor ?? 'select-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
@endphp

<label for="{{ $uniqueId }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
<select 
    id="{{ $uniqueId }}"
    name="{{ $nameAttr }}"
    @if($disabled) disabled @endif
    class="py-3 px-4 pe-9 block w-full border border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ $attributes->get('class') }}"
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

