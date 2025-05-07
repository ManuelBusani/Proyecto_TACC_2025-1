<!-- para cerrar cesión -->
<?php
session_start();
session_destroy();
header("Location: ../public/index.php");
exit;
?>