<?php
// eliminar_post.php

include "config.php";

// Verifica si hay una solicitud POST y el ID del post
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["post_id"])) {
    $post_id = $_POST["post_id"];

    // Conecta a la base de datos
    $conexion = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

    // Verifica si hay errores en la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Deshabilita la restricción de clave externa temporalmente
    $conexion->query("SET foreign_key_checks = 0");

    // Elimina los comentarios asociados al post
    $sqlComentarios = "DELETE FROM comentarios WHERE post_id = ?";
    $stmtComentarios = $conexion->prepare($sqlComentarios);
    $stmtComentarios->bind_param("i", $post_id);
    $stmtComentarios->execute();

    // Verifica si la eliminación de comentarios fue exitosa
    if ($stmtComentarios->affected_rows > 0 || $stmtComentarios->affected_rows === 0) { // Considera 0 como un caso válido
        // Elimina el post
        $sqlPost = "DELETE FROM posts WHERE id = ?";
        $stmtPost = $conexion->prepare($sqlPost);
        $stmtPost->bind_param("i", $post_id);
        $stmtPost->execute();

        // Verifica si la eliminación del post fue exitosa
        if ($stmtPost->affected_rows > 0) {
            // Redirige a foro.php
            header("Location: foro.php");
            exit();
        } else {
            echo "Error al eliminar el post";
        }
    } else {
        echo "Error al eliminar los comentarios";
    }

    // Habilita nuevamente la restricción de clave externa
    $conexion->query("SET foreign_key_checks = 1");

    // Cierra la conexión y las declaraciones preparadas
    $stmtComentarios->close();
    $stmtPost->close();
    $conexion->close();
} else {
    echo "Invalid request";
}
?>
