<?php
require_once 'config/database.php';

require_once 'views/layout/header.php';
?>

<main class="max-w-7xl mx-auto px-margin py-xl space-y-xl">
    <!-- Hero Section: The Sweetest Chaos -->
    <section class="grid md:grid-cols-2 gap-lg items-center">
        <div class="space-y-md">
            <div
                class="inline-block bg-secondary-container text-white px-4 py-1 border-2 border-[#1C1A1B] font-label-bold text-label-bold uppercase transform -rotate-2">
                Tradición desde 1948
            </div>
            <h1 class="font-h1 text-h1 text-on-surface uppercase tracking-tighter leading-[0.9]">
                EL CAOS MÁS <span class="text-primary-container drop-shadow-[3px_3px_0px_#1C1A1B]">DULCE</span> DEL
                CENTRO.
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">
                No somos una dulcería cualquiera. Somos el latido de la ciudad, el aroma a caramelo quemado y la alegría
                empaquetada que ha alimentado a tres generaciones.
            </p>
            <div class="flex gap-sm">
                <a href="catalogo.php"
                    class="inline-block bg-primary-container text-on-primary-container border-2 border-[#1C1A1B] px-md py-sm font-label-bold text-label-bold uppercase flat-bold-borders active-press">
                    Ver Catálogo
                </a>
                <a href="contacto.php"
                    class="inline-block bg-white text-[#1C1A1B] border-2 border-[#1C1A1B] px-md py-sm font-label-bold text-label-bold uppercase flat-bold-borders active-press">
                    Visítanos
                </a>
            </div>
        </div>
        <div class="relative">
            <div class="absolute -top-4 -left-4 w-full h-full border-4 border-[#1C1A1B] rounded-lg"></div>
            <img alt="Dulcería El Loco Storefront"
                class="w-full aspect-[4/3] object-cover border-4 border-[#1C1A1B] rounded-lg relative z-10"
                data-alt="Vibrant candy shop interior with rows of colorful jars, warm nostalgic lighting, and a bustling city center atmosphere"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBNqxo-eYF3SFxKYtKQAxIFBJlfJXFbdD09zQ-_GTrTZOmTDqVJaNt-eqPMhI_LIFJdLcgzfJo0Lj5kYRipNJbmdnFo6jNjp9Q1zJY934Ddu5rmy1vc9_Q6pYA1zYtt0UGapZq804FXkNMnv8OK4PpWzuWZ_0ufnLGvU_UD8o4z7a7C4bdeydD8c80Ofz4gG81Bjao_q9WqTZqtbvKOzIeahUnftohexkBMzxm8xhdFq4p0s4Y1ylqDlLymG2TdgwpAIVS_G2DlS-gL" />
            <div
                class="absolute -bottom-6 -right-6 bg-tertiary-container border-4 border-[#1C1A1B] p-4 z-20 flat-bold-borders hidden sm:block">
                <p class="font-h3 text-h3 uppercase text-white">+500 VARIEDADES</p>
            </div>
        </div>
    </section>
    <!-- Brand Strip -->
    <div class="w-full bg-[#E59120] py-4 overflow-hidden border-y-4 border-[#1C1A1B]">
        <div class="flex gap-xl animate-marquee whitespace-nowrap">
            <span class="font-h2 text-h2 text-white uppercase italic">SABOR REAL • CALIDAD LOCA • TRADICIÓN PURA • SABOR
                REAL • CALIDAD LOCA • TRADICIÓN PURA • SABOR REAL • CALIDAD LOCA</span>
        </div>
    </div>
    <!-- History Bento Grid -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
        <div
            class="md:col-span-2 bg-surface-container-high border-2 border-[#1C1A1B] p-lg flat-bold-borders flex flex-col justify-between">
            <div>
                <h2 class="font-h2 text-h2 uppercase mb-sm">NUESTRO VIAJE</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mb-md">
                    Todo comenzó con un pequeño carrito de madera en la esquina de la plaza principal. Don "Loco" no
                    solo vendía dulces; vendía momentos de escape. Con los años, ese carrito se transformó en el
                    laberinto de delicias que hoy conoces, manteniendo siempre la misma receta de honestidad y azúcar.
                </p>
            </div>
            <div class="flex gap-md items-center">
                <div
                    class="w-16 h-16 bg-[#885200] rounded-full border-2 border-[#1C1A1B] flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-3xl" data-icon="history">history</span>
                </div>
                <div>
                    <p class="font-label-bold text-label-bold uppercase">Fundada en</p>
                    <p class="font-h3 text-h3">1948</p>
                </div>
            </div>
        </div>
        <div
            class="bg-secondary text-white border-2 border-[#1C1A1B] p-lg flat-bold-borders relative overflow-hidden group">
            <h3 class="font-h3 text-h3 uppercase mb-sm relative z-10">TURISTAS &amp; LOCALES</h3>
            <p class="font-caption text-caption uppercase tracking-widest mb-md relative z-10">EL PUNTO DE ENCUENTRO</p>
            <p class="font-body-md text-body-md relative z-10">
                Nadie se va del centro sin su bolsa naranja. Somos el souvenir favorito de los viajeros y la parada
                obligatoria de los locales cada domingo.
            </p>
            <span class="material-symbols-outlined absolute -bottom-4 -right-4 text-9xl opacity-20 transform -rotate-12"
                data-icon="star">star</span>
        </div>
        <div class="bg-tertiary-container border-2 border-[#1C1A1B] p-lg flat-bold-borders">
            <span class="material-symbols-outlined text-4xl mb-sm" data-icon="auto_awesome">auto_awesome</span>
            <h3 class="font-h3 text-h3 uppercase mb-sm">CALIDAD</h3>
            <p class="font-body-md text-body-md">Seleccionamos cada dulce como si fuera para nuestra propia familia. Si
                no es increíble, no entra a la tienda.</p>
        </div>
        <div class="md:col-span-2 bg-white border-2 border-[#1C1A1B] p-lg flat-bold-borders grid md:grid-cols-2 gap-md">
            <img alt="Candy Details" class="w-full h-full object-cover border-2 border-[#1C1A1B]"
                data-alt="Close-up of traditional colorful candies in glass jars with vintage labels in a city center candy store"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCieJc576nfHjlvYFRRxr9tt1amXHmzAlmy8vOiGJGFeI7weGoAdCPFZ9X7VFUjpUVZy7ejuzyuA5OM61ZCZKgHoduJlsNKthHcENINj3vJK3iEiqGWFq5BvPYfOqC5cTCwv-8Npae_ykHoA2dh2g7XapRLGNCalpWJy09k5bamOxDbJ12LtGHlibC5QuB2cVlGmZt7U5lm15g9FXQHyb5sZaT4V1Xg11GAIyu36kQ1E-5rDCqeZkc3BDuLlzDT9wvPvGB6mYhpns_z" />
            <div class="flex flex-col justify-center">
                <h3 class="font-h3 text-h3 uppercase mb-sm">VARIEDAD FESTIVA</h3>
                <p class="font-body-md text-body-md mb-md">Desde gomitas picantes hasta chocolates artesanales y dulces
                    típicos regionales. Tenemos el sabor exacto que estás buscando.</p>
                <div class="flex flex-wrap gap-xs">
                    <span
                        class="bg-surface-container-low border border-[#1C1A1B] px-2 py-1 text-caption font-label-bold uppercase">Picantes</span>
                    <span
                        class="bg-surface-container-low border border-[#1C1A1B] px-2 py-1 text-caption font-label-bold uppercase">Chocolates</span>
                    <span
                        class="bg-surface-container-low border border-[#1C1A1B] px-2 py-1 text-caption font-label-bold uppercase">Artesanales</span>
                </div>
            </div>
        </div>
    </section>
    <!-- Values Section -->
    <section class="bg-white border-2 border-[#1C1A1B] overflow-hidden">
        <div class="grid md:grid-cols-4 divide-y-2 md:divide-y-0 md:divide-x-2 divide-[#1C1A1B]">
            <div class="p-lg space-y-sm hover:bg-primary-container transition-colors group">
                <span class="material-symbols-outlined text-4xl text-[#885200] group-hover:text-white"
                    data-icon="favorite">favorite</span>
                <h4 class="font-label-bold text-label-bold uppercase">Pasión</h4>
                <p class="font-caption text-caption">Amamos lo que hacemos y se nota en cada empaque.</p>
            </div>
            <div class="p-lg space-y-sm hover:bg-primary-container transition-colors group">
                <span class="material-symbols-outlined text-4xl text-[#885200] group-hover:text-white"
                    data-icon="diversity_3">diversity_3</span>
                <h4 class="font-label-bold text-label-bold uppercase">Comunidad</h4>
                <p class="font-caption text-caption">Crecemos junto a los vecinos del centro histórico.</p>
            </div>
            <div class="p-lg space-y-sm hover:bg-primary-container transition-colors group">
                <span class="material-symbols-outlined text-4xl text-[#885200] group-hover:text-white"
                    data-icon="workspace_premium">workspace_premium</span>
                <h4 class="font-label-bold text-label-bold uppercase">Integridad</h4>
                <p class="font-caption text-caption">Solo ingredientes reales y procesos honestos.</p>
            </div>
            <div class="p-lg space-y-sm hover:bg-primary-container transition-colors group">
                <span class="material-symbols-outlined text-4xl text-[#885200] group-hover:text-white"
                    data-icon="celebration">celebration</span>
                <h4 class="font-label-bold text-label-bold uppercase">Alegría</h4>
                <p class="font-caption text-caption">Hacemos que cada día se sienta como una fiesta.</p>
            </div>
        </div>
    </section>
    <!-- The Founder Quote -->
    <section
        class="relative bg-inverse-surface text-inverse-on-surface p-xl border-4 border-[#1C1A1B] flat-bold-borders overflow-hidden">
        <div class="relative z-10 text-center space-y-md">
            <span class="material-symbols-outlined text-6xl text-primary-fixed-dim"
                data-icon="format_quote">format_quote</span>
            <p class="font-h2 text-h2 italic leading-tight max-w-4xl mx-auto text-[#f5eff0]">
                "LA VIDA ES DEMASIADO CORTA PARA NO COMERSE EL DULCE QUE TE ESTÁ MIRANDO. EN EL LOCO, TODO VALE."
            </p>
            <p class="font-label-bold text-label-bold uppercase tracking-widest text-primary-fixed-dim">— El Loco
                Original</p>
        </div>
        <div class="absolute top-0 right-0 p-8 opacity-10">
            <span class="material-symbols-outlined text-[200px]" data-icon="ice_cream">icecream</span>
        </div>
    </section>
</main>

<?php
require_once 'views/layout/footer.php';
?>