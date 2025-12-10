<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Registro Completado! - Linkiu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-shadow {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="max-w-3xl w-full">
        {{-- Header con Logo --}}
        <div class="text-center mb-8">
            <div class="inline-block bg-white rounded-full p-4 mb-4 card-shadow">
                <i data-lucide="check-circle" class="w-16 h-16 text-green-500"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">¡Registro Completado con Éxito!</h1>
            <p class="text-white text-opacity-90 text-lg">Tu pago ha sido verificado y tu tienda está lista para comenzar</p>
        </div>

        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
            {{-- Credenciales --}}
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i data-lucide="key" class="w-5 h-5 text-blue-600"></i>
                    Tus Credenciales de Acceso
                </h2>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border-2 border-blue-200 space-y-3">
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Email</label>
                        <div class="flex items-center gap-2">
                            <input type="text" 
                                   value="{{ $registration->owner_email }}" 
                                   readonly
                                   class="flex-1 px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg text-gray-900 font-medium">
                            <button onclick="copyToClipboard('{{ $registration->owner_email }}', 'email')"
                                    class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                                    title="Copiar email">
                                <i data-lucide="copy" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                    <div x-data="{ showPassword: false }">
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Contraseña</label>
                        <div class="flex items-center gap-2">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   value="{{ $temporaryPassword }}" 
                                   readonly
                                   id="password-field"
                                   class="flex-1 px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg text-gray-900 font-medium">
                            <button @click="showPassword = !showPassword"
                                    type="button"
                                    class="p-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors"
                                    title="Ver/Ocultar contraseña">
                                <i :data-lucide="showPassword ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                            </button>
                            <button onclick="copyToClipboard('{{ $temporaryPassword }}', 'password')"
                                    class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                                    title="Copiar contraseña">
                                <i data-lucide="copy" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Info de la tienda (compacto) --}}
                <div class="mt-4 grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <span class="text-gray-600">Tienda:</span>
                        <span class="font-semibold text-gray-900">{{ $store->name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Plan:</span>
                        <span class="font-semibold text-gray-900">{{ $subscription->plan->name }} - {{ $subscription->billing_cycle_label }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-600">Válido hasta:</span>
                        <span class="font-semibold text-gray-900">{{ $subscription->current_period_end->format('d M Y') }}</span>
                    </div>
                </div>

                {{-- Alert de seguridad --}}
                <div class="flex items-start gap-2 p-3 bg-amber-50 border border-amber-200 rounded-lg mt-4">
                    <i data-lucide="shield-alert" class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5"></i>
                    <p class="text-xs text-amber-800">
                        Guarda tus credenciales. Te recomendamos cambiar tu contraseña después del primer inicio de sesión.
                    </p>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="p-6 bg-gradient-to-r from-gray-50 to-blue-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-3 mb-4">
                    <a href="{{ route('tenant.admin.dashboard', $store->slug) }}"
                       class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold text-center transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        Ir a mi Panel
                    </a>
                    <a href="{{ url('/' . $store->slug) }}"
                       target="_blank"
                       class="flex-1 px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-800 rounded-xl font-bold text-center transition-all flex items-center justify-center gap-2">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        Ver mi Tienda
                    </a>
                </div>
                
                {{-- Próximos pasos compactos --}}
                <div class="text-xs text-gray-600 text-center">
                    <i data-lucide="rocket" class="w-4 h-4 inline mr-1"></i>
                    <span class="font-medium">Próximos pasos:</span> Personaliza diseño • Agrega productos • Configura pagos • ¡Vende!
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-6">
            <p class="text-white text-opacity-80 text-sm">
                ¿Necesitas ayuda? 
                <a href="https://wa.me/573104594344" class="font-bold underline hover:text-white">WhatsApp: +57 310 459 4344</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Confetti al cargar
        window.addEventListener('load', function() {
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });
            
            setTimeout(() => {
                confetti({
                    particleCount: 50,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0 }
                });
            }, 200);
            
            setTimeout(() => {
                confetti({
                    particleCount: 50,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1 }
                });
            }, 400);
        });

        // Copiar al portapapeles
        function copyToClipboard(text, type) {
            navigator.clipboard.writeText(text).then(() => {
                const message = type === 'email' ? 'Email copiado' : 'Contraseña copiada';
                showToast(message);
            });
        }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-8 right-8 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 z-50';
            toast.innerHTML = `
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>${message}</span>
            `;
            document.body.appendChild(toast);
            lucide.createIcons();
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }

        // Inicializar iconos Lucide
        lucide.createIcons();
        
        // Re-inicializar iconos cuando Alpine cambie el DOM
        document.addEventListener('alpine:initialized', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>

