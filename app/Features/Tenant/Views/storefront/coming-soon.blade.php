@extends('frontend.layouts.app')

@section('content')
<div class="px-4 py-8">
    <div class="max-w-md mx-auto text-center">
        
        <!-- Ilustración -->
        <div class="mb-6 text-center flex flex-col items-center justify-center">
            <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_proximamente.svg" alt="img_linkiu_v1_proximamente" class="h-48 w-auto" loading="lazy">
            <h3 class="h1 text-brandNeutral-400 mt-4">¡Próximamente!</h3>
            <p class="caption text-brandNeutral-300 mt-2">Estamos trabajando en esta función increíble.<br>
                Pronto podrás hacer reservas directamente desde aquí.</p>
        </div>

        <!-- Features que vienen -->
        <div class="bg-brandWhite-100 rounded-xl p-6 mb-6 text-left">
            <h3 class="caption text-brandNeutral-400 mb-4">Lo que podrás hacer:</h3>
            <ul class="space-y-3">
                <li class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-brandSuccess-300 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-brandWhite-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="caption text-brandNeutral-400">Reservar mesas</p>
                        <p class="caption text-brandNeutral-300">Selecciona fecha, hora y número de personas</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-brandSuccess-300 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-brandWhite-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="caption text-brandNeutral-400">Confirmar tu asistencia</p>
                        <p class="caption text-brandNeutral-300">Recibe notificaciones y recordatorios</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-brandSuccess-300 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-brandWhite-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="caption text-brandNeutral-400">Solicitudes especiales</p>
                        <p class="caption text-brandNeutral-300">Agrega notas y preferencias</p>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Notificarme cuando esté lista -->
        <div class="bg-gradient-to-r from-brandPrimary-100 to-brandSecondary-100 rounded-xl p-6 mb-6">
            <h3 class="caption text-brandWhite-50 mb-3">¿Quieres que te avisemos?</h3>
            <p class="caption text-brandWhite-50 mb-4">
                Déjanos tu email y te notificaremos cuando esta función esté disponible
            </p>
            <form class="flex gap-2">
                <input type="email" 
                       placeholder="tu@email.com" 
                       class="flex-1 px-3 py-2 border border-brandPrimary-300 rounded-lg caption focus:border-brandPrimary-300 focus:ring-1 focus:ring-brandPrimary-300 focus:outline-none">
                <button type="submit" 
                        class="bg-brandPrimary-300 hover:bg-brandPrimary-400 text-brandWhite-50 px-4 py-2 rounded-lg caption transition-colors">
                    Notificarme
                </button>
            </form>
        </div>

        <!-- Botón volver -->
        <a href="{{ route('tenant.home', $store->slug) }}" 
            class="inline-flex items-center gap-2 text-brandPrimary-300 hover:text-brandPrimary-400 caption">
            <i data-lucide="arrow-left" class="w-4 h-4 text-brandPrimary-300"></i>
            Volver al inicio
            </a>
        </div>
    </div>
@endsection
