<?php
require_once 'includes/db.php';
include 'includes/header.php';

$message_sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación para mandar correo desde la pagina web 
    // Sanitizar entradas eliminando saltos de línea para prevenir inyección de cabeceras
    $name = str_replace(["\r", "\n"], '', $_POST['name'] ?? '');
    $email = str_replace(["\r", "\n"], '', $_POST['email'] ?? '');
    $message = $_POST['message'] ?? '';

    if (!empty($name) && !empty($email) && !empty($message)) {
        $to = "dulcerias.elloco@gmail.com";
        $subject = "Nuevo mensaje de contacto de: $name";
        
        $body = "Has recibido un nuevo mensaje desde el formulario de contacto de la página web.\n\n";
        $body .= "Nombre: $name\n";
        $body .= "Correo: $email\n\n";
        $body .= "Mensaje:\n$message\n";
        
        // Obtener el host actual y limpiar caracteres extraños
        $host = preg_replace('/[^a-zA-Z0-9.-]/', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
        if (empty($host) || $host === 'localhost') {
            $host = 'dulceriaelloco.com';
        }
        
        $headers = "From: Dulcería El Loco <no-reply@$host>\r\n";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Correo inválido');
        }
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        
        // Enviar el correo usando la función nativa mail() de PHP
        if (mail($to, $subject, $body, $headers)) {
            $message_sent = true;
        } else {
            $message_sent = false;
        }
    }
}
?>


<main class="contact-page">
    <section class="catalog-hero">
        <div class="container text-center">
            <h1>Contacto</h1>
            <p>¿Tienes alguna duda o pedido especial? Escríbenos.</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-form-card">
                    <?php if ($message_sent): ?>
                        <div class="success-message">
                            <i class="fa-solid fa-circle-check"></i> ¡Mensaje enviado con éxito! Nos pondremos en contacto
                            pronto.
                        </div>
                    <?php endif; ?>

                    <form action="contacto.php" method="POST">
                        <div class="form-group">
                            <label for="name">Nombre Completo</label>
                            <input type="text" id="name" name="name" placeholder="Ej. Juan Pérez" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" placeholder="juan@ejemplo.com" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Mensaje</label>
                            <textarea id="message" name="message" rows="5" placeholder="¿En qué podemos ayudarte?"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Enviar Mensaje</button>
                    </form>
                </div>

                <div class="contact-info-section">
                    <div class="contact-info-list">
                        <div class="info-item">
                            <a href="#mapa" class="info-icon-link"><i class="fa-solid fa-location-dot"></i></a>
                            <div>
                                <h4>Visítanos</h4>
                                <p><a href="#mapa" class="info-text-link">Ignacio Mariscal #338, Barrio Alto, 32160<br>Ciudad Juárez, Chihuahua.</a>
                                </p>
                            </div>
                        </div>
                        <div class="info-item">
                            <a href="tel:+526566123560" class="info-icon-link"><i class="fa-solid fa-phone"></i></a>
                            <div>
                                <h4>Llámanos</h4>
                                <p>
                                    <a href="tel:+526566123560" class="info-text-link">+52 656 612 3560</a><br>
                                </p>
                            </div>
                        </div>
                        <div class="info-item">
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=dulcerias.elloco@gmail.com"
                                target="_blank" class="info-icon-link"><i class="fa-solid fa-envelope"></i></a>
                            <div>
                                <h4>Escríbenos</h4>
                                <p><a href="https://mail.google.com/mail/?view=cm&fs=1&to=dulcerias.elloco@gmail.com"
                                        target="_blank" class="info-text-link">dulcerias.elloco@gmail.com</a></p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fa-solid fa-clock"></i>
                            <div>
                                <h4>Horario</h4>
                                <p>Lun - Sáb: 7:00 AM - 5:30 PM<br>Dom: 08:00 AM - 3:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 40px;">
                        <h4>Síguenos</h4>
                        <div class="social-links" style="margin-top: 15px;">
                            <a href="https://www.facebook.com/profile.php?id=61589713318775"><i
                                    class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/dulceriaelloco/"><i
                                    class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="contact-map-section" id="mapa">
            <div class="container">
                <div class="map-container-wrapper">
                    <div class="map-header">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <h3>Nuestra Ubicación</h3>
                    <p>Encuéntranos en el corazón de Ciudad Juárez</p>
                </div>
                    <div class="map-frame">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3393.210803072876!2d-106.49065928828318!3d31.737446536276135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86e75f2c5761719f%3A0x4a25bec6b902430a!2sDulcer%C3%ADa%20El%20Remolino!5e0!3m2!1ses-419!2smx!4v1778641478592!5m2!1ses-419!2smx"
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </section>
</main>

<?php include 'includes/footer.php'; ?>