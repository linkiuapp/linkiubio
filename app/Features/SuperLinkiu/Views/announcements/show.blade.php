@extends('shared::layouts.admin')

@section('title', 'Detalle del Anuncio')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.announcements.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Detalle del Anuncio</h1>
                <p class="text-sm text-gray-600 mt-1">{{ $announcement->title }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.announcements.analytics', $announcement) }}" 
               class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                Analytics
            </a>
            <a href="{{ route('superlinkiu.announcements.edit', $announcement) }}" 
               class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                Editar
            </a>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- SECTION: Contenido Principal --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- SECTION: Información del Anuncio --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Información del Anuncio</h2>
                        <div class="flex items-center gap-2">
                            @if($announcement->type === 'critical')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Crítico
                                </span>
                            @elseif($announcement->type === 'important')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    Importante
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Información
                                </span>
                            @endif
                            @if($announcement->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Inactivo
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $announcement->title }}</h3>
                            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="star" class="w-4 h-4"></i>
                                    Prioridad {{ $announcement->priority }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                    {{ $announcement->created_at->format('d/m/Y H:i') }}
                                </span>
                                @if($announcement->published_at && $announcement->published_at->isFuture())
                                    <span class="flex items-center gap-1 text-yellow-600">
                                        <i data-lucide="clock" class="w-4 h-4"></i>
                                        Programado para {{ $announcement->published_at->format('d/m/Y H:i') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="prose max-w-none">
                            <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $announcement->content }}</div>
                        </div>

                        {{-- Banner Preview --}}
                        @if($announcement->show_as_banner)
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Vista Previa del Banner</h4>
                                
                                @if($announcement->banner_html)
                                    <div class="w-full rounded-lg border border-gray-200 overflow-hidden" 
                                         style="background-color: {{ $announcement->banner_background_color ?? '#667eea' }}; color: {{ $announcement->banner_text_color ?? '#ffffff' }};">
                                        <div class="p-6">
                                            {!! $announcement->banner_html !!}
                                        </div>
                                    </div>
                                @elseif($announcement->banner_image)
                                    <div class="flex items-start gap-4">
                                        <img src="{{ $announcement->banner_image_url }}" 
                                             alt="Banner" 
                                             class="border border-gray-200 rounded-lg max-w-md">
                                        <div>
                                            <p class="text-sm text-gray-700 mb-1 font-medium">{{ basename($announcement->banner_image) }}</p>
                                            @if($announcement->banner_link)
                                                <a href="{{ $announcement->banner_link }}" 
                                                   target="_blank"
                                                   class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                                    <i data-lucide="link" class="w-4 h-4"></i>
                                                    {{ $announcement->banner_link }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                @if($announcement->banner_link)
                                    <div class="mt-3">
                                        <a href="{{ $announcement->banner_link }}" 
                                           target="_blank"
                                           class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                            Enlace del banner: {{ $announcement->banner_link }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{-- End SECTION: Información del Anuncio --}}

            {{-- SECTION: Estadísticas de Lectura --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-0">Estadísticas de Lectura</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 rounded-lg p-4 text-center border border-blue-100">
                            <div class="text-2xl font-bold text-gray-900">{{ $readStats['total_stores'] }}</div>
                            <div class="text-sm text-gray-600">Total Tiendas</div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 text-center border border-green-100">
                            <div class="text-2xl font-bold text-gray-900">{{ $readStats['read_count'] }}</div>
                            <div class="text-sm text-gray-600">Han Leído</div>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4 text-center border border-yellow-100">
                            <div class="text-2xl font-bold text-gray-900">{{ $readStats['unread_count'] }}</div>
                            <div class="text-sm text-gray-600">Sin Leer</div>
                        </div>
                    </div>

                    @if($readStats['read_count'] > 0)
                        <div class="space-y-3">
                            <h4 class="text-sm font-medium text-gray-700">Tiendas que han leído el anuncio:</h4>
                            <div class="max-h-64 overflow-y-auto space-y-2">
                                @foreach($announcement->reads->sortByDesc('read_at') as $read)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs text-green-700 font-medium">{{ substr($read->store->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $read->store->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $read->store->slug }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-900">{{ $read->read_at->format('d/m/Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $read->read_at->format('H:i') }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i data-lucide="eye-off" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                            <p class="text-gray-600">Aún no hay lecturas registradas</p>
                        </div>
                    @endif
                </div>
            </div>
            {{-- End SECTION: Estadísticas de Lectura --}}
        </div>
        {{-- End SECTION: Contenido Principal --}}

        {{-- SECTION: Panel Lateral --}}
        <div class="space-y-6">
            {{-- SECTION: Información General --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-0">Información General</h2>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">ID:</span>
                        <span class="text-sm text-gray-900 font-mono">#{{ $announcement->id }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Tipo:</span>
                        @if($announcement->type === 'critical')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Crítico
                            </span>
                        @elseif($announcement->type === 'important')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Importante
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Información
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Prioridad:</span>
                        <span class="text-sm text-gray-900 font-medium">{{ $announcement->priority }}/5</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Estado:</span>
                        @if($announcement->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Activo
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Inactivo
                            </span>
                        @endif
                    </div>

                    @if($announcement->isExpired())
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Expiración:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Expirado
                            </span>
                        </div>
                    @endif

                    <hr class="border-gray-200">
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Creado:</span>
                        <span class="text-sm text-gray-900">{{ $announcement->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Modificado:</span>
                        <span class="text-sm text-gray-900">{{ $announcement->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
            {{-- End SECTION: Información General --}}

            {{-- SECTION: Configuración --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-0">Configuración</h2>
                </div>
                
                <div class="p-6 space-y-4">
                    {{-- Fechas --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Fechas</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Publicación:</span>
                                <span class="text-gray-900">
                                    {{ $announcement->published_at ? $announcement->published_at->format('d/m/Y H:i') : 'Inmediata' }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Expiración:</span>
                                <span class="text-gray-900">
                                    {{ $announcement->expires_at ? $announcement->expires_at->format('d/m/Y H:i') : 'Permanente' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Segmentación --}}
                    @if($announcement->target_plans)
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Planes Target</h4>
                            <div class="flex flex-wrap gap-1">
                                @foreach($announcement->target_plans as $plan)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst($plan) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Canales --}}
                    @if($announcement->channels->isNotEmpty())
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Canales de Notificación</h4>
                            <div class="flex flex-wrap gap-1">
                                @foreach($announcement->channels as $channel)
                                    @if($channel->enabled)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                            {{ ucfirst($channel->channel) }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Banner --}}
                    @if($announcement->show_as_banner)
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Banner</h4>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                    <span class="text-sm text-gray-700">Activo como banner</span>
                                </div>
                                @if($announcement->banner_html)
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="code" class="w-4 h-4 text-blue-600"></i>
                                        <span class="text-sm text-gray-700">Banner HTML</span>
                                    </div>
                                @endif
                                @if($announcement->banner_image)
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="image" class="w-4 h-4 text-blue-600"></i>
                                        <span class="text-sm text-gray-700">Con imagen</span>
                                    </div>
                                @endif
                                @if($announcement->banner_link)
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="link" class="w-4 h-4 text-blue-600"></i>
                                        <span class="text-sm text-gray-700">Con enlace</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Comportamiento --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Comportamiento</h4>
                        <div class="space-y-2">
                            @if($announcement->show_popup)
                                <div class="flex items-center gap-2">
                                    <i data-lucide="maximize" class="w-4 h-4 text-yellow-600"></i>
                                    <span class="text-sm text-gray-700">Popup automático</span>
                                </div>
                            @endif
                            @if($announcement->send_email)
                                <div class="flex items-center gap-2">
                                    <i data-lucide="mail" class="w-4 h-4 text-blue-600"></i>
                                    <span class="text-sm text-gray-700">Envío de email</span>
                                </div>
                            @endif
                            @if($announcement->auto_mark_read_after)
                                <div class="flex items-center gap-2">
                                    <i data-lucide="clock" class="w-4 h-4 text-gray-600"></i>
                                    <span class="text-sm text-gray-700">Auto-leído en {{ $announcement->auto_mark_read_after }} días</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- End SECTION: Configuración --}}

            {{-- SECTION: Acciones Rápidas --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Acciones Rápidas</h3>
                <div class="space-y-3">
                    <a href="{{ route('superlinkiu.announcements.edit', $announcement) }}" 
                       class="w-full bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 font-medium transition-colors">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                        Editar Anuncio
                    </a>

                    <form method="POST" 
                          action="{{ route('superlinkiu.announcements.toggle-active', $announcement) }}" 
                          class="w-full">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-{{ $announcement->is_active ? 'red' : 'green' }}-600 hover:bg-{{ $announcement->is_active ? 'red' : 'green' }}-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 font-medium transition-colors">
                            @if($announcement->is_active)
                                <i data-lucide="pause-circle" class="w-4 h-4"></i>
                                Desactivar
                            @else
                                <i data-lucide="play-circle" class="w-4 h-4"></i>
                                Activar
                            @endif
                        </button>
                    </form>

                    <form method="POST" 
                          action="{{ route('superlinkiu.announcements.duplicate', $announcement) }}" 
                          class="w-full">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg flex items-center justify-center gap-2 font-medium transition-colors">
                            <i data-lucide="copy" class="w-4 h-4"></i>
                            Duplicar
                        </button>
                    </form>

                    <form method="POST" 
                          action="{{ route('superlinkiu.announcements.send-notifications', $announcement) }}" 
                          class="w-full">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 font-medium transition-colors">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Enviar Notificaciones
                        </button>
                    </form>
                </div>
            </div>
            {{-- End SECTION: Acciones Rápidas --}}
        </div>
        {{-- End SECTION: Panel Lateral --}}
    </div>
</div>
@push('scripts')
<script>
// Manejar mensajes flash con toasts
@if(session('success'))
    window.toast.success('Éxito', '{{ session('success') }}', 5000, 'top-center');
@endif

@if(session('error'))
    window.toast.error('Error', '{{ session('error') }}', 5000, 'top-center');
@endif
</script>
@endpush
@endsection
