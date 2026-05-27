document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('header');

    // --- Carga de Esqueletor (Favoritos de la Comunidad) ---
    window.addEventListener('load', () => {
        const skeletonGrid = document.getElementById('skeleton-grid');
        const featuredGrid = document.getElementById('featured-grid');
        if (skeletonGrid && featuredGrid) {
            setTimeout(() => {
                skeletonGrid.style.display = 'none';
                featuredGrid.style.display = 'grid';
            }, 800);
        }
    });

    // Header pegajoso al hacer scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });


    // --- Sistema de Notificaciones ---
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

    // --- Logica de Favoritos (localStorage) ---
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

        // Si estamos en la pagina de favoritos, renderizamos
        if (window.location.pathname.includes('favoritos.php')) {
            renderFavorites();
        }
    };

    // Verificacion de iconos de corazones
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

        // Tambien verificar el boton detallado si esta presente en la pagina de detalles
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

    // Boton de Favoritos con Toggle
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
                    categoria: card.querySelector('.category-label').innerText,
                    marca: card.getAttribute('data-brand-name') || ''
                };
                saveFavorite(product);
            }

            // Sincronizar con la base de datos
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
                    categoria: container.getAttribute('data-category'),
                    marca: container.getAttribute('data-brand') || ''
                };
                saveFavorite(product);
            }

            // Sincronizar con la base de datos
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
                    // Actualizar todas las tarjetas con este ID de producto
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

    // --- Pagina de Favoritos (Renderizado y Filtrado) ---
    const filterFavorites = () => {
        const catSelect = document.getElementById('fav-filter-category');
        const brandSelect = document.getElementById('fav-filter-brand');
        const container = document.getElementById('favorites-grid');
        const filterEmptyState = document.getElementById('favorites-filter-empty');

        if (!container || !catSelect || !brandSelect) return;

        const catVal = catSelect.value.toLowerCase().trim().replace(/\s+/g, '-');
        const brandVal = brandSelect.value.toLowerCase().trim().replace(/\s+/g, '-');

        const cards = container.querySelectorAll('.product-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardCat = (card.getAttribute('data-category') || '').toLowerCase().trim();
            const cardBrand = (card.getAttribute('data-brand') || '').toLowerCase().trim();

            const matchCat = catVal === 'all' || cardCat === catVal;
            const matchBrand = brandVal === 'all' || cardBrand === brandVal;

            if (matchCat && matchBrand) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (filterEmptyState) {
            if (visibleCount === 0 && cards.length > 0) {
                filterEmptyState.style.display = 'block';
                container.style.display = 'none';
            } else {
                filterEmptyState.style.display = 'none';
                if (cards.length > 0) {
                    container.style.display = 'grid';
                }
            }
        }
    };

    const renderFavorites = () => {
        const container = document.getElementById('favorites-grid');
        const emptyState = document.getElementById('favorites-empty');
        const filterToolbar = document.getElementById('favorites-toolbar');
        const filterEmptyState = document.getElementById('favorites-filter-empty');

        if (!container) return;

        const favs = getFavorites();
        if (favs.length === 0) {
            container.style.display = 'none';
            if (filterToolbar) filterToolbar.style.display = 'none';
            if (filterEmptyState) filterEmptyState.style.display = 'none';
            emptyState.style.display = 'block';
        } else {
            container.style.display = 'grid';
            if (filterToolbar) filterToolbar.style.display = 'flex';
            emptyState.style.display = 'none';
            if (filterEmptyState) filterEmptyState.style.display = 'none';

            container.innerHTML = favs.map(f => {
                const categoryClass = (f.categoria || '').toLowerCase().trim().replace(/\s+/g, '-');
                const brandClass = (f.marca || '').toLowerCase().trim().replace(/\s+/g, '-');
                const brandName = f.marca || '';

                return `
                    <div class="product-card" data-id="${f.id}" data-image="${f.imagen}" data-category="${categoryClass}" data-brand="${brandClass}">
                        <div class="product-img">
                            <img src="${f.imagen}" alt="${f.nombre}">
                        </div>
                        <div class="product-info">
                            <span class="category-label">${f.categoria}</span>
                            <h3>${f.nombre}</h3>
                            ${brandName ? `<span class="brand-label"><i class="fa-solid fa-copyright"></i> ${brandName}</span>` : ''}
                            <div class="product-footer">
                                <div class="product-actions" style="width: 100%; display: flex; justify-content: flex-end;">
                                    <button class="fav-btn active" title="Quitar de favoritos"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            // Filtra inmediatamente por si los filtros ya estan seleccionados
            filterFavorites();
        }
    };

    // Inicializar Pagina de Favoritos
    if (document.getElementById('favorites-grid')) {
        renderFavorites();

        // Event listeners de filtros
        const catSelect = document.getElementById('fav-filter-category');
        const brandSelect = document.getElementById('fav-filter-brand');

        if (catSelect) {
            catSelect.addEventListener('change', filterFavorites);
        }
        if (brandSelect) {
            brandSelect.addEventListener('change', filterFavorites);
        }
    }

    // Eliminar Todos los Favoritos
    window.clearAllFavorites = () => {
        if (confirm('¿Estás seguro de que deseas eliminar todos tus favoritos?')) {
            const favs = getFavorites();

            // Eliminar favoritos de la base de datos
            favs.forEach(f => {
                toggleLikeDB(f.id, 'unlike');
            });

            localStorage.removeItem('dulceria_favorites');
            showToast('Todos los favoritos han sido eliminados', 'fa-trash-can');
            renderFavorites();
        }
    };

    // Reset Filtros de Favoritos
    window.resetFavFilters = () => {
        const catSelect = document.getElementById('fav-filter-category');
        const brandSelect = document.getElementById('fav-filter-brand');

        if (catSelect) catSelect.value = 'all';
        if (brandSelect) brandSelect.value = 'all';

        filterFavorites();
    };

    // --- Filtros y Busqueda en Catalogo ---
    const searchInput = document.getElementById('product-search');
    const filterButtons = document.querySelectorAll('.sidebar-filter-btn');
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

        // Mostrar estado vacio si no hay productos
        if (visibleCount === 0) {
            emptyState.style.display = 'block';
            catalogGrid.style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            catalogGrid.style.display = 'grid';
        }

        // --- Actualizar contador de productos ---
        const countNumber = document.getElementById('product-count-number');
        const countLabel = document.getElementById('product-count-label');

        if (countNumber && countLabel) {
            // Animacion "pop" al cambiar el numero
            countNumber.classList.remove('pop');
            void countNumber.offsetWidth; // reflow para reiniciar animacion
            countNumber.classList.add('pop');
            countNumber.textContent = visibleCount;

            const plural = visibleCount !== 1 ? 's' : '';

            if (searchQuery && activeCategory !== 'all') {
                // Búsqueda + categoría
                const catName = document.querySelector(`.sidebar-filter-btn.active span`)?.textContent?.trim() || activeCategory;
                countLabel.innerHTML = `producto${plural} en <strong>${catName}</strong> que coinciden con "<em>${searchQuery}</em>"`;
            } else if (searchQuery) {
                // Solo búsqueda
                countLabel.innerHTML = `producto${plural} que coinciden con "<em>${searchQuery}</em>"`;
            } else if (activeCategory !== 'all') {
                // Solo categoría
                const catName = document.querySelector(`.sidebar-filter-btn.active span`)?.textContent?.trim() || activeCategory;
                countLabel.innerHTML = `producto${plural} en <strong>${catName}</strong>`;
            } else {
                // Todo el catálogo
                countLabel.innerHTML = `producto${plural} en <strong>Todo el catálogo</strong>`;
            }
        }
    };

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value;
            filterProducts();
        });

        // Ocultar teclado movil al presionar "Enter"
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                searchInput.blur();
            }
        });
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Actualizar estado activo de la UI
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            activeCategory = btn.getAttribute('data-filter');

            // Limpiar barra de busqueda cuando se selecciona 'Todo'
            if (activeCategory === 'all') {
                if (searchInput) {
                    searchInput.value = '';
                }
                searchQuery = '';
            }

            filterProducts();
        });
    });

    // Resetear filtros (global para el boton de estado vacio)
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

    // (Eliminar scroll del carrusel - las categorias estan ahora en una barra lateral)

    // --- Zoom de imagen de producto y Lightbox ---
    const mainImageContainer = document.querySelector('.main-image');
    const mainProductImg = document.getElementById('main-product-img');

    if (mainImageContainer && mainProductImg) {
        // Efecto de zoom tipo Amazon al pasar el mouse
        mainImageContainer.addEventListener('mousemove', (e) => {
            const rect = mainImageContainer.getBoundingClientRect();
            // Calcular la posicion del mouse en porcentaje relativa al contenedor
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;

            mainProductImg.style.transformOrigin = `${x}% ${y}%`;
            mainProductImg.style.transform = 'scale(2.2)';
        });

        mainImageContainer.addEventListener('mouseleave', () => {
            mainProductImg.style.transform = 'scale(1)';
            mainProductImg.style.transformOrigin = 'center center';
        });

        // Lightbox Fullscreen al hacer click
        mainImageContainer.addEventListener('click', () => {
            const imgSrc = mainProductImg.getAttribute('src');
            const imgAlt = mainProductImg.getAttribute('alt');

            // Crear contenedor del Lightbox
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox-modal';
            lightbox.innerHTML = `
                <button class="lightbox-close" aria-label="Cerrar"><i class="fa-solid fa-xmark"></i></button>
                <div class="lightbox-content">
                    <img src="${imgSrc}" alt="${imgAlt}">
                </div>
            `;

            document.body.appendChild(lightbox);
            document.body.classList.add('lightbox-open');

            // Forzar reflow y fundido
            setTimeout(() => {
                lightbox.classList.add('active');
            }, 10);

            // Cerrar lightbox al hacer clic
            const closeLightbox = () => {
                lightbox.classList.remove('active');
                document.body.classList.remove('lightbox-open');
                setTimeout(() => {
                    lightbox.remove();
                }, 300);
            };

            lightbox.addEventListener('click', (e) => {
                // Cerrar si se hace clic fuera de la imagen o en el boton de cerrar
                if (!e.target.closest('.lightbox-content img') || e.target.closest('.lightbox-close')) {
                    closeLightbox();
                }
            });

            // Cerrar con tecla escape
            const handleEsc = (e) => {
                if (e.key === 'Escape') {
                    closeLightbox();
                    document.removeEventListener('keydown', handleEsc);
                }
            };
            document.addEventListener('keydown', handleEsc);
        });
    }

    // --- Navegacion al hacer clic en la tarjeta de producto ---
    document.addEventListener('click', (e) => {
        const card = e.target.closest('.product-card');
        if (!card) return;

        // Ignorar si el clic es en el boton de favoritos o dentro de el
        if (e.target.closest('.fav-btn')) return;

        const id = card.getAttribute('data-id');
        if (id) {
            window.location.href = `producto.php?id=${id}`;
        }
    });

    // --- Logica del Flotante de WhatsApp ---
    const floatingWhatsApp = document.getElementById('floating-whatsapp');
    const mainFooter = document.querySelector('.main-footer');

    if (floatingWhatsApp) {
        if (floatingWhatsApp.parentElement !== document.body) {
            document.body.appendChild(floatingWhatsApp);
        }

        const updateWhatsAppVisibility = () => {
            let shouldShow = window.scrollY > 100;

            // Ocultar cuando el footer es visible en pantalla
            if (mainFooter) {
                const footerRect = mainFooter.getBoundingClientRect();
                const windowHeight = window.innerHeight;

                if (footerRect.top <= windowHeight) {
                    shouldShow = false;
                }
            }

            if (shouldShow) {
                floatingWhatsApp.classList.add('show');
            } else {
                floatingWhatsApp.classList.remove('show');
            }
        };

        window.addEventListener('scroll', updateWhatsAppVisibility, { passive: true });
        // Ejecutar al cargar por si la pagina ya tiene scroll
        updateWhatsAppVisibility();
    }
});

