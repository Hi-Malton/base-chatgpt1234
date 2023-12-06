<?php
// logout.php - Página para cerrar sesión

session_start();
session_unset();
session_destroy();

header("Location: foro.php");
exit();
?>
