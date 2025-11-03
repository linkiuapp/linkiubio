import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/wizard.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,    // Elimina console.log en producción
                drop_debugger: true,   // Elimina debugger statements
                pure_funcs: ['console.log', 'console.info', 'console.debug'],
            },
            format: {
                comments: false,       // Elimina comentarios
            }
        },
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    // Separar Litepicker en un chunk propio (lazy loading)
                    if (id.includes('litepicker')) {
                        return 'litepicker';
                    }
                    // Separar Lucide icons en un chunk propio
                    if (id.includes('lucide')) {
                        return 'lucide';
                    }
                    // Separar Alpine.js en un chunk propio
                    if (id.includes('alpinejs') || id.includes('alpine')) {
                        return 'alpine';
                    }
                },
            },
        },
        // Aumentar el límite de advertencia a 600 KB (el bundle principal puede ser grande con todas las dependencias)
        chunkSizeWarningLimit: 600,
    },
});