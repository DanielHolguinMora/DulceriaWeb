<?php
require_once 'includes/db.php';
include 'includes/header.php';

$featured_products = [];
if ($pdo) {
    try {

        $stmt = $pdo->query("SELECT p.*, c.nombre as categoria_nombre FROM productos p JOIN categoria c ON p.categoria_id = c.id ORDER BY p.likes DESC LIMIT 4");
        $featured_products = $stmt->fetchAll();
    } catch (Exception $e) {
        $featured_products = [];
    }
}
?>

<main>
    <!-- Sección Hero -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <h1>Visítanos en <br><span class="text-accent">Dulcería El Loco!</span></h1>
                <p>Descubre la selección más amplia de dulces, desechables, artículos para fiesta y materias primas en el corazón de Ciudad Juárez. <br>
                    ¡Los mejores productos a los mejores precios! </p>
                <div class="hero-btns">
                    <a href="catalogo.php" class="btn btn-primary">Ver Catálogo</a>
                    <a href="#featured" class="btn btn-secondary">Nuestros Favoritos</a>
                </div>
            </div>
            <div class="hero-collage">
                <div class="collage-container">
                    <div class="collage-card card-main">
                        <img src="assets/img/hero5.jpg" alt="Deliciosos Dulces en Dulcería El Loco">
                    </div>
                    <div class="collage-card card-overlay">
                        <img src="assets/img/7.jpg" alt="Dulces Mexicanos e Importados">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carrusel de Marcas -->
    <section class="brands-marquee">
        <div class="container">
            <div class="section-header text-center" style="margin-bottom: 30px;">
                <h2>Nuestras Marcas</h2>
                <p>La selección más completa con la calidad y sabor que nos distingue</p>
            </div>
        </div>
        <div class="marquee-wrapper">
            <div class="marquee-content">
                <?php
                $brand_logos = glob('assets/img/Marcas el Loco/*.{png,jpg,jpeg,webp}', GLOB_BRACE);
                for ($i = 0; $i < 2; $i++) {
                    foreach ($brand_logos as $logo) {
                        $brand_name = pathinfo($logo, PATHINFO_FILENAME);
                        $brand_name = ucwords(str_replace(['_', '-'], ' ', $brand_name));
                        echo "<div class='brand-logo-item' title='{$brand_name}'>
                                <img src='{$logo}' alt='{$brand_name} Logo' loading='lazy'>
                              </div>";
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Favoritos de la Comunidad -->
    <section class="featured section-padding" id="featured">
        <div class="container">
            <div class="section-header text-center">
                <h2>Favoritos de la Comunidad</h2>
                <p>Los productos con más likes y más queridos por nuestros clientes reales en Ciudad Juárez.</p>
            </div>
            
            <!-- Skeleton Loader (visible durante la carga) -->
            <div class="product-grid skeleton-grid" id="skeleton-grid">
                <?php for($i=0; $i<4; $i++): ?>
                <div class="skeleton-card">
                    <div class="skeleton-img"></div>
                    <div class="skeleton-line"></div>
                    <div class="skeleton-line short"></div>
                </div>
                <?php endfor; ?>
            </div>

            <!-- Grid real (oculto hasta que cargue) -->
            <div class="product-grid" id="featured-grid" style="display:none;">
                <?php
                require_once 'includes/product-card.php';
                foreach ($featured_products as $product) {
                    renderProductCard($product);
                }
                ?>
            </div>

            <div class="text-center" style="margin-top: 50px;">
                <a href="catalogo.php" class="btn btn-secondary">Explorar todo el catálogo</a>
            </div>
        </div>
    </section>

    <!-- Reseñas de Google Maps -->
    <section class="reviews-section section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2>Opiniones de la Comunidad</h2>
                <p>Nuestros clientes nos recomiendan. Reseñas reales de Google Maps sobre nuestro local.</p>
            </div>
        </div>

        <!-- Carrusel 1 - izquierda -->
        <div class="reviews-carousel-wrapper">
            <div class="reviews-track reviews-track--left">
                <!-- Set de tarjetas (duplicado para loop infinito) -->
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">AT</div>
                        <div class="review-user-info">
                            <h4>Alberto Turrado</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Excelente servicio y calidad en los productos. Siempre encuentro lo que busco y a buen precio."</p>
                    <div class="review-date">Hace 2 meses</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">MLJ</div>
                        <div class="review-user-info">
                            <h4>Martha Leticia Jacobo</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Encuentras cosas muy ricas y mucho dulce típico. Me encanta la variedad que tienen."</p>
                    <div class="review-date">Hace 5 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">RPS</div>
                        <div class="review-user-info">
                            <h4>Ricardo Prieto Sandoval</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Muy buena atencion y surtido."</p>
                    <div class="review-date">Hace 6 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">ESJ</div>
                        <div class="review-user-info">
                            <h4>Elizabeth San Juan</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Porque hay mucha variedad de dulces, frituras, todo para sus fiestas"</p>
                    <div class="review-date">Hace 6 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">JLP</div>
                        <div class="review-user-info">
                            <h4>Jore Luis Prado</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Se encuentra de todo y a buen precio."</p>
                    <div class="review-date">Hace 3 años</div>
                </div>
                <!-- Duplicado para loop infinito -->
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">AT</div>
                        <div class="review-user-info">
                            <h4>Alberto Turrado</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Excelente servicio y calidad en los productos. Siempre encuentro lo que busco y a buen precio."</p>
                    <div class="review-date">Hace 2 meses</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">MLJ</div>
                        <div class="review-user-info">
                            <h4>Martha Leticia Jacobo</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Encuentras cosas muy ricas y mucho dulce típico. Me encanta la variedad que tienen."</p>
                    <div class="review-date">Hace 5 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">RPS</div>
                        <div class="review-user-info">
                            <h4>Ricardo Prieto Sandoval</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Muy buena atencion y surtido."</p>
                    <div class="review-date">Hace 6 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">ESJ</div>
                        <div class="review-user-info">
                            <h4>Elizabeth San Juan</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Porque hay mucha variedad de dulces, frituras, todo para sus fiestas"</p>
                    <div class="review-date">Hace 6 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">JLP</div>
                        <div class="review-user-info">
                            <h4>Jorge Luis Prado</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Se encuentra de todo y a buen precio."</p>
                    <div class="review-date">Hace 3 años</div>
                </div>
        </div>


        <!-- Carrusel 2 – derecha -->
        <div class="reviews-carousel-wrapper">
            <div class="reviews-track reviews-track--right">
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">LM</div>
                        <div class="review-user-info">
                            <h4>Lourdes Meza</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"¡Me encantó! Visiten ese lugar, está buenísimo."</p>
                    <div class="review-date">Hace 6 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">SC</div>
                        <div class="review-user-info">
                            <h4>Sergio Campos</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Todo bien y buena atención."</p>
                    <div class="review-date">Hace 4 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">AC</div>
                        <div class="review-user-info">
                            <h4>Artemio Cruz</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Ricos dulces. ¡Muy recomendado!"</p>
                    <div class="review-date">Hace 5 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">JM</div>
                        <div class="review-user-info">
                            <h4>Juan Morales</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Buen lugar para comprar dulces."</p>
                    <div class="review-date">Hace 6 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">AF</div>
                        <div class="review-user-info">
                            <h4>Ana Flores</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Los dulces típicos mexicanos son increíbles. Me recuerdan a mi infancia. Muy buen servicio."</p>
                    <div class="review-date">Hace 9 meses</div>
                </div>
                <!-- Duplicado para loop infinito -->
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">LM</div>
                        <div class="review-user-info">
                            <h4>Lourdes Meza</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"¡Me encantó! Visiten ese lugar, está buenísimo."</p>
                    <div class="review-date">Hace 6 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">SC</div>
                        <div class="review-user-info">
                            <h4>Sergio Campos</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Todo bien y buena atención."</p>
                    <div class="review-date">Hace 4 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">AC</div>
                        <div class="review-user-info">
                            <h4>Artemio Cruz</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Ricos dulces. ¡Muy recomendado!"</p>
                    <div class="review-date">Hace 5 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">JM</div>
                        <div class="review-user-info">
                            <h4>Juan Morales</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Buen lugar para comprar dulces."</p>
                    <div class="review-date">Hace 6 años</div>
                </div>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">AF</div>
                        <div class="review-user-info">
                            <h4>Ana Flores</h4>
                            <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <i class="fa-brands fa-google review-badge"></i>
                    </div>
                    <p class="review-text">"Los dulces típicos mexicanos son increíbles. Me recuerdan a mi infancia. Muy buen servicio."</p>
                    <div class="review-date">Hace 9 meses</div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="reviews-cta">
                <a href="https://www.google.com/maps/place/Dulcer%C3%ADa+El+Remolino/@31.7374465,-106.4906593,17z/data=!4m8!3m7!1s0x86e75f2c5761719f:0x4a25bec6b902430a!8m2!3d31.737442!4d-106.488079!9m1!1b1!16s%2Fg%2F1tcw8mkh?entry=ttu&g_ep=EgoyMDI2MDUxMy4wIKXMDSoASAFQAw%3D%3D" 
                   target="_blank" 
                   class="btn btn-google">
                    <i class="fa-brands fa-google"></i> Ver Comentarios en Google Maps
                </a>
            </div>
        </div>
    </section>

    <!-- Sobre Nosotros -->
    <section class="about section-padding">
        <div class="container about-grid">
            <div class="about-image">
                <img src="assets/img/historia.jpg" alt="Sobre nosotros">
            </div>
            <div class="about-content">
                <h2>Nuestra Historia de Sabor y Tradición</h2>
                <p>Nacidos en el corazón de Ciudad Juárez, en <strong>Dulcería El Loco</strong> llevamos más de una década siendo los cómplices de tus momentos más dulces. Lo que comenzó como un sueño familiar se ha convertido en el punto de encuentro obligado para los amantes de las golosinas tradicionales y los snacks más exóticos del mundo.</p>
                <p>Creemos que cada dulce evoca un recuerdo feliz. Por eso, seleccionamos con pasión y cuidado cada producto de nuestro catálogo para garantizar la máxima frescura y la variedad que mereces. Desde el clásico mazapán que se deshace en tu boca hasta las golosinas importadas más exclusivas y picositas.</p>
                
                <!-- Medallas de Métricas -->
                <div class="about-stats">
                    <div class="stat-item">
                        <span class="stat-number">+30</span>
                        <span class="stat-label">Años de Sabor</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">+3000</span>
                        <span class="stat-label">Productos</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Familiar</span>
                    </div>
                </div>

                <a href="nosotros.php" class="btn btn-primary btn-pulse" style="margin-top: 10px;">
                    <i class="fa-solid fa-heart" style="margin-right: 8px;"></i> Descubre Más de Nosotros
                </a>
            </div>
        </div>
    </section>

    <!-- Sección Redes Sociales -->
    <section class="social-section section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2>Síguenos en Redes Sociales</h2>
                <p>Únete a nuestra comunidad en línea y entérate de todas nuestras promociones y nuevos productos.</p>
            </div>

            <div class="social-grid">
                <!-- Tarjeta Facebook -->
                <div class="social-card facebook-card">
                    <div class="social-card-header">
                        <div class="social-icon-wrapper">
                            <i class="fa-brands fa-facebook-f"></i>
                        </div>
                        <div class="social-profile-info">
                            <h3>Dulcería El Loco</h3>
                            <span>@dulceria.elloco.juárez •</span>
                        </div>
                    </div>
                    <div class="social-card-body">
                        <div class="fb-post-mockup">
                            <div class="fb-post-user">
                                <div class="fb-post-avatar">DL</div>
                                <div>
                                    <div class="fb-post-name">Dulcería El Loco</div>
                                    <div class="fb-post-date">Ayer a las 14:30 • <i class="fa-solid fa-earth-americas"></i></div>
                                </div>
                            </div>
                            <p class="fb-post-content">¡Ya llegaron los dulces importados de esta semana! 🍭 Ven por tus favoritos antes de que se agoten. Te esperamos en Ignacio Mariscal #338, Barrio Alto. ¡Sabor garantizado! 👇</p>
                            <img class="fb-post-image" src="https://images.unsplash.com/photo-1581798459219-318e76aecc7b?auto=format&fit=crop&q=80&w=600" alt="Publicación de Facebook">
                            <div class="fb-post-stats">
                                <span><i class="fa-solid fa-thumbs-up text-accent"></i> <i class="fa-solid fa-heart" style="color:#e84118;"></i> 245 personas</span>
                                <span>18 veces compartido</span>
                            </div>
                        </div>
                    </div>
                    <div class="social-card-footer">
                        <a href="https://www.facebook.com/profile.php?id=61589713318775" target="_blank" class="social-btn fb-btn">
                            <i class="fa-brands fa-facebook"></i> Visitar Facebook
                        </a>
                    </div>
                </div>

                <!-- Tarjeta Instagram -->
                <div class="social-card instagram-card">
                    <div class="social-card-header">
                        <div class="social-icon-wrapper">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                        <div class="social-profile-info">
                            <h3>@dulcerias.elloco</h3>
                            <span>Dulcería El Loco • </span>
                        </div>
                    </div>
                    <div class="social-card-body">
                        <div class="ig-grid-mockup">
                            <div class="ig-grid-item">
                                <img src="assets/img/historia.jpg" alt="Gomitas">
                                <div class="ig-overlay">
                                    <i class="fa-solid fa-heart"></i> 412
                                </div>
                            </div>
                            <div class="ig-grid-item">
                                <img src="https://images.unsplash.com/photo-1499195333224-3ce974eecb47?auto=format&fit=crop&q=80&w=400" alt="Chocolates">
                                <div class="ig-overlay">
                                    <i class="fa-solid fa-heart"></i> 325
                                </div>
                            </div>
                            <div class="ig-grid-item">
                                <img src="assets/img/1.jpg" alt="Bebidas preparadas">
                                <div class="ig-overlay">
                                    <i class="fa-solid fa-heart"></i> 589
                                </div>
                            </div>
                            <div class="ig-grid-item">
                                <img src="assets/img/2.jpg" alt="Paletas de chile">
                                <div class="ig-overlay">
                                    <i class="fa-solid fa-heart"></i> 274
                                </div>
                            </div>
                            <div class="ig-grid-item">
                                <img src="assets/img/3.jpg" alt="Dulces típicos">
                                <div class="ig-overlay">
                                    <i class="fa-solid fa-heart"></i> 390
                                </div>
                            </div>
                            <div class="ig-grid-item">
                                <img src="https://images.unsplash.com/photo-1581798459219-318e76aecc7b?auto=format&fit=crop&q=80&w=400" alt="Interior Tienda">
                                <div class="ig-overlay">
                                    <i class="fa-solid fa-heart"></i> 612
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="social-card-footer">
                        <a href="https://www.instagram.com/dulceriaelloco/" target="_blank" class="social-btn ig-btn">
                            <i class="fa-brands fa-instagram"></i> Seguir en Instagram
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>