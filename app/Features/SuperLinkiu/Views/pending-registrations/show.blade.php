@extends('shared::layouts.admin')

@section('title', 'Detalle de Registro - SuperLinkiu')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="registrationDetail()">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('superlinkiu.pending-registrations.index') }}" 
               class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Registro #{{ str_pad($pendingRegistration->id, 5, '0', STR_PAD_LEFT) }}</h1>
                <p class="text-sm text-gray-600">{{ $pendingRegistration->owner_name }} - {{ $pendingRegistration->owner_email }}</p>
            </div>
        </div>
        
        {{-- Badge de Estado --}}
        <div>
            @if($pendingRegistration->status === 'pending')
                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg font-semibold flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    Pendiente
                </span>
            @elseif($pendingRegistration->status === 'approved')
                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    Aprobado
                </span>
            @elseif($pendingRegistration->status === 'rejected')
                <span class="px-4 py-2 bg-red-100 text-red-800 rounded-lg font-semibold flex items-center gap-2">
                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                    Rechazado
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Columna Principal --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Plan Seleccionado --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="package" class="w-5 h-5 text-blue-600"></i>
                        Plan Seleccionado
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $pendingRegistration->plan->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ ucfirst($pendingRegistration->billing_period) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-blue-600">${{ number_format($pendingRegistration->getAmount(), 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">Monto a pagar</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información del Negocio --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="briefcase" class="w-5 h-5 text-purple-600"></i>
                        Información del Negocio
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nombre del Negocio</p>
                            <p class="font-semibold text-gray-900">{{ $pendingRegistration->business_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Categoría</p>
                            <p class="font-semibold text-gray-900">{{ $pendingRegistration->category->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tipo de Documento</p>
                            <p class="font-semibold text-gray-900">{{ strtoupper($pendingRegistration->document_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Número de Documento</p>
                            <p class="font-semibold text-gray-900">{{ $pendingRegistration->document_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Teléfono</p>
                            <p class="font-semibold text-gray-900">{{ $pendingRegistration->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-semibold text-gray-900">{{ $pendingRegistration->email }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Ubicación</p>
                            <p class="font-semibold text-gray-900">{{ $pendingRegistration->city }}, {{ $pendingRegistration->department }}</p>
                        </div>
                        @if($pendingRegistration->description)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Descripción</p>
                            <p class="text-gray-900">{{ $pendingRegistration->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Información de la Tienda --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="store" class="w-5 h-5 text-green-600"></i>
                        Configuración de la Tienda
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nombre de la Tienda</p>
                            <p class="font-semibold text-gray-900">{{ $pendingRegistration->store_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">URL</p>
                            <p class="font-semibold text-blue-600">{{ $pendingRegistration->slug }}.linkiu.bio</p>
                        </div>
                        @if($pendingRegistration->store_description)
                        <div>
                            <p class="text-sm text-gray-600">Descripción</p>
                            <p class="text-gray-900">{{ $pendingRegistration->store_description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Información del Propietario --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-orange-600"></i>
                        Información del Propietario
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nombre Completo</p>
                            <p class="font-semibold text-gray-900">{{ $pendingRegistration->owner_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-semibold text-gray-900">{{ $pendingRegistration->owner_email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tipo de Documento</p>
                            <p class="font-semibold text-gray-900">{{ strtoupper($pendingRegistration->owner_document_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Número de Documento</p>
                            <p class="font-semibold text-gray-900">{{ $pendingRegistration->owner_document_number }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna Lateral --}}
        <div class="space-y-6">
            {{-- Comprobante de Pago --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                        Comprobante de Pago
                    </h2>
                </div>
                <div class="p-6">
                    @if($pendingRegistration->payment_proof)
                        <img src="{{ Storage::disk('public')->url($pendingRegistration->payment_proof) }}" 
                             alt="Comprobante de Pago" 
                             class="w-full rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition-opacity"
                             onclick="window.open(this.src, '_blank')">
                        <p class="text-xs text-gray-500 mt-2 text-center mb-4">Click para ampliar</p>
                        
                        {{-- Botón de KiuBot --}}
                        <button @click="analyzeWithKiuBot"
                                :disabled="analyzing"
                                class="w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 disabled:from-gray-300 disabled:to-gray-400 text-white rounded-lg font-semibold transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <i :data-lucide="analyzing ? 'loader' : 'sparkles'" class="w-5 h-5" :class="analyzing ? 'animate-spin' : ''"></i>
                            <span x-text="analyzing ? 'KiuBot Analizando...' : 'Analizar con KiuBot'"></span>
                        </button>
                        
                        {{-- Resultado del análisis --}}
                        <div x-show="analysisResult" x-cloak class="mt-4">
                            <div :class="{
                                'bg-green-50 border-green-200 text-green-800': analysisResult === 'valid',
                                'bg-yellow-50 border-yellow-200 text-yellow-800': analysisResult === 'suspicious',
                                'bg-red-50 border-red-200 text-red-800': analysisResult === 'fake'
                            }" class="border rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <i :data-lucide="analysisResult === 'valid' ? 'check-circle' : (analysisResult === 'suspicious' ? 'alert-triangle' : 'x-circle')" class="w-5 h-5"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold mb-1" x-text="analysisTitle"></p>
                                        <p class="text-sm" x-text="analysisMessage"></p>
                                        <p class="text-xs mt-2 opacity-75">Confianza: <span x-text="analysisScore"></span>%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i data-lucide="image-off" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                            <p class="text-sm text-gray-500">No hay comprobante</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Fechas --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                        <div>
                            <p class="text-xs text-gray-600">Fecha de Solicitud</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $pendingRegistration->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @if($pendingRegistration->processed_at)
                    <div class="flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-gray-400"></i>
                        <div>
                            <p class="text-xs text-gray-600">Fecha de Procesamiento</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $pendingRegistration->processed_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @endif
                    @if($pendingRegistration->processedBy)
                    <div class="flex items-center gap-3">
                        <i data-lucide="user-check" class="w-4 h-4 text-gray-400"></i>
                        <div>
                            <p class="text-xs text-gray-600">Procesado por</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $pendingRegistration->processedBy->name }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Acciones --}}
            @if($pendingRegistration->status === 'pending')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Acciones</h3>
                <div class="space-y-3">
                    <button @click="showApproveModal = true"
                            class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Aprobar Registro
                    </button>
                    <button @click="showRejectModal = true"
                            class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                        Rechazar Registro
                    </button>
                </div>
            </div>
            @endif

            {{-- Razón de Rechazo --}}
            @if($pendingRegistration->status === 'rejected' && $pendingRegistration->rejected_reason)
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <h3 class="font-semibold text-red-900 mb-2 flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    Razón del Rechazo
                </h3>
                <p class="text-sm text-red-800">{{ $pendingRegistration->rejected_reason }}</p>
            </div>
            @endif

            {{-- Tienda Creada --}}
            @if($pendingRegistration->status === 'approved' && $pendingRegistration->createdStore)
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <h3 class="font-semibold text-green-900 mb-3 flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    Tienda Creada
                </h3>
                <a href="{{ route('superlinkiu.stores.show', $pendingRegistration->createdStore) }}"
                   class="block px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-center transition-colors">
                    Ver Tienda
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Modal de Aprobación - Backdrop --}}
    <div x-show="showApproveModal"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
         @click="showApproveModal = false"
         style="display: none;"
         x-cloak></div>

    {{-- Modal de Aprobación - Content --}}
    <div x-show="showApproveModal"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
         role="dialog"
         tabindex="-1"
         aria-labelledby="approve-modal-label"
         style="display: none;"
         x-cloak>
        <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
            <div @click.stop
                 class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto">
                <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                    <h3 id="approve-modal-label" class="font-bold text-gray-800">
                        ¿Aprobar registro?
                    </h3>
                    <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                            aria-label="Cerrar"
                            @click="showApproveModal = false"
                            :disabled="processing">
                        <span class="sr-only">Cerrar</span>
                        <i data-lucide="x" class="shrink-0 size-4"></i>
                    </button>
                </div>

                <div class="p-4 overflow-y-auto">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="size-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i data-lucide="check-circle" class="size-5 text-green-600"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-800">
                                Se creará automáticamente la tienda <strong>"{{ $pendingRegistration->store_name }}"</strong> con todos los datos proporcionados.
                            </p>
                            <p class="text-sm text-gray-600 mt-2">
                                El usuario recibirá acceso inmediato a su panel de administración.
                            </p>
                            
                            <div x-show="error" class="mt-3" x-cloak>
                                <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                    <div class="flex">
                                        <div class="shrink-0">
                                            <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
                                        </div>
                                        <div class="ms-2">
                                            <h3 class="text-sm font-medium">
                                                Error: <span x-text="error"></span>
                                            </h3>
                                        </div>
                                        <div class="ps-3 ms-auto">
                                            <div class="-mx-1.5 -my-1.5">
                                                <button type="button"
                                                        class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100"
                                                        @click="error = null">
                                                    <span class="sr-only">Descartar</span>
                                                    <i data-lucide="x" class="shrink-0 size-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                    <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                            @click="showApproveModal = false"
                            :disabled="processing">
                        Cancelar
                    </button>
                    <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-none focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none"
                            @click="approveRegistration()"
                            :disabled="processing">
                        <span x-show="!processing">Sí, aprobar</span>
                        <span x-show="processing" class="flex items-center gap-2">
                            <i data-lucide="loader" class="size-4 animate-spin"></i>
                            Aprobando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Rechazo - Backdrop --}}
    <div x-show="showRejectModal"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
         @click="showRejectModal = false"
         style="display: none;"
         x-cloak"></div>

    {{-- Modal de Rechazo - Content --}}
    <div x-show="showRejectModal"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
         role="dialog"
         tabindex="-1"
         aria-labelledby="reject-modal-label"
         style="display: none;"
         x-cloak>
        <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
            <div @click.stop
                 class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto">
                <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                    <h3 id="reject-modal-label" class="font-bold text-gray-800">
                        ¿Rechazar registro?
                    </h3>
                    <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                            aria-label="Cerrar"
                            @click="showRejectModal = false"
                            :disabled="processing">
                        <span class="sr-only">Cerrar</span>
                        <i data-lucide="x" class="shrink-0 size-4"></i>
                    </button>
                </div>

                <div class="p-4 overflow-y-auto">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-800 mb-3">
                                El usuario <strong>"{{ $pendingRegistration->owner_name }}"</strong> será notificado del rechazo.
                            </p>
                            
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Razón del Rechazo <span class="text-red-500">*</span>
                            </label>
                            <textarea x-model="rejectReason"
                                      rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:outline-none text-sm"
                                      placeholder="Explica por qué se rechaza este registro..."></textarea>
                            <p class="text-xs text-gray-500 mt-1">Esta razón se mostrará al usuario</p>
                            
                            <div x-show="error" class="mt-3" x-cloak>
                                <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                    <div class="flex">
                                        <div class="shrink-0">
                                            <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
                                        </div>
                                        <div class="ms-2">
                                            <h3 class="text-sm font-medium">
                                                Error: <span x-text="error"></span>
                                            </h3>
                                        </div>
                                        <div class="ps-3 ms-auto">
                                            <div class="-mx-1.5 -my-1.5">
                                                <button type="button"
                                                        class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100"
                                                        @click="error = null">
                                                    <span class="sr-only">Descartar</span>
                                                    <i data-lucide="x" class="shrink-0 size-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                    <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                            @click="showRejectModal = false"
                            :disabled="processing">
                        Cancelar
                    </button>
                    <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                            @click="rejectRegistration()"
                            :disabled="!rejectReason || processing">
                        <span x-show="!processing">Sí, rechazar</span>
                        <span x-show="processing" class="flex items-center gap-2">
                            <i data-lucide="loader" class="size-4 animate-spin"></i>
                            Rechazando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('registrationDetail', () => ({
        showApproveModal: false,
        showRejectModal: false,
        rejectReason: '',
        processing: false,
        error: null,
        analyzing: false,
        analysisResult: null,
        analysisTitle: '',
        analysisMessage: '',
        analysisScore: 0,

        async approveRegistration() {
            this.processing = true;
            this.error = null;

            try {
                const response = await fetch('{{ route('superlinkiu.pending-registrations.approve', $pendingRegistration) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.showApproveModal = false;
                    if (window.toast) {
                        window.toast.success('Registro aprobado', data.message, 3000, 'bottom-center');
                    }
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                this.error = error.message || 'No se pudo aprobar el registro';
                this.processing = false;
                
                // Re-inicializar iconos después de mostrar error
                this.$nextTick(() => {
                    if (window.createIcons && window.lucideIcons) {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                });
            }
        },

        async rejectRegistration() {
            if (!this.rejectReason) return;

            this.processing = true;
            this.error = null;

            try {
                const response = await fetch('{{ route('superlinkiu.pending-registrations.reject', $pendingRegistration) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        reason: this.rejectReason
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.showRejectModal = false;
                    if (window.toast) {
                        window.toast.success('Registro rechazado', data.message, 3000, 'bottom-center');
                    }
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                this.error = error.message || 'No se pudo rechazar el registro';
                this.processing = false;
                
                // Re-inicializar iconos después de mostrar error
                this.$nextTick(() => {
                    if (window.createIcons && window.lucideIcons) {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                });
            }
        },

        async analyzeWithKiuBot() {
            this.analyzing = true;
            this.analysisResult = null;

            try {
                // Aquí puedes agregar el endpoint de validación cuando esté listo
                // Por ahora simulo una respuesta
                await new Promise(resolve => setTimeout(resolve, 2000));
                
                // Resultado simulado - reemplazar con API real
                const mockResult = {
                    status: 'valid', // 'valid', 'suspicious', 'fake'
                    score: 92,
                    title: 'Comprobante Válido',
                    message: 'KiuBot ha analizado el comprobante y no detectó señales de alteración.'
                };

                this.analysisResult = mockResult.status;
                this.analysisTitle = mockResult.title;
                this.analysisMessage = mockResult.message;
                this.analysisScore = mockResult.score;

                // Re-inicializar iconos
                this.$nextTick(() => {
                    if (window.createIcons && window.lucideIcons) {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                });

                if (window.toast) {
                    window.toast.success('Análisis completado', mockResult.title, 3000, 'bottom-center');
                }
            } catch (error) {
                if (window.toast) {
                    window.toast.error('Error', 'No se pudo analizar el comprobante', 5000, 'bottom-center');
                }
            } finally {
                this.analyzing = false;
                
                // Re-inicializar iconos después del análisis
                this.$nextTick(() => {
                    if (window.createIcons && window.lucideIcons) {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                });
            }
        }
    }));
});

// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});

// Re-inicializar iconos cuando Alpine monta
document.addEventListener('alpine:initialized', () => {
    setTimeout(() => {
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
    }, 100);
});
</script>

<style>
[x-cloak] { display: none !important; }

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
@endsection

