<?php
<<<<<<< HEAD
<<<<<<< HEAD
require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

require_once 'views/layout/header.php';
?>

<main class="flex-grow container mx-auto px-margin py-lg max-w-7xl">
    <!-- Page Header & Action Bar -->
    <section class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <nav class="mb-4">
                <a class="flex items-center gap-1 text-[#E59120] font-black uppercase tracking-widest hover:translate-x-[-4px] transition-transform"
                    href="catalogo.php"><span class="material-symbols-outlined text-base"
                        data-icon="arrow_back">arrow_back</span> VOLVER AL CATÁLOGO</a>
            </nav>
            <h2 class="font-h1 text-h1 text-[#1C1A1B] uppercase italic mb-2">MI LISTA DE DESEOS</h2>
            <div class="h-2 w-48 bg-[#e0292e] border-2 border-[#1C1A1B] flat-bold-borders"></div>
        </div>
        <div class="flex gap-4">
            <button id="btn-clear-favorites"
                class="bg-[#f3eced] border-2 border-[#1C1A1B] px-6 py-3 font-label-bold text-[#1C1A1B] uppercase flat-bold-borders hover:bg-[#e7e1e2] transition-all active:translate-x-[2px] active:translate-y-[2px] active:shadow-none flex items-center gap-2"><span
                    class="material-symbols-outlined" data-icon="delete_sweep">delete_sweep</span> BORRAR
                FAVORITOS</button>
            <button
                class="bg-[#e59120] border-2 border-[#1C1A1B] px-8 py-3 font-label-bold text-[#1C1A1B] uppercase flat-bold-borders hover:bg-[#ffb869] transition-all active:translate-x-[2px] active:translate-y-[2px] active:shadow-none flex items-center gap-2"><span
                    class="material-symbols-outlined" data-icon="print">print</span> IMPRIMIR PARA TIENDA</button>
        </div>
    </section>
    <!-- Bento Grid for Favorites -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-gutter" id="favorites-grid">
        <!-- Products will be dynamically populated here by JS -->

        <!-- Empty State / Add More Card (Handled by JS to always be at the end) -->
        <div id="empty-favorites-state"
            class="border-4 border-dashed border-[#867463] flex flex-col items-center justify-center p-8 text-center bg-[#f8f2f3] group hover:border-[#885200] transition-colors h-full min-h-[300px]"
            style="display: none;">
            <span
                class="material-symbols-outlined text-6xl text-[#867463] mb-4 group-hover:scale-110 transition-transform"
                data-icon="add_circle">add_circle</span>
            <p class="font-label-bold uppercase text-[#867463]">¿Se te antoja algo más?</p>
            <a class="mt-2 text-[#885200] font-black underline uppercase" href="catalogo.php">Explorar la tienda</a>
        </div>
    </section>
    <!-- Brand Strip -->
    <section class="mt-xl bg-[#b0a700] border-y-4 border-[#1C1A1B] py-4 overflow-hidden relative">
        <div class="flex whitespace-nowrap gap-12 animate-marquee">
            <span class="font-black text-2xl text-[#3f3b00] uppercase italic tracking-tighter shrink-0">LLEVA ESTA LISTA
                A LA TIENDA CENTRAL</span>
            <span class="font-black text-2xl text-[#3f3b00] uppercase italic tracking-tighter shrink-0">•</span>
            <span class="font-black text-2xl text-[#3f3b00] uppercase italic tracking-tighter shrink-0">CAOS DULCE
                GARANTIZADO</span>
            <span class="font-black text-2xl text-[#3f3b00] uppercase italic tracking-tighter shrink-0">•</span>
            <span class="font-black text-2xl text-[#3f3b00] uppercase italic tracking-tighter shrink-0">LLEVATE TUS
                FAVORITOS ANTES DE QUE SE AGOTEN</span>
            <span class="font-black text-2xl text-[#3f3b00] uppercase italic tracking-tighter shrink-0">•</span>
            <span class="font-black text-2xl text-[#3f3b00] uppercase italic tracking-tighter shrink-0">LOS MEJORES
                DULCES DE LA CIUDAD</span>
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

$favoritos_ids = $_SESSION['favoritos'] ?? [];
$productos_fav = [];

if (!empty($favoritos_ids)) {
    $placeholders = implode(',', array_fill(0, count($favoritos_ids), '?'));
    $stmt = $conn->prepare("SELECT * FROM producto WHERE id_producto IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($favoritos_ids)), ...$favoritos_ids);
    $stmt->execute();
    $productos_fav = $stmt->get_result();
}
?>
<h2>Mis favoritos</h2>

<?php if (empty($favoritos_ids) || $productos_fav->num_rows == 0): ?>
    <p>No tienes productos favoritos. Visita el <a href="catalogo.php">catálogo</a> para agregar.</p>
<?php else: ?>
    <div class="product-grid">
        <?php while ($prod = $productos_fav->fetch_assoc()): ?>
            <div class="product-card">
                <img src="uploads/<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
                <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
                <p>$<?php echo number_format($prod['precio'], 2); ?></p>
                <button class="btn btn-danger remove-fav" data-id="<?php echo $prod['id_producto']; ?>">🗑️ Eliminar de favoritos</button>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<<<<<<< HEAD
<?php require_once 'includes/footer.php'; ?>
>>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f
=======
<?php require_once 'includes/footer.php'; ?>
>>>>>>> 6e2e6426b7a045d9a2a33bc8b3ab8f2b1b3e5b6f
