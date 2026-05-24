<?php
header('Content-Type: application/json');
require_once 'includes/db.php';

if (!$pdo) {
    echo json_encode(['status' => 'error', 'message' => 'No hay conexión a la base de datos.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido. Use POST.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$product_id = isset($data['id']) ? intval($data['id']) : (isset($_POST['id']) ? intval($_POST['id']) : null);
$action = isset($data['action']) ? $data['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if (!$product_id) {
    echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado.']);
    exit;
}

if ($action !== 'like' && $action !== 'unlike') {
    echo json_encode(['status' => 'error', 'message' => 'Acción no válida. Debe ser "like" o "unlike".']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT likes FROM productos WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado.']);
        exit;
    }

    $current_likes = intval($product['likes']);
    
    if ($action === 'like') {
        $new_likes = $current_likes + 1;
    } else {
        $new_likes = max(0, $current_likes - 1);
    }

    $updateStmt = $pdo->prepare("UPDATE productos SET likes = ? WHERE id = ?");
    $updateStmt->execute([$new_likes, $product_id]);

    echo json_encode([
        'status' => 'success',
        'id' => $product_id,
        'action' => $action,
        'likes' => $new_likes
    ]);
    exit;

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error de servidor: ' . $e->getMessage()]);
    exit;
}
?>
