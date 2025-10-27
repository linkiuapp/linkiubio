<!-- Footer -->
<footer class="bg-accent-50 border-t border-accent-200 mt-12">
    <div class="max-w-[480px] mx-auto px-6 py-8">
        <!-- Links principales -->
        <div class="flex flex-col gap-4 mb-6">
            <a href="{{ route('tenant.legal-policies', $store->slug) }}" 
               class="flex items-center justify-between py-3 px-4 bg-accent-100 hover:bg-accent-200 rounded-lg transition-colors group">
                <div class="flex items-center gap-3">
                    <x-solar-document-text-outline class="w-5 h-5 text-secondary-300" />
                    <span class="text-body-regular font-medium text-black-400">Políticas Legales</span>
                </div>
                <x-solar-alt-arrow-right-outline class="w-4 h-4 text-black-300 group-hover:translate-x-1 transition-transform" />
            </a>

            <a href="{{ route('tenant.about-us', $store->slug) }}" 
               class="flex items-center justify-between py-3 px-4 bg-accent-100 hover:bg-accent-200 rounded-lg transition-colors group">
                <div class="flex items-center gap-3">
                    <x-solar-users-group-two-rounded-outline class="w-5 h-5 text-secondary-300" />
                    <span class="text-body-regular font-medium text-black-400">Acerca de Nosotros</span>
                </div>
                <x-solar-alt-arrow-right-outline class="w-4 h-4 text-black-300 group-hover:translate-x-1 transition-transform" />
            </a>

            <a href="{{ route('tenant.report-problem', $store->slug) }}" 
               class="flex items-center justify-between py-3 px-4 bg-warning-50 hover:bg-warning-100 border border-warning-200 rounded-lg transition-colors group">
                <div class="flex items-center gap-3">
                    <x-solar-danger-triangle-outline class="w-5 h-5 text-warning-300" />
                    <span class="text-body-regular font-medium text-black-400">¿Problemas con la tienda?</span>
                </div>
                <x-solar-alt-arrow-right-outline class="w-4 h-4 text-black-300 group-hover:translate-x-1 transition-transform" />
            </a>
        </div>

        <!-- Divider -->
        <div class="border-t border-accent-200 my-6"></div>

        <!-- Info adicional -->
        <div class="text-center space-y-2">
            <p class="text-body-small text-black-300">
                {{ $store->name }}
            </p>
            <p class="text-caption text-black-200">
                © {{ date('Y') }} Todos los derechos reservados
            </p>
            <p class="text-caption text-black-200">
                Powered by <span class="font-semibold text-primary-300">Linkiu</span>
            </p>
        </div>
    </div>
</footer>

