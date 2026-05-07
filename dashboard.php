<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once 'config/database.php';
require_once 'models/Producto.php';
require_once 'models/Categoria.php';
require_once 'models/Marca.php';

$database = new Database();
$db = $database->getConnection();
$producto = new Producto($db);
$categoria = new Categoria($db);
$marca = new Marca($db);

$stmt_p = $producto->readAll();
$total_productos = $stmt_p->rowCount();

$stmt_c = $categoria->readAll();
$total_categorias = $stmt_c->rowCount();

$stmt_m = $marca->readAll();
$total_marcas = $stmt_m->rowCount();
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

        .brand-shadow-lg {
            box-shadow: 8px 8px 0px 0px #1b1b1b;
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
            class="hidden md:flex flex-col w-64 bg-surface border-r-4 border-on-background h-screen pt-4 pb-4 sticky top-20 z-40">
            <div class="px-6 mb-8">
                <h2 class="text-xl font-black text-on-background uppercase italic">Panel Admin</h2>
                <p class="text-xs font-bold text-primary uppercase tracking-widest">Gestión Dulce</p>
            </div>
            <nav class="flex flex-col gap-2 px-3">
                <a class="flex items-center gap-3 px-4 py-3 text-on-background border-2 border-on-background bg-secondary-container transition-all font-bold brand-shadow"
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
                <a class="flex items-center gap-3 px-4 py-3 text-on-background border-2 border-transparent hover:border-on-background hover:bg-secondary-container transition-all font-bold"
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
            <div class="max-w-5xl mx-auto">

                <header class="mb-10">
                    <h1 class="text-xs font-black text-on-background uppercase mb-1">Vista General</h1>
                    <p class="font-headline-md text-headline-md text-primary uppercase tracking-tighter italic">Métricas
                        de Hoy • Dulcería El Loco</p>
                </header>
                <!-- Bento Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                    <div class="bg-white border-4 border-on-background p-8 brand-shadow-lg relative overflow-hidden">
                        <div class="relative z-10">
                            <span class="font-black text-xs text-secondary uppercase">Total de Productos</span>
                            <div class="text-8xl font-black mt-2 text-on-background"><?php echo $total_productos; ?>
                            </div>
                        </div>
                        <span
                            class="material-symbols-outlined absolute -right-4 -bottom-4 text-[160px] text-on-background opacity-10 rotate-12">inventory_2</span>
                    </div>
                    <div
                        class="bg-secondary-fixed border-4 border-on-background p-8 brand-shadow-lg flex flex-col justify-between">
                        <div>
                            <span class="font-black text-xs text-on-background uppercase">Categorías</span>
                            <div class="text-8xl font-black mt-2 text-on-background"><?php echo $total_categorias; ?>
                            </div>
                        </div>
                        <p class="mt-4 font-black text-sm text-primary uppercase">Activas en Tienda</p>
                    </div>
                    <div
                        class="bg-primary-fixed border-4 border-on-background p-8 brand-shadow-lg flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <span class="font-black text-xs text-on-background uppercase">Marcas</span>
                            <div class="text-8xl font-black mt-2 text-on-background"><?php echo $total_marcas; ?></div>
                        </div>
                        <span
                            class="material-symbols-outlined absolute -right-4 -bottom-4 text-[160px] text-on-background opacity-10 rotate-12">sell</span>
                    </div>
                </div>
                <!-- Content Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <!-- Products Highlights -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="flex items-center justify-between">
                            <h2 class="font-black text-xl text-on-background uppercase italic">Destacados del Mes</h2>
                            <a href="gestion_productos.php"
                                class="font-black text-xs uppercase text-primary border-b-2 border-primary hover:text-primary-container">VER
                                TODOS</a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Product Card 1 -->
                            <div
                                class="bg-white border-4 border-on-background overflow-hidden brand-shadow group relative">
                                <div
                                    class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 font-black text-[10px] uppercase border-2 border-on-background z-10">
                                    Más Vendido</div>
                                <div
                                    class="h-64 bg-surface-variant border-b-4 border-on-background relative overflow-hidden">
                                    <img alt="Mazapán artesanal"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6uinuplrxhQav8gdJFub08Lc0l2hdZ9b9S7qNqFd6NAxDkfo5e4URZBnA4GDYai5c2wq_msZQbE5zJxBH9ShSMmAEQHxQ0IAFm4QhaqL8O4qkBbhaqGPG1agReCIKFFllTfwZ9vQ9ZhOEmFjBCHrGmy3ERMnGUMt6noTJHUhabDtk_mnRzVJGaWMBZRbkX8qkq6jXiN6i3NkqvMCK-s3OPNVZxq5b9MsFmoBXnufZ-sI7V_rg1gln1jgq1Zy6zob2AjaWeQF5qreY" />
                                </div>
                                <div class="p-6">
                                    <h3
                                        class="font-black text-2xl uppercase text-on-background leading-none mb-4 italic">
                                        Mazapán Artesanal</h3>
                                    <div class="flex gap-2">
                                        <span
                                            class="px-3 py-1 border-2 border-on-background bg-secondary-fixed text-[10px] font-black uppercase">Cacahuate</span>
                                        <span
                                            class="px-3 py-1 border-2 border-on-background bg-primary-fixed text-[10px] font-black uppercase">Clásico</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Card 2 -->
                            <div
                                class="bg-white border-4 border-on-background overflow-hidden brand-shadow group relative">
                                <div
                                    class="absolute top-4 left-4 bg-error text-on-error px-3 py-1 font-black text-[10px] uppercase border-2 border-on-background z-10">
                                    Temporada</div>
                                <div
                                    class="h-64 bg-surface-variant border-b-4 border-on-background relative overflow-hidden">
                                    <img alt="Calaveritas de azúcar"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBnE2BAemnst5WlKk0XtJ8x2aV08R7TWGal6ptPPjIS9Iu8Upo1QEssla26xQn631-RPm8iARd8Ot7JBmu3stR-Cy73KC5nULHyop-CGyuCBVQGmxZNafU8--sOXRyBP5BgkOTXRBan3nL3GJGlxWjnv8ly0TTSaaU5xgaBhkEOGGXVaodaD8uhRA6wj06kGdOGGlF5r8pReLLPV2aG3rSCmRQZoFgKdTItEj_OePqWDq_ePFOVzPZe5zsY7-jHyHDGn5ZyyLYy4Tyf" />
                                </div>
                                <div class="p-6">
                                    <h3
                                        class="font-black text-2xl uppercase text-on-background leading-none mb-4 italic">
                                        Calaveritas</h3>
                                    <div class="flex gap-2">
                                        <span
                                            class="px-3 py-1 border-2 border-on-background bg-secondary-fixed text-[10px] font-black uppercase">Tradicional</span>
                                        <span
                                            class="px-3 py-1 border-2 border-on-background bg-primary-fixed text-[10px] font-black uppercase">Colorido</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Alerts -->
                    <div class="space-y-6">
                        <div class="bg-white border-4 border-on-background p-8 brand-shadow">
                            <div class="border-b-4 border-on-background pb-6 mb-6">
                                <h2 class="font-black text-3xl text-on-background uppercase leading-none mb-2 italic">
                                    Alertas Stock</h2>
                                <p class="font-black text-xs text-error uppercase">Atención Inmediata</p>
                            </div>
                            <ul class="space-y-4">
                                <li
                                    class="flex items-center gap-4 p-4 border-2 border-on-background bg-error-container/50">
                                    <span class="material-symbols-outlined text-error text-3xl">warning</span>
                                    <div>
                                        <p class="font-black text-sm uppercase text-on-background">Tamarindos Picantes
                                        </p>
                                        <p class="text-[10px] uppercase font-bold text-on-surface-variant">Quedan 5
                                            unidades</p>
                                    </div>
                                </li>
                                <li
                                    class="flex items-center gap-4 p-4 border-2 border-on-background bg-surface-container">
                                    <span class="material-symbols-outlined text-secondary text-3xl">inventory_2</span>
                                    <div>
                                        <p class="font-black text-sm uppercase text-on-background">Pelón Pelo Rico</p>
                                        <p class="text-[10px] uppercase font-bold text-on-surface-variant">Quedan 12
                                            unidades</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-10 pt-10 border-t-4 border-on-background">
                                <h3 class="font-black text-xs uppercase mb-6 text-on-background italic">Promoción Activa
                                </h3>
                                <div
                                    class="relative group cursor-pointer border-4 border-on-background overflow-hidden brand-shadow">
                                    <img alt="Festival del Tamarindo"
                                        class="w-full h-44 object-cover transform group-hover:scale-110 transition-transform duration-500"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBi3DxHxxmPQeESuAseAq_KtklFOXRXuv_ZaLHL2LJunTz_Lg4JVGqIPt7obktr1FBggfBtZrbUs8_A0FZYTICSP3J4uGH6bd4aM2yPUJdn3bMGx8SiTHgussF8xaNNUelvNkhzJembX5ulEHZu81Zqm9N6cHfykBbbJmoZuvFn18jwYthiqQK_rHijd1EIaO2uZ0skJ2kQTXdCsoiDSzuiYbKnWvffMx0pQ3W1iHGKKrFJ2Ux8905UkX4f413_5yhPWxp_dsiDdJr2" />
                                    <div class="absolute inset-0 bg-primary/70 flex items-center justify-center p-4">
                                        <span
                                            class="text-on-primary font-black uppercase text-center text-sm leading-tight border-4 border-on-primary p-2">Festival
                                            del Tamarindo</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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