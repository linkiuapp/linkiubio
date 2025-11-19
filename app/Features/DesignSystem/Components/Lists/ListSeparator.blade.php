{{--
List Separator - Lista con separadores de puntos
Uso: Listas horizontales con separadores visuales entre items
Cuándo usar: Para navegación horizontal, breadcrumbs, enlaces relacionados
Cuándo NO usar: Cuando necesites listas verticales o con viñetas
Ejemplo: <x-list-separator :items="['FAQ', 'License', 'Terms']" />
--}}

@props([
    'items' => [],
    'textColor' => 'text-gray-600',
    'textSize' => 'body-small',
])

<ul class="{{ $textSize }} {{ $textColor }}" {{ $attributes }}>
    @foreach($items as $index => $item)
        <li class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:size-1 before:bg-gray-500 before:rounded-full">
            {{ $item }}
        </li>
    @endforeach
</ul>

