<?php
session_start();

function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function getProductById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM producto WHERE id_producto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>