<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Validar Token CSRF
$token = $_GET['csrf_token'] ?? '';
if (empty($token) || $token !== ($_SESSION['csrf_token'] ?? '')) {
    die('Acción no autorizada: Token CSRF no válido o faltante.');
}

if (isset($_GET['id']) && $pdo) {
    $id = intval($_GET['id']);

    // 1. Obtiene la ruta de la imagen para eliminar el archivo
    $stmt = $pdo->prepare("SELECT imagen_frontal FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if ($product) {
        $image_path = '../' . $product['imagen_frontal'];
        if (file_exists($image_path) && is_file($image_path)) {
            unlink($image_path);
        }

        // 2. Elimina del registro de la base de datos
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header('Location: products.php');
exit;
?>