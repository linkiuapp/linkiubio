{{--
Pagination Bordered Group - Paginación con bordes agrupados
Uso: Paginación con estilo de bordes que se conectan entre botones
Cuándo usar: Para paginación con estilo clásico y bordes visibles
Cuándo NO usar: Cuando prefieras un estilo sin bordes o más moderno
Ejemplo: <x-pagination-bordered-group :current="1" :total="10" :url="route('products.index')" />
--}}

@props([
    'current' => 1, // Página actual
    'total' => 1, // Total de páginas
    'url' => '#', // URL base para las páginas (se agregará ?page=X)
    'showPrevNext' => true, // Mostrar botones Previous/Next
    'prevLabel' => 'Previous', // Texto del botón Previous
    'nextLabel' => 'Next', // Texto del botón Next
    'maxVisible' => 5, // Máximo de páginas visibles
])

@php
    $currentPage = max(1, min($total, $current));
    $startPage = max(1, $currentPage - floor($maxVisible / 2));
    $endPage = min($total, $startPage + $maxVisible - 1);
    
    if ($endPage - $startPage < $maxVisible - 1) {
        $startPage = max(1, $endPage - $maxVisible + 1);
    }
    
    $pages = range($startPage, $endPage);
    
    $prevUrl = $currentPage > 1 ? ($url . '?page=' . ($currentPage - 1)) : '#';
    $nextUrl = $currentPage < $total ? ($url . '?page=' . ($currentPage + 1)) : '#';
@endphp

<nav class="flex items-center -space-x-px" aria-label="Pagination" {{ $attributes }}>
    @if($showPrevNext)
        <button 
            type="button" 
            @if($currentPage > 1) onclick="window.location.href='{{ $prevUrl }}'" @endif
            @if($currentPage <= 1) disabled @endif
            class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
            aria-label="{{ $prevLabel }}"
        >
            <i data-lucide="chevron-left" class="shrink-0 size-3.5"></i>
            <span class="hidden sm:block">{{ $prevLabel }}</span>
        </button>
    @endif
    
    @foreach($pages as $page)
        <button 
            type="button" 
            @if($page != $currentPage) onclick="window.location.href='{{ $url }}?page={{ $page }}'" @endif
            class="min-h-9.5 min-w-9.5 flex justify-center items-center py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none {{ $page == $currentPage ? 'bg-gray-200 text-gray-800 focus:bg-gray-300' : 'text-gray-800 hover:bg-gray-100 focus:bg-gray-100' }}"
            @if($page == $currentPage) aria-current="page" @endif
        >
            {{ $page }}
        </button>
    @endforeach
    
    @if($showPrevNext)
        <button 
            type="button" 
            @if($currentPage < $total) onclick="window.location.href='{{ $nextUrl }}'" @endif
            @if($currentPage >= $total) disabled @endif
            class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
            aria-label="{{ $nextLabel }}"
        >
            <span class="hidden sm:block">{{ $nextLabel }}</span>
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

