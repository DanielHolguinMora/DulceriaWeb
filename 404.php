<?php
$page_title = 'Página no encontrada - Dulcería El Loco';
require_once 'includes/header.php';
?>

<div class="error-page" style="min-height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 100px 20px;">
    <div class="container">
        <h1 style="font-size: 8rem; color: var(--primary); margin-bottom: 0; line-height: 1;">404</h1>
        <h2 style="font-size: 2.5rem; margin-bottom: 20px;">¡Ups! Te has perdido en la dulcería.</h2>
        <p style="font-size: 1.2rem; color: var(--text-muted); margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">
            Parece que el dulce que estabas buscando no existe o se ha movido a otra ubicación. 
            No te preocupes, tenemos muchos más esperando por ti.
        </p>
        <a href="index.php" class="btn btn-primary" style="font-size: 1.1rem; padding: 15px 40px;">Volver al Inicio</a>
    </div>
</div>

 <?php require_once 'includes/footer.php'; ?>
