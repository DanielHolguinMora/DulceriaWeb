<?php 
require_once 'includes/db.php'; 
include 'includes/header.php'; 

$message_sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        // In a real app, send email or save to DB
        // For now, just simulate success
        $message_sent = true;
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
                            <i class="fa-solid fa-circle-check"></i> ¡Mensaje enviado con éxito! Nos pondremos en contacto pronto.
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
                            <textarea id="message" name="message" rows="5" placeholder="¿En qué podemos ayudarte?" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Enviar Mensaje</button>
                    </form>
                </div>

                <div class="contact-info-section">
                    <div class="contact-info-list">
                        <div class="info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <div>
                                <h4>Visítanos</h4>
                                <p>Av. Benito Juárez 123, Centro Histórico<br>Ciudad Juárez, Chihuahua.</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fa-solid fa-phone"></i>
                            <div>
                                <h4>Llámanos</h4>
                                <p>+52 (656) 123-4567</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fa-solid fa-envelope"></i>
                            <div>
                                <h4>Escríbenos</h4>
                                <p>hola@dulceriaelloco.com</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fa-solid fa-clock"></i>
                            <div>
                                <h4>Horario</h4>
                                <p>Lun - Sáb: 9:00 AM - 8:00 PM<br>Dom: 10:00 AM - 4:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 40px;">
                        <h4>Síguenos</h4>
                        <div class="social-links" style="margin-top: 15px;">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
