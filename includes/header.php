<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/Favicon4.png">
    <title>Dulcería El Loco | Dulces, Piñatas y Desechables</title>
    <meta name="description" content="Encuentra dulces, piñatas, desechables y artículos para fiesta en Ciudad Juárez. Dulcería El Loco ofrece gran variedad y atención personalizada.">
    <meta name="keywords" content="dulcería en ciudad juárez, dulces, piñatas, desechables, artículos para fiesta">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Outfit:wght@400;600;800&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <header class="main-header" id="header">
        <nav class="navbar container">
            <div class="nav-logo">
                <a href="index.php">
                    <img src="assets/img/LogoSolo.png" alt="Dulcería El Loco Logo" class="logo-img">
                    <p class="logo-text">Dulcería <span class="logo-text-accent">El Loco!</span></p>
                </a>
            </div>

            <ul class="nav-links">
                <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
                <li><a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Inicio</a>
                </li>
                <li><a href="catalogo.php"
                        class="<?php echo $current_page == 'catalogo.php' ? 'active' : ''; ?>">Catálogo</a></li>
                <li><a href="favoritos.php"
                        class="<?php echo $current_page == 'favoritos.php' ? 'active' : ''; ?>">Favoritos</a></li>
                <li><a href="nosotros.php"
                        class="<?php echo $current_page == 'nosotros.php' ? 'active' : ''; ?>">Nosotros</a></li>
                <li><a href="contacto.php"
                        class="<?php echo $current_page == 'contacto.php' ? 'active' : ''; ?>">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <a href="index.php" class="nav-item <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-house"></i>
            <span>Inicio</span>
        </a>
        <a href="catalogo.php" class="nav-item <?php echo $current_page == 'catalogo.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-candy-cane"></i>
            <span>Catálogo</span>
        </a>
        <a href="favoritos.php" class="nav-item <?php echo $current_page == 'favoritos.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-heart"></i>
            <span>Favoritos</span>
        </a>
        <a href="contacto.php" class="nav-item <?php echo $current_page == 'contacto.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-envelope"></i>
            <span>Contacto</span>
        </a>
        <a href="https://wa.me/526561968945?text=<?php echo urlencode('Hola! Me gustaría obtener más información sobre sus productos.'); ?>" class="nav-item whatsapp-nav-item" target="_blank">
            <i class="fa-brands fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
    </nav>