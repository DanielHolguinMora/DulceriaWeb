<?php
require_once 'includes/db.php';
include 'includes/header.php';

$product_id = $_GET['id'] ?? null;
$product = null;

if ($product_id && $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.nombre as categoria_nombre, m.nombre as marca_nombre 
                             FROM productos p 
                             JOIN categoria c ON p.categoria_id = c.id 
                             LEFT JOIN marca m ON p.marca_id = m.id 
                             WHERE p.id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
    } catch (Exception $e) {
        $error = "Error al cargar el producto.";
    }
}

if (!$product) {
    echo "<div class='container' style='padding: 100px 0; text-align: center;'>
            <h2>Producto no encontrado</h2>
            <p>Lo sentimos, el producto que buscas no existe o ha sido retirado.</p>
            <a href='catalogo.php' class='btn btn-primary'>Volver al catálogo</a>
          </div>";
    include 'includes/footer.php';
    exit;
}

$name = htmlspecialchars($product['nombre']);
$desc = nl2br(htmlspecialchars($product['descripcion']));
$category = htmlspecialchars($product['categoria_nombre']);
$brand = htmlspecialchars($product['marca_nombre'] ?? 'Genérica');
$image = $product['imagen_frontal'];
?>

<main class="product-detail-page">
    <div class="container">
        <nav class="breadcrumb">
            <a href="index.php">Inicio</a> /
            <a href="catalogo.php">Catálogo</a> /
            <span><?php echo $name; ?></span>
        </nav>

        <div class="product-detail-grid">
            <div class="product-gallery">
                <div class="main-image">
                    <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" id="main-product-img">
                </div>
            </div>

            <div class="product-info-detailed">
                <span class="category-tag"><?php echo $category; ?></span>
                <h1 class="product-title"><?php echo $name; ?></h1>
                <div class="product-brand-info">Marca: <strong><?php echo $brand; ?></strong></div>

                <div class="product-description-box">
                    <h3>Descripción</h3>
                    <p><?php echo $desc; ?></p>
                </div>

                <div class="product-actions-detailed" data-id="<?php echo $product['id']; ?>"
                    data-name="<?php echo $name; ?>"
                    data-image="<?php echo $image; ?>" data-category="<?php echo $category; ?>"
                    data-description="<?php echo htmlspecialchars($product['descripcion']); ?>">

                    <button class="btn btn-primary btn-large">
                        <i class="fa-solid fa-cart-shopping"></i> Próximamente
                    </button>
                    <button class="fav-btn-detailed" title="Añadir a favoritos">
                        <i class="fa-regular fa-heart"></i> Favoritos
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>