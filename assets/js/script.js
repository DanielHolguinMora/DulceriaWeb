document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('header');
    
    // Sticky Header on Scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });


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
            if (!id || !btn) return;
            
            const icon = btn.querySelector('i');
            if (icon && favs.find(f => f.id === id)) {
                btn.classList.add('active');
                icon.classList.replace('fa-regular', 'fa-solid');
            }
        });

        // Also check detailed button if present on product detail page
        const detailedActions = document.querySelector('.product-actions-detailed');
        if (detailedActions) {
            const id = detailedActions.getAttribute('data-id');
            const btn = detailedActions.querySelector('.fav-btn-detailed');
            if (id && btn) {
                if (favs.find(f => f.id === id)) {
                    btn.classList.add('active');
                    btn.innerHTML = `<i class="fa-solid fa-heart"></i> Quitar de Favoritos`;
                }
            }
        }
    };
    updateHeartIcons();

    // Favorite Button Toggle (handles both cards and detailed page)
    document.addEventListener('click', (e) => {
        const cardBtn = e.target.closest('.fav-btn');
        const detailedBtn = e.target.closest('.fav-btn-detailed');
        
        if (!cardBtn && !detailedBtn) return;
        
        e.preventDefault();
        e.stopPropagation();

        if (cardBtn) {
            const card = cardBtn.closest('.product-card');
            const id = card.getAttribute('data-id');
            const icon = cardBtn.querySelector('i');
            const action = cardBtn.classList.contains('active') ? 'unlike' : 'like';

            if (action === 'unlike') {
                cardBtn.classList.remove('active');
                if (icon) icon.classList.replace('fa-solid', 'fa-regular');
                removeFavorite(id);
            } else {
                cardBtn.classList.add('active');
                if (icon) icon.classList.replace('fa-regular', 'fa-solid');
                
                const product = {
                    id: id,
                    nombre: card.querySelector('h3').innerText,
                    descripcion: card.querySelector('p') ? card.querySelector('p').innerText : '',
                    imagen: card.getAttribute('data-image'),
                    categoria: card.querySelector('.category-label').innerText
                };
                saveFavorite(product);
            }

            // Sync with DB
            toggleLikeDB(id, action);
        } else if (detailedBtn) {
            const container = detailedBtn.closest('.product-actions-detailed');
            const id = container.getAttribute('data-id');
            const action = detailedBtn.classList.contains('active') ? 'unlike' : 'like';

            if (action === 'unlike') {
                detailedBtn.classList.remove('active');
                detailedBtn.innerHTML = `<i class="fa-regular fa-heart"></i> Favoritos`;
                removeFavorite(id);
            } else {
                detailedBtn.classList.add('active');
                detailedBtn.innerHTML = `<i class="fa-solid fa-heart"></i> Quitar de Favoritos`;
                
                const product = {
                    id: id,
                    nombre: container.getAttribute('data-name'),
                    descripcion: container.getAttribute('data-description'),
                    imagen: container.getAttribute('data-image'),
                    categoria: container.getAttribute('data-category')
                };
                saveFavorite(product);
            }

            // Sync with DB
            toggleLikeDB(id, action);
        }
    });

    const toggleLikeDB = (id, action) => {
        fetch('toggle_like.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id, action: action })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update all cards with this product ID
                document.querySelectorAll(`.product-card[data-id="${id}"]`).forEach(card => {
                    const counter = card.querySelector('.likes-count');
                    if (counter) {
                        counter.innerText = data.likes;
                    }
                });
            } else {
                console.error('Error toggling like in database:', data.message);
            }
        })
        .catch(err => console.error('Error syncing like:', err));
    };

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
                <div class="product-card" data-id="${f.id}" data-image="${f.imagen}">
                    <div class="product-img">
                        <img src="${f.imagen}" alt="${f.nombre}">
                    </div>
                    <div class="product-info">
                        <span class="category-label">${f.categoria}</span>
                        <h3>${f.nombre}</h3>
                        <div class="product-footer">
                            <div class="product-actions" style="width: 100%; display: flex; justify-content: flex-end;">
                                <button class="fav-btn active" title="Quitar de favoritos"><i class="fa-solid fa-heart"></i></button>
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

        // Hide mobile keyboard when pressing "Enter"
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                searchInput.blur();
            }
        });
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active state UI
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            activeCategory = btn.getAttribute('data-filter');

            // Clear search bar when selecting 'Todo' (all)
            if (activeCategory === 'all') {
                if (searchInput) {
                    searchInput.value = '';
                }
                searchQuery = '';
            }

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

    // Category Carousel Scroll
    const carousel = document.getElementById('category-carousel');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtn = document.getElementById('carousel-next');

    if (carousel && prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -200, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: 200, behavior: 'smooth' });
        });

        // Hide/Show arrows based on scroll position (optional but nice)
        carousel.addEventListener('scroll', () => {
            prevBtn.style.opacity = carousel.scrollLeft <= 0 ? '0.3' : '1';
            prevBtn.style.pointerEvents = carousel.scrollLeft <= 0 ? 'none' : 'auto';
            
            const maxScroll = carousel.scrollWidth - carousel.clientWidth;
            nextBtn.style.opacity = carousel.scrollLeft >= maxScroll - 5 ? '0.3' : '1';
            nextBtn.style.pointerEvents = carousel.scrollLeft >= maxScroll - 5 ? 'none' : 'auto';
        });

        // Initialize arrows state
        prevBtn.style.opacity = '0.3';
        prevBtn.style.pointerEvents = 'none';
    }

    // --- Product Image Zoom & Lightbox ---
    const mainImageContainer = document.querySelector('.main-image');
    const mainProductImg = document.getElementById('main-product-img');

    if (mainImageContainer && mainProductImg) {
        // Amazon-like zoom effect on hover
        mainImageContainer.addEventListener('mousemove', (e) => {
            const rect = mainImageContainer.getBoundingClientRect();
            // Calculate mouse position relative to the container as a percentage
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;

            mainProductImg.style.transformOrigin = `${x}% ${y}%`;
            mainProductImg.style.transform = 'scale(2.2)';
        });

        mainImageContainer.addEventListener('mouseleave', () => {
            mainProductImg.style.transform = 'scale(1)';
            mainProductImg.style.transformOrigin = 'center center';
        });

        // Fullscreen Lightbox Modal on click
        mainImageContainer.addEventListener('click', () => {
            const imgSrc = mainProductImg.getAttribute('src');
            const imgAlt = mainProductImg.getAttribute('alt');

            // Create Lightbox Container
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox-modal';
            lightbox.innerHTML = `
                <button class="lightbox-close" aria-label="Cerrar"><i class="fa-solid fa-xmark"></i></button>
                <div class="lightbox-content">
                    <img src="${imgSrc}" alt="${imgAlt}">
                </div>
            `;

            document.body.appendChild(lightbox);
            
            // Force reflow and fade in
            setTimeout(() => {
                lightbox.classList.add('active');
            }, 10);

            // Close lightbox on click
            const closeLightbox = () => {
                lightbox.classList.remove('active');
                setTimeout(() => {
                    lightbox.remove();
                }, 300);
            };

            lightbox.addEventListener('click', (e) => {
                // Close if clicked outside the image itself or on the close button
                if (!e.target.closest('.lightbox-content img') || e.target.closest('.lightbox-close')) {
                    closeLightbox();
                }
            });

            // Close on escape key
            const handleEsc = (e) => {
                if (e.key === 'Escape') {
                    closeLightbox();
                    document.removeEventListener('keydown', handleEsc);
                }
            };
            document.addEventListener('keydown', handleEsc);
        });
    }

    // --- Product Card Click Navigation ---
    document.addEventListener('click', (e) => {
        const card = e.target.closest('.product-card');
        if (!card) return;

        // Ignore if the click is on the favorites button or inside it
        if (e.target.closest('.fav-btn')) return;

        const id = card.getAttribute('data-id');
        if (id) {
            window.location.href = `producto.php?id=${id}`;
        }
    });
});
