document.addEventListener('DOMContentLoaded', () => {
    const categoryFilter = document.getElementById('category-filter');
    const searchInput = document.getElementById('search-input');
    const productsContainer = document.getElementById('products-container');
    function debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }

    const fetchProducts = async () => {
        if (!productsContainer) return; 

        let category = categoryFilter ? categoryFilter.value : '';
        let search = searchInput ? searchInput.value : '';

        try {
            const response = await fetch(`index.php?ajax=1&category=${category}&search=${encodeURIComponent(search)}`);
            const html = await response.text();

            productsContainer.innerHTML = html;
        } catch (error) {
            console.error('Error fetching products:', error);
            productsContainer.innerHTML = '<p>Error al cargar los productos.</p>';
        }
    };

    if (categoryFilter) {
        categoryFilter.addEventListener('change', fetchProducts);
    }

    if (searchInput) {
        searchInput.addEventListener('input', debounce(fetchProducts, 500));
    }
});
