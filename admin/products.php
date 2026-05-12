<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$products = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT p.*, c.nombre as categoria_nombre, m.nombre as marca_nombre 
                         FROM productos p 
                         JOIN categoria c ON p.categoria_id = c.id 
                         LEFT JOIN marca m ON p.marca_id = m.id 
                         ORDER BY p.id DESC");
    $products = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Admin Dulcería</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-brand">DULCERÍA ADMIN</div>
            <nav class="admin-nav">
                <ul>
                    <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                    <li><a href="products.php" class="active"><i class="fa-solid fa-candy-cane"></i> Productos</a></li>
                    <li><a href="add_product.php"><i class="fa-solid fa-plus"></i> Nuevo Producto</a></li>
                    <li><a href="../index.php" target="_blank"><i class="fa-solid fa-eye"></i> Ver Sitio</a></li>
                    <li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Gestión de Productos</h1>
                <a href="add_product.php" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Nuevo
                    Producto</a>
            </header>

            <div class="admin-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px;">No hay productos registrados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $p): ?>
                                <tr>
                                    <td>
                                        <?php
                                        $img = $p['imagen_frontal'];
                                        $src = (strpos($img, 'http') === 0) ? $img : '../' . $img;
                                        ?>
                                        <img src="<?php echo $src; ?>" alt="<?php echo htmlspecialchars($p['nombre']); ?>">
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($p['nombre']); ?></strong></td>
                                    <td><span class="category-label"
                                            style="margin-bottom:0;"><?php echo htmlspecialchars($p['categoria_nombre']); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($p['marca_nombre'] ?? 'N/A'); ?></td>
                                    <td>$<?php echo number_format($p['precio'], 2); ?></td>
                                    <td><?php echo $p['stock']; ?></td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="edit_product.php?id=<?php echo $p['id']; ?>" class="btn-edit"
                                                title="Editar"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="delete_product.php?id=<?php echo $p['id']; ?>" class="btn-delete"
                                                title="Eliminar"
                                                onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')"><i
                                                    class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>