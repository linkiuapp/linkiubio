{{--
Input con Label - Ejemplo básico de input con etiqueta
Uso: Input con label visible para mayor claridad, ideal para formularios accesibles
Cuándo usar: Formularios de registro, datos importantes, cuando necesites identificación clara del campo
Cuándo NO usar: Formularios muy compactos, modales pequeños donde el espacio es limitado
Ejemplo: <x-input-with-label label="Correo electrónico" placeholder="tu@correo.com" />
--}}

@props([
    'type' => 'text',
    'label' => '',
    'placeholder' => '',
    'name' => '',
    'id' => '',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'containerClass' => 'max-w-sm',
])

@php
    $inputId = $id ?: 'input-' . uniqid();
@endphp

<div class="{{ $containerClass }}">
    <label for="{{ $inputId }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
    <input 
        type="{{ $type }}" 
        id="{{ $inputId }}" 
        @if($name) name="{{ $name }}" @endif
        @if(!is_null($value) && $value !== '') value="{{ $value }}" @endif
        @if($required) required @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        placeholder="{{ $placeholder }}"
        {{
            $attributes->merge([
                'class' => 'p-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 disabled:opacity-50 disabled:pointer-events-none'
            ])
        }}>
</div>
