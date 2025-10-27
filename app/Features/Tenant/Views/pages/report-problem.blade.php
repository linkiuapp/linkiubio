@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex text-small font-regular text-info-300">
        <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-info-200 transition-colors">Inicio</a>
        <span class="mx-2">/</span>
        <span class="text-secondary-300 font-medium">Reportar Problema</span>
    </nav>

    <!-- Header -->
    <div class="space-y-2">
        <h1 class="text-h6 font-bold text-black-400">¿Problemas con la tienda?</h1>
        <p class="text-body-small text-black-300">Ayúdanos a mejorar reportando cualquier inconveniente</p>
    </div>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="bg-success-50 border border-success-300 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <x-solar-check-circle-outline class="w-6 h-6 text-success-300 flex-shrink-0 mt-0.5" />
                <div class="text-body-small text-success-300">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Información -->
    <div class="bg-info-50 border border-info-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <x-solar-shield-check-outline class="w-6 h-6 text-info-300 flex-shrink-0 mt-0.5" />
            <div class="text-body-small text-info-300">
                <p class="font-medium mb-2">Tu reporte es importante para nosotros</p>
                <ul class="list-disc list-inside space-y-1 text-caption">
                    <li>Tu información será tratada de forma confidencial</li>
                    <li>Nuestro equipo revisará tu reporte en menos de 24 horas</li>
                    <li>Puedes reportar de forma anónima si lo prefieres</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <form action="{{ route('tenant.report-problem.submit', $store->slug) }}" method="POST" class="space-y-5">
        @csrf
        
        <!-- Motivo del reporte -->
        <div class="bg-accent-50 rounded-xl p-6 border border-accent-200 space-y-4">
            <label class="block">
                <span class="text-body-regular font-semibold text-black-400 mb-2 block">
                    Motivo del reporte <span class="text-error-300">*</span>
                </span>
                <select name="reason" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-accent-100 border border-accent-200 
                               focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors
                               text-black-400 @error('reason') border-error-300 @enderror">
                    <option value="">Selecciona un motivo</option>
                    <option value="producto_defectuoso">Producto defectuoso o no coincide con descripción</option>
                    <option value="envio_tardio">Envío tardío o no recibido</option>
                    <option value="mal_servicio">Mal servicio al cliente</option>
                    <option value="cobro_incorrecto">Cobro incorrecto</option>
                    <option value="fraude">Posible fraude o estafa</option>
                    <option value="contenido_inapropiado">Contenido inapropiado</option>
                    <option value="otro">Otro motivo</option>
                </select>
                @error('reason')
                    <p class="text-caption text-error-300 mt-1">{{ $message }}</p>
                @enderror
            </label>

            <!-- Descripción -->
            <label class="block">
                <span class="text-body-regular font-semibold text-black-400 mb-2 block">
                    Descripción del problema <span class="text-error-300">*</span>
                </span>
                <textarea name="description" 
                          rows="5"
                          required
                          maxlength="1000"
                          placeholder="Describe detalladamente el problema que experimentaste..."
                          class="w-full px-4 py-3 rounded-lg bg-accent-100 border border-accent-200 
                                 focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors
                                 text-black-400 resize-none @error('description') border-error-300 @enderror"></textarea>
                <p class="text-caption text-black-300 mt-1">Máximo 1000 caracteres</p>
                @error('description')
                    <p class="text-caption text-error-300 mt-1">{{ $message }}</p>
                @enderror
            </label>

            <!-- Email (opcional) -->
            <label class="block">
                <span class="text-body-regular font-semibold text-black-400 mb-2 block">
                    Tu email <span class="text-black-300 font-normal">(Opcional)</span>
                </span>
                <input type="email" 
                       name="reporter_email"
                       placeholder="tucorreo@ejemplo.com"
                       class="w-full px-4 py-3 rounded-lg bg-accent-100 border border-accent-200 
                              focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors
                              text-black-400 @error('reporter_email') border-error-300 @enderror">
                <p class="text-caption text-black-300 mt-1">Si deseas que te contactemos sobre tu reporte</p>
                @error('reporter_email')
                    <p class="text-caption text-error-300 mt-1">{{ $message }}</p>
                @enderror
            </label>
        </div>

        <!-- Botones -->
        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" 
                    class="flex-1 bg-error-300 hover:bg-error-200 text-accent-50 py-3 px-6 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                <x-solar-letter-unread-outline class="w-5 h-5" />
                Enviar Reporte
            </button>
            <a href="{{ route('tenant.home', $store->slug) }}" 
               class="flex-1 bg-accent-200 hover:bg-accent-300 text-black-400 py-3 px-6 rounded-lg font-medium transition-colors text-center flex items-center justify-center gap-2">
                <x-solar-close-circle-outline class="w-5 h-5" />
                Cancelar
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Contador de caracteres
    const textarea = document.querySelector('textarea[name="description"]');
    if (textarea) {
        textarea.addEventListener('input', function() {
            const maxLength = 1000;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            const caption = this.nextElementSibling;
            if (caption && caption.classList.contains('text-caption')) {
                caption.textContent = `${currentLength}/${maxLength} caracteres`;
                
                if (remaining < 100) {
                    caption.classList.add('text-warning-300');
                } else {
                    caption.classList.remove('text-warning-300');
                }
            }
        });
    }
</script>
@endpush
@endsection

