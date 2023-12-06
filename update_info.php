<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirige a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos (reemplaza con tus propias credenciales)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foro";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtén el ID del usuario de la sesión
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si el formulario ha sido enviado
    if (isset($_POST['sobre_mi'])) {
        // Obtiene el nuevo valor de "sobre_mi" del formulario
        $nuevo_sobre_mi = $_POST['sobre_mi'];

        // Actualiza el campo "sobre_mi" en la base de datos
        $sql = "UPDATE usuarios SET sobre_mi = '$nuevo_sobre_mi' WHERE id = $user_id";

        if ($conn->query($sql) === TRUE) {
            // Establece una sesión para indicar que la información se ha actualizado
            $_SESSION['cuenta_actualizada'] = true;

            // Redirige a foro.php
            header("Location: profile.php");
            exit();
        } else {
            echo "Error al actualizar la información sobre mí: " . $conn->error;
        }
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>