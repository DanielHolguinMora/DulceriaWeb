<?php
<<<<<<< HEAD
<<<<<<< HEAD
require_once 'config/database.php';
require_once 'models/Producto.php';
require_once 'models/Categoria.php';
require_once 'models/Marca.php';

$database = new Database();
$db = $database->getConnection();

$producto = new Producto($db);
$categoria = new Categoria($db);
$marca = new Marca($db);

// Get filters from GET
$search = $_GET['s'] ?? '';
$selected_cats = isset($_GET['cat']) ? (is_array($_GET['cat']) ? $_GET['cat'] : [$_GET['cat']]) : [];
$selected_brands = isset($_GET['brand']) ? (is_array($_GET['brand']) ? $_GET['brand'] : [$_GET['brand']]) : [];
$order = $_GET['order'] ?? 'relevance';

// Fetch filtered products
$params = [
    'search' => $search,
    'categorias' => $selected_cats,
    'marcas' => $selected_brands,
    'order' => $order
];
$stmt_products = $producto->readFiltered($params);
$productos = [];
if ($stmt_products) {
    $productos = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch categories and brands for sidebar
$stmt_cats = $categoria->readAll();
$all_cats = $stmt_cats->fetchAll(PDO::FETCH_ASSOC);

$stmt_brands = $marca->readAll();
$all_brands = $stmt_brands->fetchAll(PDO::FETCH_ASSOC);

require_once 'views/layout/header.php';
?>

<main class="pt-32 pb-xl px-margin max-w-7xl mx-auto">
    <form action="catalogo.php" method="GET" id="filter-form">
        <!-- Top Toolbar: Search & Sort -->
        <section class="mb-lg flex flex-col md:flex-row gap-gutter items-center">
            <!-- Search Bar -->
            <div class="flex-1 w-full">
                <div class="flex items-center bg-white border-4 border-[#1C1A1B] p-2 flat-bold-borders">
                    <span class="material-symbols-outlined text-[#1C1A1B] px-sm">search</span>
                    <input name="s" value="<?php echo htmlspecialchars($search); ?>" 
                        class="w-full border-none focus:ring-0 font-label-bold text-lg uppercase py-2"
                        placeholder="¿QUÉ ANTOJO TIENES HOY?" type="text" onchange="this.form.submit()" />
                </div>
            </div>
            <!-- Sort Dropdown -->
            <div class="w-full md:w-64">
                <div class="relative bg-white border-4 border-[#1C1A1B] p-2 flat-bold-borders">
                    <label class="absolute -top-3 left-2 bg-[#E59120] text-white text-[10px] font-black px-2 py-0.5 border-2 border-[#1C1A1B] uppercase">Ordenar por</label>
                    <select name="order" onchange="this.form.submit()" 
                        class="w-full border-none focus:ring-0 font-label-bold uppercase bg-transparent appearance-none py-2 pr-8">
                        <option value="relevance" <?php echo $order == 'relevance' ? 'selected' : ''; ?>>Relevancia</option>
                        <option value="alpha_asc" <?php echo $order == 'alpha_asc' ? 'selected' : ''; ?>>Nombre (A-Z)</option>
                        <option value="alpha_desc" <?php echo $order == 'alpha_desc' ? 'selected' : ''; ?>>Nombre (Z-A)</option>
                        <option value="price_asc" <?php echo $order == 'price_asc' ? 'selected' : ''; ?>>Precio: Menor a Mayor</option>
                        <option value="price_desc" <?php echo $order == 'price_desc' ? 'selected' : ''; ?>>Precio: Mayor a Menor</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none">expand_more</span>
                </div>
            </div>
        </section>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Left Sidebar: Filters -->
            <aside class="w-full lg:w-64 flex-shrink-0 space-y-10">
                <!-- Categories -->
                <div class="bg-white border-4 border-[#1C1A1B] p-6 flat-bold-borders relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 opacity-20 rotate-12">
                        <span class="material-symbols-outlined text-6xl text-[#E59120]">category</span>
                    </div>
                    <h3 class="font-h3 text-xl text-[#1C1A1B] uppercase italic mb-6 border-b-4 border-[#E59120] inline-block">Categorías</h3>
                    <div class="space-y-4">
                        <?php foreach ($all_cats as $cat): ?>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="cat[]" value="<?php echo $cat['id']; ?>" 
                                <?php echo in_array($cat['id'], $selected_cats) ? 'checked' : ''; ?>
                                onchange="this.form.submit()"
                                class="w-6 h-6 border-4 border-[#1C1A1B] text-[#E59120] focus:ring-0 rounded-none cursor-pointer">
                            <span class="font-label-bold text-sm uppercase group-hover:text-[#E59120] transition-colors"><?php echo htmlspecialchars($cat['nombre']); ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Brands -->
                <div class="bg-white border-4 border-[#1C1A1B] p-6 flat-bold-borders relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 opacity-20 rotate-12">
                        <span class="material-symbols-outlined text-6xl text-[#bb0119]">sell</span>
                    </div>
                    <h3 class="font-h3 text-xl text-[#1C1A1B] uppercase italic mb-6 border-b-4 border-[#bb0119] inline-block">Marcas</h3>
                    <div class="space-y-4">
                        <?php foreach ($all_brands as $b): ?>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="brand[]" value="<?php echo $b['id']; ?>" 
                                <?php echo in_array($b['id'], $selected_brands) ? 'checked' : ''; ?>
                                onchange="this.form.submit()"
                                class="w-6 h-6 border-4 border-[#1C1A1B] text-[#bb0119] focus:ring-0 rounded-none cursor-pointer">
                            <span class="font-label-bold text-sm uppercase group-hover:text-[#bb0119] transition-colors"><?php echo htmlspecialchars($b['nombre']); ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Clear Filters -->
                <?php if (!empty($search) || !empty($selected_cats) || !empty($selected_brands)): ?>
                <a href="catalogo.php" class="block w-full text-center bg-[#1C1A1B] text-white font-black uppercase py-4 border-4 border-[#1C1A1B] flat-bold-borders hover:bg-gray-800 active-button-shift transition-all">
                    Limpiar Filtros
                </a>
                <?php endif; ?>
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                <?php if (empty($productos)): ?>
                    <div class="bg-white border-4 border-[#1C1A1B] p-12 text-center flat-bold-borders">
                        <span class="material-symbols-outlined text-8xl text-gray-300 mb-4">sentiment_dissatisfied</span>
                        <h2 class="font-h2 text-h2 uppercase text-[#1C1A1B] mb-2">¡Ups! No hay dulces aquí</h2>
                        <p class="font-body-lg text-gray-600">Intenta cambiar tus filtros o busca algo diferente.</p>
                        <a href="catalogo.php" class="mt-8 inline-block bg-[#E59120] text-white font-black uppercase px-8 py-4 border-4 border-[#1C1A1B] flat-bold-borders hover:bg-[#EFBD79] transition-all">Ver todos los dulces</a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 2xl:grid-cols-4 gap-gutter" id="catalog-grid">
                        <?php
                        foreach ($productos as $row):
                            $imgSrc = !empty($row['imagen_frontal']) ? htmlspecialchars($base_url . 'uploads/' . $row['imagen_frontal']) : 'https://via.placeholder.com/400?text=No+Image';
                            $productData = [
                                "id" => (string)$row['id'],
                                "nombre" => $row['nombre'],
                                "categoria" => $row['categoria_nombre'] ?? 'Sin Categoría',
                                "imagen" => $imgSrc
                            ];
                            ?>
                            <!-- Dynamic Product Card -->
                            <div class="bg-white border-4 border-[#1C1A1B] flat-bold-borders flex flex-col group relative reveal-card"
                                data-product='<?php echo json_encode($productData, JSON_HEX_APOS | JSON_HEX_QUOT); ?>'>
                                
                                <!-- Favorite Heart Emoji -->
                                <button
                                    class="favorite-btn absolute top-4 right-4 z-20 bg-white/90 border-2 border-[#1C1A1B] w-12 h-12 flex items-center justify-center flat-bold-borders-small text-gray-400 hover:text-[#bb0119] transition-all active-button-shift"
                                    data-id="<?php echo $row['id']; ?>" title="Agregar a Favoritos">
                                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 0;">favorite</span>
                                </button>

                                <div class="relative h-64 overflow-hidden border-b-4 border-[#1C1A1B]">
                                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        alt="<?php echo htmlspecialchars($row['nombre']); ?>" src="<?php echo $imgSrc; ?>" />
                                    <?php if ($row['stock'] > 0 && $row['stock'] < 10): ?>
                                        <div class="absolute bottom-4 left-4 bg-[#e59120] text-white font-black text-xs px-3 py-1 border-2 border-[#1C1A1B] uppercase tracking-tighter italic">
                                            ¡Pocas Unidades!
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-6 bg-white flex-1 flex flex-col justify-between relative overflow-hidden">
                                    <!-- Decorative background name -->
                                    <span class="absolute -right-2 -bottom-2 text-6xl font-black text-[#1C1A1B] opacity-[0.03] uppercase italic pointer-events-none"><?php echo htmlspecialchars($row['marca_nombre'] ?? ''); ?></span>
                                    
                                    <div class="relative z-10">
                                        <div class="flex justify-between items-start mb-4">
                                            <span class="px-2 py-1 border-2 border-[#1C1A1B] bg-secondary-container text-white text-xs font-black uppercase tracking-widest"><?php echo htmlspecialchars($row['categoria_nombre'] ?? 'General'); ?></span>
                                            <span class="font-label-bold text-xs text-gray-600 uppercase tracking-widest italic font-black"><?php echo htmlspecialchars($row['marca_nombre'] ?? 'Genérico'); ?></span>
                                        </div>
                                        <h3 class="font-h3 text-2xl text-[#1C1A1B] uppercase leading-tight mb-2 group-hover:text-[#bb0119] transition-colors">
                                            <?php echo htmlspecialchars($row['nombre']); ?>
                                        </h3>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between relative z-10">
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-xs">
                                                <span class="w-3 h-3 rounded-full <?php echo $row['stock'] > 0 ? 'bg-green-500' : 'bg-red-500'; ?> border-2 border-[#1C1A1B]"></span>
                                                <span class="font-black text-xs uppercase italic <?php echo $row['stock'] > 0 ? 'text-green-600' : 'text-red-600'; ?>"><?php echo $row['stock'] > 0 ? 'En Existencia' : 'Agotado'; ?></span>
                                            </div>
                                        </div>
                                        <a href="producto.php?id=<?php echo $row['id']; ?>" class="bg-[#1C1A1B] text-white p-3 border-2 border-[#1C1A1B] flat-bold-borders-small hover:bg-[#bb0119] transition-all active-button-shift">
                                            <span class="material-symbols-outlined">visibility</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
</main>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 8px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f3eced; border: 2px solid #1C1A1B; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #1C1A1B; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #E59120; }

/* Reveal Animation */
.reveal-card {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1);
}
.reveal-card.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Heart Pop Animation */
@keyframes heartPop {
    0% { transform: scale(1); }
    50% { transform: scale(1.4); }
    100% { transform: scale(1); }
}
.favorite-btn.pop-animation span {
    animation: heartPop 0.45s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.favorite-btn.is-favorite {
    color: #bb0119 !important;
    background-color: #fff1f2 !important;
    border-color: #bb0119 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Scroll Reveal with Intersection Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Staggered appearance
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, index * 50);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const cards = document.querySelectorAll('.reveal-card');
    cards.forEach(card => observer.observe(card));
});
</script>

<?php
require_once 'views/layout/footer.php';
?>
=======
=======
>>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f
require_once 'includes/header.php';

$categorias = $conn->query("SELECT * FROM categoria");
$marcas = $conn->query("SELECT * FROM marca");

$where = [];
$params = [];
$types = "";

if (isset($_GET['categoria']) && $_GET['categoria'] != '') {
    $where[] = "id_categoria = ?";
    $params[] = $_GET['categoria'];
    $types .= "i";
}
if (isset($_GET['marca']) && $_GET['marca'] != '') {
    $where[] = "id_marca = ?";
    $params[] = $_GET['marca'];
    $types .= "i";
}
if (isset($_GET['buscar']) && $_GET['buscar'] != '') {
    $where[] = "nombre LIKE ?";
    $params[] = "%" . $_GET['buscar'] . "%";
    $types .= "s";
}

$sql = "SELECT * FROM producto";
if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$stmt = $conn->prepare($sql);
if (count($params) > 0) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$productos = $stmt->get_result();
?>
<h2>Catálogo de productos</h2>

<form method="get" action="catalogo.php" style="margin-bottom: 1rem;">
    <input type="text" name="buscar" placeholder="Buscar producto..." value="<?php echo htmlspecialchars($_GET['buscar'] ?? ''); ?>">
    <select name="categoria">
        <option value="">Todas las categorías</option>
        <?php while ($cat = $categorias->fetch_assoc()): ?>
            <option value="<?php echo $cat['id_categoria']; ?>" <?php if (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($cat['nombre']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    <select name="marca">
        <option value="">Todas las marcas</option>
        <?php while ($mar = $marcas->fetch_assoc()): ?>
            <option value="<?php echo $mar['id_marca']; ?>" <?php if (isset($_GET['marca']) && $_GET['marca'] == $mar['id_marca']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($mar['nombre']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    <button type="submit">Filtrar</button>
</form>

<div class="product-grid">
    <?php if ($productos->num_rows == 0): ?>
        <p>No hay productos que coincidan con los filtros.</p>
    <?php else: ?>
        <?php while ($prod = $productos->fetch_assoc()): ?>
            <div class="product-card">
                <img src="uploads/<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
                <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
                <p>$<?php echo number_format($prod['precio'], 2); ?></p>
                <p>Stock: <?php echo $prod['stock']; ?></p>
                <button class="btn add-fav" data-id="<?php echo $prod['id_producto']; ?>">❤️ Añadir a favoritos</button>
                <a href="catalogo.php?detalle=<?php echo $prod['id_producto']; ?>" class="btn">Ver más</a>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<<<<<<< HEAD
<?php require_once 'includes/footer.php'; ?>
>>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f
=======
<?php require_once 'includes/footer.php'; ?>
>>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f
