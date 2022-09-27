<?php
//report de errores
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

session_start();
session_destroy();
header("location: login.html");
?>