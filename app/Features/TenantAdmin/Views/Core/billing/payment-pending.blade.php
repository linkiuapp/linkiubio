@extends('shared::layouts.tenant-admin')

@section('title', 'Pago en Proceso')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full text-center">
        {{-- Icono de pendiente --}}
        <div class="mx-auto w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mb-6">
            <i data-lucide="clock" class="w-12 h-12 text-amber-600"></i>
        </div>

        {{-- Título --}}
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Pago en Proceso</h1>
        <p class="text-gray-600 mb-8">Tu pago está siendo verificado. Te notificaremos cuando sea confirmado.</p>

        {{-- Info --}}
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8 text-left">
            <h3 class="text-sm font-semibold text-amber-900 mb-3 flex items-center gap-2">
                <i data-lucide="info" class="w-4 h-4"></i>
                ¿Qué sucede ahora?
            </h3>
            <ul class="space-y-2 text-sm text-amber-800">
                <li class="flex items-start gap-2">
                    <i data-lucide="check" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    <span>Tu pago ha sido recibido y está siendo procesado</span>
                </li>
                <li class="flex items-start gap-2">
                    <i data-lucide="check" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    <span>La verificación puede tomar entre 1-24 horas</span>
                </li>
                <li class="flex items-start gap-2">
                    <i data-lucide="check" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    <span>Te enviaremos un correo cuando sea confirmado</span>
                </li>
            </ul>
        </div>

        {{-- Estado de suscripción actual --}}
        @if($subscription)
        <div class="bg-gray-50 rounded-xl p-4 mb-8 text-left">
            <p class="text-sm text-gray-600">
                <span class="font-medium">Estado actual:</span> 
                Tu tienda continúa funcionando mientras verificamos el pago.
            </p>
        </div>
        @endif

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('tenant.admin.billing.index', $store->slug) }}" 
               class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                Ver Estado del Pago
            </a>
            <a href="{{ route('tenant.admin.dashboard', $store->slug) }}" 
               class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition-colors">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                Ir al Panel
            </a>
        </div>

        {{-- Soporte --}}
        <p class="mt-8 text-sm text-gray-500">
            ¿Tienes dudas? 
            <a href="https://wa.me/573104594344" target="_blank" class="text-blue-600 hover:underline">
                Contáctanos por WhatsApp
            </a>
        </p>
    </div>
</div>
@endsection
