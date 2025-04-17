<!-- panel al iniciar sesión -->
<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: ../actions/login.php");
    exit;
}
?>

<h1>Bienvenido, <?= htmlspecialchars($_SESSION['user_email']) ?>!</h1>
<a href="../actions/logout.php">Cerrar sesión</a>