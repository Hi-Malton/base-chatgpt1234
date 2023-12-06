<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();

// Verifica si ya hay una sesión activa
if (isset($_SESSION['user_id'])) {
    header("Location: foro.php");
    exit();
}

// Conexión a la base de datos (debes ajustar esto según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las variables están definidas antes de acceder a ellas
    $username = isset($_POST['username']) ? $_POST['username'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Consultar la base de datos para verificar si el usuario ya existe
    $check_user_sql = "SELECT id FROM usuarios WHERE username = '$username' OR email = '$email'";
    $check_user_result = $conn->query($check_user_sql);

    if ($check_user_result->num_rows > 0) {
        // El usuario o correo electrónico ya existe, mostrar mensaje de error
        $error_message = "El usuario o correo electrónico ya está registrado.";
    } else {
        // Insertar el nuevo usuario en la tabla "usuarios"
        $insert_user_sql = "INSERT INTO usuarios (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if ($conn->query($insert_user_sql) === TRUE) {
            // Registro exitoso, redirigir a la página principal o mostrar un mensaje de éxito
            header("Location: foro.php");
            exit();
        } else {
            // Error en la inserción, mostrar mensaje de error
            $error_message = "Error al registrar el usuario: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="<?php echo $config['home_title']; ?> - <?php echo $server_info['gamename']; ?> Server. You can view current players & Statistic, or connect our server " />
    <title>Registrarse - Los Santos V</title>
    <link rel="shortcut icon" href="https://i.imgur.com/zEVM5k9.png" />
    <link href="styles.css" rel="stylesheet" />
    <style>
                body {
            /* Cambia el color de fondo según tus preferencias */
            background-image: url('https://i.imgur.com/7VFa4JN.png');
            background-size: cover;

        }



    </style>
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5 d-flex justify-content-between align-items-center">
            <!-- Logo centrado -->
            <a class="navbar-brand" href="#">
                <img src="https://i.imgur.com/zEVM5k9.png" alt="Logo">
            </a>

            <!-- Opciones a la derecha -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="foro.php" style="color: white;">Foro</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Opcion 3</a></li>

                <!-- Botón de perfil -->
                <li class="nav-item">
                    <?php
                    // Verifica si hay una sesión activa
                    if (isset($_SESSION['user_id'])) {
                        // Obtén el ID del usuario de la sesión
                        $user_id = $_SESSION['user_id'];

                        // Obtén la URL de la foto de perfil
                        $profile_image_url = obtener_url_de_foto_de_perfil($user_id);

                        // Verifica si la URL de la foto de perfil está definida
                        if ($profile_image_url) {
                            echo '<a class="nav-link" href="profile.php">
                                    <img src="' . $profile_image_url . '" alt="Foto de Perfil" width="30" height="30" class="rounded-circle">
                                  </a>';
                        } else {
                            // Si no hay URL de foto de perfil, muestra la imagen predeterminada
                            echo '<a class="nav-link" href="profile.php">
                                    <img src="https://i.pinimg.com/736x/e5/91/dc/e591dc82326cc4c86578e3eeecced792.jpg" alt="No Logueado" width="30" height="30" class="rounded-circle">
                                  </a>';
                                  
                        }
                    } else {
                        // Si no está logueado, muestra una imagen diferente
                        echo '<a class="nav-link" href="login.php">
                                <img src="https://i.pinimg.com/736x/e5/91/dc/e591dc82326cc4c86578e3eeecced792.jpg" alt="No Logueado" width="30" height="30" class="rounded-circle">
                              </a>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
    <br />
    <!DOCTYPE html>
<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <div class="container mt-4">
            <h2 style="color: white !important;">Registro</h2>

            <?php if ($error_message !== ""): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label for="username" class="form-label" style="color: white !important;">Usuario:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
    <label for="email" class="form-label" style="color: white !important;">Correo Electrónico:</label>
    <input type="email" id="email" name="email" class="form-control" required>
</div>


                <div class="mb-3">
                    <label for="password" class="form-label" style="color: white !important;">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <input type="submit" value="Registrar" class="btn btn-success">
            </form>
            <hr style="color: white">
    <a href="login.php" class="btn btn-link" style="color: white !important;">¿Ya tienes cuenta creada?</a> 
        </div>
    </main>
    
 
    
    <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0 text-white">
                        <p>Los Santos V es una entidad independiente y no guarda afiliación ni cuenta con el respaldo oficial de Rockstar North, Take-Two Interactive, ni otros poseedores de derechos relevantes. Todas las marcas comerciales utilizadas en este contexto son propiedad exclusiva de sus respectivos propietarios.</p>
                        <p>En este sentido, Los Santos V se reserva con firmeza todos los derechos sobre las imágenes y demás contenido visual que se presenta en su plataforma, asegurando así la protección de la propiedad intelectual legítima. Apreciamos y respetamos los derechos de autor, reconociendo la importancia de preservar la integridad de las creaciones visuales y gráficas.</p>
                        <p>En cualquier caso, si se considera que algún elemento gráfico o visual infringe algún derecho de autor, le instamos a ponerse en contacto con nosotros de inmediato para abordar y resolver cualquier problema de manera justa y eficiente. En Los Santos V, nos esforzamos por mantener altos estándares éticos y legales en relación con la propiedad intelectual.</p>
                    </div>
                </div>
                <div class="col-auto">
                    <!-- Agrega aquí íconos y enlaces a las redes sociales -->
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
