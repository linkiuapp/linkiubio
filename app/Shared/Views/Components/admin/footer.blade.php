<div class="px-6 py-4">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <p class="text-sm text-gray-600 mb-0">
           <x-badge-indicator
           class="caption-strong"
           text="Versión Beta 1.0.1"
           type="error"
           />
           - © {{ date('Y') }} <strong>Linkiu.bio</strong>. Todos los derechos reservados | Desarrollado por <strong>Linkiu Devs ♥️</strong>
        </p>
        <div class="flex flex-wrap items-center gap-3 text-xs">
            <a href="#" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Acerca de <strong>Linkiu</strong></span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="#" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Términos y condiciones</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="#" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Política de privacidad</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="#" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Política de cookies</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="#" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Políticas de envío</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide en el footer
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
