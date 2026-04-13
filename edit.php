<?php

include "config.php";
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM usuarios WHERE id=$id");
$user = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="wrapper">
        <div class="form-wrapper">
            <h1>Editar Usuario</h1>
            <form method="POST" action="action.php?id=<?= $id ?>">
                <input type="text" name="nombre" placeholder="Nombre" value="<?= $user['nombre'] ?>" required>
                <input type="email" name="email" placeholder="Email"value="<?= $user['email'] ?>" required>
                <input type="text" name="telefono" placeholder="Teléfono" value="<?= $user['telefono'] ?>" required>
                <textarea name="direccion" placeholder="Dirección" required><?= $user['direccion'] ?></textarea>
                <div class="btn-box">
                    <button type="submit" class="btn" name="actualizar">Actualizar</button>
                    <a href="index.php" class="btn">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>