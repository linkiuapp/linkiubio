{{--
Timeline Collapsable - Timeline con sección colapsable
Uso: Ocultar/mostrar eventos antiguos en timeline
Cuándo usar: Cuando tienes muchos eventos y quieres mostrar solo los más recientes
Cuándo NO usar: Cuando todos los eventos deben estar visibles
Ejemplo: <x-timeline-collapsable collapseId="timeline-old" :items="[...]" />
--}}

@props([
    'collapseId' => null, // ID único para el collapse
    'items' => [], // Array de items del timeline
    'heading' => null, // Encabezado para la sección colapsable
    'showLabel' => 'Mostrar más antiguo',
    'hideLabel' => 'Ocultar',
])

@php
    $uniqueId = $collapseId ?? uniqid('timeline-collapse-');
@endphp

<div x-data="{ isOpen: false }" {{ $attributes }}>
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 max-h-0"
        x-transition:enter-end="opacity-100 max-h-screen"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 max-h-screen"
        x-transition:leave-end="opacity-0 max-h-0"
        class="w-full overflow-hidden"
        id="{{ $uniqueId }}"
    >
        @if($heading)
            <x-timeline-heading>{{ $heading }}</x-timeline-heading>
        @endif
        
        @foreach($items as $index => $item)
            <x-timeline-item 
                :time="$item['time'] ?? null"
                :title="$item['title'] ?? ''"
                :titleIcon="$item['titleIcon'] ?? null"
                :description="$item['description'] ?? null"
                :user="$item['user'] ?? null"
                :dotIcon="$item['dotIcon'] ?? null"
                :dotAvatar="$item['dotAvatar'] ?? null"
                :dotInitials="$item['dotInitials'] ?? null"
                :dotIconName="$item['dotIconName'] ?? null"
                :isLast="$loop->last"
            />
        @endforeach
    </div>

    <!-- Toggle Button -->
    <div class="ps-2 -ms-px flex gap-x-3">
        <button 
            type="button" 
            x-show="!isOpen"
            @click="isOpen = true"
            class="text-start inline-flex items-center gap-x-1 body-small text-blue-600 font-medium decoration-2 hover:underline focus:outline-hidden focus:underline"
            id="{{ $uniqueId }}-content"
        >
            <i data-lucide="chevron-down" class="shrink-0 size-3.5"></i>
            {{ $showLabel }}
        </button>
        <button 
            type="button" 
            x-show="isOpen"
            @click="isOpen = false"
            class="text-start inline-flex items-center gap-x-1 body-small text-blue-600 font-medium decoration-2 hover:underline focus:outline-hidden focus:underline"
            aria-expanded="true"
        >
            <i data-lucide="chevron-up" class="shrink-0 size-3.5"></i>
            {{ $hideLabel }}
        </button>
    </div>
</div>

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
