<?php
require_once 'includes/db.php';
include 'includes/header.php';

$product_id = $_GET['id'] ?? null;
$product = null;
$prev_id = null;
$next_id = null;

if ($product_id && $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.nombre as categoria_nombre, m.nombre as marca_nombre 
                             FROM productos p 
                             JOIN categoria c ON p.categoria_id = c.id 
                             LEFT JOIN marca m ON p.marca_id = m.id 
                             WHERE p.id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        if ($product) {
            // Obtener el ID del producto anterior
            $stmt_prev = $pdo->prepare("SELECT id FROM productos WHERE id < ? ORDER BY id DESC LIMIT 1");
            $stmt_prev->execute([$product_id]);
            $prev_res = $stmt_prev->fetch();
            if ($prev_res) {
                $prev_id = $prev_res['id'];
            } else {
                // Volver al último producto
                $stmt_max = $pdo->query("SELECT id FROM productos ORDER BY id DESC LIMIT 1");
                $max_res = $stmt_max->fetch();
                $prev_id = $max_res['id'] ?? null;
            }

            // Obtener el ID del producto siguiente
            $stmt_next = $pdo->prepare("SELECT id FROM productos WHERE id > ? ORDER BY id ASC LIMIT 1");
            $stmt_next->execute([$product_id]);
            $next_res = $stmt_next->fetch();
            if ($next_res) {
                $next_id = $next_res['id'];
            } else {
                // Volver al primer producto
                $stmt_min = $pdo->query("SELECT id FROM productos ORDER BY id ASC LIMIT 1");
                $min_res = $stmt_min->fetch();
                $next_id = $min_res['id'] ?? null;
            }
        }
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
        <div class="product-detail-header">
            <nav class="breadcrumb">
                <a href="index.php">Inicio</a> /
                <a href="catalogo.php">Catálogo</a> /
                <span><?php echo $name; ?></span>
            </nav>
            <?php if ($prev_id || $next_id): ?>
            <div class="product-navigation">
                <?php if ($prev_id): ?>
                <a href="producto.php?id=<?php echo $prev_id; ?>" class="nav-arrow prev" title="Producto Anterior">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <?php endif; ?>
                <?php if ($next_id): ?>
                <a href="producto.php?id=<?php echo $next_id; ?>" class="nav-arrow next" title="Siguiente Producto">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="product-detail-grid">
            <div class="product-gallery">
                <div class="main-image main-image-container">
                    <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" id="main-product-img">
                </div>
            </div>

            <div class="product-info-detailed">
                <div class="product-meta">
                    <span class="category-tag"><i class="fa-solid fa-tag"></i> <?php echo $category; ?></span>
                    <span class="product-brand-badge"><i class="fa-solid fa-certificate"></i> <?php echo $brand; ?></span>
                </div>
                
                <h1 class="product-title"><?php echo $name; ?></h1>
                
                <div class="product-description-box">
                    <h3>Sobre este producto</h3>
                    <p class="description-text"><?php echo $desc; ?></p>
                </div>

                <div class="product-actions-detailed" data-id="<?php echo $product['id']; ?>"
                    data-name="<?php echo $name; ?>"
                    data-image="<?php echo $image; ?>" data-category="<?php echo $category; ?>"
                    data-brand="<?php echo $brand; ?>"
                    data-description="<?php echo htmlspecialchars($product['descripcion']); ?>">

                    <button class="btn btn-primary btn-large action-btn">
                        <i class="fa-solid fa-cart-shopping"></i> Próximamente
                    </button>
                    <button class="btn btn-secondary btn-large fav-btn-detailed" title="Añadir a favoritos">
                        <i class="fa-regular fa-heart"></i> Favoritos
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Flechas de navegación flotantes -->
    <?php if ($prev_id): ?>
    <a href="producto.php?id=<?php echo $prev_id; ?>" class="floating-nav-btn prev" title="Producto Anterior">
        <i class="fa-solid fa-chevron-left"></i>
    </a>
    <?php endif; ?>
    <?php if ($next_id): ?>
    <a href="producto.php?id=<?php echo $next_id; ?>" class="floating-nav-btn next" title="Siguiente Producto">
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>