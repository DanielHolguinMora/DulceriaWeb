<?php 
require_once 'includes/db.php'; 
include 'includes/header.php'; 

$categories = [];
$brands = [];

if ($pdo) {
    try {
        $stmt_cat = $pdo->query("SELECT * FROM categoria ORDER BY nombre ASC");
        $categories = $stmt_cat->fetchAll();

        $stmt_brand = $pdo->query("SELECT * FROM marca ORDER BY nombre ASC");
        $brands = $stmt_brand->fetchAll();
    } catch (Exception $e) {
        // En caso de error, retornar arrays vacíos
    }
}
?>

<main class="favorites-page">
    <section class="catalog-hero">
        <div class="container text-center">
            <h1>Mis Favoritos</h1>
            <p>Guarda tus dulces preferidos para encontrarlos fácilmente después.</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <!-- Barra de Herramientas de Favoritos -->
            <div class="favorites-toolbar" id="favorites-toolbar" style="display: none;">
                <div class="toolbar-left">
                    <a href="catalogo.php" class="btn btn-back btn-sm">
                        <i class="fa-solid fa-arrow-left"></i> Regresar al Catálogo
                    </a>
                </div>
                
                <div class="toolbar-filters">
                    <div class="filter-group">
                        <label for="fav-filter-category"><i class="fa-solid fa-tag"></i> Categoría:</label>
                        <select id="fav-filter-category" class="filter-select">
                            <option value="all">Todas las categorías</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars(strtolower(str_replace(' ', '-', $cat['nombre']))); ?>">
                                    <?php echo htmlspecialchars($cat['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="fav-filter-brand"><i class="fa-solid fa-certificate"></i> Marca:</label>
                        <select id="fav-filter-brand" class="filter-select">
                            <option value="all">Todas las marcas</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?php echo htmlspecialchars(strtolower(str_replace(' ', '-', $brand['nombre']))); ?>">
                                    <?php echo htmlspecialchars($brand['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="toolbar-right">
                    <button id="btn-clear-all" class="btn btn-danger btn-sm" onclick="clearAllFavorites()">
                        <i class="fa-solid fa-trash-can"></i> Eliminar Todos
                    </button>
                </div>
            </div>

            <!-- Grid de Productos Favoritos -->
            <div class="product-grid" id="favorites-grid">
            </div>

            <!-- Empty State Principal (Sin Favoritos Guardados) -->
            <div id="favorites-empty" class="empty-state" style="display: none;">
                <div class="empty-icon">
                    <i class="fa-solid fa-heart-crack"></i>
                </div>
                <h3>Aún no tienes favoritos</h3>
                <p>Explora nuestro catálogo y haz clic en el corazón para guardar tus dulces preferidos.</p>
                <a href="catalogo.php" class="btn btn-primary">Ir al Catálogo</a>
            </div>

            <!-- Empty State Secundario (Sin Coincidencias de Filtro) -->
            <div id="favorites-filter-empty" class="empty-state" style="display: none;">
                <div class="empty-icon">
                    <i class="fa-solid fa-cookie-bite"></i>
                </div>
                <h3>Sin coincidencias en favoritos</h3>
                <p>No tienes ningún dulce favorito que coincida con los filtros seleccionados.</p>
                <button onclick="resetFavFilters()" class="btn btn-secondary">Limpiar Filtros</button>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
