{{--
Pagination With Of - Paginación con texto "of" (X of Y)
Uso: Paginación que muestra "1 of 3" en lugar de botones de páginas
Cuándo usar: Para mostrar información de página actual vs total de forma compacta
Cuándo NO usar: Cuando necesites navegación directa a páginas específicas
Ejemplo: <x-pagination-with-of :current="1" :total="10" :url="route('products.index')" />
--}}

@props([
    'current' => 1, // Página actual
    'total' => 1, // Total de páginas
    'url' => '#', // URL base para las páginas
    'showPrevNext' => true, // Mostrar botones Previous/Next
    'prevLabel' => 'Previous', // Texto del botón Previous
    'nextLabel' => 'Next', // Texto del botón Next
    'ofText' => 'of', // Texto entre página actual y total
    'alignment' => 'center', // center, start, end
])

@php
    $currentPage = max(1, min($total, $current));
    $prevUrl = $currentPage > 1 ? ($url . '?page=' . ($currentPage - 1)) : '#';
    $nextUrl = $currentPage < $total ? ($url . '?page=' . ($currentPage + 1)) : '#';
    $alignmentClass = match($alignment) {
        'start' => 'justify-start',
        'end' => 'justify-end',
        default => 'justify-center',
    };
@endphp

<nav class="flex {{ $alignmentClass }} items-center gap-x-1" aria-label="Pagination" {{ $attributes }}>
    @if($showPrevNext)
        <button 
            type="button" 
            @if($currentPage > 1) onclick="window.location.href='{{ $prevUrl }}'" @endif
            @if($currentPage <= 1) disabled @endif
            class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
            aria-label="{{ $prevLabel }}"
        >
            <i data-lucide="chevron-left" class="shrink-0 size-3.5"></i>
            <span class="sr-only">{{ $prevLabel }}</span>
        </button>
    @endif
    
    <div class="flex items-center gap-x-1">
        <span class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-50">
            {{ $currentPage }}
        </span>
        <span class="min-h-9.5 flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm">
            {{ $ofText }}
        </span>
        <span class="min-h-9.5 flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm">
            {{ $total }}
        </span>
    </div>
    
    @if($showPrevNext)
        <button 
            type="button" 
            @if($currentPage < $total) onclick="window.location.href='{{ $nextUrl }}'" @endif
            @if($currentPage >= $total) disabled @endif
            class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
            aria-label="{{ $nextLabel }}"
        >
            <span class="sr-only">{{ $nextLabel }}</span>
            <i data-lucide="chevron-right" class="shrink-0 size-3.5"></i>
        </button>
    @endif
</nav>

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

