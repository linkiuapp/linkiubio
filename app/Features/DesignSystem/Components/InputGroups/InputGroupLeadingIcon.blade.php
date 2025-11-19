{{--
Input Group Leading Icon - Icono al inicio dentro del input
Uso: Permite agregar un icono dentro del input al inicio
Cuándo usar: Cuando necesites un icono descriptivo dentro del campo de input
Cuándo NO usar: Cuando el icono deba ser parte del borde del input
Ejemplo: <x-input-group-leading-icon icon="mail" input-id="email" placeholder="you@site.com" />
--}}

@props([
    'icon' => 'mail', // Nombre del icono Lucide
    'inputId' => null,
    'inputName' => null,
    'label' => null,
    'placeholder' => '',
])

@php
    $uniqueId = $inputId ?? 'input-group-' . uniqid();
    $inputNameAttr = $inputName ?? $uniqueId;
@endphp

@if($label)
    <label for="{{ $uniqueId }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
@endif
<div class="relative">
    <input 
        type="text" 
        id="{{ $uniqueId }}" 
        name="{{ $inputNameAttr }}" 
        class="py-2.5 sm:py-3 px-4 ps-11 block w-full border border-gray-400 rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" 
        placeholder="{{ $placeholder }}"
    >
    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
        <i data-lucide="{{ $icon }}" class="shrink-0 size-4 text-gray-400"></i>
    </div>
</div>

