<?php
// conexión a la base de datos -->
// en este archivo establecemos la conexion con la base de datos MYSQL usando PDO-->
// PDO (PHP Data Objects) es una interfaz de acceso a bases de datos en PHP -->

$host = 'localhost';
$db = 'test_db';
$user = ''; // usuario del servidor
$pass = ''; // contraseña para conectarse a mysql

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>