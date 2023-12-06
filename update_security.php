<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén el ID del usuario de la sesión
    $user_id = $_SESSION['user_id'];

    // Conéctate a la base de datos (reemplaza con tus propias credenciales)
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

    // Identifica la operación a realizar
    $operation = $_POST['operation'];

    // Realiza la operación correspondiente
    if ($operation === 'update_username') {
        // Actualiza el nombre de cuenta
        $new_username = $_POST['new_username'];
        $sql = "UPDATE usuarios SET username = '$new_username' WHERE id = $user_id";
        $_SESSION['verify_message'] = "Nombre de usuario actualizado correctamente.";
    } elseif ($operation === 'update_password') {
        // Actualiza la contraseña
        $current_password = $_POST['current_password'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        
        // Verifica la contraseña actual antes de actualizar
        $check_password_sql = "SELECT password FROM usuarios WHERE id = $user_id";
        $check_password_result = $conn->query($check_password_sql);

        if ($check_password_result->num_rows > 0) {
            $row = $check_password_result->fetch_assoc();
            $hashed_password = $row['password'];
        
            if (password_verify($current_password, $hashed_password)) {
                $sql = "UPDATE usuarios SET password = '$new_password' WHERE id = $user_id";
                $_SESSION['verify_message'] = "Contraseña actualizada correctamente.";
            } else {
                $_SESSION['error_message'] = "La contraseña actual es incorrecta.";
                header("Location: profile.php");
                exit();
            }
        }
    }
    // ...

    // Ejecuta la consulta
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = $_SESSION['verify_message']; // Establece el mensaje de éxito
        unset($_SESSION['verify_message']); // Limpia el mensaje de verificación
        $_SESSION['cuenta_actualizada'] = true;
        header("Location: profile.php");
    } else {
        echo "Error al actualizar la cuenta: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    // Si se intenta acceder al script de manera incorrecta
    echo "Acceso no permitido.";
}
?>
