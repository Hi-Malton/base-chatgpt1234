<?php
include "config.php";

// Conecta a la base de datos
$conexion = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

// Verifica si hay errores en la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Verifica si se envió el formulario y si existe el campo post_id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_id"])) {
    $post_id = $_POST["post_id"];

    // Realiza la eliminación del post
    $sql_eliminar = "DELETE FROM posts WHERE id = $post_id";

    if ($conexion->query($sql_eliminar) === TRUE) {
        // Eliminación exitosa, redirige a la página principal o a donde sea apropiado
        header("Location: index.php");
        exit();
    } else {
        // Error en la eliminación
        echo "Error al eliminar el post: " . $conexion->error;
    }
} else {
    // No se recibió el formulario correctamente
    echo "Error: No se recibieron datos del formulario.";
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
