<footer class="main-footer">
    <div class="container footer-grid">
        <div class="footer-info">
            <h3 class="footer-logo">DULCERÍA <span class="accent">EL LOCO!</span></h3>
            <!-- <img src="assets/img/9.png" alt="Dulcería El Loco Logo" class="footer-logo-img"> -->
            <p>Tu rincón dulce en el corazón de Ciudad Juárez. Ofrecemos la mejor selección de dulces nacionales,
                importados y botanas para todos los gustos.</p>
            <div class="social-links">
                <a href="https://www.facebook.com/profile.php?id=61589713318775" target="_blank"><i
                        class="fa-brands fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/dulceriaelloco/" target="_blank"><i
                        class="fa-brands fa-instagram"></i></a>
                <a href="https://wa.me/526561968945?text=<?php echo urlencode('Hola! Me gustaría obtener más información sobre sus productos.'); ?>" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
        </div>

        <div class="footer-nav">
            <h4>Navegación</h4>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="favoritos.php">Favoritos</a></li>
                <li><a href="nosotros.php">Nosotros</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </div>

        <div class="footer-contact">
            <h4>Contacto</h4>
            <p><i class="fa-solid fa-location-dot"></i> Ignacio Mariscal #338<br>Barrio Alto, 32160<br>Ciudad Juárez, Chih.
            </p>
            <p><i class="fa-solid fa-phone"></i> +52 (656) 612-3560</p>
            <p><i class="fa-solid fa-envelope"></i> dulcerias.elloco@gmail.com</p>
        </div>
    </div>

    <div class="footer-bottom container">
        <div class="footer-copy">
            <p>&copy; <?php echo date('Y'); ?> Dulcería El Loco! Todos los derechos reservados.</p>            
            <p>Diseñado & programado con <i class="fa-solid fa-heart text-accent"></i> en <a href="https://portafoliol.netlify.app" style="text-decoration: underline;">Ciudad Juárez</a></p>
        </div>
        <div class="footer-admin-link">
            <a href="login.php" class="admin-access-btn"><i class="fa-solid fa-user-lock"></i> Acceso Admin</a>
        </div>
    </div>
</footer>

<!-- Boton de WhatsApp -->
<a href="https://wa.me/526561968945?text=<?php echo urlencode('Hola! Me gustaría obtener más información sobre sus productos.'); ?>" 
   class="floating-whatsapp" id="floating-whatsapp" target="_blank" aria-label="Contáctanos por WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
</a>

<!-- Scripts -->
<script src="assets/js/script.js?v=<?php echo time(); ?>"></script>
</body>

</html>