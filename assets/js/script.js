document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('header');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    
    // Sticky Header on Scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Mobile Menu Toggle (Basic)
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', () => {
            alert('Menú móvil próximamente. Implementando navegación completa...');
        });
    }

    // --- Toast System ---
    const showToast = (message, icon = 'fa-check-circle') => {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `
            <i class="fa-solid ${icon}"></i>
            <span>${message}</span>
        `;
        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('removing');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };

    // --- Favorites Logic (localStorage) ---
    const getFavorites = () => JSON.parse(localStorage.getItem('dulceria_favorites')) || [];

    const saveFavorite = (product) => {
        const favs = getFavorites();
        if (!favs.find(f => f.id === product.id)) {
            favs.push(product);
            localStorage.setItem('dulceria_favorites', JSON.stringify(favs));
            showToast('¡Añadido a favoritos!', 'fa-heart');
        }
    };

    const removeFavorite = (id) => {
        const favs = getFavorites().filter(f => f.id !== id);
        localStorage.setItem('dulceria_favorites', JSON.stringify(favs));
        showToast('Eliminado de favoritos', 'fa-trash-can');
        
        // If we are on favorites page, re-render
        if (window.location.pathname.includes('favoritos.php')) {
            renderFavorites();
        }
    };

    // Initial check for heart icons
    const updateHeartIcons = () => {
        const favs = getFavorites();
        document.querySelectorAll('.product-card').forEach(card => {
            const id = card.getAttribute('data-id');
            const btn = card.querySelector('.fav-btn');
            const icon = btn.querySelector('i');
            if (favs.find(f => f.id === id)) {
                btn.classList.add('active');
                icon.classList.replace('fa-regular', 'fa-solid');
            }
        });
    };
    updateHeartIcons();

    // Favorite Button Toggle
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.fav-btn');
        if (!btn) return;
        
        e.preventDefault();
        const card = btn.closest('.product-card');
        const id = card.getAttribute('data-id');
        const icon = btn.querySelector('i');

        if (btn.classList.contains('active')) {
            btn.classList.remove('active');
            icon.classList.replace('fa-solid', 'fa-regular');
            removeFavorite(id);
        } else {
            btn.classList.add('active');
            icon.classList.replace('fa-regular', 'fa-solid');
            
            const product = {
                id: id,
                nombre: card.querySelector('h3').innerText,
                descripcion: card.querySelector('p').innerText,
                precio: card.getAttribute('data-price'),
                imagen: card.getAttribute('data-image'),
                categoria: card.querySelector('.category-label').innerText
            };
            saveFavorite(product);
        }
    });

    // --- Favorites Page Rendering ---
    const renderFavorites = () => {
        const container = document.getElementById('favorites-grid');
        const emptyState = document.getElementById('favorites-empty');
        if (!container) return;

        const favs = getFavorites();
        if (favs.length === 0) {
            container.style.display = 'none';
            emptyState.style.display = 'block';
        } else {
            container.style.display = 'grid';
            emptyState.style.display = 'none';
            container.innerHTML = favs.map(f => `
                <div class="product-card" data-id="${f.id}" data-price="${f.precio}" data-image="${f.imagen}">
                    <div class="product-img">
                        <img src="${f.imagen}" alt="${f.nombre}">
                    </div>
                    <div class="product-info">
                        <span class="category-label">${f.categoria}</span>
                        <h3>${f.nombre}</h3>
                        <p>${f.descripcion}</p>
                        <div class="product-footer">
                            <span class="product-price">$${f.precio}</span>
                            <div class="product-actions">
                                <button class="fav-btn active" title="Quitar de favoritos"><i class="fa-solid fa-heart"></i></button>
                                <a href="producto.php?id=${f.id}" class="view-more-btn">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    };
    renderFavorites();

    // --- Catalog Filtering & Search Logic ---
    const searchInput = document.getElementById('product-search');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    const emptyState = document.getElementById('empty-state');
    const catalogGrid = document.getElementById('catalog-grid');

    let activeCategory = 'all';
    let searchQuery = '';

    const filterProducts = () => {
        let visibleCount = 0;

        productCards.forEach(card => {
            const name = card.getAttribute('data-name');
            const category = card.getAttribute('data-category');

            const matchesSearch = name.includes(searchQuery.toLowerCase());
            const matchesCategory = activeCategory === 'all' || category === activeCategory;

            if (matchesSearch && matchesCategory) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Toggle empty state
        if (visibleCount === 0) {
            emptyState.style.display = 'block';
            catalogGrid.style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            catalogGrid.style.display = 'grid';
        }
    };

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value;
            filterProducts();
        });
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active state UI
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            activeCategory = btn.getAttribute('data-filter');
            filterProducts();
        });
    });

    // Reset Filters function (global for the empty state button)
    window.resetFilters = () => {
        if (searchInput) searchInput.value = '';
        searchQuery = '';
        activeCategory = 'all';
        
        filterButtons.forEach(b => {
            b.classList.remove('active');
            if (b.getAttribute('data-filter') === 'all') b.classList.add('active');
        });
        
        filterProducts();
    };
});
