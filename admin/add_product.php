<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$error = '';
$success = '';

// Fetch categories and brands for the select inputs
$categories = [];
$brands = [];
if ($pdo) {
    $categories = $pdo->query("SELECT * FROM categoria")->fetchAll();
    $brands = $pdo->query("SELECT * FROM marca")->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? '';
    $marca_id = $_POST['marca_id'] ?? null;
    $stock = $_POST['stock'] ?? 0;

    // Handle Image Upload
    $image_path = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $upload_dir = '../uploads/';
        $file_ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_ext;
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
            $image_path = 'uploads/' . $file_name;
        } else {
            $error = 'Error al subir la imagen.';
        }
    } else {
        $error = 'Por favor, selecciona una imagen.';
    }

    if (empty($error) && !empty($nombre) && !empty($precio) && !empty($categoria_id)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, categoria_id, marca_id, stock, imagen_frontal) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $descripcion, $precio, $categoria_id, $marca_id, $stock, $image_path]);
            $success = 'Producto añadido con éxito.';
        } catch (Exception $e) {
            $error = 'Error al guardar en la base de datos: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - Admin Dulcería</title>
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
                    <li><a href="products.php"><i class="fa-solid fa-candy-cane"></i> Productos</a></li>
                    <li><a href="add_product.php" class="active"><i class="fa-solid fa-plus"></i> Nuevo Producto</a>
                    </li>
                    <li><a href="../index.php" target="_blank"><i class="fa-solid fa-eye"></i> Ver Sitio</a></li>
                    <li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Nuevo Producto</h1>
                <a href="products.php" class="btn btn-secondary btn-sm">Volver a la lista</a>
            </header>

            <div class="admin-card">
                <?php if ($error): ?>
                    <div class="error-msg"><?php echo $error; ?></div><?php endif; ?>
                <?php if ($success): ?>
                    <div class="success-message"><?php echo $success; ?></div><?php endif; ?>

                <form action="add_product.php" method="POST" enctype="multipart/form-data" class="admin-form">
                    <div class="form-group">
                        <label for="nombre">Nombre del Producto</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej. Mazapán Gigante" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="categoria_id">Categoría</label>
                            <select id="categoria_id" name="categoria_id" required
                                style="width:100%; padding:14px; border-radius:12px; border:2px solid #eee;">
                                <option value="">Selecciona una categoría</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="marca_id">Marca (Opcional)</label>
                            <select id="marca_id" name="marca_id"
                                style="width:100%; padding:14px; border-radius:12px; border:2px solid #eee;">
                                <option value="">Selecciona una marca</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?php echo $brand['id']; ?>"><?php echo $brand['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="precio">Precio ($)</label>
                            <input type="number" step="0.01" id="precio" name="precio" placeholder="0.00" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock Inicial</label>
                            <input type="number" id="stock" name="stock" value="0">
                        </div>
                        <div class="form-group">
                            <label for="imagen">Imagen Frontal</label>
                            <input type="file" id="imagen" name="imagen" accept="image/*" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="4"
                            placeholder="Breve descripción del producto..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </form>
            </div>
        </main>
    </div>
</body>

</html>