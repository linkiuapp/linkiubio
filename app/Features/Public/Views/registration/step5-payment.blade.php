<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Validando Pago - Linkiu</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-100 to-indigo-100">
    
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-2xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden" x-data="paymentValidation()">
            
            {{-- Header con Logo --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i data-lucide="check-circle" class="w-10 h-10 text-blue-600"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">¡Registro Casi Completo!</h1>
                <p class="text-gray-900">Estamos validando tu comprobante de pago</p>
            </div>

            {{-- Progress Area --}}
            <div class="p-8">
                {{-- Barra de Progreso Animada --}}
                <div class="mb-8">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Validando...</span>
                        <span x-text="progress + '%'">0%</span>
                    </div>
                    <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 transition-all duration-500 ease-out rounded-full"
                             :style="`width: ${progress}%`"></div>
                    </div>
                </div>

                {{-- Tiempo Transcurrido --}}
                <div class="text-center mb-8">
                    <p class="text-sm text-gray-600 mb-1">Tiempo transcurrido</p>
                    <div class="text-4xl font-bold text-gray-900">
                        <span x-text="formatTime()">0:00</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Validación típica: 5-15 minutos</p>
                </div>

                {{-- Pasos de Validación --}}
                <div class="space-y-4 mb-8">
                    <div class="flex items-center gap-4 p-4 rounded-xl transition-all"
                         :class="currentStep >= 1 ? 'bg-green-50 border-2 border-green-500' : 'bg-gray-50 border-2 border-gray-200'">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                             :class="currentStep >= 1 ? 'bg-green-500' : 'bg-gray-300'">
                            <i data-lucide="check" class="w-5 h-5 text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Comprobante recibido</p>
                            <p class="text-sm text-gray-600">Archivo guardado correctamente</p>
                        </div>
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-500" x-show="currentStep >= 1"></i>
                    </div>

                    <div class="flex items-center gap-4 p-4 rounded-xl transition-all"
                         :class="currentStep >= 2 ? 'bg-blue-50 border-2 border-blue-500' : 'bg-gray-50 border-2 border-gray-200'">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                             :class="currentStep >= 2 ? 'bg-blue-500' : 'bg-gray-300'">
                            <i :data-lucide="currentStep >= 2 ? 'zap' : 'clock'" class="w-5 h-5 text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Validando información</p>
                            <p class="text-sm text-gray-600">Analizando datos del registro</p>
                        </div>
                        <div x-show="currentStep === 2" class="flex gap-1">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                        <i data-lucide="check-circle" class="w-6 h-6 text-blue-500" x-show="currentStep > 2"></i>
                    </div>

                    <div class="flex items-center gap-4 p-4 rounded-xl transition-all"
                         :class="currentStep >= 3 ? 'bg-purple-50 border-2 border-purple-500' : 'bg-gray-50 border-2 border-gray-200'">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                             :class="currentStep >= 3 ? 'bg-purple-500' : 'bg-gray-300'">
                            <i :data-lucide="currentStep >= 3 ? 'sparkles' : 'clock'" class="w-5 h-5 text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Revisión del equipo</p>
                            <p class="text-sm text-gray-600">Nuestro equipo verificará tu pago</p>
                        </div>
                        <div x-show="currentStep === 3" class="flex gap-1">
                            <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                        <i data-lucide="check-circle" class="w-6 h-6 text-purple-500" x-show="currentStep > 3"></i>
                    </div>

                    <div class="flex items-center gap-4 p-4 rounded-xl transition-all"
                         :class="currentStep >= 4 ? 'bg-green-50 border-2 border-green-500' : 'bg-gray-50 border-2 border-gray-200'">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                             :class="currentStep >= 4 ? 'bg-green-500' : 'bg-gray-300'">
                            <i :data-lucide="currentStep >= 4 ? 'rocket' : 'clock'" class="w-5 h-5 text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Activando tu tienda</p>
                            <p class="text-sm text-gray-600">Preparando todo para ti</p>
                        </div>
                        <div x-show="currentStep === 4" class="flex gap-1">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-500" x-show="currentStep > 4"></i>
                    </div>
                </div>

                {{-- Info Email --}}
                <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6 text-center">
                    <i data-lucide="mail" class="w-8 h-8 text-blue-600 mx-auto mb-3"></i>
                    <p class="text-sm text-gray-700 mb-2">
                        <strong>Puedes cerrar esta ventana si quieres</strong>
                    </p>
                    <p class="text-sm text-gray-600">
                        Te enviaremos un email a <strong class="text-gray-900">{{ $registration->owner_email }}</strong> cuando tu tienda esté lista
                    </p>
                </div>

                {{-- Estado de Aprobación --}}
                <div x-show="status === 'approved'" x-cloak class="mt-6">
                    <div class="bg-green-50 border-2 border-green-500 rounded-xl p-6 text-center">
                        <i data-lucide="party-popper" class="w-12 h-12 text-green-600 mx-auto mb-3"></i>
                        <h3 class="text-xl font-bold text-green-900 mb-2">¡Pago Aprobado!</h3>
                        <p class="text-gray-700 mb-4">Redirigiendo a tu tienda...</p>
                    </div>
                </div>

                <div x-show="status === 'rejected'" x-cloak class="mt-6">
                    <div class="bg-red-50 border-2 border-red-500 rounded-xl p-6 text-center">
                        <i data-lucide="x-circle" class="w-12 h-12 text-red-600 mx-auto mb-3"></i>
                        <h3 class="text-xl font-bold text-red-900 mb-2">Pago No Aprobado</h3>
                        <p class="text-gray-700" x-text="rejectionReason">Hubo un problema con el comprobante</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('paymentValidation', () => ({
            progress: 0,
            currentStep: 1,
            elapsedSeconds: 0,
            status: 'pending', // pending, approved, rejected
            rejectionReason: '',
            pollingInterval: null,
            registrationId: {{ $registration->id }},
            
            init() {
                // Simular progreso inicial
                this.simulateProgress();
                
                // Contador de tiempo
                setInterval(() => {
                    this.elapsedSeconds++;
                }, 1000);
                
                // Polling cada 10 segundos
                this.startPolling();
                
                // Reiniciar iconos
                this.$nextTick(() => {
                    if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
                });
            },
            
            simulateProgress() {
                // Paso 1: Inmediato
                setTimeout(() => {
                    this.progress = 25;
                    this.currentStep = 2;
                    this.refreshIcons();
                }, 1000);
                
                // Paso 2: A los 30 segundos
                setTimeout(() => {
                    this.progress = 50;
                    this.currentStep = 3;
                    this.refreshIcons();
                }, 30000);
            },
            
            startPolling() {
                this.pollingInterval = setInterval(async () => {
                    await this.checkStatus();
                }, 10000); // Cada 10 segundos
            },
            
            async checkStatus() {
                if (!this.registrationId) return;
                
                try {
                    const response = await fetch(`/api/check-registration-status/${this.registrationId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.status === 'approved') {
                        this.progress = 100;
                        this.currentStep = 4;
                        this.status = 'approved';
                        clearInterval(this.pollingInterval);
                        this.refreshIcons();
                        
                        // Redirigir a vista de éxito
                        setTimeout(() => {
                            window.location.href = '{{ route('register.success', $registration->id) }}';
                        }, 1000);
                    } else if (data.status === 'rejected') {
                        this.status = 'rejected';
                        this.rejectionReason = data.reason || 'El comprobante no pudo ser validado';
                        clearInterval(this.pollingInterval);
                        this.refreshIcons();
                        
                        // Redirigir a vista de rechazo
                        setTimeout(() => {
                            window.location.href = '{{ route('register.rejected', $registration->id) }}';
                        }, 2000);
                    }
                } catch (error) {
                    console.error('Error checking status:', error);
                }
            },
            
            formatTime() {
                const minutes = Math.floor(this.elapsedSeconds / 60);
                const seconds = this.elapsedSeconds % 60;
                return `${minutes}:${seconds.toString().padStart(2, '0')}`;
            },
            
            refreshIcons() {
                this.$nextTick(() => {
                    if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
                });
            }
        }));
    });

    // Inicializar iconos Lucide
    document.addEventListener('DOMContentLoaded', function() {
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
    });
    </script>
    
    <style>
    [x-cloak] { display: none !important; }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-bounce {
        animation: bounce 1s infinite;
    }
    </style>
</body>
</html>

