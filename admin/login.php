<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (isAdminLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['contraseña'])) {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_id'] = $admin['id_admin'];
        redirect('dashboard.php');
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Administrador</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <h2>Iniciar sesión como administrador</h2>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
            <button type="submit">Ingresar</button>
        </form>
    </main>
</body>
</html>