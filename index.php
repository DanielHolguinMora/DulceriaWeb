<?php

include "config.php";
$query = mysqli_query($conn, "SELECT * FROM usuarios");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operaciones CRUD usando PHP & MYSQL | DannyH</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Usuarios</h1>
        <a href="add.php"> Añade usuarios</a>

        <table>
            <tr>
                <th>Num.</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teleéono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>

            <?php
            $num = 1;
            while ($user = mysqli_fetch_assoc($query)) :  ?>

            <tr>
                <td><?= $num++ ?></td>
                <td><?= $user['nombre'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['telefono'] ?></td>
                <td><?= $user['direccion'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $user['id'] ?>">Editar</a> 
                    <a href="action.php?id=<?= $user['id'] ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

    </div>
    
</body>
</html>