{{--
List Group Links - Grupo de lista con enlaces interactivos
Uso: Navegación, menús con estados activos, enlaces deshabilitados
Cuándo usar: Cuando necesites listas con enlaces que tengan estados (active, hover, disabled)
Cuándo NO usar: Cuando necesites listas estáticas sin interacción
Ejemplo: <x-list-group-links :items="[['label' => 'Active', 'url' => '#', 'icon' => 'bell', 'active' => true]]" />
--}}

@props([
    'items' => [], // Array de objetos: ['label', 'url', 'icon'?, 'active'?, 'disabled'?]
    'width' => 'max-w-xs',
    'textSize' => 'body-small',
])

@php
    $containerClasses = "{$width} flex flex-col";
@endphp

<div class="{{ $containerClasses }}" {{ $attributes }}>
    @foreach($items as $item)
        @php
            $label = $item['label'] ?? '';
            $url = $item['url'] ?? '#';
            $icon = $item['icon'] ?? null;
            $active = $item['active'] ?? false;
            $disabled = $item['disabled'] ?? false;
            
            $linkClasses = "inline-flex items-center gap-x-3.5 py-3 px-4 {$textSize} font-medium border border-gray-200 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600";
            
            if ($active) {
                $linkClasses .= " text-blue-600";
            } elseif ($disabled) {
                $linkClasses .= " text-gray-400 cursor-not-allowed";
            } else {
                $linkClasses .= " text-gray-800 hover:text-blue-600";
            }
        @endphp
        <a href="{{ $disabled ? '#' : $url }}" 
           class="{{ $linkClasses }}"
           @if($disabled) onclick="return false;" @endif>
            @if($icon)
                <i data-lucide="{{ $icon }}" class="shrink-0 size-4"></i>
            @endif
            {{ $label }}
        </a>
    @endforeach
</div>















