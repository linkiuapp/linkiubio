/**
 * Sistema de Favoritos - LocalStorage
 * Gestiona productos favoritos sin necesidad de registro
 */

const STORAGE_KEY = 'linkiu_favorites';

class Favorites {
    constructor(storeSlug) {
        this.storeSlug = storeSlug;
        this.storageKey = `${STORAGE_KEY}_${storeSlug}`;
        this.favorites = this.load();
    }

    /**
     * Cargar favoritos desde localStorage
     */
    load() {
        try {
            const stored = localStorage.getItem(this.storageKey);
            return stored ? JSON.parse(stored) : [];
        } catch (error) {
            console.error('Error loading favorites:', error);
            return [];
        }
    }

    /**
     * Guardar favoritos en localStorage
     */
    save() {
        try {
            localStorage.setItem(this.storageKey, JSON.stringify(this.favorites));
            this.updateUI();
            return true;
        } catch (error) {
            console.error('Error saving favorites:', error);
            return false;
        }
    }

    /**
     * Agregar producto a favoritos
     */
    add(productId) {
        productId = parseInt(productId);
        
        if (!this.favorites.includes(productId)) {
            this.favorites.push(productId);
            this.save();
            this.showToast('Producto agregado a favoritos ❤️');
            return true;
        }
        return false;
    }

    /**
     * Remover producto de favoritos
     */
    remove(productId) {
        productId = parseInt(productId);
        const index = this.favorites.indexOf(productId);
        
        if (index > -1) {
            this.favorites.splice(index, 1);
            this.save();
            this.showToast('Producto eliminado de favoritos');
            return true;
        }
        return false;
    }

    /**
     * Toggle (agregar o quitar) producto de favoritos
     */
    toggle(productId) {
        if (this.has(productId)) {
            return this.remove(productId);
        } else {
            return this.add(productId);
        }
    }

    /**
     * Verificar si un producto está en favoritos
     */
    has(productId) {
        return this.favorites.includes(parseInt(productId));
    }

    /**
     * Obtener cantidad de favoritos
     */
    count() {
        return this.favorites.length;
    }

    /**
     * Obtener todos los IDs de favoritos
     */
    getAll() {
        return [...this.favorites];
    }

    /**
     * Limpiar todos los favoritos
     */
    clear() {
        if (confirm('¿Estás seguro de que quieres eliminar todos los favoritos?')) {
            this.favorites = [];
            this.save();
            this.showToast('Todos los favoritos han sido eliminados');
            return true;
        }
        return false;
    }

    /**
     * Actualizar UI (botones, badges, etc)
     */
    updateUI() {
        // Actualizar contador en el menú
        this.updateMenuBadge();
        
        // Actualizar estados de los botones de favoritos
        this.updateFavoriteButtons();
        
        // Actualizar contador en la página de favoritos
        this.updateFavoritesPageCounter();
    }

    /**
     * Actualizar badge en el menú de navegación
     */
    updateMenuBadge() {
        const count = this.count();
        const badge = document.querySelector('#favorites-menu-badge');
        
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    /**
     * Actualizar estados visuales de los botones de favoritos
     */
    updateFavoriteButtons() {
        document.querySelectorAll('[data-favorite-btn]').forEach(btn => {
            const productId = parseInt(btn.dataset.productId);
            const icon = btn.querySelector('i[data-lucide]');
            
            if (this.has(productId)) {
                // Producto en favoritos - ESTADO ACTIVO
                // Cambiar clases del botón
                btn.className = 'p-1 md:p-2 flex items-center justify-center transition-transform bg-red-50 hover:bg-red-100 rounded-full hover:scale-110';
                btn.setAttribute('data-favorite-state', 'active');
                
                if (icon) {
                    icon.setAttribute('data-lucide', 'heart');
                    // Cambiar clases del icono - BLANCO en estado activo
                    icon.className = 'w-3 h-3 md:w-6 md:h-6 text-red-500';
                }
            } else {
                // Producto NO en favoritos - ESTADO DEFAULT
                // Cambiar clases del botón
                btn.className = 'p-1 md:p-2 flex items-center justify-center transition-transform bg-red-50 hover:bg-red-100 rounded-full hover:scale-110';
                btn.setAttribute('data-favorite-state', 'inactive');
                
                if (icon) {
                    icon.setAttribute('data-lucide', 'heart');
                    // Cambiar clases del icono - ROJO en estado default
                    icon.className = 'w-3 h-3 md:w-6 md:h-6 text-red-500';
                }
            }
        });

        // Reinicializar iconos de Lucide
        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
            window.createIcons({ icons: window.lucideIcons });
            
            // Después de reinicializar, aplicar fill a los SVGs
            document.querySelectorAll('[data-favorite-btn]').forEach(btn => {
                const productId = parseInt(btn.dataset.productId);
                const svg = btn.querySelector('svg');
                
                if (svg) {
                    if (this.has(productId)) {
                        // Corazón lleno
                        svg.style.fill = 'currentColor';
                    } else {
                        // Corazón vacío
                        svg.style.fill = 'none';
                    }
                }
            });
        }
    }

    /**
     * Actualizar contador en la página de favoritos
     */
    updateFavoritesPageCounter() {
        const counter = document.querySelector('#favorites-count');
        if (counter) {
            counter.textContent = this.count();
        }
    }

    /**
     * Mostrar toast de notificación
     */
    showToast(message, type = 'favorite') {
        // Usar el sistema unificado de toasts
        if (window.toast) {
            if (message.includes('agregado')) {
                window.toast.favorite('¡Añadido a favoritos!', message, 5000);
            } else if (message.includes('eliminado')) {
                window.toast.info('Favorito eliminado', message, 5000);
            } else {
                window.toast.info('Favoritos', message, 5000);
            }
        }
    }
}

/**
 * Cargar y mostrar favoritos en la página de favoritos
 */
export async function loadFavoritesPage(storeSlug) {
    const favorites = new Favorites(storeSlug);
    const favoriteIds = favorites.getAll();

    const loadingEl = document.getElementById('loading-favorites');
    const emptyStateEl = document.getElementById('empty-favorites-state');
    const gridEl = document.getElementById('favorites-grid');
    const gridContainer = document.getElementById('favorites-products-grid');

    // Ocultar loading
    loadingEl.classList.add('hidden');

    // Si no hay favoritos, mostrar estado vacío
    if (favoriteIds.length === 0) {
        emptyStateEl.classList.remove('hidden');
        gridEl.classList.add('hidden');
        favorites.updateFavoritesPageCounter();
        return;
    }

    // Mostrar grid
    emptyStateEl.classList.add('hidden');
    gridEl.classList.remove('hidden');

    try {
        // Obtener detalles de los productos desde la API
        const response = await fetch(`/${storeSlug}/favoritos/api/products`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                product_ids: favoriteIds
            })
        });

        if (!response.ok) {
            throw new Error('Error al cargar productos');
        }

        const data = await response.json();
        
        // Renderizar productos
        gridContainer.innerHTML = data.products.map(product => {
            // Convertir números a formato numérico para cálculos
            product.price = parseFloat(product.price) || 0;
            product.precio_promocional = parseFloat(product.precio_promocional) || 0;
            product.precio_final = parseFloat(product.precio_final) || product.price;
            product.stock_disponible = parseInt(product.stock_disponible) || 0;
            return createProductCard(product, storeSlug, favorites);
        }).join('');

        // Actualizar contador
        favorites.updateFavoritesPageCounter();

        // Reinicializar iconos de Lucide
        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
            window.createIcons({ icons: window.lucideIcons });
        }

        // Event listener para limpiar todos
        document.getElementById('clear-all-favorites-btn')?.addEventListener('click', () => {
            if (favorites.clear()) {
                loadFavoritesPage(storeSlug); // Recargar página
            }
        });

    } catch (error) {
        console.error('Error loading favorites:', error);
        gridContainer.innerHTML = `
            <div class="col-span-full text-center py-8">
                <p class="body-lg text-brandError-400">Error al cargar favoritos. Por favor, intenta nuevamente.</p>
            </div>
        `;
    }
}

/**
 * Crear HTML de card de producto (mismo diseño que catálogo)
 */
function createProductCard(product, storeSlug, favorites) {
    // Función helper para formatear números
    const formatPrice = (price) => {
        return Math.round(price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    };
    
    // Badge de stock
    let stockBadge = '';
    if (product.tiene_stock_bajo && product.stock_disponible > 0) {
        const unidadesText = product.stock_disponible > 1 ? 'es' : '';
        stockBadge = `
            <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                    <span class="bg-red-50 text-red-600 rounded-full px-2 py-1 text-xs font-semibold text-red-600">
                        Queda ${product.stock_disponible} unidad${unidadesText}
                    </span>
                </div>
                ${product.categories && product.categories.length > 0 ? `
                    <div class="flex flex-wrap gap-1">
                        <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-50 rounded-full">
                            ${product.categories[0].name}
                        </span>
                    </div>
                ` : ''}
            </div>
        `;
    } else if (product.esta_agotado) {
        stockBadge = `
            <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                <div class="flex items-center gap-1.5 w-fit">
                    <span class="text-xs font-medium text-white bg-red-500 px-2 py-0.5 rounded-full">
                        Agotado
                    </span>
                </div>
                ${product.categories && product.categories.length > 0 ? `
                    <div class="flex flex-wrap gap-1">
                        <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-50 rounded-full">
                            ${product.categories[0].name}
                        </span>
                    </div>
                ` : ''}
            </div>
        `;
    } else if (product.categories && product.categories.length > 0) {
        // Si no hay badge de stock pero hay categorías, mostrar solo la categoría
        stockBadge = `
            <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                <div class="flex flex-wrap gap-1">
                    <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-50 rounded-full">
                        ${product.categories[0].name}
                    </span>
                </div>
            </div>
        `;
    }
    
    // Precio con promoción
    let precioHtml = '';
    if (product.tiene_promocion) {
        precioHtml = `
            <div class="flex items-center gap-2">
                <span class="text-base font-normal text-slate-900 line-through">$${formatPrice(product.price)}</span>
                <span class="text-base font-bold text-slate-900">$${formatPrice(product.precio_final)}</span>
            </div>
        `;
    } else {
        precioHtml = `
            <div class="flex items-center gap-2">
                <span class="text-base font-bold text-slate-900">$${formatPrice(product.precio_final)}</span>
            </div>
        `;
    }
    
    // Botón de agregar al carrito (igual estructura que el componente add-to-cart-button)
    let cartButtonHtml = '';
    if (product.esta_agotado) {
        cartButtonHtml = `
            <div class="flex-shrink-0 relative">
                <button type="button"
                        disabled
                        class="bg-gray-300 text-gray-500 font-medium text-sm py-3 px-6 rounded-full transition-colors text-center cursor-not-allowed opacity-50 relative">
                        <span class="text-sm font-medium">Producto agotado</span>
                </button>
            </div>
        `;
    } else if (product.type === 'variable') {
        cartButtonHtml = `
            <div class="flex-shrink-0 relative">
                <button type="button"
                        onclick="event.stopPropagation(); event.preventDefault(); window.location.href='${product.url}';"
                        class="bg-slate-900 hover:bg-slate-800 text-white font-medium text-sm py-2 px-3 md:py-3 md:px-4 rounded-full transition-colors text-center">
                        <span class="text-sm font-medium">Ver producto</span>
                </button>
            </div>
        `;
    } else {
        cartButtonHtml = `
            <div class="flex-shrink-0 relative">
                <button type="button" 
                        class="add-to-cart-btn bg-slate-900 hover:bg-slate-800 text-white font-medium text-sm py-3 px-6 rounded-full transition-colors text-center relative" 
                        data-product-id="${product.id}"
                        data-product-name="${product.name.replace(/'/g, "\\'")}"
                        data-product-price="${product.precio_final}"
                        data-product-image="${product.image_url || ''}"
                        onclick="event.stopPropagation(); event.preventDefault();">
                        <span class="text-sm font-medium">Agregar</span>
                </button>
            </div>
        `;
    }
    
    // Obtener el color de fondo de la card (igual que en catálogo)
    const cardBgColor = window.FAVORITES_CARD_BG_COLOR || 'rgba(249, 250, 251, 0.1)';
    const cardBgStyle = `background-color: ${cardBgColor};`;
    
    return `
        <div class="flex gap-2 md:gap-4 rounded-xl p-4 md:p-4 transition-all duration-200 hover:shadow-sm relative" style="${cardBgStyle}">
            <div class="flex items-center gap-4 flex-1 min-w-0">
                <!-- Imagen del producto -->
                <a href="${product.url}" class="w-[120px] h-[120px] md:w-[126px] md:h-[126px] rounded-lg flex-shrink-0 overflow-hidden cursor-pointer">
                    ${product.image_url ? `
                        <img src="${product.image_url}" 
                             alt="${product.name}" 
                             class="w-full h-full object-cover hover:opacity-90 transition-opacity"
                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\\'w-full h-full flex items-center justify-center bg-gray-100\\'><i data-lucide=\\'image\\' class=\\'w-6 h-6 text-gray-400\\'></i></div>';">
                    ` : `
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                        </div>
                    `}
                </a>

                <!-- Información del producto -->
                <div class="flex-1 min-w-0 flex flex-col md:gap-1 gap-0">
                    ${stockBadge}
                    
                    <!-- Título del producto -->
                    <a href="${product.url}" class="text-base font-bold text-slate-900 leading-tight hover:text-blue-600 transition-colors cursor-pointer">${product.name}</a>
                    
                    <!-- Descripción -->
                    ${product.description ? `<p class="text-xs font-normal text-slate-900 leading-tight line-clamp-1">${product.description}</p>` : ''}

                    <!-- Precios -->
                    ${precioHtml}

                    <!-- Botones de acción -->
                    <div class="flex gap-2 items-center md:mt-0 mt-2">
                        ${cartButtonHtml}
                        <button class="p-3 flex items-center justify-center transition-transform bg-red-50 hover:bg-red-100 rounded-full hover:scale-110"
                                onclick="event.preventDefault(); event.stopPropagation(); window.favoritesManager.remove(${product.id}); loadFavoritesPage('${storeSlug}');"
                                data-favorite-btn
                                data-product-id="${product.id}">
                            <i data-lucide="heart" class="w-6 h-6 text-red-500 hover:text-red-600" style="fill: currentColor;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

/**
 * Inicializar sistema de favoritos globalmente
 */
export function initFavorites(storeSlug) {
    // Crear instancia global
    window.favoritesManager = new Favorites(storeSlug);
    
    // Actualizar UI inicial
    window.favoritesManager.updateUI();
    
    // Event listeners para botones de favoritos
    document.addEventListener('click', function(e) {
        const favoriteBtn = e.target.closest('[data-favorite-btn]');
        if (favoriteBtn) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = favoriteBtn.dataset.productId;
            window.favoritesManager.toggle(productId);
        }
    });
    
    // Hacer loadFavoritesPage disponible globalmente
    window.loadFavoritesPage = loadFavoritesPage;
}

// Exportar para uso en otros módulos
export default Favorites;

