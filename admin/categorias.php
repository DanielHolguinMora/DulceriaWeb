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
    if ($accion === 'agregar') {
        $stmt = $conn->prepare("INSERT INTO categoria (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Categoría agregada.";
        } else {
            $_SESSION['error'] = "Error al agregar.";
        }
    } elseif ($accion === 'editar' && $id > 0) {
        $stmt = $conn->prepare("UPDATE categoria SET nombre = ? WHERE id_categoria = ?");
        $stmt->bind_param("si", $nombre, $id);
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Categoría actualizada.";
        } else {
            $_SESSION['error'] = "Error al actualizar.";
        }
    }
    redirect('categorias.php');
}

if ($accion === 'eliminar' && $id > 0) {
    $stmt = $conn->prepare("DELETE FROM categoria WHERE id_categoria = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Categoría eliminada.";
    } else {
        $_SESSION['error'] = "No se puede eliminar porque tiene productos asociados.";
    }
    redirect('categorias.php');
}

$categoria_editar = null;
if ($accion === 'editar' && $id > 0) {
    $stmt = $conn->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $categoria_editar = $stmt->get_result()->fetch_assoc();
    if (!$categoria_editar) redirect('categorias.php');
}

include '../includes/header.php';
?>

<h2>Gestión de Categorías</h2>

<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php if ($accion === 'agregar' || $accion === 'editar'): ?>
    <h3><?php echo ($accion === 'agregar') ? 'Agregar Categoría' : 'Editar Categoría'; ?></h3>
    <form method="post">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($categoria_editar['nombre'] ?? ''); ?>" required>
        <button type="submit">Guardar</button>
        <a href="categorias.php" class="btn">Cancelar</a>
    </form>
<?php else: ?>
    <a href="categorias.php?accion=agregar" class="btn">Agregar categoría</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $categorias = $conn->query("SELECT * FROM categoria");
            while ($row = $categorias->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $row['id_categoria']; ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td>
                        <a href="categorias.php?accion=editar&id=<?php echo $row['id_categoria']; ?>" class="btn btn-small">Editar</a>
                        <a href="categorias.php?accion=eliminar&id=<?php echo $row['id_categoria']; ?>" class="btn btn-small btn-danger" onclick="return confirm('¿Eliminar categoría?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>