{{--
Select Sizes - Select en diferentes tamaños
Uso: Select en diferentes tamaños (sm, md, lg)
Cuándo usar: Cuando necesites variar el tamaño según el contexto
Cuándo NO usar: Cuando el tamaño estándar sea suficiente
Ejemplo: <x-select-sizes size="sm" name="select" :options="['Opción 1', 'Opción 2']" />
--}}

@props([
    'size' => 'md', // 'sm', 'md', 'lg'
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
    
    $sizeClasses = [
        'sm' => 'py-2 px-3',
        'md' => 'py-3 px-4',
        'lg' => 'sm:p-5 p-4',
    ];
    
    $paddingClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<select 
    id="{{ $uniqueId }}"
    name="{{ $nameAttr }}"
    @if($disabled) disabled @endif
    class="{{ $paddingClass }} pe-9 block w-full border border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ $attributes->get('class') }}"
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

