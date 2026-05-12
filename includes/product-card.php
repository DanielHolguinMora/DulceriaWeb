<?php
function renderProductCard($product) {
    $name = htmlspecialchars($product['nombre']);
    $desc = htmlspecialchars($product['descripcion']);
    $price = number_format($product['precio'], 2);
    $category = htmlspecialchars($product['categoria']);
    $image = $product['imagen'];
    $isNew = isset($product['nuevo']) && $product['nuevo'];
    
    // Create a slug or simple ID for filtering/JS
    $dataCategory = strtolower(str_replace(' ', '-', $category));
    $dataName = strtolower($name);

    echo "
    <div class='product-card' 
         data-id='{$product['id']}'
         data-name='{$dataName}' 
         data-category='{$dataCategory}'
         data-price='{$price}'
         data-image='{$image}'>
        " . ($isNew ? "<div class='product-badge'>Nuevo</div>" : "") . "
        <div class='product-img'>
            <img src='{$image}' alt='{$name}' loading='lazy'>
        </div>
        <div class='product-info'>
            <span class='category-label'>{$category}</span>
            <h3>{$name}</h3>
            <p>" . (strlen($desc) > 70 ? substr($desc, 0, 67) . '...' : $desc) . "</p>
            <div class='product-footer'>
                <span class='product-price'>\${$price}</span>
                <div class='product-actions'>
                    <button class='fav-btn' title='Añadir a favoritos'><i class='fa-regular fa-heart'></i></button>
                    <a href='producto.php?id={$product['id']}' class='view-more-btn'>Ver más</a>
                </div>
            </div>
        </div>
    </div>
    ";
}
?>
