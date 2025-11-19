{{--
Vista Show - Detalles de anuncio
Muestra información completa de un anuncio con diseño compacto de 2 columnas
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', $announcement->title)

    @section('content')
    @php
        $typeColors = [
            'critical' => ['bg' => 'bg-red-50', 'border' => 'border-red-500', 'text' => 'text-red-700', 'badge' => 'error', 'icon' => 'alert-triangle'],
            'important' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-500', 'text' => 'text-yellow-700', 'badge' => 'warning', 'icon' => 'star'],
            'info' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-500', 'text' => 'text-blue-700', 'badge' => 'info', 'icon' => 'info'],
        ];
        $colors = $typeColors[$announcement->type] ?? $typeColors['info'];
    @endphp

    {{-- SECTION: Main Container --}}
    <div class="max-w-7xl mx-auto space-y-4">
        {{-- SECTION: Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('tenant.admin.announcements.index', $store->slug) }}">
                {{-- COMPONENT: ButtonIcon | props:{type:outline, color:dark, icon:arrow-left, size:sm} --}}
                <x-button-icon 
                    type="outline" 
                    color="dark" 
                    icon="arrow-left"
                    size="sm"
                    text="Volver"
                />
                {{-- End COMPONENT: ButtonIcon --}}
            </a>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Main Card --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="p-4 space-y-4">
                {{-- SECTION: Card Header --}}
                <div class="flex items-center gap-3 pb-4 border-b border-gray-200">
                    <div class="shrink-0 w-10 h-10 {{ $colors['bg'] }} rounded-lg border {{ $colors['border'] }} flex items-center justify-center">
                        <i data-lucide="{{ $colors['icon'] }}" class="w-5 h-5 {{ $colors['text'] }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-base font-semibold text-gray-900">{{ $announcement->title }}</h1>
                        <div class="flex items-center gap-2 mt-1">
                            {{-- COMPONENT: BadgeSoft | props:{type:dynamic} --}}
                            <x-badge-soft 
                                :type="$colors['badge']" 
                                :text="$announcement->type_label" 
                            />
                            {{-- End COMPONENT: BadgeSoft --}}
                            <span class="text-xs text-gray-500">Anuncio de Linkiu</span>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Card Header --}}

                {{-- SECTION: Two Column Layout --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            {{-- SECTION: Main Content --}}
            <div class="lg:col-span-2 space-y-4">
                {{-- SECTION: Content Card --}}
                <div class="bg-white border-l-4 {{ $colors['border'] }} rounded-lg border border-gray-200 overflow-hidden">
                    <div class="p-4 space-y-3">
                        {{-- SECTION: Content Header --}}
                        <div class="flex items-center justify-between gap-3 pb-3 border-b border-gray-200">
                            <h2 class="text-sm font-semibold text-gray-900">Contenido del Anuncio</h2>
                            <div class="flex items-center gap-3 text-xs text-gray-600">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                    {{ $announcement->created_at->format('d/m/Y H:i') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="star" class="w-3 h-3"></i>
                                    Prioridad {{ $announcement->priority }}
                                </span>
                            </div>
                        </div>
                        {{-- End SECTION: Content Header --}}

                        {{-- SECTION: Content Text --}}
                        <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">
                            {{ $announcement->content }}
                        </div>
                        {{-- End SECTION: Content Text --}}
                    </div>
                </div>
                {{-- End SECTION: Content Card --}}

                {{-- SECTION: Banner Card --}}
                @if($announcement->banner_image)
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="p-4 space-y-3">
                            <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <i data-lucide="image" class="w-4 h-4"></i>
                                Banner Asociado
                            </h3>
                            <div class="flex items-start gap-4">
                                <img 
                                    src="{{ $announcement->banner_image_url }}" 
                                    alt="Banner" 
                                    class="border border-gray-200 rounded shadow-sm shrink-0"
                                    style="width: 200px; height: 60px; object-fit: cover;"
                                >
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-600 mb-2">
                                        Este banner se muestra en el carrusel del dashboard cuando está activo.
                                    </p>
                                    @if($announcement->banner_link)
                                        <a href="{{ $announcement->banner_link }}" target="_blank">
                                            {{-- COMPONENT: ButtonIcon | props:{type:solid, color:dark, icon:external-link, size:sm} --}}
                                            <x-button-icon 
                                                type="solid" 
                                                color="dark" 
                                                icon="external-link"
                                                size="sm"
                                                text="Ir al Enlace"
                                            />
                                            {{-- End COMPONENT: ButtonIcon --}}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- End SECTION: Banner Card --}}

                {{-- SECTION: Additional Info --}}
                @if($announcement->expires_at || $announcement->auto_mark_read_after)
                    {{-- COMPONENT: AlertSoft | props:{type:info} --}}
                    <x-alert-soft type="info">
                        <div class="space-y-1.5 text-xs">
                            @if($announcement->expires_at)
                                <div class="flex items-center gap-2">
                                    <i data-lucide="clock" class="w-3 h-3 shrink-0"></i>
                                    <span>Expira el {{ $announcement->expires_at->format('d/m/Y H:i') }} ({{ $announcement->expires_at->diffForHumans() }})</span>
                                </div>
                            @endif
                            @if($announcement->auto_mark_read_after)
                                <div class="flex items-center gap-2">
                                    <i data-lucide="check-circle-2" class="w-3 h-3 shrink-0"></i>
                                    <span>Se marcará como leído automáticamente después de {{ $announcement->auto_mark_read_after }} días</span>
                                </div>
                            @endif
                        </div>
                    </x-alert-soft>
                    {{-- End COMPONENT: AlertSoft --}}
                @endif
                {{-- End SECTION: Additional Info --}}
            </div>
            {{-- End SECTION: Main Content --}}

            {{-- SECTION: Sidebar --}}
            <div class="space-y-4">
                {{-- SECTION: Status Card --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Estado</h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="text-center pb-3 border-b border-gray-200">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                            </div>
                            <div class="text-xs font-medium text-green-600">Leído</div>
                            <p class="text-xs text-gray-500 mt-1">Marcado al abrir</p>
                        </div>

                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Tipo:</span>
                                {{-- COMPONENT: BadgeSoft | props:{type:dynamic} --}}
                                <x-badge-soft 
                                    :type="$colors['badge']" 
                                    :text="$announcement->type_label" 
                                />
                                {{-- End COMPONENT: BadgeSoft --}}
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Prioridad:</span>
                                <span class="font-medium text-gray-900">{{ $announcement->priority }}/10</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Publicado:</span>
                                <span class="text-gray-900">{{ $announcement->created_at->format('d/m/Y') }}</span>
                            </div>
                            @if($announcement->expires_at)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Expira:</span>
                                    <span class="text-gray-900">{{ $announcement->expires_at->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Status Card --}}

                {{-- SECTION: Features Card --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Características</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        @if($announcement->show_as_banner)
                            <div class="flex items-center gap-2 p-2 bg-blue-50 rounded border border-blue-100">
                                <i data-lucide="image" class="w-4 h-4 text-blue-600 shrink-0"></i>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium text-blue-700">Banner Activo</div>
                                    <div class="text-xs text-blue-600">En carrusel dashboard</div>
                                </div>
                            </div>
                        @endif

                        @if($announcement->show_popup)
                            <div class="flex items-center gap-2 p-2 bg-yellow-50 rounded border border-yellow-100">
                                <i data-lucide="layers" class="w-4 h-4 text-yellow-600 shrink-0"></i>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium text-yellow-700">Popup Automático</div>
                                    <div class="text-xs text-yellow-600">Se muestra al entrar</div>
                                </div>
                            </div>
                        @endif

                        @if($announcement->send_email)
                            <div class="flex items-center gap-2 p-2 bg-blue-50 rounded border border-blue-100">
                                <i data-lucide="mail" class="w-4 h-4 text-blue-600 shrink-0"></i>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium text-blue-700">Notificación Email</div>
                                    <div class="text-xs text-blue-600">Enviado por correo</div>
                                </div>
                            </div>
                        @endif

                        @if(!$announcement->show_as_banner && !$announcement->show_popup && !$announcement->send_email)
                            <div class="text-center py-3">
                                <i data-lucide="info" class="w-5 h-5 text-gray-400 mx-auto mb-1"></i>
                                <p class="text-xs text-gray-500">Sin características especiales</p>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- End SECTION: Features Card --}}

                {{-- SECTION: Actions Card --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Navegación</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        <a href="{{ route('tenant.admin.tickets.create', ['store' => $store->slug]) }}" 
                           class="inline-flex items-center gap-x-2 w-full justify-center py-2 px-3 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 focus:outline-none transition-colors">
                            <i data-lucide="message-circle" class="w-3 h-3"></i>
                            Crear Ticket de Soporte
                        </a>

                        @if($announcement->banner_link)
                            <a href="{{ $announcement->banner_link }}" 
                               target="_blank"
                               class="inline-flex items-center gap-x-2 w-full justify-center py-2 px-3 text-sm font-medium rounded-lg border-2 border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:outline-none transition-colors">
                                <i data-lucide="external-link" class="w-3 h-3"></i>
                                Ver Enlace Relacionado
                            </a>
                        @endif

                        <a href="{{ route('tenant.admin.dashboard', $store->slug) }}" 
                           class="inline-flex items-center gap-x-2 w-full justify-center py-2 px-3 text-sm font-medium rounded-lg border-2 border-gray-500 text-gray-500 hover:border-gray-800 hover:text-gray-800 focus:outline-none transition-colors">
                            <i data-lucide="home" class="w-3 h-3"></i>
                            Ir al Dashboard
                        </a>
                    </div>
                </div>
                {{-- End SECTION: Actions Card --}}
                </div>
                {{-- End SECTION: Sidebar --}}
                </div>
                {{-- End SECTION: Two Column Layout --}}
            </div>
        </div>
        {{-- End SECTION: Main Card --}}
    </div>
    {{-- End SECTION: Main Container --}}

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar iconos Lucide
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
