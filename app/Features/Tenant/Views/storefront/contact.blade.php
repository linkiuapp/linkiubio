@extends('frontend.layouts.app')

@section('content')
    <div class="p-4 space-y-6">
        <!-- Header -->
        <div class="space-y-3">
            <!-- Breadcrumbs -->
            <nav class="flex text-small font-regular text-info-300">
                <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-info-200 transition-colors">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-secondary-300 font-medium">Sedes</span>
            </nav>
            
            <!-- Title -->
            <div class="space-y-2">
                <h7 class="text-h7 font-bold text-black-300">Nuestras Sedes</h7>
                <p class="text-body-small font-regular text-black-200">Encuentra la sede más cercana a ti</p>
            </div>
        </div>

        @if($locations->count() > 0)
            <!-- Lista de sedes -->
            <div class="space-y-4">
                @foreach($locations as $location)
                    <div class="bg-accent-50 rounded-xl border border-accent-200 overflow-hidden" x-data="{ showSchedule: false }">
                        <!-- Header de la sede -->
                        <div class="p-4 pb-3">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-lg font-semibold text-black-400">{{ $location->name }}</h3>
                                        @if($location->is_main)
                                            <span class="bg-primary-300 text-accent-50 text-xs px-2 py-1 rounded-full font-medium">Principal</span>
                                        @endif
                                    </div>
                                    
                                    @if($location->description)
                                        <p class="text-sm text-black-300 mb-2">{{ $location->description }}</p>
                                    @endif
                                    
                                    <!-- Estado actual con badge -->
                                    <div class="flex items-center gap-2">
                                        @if($location->currentStatus['status'] === 'open')
                                            <span class="bg-success-200 text-black-400 text-xs px-3 py-1 rounded-full font-medium flex items-center gap-1">
                                                <div class="w-1.5 h-1.5 bg-accent-50 rounded-full"></div>
                                                {{ $location->currentStatus['text'] }}
                                            </span>
                                        @elseif($location->currentStatus['status'] === 'closed')
                                            <span class="bg-error-200 text-accent-50 text-xs px-3 py-1 rounded-full font-medium flex items-center gap-1">
                                                <div class="w-1.5 h-1.5 bg-accent-50 rounded-full"></div>
                                                {{ $location->currentStatus['text'] }}
                                            </span>
                                        @else
                                            <span class="bg-warning-300 text-black-400 text-xs px-3 py-1 rounded-full font-medium flex items-center gap-1">
                                                <div class="w-1.5 h-1.5 bg-black-400 rounded-full"></div>
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
                                    <x-solar-map-point-outline class="w-full h-full text-black-300" />
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-black-400 font-medium">{{ $location->address }}</p>
                                    <p class="text-xs text-black-300">{{ $location->city }}, {{ $location->department }}</p>
                                </div>
                            </div>

                            <!-- Manager (si existe) -->
                            @if($location->manager_name)
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 flex-shrink-0">
                                        <x-solar-user-outline class="w-full h-full text-black-300" />
                                    </div>
                                    <p class="text-sm text-black-400">{{ $location->manager_name }}</p>
                                </div>
                            @endif

                            <!-- Contacto -->
                            <div class="space-y-2">
                                @if($location->phone)
                                    <a href="tel:{{ $location->phone }}" 
                                       class="flex items-center gap-3 p-3 bg-accent-100 rounded-lg hover:bg-primary-50 transition-colors">
                                        <div class="w-5 h-5 flex-shrink-0">
                                            <x-solar-phone-outline class="w-full h-full text-primary-300" />
                                        </div>
                                        <span class="text-sm text-black-400 font-medium">{{ $location->phone }}</span>
                                    </a>
                                @endif

                                @if($location->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $location->whatsapp) }}{{ $location->whatsapp_message ? '?text=' . urlencode($location->whatsapp_message) : '' }}" 
                                       target="_blank"
                                       class="flex items-center gap-3 p-3 bg-success-50 rounded-lg hover:bg-success-100 transition-colors">
                                        <div class="w-5 h-5 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></g></svg>
                                        </div>
                                        <span class="text-sm text-success-500 font-medium">WhatsApp</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Horarios -->
                        @if($location->schedules->count() > 0)
                            <div class="border-t border-accent-200">
                                <button @click="showSchedule = !showSchedule" 
                                        class="w-full px-4 py-3 flex items-center justify-between text-left hover:bg-accent-100 transition-colors">
                                    <span class="text-sm text-black-400 font-medium">Ver horarios</span>
                                    <x-solar-alt-arrow-down-outline class="w-4 h-4 text-black-300 transition-transform" 
                                                                     x-bind:class="showSchedule ? 'rotate-180' : ''" />
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
                                                <span class="text-xs text-black-300 font-medium">{{ $days[$day] }}</span>
                                                <div class="text-xs text-black-400">
                                                    @if($schedule && !$schedule->is_closed)
                                                        <span>{{ substr($schedule->open_time_1, 0, 5) }} - {{ substr($schedule->close_time_1, 0, 5) }}</span>
                                                        @if($schedule->open_time_2 && $schedule->close_time_2)
                                                            <span class="text-black-300"> • </span>
                                                            <span>{{ substr($schedule->open_time_2, 0, 5) }} - {{ substr($schedule->close_time_2, 0, 5) }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-error-300">Cerrado</span>
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
                            <div class="border-t border-accent-200 p-4">
                                <p class="text-xs text-black-300 font-medium mb-2">Síguenos</p>
                                <div class="flex gap-2">
                                    @foreach($location->socialLinks as $social)
                                        <a href="{{ $social->url }}" 
                                           target="_blank"
                                           class="w-8 h-8 bg-accent-200 rounded-lg flex items-center justify-center hover:bg-primary-100 transition-colors">
                                            @if($social->platform === 'facebook')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10v4h3v7h4v-7h3l1-4h-4V8a1 1 0 0 1 1-1h3V3h-3a5 5 0 0 0-5 5v2z"/></svg>
                                            @elseif($social->platform === 'instagram')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M4 8a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4z"/><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0-6 0m7.5-4.5v.01"/></g></svg>
                                            @elseif($social->platform === 'whatsapp')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></g></svg>
                                            @elseif($social->platform === 'tiktok')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 7.917v4.034A9.95 9.95 0 0 1 16 10v4.5a6.5 6.5 0 1 1-8-6.326V12.5a2.5 2.5 0 1 0 4 2V3h4.083A6.005 6.005 0 0 0 21 7.917"/></svg>
                                            @elseif($social->platform === 'youtube')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M2 8a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4z"/><path d="m10 9l5 3l-5 3z"/></g></svg>
                                            @elseif($social->platform === 'linkiu')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 15l6-6m-4-3l.463-.536a5 5 0 0 1 7.071 7.072L18 13m-5 5l-.397.534a5.07 5.07 0 0 1-7.127 0a4.97 4.97 0 0 1 0-7.071L6 11"/></svg>
                                            @else
                                                <x-solar-link-circle-outline class="w-4 h-4 text-black-400" />
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
            <div class="bg-accent-50 rounded-xl p-8 text-center border border-accent-200">
                <div class="w-16 h-16 bg-accent-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-lucide-building-2 class="w-8 h-8 text-black-300" />
                </div>
                <h3 class="text-h7 font-bold text-black-300 mb-2">Próximamente</h3>
                <p class="text-body-small font-regular text-black-300 mb-4">Estamos trabajando en agregar nuestras sedes</p>
                @if($store->phone || $store->email)
                    <div class="space-y-2">
                        @if($store->phone)
                            <a href="tel:{{ $store->phone }}" 
                               class="inline-flex items-center gap-2 bg-primary-300 text-accent-50 px-4 py-2 rounded-lg text-caption font-medium hover:bg-primary-200 transition-colors">
                                <x-solar-phone-outline class="w-4 h-4" />
                                {{ $store->phone }}
                            </a>
                        @endif
                        @if($store->email)
                            <a href="mailto:{{ $store->email }}" 
                               class="inline-flex items-center gap-2 bg-accent-200 text-black-300 px-4 py-2 rounded-lg text-caption font-medium hover:bg-accent-300 transition-colors">
                                <x-solar-letter-outline class="w-4 h-4" />
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