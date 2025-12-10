<x-tenant-admin-layout :store="$store">
    @section('title', 'Ticket #' . $ticket->ticket_number)

    @section('content')
    <div class="max-w-5xl mx-auto space-y-6 mt-6" x-data="ticketDetail()">
        <x-toast-notification />

        {{-- SECTION: Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Ticket #{{ $ticket->ticket_number }}</h1>
                <p class="text-sm text-gray-600 mt-1">{{ $ticket->title }}</p>
            </div>
            <div class="flex items-center gap-3">
                @if(in_array($ticket->status, ['open', 'in_progress']))
                    <button x-on:click="showStatusModal = true" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition-colors text-sm font-medium">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                        Cambiar Estado
                    </button>
                @endif
                <a href="{{ route('tenant.admin.tickets.index', ['store' => $store->slug]) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Volver
                </a>
            </div>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Información del Ticket --}}
        <x-card-base shadow="sm">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-base font-semibold text-gray-900">Información del Ticket</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-2">Estado</label>
                    @if($ticket->status_color == 'info')
                        <x-badge-soft type="info" :text="$ticket->status_label" />
                    @elseif($ticket->status_color == 'warning')
                        <x-badge-soft type="warning" :text="$ticket->status_label" />
                    @elseif($ticket->status_color == 'success')
                        <x-badge-soft type="success" :text="$ticket->status_label" />
                    @else
                        <x-badge-soft type="secondary" :text="$ticket->status_label" />
                    @endif
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-2">Prioridad</label>
                    @if($ticket->priority_color == 'success')
                        <x-badge-soft type="success" :text="$ticket->priority_label" />
                    @elseif($ticket->priority_color == 'info')
                        <x-badge-soft type="info" :text="$ticket->priority_label" />
                    @elseif($ticket->priority_color == 'warning')
                        <x-badge-soft type="warning" :text="$ticket->priority_label" />
                    @else
                        <x-badge-soft type="error" :text="$ticket->priority_label" />
                    @endif
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-2">Categoría</label>
                    <span class="text-sm text-gray-900">{{ $ticket->category_label }}</span>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción Original</label>
                <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $ticket->description }}</p>
                
                {{-- Archivos adjuntos del ticket original --}}
                @if($ticket->attachments && count($ticket->attachments) > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Archivos adjuntos</label>
                        <div class="space-y-2">
                            @foreach($ticket->attachments as $attachment)
                                <div class="flex items-center gap-2 text-sm">
                                    @if(in_array($attachment['mime_type'], ['image/jpeg', 'image/jpg', 'image/png']))
                                        <i data-lucide="image" class="w-4 h-4 text-blue-600"></i>
                                    @else
                                        <i data-lucide="file" class="w-4 h-4 text-gray-400"></i>
                                    @endif
                                    <a href="{{ $ticket->getAttachmentUrl($attachment) }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-700 truncate">
                                        {{ $attachment['original_name'] }}
                                    </a>
                                    <span class="text-xs text-gray-500">
                                        ({{ number_format($attachment['size'] / 1024, 1) }} KB)
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            @if($ticket->metadata)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Información Técnica</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        @if(isset($ticket->metadata['browser']))
                            <div>
                                <span class="text-gray-600">Navegador:</span>
                                <span class="text-gray-900 font-medium ml-1">{{ $ticket->metadata['browser'] }}</span>
                            </div>
                        @endif
                        @if(isset($ticket->metadata['plan']))
                            <div>
                                <span class="text-gray-600">Plan:</span>
                                <span class="text-gray-900 font-medium ml-1">{{ $ticket->metadata['plan'] }}</span>
                            </div>
                        @endif
                        @if(isset($ticket->metadata['created_by']))
                            <div>
                                <span class="text-gray-600">Creado por:</span>
                                <span class="text-gray-900 font-medium ml-1">{{ $ticket->metadata['created_by'] }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="text-gray-600">Fecha:</span>
                            <span class="text-gray-900 font-medium ml-1">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </x-card-base>
        {{-- End SECTION: Información del Ticket --}}

        {{-- SECTION: Conversación --}}
        <x-card-base shadow="sm" x-data="{ showAllMessages: {{ $ticket->responses->count() <= 3 ? 'true' : 'false' }} }">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-gray-900">Conversación ({{ $ticket->responses->count() }} respuestas)</h2>
                    @if($ticket->responses->count() > 3)
                        <button x-on:click="showAllMessages = !showAllMessages" 
                                class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <i data-lucide="eye" class="w-4 h-4" x-show="!showAllMessages"></i>
                            <i data-lucide="eye-off" class="w-4 h-4" x-show="showAllMessages"></i>
                            <span x-text="showAllMessages ? 'Mostrar solo recientes' : 'Mostrar todo el historial'"></span>
                        </button>
                    @endif
                </div>
            </div>
            
            <div class="space-y-6">
                {{-- Indicador de mensajes ocultos --}}
                @if($ticket->responses->count() > 3)
                    <div x-show="!showAllMessages" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="text-center py-4 border border-gray-200 rounded-lg bg-gray-50">
                        <div class="flex items-center justify-center gap-2 text-gray-600 mb-2">
                            <i data-lucide="history" class="w-5 h-5"></i>
                            <span class="font-medium">{{ $ticket->responses->count() - 3 }} mensajes anteriores ocultos</span>
                        </div>
                        <button x-on:click="showAllMessages = true" 
                                class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Mostrar todo el historial →
                        </button>
                    </div>
                @endif

                @forelse($ticket->responses as $index => $response)
                    <div x-show="showAllMessages || {{ $index >= $ticket->responses->count() - 3 ? 'true' : 'false' }}" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="flex gap-4 {{ $response->is_support_team ? 'justify-end' : 'justify-start' }}">
                        
                        <div class="w-full max-w-2xl {{ $response->is_support_team ? 'order-2' : 'order-1' }}">
                            <div class="rounded-lg p-4 border {{ $response->is_support_team ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 {{ $response->is_support_team ? 'bg-blue-600' : 'bg-gray-600' }} rounded-full flex items-center justify-center">
                                            <span class="text-xs font-semibold text-white">{{ substr($response->user->name ?? 'U', 0, 1) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">
                                            @if($response->is_support_team)
                                                🛠️ {{ $response->user->name ?? 'Soporte Linkiu' }}
                                            @else
                                                👤 {{ $response->user->name ?? 'Usuario de la tienda' }}
                                            @endif
                                        </span>
                                        @if($response->response_type === 'status_change')
                                            <x-badge-soft type="warning" text="Cambio de Estado" />
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $response->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                
                                <div class="text-sm text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $response->message }}</div>

                                {{-- Archivos adjuntos --}}
                                @if($response->attachments && count($response->attachments) > 0)
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <label class="block text-xs font-medium text-gray-700 mb-2">Archivos adjuntos</label>
                                        <div class="space-y-1">
                                            @foreach($response->attachments as $attachment)
                                                <div class="flex items-center gap-2 text-sm">
                                                    <i data-lucide="file" class="w-4 h-4 text-gray-400"></i>
                                                    <a href="{{ $response->getAttachmentUrl($attachment) }}" 
                                                       target="_blank"
                                                       class="text-blue-600 hover:text-blue-700 truncate">
                                                        {{ $attachment['original_name'] }}
                                                    </a>
                                                    <span class="text-xs text-gray-500">
                                                        ({{ number_format($attachment['size'] / 1024, 1) }} KB)
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="flex flex-col items-center gap-2">
                            <i data-lucide="message-circle" class="w-12 h-12 text-gray-400"></i>
                            <p class="text-gray-600">Aún no hay respuestas en este ticket</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </x-card-base>
        {{-- End SECTION: Conversación --}}

        {{-- SECTION: Formulario de Respuesta --}}
        @if(in_array($ticket->status, ['open', 'in_progress']))
            <x-card-base shadow="sm" id="response">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-base font-semibold text-gray-900">Agregar Respuesta</h2>
                </div>
                
                <form action="{{ route('tenant.admin.tickets.add-response', ['store' => $store->slug, 'ticket' => $ticket]) }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <x-textarea-with-label 
                                label="Tu respuesta"
                                name="message"
                                rows="4"
                                placeholder="Escribe tu respuesta..."
                                required
                                maxlength="2000"
                            >{{ old('message') }}</x-textarea-with-label>
                            @error('message')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Máximo 2000 caracteres</p>
                        </div>

                        {{-- Archivos adjuntos --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Archivos adjuntos (opcional)</label>
                            <input type="file" 
                                   name="attachments[]" 
                                   multiple
                                   accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Máximo 3 archivos, 5MB cada uno</p>
                            @error('attachments.*')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors text-sm font-medium">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                Enviar Respuesta
                            </button>
                        </div>
                    </div>
                </form>
            </x-card-base>
        @else
            <x-card-base shadow="sm">
                <div class="text-center py-8">
                    <div class="flex flex-col items-center gap-4">
                        <i data-lucide="lock" class="w-12 h-12 text-gray-400"></i>
                        <p class="text-gray-600">Este ticket está {{ $ticket->status_label }}</p>
                        
                        @if(in_array($ticket->status, ['resolved', 'closed']))
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 mb-3">¿El problema persiste o tienes más preguntas?</p>
                                <button x-on:click="showReopenModal = true" 
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition-colors text-sm font-medium">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                    Reabrir Ticket
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </x-card-base>
        @endif
        {{-- End SECTION: Formulario de Respuesta --}}
    </div>

    {{-- Modal para reabrir ticket --}}
    <div x-show="showReopenModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         x-on:click.away="showReopenModal = false">
        
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">¿Reabrir este ticket?</h3>
            
            <p class="text-sm text-gray-600 mb-4">
                El ticket volverá al estado "Abierto" y nuestro equipo de soporte será notificado.
                Podrás continuar la conversación agregando nuevas respuestas.
            </p>
            
            <form id="reopenForm" method="POST" action="{{ route('tenant.admin.tickets.reopen', ['store' => $store->slug, 'ticket' => $ticket]) }}">
                @csrf
                
                <div class="mb-4">
                    <x-textarea-with-label 
                        label="Razón de reapertura (opcional)"
                        name="reason"
                        rows="3"
                        placeholder="Ej: El problema volvió a ocurrir..."
                        maxlength="500"
                    ></x-textarea-with-label>
                    <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres</p>
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" 
                            x-on:click="showReopenModal = false"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition-colors text-sm font-medium">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        Reabrir Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal para cambiar estado --}}
    <div x-show="showStatusModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         x-on:click.away="showStatusModal = false">
        
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">¿Tu problema fue resuelto?</h3>
            
            <p class="text-sm text-gray-600 mb-4">
                Si tu problema fue solucionado, puedes cerrar este ticket. 
                Si el problema persiste, siempre puedes reabrirlo desde tu panel.
            </p>
            
            <div class="space-y-3">
                <button x-on:click="updateStatus('closed')" 
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg hover:bg-green-100 transition-colors text-sm font-medium">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    Sí, mi problema está resuelto
                </button>
            </div>
            
            <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-gray-200">
                <button x-on:click="showStatusModal = false" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                    Cancelar
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function ticketDetail() {
        return {
            showStatusModal: false,
            showReopenModal: false,
            
            async updateStatus(status) {
                try {
                    const response = await fetch(`{{ route('tenant.admin.tickets.update-status', ['store' => $store->slug, 'ticket' => $ticket]) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    });
                    
                    const data = await response.json();
                    if (data.success) {
                        this.showStatusModal = false;
                        if (window.toast) {
                            window.toast.success(
                                'Estado actualizado',
                                data.message || 'El estado del ticket ha sido actualizado correctamente',
                                5000,
                                'bottom-center'
                            );
                        }
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        if (window.toast) {
                            window.toast.error(
                                'Error',
                                data.message || 'Error al actualizar el estado',
                                5000,
                                'bottom-center'
                            );
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    if (window.toast) {
                        window.toast.error(
                            'Error',
                            'Error al actualizar el estado',
                            5000,
                            'bottom-center'
                        );
                    }
                }
            }
        }
    }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
