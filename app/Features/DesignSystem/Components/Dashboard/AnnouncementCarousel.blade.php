{{--
AnnouncementCarousel - Carousel de anuncios/banners
Uso: Mostrar banners de anuncios en formato carousel con navegación
Cuándo usar: Dashboards, páginas principales donde se muestran anuncios o banners
Cuándo NO usar: Cuando solo hay un banner o no se necesita carousel
Ejemplo: <x-announcement-carousel :apiUrl="route('announcements.api.banners', $store->slug)" />
--}}

@props([
    'apiUrl' => '',
    'height' => 'h-48', // h-32, h-48, h-64, h-96
])

<div class="relative w-full {{ $height }} rounded-xl overflow-hidden shadow-sm" 
     x-data="announcementCarousel()" 
     x-init="loadBanners()"
     {{ $attributes }}>
    {{-- Carousel Container --}}
    <div class="relative w-full h-full">
        <template x-for="(banner, index) in banners" :key="banner.id">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                 class="absolute inset-0 w-full h-full">
                <a :href="banner.banner_link || banner.show_url" 
                   class="block w-full h-full"
                   :target="banner.banner_link ? '_blank' : '_self'">
                    <img :src="banner.banner_image_url" 
                         :alt="banner.title"
                         class="w-full h-full object-cover">
                </a>
            </div>
        </template>
    </div>
    
    {{-- Navigation Arrows --}}
    <div x-show="banners.length > 1" class="absolute inset-0 flex items-center justify-between pointer-events-none">
        <button @click="previousSlide()" 
                class="ml-4 w-8 h-8 bg-black bg-opacity-40 hover:bg-opacity-60 rounded-full flex items-center justify-center text-white transition-all duration-200 pointer-events-auto">
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
        </button>
        <button @click="nextSlide()" 
                class="mr-4 w-8 h-8 bg-black bg-opacity-40 hover:bg-opacity-60 rounded-full flex items-center justify-center text-white transition-all duration-200 pointer-events-auto">
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
        </button>
    </div>
    
    {{-- Dots Indicator --}}
    <div x-show="banners.length > 1" class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex gap-2">
        <template x-for="(banner, index) in banners" :key="'dot-' + banner.id">
            <button @click="goToSlide(index)"
                    class="w-2 h-2 rounded-full transition-all duration-200"
                    :class="currentSlide === index ? 'bg-white' : 'bg-white bg-opacity-50'">
            </button>
        </template>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('announcementCarousel', () => ({
        banners: [],
        currentSlide: 0,
        autoplayInterval: null,
        autoplayDelay: 4000,
        
        async loadBanners() {
            try {
                const response = await fetch('{{ $apiUrl }}');
                const data = await response.json();
                this.banners = data;
                
                if (this.banners.length > 0) {
                    this.startAutoplay();
                }
            } catch (error) {
                // Error silencioso
            }
        },
        
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.banners.length;
            this.resetAutoplay();
        },
        
        previousSlide() {
            this.currentSlide = this.currentSlide === 0 ? this.banners.length - 1 : this.currentSlide - 1;
            this.resetAutoplay();
        },
        
        goToSlide(index) {
            this.currentSlide = index;
            this.resetAutoplay();
        },
        
        startAutoplay() {
            if (this.banners.length <= 1) return;
            
            this.autoplayInterval = setInterval(() => {
                this.nextSlide();
            }, this.autoplayDelay);
        },
        
        stopAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        },
        
        resetAutoplay() {
            this.stopAutoplay();
            this.startAutoplay();
        }
    }));
});

document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush

