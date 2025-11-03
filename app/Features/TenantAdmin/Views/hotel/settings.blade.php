<x-tenant-admin-layout :store="$store">
@section('title', 'Configuración de Hotel')

@section('content')
<div class="container-fluid" x-data="hotelSettings">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('tenant.admin.hotel.reservations.index', $store->slug) }}" 
               class="text-black-300 hover:text-black-400">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-lg font-semibold text-black-500">Configuración de Hotel</h1>
        </div>
        <p class="text-sm text-black-300">Configura horarios, políticas y notificaciones para tu sistema de reservas de hotel</p>
    </div>

    <form action="{{ route('tenant.admin.hotel.update-settings', $store->slug) }}" method="POST" @submit.prevent="saveSettings($event)" id="settings-form">
        @csrf
        @method('PUT')

        <!-- HORARIOS DE ENTRADA Y SALIDA -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden mb-6">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <h2 class="text-body-large font-bold text-black-400 mb-0">Horarios de Entrada y Salida</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-black-400 mb-2">
                            Hora de Check-in *
                        </label>
                        <input type="time" 
                               x-model="form.check_in_time"
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                               required>
                        <p class="text-sm text-black-300 mt-1">Hora desde la cual los huéspedes pueden hacer check-in</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-black-400 mb-2">
                            Hora de Check-out *
                        </label>
                        <input type="time" 
                               x-model="form.check_out_time"
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                               required>
                        <p class="text-sm text-black-300 mt-1">Hora hasta la cual los huéspedes deben hacer check-out</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONFIGURACIÓN DE ANTICIPOS -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden mb-6">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <h2 class="text-body-large font-bold text-black-400 mb-0">Anticipos</h2>
            </div>
            
            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Tipo de Anticipo *
                    </label>
                    <select x-model="form.deposit_type"
                            class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                            @change="updateDepositType()">
                        <option value="percentage">Porcentaje del total</option>
                        <option value="fixed">Monto fijo</option>
                    </select>
                </div>
                
                <div x-show="form.deposit_type === 'percentage'" x-transition>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Porcentaje de Anticipo *
                    </label>
                    <input type="number" 
                           x-model.number="form.deposit_percentage"
                           name="deposit_percentage"
                           min="0" 
                           max="100"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Porcentaje del total que se cobrará como anticipo</p>
                </div>
                
                <div x-show="form.deposit_type === 'fixed'" x-transition>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Monto Fijo de Anticipo *
                    </label>
                    <input type="number" 
                           x-model.number="form.deposit_fixed_amount"
                           name="deposit_fixed_amount"
                           min="0" 
                           step="1000"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Monto fijo que se cobrará como anticipo</p>
                </div>
            </div>
        </div>

        <!-- DEPÓSITO DE SEGURIDAD -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden mb-6">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <h2 class="text-body-large font-bold text-black-400 mb-0">Depósito de Seguridad</h2>
            </div>
            
            <div class="p-6 space-y-4">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" 
                           x-model="form.require_security_deposit"
                           class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-primary-300">
                    <span class="text-body-base font-semibold text-black-400">Requerir depósito de seguridad</span>
                </label>
                
                <div x-show="form.require_security_deposit" x-transition>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Monto del Depósito de Seguridad *
                    </label>
                    <input type="number" 
                           x-model.number="form.security_deposit_amount"
                           name="security_deposit_amount"
                           min="0" 
                           step="1000"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Monto que se cobrará adicional al total como garantía</p>
                </div>
            </div>
        </div>

        <!-- POLÍTICAS Y RESTRICCIONES -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden mb-6">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <h2 class="text-body-large font-bold text-black-400 mb-0">Políticas y Restricciones</h2>
            </div>
            
            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Horas de Anticipación Mínima *
                    </label>
                    <input type="number" 
                           x-model.number="form.min_advance_hours"
                           min="0" 
                           max="720"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Con cuántas horas de anticipación pueden reservar los clientes</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Horas Mínimas para Cancelación *
                    </label>
                    <input type="number" 
                           x-model.number="form.cancellation_hours"
                           min="0" 
                           max="168"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Horas antes del check-in necesarias para cancelar sin penalización</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Edad Mínima del Huésped *
                    </label>
                    <input type="number" 
                           x-model.number="form.min_guest_age"
                           min="1" 
                           max="100"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Edad mínima requerida para realizar una reserva</p>
                </div>
            </div>
        </div>

        <!-- POLÍTICAS DE NIÑOS -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden mb-6">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <h2 class="text-body-large font-bold text-black-400 mb-0">Políticas de Niños</h2>
            </div>
            
            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Edad Máxima para Niños Gratis *
                    </label>
                    <input type="number" 
                           x-model.number="form.children_free_max_age"
                           min="0" 
                           max="10"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Hasta qué edad los niños se alojan gratis (comparten cama con padres). Recomendado: 2 años</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Edad Máxima para Tarifa Reducida *
                    </label>
                    <input type="number" 
                           x-model.number="form.children_discounted_max_age"
                           min="0" 
                           max="17"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Hasta qué edad los niños tienen descuento. Los mayores de esta edad pagan como adultos. Recomendado: 11 años</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Porcentaje de Descuento para Niños *
                    </label>
                    <input type="number" 
                           x-model.number="form.children_discount_percentage"
                           min="0" 
                           max="100"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Porcentaje de descuento aplicado al precio base para niños con tarifa reducida. Recomendado: 50%</p>
                </div>
                
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" 
                           x-model="form.charge_children_by_occupancy"
                           class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-primary-300">
                    <span class="text-body-base text-black-400">Los niños cuentan en la ocupación base para cargos adicionales</span>
                </label>
                <p class="text-sm text-black-300 mt-1 ml-8">Si está activo, los niños (excepto los gratis) se incluyen en el cálculo de ocupación extra. Si está desactivado, solo los adultos cuentan.</p>
            </div>
        </div>

        <!-- NOTIFICACIONES -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden mb-6">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <h2 class="text-body-large font-bold text-black-400 mb-0">Notificaciones WhatsApp</h2>
            </div>
            
            <div class="p-6 space-y-4">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" 
                           x-model="form.send_confirmation"
                           class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-primary-300">
                    <span class="text-body-base text-black-400">Enviar confirmación automática al cliente</span>
                </label>
                
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" 
                           x-model="form.send_checkin_reminder"
                           class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-primary-300">
                    <span class="text-body-base text-black-400">Enviar recordatorio de check-in</span>
                </label>
                
                <div x-show="form.send_checkin_reminder" x-transition>
                    <label class="block text-sm font-semibold text-black-400 mb-2 mt-4">
                        Horas antes del check-in para enviar recordatorio *
                    </label>
                    <input type="number" 
                           x-model.number="form.reminder_hours"
                           min="0" 
                           max="72"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-end gap-4 mb-6">
            <a href="{{ route('tenant.admin.hotel.reservations.index', $store->slug) }}" 
               class="px-6 py-3 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-primary-200 hover:bg-primary-300 text-accent-50 rounded-lg text-sm transition-colors">
                Guardar Configuración
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('hotelSettings', () => ({
        form: {
            check_in_time: '{{ isset($settings->check_in_time) ? substr($settings->check_in_time, 0, 5) : "15:00" }}',
            check_out_time: '{{ isset($settings->check_out_time) ? substr($settings->check_out_time, 0, 5) : "12:00" }}',
            deposit_type: '{{ $settings->deposit_type ?? "percentage" }}',
            deposit_percentage: {{ $settings->deposit_percentage ?? 50 }},
            deposit_fixed_amount: {{ $settings->deposit_fixed_amount ?? 0 }},
            require_security_deposit: {{ $settings->require_security_deposit ? 'true' : 'false' }},
            security_deposit_amount: {{ $settings->security_deposit_amount ?? 0 }},
            cancellation_hours: {{ $settings->cancellation_hours ?? 48 }},
            min_guest_age: {{ $settings->min_guest_age ?? 18 }},
            min_advance_hours: {{ $settings->min_advance_hours ?? 2 }},
            children_free_max_age: {{ $settings->children_free_max_age ?? 2 }},
            children_discounted_max_age: {{ $settings->children_discounted_max_age ?? 11 }},
            children_discount_percentage: {{ $settings->children_discount_percentage ?? 50 }},
            charge_children_by_occupancy: {{ $settings->charge_children_by_occupancy ? 'true' : 'false' }},
            send_confirmation: {{ $settings->send_confirmation ? 'true' : 'false' }},
            send_checkin_reminder: {{ $settings->send_checkin_reminder ? 'true' : 'false' }},
            reminder_hours: {{ $settings->reminder_hours ?? 24 }}
        },
        
        updateDepositType() {
            // Limpiar valores cuando cambia el tipo
            if (this.form.deposit_type === 'percentage') {
                this.form.deposit_fixed_amount = 0;
            } else {
                this.form.deposit_percentage = 0;
            }
        },
        
        async saveSettings(event) {
            event.preventDefault();
            
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('_method', 'PUT');
            
            // Asegurar que todos los campos del formulario se envíen
            Object.keys(this.form).forEach(key => {
                if (typeof this.form[key] === 'boolean') {
                    formData.append(key, this.form[key] ? '1' : '0');
                } else if (this.form[key] === null || this.form[key] === undefined) {
                    // No enviar valores nulos
                    return;
                } else if (key === 'check_in_time' || key === 'check_out_time') {
                    // Asegurar formato correcto para horas (HH:MM -> H:i)
                    let timeValue = this.form[key];
                    // Si viene como "HH:MM", asegurar que tenga el formato correcto
                    if (timeValue && typeof timeValue === 'string') {
                        // Remover segundos si existen (HH:MM:SS -> HH:MM)
                        timeValue = timeValue.substring(0, 5);
                        formData.append(key, timeValue);
                    } else {
                        formData.append(key, this.form[key]);
                    }
                } else {
                    formData.append(key, this.form[key]);
                }
            });
            
            // Asegurar que los campos condicionales se envíen aunque estén ocultos
            if (this.form.deposit_type === 'percentage' && !formData.has('deposit_percentage')) {
                formData.append('deposit_percentage', this.form.deposit_percentage || 50);
            }
            if (this.form.deposit_type === 'fixed' && !formData.has('deposit_fixed_amount')) {
                formData.append('deposit_fixed_amount', this.form.deposit_fixed_amount || 0);
            }
            if (this.form.require_security_deposit && !formData.has('security_deposit_amount')) {
                formData.append('security_deposit_amount', this.form.security_deposit_amount || 0);
            }
            
            try {
                const response = await fetch('{{ route("tenant.admin.hotel.update-settings", $store->slug) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    // Mostrar errores de validación si existen
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join('\n');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de Validación',
                            text: errorMessages || 'Por favor revisa los campos del formulario',
                            html: '<div class="text-left"><ul class="list-disc list-inside">' + 
                                  Object.values(data.errors).flat().map(err => '<li>' + err + '</li>').join('') + 
                                  '</ul></div>'
                        });
                    } else {
                        throw new Error(data.message || 'Error al guardar');
                    }
                    return;
                }
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message || 'Configuración actualizada correctamente',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    throw new Error(data.message || 'Error al guardar');
                }
            } catch (error) {
                console.error('Error guardando configuración:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Error al guardar la configuración'
                });
            }
        }
    }));
});
</script>
@endpush
@endsection

</x-tenant-admin-layout>