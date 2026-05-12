<?php 
require_once 'includes/db.php'; 
require_once 'includes/product-card.php';
include 'includes/header.php'; 

// Fetch Products from Database
$products = [];
$categories_db = [];

if ($pdo) {
    try {
        // Fetch categories for filters
        $stmt_cat = $pdo->query("SELECT * FROM categoria");
        $categories_db = $stmt_cat->fetchAll();

        // Fetch products with category names
        $stmt = $pdo->query("SELECT p.*, c.nombre as categoria_nombre FROM productos p JOIN categoria c ON p.categoria_id = c.id");
        $products = $stmt->fetchAll();
    } catch (Exception $e) {
        $error = "Error al conectar con la base de datos.";
    }
}
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
                <button class="filter-btn active" data-filter="all">Todo</button>
                <?php foreach ($categories_db as $cat): ?>
                    <button class="filter-btn" 
                            data-filter="<?php echo strtolower(str_replace(' ', '-', $cat['nombre'])); ?>">
                        <?php echo $cat['nombre']; ?>
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
