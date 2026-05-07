<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isAdminLoggedIn()) {
    redirect('login.php');
}

include '../includes/header.php';
?>
<h2>Mensajes de Contacto</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Mensaje</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $mensajes = $conn->query("SELECT * FROM mensajes_contacto ORDER BY fecha DESC");
        while ($msg = $mensajes->fetch_assoc()):
        ?>
            <tr>
                <td><?php echo $msg['id_mensaje']; ?></td>
                <td><?php echo htmlspecialchars($msg['nombre']); ?></td>
                <td><?php echo htmlspecialchars($msg['email']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($msg['mensaje'])); ?></td>
                <td><?php echo $msg['fecha']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>