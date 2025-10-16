<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error del Servidor - LINKIU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-error-50 to-error-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">

        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-error-300 to-error-400 p-8 text-center">
                <h1 class="text-4xl font-bold text-accent-50 mb-2">¡Algo salió mal!</h1>
                <p class="text-accent-50 text-lg">Error interno del servidor</p>
            </div>

            {{-- Contenido --}}
            <div class="p-8">
                {{-- Ilustración/Mensaje --}}
                <div class="text-center mb-8">
                    <div class="mb-6">
                        <svg class="w-32 h-32 mx-auto text-error-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <p class="text-black-300 text-base leading-relaxed mb-4">
                        Lo sentimos, algo no funcionó correctamente en nuestro servidor.
                    </p>
                    <p class="text-black-200 text-sm">
                        Nuestro equipo ha sido notificado y está trabajando para solucionar el problema.
                    </p>
                </div>

                {{-- Qué hacer --}}
                <div class="bg-accent-50 rounded-xl p-6 mb-6">
                    <h2 class="text-lg font-semibold text-black-400 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-info-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Mientras tanto, puedes:
                    </h2>
                    <ul class="space-y-2 text-sm text-black-300">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-success-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Intentar nuevamente en unos minutos
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-success-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Refrescar la página
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-success-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Contactar a soporte si el problema persiste
                        </li>
                    </ul>
                </div>

                {{-- Botones de Acción --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-black-400 bg-white hover:bg-accent-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-info-300 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Volver al Inicio
                    </a>
                    <a href="javascript:location.reload()" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-info-300 hover:bg-info-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-info-300 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refrescar Página
                    </a>
                </div>

                {{-- Soporte --}}
                <div class="mt-6 text-center">
                    <p class="text-sm text-black-200">
                        ¿El problema persiste? 
                        <a href="mailto:soporte@linkiu.bio" class="text-error-300 hover:text-error-400 font-medium">
                            Reportar problema
                        </a>
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-8 text-sm text-black-200">
            <p>&copy; {{ date('Y') }} LINKIU. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>

