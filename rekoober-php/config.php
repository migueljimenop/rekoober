<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'RekooberDB');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($link === false) {
	die("ERROR: No es posible conectar a la base de datos. " .mysqli_connect_error());
} 
/*else {
	die("OK: Hay conexion.");
}*/