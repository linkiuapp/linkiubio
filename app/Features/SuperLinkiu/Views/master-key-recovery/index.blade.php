@extends('shared::layouts.admin')

@section('title', 'Solicitudes de Recuperación - Clave Maestra')

@section('content')
<div class="space-y-6" x-data="recoveryManager">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-body-large font-bold text-black-500">🔐 Recuperación de Clave Maestra</h2>
            <p class="text-body-small text-black-300 mt-1">
                Gestiona las solicitudes de recuperación de clave maestra de las tiendas
            </p>
        </div>
        
        <!-- Stats -->
        <div class="flex gap-4">
            <div class="bg-warning-50 rounded-lg px-4 py-2">
                <div class="text-body-large font-bold text-warning-300">{{ $requests->where('status', 'pending')->count() }}</div>
                <div class="text-caption text-black-300">Pendientes</div>
            </div>
            <div class="bg-success-50 rounded-lg px-4 py-2">
                <div class="text-body-large font-bold text-success-300">{{ $requests->where('status', 'approved')->count() }}</div>
                <div class="text-caption text-black-300">Aprobadas</div>
            </div>
            <div class="bg-error-50 rounded-lg px-4 py-2">
                <div class="text-body-large font-bold text-error-300">{{ $requests->where('status', 'rejected')->count() }}</div>
                <div class="text-caption text-black-300">Rechazadas</div>
            </div>
        </div>
    </div>

    <!-- Tabla de Solicitudes -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($requests->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-accent-200">
                    <thead class="bg-accent-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-caption font-bold text-black-400 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-caption font-bold text-black-400 uppercase tracking-wider">
                                Tienda
                            </th>
                            <th class="px-6 py-3 text-left text-caption font-bold text-black-400 uppercase tracking-wider">
                                Solicitado por
                            </th>
                            <th class="px-6 py-3 text-left text-caption font-bold text-black-400 uppercase tracking-wider">
                                Fecha solicitud
                            </th>
                            <th class="px-6 py-3 text-left text-caption font-bold text-black-400 uppercase tracking-wider">
                                Resuelto por
                            </th>
                            <th class="px-6 py-3 text-center text-caption font-bold text-black-400 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-accent-200">
                        @foreach($requests as $request)
                            <tr class="hover:bg-accent-50 transition-colors">
                                <!-- Estado -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($request->status === 'pending')
                                        <span class="flex items-center gap-2 px-2 py-1 inline-flex text-caption font-semibold rounded-full bg-warning-50 text-warning-500">
                                            <x-solar-clock-circle-bold class="w-5 h-5" /> Pendiente
                                        </span>
                                    @elseif($request->status === 'approved')
                                        <span class="flex items-center gap-2 px-2 py-1 inline-flex text-caption font-semibold rounded-full bg-success-50 text-success-500">
                                            <x-solar-check-circle-bold class="w-5 h-5" /> Aprobada
                                        </span>
                                    @else
                                        <span class="flex items-center gap-2 px-2 py-1 inline-flex text-caption font-semibold rounded-full bg-error-50 text-error-500">
                                            <x-solar-close-circle-bold class="w-5 h-5" /> Rechazada
                                        </span>
                                    @endif
                                </td>

                                <!-- Tienda -->
                                <td class="px-6 py-4">
                                    <div class="text-body-small font-medium text-black-500">
                                        {{ $request->store->name }}
                                    </div>
                                    <div class="text-caption text-black-300">
                                        {{ $request->store->slug }}
                                    </div>
                                </td>

                                <!-- Solicitado por -->
                                <td class="px-6 py-4">
                                    <div class="text-body-small text-black-400">
                                        {{ $request->requestedByUser->name }}
                                    </div>
                                    <div class="text-caption text-black-300">
                                        {{ $request->requestedByUser->email }}
                                    </div>
                                </td>

                                <!-- Fecha solicitud -->
                                <td class="px-6 py-4 whitespace-nowrap text-body-small text-black-400">
                                    {{ $request->created_at->format('d/m/Y H:i') }}
                                    <div class="text-caption text-black-300">
                                        {{ $request->created_at->diffForHumans() }}
                                    </div>
                                </td>

                                <!-- Resuelto por -->
                                <td class="px-6 py-4">
                                    @if($request->approvedByUser)
                                        <div class="text-body-small text-black-400">
                                            {{ $request->approvedByUser->name }}
                                        </div>
                                        <div class="text-caption text-black-300">
                                            {{ $request->resolved_at->format('d/m/Y H:i') }}
                                        </div>
                                    @else
                                        <span class="text-caption text-black-300">-</span>
                                    @endif
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($request->status === 'pending')
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="approveRequest({{ $request->id }}, '{{ $request->store->name }}')" 
                                                    class="inline-flex items-center gap-2 px-3 py-1.5 border border-transparent text-caption font-bold rounded-md text-black-400 bg-success-300 hover:bg-success-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success-200">
                                                <x-solar-check-circle-bold class="w-5 h-5" /> Aprobar
                                            </button>
                                            <button @click="showRejectModal({{ $request->id }}, '{{ $request->store->name }}')" 
                                                    class="inline-flex items-center gap-2 px-3 py-1.5 border border-transparent text-caption font-bold rounded-md text-accent-50 bg-error-300 hover:bg-error-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-error-200">
                                                <x-solar-close-circle-outline class="w-5 h-5" /> Rechazar
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-caption text-black-300">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 border-t border-accent-200">
                {{ $requests->links() }}
            </div>
        @else
            <!-- Estado vacío -->
            <div class="text-center py-12">
                <div class="text-6xl mb-4 flex items-center justify-center"><x-solar-lock-bold class="w-12 h-12" /></div>
                <h3 class="text-body-large font-bold text-black-400 mb-2">No hay solicitudes</h3>
                <p class="text-body-small text-black-300">
                    No se han registrado solicitudes de recuperación de clave maestra
                </p>
            </div>
        @endif
    </div>

    <!-- Modal de Rechazo -->
    <div x-show="showRejectModalVisible" 
         x-cloak
         class="fixed z-50 inset-0 overflow-y-auto"
         @keydown.escape.window="showRejectModalVisible = false">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div x-show="showRejectModalVisible"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black-500 bg-opacity-75 transition-opacity"
                 @click="showRejectModalVisible = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <!-- Modal -->
            <div x-show="showRejectModalVisible"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form :action="`/superlinkiu/master-key-recovery/${rejectRequestId}/reject`" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-error-50 sm:mx-0 sm:h-10 sm:w-10">
                                <span class="text-2xl"><x-solar-close-circle-bold class="w-5 h-5" /></span>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-body-large leading-6 font-bold text-black-500">
                                    Rechazar Solicitud
                                </h3>
                                <div class="mt-4">
                                    <p class="text-body-small text-black-300 mb-4">
                                        ¿Seguro que deseas rechazar la solicitud de recuperación de <strong x-text="rejectStoreName"></strong>?
                                    </p>
                                    <label class="block text-caption font-bold text-black-400 mb-2">
                                        Razón del rechazo (opcional)
                                    </label>
                                    <textarea name="reason" 
                                              rows="3"
                                              class="w-full px-3 py-2 border border-accent-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200"
                                              placeholder="Explica por qué se rechaza la solicitud..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-accent-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-error-300 text-base font-medium text-white hover:bg-error-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-error-200 sm:ml-3 sm:w-auto sm:text-sm">
                            Rechazar solicitud
                        </button>
                        <button type="button" 
                                @click="showRejectModalVisible = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-accent-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black-400 hover:bg-accent-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('recoveryManager', () => ({
            showRejectModalVisible: false,
            rejectRequestId: null,
            rejectStoreName: '',

            async approveRequest(requestId, storeName) {
                const result = await Swal.fire({
                    title: 'Aprobar Recuperación',
                    html: `
                        <p class="text-body-small text-black-400 mb-3">
                            ¿Confirmas que deseas aprobar la solicitud de recuperación de:
                        </p>
                        <p class="text-body-large font-bold text-black-500">${storeName}</p>
                        <p class="text-caption text-black-300 mt-3">
                            Esto desactivará la clave maestra actual y permitirá al administrador crear una nueva.
                        </p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, aprobar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#001b48'
                });

                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/superlinkiu/master-key-recovery/${requestId}/approve`;
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            },

            showRejectModal(requestId, storeName) {
                this.rejectRequestId = requestId;
                this.rejectStoreName = storeName;
                this.showRejectModalVisible = true;
            }
        }));
    });
</script>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection

