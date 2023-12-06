<?php
include "config.php";
session_start();

// Verifica si hay una sesión activa
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Conecta a la base de datos
$conexion = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

// Verifica si hay errores en la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Obtén los datos del formulario de edición
$post_id = $_POST['post_id'];
$titulo = $conexion->real_escape_string($_POST['titulo']);
$descripcion = $conexion->real_escape_string($_POST['descripcion']);

// Consulta SQL para actualizar el post
$sql = "UPDATE posts SET titulo = '$titulo', descripcion = '$descripcion' WHERE id = $post_id";

if ($conexion->query($sql) === TRUE) {
    // Redirige a la página del post después de la edición
    header("Location: post.php?id=" . $post_id);
} else {
    // Maneja el caso de error en la actualización
    echo "Error al actualizar el post: " . $conexion->error;
}

// Cierra la conexión
$conexion->close();
?>
