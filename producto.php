<?php

require_once 'config/database.php';
require_once 'models/Producto.php';

$database = new Database();
$db = $database->getConnection();

$producto = new Producto($db);

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$producto->id = $_GET['id'];
if (!$producto->readOne()) {
    echo "Producto no encontrado.";
    exit;
}

$img_front = !empty($producto->imagen_frontal) ? 'uploads/' . $producto->imagen_frontal : 'https://placehold.co/600x600/e7e1e2/1d1b1c?text=Frontal';
$img_back = !empty($producto->imagen_trasera) ? 'uploads/' . $producto->imagen_trasera : 'https://placehold.co/600x600/e7e1e2/1d1b1c?text=Trasera';

require_once 'views/layout/header.php';
?>

<div class="container">
    <div class="product-detail-grid">
        <div class="product-detail-images">
            <img src="<?php echo $img_front; ?>" alt="<?php echo htmlspecialchars($producto->nombre); ?> - Frontal">
            <?php if (!empty($producto->imagen_trasera)): ?>
                <img src="<?php echo $img_back; ?>" alt="<?php echo htmlspecialchars($producto->nombre); ?> - Trasera">
            <?php endif; ?>
        </div>

        <div class="product-detail-info">
            <span class="product-category"
                style="display:block; margin-bottom: 0.5rem; color: var(--secondary); font-weight:bold; text-transform:uppercase;">
                <?php echo htmlspecialchars($producto->categoria_nombre); ?>
            </span>

            <h1><?php echo htmlspecialchars($producto->nombre); ?></h1>

            <div class="price">$<?php echo number_format($producto->precio, 2); ?></div>

            <?php if ($producto->stock > 0): ?>
                <span class="badge badge-in-stock">En Stock (<?php echo $producto->stock; ?> disponibles)</span>
            <?php else: ?>
                <span class="badge badge-out-stock">Agotado</span>
            <?php endif; ?>

            <div class="description">
                <h3>Descripción</h3>
                <p><?php echo nl2br(htmlspecialchars($producto->descripcion)); ?></p>
            </div>

            <button class="btn btn-primary" <?php echo $producto->stock <= 0 ? 'disabled' : ''; ?>
                style="width: 100%; font-size: 1.2rem; padding: 1rem;">
                Añadir al Carrito
            </button>
        </div>
    </div>
</div>

<?php
require_once 'views/layout/footer.php';
?>