<?php
//Listado de usuarios
session_start();

include 'funciones.php';

csrf();
if (isset($_POST['submit']) &&!hash_equals($_SESSION['csrf'],$_POST['csrf'])){
    die();
}

$error = false;
$config = include 'config.php';

try { 
    $dsn = 'mysql:host='. $config ['db']['host'] . ';dbname=' . $config ['db']['name']; $conexion = new PDO($dsn, $config ['db']['user'], $config ['db']['pass'], $config ['db']['options']);

    if (isset($_POST['nombre_cliente'])){
        $consultaSQL = "SELECT * FROM usuario WHERE email LIKE '%" . $_POST['nombre_puestero'] . "%'";
    } else {
        $consultaSQL = "SELECT * FROM usuario";
    }

    $sentencia = $conexion ->prepare($consultaSQL); 
    $sentencia->execute();

    $productos = $sentencia->fetchAll();

} catch(PDOException $error) {
    $error = $error->getMessage();
}
    $titulo = isset($_POST['nombre_puestero']) ? 'Lista de Productos(' . $_POST ['nombre_puestero'] . ')': 'Lista de Productos';
?>

<?php include "templates/header.php"; ?>

<?php
if ($error){
    ?>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<div class="container">
   <div class="row">
    <div class="col-md-12">
        <!-- form de busqueda-->
        <form method="post" class="form-inline">
            <div class="form-group mr-3">
                <input type="text" style="width:80%;float:left;margin-right:5px;"
                id="nombre_puestero" name="nombre puestero" placeholder="Buscar por nombre" class="form-control">
            </div>
            <input name="csrf"   type="hidden" value="<?php echo escapar ($_SESSION ['csrf']); ?>">
            <button type="submit" name="submit" class="btn btn primary"> 
            </button>
        </form>
        <hr>
        <!-- Pantalla de pedidos.-->
            <a href="inicio_crud.php" class="btn btn-primary mt-4">Ir para los Pedidos/Productos</a>
            <a href="usuarios_registrados.php" class="btn btn-primary mt-4">Usuarios Registrados</a>
            <a href="logout.php" class="btn btn-primary mt-4">Cerrar sesion de <?php echo $_SESSION["nombre"] ?> </a>
    </div>
   </div> 
</div>
<!---Modificación para niveles, corregir el div---->