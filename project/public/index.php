<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Supermercado El Llano</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos Generales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
        }
        
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header h1 {
            margin: 0;
            font-size: 2em;
        }

        nav ul {
            display: flex;
            justify-content: center;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1em;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1100px;
            margin: 20px auto;
            padding: 0 15px;
        }

        /* Estilos para la bienvenida */
        .welcome-container {
            background: white;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 40px;
        }

        .welcome-container h2 {
            font-size: 2em;
            color: #4CAF50;
            margin-bottom: 15px;
        }

        .welcome-container section {
            margin-bottom: 30px;
        }

        .welcome-container h3 {
            font-size: 1.5em;
            color: #333;
        }

        .welcome-container ul {
            padding-left: 20px;
        }

        .welcome-container ul li {
            font-size: 1.1em;
        }

        /* Estilos para el formulario de login */
        .login-container {
            background: white;
            max-width: 400px;
            margin: 20px auto;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .login-container h2 {
            font-size: 1.8em;
            text-align: center;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #45a049;
        }

        .login-container .register-link {
            text-align: center;
            margin-top: 10px;
        }

        .forgot-password {
            text-align: center;
            margin-top: 10px;
        }

        .forgot-password a {
            color: #4CAF50;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 50px;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>

    <!-- Encabezado -->
    <header>
        <h1>Supermercado El Llano</h1>
        <nav>
            <ul>
                <li><a href="index.php">Bienvenida</a></li>
                <li><a href="about.php">Sobre Nosotros</a></li>
                <li><a href="contact.php">Contacto</a></li>
                <li><a href="products.php">Productos</a></li>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <li><a href="restricted_area.php">Zona Restringida</a></li>
                        <li><a href="admin_panel.php">Panel de Administración</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] != 1): ?>
                        <li><a href="restricted_area.php">Zona Restringida</a></li>
                <?php endif; ?>
                <li><a href="../actions/logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <!-- Contenido Principal -->
    <div class="container">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <!-- Si el usuario no está logueado (Usuario Visitante) -->

            <div class="welcome-container">
                <h2>Bienvenido al Supermercado El Llano</h2>
                <p>En El Llano, ofrecemos productos frescos y de calidad para tu hogar. Visítanos y descubre nuestras ofertas especiales.</p>

                <section>
                    <h3>Objetivos y Propósitos</h3>
                    <p>Brindar a nuestros clientes productos frescos, de calidad y a buen precio. A través de una experiencia de compra amigable, nos comprometemos con la satisfacción de todos nuestros clientes.</p>
                </section>

                <section>
                    <h3>Productos Básicos Disponibles</h3>
                    <p>A continuación, algunos de nuestros productos más populares:</p>
                    <ul>
                        <li>Arroz (1kg) - $20</li>
                        <li>Frijoles (1kg) - $15</li>
                        <li>Leche (1L) - $10</li>
                        <li>Pan de caja - $12</li>
                    </ul>
                </section>

                <section>
                    <h3>Horario de Atención</h3>
                    <p>De lunes a viernes: 8:00 AM - 7:00 PM</p>
                    <p>Sábados: 9:00 AM - 6:00 PM</p>
                    <p>Domingos: Cerrado</p>
                </section>

                <section>
                    <h3>Ubicación</h3>
                    <p>Estamos ubicados en la calle principal del pueblo, a un costado de la plaza central.</p>
                </section>
            </div>

            <!-- Formulario de inicio de sesión -->
            <div class="login-container">
                <h2>Iniciar sesión</h2>

                <?php if (isset($_SESSION['error'])): ?>
                    <p class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>

                <form action="../actions/login.php" method="POST">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Entrar</button>
                </form>

                <div class="register-link">
                    <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
                </div>

                <div class="forgot-password">
                    <p><a href="forgot_password.php">¿Olvidaste tu contraseña?</a></p>
                </div>
            </div>

        <?php else: ?>
            <!-- Si el usuario está logueado -->
            <?php if ($_SESSION['is_admin'] == 1): ?>
                <!-- Si el usuario es administrador -->
                <h2>Bienvenido, Administrador</h2>
                <p>En el panel de administración, puedes gestionar los productos y consultar reportes.</p>
                <a href="admin_panel.php">Ir al Panel de Administración</a>
            <?php else: ?>
                <!-- Si el usuario es restringido -->
                <h2>Bienvenido, <?= htmlspecialchars($_SESSION['first_name']); ?></h2>
                <p>Accede a las páginas restringidas para consultar y descargar información de productos.</p>
                <a href="restricted_area.php">Ir a la zona restringida</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Pie de página -->
    <footer>
        <p>&copy; 2025 Supermercado El Llano - Todos los derechos reservados</p>
    </footer>

</body>
</html>
