{{--
Breadcrumb Chevrons - Breadcrumbs con chevrons (flechas)
Uso: Navegación jerárquica con separadores de chevrons
Cuándo usar: Para mostrar la ruta de navegación en páginas
Cuándo NO usar: Cuando no necesites mostrar la jerarquía de navegación
Ejemplo: <x-breadcrumb-chevrons :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Productos', 'url' => '/productos'], ['label' => 'Detalle', 'active' => true]]" />
--}}

@props([
    'items' => [], // Array de items: [['label' => '...', 'url' => '...', 'active' => false]]
])

<ol class="flex items-center whitespace-nowrap" {{ $attributes }}>
    @foreach($items as $index => $item)
        @php
            $label = $item['label'] ?? '';
            $url = $item['url'] ?? '#';
            $isActive = $item['active'] ?? ($loop->last);
            $isLast = $loop->last;
        @endphp
        
        <li class="inline-flex items-center">
            @if($isActive && $isLast)
                <span class="text-sm font-semibold text-gray-800 truncate" aria-current="page">
                    {{ $label }}
                </span>
            @else
                <a 
                    class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600"
                    href="{{ $url }}"
                >
                    {{ $label }}
                </a>
                @if(!$isLast)
                    <i data-lucide="chevron-right" class="shrink-0 mx-2 size-4 text-gray-400"></i>
                @endif
            @endif
        </li>
    @endforeach
</ol>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof createIcons !== 'undefined') {
        createIcons();
    }
});
</script>
@endpush















