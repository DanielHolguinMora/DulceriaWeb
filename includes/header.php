<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'db.php';
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulcería</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <header>
        <h1>Dulcería El Sabor</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="catalogo.php">Catálogo</a>
            <a href="favoritos.php">Favoritos</a>
            <a href="nosotros.php">Nosotros</a>
            <a href="contacto.php">Contacto</a>
            <?php if (isAdminLoggedIn()): ?>
                <a href="admin/dashboard.php">Admin</a>
                <a href="admin/logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a href="admin/login.php">Iniciar sesión</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>