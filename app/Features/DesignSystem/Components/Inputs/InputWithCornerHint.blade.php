{{--
Input con Corner Hint - Ejemplo básico de input con etiqueta en esquina
Uso: Input con texto adicional en la esquina superior derecha (ej: "Opcional", "Requerido")
Cuándo usar: Formularios donde necesites indicar el estado del campo de manera sutil
Cuándo NO usar: Formularios simples, cuando ya tengas mucha información visual
Ejemplo: <x-input-with-corner-hint label="Teléfono" hint="Opcional" placeholder="+57 300 123 4567" />
--}}

@props([
    'type' => 'text',
    'label' => '',
    'hint' => '',
    'placeholder' => '',
    'name' => '',
    'id' => '',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
])

@php
    $inputId = $id ?: 'input-hint-' . uniqid();
@endphp

<div class="max-w-sm">
    <div class="flex flex-wrap justify-between items-center gap-2">
        <label for="{{ $inputId }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
        @if($hint)
            <span class="block mb-2 text-sm text-gray-500">{{ $hint }}</span>
        @endif
    </div>
    <input 
        type="{{ $type }}" 
        id="{{ $inputId }}" 
        @if($name) name="{{ $name }}" @endif
        @if($value) value="{{ $value }}" @endif
        @if($required) required @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        class="p-3 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 disabled:opacity-50 disabled:pointer-events-none" 
        placeholder="{{ $placeholder }}"
        {{ $attributes }}>
</div>
