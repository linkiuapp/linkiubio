<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página No Encontrada - LINKIU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-accent-50 to-info-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">

        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-info-300 to-info-400 p-8 text-center">
                <h1 class="text-4xl font-bold text-accent-50 mb-2">¡Ups!</h1>
                <p class="text-accent-50 text-lg">Página no encontrada</p>
            </div>

            {{-- Contenido --}}
            <div class="p-8">
                {{-- Ilustración/Mensaje --}}
                <div class="text-center mb-8">
                    <div class="mb-6">
                        <svg class="w-32 h-32 mx-auto text-info-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-black-300 text-base leading-relaxed mb-4">
                        No pudimos encontrar la página que estás buscando.
                    </p>
                </div>

                {{-- Posibles Razones --}}
                <div class="bg-accent-50 rounded-xl p-6 mb-6">
                    <h2 class="text-lg font-semibold text-black-400 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-info-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Puede que:
                    </h2>
                    <ul class="space-y-2 text-sm text-black-300">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-info-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            El enlace esté mal escrito o incompleto
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-info-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            La página haya sido movida o eliminada
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-info-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            El contenido ya no esté disponible
                        </li>
                    </ul>
                </div>

                {{-- Call to Action --}}
                <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-xl p-6 mb-6 text-center">
                    <h3 class="text-lg font-semibold text-black-400 mb-2">¿Tienes un negocio?</h3>
                    <p class="text-sm text-black-300 mb-4">
                        Crea tu propia tienda en línea en minutos
                    </p>
                    <div class="flex items-center justify-center gap-2 text-primary-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm font-medium">Gratis • Sin tarjeta • 5 minutos</span>
                    </div>
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
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary-300 hover:bg-primary-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-300 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Crear Mi Tienda
                    </a>
                </div>

                {{-- Soporte --}}
                <div class="mt-6 text-center">
                    <p class="text-sm text-black-200">
                        ¿Necesitas ayuda? 
                        <a href="mailto:soporte@linkiu.bio" class="text-info-300 hover:text-info-400 font-medium">
                            Contáctanos
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

