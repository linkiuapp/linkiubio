@extends('frontend.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 space-y-6">
    <!-- Header de Éxito -->
    <div class="text-center">
        <div class="w-32 h-32 bg-gradient-to-r from-brandPrimary-300 to-brandSecondary-300 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
            <lord-icon
                src="https://cdn.lordicon.com/yvgmrqny.json"
                trigger="loop"
                stroke="bold"
                colors="primary:#ffffff,secondary:#ffffff"
                style="width:88px;height:88px">
            </lord-icon>
        </div>
        
        <h1 class="h3 text-brandNeutral-400 mb-2">¡Reserva Solicitada!</h1>
        <p class="caption text-brandNeutral-400">Hemos recibido tu solicitud de reserva. Te contactaremos pronto para confirmar.</p>
    </div>

    <!-- Código de Referencia -->
    <div class="bg-gradient-to-r from-brandPrimary-100 to-brandSecondary-100 rounded-xl p-6 border border-brandWhite-300 shadow-sm">
        <div class="text-center">
            <h2 class="caption-strong text-brandNeutral-400 mb-2">CÓDIGO DE RESERVA</h2>
            <div class="bg-brandWhite-50 rounded-lg p-4 border-2 border-dashed border-brandPrimary-300">
                <p class="h3 font-bold text-brandPrimary-300 tracking-wider" id="reservation-code">{{ $reservation->reference_code }}</p>
                <button onclick="copyReservationCode()" class="mt-2 caption bg-brandPrimary-300 hover:bg-brandSuccess-300 hover:text-brandWhite-50 text-brandWhite-50 px-3 py-2 rounded-full transition-colors">
                    Copiar código
                </button>
            </div>
        </div>
    </div>

    <!-- Estado de la Reserva -->
    <div class="bg-brandWhite-50 rounded-xl p-6 border border-brandWhite-300 shadow-sm">
        <h3 class="caption-strong text-brandNeutral-400 mb-4 flex items-center">
            <x-solar-clipboard-list-outline class="w-6 h-6 text-brandNeutral-400 mr-2" />
            Estado de la Reserva
        </h3>
        <div class="space-y-3">
            @php
                $statusMap = [
                    'pending' => ['label' => 'Pendiente', 'icon' => 'clock', 'color' => 'brandWarning-400', 'description' => 'Tu reserva está pendiente de confirmación'],
                    'confirmed' => ['label' => 'Confirmada', 'icon' => 'check-circle', 'color' => 'brandSuccess-400', 'description' => 'Tu reserva ha sido confirmada'],
                    'completed' => ['label' => 'Completada', 'icon' => 'trophy', 'color' => 'brandPrimary-300', 'description' => 'Tu reserva ha sido completada'],
                    'cancelled' => ['label' => 'Cancelada', 'icon' => 'x-circle', 'color' => 'brandError-400', 'description' => 'Tu reserva ha sido cancelada']
                ];
                $currentStatus = $statusMap[$reservation->status] ?? $statusMap['pending'];
            @endphp
            
            <div class="bg-gradient-to-r from-primary-50 to-primary-100 rounded-lg p-4 border border-primary-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-{{ $currentStatus['color'] }} rounded-full flex items-center justify-center text-brandNeutral-400 mr-3">
                            <i data-lucide="{{ $currentStatus['icon'] }}" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="caption-strong text-brandNeutral-400">Estado Actual</h4>
                            <p class="caption text-{{ $currentStatus['color'] }}">{{ $currentStatus['label'] }}</p>
                            <p class="caption text-brandNeutral-300">{{ $currentStatus['description'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalles de la Reserva -->
    <div class="bg-brandWhite-50 rounded-xl p-6 border border-brandWhite-300 shadow-sm">
        <h3 class="caption-strong text-brandNeutral-400 mb-4 flex items-center">
            <x-solar-document-text-outline class="w-6 h-6 text-brandNeutral-400 mr-2" />
            Detalles de la Reserva
        </h3>
        
        <div class="space-y-4">
            <!-- Información del Cliente -->
            <div class="bg-brandWhite-50 border border-brandWhite-300 rounded-lg p-4">
                <h4 class="caption-strong text-brandNeutral-400 mb-3">Información del Cliente</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Nombre:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->customer_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Teléfono:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->customer_phone }}</span>
                    </div>
                </div>
            </div>

            <!-- Información de la Reserva -->
            <div class="bg-brandWhite-50 border border-brandWhite-300 rounded-lg p-4">
                <h4 class="caption-strong text-brandNeutral-400 mb-3">Información de la Reserva</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Fecha:</span>
                        @php
                            $dateRaw = $reservation->getRawReservationDate();
                            if (!empty($dateRaw)) {
                                $dateObj = \Carbon\Carbon::createFromFormat('Y-m-d', $dateRaw);
                                $dateFormatted = $dateObj->format('d/m/Y');
                            } else {
                                $dateFormatted = '-';
                            }
                        @endphp
                        <span class="caption-strong text-brandNeutral-400">{{ $dateFormatted }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Hora:</span>
                        @php
                            $timeRaw = $reservation->getRawReservationTime();
                            $timeFormatted = $timeRaw ?: '-';
                        @endphp
                        <span class="caption-strong text-brandNeutral-400">{{ $timeFormatted }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Personas:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->party_size }} {{ $reservation->party_size === 1 ? 'persona' : 'personas' }}</span>
                    </div>
                    @if($reservation->table)
                        <div class="flex justify-between">
                            <span class="caption text-brandNeutral-400">Mesa:</span>
                            <span class="caption-strong text-brandNeutral-400">Mesa #{{ $reservation->table->table_number }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Resumen de Pago (si aplica) -->
            @if($reservation->deposit_amount)
            <div class="bg-brandWhite-50 border border-brandWhite-300 rounded-lg p-4">
                <h4 class="caption-strong text-brandNeutral-400 mb-3">Resumen de Anticipo</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Monto del anticipo:</span>
                        <span class="caption-strong text-brandNeutral-400">${{ number_format($reservation->deposit_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Estado del anticipo:</span>
                        <span class="caption-strong {{ $reservation->deposit_paid ? 'text-brandSuccess-400' : 'text-brandWarning-400' }}">
                            {{ $reservation->deposit_paid ? 'Pagado' : 'Pendiente' }}
                        </span>
                    </div>
                    <div class="border-t border-accent-200 pt-2 mt-2">
                        <p class="caption text-brandNeutral-400">
                            Este anticipo se descontará del consumo final.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Notas Especiales -->
            @if($reservation->notes)
            <div class="bg-brandInfo-50 border border-brandInfo-300 rounded-lg p-4">
                <h4 class="caption-strong text-brandNeutral-400 mb-2">Notas Especiales</h4>
                <p class="caption text-brandNeutral-400">{{ $reservation->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Acciones de Compartir -->
    <div class="bg-brandWhite-50 rounded-xl p-6 border border-brandWhite-300 shadow-sm">
        <h3 class="body-large font-bold text-brandNeutral-400 mb-4 flex items-center">
            <x-solar-share-outline class="w-6 h-6 text-brandNeutral-400 mr-2" />
            Compartir
        </h3>
        
        <div class="grid grid-cols-1 gap-3">
            <!-- Contactar al negocio -->
            <button onclick="shareWithBusiness()" class="flex items-center justify-center w-full bg-brandSuccess-300 hover:bg-brandSuccess-200 text-brandWhite-50 py-3 px-4 rounded-lg font-medium transition-colors">
                <i data-lucide="phone" class="w-6 h-6 text-brandWhite-50 mr-2"></i>
                Contactar al negocio
            </button>
            
            <!-- Compartir con un amigo -->
            <button onclick="shareWithFriend()" class="flex items-center justify-center w-full bg-brandInfo-300 hover:bg-brandInfo-200 text-brandWhite-50 py-3 px-4 rounded-lg font-medium transition-colors">
                <i data-lucide="heart" class="w-6 h-6 text-brandWhite-50 mr-2"></i>
                Compartir con un amigo
            </button>
        </div>
    </div>

    <!-- Información Importante -->
    <div class="bg-brandInfo-50 border border-brandInfo-300 rounded-xl p-6">
        <h3 class="caption-strong text-brandNeutral-400 mb-3 flex items-center">
            <x-solar-info-circle-outline class="w-5 h-5 text-brandNeutral-400 mr-2" />
            Información Importante
        </h3>
        <ul class="space-y-2">
            <li class="flex items-start gap-2">
                <span class="caption text-brandNeutral-400">•</span>
                <span class="caption text-brandNeutral-400 flex-1">Tu reserva está en estado <strong>{{ $currentStatus['label'] }}</strong>. @if($reservation->status === 'pending') Te contactaremos para confirmar. @endif</span>
            </li>
            @if($reservation->deposit_amount && !$reservation->deposit_paid)
                <li class="flex items-start gap-2">
                    <span class="caption text-brandNeutral-400">•</span>
                    <span class="caption text-brandNeutral-400 flex-1">Si subiste un comprobante, lo revisaremos y confirmaremos tu reserva.</span>
                </li>
            @endif
            <li class="flex items-start gap-2">
                <span class="caption text-brandNeutral-400">•</span>
                <span class="caption text-brandNeutral-400 flex-1">Recibirás una notificación por WhatsApp cuando confirmemos tu reserva.</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="caption text-brandNeutral-400">•</span>
                <span class="caption text-brandNeutral-400 flex-1">Si necesitas cancelar, contáctanos por WhatsApp con más de 24 horas de anticipación para reembolso completo.</span>
            </li>
        </ul>
    </div>

    <!-- Botones de Acción -->
    <div class="grid grid-cols-1 gap-3">
        <a href="{{ route('tenant.reservations.index', $store->slug) }}" 
           class="flex items-center justify-center w-full bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-50 py-3 px-4 rounded-lg font-semibold transition-colors">
            <i data-lucide="calendar-plus" class="w-6 h-6 text-brandWhite-50 mr-2"></i>
            Hacer otra reserva
        </a>
        
        <a href="{{ route('tenant.home', $store->slug) }}" 
           class="flex items-center justify-center w-full bg-brandWhite-300 hover:bg-brandWhite-200 text-brandNeutral-400 py-3 px-4 rounded-lg font-medium transition-colors">
            <i data-lucide="home" class="w-6 h-6 text-brandNeutral-400 mr-2"></i>
            Volver al inicio
        </a>
    </div>
</div>

@push('scripts')
<script>
const RESERVATION_CODE = '{{ $reservation->reference_code }}';
const STORE_SLUG = '{{ $store->slug ?? '' }}';
const STORE_PHONE = '{{ $store->phone ?? '' }}';
const STORE_NAME = '{{ $store->name ?? 'Tienda' }}';
const CUSTOMER_NAME = '{{ $reservation->customer_name ?? 'Cliente' }}';
const RESERVATION_DATE = '{{ !empty($reservation->getRawReservationDate()) ? \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->getRawReservationDate())->format("d/m/Y") : "" }}';
const RESERVATION_TIME = '{{ $reservation->getRawReservationTime() ?? "" }}';
const PARTY_SIZE = '{{ $reservation->party_size ?? "" }}';

document.addEventListener('DOMContentLoaded', function() {
    // 🎉 CONFETTI DE CELEBRACIÓN - Solo en primera carga
    if (!sessionStorage.getItem('reservation_confetti_shown_{{ $reservation->id }}')) {
        if (typeof window.confetti === 'function') {
            setTimeout(() => {
                // Confetti sutil desde arriba
                window.confetti({
                    particleCount: 80,
                    spread: 70,
                    origin: { y: 0.4 },
                    colors: ['#da27a7', '#0000fe', '#00c76f', '#e8e6fb'],
                    startVelocity: 25,
                    ticks: 50,
                    gravity: 0.8
                });
                
                // Segundo burst más pequeño
                setTimeout(() => {
                    window.confetti({
                        particleCount: 40,
                        spread: 50,
                        origin: { y: 0.4 },
                        colors: ['#da27a7', '#0000fe', '#00c76f', '#e8e6fb'],
                        startVelocity: 20,
                        ticks: 40
                    });
                }, 250);
            }, 300);
            
            // Marcar que ya se mostró
            sessionStorage.setItem('reservation_confetti_shown_{{ $reservation->id }}', 'true');
        }
    }
});

// Copiar código de reserva
function copyReservationCode() {
    const code = RESERVATION_CODE;
    
    navigator.clipboard.writeText(code).then(() => {
        Swal.fire({
            icon: 'success',
            title: '¡Copiado!',
            text: 'Código de reserva copiado al portapapeles',
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }).catch(() => {
        alert('Código de reserva: ' + code);
    });
}

// Compartir con el negocio via WhatsApp
function shareWithBusiness() {
    let message = `🍽️ *Confirmación de Reserva*\n\n`;
    message += `👋 ¡Hola ${STORE_NAME}! Soy *${CUSTOMER_NAME}*\n\n`;
    message += `📋 *Código de Reserva:* ${RESERVATION_CODE}\n`;
    message += `📅 *Fecha:* ${RESERVATION_DATE}\n`;
    message += `⏰ *Hora:* ${RESERVATION_TIME}\n`;
    message += `👥 *Personas:* ${PARTY_SIZE}\n\n`;
    message += `📞 *Teléfono:* {{ $reservation->customer_phone ?? 'N/A' }}\n\n`;
    message += `¿Podrían confirmar que recibieron mi reserva? ¡Gracias! 😊`;
    
    const whatsappNumber = STORE_PHONE || '{{ $store->phone ?? "" }}';
    if (!whatsappNumber) {
        Swal.fire({
            icon: 'warning',
            title: 'WhatsApp no disponible',
            text: 'Número de WhatsApp no configurado para esta tienda',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
        return;
    }
    
    const url = `https://wa.me/${whatsappNumber.replace(/\D/g, '')}?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
}

// Compartir con un amigo
function shareWithFriend() {
    const message = `¡Acabo de hacer una reserva en ${STORE_NAME}! 🍽️\n\nCódigo: ${RESERVATION_CODE}\nFecha: ${RESERVATION_DATE}\nHora: ${RESERVATION_TIME}\nPersonas: ${PARTY_SIZE}\n\nRevisa sus productos: ${window.location.origin}/${STORE_SLUG}`;
    
    if (navigator.share) {
        navigator.share({
            title: 'Mi reserva en ' + STORE_NAME,
            text: message,
            url: window.location.href
        }).catch(() => {
            // Fallback a WhatsApp
            shareViaWhatsApp(message);
        });
    } else {
        // Fallback a WhatsApp o copiar al portapapeles
        shareViaWhatsApp(message);
    }
}

// Compartir via WhatsApp (fallback)
function shareViaWhatsApp(message) {
    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}
</script>
@endpush
@endsection
