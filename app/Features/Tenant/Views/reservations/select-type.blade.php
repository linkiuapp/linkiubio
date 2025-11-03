@extends('frontend.layouts.app')

@push('meta')
    <meta name="description" content="Selecciona el tipo de reserva en {{ $store->name }}">
    <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')
<div class="px-4 py-6 sm:py-8">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-brandPrimary-50 rounded-full mb-4">
                <i data-lucide="calendar-heart" class="w-8 h-8 text-brandPrimary-300"></i>
            </div>
            <h1 class="h1 text-brandNeutral-400 mb-2">Reservas</h1>
            <p class="caption text-brandNeutral-400">Selecciona el tipo de reserva que deseas realizar</p>
        </div>

        <!-- Opciones -->
        <div class="space-y-4">
            @if(featureEnabled($store, 'reservas_mesas'))
                <a href="{{ route('tenant.reservations.index', $store->slug) }}" 
                   class="block bg-brandWhite-50 rounded-lg p-6 border border-brandWhite-300 hover:border-brandPrimary-300 hover:bg-brandPrimary-50 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-brandPrimary-50 rounded-full flex items-center justify-center flex-shrink-0">
                            <i data-lucide="utensils" class="w-8 h-8 text-brandPrimary-300"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="caption-strong text-brandNeutral-400 mb-1">Reserva de Mesa</h3>
                            <p class="caption text-brandNeutral-300">Reserva una mesa en nuestro restaurante</p>
                        </div>
                        <i data-lucide="arrow-right" class="w-6 h-6 text-brandNeutral-400"></i>
                    </div>
                </a>
            @endif

            @if(featureEnabled($store, 'reservas_hotel'))
                <a href="{{ route('tenant.hotel-reservations.index', $store->slug) }}" 
                   class="block bg-brandWhite-50 rounded-lg p-6 border border-brandWhite-300 hover:border-brandPrimary-300 hover:bg-brandPrimary-50 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-brandPrimary-50 rounded-full flex items-center justify-center flex-shrink-0">
                            <i data-lucide="bed" class="w-8 h-8 text-brandPrimary-300"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="caption-strong text-brandNeutral-400 mb-1">Reserva de Hotel</h3>
                            <p class="caption text-brandNeutral-300">Reserva una habitación para tu estadía</p>
                        </div>
                        <i data-lucide="arrow-right" class="w-6 h-6 text-brandNeutral-400"></i>
                    </div>
                </a>
            @endif
        </div>
    </div>
</div>
@endsection

