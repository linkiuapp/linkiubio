{{--
Input Validation - Inputs con estados de validación
Código exacto de Preline UI sin modificaciones en clases
--}}

<div class="max-w-sm space-y-4">
  <div>
    <label for="hs-validation-name-error" class="block text-sm font-medium mb-2">Correo electrónico</label>
    <div class="relative">
      <input type="text" id="hs-validation-name-error" name="hs-validation-name-error" class="py-2.5 sm:py-3 px-4 block w-full border border-red-500 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500" required="" aria-describedby="hs-validation-name-error-helper">
      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
        <i data-lucide="alert-circle" class="shrink-0 size-4 text-red-500"></i>
      </div>
    </div>
    <p class="text-sm text-red-600 mt-2" id="hs-validation-name-error-helper">Por favor ingresa una dirección de correo válida.</p>
  </div>

  <div>
    <label for="hs-validation-name-success" class="block text-sm font-medium mb-2">Correo electrónico</label>
    <div class="relative">
      <input type="text" id="hs-validation-name-success" name="hs-validation-name-success" class="py-2.5 sm:py-3 px-4 block w-full border border-teal-500 rounded-lg sm:text-sm focus:border-teal-500 focus:ring-teal-500" required="" aria-describedby="hs-validation-name-success-helper">
      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
        <i data-lucide="check" class="shrink-0 size-4 text-teal-500"></i>
      </div>
    </div>
    <p class="text-sm text-teal-600 mt-2" id="hs-validation-name-success-helper">¡Se ve bien!</p>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
