<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once 'config/database.php';
require_once 'models/Marca.php';

$database = new Database();
$db = $database->getConnection();
$marca = new Marca($db);

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed-dim": "#ffb59b",
                        "tertiary-container": "#959494",
                        "on-secondary-container": "#71604e",
                        "surface-container-highest": "#e5e2e1",
                        "on-background": "#1b1b1b",
                        "surface": "#fcf9f8",
                        "on-surface": "#1b1b1b",
                        "on-secondary-fixed-variant": "#534433",
                        "surface-container": "#f0eded",
                        "surface-container-low": "#f6f3f2",
                        "on-primary-fixed-variant": "#812900",
                        "on-tertiary-fixed-variant": "#474747",
                        "inverse-surface": "#313030",
                        "error": "#ba1a1a",
                        "tertiary-fixed-dim": "#c8c6c6",
                        "surface-bright": "#fcf9f8",
                        "secondary-container": "#f3dcc5",
                        "error-container": "#ffdad6",
                        "tertiary": "#5f5e5e",
                        "surface-tint": "#a93800",
                        "inverse-primary": "#ffb59b",
                        "surface-container-lowest": "#ffffff",
                        "secondary-fixed-dim": "#d9c3ad",
                        "surface-container-high": "#eae7e7",
                        "on-error": "#ffffff",
                        "on-tertiary-fixed": "#1b1c1c",
                        "outline-variant": "#e3bfb3",
                        "secondary": "#6c5b4a",
                        "on-primary": "#ffffff",
                        "primary-fixed": "#ffdbcf",
                        "primary-container": "#EFBD79",
                        "background": "#fcf9f8",
                        "on-tertiary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-secondary": "#ffffff",
                        "tertiary-fixed": "#e4e2e1",
                        "inverse-on-surface": "#f3f0ef",
                        "primary": "#E59120",
                        "secondary-fixed": "#f6dfc8",
                        "on-primary-fixed": "#380d00",
                        "on-primary-container": "#551800",
                        "on-tertiary-container": "#2d2d2d",
                        "outline": "#8e7066",
                        "on-secondary-fixed": "#25190b",
                        "on-surface-variant": "#5a4138",
                        "surface-variant": "#e5e2e1",
                        "surface-dim": "#dcd9d9"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "lg": "48px",
                        "margin": "32px",
                        "md": "24px",
                        "gutter": "24px",
                        "xs": "8px",
                        "unit": "4px",
                        "xl": "80px",
                        "sm": "16px"
                    },
                    "fontFamily": {
                        "label-bold": ["Lexend"],
                        "label-sm": ["Lexend"],
                        "headline-md": ["Lexend"],
                        "headline-lg": ["Lexend"],
                        "body-md": ["Lexend"],
                        "body-lg": ["Lexend"],
                        "headline-xl": ["Lexend"]
                    },
                    "fontSize": {
                        "label-bold": ["14px", { "lineHeight": "1.2", "fontWeight": "700" }],
                        "label-sm": ["12px", { "lineHeight": "1.2", "fontWeight": "600" }],
                        "headline-md": ["32px", { "lineHeight": "1.2", "fontWeight": "700" }],
                        "headline-lg": ["48px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "800" }],
                        "body-md": ["16px", { "lineHeight": "1.5", "fontWeight": "400" }],
                        "body-lg": ["20px", { "lineHeight": "1.6", "fontWeight": "500" }],
                        "headline-xl": ["80px", { "lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "900" }]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;
        }

        body {
            background-color: #fcf9f8;
            color: #1b1b1b;
            font-family: 'Lexend', sans-serif;
        }

        .brand-shadow {
            box-shadow: 4px 4px 0px 0px #1b1b1b;
        }

        .btn-active:active {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px 0px #1b1b1b;
        }
    </style>
</head>

<body class="bg-background text-on-background min-h-screen flex flex-col">
    <!-- TopNavBar -->
    <header
        class="bg-primary flex justify-between items-center w-full px-6 py-4 sticky top-0 z-50 border-b-4 border-on-background">
        <div class="flex items-center gap-6">
            <div class="bg-white p-1 border-2 border-on-primary brand-shadow">
                <img src="uploads/LogoElLoco.jpg" alt="Dulcería El Loco" class="h-10 w-auto">
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="index.php"
                class="p-2 border-2 border-on-background bg-secondary-fixed hover:bg-secondary-fixed-dim transition-all text-on-background brand-shadow btn-active"
                title="Ir a la Tienda">
                <span class="material-symbols-outlined" data-icon="storefront">storefront</span>
            </a>
            <a href="login.php?action=logout"
                class="p-2 border-2 border-on-background bg-secondary-fixed hover:bg-secondary-fixed-dim transition-all text-on-background brand-shadow btn-active"
                title="Cerrar Sesión">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
            </a>
        </div>
    </header>
    <div class="flex flex-1 overflow-hidden">
        <!-- SideNavBar -->
        <aside
            class="hidden md:flex flex-col w-64 bg-surface border-r-4 border-on-background h-screen pt-4 pb-4 sticky top-20 z-30">
            <div class="px-6 mb-8">
                <h2 class="text-xl font-black text-on-background uppercase italic">Panel Admin</h2>
                <p class="text-xs font-bold text-primary uppercase tracking-widest">Gestión Dulce</p>
            </div>
            <nav class="flex flex-col gap-2 px-3">
                <a class="flex items-center gap-3 px-4 py-3 text-on-background border-2 border-transparent hover:border-on-background hover:bg-secondary-container transition-all font-bold"
                    href="dashboard.php">
                    <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-on-background border-2 border-transparent hover:border-on-background hover:bg-secondary-container transition-all font-bold"
                    href="gestion_productos.php">
                    <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                    <span>Inventario</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-on-background border-2 border-transparent hover:border-on-background hover:bg-secondary-container transition-all font-bold"
                    href="gestion_categorias.php">
                    <span class="material-symbols-outlined" data-icon="category">category</span>
                    <span>Categorías</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-on-background border-2 border-on-background bg-secondary-container transition-all font-bold brand-shadow"
                    href="gestion_marcas.php">
                    <span class="material-symbols-outlined" data-icon="sell">sell</span>
                    <span>Marcas</span>
                </a>
            </nav>
            <div class="mt-auto px-4">
                <a href="nuevo_producto.php"
                    class="w-full py-4 block text-center bg-primary text-on-primary font-black uppercase border-2 border-on-background brand-shadow btn-active hover:bg-primary-container transition-all">
                    Añadir Producto
                </a>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-surface-container-low p-6 md:p-12">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center justify-between gap-4 mb-10">
                    <div class="flex items-center gap-4">
                        <h1
                            class="font-headline-md text-headline-md text-on-background uppercase tracking-tighter italic">
                            Gestión de Marcas
                        </h1>
                    </div>
                    <a href="nueva_marca.php"
                        class="px-8 py-4 bg-primary text-on-primary font-black uppercase text-lg border-4 border-on-background brand-shadow btn-active hover:bg-primary-container transition-colors">
                        Añadir Nueva
                    </a>
                </div>

                <?php if ($msg == 'created'): ?>
                    <div
                        class="bg-primary-fixed border-4 border-on-background p-4 mb-8 brand-shadow text-on-background font-bold text-center uppercase tracking-widest">
                        Marca creada exitosamente.
                    </div>
                <?php elseif ($msg == 'updated'): ?>
                    <div
                        class="bg-primary-fixed border-4 border-on-background p-4 mb-8 brand-shadow text-on-background font-bold text-center uppercase tracking-widest">
                        Marca actualizada exitosamente.
                    </div>
                <?php elseif ($msg == 'deleted'): ?>
                    <div
                        class="bg-error border-4 border-on-background p-4 mb-8 brand-shadow text-on-error font-bold text-center uppercase tracking-widest">
                        Marca eliminada.
                    </div>
                <?php elseif ($msg == 'error'): ?>
                    <div
                        class="bg-error border-4 border-on-background p-4 mb-8 brand-shadow text-on-error font-bold text-center uppercase tracking-widest">
                        Hubo un error en la operación.
                    </div>
                <?php endif; ?>

                <div class="bg-white border-4 border-on-background brand-shadow overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-secondary-fixed border-b-4 border-on-background text-on-background font-black uppercase text-sm tracking-widest">
                                <th class="p-4 border-r-4 border-on-background">ID</th>
                                <th class="p-4 border-r-4 border-on-background">Nombre</th>
                                <th class="p-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="font-body-md text-on-background">
                            <?php
                            $stmt = $marca->readAll();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr class='border-b-4 border-on-background hover:bg-surface-container transition-colors'>";
                                echo "<td class='p-4 border-r-4 border-on-background font-bold'>" . $row['id'] . "</td>";
                                echo "<td class='p-4 border-r-4 border-on-background font-black uppercase italic'>" . htmlspecialchars($row['nombre']) . "</td>";
                                echo "<td class='p-4'>
                        <div class='flex gap-4 justify-center'>
                            <a href='nueva_marca.php?edit=" . $row['id'] . "' class='px-4 py-2 bg-primary text-on-primary font-black uppercase border-2 border-on-background brand-shadow btn-active hover:bg-primary-container transition-colors text-sm'>Editar</a>
                            <a href='controllers/AdminController.php?action=delete_brand&id=" . $row['id'] . "' class='px-4 py-2 bg-error text-on-error font-black uppercase border-2 border-on-background brand-shadow btn-active hover:bg-red-700 transition-colors text-sm' onclick='return confirm(\"¿Estás seguro? Esto podría afectar a los productos asociados.\")'>Eliminar</a>
                        </div>
                      </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>
    <!-- Footer -->
    <footer
        class="bg-on-background text-on-primary w-full py-8 px-10 flex flex-col md:flex-row justify-between items-center border-t-4 border-primary mt-auto z-50">
        <div class="flex items-center gap-4 mb-4 md:mb-0">
            <span class="text-primary font-black text-2xl tracking-tighter italic">DULCERÍA EL LOCO</span>
            <span class="font-lexend font-bold text-xs uppercase opacity-60">© 2024 - Admin Panel</span>
        </div>
        <div class="flex gap-8">
            <a class="font-lexend font-bold text-xs uppercase hover:text-primary transition-colors underline underline-offset-4"
                href="#">Soporte</a>
            <a class="font-lexend font-bold text-xs uppercase hover:text-primary transition-colors"
                href="#">Privacidad</a>
            <a class="font-lexend font-bold text-xs uppercase hover:text-primary transition-colors"
                href="#">Términos</a>
        </div>
    </footer>
</body>

</html>