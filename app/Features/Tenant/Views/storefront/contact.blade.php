@extends('frontend.layouts.app')

@section('content')
    <div class="p-4 space-y-6">
        <!-- Header -->
        <div class="space-y-2">
            <!-- Breadcrumbs -->
            <nav class="flex text-xs md:text-sm font-medium text-slate-900">
                <a href="{{ route('tenant.home', $store->slug) }}" class="text-blue-600 hover:text-blue-900 transition-colors">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-xs md:text-sm font-medium text-slate-900">Sedes</span>
            </nav>
            
            <!-- Title -->
            <div class="space-y-2">
                <p class="text-base font-semibold text-slate-900">Encuentra la sede más cercana a ti</p>
            </div>
        </div>

        @if($locations->count() > 0)
            <!-- Lista de sedes -->
            <div class="space-y-4">
                @foreach($locations as $location)
                    <div class="bg-white rounded-xl overflow-hidden">
                        <!-- Banner/Mapa -->
                        @php
                            $fullAddress = $location->address . ', ' . $location->city . ', ' . $location->department;
                            $navigationUrls = getNavigationUrls($fullAddress);
                            $mapUrl = null;
                            
                            // Si tiene coordenadas, generar URL del mapa estático
                            if ($location->latitude && $location->longitude) {
                                $mapUrl = getMapboxStaticMapUrlFromCoordinates(
                                    $location->longitude, 
                                    $location->latitude,
                                    600, // width
                                    256  // height (h-32 = 128px, pero 256px para retina)
                                );
                            }
                        @endphp
                        
                        <!-- Contenedor del mapa con botones de navegación -->
                        <div class="relative w-full h-32 rounded-t-xl overflow-hidden">
                            @if($mapUrl)
                                <!-- Mapa estático con Mapbox -->
                                <a href="{{ $navigationUrls['google_maps'] }}" target="_blank" class="block w-full h-full">
                                    <img src="{{ $mapUrl }}" 
                                         alt="Ubicación: {{ $location->name }}" 
                                         class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity">
                                </a>
                            @else
                                <!-- Placeholder clickeable -->
                                <a href="{{ $navigationUrls['google_maps'] }}" target="_blank" 
                                   class="block w-full h-full bg-gray-200 hover:bg-gray-300 transition-colors flex items-center justify-center cursor-pointer group">
                                    <div class="text-center">
                                        <i data-lucide="map-pin" class="w-8 h-8 text-gray-500 group-hover:text-gray-700 mx-auto mb-1"></i>
                                        <p class="text-xs text-gray-600 group-hover:text-gray-800">Ver en mapa</p>
                                    </div>
                                </a>
                            @endif
                            
                            <!-- Botones flotantes de navegación -->
                            <div class="absolute top-2 right-2 flex gap-2 z-10">
                                <!-- Botón Google Maps -->
                                <a 
                                    href="{{ $navigationUrls['google_maps'] }}" 
                                    target="_blank"
                                    @click.stop
                                    class="bg-white hover:bg-gray-50 text-gray-700 rounded-full p-2.5 shadow-lg border border-gray-200 transition-all hover:scale-110"
                                    aria-label="Abrir en Google Maps"
                                    title="Google Maps">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-red-500"></i>
                                </a>
                                
                                <!-- Botón Waze -->
                                <a 
                                    href="{{ $navigationUrls['waze'] }}" 
                                    target="_blank"
                                    @click.stop
                                    class="bg-white hover:bg-gray-50 text-gray-700 rounded-full p-2.5 shadow-lg border border-gray-200 transition-all hover:scale-110"
                                    aria-label="Abrir en Waze"
                                    title="Waze">
                                    <i data-lucide="navigation" class="w-5 h-5 text-blue-500"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Contenido de la card -->
                        <div class="p-4 space-y-3">
                            <!-- Nombre de la sede y badge Principal -->
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-bold text-slate-900">{{ $location->name }}</h3>
                                @if($location->is_main)
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">Principal</span>
                                @endif
                            </div>
                            
                            <!-- Descripción -->
                            @if($location->description)
                                <p class="text-sm font-normal text-slate-700">{{ $location->description }}</p>
                            @endif
                            
                            <!-- Estado actual con badge -->
                            @if($location->currentStatus['status'] === 'open')
                                <div class="flex items-center gap-1 bg-green-100 text-green-800 px-3 py-1 rounded-full w-fit">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-normal">Abierto ahora</span>
                                </div>
                            @endif

                            <!-- Ubicación -->
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 mt-0.5 flex-shrink-0">
                                    <i data-lucide="map-pin" class="w-full h-full text-slate-900"></i>
                                </div>
                                <p class="text-sm font-normal text-slate-900 flex-1">
                                    {{ $location->address }}{{ $location->city || $location->department ? ', ' : '' }}{{ $location->city }}{{ $location->city && $location->department ? ', ' : '' }}{{ $location->department }}
                                </p>
                            </div>

                            <!-- Manager (si existe) -->
                            @if($location->manager_name)
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 flex-shrink-0">
                                        <i data-lucide="user" class="w-full h-full text-slate-900"></i>
                                    </div>
                                    <p class="text-sm font-normal text-slate-900">{{ $location->manager_name }}</p>
                                </div>
                            @endif

                            <!-- Horarios en grid horizontal -->
                            @if($location->schedules->count() > 0)
                                @php
                                    $dayAbbreviations = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
                                    $currentDayOfWeek = \Carbon\Carbon::now()->dayOfWeek; // 0=Domingo, 6=Sábado
                                @endphp
                                <div class="flex gap-2">
                                    @for($day = 0; $day < 7; $day++)
                                        @php
                                            $schedule = $location->schedules->where('day_of_week', $day)->first();
                                            $isToday = $day === $currentDayOfWeek;
                                        @endphp
                                        <div class="flex-1 rounded-lg p-2 text-center {{ $isToday ? 'bg-blue-100 border-2 border-blue-500' : 'bg-gray-100' }}">
                                            @if($schedule && !$schedule->is_closed)
                                                <div class="space-y-0.5">
                                                    <!-- Horario principal -->
                                                    <div class="text-sm font-bold {{ $isToday ? 'text-blue-900' : 'text-slate-900' }}">
                                                        {{ substr($schedule->open_time_1, 0, 5) }}
                                                    </div>
                                                    <!-- Horario adicional si existe -->
                                                    @if($schedule->hasAdditionalSchedule())
                                                        <div class="text-xs font-semibold {{ $isToday ? 'text-blue-700' : 'text-slate-600' }}">
                                                            {{ substr($schedule->open_time_2, 0, 5) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-sm font-bold {{ $isToday ? 'text-blue-900' : 'text-slate-900' }}">-</div>
                                            @endif
                                            <div class="text-xs font-normal mt-1 {{ $isToday ? 'text-blue-800 font-semibold' : 'text-slate-700' }}">
                                                {{ $dayAbbreviations[$day] }}
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            @endif

                            <!-- Redes sociales -->
                            @if($location->socialLinks->count() > 0)
                                <div class="pt-3">
                                    <p class="text-xs text-slate-900 mb-2">Síguenos</p>
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

@endsection 