{{--
List Group With Badges - Grupo de lista con badges (notificaciones, contadores)
Uso: Listas con indicadores de notificaciones, contadores, estados
Cuándo usar: Cuando necesites mostrar información adicional como contadores o badges
Cuándo NO usar: Cuando necesites listas simples sin información adicional
Ejemplo: <x-list-group-with-badges :items="[['label' => 'Profile', 'badge' => 'New', 'badgeColor' => 'blue']]" />
--}}

@props([
    'items' => [], // Array de objetos: ['label', 'badge'?, 'badgeColor'?, 'icon'?]
    'width' => 'max-w-xs',
    'textSize' => 'body-small',
])

@php
    $containerClasses = "{$width} flex flex-col";
    
    $badgeColorClasses = [
        'blue' => 'bg-blue-500 text-white',
        'red' => 'bg-red-500 text-white',
        'green' => 'bg-green-500 text-white',
        'yellow' => 'bg-yellow-500 text-white',
        'gray' => 'bg-gray-500 text-white',
    ];
@endphp

<ul class="{{ $containerClasses }}" {{ $attributes }}>
    @foreach($items as $item)
        @php
            $label = $item['label'] ?? '';
            $badge = $item['badge'] ?? null;
            $badgeColor = $badgeColorClasses[$item['badgeColor'] ?? 'blue'] ?? $badgeColorClasses['blue'];
            $icon = $item['icon'] ?? null;
        @endphp
        <li class="inline-flex items-center gap-x-2 py-3 px-4 {{ $textSize }} font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg">
            <div class="flex justify-between w-full">
                <div class="flex items-center gap-x-2">
                    @if($icon)
                        <i data-lucide="{{ $icon }}" class="shrink-0 size-4"></i>
                    @endif
                    {{ $label }}
                </div>
                @if($badge)
                    <span class="inline-flex items-center py-1 px-2 rounded-full text-xs font-medium {{ $badgeColor }}">
                        {{ $badge }}
                    </span>
                @endif
            </div>
        </li>
    @endforeach
</ul>















