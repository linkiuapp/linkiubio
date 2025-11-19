{{--
Switch Soft - Switch con variante de color suave
Uso: Switch con estilo suave (fondo azul claro cuando está activo)
Cuándo usar: Cuando necesites un estilo más sutil
Cuándo NO usar: Cuando necesites el estilo estándar
Ejemplo: <x-switch-soft size="sm" checked="false" />
--}}

@props([
    'size' => 'sm', // 'sm', 'md', 'lg'
    'switchId' => null,
    'switchName' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $uniqueId = $switchId ?? 'switch-' . uniqid();
    $nameAttr = $switchName ?? $uniqueId;
    
    $sizeClasses = [
        'sm' => [
            'container' => 'w-11 h-6',
            'thumb' => 'size-5',
        ],
        'md' => [
            'container' => 'w-[3.25rem] h-7',
            'thumb' => 'size-6',
        ],
        'lg' => [
            'container' => 'w-[3.75rem] h-8',
            'thumb' => 'size-7',
        ],
    ];
    
    $classes = $sizeClasses[$size] ?? $sizeClasses['sm'];
@endphp

<div class="flex items-center">
    <label for="{{ $uniqueId }}" class="relative inline-block {{ $classes['container'] }} cursor-pointer">
        <input 
            type="checkbox" 
            id="{{ $uniqueId }}"
            name="{{ $nameAttr }}"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            class="peer sr-only"
            {{ $attributes }}
        >
        <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-100 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 {{ $classes['thumb'] }} bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:bg-blue-600 peer-checked:translate-x-full"></span>
    </label>
</div>

