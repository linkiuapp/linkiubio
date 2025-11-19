{{--
Toggle Password Input - Input individual para usar dentro de TogglePasswordMulti
Uso: Input de contraseña individual que se usa dentro del componente Multi
Cuándo usar: Solo dentro de TogglePasswordMulti
Cuándo NO usar: Para uso individual, usar TogglePasswordBasic
Ejemplo: <x-toggle-password-input name="password" label="Contraseña" />
--}}

@props([
    'name' => null,
    'inputId' => null,
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'disabled' => false,
    'maxWidth' => 'max-w-sm',
])

@php
    $uniqueId = $inputId ?? 'toggle-password-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
@endphp

<div class="{{ $maxWidth }}" x-data="{ showPassword: $parent.showPassword }">
    @if($label)
        <label for="{{ $uniqueId }}" class="block text-sm mb-2">{{ $label }}</label>
    @endif
    <div class="relative">
        <input 
            id="{{ $uniqueId }}"
            name="{{ $nameAttr }}"
            :type="$parent.showPassword ? 'text' : 'password'"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($value) value="{{ $value }}" @endif
            @if($disabled) disabled @endif
            class="py-2.5 sm:py-3 ps-4 pe-10 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
            {{ $attributes }}
        >
        <button 
            type="button" 
            @click="$parent.showPassword = !$parent.showPassword"
            class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-hidden focus:text-blue-600"
            aria-label="Mostrar/Ocultar contraseña"
        >
            <i :data-lucide="$parent.showPassword ? 'eye-off' : 'eye'" class="shrink-0 size-3.5"></i>
        </button>
    </div>
</div>















