{{--
List Group Basic - Grupo de lista básico con items
Uso: Listas de navegación, menús laterales, opciones de configuración
Cuándo usar: Cuando necesites mostrar una lista de items agrupados con bordes y espaciado consistente
Cuándo NO usar: Cuando necesites listas interactivas con enlaces o botones
Ejemplo: <x-list-group-basic :items="['Profile', 'Settings', 'Newsletter']" />
--}}

@props([
    'items' => [], // Array de items o array de objetos con 'label' y opcionalmente 'icon'
    'width' => 'max-w-xs',
    'textSize' => 'body-small',
    'textColor' => 'text-gray-800',
    'noGutters' => false, // Si true, sin padding lateral y usa dividers
])

@php
    $containerClasses = "{$width} flex flex-col";
    if ($noGutters) {
        $containerClasses .= " divide-y divide-gray-200";
    }
    
    $itemClasses = "inline-flex items-center gap-x-2 body-small font-medium text-gray-800";
    
    if ($noGutters) {
        $itemClasses .= " py-3";
    } else {
        $itemClasses .= " py-3 px-4 bg-white border border-gray-200 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg";
    }
@endphp

<ul class="{{ $containerClasses }}" {{ $attributes }}>
    @foreach($items as $item)
        @php
            $label = is_array($item) ? ($item['label'] ?? $item) : $item;
            $icon = is_array($item) ? ($item['icon'] ?? null) : null;
        @endphp
        <li class="{{ $itemClasses }}">
            @if($icon)
                <i data-lucide="{{ $icon }}" class="shrink-0 size-4"></i>
            @endif
            {{ $label }}
        </li>
    @endforeach
</ul>















