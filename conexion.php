<?php
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_de_datos = 'foro';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$base_de_datos", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
