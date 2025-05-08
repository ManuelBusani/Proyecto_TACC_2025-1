<!-- en esta pagina se le permitiria al usuario ingresar una nueva contraseña-->
 <?php
 session_start();
 require_once "../config/db.php";

 // verificamos que el token sea valido
 if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // buscamos el token en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM equipoPi_users WHERE reset_token = :token LIMIT 1");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['error'] = "El enlace de recuperación no es válido o ha expirado.";
        header("Location: ../public/forgot_password.php");
        exit;
    }
 } else {
    $_SESSION['error'] = "Token no proporcionado.";
    header("Location: ../public/forgot_password.php");
    exit;
 }
 ?>