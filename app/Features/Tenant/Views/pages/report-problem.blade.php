@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex caption text-brandPrimary-300">
        <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-brandPrimary-400 transition-colors">Inicio</a>
        <span class="mx-2">/</span>
        <span class="caption text-brandNeutral-400">Reportar Problema</span>
    </nav>

    <!-- Header -->
    <div class="space-y-2">
        <h1 class="h3 text-brandNeutral-400">¿Problemas con la tienda?</h1>
        <p class="caption text-brandNeutral-300">Ayúdanos a mejorar reportando cualquier inconveniente</p>
    </div>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="bg-brandSuccess-50 border border-brandSuccess-300 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i data-lucide="check-circle" class="w-6 h-6 text-brandSuccess-300 flex-shrink-0 mt-0.5"></i>
                <div class="caption text-brandSuccess-300">
                    <p class="body-lg-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Información -->
    <div class="bg-brandInfo-50 border border-brandInfo-300 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <i data-lucide="shield-check" class="w-6 h-6 text-brandInfo-300 flex-shrink-0 mt-0.5"></i>
            <div class="caption text-brandInfo-300">
                <p class="body-lg-medium mb-2">Tu reporte es importante para nosotros</p>
                <ul class="list-disc list-inside space-y-1 caption">
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
        <div class="bg-brandWhite-100 rounded-xl p-6 space-y-4">
            <label class="block">
                <span class="body-lg-medium text-brandNeutral-400 mb-2 block">
                    Motivo del reporte <span class="text-brandError-300">*</span>
                </span>
                <select name="reason" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-brandWhite-50 border border-brandWhite-300 
                               transition-colors text-brandNeutral-400 caption
                               @error('reason') border-brandWhite-300 @enderror">
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
                    <p class="caption text-brandError-300 mt-1">{{ $message }}</p>
                @enderror
            </label>

            <!-- Descripción -->
            <label class="block">
                <span class="body-lg-medium text-brandNeutral-400 mb-2 block">
                    Descripción del problema <span class="text-brandError-300">*</span>
                </span>
                <textarea name="description" 
                          rows="5"
                          required
                          maxlength="1000"
                          placeholder="Describe detalladamente el problema que experimentaste..."
                          class="w-full px-4 py-3 rounded-lg bg-brandWhite-50 border border-brandWhite-300 
                                 transition-colors text-brandNeutral-400 caption
                                 resize-none @error('description') border-brandError-300 @enderror"></textarea>
                <p class="caption text-brandNeutral-300 mt-1">Máximo 1000 caracteres</p>
                @error('description')
                    <p class="caption text-brandError-300 mt-1">{{ $message }}</p>
                @enderror
            </label>

            <!-- Email (opcional) -->
            <label class="block">
                <span class="body-lg-medium text-brandNeutral-400 mb-2 block">
                    Tu email <span class="caption text-brandNeutral-400">(Opcional)</span>
                </span>
                <input type="email" 
                       name="reporter_email"
                       placeholder="tucorreo@ejemplo.com"
                       class="w-full px-4 py-3 rounded-lg bg-brandWhite-50 border border-brandWhite-300 
                              transition-colors text-brandNeutral-400 caption
                              caption @error('reporter_email') border-brandError-300 @enderror">
                <p class="caption text-brandNeutral-300 mt-1">Si deseas que te contactemos sobre tu reporte</p>
                @error('reporter_email')
                    <p class="caption text-brandError-300 mt-1">{{ $message }}</p>
                @enderror
            </label>
        </div>

        <!-- Botones -->
        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" 
                    class="flex-1 bg-brandError-300 hover:bg-brandError-200 body-small hover:text-brandError-50 text-brandWhite-50 py-3 px-6 rounded-lg body-lg-bold transition-colors flex items-center justify-center gap-2">
                <i data-lucide="send" class="w-5 h-5 text-brandWhite-50"></i>
                Enviar Reporte
            </button>
            <a href="{{ route('tenant.home', $store->slug) }}" 
               class="flex-1 bg-brandPrimary-100 hover:bg-brandPrimary-200 body-small hover:text-brandPrimary-50 text-brandPrimary-300 py-3 px-6 rounded-lg body-lg-medium transition-colors text-center flex items-center justify-center gap-2">
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
            if (caption && caption.classList.contains('caption')) {
                caption.textContent = `${currentLength}/${maxLength} caracteres`;
                
                if (remaining < 100) {
                    caption.classList.add('text-brandWarning-300');
                } else {
                    caption.classList.remove('text-brandWarning-300');
                }
            }
        });
    }
</script>
@endpush
@endsection

