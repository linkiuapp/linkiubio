@extends('frontend.layouts.app')

@section('content')
<div class="px-4 py-4 sm:py-6">
    <div class="max-w-md mx-auto text-center">
        <div class="bg-brandWhite-50 rounded-lg p-6 border border-brandWhite-300">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-brandWarning-50 rounded-full mb-4">
                <i data-lucide="alert-circle" class="w-8 h-8 text-brandWarning-300"></i>
            </div>
            
            <h1 class="h1 text-brandNeutral-400 mb-2">
                Servicio No Disponible
            </h1>
            
            <p class="caption text-brandNeutral-400 mb-6">
                El servicio de pedidos desde {{ $table->type === 'mesa' ? 'mesa' : 'habitación' }} no está activo en este momento.
            </p>
            
            <a 
                href="{{ route('tenant.catalog', $store->slug) }}" 
                class="inline-block bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 py-3 px-6 rounded-full caption-strong transition-colors"
            >
                Ver Catálogo
            </a>
        </div>
    </div>
</div>
@endsection

