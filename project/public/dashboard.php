<!-- panel al iniciar sesión -->

<?php
  session_start();
  var_dump($_SESSION);
  // Redirigiremos si el usuario no ha iniciado sesion
//   if (!isset($_SESSION['user_id'])) {
//     header("Location: index.php");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel principal</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #f9f9f9;
    }
    .panel {
      background-color: white;
      padding: 30px;
      max-width: 500px;
      margin: auto;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    .logout-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background: #c0392b;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .logout-btn:hover {
      background: #e74c3c;
    }
  </style>
</head>
<body>
  <div class="panel">
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['first_name']) ?> 👋</h2>
    <p>Has iniciado sesión correctamente.</p>
    
    <a href="logout.php" class="logout-btn">Cerrar sesión</a>
  </div>
</body>
</html>