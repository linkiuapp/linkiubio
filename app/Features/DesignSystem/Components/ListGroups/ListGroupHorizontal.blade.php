{{--
List Group Horizontal - Grupo de lista horizontal (responsive)
Uso: Navegación horizontal, tabs, opciones en fila
Cuándo usar: Cuando necesites listas horizontales que se adapten a móvil
Cuándo NO usar: Cuando necesites listas verticales o con mucho contenido
Ejemplo: <x-list-group-horizontal :items="[['label' => 'Newsletter', 'icon' => 'bell']]" />
--}}

@props([
    'items' => [], // Array de objetos: ['label', 'icon'?]
    'textSize' => 'body-small',
    'textColor' => 'text-gray-800',
])

<ul class="flex flex-col sm:flex-row" {{ $attributes }}>
    @foreach($items as $item)
        @php
            $label = is_array($item) ? ($item['label'] ?? $item) : $item;
            $icon = is_array($item) ? ($item['icon'] ?? null) : null;
        @endphp
        <li class="inline-flex items-center gap-x-2.5 py-3 px-4 {{ $textSize }} font-medium bg-white border border-gray-200 {{ $textColor }} -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ms-px sm:mt-0 sm:first:rounded-se-none sm:first:rounded-es-lg sm:last:rounded-es-none sm:last:rounded-se-lg">
            @if($icon)
                <i data-lucide="{{ $icon }}" class="shrink-0 size-4"></i>
            @endif
            {{ $label }}
        </li>
    @endforeach
</ul>















