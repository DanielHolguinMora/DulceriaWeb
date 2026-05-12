<?php 
require_once 'includes/db.php'; 
require_once 'includes/products.php';
require_once 'includes/product-card.php';
include 'includes/header.php'; 

// Database logic (optional for now, using array as primary source)
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM productos");
        $db_products = $stmt->fetchAll();
        if (!empty($db_products)) {
            // Map DB fields to our card structure if needed
            // $products = $db_products; 
        }
    } catch (Exception $e) {}
}

$categories = ['Todo', 'Chocolates', 'Gummies', 'Chips', 'Mexican Candy', 'Drinks'];
?>

<main class="catalog-page">
    <!-- Catalog Header -->
    <section class="catalog-hero">
        <div class="container text-center">
            <h1>Catálogo de Dulces</h1>
            <p>Explora nuestra deliciosa variedad de golosinas, botanas y dulces tradicionales.</p>
        </div>
    </section>

    <!-- Search and Filters -->
    <section class="catalog-controls">
        <div class="container">
            <div class="search-bar-wrapper">
                <div class="search-input-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="product-search" placeholder="Buscar dulces por nombre...">
                </div>
            </div>

            <div class="category-filters">
                <?php foreach ($categories as $cat): ?>
                    <button class="filter-btn <?php echo $cat === 'Todo' ? 'active' : ''; ?>" 
                            data-filter="<?php echo $cat === 'Todo' ? 'all' : strtolower(str_replace(' ', '-', $cat)); ?>">
                        <?php echo $cat; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Product Grid -->
    <section class="catalog-grid-section section-padding">
        <div class="container">
            <div class="product-grid" id="catalog-grid">
                <?php 
                foreach ($products as $product) {
                    renderProductCard($product);
                }
                ?>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="empty-state" style="display: none;">
                <div class="empty-icon">
                    <i class="fa-solid fa-cookie-bite"></i>
                </div>
                <h3>No se encontraron dulces</h3>
                <p>Intenta con otros términos de búsqueda o selecciona una categoría diferente.</p>
                <button onclick="resetFilters()" class="btn btn-secondary">Ver todo el catálogo</button>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
