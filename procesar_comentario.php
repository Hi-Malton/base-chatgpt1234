<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevoComentario = $_POST["nuevoComentario"];
    $post_id = $_POST["post_id"];

    session_start();
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (!$user_id) {
        // El usuario no está autenticado, manejar según sea necesario
        header("Location: login.php");
        exit();
    }

    $conexion = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Asegúrate de limpiar y validar los datos antes de usarlos en la consulta SQL
    $nuevoComentario = $conexion->real_escape_string($nuevoComentario);

    $sql = "INSERT INTO comentarios (post_id, user_id, comentario, fecha_creacion) VALUES ('$post_id', '$user_id', '$nuevoComentario', NOW())";

    if ($conexion->query($sql) === TRUE) {
        // Éxito al insertar el comentario
        header("Location: post.php?id=$post_id"); // Redirige de vuelta al post después de agregar el comentario
        exit();
    } else {
        // Error al insertar el comentario
        echo "Error al agregar el comentario: " . $conexion->error;
    }

    $conexion->close();
} else {
    // Si no se han enviado datos por POST, redirige a la página principal
    header("Location: index.php");
    exit();
}
?>
