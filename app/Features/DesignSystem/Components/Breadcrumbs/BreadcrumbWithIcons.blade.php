{{--
Breadcrumb With Icons - Breadcrumbs con iconos
Uso: Navegación jerárquica con iconos en cada item
Cuándo usar: Para mejorar la UX visual con iconos descriptivos
Cuándo NO usar: Cuando los breadcrumbs sean autoexplicativos sin necesidad de iconos
Ejemplo: <x-breadcrumb-with-icons :items="[['label' => 'Home', 'url' => '/', 'icon' => 'home'], ['label' => 'Productos', 'url' => '/productos', 'icon' => 'package'], ['label' => 'Detalle', 'active' => true]]" />
--}}

@props([
    'items' => [], // Array de items: [['label' => '...', 'url' => '...', 'icon' => '...', 'active' => false]]
])

<ol class="flex items-center whitespace-nowrap" {{ $attributes }}>
    @foreach($items as $index => $item)
        @php
            $label = $item['label'] ?? '';
            $url = $item['url'] ?? '#';
            $icon = $item['icon'] ?? null;
            $isActive = $item['active'] ?? ($loop->last);
            $isLast = $loop->last;
        @endphp
        
        <li class="inline-flex items-center">
            @if($isActive && $isLast)
                <span class="text-sm font-semibold text-gray-800 truncate flex items-center" aria-current="page">
                    @if($icon)
                        <i data-lucide="{{ $icon }}" class="shrink-0 me-3 size-4"></i>
                    @endif
                    {{ $label }}
                </span>
            @else
                <a 
                    class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600"
                    href="{{ $url }}"
                >
                    @if($icon)
                        <i data-lucide="{{ $icon }}" class="shrink-0 me-3 size-4"></i>
                    @endif
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















