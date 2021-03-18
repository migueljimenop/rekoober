<?php
// Inicializa la sesión.
session_start();

// Desactiva todas las sesiones;
$_SESSION = array();

// Destruye la sesion.
session_destroy();

// Redirecciona a la página login.
header("location: login.php");
exit;