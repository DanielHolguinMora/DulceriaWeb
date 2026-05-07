<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once '../config/database.php';
require_once '../models/Producto.php';
require_once '../models/Categoria.php';
require_once '../models/Marca.php';

$database = new Database();
$db = $database->getConnection();
$producto = new Producto($db);
$categoria = new Categoria($db);
$marca = new Marca($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

function uploadImage($fileInputName)
{
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES[$fileInputName]['name']);
        $targetFilePath = $uploadDir . $fileName;

        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        if (in_array(strtolower($fileType), $allowTypes)) {
            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetFilePath)) {
                return $fileName;
            }
        }
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create') {
        $producto->nombre = $_POST['nombre'];
        $producto->categoria_id = $_POST['categoria_id'];
        $producto->marca_id = $_POST['marca_id'];
        $producto->precio = $_POST['precio'];
        $producto->descripcion = $_POST['descripcion'];
        $producto->stock = $_POST['stock'];

        $imgFront = uploadImage('imagen_frontal');
        $imgBack = uploadImage('imagen_trasera');

        $producto->imagen_frontal = $imgFront ? $imgFront : '';
        $producto->imagen_trasera = $imgBack ? $imgBack : '';

        if ($producto->create()) {
            header("Location: ../gestion_productos.php?msg=created");
        } else {
            header("Location: ../gestion_productos.php?msg=error");
        }
        exit;
    }

    if ($action == 'update') {
        $producto->id = $_POST['id'];
        $producto->nombre = $_POST['nombre'];
        $producto->categoria_id = $_POST['categoria_id'];
        $producto->marca_id = $_POST['marca_id'];
        $producto->precio = $_POST['precio'];
        $producto->descripcion = $_POST['descripcion'];
        $producto->stock = $_POST['stock'];

        $newFront = uploadImage('imagen_frontal');
        if ($newFront)
            $producto->imagen_frontal = $newFront;

        $newBack = uploadImage('imagen_trasera');
        if ($newBack)
            $producto->imagen_trasera = $newBack;

        if ($producto->update()) {
            header("Location: ../gestion_productos.php?msg=updated");
        } else {
            header("Location: ../gestion_productos.php?msg=error");
        }
        exit;
    }

    if ($action == 'create_category') {
        $categoria->nombre = $_POST['nombre'];
        if ($categoria->create()) {
            header("Location: ../gestion_categorias.php?msg=created");
        } else {
            header("Location: ../gestion_categorias.php?msg=error");
        }
        exit;
    }

    if ($action == 'update_category') {
        $categoria->id = $_POST['id'];
        $categoria->nombre = $_POST['nombre'];
        if ($categoria->update()) {
            header("Location: ../gestion_categorias.php?msg=updated");
        } else {
            header("Location: ../gestion_categorias.php?msg=error");
        }
        exit;
    }

    if ($action == 'create_brand') {
        $marca->nombre = $_POST['nombre'];
        if ($marca->create()) {
            header("Location: ../gestion_marcas.php?msg=created");
        } else {
            header("Location: ../gestion_marcas.php?msg=error");
        }
        exit;
    }

    if ($action == 'update_brand') {
        $marca->id = $_POST['id'];
        $marca->nombre = $_POST['nombre'];
        if ($marca->update()) {
            header("Location: ../gestion_marcas.php?msg=updated");
        } else {
            header("Location: ../gestion_marcas.php?msg=error");
        }
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($action == 'delete') {
        $producto->id = $_GET['id'];
        if ($producto->delete()) {
            header("Location: ../gestion_productos.php?msg=deleted");
        } else {
            header("Location: ../gestion_productos.php?msg=error");
        }
        exit;
    }

    if ($action == 'delete_category') {
        $categoria->id = $_GET['id'];
        if ($categoria->delete()) {
            header("Location: ../gestion_categorias.php?msg=deleted");
        } else {
            header("Location: ../gestion_categorias.php?msg=error");
        }
        exit;
    }

    if ($action == 'delete_brand') {
        $marca->id = $_GET['id'];
        if ($marca->delete()) {
            header("Location: ../gestion_marcas.php?msg=deleted");
        } else {
            header("Location: ../gestion_marcas.php?msg=error");
        }
        exit;
    }
}

header("Location: ../dashboard.php");
exit;
