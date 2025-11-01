@extends('frontend.layouts.app')

@section('content')
    <div class="p-4 space-y-6">
        <!-- Header -->
        <div class="space-y-3">
            <!-- Breadcrumbs -->
            <nav class="flex caption text-brandInfo-300">
                <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-brandInfo-400 transition-colors">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-brandNeutral-400 caption">Sedes</span>
            </nav>
            
            <!-- Title -->
            <div class="space-y-2">
                <h2 class="h3 text-brandNeutral-400">Nuestras Sedes</h2>
                <p class="caption text-brandNeutral-400">Encuentra la sede más cercana a ti</p>
            </div>
        </div>

        @if($locations->count() > 0)
            <!-- Lista de sedes -->
            <div class="space-y-4">
                @foreach($locations as $location)
                    <div class="bg-brandWhite-100 rounded-xl border border-brandWhite-400 overflow-hidden" x-data="{ showSchedule: false }">
                        <!-- Header de la sede -->
                        <div class="p-4 pb-3">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="body-lg-bold text-brandNeutral-400">{{ $location->name }}</h3>
                                        @if($location->is_main)
                                            <span class="bg-brandPrimary-300 text-brandWhite-100 caption px-2 py-1 rounded-full">Principal</span>
                                        @endif
                                    </div>
                                    
                                    @if($location->description)
                                        <p class="caption text-brandNeutral-400 mb-2">{{ $location->description }}</p>
                                    @endif
                                    
                                    <!-- Estado actual con badge -->
                                    <div class="flex items-center gap-2">
                                        @if($location->currentStatus['status'] === 'open')
                                            <span class="bg-brandSuccess-300 text-brandSuccess-50 caption px-3 py-1 rounded-full flex items-center gap-1">
                                                <div class="w-1.5 h-1.5 bg-brandSuccess-50 rounded-full"></div>
                                                {{ $location->currentStatus['text'] }}
                                            </span>
                                        @elseif($location->currentStatus['status'] === 'closed')
                                            <span class="bg-brandError-300 text-brandError-50 caption px-3 py-1 rounded-full flex items-center gap-1">
                                                <div class="w-1.5 h-1.5 bg-brandError-50 rounded-full"></div>
                                                {{ $location->currentStatus['text'] }}
                                            </span>
                                        @else
                                            <span class="bg-brandWarning-300 text-brandWarning-50 caption px-3 py-1 rounded-full flex items-center gap-1">
                                                <div class="w-1.5 h-1.5 bg-brandWarning-50 rounded-full"></div>
                                                {{ $location->currentStatus['text'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de contacto y ubicación -->
                        <div class="px-4 pb-4 space-y-3">
                            <!-- Ubicación -->
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 mt-0.5 flex-shrink-0">
                                    <i data-lucide="map-pin" class="w-full h-full text-brandNeutral-400"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="body-lg-bold text-brandNeutral-400">{{ $location->address }}</p>
                                    <p class="caption text-brandNeutral-400">{{ $location->city }}, {{ $location->department }}</p>
                                </div>
                            </div>

                            <!-- Manager (si existe) -->
                            @if($location->manager_name)
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 flex-shrink-0">
                                        <i data-lucide="user" class="w-full h-full text-brandNeutral-400"></i>
                                    </div>
                                    <p class="body-lg-bold text-brandNeutral-400">{{ $location->manager_name }}</p>
                                </div>
                            @endif

                            <!-- Contacto -->
                            <div class="space-y-2">
                                @if($location->phone)
                                    <a href="tel:{{ $location->phone }}" 
                                       class="flex items-center gap-3 p-3 bg-brandPrimary-50 rounded-lg hover:bg-brandPrimary-300 transition-colors group">
                                        <div class="w-5 h-5 flex-shrink-0 text-brandPrimary-300 transition-colors group-hover:text-brandWhite-100">
                                            <i data-lucide="phone" class="w-full h-full"></i>
                                        </div>
                                        <span class="body-lg-bold text-brandPrimary-300 transition-colors group-hover:text-brandWhite-100">{{ $location->phone }}</span>
                                    </a>
                                @endif

                                @if($location->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $location->whatsapp) }}{{ $location->whatsapp_message ? '?text=' . urlencode($location->whatsapp_message) : '' }}" 
                                       target="_blank"
                                       class="flex items-center gap-3 p-3 bg-brandSuccess-50 rounded-lg hover:bg-brandSuccess-300 transition-colors group">
                                        <div class="w-5 h-5 flex-shrink-0 text-brandSuccess-400 transition-colors group-hover:text-brandWhite-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></g></svg>
                                        </div>
                                        <span class="body-lg-bold text-brandSuccess-400 transition-colors group-hover:text-brandWhite-100">WhatsApp</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Horarios -->
                        @if($location->schedules->count() > 0)
                            <div class="border-t border-brandWhite-400 bg-brandWhite-50">
                                <button @click="showSchedule = !showSchedule" 
                                        class="w-full px-4 py-3 flex items-center justify-between text-left hover:bg-brandPrimary-50 transition-colors">
                                    <span class="body-lg-bold text-brandNeutral-400">Ver horarios</span>
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-brandNeutral-400 transition-transform" 
                                                                     x-bind:class="showSchedule ? 'rotate-180' : ''"></i>
                                </button>
                                
                                <div x-show="showSchedule" 
                                     x-collapse
                                     class="px-4 pb-4">
                                    <div class="space-y-2">
                                        @php
                                            $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                        @endphp
                                        @for($day = 0; $day < 7; $day++)
                                            @php
                                                $schedule = $location->schedules->where('day_of_week', $day)->first();
                                            @endphp
                                            <div class="flex justify-between items-center py-1">
                                                <span class="caption text-brandNeutral-400">{{ $days[$day] }}</span>
                                                <div class="caption text-brandNeutral-400">
                                                    @if($schedule && !$schedule->is_closed)
                                                        <span>{{ substr($schedule->open_time_1, 0, 5) }} - {{ substr($schedule->close_time_1, 0, 5) }}</span>
                                                        @if($schedule->open_time_2 && $schedule->close_time_2)
                                                            <span class="caption text-brandNeutral-400"> • </span>
                                                            <span>{{ substr($schedule->open_time_2, 0, 5) }} - {{ substr($schedule->close_time_2, 0, 5) }}</span>
                                                        @endif
                                                    @else
                                                        <span class="caption text-brandError-400">Cerrado</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Redes sociales -->
                        @if($location->socialLinks->count() > 0)
                            <div class="border-t border-brandWhite-400 p-4">
                                <p class="caption text-brandNeutral-400 mb-2">Síguenos</p>
                                <div class="flex gap-2">
                                    @foreach($location->socialLinks as $social)
                                        <a href="{{ $social->url }}" 
                                           target="_blank"
                                           class="w-12 h-12 bg-brandPrimary-50 rounded-lg flex items-center justify-center transition-colors">
                                            @if($social->platform === 'facebook')
                                            <lord-icon
                                                src="https://cdn.lordicon.com/lplofcfe.json"
                                                trigger="loop"
                                                stroke="bold"
                                                colors="primary:#0C4A6E,secondary:#0C4A6E"
                                                style="width:40px;height:40px">
                                            </lord-icon>
                                            @elseif($social->platform === 'instagram')
                                            <lord-icon
                                                src="https://cdn.lordicon.com/cuwcpyqc.json"
                                                trigger="loop"
                                                stroke="bold"
                                                colors="primary:#831843,secondary:#831843"
                                                style="width:40px;height:40px">
                                            </lord-icon>
                                            @elseif($social->platform === 'whatsapp')
                                            <lord-icon
                                                src="https://cdn.lordicon.com/axewyqun.json"
                                                trigger="loop"
                                                stroke="bold"
                                                colors="primary:#064E3B,secondary:#064E3B"
                                                style="width:40px;height:40px">
                                            </lord-icon>
                                            @elseif($social->platform === 'tiktok')
                                            <lord-icon
                                                src="https://cdn.lordicon.com/opjtxtkg.json"
                                                trigger="loop"
                                                stroke="bold"
                                                colors="primary:#0F172A,secondary:#0F172A"
                                                style="width:40px;height:40px">
                                            </lord-icon>
                                            @elseif($social->platform === 'youtube')
                                            <lord-icon
                                                src="https://cdn.lordicon.com/hhavjzmw.json"
                                                trigger="loop"
                                                stroke="bold"
                                                colors="primary:#FF0000,secondary:#FF0000"
                                                style="width:40px;height:40px">
                                            </lord-icon>
                                            @elseif($social->platform === 'linkiu')
                                            <lord-icon
                                                src="https://cdn.lordicon.com/wxopfjkt.json"
                                                trigger="loop"
                                                stroke="bold"
                                                colors="primary:#000080,secondary:#000080"
                                                style="width:40px;height:40px">
                                            </lord-icon>
                                            @else
                                                <i data-lucide="link" class="w-full h-full text-brandNeutral-400"></i>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <!-- Estado vacío -->
            <div class="bg-accent-50 rounded-xl p-8 text-center flex flex-col items-center justify-center border border-accent-200">
                <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_sedes.svg" alt="img_linkiu_v1_sedes" class="h-32 w-auto" loading="lazy">
                <h3 class="body-lg-bold text-brandNeutral-400 mb-2">Próximamente</h3>
                <p class="caption text-brandNeutral-400 mb-4">Estamos trabajando en agregar nuestras sedes</p>
                @if($store->phone || $store->email)
                    <div class="flex items-center justify-center gap-2">
                        @if($store->phone)
                            <a href="tel:{{ $store->phone }}" 
                               class="inline-flex items-center gap-2 bg-brandSecondary-300 text-brandWhite-100 px-4 py-2 rounded-lg caption hover:bg-brandSecondary-200 transition-colors">
                                <i data-lucide="phone" class="w-4 h-4 text-brandWhite-100"></i>
                                {{ $store->phone }}
                            </a>
                        @endif
                        @if($store->email)
                            <a href="mailto:{{ $store->email }}" 
                               class="inline-flex items-center gap-2 bg-brandPrimary-300 text-brandWhite-100 px-4 py-2 rounded-lg caption hover:bg-brandPrimary-200 transition-colors">
                                <i data-lucide="mail" class="w-4 h-4 text-brandWhite-100"></i>
                                {{ $store->email }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="//unpkg.com/alpinejs" defer></script>
    @endpush
@endsection 