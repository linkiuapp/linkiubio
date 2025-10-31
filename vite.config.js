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
                manualChunks: undefined,
            },
        },

    },
});