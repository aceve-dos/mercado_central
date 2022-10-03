<?php
//lista de productos
session_start();
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'],$_POST['csrf'])) {
    die();
}

$error = false;
$config = include 'config.php';

try {
    $dsn = 'mysql:host=' . $config ['db']['host'] . ';dbname=' . $config['db']['name']; $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
    if (isset($_POST['nombre_cliente'])) {
        $consultaSQL = "SELECT * from pedido "
    }
} 
//aca va un IF que determina el nivel de usuario si es admin o no, para luego dar consulta a la base de datos desde la tabla de productos y mostrar dichos productos. 

?>

//BOTON DE BUSCAR PRODUCTO.--->
//<!---CRUD--->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3"><?=$titulo ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID Producto</th>
                        <th>Nombre de Producto</th>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Peso</th>
                        <th>Precio Maximo</th>
                        <th>Precio Minimo</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

