{{--
Select Basic - Select básico
Uso: Select básico estándar
Cuándo usar: Cuando necesites un dropdown simple
Cuándo NO usar: Cuando necesites validación o estilos especiales
Ejemplo: <x-select-basic name="select" :options="['Opción 1', 'Opción 2']" />
--}}

@props([
    'name' => null,
    'selectId' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Selecciona una opción',
    'disabled' => false,
])

@php
    $uniqueId = $selectId ?? 'select-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
@endphp

<select 
    id="{{ $uniqueId }}"
    name="{{ $nameAttr }}"
    @if($disabled) disabled @endif
    class="py-3 px-4 pe-9 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ $attributes->get('class') }}"
    {{ $attributes->except('class') }}
>
    @if($placeholder)
        <option value="" @if($selected === null || $selected === '') selected @endif>{{ $placeholder }}</option>
    @endif
    @foreach($options as $value => $label)
        @if(is_array($label))
            <optgroup label="{{ $value }}">
                @foreach($label as $optValue => $optLabel)
                    <option value="{{ $optValue }}" @if($selected == $optValue) selected @endif>{{ $optLabel }}</option>
                @endforeach
            </optgroup>
        @else
            <option value="{{ $value }}" @if($selected == $value) selected @endif>
                {{ $label }}
            </option>
        @endif
    @endforeach
</select>

