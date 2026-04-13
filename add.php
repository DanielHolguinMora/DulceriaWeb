<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anadir Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="wrapper">
        <div class="formwrapper">
            <h1>Añade Usuario</h1>
            <form method="POST" action="action.php">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="telefono" placeholder="Teléfono" required>
                <textarea name="direccion" placeholder="Dirección" required></textarea>
                <div class="btn-box">
                    <button type="submit" class="btn" name="agregar">Guardar</button>
                    <a href="index.php" class="btn">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>