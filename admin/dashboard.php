<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$total_products = 0;
$total_categories = 0;
$total_brands = 0;

if ($pdo) {
    $total_products = $pdo->query("SELECT COUNT(*) FROM productos")->fetchColumn();
    $total_categories = $pdo->query("SELECT COUNT(*) FROM categoria")->fetchColumn();
    $total_brands = $pdo->query("SELECT COUNT(*) FROM marca")->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/Favicon4.png">
    <title>Dashboard - Dulcería El Loco</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">DULCERÍA ADMIN</div>
            <nav class="admin-nav">
                <ul>
                    <li><a href="dashboard.php" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                    <li><a href="products.php"><i class="fa-solid fa-candy-cane"></i> Productos</a></li>
                    <li><a href="add_product.php"><i class="fa-solid fa-plus"></i> Nuevo Producto</a></li>
                    <li><a href="add_brand.php"><i class="fa-solid fa-copyright"></i> Marcas</a></li>
                    <li><a href="add_category.php"><i class="fa-solid fa-tags"></i> Categorías</a></li>
                    <li><a href="../index.php" target="_blank"><i class="fa-solid fa-eye"></i> Ver Sitio</a></li>
                    <li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <h1>Bienvenido, <?php echo $_SESSION['admin_user']; ?></h1>
                <div class="admin-user-info">
                    <span><?php echo date('d/m/Y'); ?></span>
                </div>
            </header>

            <section class="admin-stats">
                <div class="stat-card modern-stat-card bg-gradient-primary">
                    <div class="stat-icon"><i class="fa-solid fa-box"></i></div>
                    <div class="stat-info">
                        <h3>Total Productos</h3>
                        <span><?php echo $total_products; ?></span>
                    </div>
                </div>
                <div class="stat-card modern-stat-card bg-gradient-success">
                    <div class="stat-icon"><i class="fa-solid fa-tags"></i></div>
                    <div class="stat-info">
                        <h3>Categorías</h3>
                        <span><?php echo $total_categories; ?></span>
                    </div>
                </div>
                <div class="stat-card modern-stat-card bg-gradient-info">
                    <div class="stat-icon"><i class="fa-solid fa-copyright"></i></div>
                    <div class="stat-info">
                        <h3>Marcas</h3>
                        <span><?php echo $total_brands; ?></span>
                    </div>
                </div>
            </section>

            <section class="admin-card">
                <h3><i class="fa-solid fa-bolt"></i> Acciones Rápidas</h3>
                <div class="quick-actions" style="margin-top: 25px; display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="add_product.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Nuevo Producto</a>
                    <a href="products.php" class="btn btn-secondary"><i class="fa-solid fa-boxes-stacked"></i> Inventario</a>
                    <a href="add_category.php" class="btn btn-secondary btn-outline-success"><i class="fa-solid fa-tags"></i> Añadir Categoría</a>
                    <a href="add_brand.php" class="btn btn-secondary btn-outline-info"><i class="fa-solid fa-copyright"></i> Añadir Marca</a>
                </div>
            </section>
        </main>

        <!-- Admin Mobile Bottom Nav -->
        <nav class="admin-mobile-nav">
            <a href="dashboard.php" class="nav-item active">
                <i class="fa-solid fa-gauge"></i>
                <span>Panel</span>
            </a>
            <a href="products.php" class="nav-item">
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
</body>

</html>