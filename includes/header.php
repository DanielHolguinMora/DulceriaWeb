<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulcería El Loco - Los mejores dulces en Ciudad Juárez</title>
    <meta name="description"
        content="Descubre la mejor variedad de dulces mexicanos, importados y snacks en el centro de Ciudad Juárez. Calidad premium y sabor inigualable.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Outfit:wght@400;600;800&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <header class="main-header" id="header">
        <nav class="navbar container">
            <div class="nav-logo">
                <a href="index.php">
                    <img src="assets/img/LogoSolo.png" alt="Dulcería El Loco Logo" class="logo-img">
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

            <div class="nav-actions">
                <a href="login.php" class="btn btn-secondary btn-sm">
                    <i class="fa-solid fa-user"></i> Admin
                </a>
                <button class="mobile-menu-btn" id="mobile-menu-btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
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
            <span>Dulces</span>
        </a>
        <div class="nav-item-center">
            <a href="index.php" class="center-logo">
                <img src="assets/img/LogoSolo.png" alt="Logo">
            </a>
        </div>
        <a href="favoritos.php" class="nav-item <?php echo $current_page == 'favoritos.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-heart"></i>
            <span>Favoritos</span>
        </a>
        <a href="contacto.php" class="nav-item <?php echo $current_page == 'contacto.php' ? 'active' : ''; ?>">
            <i class="fa-solid fa-envelope"></i>
            <span>Contacto</span>
        </a>
    </nav>