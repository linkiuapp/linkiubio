<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 🛡️ Security Headers Middleware
 * 
 * Agrega headers de seguridad recomendados por OWASP
 * para proteger contra ataques comunes.
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 🛡️ Content Security Policy (CSP)
        // Previene XSS, Clickjacking, y data injection
        $csp = $this->buildContentSecurityPolicy();
        $response->headers->set('Content-Security-Policy', $csp);

        // 🔒 X-Content-Type-Options
        // Previene MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 🖼️ X-Frame-Options
        // Previene clickjacking (DENY = no se puede embedear en iframe)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 🛡️ X-XSS-Protection
        // Activa protección XSS del navegador
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // 🔗 Referrer-Policy
        // Controla cuánta información de referrer se envía
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 🚫 Permissions-Policy (antes Feature-Policy)
        // Controla qué features del navegador pueden usarse
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // 🔐 Strict-Transport-Security (HSTS)
        // SOLO EN PRODUCCIÓN CON HTTPS
        if (config('app.env') === 'production' && $request->secure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // ⚡ Cache-Control para Edge Network
        // Solo agregar headers de cache a recursos estáticos
        if (!$request->is('*/admin/*') && !$request->is('*api*') && !auth()->check()) {
            // Assets estáticos (CSS, JS, imágenes) - Cache por 1 año
            if (preg_match('/\.(css|js|jpg|jpeg|png|gif|svg|ico|woff|woff2|ttf|eot)$/', $request->path())) {
                $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
            }
            // Páginas públicas (landing, catálogo) - Cache por 5 minutos
            elseif ($request->is('*/') || $request->is('*/cat*')) {
                $response->headers->set('Cache-Control', 'public, max-age=300');
            }
        }

        return $response;
    }

    /**
     * 🔨 Construir Content Security Policy
     */
    private function buildContentSecurityPolicy(): string
    {
        $directives = [
            // Fuentes por defecto
            "default-src 'self'",

            // Scripts: self + inline (Alpine.js) + eval (Alpine.js) + CDNs necesarios
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://js.pusher.com https://unpkg.com",

            // Estilos: self + inline (Tailwind) + Google Fonts
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net",

            // Imágenes: self + data URIs + cualquier HTTPS (productos de usuarios)
            "img-src 'self' data: https: blob:",

            // Fuentes: self + data URIs + Google Fonts
            "font-src 'self' data: https://fonts.gstatic.com",

            // Conexiones AJAX: self + Pusher
            "connect-src 'self' https://api.linkiu.bio wss://ws.pusher.com https://sockjs.pusher.com",

            // Frames: ninguno (previene clickjacking)
            "frame-ancestors 'none'",

            // Base URI: solo self
            "base-uri 'self'",

            // Form actions: solo self
            "form-action 'self'",

            // Object/Embed (Flash, Java, etc): ninguno
            "object-src 'none'",

            // Media: self
            "media-src 'self'",

            // Workers: self
            "worker-src 'self' blob:",

            // Manifest: self
            "manifest-src 'self'",
        ];

        return implode('; ', $directives);
    }
}

