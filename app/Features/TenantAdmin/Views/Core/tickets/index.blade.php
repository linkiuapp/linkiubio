<x-tenant-admin-layout :store="$store">
    @section('title', 'Soporte y Tickets')

    @section('content')
    <div class="max-w-7xl mx-auto space-y-6 mt-6" x-data="ticketsIndex()">
        <x-toast-notification />

        {{-- SECTION: Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Soporte y Tickets</h1>
                <p class="text-sm text-gray-600 mt-1">
                    Gestiona tus consultas y solicitudes de soporte
                </p>
            </div>
            <a href="{{ route('tenant.admin.tickets.create', ['store' => $store->slug]) }}">
                <x-button-icon 
                    type="solid" 
                    color="dark" 
                    icon="plus-circle"
                    size="md"
                    text="Crear Ticket"
                />
            </a>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Estadísticas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-card-base shadow="sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="ticket" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>
            </x-card-base>

            <x-card-base shadow="sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Abiertos</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['open'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>
            </x-card-base>

            <x-card-base shadow="sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">En Progreso</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['in_progress'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="settings" class="w-6 h-6 text-yellow-600"></i>
                    </div>
                </div>
            </x-card-base>

            <x-card-base shadow="sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Resueltos</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['resolved'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>
            </x-card-base>
        </div>
        {{-- End SECTION: Estadísticas --}}

        {{-- SECTION: Filtros --}}
        <x-card-base shadow="sm">
            <form method="GET" action="{{ route('tenant.admin.tickets.index', ['store' => $store->slug]) }}" 
                  class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <x-input-with-label 
                            name="search"
                            type="text"
                            :value="request('search')"
                            placeholder="Buscar por número, asunto o descripción..."
                        />
                    </div>

                    <div>
                        <x-select-basic 
                            name="status"
                            select-id="status"
                            :options="[
                                '' => 'Todos los estados',
                                'open' => 'Abierto',
                                'in_progress' => 'En Progreso',
                                'resolved' => 'Resuelto',
                                'closed' => 'Cerrado'
                            ]"
                            :selected="request('status', '')"
                        />
                    </div>

                    <div>
                        <x-select-basic 
                            name="priority"
                            select-id="priority"
                            :options="[
                                '' => 'Todas las prioridades',
                                'low' => 'Baja',
                                'medium' => 'Media',
                                'high' => 'Alta',
                                'urgent' => 'Urgente'
                            ]"
                            :selected="request('priority', '')"
                        />
                    </div>

                    <div>
                        <x-select-basic 
                            name="category"
                            select-id="category"
                            :options="array_merge(['' => 'Todas las categorías'], $categories)"
                            :selected="request('category', '')"
                        />
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors text-sm font-medium">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        Filtrar
                    </button>
                    <a href="{{ route('tenant.admin.tickets.index', ['store' => $store->slug]) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        Limpiar
                    </a>
                </div>
            </form>
        </x-card-base>
        {{-- End SECTION: Filtros --}}

        {{-- SECTION: Lista de Tickets --}}
        <x-card-base shadow="sm">
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h2 class="text-base font-semibold text-gray-900">
                    Mis Tickets ({{ $tickets->total() }})
                </h2>
            </div>

            <div class="space-y-4">
                @forelse($tickets as $ticket)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="font-mono text-sm font-semibold text-gray-700">
                                    #{{ $ticket->ticket_number }}
                                </span>
                                
                                @if($ticket->status_color == 'info')
                                    <x-badge-soft type="info" :text="$ticket->status_label" />
                                @elseif($ticket->status_color == 'warning')
                                    <x-badge-soft type="warning" :text="$ticket->status_label" />
                                @elseif($ticket->status_color == 'success')
                                    <x-badge-soft type="success" :text="$ticket->status_label" />
                                @else
                                    <x-badge-soft type="secondary" :text="$ticket->status_label" />
                                @endif

                                @if($ticket->priority_color == 'success')
                                    <x-badge-soft type="success" :text="$ticket->priority_label" />
                                @elseif($ticket->priority_color == 'info')
                                    <x-badge-soft type="info" :text="$ticket->priority_label" />
                                @elseif($ticket->priority_color == 'warning')
                                    <x-badge-soft type="warning" :text="$ticket->priority_label" />
                                @else
                                    <x-badge-soft type="error" :text="$ticket->priority_label" />
                                @endif

                                @if($ticket->has_new_support_responses)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700" 
                                          title="Respuestas nuevas del soporte">
                                        <i data-lucide="message-circle" class="w-3 h-3"></i>
                                        {{ $ticket->new_support_responses_count }} nueva{{ $ticket->new_support_responses_count > 1 ? 's' : '' }}
                                    </span>
                                @endif

                                <span class="text-xs text-gray-500">
                                    {{ $ticket->category_label }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <h3 class="font-semibold text-gray-900 mb-1">{{ $ticket->title }}</h3>
                            <p class="text-sm text-gray-600">{{ Str::limit($ticket->description, 150) }}</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                @if($ticket->responses->count() > 0)
                                    Última respuesta: {{ $ticket->responses->last()->created_at->diffForHumans() }}
                                @else
                                    Sin respuestas
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('tenant.admin.tickets.show', ['store' => $store->slug, 'ticket' => $ticket]) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i data-lucide="eye" class="w-3 h-3"></i>
                                    Ver Ticket
                                </a>
                                @if(in_array($ticket->status, ['open', 'in_progress']))
                                    <a href="{{ route('tenant.admin.tickets.show', ['store' => $store->slug, 'ticket' => $ticket]) }}#response" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-900 transition-colors">
                                        <i data-lucide="message-circle" class="w-3 h-3"></i>
                                        Responder
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <x-empty-state 
                        icon="ticket"
                        title="No tienes tickets de soporte"
                        description="Crea tu primer ticket para recibir ayuda de nuestro equipo"
                    >
                        <a href="{{ route('tenant.admin.tickets.create', ['store' => $store->slug]) }}">
                            <x-button-icon 
                                type="solid" 
                                color="dark" 
                                icon="plus-circle"
                                size="md"
                                text="Crear tu primer ticket"
                            />
                        </a>
                    </x-empty-state>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($tickets->hasPages())
                <div class="border-t border-gray-200 pt-4 mt-4">
                    {{ $tickets->links() }}
                </div>
            @endif
        </x-card-base>
        {{-- End SECTION: Lista de Tickets --}}
    </div>

    @push('scripts')
    <script>
    function ticketsIndex() {
        return {
            init() {
                // Mostrar toasts de sesión si existen
                @if(session('ticket_created'))
                    if (window.toast) {
                        window.toast.success(
                            'Ticket creado',
                            '{{ session('ticket_created') }}',
                            5000,
                            'bottom-center'
                        );
                    }
                @endif

                @if(session('ticket_updated'))
                    if (window.toast) {
                        window.toast.success(
                            'Ticket actualizado',
                            '{{ session('ticket_updated') }}',
                            5000,
                            'bottom-center'
                        );
                    }
                @endif

                @if(session('response_added'))
                    if (window.toast) {
                        window.toast.success(
                            'Respuesta enviada',
                            '{{ session('response_added') }}',
                            5000,
                            'bottom-center'
                        );
                    }
                @endif
            }
        }
    }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
