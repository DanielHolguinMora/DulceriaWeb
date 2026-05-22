<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$error = '';
$success = '';
$id = $_GET['id'] ?? null;

if (!$id || !$pdo) {
    header('Location: products.php');
    exit;
}

// Fetch existing data
$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: products.php');
    exit;
}

// Fetch categories and brands
$categories = $pdo->query("SELECT * FROM categoria")->fetchAll();
$brands = $pdo->query("SELECT * FROM marca")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? '';
    $marca_id = $_POST['marca_id'] ?? null;

    $image_path = $product['imagen_frontal'];

    // Handle Optional Image Upload
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $upload_dir = '../uploads/';
        $file_ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_ext;
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
            // Delete old image
            if (file_exists('../' . $image_path) && is_file('../' . $image_path)) {
                unlink('../' . $image_path);
            }
            $image_path = 'uploads/' . $file_name;
        }
    }

    if (!empty($nombre) && !empty($categoria_id)) {
        try {
            $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, descripcion = ?, categoria_id = ?, marca_id = ?, imagen_frontal = ? WHERE id = ?");
            $stmt->execute([$nombre, $descripcion, $categoria_id, $marca_id, $image_path, $id]);
            $success = 'Producto actualizado con éxito.';
            // Update local object to show new data in form
            $product['nombre'] = $nombre;
            $product['descripcion'] = $descripcion;
            $product['categoria_id'] = $categoria_id;
            $product['marca_id'] = $marca_id;
            $product['imagen_frontal'] = $image_path;
        } catch (Exception $e) {
            $error = 'Error al actualizar: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Admin Dulcería</title>
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
                <h1>Editar Producto: <?php echo htmlspecialchars($product['nombre']); ?></h1>
                <a href="products.php" class="btn btn-secondary btn-sm">Volver a la lista</a>
            </header>

            <div class="admin-card">
                <?php if ($error): ?>
                    <div class="error-msg"><?php echo $error; ?></div><?php endif; ?>
                <?php if ($success): ?>
                    <div class="success-message"><?php echo $success; ?></div><?php endif; ?>

                <form action="edit_product.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data"
                    class="admin-form">
                    <div class="form-group">
                        <label for="nombre">Nombre del Producto</label>
                        <input type="text" id="nombre" name="nombre"
                            value="<?php echo htmlspecialchars($product['nombre']); ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="categoria_id">Categoría</label>
                            <select id="categoria_id" name="categoria_id" required
                                style="width:100%; padding:14px; border-radius:12px; border:2px solid #eee;">
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $product['categoria_id']) ? 'selected' : ''; ?>>
                                        <?php echo $cat['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="marca_id">Marca (Opcional)</label>
                            <select id="marca_id" name="marca_id"
                                style="width:100%; padding:14px; border-radius:12px; border:2px solid #eee;">
                                <option value="">Selecciona una marca</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?php echo $brand['id']; ?>" <?php echo ($brand['id'] == $product['marca_id']) ? 'selected' : ''; ?>>
                                        <?php echo $brand['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="imagen">Cambiar Imagen (opcional)</label>
                        <input type="file" id="imagen" name="imagen" accept="image/*">
                        <small>Imagen actual: <?php echo $product['imagen_frontal']; ?></small>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion"
                            rows="4"><?php echo htmlspecialchars($product['descripcion']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                </form>
            </div>
        </main>
    </div>
</body>

</html>