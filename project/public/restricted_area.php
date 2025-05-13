<?php
session_start();
require_once "../config/db.php"; // Asegúrate de tener la conexión a la base de datos

// Verificamos si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirigimos a la página de login si no está logueado
    exit;
}

// Verificamos si el producto fue marcado como vendido
if (isset($_POST['mark_sold'])) {
    $product_id = $_POST['product_id'];
    $stmt = $pdo->prepare("UPDATE equipoPi_products SET status = 'sold' WHERE id = :product_id");
    $stmt->execute(['product_id' => $product_id]);
}

// Obtener los datos del formulario de búsqueda (si se enviaron)
$search_name = isset($_POST['search_name']) ? strtolower(trim($_POST['search_name'])) : '';
$search_expiration_date = isset($_POST['search_expiration_date']) ? $_POST['search_expiration_date'] : '';
$search_stock = isset($_POST['search_stock']) ? $_POST['search_stock'] : '';

// Filtrar productos según los parámetros
$query = "SELECT * FROM equipoPi_products WHERE 1=1";
$params = [];

if ($search_name) {
    $query .= " AND LOWER(name) LIKE :search_name";
    $params['search_name'] = "%$search_name%";
}

if ($search_expiration_date) {
    $query .= " AND expiration_date = :search_expiration_date";
    $params['search_expiration_date'] = $search_expiration_date;
}

if ($search_stock) {
    $query .= " AND stock >= :search_stock";
    $params['search_stock'] = $search_stock;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Notificaciones de productos cercanos a la caducidad o con bajo stock
$alert_query = "SELECT * FROM equipoPi_products WHERE expiration_date <= CURDATE() + INTERVAL 7 DAY OR stock <= 10";
$stmt = $pdo->prepare($alert_query);
$stmt->execute();
$alerts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Restringida - Supermercado El Llano</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                <li><a href="admin_panel.php">Panel de Administración</a></li>
            <?php endif; ?>
            <li><a href="../actions/logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Zona Restringida</h2>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['first_name']); ?>. Aquí puedes consultar productos disponibles en el inventario.</p>

    <!-- Formulario de búsqueda para filtrar productos -->
    <form action="restricted_area.php" method="POST">
        <label for="search_name">Buscar por nombre:</label>
        <input type="text" id="search_name" name="search_name" value="<?= htmlspecialchars($search_name); ?>" placeholder="Ejemplo: Frijoles">

        <label for="search_expiration_date">Buscar por fecha de caducidad:</label>
        <input type="date" id="search_expiration_date" name="search_expiration_date" value="<?= htmlspecialchars($search_expiration_date); ?>">

        <label for="search_stock">Buscar por stock mínimo:</label>
        <input type="number" id="search_stock" name="search_stock" value="<?= htmlspecialchars($search_stock); ?>" min="0" placeholder="Ejemplo: 10">

        <button type="submit">Filtrar</button>
    </form>

    <!-- Notificaciones de productos cercanos a la caducidad o con bajo stock -->
    <?php if ($alerts): ?>
        <div class="alerts">
            <h3>Alertas</h3>
            <ul>
                <?php foreach ($alerts as $alert): ?>
                    <li>
                        <strong><?= htmlspecialchars($alert['name']); ?></strong>: 
                        <?= ($alert['expiration_date'] <= date('Y-m-d')) ? 'Producto caducado o cercano a la caducidad' : 'Stock bajo'; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


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
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td><?= htmlspecialchars($product['price']); ?> $</td>
                        <td><?= htmlspecialchars($product['stock']); ?></td>
                        <td><?= htmlspecialchars($product['expiration_date']); ?></td>
                        <td>
                            <?php if ($product['status'] == 'available'): ?>
                                <form action="restricted_area.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                    <button type="submit" name="mark_sold">Marcar como vendido</button>
                                </form>
                            <?php else: ?>
                                <span>Vendido</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No se encontraron productos con esos filtros.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

        <!-- Gráfico de barras para mostrar el stock de productos -->
        <canvas id="stockChart" width="400" height="200"></canvas>

<script>
    var ctx = document.getElementById('stockChart').getContext('2d');
    var stockChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($products, 'name')); ?>, // Nombres de los productos
            datasets: [{
                label: 'Stock disponible',
                data: <?= json_encode(array_column($products, 'stock')); ?>, // Stock de cada producto
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        }
    });
</script>

</div>

<footer>
    <p>&copy; 2025 Supermercado El Llano - Todos los derechos reservados</p>
</footer>

</body>
</html>
