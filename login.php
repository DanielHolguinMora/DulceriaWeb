<?php

session_start();

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

require_once 'config/database.php';
require_once 'models/Usuario.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Usuario($db);

    $usuario->username = $_POST['username'] ?? '';
    $usuario->password = $_POST['password'] ?? '';

    if ($usuario->login()) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $usuario->id;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-lowest": "#ffffff",
                        "inverse-primary": "#ffb59b",
                        "on-secondary": "#ffffff",
                        "inverse-surface": "#313030",
                        "primary": "#885200",
                        "on-surface": "#1b1b1b",
                        "tertiary": "#5f5e5e",
                        "on-secondary-container": "#71604e",
                        "on-primary": "#ffffff",
                        "secondary-fixed-dim": "#d9c3ad",
                        "surface-dim": "#dcd9d9",
                        "surface-variant": "#e5e2e1",
                        "surface-tint": "#a93800",
                        "surface-container-highest": "#e5e2e1",
                        "surface-container": "#f0eded",
                        "primary-fixed-dim": "#ffb59b",
                        "on-secondary-fixed": "#25190b",
                        "tertiary-fixed": "#e4e2e1",
                        "on-primary-fixed": "#380d00",
                        "tertiary-container": "#959494",
                        "outline": "#8e7066",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed-dim": "#c8c6c6",
                        "on-tertiary-fixed-variant": "#474747",
                        "on-tertiary-container": "#2d2d2d",
                        "surface-container-low": "#f6f3f2",
                        "background": "#fcf9f8",
                        "inverse-on-surface": "#f3f0ef",
                        "surface-container-high": "#eae7e7",
                        "on-tertiary-fixed": "#1b1c1c",
                        "primary-container": "#E59120",
                        "secondary": "#6c5b4a",
                        "on-background": "#1b1b1b",
                        "secondary-fixed": "#f6dfc8",
                        "secondary-container": "#f3dcc5",
                        "on-primary-fixed-variant": "#812900",
                        "error-container": "#ffdad6",
                        "primary-fixed": "#ffdbcf",
                        "on-surface-variant": "#5a4138",
                        "on-error": "#ffffff",
                        "surface-bright": "#fcf9f8",
                        "on-primary-container": "#1C1A1B",
                        "on-secondary-fixed-variant": "#534433",
                        "surface": "#fcf9f8",
                        "error": "#ba1a1a",
                        "outline-variant": "#e3bfb3",
                        "on-error-container": "#93000a"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "xl": "80px",
                        "margin": "32px",
                        "md": "24px",
                        "lg": "48px",
                        "sm": "16px",
                        "xs": "8px",
                        "unit": "4px"
                    },
                    "fontFamily": {
                        "headline-xl": ["Lexend"],
                        "label-bold": ["Lexend"],
                        "headline-lg": ["Lexend"],
                        "body-lg": ["Lexend"],
                        "body-md": ["Lexend"],
                        "label-sm": ["Lexend"],
                        "headline-md": ["Lexend"]
                    },
                    "fontSize": {
                        "headline-xl": ["80px", { "lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "900" }],
                        "label-bold": ["14px", { "lineHeight": "1.2", "fontWeight": "700" }],
                        "headline-lg": ["48px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "800" }],
                        "body-lg": ["20px", { "lineHeight": "1.6", "fontWeight": "500" }],
                        "body-md": ["16px", { "lineHeight": "1.5", "fontWeight": "400" }],
                        "label-sm": ["12px", { "lineHeight": "1.2", "fontWeight": "600" }],
                        "headline-md": ["32px", { "lineHeight": "1.2", "fontWeight": "700" }]
                    }
                }
            }
        }</script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .clean-shadow {
            box-shadow: 6px 6px 0px 0px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-surface font-body-md text-on-background min-h-screen flex flex-col">
    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center p-sm md:p-lg relative overflow-hidden">
        <!-- Subtle Decorative Background Elements -->
        <div
            class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-secondary-fixed/20 rounded-full blur-3xl -z-10">
        </div>
        <div
            class="absolute bottom-[-10%] right-[-10%] w-[30rem] h-[30rem] bg-primary-container/10 rounded-full blur-3xl -z-10">
        </div>
        <!-- Login Card -->
        <section
            class="bg-surface-container-lowest border border-outline-variant w-full max-w-md p-lg rounded-xl clean-shadow relative z-10">
            <!-- Central Main Logo Area -->
            <div class="flex flex-col items-center mb-lg">
                <div class="w-full max-w-[240px] mb-md flex justify-center">
                    <!-- Main Store Logo: Imagotipo Principal -->
                    <img alt="Dulcería El Loco Logo" class="w-full h-auto"
                        data-alt="A clean version of the main logo for Dulcería El Loco, featuring the energetic yellow character mascot next to the bold, stylized 'EL LOCO!' text. The logo is centered and prominent."
                        src="uploads/LogoElLoco.jpg" />
                </div>
                <h1
                    class="font-label-bold text-on-surface-variant uppercase tracking-widest text-center border-b-2 border-primary-container pb-1">
                    Panel de Administración
                </h1>
            </div>

            <?php if ($error): ?>
                <div class="bg-error text-white p-3 rounded mb-4 font-bold text-center">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form class="space-y-md" method="POST" action="login.php">
                <div class="space-y-xs">
                    <label class="font-label-bold text-on-surface-variant text-xs uppercase"
                        for="username">Usuario</label>
                    <div class="relative">
                        <input
                            class="w-full bg-surface-container-low border border-outline-variant p-sm font-body-md rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-container focus:border-transparent transition-all placeholder:text-on-surface-variant/40"
                            id="username" name="username" placeholder="Introduce tu usuario" type="text" required />
                        <span
                            class="material-symbols-outlined absolute right-sm top-1/2 -translate-y-1/2 text-on-surface-variant/60">person</span>
                    </div>
                </div>
                <div class="space-y-xs">
                    <label class="font-label-bold text-on-surface-variant text-xs uppercase"
                        for="password">Contraseña</label>
                    <div class="relative">
                        <input
                            class="w-full bg-surface-container-low border border-outline-variant p-sm font-body-md rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-container focus:border-transparent transition-all placeholder:text-on-surface-variant/40"
                            id="password" name="password" placeholder="••••••••" type="password" required />
                        <span
                            class="material-symbols-outlined absolute right-sm top-1/2 -translate-y-1/2 text-on-surface-variant/60">lock</span>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-xs">
                    <label class="flex items-center gap-xs cursor-pointer group">
                        <input
                            class="w-5 h-5 border border-outline-variant text-primary rounded focus:ring-primary-container focus:ring-offset-0"
                            type="checkbox" />
                        <span
                            class="font-body-md text-sm text-on-surface-variant group-hover:text-on-surface transition-colors">Recordarme</span>
                    </label>
                    <a class="font-label-bold text-sm text-primary hover:underline transition-colors"
                        href="#">¿Olvidaste tu clave?</a>
                </div>
                <!-- Action Button -->
                <button
                    class="w-full bg-primary-container hover:bg-primary text-on-primary-container hover:text-on-primary font-headline-md py-sm px-md rounded-lg shadow-md hover:shadow-lg transition-all uppercase mt-md text-[#1C1A1B]"
                    type="submit">
                    ENTRAR AL SISTEMA
                </button>
            </form>
            <div class="mt-lg pt-md border-t border-outline-variant/30 text-center">
                <p class="font-body-md text-on-surface-variant/70 text-sm italic">"La gestión nunca fue tan dulce."</p>
            </div>
        </section>
    </main>
    <!-- Professional Footer -->
    <footer
        class="w-full py-8 px-10 flex flex-col md:flex-row justify-between items-center bg-white border-t border-outline-variant">
        <div class="flex items-center gap-2 mb-4 md:mb-0">
            <span class="font-black text-primary text-xl uppercase tracking-tighter">Dulcería El Loco</span>
            <div class="h-4 w-[1px] bg-outline-variant hidden md:block mx-2"></div>
            <span class="font-label-sm text-on-surface-variant/60 uppercase tracking-widest">Portal
                Administrativo</span>
        </div>
        <div class="flex flex-col md:flex-row items-center gap-md">
            <p class="font-label-sm text-on-surface-variant/60">
                © 2024 Dulcería El Loco
            </p>
            <div class="flex gap-sm">
                <a class="font-label-sm text-on-surface-variant hover:text-primary transition-colors"
                    href="#">Soporte</a>
                <a class="font-label-sm text-on-surface-variant hover:text-primary transition-colors"
                    href="#">Privacidad</a>
            </div>
        </div>
    </footer>
</body>

</html>