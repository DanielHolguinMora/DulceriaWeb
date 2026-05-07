<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isAdminLoggedIn()) {
    redirect('login.php');
}

$totalProductos = $conn->query("SELECT COUNT(*) as total FROM producto")->fetch_assoc()['total'];
$totalCategorias = $conn->query("SELECT COUNT(*) as total FROM categoria")->fetch_assoc()['total'];
$totalMarcas = $conn->query("SELECT COUNT(*) as total FROM marca")->fetch_assoc()['total'];
$totalMensajes = $conn->query("SELECT COUNT(*) as total FROM mensajes_contacto")->fetch_assoc()['total'];

include '../includes/header.php';
?>
<h2>Panel de Administración</h2>
<div style="display: flex; gap: 1rem; flex-wrap: wrap;">
    <div class="card" style="background: #f4a261; padding: 1rem; border-radius: 8px; min-width: 150px;">
        <h3>Productos</h3>
        <p><?php echo $totalProductos; ?></p>
        <a href="productos.php" class="btn">Gestionar</a>
    </div>
    <div class="card" style="background: #e9c46a; padding: 1rem; border-radius: 8px; min-width: 150px;">
        <h3>Categorías</h3>
        <p><?php echo $totalCategorias; ?></p>
        <a href="categorias.php" class="btn">Gestionar</a>
    </div>
    <div class="card" style="background: #2a9d8f; padding: 1rem; border-radius: 8px; min-width: 150px;">
        <h3>Marcas</h3>
        <p><?php echo $totalMarcas; ?></p>
        <a href="marcas.php" class="btn">Gestionar</a>
    </div>
    <div class="card" style="background: #e76f51; padding: 1rem; border-radius: 8px; min-width: 150px;">
        <h3>Mensajes</h3>
        <p><?php echo $totalMensajes; ?></p>
        <a href="mensajes.php" class="btn">Ver</a>
    </div>
</div>
<?php include '../includes/footer.php'; ?>