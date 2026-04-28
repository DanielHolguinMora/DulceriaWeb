<?php
require_once 'includes/header.php';
// Mostrar algunos productos destacados (los últimos 3)
$stmt = $conn->prepare("SELECT * FROM producto ORDER BY fecha_creacion DESC LIMIT 3");
$stmt->execute();
$productos_destacados = $stmt->get_result();
?>
<h2>Bienvenido a Dulcería El Sabor</h2>
<p>Los mejores dulces al mejor precio. Explora nuestro catálogo y encuentra tus favoritos.</p>

<h3>Productos destacados</h3>
<div class="product-grid">
    <?php while ($prod = $productos_destacados->fetch_assoc()): ?>
        <div class="product-card">
            <img src="uploads/<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
            <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
            <p>$<?php echo number_format($prod['precio'], 2); ?></p>
            <a href="catalogo.php?detalle=<?php echo $prod['id_producto']; ?>" class="btn">Ver más</a>
        </div>
    <?php endwhile; ?>
</div>
<?php require_once 'includes/footer.php'; ?>