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
                btn.className = 'p-2 w-11 h-11 flex items-center justify-center transition-transform bg-brandError-50 hover:bg-brandError-300 hover:text-brandError-50 rounded-lg hover:scale-110';
                btn.setAttribute('data-favorite-state', 'active');
                
                if (icon) {
                    icon.setAttribute('data-lucide', 'heart');
                    // Cambiar clases del icono - BLANCO en estado activo
                    icon.className = 'w-6 h-6 text-brandError-50';
                }
            } else {
                // Producto NO en favoritos - ESTADO DEFAULT
                // Cambiar clases del botón
                btn.className = 'p-2 w-11 h-11 flex items-center justify-center transition-transform bg-brandError-50 hover:bg-brandError-300 rounded-lg hover:scale-110';
                btn.setAttribute('data-favorite-state', 'inactive');
                
                if (icon) {
                    icon.setAttribute('data-lucide', 'heart');
                    // Cambiar clases del icono - ROJO en estado default
                    icon.className = 'w-6 h-6 text-brandError-400';
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
    showToast(message) {
        // Usar el sistema de toasts global si existe
        if (typeof window.showToast === 'function') {
            window.showToast('success', message);
        } else {
            // Fallback: console
            console.log(message);
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
        gridContainer.innerHTML = data.products.map(product => createProductCard(product, storeSlug, favorites)).join('');

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
 * Crear HTML de card de producto (estilo lista horizontal)
 */
function createProductCard(product, storeSlug, favorites) {
    const isFavorite = favorites.has(product.id);
    
    // Botón de carrito o ver producto (según tipo)
    const cartButton = product.type === 'variable' 
        ? `<button type="button"
                   onclick="event.stopPropagation(); event.preventDefault(); window.location.href='${product.url}';"
                   class="bg-brandPrimary-300 hover:bg-brandPrimary-400 w-11 h-11 rounded-lg flex items-center justify-center transition-colors">
               <i data-lucide="eye" class="w-16px h-16px text-brandWhite-200"></i>
           </button>`
        : `<button type="button" 
                   class="add-to-cart-btn bg-brandPrimary-300 hover:bg-brandPrimary-400 w-11 h-11 rounded-lg flex items-center justify-center transition-colors" 
                   data-product-id="${product.id}"
                   data-product-name="${product.name}"
                   data-product-price="${product.price}"
                   data-product-image="${product.image_url}"
                   onclick="event.stopPropagation(); event.preventDefault();">
               <i data-lucide="badge-plus" class="w-16px h-16px text-brandWhite-200"></i>
           </button>`;
    
    return `
        <a href="${product.url}" 
           class="bg-brandWhite-100 hover:bg-brandPrimary-50 rounded-lg p-4 hover:shadow-sm transition-all duration-200 block relative">
            <div class="flex items-center gap-3">
                <!-- Imagen del producto -->
                <div class="w-[78px] h-[78px] rounded-lg flex-shrink-0 overflow-hidden">
                    <img src="${product.image_url}" 
                         alt="${product.name}" 
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/78x78?text=Sin+Imagen';">
                </div>

                <!-- Información del producto -->
                <div class="flex-1 min-w-0">
                    <h3 class="body-lg-bold text-brandNeutral-400 line-clamp-1">${product.name}</h3>
                    
                    ${product.description ? `<p class="caption text-brandNeutral-400 line-clamp-1">${product.description}</p>` : ''}

                    <!-- Precio prominente -->
                    <div class="body-lg-bold text-brandNeutral-400 mb-1">
                        ${product.formatted_price}
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex flex-col gap-2">
                    <!-- Botón agregar al carrito o ver opciones -->
                    ${cartButton}
                    
                    <!-- Botón quitar de favoritos -->
                    <button class="p-2 w-11 h-11 flex items-center justify-center transition-transform bg-brandError-300 hover:bg-brandError-50 rounded-lg hover:scale-110"
                            onclick="event.preventDefault(); event.stopPropagation(); window.favoritesManager.remove(${product.id}); this.closest('a').remove(); if(window.favoritesManager.count() === 0) { window.location.reload(); }"
                            data-favorite-btn
                            data-product-id="${product.id}">
                        <i data-lucide="heart" class="w-6 h-6 text-brandError-50 hover:text-brandError-300" style="fill: currentColor;"></i>
                    </button>
                </div>
            </div>
        </a>
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

