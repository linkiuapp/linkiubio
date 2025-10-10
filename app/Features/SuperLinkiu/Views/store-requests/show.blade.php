@extends('shared::layouts.admin')

@section('title', 'Detalle de Solicitud - ' . $store->name)

@section('content')
<div class="container-fluid" x-data="{ showApproveModal: false, showRejectModal: false }">
    {{-- Back Button --}}
    <div class="mb-4">
        <a href="{{ route('superlinkiu.store-requests.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
            <x-solar-alt-arrow-left-outline class="w-5 h-5 mr-2" />
            Volver a Solicitudes
        </a>
    </div>

    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $store->name }}</h1>
                <p class="text-sm text-gray-600 mt-1">Solicitud recibida {{ $store->created_at->diffForHumans() }}</p>
            </div>
            <div>
                @if($store->approval_status === 'pending_approval')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-warning-100 text-warning-800">
                        <x-solar-clock-circle-outline class="w-4 h-4 mr-2" />
                        Pendiente
                    </span>
                @elseif($store->approval_status === 'approved')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-success-100 text-success-800">
                        <x-solar-check-circle-outline class="w-4 h-4 mr-2" />
                        Aprobada
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-danger-100 text-danger-800">
                        <x-solar-close-circle-outline class="w-4 h-4 mr-2" />
                        Rechazada
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Información del Negocio --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Información del Negocio</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $store->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Slug</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $store->slug }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Categoría</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($store->businessCategory)
                                {{ $store->businessCategory->icon }} {{ $store->businessCategory->name }}
                            @else
                                {{ $store->business_type ?? 'No especificado' }}
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Documento</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $store->business_document_type }} {{ $store->business_document_number }}
                            @if($store->document_verified)
                                <x-solar-check-circle-bold class="w-4 h-4 text-success-300 inline ml-1" />
                            @endif
                        </dd>
                    </div>
                    @if($store->email)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email Tienda</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $store->email }}</dd>
                    </div>
                    @endif
                    @if($store->phone)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $store->phone }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Información del Administrador --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Administrador</h2>
                @php $admin = $store->admins->first(); @endphp
                @if($admin)
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $admin->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $admin->email }}</dd>
                    </div>
                </dl>
                @endif
            </div>

            {{-- Plan Seleccionado --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Plan Seleccionado</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Plan</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $store->plan->name ?? 'No especificado' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Período de Facturación</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($store->subscription)
                                {{ ucfirst($store->subscription->billing_period) }}
                            @else
                                No especificado
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Notas del Admin --}}
            @if($store->admin_notes)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-blue-900 mb-2">Notas del Administrador</h2>
                <p class="text-sm text-blue-800">{{ $store->admin_notes }}</p>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Timeline --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Línea de Tiempo</h2>
                <div class="space-y-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center">
                                <x-solar-add-circle-outline class="w-4 h-4 text-primary-600" />
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Solicitud Creada</p>
                            <p class="text-xs text-gray-500">{{ $store->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @if($store->approved_at)
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-success-100 flex items-center justify-center">
                                <x-solar-check-circle-outline class="w-4 h-4 text-success-600" />
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Aprobada</p>
                            <p class="text-xs text-gray-500">{{ $store->approved_at->format('d/m/Y H:i') }}</p>
                            @if($store->approvedBy)
                                <p class="text-xs text-gray-500">Por: {{ $store->approvedBy->name }}</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($store->rejected_at)
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-danger-100 flex items-center justify-center">
                                <x-solar-close-circle-outline class="w-4 h-4 text-danger-600" />
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Rechazada</p>
                            <p class="text-xs text-gray-500">{{ $store->rejected_at->format('d/m/Y H:i') }}</p>
                            @if($store->rejection_reason)
                                <p class="text-xs text-gray-500 mt-1">Motivo: {{ $store->rejection_reason }}</p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Acciones --}}
            @if($store->approval_status === 'pending_approval')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h2>
                <div class="space-y-3">
                    <button @click="showApproveModal = true" class="btn-success w-full">
                        <x-solar-check-circle-outline class="w-5 h-5 mr-2" />
                        Aprobar Solicitud
                    </button>
                    <button @click="showRejectModal = true" class="btn-danger w-full">
                        <x-solar-close-circle-outline class="w-5 h-5 mr-2" />
                        Rechazar Solicitud
                    </button>
                </div>
            </div>
            @endif

            {{-- Stats --}}
            <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-3">Estadísticas</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tiempo transcurrido:</span>
                        <span class="font-medium">{{ $store->created_at->diffForHumans(null, true) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Categoría auto-aprueba:</span>
                        <span class="font-medium">
                            @if($store->businessCategory)
                                {{ $store->businessCategory->requires_manual_approval ? 'No' : 'Sí' }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Documento verificado:</span>
                        <span class="font-medium">{{ $store->document_verified ? 'Sí' : 'No' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Aprobar --}}
    <div x-show="showApproveModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showApproveModal" @click="showApproveModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div x-show="showApproveModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('superlinkiu.store-requests.approve', $store) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aprobar Solicitud</h3>
                        <p class="text-sm text-gray-600 mb-4">¿Estás seguro de que deseas aprobar esta solicitud? Se enviará un email al administrador con las credenciales de acceso.</p>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Notas (opcional)</label>
                                <textarea name="admin_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="send_welcome_email" value="1" checked class="mr-2">
                                    <span class="text-sm">Enviar email de bienvenida</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="btn-success w-full sm:w-auto sm:ml-3">Aprobar</button>
                        <button type="button" @click="showApproveModal = false" class="btn-secondary w-full sm:w-auto mt-3 sm:mt-0">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Rechazar --}}
    <div x-show="showRejectModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showRejectModal" @click="showRejectModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div x-show="showRejectModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('superlinkiu.store-requests.reject', $store) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Rechazar Solicitud</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Motivo del rechazo *</label>
                                <select name="rejection_reason" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                    <option value="">Selecciona un motivo</option>
                                    <option value="Documentación incompleta">Documentación incompleta</option>
                                    <option value="Documento inválido">Documento inválido</option>
                                    <option value="Categoría no permitida">Categoría no permitida</option>
                                    <option value="Información sospechosa">Información sospechosa</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje al solicitante *</label>
                                <textarea name="rejection_message" required rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Explica el motivo del rechazo..."></textarea>
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allow_reapply" value="1" checked class="mr-2">
                                    <span class="text-sm">Permitir re-aplicar en 15 días</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="btn-danger w-full sm:w-auto sm:ml-3">Rechazar</button>
                        <button type="button" @click="showRejectModal = false" class="btn-secondary w-full sm:w-auto mt-3 sm:mt-0">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection

