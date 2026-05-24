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
                    <h2>Dulcería El Loco</h2>
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
            <p style="max-width: 700px; margin: 0 auto 50px;">Contamos con la selección más amplia de dulces mexicanos, papas preparadas y snacks que solo encontrarás aquí.</p>
            <div class="product-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                <div class="product-card">
                    <div class="product-img" style="height: 120px;"><i class="fa-solid fa-candy-cane" style="font-size: 3rem; color: var(--primary);"></i></div>
                    <h3>Dulces Típicos</h3>
                </div>
                <div class="product-card">
                    <div class="product-img" style="height: 120px;"><i class="fa-solid fa-pepper-hot" style="font-size: 3rem; color: var(--primary);"></i></div>
                    <h3>Botanas Picosas</h3>
                </div>
                <div class="product-card">
                    <div class="product-img" style="height: 120px;"><i class="fa-solid fa-utensils" style="font-size: 3rem; color: var(--primary);"></i></div>
                    <h3>Desechables</h3>
                </div>
                <div class="product-card">
                    <div class="product-img" style="height: 120px;"><i class="fa-solid fa-solid fa-face-grin-stars" style="font-size: 3rem; color: var(--primary);"></i></div>
                    <h3>Articulos para Fiesta</h3>
                </div>
                <div class="product-card">
                    <div class="product-img" style="height: 120px;"><i class="fa-solid fa-birthday-cake" style="font-size: 3rem; color: var(--primary);"></i></div>
                    <h3>Repostería</h3>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
