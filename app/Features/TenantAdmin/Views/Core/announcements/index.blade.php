{{--
Vista Index - Listado de Anuncios
Muestra todos los anuncios con filtros, estadísticas y acciones
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Anuncios de Linkiu')

    @section('content')
    {{-- SECTION: Empty State Configuration --}}
    @php
        $emptyStateSvg = 'base_ui_empty_anuncios.svg';
        $emptyStateTitle = 'No hay anuncios';
        $emptyStateMessage = request()->hasAny(['type', 'status', 'search']) 
            ? 'No se encontraron anuncios con los filtros aplicados.'
            : 'Aún no hay anuncios disponibles para tu tienda.';
    @endphp
    {{-- End SECTION: Empty State Configuration --}}

    {{-- SECTION: Main Container --}}
    <div 
        x-data="announcementsBoard()" 
        class="space-y-6"
        x-init="init()"
    >
        {{-- SECTION: Success Alert - Mark as Read --}}
        <div 
            x-show="showSuccessAlert" 
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            style="display: none;"
        >
            <x-alert-bordered type="success">
                <h3 class="text-gray-800 font-semibold" x-text="successMessage"></h3>
            </x-alert-bordered>
        </div>
        {{-- End SECTION: Success Alert --}}

        {{-- SECTION: Main Card --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="p-6 space-y-6">
                {{-- SECTION: Header --}}
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-lg font-semibold text-gray-800">Anuncios de Linkiu</h1>
                        <p class="text-sm text-gray-600 mt-1">Mantente informado sobre actualizaciones y novedades de la plataforma</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($stats['unread'] > 0)
                            {{-- COMPONENT: ButtonIcon | props:{type:solid, color:info, icon:check-circle-2, text:Marcar Todos como Leídos} --}}
                            <x-button-icon 
                                type="solid" 
                                color="info" 
                                icon="check-circle-2"
                                size="md"
                                text="Marcar Todos como Leídos"
                                html-type="button"
                                @click="markAllAsRead()"
                            />
                            {{-- End COMPONENT: ButtonIcon --}}
                        @endif
                    </div>
                </div>
                {{-- End SECTION: Header --}}

                {{-- SECTION: Statistics Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- ITEM: Total --}}
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                            </div>
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="message-square" class="w-5 h-5 text-blue-600"></i>
                            </div>
                        </div>
                    </div>
                    {{-- End ITEM: Total --}}

                    {{-- ITEM: Sin Leer --}}
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Sin Leer</p>
                                <p class="text-2xl font-bold text-yellow-600">{{ $stats['unread'] }}</p>
                            </div>
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="bell" class="w-5 h-5 text-yellow-600"></i>
                            </div>
                        </div>
                    </div>
                    {{-- End ITEM: Sin Leer --}}

                    {{-- ITEM: Banners --}}
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Banners</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $stats['banners'] }}</p>
                            </div>
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="image" class="w-5 h-5 text-blue-600"></i>
                            </div>
                        </div>
                    </div>
                    {{-- End ITEM: Banners --}}

                    {{-- ITEM: Críticos --}}
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Críticos</p>
                                <p class="text-2xl font-bold text-red-600">{{ $stats['critical'] }}</p>
                            </div>
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="alert-triangle" class="w-5 h-5 text-red-600"></i>
                            </div>
                        </div>
                    </div>
                    {{-- End ITEM: Críticos --}}
                </div>
                {{-- End SECTION: Statistics Cards --}}

                {{-- SECTION: Filters --}}
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        {{-- ITEM: Type Filter --}}
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-800 mb-2">Tipo</label>
                            {{-- COMPONENT: SelectBasic | props:{name:type, select-id:type} --}}
                            <x-select-basic 
                                name="type"
                                select-id="type"
                                :options="[
                                    '' => 'Todos los tipos',
                                    'critical' => 'Crítico',
                                    'important' => 'Importante',
                                    'info' => 'Información'
                                ]"
                                :selected="request('type', '')"
                                placeholder=""
                            />
                            {{-- End COMPONENT: SelectBasic --}}
                        </div>
                        {{-- End ITEM: Type Filter --}}

                        {{-- ITEM: Status Filter --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-800 mb-2">Estado de Lectura</label>
                            {{-- COMPONENT: SelectBasic | props:{name:status, select-id:status} --}}
                            <x-select-basic 
                                name="status"
                                select-id="status"
                                :options="[
                                    '' => 'Todos',
                                    'unread' => 'Sin leer',
                                    'read' => 'Leídos'
                                ]"
                                :selected="request('status', '')"
                                placeholder=""
                            />
                            {{-- End COMPONENT: SelectBasic --}}
                        </div>
                        {{-- End ITEM: Status Filter --}}

                        {{-- ITEM: Search Input --}}
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-800 mb-2">Buscar</label>
                            {{-- COMPONENT: InputWithIcon | props:{icon:search, iconPosition:left, placeholder:Título o contenido...} --}}
                            <x-input-with-icon 
                                type="text"
                                icon="search"
                                icon-position="left"
                                placeholder="Título o contenido..."
                                name="search"
                                id="search"
                                :value="request('search', '')"
                            />
                            {{-- End COMPONENT: InputWithIcon --}}
                        </div>
                        {{-- End ITEM: Search Input --}}

                        {{-- ITEM: Filter Actions --}}
                        <div class="flex items-end gap-2">
                            {{-- COMPONENT: ButtonIcon | props:{type:solid, color:dark, icon:search, text:Filtrar} --}}
                            <x-button-icon 
                                type="solid" 
                                color="dark" 
                                icon="search"
                                size="sm"
                                text="Filtrar"
                                html-type="submit"
                                class="flex-1"
                            />
                            {{-- End COMPONENT: ButtonIcon --}}
                            <a href="{{ route('tenant.admin.announcements.index', $store->slug) }}" 
                               class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                                <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                            </a>
                        </div>
                        {{-- End ITEM: Filter Actions --}}
                    </form>
                </div>
                {{-- End SECTION: Filters --}}

                {{-- SECTION: Announcements List --}}
                <div class="space-y-4">
                    @forelse($announcements as $announcement)
                        @php
                            $isRead = $announcement->isReadBy($store->id);
                            $typeColors = [
                                'critical' => ['bg' => 'bg-red-50', 'border' => 'border-red-500', 'text' => 'text-red-700', 'badge' => 'error'],
                                'important' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-500', 'text' => 'text-yellow-700', 'badge' => 'warning'],
                                'info' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-500', 'text' => 'text-blue-700', 'badge' => 'info'],
                            ];
                            $colors = $typeColors[$announcement->type] ?? $typeColors['info'];
                        @endphp
                        
                        {{-- ITEM: Announcement Card --}}
                        @php
                            $ringClass = !$isRead ? 'ring-2 ' . str_replace('border-', 'ring-', str_replace('-500', '-100', $colors['border'])) : '';
                        @endphp
                        <div class="bg-white rounded-lg border-l-4 {{ $colors['border'] }} p-0 overflow-hidden {{ $ringClass }}">
                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        {{-- SECTION: Announcement Header --}}
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="w-10 h-10 {{ $colors['bg'] }} rounded-full flex items-center justify-center flex-shrink-0">
                                                @if($announcement->type === 'critical')
                                                    <i data-lucide="alert-triangle" class="w-5 h-5 {{ $colors['text'] }}"></i>
                                                @elseif($announcement->type === 'important')
                                                    <i data-lucide="star" class="w-5 h-5 {{ $colors['text'] }}"></i>
                                                @else
                                                    <i data-lucide="info" class="w-5 h-5 {{ $colors['text'] }}"></i>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                    <h3 class="text-lg font-semibold text-gray-800">{{ $announcement->title }}</h3>
                                                    @if(!$isRead)
                                                        {{-- COMPONENT: BadgeSoft | props:{type:warning, text:Nuevo} --}}
                                                        <x-badge-soft type="warning" text="Nuevo" />
                                                        {{-- End COMPONENT: BadgeSoft --}}
                                                    @endif
                                                    @if($announcement->show_as_banner)
                                                        {{-- COMPONENT: BadgeSoft | props:{type:info, text:Banner} --}}
                                                        <x-badge-soft type="info" text="Banner" />
                                                        {{-- End COMPONENT: BadgeSoft --}}
                                                    @endif
                                                </div>
                                                
                                                <div class="flex items-center gap-4 text-sm text-gray-600 flex-wrap">
                                                    {{-- COMPONENT: BadgeSoft | props:{type:dynamic, text:type_label} --}}
                                                    <x-badge-soft 
                                                        :type="$colors['badge']" 
                                                        :text="$announcement->type_label" 
                                                    />
                                                    {{-- End COMPONENT: BadgeSoft --}}
                                                    <span class="flex items-center gap-1">
                                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                                        {{ $announcement->created_at->format('d/m/Y') }}
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <i data-lucide="star" class="w-4 h-4"></i>
                                                        Prioridad {{ $announcement->priority }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End SECTION: Announcement Header --}}

                                        {{-- SECTION: Announcement Content --}}
                                        <div class="ml-13">
                                            <p class="text-gray-700 leading-relaxed mb-4">
                                                {{ Str::limit($announcement->content, 200) }}
                                            </p>

                                            {{-- ITEM: Banner Preview --}}
                                            @if($announcement->banner_image)
                                                <div class="mb-4">
                                                    <img src="{{ $announcement->banner_image_url }}" 
                                                         alt="Banner" 
                                                         class="border border-gray-200 rounded"
                                                         style="width: 160px; height: 50px; object-fit: cover;">
                                                </div>
                                            @endif
                                            {{-- End ITEM: Banner Preview --}}

                                            {{-- SECTION: Actions --}}
                                            <div class="flex items-center gap-3 flex-wrap">
                                                <a href="{{ route('tenant.admin.announcements.show', ['store' => $store->slug, 'announcement' => $announcement]) }}">
                                                    {{-- COMPONENT: ButtonIcon | props:{type:solid, color:dark, icon:eye, text:Leer Completo} --}}
                                                    <x-button-icon 
                                                        type="solid" 
                                                        color="dark" 
                                                        icon="eye"
                                                        size="sm"
                                                        text="Leer Completo"
                                                    />
                                                    {{-- End COMPONENT: ButtonIcon --}}
                                                </a>

                                                @if(!$isRead)
                                                    <x-button-icon 
                                                        type="outline" 
                                                        color="success" 
                                                        icon="check-circle"
                                                        size="md"
                                                        text="Marcar como Leído"
                                                        html-type="button"
                                                        @click="markAsRead({{ $announcement->id }})"
                                                    />
                                                @else
                                                    {{-- COMPONENT: BadgeSoft | props:{type:success, text:Leído ✓} --}}
                                                    <x-badge-soft type="success" text="Leído" />
                                                    {{-- End COMPONENT: BadgeSoft --}}
                                                @endif

                                                @if($announcement->banner_link)
                                                    <a href="{{ $announcement->banner_link }}" target="_blank">
                                                        {{-- COMPONENT: ButtonIcon | props:{type:outline, color:info, icon:external-link, text:Ver Enlace} --}}
                                                        <x-button-icon 
                                                            type="outline" 
                                                            color="info" 
                                                            icon="external-link"
                                                            size="md"
                                                            text="Ver Enlace"
                                                        />
                                                        {{-- End COMPONENT: ButtonIcon --}}
                                                    </a>
                                                @endif
                                            </div>
                                            {{-- End SECTION: Actions --}}
                                        </div>
                                        {{-- End SECTION: Announcement Content --}}
                                    </div>

                                    {{-- ITEM: Relative Date --}}
                                    <div class="text-right text-sm text-gray-600">
                                        {{ $announcement->created_at->diffForHumans() }}
                                    </div>
                                    {{-- End ITEM: Relative Date --}}
                                </div>
                            </div>
                        </div>
                        {{-- End ITEM: Announcement Card --}}
                    @empty
                {{-- COMPONENT: EmptyState | props:{svg, title, message} --}}
                <x-empty-state 
                    :svg="$emptyStateSvg"
                    :title="$emptyStateTitle"
                    :message="$emptyStateMessage"
                >
                    @if(request()->hasAny(['type', 'status', 'search']))
                        <a href="{{ route('tenant.admin.announcements.index', $store->slug) }}">
                            <x-button-base 
                                type="outline" 
                                color="primary" 
                                size="md"
                                text="Limpiar Filtros"
                            />
                        </a>
                    @endif
                </x-empty-state>
                {{-- End COMPONENT: EmptyState --}}
            @endforelse
                </div>
                {{-- End SECTION: Announcements List --}}

                {{-- SECTION: Pagination --}}
                @if($announcements->hasPages())
                    <div class="mt-6">
                        {{ $announcements->links() }}
                    </div>
                @endif
                {{-- End SECTION: Pagination --}}
            </div>
        </div>
        {{-- End SECTION: Main Card --}}
    </div>
    {{-- End SECTION: Main Container --}}

    @push('scripts')
    <script>
        function announcementsBoard() {
            return {
                showSuccessAlert: false,
                successMessage: '',
                
                init() {
                    // Inicializar iconos Lucide
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                },
                
                markAsRead(announcementId) {
                    fetch(`{{ route('tenant.admin.announcements.mark-as-read', ['store' => $store->slug, 'announcement' => ':id']) }}`.replace(':id', announcementId), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.showSuccessMessage(data.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                },
                
                markAllAsRead() {
                    if (confirm('¿Marcar todos los anuncios como leídos?')) {
                        fetch(`{{ route('tenant.admin.announcements.mark-all-as-read', $store->slug) }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.showSuccessMessage(data.message);
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                },
                
                showSuccessMessage(message) {
                    this.successMessage = message;
                    this.showSuccessAlert = true;
                    setTimeout(() => {
                        this.showSuccessAlert = false;
                    }, 5000);
                }
            }
        }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
