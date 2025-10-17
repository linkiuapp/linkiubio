@extends('frontend.layouts.app')

@section('content')
<div class="px-4 py-8">
    <div class="max-w-md mx-auto text-center">
        
        <!-- Ilustración -->
        <div class="mb-6">
            <div class="w-32 h-32 mx-auto bg-gradient-to-br from-warning-100 to-warning-200 rounded-full flex items-center justify-center mb-4">
                <svg class="w-20 h-20 text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-h6 font-bold text-black-400 mb-3">
                ¡Próximamente!
            </h1>
            
            <p class="text-body-regular text-black-300 mb-6">
                Estamos trabajando en esta función increíble.<br>
                Pronto podrás hacer reservas directamente desde aquí.
            </p>
        </div>

        <!-- Features que vienen -->
        <div class="bg-accent-50 rounded-xl p-6 mb-6 text-left">
            <h3 class="text-sm font-bold text-black-400 mb-4">Lo que podrás hacer:</h3>
            <ul class="space-y-3">
                <li class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-success-300 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-black-400 font-medium">Reservar mesas</p>
                        <p class="text-xs text-black-300">Selecciona fecha, hora y número de personas</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-success-300 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-black-400 font-medium">Confirmar tu asistencia</p>
                        <p class="text-xs text-black-300">Recibe notificaciones y recordatorios</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-success-300 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-black-400 font-medium">Solicitudes especiales</p>
                        <p class="text-xs text-black-300">Agrega notas y preferencias</p>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Notificarme cuando esté lista -->
        <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-xl p-6 mb-6">
            <h3 class="text-sm font-bold text-black-400 mb-3">¿Quieres que te avisemos?</h3>
            <p class="text-xs text-black-300 mb-4">
                Déjanos tu email y te notificaremos cuando esta función esté disponible
            </p>
            <form class="flex gap-2">
                <input type="email" 
                       placeholder="tu@email.com" 
                       class="flex-1 px-3 py-2 border border-accent-200 rounded-lg text-sm focus:border-primary-300 focus:ring-1 focus:ring-primary-300 focus:outline-none">
                <button type="submit" 
                        class="bg-primary-300 hover:bg-primary-400 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Notificarme
                </button>
            </form>
        </div>

        <!-- Botón volver -->
        <a href="{{ route('tenant.home', $store->slug) }}" 
           class="inline-flex items-center gap-2 text-info-300 hover:text-info-400 font-medium text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al inicio
        </a>
    </div>
</div>
@endsection

