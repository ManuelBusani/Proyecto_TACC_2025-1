<!-- archivo que procesara el cambio de contraseña -->
 <?php
 session_start();
 require_once "../config/db.php";

 // Verificamos que el token y la contraseña sean validos
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'], $_POST['password'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];

    // verificamos si el token es valido
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token LIMIT 1");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch();

    if ($user) {
        // hasheamos la nueva contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // actualizamos la contraseña y eliminamos el token
        $stmt = $pdo->prepare(UPDATE users SET password = :password, reset_token = NULL WHERE reset_token = :token");
        $stmt->execute(['password' => $hashed_password, 'token' => $token]);

        $_SESSION['success'] = "Tu contraseña ha sido actualizada exitosamente.";
        header("Location: ../public/index.php");
        exit;
    } else {
        $_SESSION['error'] = "El enlace de recuperación no es válido.";
        header("Location: ../public/forgot_password.php");
        exit;
    }
 }