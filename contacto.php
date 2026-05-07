<?php

require_once 'config/database.php';

require_once 'views/layout/header.php';
?>

<main class="max-w-7xl mx-auto px-margin py-xl">
    <!-- Hero Section / Title -->
    <div class="mb-xl text-center md:text-left">
        <h2
            class="font-h1 text-h1 uppercase italic mb-sm text-[#1C1A1B] underline decoration-[#E59120] decoration-8 underline-offset-4">
            ¡HÁBLANOS, LOCO!</h2>
        <p class="font-body-lg text-body-lg max-w-2xl text-[#1C1A1B] font-bold">Ya sea que estés buscando ese dulce
            específico de tu infancia o planeando una fiesta masiva, estamos aquí para alimentar tu antojo de azúcar.
        </p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-xl">
        <!-- Left Column: Contact Form & Socials -->
        <div class="lg:col-span-7 space-y-lg">
            <!-- Contact Form Card -->
            <div class="bg-white border-4 border-[#1C1A1B] p-lg flat-bold-borders">
                <h3 class="font-h3 text-h3 uppercase mb-md flex items-center gap-xs"><span
                        class="material-symbols-outlined text-[#bb0119]"
                        style="font-variation-settings: 'FILL' 1;">mail</span> Enviar un Mensaje</h3>
                <form class="space-y-md">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <div class="space-y-xs">
                            <label class="font-label-bold text-label-bold uppercase">Nombre Completo</label>
                            <input
                                class="w-full border-2 border-[#1C1A1B] p-sm font-body-md focus:ring-0 focus:border-[#E59120] bg-[#fef8f9]"
                                placeholder="Your Name" type="text" />
                        </div>
                        <div class="space-y-xs">
                            <label class="font-label-bold text-label-bold uppercase">Correo Electrónico</label>
                            <input
                                class="w-full border-2 border-[#1C1A1B] p-sm font-body-md focus:ring-0 focus:border-[#E59120] bg-[#fef8f9]"
                                placeholder="email@example.com" type="email" />
                        </div>
                    </div>
                    <div class="space-y-xs">
                        <label class="font-label-bold text-label-bold uppercase">Tu Mensaje Dulce</label>
                        <textarea
                            class="w-full border-2 border-[#1C1A1B] p-sm font-body-md focus:ring-0 focus:border-[#E59120] bg-[#fef8f9]"
                            placeholder="Cuéntanos lo que necesitas..." rows="4"></textarea>
                    </div>
                    <button
                        class="w-full md:w-auto px-xl py-md bg-[#E59120] text-[#1C1A1B] font-black uppercase tracking-widest border-4 border-[#1C1A1B] flat-bold-borders active-button-shift transition-all hover:bg-white"
                        type="button">ENVIAR AL LABORATORIO</button>
                </form>
            </div>
            <!-- Social Media Block -->
            <div
                class="bg-[#e0292e] p-md border-4 border-[#1C1A1B] flat-bold-borders flex flex-wrap justify-between items-center gap-md">
                <span class="font-h3 text-white uppercase italic">SÍGUENOS:</span>
                <div class="flex gap-sm">
                    <a class="w-12 h-12 bg-white border-2 border-[#1C1A1B] flex items-center justify-center flat-bold-borders-small hover:bg-[#EFBD79] transition-colors"
                        href="#">
                        <span class="material-symbols-outlined text-[#1C1A1B]"
                            data-icon="facebook">social_leaderboard</span>
                    </a>
                    <a class="w-12 h-12 bg-white border-2 border-[#1C1A1B] flex items-center justify-center flat-bold-borders-small hover:bg-[#EFBD79] transition-colors"
                        href="#">
                        <span class="material-symbols-outlined text-[#1C1A1B]"
                            data-icon="photo_camera">photo_camera</span>
                    </a>
                    <a class="w-12 h-12 bg-white border-2 border-[#1C1A1B] flex items-center justify-center flat-bold-borders-small hover:bg-[#EFBD79] transition-colors"
                        href="#">
                        <span class="material-symbols-outlined text-[#1C1A1B]"
                            data-icon="potted_plant">potted_plant</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Right Column: Info & Map -->
        <div class="lg:col-span-5 space-y-lg">
            <!-- Info Section -->
            <div class="space-y-md">
                <div class="bg-[#EFBD79] border-4 border-[#1C1A1B] p-md flat-bold-borders flex gap-md items-start">
                    <div class="bg-white p-2 border-2 border-[#1C1A1B]">
                        <span class="material-symbols-outlined text-[#bb0119]"
                            style="font-variation-settings: 'FILL' 1;">phone_in_talk</span>
                    </div>
                    <div>
                        <p class="font-label-bold uppercase text-xs">Llama a la Línea Directa del Dulce</p>
                        <p class="font-h3 text-[#1C1A1B]">+52 (55) 1234-5678</p>
                    </div>
                </div>
                <div class="bg-white border-4 border-[#1C1A1B] p-md flat-bold-borders flex gap-md items-start">
                    <div class="bg-[#e59120] p-2 border-2 border-[#1C1A1B]">
                        <span class="material-symbols-outlined text-white"
                            style="font-variation-settings: 'FILL' 1;">location_on</span>
                    </div>
                    <div>
                        <p class="font-label-bold uppercase text-xs">Visita la Locura</p>
                        <p class="font-body-lg font-black text-[#1C1A1B]">Calle Dulzura #123, Centro Histórico</p>
                        <p class="font-caption text-[#534435] uppercase font-bold">ABIERTO TODOS LOS DÍAS: 9:00 AM -
                            9:00 PM</p>
                    </div>
                </div>
            </div>
            <!-- Map Section -->
            <div class="relative group mt-8">
                <div class="absolute -inset-1 bg-[#1C1A1B] border-2 border-[#1C1A1B]"></div>
                <div class="relative h-[350px] border-4 border-[#1C1A1B] bg-surface overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d212.07559945366404!2d-106.48822372226552!3d31.73747961866284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86e75f2c5761719f%3A0x4a25bec6b902430a!2sDulcer%C3%ADa%20El%20Remolino!5e0!3m2!1ses-419!2smx!4v1777683375283!5m2!1ses-419!2smx"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <!-- Decorative Brand Strip -->
            <div
                class="h-8 bg-[#E59120] border-4 border-[#1C1A1B] flex items-center overflow-hidden whitespace-nowrap mt-8">
                <div class="flex animate-marquee space-x-8">
                    <span class="font-black text-xs uppercase italic text-white">SPICY SWEET SPICY SWEET SPICY SWEET
                        SPICY SWEET SPICY SWEET</span>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once 'views/layout/footer.php';
?>
=======
=======
>>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$mensaje = trim($_POST['mensaje']);

$errores = [];
if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
if (empty($email)) $errores[] = "El email es obligatorio.";
if (empty($mensaje)) $errores[] = "El mensaje es obligatorio.";

if (empty($errores)) {
$stmt = $conn->prepare("INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $email, $mensaje);
if ($stmt->execute()) {
$exito = "Mensaje enviado correctamente. ¡Gracias por contactarnos!";
} else {
$errores[] = "Error al guardar el mensaje.";
}
}
}
?>
<h2>Contacto</h2>
<?php if (isset($exito)): ?>
    <div class="alert alert-success"><?php echo $exito; ?></div>
<?php endif; ?>
<?php if (!empty($errores)): ?>
    <div class="alert alert-error">
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="contacto.php">
    <label>Nombre:</label>
    <input type="text" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">

    <label>Email:</label>
    <input type="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">

    <label>Mensaje:</label>
    <textarea name="mensaje" rows="5" required><?php echo htmlspecialchars($_POST['mensaje'] ?? ''); ?></textarea>

    <button type="submit">Enviar mensaje</button>
</form>

<p>También puedes visitarnos en: Av. Dulce 123, Ciudad, o llamarnos al (123) 456-7890.</p>

<<<<<<< HEAD <?php require_once 'includes/footer.php'; ?>
    >>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f
    =======
    <?php require_once 'includes/footer.php'; ?>
    >>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f