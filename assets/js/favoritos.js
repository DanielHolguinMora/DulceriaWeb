document.addEventListener("DOMContentLoaded", () => {
    const FAV_KEY = "dulceria_favoritos";

    function getFavorites() {
        return JSON.parse(localStorage.getItem(FAV_KEY) || "[]");
    }

    function saveFavorites(favs) {
        localStorage.setItem(FAV_KEY, JSON.stringify(favs));
    }

    const favoriteBtns = document.querySelectorAll(".favorite-btn");
    if (favoriteBtns.length > 0) {
        const favs = getFavorites();

        favoriteBtns.forEach(btn => {
            const productId = btn.getAttribute("data-id");
            const icon = btn.querySelector(".material-symbols-outlined");

            if (favs.some(f => f.id === productId)) {
                icon.style.fontVariationSettings = "'FILL' 1";
                btn.classList.add("is-favorite");
                btn.classList.remove("text-gray-400");
            } else {
                icon.style.fontVariationSettings = "'FILL' 0";
                btn.classList.add("text-gray-400");
                btn.classList.remove("is-favorite");
            }

            btn.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();

                // Add pop animation
                btn.classList.add("pop-animation");
                setTimeout(() => btn.classList.remove("pop-animation"), 500);

                const productData = JSON.parse(btn.closest("[data-product]").getAttribute("data-product"));
                let currentFavs = getFavorites();
                const existsIndex = currentFavs.findIndex(f => f.id === productId);

                if (existsIndex >= 0) {
                    currentFavs.splice(existsIndex, 1);
                    icon.style.fontVariationSettings = "'FILL' 0";
                    btn.classList.remove("is-favorite");
                    btn.classList.add("text-gray-400");
                } else {
                    currentFavs.push(productData);
                    icon.style.fontVariationSettings = "'FILL' 1";
                    btn.classList.add("is-favorite");
                    btn.classList.remove("text-gray-400");
                }

                saveFavorites(currentFavs);
            });
        });
    }

    const favoritesGrid = document.getElementById("favorites-grid");
    if (favoritesGrid) {
        renderFavorites();

        document.getElementById("btn-clear-favorites")?.addEventListener("click", () => {
            localStorage.removeItem(FAV_KEY);
            renderFavorites();
        });
    }

    function renderFavorites() {
        const favs = getFavorites();
        const emptyState = document.getElementById("empty-favorites-state");

        favoritesGrid.innerHTML = "";

        if (favs.length === 0) {
            emptyState.style.display = "flex";
            favoritesGrid.appendChild(emptyState);
            return;
        }

        emptyState.style.display = "flex";

        favs.forEach(product => {
            const article = document.createElement("article");
            article.className = "bg-white border-2 border-[#1C1A1B] p-2 flex flex-col flat-bold-borders group";
            article.innerHTML = `
                <div class="relative overflow-hidden aspect-square border-2 border-[#1C1A1B] mb-sm">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="${product.imagen}" alt="${product.nombre}" />
                    <button class="remove-fav-btn absolute bottom-2 right-2 bg-white border border-[#1C1A1B] p-1 flex items-center justify-center flat-bold-borders text-[#bb0119]" data-id="${product.id}">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">favorite</span>
                    </button>
                </div>
                <div class="px-2 pb-2">
                    <span class="text-xs font-black text-[#885200] uppercase tracking-widest mb-1 block">${product.categoria}</span>
                    <h3 class="font-h3 text-h3 text-[#1C1A1B] uppercase leading-tight">${product.nombre}</h3>
                    <div class="mt-4 flex gap-2">
                        <span class="bg-[#ede7e8] px-2 py-0.5 border border-[#1C1A1B] text-[10px] font-black uppercase">FAVORITO</span>
                    </div>
                </div>
            `;
            favoritesGrid.appendChild(article);
        });

        favoritesGrid.appendChild(emptyState);

        document.querySelectorAll(".remove-fav-btn").forEach(btn => {
            btn.addEventListener("click", (e) => {
                const idToRemove = btn.getAttribute("data-id");
                let currentFavs = getFavorites();
                currentFavs = currentFavs.filter(f => f.id !== idToRemove);
                saveFavorites(currentFavs);
                renderFavorites();
            });
        });
    }
});
