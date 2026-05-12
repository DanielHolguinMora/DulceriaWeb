<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

if (isset($_GET['id']) && $pdo) {
    $id = $_GET['id'];

    // 1. Get image path to delete file
    $stmt = $pdo->prepare("SELECT imagen_frontal FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if ($product) {
        $image_path = '../' . $product['imagen_frontal'];
        if (file_exists($image_path) && is_file($image_path)) {
            unlink($image_path);
        }

        // 2. Delete from database
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header('Location: products.php');
exit;
?>