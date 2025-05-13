<?php
// procesa el formulario login -->
// procesa el formulario login -->
// Este script: Recibe el correo y la contraseña.
//              Consulta la base de datos.
//              Verifica que el usuario exista y la contraseña coincida.
//              Crea la sesión si todo es correcto.
//              Redirige el dashboard o al login con error.


session_start();
require_once "../config/db.php";

// Verificamos que el formulario se haya enviado por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Obtenemos y sanitizamos los datos del formulario
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    // Consultamos el usuario en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM equipoPi_users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Verificamos que exista y que la contraseña sea correcta
    if ($user && password_verify($password, $user['password'])) {

        // (esto es opcional) verificamos si la cuenta ha sido activada
        // if (!$user['is_verified']) {
        //     $_SESSION['error'] = "Tu cuenta no ha sido verificada aún.";
        //     header("Location: ../public/index.php");
        //     exit;
        // } 

        // Guardamos los datos mínimos en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['first_name'] = $user['first_name'];

       // Verificamos si el usuario es administrador
        if ($_SESSION['is_admin'] == 1) {
            // Si es administrador, redirigimos al panel de administración
            header("Location: ../public/admin_panel.php");
            exit;
        }
        // Redireccionamos al panel
        header("Location: ../public/restricted_area.php");
        exit;
} else {
    // Si alguien intenta acceder directamente por GET
    header("Location: ../public/index.php");
    exit;
}
