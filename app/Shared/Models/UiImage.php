<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class UiImage extends Model
{
    protected $fillable = [
        'context',
        'category',
        'name',
        'url',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'is_active',
        'sort_order',
        'metadata',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
        'sort_order' => 'integer',
        'metadata' => 'array',
    ];

    // Constantes de contexto
    const CONTEXT_STORE = 'store';
    const CONTEXT_TENANT_ADMIN = 'tenant_admin';
    const CONTEXT_WEBSITE = 'website';
    const CONTEXT_SUPER_ADMIN = 'super_admin';

    const CONTEXTS = [
        self::CONTEXT_STORE => 'Tiendas',
        self::CONTEXT_TENANT_ADMIN => 'Admin de Tiendas',
        self::CONTEXT_WEBSITE => 'Sitio Web',
        self::CONTEXT_SUPER_ADMIN => 'Super Admin',
    ];

    // Constantes de categorías comunes
    const CATEGORY_CHECKOUT_SUCCESS = 'checkout_success';
    const CATEGORY_LOGIN_BANNER = 'login_banner';
    const CATEGORY_LOGIN_LOGO = 'login_logo';
    const CATEGORY_PRODUCT_PLACEHOLDER = 'product_placeholder';
    const CATEGORY_STORE_BANNER = 'store_banner';
    const CATEGORY_DASHBOARD_WIDGETS = 'dashboard_widgets';
    const CATEGORY_LANDING_HERO = 'landing_hero';
    const CATEGORY_FEATURES_ICONS = 'features_icons';
    const CATEGORY_FOOTER_LOGO = 'footer_logo';

    /**
     * Obtener todas las categorías predefinidas con sus etiquetas y descripciones
     * Retorna un array con: 'value' => ['label' => '...', 'description' => '...', 'contexts' => [...]]
     */
    public static function getPredefinedCategories(): array
    {
        return [
            self::CATEGORY_CHECKOUT_SUCCESS => [
                'label' => '🎉 Página de Éxito de Compra',
                'description' => 'Banners que aparecen después de completar una compra en la tienda',
                'contexts' => ['store'],
                'location' => 'Tienda → Página de éxito de checkout'
            ],
            self::CATEGORY_LOGIN_BANNER => [
                'label' => '🖼️ Banner Lateral de Login',
                'description' => 'Imagen grande que aparece en el lado izquierdo de las páginas de login',
                'contexts' => ['tenant_admin', 'super_admin'],
                'location' => 'Admin/Login → Lado izquierdo (desktop)'
            ],
            self::CATEGORY_LOGIN_LOGO => [
                'label' => '🏢 Logo en Página de Login',
                'description' => 'Logo que aparece arriba del formulario de login',
                'contexts' => ['tenant_admin', 'super_admin'],
                'location' => 'Admin/Login → Arriba del formulario'
            ],
            self::CATEGORY_PRODUCT_PLACEHOLDER => [
                'label' => '📦 Placeholder de Producto',
                'description' => 'Imagen que se muestra cuando un producto no tiene foto',
                'contexts' => ['store', 'tenant_admin'],
                'location' => 'Tienda/Admin → Productos sin imagen'
            ],
            self::CATEGORY_STORE_BANNER => [
                'label' => '🏪 Banner Principal de Tienda',
                'description' => 'Banner que se muestra en la página principal de la tienda',
                'contexts' => ['store'],
                'location' => 'Tienda → Página de inicio'
            ],
            self::CATEGORY_DASHBOARD_WIDGETS => [
                'label' => '📊 Widgets del Dashboard',
                'description' => 'Iconos y gráficos para widgets del panel de administración',
                'contexts' => ['tenant_admin', 'super_admin'],
                'location' => 'Admin → Dashboard principal'
            ],
            self::CATEGORY_LANDING_HERO => [
                'label' => '🎯 Hero de Landing Page',
                'description' => 'Imagen principal de la página de inicio del sitio web',
                'contexts' => ['website'],
                'location' => 'Sitio Web → Página principal (hero section)'
            ],
            self::CATEGORY_FEATURES_ICONS => [
                'label' => '✨ Iconos de Características',
                'description' => 'Iconos para sección de características o beneficios',
                'contexts' => ['website', 'store'],
                'location' => 'Sitio Web/Tienda → Sección de características'
            ],
            self::CATEGORY_FOOTER_LOGO => [
                'label' => '🔗 Logo en Footer',
                'description' => 'Logo que aparece en el pie de página',
                'contexts' => ['website', 'store'],
                'location' => 'Sitio Web/Tienda → Footer (pie de página)'
            ],
        ];
    }

    /**
     * Obtener categorías agrupadas por contexto
     */
    public static function getCategoriesByContext(string $context): array
    {
        $allCategories = self::getPredefinedCategories();
        $filtered = [];
        
        foreach ($allCategories as $key => $data) {
            if (in_array($context, $data['contexts'])) {
                $filtered[$key] = $data;
            }
        }
        
        return $filtered;
    }

    /**
     * Obtener todas las categorías disponibles (predefinidas + de BD) para un contexto específico
     * Formato: ['key' => 'label completo para mostrar']
     */
    public static function getAvailableCategories(?string $context = null): array
    {
        $predefined = self::getPredefinedCategories();
        
        // Filtrar por contexto si se especifica
        if ($context) {
            $predefined = array_filter($predefined, function($data) use ($context) {
                return in_array($context, $data['contexts']);
            });
        }
        
        // Convertir a formato simple para el select
        $formatted = [];
        foreach ($predefined as $key => $data) {
            $formatted[$key] = $data['label'] . ' - ' . $data['location'];
        }
        
        // Obtener categorías existentes en BD que no estén en predefinidas
        $query = self::select('category')->distinct();
        if ($context) {
            $query->where('context', $context);
        }
        
        $dbCategories = $query
            ->whereNotIn('category', array_keys($predefined))
            ->orderBy('category')
            ->pluck('category')
            ->mapWithKeys(fn($cat) => [
                $cat => '📌 ' . ucfirst(str_replace('_', ' ', $cat)) . ' (Personalizada)'
            ])
            ->toArray();
        
        return array_merge($formatted, $dbCategories);
    }

    /**
     * Obtener información completa de una categoría (para mostrar descripción)
     */
    public static function getCategoryInfo(string $category): ?array
    {
        $categories = self::getPredefinedCategories();
        return $categories[$category] ?? null;
    }

    /**
     * Relación con el usuario que creó la imagen
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(\App\Shared\Models\User::class, 'created_by');
    }

    /**
     * Scope: solo imágenes activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: filtrar por contexto
     */
    public function scopeByContext($query, string $context)
    {
        return $query->where('context', $context);
    }

    /**
     * Scope: filtrar por categoría
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: ordenar por sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * Obtener URL completa de la imagen
     */
    public function getUrlAttribute(): string
    {
        if (!$this->file_path) {
            return '';
        }
        
        // Limpiar 'storage/' si existe por compatibilidad con registros antiguos
        $path = str_replace('storage/', '', $this->file_path);
        
        // Usar Storage::url() para compatibilidad con S3/Laravel Cloud
        try {
            return Storage::disk('public')->url($path);
        } catch (\Exception $e) {
            \Log::error('Error generando URL de imagen UI', [
                'image_id' => $this->id,
                'file_path' => $this->file_path,
                'error' => $e->getMessage()
            ]);
            return '';
        }
    }

    /**
     * Validar que el formato sea SVG o WebP
     */
    public static function isValidMimeType(string $mimeType): bool
    {
        return in_array($mimeType, [
            'image/svg+xml',
            'image/webp',
        ]);
    }
}
