<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Rechazada - {{ $store->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <img src="{{ asset('assets/images/Logo_Linkiu.svg') }}" alt="Linkiu" class="h-12 mx-auto mb-4">
        </div>

        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-danger-300 to-danger-400 p-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-4">
                    <svg class="w-12 h-12 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Solicitud Rechazada</h1>
                <p class="text-white text-opacity-90">Tu solicitud no pudo ser aprobada</p>
            </div>

            {{-- Contenido --}}
            <div class="p-8">
                {{-- Información del Rechazo --}}
                <div class="bg-red-50 border-l-4 border-red-400 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-red-900 mb-3">Motivo del Rechazo</h2>
                    <p class="text-sm font-medium text-red-800 mb-4">
                        {{ $store->rejection_reason ?? 'No especificado' }}
                    </p>
                    
                    @if($store->rejection_message)
                    <div class="bg-white rounded-lg p-4 border border-red-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Mensaje del Equipo de Revisión:</h3>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $store->rejection_message }}</p>
                    </div>
                    @endif
                </div>

                {{-- Información de la Solicitud --}}
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Tu Solicitud</h2>
                    <dl class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <dt class="text-sm font-medium text-gray-600">Nombre de la Tienda</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $store->name }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <dt class="text-sm font-medium text-gray-600">Categoría</dt>
                            <dd class="text-sm font-semibold text-gray-900">
                                @if($store->businessCategory)
                                    {{ $store->businessCategory->icon }} {{ $store->businessCategory->name }}
                                @else
                                    {{ $store->business_type ?? 'No especificado' }}
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <dt class="text-sm font-medium text-gray-600">Documento</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $store->business_document_type }} {{ $store->business_document_number }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <dt class="text-sm font-medium text-gray-600">Fecha de Rechazo</dt>
                            <dd class="text-sm font-semibold text-gray-900">
                                {{ $store->rejected_at?->format('d/m/Y H:i') ?? 'N/A' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Opciones --}}
                <div class="space-y-4 mb-6">
                    @if($store->can_reapply_at && $store->can_reapply_at->isFuture())
                        {{-- Aún no puede re-aplicar --}}
                        <div class="bg-warning-50 border border-warning-200 rounded-xl p-6 text-center">
                            <svg class="w-12 h-12 text-warning-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-warning-900 mb-2">Podrás Re-aplicar Pronto</h3>
                            <p class="text-sm text-warning-700 mb-3">
                                Podrás volver a enviar tu solicitud el:
                            </p>
                            <p class="text-2xl font-bold text-warning-900 mb-1">
                                {{ $store->can_reapply_at->format('d/m/Y') }}
                            </p>
                            <p class="text-sm text-warning-600">
                                ({{ $store->can_reapply_at->diffForHumans() }})
                            </p>
                        </div>
                    @else
                        {{-- Puede re-aplicar --}}
                        <div class="bg-success-50 border border-success-200 rounded-xl p-6 text-center">
                            <svg class="w-12 h-12 text-success-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-success-900 mb-2">¡Puedes Re-aplicar!</h3>
                            <p class="text-sm text-success-700 mb-4">
                                Ya puedes volver a enviar tu solicitud con la información corregida
                            </p>
                            <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-success-300 hover:bg-success-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success-300 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Intentar Nuevamente
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Opciones de Ayuda --}}
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">¿No estás de acuerdo con la decisión?</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Puedes:</p>
                                <ul class="list-disc list-inside mt-2 space-y-1">
                                    <li>Corregir la información y volver a aplicar</li>
                                    <li>Contactar a nuestro equipo para más información</li>
                                    <li>Enviar una apelación si consideras que es un error</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="mailto:apelaciones@linkiu.email?subject=Apelación Solicitud {{ $store->name }}&body=ID Tienda: {{ $store->id }}%0A%0AMotivo de apelación:" 
                       class="inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Enviar Apelación
                    </a>
                    <a href="mailto:soporte@linkiu.email?subject=Consulta Solicitud {{ $store->name }}&body=ID Tienda: {{ $store->id }}%0A%0AMi consulta es:" 
                       class="inline-flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-200 hover:bg-primary-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Contactar Soporte
                    </a>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-8 text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} Linkiu. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>

