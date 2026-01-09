@extends('shared::layouts.tenant-admin')

@section('title', 'Pago No Procesado')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full text-center">
        {{-- Icono de error --}}
        <div class="mx-auto w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-6">
            <i data-lucide="x-circle" class="w-12 h-12 text-red-600"></i>
        </div>

        {{-- Título --}}
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Pago No Procesado</h1>
        <p class="text-gray-600 mb-8">{{ $errorMessage }}</p>

        {{-- Motivos comunes --}}
        <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-8 text-left">
            <h3 class="text-sm font-semibold text-red-900 mb-3 flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                Posibles motivos
            </h3>
            <ul class="space-y-2 text-sm text-red-800">
                <li class="flex items-start gap-2">
                    <span class="w-1 h-1 bg-red-500 rounded-full mt-2 shrink-0"></span>
                    <span>Fondos insuficientes en la cuenta</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-1 h-1 bg-red-500 rounded-full mt-2 shrink-0"></span>
                    <span>Tarjeta vencida o bloqueada</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-1 h-1 bg-red-500 rounded-full mt-2 shrink-0"></span>
                    <span>Límite de transacciones excedido</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-1 h-1 bg-red-500 rounded-full mt-2 shrink-0"></span>
                    <span>Error de conexión con el banco</span>
                </li>
            </ul>
        </div>

        {{-- Sugerencia --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
            <p class="text-sm text-blue-800 flex items-center justify-center gap-2">
                <i data-lucide="lightbulb" class="w-4 h-4"></i>
                Puedes intentar con otro método de pago o transferencia bancaria.
            </p>
        </div>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('tenant.admin.billing.checkout', $store->slug) }}" 
               class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                Intentar de Nuevo
            </a>
            <a href="{{ route('tenant.admin.billing.index', $store->slug) }}" 
               class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Volver
            </a>
        </div>

        {{-- Soporte --}}
        <p class="mt-8 text-sm text-gray-500">
            ¿Necesitas ayuda? 
            <a href="https://wa.me/573104594344" target="_blank" class="text-blue-600 hover:underline">
                Contáctanos por WhatsApp
            </a>
        </p>
    </div>
</div>
@endsection
