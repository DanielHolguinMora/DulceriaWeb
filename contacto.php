<?php
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $mensaje = trim($_POST['mensaje']);

    $errores = [];
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if (empty($email)) $errores[] = "El email es obligatorio.";
    if (empty($mensaje)) $errores[] = "El mensaje es obligatorio.";

    if (empty($errores)) {
        $stmt = $conn->prepare("INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $mensaje);
        if ($stmt->execute()) {
            $exito = "Mensaje enviado correctamente. ¡Gracias por contactarnos!";
        } else {
            $errores[] = "Error al guardar el mensaje.";
        }
    }
}
?>
<h2>Contacto</h2>
<?php if (isset($exito)): ?>
    <div class="alert alert-success"><?php echo $exito; ?></div>
<?php endif; ?>
<?php if (!empty($errores)): ?>
    <div class="alert alert-error">
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="contacto.php">
    <label>Nombre:</label>
    <input type="text" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">

    <label>Email:</label>
    <input type="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">

    <label>Mensaje:</label>
    <textarea name="mensaje" rows="5" required><?php echo htmlspecialchars($_POST['mensaje'] ?? ''); ?></textarea>

    <button type="submit">Enviar mensaje</button>
</form>

<p>También puedes visitarnos en: Av. Dulce 123, Ciudad, o llamarnos al (123) 456-7890.</p>

<?php require_once 'includes/footer.php'; ?>