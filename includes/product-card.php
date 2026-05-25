<?php
function renderProductCard($product) {
    $name = htmlspecialchars($product['nombre']);
    $desc = htmlspecialchars($product['descripcion'] ?? '');
    // Mostrar el nombre de la categoría o "Sin categoría"
    $category = htmlspecialchars($product['categoria_nombre'] ?? $product['categoria'] ?? 'Sin categoría');
    // Mostrar el nombre de la marca o "Genérica"
    $brand = htmlspecialchars($product['marca_nombre'] ?? $product['marca'] ?? 'Genérica');
    $image = $product['imagen_frontal'] ?? $product['imagen'] ?? 'assets/img/hero.png';
    $isNew = isset($product['nuevo']) && $product['nuevo'];
    
    // Create a slug or simple ID for filtering/JS
    $dataCategory = strtolower(str_replace(' ', '-', $category));
    $dataBrand = strtolower(str_replace(' ', '-', $brand));
    $dataName = strtolower($name);

    $likes = isset($product['likes']) ? intval($product['likes']) : 0;

    echo "
    <div class='product-card' 
         data-id='{$product['id']}'
         data-name='{$dataName}' 
         data-category='{$dataCategory}'
         data-brand='{$dataBrand}'
         data-brand-name='{$brand}'
         data-image='{$image}'>
        " . ($isNew ? "<div class='product-badge'>Nuevo</div>" : "") . "
        <div class='product-img'>
            <img src='{$image}' alt='{$name}' loading='lazy'>
        </div>
        <div class='product-info'>
            <span class='category-label'>{$category}</span>
            <h3>{$name}</h3>
            <div class='product-footer'>
                <div class='product-actions' style='width: 100%; display: flex; justify-content: flex-end;'>
                    <button class='fav-btn' title='Añadir a favoritos'>
                        <i class='fa-regular fa-heart'></i>
                        <span class='likes-count'>{$likes}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    ";
}
?>
