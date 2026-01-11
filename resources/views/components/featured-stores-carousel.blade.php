@props([
    'stores' => collect([]),
])

@if($stores->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 items-center justify-center">
        <h2 class="text-center text-lg md:text-3xl text-slate-900 font-black tracking-tight mb-12">Tiendas que confían en Linkiu</h2>
        
        <!-- Carrusel de logos -->
        <div class="relative overflow-hidden">
            <!-- Gradient overlays para efecto fade -->
            <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>
            
            <!-- Carrusel infinito -->
            <div class="stores-carousel flex items-center justify-center">
                <div class="stores-carousel-track">
                    <!-- Primera pasada -->
                    @foreach($stores as $store)
                    <a href="{{ $store['url'] }}" target="_blank" class="stores-carousel-item group flex items-center justify-center" title="{{ $store['name'] }}">
                        <div class="w-32 h-16 flex items-center justify-center bg-white rounded-xl border border-gray-200 hover:border-gray-300 hover:shadow-lg transition-all duration-300">
                            <img src="{{ $store['logo_url'] }}" 
                                 alt="{{ $store['name'] }}" 
                                 class="w-full h-full object-cover object-center rounded-xl"
                                 loading="lazy"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden items-center justify-center w-full h-full text-gray-400 text-sm font-medium text-center px-2">
                                {{ $store['name'] }}
                            </div>
                        </div>
                    </a>
                    @endforeach
                    <!-- Segunda pasada (duplicado para efecto infinito) -->
                    @foreach($stores as $store)
                    <a href="{{ $store['url'] }}" target="_blank" class="stores-carousel-item group flex items-center justify-center" title="{{ $store['name'] }}">
                        <div class="w-32 h-16 flex items-center justify-center bg-white rounded-xl border border-gray-200 hover:border-gray-300 hover:shadow-lg transition-all duration-300">
                            <img src="{{ $store['logo_url'] }}" 
                                 alt="{{ $store['name'] }}" 
                                 class="w-full h-full object-cover object-center rounded-xl"
                                 loading="lazy"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden items-center justify-center w-full h-full text-gray-400 text-sm font-medium text-center px-2">
                                {{ $store['name'] }}
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
