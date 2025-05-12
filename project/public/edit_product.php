<?php
session_start();
require_once "../config/db.php"; // Asegúrate de tener la conexión a la base de datos

// Verificamos si el usuario está logueado y tiene privilegios de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php"); // Redirigimos si no está logueado o no es administrador
    exit;
}

// Verificamos si se ha enviado un id de producto para editar
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Consultamos el producto desde la base de datos
    $stmt = $pdo->prepare("SELECT * FROM equipoPi_products WHERE id = :product_id LIMIT 1");
    $stmt->execute(['product_id' => $product_id]);
    $product = $stmt->fetch();

    // Si no existe el producto, redirigimos al panel de administración
    if (!$product) {
        header("Location: admin_panel.php"); 
        exit;
    }
} else {
    // Si no se ha pasado un id de producto, redirigimos
    header("Location: admin_panel.php");
    exit;
}

// Procesamos el formulario para actualizar el producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $expiration_date = $_POST['expiration_date'];

    // Actualizamos el producto en la base de datos
    $stmt = $pdo->prepare("UPDATE equipoPi_products SET name = :name, price = :price, stock = :stock, expiration_date = :expiration_date WHERE id = :product_id");
    $stmt->execute([
        'name' => $name,
        'price' => $price,
        'stock' => $stock,
        'expiration_date' => $expiration_date,
        'product_id' => $product_id
    ]);

    $_SESSION['success'] = "Producto actualizado exitosamente.";
    header("Location: admin_panel.php"); // Redirigimos al panel de administración
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Supermercado El Llano</title>
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
    <h2>Editar Producto</h2>
    <p>Estás editando el producto: <?= htmlspecialchars($product['name']); ?></p>

    <!-- Formulario de edición de producto -->
    <form action="edit_product.php?product_id=<?= $product['id']; ?>" method="POST">
        <label for="name">Nombre del producto:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>

        <label for="price">Precio:</label>
        <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product['price']); ?>" required>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($product['stock']); ?>" required>

        <label for="expiration_date">Fecha de Caducidad:</label>
        <input type="date" id="expiration_date" name="expiration_date" value="<?= htmlspecialchars($product['expiration_date']); ?>" required>

        <button type="submit">Actualizar Producto</button>
    </form>
</div>

<footer>
    <p>&copy; 2025 Supermercado El Llano - Todos los derechos reservados</p>
</footer>

</body>
</html>
