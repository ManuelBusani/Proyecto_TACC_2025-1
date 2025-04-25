<!-- para cerrar cesión -->
 <?php
 session_start();

 // Destruimos todas las variables de sesión
 session_unset();
 session_destroy();

 // Redirigimos al login
 header("Location: index.php");
 exit;
