<?php 
require_once 'includes/db.php'; 
include 'includes/header.php'; 

// Fetch products from database if available
$featured_products = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM productos LIMIT 4");
        $featured_products = $stmt->fetchAll();
    } catch (Exception $e) {
        $featured_products = []; // Fallback to mock data
    }
}

// Mock data if database is empty or not connected
if (empty($featured_products)) {
    $featured_products = [
        [
            'nombre' => 'Mazapán Gigante',
            'descripcion' => 'El clásico dulce de cacahuate, ahora en tamaño familiar.',
            'precio' => 45.00,
            'imagen_frontal' => 'https://via.placeholder.com/200?text=Mazapan'
        ],
        [
            'nombre' => 'Paletas de Mango con Chile',
            'descripcion' => 'Delicioso sabor mango con una capa de chile picosito.',
            'precio' => 12.50,
            'imagen_frontal' => 'https://via.placeholder.com/200?text=Paleta'
        ],
        [
            'nombre' => 'Surtido de Gomitas',
            'descripcion' => 'Mezcla premium de gomitas importadas de ositos y frutas.',
            'precio' => 35.00,
            'imagen_frontal' => 'https://via.placeholder.com/200?text=Gomitas'
        ],
        [
            'nombre' => 'Chocolates Artesanales',
            'descripcion' => 'Caja de 6 piezas con rellenos de cajeta y nuez.',
            'precio' => 85.00,
            'imagen_frontal' => 'https://via.placeholder.com/200?text=Chocolate'
        ]
    ];
}
?>

<main>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <h1>Sabor que <br><span class="text-accent">Dulzura</span> el Alma</h1>
                <p>Descubre la selección más exclusiva de dulces mexicanos e importados en el corazón de Ciudad Juárez. ¡Calidad premium para los paladares más exigentes!</p>
                <div class="hero-btns">
                    <a href="catalogo.php" class="btn btn-primary">Ver Catálogo</a>
                    <a href="#featured" class="btn btn-secondary">Nuestros Favoritos</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="assets/img/hero.png" alt="Dulcería El Loco Hero">
                <div class="floating-candy" style="top: 10%; right: -20px; animation-delay: 0s;">
                    <i class="fa-solid fa-candy-cane text-accent" style="font-size: 3rem; transform: rotate(45deg);"></i>
                </div>
                <div class="floating-candy" style="bottom: 20%; left: -30px; animation-delay: 1s;">
                    <i class="fa-solid fa-cookie-bite" style="font-size: 2.5rem; color: #6B4DFF; transform: rotate(-20deg);"></i>
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
                <?php foreach ($featured_products as $product): ?>
                <div class="product-card">
                    <div class="product-badge">Nuevo</div>
                    <div class="product-img">
                        <img src="<?php echo $product['imagen_frontal']; ?>" alt="<?php echo $product['nombre']; ?>">
                    </div>
                    <div class="product-info">
                        <h3><?php echo $product['nombre']; ?></h3>
                        <p><?php echo substr($product['descripcion'], 0, 80) . '...'; ?></p>
                        <div class="product-footer">
                            <span class="product-price">$<?php echo number_format($product['precio'], 2); ?></span>
                            <button class="fav-btn"><i class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
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
                <img src="https://images.unsplash.com/photo-1534073828943-f801091bb18c?auto=format&fit=crop&q=80&w=800" alt="Sobre nosotros">
            </div>
            <div class="about-content">
                <h2>Tradición Dulce en Ciudad Juárez</h2>
                <p>Somos una dulcería local orgullosamente juarense, dedicada a traer los mejores sabores de México y el mundo a nuestra comunidad. Desde los clásicos mazapanes hasta las golosinas importadas más exclusivas.</p>
                <p>En <strong>Dulcería El Loco</strong>, creemos que cada dulce cuenta una historia. Por eso seleccionamos cuidadosamente cada producto de nuestro catálogo para asegurar frescura y calidad.</p>
                <a href="nosotros.php" class="btn btn-primary" style="margin-top: 20px;">Conócenos más</a>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
