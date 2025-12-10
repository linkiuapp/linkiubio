<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - {{ $store->name }}</title>
    
    <meta name="description" content="Recuperar contraseña para {{ $store->name }}">
    <meta name="robots" content="noindex, nofollow">
    
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="antialiased">
    <div class="min-h-screen flex">
        <!-- Lado izquierdo: Background con imagen SVG -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-200">
            <div class="absolute inset-0">
                <img src="{{ asset('images-ui/banner_navidad_logens.webp') }}" 
                     alt="Banner de información" 
                     class="w-full h-full object-contain items-center justify-center">
            </div>
        </div>
        
        <!-- Lado derecho: Formulario -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <!-- Logo móvil -->
                <div class="mb-8 text-start">
                    <img src="{{ asset('images-ui/base_ui_login_logo.svg') }}" 
                    alt="Logo de Linkiu" 
                    class="h-12 w-auto mb-4">
                </div>
                
                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">
                        Recuperar Contraseña
                    </h2>
                    <p class="text-gray-600">
                        Ingresa tu correo electrónico y te enviaremos un código de verificación por WhatsApp
                    </p>
                </div>
                
                <!-- Alertas -->
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                            <div class="flex-1">
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Formulario -->
                <form method="POST" action="{{ route('tenant.admin.password.send-code', $store->slug) }}" class="space-y-6">
                    @csrf
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                            </div>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('email') border-red-500 @enderror"
                                   placeholder="correo@ejemplo.com"
                                   required
                                   autofocus>
                        </div>
                    </div>
                    
                    <!-- Submit button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i data-lucide="send" class="w-5 h-5"></i>
                        Enviar Código
                    </button>
                </form>
                
                <!-- Volver al login -->
                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <a href="{{ route('tenant.admin.login', $store->slug) }}" 
                       class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Volver al inicio de sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>

