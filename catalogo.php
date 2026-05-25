<?php
require_once 'includes/db.php';
require_once 'includes/product-card.php';
include 'includes/header.php';

$products = [];
$categories_db = [];

if ($pdo) {
    try {
        // Obtener categorías para filtros
        $stmt_cat = $pdo->query("SELECT * FROM categoria");
        $categories_db = $stmt_cat->fetchAll();

        // Obtener productos con categoría y marca
        $stmt = $pdo->query("SELECT p.*, c.nombre as categoria_nombre, m.nombre as marca_nombre FROM productos p JOIN categoria c ON p.categoria_id = c.id LEFT JOIN marca m ON p.marca_id = m.id");
        $products = $stmt->fetchAll();
    } catch (Exception $e) {
        $error = "Error al conectar con la base de datos.";
    }
}
?>

<main class="catalog-page">
    <!-- Header del catálogo -->
    <section class="catalog-hero">
        <div class="container text-center">
            <h1>Catálogo de Dulces</h1>
            <p>Explora nuestra deliciosa variedad de golosinas, botanas y dulces tradicionales.</p>
        </div>
    </section>


    <section class="catalog-section">
        <div class="container">
            <div class="catalog-layout">

                <!-- Barra Lateral de Categorías -->
                <aside class="catalog-sidebar">
                    <div class="sidebar-header">
                        <i class="fa-solid fa-tags"></i>
                        <span>Categorías</span>
                    </div>
                    <nav class="sidebar-categories">
                        <button class="sidebar-filter-btn active" data-filter="all">
                            <i class="fa-solid fa-border-all"></i>
                            <span>Todo el catálogo</span>
                        </button>
                        <?php foreach ($categories_db as $cat): ?>
                            <button class="sidebar-filter-btn"
                                    data-filter="<?php echo strtolower(str_replace(' ', '-', $cat['nombre'])); ?>">
                                <i class="fa-solid fa-circle-dot"></i>
                                <span><?php echo $cat['nombre']; ?></span>
                            </button>
                        <?php endforeach; ?>
                    </nav>
                </aside>

                <!-- Contenido Principal -->
                <div class="catalog-main-content">
                    <!-- Toolbar: Buscar + Contador -->
                    <div class="catalog-toolbar">
                        <!-- Buscador -->
                        <div class="catalog-search-top">
                            <div class="search-input-group">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" id="product-search" placeholder="Buscar dulce...">
                            </div>
                        </div>
                        <!-- Contador de Productos -->
                        <div class="product-count-bar" id="product-count-bar">
                            <span class="product-count-number" id="product-count-number"><?php echo count($products); ?></span>
                            <span class="product-count-label" id="product-count-label">
                                producto<?php echo count($products) !== 1 ? 's' : ''; ?> en <strong>Todo el catálogo</strong>
                            </span>
                        </div>
                    </div>

                    <!-- Grid de Productos -->
                    <div class="catalog-full-content">
                        <div class="product-grid-5" id="catalog-grid">
                            <?php
                            foreach ($products as $product) {
                                renderProductCard($product);
                            }
                            ?>
                        </div>

                        <!-- En caso de no encontrar productos -->
                        <div id="empty-state" class="empty-state" style="display: none;">
                            <div class="empty-icon">
                                <i class="fa-solid fa-cookie-bite"></i>
                            </div>
                            <h3>No se encontraron dulces</h3>
                            <p>Intenta con otros términos de búsqueda o selecciona una categoría diferente.</p>
                            <button onclick="resetFilters()" class="btn btn-secondary">Ver todo el catálogo</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>