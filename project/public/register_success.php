<?php
session_start();

// verificamos si el usuario se registro correctamente
if (!isset($_SESSION['success'])) {
    header("Location: ../public/index.php"); // redirige si no se registro correctamente
    exit;
}   
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 50px;
        }
        .success-container {
            background: white;
            max-width: 400px;
            margin: auto;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            text-align: center;
        }
        .success-container h2 {
            color: #4CAF50;
        }
        .success-container p {
            font-size: 16px;
        }
        .login-btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .login-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <h2>Registro Exitoso!</h2>
        <p>Tu cuenta ha sido registrada correctamente. Te hemos enviado un correo para verificar tu cuenta.</p>
        <p>Por favor, sigue las instrucciones en el correo para activar tu cuenta.</p>
        <a href="index.php" class="login-btn">Ir a Iniciar Sesión</a>
    </div>
</body>
</html>