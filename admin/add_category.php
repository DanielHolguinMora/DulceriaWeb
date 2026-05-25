<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$error = '';
$success = '';
$edit_item = null;

// Manejar eliminación (DELETE)
if (isset($_GET['delete'])) {
    $token = $_GET['csrf_token'] ?? '';
    if (empty($token) || $token !== ($_SESSION['csrf_token'] ?? '')) {
        die('Acción no autorizada: Token CSRF no válido o faltante.');
    }
    $delete_id = intval($_GET['delete']);
    try {
        // Verificar primero si hay productos asociados a esta categoría
        $check_products = $pdo->prepare("SELECT COUNT(*) FROM productos WHERE categoria_id = ?");
        $check_products->execute([$delete_id]);
        $has_products = $check_products->fetchColumn() > 0;

        if ($has_products) {
            $error = 'No se puede eliminar la categoría porque tiene productos asociados.';
        } else {
            $stmt = $pdo->prepare("DELETE FROM categoria WHERE id = ?");
            $stmt->execute([$delete_id]);
            $success = 'Categoría eliminada con éxito.';
        }
    } catch (Exception $e) {
        $error = 'Error al eliminar la categoría: ' . $e->getMessage();
    }
}

// Manejar creación (INSERT) y actualización (UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (empty($token) || $token !== ($_SESSION['csrf_token'] ?? '')) {
        die('Acción no autorizada: Token CSRF no válido o faltante.');
    }
    $nombre = trim($_POST['nombre'] ?? '');
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;

    if (!empty($nombre)) {
        try {
            if ($id) {
                // Modo Edición / Actualización
                // Verificar si ya existe otra categoría con el mismo nombre
                $check = $pdo->prepare("SELECT id FROM categoria WHERE nombre = ? AND id != ?");
                $check->execute([$nombre, $id]);
                if ($check->rowCount() > 0) {
                    $error = 'Ya existe otra categoría con este nombre.';
                } else {
                    $stmt = $pdo->prepare("UPDATE categoria SET nombre = ? WHERE id = ?");
                    $stmt->execute([$nombre, $id]);
                    $success = 'Categoría actualizada con éxito.';
                }
            } else {
                // Modo Creación
                // Verificar si ya existe para evitar duplicados exactos
                $check = $pdo->prepare("SELECT id FROM categoria WHERE nombre = ?");
                $check->execute([$nombre]);
                if ($check->rowCount() > 0) {
                    $error = 'Esta categoría ya existe.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO categoria (nombre) VALUES (?)");
                    $stmt->execute([$nombre]);
                    $success = 'Categoría añadida con éxito.';
                }
            }
        } catch (Exception $e) {
            $error = 'Error al guardar en la base de datos: ' . $e->getMessage();
        }
    } else {
        $error = 'Por favor, ingresa el nombre de la categoría.';
    }
}

// Cargar datos para edición si se solicita por GET
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $pdo->prepare("SELECT * FROM categoria WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_item = $stmt->fetch();
}

// Obtener todas las categorías para listarlas en la tabla
$categorias = [];
try {
    $stmt = $pdo->query("SELECT * FROM categoria ORDER BY nombre ASC");
    $categorias = $stmt->fetchAll();
} catch (Exception $e) {
    $error = 'Error al cargar las categorías: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/Favicon4.png">
    <title>Categorías - Admin Dulcería</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 30px;
            align-items: start;
            margin-top: 20px;
        }
        @media (max-width: 992px) {
            .admin-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
        .admin-table-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .admin-table th, .admin-table td {
            padding: 15px 20px;
        }
        .table-title {
            font-size: 1.3rem;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #f4f7f6;
            padding-bottom: 10px;
        }
        .table-title span {
            background: var(--admin-primary);
            color: white;
            font-size: 0.9rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
        }
        .btn-cancel {
            background: #f2f4f4;
            color: #7f8c8d;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-cancel:hover {
            background: #e5e8e8;
            color: #2c3e50;
        }

        /* Responsive overrides to show and style tables on mobile devices */
        @media (max-width: 768px) {
            .table-responsive {
                display: block !important; /* Overrides the 'display: none' from admin.css */
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border-radius: 8px;
                border: 1px solid #eef2f3;
            }
            .admin-table-card {
                background: white !important;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05) !important;
                border-radius: 12px !important;
                padding: 20px !important;
                margin-top: 10px;
            }
            .admin-card {
                background: white !important;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05) !important;
                border-radius: 12px !important;
                padding: 20px !important;
            }
            .admin-main {
                padding-bottom: 90px !important; /* Ensure content isn't covered by bottom nav */
            }
        }
        @media (max-width: 576px) {
            .admin-table th, .admin-table td {
                padding: 10px 12px !important;
                font-size: 0.9rem !important;
            }
            .table-title {
                font-size: 1.1rem !important;
            }
            .btn-edit, .btn-delete {
                width: 35px !important;
                height: 35px !important;
                font-size: 1rem !important;
            }
            .action-btns {
                gap: 8px !important;
            }
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-brand">DULCERÍA ADMIN</div>
            <nav class="admin-nav">
                <ul>
                    <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                    <li><a href="products.php"><i class="fa-solid fa-candy-cane"></i> Productos</a></li>
                    <li><a href="add_product.php"><i class="fa-solid fa-plus"></i> Nuevo Producto</a></li>
                    <li><a href="add_brand.php"><i class="fa-solid fa-copyright"></i> Marcas</a></li>
                    <li><a href="add_category.php" class="active"><i class="fa-solid fa-tags"></i> Categorías</a></li>
                    <li><a href="../index.php" target="_blank"><i class="fa-solid fa-eye"></i> Ver Sitio</a></li>
                    <li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="admin-header">
                <h1><?php echo $edit_item ? 'Editar Categoría' : 'Categorías'; ?></h1>
                <a href="dashboard.php" class="btn btn-secondary btn-sm">Volver al Panel</a>
            </header>

            <div class="admin-grid">
                <!-- Columna Formulario -->
                <div class="admin-card">
                    <h2 class="table-title"><?php echo $edit_item ? '<i class="fa-solid fa-pen-to-square"></i> Editar Categoría' : '<i class="fa-solid fa-plus"></i> Nueva Categoría'; ?></h2>
                    
                    <?php if ($error): ?>
                        <div class="error-msg"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="success-message" style="background: #e5f9e7; color: #2ecc71; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: 600;"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form action="add_category.php" method="POST" class="admin-form">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <?php if ($edit_item): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_item['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="nombre">Nombre de la Categoría</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Ej. Chocolates Suizos" required value="<?php echo htmlspecialchars($edit_item['nombre'] ?? ''); ?>">
                        </div>

                        <?php if ($edit_item): ?>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
                                <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="fa-solid fa-save"></i> Guardar</button>
                                <a href="add_category.php" class="btn-cancel"><i class="fa-solid fa-xmark"></i> Cancelar</a>
                            </div>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 15px;"><i class="fa-solid fa-save"></i> Guardar Categoría</button>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Columna Tabla -->
                <div class="admin-table-card">
                    <h2 class="table-title">
                        <i class="fa-solid fa-list"></i> Categorías Existentes
                        <span><?php echo count($categorias); ?></span>
                    </h2>

                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    
                                    <th>Nombre</th>
                                    <th style="width: 150px; text-align: right;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($categorias)): ?>
                                    <tr>
                                        <td colspan="3" style="text-align: center; padding: 40px; color: #7f8c8d;">No hay categorías registradas.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($categorias as $cat): ?>
                                        <tr>
                                            
                                            <td><?php echo htmlspecialchars($cat['nombre']); ?></td>
                                            <td>
                                                <div class="action-btns" style="justify-content: flex-end;">
                                                    <a href="add_category.php?edit=<?php echo $cat['id']; ?>" class="btn-edit" title="Editar"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="add_category.php?delete=<?php echo $cat['id']; ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>" class="btn-delete" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')"><i class="fa-solid fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Admin Mobile Bottom Nav -->
    <nav class="admin-mobile-nav">
        <a href="dashboard.php" class="nav-item">
            <i class="fa-solid fa-gauge"></i>
            <span>Panel</span>
        </a>
        <a href="products.php" class="nav-item">
            <i class="fa-solid fa-candy-cane"></i>
            <span>Productos</span>
        </a>
        <div class="nav-item-center">
            <a href="add_product.php" class="center-add">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>
        <a href="../index.php" class="nav-item" target="_blank">
            <i class="fa-solid fa-eye"></i>
            <span>Ver Sitio</span>
        </a>
        <a href="../logout.php" class="nav-item">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Salir</span>
        </a>
    </nav>
</body>

</html>
