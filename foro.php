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
                    // Inicia la sesión
                    session_start();

                    // Verifica si hay una sesión activa
                    if (isset($_SESSION['user_id'])) {
                        // Obtén el ID del usuario de la sesión
                        $user_id = $_SESSION['user_id'];

                        // Aquí deberías realizar una consulta a la base de datos para obtener la URL de la foto de perfil
                        // Supongamos que tienes una columna 'profile_image_url' en tu tabla de usuarios
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

    <div class="container">
        <!-- Primera sección (Foro Original) -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="text-start" style="color: white !important;">Foro</h3>
                </div>


                <div class="card mb-4" id="about">
                    <div class="card-header" style="background-color: #212529; color: #ffffff;">Información</div>
                    <div class="card-body">
                        <h4 class="card-title"><a href="normativas.php" style="color: #212529">Normativas</a></h4>
                        <hr>
                        <h4 class="card-title"> <a href="post.php?id=90" style="color: #212529">Actualizaciones</a></h4>
                        <hr>
                        <h4 class="card-title"> <a href="info%20extra.php" style="color: #212529">Información Extra</h4>
                        <!-- Agrega más títulos y líneas según sea necesario -->
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Segunda sección (Otra Sección) -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4" id="another-section">
                    <div class="card-header" style="background-color: #212529; color: #ffffff;">Comunidad</div>
                    <div class="card-body">
                        <h4 class="card-title">Sugerencias</h4>
                        <hr>
                        <h4 class="card-title">Imágenes</h4>
                        <!-- Agrega más títulos y líneas según sea necesario -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4" id="another-section">
                    <div class="card-header" style="background-color: #212529; color: #ffffff;">Dentro del Personaje</div>
                    <div class="card-body">
                        <h4 class="card-title">Biografias</h4>
                        <hr>
                        <h4 class="card-title">Gubernamentales</h4>
                        <hr>
                        <h4 class="card-title">Organizaciones</h4>
                        <!-- Agrega más títulos y líneas según sea necesario -->
                    </div>
                </div>
            </div>
        </div>
        <!-- ... Puedes seguir replicando según sea necesario ... -->
    </div>

    <!-- ... Tu código existente ... -->

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
