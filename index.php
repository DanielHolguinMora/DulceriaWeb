<?php
<<<<<<< HEAD
<<<<<<< HEAD
require_once 'config/database.php';
require_once 'models/Producto.php';

$database = new Database();
$db = $database->getConnection();

$producto = new Producto($db);

require_once 'views/layout/header.php';
?>

<main>
    <!-- Hero Section -->
    <header
        class="relative w-full min-h-[716px] flex flex-col md:flex-row items-center justify-center bg-[#EFBD79] overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10">
            <div class="grid grid-cols-10 h-full w-full">
                <!-- Repeating pattern simulated by div loops -->
                <div class="border-r border-b border-[#1C1A1B]"></div>
                <div class="border-r border-b border-[#1C1A1B]"></div>
                <div class="border-r border-b border-[#1C1A1B]"></div>
                <div class="border-r border-b border-[#1C1A1B]"></div>
                <div class="border-r border-b border-[#1C1A1B]"></div>
                <div class="border-r border-b border-[#1C1A1B]"></div>
                <div class="border-r border-b border-[#1C1A1B]"></div>
                <div class="border-r border-b border-[#1C1A1B]"></div>
                <div class="border-r border-b border-[#1C1A1B]"></div>
                <div class="border-r border-b border-[#1C1A1B]"></div>
            </div>
        </div>
        <div class="relative z-10 container mx-auto px-6 flex flex-col md:flex-row items-center gap-12 py-xl">
            <div class="w-full md:w-1/2 flex justify-center">
                <div class="p-4 bg-white border-4 border-[#1C1A1B] flat-bold-borders rotate-[-2deg]">
                    <img class="w-full h-auto object-contain"
                        alt="Bold colorful logo of a traditional candy store with expressive typography and candy illustrations in orange and red"
                        src="/dulceria/uploads/LogoSolo.png" width="1024" height="1024" />
                </div>
            </div>
            <div class="w-full md:w-1/2 text-center md:text-left">
                <h1 class="font-h1 text-h1 text-[#1C1A1B] mb-6 uppercase leading-none tracking-tighter">EL CAOS MÁS
                    DULCE <span class="bg-[#E59120] text-white px-2">EN EL CENTRO</span> DE LA CIUDAD</h1>
                <p class="font-body-lg text-body-lg text-[#1C1A1B] mb-8 max-w-lg font-bold">
                    Tradición, sabor y locura desde el corazón de la ciudad. Llevamos décadas endulzando tus momentos
                    más especiales.
                </p>
                <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                    <a href="catalogo.php"
                        class="bg-[#E59120] text-[#1C1A1B] border-4 border-[#1C1A1B] px-8 py-4 font-label-bold text-lg uppercase flat-bold-borders active-button-shift transition-all inline-block">
                        Explorar Dulces
                    </a>
                    <a href="catalogo.php"
                        class="bg-white text-[#1C1A1B] border-4 border-[#1C1A1B] px-8 py-4 font-label-bold text-lg uppercase flat-bold-borders active-button-shift transition-all inline-block">
                        Ver Piñatas
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- Brand Strip -->
    <div class="w-full bg-[#1C1A1B] py-4 overflow-hidden whitespace-nowrap">
        <div class="flex gap-12 animate-marquee">
            <span class="text-[#E59120] font-h3 text-h3 uppercase italic">CALAVERITAS</span>
            <span class="text-white font-h3 text-h3 uppercase italic">PIÑATAS</span>
            <span class="text-[#E59120] font-h3 text-h3 uppercase italic">PICANTES</span>
            <span class="text-white font-h3 text-h3 uppercase italic">TRADICIONALES</span>
            <span class="text-[#E59120] font-h3 text-h3 uppercase italic">CHOCOLATES</span>
            <span class="text-white font-h3 text-h3 uppercase italic">CAOS</span>
            <!-- Repeated for seamless loop effect -->
            <span class="text-[#E59120] font-h3 text-h3 uppercase italic">CALAVERITAS</span>
            <span class="text-white font-h3 text-h3 uppercase italic">PIÑATAS</span>
            <span class="text-[#E59120] font-h3 text-h3 uppercase italic">PICANTES</span>
            <span class="text-white font-h3 text-h3 uppercase italic">TRADICIONALES</span>
        </div>
    </div>
    <!-- Main Categories: Bento Grid Style -->
    <section class="py-xl container mx-auto px-6">
        <h2 class="font-h1 text-h2 text-center mb-12 uppercase tracking-tighter">Nuestras Categorías</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 h-auto md:h-[600px]">
            <div
                class="md:col-span-2 md:row-span-2 bg-[#f4e700] border-4 border-[#1C1A1B] flat-bold-borders p-8 flex flex-col justify-between group cursor-pointer overflow-hidden relative">
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-6xl mb-4 text-[#1C1A1B]">bakery_dining</span>
                    <h3 class="font-h2 text-h2 uppercase mb-2">Tradicionales</h3>
                    <p class="font-body-md font-bold text-[#1C1A1B]/70">El sabor de antaño en cada mordida.</p>
                </div>
                <img class="absolute bottom-0 right-0 w-1/2 translate-y-12 translate-x-12 group-hover:translate-y-4 group-hover:translate-x-4 transition-transform duration-500"
                    alt="Close-up of colorful traditional Mexican candies like cocadas and palanquetas on a rustic wooden tray"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCHYISJq59GdAvMsjE2YiMIqSC8Pumyq9R5ktdyGUVbaoDCBPqeVkO71roaxBXBTqvnOcCS7g6fKHjRP8wCVhb2PsL-kamC6nB6OHJKH-xmxWGLD1_cVVnMmOFfaDptzpU_X26p_PG47FiN_UsA9Uty18U3W-2-pNdP3T9r4sPtrtTGevL1iS_Rx92-mTrTno0B4FpG5TK8gVzwXvSUXAXu6adafOLxIPCQrW6PfS3lYhf6TFu87M7zAS_sXE0sRG_cWuUzMAN3Y5c5" />
            </div>
            <div
                class="bg-[#bb0119] border-4 border-[#1C1A1B] flat-bold-borders p-6 flex flex-col justify-center items-center text-center text-white group cursor-pointer overflow-hidden relative">
                <span class="material-symbols-outlined text-5xl mb-2" data-weight="fill">celebration</span>
                <h3 class="font-h3 text-h3 uppercase">Piñatas</h3>
                <div class="absolute inset-0 bg-[#1C1A1B] opacity-0 group-hover:opacity-10 transition-opacity"></div>
            </div>
            <div
                class="bg-[#e59120] border-4 border-[#1C1A1B] flat-bold-borders p-6 flex flex-col justify-center items-center text-center text-white group cursor-pointer overflow-hidden relative">
                <span class="material-symbols-outlined text-5xl mb-2">nutrition</span>
                <h3 class="font-h3 text-h3 uppercase">Picantes</h3>
            </div>
            <div
                class="md:col-span-2 bg-white border-4 border-[#1C1A1B] flat-bold-borders p-6 flex items-center gap-8 group cursor-pointer">
                <div class="w-1/3 h-full overflow-hidden border-2 border-[#1C1A1B]">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        alt="Large glass jars filled with assorted gummy candies in a high-density candy store shelf layout"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBArAbWj2cbAgHaecsYXNl7pIBdwyESOP5dQ0aib90MVL9fOoaaPpPoe0TxU612qZqMcscHD33wvdPEuCdTFi_ACw8Au0DTvdyHbsIxlAKsAp5UFL0BSjfguMn2vxOWanQ-OxCVxi3YiqBnA5OV8i0Pj7MEE8gsN9VaUvnNrLs0b7xbPiMlaXigp4JNbt8xDN5SxgV0AS-A83EHKZ-2mLM1bAOPDV-rmjCo1p1Sxy3eZ5lF13qNTBwxl0tjg9vRcxNwWoxGKiN-QMa5" />
                </div>
                <div>
                    <h3 class="font-h2 text-h3 uppercase">Dulces a Granel</h3>
                    <p class="font-caption text-caption uppercase mt-2">¡Lleva lo que quieras!</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Products Strip -->
    <section class="bg-surface-container py-xl">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <h2 class="font-h1 text-h2 uppercase tracking-tighter max-w-sm">Lo más buscado esta semana</h2>
                <a href="catalogo.php"
                    class="bg-[#1C1A1B] text-white px-6 py-2 font-label-bold uppercase border-2 border-[#1C1A1B] flat-bold-borders">Ver
                    Todo</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
                <!-- Product Card 1 -->
                <div class="bg-white border-2 border-[#1C1A1B] p-base group cursor-pointer">
                    <div class="relative aspect-square overflow-hidden mb-sm border-b-2 border-[#1C1A1B]">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="Close-up studio shot of iconic spicy tamarind candy with bold lighting and high saturation"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBmJ1YAo1srLkRXlM2wcZ2WMGsZo3rYn_9JApYumlqsPumYNo8rlBbXtuE3mJw0_nIKYpXGP63hCl-QhUmP1T6mGxvwvcfrgKp8oi0ygFwr-uN72Kj52K0JBOUwUSdtwD_XvxzylSs43DYsVVuwn4emry65DEguch73HPhy0tBrN9dsiuM5GCri2pO3kXi71efqdpeXnWhtJ-zaGGd4Dp4HrSVlpkd7Avy844wqVL6kMWXPOQTj6k1K0S_9eEd48AS9hnf3-C_1yIzw" />
                        <div
                            class="absolute top-2 left-2 bg-[#bb0119] text-white font-label-bold px-2 py-1 text-[10px] uppercase">
                            New</div>
                    </div>
                    <div class="px-2 pb-2">
                        <h4 class="font-label-bold text-on-surface uppercase truncate">Tamarindo Loco Spicy</h4>
                        <div class="mt-2 flex gap-1">
                            <span
                                class="bg-surface-container-highest px-2 py-1 text-[10px] font-bold uppercase rounded-full">Spicy</span>
                            <span
                                class="bg-surface-container-highest px-2 py-1 text-[10px] font-bold uppercase rounded-full">Classic</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card 2 -->
                <div class="bg-white border-2 border-[#1C1A1B] p-base group cursor-pointer">
                    <div class="relative aspect-square overflow-hidden mb-sm border-b-2 border-[#1C1A1B]">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="Wrapped peanut mazapan candy on a minimalist white surface with hard shadows"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCS_IK_pQbu2hIVkgq2gF_6BBqRc5CZiQKHp_iwLDnx12XprOb5YQkid5G9d1Kmf7SEZCKJtTMtHeg31yYYDCPKVbI1ybQnNCJPuFP1lVH4F0ojg_tJnA1ojuSgiZzV9M_tChbowGYRLmq3F9SzIjkQrBjmx7Qug2SleWqq15ugGx0f13qlyG5Pf7f5shNQgc-xI9INCkokvxYubzlprVY3rYwFzr_QkDi9RcuvvrEzn-6nFRWE-8Wg0fiSAki3etFT_2v7Fv7a6Ufi" />
                        <div
                            class="absolute top-2 left-2 bg-[#e59120] text-white font-label-bold px-2 py-1 text-[10px] uppercase">
                            Top Seller</div>
                    </div>
                    <div class="px-2 pb-2">
                        <h4 class="font-label-bold text-on-surface uppercase truncate">Mazapán Gigante</h4>
                        <div class="mt-2 flex gap-1">
                            <span
                                class="bg-surface-container-highest px-2 py-1 text-[10px] font-bold uppercase rounded-full">Sweet</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card 3 -->
                <div class="bg-white border-2 border-[#1C1A1B] p-base group cursor-pointer">
                    <div class="relative aspect-square overflow-hidden mb-sm border-b-2 border-[#1C1A1B]">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="Handcrafted seven-pointed star piñata with vibrant multi-colored tissue paper streamers"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAfPAQuH1Rl5IsRxhBfHHeAjOc8IMFyUi1N1q6fW__c8leIqYrCM2Z-XOpf2wlIuqZ8AyEboniWj0uqEiJK3CVPL9aYQCDdf_M6iDHQOGL7-FKNVTrovymiEC2kjIz3-jE4JFVryOkPJbF9CvjwQrV3vW_iFChB2ZBVqbxhz07GTe7YxeD3BIg727y48biz5hML1cI6EVea13eY66QbjL51_gDccKb5BnIjy7QklpeGd2ggulDROkPecLMDZv2aC6FJljahgZk0fdrZ" />
                    </div>
                    <div class="px-2 pb-2">
                        <h4 class="font-label-bold text-on-surface uppercase truncate">Piñata Tradicional 7 Picos</h4>
                        <div class="mt-2 flex gap-1">
                            <span
                                class="bg-surface-container-highest px-2 py-1 text-[10px] font-bold uppercase rounded-full">Party</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card 4 -->
                <div class="bg-white border-2 border-[#1C1A1B] p-base group cursor-pointer">
                    <div class="relative aspect-square overflow-hidden mb-sm border-b-2 border-[#1C1A1B]">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="Stack of traditional Mexican wafers filled with cajeta, topped with goat milk caramel"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBirFKTwE8llCbg9MH-avlkpAUuJ8bp026HN9TbEcm7BixaekzDpSft9MayzcQR8qpUimHGUZr7fGPytHFu8NFHVxmruhMiDKd2Avr2bOdfBKM4-MvI3MDYIqElWALDCsb_PnzrdFz3-cNERn85_ww9OLeFiu6eLtYqBNpbjQwjj4aDqrGPNZ8gOw4F4ZRmsAzNEZ_y-kcfrdGrcjCj-J_Zm6K3pdloMh8M83BJxuVKfW5GhPcHAvW5niCoFg5Bq3HhqW45pSxm85j_" />
                    </div>
                    <div class="px-2 pb-2">
                        <h4 class="font-label-bold text-on-surface uppercase truncate">Obleas con Cajeta</h4>
                        <div class="mt-2 flex gap-1">
                            <span
                                class="bg-surface-container-highest px-2 py-1 text-[10px] font-bold uppercase rounded-full">Cajeta</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- History Blurb -->
    <section class="py-xl bg-[#1C1A1B] text-white">
        <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <div class="border-4 border-[#E59120] p-2 rotate-[2deg]">
                    <img class="w-full h-auto grayscale contrast-125"
                        alt="Vintage black and white photo of a busy traditional candy store storefront in a bustling historic city center"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBbRbyISrp8fEb_5A3NKOZvJeXDiL580KlNGE7HmL1FOGA5C-IrxSe7pg6WsQb6xjC_pLRaRSqEVSUW4Z4-lOLcHzO7MiBCs4ZyyIxhFFrvFl5D19XNrA5Kw-I7hCeWKRKyvAQXNy6UEjQytuqJRwx0l-gKCQ0f6mjonlSF2jcflULvspcQHnfg8X51w1wMaNpapKhIFbLcxxFnofklmtvx7OyO6p5N7WzGwr4ZCtmxMeFppWFqKUMRafME2waZ9xpfWqUmJw2ocN5D" />
                </div>
                <div
                    class="absolute -bottom-4 -right-4 bg-[#E59120] text-[#1C1A1B] p-6 font-h3 text-h3 uppercase leading-tight -rotate-[3deg] flat-bold-borders">
                    FUND. 1984</div>
            </div>
            <div>
                <h2 class="font-h1 text-h1 uppercase mb-6 tracking-tighter text-[#E59120]">Nuestra Historia</h2>
                <p class="font-body-lg text-body-lg mb-6 leading-relaxed">
                    Nacimos en el corazón del caos urbano, entre el bullicio de los mercados y el color de las plazas.
                    Dulcería El Loco no es solo una tienda, es el refugio de los que buscan ese sabor que te transporta
                    a la infancia.
                </p>
                <p class="font-body-md text-body-md mb-8 opacity-80">
                    Desde nuestras primeras piñatas hechas a mano hasta la selección de los tamarindos más bravos,
                    mantenemos viva la locura por lo dulce.
                </p>
                <a href="historia.php"
                    class="border-2 border-white px-8 py-3 font-label-bold uppercase hover:bg-white hover:text-[#1C1A1B] transition-colors inline-block">Leer
                    más</a>
            </div>
        </div>
    </section>
    <!-- Special Promotions / Social -->
    <section class="py-xl container mx-auto px-6">
        <div class="flex flex-col md:flex-row gap-gutter">
            <div
                class="flex-1 bg-[#EFBD79] border-4 border-[#1C1A1B] p-lg flat-bold-borders flex flex-col items-start gap-4">
                <span class="bg-[#bb0119] text-white px-3 py-1 font-label-bold uppercase">Promoción Especial</span>
                <h2 class="font-h1 text-h2 uppercase leading-none">Combos de Fiesta para Locos</h2>
                <p class="font-body-md font-bold max-w-sm">Todo lo que necesitas para tu piñata en un solo paquete.
                    ¡Dulces, relleno y más locura!</p>
                <button class="mt-4 bg-[#1C1A1B] text-white px-8 py-3 font-label-bold uppercase active-button-shift">Me
                    Interesa</button>
            </div>
            <div
                class="w-full md:w-1/3 bg-white border-4 border-[#1C1A1B] p-lg flat-bold-borders flex flex-col justify-center gap-6">
                <h3 class="font-h2 text-h3 uppercase text-center">¡Síguenos en el caos!</h3>
                <div class="flex justify-center gap-6">
                    <div
                        class="w-12 h-12 bg-[#1C1A1B] flex items-center justify-center text-[#E59120] cursor-pointer hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">social_leaderboard</span>
                    </div>
                    <div
                        class="w-12 h-12 bg-[#1C1A1B] flex items-center justify-center text-[#E59120] cursor-pointer hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">photo_camera</span>
                    </div>
                    <div
                        class="w-12 h-12 bg-[#1C1A1B] flex items-center justify-center text-[#E59120] cursor-pointer hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">play_circle</span>
                    </div>
                </div>
                <p class="text-center font-caption text-caption uppercase font-bold">@DulceriaElLocoOficial</p>
            </div>
        </div>
    </section>
</main>

<?php
require_once 'views/layout/footer.php';
?>
=======
=======
>>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f
require_once 'includes/header.php';
// Mostrar algunos productos destacados (los últimos 3)
$stmt = $conn->prepare("SELECT * FROM producto ORDER BY fecha_creacion DESC LIMIT 3");
$stmt->execute();
$productos_destacados = $stmt->get_result();
?>
<h2>Bienvenido a Dulcería El Sabor</h2>
<p>Los mejores dulces al mejor precio. Explora nuestro catálogo y encuentra tus favoritos.</p>

<h3>Productos destacados</h3>
<div class="product-grid">
    <?php while ($prod = $productos_destacados->fetch_assoc()): ?>
        <div class="product-card">
            <img src="uploads/<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
            <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
            <p>$<?php echo number_format($prod['precio'], 2); ?></p>
            <a href="catalogo.php?detalle=<?php echo $prod['id_producto']; ?>" class="btn">Ver más</a>
        </div>
    <?php endwhile; ?>
</div>
<<<<<<< HEAD
<?php require_once 'includes/footer.php'; ?>
>>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f
=======
<?php require_once 'includes/footer.php'; ?>
>>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f
