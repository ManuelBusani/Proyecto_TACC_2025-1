<!-- Script para insertar un usuario de prueba -->
<?php
require_once "../config/db.php";

// Datos del usuario de prueba
$email = "usuario@correo.com";
$password = "123456";  // Contraseña en texto plano
$first_name = "Carlos";
$last_name = "Mancillas";
$is_admin = 0;
$is_verified = 1;

// Generar el hash seguro de la contraseña
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insertar el usuario en la base de datos
$stmt = $pdo->prepare("INSERT INTO users (email, password, first_name, last_name, is_admin, is_verified) 
                       VALUES (:email, :password, :first_name, :last_name, :is_admin, :is_verified)");

try {
    $stmt->execute([
        'email' => $email,
        'password' => $hashed_password,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'is_admin' => $is_admin,
        'is_verified' => $is_verified
    ]);

    echo "✅ Usuario de prueba insertado con éxito.";
} catch (PDOException $e) {
    echo "❌ Error al insertar usuario: " . $e->getMessage();
}
?>
