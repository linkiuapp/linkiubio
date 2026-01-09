@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Configuración')

@section('content')
<div class="container-fluid max-w-4xl">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white">Configuración de Notificaciones</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Configura tus notificaciones de WhatsApp</p>
    </div>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400">Total Enviadas</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_sent'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400">Fallidas</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['failed'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400">Hoy</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['today'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400">Últimos 7 días</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['last_7_days'] }}</p>
        </div>
    </div>

    {{-- Formulario de Configuración --}}
    <form action="{{ route('superlinkiu.linkiudev.settings.update') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            {{-- Número de WhatsApp --}}
            <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Tu Número de WhatsApp</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Este es el número donde recibirás las notificaciones personales (resumen diario, recordatorios).</p>
                
                <div class="flex gap-2 max-w-md">
                    <select 
                        name="country_code" 
                        class="w-auto min-w-[100px] px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-200 focus:border-blue-500"
                    >
                        <option value="+57" {{ old('country_code', $settings->country_code) === '+57' ? 'selected' : '' }}>🇨🇴 +57</option>
                        <option value="+52" {{ old('country_code', $settings->country_code) === '+52' ? 'selected' : '' }}>🇲🇽 +52</option>
                        <option value="+507" {{ old('country_code', $settings->country_code) === '+507' ? 'selected' : '' }}>🇵🇦 +507</option>
                        <option value="+1" {{ old('country_code', $settings->country_code) === '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                        <option value="+34" {{ old('country_code', $settings->country_code) === '+34' ? 'selected' : '' }}>🇪🇸 +34</option>
                        <option value="+51" {{ old('country_code', $settings->country_code) === '+51' ? 'selected' : '' }}>🇵🇪 +51</option>
                        <option value="+54" {{ old('country_code', $settings->country_code) === '+54' ? 'selected' : '' }}>🇦🇷 +54</option>
                        <option value="+56" {{ old('country_code', $settings->country_code) === '+56' ? 'selected' : '' }}>🇨🇱 +56</option>
                        <option value="+593" {{ old('country_code', $settings->country_code) === '+593' ? 'selected' : '' }}>🇪🇨 +593</option>
                    </select>
                    <input 
                        type="text" 
                        name="whatsapp_number" 
                        value="{{ old('whatsapp_number', $settings->whatsapp_number) }}"
                        required
                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300"
                        placeholder="3001234567"
                    >
                </div>
            </div>

            {{-- Resumen Diario --}}
            <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Resumen Diario</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Recibe un resumen de tu agenda cada mañana</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="daily_summary_enabled" value="1" class="sr-only peer" {{ $settings->daily_summary_enabled ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300/20 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-300"></div>
                    </label>
                </div>
                
                <div class="flex items-center gap-4">
                    <label class="text-sm text-gray-700 dark:text-gray-300">Hora del resumen:</label>
                    <input 
                        type="time" 
                        name="daily_summary_time" 
                        value="{{ old('daily_summary_time', \Carbon\Carbon::parse($settings->daily_summary_time)->format('H:i')) }}"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300"
                    >
                </div>
            </div>

            {{-- Recordatorios de Tareas --}}
            <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Recordatorios de Tareas</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Recibe recordatorios antes de cada tarea programada</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="task_reminders_enabled" value="1" class="sr-only peer" {{ $settings->task_reminders_enabled ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300/20 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-300"></div>
                    </label>
                </div>
                
                <div class="flex items-center gap-4">
                    <label class="text-sm text-gray-700">Minutos antes (por defecto):</label>
                    <select 
                        name="default_reminder_minutes" 
                        class="w-auto min-w-[140px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >
                        <option value="15" {{ $settings->default_reminder_minutes == 15 ? 'selected' : '' }}>15 minutos</option>
                        <option value="30" {{ $settings->default_reminder_minutes == 30 ? 'selected' : '' }}>30 minutos</option>
                        <option value="60" {{ $settings->default_reminder_minutes == 60 ? 'selected' : '' }}>1 hora</option>
                        <option value="120" {{ $settings->default_reminder_minutes == 120 ? 'selected' : '' }}>2 horas</option>
                    </select>
                </div>
            </div>

            {{-- Notificaciones a Clientes --}}
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Notificaciones a Clientes</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Permite enviar actualizaciones a los clientes por WhatsApp</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="client_notifications_enabled" value="1" class="sr-only peer" {{ $settings->client_notifications_enabled ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300/20 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-300"></div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <button type="submit" class="px-6 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg transition-colors flex items-center gap-2">
                <i data-lucide="save" class="w-5 h-5"></i>
                Guardar Configuración
            </button>
        </div>
    </form>

    {{-- Probar Notificaciones --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Probar Notificaciones</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Envía una notificación de prueba a tu número configurado.</p>
        
        <div class="flex gap-3">
            <form action="{{ route('superlinkiu.linkiudev.settings.test-notification') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="type" value="daily_summary">
                <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                    Probar Resumen Diario
                </button>
            </form>
            <form action="{{ route('superlinkiu.linkiudev.settings.test-notification') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="type" value="task_reminder">
                <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors flex items-center gap-2">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                    Probar Recordatorio
                </button>
            </form>
        </div>
    </div>

    {{-- Últimas Notificaciones --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Últimas Notificaciones</h3>
            <a href="{{ route('superlinkiu.linkiudev.notification-logs') }}" class="text-sm text-primary-300 hover:underline">
                Ver todas →
            </a>
        </div>
        
        @if($recentLogs->isEmpty())
            <div class="p-6 text-center">
                <i data-lucide="bell-off" class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3"></i>
                <p class="text-sm text-gray-500 dark:text-gray-400">No hay notificaciones recientes</p>
            </div>
        @else
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($recentLogs as $log)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $log->type_label }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $log->recipient_phone }} • {{ $log->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $log->status_color }}-100 text-{{ $log->status_color }}-800 dark:bg-{{ $log->status_color }}-900/30 dark:text-{{ $log->status_color }}-300">
                                {{ $log->status_label }}
                            </span>
                        </div>
                        @if($log->error_message)
                            <p class="text-xs text-red-500 mt-2">{{ $log->error_message }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush
