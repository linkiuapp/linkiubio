{{--
List Checked - Lista con iconos de check
Uso: Listas de características, beneficios, checklist
Cuándo usar: Cuando necesites mostrar items completados o características destacadas
Cuándo NO usar: Cuando necesites listas simples sin iconos
Ejemplo: <x-list-checked variant="simple" color="blue" :items="['FAQ', 'License', 'Terms']" />
--}}

@props([
    'variant' => 'simple', // simple, circle-outline, circle-filled
    'color' => 'blue', // blue, red, green, yellow, gray, teal
    'items' => [],
    'spacing' => 'space-y-3',
    'textColor' => 'text-gray-800',
    'textSize' => 'body-small',
])

@php
    $iconColor = match($color) {
        'blue' => 'text-blue-600',
        'red' => 'text-red-500',
        'green' => 'text-teal-500',
        'yellow' => 'text-yellow-500',
        'gray' => 'text-gray-800',
        'teal' => 'text-teal-500',
        default => 'text-blue-600',
    };
    
    $circleBgColor = match($color) {
        'blue' => 'bg-blue-50 text-blue-600',
        'red' => 'bg-red-50 text-red-500',
        'green' => 'bg-teal-50 text-teal-500',
        'yellow' => 'bg-yellow-50 text-yellow-500',
        'gray' => 'bg-gray-50 text-gray-600',
        'teal' => 'bg-teal-50 text-teal-500',
        default => 'bg-blue-50 text-blue-600',
    };
    
    $circleFilledBg = match($color) {
        'blue' => 'bg-blue-600 text-white',
        'red' => 'bg-red-500 text-white',
        'green' => 'bg-teal-500 text-white',
        'yellow' => 'bg-yellow-500 text-white',
        'gray' => 'bg-gray-800 text-gray-200',
        'teal' => 'bg-teal-500 text-white',
        default => 'bg-blue-600 text-white',
    };
@endphp

<ul class="{{ $spacing }} {{ $textSize }}" {{ $attributes }}>
    @foreach($items as $item)
        <li class="flex gap-x-3">
            @if($variant === 'simple')
                <i data-lucide="check" class="shrink-0 size-4 mt-0.5 {{ $iconColor }}"></i>
                <span class="{{ $textColor }}">{{ $item }}</span>
            @elseif($variant === 'circle-outline')
                <span class="size-5 flex justify-center items-center rounded-full {{ $circleBgColor }}">
                    <i data-lucide="check" class="shrink-0 size-3.5"></i>
                </span>
                <span class="{{ $textColor }}">{{ $item }}</span>
            @elseif($variant === 'circle-filled')
                <span class="size-5 flex justify-center items-center rounded-full {{ $circleFilledBg }}">
                    <i data-lucide="check" class="shrink-0 size-3.5"></i>
                </span>
                <span class="{{ $textColor }}">{{ $item }}</span>
            @endif
        </li>
    @endforeach
</ul>















