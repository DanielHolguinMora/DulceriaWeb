<?php

include 'config.php';

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    mysqli_query($conn, "INSERT INTO usuarios (nombre, email, telefono, direccion) 
                     VALUES ('$nombre', '$email', '$telefono', '$direccion')");
    header("Location: index.php");
    exit();
}

if (isset($_POST['actualizar'])) {
    $id = $_GET['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    mysqli_query($conn, "UPDATE usuarios SET 
                     nombre='$nombre', 
                     email='$email', 
                     telefono='$telefono', 
                     direccion='$direccion' 
                     WHERE id=$id");
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    mysqli_query($conn, "DELETE FROM usuarios WHERE id=$id");
    header("Location: index.php");
    exit();
}