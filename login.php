<?php
session_start();
require_once 'includes/db.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: admin/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        if ($pdo) {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_user'] = $user['username'];
                header('Location: admin/dashboard.php');
                exit;
            } else {
                sleep(1); // Retraso anti fuerza bruta
                $error = 'Credenciales inválidas';
            }
        } else {
            $error = 'Error de conexión a la base de datos';
        }
    } else {
        $error = 'Por favor, rellene todos los campos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/Favicon4.png">
    <title>Admin Login - Dulcería El Loco</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>ADMIN PANEL</h2>
                <p>Ingresa tus credenciales para continuar</p>
            </div>

            <?php if ($error): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" placeholder="Usuario" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">
                    Iniciar Sesión
                </button>
            </form>

            <div class="login-footer">
                <a href="index.php">← Volver al sitio</a>
            </div>
        </div>
    </div>
</body>

</html>