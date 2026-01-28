<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Error del Servidor - LINKIU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
</head>
<body class="bg-gradient-to-br from-error-50 to-error-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">

        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-error-300 to-error-400 p-8 text-center">
                <h1 class="text-4xl font-bold text-white mb-2">¡Algo salió mal!</h1>
                <p class="text-white text-lg">Error interno del servidor (500)</p>
            </div>

            {{-- Contenido --}}
            <div class="p-8">
                {{-- Ilustración/Mensaje --}}
                <div class="text-center mb-8">
                    <div class="mb-6">
                        <i data-lucide="alert-triangle" class="w-32 h-32 mx-auto text-error-300"></i>
                    </div>
                    <p class="text-gray-700 text-base leading-relaxed mb-4">
                        Lo sentimos, algo no funcionó correctamente en nuestro servidor.
                    </p>
                </div>

                {{-- Detalles del Error (si está disponible) --}}
                @php
                    $showDetails = config('app.debug') || (isset($exception) && $exception->getMessage());
                @endphp
                
                @if($showDetails && isset($exception))
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
                    <details class="cursor-pointer" {{ config('app.debug') ? 'open' : '' }}>
                        <summary class="font-semibold text-red-800 mb-3 flex items-center gap-2">
                            <i data-lucide="info" class="w-5 h-5"></i>
                            Detalles del Error{{ config('app.debug') ? ' (Modo Debug)' : '' }}
                        </summary>
                        <div class="mt-4 space-y-3">
                            <div>
                                <p class="text-sm font-medium text-red-900 mb-1">Mensaje:</p>
                                <p class="text-sm text-red-800 bg-red-100 p-3 rounded font-mono break-words">
                                    {{ $exception->getMessage() }}
                                </p>
                            </div>
                            @if(config('app.debug') && $exception->getFile())
                            <div>
                                <p class="text-sm font-medium text-red-900 mb-1">Archivo:</p>
                                <p class="text-sm text-red-800 bg-red-100 p-3 rounded font-mono break-all">
                                    {{ $exception->getFile() }}:{{ $exception->getLine() }}
                                </p>
                            </div>
                            @endif
                            @if(config('app.debug') && $exception->getTraceAsString())
                            <div>
                                <p class="text-sm font-medium text-red-900 mb-1">Stack Trace:</p>
                                <pre class="text-xs text-red-800 bg-red-100 p-3 rounded overflow-x-auto max-h-64 overflow-y-auto">{{ $exception->getTraceAsString() }}</pre>
                            </div>
                            @endif
                        </div>
                    </details>
                </div>
                @endif

                {{-- Formulario de Reporte de Error --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                    <h2 class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2">
                        <i data-lucide="bug" class="w-5 h-5"></i>
                        Reportar este Error
                    </h2>
                    <p class="text-sm text-blue-800 mb-4">
                        Ayúdanos a solucionar este problema reportando el error. Incluye una captura de pantalla si es posible.
                    </p>
                    
                    <form id="errorReportForm" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="error_url" value="{{ request()->fullUrl() }}">
                        <input type="hidden" name="error_message" value="{{ isset($exception) && $exception->getMessage() ? $exception->getMessage() : 'Error desconocido' }}">
                        <input type="hidden" name="user_agent" value="{{ request()->userAgent() }}">
                        
                        <div>
                            <label class="block text-sm font-medium text-blue-900 mb-1">¿Qué estabas haciendo cuando ocurrió el error? *</label>
                            <textarea name="description" rows="3" required
                                placeholder="Ej: Intentaba crear una nueva deuda en finanzas personales..."
                                class="w-full px-3 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-blue-900 mb-1">Captura de Pantalla (Opcional)</label>
                            <input type="file" name="screenshot" accept="image/*"
                                class="w-full px-3 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-blue-700 mt-1">Formatos permitidos: JPG, PNG (máx. 5MB)</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-blue-900 mb-1">Tu Email (Opcional)</label>
                            <input type="email" name="email" value="{{ auth()->user()?->email ?? '' }}"
                                placeholder="tu@email.com"
                                class="w-full px-3 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-blue-700 mt-1">Para contactarte si necesitamos más información</p>
                        </div>
                        
                        <button type="submit" 
                            class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Enviar Reporte
                        </button>
                    </form>
                    
                    <div id="reportSuccess" class="hidden mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center gap-2 text-green-800">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                            <p class="font-medium">¡Reporte enviado exitosamente! Gracias por tu ayuda.</p>
                        </div>
                    </div>
                </div>

                {{-- Qué hacer --}}
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="lightbulb" class="w-5 h-5"></i>
                        Mientras tanto, puedes:
                    </h2>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i data-lucide="arrow-right" class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5"></i>
                            Intentar nuevamente en unos minutos
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="arrow-right" class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5"></i>
                            Refrescar la página
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="arrow-right" class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5"></i>
                            Volver a la página anterior
                        </li>
                    </ul>
                </div>

                {{-- Botones de Acción --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ url()->previous() }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                        Volver Atrás
                    </a>
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i data-lucide="home" class="w-5 h-5 mr-2"></i>
                        Ir al Inicio
                    </a>
                    <a href="javascript:location.reload()" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i data-lucide="refresh-cw" class="w-5 h-5 mr-2"></i>
                        Refrescar
                    </a>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-8 text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} LINKIU. Todos los derechos reservados.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Manejar envío del formulario de reporte
            const form = document.getElementById('errorReportForm');
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(form);
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Enviando...';
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                    
                    try {
                        const response = await fetch('{{ route('api.error-report') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (response.ok) {
                            document.getElementById('reportSuccess').classList.remove('hidden');
                            form.reset();
                            form.style.display = 'none';
                        } else {
                            alert('Error al enviar el reporte. Por favor, contacta a soporte directamente.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error al enviar el reporte. Por favor, contacta a soporte directamente.');
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
