<!-- aqui creamos formulario para que el usuario ingrese su correo eletronico y solicite el restablecimeinto de contraseña -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 50px;
        }

        .reset-container {
            background: white;
            max-width: 400px;
            margin: auto;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .reset-container h2 {
            text-align: center;
        }

        .reset-container input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .reset-container button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .reset-container button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            text-align: center;
        }   
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Recuperar Contraseña</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form action="../actions/send_reset_email.php" method="POST">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Enviar enlace de recuperación</button>
        </form>     
    </div>
</body>
</html>