{{--
Breadcrumb Slashes - Breadcrumbs con barras diagonales
Uso: Navegación jerárquica con separadores de barras diagonales
Cuándo usar: Para mostrar la ruta de navegación con estilo de barras
Cuándo NO usar: Cuando prefieras otro estilo de separador
Ejemplo: <x-breadcrumb-slashes :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Productos', 'url' => '/productos'], ['label' => 'Detalle', 'active' => true]]" />
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
                    <svg class="shrink-0 size-5 text-gray-400 mx-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M6 13L10 3" stroke="currentColor" stroke-linecap="round"></path>
                    </svg>
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















