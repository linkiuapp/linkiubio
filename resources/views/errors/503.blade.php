<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento - LINKIU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-warning-50 to-warning-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">

        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-warning-300 to-warning-400 p-8 text-center">
                <h1 class="text-4xl font-bold text-accent-50 mb-2">Estamos en Mantenimiento</h1>
                <p class="text-accent-50 text-lg">Volvemos pronto</p>
            </div>

            {{-- Contenido --}}
            <div class="p-8">
                {{-- Ilustración/Mensaje --}}
                <div class="text-center mb-8">
                    <div class="mb-6">
                        <svg class="w-32 h-32 mx-auto text-warning-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <p class="text-black-300 text-base leading-relaxed mb-4">
                        Estamos realizando mejoras para ofrecerte una mejor experiencia.
                    </p>
                    <p class="text-black-200 text-sm">
                        Esto no debería tomar mucho tiempo. Gracias por tu paciencia.
                    </p>
                </div>

                {{-- Info --}}
                <div class="bg-accent-50 rounded-xl p-6 mb-6">
                    <h2 class="text-lg font-semibold text-black-400 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-warning-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        ¿Qué está pasando?
                    </h2>
                    <ul class="space-y-2 text-sm text-black-300">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-warning-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Estamos actualizando el sistema
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-warning-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Implementando nuevas características
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-warning-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Mejorando el rendimiento y seguridad
                        </li>
                    </ul>
                </div>

                {{-- Botones de Acción --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="javascript:location.reload()" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-black-400 bg-white hover:bg-accent-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-warning-300 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Intentar Nuevamente
                    </a>
                    <a href="mailto:soporte@linkiu.bio" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-warning-300 hover:bg-warning-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-warning-300 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contactar Soporte
                    </a>
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

