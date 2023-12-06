<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foro";

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se seleccionó un archivo
    if (isset($_FILES['new_profile_image']) && $_FILES['new_profile_image']['error'] === UPLOAD_ERR_OK) {
        // Directorio donde se almacenarán las imágenes de perfil
        $upload_dir = 'profile_images/';

        // Nombre único para la imagen basado en el tiempo
        $file_name = uniqid() . '_' . $_FILES['new_profile_image']['name'];

        // Ruta completa donde se guardará la imagen
        $upload_path = $upload_dir . $file_name;

        // Mueve la imagen al directorio de destino
        move_uploaded_file($_FILES['new_profile_image']['tmp_name'], $upload_path);

        // Actualiza la URL de la foto de perfil en la base de datos
        $user_id = $_SESSION['user_id'];
        $profile_image_url = $upload_path;

        // Conecta a la base de datos y actualiza la URL
        include "config.php";  // Asegúrate de tener este archivo con la configuración de la base de datos
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $sql = "UPDATE usuarios SET profile_image_url = '$profile_image_url' WHERE id = $user_id";
        $result = $conn->query($sql);

        // Cierra la conexión
        $conn->close();

        // Redirige a la página de perfil con un mensaje de éxito
        $_SESSION['cuenta_actualizada'] = true;
        header("Location: profile.php");
        exit();
    } else {
        echo "Error al cargar la imagen.";
    }
} else {
    echo "Acceso no autorizado.";
}
?>
