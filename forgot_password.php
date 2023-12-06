<?php
session_start();


// Conexión a la base de datos (ajusta esto según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Verifica si el correo electrónico existe en tu base de datos
    $sql = "SELECT id, username FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si se encuentra el correo electrónico, puedes enviar un correo de restablecimiento aquí
        $row = $result->fetch_assoc();
        $username = $row['username'];

        // Genera una nueva contraseña y realiza las acciones necesarias
        $newPassword = generateRandomPassword(); // Implementa esta función

        // Actualiza la contraseña en la base de datos
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSql = "UPDATE usuarios SET password = '$hashedPassword' WHERE email = '$email'";
        $conn->query($updateSql);

        // Ejecuta el script de Node.js para enviar el correo electrónico
        $output = '';
        $returnValue = 0;
        exec("node sendResetEmail.js $username $email $newPassword", $output, $returnValue);

        if ($returnValue === 0) {
            echo "Se ha enviado un correo electrónico de restablecimiento a $email";
        } else {
            echo "Error al enviar el correo electrónico de restablecimiento";
        }
    } else {
        echo "No se encontró el correo electrónico en nuestra base de datos";
    }
}

$conn->close();

// Función para generar una contraseña aleatoria
function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}
?>
