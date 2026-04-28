<?php
require_once 'includes/header.php';

$categorias = $conn->query("SELECT * FROM categoria");
$marcas = $conn->query("SELECT * FROM marca");

$where = [];
$params = [];
$types = "";

if (isset($_GET['categoria']) && $_GET['categoria'] != '') {
    $where[] = "id_categoria = ?";
    $params[] = $_GET['categoria'];
    $types .= "i";
}
if (isset($_GET['marca']) && $_GET['marca'] != '') {
    $where[] = "id_marca = ?";
    $params[] = $_GET['marca'];
    $types .= "i";
}
if (isset($_GET['buscar']) && $_GET['buscar'] != '') {
    $where[] = "nombre LIKE ?";
    $params[] = "%" . $_GET['buscar'] . "%";
    $types .= "s";
}

$sql = "SELECT * FROM producto";
if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$stmt = $conn->prepare($sql);
if (count($params) > 0) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$productos = $stmt->get_result();
?>
<h2>Catálogo de productos</h2>

<form method="get" action="catalogo.php" style="margin-bottom: 1rem;">
    <input type="text" name="buscar" placeholder="Buscar producto..." value="<?php echo htmlspecialchars($_GET['buscar'] ?? ''); ?>">
    <select name="categoria">
        <option value="">Todas las categorías</option>
        <?php while ($cat = $categorias->fetch_assoc()): ?>
            <option value="<?php echo $cat['id_categoria']; ?>" <?php if (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($cat['nombre']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    <select name="marca">
        <option value="">Todas las marcas</option>
        <?php while ($mar = $marcas->fetch_assoc()): ?>
            <option value="<?php echo $mar['id_marca']; ?>" <?php if (isset($_GET['marca']) && $_GET['marca'] == $mar['id_marca']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($mar['nombre']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    <button type="submit">Filtrar</button>
</form>

<div class="product-grid">
    <?php if ($productos->num_rows == 0): ?>
        <p>No hay productos que coincidan con los filtros.</p>
    <?php else: ?>
        <?php while ($prod = $productos->fetch_assoc()): ?>
            <div class="product-card">
                <img src="uploads/<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
                <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
                <p>$<?php echo number_format($prod['precio'], 2); ?></p>
                <p>Stock: <?php echo $prod['stock']; ?></p>
                <button class="btn add-fav" data-id="<?php echo $prod['id_producto']; ?>">❤️ Añadir a favoritos</button>
                <a href="catalogo.php?detalle=<?php echo $prod['id_producto']; ?>" class="btn">Ver más</a>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>