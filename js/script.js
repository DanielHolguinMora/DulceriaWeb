document.addEventListener('DOMContentLoaded', function() {
    const favButtons = document.querySelectorAll('.add-fav');
    favButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.id;
            fetch(`ajax_favoritos.php?action=add&id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Producto añadido a favoritos');
                        this.textContent = '✓ En favoritos';
                        this.disabled = true;
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
        });
    });

    const removeFavButtons = document.querySelectorAll('.remove-fav');
    removeFavButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.id;
            fetch(`ajax_favoritos.php?action=remove&id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); 
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
        });
    });
});