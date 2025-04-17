<!-- procesa el formulario login -->
<html>
<body>

<?php
session_start();

include '../config/db.php';

// checar si la petición fue enviada por POST 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $input_password = $_POST['password'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT password FROM informacion_usuarios WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user and password_verify($input_password, $user['password'])) {
                // Usuario autenticado
                $_SESSION['user_email'] = $email;
                header("Location: ../public/dashboard.php");
                exit;
        } else {
			$_SESSION['error'] = 'Correo o contraseña incorrecta.';
            header("Location: ../public/index.php");
            exit;
        }
    } catch (PDOException $e) {    	
        $_SESSION['error'] = 'Error en la base de datos: ' . $e->getMessage();
        header("Location: ../public/index.php");
        exit;
    }
}
?>

</body>
</html>