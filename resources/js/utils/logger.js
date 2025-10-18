/**
 * 🛡️ Sistema de Logging Inteligente
 * 
 * - En desarrollo: Muestra todos los logs
 * - En producción: Solo errores críticos
 * - Previene exposición de data sensible
 */

const isDevelopment = import.meta.env.DEV;
const isProduction = import.meta.env.PROD;

const logger = {
    /**
     * 🔵 INFO - Solo en desarrollo
     * Úsalo para debugging general
     */
    info(...args) {
        if (isDevelopment) {
            console.log(...args);
        }
    },

    /**
     * ✅ SUCCESS - Solo en desarrollo
     * Para operaciones exitosas
     */
    success(...args) {
        if (isDevelopment) {
            console.log(...args);
        }
    },

    /**
     * ⚠️ WARNING - Siempre (pero sin data sensible)
     * Para advertencias importantes
     */
    warn(...args) {
        if (isDevelopment) {
            console.warn(...args);
        }
        // En producción, podrías enviar a servicio de monitoring
    },

    /**
     * 🔴 ERROR - Siempre
     * Para errores que deben ser capturados
     */
    error(...args) {
        console.error(...args);
        
        // TODO: En futuro, integrar con Sentry o similar
        // if (isProduction) {
        //     Sentry.captureException(args[0]);
        // }
    },

    /**
     * 🐛 DEBUG - Solo en desarrollo con flag especial
     * Para debugging profundo
     */
    debug(...args) {
        if (isDevelopment && window._debugMode) {
            console.log('🐛 [DEBUG]', ...args);
        }
    },

    /**
     * 📊 TABLE - Solo en desarrollo
     * Para mostrar data tabular
     */
    table(data) {
        if (isDevelopment) {
            console.table(data);
        }
    },

    /**
     * ⏱️ TIME - Solo en desarrollo
     * Para medir performance
     */
    time(label) {
        if (isDevelopment) {
            console.time(label);
        }
    },

    timeEnd(label) {
        if (isDevelopment) {
            console.timeEnd(label);
        }
    },

    /**
     * 🎯 GROUP - Solo en desarrollo
     * Para agrupar logs relacionados
     */
    group(label) {
        if (isDevelopment) {
            console.group(label);
        }
    },

    groupEnd() {
        if (isDevelopment) {
            console.groupEnd();
        }
    }
};

// Activar modo debug desde console: window._debugMode = true
window._debugMode = false;

export default logger;

