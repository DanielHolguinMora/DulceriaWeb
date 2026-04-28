<?php
require_once 'includes/header.php';

$favoritos_ids = $_SESSION['favoritos'] ?? [];
$productos_fav = [];

if (!empty($favoritos_ids)) {
    $placeholders = implode(',', array_fill(0, count($favoritos_ids), '?'));
    $stmt = $conn->prepare("SELECT * FROM producto WHERE id_producto IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($favoritos_ids)), ...$favoritos_ids);
    $stmt->execute();
    $productos_fav = $stmt->get_result();
}
?>
<h2>Mis favoritos</h2>

<?php if (empty($favoritos_ids) || $productos_fav->num_rows == 0): ?>
    <p>No tienes productos favoritos. Visita el <a href="catalogo.php">catálogo</a> para agregar.</p>
<?php else: ?>
    <div class="product-grid">
        <?php while ($prod = $productos_fav->fetch_assoc()): ?>
            <div class="product-card">
                <img src="uploads/<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
                <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
                <p>$<?php echo number_format($prod['precio'], 2); ?></p>
                <button class="btn btn-danger remove-fav" data-id="<?php echo $prod['id_producto']; ?>">🗑️ Eliminar de favoritos</button>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>