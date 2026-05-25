<?php 
require_once 'includes/db.php'; 
include 'includes/header.php'; 
?>

<main class="about-page">
    <section class="catalog-hero">
        <div class="container text-center">
            <h1>Nuestra Historia</h1>
            <p>Conoce más sobre la dulcería más querida de Ciudad Juárez.</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <h2>Dulcería <span class="logo-text-accent">El Loco!</span></h2>
                    <p>Fundada en el corazón de Ciudad Juárez, nuestra dulcería nació con un propósito simple: traer alegría a través de los sabores más tradicionales y emocionantes.</p>
                    <p>Lo que comenzó como un pequeño puesto familiar se ha convertido en el destino favorito para quienes buscan desde el clásico mazapán hasta las botanas más exóticas e importadas.</p>
                    <p>Nos enorgullecemos de ser un negocio local que entiende el gusto de nuestra gente. Ya sea que busques algo picosito, dulce o salado, aquí siempre encontrarás un rincón de felicidad.</p>
                    
                    <div style="margin-top: 30px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="info-item">
                            <i class="fa-solid fa-star"></i>
                            <div>
                                <h4>Calidad</h4>
                                <p>Productos siempre frescos.</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fa-solid fa-truck"></i>
                            <div>
                                <h4>Variedad</h4>
                                <p>Nacional e Importado.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1581798459219-318e76aecc7b?auto=format&fit=crop&q=80&w=800" alt="Interior de la tienda">
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding featured">
        <div class="container text-center">
            <h2>Nuestra Especialidad</h2>
            <p style="max-width: 700px; margin: 0 auto 50px;">Contamos con la selección más amplia de dulces mexicanos, articulos para fiesta y snacks que solo encontrarás aquí.</p>
            <div class="about-stats" style="grid-template-columns: repeat(5, 1fr);">
                <div class="stat-item">
                    <span class="stat-number"><i class="fa-solid fa-candy-cane"></i></span>
                    <span class="stat-label">Dulces Típicos</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><i class="fa-solid fa-pepper-hot"></i></span>
                    <span class="stat-label">Botanas Picosas</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><i class="fa-solid fa-utensils"></i></span>
                    <span class="stat-label">Desechables</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><i class="fa-solid fa-face-grin-stars"></i></span>
                    <span class="stat-label">Artículos para Fiesta</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><i class="fa-solid fa-birthday-cake"></i></span>
                    <span class="stat-label">Repostería</span>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
