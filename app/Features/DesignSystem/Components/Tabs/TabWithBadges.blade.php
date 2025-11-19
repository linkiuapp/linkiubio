{{--
Tab With Badges - Tabs con badges
Uso: Tabs con badges para mostrar contadores o notificaciones
Cuándo usar: Para organizar contenido con indicadores visuales de cantidad
Cuándo NO usar: Cuando no necesites badges o contadores
Ejemplo: <x-tab-with-badges :tabs="[['label' => 'Tab 1', 'content' => 'Contenido 1', 'badge' => '5'], ['label' => 'Tab 2', 'content' => 'Contenido 2', 'badge' => '12']]" />
--}}

@props([
    'tabs' => [], // Array de tabs: [['label' => '...', 'content' => '...', 'badge' => '...', 'icon' => '...', 'active' => false]]
    'tabId' => null, // ID único para el grupo de tabs (se genera automáticamente si no se proporciona)
])

@php
    $uniqueId = $tabId ?? 'tab-badges-' . uniqid();
    $defaultActive = 0;
    foreach($tabs as $index => $tab) {
        if ($tab['active'] ?? false) {
            $defaultActive = $index;
            break;
        }
    }
@endphp

<div x-data="{ activeTab: {{ $defaultActive }} }" {{ $attributes }}>
    <div class="border-b border-gray-200">
        <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
            @foreach($tabs as $index => $tab)
                @php
                    $label = $tab['label'] ?? '';
                    $tabButtonId = $uniqueId . '-item-' . ($index + 1);
                    $badge = $tab['badge'] ?? null;
                    $icon = $tab['icon'] ?? null;
                @endphp
                
                <button 
                    type="button" 
                    @click="activeTab = {{ $index }}"
                    :class="activeTab === {{ $index }} ? 'font-semibold border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-blue-600'"
                    class="py-4 px-1 inline-flex items-center gap-x-2 border-b-2 text-sm whitespace-nowrap focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none transition-colors" 
                    id="{{ $tabButtonId }}" 
                    :aria-selected="activeTab === {{ $index }} ? 'true' : 'false'"
                    role="tab"
                >
                    @if($icon)
                        <i data-lucide="{{ $icon }}" class="shrink-0 size-4"></i>
                    @endif
                    {{ $label }}
                    @if($badge)
                        <span :class="activeTab === {{ $index }} ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-800'" class="ms-1 py-0.5 px-1.5 rounded-full text-xs font-medium transition-colors">
                            {{ $badge }}
                        </span>
                    @endif
                </button>
            @endforeach
        </nav>
    </div>

    <div class="mt-3">
        @foreach($tabs as $index => $tab)
            @php
                $tabPanelId = $uniqueId . '-' . ($index + 1);
                $tabButtonId = $uniqueId . '-item-' . ($index + 1);
                $content = $tab['content'] ?? '';
            @endphp
            
            <div 
                id="{{ $tabPanelId }}" 
                role="tabpanel" 
                aria-labelledby="{{ $tabButtonId }}"
                x-show="activeTab === {{ $index }}"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                {!! $content !!}
            </div>
        @endforeach
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
