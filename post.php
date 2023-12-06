<?php
include "config.php";

// Inicia la sesión
session_start();

// Verifica si hay una sesión activa
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Conecta a la base de datos
$conexion = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

// Verifica si hay errores en la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Función para procesar el formato de texto
function procesarFormatoTexto($texto)
{
    // Negrita: **texto**
    $texto = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $texto);

    // Cursiva: *texto*
    $texto = preg_replace('/\*(.*?)\*/', '<i>$1</i>', $texto);

    // Ocultar: ||texto||
    $texto = preg_replace('/\|\|(.*?)\|\|/', '<span class="oculto" onclick="mostrarTexto(this)">Mostrar</span><pre class="contenido-oculto">$1</pre>', $texto);

    // Alineación izquierda: |-texto-|
    $texto = preg_replace('/\|-(.*?)-\|/', '<div style="text-align: left;">$1</div>', $texto);

    // Alineación centrada: -|texto|-
    $texto = preg_replace('/-\|(.*?)-\|/', '<div style="text-align: center;">$1</div>', $texto);

    // Alineación derecha: |-texto-|
    $texto = preg_replace('/\|-(.*?)-\|/', '<div style="text-align: right;">$1</div>', $texto);

    // Alineación justificada: |=texto=|
    $texto = preg_replace('/=\|(.*?)\|/', '<div style="text-align: justify;">$1</div>', $texto);

    // Insertar imágenes: [image:(url de la imagen)]
    $texto = preg_replace('/\[image:\((.*?)\)\]/', '<img src="$1" alt="Imagen" class="img-fluid">', $texto);

    // Colorear texto: [color:(#HEXCOLOR#)(Texto a colorear)]
    $texto = preg_replace('/\[color:\((#(?:[0-9a-fA-F]{3}){1,2})\)\((.*?)\)\]/', '<span class="coloreable" style="color: ${1};">$2</span>', $texto);

    $texto = preg_replace('/```(.*?)```/s', '<pre class="code-text">$1</pre>', $texto);

    $texto = preg_replace('/```(.*?)```/s', '<pre class="code-text">$1</pre>', $texto);

    $texto = preg_replace('/#(\w+)\((.*?)\)/', '<h1 id="$1">$2</h1>', $texto);

    $texto = preg_replace('/\[link:\((.*?)\)\((.*?)\)\]/', '<a href="$2">$1</a>', $texto);

    $texto = preg_replace('/^\* (.*?)$/m', '<li>$1</li>', $texto);
    $texto = preg_replace('/__(.*?)__/', '<u>$1</u>', $texto);
    $texto = '<ul>' . $texto . '</ul>';    
    
    return $texto;
    
}

// Obtiene el ID del post desde la URL
if (isset($_GET['id'])) {
    $id_post = $_GET['id'];

    // Consulta SQL para obtener los detalles del post
    $sql = "SELECT * FROM posts WHERE id = $id_post";
    $resultado = $conexion->query($sql);

    $sql = "SELECT * FROM posts WHERE id = $id_post";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $post = $resultado->fetch_assoc();
    } else {
        // Redirige si el post no se encuentra
        header("Location: normativas.php");
        exit();
    }
} else {
    // Redirige si no se proporciona un ID de post
    header("Location: normativas.php");
    exit();
}

// Obtener el grupo del usuario actual
$id_usuario = $_SESSION['user_id'];
$sql_grupo = "SELECT id_grupo FROM usuarios WHERE id = $id_usuario";
$resultado_grupo = $conexion->query($sql_grupo);

if ($resultado_grupo->num_rows > 0) {
    $row_grupo = $resultado_grupo->fetch_assoc();
    $id_grupo_usuario = $row_grupo['id_grupo'];
}

$conexion->close();

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

// Función para obtener comentarios de un post
function obtenerComentarios($post_id)
{
    global $config;

    $db_host = $config['db_host'];
    $db_user = $config['db_user'];
    $db_password = $config['db_password'];
    $db_name = $config['db_name'];

    $conexion = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    $post_id = $conexion->real_escape_string($post_id);

    $sql = "SELECT * FROM comentarios WHERE post_id = $post_id";
    $result = $conexion->query($sql);

    $comentarios = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $comentarios[] = $row;
        }
    }

    foreach ($comentarios as &$comentario) {
        // Aplica formato al texto del comentario
        $comentario['comentario'] = procesarFormatoTexto($comentario['comentario']);
    }
    
    $conexion->close();

    return $comentarios;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?php echo $post['titulo']; ?> - <?php echo $config['home_title']; ?></title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="shortcut icon" href="https://i.imgur.com/zEVM5k9.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
<!-- Agrega esto en el encabezado de tu HTML para cargar jQuery desde un CDN -->
<!-- jQuery, Popper.js, Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <style>
 body {
        background-image: url(https://i.imgur.com/J0Un7N5.jpg);
        background-position: center;
        background-size: cover;
        background-attachment: fixed; /* Fija la imagen de fondo */
    }

        main {
            background-color: #ffffff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #007bff;
            text-align: center; /* Agregado para centrar el título */
        }

        .card-header {
            background-color: #212529;
            color: #ffffff;
        }

        .card-body {
            line-height: 1.6;
        }

        .oculto {
            cursor: pointer;
            text-decoration: underline;
            color: blue;
        }

        .contenido-oculto {
            display: none;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .coloreable {
            color: $1;
        }

    </style>
    <script>
        function mostrarTexto(elemento) {
            var contenidoOculto = elemento.nextElementSibling;

            if (contenidoOculto.style.display === "none") {
                contenidoOculto.style.display = "block";
            } else {
                contenidoOculto.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5 d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="#">
                <img src="https://i.imgur.com/zEVM5k9.png" alt="Logo">
            </a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="foro.php" style="color: white;">Foro</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Opcion 3</a></li>
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $profile_image_url = obtener_url_de_foto_de_perfil($user_id);

                        if ($profile_image_url) {
                            echo '<a class="nav-link" href="profile.php">
                                    <img src="' . $profile_image_url . '" alt="Foto de Perfil" width="30" height="30" class="rounded-circle">
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


    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-3 text-right">
                <!-- Botón Atrás a la derecha -->
                <a href="javascript:history.back()" class="btn btn-dark">Atrás</a>
            </div>
            <div class="card mb-4">
                <!-- Resto del contenido de la página -->
    <div class="card-header">
        <?php echo $post['titulo']; ?>
        <div class="small text-muted">
            <?php
            // Obtener información del autor del post
            $author_id = $post['author_id'];
            $author_name = obtener_nombre_del_autor($author_id);
            $author_photo_url = obtener_url_de_foto_de_perfil($author_id);
            $post_created_at = $post['created_at'];

            // Mostrar la información del autor y la hora
            echo "<img src='$author_photo_url' alt='Foto de perfil' width='20' height='20' class='rounded-circle'> $author_name - $post_created_at";
            ?>
        </div>
        <div class="text-end">
    <?php
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['author_id']) {
        // Mostrar el botón de editar solo si el usuario está logueado y es el autor del post
        echo '<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarModal">Editar</button>';
    }
    ?>
    <?php if (isset($_SESSION['user_id']) && ($id_grupo_usuario == 8) || ($id_grupo_usuario == 7)): ?>
    <!-- Mostrar el botón solo si el usuario está logueado y pertenece al grupo con ID 8 -->
    <button type="button" class="btn btn-danger" onclick="confirmarEliminar()">
    Eliminar
</button>
<?php endif; ?>

</div>

<!-- Agrega el modal de confirmación -->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #212529">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="color: #212529">¿Estás seguro de que deseas eliminar este post?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="formEliminarPost" method="post" action="eliminar_post.php">
                    <input type="hidden" name="post_id" value="<?php echo $id_post; ?>">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
        function confirmarEliminar() {
        // Abre el modal de confirmación
        $('#eliminarModal').modal('show');
    }

    function eliminarPost() {
        // Cierra el modal
        $("#eliminarModal").modal("hide");

        // Enviar el formulario de eliminación
        $("#formEliminarPost").submit();
    }
</script>


<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Columna del formulario de edición -->
                    <div class="col-md-6">
                        <form method="post" action="procesar_edicion_post.php">
                        <div class="mb-3">
                        <label for="titulo" class="form-label">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $post['titulo']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required><?php echo $post['descripcion']; ?></textarea>
                    </div>
                    <input type="hidden" name="post_id" value="<?php echo $id_post; ?>">
                    <button type="button" class="btn btn-success" onclick="guardarCambios()">Guardar Cambios</button>
                        </form>
                    </div>
                    <!-- Columna de vista previa -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="vistaPreviaEditar" class="form-label">Vista Previa</label>
                            <div id="vistaPreviaEditar" class="form-control p-3" style="white-space: pre-wrap; height: 300px; max-height: 70vh; overflow-y: auto; background-color: #333; color: white; border: 1px solid #555;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function guardarCambios() {
        console.log("Guardar Cambios button clicked");

        // Obtén los datos del formulario
        var postData = $("#editarModal form").serialize();

        // Realiza una petición AJAX para actualizar el post
        $.ajax({
            type: "POST",
            url: "procesar_edicion.php",
            data: postData,
            success: function(response) {
                // Cierra el modal después de la actualización exitosa
                $("#editarModal").modal("hide");

                // Actualiza el contenido del post en la página
                // (puedes recargar la página completa o actualizar solo la parte modificada con JavaScript)
                location.reload(); // Esto recarga la página completa, puedes adaptarlo según tus necesidades
            },
            error: function(error) {
                console.log("Error al actualizar el post:", error);
                // Puedes manejar el error de acuerdo a tus necesidades
            }
        });
    }
</script>

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
    texto = '<ul>' + texto + '</ul>';  // Envolver listas

        return texto;
    }

    // Función para actualizar la vista previa
    function actualizarVistaPrevia() {
        // Obtener valores del formulario
        var titulo = document.getElementById('titulo').value;
        var descripcion = document.getElementById('descripcion').value;

        // Procesar el formato de texto en la vista previa
        var vistaPrevia = '<h3>' + procesarFormatoTextoVistaPrevia(titulo) + '</h3>';
        vistaPrevia += '<div style="word-wrap: break-word;">' + procesarFormatoTextoVistaPrevia(descripcion) + '</div>';

        // Actualizar el contenido de la vista previa y ajustar la altura si es necesario
        var vistaPreviaElement = document.getElementById('vistaPrevia');
        vistaPreviaElement.innerHTML = vistaPrevia;

        // Ajustar automáticamente la altura basada en el contenido
        vistaPreviaElement.style.height = 'auto';
    }

    // Ejecutar la función inicialmente para establecer la altura
    actualizarVistaPrevia();

    // Agregar evento oninput a los campos del formulario
    document.getElementById('titulo').addEventListener('input', actualizarVistaPrevia);
    document.getElementById('descripcion').addEventListener('input', actualizarVistaPrevia);
</script>


    </div>
    
    <div class="card-body">
        <?php echo nl2br(procesarFormatoTexto($post['descripcion'])); ?>
    </div>
<div class="card-header">Comentarios</div>
    <div class="card-body">
        <?php
        // Obtén los comentarios para este post
        $comentarios = obtenerComentarios($id_post);

        // Muestra los comentarios
        foreach ($comentarios as $comentario) {
            $comment_author_id = $comentario['user_id'];
            $comment_author_name = obtener_nombre_del_autor($comment_author_id);
            $comment_author_photo_url = obtener_url_de_foto_de_perfil($comment_author_id);
            $comment_created_at = $comentario['fecha_creacion'];

            echo "<div class='mb-3'>";
            echo "<img src='$comment_author_photo_url' alt='Foto de perfil' width='20' height='20' class='rounded-circle'> $comment_author_name - $comment_created_at";
            echo "<p>{$comentario['comentario']}</p>";
            echo "</div>";
            echo '<hr>'; // Agregar esta línea para incluir <hr> entre las publicaciones
        }
        ?>


        <!-- Formulario para agregar un nuevo comentario -->
        <form method="post" action="procesar_comentario.php">
            <div class="mb-3">
                <label for="nuevoComentario" class="form-label">Agregar Comentario:</label>
                <textarea class="form-control" id="nuevoComentario" name="nuevoComentario" rows="3" required></textarea>
            </div>
            <input type="hidden" name="post_id" value="<?php echo $id_post; ?>">
            <button type="submit" class="btn btn-success">Publicar Comentario</button>
        </form>
    </div>
</div>
</div>
</div>

<!-- Separador (línea horizontal) entre el contenido principal y la sección de comentarios -->


</div>


<!-- ... (código posterior) ... -->
<script>
    function cambiarColor(elemento, colorInicial) {
        var nuevoColor = prompt("Introduce el nuevo color en formato HEX (por ejemplo, #RRGGBB):", colorInicial);
        if (nuevoColor !== null) {
            elemento.style.color = nuevoColor;
        }
    }
</script>

<!-- ... (código posterior) ... -->

<?php
function obtener_nombre_del_autor($user_id) {
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
        return "Anónimo"; // Manejar el caso en el que $user_id es NULL
    }

    $sql = "SELECT username FROM usuarios WHERE id = $user_id";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['username'];
    } else {
        return "Desconocido";
    }

    $conexion->close();
}
?>


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
