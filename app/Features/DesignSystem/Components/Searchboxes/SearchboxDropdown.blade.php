{{--
Searchbox Dropdown - Búsqueda con dropdown
Uso: Campo de búsqueda con dropdown de resultados
Cuándo usar: Cuando necesites búsqueda con autocompletado y resultados agrupados
Cuándo NO usar: Cuando un input simple sea suficiente
Ejemplo: <x-searchbox-dropdown name="search" :items="$items" />
--}}

@props([
    'name' => null,
    'searchboxId' => null,
    'placeholder' => 'Escribe un nombre',
    'items' => [], // Array de items: [['name' => '...', 'category' => '...', 'image' => '...']]
    'disabled' => false,
])

@php
    $uniqueId = $searchboxId ?? 'searchbox-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
    
    // Agrupar items por categoría si existe
    $groupedItems = [];
    foreach ($items as $item) {
        $category = $item['category'] ?? 'Otros';
        if (!isset($groupedItems[$category])) {
            $groupedItems[$category] = [];
        }
        $groupedItems[$category][] = $item;
    }
@endphp

<div class="max-w-sm relative" x-data="searchbox{{ $uniqueId }}()">
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
            <i data-lucide="search" class="shrink-0 size-4 text-gray-400"></i>
        </div>
        <input 
            type="text" 
            id="{{ $uniqueId }}"
            name="{{ $nameAttr }}"
            x-model="searchQuery"
            @input="filterItems()"
            @focus="isOpen = true"
            placeholder="{{ $placeholder }}"
            @if($disabled) disabled @endif
            role="combobox"
            :aria-expanded="isOpen"
            class="py-2.5 sm:py-3 ps-10 pe-4 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ $attributes->get('class') }}"
            {{ $attributes->except('class') }}
        >
    </div>

    <!-- SearchBox Dropdown -->
    <div 
        x-show="isOpen && filteredItems.length > 0"
        @click.away="isOpen = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl"
        style="display: none;"
    >
        <div class="max-h-72 rounded-b-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
            <template x-for="(group, category) in filteredGroups" :key="category">
                <div>
                    <div class="text-xs uppercase text-gray-500 m-3 mb-1" x-text="category"></div>
                    <template x-for="item in group" :key="item.name">
                        <div 
                            @click="selectItem(item)"
                            class="flex items-center cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100"
                            :class="{ 'bg-blue-50': selectedItem && selectedItem.name === item.name }"
                        >
                            <div class="flex items-center w-full">
                                <template x-if="item.image">
                                    <div class="flex items-center justify-center rounded-full bg-gray-200 size-6 overflow-hidden me-2.5">
                                        <img :src="item.image" :alt="item.name" class="shrink-0 size-6 object-cover" />
                                    </div>
                                </template>
                                <div x-text="item.name" class="flex-1"></div>
                            </div>
                            <span x-show="selectedItem && selectedItem.name === item.name" class="ms-2">
                                <i data-lucide="check" class="shrink-0 size-3.5 text-blue-600"></i>
                            </span>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
    <!-- End SearchBox Dropdown -->
</div>

@push('scripts')
<script>
    function searchbox{{ $uniqueId }}() {
        return {
            searchQuery: '',
            isOpen: false,
            selectedItem: null,
            items: @json($items),
            filteredItems: [],
            filteredGroups: {},
            
            init() {
                this.filteredItems = this.items;
                this.filterItems();
                
                // Inicializar iconos Lucide
                this.$nextTick(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            },
            
            filterItems() {
                const query = this.searchQuery.toLowerCase().trim();
                
                if (!query) {
                    this.filteredItems = this.items;
                } else {
                    this.filteredItems = this.items.filter(item => {
                        const name = (item.name || '').toLowerCase();
                        const category = (item.category || '').toLowerCase();
                        return name.includes(query) || category.includes(query);
                    });
                }
                
                // Agrupar por categoría
                this.groupByCategory();
            },
            
            groupByCategory() {
                const groups = {};
                this.filteredItems.forEach(item => {
                    const category = item.category || 'Otros';
                    if (!groups[category]) {
                        groups[category] = [];
                    }
                    groups[category].push(item);
                });
                this.filteredGroups = groups;
            },
            
            selectItem(item) {
                this.selectedItem = item;
                this.searchQuery = item.name;
                this.isOpen = false;
                
                // Disparar evento personalizado
                this.$dispatch('item-selected', item);
            }
        };
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

