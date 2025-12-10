<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperLinkiu - Iniciar Sesión</title>
    
    <!-- Meta tags -->
    <meta name="description" content="Panel de administración SuperLinkiu">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        #particles-js {
            position: fixed !important;
            width: 100vw !important;
            height: 100vh !important;
            min-height: 100vh !important;
            top: 0 !important;
            left: 0 !important;
            z-index: 999 !important;
            pointer-events: none !important;
            background: transparent !important;
        }
        
        #particles-js canvas {
            display: block !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
        }
        
        body {
            position: relative;
        }
        
        .min-h-screen {
            position: relative;
            z-index: 2;
            background: transparent;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Contenedor de partículas para nieve -->
    <div id="particles-js"></div>
    
    <div class="min-h-screen flex" style="position: relative; z-index: 2;">
        <!-- Lado izquierdo: Background atractivo -->
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
                
                <!-- Header del formulario -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">
                        Bienvenido Crack de Linkiu
                    </h2>
                    <p class="text-gray-600">
                        Gracias por ser parte de la familia Linkiu
                    </p>
                </div>
                
                <!-- Alertas de error -->
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-red-800 mb-2">Errores de validación:</p>
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
                <form method="POST" action="{{ route('superlinkiu.login.submit') }}" class="space-y-6">
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
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('password') border-red-500 @enderror"
                                   placeholder="••••••••"
                                   required>
                            <button type="button" 
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i data-lucide="eye" id="eye-icon" class="w-5 h-5 text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Remember me -->
                    <div class="flex items-center">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Recordarme</span>
                        </label>
                    </div>
                    
                    <!-- Submit button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i data-lucide="log-in" class="w-5 h-5"></i>
                        Iniciar Sesión
                    </button>
                </form>
                
                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500">
                        ¿Problemas para acceder?
                        <a href="https://wa.me/573104594344" class="text-indigo-600 hover:text-indigo-700 font-medium" target="_blank">
                            Contacta soporte
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Animaciones CSS -->
    <style>
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(20px, -50px) scale(1.1);
            }
            50% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            75% {
                transform: translate(50px, 50px) scale(1.05);
            }
        }
        
        .animate-blob {
            animation: blob 20s infinite;
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
    
    <!-- Scripts -->
    <script>
        // Inicializar iconos Lucide
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Auto-focus en el primer campo
            const emailInput = document.getElementById('email');
            if (emailInput && !emailInput.value) {
                emailInput.focus();
            }
            
            // Mostrar toast de éxito si existe
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            @endif
            
        });
        
        // Toggle para mostrar/ocultar contraseña
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            
            // Reinicializar iconos
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
    </script>
    
    <!-- Particles.js para animación de nieve - Cargar al final -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Función para inicializar partículas
        function initSnow() {
            const container = document.getElementById('particles-js');
            
            if (typeof particlesJS !== 'undefined' && container) {
                particlesJS('particles-js', {
                    particles: {
                        number: {
                            value: 80,
                            density: {
                                enable: true,
                                value_area: 900
                            }
                        },
                        color: {
                            value: '#ffffff'
                        },
                        shape: {
                            type: 'circle'
                        },
                        opacity: {
                            value: 1,
                            random: true,
                            anim: {
                                enable: true,
                                speed: 1,
                                opacity_min: 0.5,
                                sync: false
                            }
                        },
                        size: {
                            value: 5,
                            random: true,
                            anim: {
                                enable: true,
                                speed: 2,
                                size_min: 2,
                                sync: false
                            }
                        },
                        line_linked: {
                            enable: false
                        },
                        move: {
                            enable: true,
                            speed: 2,
                            direction: 'bottom',
                            random: true,
                            straight: false,
                            out_mode: 'out',
                            bounce: false
                        }
                    },
                    interactivity: {
                        detect_on: 'canvas',
                        events: {
                            onhover: {
                                enable: false
                            },
                            onclick: {
                                enable: false
                            },
                            resize: true
                        }
                    },
                    retina_detect: true
                });
            } else {
                setTimeout(initSnow, 300);
            }
        }
        
        // Múltiples intentos de inicialización
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initSnow, 200);
            });
        } else {
            setTimeout(initSnow, 200);
        }
        
        window.addEventListener('load', function() {
            setTimeout(initSnow, 300);
        });
    </script>
</body>
</html>
