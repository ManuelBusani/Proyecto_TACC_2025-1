<?php
session_start();
require_once "../config/db.php"; // Asegúrate de tener la conexión a la base de datos

// Verificamos si el usuario está logueado y tiene privilegios de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y obtener los datos del formulario
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $expiration_date = $_POST['expiration_date'];

    // Insertar el nuevo producto en la base de datos
    $stmt = $pdo->prepare("INSERT INTO equipoPi_products (name, price, stock, expiration_date, status) VALUES (:name, :price, :stock, :expiration_date, 'available')");
    $stmt->execute([
        'name' => $name,
        'price' => $price,
        'stock' => $stock,
        'expiration_date' => $expiration_date
    ]);

    $_SESSION['success'] = "Producto agregado exitosamente.";
    header("Location: admin_panel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto - Supermercado El Llano</title>
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
    <h2>Agregar Nuevo Producto</h2>

    <form action="add_product.php" method="POST">
        <label for="name">Nombre del producto:</label>
        <input type="text" id="name" name="name" required>

        <label for="price">Precio:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>

        <label for="expiration_date">Fecha de Caducidad:</label>
        <input type="date" id="expiration_date" name="expiration_date" required>

        <button type="submit">Agregar Producto</button>
    </form>
</div>

<footer>
    <p>&copy; 2025 Supermercado El Llano - Todos los derechos reservados</p>
</footer>

</body>
</html>
