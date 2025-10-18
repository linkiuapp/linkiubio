/**
 * 🛡️ SISTEMA DE SEGURIDAD FRONTEND
 * 
 * - Detecta DevTools abierto
 * - Muestra advertencia de seguridad
 * - Previene ataques de ingeniería social
 */

import logger from './utils/logger';

/**
 * 🚨 Mostrar advertencia de seguridad en consola
 * Similar a Facebook, WhatsApp, etc.
 */
export function showSecurityWarning() {
    // Solo en producción
    if (!import.meta.env.PROD) return;

    try {
        // Limpiar consola primero
        console.clear();

        // Header grande y llamativo
        console.log(
            '%c⛔ ¡ALTO!',
            'color: #ff0000; font-size: 60px; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);'
        );

        // Advertencia principal
        console.log(
            '%c🛡️ ADVERTENCIA DE SEGURIDAD',
            'color: #ff3333; font-size: 24px; font-weight: bold; padding: 10px 0;'
        );

        console.log(
            '%cEsta es una función del navegador destinada para desarrolladores.',
            'font-size: 16px; color: #333; line-height: 1.8;'
        );

        console.log(
            '%c⚠️ Si alguien te dijo que copiaras y pegaras algo aquí para "hackear" una cuenta, obtener acceso especial, o cualquier cosa similar, es un FRAUDE.',
            'font-size: 16px; color: #ff0000; font-weight: bold; line-height: 1.8; background: #fff3cd; padding: 10px; border-left: 4px solid #ff0000;'
        );

        console.log(
            '%cPegar código malicioso aquí puede darle a atacantes acceso a tu cuenta.',
            'font-size: 14px; color: #721c24; background: #f8d7da; padding: 8px; border-radius: 4px;'
        );

        console.log(
            '%c📚 A menos que sepas exactamente lo que estás haciendo, cierra esta ventana y mantente seguro.',
            'font-size: 14px; color: #004085; background: #cce5ff; padding: 8px; border-radius: 4px; margin-top: 10px;'
        );

        console.log(
            '%c🔗 Más información: https://linkiu.bio/seguridad',
            'font-size: 12px; color: #666; margin-top: 10px;'
        );

        // Separador
        console.log(
            '%c' + '═'.repeat(80),
            'color: #ddd;'
        );

    } catch (error) {
        // Silencioso en caso de error
    }
}

/**
 * 🔍 Detectar si DevTools está abierto
 */
let devtoolsOpen = false;
let devtoolsCheckInterval = null;

function detectDevTools() {
    const threshold = 160;
    const widthThreshold = window.outerWidth - window.innerWidth > threshold;
    const heightThreshold = window.outerHeight - window.innerHeight > threshold;
    const orientationThreshold = window.Firebug && window.Firebug.chrome && window.Firebug.chrome.isInitialized;

    if (widthThreshold || heightThreshold || orientationThreshold) {
        if (!devtoolsOpen) {
            devtoolsOpen = true;
            showSecurityWarning();
            
            // Dispatch event para que otros componentes puedan reaccionar
            window.dispatchEvent(new CustomEvent('devtools-opened'));
        }
    } else {
        devtoolsOpen = false;
    }
}

/**
 * 🚀 Inicializar detección de DevTools
 */
export function initDevToolsDetection() {
    // Solo en producción
    if (!import.meta.env.PROD) return;

    // Mostrar warning inicial
    showSecurityWarning();

    // Revisar cada 2 segundos
    devtoolsCheckInterval = setInterval(detectDevTools, 2000);

    logger.info('🛡️ Security monitoring initialized');
}

/**
 * 🛑 Detener detección
 */
export function stopDevToolsDetection() {
    if (devtoolsCheckInterval) {
        clearInterval(devtoolsCheckInterval);
        devtoolsCheckInterval = null;
    }
}

/**
 * 🚫 Deshabilitar click derecho (OPCIONAL - comentado por defecto)
 */
export function disableRightClick() {
    // Solo en producción
    if (!import.meta.env.PROD) return;

    // ⚠️ DESCOMENTAR SOLO SI REALMENTE LO NECESITAS
    // Puede molestar a usuarios legítimos
    /*
    document.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        logger.warn('⚠️ Click derecho deshabilitado por seguridad');
        return false;
    });
    */
}

/**
 * 🔒 Prevenir copy/paste de scripts maliciosos
 */
export function preventMaliciousPaste() {
    // Solo en producción
    if (!import.meta.env.PROD) return;

    // Detectar paste en consola (esto no previene realmente, pero puedes loggear)
    window.addEventListener('paste', (e) => {
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        
        // Detectar patrones sospechosos
        const suspiciousPatterns = [
            /javascript:/i,
            /<script/i,
            /eval\(/i,
            /document\.cookie/i,
            /localStorage/i,
            /sessionStorage/i,
        ];

        const isSuspicious = suspiciousPatterns.some(pattern => pattern.test(pastedText));

        if (isSuspicious && pastedText.length > 50) {
            logger.warn('⚠️ Posible intento de paste malicioso detectado');
            // En producción, podrías enviar alerta a backend
        }
    });
}

// Auto-inicializar en producción
if (import.meta.env.PROD) {
    // Esperar a que el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            initDevToolsDetection();
            preventMaliciousPaste();
        });
    } else {
        initDevToolsDetection();
        preventMaliciousPaste();
    }
}

