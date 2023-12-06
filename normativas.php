<?php
include "config.php";

// Verificar la sesión
session_start();
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Conectar a la base de datos
$conexion = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Obtener el grupo del usuario actual
$id_usuario = $_SESSION['user_id'];
$sql_grupo = "SELECT id_grupo FROM usuarios WHERE id = $id_usuario";
$resultado_grupo = $conexion->query($sql_grupo);

if ($resultado_grupo->num_rows > 0) {
    $row_grupo = $resultado_grupo->fetch_assoc();
    $id_grupo_usuario = $row_grupo['id_grupo'];

    // Consulta SQL para obtener los posts de la categoría "normativas"
    $sql = "SELECT * FROM posts WHERE categoria = 'normativas'";
    $resultado = $conexion->query($sql);
} else {
    // Si no se puede obtener el grupo del usuario, redirigir
    header("Location: login.php");
    exit();
}

// Cerrar la conexión
$conexion->close();

// Function to obtain the profile image URL
function obtener_url_de_foto_de_perfil($user_id) {
    global $config;

    $db_host = $config['db_host'];
    $db_user = $config['db_user'];
    $db_password = $config['db_password'];
    $db_name = $config['db_name'];

    $conexion = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Verificar si $user_id es NULL o no está definido
    if ($user_id === null || !isset($user_id)) {
        // Manejar el caso en el que $user_id es NULL
        return "https://i.pinimg.com/736x/e5/91/dc/e591dc82326cc4c86578e3eeecced792.jpg";
    }

    $sql = "SELECT profile_image_url FROM usuarios WHERE id = $user_id";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['profile_image_url'];
    } else {
        // Si no se encuentra la URL de la imagen de perfil, retornar una URL predeterminada
        return "https://i.pinimg.com/736x/e5/91/dc/e591dc82326cc4c86578e3eeecced792.jpg";
    }

    $conexion->close();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <div class="container">
        <!-- Primera sección (Foro Original) -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mt-2 mb-2">
    <h3 class="text-start" style="color: white;">Normativas</h3>
    <!-- Mostrar el botón solo si el usuario está logueado y es del grupo 'Admin' o 'Moderador' -->
    <?php if (isset($_SESSION['user_id']) && ($id_grupo_usuario == 7 || $id_grupo_usuario == 8)): ?>
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#crearPostModal">
            Crear Post
        </button>
    <?php endif; ?>
    <a href="javascript:history.back()" class="btn btn-dark">Atrás</a>
</div>



                <div class="card mb-4" id="about">
    <div class="card-header" style="background-color: #212529; color: #ffffff;">Sección de Normativas de Los Santos V</div>
    <div class="card-body">
        <?php
        while ($row = $resultado->fetch_assoc()) {
            echo '<div class="mb-3 d-flex align-items-center">';
            echo '<div style="flex-grow: 1;">';
            echo '<h5><a href="post.php?id=' . $row['id'] . '">' . $row['titulo'] . '</a></h5>';
            echo '</div>';
            
            
            // Obtener la URL de la imagen del creador
// Obtener la URL de la imagen del creador
$id_creador = $row['id_creador'];
$creador_image_url = obtener_url_de_foto_de_perfil($id_creador);

            
            // Mostrar la imagen del creador
            echo '<img src="' . $creador_image_url . '" alt="Creador" width="50" height="50" class="rounded-circle ml-3">';

            echo '</div>';
            echo '<hr>'; // Agregar esta línea para incluir <hr> entre las publicaciones
        }
        ?>
    </div>
</div>


    <!-- Agrega esto en la sección head de tu HTML -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.1/showdown.min.js"></script>

<!-- Modal para Crear Post -->
<!-- Modal para Crear Post -->
<div class="modal fade" id="crearPostModal" tabindex="-1" aria-labelledby="crearPostModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl"> <!-- Cambiado de 'modal-lg' a 'modal-xl' -->
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="crearPostModalLabel">Crear Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Columna del formulario -->
                    <div class="col-md-6">
                        <form method="post" action="procesar_creacion_post.php">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>

                                <!-- Botones para insertar texto -->
                                <div class="mt-2">
                                    <!-- Botón con emoji de Font Awesome -->
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertarTexto('[image:(URL_DE_LA_IMAGEN)]')" title="Insertar Imagen">
                                        <i class="fa fa-file-image-o"></i>
                                    </button>
                                            <!-- Otros botones -->
        <button type="button" class="btn btn-outline-secondary" onclick="insertarTexto('**TEXTO**')" title="Insertar Negrita">
    <i class="fa fa-bold"></i>
</button>      
<button type="button" class="btn btn-outline-secondary" onclick="insertarTexto('*TEXTO*')" title="Insertar Cursiva">
    <i class="fa fa-italic"></i>
</button>
<button type="button" class="btn btn-outline-secondary" onclick="insertarTexto('||TEXTO||')" title="Insertar Revelación">
    <i class="fa fa-eye-slash"></i>
</button>
<button type="button" class="btn btn-outline-secondary" onclick="insertarTexto('```TEXTO```')" title="Insertar Código">
    <i class="fa fa-file-code-o"></i>
</button>
<button type="button" class="btn btn-outline-secondary" onclick="insertarTexto('[color:(#XXXXXX)(Texto a colorear)]')" title="Insertar Color">
    <i class="fa fa-eyedropper"></i>
</button>
<button type="button" class="btn btn-outline-secondary" onclick="insertarTexto('* Texto')" title="Insertar Lista">
    <i class="fa fa-list-ul"></i>
</button>
<button type="button" class="btn btn-outline-secondary" onclick="insertarTexto('__Texto__')" title="Subrayar">
    <i class="fa fa-underline"></i>
</button>

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select class="form-select" id="categoria" name="categoria" required>
                                    <option value="normativas">Normativas</option>
                                    <!-- Agrega más opciones según sea necesario -->
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Publicar</button>
                        </form>
                    </div>
                    <!-- Columna de vista previa -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="vistaPrevia" class="form-label">Vista Previa</label>
                            <div id="vistaPrevia" class="form-control p-3" style="white-space: pre-wrap; height: 300px; max-height: 70vh; overflow-y: auto; background-color: #333; color: white; border: 1px solid #555;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</div>

<script>
    // Función para procesar el formato de texto
    function procesarFormatoTextoVistaPrevia(texto) {
        texto = texto.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');  // Negrita
        texto = texto.replace(/\*(.*?)\*/g, '<i>$1</i>');  // Cursiva
        texto = texto.replace(/\|\|(.*?)\|\|/g, '<span class="oculto" onclick="mostrarTexto(this)">Mostrar</span><pre class="contenido-oculto">$1</pre>');  // Ocultar
        texto = texto.replace(/\|-(.*?)-\|/g, '<div style="text-align: left;">$1</div>');  // Alineación izquierda
        texto = texto.replace(/-\|(.*?)-\|/g, '<div style="text-align: center;">$1</div>');  // Alineación centrada
        texto = texto.replace(/\|-...(.*?)-\|/g, '<div style="text-align: right;">$1</div>');  // Alineación derecha
        texto = texto.replace(/=\|(.*?)\|/g, '<div style="text-align: justify;">$1</div>');  // Alineación justificada
        texto = texto.replace(/\[image:\((.*?)\)\]/g, '<img src="$1" alt="Imagen" class="img-fluid">');  // Insertar imágenes
        texto = texto.replace(/\[color:\((#(?:[0-9a-fA-F]{3}){1,2})\)\((.*?)\)\]/g, '<span class="coloreable" style="color: $1;">$2</span>');  // Colorear texto
        texto = texto.replace(/```(.*?)```/gs, '<pre class="code-text">$1</pre>');  // Bloques de código
        texto = texto.replace(/#(\w+)\((.*?)\)/g, '<h1 id="$1">$2</h1>');  // Encabezados
        texto = texto.replace(/^\* (.*?)$/gm, '<li>$1</li>');  // Listas
        texto = texto.replace(/__(.*?)__/g, '<u>$1</u>');  // Subrayado
        // Envolver listas solo si hay contenido
        if (texto.trim() !== '') {
            texto = '<ul>' + texto + '</ul>';
        }

        return texto;
    }

    function actualizarVistaPrevia() {
        // Obtener valores del formulario
        var titulo = document.getElementById('titulo').value;
        var descripcion = document.getElementById('descripcion').value;

        // Procesar el formato de texto en la vista previa
        var vistaPrevia = '<h3>' + procesarFormatoTextoVistaPrevia(titulo) + '</h3>';
        vistaPrevia += '<div style="word-wrap: break-word;">' + procesarFormatoTextoVistaPrevia(descripcion) + '</div>';

        // Obtener el elemento de vista previa
        var vistaPreviaElement = document.getElementById('vistaPrevia');

        // Verificar si el elemento de vista previa existe antes de intentar modificarlo
        if (vistaPreviaElement) {
            // Actualizar el contenido de la vista previa y ajustar la altura si es necesario
            vistaPreviaElement.innerHTML = vistaPrevia;
            vistaPreviaElement.style.height = 'auto';
        }
    }

    // Ejecutar la función inicialmente para establecer la altura
    document.addEventListener('DOMContentLoaded', function () {
        actualizarVistaPrevia();

        // Agregar evento oninput a los campos del formulario
        var tituloElement = document.getElementById('titulo');
        var descripcionElement = document.getElementById('descripcion');

        if (tituloElement && descripcionElement) {
            tituloElement.addEventListener('input', actualizarVistaPrevia);
            descripcionElement.addEventListener('input', actualizarVistaPrevia);
        }
    });
</script>







    <script>
    // Función para insertar texto en el área de descripción
    function insertarTexto(texto) {
        var descripcionTextArea = document.getElementById('descripcion');
        // Agrega el texto al contenido actual del área de descripción
        descripcionTextArea.value += texto;
    }
</script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var textarea = document.getElementById("descripcion");
        
        // Crear el convertidor Markdown
        var converter = new showdown.Converter();

        // Agregar un evento de escucha al textarea para convertir el contenido Markdown
        textarea.addEventListener("input", function () {
            var markdownText = textarea.value;
            var htmlText = converter.makeHtml(markdownText);
            
            // Actualizar el contenido del textarea con el HTML generado
            textarea.innerHTML = htmlText;
        });
    });
</script>


    <!-- ... Puedes seguir replicando según sea necesario ... -->

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
