{{--
Badge en Botón - Badge usado como contador dentro de botones
Uso: Contadores en botones como notificaciones, elementos pendientes, carritos
Cuándo usar: Botones que requieren mostrar cantidad, notificaciones pendientes
Cuándo NO usar: Botones simples sin contadores, información estática
Ejemplo: <x-badge-button text="Notificaciones" count="5" icon="bell" />
--}}

@props([
    'text' => 'Botón',
    'count' => '',
    'icon' => '',
    'color' => 'red', // red, green, blue, yellow, gray
    'buttonStyle' => 'default', // default, outline, ghost
    'size' => 'md', // sm, md, lg
])

@php
    $countColorClasses = [
        'red' => 'bg-red-500 text-white',
        'green' => 'bg-green-500 text-white',
        'blue' => 'bg-blue-500 text-white',
        'yellow' => 'bg-yellow-500 text-white',
        'gray' => 'bg-gray-500 text-white'
    ];
    
    $buttonStyleClasses = [
        'default' => 'border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50',
        'outline' => 'border border-gray-300 bg-transparent text-gray-700 hover:bg-gray-50',
        'ghost' => 'border-transparent bg-transparent text-gray-700 hover:bg-gray-100'
    ];
    
    $sizeClasses = [
        'sm' => 'py-2 px-3 body-small',
        'md' => 'py-3 px-4 body-small',
        'lg' => 'py-4 px-5 body-lg'
    ];
    
    $countColorClass = $countColorClasses[$color] ?? $countColorClasses['red'];
    $buttonStyleClass = $buttonStyleClasses[$buttonStyle] ?? $buttonStyleClasses['default'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<button type="button" 
        class="{{ $sizeClass }} inline-flex items-center gap-x-2 font-medium rounded-lg {{ $buttonStyleClass }} disabled:opacity-50 transition-colors"
        {{ $attributes }}>
    @if($icon)
        <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
    @endif
    
    {{ $text }}
    
    @if($count)
        <span class="inline-flex items-center py-0.5 px-1.5 rounded-full caption font-medium {{ $countColorClass }}">
            {{ $count }}
        </span>
    @endif
</button>
