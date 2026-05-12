<?php
require_once 'includes/db.php';
include 'includes/header.php';

// Fetch products from database
$featured_products = [];
if ($pdo) {
    try {
        // Fetch 4 random or newest products joined with category
        $stmt = $pdo->query("SELECT p.*, c.nombre as categoria_nombre FROM productos p JOIN categoria c ON p.categoria_id = c.id LIMIT 4");
        $featured_products = $stmt->fetchAll();
    } catch (Exception $e) {
        $featured_products = [];
    }
}
?>

<main>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <h1>Sabor que <br><span class="text-accent">Endulza</span> el Alma</h1>
                <p>Descubre la selección más exclusiva de dulces mexicanos e importados en el corazón de Ciudad Juárez.
                    ¡Calidad premium para los paladares más exigentes!</p>
                <div class="hero-btns">
                    <a href="catalogo.php" class="btn btn-primary">Ver Catálogo</a>
                    <a href="#featured" class="btn btn-secondary">Nuestros Favoritos</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="assets/img/hero.png" alt="Dulcería El Loco Hero">
                <div class="floating-candy" style="top: 10%; right: -20px; animation-delay: 0s;">
                    <i class="fa-solid fa-candy-cane text-accent"
                        style="font-size: 3rem; transform: rotate(45deg);"></i>
                </div>
                <div class="floating-candy" style="bottom: 20%; left: -30px; animation-delay: 1s;">
                    <i class="fa-solid fa-cookie-bite"
                        style="font-size: 2.5rem; color: #6B4DFF; transform: rotate(-20deg);"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured section-padding" id="featured">
        <div class="container">
            <div class="section-header text-center">
                <h2>Favoritos del Mes</h2>
                <p>Nuestra selección especial de lo más pedido esta semana.</p>
            </div>

            <div class="product-grid">
                <?php 
                require_once 'includes/product-card.php';
                foreach ($featured_products as $product) {
                    renderProductCard($product);
                } 
                ?>
            </div>

            <div class="text-center" style="margin-top: 50px;">
                <a href="catalogo.php" class="btn btn-secondary">Explorar todo el catálogo</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about section-padding">
        <div class="container about-grid">
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1534073828943-f801091bb18c?auto=format&fit=crop&q=80&w=800"
                    alt="Sobre nosotros">
            </div>
            <div class="about-content">
                <h2>Tradición Dulce en Ciudad Juárez</h2>
                <p>Somos una dulcería local orgullosamente juarense, dedicada a traer los mejores sabores de México y el
                    mundo a nuestra comunidad. Desde los clásicos mazapanes hasta las golosinas importadas más
                    exclusivas.</p>
                <p>En <strong>Dulcería El Loco</strong>, creemos que cada dulce cuenta una historia. Por eso
                    seleccionamos cuidadosamente cada producto de nuestro catálogo para asegurar frescura y calidad.</p>
                <a href="nosotros.php" class="btn btn-primary" style="margin-top: 20px;">Conócenos más</a>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>