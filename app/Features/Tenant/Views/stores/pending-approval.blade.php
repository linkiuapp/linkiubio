<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud en Revisión - {{ $store->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="refresh" content="30">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <img src="{{ asset('assets/Logo-original.png') }}" alt="Linkiu" class="h-12 mx-auto mb-4">
        </div>

        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Header con animación --}}
            <div class="bg-gradient-to-r from-warning-300 to-warning-400 p-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-4 animate-pulse">
                    <svg class="w-12 h-12 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">¡Solicitud en Revisión!</h1>
                <p class="text-white text-opacity-90">Tu tienda está siendo evaluada por nuestro equipo</p>
            </div>

            {{-- Contenido --}}
            <div class="p-8">
                {{-- Información de la Solicitud --}}
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Información de tu Solicitud</h2>
                    <dl class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <dt class="text-sm font-medium text-gray-600">Nombre de la Tienda</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $store->name }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <dt class="text-sm font-medium text-gray-600">Categoría</dt>
                            <dd class="text-sm font-semibold text-gray-900">
                                @if($store->businessCategory)
                                    {{ $store->businessCategory->name }}
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
                            <dt class="text-sm font-medium text-gray-600">Tiempo Transcurrido</dt>
                            <dd class="text-sm font-semibold text-warning-600">
                                {{ $store->created_at->diffForHumans() }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Timeline Estimado --}}
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Tiempo Estimado de Revisión</h2>
                    <div class="relative">
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-gray-200">
                            @php
                                $hoursElapsed = $store->created_at->diffInHours(now());
                                $progress = min(($hoursElapsed / 6) * 100, 100);
                            @endphp
                            <div style="width:{{ $progress }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-warning-400 transition-all duration-500"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-600">
                            <span>Recibida</span>
                            <span class="font-medium text-warning-600">≈ 6 horas</span>
                        </div>
                    </div>
                </div>

                {{-- Siguiente Pasos --}}
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">¿Qué sigue?</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Nuestro equipo está revisando tu información</li>
                                    <li>Recibirás un email cuando tu tienda sea aprobada</li>
                                    <li>El tiempo estimado es de <strong>6 horas</strong> (máximo 24 horas)</li>
                                    <li>Esta página se actualiza automáticamente cada 30 segundos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Auto-refresh info --}}
                <div class="text-center text-sm text-gray-500 mb-6">
                    <svg class="inline-block w-4 h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Actualizando automáticamente...
                </div>

                {{-- Contacto --}}
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-3">¿Tienes alguna pregunta?</p>
                    <a href="mailto:soporte@linkiu.email" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-200 hover:bg-primary-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
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

    {{-- Loading overlay subtle --}}
    <div class="fixed top-4 right-4 bg-white rounded-full shadow-lg px-4 py-2 flex items-center space-x-2 text-sm text-gray-600 animate-pulse">
        <div class="w-2 h-2 bg-warning-400 rounded-full"></div>
        <span>En revisión</span>
    </div>
</body>
</html>

