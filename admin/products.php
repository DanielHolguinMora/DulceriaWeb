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
                <a href="add_product.php" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Nuevo Producto</a>
            </header>

            <!-- Admin Tools -->
            <section class="admin-tools">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="admin-search" placeholder="Buscar por nombre o marca...">
                </div>
                <div class="filter-box">
                    <select id="admin-filter-category">
                        <option value="all">Todas las Categorías</option>
                        <?php 
                        $cats = $pdo->query("SELECT * FROM categoria")->fetchAll();
                        foreach($cats as $c): ?>
                            <option value="<?php echo strtolower(str_replace(' ', '-', $c['nombre'])); ?>">
                                <?php echo $c['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </section>

            <div class="admin-card">
                <!-- Vista de Tabla (Desktop) -->
                <div class="table-responsive">
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
                                    <td colspan="7" style="text-align: center; padding: 40px;">No hay productos registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $p): ?>
                                    <tr class="admin-product-row" 
                                        data-name="<?php echo strtolower($p['nombre']); ?>" 
                                        data-brand="<?php echo strtolower($p['marca_nombre'] ?? ''); ?>"
                                        data-category="<?php echo strtolower(str_replace(' ', '-', $p['categoria_nombre'])); ?>">
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

                <!-- Vista de Tarjetas (Mobile) -->
                <div class="admin-products-mobile">
                    <?php if (empty($products)): ?>
                        <p style="text-align: center; padding: 20px;">No hay productos registrados.</p>
                    <?php else: ?>
                        <?php foreach ($products as $p): ?>
                            <?php
                            $img = $p['imagen_frontal'];
                            $src = (strpos($img, 'http') === 0) ? $img : '../' . $img;
                            ?>
                            <div class="admin-product-mobile-card admin-product-row"
                                 data-name="<?php echo strtolower($p['nombre']); ?>" 
                                 data-brand="<?php echo strtolower($p['marca_nombre'] ?? ''); ?>"
                                 data-category="<?php echo strtolower(str_replace(' ', '-', $p['categoria_nombre'])); ?>">
                                <div class="card-mobile-img">
                                    <img src="<?php echo $src; ?>" alt="<?php echo htmlspecialchars($p['nombre']); ?>">
                                </div>
                                <div class="card-mobile-info">
                                    <span class="category-label"><?php echo htmlspecialchars($p['categoria_nombre']); ?></span>
                                    <h4><?php echo htmlspecialchars($p['nombre']); ?></h4>
                                    <div class="card-mobile-meta">
                                        <span>Marca: <strong><?php echo htmlspecialchars($p['marca_nombre'] ?? 'N/A'); ?></strong></span>
                                        <span>Stock: <strong><?php echo $p['stock']; ?></strong></span>
                                    </div>
                                    <div class="card-mobile-price">$<?php echo number_format($p['precio'], 2); ?></div>
                                    <div class="card-mobile-actions">
                                        <a href="edit_product.php?id=<?php echo $p['id']; ?>" class="btn-edit-mobile">
                                            <i class="fa-solid fa-pen"></i> Editar
                                        </a>
                                        <a href="delete_product.php?id=<?php echo $p['id']; ?>" class="btn-delete-mobile"
                                           onclick="return confirm('¿Eliminar producto?')">
                                            <i class="fa-solid fa-trash"></i> Eliminar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <!-- Admin Mobile Bottom Nav -->
        <nav class="admin-mobile-nav">
            <a href="dashboard.php" class="nav-item">
                <i class="fa-solid fa-gauge"></i>
                <span>Panel</span>
            </a>
            <a href="products.php" class="nav-item active">
                <i class="fa-solid fa-candy-cane"></i>
                <span>Productos</span>
            </a>
            <div class="nav-item-center">
                <a href="add_product.php" class="center-add">
                    <i class="fa-solid fa-plus"></i>
                </a>
            </div>
            <a href="../index.php" class="nav-item" target="_blank">
                <i class="fa-solid fa-eye"></i>
                <span>Ver Sitio</span>
            </a>
            <a href="../logout.php" class="nav-item">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Salir</span>
            </a>
        </nav>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('admin-search');
            const categoryFilter = document.getElementById('admin-filter-category');
            const productRows = document.querySelectorAll('.admin-product-row');

            function filterProducts() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value;

                productRows.forEach(row => {
                    const name = row.getAttribute('data-name');
                    const brand = row.getAttribute('data-brand');
                    const category = row.getAttribute('data-category');

                    const matchesSearch = name.includes(searchTerm) || brand.includes(searchTerm);
                    const matchesCategory = selectedCategory === 'all' || category === selectedCategory;

                    if (matchesSearch && matchesCategory) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterProducts);
            categoryFilter.addEventListener('change', filterProducts);
        });
    </script>
</body>

</html>