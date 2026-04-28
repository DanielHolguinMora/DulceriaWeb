<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isAdminLoggedIn()) {
    redirect('login.php');
}

$accion = $_GET['accion'] ?? 'listar';
$id = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $id_categoria = $_POST['id_categoria'];
    $id_marca = $_POST['id_marca'];
    $stock = $_POST['stock'];
    $imagen = $_POST['imagen_actual'] ?? '';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombre_imagen = uniqid() . '.' . $extension;
        $ruta_destino = '../uploads/' . $nombre_imagen;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
            $imagen = $nombre_imagen;
        } else {
            $error = "Error al subir la imagen.";
        }
    }

    if (!isset($error)) {
        if ($accion === 'agregar') {
            $stmt = $conn->prepare("INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_marca, imagen, stock, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssdiisi", $nombre, $descripcion, $precio, $id_categoria, $id_marca, $imagen, $stock);
            if ($stmt->execute()) {
                $_SESSION['mensaje'] = "Producto agregado correctamente.";
                redirect('productos.php');
            } else {
                $error = "Error al agregar: " . $conn->error;
            }
        } elseif ($accion === 'editar' && $id > 0) {
            $stmt = $conn->prepare("UPDATE producto SET nombre=?, descripcion=?, precio=?, id_categoria=?, id_marca=?, imagen=?, stock=? WHERE id_producto=?");
            $stmt->bind_param("ssdiisii", $nombre, $descripcion, $precio, $id_categoria, $id_marca, $imagen, $stock, $id);
            if ($stmt->execute()) {
                $_SESSION['mensaje'] = "Producto actualizado.";
                redirect('productos.php');
            } else {
                $error = "Error al actualizar: " . $conn->error;
            }
        }
    }
}

if ($accion === 'eliminar' && $id > 0) {
    $stmt = $conn->prepare("DELETE FROM producto WHERE id_producto = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Producto eliminado.";
    } else {
        $_SESSION['error'] = "Error al eliminar.";
    }
    redirect('productos.php');
}

$producto = null;
if ($accion === 'editar' && $id > 0) {
    $producto = getProductById($conn, $id);
    if (!$producto) {
        redirect('productos.php');
    }
}

$categorias = $conn->query("SELECT * FROM categoria");
$marcas = $conn->query("SELECT * FROM marca");

include '../includes/header.php';
?>

<h2>Gestión de Productos</h2>

<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php if ($accion === 'agregar' || $accion === 'editar'): ?>
    <h3><?php echo ($accion === 'agregar') ? 'Agregar Producto' : 'Editar Producto'; ?></h3>
    <form method="post" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre'] ?? ''); ?>" required>

        <label>Descripción:</label>
        <textarea name="descripcion"><?php echo htmlspecialchars($producto['descripcion'] ?? ''); ?></textarea>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio'] ?? ''); ?>" required>

        <label>Categoría:</label>
        <select name="id_categoria" required>
            <option value="">Seleccione</option>
            <?php while ($cat = $categorias->fetch_assoc()): ?>
                <option value="<?php echo $cat['id_categoria']; ?>" <?php if (isset($producto) && $producto['id_categoria'] == $cat['id_categoria']) echo 'selected'; ?>>
                    <?php echo $cat['nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Marca:</label>
        <select name="id_marca" required>
            <option value="">Seleccione</option>
            <?php while ($mar = $marcas->fetch_assoc()): ?>
                <option value="<?php echo $mar['id_marca']; ?>" <?php if (isset($producto) && $producto['id_marca'] == $mar['id_marca']) echo 'selected'; ?>>
                    <?php echo $mar['nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Stock:</label>
        <input type="number" name="stock" value="<?php echo htmlspecialchars($producto['stock'] ?? 0); ?>" required>

        <label>Imagen (dejar vacío si no se cambia):</label>
        <input type="file" name="imagen" accept="image/*">
        <?php if (isset($producto) && $producto['imagen']): ?>
            <input type="hidden" name="imagen_actual" value="<?php echo $producto['imagen']; ?>">
            <p>Imagen actual: <img src="../uploads/<?php echo $producto['imagen']; ?>" width="100"></p>
        <?php endif; ?>

        <button type="submit">Guardar</button>
        <a href="productos.php" class="btn">Cancelar</a>
    </form>
<?php else: ?>
    <a href="productos.php?accion=agregar" class="btn">Agregar producto</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $productos = $conn->query("SELECT * FROM producto");
            while ($row = $productos->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $row['id_producto']; ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td>$<?php echo number_format($row['precio'], 2); ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td><img src="../uploads/<?php echo $row['imagen']; ?>" width="50"></td>
                    <td>
                        <a href="productos.php?accion=editar&id=<?php echo $row['id_producto']; ?>" class="btn btn-small">Editar</a>
                        <a href="productos.php?accion=eliminar&id=<?php echo $row['id_producto']; ?>" class="btn btn-small btn-danger" onclick="return confirm('¿Eliminar producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>