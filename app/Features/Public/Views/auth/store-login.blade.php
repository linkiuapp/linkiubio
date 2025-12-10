<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acceder a tu Tienda - Linkiu</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Accede a tu Tienda</h2>
                <p class="text-gray-600">Ingresa el nombre de tu tienda para iniciar sesión</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form x-data="{ storeSlug: '', loading: false }" 
                      @submit.prevent="if(storeSlug.trim()) { loading = true; window.location.href = '/' + storeSlug.trim() + '/admin/login'; }">
                    <div class="mb-6">
                        <label for="store-slug" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre de tu tienda
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-sm">linkiu.bio/</span>
                            </div>
                            <input 
                                type="text" 
                                id="store-slug"
                                x-model="storeSlug"
                                placeholder="mi-tienda"
                                class="block w-full pl-28 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                required
                                autofocus
                                pattern="[a-z0-9-]+"
                                title="Solo letras minúsculas, números y guiones"
                            >
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Ejemplo: si tu tienda es "linkiu.bio/mi-tienda", ingresa "mi-tienda"
                        </p>
                    </div>

                    <button 
                        type="submit"
                        :disabled="!storeSlug.trim() || loading"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <span x-show="!loading">Continuar</span>
                        <span x-show="loading" class="inline-flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Redirigiendo...
                        </span>
                        <i data-lucide="arrow-right" class="w-5 h-5" x-show="!loading"></i>
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <a href="{{ route('register.step1') }}" 
                       class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        ¿No tienes cuenta? Regístrate aquí
                    </a>
                </div>
            </div>

            <div class="text-center">
                <a href="/" class="text-sm text-gray-500 hover:text-gray-700">
                    ← Volver al inicio
                </a>
            </div>
        </div>
    </div>

    <script>
        // Inicializar iconos Lucide
        document.addEventListener('DOMContentLoaded', function() {
            if (window.createIcons && window.lucideIcons) {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
</body>
</html>

