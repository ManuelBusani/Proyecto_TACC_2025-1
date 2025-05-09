<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Supermercado El Llano</title>
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
            </ul>
        </nav>
    </header>

    <div class="content">
        <h2>Contacto</h2>
        <p>Para más información o si tienes alguna consulta, por favor contáctanos utilizando el siguiente formulario:</p>

        <form action="submit_contact.php" method="POST">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Mensaje:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Enviar Mensaje</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Supermercado El Llano - Todos los derechos reservados</p>
    </footer>
</body>
</html>
