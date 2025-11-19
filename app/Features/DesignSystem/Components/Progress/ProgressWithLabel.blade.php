{{--
Progress With Label - Barra de progreso con label al final
Uso: Progreso con porcentaje visible, indicadores con texto
Cuándo usar: Cuando necesites mostrar el porcentaje junto a la barra
Cuándo NO usar: Cuando necesites barras simples sin texto
Ejemplo: <x-progress-with-label :value="25" />
--}}

@props([
    'value' => 0,
    'color' => 'blue',
    'height' => 'h-2',
    'showIcon' => false, // Si mostrar icono de check/error en lugar de porcentaje
    'iconType' => 'check', // 'check' o 'error'
])

@php
    $barColor = match($color) {
        'blue' => 'bg-blue-600',
        'gray' => 'bg-gray-500',
        'dark' => 'bg-gray-800',
        'green' => 'bg-teal-500',
        'red' => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'white' => 'bg-white',
        default => 'bg-blue-600',
    };
    
    $value = max(0, min(100, $value));
@endphp

<div class="flex items-center gap-x-3 whitespace-nowrap" {{ $attributes }}>
    <div class="flex w-full {{ $height }} bg-gray-200 rounded-full overflow-hidden" 
         role="progressbar" 
         aria-valuenow="{{ $value }}" 
         aria-valuemin="0" 
         aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden {{ $barColor }} text-xs text-white text-center whitespace-nowrap transition duration-500" 
             style="width: {{ $value }}%"></div>
    </div>
    <div class="w-10 text-end">
        @if($showIcon)
            @if($iconType === 'check')
                <span class="shrink-0 ms-auto size-4 flex justify-center items-center rounded-full {{ $barColor }} text-white">
                    <i data-lucide="check" class="shrink-0 size-3"></i>
                </span>
            @else
                <span class="shrink-0 ms-auto size-4 flex justify-center items-center rounded-full {{ $barColor }} text-white">
                    <i data-lucide="x" class="shrink-0 size-3"></i>
                </span>
            @endif
        @else
            <span class="body-small text-gray-800">{{ $value }}%</span>
        @endif
    </div>
</div>















