{{--
Nav With Icons - Navegación con iconos
Código exacto de Preline UI sin modificaciones en clases
--}}

<div class="border-b-2 border-gray-200">
  <nav class="-mb-0.5 flex gap-x-6">
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600" href="#">
      <i data-lucide="home" class="shrink-0 size-4"></i>
      Tab 1
    </a>
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-blue-500 text-sm font-medium whitespace-nowrap text-blue-600 focus:outline-hidden focus:text-blue-800" href="#" aria-current="page">
      <i data-lucide="user" class="shrink-0 size-4"></i>
      Tab 2
    </a>
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600" href="#">
      <i data-lucide="settings" class="shrink-0 size-4"></i>
      Tab 3
    </a>
  </nav>
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
