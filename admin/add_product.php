<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$error = '';
$success = '';

// Obtiene las categorías y marcas para los campos de selección
$categories = [];
$brands = [];
if ($pdo) {
    $categories = $pdo->query("SELECT * FROM categoria")->fetchAll();
    $brands = $pdo->query("SELECT * FROM marca")->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    $token = $_POST['csrf_token'] ?? '';
    if (empty($token) || $token !== ($_SESSION['csrf_token'] ?? '')) {
        die('Acción no autorizada: Token CSRF no válido o faltante.');
    }

    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? '';
    $marca_id = $_POST['marca_id'] ?? null;

    // Maneja la subida de la imagen
    $image_path = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $upload_dir = '../uploads/';
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
        $file_ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_exts)) {
            // Verificar si el archivo es realmente una imagen
            $check = getimagesize($_FILES['imagen']['tmp_name']);
            if ($check !== false) {
                $file_name = uniqid() . '.' . $file_ext;
                $target_file = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                    $image_path = 'uploads/' . $file_name;
                } else {
                    $error = 'Error al subir la imagen al servidor.';
                }
            } else {
                $error = 'El archivo subido no es una imagen válida.';
            }
        } else {
            $error = 'Formato de imagen no permitido. Usa JPG, PNG o WEBP.';
        }
    } else {
        $error = 'Por favor, selecciona una imagen válida.';
    }

    if (empty($error) && !empty($nombre) && !empty($categoria_id)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, categoria_id, marca_id, imagen_frontal) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $descripcion, $categoria_id, $marca_id, $image_path]);
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
    <link rel="icon" type="image/png" href="../assets/img/Favicon4.png">
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
                    <li><a href="add_product.php" class="active"><i class="fa-solid fa-plus"></i> Nuevo Producto</a></li>
                    <li><a href="add_brand.php"><i class="fa-solid fa-copyright"></i> Marcas</a></li>
                    <li><a href="add_category.php"><i class="fa-solid fa-tags"></i> Categorías</a></li>
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
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
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
                            <label for="marca_id">Marca</label>
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
                            <label for="imagen">Imagen Frontal</label>
                            <input type="file" id="imagen" name="imagen" accept="image/png, image/jpeg, image/webp" required>
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
    <!-- Admin Mobile Bottom Nav -->
        <nav class="admin-mobile-nav">
            <a href="dashboard.php" class="nav-item">
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
</body>

</html>