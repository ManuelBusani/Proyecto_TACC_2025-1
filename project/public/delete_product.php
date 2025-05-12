<?php
session_start();
require_once "../config/db.php"; // Asegúrate de tener la conexión a la base de datos

// Verificamos si el usuario está logueado y tiene privilegios de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}

// Procesar la eliminación de un producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Eliminar el producto de la base de datos
    $stmt = $pdo->prepare("DELETE FROM equipoPi_products WHERE id = :product_id");
    $stmt->execute(['product_id' => $product_id]);

    $_SESSION['success'] = "Producto eliminado exitosamente.";
    header("Location: admin_panel.php");
    exit;
}

// Obtener los productos para mostrar en la tabla de eliminación
$stmt = $pdo->prepare("SELECT * FROM equipoPi_products");
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto - Supermercado El Llano</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<header>
    <h1>Supermercado El Llano</h1>
    <nav>
        <ul>
            <li><a href="admin_panel.php">Panel de Administración</a></li>
            <li><a href="../actions/logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Eliminar Producto</h2>

    <!-- Tabla de productos -->
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
                        <form action="delete_product.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                            <button type="submit">Eliminar</button>
                        </form>
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
