<?php

//activa el report de errores
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "mercado_central";


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(!$conn){
    die("No hay conexion:" . mysqli_connect_error());
}
?>
