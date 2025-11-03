@extends('frontend.layouts.app')

@push('meta')
    <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 space-y-6" data-reservation-id="{{ $reservation->id }}">
    <!-- Header con animación -->
    <div class="text-center">
        <div class="w-32 h-32 bg-gradient-to-r from-brandPrimary-300 to-brandSecondary-300 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
            <lord-icon src="https://cdn.lordicon.com/yvgmrqny.json" trigger="loop" stroke="bold" colors="primary:#ffffff,secondary:#ffffff" style="width:88px;height:88px"></lord-icon>
        </div>
        <h1 class="h3 text-brandNeutral-400 mb-2">¡Reserva Solicitada!</h1>
        <p class="caption text-brandNeutral-400">Hemos recibido tu solicitud de reserva de habitación. Te contactaremos pronto para confirmar.</p>
    </div>

    <!-- Código de Referencia -->
    <div class="bg-gradient-to-r from-brandPrimary-100 to-brandSecondary-100 rounded-xl p-6 border border-brandWhite-300 shadow-sm">
        <div class="text-center">
            <h2 class="caption-strong text-brandNeutral-400 mb-2">CÓDIGO DE RESERVA</h2>
            <div class="bg-brandWhite-50 rounded-lg p-4 border-2 border-dashed border-brandPrimary-300">
                <p class="h3 font-bold text-brandPrimary-300 tracking-wider" id="reservation-code">{{ $reservation->reservation_code }}</p>
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
        <div id="reservation-status-tracker" class="space-y-4">
            <div class="bg-gradient-to-r from-brandPrimary-50 to-brandPrimary-100 rounded-lg p-4 border border-brandPrimary-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-brandWarning-400 rounded-full flex items-center justify-center text-brandWhite-50 text-lg mr-3">
                            <i data-lucide="hourglass" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="caption-strong text-brandNeutral-400">Estado Actual</h4>
                            <p class="caption text-brandWarning-400">Pendiente</p>
                            <p class="caption text-brandNeutral-300">Actualizado: {{ $reservation->updated_at->format('d/m/Y H:i') }}</p>
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
            Detalles de tu Reserva
        </h3>
        <div class="space-y-4">
            <div class="bg-brandWhite-100 border border-brandWhite-300 rounded-lg p-4">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Nombre:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->guest_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Teléfono:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->guest_phone }}</span>
                    </div>
                    @if($reservation->guest_email)
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Email:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->guest_email }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Habitación:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->roomType->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Check-in:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->check_in_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Check-out:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->check_out_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Noches:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->num_nights }} {{ $reservation->num_nights === 1 ? 'noche' : 'noches' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Huéspedes:</span>
                        <span class="caption-strong text-brandNeutral-400">
                            {{ $reservation->num_adults }} {{ $reservation->num_adults === 1 ? 'adulto' : 'adultos' }}
                            @if($reservation->num_children > 0)
                                , {{ $reservation->num_children }} {{ $reservation->num_children === 1 ? 'niño' : 'niños' }}
                            @endif
                        </span>
                    </div>
                    @if($reservation->estimated_arrival_time)
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Hora estimada de llegada:</span>
                        <span class="caption-strong text-brandNeutral-400">{{ $reservation->estimated_arrival_time }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Total:</span>
                        <span class="caption-strong text-brandNeutral-400">${{ number_format($reservation->total, 0, ',', '.') }}</span>
                    </div>
                    @if($reservation->deposit_amount)
                        <div class="flex justify-between">
                            <span class="caption text-brandNeutral-400">Anticipo:</span>
                            <span class="caption-strong text-brandNeutral-400">${{ number_format($reservation->deposit_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="caption text-brandNeutral-400">Estado del anticipo:</span>
                            <span class="caption-strong {{ $reservation->deposit_paid ? 'text-brandSuccess-400' : 'text-brandWarning-400' }}">
                                {{ $reservation->deposit_paid ? 'Pagado' : 'Pendiente por confirmar' }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            @if($reservation->special_requests)
                <div class="bg-brandInfo-50 border border-brandInfo-300 rounded-lg p-4">
                    <h4 class="caption-strong text-brandNeutral-400 mb-2">Solicitudes Especiales</h4>
                    <p class="caption text-brandNeutral-400">{{ $reservation->special_requests }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Información Importante -->
    <div class="bg-brandInfo-50 border border-brandInfo-300 rounded-xl p-6">
        <h3 class="caption-strong text-brandNeutral-400 mb-3">📋 Información Importante</h3>
        <ul class="space-y-2">
            <li class="flex items-start gap-2">
                <span class="caption text-brandNeutral-400">•</span>
                <span class="caption text-brandNeutral-400 flex-1">Tu reserva está en estado <strong>Pendiente</strong>. Te contactaremos para confirmar.</span>
            </li>
            @if($reservation->deposit_amount && !$reservation->deposit_paid)
                <li class="flex items-start gap-2">
                    <span class="caption text-brandNeutral-400">•</span>
                    <span class="caption text-brandNeutral-400 flex-1">Si subiste un comprobante de anticipo, lo revisaremos y confirmaremos tu reserva.</span>
                </li>
            @endif
            <li class="flex items-start gap-2">
                <span class="caption text-brandNeutral-400">•</span>
                <span class="caption text-brandNeutral-400 flex-1">Recibirás una notificación por WhatsApp cuando confirmemos tu reserva y se te asignará el número de habitación.</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="caption text-brandNeutral-400">•</span>
                <span class="caption text-brandNeutral-400 flex-1">El check-in está disponible desde las {{ \Carbon\Carbon::parse($settings->check_in_time ?? '15:00:00')->format('g:i A') }} y el check-out hasta las {{ \Carbon\Carbon::parse($settings->check_out_time ?? '12:00:00')->format('g:i A') }}.</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="caption text-brandNeutral-400">•</span>
                <span class="caption text-brandNeutral-400 flex-1">Si necesitas cancelar, contáctanos por WhatsApp con más de {{ $settings->cancellation_hours ?? 48 }} horas de anticipación para reembolso completo.</span>
            </li>
        </ul>
    </div>

    <!-- Botones de Acción -->
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('tenant.home', $store->slug) }}"
           class="flex-1 px-4 py-3 bg-brandWhite-50 hover:bg-brandWhite-100 text-brandNeutral-400 rounded-full caption transition-colors border border-brandWhite-300 text-center">
            Volver al inicio
        </a>
        <a href="{{ route('tenant.hotel-reservations.index', $store->slug) }}"
           class="flex-1 px-4 py-3 bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 rounded-full caption transition-colors text-center">
            Hacer otra reserva
        </a>
    </div>
</div>

@push('scripts')
<script>
const RESERVATION_ID = {{ $reservation->id ?? 'null' }};
const STORE_SLUG = '{{ $store->slug ?? '' }}';

function copyReservationCode() {
    const code = document.getElementById('reservation-code').textContent;
    navigator.clipboard.writeText(code).then(function() {
        Swal.fire({
            icon: 'success',
            title: '¡Copiado!',
            text: 'Código de reserva copiado al portapapeles',
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.confetti === 'function' && !sessionStorage.getItem('hotel_reservation_confetti_shown_{{ $reservation->id }}')) {
        setTimeout(() => {
            window.confetti({
                particleCount: 80,
                spread: 70,
                origin: { y: 0.4 },
                colors: ['#da27a7', '#0000fe', '#00c76f', '#e8e6fb'],
                startVelocity: 25,
                ticks: 50,
                gravity: 0.8
            });
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
        sessionStorage.setItem('hotel_reservation_confetti_shown_{{ $reservation->id }}', 'true');
    }
});
</script>
@endpush
@endsection

