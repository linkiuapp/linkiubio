@php
    // Obtener la versión actual desde la base de datos
    $currentVersion = \App\Features\SuperLinkiu\Models\ReleaseNote::current()->first();
    $versionText = $currentVersion ? "v{$currentVersion->version}" : 'v1.0.1';
@endphp

<div class="px-6 py-4">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-3 text-center sm:text-left">
            <x-badge-indicator
                class="caption-strong"
                text="{{ $versionText }}"
                type="error"
            />
            <div class="text-sm text-gray-600">
                <span>© {{ date('Y') }} <strong>Linkiu.bio</strong>.</span>
                <span class="hidden sm:inline">Todos los derechos reservados.</span>
                <span class="block sm:inline sm:ml-1">Desarrollado con <strong class="text-red-500">♥</strong> por <strong>Linkiu Devs</strong></span>
            </div>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-3 text-xs">
            <a href="{{ route('about.index') }}" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Acerca de <strong>Linkiu</strong></span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="{{ route('legal.terms') }}" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Términos y condiciones</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="{{ route('legal.privacy') }}" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Política de privacidad</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="{{ route('legal.cookies') }}" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Política de cookies</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="{{ route('legal.refunds') }}" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Política de reembolsos</span>
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
