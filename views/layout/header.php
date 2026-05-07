<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$base_url = '/dulceria/';
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dulcería El Loco</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <style>
        @font-face {
            font-family: 'Cal Sans';
            src: url('https://fonts.cdnfonts.com/s/76251/CalSans-SemiBold.woff') format('woff');
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;
        }

        .flat-bold-borders {
            box-shadow: 4px 4px 0px 0px #1C1A1B;
        }

        .flat-bold-borders-small {
            box-shadow: 2px 2px 0px 0px #1C1A1B;
        }

        .active-button-shift:active {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px 0px #1C1A1B;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            display: flex;
            width: 200%;
            animation: marquee 20s linear infinite;
        }
    </style>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-container": "#e59120",
                        "primary-fixed-dim": "#ffb869",
                        "error-container": "#ffdad6",
                        "tertiary-fixed-dim": "#d6ca00",
                        "on-tertiary-fixed": "#1e1c00",
                        "on-secondary-container": "#fffbff",
                        "surface": "#fef8f9",
                        "secondary-container": "#e0292e",
                        "surface-dim": "#ded9da",
                        "on-error-container": "#93000a",
                        "on-primary-container": "#563200",
                        "on-tertiary-fixed-variant": "#4d4800",
                        "background": "#fef8f9",
                        "on-secondary": "#ffffff",
                        "on-primary-fixed": "#2c1700",
                        "outline-variant": "#d8c3af",
                        "secondary-fixed": "#ffdad6",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed": "#f4e700",
                        "surface-container-low": "#f8f2f3",
                        "surface-container-highest": "#e7e1e2",
                        "inverse-primary": "#ffb869",
                        "on-surface": "#1d1b1c",
                        "inverse-on-surface": "#f5eff0",
                        "on-secondary-fixed-variant": "#930011",
                        "on-tertiary-container": "#3f3b00",
                        "outline": "#867463",
                        "secondary": "#bb0119",
                        "on-background": "#1d1b1c",
                        "secondary-fixed-dim": "#ffb3ad",
                        "on-primary-fixed-variant": "#673d00",
                        "on-primary": "#ffffff",
                        "surface-tint": "#885200",
                        "primary-fixed": "#ffdcbb",
                        "surface-container": "#f3eced",
                        "on-error": "#ffffff",
                        "surface-variant": "#e7e1e2",
                        "primary": "#885200",
                        "inverse-surface": "#323031",
                        "on-surface-variant": "#534435",
                        "on-secondary-fixed": "#410003",
                        "surface-container-high": "#ede7e8",
                        "surface-bright": "#fef8f9",
                        "tertiary-container": "#b0a700",
                        "error": "#ba1a1a",
                        "surface-container-lowest": "#ffffff",
                        "tertiary": "#666000"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "sm": "16px",
                        "xl": "64px",
                        "xs": "8px",
                        "base": "4px",
                        "gutter": "16px",
                        "margin": "20px",
                        "lg": "40px",
                        "md": "24px"
                    },
                    "fontFamily": {
                        "label-bold": ["Lexend"],
                        "caption": ["Lexend"],
                        "h2": ["Cal Sans"],
                        "h1": ["Cal Sans"],
                        "body-lg": ["Lexend"],
                        "h3": ["Cal Sans"],
                        "body-md": ["Lexend"]
                    },
                    "fontSize": {
                        "label-bold": ["14px", { "lineHeight": "1", "fontWeight": "600" }],
                        "caption": ["12px", { "lineHeight": "1.4", "fontWeight": "400" }],
                        "h2": ["32px", { "lineHeight": "1.2", "fontWeight": "700" }],
                        "h1": ["48px", { "lineHeight": "1.1", "fontWeight": "700" }],
                        "body-lg": ["18px", { "lineHeight": "1.5", "fontWeight": "400" }],
                        "h3": ["24px", { "lineHeight": "1.2", "fontWeight": "700" }],
                        "body-md": ["16px", { "lineHeight": "1.5", "fontWeight": "400" }]
                    }
                },
            },
        }
    </script>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
</head>

<body class="bg-background font-body-md text-on-background">

    <nav
        class="sticky top-0 z-50 flex justify-between items-center w-full px-6 py-4 bg-[#E59120] border-b-4 border-[#1C1A1B]">
        <div class="flex items-center gap-4">
            <a href="<?php echo $base_url; ?>" class="hover:scale-105 transition-transform active-button-shift">
                <img src="<?php echo $base_url; ?>uploads/LogoSolo.png" alt="Dulcería El Loco"
                    class=" h-14 w-auto border-2 border-[#1C1A1B] flat-bold-borders-small bg-white">
            </a>
        </div>
        <div class="hidden md:flex items-center gap-8">
            <a class="<?php echo ($current_page == 'index.php' || $current_page == '') ? 'text-white border-b-4 border-white pb-1 font-black' : 'text-[#EFBD79] hover:bg-[#EFBD79] hover:text-[#1C1A1B] transition-all font-bold'; ?> font-['Lexend'] uppercase tracking-tight"
                href="<?php echo $base_url; ?>">Inicio</a>
            <a class="<?php echo ($current_page == 'catalogo.php') ? 'text-white border-b-4 border-white pb-1 font-black' : 'text-[#EFBD79] hover:bg-[#EFBD79] hover:text-[#1C1A1B] transition-all font-bold'; ?> font-['Lexend'] uppercase tracking-tight"
                href="<?php echo $base_url; ?>catalogo.php">Catálogo</a>
            <a class="<?php echo ($current_page == 'favoritos.php') ? 'text-white border-b-4 border-white pb-1 font-black' : 'text-[#EFBD79] hover:bg-[#EFBD79] hover:text-[#1C1A1B] transition-all font-bold'; ?> font-['Lexend'] uppercase tracking-tight"
                href="<?php echo $base_url; ?>favoritos.php">Favoritos</a>
            <a class="<?php echo ($current_page == 'contacto.php') ? 'text-white border-b-4 border-white pb-1 font-black' : 'text-[#EFBD79] hover:bg-[#EFBD79] hover:text-[#1C1A1B] transition-all font-bold'; ?> font-['Lexend'] uppercase tracking-tight"
                href="<?php echo $base_url; ?>contacto.php">Contacto</a>
        </div>
        <div class="flex items-center gap-4">
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                <a href="<?php echo $base_url; ?>dashboard.php"
                    class="text-white font-bold uppercase tracking-tight hover:text-[#1C1A1B]">Dashboard</a>
                <a href="<?php echo $base_url; ?>login.php?action=logout"
                    class="text-[#1C1A1B] bg-white px-3 py-1 font-bold uppercase flat-bold-borders border-2 border-[#1C1A1B]">Salir</a>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>login.php"
                    class="material-symbols-outlined text-white cursor-pointer hover:bg-[#EFBD79] hover:text-[#1C1A1B] p-2 transition-all">account_circle</a>
            <?php endif; ?>
        </div>
    </nav>