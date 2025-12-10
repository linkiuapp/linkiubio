<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago No Verificado - Linkiu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg {
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        }
        .card-shadow {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-block bg-white rounded-full p-4 mb-4 card-shadow">
                <i data-lucide="alert-triangle" class="w-16 h-16 text-orange-500"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Pago No Verificado</h1>
            <p class="text-white text-opacity-90 text-lg">Lo sentimos, no pudimos verificar tu pago</p>
        </div>

        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
            {{-- Razón del Rechazo --}}
            <div class="p-8 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <i data-lucide="file-x" class="w-6 h-6 text-red-600"></i>
                    Razón del Rechazo
                </h2>
                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-6">
                    <p class="text-gray-800 leading-relaxed mb-4">
                        {{ $registration->rejection_reason ?? 'El comprobante de pago no es válido o no coincide con el monto esperado.' }}
                    </p>
                    
                    @if($registration->rejection_details)
                    <div class="mt-4 pt-4 border-t border-red-200">
                        <p class="text-sm font-medium text-gray-700 mb-2">Detalles adicionales:</p>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-700">
                            @foreach(json_decode($registration->rejection_details, true) ?? [] as $detail)
                                <li>{{ $detail }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                {{-- Referencia --}}
                <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-600">
                        <strong>Referencia de Solicitud:</strong> <span class="font-mono text-gray-900">#REG-{{ str_pad($registration->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </p>
                </div>
            </div>

            {{-- Contacto con Soporte --}}
            <div class="p-8 bg-gradient-to-r from-orange-50 to-red-50">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <i data-lucide="headphones" class="w-6 h-6 text-orange-600"></i>
                    Contacta con Soporte
                </h2>
                
                <div class="bg-white rounded-xl p-6 border-2 border-orange-200 mb-6">
                    <div class="text-center">
                        <i data-lucide="message-circle" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
                        <p class="text-gray-700 mb-4">Nuestro equipo está listo para ayudarte a resolver este problema</p>
                        <a href="https://wa.me/573104594344?text=Hola,%20necesito%20ayuda%20con%20mi%20registro%20#REG-{{ str_pad($registration->id, 5, '0', STR_PAD_LEFT) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-3 px-8 py-4 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-xl">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                            Contactar por WhatsApp
                            <span class="text-white text-opacity-90">+57 310 459 4344</span>
                        </a>
                    </div>
                </div>

                {{-- Qué puedes hacer --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-gray-900 text-lg">¿Qué puedes hacer?</h3>
                    <div class="grid grid-cols-1 gap-3">
                        <div class="flex items-start gap-3 bg-white rounded-lg p-4 border border-gray-200">
                            <div class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0 font-bold">
                                1
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Verificar el comprobante</p>
                                <p class="text-sm text-gray-600">Asegúrate de que el comprobante sea legible y coincida con el monto exacto</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-white rounded-lg p-4 border border-gray-200">
                            <div class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0 font-bold">
                                2
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Realizar el pago nuevamente</p>
                                <p class="text-sm text-gray-600">Si el pago no se completó, puedes intentar el proceso de nuevo</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-white rounded-lg p-4 border border-gray-200">
                            <div class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0 font-bold">
                                3
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Contactar con soporte</p>
                                <p class="text-sm text-gray-600">Nuestro equipo puede revisar tu caso y ayudarte directamente</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="p-8 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register.step1') }}"
                       class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold text-center transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                        Intentar de Nuevo
                    </a>
                    <a href="https://wa.me/573104594344?text=Hola,%20necesito%20ayuda%20con%20mi%20registro%20#REG-{{ str_pad($registration->id, 5, '0', STR_PAD_LEFT) }}"
                       target="_blank"
                       class="flex-1 px-8 py-4 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-center transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                        Contactar Soporte
                    </a>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-8">
            <a href="{{ url('/') }}" class="text-white text-opacity-80 hover:text-white font-medium underline flex items-center justify-center gap-2">
                <i data-lucide="home" class="w-4 h-4"></i>
                Volver al Inicio
            </a>
        </div>
    </div>

    <script>
        // Inicializar iconos Lucide
        lucide.createIcons();
    </script>
</body>
</html>

