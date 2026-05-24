<?php 
require_once 'includes/db.php'; 
include 'includes/header.php'; 
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
            <div class="product-grid" id="favorites-grid">
            </div>

            <div id="favorites-empty" class="empty-state" style="display: none;">
                <div class="empty-icon">
                    <i class="fa-solid fa-heart-crack"></i>
                </div>
                <h3>Aún no tienes favoritos</h3>
                <p>Explora nuestro catálogo y haz clic en el corazón para guardar tus dulces preferidos.</p>
                <a href="catalogo.php" class="btn btn-primary">Ir al Catálogo</a>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
