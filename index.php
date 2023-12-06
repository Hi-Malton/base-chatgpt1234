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





        <header class="py-5">
            <div class="container px-5">
                <div class="row gx-5 align-items-center justify-content-center">
                    <div class="col-lg-8 col-xl-7 col-xxl-6">
                        <div class="my-5 text-center text-xl-start">
                            <h1 class="display-5 fw-bolder text-white mb-2"><?php echo $config['home_short_description']; ?></h1>
                            <p class="lead fw-normal text-white-80 mb-4"><?php echo $config['home_description']; ?></p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                <a class="btn btn-success btn-lg px-4 me-sm-3" href="#connect"><?php echo $config['our_server_button']; ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="https://i.imgur.com/mmO7xNv.png" /></div>
                </div>
            </div>
        </header>


<!-- Haz los códigos aqui CHATGPT-->
<!-- ... Código previo ... -->


<!-- Sección de contenido después del header -->
<section class="py-5" style="background-color: #212529; color: #d6d6d6;">
    <div class="container px-5">
        <div class="row gx-5">
            <div class="col-md-12 text-center mb-4">
                <h1 class="text-white">¿Los Santos V? ¿Heavy Roleplay?</h1>
            </div>
        </div>
        <div class="row gx-5">
            <!-- Sección izquierda -->
            <div class="col-md-6 mb-4">
                <!-- Texto a la izquierda -->
                <img class="img-fluid rounded-3" src="https://i.imgur.com/9zDiHp9.png" alt="Imagen izquierda" />
                <div class="mt-4">
                    <p>Explora las posibilidades ilimitadas en Los Santos V, donde encontrar el hogar perfecto o el auto de tus sueños es solo el comienzo. Desde lujosos vehículos hasta acogedoras viviendas y objetos exclusivos, aquí no hay límites. Satisface tus deseos y sumérgete en un mundo de propiedades únicas que están a tu alcance. En Los Santos V, la elección es tuya. ¡Haz de tus sueños digitales una realidad sin restricciones!</p>
                </div>
            </div>
            
            <!-- Sección derecha -->
            <div class="col-md-6 mb-4">
                <!-- Imagen a la derecha -->
                <img class="img-fluid rounded-3" src="https://i.imgur.com/SBNIqqA.jpg" alt="Imagen derecha" />
                
                <!-- Texto a la derecha -->
                <div class="mt-4">
                    <p>¿Prefieres la senda de la justicia y el orden? Únete a nuestras filas gubernamentales, sirve con honor y protege la paz en un entorno desafiante. Pero si la adrenalina de la delincuencia te llama, únete a las filas criminales, donde la astucia y la audacia son tus mayores aliados. Tú decides tu camino en este emocionante universo digital. ¿Gobernarás desde la luz o te sumergirás en las sombras? ¡La elección es tuya!</p>
                </div>
            </div>
        </div>
        <div class="row gx-5">
            <!-- Primera imagen abajo -->
            <div class="col-md-6 mb-4">
                <img class="img-fluid rounded-3" src="https://i.imgur.com/IY0n18N.jpg" alt="Primera Imagen Abajo" />
                <div class="mt-4">
                    <p>Podrás organizar eventos tanto legales como ilegales, ya sea de forma privada o pública. Desde elegantes galas y actividades legales hasta emocionantes operaciones clandestinas, la ciudad ofrece escenarios diversos para tus ambiciones. ¿Te aventurarás en eventos públicos que desafíen la ley, o planificarás reuniones privadas para tratos exclusivos? ¡La elección es tuya! ¡Sumérgete en la trama de eventos y haz tu marca en el servidor!</p>
                </div>
            </div>
            <!-- Segunda imagen abajo -->
            <div class="col-md-6 mb-4">
                <img class="img-fluid rounded-3" src="https://i.imgur.com/h40m8Nr.jpg" alt="Segunda Imagen Abajo" />
                <div class="mt-4">
                    <p>
                        ¿No prefieres hacer nada de lo anteriormente comentado? Tranquilo, hay más sistemas legales y/o ilegales para civiles. En Los Santos V, la variedad es la norma. Explora opciones adicionales que se adaptan a tu estilo, ya sea sumergiéndote en sistemas legales más especializados o explorando oportunidades ilegales intrigantes. Tu camino en este vibrante universo digital es único, y las posibilidades son infinitas. ¡Redefine tu experiencia en Los Santos V!</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Actualiza tu sección HTML -->
<section class="py-5" style="background-color: white; color: black;">
<div class="col-md-12 text-center mb-4">
                <h1 class="text-black">Estadísticas del Foro</h1>
            </div>
    <div class="container px-5">
        <div class="col-md-12 text-center mb-4">

        </div>
        <div class="text-center">
            <div style="max-width: 150%; margin: 0 auto; border-radius: 15px; overflow: hidden;">
                <img class="img-fluid rounded" src="https://i.imgur.com/RYuN7rj.jpg" alt="Imagen de Prueba" />
            </div>
        </div>
    </div>






<!-- ... Código posterior ... -->


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

