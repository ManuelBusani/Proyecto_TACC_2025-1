<?php
// este script sera el encargado de enviar un enlace de recuperacion al correo del usaurio
session_start();

require_once "../config/db.php";
require_once "../vendor/autoload.php"; // esto es si usamos PHPMailer y composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// verificamos que el formulario se haya enviado por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitizamos el correo
    $email = strtolower(trim($_POST['email']));

    // verificamos si el correo esta registrado
    $stmt = $pdo->prepare("SELECT * FROM equipoPi_users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // generamos un token unico para el enlace de recuperacion
        $token = bin2hex(random_bytes(16)); // 32 caracteres

        // guardamos el token en la base de datos
        $stmt = $pdo->prepare("UPDATE equipoPi_users SET reset_token = :token WHERE email = :email");
        $stmt->execute(['token' => $token, 'email' => $email]);

        // enviamos el correo con el enlace de recuperacion
        $reset_link = "http://148.225.83.8/~cursotacc/a220221313/proyecto_final/proyecto_final/Proyecto_TACC_2025-1/project/public/reset_password.php?token=$token";

        // falta checar
        // usamos PHPMailer para enviar el correo
        // $mail = new PHPMailer\PHPMailer\PHPMailer();
        // $mail->setFrom('no-reply@tusitio.com', 'Sistema de Recuperación');
        // $mail->addAddress($email);
        // $mail->Subject = 'Recuperación de Contraseña';
        // $mail->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña: \n\n$reset_link";
        
        // if ($mail->send()) {
        //     $_SESSION['success'] = "Te hemos enviado un enlace para recuperar tu contraseña.";
        // } else {
        //     $_SESSION['error'] = "Error al enviar el correo.";
        // }
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.office365.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'no.reply.super.Llano@outlook.com';
            $mail->Password   = ''; // la contraseña de la cuenta
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Remitente y destinatario
            $mail->setFrom('no.reply.super.Llano@outlook.com', 'notificaciones Llano');
            $mail->addAddress($email); // Email del usuario que se registró

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = "Verifica tu correo";
            $mail->Body = 
            "<p>Haz clic en el siguiente enlace para verificar tu cuenta: <\p> 
             <a href='https://semana.mat.uson.mx/~cursotacc/a222217995/Proyecto_TACC_2025-1/project/actions/verificar.php?email=$email&token=$token'>Verificar cuenta</a>";

            $mail->send();
            $_SESSION['success'] = "Te hemos enviado un enlace para recuperar tu contraseña.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al enviar el correo. {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['error'] = "El correo no está registrado.";
    }
    
    header("Location: ../public/forgot_password.php");
    exit;
}