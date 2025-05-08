<?php
session_start();
require_once "../config/db.php"; // recordatorio: asegurarnos de que este archivo tenga la conexion a la base de datos

// Verificamos que el formulario se haya enviado por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // sanitizamos y obtenemos los datos del formulario
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    // verificamos si el correo ya esta registrado en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $existing_user = $stmt->fetch();

    // si el usuario ya existe, mostramos un mensaje de error
    if ($existing_user){
        $_SESSION['error'] = "El correo electrónico ya está registrado.";
        header("Location: ../public/register.php");  // redirige de nuevo al formulario de registro
        exit;
    }

    // hasheando contraseña para almacenarla de forma segura
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // insertamos el nuevo usuario en la base de datos
    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, is_admin, is_verified) 
                           VALUES (:first_name, :last_name, :email, :password, :is_admin, :is_verified)");


    try{
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $hashed_password,
            'is_admin' => 0, // no es admin por defecto
            'is_verified' => 1 // esto por si decidimos implementar la verificacion por correo la cambiamos a false
        ]);
    
        $_SESSION['success'] = "Registro exitoso. Ahora puedes iniciar sesión.";
        header("Location: ../public/index.php"); // redirigiremos al login despues de un registro exitoso
        exit;
    } catch (PDOException $e){
        // si ocurre un error mostramos este mensaje
        $_SESSION['error'] = "Error al registrar: " . $e->getMessage();
        header("Location: ../public/register.php"); // redirigimos de nuevo al formulario de registro con el error
        exit;
    }
}
?>