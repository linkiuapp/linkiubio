@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <!-- Header con Breadcrumb -->
    <div class="space-y-3">
        <nav class="flex caption text-brandInfo-300">
            <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-brandInfo-400 transition-colors">Inicio</a>
            <span class="mx-2">/</span>
            <span class="text-brandNeutral-400 caption">Favoritos</span>
        </nav>
        
        <div class="flex items-center justify-between gap-4">
            <div class="space-y-1">
                <h1 class="h3 text-brandNeutral-400">Mis Favoritos</h1>
                <p class="caption text-brandNeutral-400">
                    <span id="favorites-count">0</span> productos guardados
                </p>
            </div>
        </div>
    </div>

        {{-- Estado: Sin favoritos --}}
    <div id="empty-favorites-state" class="hidden">
        <div class="flex flex-col items-center justify-center py-16 space-y-4">
            <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_ghost.svg" 
                 alt="Sin favoritos" 
                 class="h-32 w-auto" 
                 loading="lazy">
            <div class="text-center space-y-2">
                <h3 class="h3 text-brandNeutral-400">Aún no tienes favoritos</h3>
                <p class="caption text-brandNeutral-400 max-w-md mx-auto">
                    Explora nuestro catálogo y guarda tus productos preferidos para encontrarlos fácilmente
                </p>
            </div>
            <a href="{{ route('tenant.catalog', $store->slug) }}" 
               class="bg-brandPrimary-300 hover:bg-brandPrimary-400 text-brandWhite-50 px-6 py-3 rounded-lg caption transition-colors">
                Explorar Catálogo
            </a>
        </div>
    </div>

    {{-- Grid de productos favoritos --}}
    <div id="favorites-grid" class="hidden space-y-4">
        {{-- Acciones rápidas --}}
        <div class="flex items-center justify-between gap-4 p-3 bg-brandWhite-100 rounded-lg">
            <div class="flex items-center gap-2">
                <i data-lucide="heart" class="w-16px h-16px text-brandError-400"></i>
                <span class="caption-strong text-brandNeutral-400">Tus productos guardados</span>
            </div>
            <button id="clear-all-favorites-btn" 
                    class="caption text-brandError-400 hover:text-brandError-500 transition-colors">
                Limpiar todos
            </button>
        </div>

        {{-- Lista de productos --}}
        <div id="favorites-products-grid" class="space-y-4">
            {{-- Los productos se cargarán dinámicamente con JavaScript --}}
        </div>
    </div>

    {{-- Loading state --}}
    <div id="loading-favorites" class="flex flex-col items-center justify-center py-16">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brandPrimary-300"></div>
        <p class="caption text-brandNeutral-400 mt-4">Cargando favoritos...</p>
    </div>
</div>

    @push('scripts')
    <script>
        // Cargar favoritos al iniciar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Esperar a que loadFavoritesPage esté disponible
            const checkAndLoad = () => {
                if (typeof window.loadFavoritesPage === 'function') {
                    window.loadFavoritesPage('{{ $store->slug }}');
                } else {
                    // Reintentar después de un breve delay
                    setTimeout(checkAndLoad, 100);
                }
            };
            checkAndLoad();
        });
    </script>
    @endpush
@endsection

