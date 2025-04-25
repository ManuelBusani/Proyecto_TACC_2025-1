<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registar usuario</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        padding: 50px;
        }
        .register-container {
        background: white;
        max-width: 400px;
        margin: auto;
        padding: 30px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border-radius: 10px;
        }
        .register-container h2 {
        text-align: center;
        }
        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        }
        .register-container button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        }
        .register-container button:hover {
        background-color: #45a049;
        }
        .error {
        color: red;
        text-align: center;
        }
</style>
</head>
<body>
    <div class="register-container">
        <h2> Registrar nuevo usuario</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form action="../actions/register_user.php" method="POST">
            <label for="first_name">Nombre:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Apellido:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password"> Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>