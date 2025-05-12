<?php
session_start();
require_once "../config/db.php"; // Asegúrate de tener la conexión a la base de datos

// Verificamos si el usuario está logueado y tiene privilegios de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php"); // Redirigimos si no está logueado o no es administrador
    exit;
}

// Consulta para generar el reporte de productos cercanos a la fecha de caducidad o con bajo stock (stock <= 20)
$stmt = $pdo->prepare("SELECT * FROM equipoPi_products WHERE expiration_date <= CURDATE() + INTERVAL 7 DAY OR stock <= 20 ORDER BY expiration_date");
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reportes - Supermercado El Llano</title>
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
    <h2>Generar Reportes</h2>
    <p>En este reporte, mostramos los productos que están cerca de su fecha de caducidad o tienen bajo stock (20 o menos).</p>

    <!-- Reporte de productos cercanos a la caducidad o con bajo stock -->
    <?php if ($products): ?>
        <h3>Productos con bajo stock o cercanos a la caducidad:</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Fecha de Caducidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td><?= htmlspecialchars($product['price']); ?> $</td>
                        <td><?= htmlspecialchars($product['stock']); ?></td>
                        <td><?= htmlspecialchars($product['expiration_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay productos con bajo stock o cercanos a la caducidad.</p>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2025 Supermercado El Llano - Todos los derechos reservados</p>
</footer>

</body>
</html>
