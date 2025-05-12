<?php
session_start();
require_once "../config/db.php";

// Verificamos si el usuario está logueado y tiene privilegios de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}

// Obtener todos los productos de la base de datos
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Supermercado El Llano</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<header>
    <h1>Supermercado El Llano</h1>
    <nav>
        <ul>
            <li><a href="index.php">Bienvenida</a></li>
            <li><a href="about.php">Sobre Nosotros</a></li>
            <li><a href="contact.php">Contacto</a></li>
            <li><a href="products.php">Productos</a></li>
            <li><a href="restricted_area.php">Zona Restringida</a></li>
            <li><a href="admin_panel.php">Panel de Administración</a></li>
            <li><a href="../actions/logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Panel de Administración</h2>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['first_name']); ?>. Aquí puedes gestionar los productos y generar reportes.</p>

    <!-- Opciones de administración -->
    <div class="admin-options">
        <h3>Opciones</h3>
        <ul>
            <li><a href="restricted_area.php">Zona Restringida</a></li>
            <li><a href="add_product.php">Agregar Nuevo Producto</a></li>
            <li><a href="delete_product.php">Eliminar Productos</a></li>
            <li><a href="generate_reports.php">Generar Reportes</a></li>
        </ul>
    </div>

    <!-- Tabla de productos -->
    <h3>Productos Disponibles:</h3>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Fecha de Caducidad</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']); ?></td>
                    <td><?= htmlspecialchars($product['price']); ?> $</td>
                    <td><?= htmlspecialchars($product['stock']); ?></td>
                    <td><?= htmlspecialchars($product['expiration_date']); ?></td>
                    <td>
                        <a href="edit_product.php?product_id=<?= $product['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; 2025 Supermercado El Llano - Todos los derechos reservados</p>
</footer>

</body>
</html>
