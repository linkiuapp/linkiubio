import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/wizard.css',
                'resources/css/tours.css',
                'resources/js/app.js',
                'resources/js/tours/tour-manager.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build', // MOVIDO AQUÍ - Laravel espera los assets en public/build
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
                pure_funcs: ['console.log', 'console.info', 'console.debug'],
            },
            format: {
                comments: false,
            },
            // outDir NO va aquí
        },
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    if (id.includes('litepicker')) {
                        return 'litepicker';
                    }
                    if (id.includes('lucide')) {
                        return 'lucide';
                    }
                    if (id.includes('alpinejs') || id.includes('alpine')) {
                        return 'alpine';
                    }
                    if (id.includes('driver.js') || id.includes('driver')) {
                        return 'driver';
                    }
                },
            },
        },
        chunkSizeWarningLimit: 600,
    },
});