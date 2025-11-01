@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">

    <!-- Header -->
    <div class="space-y-3">
        
        <!-- Breadcrumbs -->
        <nav class="flex caption text-brandInfo-300">
            <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-brandInfo-400 transition-colors">Inicio</a>
            <span class="mx-2">/</span>
            <span class="text-brandNeutral-400 caption">Promociones</span>
        </nav>
        
        <!-- Title -->
        <div class="space-y-2">
            <h3 class="h3 text-brandNeutral-400">Nuestras Promociones</h3>
        </div>

        <!-- Información adicional -->
        <div class="bg-brandInfo-50 rounded-lg p-4">
            <h3 class="body-lg-bold text-brandInfo-400 mb-2">¿Cómo usar nuestros cupones?</h3>
            <div class="space-y-2 caption text-brandInfo-400">
                <div class="flex items-start gap-2">
                    <span class="caption-strong text-brandInfo-400">1.</span>
                    <span>Copia el código de descuento tocando el botón "Copiar"</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="caption-strong text-brandInfo-400">2.</span>
                    <span>Agrega productos a tu carrito de compras</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="caption-strong text-brandInfo-400">3.</span>
                    <span>En el checkout, pega el código en el campo "Cupón de descuento"</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="caption-strong text-brandInfo-400">4.</span>
                    <span>¡Disfruta tu descuento! 🎉</span>
                </div>
            </div>
        </div>
    </div>

    @if($coupons->count() > 0)
    
        <!-- Lista de promociones -->
        <div class="space-y-4">
            @foreach($coupons as $coupon)
                <div class="bg-brandWhite-100 rounded-lg overflow-hidden shadow-sm" x-data="{ copied: false }">
                    
                    <!-- Header del cupón con descuento destacado -->
                    <div class="bg-gradient-to-r from-brandSecondary-300 to-brandPrimary-300 p-4 text-accent-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <!-- Descuento principal -->
                                <div class="h1 mb-1">
                                    @if($coupon->discount_type === 'percentage')
                                        {{ $coupon->formatted_discount }} OFF
                                    @else
                                        {{ $coupon->formatted_discount }} OFF
                                    @endif
                                </div>
                                
                                <!-- Nombre del cupón -->
                                <div class="caption">{{ $coupon->name }}</div>
                            </div>
                            <!-- Badge de estado -->
                            <div class="text-right">
                                <span class="inline-flex items-center rounded-full bg-brandsuccess-50 border border-brandSuccess-400 px-2 py-1 caption-strong text-brandSuccess-400 {{ $coupon->status_info['bg'] }} {{ $coupon->status_info['color'] }} border {{ $coupon->status_info['border'] }}">
                                    {{ $coupon->status_info['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Contenido del cupón -->
                    <div class="p-4 space-y-4">
                        
                        <!-- Código del cupón -->
                        <div>
                            <div class="body-lg-bold text-brandNeutral-400 mb-2">Código de descuento</div>
                            <div class="bg-brandWhite-50 border-2 border-dashed border-dashed-rounded border-brandPrimary-400 rounded-full p-3 flex items-center justify-between">
                                <span class="font-mono h2 text-brandPrimary-300">{{ $coupon->code }}</span>
                                <button 
                                    @click="
                                        navigator.clipboard.writeText('{{ $coupon->code }}');
                                        copied = true;
                                        setTimeout(() => copied = false, 2000);
                                        showCopiedNotification('{{ $coupon->code }}');
                                    " 
                                    class="body-lg-regular bg-brandPrimary-300 hover:bg-brandPrimary-400 text-brandWhite-50 px-3 py-1 rounded-full transition-colors flex items-center gap-2"
                                    type="button"
                                >
                                    <div class="flex items-center gap-2" x-show="!copied">
                                        <i data-lucide="copy" class="w-16px h-16px"></i>
                                        <span>Copiar</span>
                                    </div>
                                    <div class="flex items-center gap-2" x-show="copied" style="display: none;">
                                        <i data-lucide="circle-check" class="w-16px h-16px"></i>
                                        <span>¡Copiado!</span>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <!-- Descripción -->
                        @if($coupon->description)
                            <div class="body-lg-regular text-brandNeutral-400 text-center">
                                {{ $coupon->description }}
                            </div>
                        @endif

                        <!-- Aplicabilidad -->
                        @if($coupon->type !== 'global')
                            <div class="bg-brandInfo-50 border border-brandInfo-100 rounded-lg p-3">
                                <div class="flex items-center gap-2 text-brandInfo-300">
                                    <i data-lucide="info" class="w-16px h-16px"></i>
                                    <span class="body-lg-regular">
                                        @if($coupon->type === 'categories')
                                            Válido para categorías específicas
                                        @else
                                            Válido para productos específicos
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Condiciones y validez -->
                        <div class="space-y-2">
                            @if($coupon->conditions_text)
                                <div class="flex items-center gap-2 text-brandNeutral-400">
                                    <i data-lucide="file-text" class="w-8px h-8px"></i>
                                    <span class="caption">{{ $coupon->conditions_text }}</span>
                                </div>
                            @endif

                            @if($coupon->expiry_text)
                                <div class="flex items-center gap-2 text-brandNeutral-400">
                                    <i data-lucide="calendar" class="w-8px h-8px"></i>
                                    <span class="caption">{{ $coupon->expiry_text }}</span>
                                </div>
                            @endif

                            <!-- Días y horarios específicos -->
                            @if($coupon->days_of_week || $coupon->start_time || $coupon->end_time)
                                <div class="flex items-center gap-2 text-brandNeutral-400">
                                    <i data-lucide="clock" class="w-8px h-8px"></i>
                                    <span class="caption">
                                        @if($coupon->days_of_week)
                                            @php
                                                $dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
                                                $selectedDays = collect($coupon->days_of_week)->map(fn($day) => $dayNames[$day] ?? $day);
                                            @endphp
                                            {{ $selectedDays->join(', ') }}
                                        @endif
                                        @if($coupon->start_time || $coupon->end_time)
                                            {{ $coupon->start_time ? $coupon->start_time->format('H:i') : '00:00' }} - 
                                            {{ $coupon->end_time ? $coupon->end_time->format('H:i') : '23:59' }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Call to action -->
                        <div class="pt-2">
                            <div class="bg-brandSuccess-50 border border-brandSuccess-100 rounded-lg p-3 text-center flex items-center justify-center gap-2">
                                <i data-lucide="star" class="w-5 h-5 text-brandSuccess-400"></i>
                                <span class="caption-strong text-brandSuccess-400">Copia el código y úsalo en tu próxima compra</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else

        <!-- Estado vacío -->
        <div class="flex flex-col items-center justify-center py-8">
            <div class="flex flex-col items-center justify-center">
                <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_coupon.svg" alt="img_linkiu_v1_coupon" class="h-32 w-auto" loading="lazy">
                <p class="body-lg-bold text-center text-brandNeutral-400 mt-4">No hay promociones activas</p>
                <a href="{{ route('tenant.home', $store->slug) }}" 
                   class="rounded-full gap-2 inline-flex mt-2 px-4 py-2 bg-brandPrimary-300 text-brandWhite-100 rounded-full body-lg-medium hover:bg-brandPrimary-400 transition-colors">
                Continuar comprando
                <i data-lucide="arrow-up-right" class="w-24px h-24px sm:w-32px sm:h-32px"></i>
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Función para mostrar notificación de cupón copiado
    window.showCopiedNotification = function(couponCode) {
        // Crear notificación temporal
        const notification = document.createElement('div');
        notification.className = 'fixed top-6 left-1/2 transform -translate-x-1/2 bg-brandSuccess-100 px-6 py-4 rounded-2xl shadow-2xl z-[9999] transition-all duration-500 -translate-y-32 opacity-0 min-w-[320px]';
        notification.innerHTML = `
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check text-brandSuccess-400"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
 
                <div class="flex flex-col gap-1">
                    <span class="caption-strong text-brandNeutral-500">¡Ufff! Cupón copiado exitosamente</span>
                    <span class="caption text-brandNeutral-400">Código: <strong>${couponCode}</strong></span>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.style.transform = 'translate(-50%, 0)';
            notification.style.opacity = '1';
        }, 10);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            notification.style.transform = 'translate(-50%, -8rem)';
            notification.style.opacity = '0';
            
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 3000);
    };

    // Auto-scroll to copied coupon for better UX
    document.addEventListener('alpine:init', () => {
        Alpine.data('couponCard', () => ({
            copied: false,
            
            async copyCoupon(code) {
                try {
                    await navigator.clipboard.writeText(code);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                    // Mostrar notificación
                    showCopiedNotification(code);
                } catch (err) {
                    console.error('Error al copiar:', err);
                    // Fallback para dispositivos que no soportan clipboard API
                    this.fallbackCopy(code);
                }
            },
            
            fallbackCopy(text) {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
                // Mostrar notificación
                showCopiedNotification(text);
            }
        }));
    });
</script>
@endpush
@endsection 