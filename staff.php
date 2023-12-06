<?php
include "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="styles.css" rel="stylesheet" />
    <title><?php echo $config['home_title']; ?></title>
    <link rel="shortcut icon" href="https://i.imgur.com/zEVM5k9.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-fvXC5TRC89Up6y1fe+5pUBtC6zgYK/7L9iNsvvlUQIvK6WL6do/Xcmlb6xVm+Lxh+EnYnIfXAT3CIZ0jEVxPSg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
         body {
        background-image: url(https://i.imgur.com/J0Un7N5.jpg);
        background-position: center;
        background-size: cover;
        background-attachment: fixed; /* Fija la imagen de fondo */
    }
    
        header {
            position: relative;
            background: url('https://i.imgur.com/gq8hLQA.jpg') center center/cover no-repeat; /* Reemplaza la URL con la de tu imagen */
            color: #fff; /* Color del texto en el encabezado, ajusta según sea necesario */
        }
        
        header::before {
            content: "";
            position: absolute;
            bottom: 100px; /* Ajusta la distancia desde abajo */
            left: 0;
            width: 100%;
            height: 120px; /* Altura del degradado que comienza desde la parte inferior del header */
            background: linear-gradient(to top, rgba(33, 37, 41, 1) 10%, rgba(0, 0, 0, 0) 100%);
            z-index: 2; /* Asegura que esté por encima de otros elementos en el header */
        }

        header::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: calc(31% - 100px); /* Resta la altura del degradado para limitar el color al área debajo */
            background-color: #212529; /* Color uniforme debajo del degradado, ajusta según sea necesario */
            z-index: 1; /* Asegura que esté detrás del contenido del header */
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<main class="flex-shrink-0">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5 d-flex justify-content-between align-items-center">
            <!-- Logo centrado -->
            <a class="navbar-brand" href="#">
                <img src="https://i.imgur.com/zEVM5k9.png" alt="Logo">
            </a>

            <!-- Opciones a la derecha -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php" style="color: white !important;">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="foro.php">Foro</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Opcion 3</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Primera sección (Foro Original) -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
            <div style="width: 100%; overflow: auto;">
  <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSc0vFFK_q-lJv3daw1SupLCmWTRJhq6uEkvIqe4r0eV7-I-bA/viewform?embedded=true" width="100%" height="2000" frameborder="0" marginheight="0" marginwidth="0">Cargando…</iframe>
</div>


        </div>
        </div>
        </div>


<!-- Actualiza tu sección HTML -->







<!-- ... Código posterior ... -->


    </main>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>

