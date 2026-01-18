{{--
Vista Index - Notificaciones Unificadas
Muestra todas las notificaciones (pedidos, tickets, anuncios) en un solo lugar
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Notificaciones')

    @section('content')
    {{-- SECTION: Main Container --}}
    @php
        $notificationsJson = json_encode($allNotifications);
    @endphp
    <div 
        class="space-y-6"
        x-data="{
            allNotifications: {{ $notificationsJson }},
            hiddenNotifications: [],
            
            init() {
                const hidden = localStorage.getItem('tenant_hidden_notifications');
                if (hidden) {
                    try {
                        this.hiddenNotifications = JSON.parse(hidden);
                    } catch(e) {
                        this.hiddenNotifications = [];
                    }
                }
                
                this.$nextTick(() => {
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                });
            },
            
            get filteredNotifications() {
                return this.allNotifications.filter(n => !this.hiddenNotifications.includes(n.id));
            },
            
            removeNotification(id) {
                if (!this.hiddenNotifications.includes(id)) {
                    this.hiddenNotifications.push(id);
                    localStorage.setItem('tenant_hidden_notifications', JSON.stringify(this.hiddenNotifications));
                }
                
                this.$nextTick(() => {
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                });
            },
            
            handleNotificationClick(notification, event) {
                // Si es una notificación de verificación, prevenir navegación y mostrar modal
                if (notification.type === 'store_verification_changed') {
                    event.preventDefault();
                    
                    // Extraer el estado de verificación del color o del contenido
                    const isVerified = notification.color === 'green' || 
                                     notification.message.includes('badge oficial') ||
                                     notification.title.includes('Verificada!');
                    
                    // Mostrar el modal de verificación
                    if (typeof window.showVerificationModal === 'function') {
                        window.showVerificationModal({
                            verified: isVerified,
                            message: notification.message,
                            title: notification.title
                        });
                    }
                }
                // Para otros tipos, dejar que navegue normalmente
            }
        }"
    >
        {{-- SECTION: Header --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Notificaciones</h1>
                    <p class="text-sm text-gray-600 mt-1">Todas tus notificaciones en un solo lugar</p>
                </div>
            </div>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Notifications List --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="p-6">
                <h2 class="text-md font-semibold text-gray-800 mb-4">Todas las Notificaciones</h2>
                
                <template x-if="filteredNotifications.length === 0">
                    <div class="text-center py-12">
                        <i data-lucide="bell-off" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                        <p class="text-gray-600 font-medium">No hay notificaciones</p>
                        <p class="text-sm text-gray-500 mt-1">Las notificaciones aparecerán aquí cuando recibas nuevos pedidos, respuestas de tickets, anuncios, actualizaciones, facturas, íconos aprobados, errores resueltos o cambios en la verificación de tu tienda</p>
                    </div>
                </template>

                <template x-if="filteredNotifications.length > 0">
                    <div class="space-y-2">
                        <template x-for="notification in filteredNotifications" :key="notification.id">
                            <div
                                class="flex items-start gap-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors group"
                            >
                                {{-- Icon --}}
                                <div 
                                    class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                                    :class="{
                                        'bg-red-100': notification.type === 'order',
                                        'bg-blue-100': notification.type === 'ticket',
                                        'bg-yellow-100': notification.type === 'announcement',
                                        'bg-purple-100': notification.type === 'release-note' || notification.type === 'icon-request-approved',
                                        'bg-indigo-100': notification.type === 'release-note-item',
                                        'bg-orange-100': notification.type === 'invoice' && notification.color === 'orange',
                                        'bg-green-100': (notification.type === 'invoice' && notification.color === 'green') || notification.type === 'error-report-resolved' || (notification.type === 'store_verification_changed' && notification.color === 'green'),
                                        'bg-red-100': notification.type === 'invoice' && notification.color === 'red',
                                        'bg-gray-100': (notification.type === 'invoice' && notification.color === 'gray') || (notification.type === 'store_verification_changed' && notification.color === 'gray')
                                    }"
                                >
                                    <i 
                                        :data-lucide="notification.icon"
                                        class="w-5 h-5"
                                        :class="{
                                        'text-red-600': notification.type === 'order',
                                        'text-blue-600': notification.type === 'ticket',
                                        'text-yellow-600': notification.type === 'announcement',
                                        'text-purple-600': notification.type === 'release-note' || notification.type === 'icon-request-approved',
                                        'text-indigo-600': notification.type === 'release-note-item',
                                        'text-orange-600': notification.type === 'invoice' && notification.color === 'orange',
                                        'text-green-600': (notification.type === 'invoice' && notification.color === 'green') || notification.type === 'error-report-resolved' || (notification.type === 'store_verification_changed' && notification.color === 'green'),
                                        'text-red-600': notification.type === 'invoice' && notification.color === 'red',
                                        'text-gray-600': (notification.type === 'invoice' && notification.color === 'gray') || (notification.type === 'store_verification_changed' && notification.color === 'gray')
                                    }"
                                    ></i>
                                </div>

                                {{-- Content --}}
                                <a 
                                    :href="notification.type === 'store_verification_changed' ? '#' : notification.url"
                                    @click="handleNotificationClick(notification, $event)"
                                    class="flex-1 min-w-0"
                                >
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-sm font-medium text-gray-900" x-text="notification.title"></p>
                                    </div>
                                    <p 
                                        class="text-xs text-gray-600 mt-1 line-clamp-2"
                                        x-html="notification.message"
                                    ></p>
                                    <p class="text-xs text-gray-400 mt-2" x-text="notification.formatted_time"></p>
                                </a>

                                {{-- Delete Button --}}
                                <button
                                    @click.stop="removeNotification(notification.id)"
                                    class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"
                                    title="Eliminar notificación"
                                >
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
        {{-- End SECTION: Notifications List --}}
    </div>
    {{-- End SECTION: Main Container --}}
    @endsection
</x-tenant-admin-layout>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos después de que se cargue el DOM
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
