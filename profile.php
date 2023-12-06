<?php
include "config.php";

// Función para obtener la URL de la foto de perfil
function obtener_url_de_foto_de_perfil($user_id) {
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

    // Consulta SQL para obtener la URL de la foto de perfil
    $sql = "SELECT profile_image_url FROM usuarios WHERE id = $user_id";
    $result = $conn->query($sql);

    // Verifica si se encontró la URL de la foto de perfil
    if ($result->num_rows > 0) {
        // Obtiene la URL de la foto de perfil
        $row = $result->fetch_assoc();
        $profile_image_url = $row['profile_image_url'];

        // Cierra la conexión a la base de datos
        $conn->close();

        return $profile_image_url;
    } else {
        // Si no se encuentra la URL de la foto de perfil, devuelve false
        $conn->close();
        return false;
    }
}

// Inicia la sesión
session_start();

// Verifica si hay una sesión activa
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
    
    // Limpia la variable de sesión después de mostrar el mensaje
    unset($_SESSION['error_message']);
}

if (isset($_SESSION['success_message'])) {
    echo '<div class="success alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
    
    // Limpia la variable de sesión después de mostrar el mensaje
    unset($_SESSION['success_message']);
}

// Obtén el ID del usuario de la sesión
$user_id = $_SESSION['user_id'];

// Verifica si se envió el formulario para cambiar el nombre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_name'])) {
    // Realiza la actualización del nombre de usuario (debes implementar update_name.php)
    $new_name = $_POST['new_name'];
    // Aquí debes llamar a tu función de actualización de nombre de usuario
    // E.g., actualizar_nombre_de_usuario($user_id, $new_name);
    // Luego, podrías redirigir o mostrar un mensaje de éxito
}

// Verifica si se envió el formulario para cambiar la contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
    // Realiza la actualización de la contraseña (debes implementar update_password.php)
    $new_password = $_POST['new_password'];
    // Aquí debes llamar a tu función de actualización de contraseña
    // E.g., actualizar_contraseña($user_id, $new_password);
    // Luego, podrías redirigir o mostrar un mensaje de éxito
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

// Consulta SQL para obtener información del usuario
$sql = "SELECT * FROM usuarios WHERE id = $user_id";
$result = $conn->query($sql);

// Verifica si se encontró el usuario
if ($result->num_rows > 0) {
    // Obtiene los detalles del usuario
    $row = $result->fetch_assoc();
    $user_name = $row['username'];
    $user_role = $row['id_grupo'];
    $profile_image_url = obtener_url_de_foto_de_perfil($user_id);
} else {
    // Manejo de error si el usuario no se encuentra en la base de datos
    echo "Error: Usuario no encontrado";
    exit();
}

// Cierra la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="<?php echo $config['home_title']; ?> - <?php echo $server_info['gamename']; ?> Server. You can view current players & Statistic, or connect our server " />
    <link rel="shortcut icon" href="https://i.imgur.com/zEVM5k9.png" />
    <title><?php echo $config['home_title']; ?></title>
    <link href="styles.css" rel="stylesheet" />
    <style>
                body {
            /* Cambia el color de fondo según tus preferencias */
            background-image: url('https://i.imgur.com/J0Un7N5.jpg');
            background-size: cover;

        }



    </style>
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5 d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="#">
                <img src="https://i.imgur.com/zEVM5k9.png" alt="Logo">
            </a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="foro.php">Foro</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Opcion 3</a></li>
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $profile_image_url = obtener_url_de_foto_de_perfil($user_id);
                        if ($profile_image_url) {
                            echo '<a class="nav-link" href="profile.php">
                                    <img src="' . $profile_image_url . '" alt="Foto de Perfil" width="30" height="30" class="rounded-circle" >
                                  </a>';
                        } else {
                            echo '<a class="nav-link" href="profile.php">
                                    <img src="https://i.pinimg.com/736x/e5/91/dc/e591dc82326cc4c86578e3eeecced792.jpg" alt="No Logueado" width="30" height="30" class="rounded-circle">
                                  </a>';
                        }
                    } else {
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

    <div class="container mt-4">

            <!-- Mostrar contenido según el rango -->
            <?php if ($user_role == 0): ?>
                <!-- Contenido específico para el rango 1 -->
                <h2 style="color: white;">Bienvenido, <?php echo $user_name; ?>!</h2>
                <?php elseif ($user_role == 1): ?>
                <!-- Contenido específico para el rango 2 -->
                <h2 style="color: white;">Bienvenido, Tester <?php echo $user_name; ?>!</h2>
            <?php elseif ($user_role == 2): ?>
                <!-- Contenido específico para el rango 2 -->
                <h2 style="color: white;">Bienvenido, Mapper <?php echo $user_name; ?>!</h2>
            <?php elseif ($user_role == 3): ?>
                <!-- Contenido específico para el rango 3 -->
                <h2 style="color: white;">Bienvenido, Colaborador <?php echo $user_name; ?>!</h2>
                <?php elseif ($user_role == 4): ?>
                <!-- Contenido específico para el rango 3 -->
                <h2 style="color: white;">Bienvenido, Programador <?php echo $user_name; ?>!</h2>
                <?php elseif ($user_role == 5): ?>
                <!-- Contenido específico para el rango 3 -->
                <h2 style="color: white;">Bienvenido, Soporte <?php echo $user_name; ?>!</h2>
                <?php elseif ($user_role == 6): ?>
                <!-- Contenido específico para el rango 3 -->
                <h2 style="color: white;">Bienvenido, Moderador <?php echo $user_name; ?>!</h2>
                <?php elseif ($user_role == 7): ?>
                <!-- Contenido específico para el rango 3 -->
                <h2 style="color: white;">Bienvenido, Encargado de Foro <?php echo $user_name; ?>!</h2>
                 <?php elseif ($user_role == 8): ?>
                <!-- Contenido específico para el rango 3 -->
                <h2 style="color: white;">Bienvenido, Game Master <?php echo $user_name; ?>!</h2>
            <?php else: ?>

                <!-- Contenido por defecto para otros rangos -->
                <h2 style="color: white;">Bienvenido, <?php echo $user_name; ?>!</h2>
            <?php endif; ?>

        <hr style="color: white;">
        <h6 style="color: white;">Bienvenido al Panel de Control de tu cuenta de Los Santos V</h6>
<p style="color: white;">En este apartado tendrás varias opciones para poder gestionar tu cuenta, solo es ir explorando la Dashboard y sentirte agusto.</p>
<h6>ㅤㅤ</h6>
<div class="row justify-content">
    <div class="col-lg-8">
        <!-- Cuadro existente -->
        <div class="card mb-4" id="another-section">
            <div class="card-header" style="background-color: #212529; color: #ffffff;">Información de Cuenta</div>
            <div class="card-body">
                <form action="update_info.php" method="post" enctype="multipart/form-data">
                    <!-- Contenido del formulario -->
                    <h6 class="card-title">Sobre Mí</h6>
                    <?php
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

                    // Realiza una consulta para obtener el campo "sobre_mi" de la base de datos
                    $sql = "SELECT sobre_mi FROM usuarios WHERE id = $user_id";
                    $result = $conn->query($sql);

                    // Verifica si se encontró el usuario y muestra el formulario
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $sobre_mi = $row['sobre_mi'];
                    ?>
                        <div class="mb-3">
                            <textarea id="sobre_mi" name="sobre_mi" class="form-control" required><?php echo $sobre_mi; ?></textarea>
                        </div>

                        <!-- Agrega un campo oculto para identificar la operación -->
                        <input type="hidden" name="operation" value="update_sobre_mi">
                    <?php
                    } else {
                        echo "Usuario no encontrado.";
                    }

                    // Cierra la conexión a la base de datos
                    $conn->close();
                    ?>

                    <hr>
                
                    <!-- Agrega el botón "Guardar Cambios" -->
                    <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Cuadro adicional -->
    <div class="col-lg-4">
    <div class="card mb-4">
        <div class="card-header" style="background-color: #212529; color: #ffffff;">Imagén de Cuenta</div>
        <div class="card-body">
            <h6 class="card-title">Foto de Perfil</h6>

            <?php
            // Conéctate a la base de datos nuevamente para obtener el campo "profile_image_url"
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Realiza una consulta para obtener el campo "profile_image_url" de la base de datos
            $sql = "SELECT profile_image_url FROM usuarios WHERE id = $user_id";
            $result = $conn->query($sql);

            // Verifica si se encontró el usuario y muestra el formulario
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $profile_image_url = $row['profile_image_url'];
            ?>
                <form action="update_profileimg.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="new_profile_image">Cambiar Foto de Perfil:</label>
                        <input type="file" id="new_profile_image" name="new_profile_image" class="form-control" accept="image/*" required>
                    </div>

                    <!-- Agrega un campo oculto para identificar la operación -->
                    <input type="hidden" name="operation" value="update_profile_image">

                    <hr>

                    <!-- Agrega el botón "Guardar Cambios" -->
                    <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                </form>
            <?php
            } else {
                echo "Usuario no encontrado.";
            }

            // Cierra la conexión a la base de datos
            $conn->close();
            ?>
        </div>
        
    </div>
    
</div>
</div>
<div class="row justify-content">
    <div class="col-lg-8">
        <div class="card mb-4" id="another-section">
            <div class="card-header" style="background-color: #212529; color: #ffffff;">Seguridad</div>
            <div class="card-body">
                <h6 class="card-title">Nuevo Nick</h6>
                <form action="update_security.php" method="post">
                    <div class="mb-3">
                        <input type="text" id="new_username" name="new_username" class="form-control" required>
                    </div>

                    <!-- Agrega un campo oculto para identificar la operación -->
                    <input type="hidden" name="operation" value="update_username">

                    <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                </form>
                <hr>
                <h5 class="card-title">Contraseña Cuenta</h5>
                <h6 class="card-title">Contrasela Actual</h6>
                <form action="update_security.php" method="post">
                    <div class="mb-3">
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <h6 for="new_password">Contraseña Nueva</h6>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                    </div>

                    <!-- Agrega un campo oculto para identificar la operación -->
                    <input type="hidden" name="operation" value="update_password">

                    <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
    <div class="card mb-4">
    <div class="card-header" style="background-color: #212529; color: #ffffff;">Otras Opciones</div>
<div class="card-body">

    <?php
    // Conéctate a la base de datos nuevamente para obtener el campo "profile_image_url"
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Realiza una consulta para obtener el campo "profile_image_url" de la base de datos
    $sql = "SELECT profile_image_url FROM usuarios WHERE id = $user_id";
    $result = $conn->query($sql);

    // Verifica si se encontró el usuario y muestra el formulario
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $profile_image_url = $row['profile_image_url'];
    ?>

    <!-- Formulario con el botón "Guardar Cambios" -->
    <form method="post" action="logout.php">
        <button type="submit" class="btn btn-dark">Cerrar Sesión</button>
    </form>

    <?php
    } else {
        echo "Usuario no encontrado.";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
    ?>
</div>

    </div>
    
    
</div>
</div>
</div>
</div>
</div>






<?php
// Inicia la sesión

// Verifica si hay una notificación de cuenta actualizada
if (isset($_SESSION['cuenta_actualizada']) && $_SESSION['cuenta_actualizada']) {
    // Limpia la sesión para que la notificación no se muestre después de una recarga de página
    unset($_SESSION['cuenta_actualizada']);
}
?>
<!DOCTYPE html>
<!-- Resto del código de foro.php -->

</body>
</html>

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
