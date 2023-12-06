<?php
include "config.php";

// Verifica si se han enviado datos a través del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recupera los datos del formulario
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $categoria = $_POST["categoria"];

    // Obtiene la ID del usuario que crea el post desde la sesión
    session_start();
    $id_creador = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Conecta a la base de datos (ajusta estos valores según tu configuración)
    $conexion = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

    // Verifica si hay errores en la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Prepara la consulta SQL
    $consulta = $conexion->prepare("INSERT INTO posts (id_creador, author_id, titulo, descripcion, categoria) VALUES (?, ?, ?, ?, ?)");

    // Vincula los parámetros
    $consulta->bind_param("iisss", $id_creador, $id_creador, $titulo, $descripcion, $categoria);

    // Ejecuta la consulta
    $consulta->execute();

    // Obtiene el ID del post recién creado
    $id_post = $conexion->insert_id;

    // Cierra la conexión y la consulta
    $consulta->close();
    $conexion->close();

    // Redireccionar a la página del post recién creado
    header("Location: post.php?id=$id_post");
    exit();
} else {
    // Si no se han enviado datos por POST, redirige a la página principal
    header("Location: index.php");
    exit();
}
?>
